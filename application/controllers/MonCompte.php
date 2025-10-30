<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MonCompte extends CI_Controller {

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
	$this->load->model('Dashbord_model','dashModel');
	$this->load->model('Auth_model', 'authModel');
	date_default_timezone_set('UTC');
}

public function index()
{   
    $email_pme = $this->session->userdata('email_pme');  
    if ($email_pme == NULL)
    {   
        redirect(site_url('Accueil/login'));
    }
    else
    {   
        $getTypeFacture = $this->dashModel->getTypeFacturesActifs();
        $Pme = $this->session->userdata('pmeID');

        $data = array(
            'page' => "comptes",
            'getTypeFacture' => $getTypeFacture,
            'page_title' => "Coinfinance !"
        );

        $this->load->view('acompte/comptes', $data);
    }
}


public function Password()
{	
	//on vérifie si une session existe 
	$email_pme = $this->session->userdata('email_users');	
	if ($email_pme == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{	

		$getComptes = $this->authModel->getPmeById($this->session->userdata('id_users'));
		

		$data['page'] = "motdepasse";
		$data['getComptes'] = $getComptes;
		$data['page_title'] = $this->lang->line('Accueil_title');

		$this->load->view('acompte/motdepasse', $data);
	}
}

public function majPassword()
{ 
    //on vérifie si une session existe 
    $email_pme = $this->session->userdata('email_users');
	if ($email_pme == NULL)
	{
		redirect(site_url('Accueil'));	
	}
	else
	{	
		$mobile_users = $this->session->userdata('mobile_users');
		$getUsers = $this->authModel->loginAuth($mobile_users, $this->input->post('oPassword'));
		if ($getUsers)
        {
	        if ($this->input->post('password') == $this->input->post('rpassword'))
	        {
	            if (strlen($this->input->post('password')) >= 5)
	            {	
	            	$id = $getUsers->idPme;
	                $completed = $this->authModel->changer_mot_passe_pme($id, $this->input->post('password'));
	                
	                if ($completed)
	                {   
	                    $this->session->set_flashdata('success','Succès, Mot de passe modifié !'); 
	                    redirect('MonCompte/password');
	                }
	                else
	                { 
	                    $this->session->set_flashdata('error','Veuillez réessayer SVP !'); 
	                    redirect('MonCompte/password');
	                }
	            }
	            else
	            { 
	                $this->session->set_flashdata('error','Longueur de mot de passe incorrecte'); 
	                redirect('MonCompte/password');
	            }
	        }
	        else
	        { 
	           $this->session->set_flashdata('error','Les mots de passe sont différents !'); 
	           redirect('MonCompte/password');  
  	     	}
	    }
        else
        { 
           $this->session->set_flashdata('error','Mauvais mot de passe !'); 
           redirect('MonCompte/password');  
	    }
    }
}

public function voirDossiers($id_patients)
{	
	//on vérifie si une session existe 
	$email_pme = $this->session->userdata('email_users');	
	if ($email_pme == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{	

		$getComptes = $this->dossiersModel->isPatientsWithCategories($id_patients);
		
		$getMetiers = $this->metiersModel->getMetiersActifs();
		$getCommunes = $this->communesModel->getCommunesActifs();
		$getSousVaccins = $this->sousVaccinsModel->getSousVaccinsActifs();
		$getCatVaccins = $this->catVaccinsModel->getCatVaccinsActifs();
		$getGroupeSanguins = $this->groupeSanguinsModel->getGroupesSanguinsActifs();
		
		$data['page'] = "dossiers";
		$data['getMetiers'] = $getMetiers;
		$data['getComptes'] = $getComptes;
		$data['getSousVaccins'] = $getSousVaccins;
		$data['getCatVaccins'] = $getCatVaccins;
		$data['getGroupeSanguins'] = $getGroupeSanguins;
		$data['getCommunes'] = $getCommunes;
		$data['page_title'] = $this->lang->line('Accueil_title');
		$this->load->view('acompte/modifierdossiers', $data);
	}
}

public function ajouter()
{	
	//on vérifie si une session existe 
	$email_pme = $this->session->userdata('email_users');	
	if ($email_pme == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{	

		$getMetiers = $this->metiersModel->getMetiersActifs();
		$getCommunes = $this->communesModel->getCommunesActifs();
		$getSousVaccins = $this->sousVaccinsModel->getSousVaccinsActifs();
		$getCatVaccins = $this->catVaccinsModel->getCatVaccinsActifs();
		$getGroupeSanguins = $this->groupeSanguinsModel->getGroupesSanguinsActifs();
		

		$data['page'] = "dossiers";
		$data['getMetiers'] = $getMetiers;
		$data['getCommunes'] = $getCommunes;
		$data['getSousVaccins'] = $getSousVaccins;
		$data['getCatVaccins'] = $getCatVaccins;
		$data['getGroupeSanguins'] = $getGroupeSanguins;
		$data['page_title'] = $this->lang->line('Accueil_title');
		$this->load->view('acompte/createdossiers', $data);
	}
}

public function MesDossiers()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{	
		$getListeDossiers = $this->dossiersModel->getListesDossiersByPatients($this->session->userdata('id_users'));

		$data['page'] = "dossiers";
		$data['getListeDossiers'] = $getListeDossiers;
		$data['page_title'] = $this->lang->line('Accueil_title');
		$this->load->view('acompte/dossiers', $data);
	}
}

public function MesRappelsVaccins()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{	
		$getMesRappelsVaccins = $this->resModel->getListesRappelsByUsers($this->session->userdata('id_users'));

		$getRappelsAnnules = $this->resModel->getUsersStatsRappelsByStatus($this->session->userdata('id_users'),'A');
		$getRappelsPendings = $this->resModel->getUsersStatsRappelsByStatus($this->session->userdata('id_users'),'P');
		$getRappelsEffectues = $this->resModel->getUsersStatsRappelsByStatus($this->session->userdata('id_users'),'S');

		$data['page'] = "listedesrappels";
		$data['getRappelsAnnules'] = $getRappelsAnnules;
		$data['getRappelsPendings'] = $getRappelsPendings;
		$data['getRappelsEffectues'] = $getRappelsEffectues;
		$data['getMesRappelsVaccins'] = $getMesRappelsVaccins;
		$data['page_title'] = $this->lang->line('Accueil_title');
		$this->load->view('acompte/listedesrappels', $data);
	}
}

public function MesRendezVous()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{	
		$getMesRendezVous = $this->resModel->getListesRDVsByUsers($this->session->userdata('id_users'));

		$getRDVsAnnules = $this->resModel->getUsersStatsRDVsByStatus($this->session->userdata('id_users'),'A');
		$getRDVsPendings = $this->resModel->getUsersStatsRDVsByStatus($this->session->userdata('id_users'),'P');
		$getRDVsEffectues = $this->resModel->getUsersStatsRDVsByStatus($this->session->userdata('id_users'),'S');

		$data['page'] = "rendezvous";
		$data['getRDVsAnnules'] = $getRDVsAnnules;
		$data['getRDVsPendings'] = $getRDVsPendings;
		$data['getRDVsEffectues'] = $getRDVsEffectues;
		$data['getMesRendezVous'] = $getMesRendezVous;
		$data['page_title'] = $this->lang->line('Accueil_title');
		$this->load->view('acompte/rendezvous', $data);
	}
}

