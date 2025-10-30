<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facture extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Facture_model');
    }
    
    public function index() {
        $data['factures'] = $this->Facture_model->get_factures();
        $this->load->view('admin/function_view', $data);
    }
    
    public function get_factures_ajax() {
        $factures = $this->Facture_model->get_factures();
        echo json_encode($factures);
    }
}
?>