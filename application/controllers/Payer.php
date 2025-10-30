<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payer extends CI_Controller {

public function __construct()
{
	//	Chargement des ressources pour tout le contrôleur
	parent::__construct();
	$this->load->helper(array('url', 'assets', 'form'));
    $this->load->model('Auth_model', 'authModel');
	$this->load->model('Global_model','globalModel');
    $this->load->model('Vaccins_model', 'vaccinsModel');
    $this->load->model('Dossiers_model', 'dossiersModel');
    $this->load->model('Reservations_model','resModel');
	date_default_timezone_set('UTC');
}



public function insererRDVOnline()
{
    //on vérifie si une session existe
    $communeID = $this->session->userdata('communeID');
    if ($communeID == NULL)
    {
        redirect(site_url('Accueil/login'));  
    }
    else
    {      
          $typeClients = $this->input->post('typeClients');
          $sexe_patients = 'Homme';
          $nom_patients = strtok($this->input->post('nameClient'), ' ');
          $prenoms_patients = str_replace($nom_patients.' ', '', $this->input->post('nameClient'));
          $contact_patients = $this->session->userdata('numero_telephone');
          $communePatientsId = $this->input->post('communePatientsId');
          $quartierEntrepriseId = $this->input->post('quartierEntrepriseId');

          $sousVaccinsID = $this->input->post('sousVaccinsID');
          $catVaccinsID = $this->input->post('catVaccinsID');

          if ($typeClients == 'N') 
          { 
               if (!empty($nom_patients) && !empty($sousVaccinsID) && !empty($catVaccinsID)) 
               {
                    $addingPatientID = $this->dossiersModel->creationsDossiers($nom_patients, 
                    $prenoms_patients, $sexe_patients, $contact_patients, 
                    $communePatientsId, $quartierEntrepriseId, $sousVaccinsID, $catVaccinsID);
               }
               else
               {
                    $this->session->set_flashdata('error',"Veuillez renseigner le nouveau dossier SVP !"); 
                    redirect(site_url('MonCompte/prendreRendezVous'));
               }
          }
          
          

          $montant_res = 500;
          $modePaieID = 1;
       
          $quartierEntrepriseId = $this->input->post('quartierEntrepriseId');
          $idPlageHoraires = $this->input->post('idPlageHoraires');
          $ClientsId = $this->input->post('ClientsId');
          $idEntreprise = $this->input->post('idEntreprise');
          $dateResDeb = $this->globalModel->jeConvertisDateEnFormatAnglais($this->input->post('date_res_deb')).' 07:00:00';

          //Liste des vaccins (tableau)
          $idVaccins = $this->input->post('idVaccins');
          $code_res = 'V'.$this->globalModel->generateUnik();
          $date_res_deb = date('Y-m-d '.$randPlageHoraire.'00:00', strtotime("$dateResDeb"));
          $date_res_end = date("Y-m-d H:i:s", strtotime("$date_res_deb +1 hours"));
          $getDossiers = $this->dossiersModel->isDossiersByPatientsID($ClientsId);

          $existance = $this->resModel->isCodeRes($code_res);
          if (empty($existance))
          {
              if ($typeClients == 'N' && !empty($addingPatientID))
              { 
                  $resID = $this->resModel->createResVaccins($code_res, $idEntreprise, $addingPatientID, 
                  $montant_res, $date_res_deb, $date_res_end, $idPlageHoraires, $sousVaccinsID, 
                  $catVaccinsID, count($idVaccins), null, 'V', $modePaieID);

                  //foreach ($idVaccins as $vaccins)
                  for ($i=0; $i < count($idVaccins); $i++)   
                  {
                      $this->resModel->createVaccinations($idEntreprise, $resID, $idVaccins[$i], 
                      $addingPatientID, null, 'V');
                        // Préparation des données pour l'API de paiement
        $url = 'https://rest-airtime.paysecurehub.com/api/payhub-ws/build-away';
        $donnees = [
            'code_paiement' => $code_res,
            'nom_usager' => $this->input->post('nom_usager'),
            'prenom_usager' => $this->input->post('prenom_usager'),
            'telephone' => $this->input->post('telephone'),
            'email' => $this->input->post('email'),
            'libelle_article' => $this->input->post('libelle_article'),
            'quantite' => $this->input->post('quantite'),
            'montant' => $montant_res,
            'lib_order' => 'PAIEMENT DE RENDEZ-VOUS',
            'Url_Retour' => 'https://vaccipha.vaccipha.net/MesRendezVous',
            'Url_Callback' => 'https://vaccipha.vaccipha.net/Payer/getRetourPaiement'
        ];

        $jsonData = json_encode($donnees);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'ApiKey: shk_ZYPIGsVXBjZHmHCB90Yru33KusyHUZ5r7n19',
            'MerchantId: qr73jgfjet',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);

        $apiResponse = curl_exec($curl);
        if ($apiResponse === false) {
            $response = [
                'success' => false,
                'message' => 'Erreur lors de la communication avec le serveur de paiement.',
                'error' => curl_error($curl)
            ];
        } else {
            $ResJSON = json_decode($apiResponse, true);
            if ($ResJSON['code'] === 200 && !empty($ResJSON['url'])) {
                header('Location: ' . $ResJSON['url']);
                exit;
            } else {
                $response = [
                    'success' => false,
                    'message' => $ResJSON['message'] ?? 'Erreur inattendue lors du traitement du paiement.'
                ];
            }
        }
        curl_close($curl);


   

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;

                      /*
                      $getVaccins = $this->vaccinsModel->isVaccinsActifs($idVaccins[$i]);
                      if ($getVaccins && (int)$getVaccins->isDoseUnique == 0) {

                          for ($j=1; $j < (int)$getVaccins->nombreDoses; $j++) { 

                            $nombre = (int)$getVaccins->nombreDoses*$j;
                            $codeRes = 'R'.$this->globalModel->generateUnik();
                            $dateCreateRes = date("Y-m-d", strtotime("$date_res_end +$nombre days")).' 07:00:00';

                            $dateResDebut = date("Y-m-d H:i:s", strtotime("$dateCreateRes +$idPlageHoraires hours"));
                            $dateResFinal = date("Y-m-d H:i:s", strtotime("$dateResDebut +1 hours"));


                            $idRes = $this->resModel->createResVaccins($codeRes, $idEntreprise, 
                            $addingPatientID, $montant_res, $dateResDebut, $dateResFinal, 
                            $idPlageHoraires, $sousVaccinsID, $catVaccinsID, 1, $resID, 'R', $modePaieID);

                            $this->resModel->createVaccinations($idEntreprise, $idRes, $idVaccins[$i], 
                            $addingPatientID, $resID, 'R');

                          }

                      }
                      */
                  }
              }
              else
              {
                  $resID = $this->resModel->createResVaccins($code_res, $idEntreprise, $ClientsId, 
                  $montant_res, $date_res_deb, $date_res_end, $idPlageHoraires, 
                  $getDossiers->sousVaccinsID, $getDossiers->catVaccinsID, count($idVaccins), 
                  null, 'V', $modePaieID);

                  //foreach ($idVaccins as $vaccins)

                  for ($i=0; $i < count($idVaccins); $i++)  
                  {
                       $this->resModel->createVaccinations($idEntreprise, $resID, $idVaccins[$i], 
                       $ClientsId, null, 'V');
                         // Préparation des données pour l'API de paiement
        $url = 'https://rest-airtime.paysecurehub.com/api/payhub-ws/build-away';
        $donnees = [
            'code_paiement' => $code_res,
            'nom_usager' => $this->input->post('nom_usager'),
            'prenom_usager' => $this->input->post('prenom_usager'),
            'telephone' => $this->input->post('telephone'),
            'email' => $this->input->post('email'),
            'libelle_article' => $this->input->post('libelle_article'),
            'quantite' => $this->input->post('quantite'),
            'montant' => $montant_res,
            'lib_order' => 'PAIEMENT DE RENDEZ-VOUS',
            'Url_Retour' => 'https://vaccipha.vaccipha.net/MesRendezVous',
            'Url_Callback' => 'https://vaccipha.vaccipha.net/Payer/getRetourPaiement'
        ];

        $jsonData = json_encode($donnees);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'ApiKey: shk_ZYPIGsVXBjZHmHCB90Yru33KusyHUZ5r7n19',
            'MerchantId: qr73jgfjet',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);

        $apiResponse = curl_exec($curl);
        if ($apiResponse === false) {
            $response = [
                'success' => false,
                'message' => 'Erreur lors de la communication avec le serveur de paiement.',
                'error' => curl_error($curl)
            ];
        } else {
            $ResJSON = json_decode($apiResponse, true);
            if ($ResJSON['code'] === 200 && !empty($ResJSON['url'])) {
                header('Location: ' . $ResJSON['url']);
                exit;
            } else {
                $response = [
                    'success' => false,
                    'message' => $ResJSON['message'] ?? 'Erreur inattendue lors du traitement du paiement.'
                ];
            }
        }
        curl_close($curl);

   

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;

                       /*
                       $getVaccins = $this->vaccinsModel->isVaccinsActifs($idVaccins[$i]);
                       if ($getVaccins && (int)$getVaccins->isDoseUnique == 0) {

                          for ($j=1; $j < (int)$getVaccins->nombreDoses; $j++) { 

                            $nombre = (int)$getVaccins->nombreDoses*$j;
                            $codeRes = 'R'.$this->globalModel->generateUnik();
                            $dateCreateRes = date("Y-m-d", strtotime("$date_res_end +$nombre days")).' 07:00:00';

                            $dateResDebut = date("Y-m-d H:i:s", strtotime("$dateCreateRes +$idPlageHoraires hours"));
                            $dateResFinal = date("Y-m-d H:i:s", strtotime("$dateResDebut +1 hours"));


                            $idRes = $this->resModel->createResVaccins($codeRes, $idEntreprise, 
                            $ClientsId, $montant_res, $dateResDebut, $dateResFinal, 
                            $idPlageHoraires, $getDossiers->sousVaccinsID, $getDossiers->catVaccinsID, 
                            1, $resID, 'R', $modePaieID);

                            $this->resModel->createVaccinations($idEntreprise, $idRes, $idVaccins[$i], 
                            $ClientsId, $resID, 'R');

                          }

                        }
                        */
                  }
                  

              }

              if ($resID)
              {   
                  $this->session->set_flashdata('success', "Succès, Votre RDV est enregistré !");
                  redirect(site_url('MonCompte/MesRendezVous'));
              }
              else
              {
                  $this->session->set_flashdata('error', "Erreur système, Veuillez reprendre SVP !");
                  redirect(site_url('MonCompte/MesRendezVous'));
              }

          }
          else
          {
              $this->session->set_flashdata('error',"Cette réservation existe déjà !"); 
              redirect(site_url('MonCompte/prendreRendezVous'));
          }

          
    }
}

