<?php
   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
	class Metiers_model extends CI_Model {

    protected $table_metiers = "metiers";

    public function __construct()
    {
        parent::__construct();
    	date_default_timezone_set('UTC');
    }
	
    public function getMetiersActifs()
    {	
        $query = $this->db->select('*')
		 				   ->from($this->table_metiers)
		 				   ->where('etat_metiers', 'A')
		 				   ->order_by("libelle_metiers","asc")
						   ->get();
		     return $query->result();
    }

}