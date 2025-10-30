<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factures_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('UTC');
    }

    public function insert_facture($data) {
        return $this->db->insert('facture', $data);
    }

    public function get_all_factures() {
        return $this->db->order_by('date', 'DESC')
                        ->get('facture')
                        ->result_array();
    }

    public function get_factures_paginated($limit, $offset) {
        return $this->db->order_by('date', 'DESC')
                        ->limit($limit, $offset)
                        ->get('facture')
                        ->result_array();
    }

    public function count_all_factures() {
        return $this->db->count_all_results('facture');
    }
}