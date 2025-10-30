<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factures extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'mailjet'));
        $this->load->helper(array('url', 'assets', 'form'));
        $this->load->model('Factures_model');
        date_default_timezone_set('UTC');
    }

 
protected function get_badge_class($statut) {
    $statut = strtolower($statut);
    switch ($statut) {
        case 'validée':
            return 'bg-success';
        case 'en attente':
        case 'en_attente':
            return 'bg-warning text-dark';
        case 'rejetée':
            return 'bg-secondary';
        default:
            return 'bg-info';
    }
}

public function liste($offset = 0) {
    $limit = 10;
    
   // $this->load->library('pagination');
    
    // Correction de l'URL de base
    $config['base_url'] = site_url('acompte/liste');
    $config['total_rows'] = $this->Factures_model->count_all_factures();
    $config['per_page'] = $limit;
    
  //  $this->pagination->initialize($config);
    
    $data['factures'] = $this->Factures_model->get_factures_paginated($limit, $offset);
   // $data['pagination'] = $this->pagination->create_links();
    
    // Chargez la bonne vue (vérifiez le chemin)
    $this->load->view('acompte/liste', $data); // Adaptez selon votre structure
}

    public function ajouter() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            // Récupération de l'ID PME depuis la session
            $idPme = $this->session->userdata('idPme');

            $data = [
               // 'idPme'             => $idPme,
                'date'              => $this->input->post('date'),
                'nom_entreprise'    => $this->input->post('nom_entreprise'),
                'nom_client'        => $this->input->post('nom_client'),
                'secteur'          => $this->input->post('secteur'),
                'Pays'              => $this->input->post('Pays'),
                'adresse_entreprise'=> $this->input->post('adresse_entreprise'),
                'adresse_client'    => $this->input->post('adresse_client'),
                'type_facture'     => $this->input->post('type_facture'),
                'desc_facture'      => $this->input->post('desc_facture'),
                'montant'           => $this->input->post('montant'),
                'duree'             => $this->input->post('duree'),
                'date_financement' => $this->input->post('date_financement')
            ];

            if ($this->Factures_model->insert_facture($data)) {
                $this->session->set_flashdata('success', 'Facture ajoutée avec succès.');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de l\'ajout de la facture.');
            }

            redirect('MonCompte/prendreRendezVous'); // Rediriger vers la liste des factures
        } else {
            show_error('Méthode non autorisée', 405);
        }
    }
}