public function prendreRendezVous()
{		

       
		$data['page'] = "prendrerdv";
		$data = array('page' => "Coinfinance || Site PME !",

		'getScorePmeActif' => $this->dashModel->getScorePme(),
		'getFactureTokeniserPmeActif' => $this->dashModel->getMontantFactureTokeniser(),
		'getLiquiditeObtenueActif' => $this->dashModel->getLiquiditeObtenue(),
		'getFacture' => $this->dashModel->getFacturefActif(),
				         );
		$this->load->view('acompte/prendrerdv', $data);

	
}

public function jqueryConfirmationsByRdvs()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{
		header("Access-Control-Allow-Origin: *");

		$date_deb_res = $this->globalModel->jeConvertisDateEnFormatAnglais($this->input->post('date_deb_res'));
		$idEntreprise = $this->input->post('idEntreprise');

		$getRangs = $this->resModel->getRangRdvsVaccins($idEntreprise, $date_deb_res)->nombre;
			if ((int)$getRangs > 0)
			{	
					$rangs = (int)$getRangs +1;
					echo ($rangs.'ème');
			}
			else
			{
				  echo "1ère";
			}

	}
	
}

public function jqueryListeCentresByCommune()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{
		header("Access-Control-Allow-Origin: *");

		$communeEntrepriseId = $this->input->post('communeEntrepriseId');
		//var_dump($sousVaccinsFk);
		$query = $this->entModel->getEntrepriseByCommunesId($communeEntrepriseId);
		if ($query)
		{
			echo json_encode($query);
		}
		else
		{
			echo "";
		}

	}

}

