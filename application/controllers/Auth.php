<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('User_model');
    }



   public function metaMaskLogin() {
    $didToken = $this->input->post('didToken');

    if (!$didToken) {
        echo json_encode([
            'success' => false,
            'message' => 'Token missing'
        ]);
        return;
    }

    // ⚠️ Ici tu devrais valider le token avec le SDK Magic

    $this->session->set_userdata([
        'user_role' => 'user',
        'wallet_address' => '0x123456789...' // Exemple
    ]);

    echo json_encode([
        'success' => true,
        'redirect' => base_url('index.php/dashboard')
    ]);
}


    public function magicLogin() {
    $didToken = $this->input->post('didToken');

    if (!$didToken) {
        echo json_encode([
            'success' => false,
            'message' => 'Token missing'
        ]);
        return;
    }

    // ⚠️ Ici tu devrais valider le token avec le SDK Magic
    // Pour l'instant on suppose qu'il est valide.

    $this->session->set_userdata([
        'user_role' => 'user',
        'wallet_address' => '0x123456789...' // ou l'email/id utilisateur Magic
    ]);

    echo json_encode([
        'success' => true,
        'redirect' => base_url('index.php/Dashboard')
    ]);
}




    public function index()
{   
    //$getCommunes = $this->communesModel->getCommunesActifs();
//  $getTypes = $this->typesModel->getTypeInstitutionsActifs();
    $data['page'] = "index";
    //$data['getTypes'] = $getTypes;
    //$data['getCommunes'] = $getCommunes;
    $this->load->view('templates/header', $data);
    $data['page_title'] = $this->lang->line('Accueil_title');
    $this->load->view('auth/login', $data);
      $this->load->view('templates/footer', $data);
}


    public function register() {
        $data = array(
            'page_title' => 'Register - CoinFinance',
            'active_page' => 'register'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('auth/register', $data);
        $this->load->view('templates/footer', $data);
    }

public function logout() {
    $this->session->sess_destroy();
    redirect('auth'); // index est la méthode par défaut
}


    public function verify($token) {
        // Logique de vérification Magic Link
        if ($this->User_model->verify_magic_link($token)) {
            $user_data = $this->User_model->get_user_by_token($token);
            
            $session_data = array(
                'user_id' => $user_data['id'],
                'email' => $user_data['email'],
                'user_role' => $user_data['role'],
                'wallet_address' => $user_data['wallet_address'],
                'is_logged_in' => TRUE
            );
            
            $this->session->set_userdata($session_data);
            redirect('dashboard');
        } else {
            redirect('auth/login?error=invalid_token');
        }
    }

    public function wallet_connect() {
        // Endpoint pour la connexion wallet via AJAX
        $wallet_address = $this->input->post('wallet_address');
        $signature = $this->input->post('signature');
        
        if ($this->User_model->verify_wallet_signature($wallet_address, $signature)) {
            $user_data = $this->User_model->get_user_by_wallet($wallet_address);
            
            $session_data = array(
                'user_id' => $user_data['id'],
                'wallet_address' => $wallet_address,
                'user_role' => $user_data['role'],
                'login_method' => 'wallet',
                'is_logged_in' => TRUE
            );
            
            $this->session->set_userdata($session_data);
            
            $response = array('status' => 'success', 'redirect' => base_url('dashboard'));
        } else {
            $response = array('status' => 'error', 'message' => 'Invalid signature');
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    
}