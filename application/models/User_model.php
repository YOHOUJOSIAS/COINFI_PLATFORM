<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Vérifie un magic link token
     */
    public function verify_magic_link($token) {
        $this->db->where('magic_token', $token);
        $this->db->where('token_expires >', time());
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) {
            // Clear the token after use
            $this->db->where('magic_token', $token);
            $this->db->update('users', array(
                'magic_token' => null,
                'token_expires' => null,
                'email_verified' => 1
            ));
            
            return true;
        }
        
        return false;
    }

    /**
     * Obtient un utilisateur par token
     */
    public function get_user_by_token($token) {
        $this->db->where('magic_token', $token);
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        return null;
    }

    /**
     * Vérifie une signature de portefeuille
     */
    public function verify_wallet_signature($wallet_address, $signature) {
        // En production, vous devriez vérifier la signature cryptographique
        // Pour cette démo, on simule une vérification réussie
        return !empty($wallet_address) && !empty($signature);
    }

    /**
     * Obtient un utilisateur par adresse de portefeuille
     */
    public function get_user_by_wallet($wallet_address) {
        $this->db->where('wallet_address', $wallet_address);
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            // Créer un nouvel utilisateur si il n'existe pas
            return $this->create_wallet_user($wallet_address);
        }
    }

    /**
     * Crée un nouvel utilisateur avec une adresse de portefeuille
     */
    private function create_wallet_user($wallet_address) {
        $user_data = array(
            'wallet_address' => $wallet_address,
            'role' => 'investor', // Rôle par défaut
            'created_at' => date('Y-m-d H:i:s'),
            'email_verified' => 1
        );
        
        $this->db->insert('users', $user_data);
        $user_id = $this->db->insert_id();
        
        $user_data['id'] = $user_id;
        return $user_data;
    }

    /**
     * Met à jour l'adresse de portefeuille d'un utilisateur
     */
    public function update_wallet_address($user_id, $wallet_address) {
        $this->db->where('id', $user_id);
        return $this->db->update('users', array(
            'wallet_address' => $wallet_address,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Obtient un utilisateur par ID
     */
    public function get_user($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        return null;
    }

    /**
     * Obtient un utilisateur par email
     */
    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        return null;
    }

    /**
     * Crée un nouvel utilisateur
     */
    public function create_user($data) {
        $user_data = array(
            'email' => $data['email'],
            'role' => $data['role'] ?? 'investor',
            'wallet_address' => $data['wallet_address'] ?? null,
            'magic_token' => $data['magic_token'] ?? null,
            'token_expires' => $data['token_expires'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert('users', $user_data);
        return $this->db->insert_id();
    }

    /**
     * Met à jour un utilisateur
     */
    public function update_user($user_id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    /**
     * Supprime un utilisateur
     */
    public function delete_user($user_id) {
        $this->db->where('id', $user_id);
        return $this->db->delete('users');
    }

    /**
     * Obtient tous les utilisateurs avec pagination
     */
    public function get_users($limit = 10, $offset = 0, $role = null) {
        if ($role) {
            $this->db->where('role', $role);
        }
        
        $this->db->limit($limit, $offset);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('users');
        
        return $query->result_array();
    }

    /**
     * Compte le nombre total d'utilisateurs
     */
    public function count_users($role = null) {
        if ($role) {
            $this->db->where('role', $role);
        }
        
        return $this->db->count_all_results('users');
    }

    /**
     * Met à jour le rôle d'un utilisateur
     */
    public function update_user_role($user_id, $role) {
        $this->db->where('id', $user_id);
        return $this->db->update('users', array(
            'role' => $role,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Génère un token magic link
     */
    public function generate_magic_token($email) {
        $token = bin2hex(random_bytes(32));
        $expires = time() + (15 * 60); // 15 minutes
        
        // Vérifier si l'utilisateur existe
        $user = $this->get_user_by_email($email);
        
        if ($user) {
            // Mettre à jour le token existant
            $this->db->where('email', $email);
            $this->db->update('users', array(
                'magic_token' => $token,
                'token_expires' => $expires,
                'updated_at' => date('Y-m-d H:i:s')
            ));
        } else {
            // Créer un nouvel utilisateur
            $this->create_user(array(
                'email' => $email,
                'magic_token' => $token,
                'token_expires' => $expires
            ));
        }
        
        return $token;
    }

    /**
     * Vérifie si un utilisateur a un rôle spécifique
     */
    public function has_role($user_id, $role) {
        $this->db->where('id', $user_id);
        $this->db->where('role', $role);
        $query = $this->db->get('users');
        
        return $query->num_rows() > 0;
    }

    /**
     * Obtient les statistiques des utilisateurs
     */
    public function get_user_stats() {
        $stats = array();
        
        // Total des utilisateurs
        $stats['total'] = $this->db->count_all('users');
        
        // Par rôle
        $roles = array('admin', 'enterprise', 'investor', 'client');
        foreach ($roles as $role) {
            $this->db->where('role', $role);
            $stats[$role] = $this->db->count_all_results('users');
        }
        
        // Utilisateurs actifs (connectés dans les 30 derniers jours)
        $this->db->where('last_login >', date('Y-m-d H:i:s', strtotime('-30 days')));
        $stats['active'] = $this->db->count_all_results('users');
        
        return $stats;
    }
}