public function getTokens2()
{
    $communeID = $this->session->userdata('communeID');
    if ($communeID == NULL)
    {
        redirect(site_url('Accueil'));  
    }
    else
    {   
        $token = null;
        $montantTotal = $this->input->post('montantTotal');

        $curl = curl_init();
        curl_setopt_array($curl, array(
          //CURLOPT_URL => 'https://dev.sycapay.com/login.php',
          CURLOPT_URL => 'https://secure.sycapay.com/login',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          //CURLOPT_POSTFIELDS => array('montant' => $montantTotal,'currency' => 'XOF'),
          CURLOPT_POSTFIELDS => array('montant' => $montantTotal,'curr' => 'XOF'),
          CURLOPT_HTTPHEADER => array(
            'X-SYCA-MERCHANDID: C_6568A1CEBC03C',
            'X-SYCA-APIKEY: pk_syca_439a63e572e8c149dc0775aab22e5f47d2aeda4f',
            'X-SYCA-REQUEST-DATA-FORMAT: JSON',
            'X-SYCA-RESPONSE-DATA-FORMAT: JSON'
          ),
        ));
        $response = json_decode(curl_exec($curl),TRUE);
        curl_close($curl);
        if($response['code'] == 0)
        {
            $token = $response['token'];
        }

        if ($token)
        {   
            $code_res = 'V'.$this->globalModel->generateUnik();
            echo json_encode(array('token' => $token, 'code_res' => $code_res));
        }
        else
        {
            echo "";
        }
    }
}