public function jqueryListeCentresByQuartiers()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{
		header("Access-Control-Allow-Origin: *");

		$quartierEntrepriseId = $this->input->post('quartierEntrepriseId');
		$communeEntrepriseId = $this->input->post('communeEntrepriseId');
		$date_deb_res = $this->globalModel->jeConvertisDateEnFormatAnglais($this->input->post('date_deb_res'));
		$indexJourVaccination = date_create($date_deb_res)->format('w');

		//var_dump($indexJourVaccination);
		$query = $this->entModel->isEntrepriseByQuartiersId($quartierEntrepriseId, $communeEntrepriseId,
		$indexJourVaccination);
		if ($query)
		{
			echo json_encode($query);
		}
		else
		{
			echo "";
		}

	}


}

public function jqueryListeQuartiersByCommune()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{
		header("Access-Control-Allow-Origin: *");

		$communeEntrepriseId = $this->input->post('communeEntrepriseId');
		//var_dump($sousVaccinsFk);
		$query = $this->quartiersModel->getQuartiersByCommune($communeEntrepriseId);
		if ($query)
		{
			echo json_encode($query);
		}
		else
		{
			echo "";
		}

	}


}

public function jqueryListeVaccinsBySousVaccins()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{
		header("Access-Control-Allow-Origin: *");

		$sousVaccinsFk = $this->input->post('sousVaccinsFk');
		//var_dump($sousVaccinsFk);
		$query = $this->vaccinsModel->getListeVaccinsBySousVaccins($sousVaccinsFk);
		if ($query)
		{
			echo json_encode($query);
		}
		else
		{
			echo "";
		}

	}


}

public function majDossiersPersos()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{
		$catVaccinsID = $this->input->post('catVaccinsID');
		$sousVaccinsID = $this->input->post('sousVaccinsID');

        $existance = $this->authModel->getPmeById($this->session->userdata('id_users')); 
	    if ($existance)
	    {	
	    	$addingID = $this->dossiersModel->majDossiersPersos($this->session->userdata('id_users'), 
	    	$catVaccinsID, $sousVaccinsID); 
	    	if ($addingID) 
	    	{	
		    	$this->session->set_flashdata('success', "Votre compte est mis à jour !");
	            redirect(site_url('MonCompte'));
	    		
	    	}
	    	else
	    	{
	    		$this->session->set_flashdata('error',"Mise à jour des existants échoués !"); 
            	redirect(site_url('MonCompte'));
	    	}
	    	
	    }
	    else
	    {
	    	$this->session->set_flashdata('error',"Ce compte est inexistant !"); 
            redirect(site_url('MonCompte'));
	    }
	}
}

