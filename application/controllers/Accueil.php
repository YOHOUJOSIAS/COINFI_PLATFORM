<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil extends CI_Controller {

public function __construct()
{
	//	Chargement des ressources pour tout le contrôleur
	parent::__construct();
	$this->load->library(array('form_validation', 'mailjet'));
	$this->load->helper(array('url', 'assets', 'form'));
	$this->load->model('Global_model', 'globalModel');
	//$this->load->model('Communes_model', 'communesModel');
	$this->load->model('Types_institutions_model', 'typesModel');
	$this->load->model('CanalDiffusions_model','canalModel');
	$this->load->model('Auth_model', 'authModel');
	date_default_timezone_set('UTC');
}


public function index()
{	
	//$getCommunes = $this->communesModel->getCommunesActifs();
//	$getTypes = $this->typesModel->getTypeInstitutionsActifs();
	$data['page'] = "index";
	//$data['getTypes'] = $getTypes;
	//$data['getCommunes'] = $getCommunes;
	$data['page_title'] = $this->lang->line('Accueil_title');
	$this->load->view('customers/accueil', $data);
}


public function ajouter_action()
{
    $data = array(
        'nom_projet' => $this->input->post('nom_projet'),
        'description' => $this->input->post('description'),
        'montant' => $this->input->post('montant')
    );

    $this->factureModel->ajouter_facture($data); // Adapte selon ton modèle
    redirect('Facture');
}



public function inscription()
{	
	// Only process POST reqeusts.
    if ($_POST) 
    {
        // Get the form fields and remove whitespace.
        $nom_pme = $this->input->post('nom_pme');
		$description = $this->input->post('description');
		$email_pme = $this->input->post('email_pme');
		$numero_telephone = $this->input->post('numero_telephone');
		$pass_pme = $this->input->post('pass_pme');
		$isAgree = $this->input->post('isAgree');

        // Check that data was sent to the mailer.
        if ( (int)$isAgree != 1 ) 
        {
            // Set a 400 (bad request) response code and exit.
            $this->session->set_flashdata('error',"Veuillez accepter nos conditions SVP !"); 
            redirect(site_url('Accueil/login'));
        }

        if (empty($nom_pme) OR empty($email_pme)) 
        {
            // Set a 400 (bad request) response code and exit.
            $this->session->set_flashdata('error',"Veuillez renseigner les champs SVP !"); 
            redirect(site_url('Accueil/login'));
        }

        $nom_pme = $this->globalModel->jeBloqueLesFauxComptes($nom_pme);
	  //  $nom_pme = $this->globalModel->jeBloqueLesFauxComptes($prenoms_patients);
	    // Check that data was sent to the mailer.
        if ($nom_pme == FALSE) 
        {
            $this->session->set_flashdata('error',"Vérifier les champs renseignés SVP !"); 
            redirect(site_url('Accueil/login'));
        }

        $getPhone = $this->globalModel->getCodeMobile($numero_telephone);
	    if($getPhone == FALSE) 
	    {
		    $this->session->set_flashdata('error',"Format de mobile incorrect ! !"); 
            redirect(site_url('Accueil/login'));
	    }

        $existance = $this->authModel->existePme($numero_telephone); 
	    if (empty($existance)) 
	    {	
	    	$addingID = $this->authModel->createPme($nom_pme, $description, 
	    	$email_pme, $numero_telephone, $pass_pme);

	    	if ($addingID)
		  	{	

		  	//	$this->authModel->createCanalPatients($addingID, $canalFk);

                // Suppression de la gestion des tokens et de l'envoi de SMS Orange
                $this->session->set_flashdata('success', "Succès, votre compte a été créé !");
            	redirect(site_url('Accueil/login'));
            }
			else
			{
				$this->session->set_flashdata('error', "Oups, Prière reprendre SVP !");
            	redirect(site_url('Accueil/login'));
			}

            
        } 
        else 
        {
            $this->session->set_flashdata('error',"Adresse email et/ou mobile existe déjà !"); 
            redirect(site_url('Accueil'));
        }

    } 
    else 
    {
        $this->session->set_flashdata('error','There was a problem, please try again !'); 
        redirect(site_url('Accueil/login'));
    }

}

public function password()
{	
	if ($_POST) 
	{	
        $loginLogin = $this->input->post('loginLogin');
        $query = $this->authModel->existePme($loginLogin);
		if ($query) 
		{	
			$id_users = $query->idPme;
		  	$nom_users = $query->nom_pme;

		  	$getNombreReinitialise = $this->globalModel->getPatientsByReinitialize($id_users);
		  	if ((int)$getNombreReinitialise->nombre >= 2)
		  	{
			    $this->session->set_flashdata('error','Nombre limite quotidien de réinitialisation atteint. Contactez le Support SVP !'); 
                redirect(site_url('Accueil/login'));
		  	}
		  	else
		  	{	
  				
  				$this->globalModel->createReinitialize($id_users, 'P');
  				$mot_de_passe = strtoupper(substr($nom_users, 0, 1)).rand(10000, 99999);
		  	    $getMiseJours = $this->authModel->changer_mot_passe_pme($id_users, $mot_de_passe);
		  		if ($getMiseJours)
			  	{
				    $curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_URL => 'https://api.orange.com/oauth/v3/token',
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => '',
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 0,
					  CURLOPT_FOLLOWLOCATION => true,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => 'POST',
					  CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
					  CURLOPT_HTTPHEADER => array(
					    'Content-Type: application/x-www-form-urlencoded',
					    'Authorization: Basic ZUFYOFpMRnRhbnBFMDFjcjZwRnl4dExZeHZrb3lOcGo6NjlrQkYzNmZGa1RyTXpLbQ=='
					  ),
					));
					$response1 = json_decode(curl_exec($curl), true);
					curl_close($curl);
					if (isset($response1["access_token"]))
					{
						$emailClient = str_replace(array(' ', '-'), '', $loginLogin);
						$message = "Bonjour. Votre nouveau mot de passe temporaire est $mot_de_passe";

						$ch = curl_init();
						curl_setopt_array($ch, array(
						  CURLOPT_URL => 'https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B2250000/requests',
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_POSTFIELDS =>'{
							"outboundSMSMessageRequest": {
								"address": "tel:'.$emailClient.'",
								"senderAddress":"tel:+2250000",
								"senderName":"VACCIPHA",
								"outboundSMSTextMessage": {
									"message": "'.$message.'"
								}
							}
						}',
						  CURLOPT_HTTPHEADER => array(
						    'Content-Type: application/json',
						    'Authorization: Bearer '.$response1["access_token"].''
						  ),
						));
						$resultats = json_decode(curl_exec($ch), true);
						curl_close($ch);
					}

				    if(isset($resultats["outboundSMSMessageRequest"]["resourceURL"]))
	                { 
	                    $this->session->set_flashdata('success', "Succès, Consulter votre mobile !");
	            		redirect(site_url('Accueil/login'));
	                }
	                else
	                {
	                    $this->session->set_flashdata('error', "Oups, Prière consulter le support SVP !");
	            	    redirect(site_url('Accueil/login'));
	                } 

	            }
                else
                {
                    $this->session->set_flashdata('error', "Veuillez reprendre SVP !");
            	    redirect(site_url('Accueil/login'));
                } 

            }
		

		}
		else
		{
			$this->session->set_flashdata('error', "Ce mobile est inconnu !");
        	redirect(site_url('Accueil/login'));
		}

	}
	else
	{
		$this->session->set_flashdata('error', "Veuillez saisir votre mobile !");
    	redirect(site_url('Accueil/login'));
	}
}

