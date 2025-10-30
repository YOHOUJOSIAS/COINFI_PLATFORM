<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('User_model');
        
        // Vérifier les droits d'admin
        // $this->check_admin_access();
    }

    //  

    public function index() {
        $data = array(
            'page_title' => 'Admin Panel - CoinFinance',
            'active_page' => 'admin_dashboard'
        );

        // $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        // $this->load->view('templates/footer', $data);
    }


    public function functions_view() {
        $data = array(
            'page_title' => 'Admin Functions - CoinFinance',
            'active_page' => 'admin_functions'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('admin/functions_view', $data);
        $this->load->view('templates/footer', $data);
    }

    public function users() {
        $data = array(
            'page_title' => 'User Management - CoinFinance',
            'active_page' => 'admin_users'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('templates/footer', $data);
    }

    public function invoices() {
        $data = array(
            'page_title' => 'Invoice Management - CoinFinance',
            'active_page' => 'admin_invoices'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('admin/invoices', $data);
        $this->load->view('templates/footer', $data);
    }

    public function pools() {
        $data = array(
            'page_title' => 'Pool Management - CoinFinance',
            'active_page' => 'admin_pools'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('admin/pools', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create_invoice() {
        $data = array(
            'page_title' => 'Create Invoice - CoinFinance',
            'active_page' => 'admin_create_invoice'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('admin/create_invoice', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create_pool() {
        $data = array(
            'page_title' => 'Create Pool - CoinFinance',
            'active_page' => 'admin_create_pool'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('admin/create_pool', $data);
        $this->load->view('templates/footer', $data);
    }

    public function settings() {
        $data = array(
            'page_title' => 'Contract Settings - CoinFinance',
            'active_page' => 'admin_settings'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('admin/settings', $data);
        $this->load->view('templates/footer', $data);
    }

    public function roles() {
        $data = array(
            'page_title' => 'Role Management - CoinFinance',
            'active_page' => 'admin_roles'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('admin/roles', $data);
        $this->load->view('templates/footer', $data);
    }
}