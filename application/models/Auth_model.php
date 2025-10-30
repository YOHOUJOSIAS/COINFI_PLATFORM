<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth_model extends CI_Model {

protected $table_patients = "patients";
protected $table_pme = "pme";

protected $table_newsletters = "newsletters";
protected $table_entreprise = "entreprise";
protected $table_dossiers_patients = "dossiers_patients";
protected $table_patient_canal = "patient_canal";

public function __construct()
{
    parent::__construct();
	date_default_timezone_set('UTC');
}


public function createCanalPatients($patientFk, $canalFk)
{
  return $this->db->set('canalFk', $canalFk)
                  ->set('patientFk', $patientFk)
                  ->set('etat_patient_canal', 'A')
                  ->set('date_patient_canal', date("Y-m-d H:i:s"))
                  ->insert($this->table_patient_canal);
}

public function loginAuth($login, $password)
{	
    $query = $this->db->select('*')
	 				 ->from($this->table_pme)
	 		         ->where('pme.etat_pme', 'A')
	 				 ->where('pme.email_pme', $login)
					 ->get()
	                 ->row();

	if($query && password_verify($password, $query->pass_pme))
	{
        return $query;
    }
    else
    {
        return NULL;
	}
}

public function getPmeById($id_pme)
{		
	 $query = $this->db->select('*')
	 				 ->from($this->table_pme)
	 				 ->where('pme.etat_pme', 'A')
	 				 ->where('pme.idPme', $id_pme)
					 ->get();
        return $query->result();
}

public function getPmeByIdSingle($id_pme)
{		
	return $this->db->select('*')
	 				->from($this->table_pme)
	 				->where('pme.etat_pme', 'A')
	 				->where('pme.idPme', $id_pme)
					->get()
                    ->row();
}

public function updatePme($id_pme, $nom_pme, $description, $email_pme, $numero_telephone)
{		
   return $this->db->set('nom_pme', $nom_pme)
				   ->set('description', $description)
				   ->set('email_pme', $email_pme)
				   ->set('numero_telephone', $numero_telephone)
				   ->set('date_maj_pme', date("Y-m-d H:i:s"))
			       ->where('idPme', $id_pme)
				   ->update($this->table_pme);
}

public function changer_mot_passe_pme($id_pme, $password)
{		
    $pass_pme = password_hash($password, PASSWORD_DEFAULT);
    return $this->db->set('pass_pme', $pass_pme)
    				->set('date_maj_pme', date("Y-m-d H:i:s"))
				    ->where('idPme', $id_pme)
					->update($this->table_pme);
}

public function createPme($nom_pme, $description, $email_pme, $numero_telephone, $pass_pme)
{
	$pass_pme = password_hash($pass_pme, PASSWORD_DEFAULT);
    $this->db->set('nom_pme', $nom_pme)
        ->set('description', $description)
        ->set('email_pme', $email_pme)
		->set('numero_telephone', $numero_telephone)
		->set('pass_pme', $pass_pme)
        ->set('date_create_pme', date("Y-m-d H:i:s"))
        ->insert($this->table_pme); // Remplace 'pme' par le nom réel de ta table PME si besoin
    return $this->db->insert_id();
}

public function existePme($numero_telephone)
{
     return $this->db->select('*')
	 				 ->from($this->table_pme)
	 				 ->where('numero_telephone', $numero_telephone)
					 ->get()
	                 ->row();
}

public function existeEntreprise($nom_entreprise, $email_entreprise, $contact_entreprise)
{
     return $this->db->select('*')
	 				 ->from($this->table_entreprise)
	 				 ->where('nom_entreprise', $nom_entreprise)
	 				 ->or_where('email_entreprise', $email_entreprise)
	 				 ->or_where('contact_entreprise', $contact_entreprise)
					 ->get()
	                 ->row();
}


public function createursEntreprises($nom_entreprise, $email_entreprise, 
$contact_entreprise, $villeEntrepriseId, $situationGeoEntreprise, $typeEntrepriseID, $communeEntrepriseId)
{

	         $this->db->set('nom_entreprise', $nom_entreprise)
	  				  ->set('contact_entreprise', $contact_entreprise)
	  				  ->set('email_entreprise', $email_entreprise)
	  				  ->set('villeEntrepriseId', $villeEntrepriseId)
	  				  ->set('situationGeoEntreprise', $situationGeoEntreprise)
	  				  ->set('typeEntrepriseID', $typeEntrepriseID)
	  				  ->set('communeEntrepriseId', $communeEntrepriseId)
	  				  ->set('etat_entreprise', 'I')
	                  ->set('date_create_entreprise', date("Y-m-d H:i:s"))
	                  ->insert($this->table_entreprise);
	 return $this->db->insert_id();
}


public function existeVisiteurs($numero_telephone)
{
     return $this->db->select('*')
	 				 ->from($this->table_pme)
	 				 ->where('numero_telephone', $numero_telephone)
					 ->get()
	                 ->row();
}

public function existeNewsletter($email_newsletters)
{
     return $this->db->select('*')
	 				 ->from($this->table_newsletters)
	 				 ->where('email_newsletters', $email_newsletters)
					 ->get()
	                 ->row();
}

public function createNewsletter($email_newsletters, $code_promotions)
{
  return $this->db->set('code_promotions', $code_promotions)
  				  ->set('email_newsletters', $email_newsletters)
  				  ->set('etat_newsletters', 'A')
                  ->set('date_create_newsletters', date("Y-m-d H:i:s"))
                  ->insert($this->table_newsletters);
}




   
}
?>