public function login()
{	
	//$getCommunes = $this->communesModel->getCommunesActifs();
	//$getCanalDiffusions = $this->canalModel->getCanalDiffusions();
	$data['page'] = "login";
	//$data['getCommunes'] = $getCommunes;
	//$data['getCanalDiffusions'] = $getCanalDiffusions;
	$data['page_title'] = $this->lang->line('Accueil_title');
	$this->load->view('customers/login', $data);
}

public function presentation()
{	
	

	$data['page'] = "apropos";
	$data['page_title'] = $this->lang->line('Accueil_title');
	$this->load->view('customers/apropos', $data);
}

public function marche()
{	
	
	$data['page'] = "commentcamarches";
	$data['page_title'] = $this->lang->line('Accueil_title');
	$this->load->view('customers/commentcamarche', $data);
}

public function market()
{	
	
	$data['page'] = "marketplace";
	$data['page_title'] = $this->lang->line('Accueil_title');
	$this->load->view('customers/marketplace', $data);
}

public function connexion()
{
	//on vérifie si une session existe 
	$communeID = $this->session->userdata('email_pme');	
	if ($communeID != NULL)
	{	
		redirect(site_url('MonCompte'));
	}
	else
	{
		$email_pme = $this->input->post('login');
		$pass_pme = $this->input->post('password');
		$auth = $this->authModel->loginAuth($email_pme, $pass_pme);

		if ($auth)
		{	
			$this->globalModel->createConnectivite($auth->idPme);
			$userdata = array('id_users' => $auth->idPme,
							  'nom_users' => $auth->nom_pme,
							  'prenom_users' => $auth->description,
							  'numero_telephone' => $auth->numero_telephone,
							  'email_users' => $auth->email_pme,
							
							  );
			$this->session->set_userdata($userdata);

   	  		$this->session->set_flashdata('success', 'Bienvenu(e) !');
   	  		redirect(site_url('MonCompte'));
			
		}
		else
		{	
			$this->session->set_flashdata('error', 'Mobile / Password Incorrect !');
			redirect(site_url('Accueil/login'));
		}

	}

}

