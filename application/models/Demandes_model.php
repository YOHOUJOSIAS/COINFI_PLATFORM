<?php 
   
   if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demandes_model extends CI_Model {

   protected $table_pme = "pme";
   protected $table_facture = "facture";
  
   

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('UTC');
    }



public function getFacturesActifs()
    { 

        return $this->db->select('count(facture.id) AS nombre')
        ->from($this->table_facture)
        ->where('facture.etat_facture', 'A')               
        ->order_by("nombre","desc")
        ->get()
        ->row();
    }

public function getFacturesActifsByMois()
    { 

        return $this->db->select('count(facture.id) AS nombre')
        ->from($this->table_facture)
        ->where('facture.etat_facture', 'A')
        ->where('facture.date_create_facture >=', date("Y-m-01 00:00:00"))
        ->where('facture.date_create_facture <=',date("Y-m-t 23:59:59"))             
        ->order_by("nombre","desc")
        ->get()
        ->row();
    }

  public function getFacturesListe()
    { 

        $query = $this->db->select('*')
        ->from($this->table_facture)  
        ->join('pme','pme.idPme = facture.PmeFactureID', 'left')            
        ->where('facture.etat_facture','A')
        ->order_by("facture.date_create_facture","desc")
        ->get();
        return $query->result();
    }

var $column_order = array('nom_entreprise','nom_client','nom_pme','type_facture','montant','date_financement','adresse_entreprise','adresse_client'); //set column field database for datatable orderable
var $column_search = array('nom_entreprise','nom_client','nom_pme','type_facture','montant','date_financement','adresse_entreprise','adresse_client');
//set column field database for datatable searchable 
var $order = array('date_create_facture' => 'desc'); // default order 

private function _get_datatables_query()
{

   $this->db->select('*')
    ->from($this->table_facture)  
        ->join('pme','pme.idPme = facture.PmeFactureID', 'left')            
        ->where('facture.etat_facture','A');
                
 //->where('pme.etat_pme','A');
       
   
   $i = 0;

  foreach ($this->column_search as $item) // loop column 
  {
    if($_POST['search']['value']) // if datatable send POST for search
    {
      
      if($i===0) // first loop
      {
        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
        $this->db->like($item, $_POST['search']['value']);
    }
    else
    {
        $this->db->or_like($item, $_POST['search']['value']);
    }

      if(count($this->column_search) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
    }
    $i++;
}

  if(isset($_POST['order'])) // here order processing
  {
    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
} 
else if(isset($this->order))
{
    $order = $this->order;
    $this->db->order_by(key($order), $order[key($order)]);
}
}

function get_datatables()
{
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
}

function count_filtered()
{
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
}

public function count_all()
{
   $this->db->select('*')
   
  ->from($this->table_facture)  
        ->join('pme','pme.idPme = facture.PmeFactureID', 'left')            
        ->where('facture.etat_facture','A');                
                 
 // ->where('pme.etat_pme','A');
   return $this->db->count_all_results();
}


}
 ?>