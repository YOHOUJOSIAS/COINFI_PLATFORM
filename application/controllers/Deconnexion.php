<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Deconnexion extends CI_Controller {
	
	    function __construct()
	    {
	        //	Chargement des ressources pour tout le contrôleur
	        parent::__construct();
			$this->load->helper(array('url', 'assets'));
			//$this->load->model('Global_model', 'globalModel');
	    }
	
	    function index()
	    {	
	    	//on vérifie si une session existe 
			$email_pme = $this->session->userdata('email_pme');
			if ($email_pme == NULL)
			{	
				$this->session->sess_destroy();
		    	redirect(base_url());
			}
			else
			{	
		    	$this->session->unset_userdata('email_pme');
	        	$this->session->sess_destroy();
		    	redirect(base_url());
		    }
	    }
	}
?>