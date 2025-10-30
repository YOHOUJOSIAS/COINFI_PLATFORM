<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('User_model');
        
        // Load environment variables
        // $this->load->library('dotenv');
        // $this->dotenv->load();
    }

    public function index() {
        $data = array(
            'page_title' => 'Dashboard - CoinFinance',
            'active_page' => 'dashboard',
            'user_role' => $this->session->userdata('user_role') ?? 'guest',
            'wallet_address' => $this->session->userdata('wallet_address'),
            'contracts' => array(
                'invoice_token' => $_ENV['INVOICE_TOKEN_ADDRESS'],
                'stablecoin_token' => $_ENV['CFN_TOKEN_ADDRESS'],
            ),
            'networks' => array(
                'stablecoin_token' => $_ENV['NETWORK_RPC']
            )
        );

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function statistics() {
        // Endpoint pour récupérer les statistiques via AJAX
        $stats = array(
            'total_invoices' => 0,
            'total_pools' => 0,
            'total_invested' => 0,
            'active_users' => 0
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($stats));
    }

    public function profile() {
        $data = array(
            'page_title' => 'Profile - CoinFinance',
            'active_page' => 'profile',
            'user_data' => $this->session->userdata()
        );

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/profile', $data);
        $this->load->view('templates/footer', $data);
    }

    public function settings() {
        $data = array(
            'page_title' => 'Settings - CoinFinance',
            'active_page' => 'settings'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/settings', $data);
        $this->load->view('templates/footer', $data);
    }
}