public function jqueryListeSousVaccinsByCatVaccins()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{
		header("Access-Control-Allow-Origin: *");

		$catVaccinsID = $this->input->post('catVaccinsID');
		$query = $this->dossiersModel->getListesSousVaccinsByCategories($catVaccinsID);
		if ($query)
		{
			echo json_encode($query);
		}
		else
		{
			echo "";
		}

	}
}

public function suppression($id_patients)
{
    //on vérifie si une session existe
    $communeID = $this->session->userdata('communeID');
    if ($communeID == NULL)
    {
        redirect(site_url('Accueil/login'));  
    }
    else
    {     
    	  $getResByPatients = $this->resModel->isResPatientsByIds($id_patients);
          if ($getResByPatients)
          {
              $this->session->set_flashdata('error','Ce patient a déjà un suivi médical !'); 
              redirect('MonCompte/MesDossiers');
          }

          $existance = $this->authModel->isGetsPatientsByUsers($id_patients);
          if ($existance)
          {
              $this->dossiersModel->supprimerDossiers($id_patients);            
              $this->session->set_flashdata('success','Suppression effectuée !'); 
              redirect('MonCompte/MesDossiers');
          }
          else
          {   
              $this->session->set_flashdata('error','Ce patient est inexistant !'); 
              redirect('MonCompte/MesDossiers');
          }
    }
}

public function majDossiersPatients()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{	
		$id_patients = $this->input->post('id_patients');

		$nom_patients = $this->input->post('nom_patients');
		$prenoms_patients = $this->input->post('prenoms_patients');
		$sexe_patients = $this->input->post('sexe_patients');
		$metiersID = $this->input->post('metiersID');
		$dateNaisPatients = $this->input->post('dateNaisPatients');
		
		$communePatientsId = $this->input->post('communePatientsId');
		$adresse_patients = $this->input->post('adresse_patients');
		$groupeSangPatients = $this->input->post('groupeSangPatients');

		$catVaccinsID = $this->input->post('catVaccinsID');
		$sousVaccinsID = $this->input->post('sousVaccinsID');

        // Check that data was sent to the mailer.
        if ( empty($prenoms_patients) OR empty($nom_patients)) 
        {
            $this->session->set_flashdata('error',"Nom et/ou Prénom(s) requis !"); 
            redirect(site_url('MonCompte/MesDossiers'));
        }

        if ( empty($catVaccinsID) OR empty($sousVaccinsID)) 
        {
            $this->session->set_flashdata('error',"Catégorie et/ou sous vaccin requis !"); 
            redirect(site_url('MonCompte/MesDossiers'));
        }

        $existance = $this->authModel->isGetsPatientsByUsers($id_patients);
	    if ($existance)
	    {	
	    	$this->dossiersModel->majProfilsVisiteurs($id_patients, $nom_patients, $prenoms_patients, 
	    	$sexe_patients, $metiersID, $dateNaisPatients, $communePatientsId, 
	    	$adresse_patients, $groupeSangPatients, $catVaccinsID, $sousVaccinsID);

	    	$this->session->set_flashdata('success', "Ce dossier a été mis à jour !");
            redirect(site_url('MonCompte/MesDossiers'));
	    }
	    else
	    {
	    	$this->session->set_flashdata('error',"Ce compte est inexistant !"); 
            redirect(site_url('MonCompte/MesDossiers'));
	    }
	}
}


