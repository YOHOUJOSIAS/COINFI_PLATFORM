<?php
defined ('BASEPATH') OR exit ('No  direct   script   access   allowed');
//CREER LE CONSTRUCTEUR DU MODEL

class Reservations_model extends CI_Model {

public function __construct()
{
    parent::__construct();
    date_default_timezone_set('UTC');
}


protected $table_vaccinations = "vaccinations";
protected $table_entreprise = "entreprise";
protected $table_reservations = "reservations";
protected $table_transactions = "transactions";

/*public function payerTrans($statusTrans, $operateur_trans, $reference_syca, 
    $resID, $montant_trans, $entID, $mobile_paiement)
{       
      if ((int)$statusTrans == 0)
      {     
           $frais_trans = (float)$montant_trans*0.03;
           $status_trans = 'S';
      }
      elseif ((int)$statusTrans == -100)
      {     
          $frais_trans = 0;
          $status_trans = 'P';
      }
      else
      {    
          $frais_trans = 0;
          $status_trans = 'E';
      }

      if (!empty($operateur_trans) AND !empty($reference_syca)) 
      {
          $modePaysId = 2;
      }
      else
      {
          $modePaysId = 2;
          $operateur_trans = 'Neant';
      }   
        

     return $this->db->set('operateur_trans', $operateur_trans)
                     ->set('mobile_paiement', $mobile_paiement)
                     ->set('reference_syca', $reference_syca)
                     ->set('modePayerId', $modePaysId)
                     ->set('montant_trans', (float)$montant_trans)
                     ->set('frais_trans', (double)$frais_trans)
                     ->set('date_maj_trans', date("Y-m-d H:i:s"))
                     ->set('status_trans', $status_trans)
                     ->where('resID', $resID)
                     ->where('entID', $entID)
                     ->update($this->table_transactions);

}*/


public function payerTrans($statusTrans, $operateur_trans, $resID, $montant_trans, $reference_syca, $mobile_paiement)
{  
    log_message('error', 'payerTrans appelée avec statusTrans = '.$statusTrans);

   
    if ((int)$statusTrans === 200) 
    {     
        $frais_trans = (float)$montant_trans * 0.03;
        $status_trans = 'P'; 
    }
   
    else 
    {    
        $frais_trans = 0;
        $status_trans = 'E'; 
    }

    log_message('error', 'Mise à jour status_trans en '.$status_trans.' pour resID '.$resID);


    if (!empty($operateur_trans) && !empty($reference_syca)) 
    {
        $modePaysId = 2;
    }
    else
    {
        $modePaysId = 2;
        $operateur_trans = 'Neant';
    }   

    $req1 = $this->db->set('status_res', $status_trans)
                     ->set('modePaieID', $modePaysId)
                     ->set('date_maj_res', date("Y-m-d H:i:s"))
                     ->where('id_res', $resID)
                     ->update($this->table_reservations);

    if ($req1) 
    {
        $updateTrans = $this->db->set('operateur_trans', $operateur_trans)
                                ->set('mobile_paiement', $mobile_paiement)
                                ->set('reference_syca', $reference_syca)
                                ->set('modePayerId', $modePaysId)
                                ->set('montant_trans', (float)$montant_trans)
                                ->set('frais_trans', (double)$frais_trans)
                                ->set('date_maj_trans', date("Y-m-d H:i:s"))
                                ->set('status_trans', $status_trans)
                                ->where('resID', $resID)
                                ->update($this->table_transactions);

        if (!$updateTrans) {
            log_message('error', 'Échec mise à jour status_trans pour resID '.$resID);
        }

        return $updateTrans;
    }
    else
    {
        log_message('error', ' Échec mise à jour status_res pour resID '.$resID);
        return FALSE;
    }
}



public function getListesVaccinsByRes($reservationsFk)
{     
   $query = $this->db->select('*')
                     ->from($this->table_vaccinations)
                     ->join('vaccins', 'vaccins.idVaccins = vaccinations.vaccinsFk', 'left')
                     ->where('vaccinations.reservationsFk', $reservationsFk)
                     ->order_by("vaccinations.idVaccinations","desc")
                     ->get();
        return $query->result();
}

public function isResPatientsByIds($patientsResId)
{     
      return $this->db->select('*')
                     ->from($this->table_reservations)
                     ->where('reservations.etat_res', 'A')
                     ->where('reservations.patientsResId', $patientsResId)
                     ->get()
                     ->row();
}

public function getUsersStatsRDVsByStatus($patientsResId, $status_res)
{     
      return $this->db->select('count(id_res) as nombre')
                     ->from($this->table_reservations)
                     ->join('patients', 'patients.id_patients = reservations.patientsResId', 'left')
                     ->where('reservations.etat_res', 'A')
                     ->where('reservations.serviceResID', 1)
                     ->where('reservations.parentResFK', NULL)
                     ->where('reservations.status_res', $status_res)
                     ->where('patients.isSousResponsabilite', $patientsResId)
                     ->get()
                     ->row();
}

public function getUsersStatsRappelsByStatus($patientsResId, $status_res)
{     
      return $this->db->select('count(id_res) as nombre')
                     ->from($this->table_reservations)
                     ->join('patients', 'patients.id_patients = reservations.patientsResId', 'left')
                     ->where('reservations.etat_res', 'A')
                     ->where('reservations.serviceResID', 1)
                     ->where('reservations.parentResFK !=', NULL)
                     ->where('reservations.status_res', $status_res)
                     ->where('patients.isSousResponsabilite', $patientsResId)
                     ->get()
                     ->row();
}

public function getListesRappelsByUsers($patientsResId)
{     
      $query = $this->db->select('*')
                        ->from($this->table_reservations)
                        ->join('patients', 'patients.id_patients = reservations.patientsResId', 'left')
                        ->join('entreprise', 'entreprise.id_entreprise = reservations.entResId', 'left')
                        ->where('reservations.etat_res', 'A')
                        ->where('reservations.serviceResID', 1)
                        ->where('reservations.parentResFK !=', NULL)
                        ->where('patients.isSousResponsabilite', $patientsResId)
                        ->order_by("reservations.id_res","desc")
                        ->get();
           return $query->result();
}

public function getListesRDVsByUsers($patientsResId)
{     
      $query = $this->db->select('*')
                        ->from($this->table_reservations)
                        ->join('patients', 'patients.id_patients = reservations.patientsResId', 'left')
                        ->join('entreprise', 'entreprise.id_entreprise = reservations.entResId', 'left')
                        ->where('reservations.etat_res', 'A')
                        ->where('reservations.serviceResID', 1)
                        ->where('reservations.parentResFK', NULL)
                        ->where('patients.isSousResponsabilite', $patientsResId)
                        ->order_by("reservations.id_res","desc")
                        ->get();
           return $query->result();
}

public function annulerReservations($id_res)
{  
   
   $req = $this->db->set('status_res', 'A')
                   ->set('date_maj_res', date("Y-m-d H:i:s"))
                   ->where('id_res', $id_res)
                   ->update($this->table_reservations);

   if ($req) 
   {
       return $this->db->set('etatVaccinations', 'I')
                       ->set('dateMajVaccinations', date("Y-m-d H:i:s"))
                       ->where('reservationsFk', $id_res)
                       ->update($this->table_vaccinations);
   }
   else
   {
        return FALSE;
   }

}

public function createVaccinations($entreprisesID, $reservationsFk, $vaccinsFk, 
$patientsFk, $parentResID, $typeResVaccins)
{           
             $this->db->set('entreprisesID', $entreprisesID)
                      ->set('reservationsFk', $reservationsFk)
                      ->set('vaccinsFk', $vaccinsFk)
                      ->set('typeResVaccins', $typeResVaccins)
                      ->set('parentResID', $parentResID)
                      ->set('patientsFk', $patientsFk)
                      ->set('etatVaccinations', 'A')
                      ->set('dateCreateVaccinations', date("Y-m-d H:i:s"))
                      ->insert($this->table_vaccinations);
      return $this->db->insert_id();
}

public function createResVaccins($code_res, $entResId, $patientsResId, $montant_res, $date_res_deb, 
$date_res_end, $plageHoraireID, $sousVaccinsResID, $catVaccinsResID, $qteProduits, 
$parentResFK, $typeResCode, $modePaieID)
{    
     $req1 = $this->db->set('entResId', $entResId)
                      ->set('parentResFK', $parentResFK)
                      ->set('code_res', $code_res)
                      ->set('typeResCode', $typeResCode)
                      ->set('montant_res', (float)$montant_res)
                      ->set('date_res_end', date("Y-m-d H:i:s", strtotime($date_res_end)))
                      ->set('date_res_deb', date("Y-m-d H:i:s", strtotime($date_res_deb)))
                      ->set('patientsResId', $patientsResId)
                      ->set('plageHoraireID', $plageHoraireID)
                      ->set('sousVaccinsResID', $sousVaccinsResID)
                      ->set('qteProduits', $qteProduits)
                      ->set('catVaccinsResID', $catVaccinsResID)
                      ->set('status_res', 'P')
                      ->set('etat_res', 'A')
                      ->set('devicesID', 1)
                      ->set('modePaieID', $modePaieID)
                      ->set('serviceResID', 1)
                      ->set('date_create_res', date("Y-m-d H:i:s"))
                  ->insert($this->table_reservations);

    if ($req1 && (int)$modePaieID == 1) 
    {
              $this->db->set('operateur_trans', 'Caisse')
                       ->set('lotsResTrans', null)
                       ->set('mobile_paiement', null)
                       ->set('reference_syca', null)
                       ->set('modePayerId', $modePaieID)
                       ->set('montant_trans', (float)$montant_res)
                       ->set('frais_trans', 0)
                       ->set('date_maj_trans', date("Y-m-d H:i:s"))
                       ->set('resID', $resID)
                       ->set('entID', $entID)
                       ->set('patientsFK', $patientsResId)
                       ->set('usersEntrepriseFK', null)
                       ->set('etat_trans', 'A')
                       ->set('reversCode', 'N')
                       ->set('servicesTransID', 1)
                       ->set('status_trans', 'P')
                       ->set('date_create_trans', date("Y-m-d H:i:s"))
                       ->insert($this->table_transactions);
       return $this->db->insert_id();
    } 
    elseif ($req1 && (int)$modePaieID == 2) 
    {
                $this->db->set('operateur_trans', null)
                         ->set('lotsResTrans', null)
                         ->set('mobile_paiement', null)
                         ->set('reference_syca', null)
                         ->set('modePayerId', $modePaieID)
                         ->set('montant_trans', (float)$montant_res)
                         ->set('frais_trans', (float)$montant_res*0.03)
                         ->set('resID', $resID)
                         ->set('entID', $entID)
                         ->set('patientsFK', $patientsResId)
                         ->set('usersEntrepriseFK', null)
                         ->set('etat_trans', 'A')
                         ->set('reversCode', 'N')
                         ->set('servicesTransID', 1)
                         ->set('status_trans', 'P')
                         ->set('date_create_trans', date("Y-m-d H:i:s"))
                         ->insert($this->table_transactions);
         return $this->db->insert_id();
    } 
    else
    { 
        return FALSE;
    } 
             
}

public function isSavoirSiDejaRdvsVaccins($patientsResId, $entResId, $date_res_deb)
{   
   return $this->db->select('*')
                     ->from($this->table_reservations)
                     ->where('reservations.patientsResId', $patientsResId)
                     ->where('reservations.entResId', $entResId)
                     ->where('DATE(reservations.date_res_deb)', date("Y-m-d", strtotime($date_res_deb)))
                     ->where('reservations.serviceResID', 1)
                     ->where('reservations.parentResFK', NULL)
                     ->where('reservations.etat_res', 'A')
                     ->get()
                     ->row();
}

public function getRangRdvsVaccins($entResId, $date_res_deb)
{   
   return $this->db->select('count(*) as nombre')
                     ->from($this->table_reservations)
                     ->where('reservations.entResId', $entResId)
                     ->where('DATE(reservations.date_res_deb)', date("Y-m-d", strtotime($date_res_deb)))
                     ->where('reservations.serviceResID', 1)
                     ->where('reservations.parentResFK', NULL)
                     ->where('reservations.etat_res', 'A')
                     ->get()
                     ->row();
}


public function isCodeRes($code_res)
{   
   return $this->db->select('*')
                     ->from($this->table_reservations)
                     ->where('reservations.code_res', $code_res)
                     ->get()
                     ->row();
}

public function isAfficherResByCodes($code_res)
{   
   return $this->db->select('*')
                     ->from($this->table_reservations)
                     ->join('patients', 'patients.id_patients = reservations.patientsResId', 'left')
                     ->join('entreprise', 'entreprise.id_entreprise = reservations.entResId', 'left')
                     ->join('cat_vaccins', 'cat_vaccins.id_cat_vaccins = reservations.catVaccinsResID', 'left')
                     ->join('sous_vaccins', 'sous_vaccins.id_sous_vaccins = reservations.sousVaccinsResID', 'left')
                     ->where('reservations.code_res', $code_res)
                     ->where('reservations.etat_res', 'A')
                     ->get()
                     ->row();
}





}