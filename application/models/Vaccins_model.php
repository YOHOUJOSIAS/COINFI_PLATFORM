<?php
   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
	class Vaccins_model extends CI_Model {

    protected $table_vaccins = "vaccins";
    protected $table_vaccinations = "vaccinations";
    protected $table_vaccinBySousVaccins = "vaccinBySousVaccins";

    public function __construct()
    {
        parent::__construct();
    	date_default_timezone_set('UTC');
    }
	
    public function isVaccinsActifs($idVaccins)
    {	
       return $this->db->select('*')
	 				   ->from($this->table_vaccins)
	 				   ->where('etatVaccins', 'A')
                       ->where('idVaccins', $idVaccins)
                       ->get()
                       ->row();
    }

    public function getListeVaccinsBySousVaccins($sousVaccinsFk)
    {       
           $query = $this->db->select('*')
                            ->from($this->table_vaccinBySousVaccins)
                            ->join('vaccins', 'vaccins.idVaccins = vaccinBySousVaccins.vaccinsFk', 'left')
                            ->where('vaccinBySousVaccins.etatVaccinBySousVaccins', 'A')
                            ->where('vaccinBySousVaccins.sousVaccinsFk', $sousVaccinsFk)
                            ->order_by("vaccins.nomVaccins","asc")
                            ->get();
            return $query->result();
    }

    public function getVaccinsActifs()
    {   
        $query = $this->db->select('*')
                           ->from($this->table_vaccins)
                           ->where('etatVaccins', 'A')
                           ->order_by("nomVaccins","asc")
                           ->get();
             return $query->result();
    }

    public function getVaccinsByArrays($tab)
    {   
        $query = $this->db->select('*')
                           ->from($this->table_vaccins)
                           ->where_in('idVaccins', $tab)
                           ->order_by("nomVaccins","asc")
                           ->get();
             return $query->result();
    }

}