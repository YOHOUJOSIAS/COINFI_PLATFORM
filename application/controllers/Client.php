<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('User_model');
        
        // Vérifier les droits de client
        // $this->check_client_access();
    }

    // private function check_client_access() {
    //     $user_role = $this->session->userdata('user_role');
    //     if (!in_array($user_role, ['client', 'admin'])) {
    //         redirect('dashboard');
    //     }
    // }

    public function functions_view() {
        $data = array(
            'page_title' => 'Client Dashboard - CoinFinance',
            'active_page' => 'client_dashboard'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('client/functions_view', $data);
        $this->load->view('templates/footer', $data);
    }

    public function invoices() {
        $data = array(
            'page_title' => 'My Invoices - CoinFinance',
            'active_page' => 'client_invoices'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('client/invoices', $data);
        $this->load->view('templates/footer', $data);
    }

    public function invoice_details($invoice_id) {
        $data = array(
            'page_title' => 'Invoice Details - CoinFinance',
            'active_page' => 'client_details',
            'invoice_id' => $invoice_id
        );

        $this->load->view('templates/header', $data);
        $this->load->view('client/invoice_details', $data);
        $this->load->view('templates/footer', $data);
    }

    public function payment($invoice_id) {
        $data = array(
            'page_title' => 'Repay Invoice - CoinFinance',
            'active_page' => 'client_payment',
            'invoice_id' => $invoice_id
        );

        $this->load->view('templates/header', $data);
        $this->load->view('client/payment', $data);
        $this->load->view('templates/footer', $data);
    }

    public function payment_history() {
        $data = array(
            'page_title' => 'Payment History - CoinFinance',
            'active_page' => 'client_history'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('client/payment_history', $data);
        $this->load->view('templates/footer', $data);
    }
}