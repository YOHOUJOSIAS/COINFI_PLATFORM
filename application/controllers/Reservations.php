<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reservations extends CI_Controller {

function __construct()
{
    parent::__construct();
    $this->load->helper(array('url', 'assets'));
    $this->load->model('Global_model','globalModel');
    $this->load->model('Vaccins_model', 'vaccinsModel');
    $this->load->model('Dossiers_model', 'dossiersModel');
    $this->load->model('Reservations_model','resModel');
    date_default_timezone_set('UTC');
}


public function voirListesVaccins($code_res)
{
    //on vérifie si une session existe
    $communeID = $this->session->userdata('communeID');
    if ($communeID == NULL)
    {
        redirect(site_url('Accueil/login'));  
    }
    else
    {     
          $getCodeRes = $this->resModel->isAfficherResByCodes($code_res);
          if ($getCodeRes)
          {
                $getListeVaccins = $this->resModel->getListesVaccinsByRes($getCodeRes->id_res);

                $data['page'] = "rendezvous";
                $data['getCodeRes'] = $getCodeRes;
                $data['getListeVaccins'] = $getListeVaccins;
                $data['page_title'] = $this->lang->line('Accueil_title');
                $this->load->view('acompte/afficherrendezvous', $data);
          }
          else
          {   
              $this->session->set_flashdata('error','Cette réservation n existe pas !'); 
              redirect('MonCompte/MesRendezVous');
          }
    }
}

public function voirListesRappels($code_res)
{
    //on vérifie si une session existe
    $communeID = $this->session->userdata('communeID');
    if ($communeID == NULL)
    {
        redirect(site_url('Accueil/login'));  
    }
    else
    {     
          $getCodeRes = $this->resModel->isAfficherResByCodes($code_res);
          if ($getCodeRes)
          {
                $getListeVaccins = $this->resModel->getListesVaccinsByRes($getCodeRes->id_res);

                $data['page'] = "listedesrappels";
                $data['getCodeRes'] = $getCodeRes;
                $data['getListeVaccins'] = $getListeVaccins;
                $data['page_title'] = $this->lang->line('Accueil_title');
                $this->load->view('acompte/afficherrappels', $data);
          }
          else
          {   
              $this->session->set_flashdata('error','Cette réservation n existe pas !'); 
              redirect('MonCompte/MesRappelsVaccins');
          }
    }
}

public function desactiver($code_res)
{
    //on vérifie si une session existe
    $communeID = $this->session->userdata('communeID');
    if ($communeID == NULL)
    {
        redirect(site_url('Accueil/login'));  
    }
    else
    {     
          $existance = $this->resModel->isCodeRes($code_res);
          if ($existance)
          {
              $this->resModel->annulerReservations($existance->id_res);            
              $this->session->set_flashdata('success','Annulation effectuée !'); 
              redirect('MonCompte/MesRendezVous');
          }
          else
          {   
              $this->session->set_flashdata('error','Cette réservation n existe pas !'); 
              redirect('MonCompte/MesRendezVous');
          }
    }
}

public function inserer()
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



}