public function createCompteUsers()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{
		$nom_patients = $this->input->post('nom_patients');
		$prenoms_patients = $this->input->post('prenoms_patients');
		$sexe_patients = $this->input->post('sexe_patients');
		$metiersID = $this->input->post('metiersID');
		$dateNaisPatients = $this->input->post('dateNaisPatients');
		$email_patients = $this->input->post('email_patients');
		$communePatientsId = $this->input->post('communePatientsId');
		$contact_patients = $this->input->post('contact_patients');
		$adresse_patients = $this->input->post('adresse_patients');
		$groupeSangPatients = $this->input->post('groupeSangPatients');

		$catVaccinsID = $this->input->post('catVaccinsID');
		$sousVaccinsID = $this->input->post('sousVaccinsID');

        // Check that data was sent to the mailer.
        if ( empty($prenoms_patients) OR empty($nom_patients)) 
        {
            $this->session->set_flashdata('error',"Nom et/ou Prénom(s) requis !"); 
            redirect(site_url('MonCompte/MesDossiers'));
        }

        if ( empty($catVaccinsID) OR empty($sousVaccinsID)) 
        {
            $this->session->set_flashdata('error',"Catégorie et/ou sous vaccin requis !"); 
            redirect(site_url('MonCompte/MesDossiers'));
        }

        $existance = $this->dossiersModel->existeSousMyResponsabilite($this->session->userdata('id_users'), 
        $nom_patients, $prenoms_patients); 
	    if (empty($existance))
	    {	
	    	$this->dossiersModel->creerVisiteurs($nom_patients, $prenoms_patients, 
	    	$sexe_patients, $metiersID, $dateNaisPatients, $contact_patients, 
	    	$communePatientsId, $adresse_patients, $email_patients, $groupeSangPatients,
	        $catVaccinsID, $sousVaccinsID);

	    	$this->session->set_flashdata('success', "Ce dossier est crée !");
            redirect(site_url('MonCompte/MesDossiers'));
	    }
	    else
	    {
	    	$this->session->set_flashdata('error',"Ce compte est inexistant !"); 
            redirect(site_url('MonCompte/MesDossiers'));
	    }
	}
}

public function majCompteUsers()
{	
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('communeID');	
	if ($communeID == NULL)
	{	
		redirect(site_url('Accueil/login'));
	}
	else
	{
		$nom_patients = $this->input->post('nom_patients');
		$prenoms_patients = $this->input->post('prenoms_patients');
		$sexe_patients = $this->input->post('sexe_patients');
		$metiersID = $this->input->post('metiersID');
		$dateNaisPatients = $this->input->post('dateNaisPatients');
		$email_patients = $this->input->post('email_patients');
		$communePatientsId = $this->input->post('communePatientsId');
		$contact_patients = $this->input->post('contact_patients');
		$adresse_patients = $this->input->post('adresse_patients');
		$groupeSangPatients = $this->input->post('groupeSangPatients');

        // Check that data was sent to the mailer.
        if ( empty($contact_patients) OR empty($nom_patients) OR empty($dateNaisPatients) OR DateTime::createFromFormat('Y-m-d', $dateNaisPatients) == FALSE) 
        {
            $this->session->set_flashdata('error',"Nom ou Mobile ou Date de Naissance ou Adresse obligatoire !"); 
            redirect(site_url('MonCompte'));
        }

        $getPhone = $this->globalModel->getCodeMobile($contact_patients);
	    if($getPhone == FALSE) 
	    {
	        $this->session->set_flashdata('error','Format de mobile incorrect !'); 
	        redirect(site_url('MonCompte'));
	    }

	    if (!empty($email_patients) && filter_var($email_patients, FILTER_VALIDATE_EMAIL) == FALSE) 
	    {
	    	$this->session->set_flashdata('error','Format Email incorrect !'); 
	        redirect(site_url('MonCompte'));
	    }

        $existance = $this->authModel->getPmeById($this->session->userdata('id_users')); 
	    if ($existance)
	    {	
	    	$this->authModel->updatePme($this->session->userdata('id_users'), $nom_patients, 
	    	$prenoms_patients, $email_patients, $contact_patients);

	    	$this->session->set_flashdata('success', "Votre compte est mis à jour !");
            redirect(site_url('MonCompte'));
	    }
	    else
	    {
	    	$this->session->set_flashdata('error',"Ce compte est inexistant !"); 
            redirect(site_url('Accueil/login'));
	    }
	}
}



}
