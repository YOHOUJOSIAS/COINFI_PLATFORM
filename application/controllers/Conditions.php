<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conditions extends CI_Controller {

public function __construct()
{
	//	Chargement des ressources pour tout le contrôleur
	parent::__construct();
	$this->load->library(array('form_validation', 'mailjet'));
	$this->load->helper(array('url', 'assets', 'form'));
	date_default_timezone_set('UTC');
}


public function index()
{	
	$data['page'] = "contacts";
	$data['page_title'] = $this->lang->line('Accueil_title');
	$this->load->view('customers/conditions', $data);
}

}
