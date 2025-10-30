<?php
   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
	class Pharmacies_model extends CI_Model {

    protected $table_entreprise = "entreprise";
    protected $table_pharmaciesGarde = "pharmaciesGarde";
    protected $table_periodeGarde = "periodeGarde";

    protected $table_accepte_assur = "accepte_assur";
    protected $table_assurances = "assurances";

    public function __construct()
    {
        parent::__construct();
    	date_default_timezone_set('UTC');
    }

    public function getListeAssurByOfficines($entrepriseAssurID)
    {
       $query = $this->db->select('*')
                         ->from($this->table_accepte_assur)
                         ->join('assurances', 'assurances.id_assurances = accepte_assur.assuranceOfficineID', 'left')
                         ->where('accepte_assur.entrepriseAssurID', $entrepriseAssurID)
                         ->where('accepte_assur.etat_accepte_assur !=', 'S')
                         ->order_by("assurances.libelle_assurances  ","asc")
                         ->get();
        return $query->result();
    }

    public function isIdClients($id_entreprise)
    { 
         return $this->db->select('*')
                        ->from($this->table_entreprise)
                        ->where('id_entreprise', $id_entreprise)
                        ->get()
                        ->row();    
    }
	
    public function getPharmaciesByCommunesId($communeEntrepriseId)
    {	
        $query = $this->db->select('*')
		 				   ->from($this->table_pharmaciesGarde)
                           ->join('entreprise', 'entreprise.id_entreprise = pharmaciesGarde.pharmaciesID', 'left')
                           ->join('periodeGarde', 'periodeGarde.idPeriodeGarde = pharmaciesGarde.periodeGardeID', 'left')
                           ->join('communes', 'communes.id_commune = entreprise.communeEntrepriseId', 'left')
		 				   ->where('pharmaciesGarde.etatPharmaciesGarde', 'A');

                        if($communeEntrepriseId != null)
                        {
                           $this->db->where('entreprise.communeEntrepriseId', $communeEntrepriseId);
                        }

        $query = $this->db->order_by("entreprise.nom_entreprise","asc")
                          ->get();
            return $query->result();			 
    }

    public function isPeriodesGarde()
    {       
         return $this->db->select('*')
                         ->from($this->table_periodeGarde)
                         ->where('etatPeriodePeriode', 'A')
                         ->get()
                         ->row();
    }



}