public function getMobileRetoursPaiement()
{	
	//on vérifie si une session existe
    $purchaseinfo = $this->input->post('purchaseinfo');
    $montant = $this->input->post('montant');
    $status = $this->input->post('status');
    $reference = $this->input->post('reference');
    $contact = $this->input->post('contact');
    $operatorTrans = $this->input->post('provider');

    if ($purchaseinfo)
    {
        $getRecus = $this->resModel->isCodeRes($purchaseinfo);
        if ($getRecus) 
        {
            $id = $this->resModel->payerTrans($status, $operatorTrans, $reference, 
            $getRecus->id_res, $getRecus->montant_res, $getRecus->entResId, $contact);

	        if ($id)
	        {   
                if ((int)$status == 0)
                {
                    if ((int)$getRecus->serviceResID == 2 OR (int)$getRecus->serviceResID == 4) 
                    {
                        $getStocksProd2 = $this->stocksModel->getQteProduitsEnStocks($getRecus->produitsID);
                        if ($getStocksProd2) 
                        {
                            $this->stocksModel->mouvements($id, $getRecus->produitsID, 'S', 
                            $getRecus->montant_res, $getRecus->qteProduits, $getStocksProd2->id_stock_produit, 
                            'Commande confirmée');
                        }
                    }

    	            $response['code']=1;
    	            $response['data']=$purchaseinfo;
    	            $response['msg']="Votre paiement est un succes !";
                }
                else
                { 
                    $response['code']=0;
                    $response['data']= '';
                    $response['msg']="Votre paiement a echoue !";
                }
	        }
	        else
	        {
	            $response['code']=0;
	            $response['data']= '';
	            $response['msg']="Erreur système, Priere contacter le support !";
	        }
        }
        else
        {
        	$response['code']=0;
	        $response['data']= '';
	        $response['msg']="Cette reference de paiement n est pas autorisee !";
        }

    }
    else
    {
        $response['code']=0;
        $response['data']= '';
        $response['msg']="Votre paiement a echoue !";
    }

    echo json_encode($response);
}

