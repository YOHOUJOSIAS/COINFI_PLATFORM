<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Investor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('User_model');
        
        // Vérifier les droits d'investisseur
        // $this->check_investor_access();
    }

    // private function check_investor_access() {
    //     $user_role = $this->session->userdata('user_role');
    //     if (!in_array($user_role, ['investor', 'admin'])) {
    //         redirect('dashboard');
    //     }
    // }

    public function functions_view() {
        $data = array(
            'page_title' => 'Investor Dashboard - CoinFinance',
            'active_page' => 'investor_dashboard'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('investor/functions_view', $data);
        $this->load->view('templates/footer', $data);
    }

    public function marketplace() {
        $data = array(
            'page_title' => 'Investment Marketplace - CoinFinance',
            'active_page' => 'investor_marketplace'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('investor/marketplace', $data);
        $this->load->view('templates/footer', $data);
    }

    public function portfolio() {
        $data = array(
            'page_title' => 'My Portfolio - CoinFinance',
            'active_page' => 'investor_portfolio'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('investor/portfolio', $data);
        $this->load->view('templates/footer', $data);
    }

    public function pools() {
        $data = array(
            'page_title' => 'Investment Pools - CoinFinance',
            'active_page' => 'investor_pools'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('investor/pools', $data);
        $this->load->view('templates/footer', $data);
    }

    public function invoice_details($invoice_id) {
        $data = array(
            'page_title' => 'Invoice Details - CoinFinance',
            'active_page' => 'investor_details',
            'invoice_id' => $invoice_id
        );

        $this->load->view('templates/header', $data);
        $this->load->view('investor/invoice_details', $data);
        $this->load->view('templates/footer', $data);
    }

    public function pool_details($pool_id) {
        $data = array(
            'page_title' => 'Pool Details - CoinFinance',
            'active_page' => 'investor_pool_details',
            'pool_id' => $pool_id
        );

        $this->load->view('templates/header', $data);
        $this->load->view('investor/pool_details', $data);
        $this->load->view('templates/footer', $data);
    }

    public function claims() {
        $data = array(
            'page_title' => 'Claim Funds - CoinFinance',
            'active_page' => 'investor_claims'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('investor/claims', $data);
        $this->load->view('templates/footer', $data);
    }
}