public function contacts()
{	
	$data['page'] = "contacts";
	$data['page_title'] = "Coinfinance || Nos Contacts";
	$this->load->view('customers/contacts', $data);
}

public function blogs()
{	
	$data['page'] = "blogs";
	$data['page_title'] = "Coinfinance || Nos Contacts";
	$this->load->view('customers/blog', $data);
}

public function createEntreprises()
{
    // Only process POST reqeusts.
    if ($_POST) 
    {
        // Get the form fields and remove whitespace.
        $nom_entreprise = $this->input->post('nom_entreprise');
		$email_entreprise = $this->input->post('email_entreprise');
		$mobile_entreprise = $this->input->post('contact_entreprise');
		$adresse_entreprise = $this->input->post('situationGeoEntreprise');
		$communeEntrepriseId = $this->input->post('communeEntrepriseId');
		$typeEntrepriseId = $this->input->post('typeEntrepriseID');

        // Check that data was sent to the mailer.
        if ( empty($nom_entreprise) OR empty($mobile_entreprise) OR !filter_var($email_entreprise, FILTER_VALIDATE_EMAIL)) 
        {
            // Set a 400 (bad request) response code and exit.
            $this->session->set_flashdata('error',"Veuillez renseigner les champs SVP !"); 
            redirect(site_url('Accueil'));
        }

        $getPhone = $this->globalModel->getCodeMobile($mobile_entreprise);
	    if($getPhone == FALSE) 
	    {
	        $this->session->set_flashdata('error','Format de téléphone incorrect !'); 
	        redirect(site_url('Accueil'));
	    }

        $getRaisonSociaux = $this->globalModel->jeBloqueLesFauxComptes($nom_entreprise);
	    $getEmailEnts = $this->globalModel->jeBloqueLesFauxComptes($email_entreprise);

	    // Check that data was sent to the mailer.
        if ($getRaisonSociaux == FALSE OR $getEmailEnts == FALSE) 
        {
            // Set a 400 (bad request) response code and exit.
            $this->session->set_flashdata('error',"Vérifier les champs renseignés SVP !"); 
            redirect(site_url('Accueil'));
        }

        $existance = $this->authModel->existeEntreprise($nom_entreprise, $email_entreprise, $mobile_entreprise); 
	    if (empty($existance)) 
	    {	

	    	$villeId = $this->communesModel->isCommunes($communeEntrepriseId)->villeCommuneFK;
	    	$entrepriseId = $this->authModel->createursEntreprises($nom_entreprise, $email_entreprise, 
	    	$mobile_entreprise, $villeId, $adresse_entreprise, $typeEntrepriseId, $communeEntrepriseId);

	    	$messageADMIN = "<p>Bonjour ".$nom_entreprise.",</p>       
	        <span>Une demande d'inscription à Vaccipha a été envoyé avec succès.</span> <br />
	        <span>Prière vous connecter au Manager pour une prise en charge.</span><br \>
	        <span>Cordialement,</span> <br /> <br />        
	        <p>Equipe de Vaccipha</p>
	        <p>Cet e-mail a été envoyé automatiquement. Merci de ne pas y répondre.</p>
	        <p>Pour plus d'informations, contactez le +2252522018644 ou envoyer un email à vaccipha@enovpharm.com</p>";
	        $this->mailjet->emailing('vaccipha@enovpharm.com', "INSCRIPTION D'UNE INSTITUTION", $messageADMIN);

	    	if ($entrepriseId) 
	    	{
	            $this->session->set_flashdata('success', "Demande d inscription envoyée !");
	            redirect(site_url('Accueil'));
	    	}
	    	else
	    	{
	    		$this->session->set_flashdata('success', "Demande d inscription envoyée !");
	            redirect(site_url('Accueil'));
	        }

        } 
        else 
        {
            $this->session->set_flashdata('error',"Adresse email et/ou mobile existe déjà !"); 
            redirect(site_url('Accueil'));
        }

    } 
    else 
    {
        $this->session->set_flashdata('error','There was a problem, please try again !'); 
        redirect(site_url('Accueil'));
    }

}