public function getRetourPaiement()
{   



    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    $statusTrans = $data['code'];
    $msisdn = $data['no_transation'];
    $operator_id = $data['service_id'];
    $reference_Paiement = $data['referencePaiement'];
    $codeRdv = $data['codePaiement'];
   

    if ($codeRdv)
    {
        $getRecus = $this->resModel->isCodeRes($codeRdv);
        if ($getRecus) 
        {   
            $patientsResId = $getRecus->patientsResId;
            $id = $this->resModel->payerTrans($status, $operatorTrans, $reference, 
            $getRecus->id_res, $getRecus->montant_res, $getRecus->entResId, $contact);

            $auth = $this->authModel->isIDsVisiteurs($patientsResId);
            $this->globalModel->createConnectivite($patientsResId);
            $userdata = array('id_users' => $patientsResId,
                              'nom_users' => $auth->nom_patients,
                              'prenom_users' => $auth->prenoms_patients,
                              'numero_telephone' => $auth->contact_patients,
                              'email_users' => $auth->email_patients,
                              'communeID' => $auth->communePatientsId
                              );
            $this->session->set_userdata($userdata);

            if ($auth)
            {   
                if ((int)$status == 200)
                {
                    $this->session->set_flashdata('success',"Votre paiement est un succès !");
                }
                else
                { 
                    $this->session->set_flashdata('error',"Votre paiement a echoue !");
                }
                
                redirect(site_url('MonCompte/MesRendezVous'));

            }
            else
            {
                $this->session->set_flashdata('error',"Erreur système, Prière contacter le support !");
                redirect(site_url('MonCompte/MesRendezVous'));
            }
        }
        else
        {
            $this->session->set_flashdata('error',"Cette référence de paiement n'est pas autorisée !");
            redirect(site_url('Accueil'));
        }

    }
    else
    {
        $this->session->set_flashdata('error',"Votre paiement a échoué !");
        redirect(site_url('Accueil'));
    }

}



}