<?php
   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
	class Entreprises_model extends CI_Model {

    protected $table_entreprise = "entreprise";

    public function __construct()
    {
        parent::__construct();
    	date_default_timezone_set('UTC');
    }
	
    public function getEntrepriseByCommunesId($communeEntrepriseId)
    {	
        $query = $this->db->select('*')
		 				   ->from($this->table_entreprise)
                           ->join('communes', 'communes.id_commune = entreprise.communeEntrepriseId', 'left')
		 				   ->where('entreprise.etat_entreprise', 'A')
                           ->where('entreprise.communeEntrepriseId', $communeEntrepriseId)
                           ->order_by("entreprise.nom_entreprise","asc")
                          ->get();
            return $query->result();			 
    }

   
    public function getEntrepriseByQuartiersId($quartierEntrepriseId)
    {   
        $query = $this->db->select('*')
                           ->from($this->table_entreprise)
                           ->join('quartiers', 'quartiers.id_quartiers = entreprise.quartierEntrepriseId', 'left')
                           ->where('entreprise.etat_entreprise', 'A')
                           ->where('entreprise.quartierEntrepriseId', $quartierEntrepriseId)
                           ->order_by("entreprise.nom_entreprise","asc")
                          ->get();
            return $query->result();             
    }


    public function isEntrepriseByQuartiersId($quartierEntrepriseId, $communeEntrepriseId, 
    $indexJourVaccination)
    {   
        return $this->db->select('*')
                           ->from($this->table_entreprise)
                           ->join('quartiers', 'quartiers.id_quartiers = entreprise.quartierEntrepriseId', 'left')
                           ->join('JourVaccination', 'JourVaccination.centreId = entreprise.id_entreprise', 'left')
                           ->where('entreprise.etat_entreprise', 'A')
                           ->where('entreprise.isAgree', '1')
                           ->where('entreprise.typeEntrepriseID !=', '3')
                           //DECOMMENTER EN PRODUCTION
                           //->where('JourVaccination.indexJourVaccination', $indexJourVaccination)
                           ->where('entreprise.quartierEntrepriseId', $quartierEntrepriseId)
                           ->order_by("entreprise.nom_entreprise","asc")
                           ->limit(1)
                           ->get()
                           ->row();             
    }

}