public function submitContactForm()
{
    // Only process POST reqeusts.
    if ($_POST) 
    {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["w3lName"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        //$phone = trim($_POST["w3lPhone"]);
        $message = trim($_POST["w3lMessage"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            // Set a 400 (bad request) response code and exit.
            $this->session->set_flashdata('error',"Oops! Something went wrong !"); 
            redirect(site_url('Accueil/contacts'));
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "vaccipha@enovpharm.com";
        // Set the email subject.
        $subject = $_POST['object'];

        //$this->email->from($email, $name);
		//$this->email->to($recipient);
		//$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
		//$this->email->subject($subject);
		$message = "Formulaire de contact\n\n";
		$message .= "Name: ". $_POST['w3lName'] . "\n";
		//$message .= "Phone: ". $_POST['w3lPhone'] . "\n";
		$message .= "Email: ". $_POST['email'] . "\n";
		$message .= "Message: ". $_POST['w3lMessage'] . "\n";
		//$this->email->message($message);
		//$this->email->send();

        // Send the email.
        $messageid = $this->mailjet->emailing($recipient, $subject, $message);
        if ($messageid) 
        {
            $this->session->set_flashdata('success', "Thank You! Your message has been sent !");
            redirect(site_url('Accueil/contacts'));
        } 
        else 
        {
            $this->session->set_flashdata('error',"Oops! Something went wrong !"); 
            redirect(site_url('Accueil/contacts'));
        }

    } 
    else 
    {
        $this->session->set_flashdata('error','There was a problem, please try again !'); 
        redirect(site_url('Accueil/contacts'));
    }

}

public function submitNewsletter()
{	

	$emailAbo = $this->input->post('emailAbo');
    $verify_email = filter_var($emailAbo, FILTER_VALIDATE_EMAIL);
    if($verify_email == FALSE) 
    {
        $this->session->set_flashdata('error','Format d\'email incorrect !'); 
        redirect(site_url('Accueil'));
    }

    $existance = $this->authModel->existeNewsletter($emailAbo); 
    if (empty($existance)) 
    {
    	// code...
	    $chiffre = mt_rand(0, 65535);
	    $code_promotions = strtoupper('Va-'.$chiffre);
    	$this->authModel->createNewsletter($emailAbo, $code_promotions);

    	$message = "<p>Bienvenu(e) sur Vaccipha,</p>				
		<span>Merci de nous avoir rejoint. Votre plateforme de services de santé en ligne.</span> <br />
		<span>Cordialement,</span> <br /> <br />				
		<p>Equipe de Vaccipha</p>
		<p>Cet e-mail a été envoyé automatiquement. Merci de ne pas y répondre.</p>
		<p>Pour plus d'informations, contactez le +2252522018644 ou envoyer un email à vaccipha@enovpharm.com</p>";
    	$messageid = $this->mailjet->emailing($emailAbo, 
			        									"BIENVENU(E) SUR VACCIPHA !", $message);

    	$this->session->set_flashdata('success', "Email enregistré avec succès !");
		redirect(site_url('Accueil'));
    }
    else
    {
    	$this->session->set_flashdata('error', "Cet abonné existe déjà !");
		redirect(site_url('Accueil'));
    }

}


}
