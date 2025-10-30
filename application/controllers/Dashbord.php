	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashbord extends CI_Controller {

	  public function __construct()
	{
		//	Chargement des ressources pour tout le contrôleur
		parent::__construct();

		$this->load->model('Groupes_sanguins_model', 'groupeSanguinsModel');
		$this->load->model('Reservations_model', 'resModel');
		$this->load->model('Quartiers_model', 'quartiersModel');
		$this->load->model('Horaires_model', 'horairesModel');
		$this->load->model('Entreprises_model', 'entModel');
		$this->load->model('Sous_vaccins_model', 'sousVaccinsModel');
		$this->load->model('Cat_vaccins_model', 'catVaccinsModel');
		$this->load->model('Vaccins_model', 'vaccinsModel');
		$this->load->model('Dossiers_model', 'dossiersModel');
		$this->load->model('Metiers_model', 'metiersModel');
		$this->load->model('Communes_model', 'communesModel');
		$this->load->model('Global_model', 'globalModel');
		$this->load->model('Auth_model', 'authModel');
		date_default_timezone_set('UTC');
	}

	public function index()
	{	
		//on vérifie si une session existe 
		$email_pme = $this->session->userdata('email_pme');	
		if ($email_pme == NULL)
		{	
			redirect(site_url('Accueil/login'));
		}
		else
		{	
			$data['page'] = "dashbord";
			$data['page_title'] = $this->lang->line('Accueil_title');
			$this->load->view('acompte/dashbord', $data);
		}
	}

	}
