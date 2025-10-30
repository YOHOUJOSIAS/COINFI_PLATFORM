<?php
   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
	class Types_institutions_model extends CI_Model {

    protected $table_type_entreprise = "type_entreprise";

    public function __construct()
    {
        parent::__construct();
    	date_default_timezone_set('UTC');
    }
	
    public function getTypeInstitutionsActifs()
    {	
        $query = $this->db->select('*')
		 				   ->from($this->table_type_entreprise)
		 				   ->where('etat_type_entreprise', 'A')
		 				   ->order_by("libelle_type_entreprise","asc")
						   ->get();
		     return $query->result();
    }

}