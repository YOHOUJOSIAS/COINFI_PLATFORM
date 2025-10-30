<?php
   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
	class Dashbord_model extends CI_Model {

    protected $table_pme = "pme";
    protected $table_facture = "factures";
     protected $table_type_facture = "type_facture";


    public function __construct()
    {
        parent::__construct();
    	date_default_timezone_set('UTC');
    }
	
      public function getScorePme()
    {   
       $entID = $this->session->userdata('entID');
       return $this->db->select('pme.score_pme AS nombre')
                        ->from($this->table_pme)
                        ->where('pme.etat_pme','A')
                         ->where('idPme',$entID)
                        ->get()
                        ->row();
    }

      public function getMontantFactureTokeniser()
    {   
      // $entID = $this->session->userdata('entID');
       return $this->db->select('factures.prix_facture AS texte_score')
                        ->from($this->table_facture)
                        ->where('factures.etat_factures','A')
                        ->get()
                        ->row();
    }

     public function getLiquiditeObtenue()
    {   
      // $entID = $this->session->userdata('entID');
       return $this->db->select('factures.liquidite_facture AS texte_score')
                        ->from($this->table_facture)
                        ->where('factures.etat_factures','A')
                        ->get()
                        ->row();
    }

     public function getFacturefActif()
    {   
      // $entID = $this->session->userdata('entID');
      return $this->db->select('count(factures.PmeId) AS nombre')
                        ->from($this->table_facture)
                        ->where('factures.etat_factures','A')
                        ->get()
                        ->row();
    }

    public function getTypeFacturesActifs()
    { 
        $query = $this->db->select('*')
               ->from($this->table_type_facture)
               ->where('etat_type_facture', 'A')
               ->order_by("libelle_facture","asc")
               ->get();
         return $query->result();
    }

}