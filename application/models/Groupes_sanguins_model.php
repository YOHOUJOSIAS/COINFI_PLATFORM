<?php
   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
	class Groupes_sanguins_model extends CI_Model {

    protected $table_groupes_sanguins = "groupes_sanguins";

    public function __construct()
    {
        parent::__construct();
    	date_default_timezone_set('UTC');
    }
	
    public function getGroupesSanguinsActifs()
    {	
        $query = $this->db->select('*')
		 				   ->from($this->table_groupes_sanguins)
		 				   ->where('etat_groupes_sanguins', 'A')
		 				   ->order_by("id_groupes_sanguins","asc")
						   ->get();
		     return $query->result();
    }

}