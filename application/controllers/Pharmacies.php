<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pharmacies extends CI_Controller {

public function __construct()
{
	//	Chargement des ressources pour tout le contrôleur
	parent::__construct();
	$this->load->library(array('form_validation', 'mailjet'));
	$this->load->helper(array('url', 'assets', 'form'));
	$this->load->model('Global_model', 'globalModel');
	$this->load->model('Pharmacies_model', 'pharmaciesModel');
	$this->load->model('Communes_model', 'communesModel');
	date_default_timezone_set('UTC');
}


public function index()
{	
	$getCommunes = $this->communesModel->getCommunesActifs();

	$getPharmacies = $this->pharmaciesModel->getPharmaciesByCommunesId($this->session->userdata('communeId'));
	
	$data['page'] = "pharmacies";
	$data['getCommunes'] = $getCommunes;
	$data['getPharmacies'] = $getPharmacies;
	$data['getPeriodesGarde'] = $this->pharmaciesModel->isPeriodesGarde();
	$data['page_title'] = $this->lang->line('Accueil_title');
	$this->load->view('customers/pharmacies', $data);
}

public function listerLesAssurances($id_entreprise)
{
    //on vérifie si une session existe
    $getListeAssurances = $this->pharmaciesModel->getListeAssurByOfficines($id_entreprise);
    if ($getListeAssurances)
    {  
        $data['page'] = "assurances";
		$data['getPharmacies'] = $this->pharmaciesModel->isIdClients($id_entreprise);
		$data['getListeAssur'] = $getListeAssurances;
		$data['page_title'] = $this->lang->line('Accueil_title');
		$this->load->view('customers/assurances', $data);
    }
    else
    {   
        $this->session->set_flashdata('error','Aucune Assurance Associée !'); 
        redirect('Pharmacies');
    }
}

public function rechercher()
{	

	$communeId = $this->input->post('communeId');
	$filtre_date = array('communeId' => $communeId);
    $this->session->set_userdata($filtre_date);

	$getCommunes = $this->communesModel->getCommunesActifs();
	$getPharmacies = $this->pharmaciesModel->getPharmaciesByCommunesId($communeId);

	if (empty($getPharmacies)) 
	{
		$this->session->set_flashdata('error', "Aucune correspondance !");
	}
	else
	{
		 $this->session->set_flashdata('success', "Recherche terminée !");
	}

	//var_dump($getPharmacies);
	//exit();

	$data['page'] = "pharmacies";
	$data['getCommunes'] = $getCommunes;
	$data['getPharmacies'] = $getPharmacies;
	$data['getPeriodesGarde'] = $this->pharmaciesModel->isPeriodesGarde();
	$data['page_title'] = $this->lang->line('Accueil_title');
	$this->load->view('customers/pharmacies', $data);
}


}
