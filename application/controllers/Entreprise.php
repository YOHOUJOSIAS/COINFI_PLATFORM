<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entreprise extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('User_model');
        
        // Vérifier les droits d'entreprise
        // $this->check_enterprise_access();
    }

    // private function check_enterprise_access() {
    //     $user_role = $this->session->userdata('user_role');
    //     if (!in_array($user_role, ['enterprise', 'admin'])) {
    //         redirect('dashboard');
    //     }
    // }

    public function functions_view() {
        $data = array(
            'page_title' => 'Enterprise Dashboard - CoinFinance',
            'active_page' => 'enterprise_dashboard'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('entreprise/functions_view', $data);
        $this->load->view('templates/footer', $data);
    }

    public function invoices() {
        $data = array(
            'page_title' => 'My Invoices - CoinFinance',
            'active_page' => 'enterprise_invoices'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('enterprise/invoices', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create_invoice() {
        $data = array(
            'page_title' => 'Submit Invoice - CoinFinance',
            'active_page' => 'enterprise_create'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('enterprise/create_invoice', $data);
        $this->load->view('templates/footer', $data);
    }

    public function collateral($invoice_id = null) {
        $data = array(
            'page_title' => 'Manage Collateral - CoinFinance',
            'active_page' => 'enterprise_collateral',
            'invoice_id' => $invoice_id
        );

        $this->load->view('templates/header', $data);
        $this->load->view('enterprise/collateral', $data);
        $this->load->view('templates/footer', $data);
    }

    public function funds() {
        $data = array(
            'page_title' => 'Withdraw Funds - CoinFinance',
            'active_page' => 'enterprise_funds'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('enterprise/funds', $data);
        $this->load->view('templates/footer', $data);
    }

    public function invoice_details($invoice_id) {
        $data = array(
            'page_title' => 'Invoice Details - CoinFinance',
            'active_page' => 'enterprise_details',
            'invoice_id' => $invoice_id
        );

        $this->load->view('templates/header', $data);
        $this->load->view('enterprise/invoice_details', $data);
        $this->load->view('templates/footer', $data);
    }
}