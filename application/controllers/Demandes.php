<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demandes extends CI_Controller {

    public function __construct()
    {
        //  Chargement des ressources pour tout le contrôleur
       parent::__construct();
        $this->load->helper(array('url', 'assets'));
        $this->load->model('Global_model', 'globalModel');
        $this->load->model('Facture_model', 'facModel');
        date_default_timezone_set('UTC');
    }

    public function index()
    {   
        //on vérifie si une session existe 
        $email_users = $this->session->userdata('email_users');
        if ($email_users == NULL)
        {
            redirect(site_url('Accueil'));
        }
        else
        {   
            $nom_users = $this->session->userdata('nom_users');
            $libelle = "Factures";
            $description = "L'utilisateur $nom_users consulte";
            $this->globalModel->traceurs($libelle, $description, NULL);

            $query = $this->facModel->getFacturesListe();

            if (empty($query)) {
            $query = 'query';
            }

           // $getFacturesActifs = $this->entModel->getClientIsAgree();

            $data = array('affiche' => $query,
              //  'getFacturesActifs' => $getFacturesActifs,
                'page_title' => "Coinfinance || Plateforme administration !",
            );
            $this->load->view('managers/facture', $data); 
        }
    }

    public function ajax_list()
    {        
        $search = $this->session->userdata('search');
        if (isset($search))
        {


            $list = $this->facModel->get_datatables();

            $data = array();
            $no = $_POST['start'];
            foreach ($list as $historiques) {
                $no++;
                $row = array();
                $row[] = $historiques->nom_projet;
                $row[] = $historiques->desc_facture;
                $row[] = $historiques->nom_entreprise;
                $row[] = $historiques->nom_client;
                $row[] = $historiques->nom_pme;
                $row[] = $historiques->Pays;
                $row[] = $historiques->montant . ' USDT';
                $row[] = $historiques->date_financement;
                $row[] = $historiques->duree . ' Jour(s)';
                $row[] = $historiques->adresse_entreprise;
                $row[] = $historiques->adresse_client;
                
                $row[] = date("d-m-Y H:i:s", strtotime($historiques->date_create_facture));

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->facModel->count_all(),
                "recordsFiltered" => $this->facModel->count_filtered(),
                "data" => $data,
            );

          //output to json format
            echo json_encode($output);

        }
        else
        {   

            $list = $this->facModel->get_datatables();

            $data = array();
            $no = $_POST['start'];
            foreach ($list as $historiques) {
                $no++;
                $row = array();
                $row[] = $historiques->nom_projet;
                $row[] = $historiques->desc_facture;
                $row[] = $historiques->nom_entreprise;
                $row[] = $historiques->nom_client;
                $row[] = $historiques->nom_pme;
                $row[] = $historiques->Pays;
                $row[] = $historiques->montant . ' USDT';
                $row[] = $historiques->date_financement;
                 $row[] = $historiques->duree . ' Jour(s)';;
                $row[] = $historiques->adresse_entreprise;
                $row[] = $historiques->adresse_client;
                
                $row[] = date("d-m-Y H:i:s", strtotime($historiques->date_create_facture));
                $data[] = $row; 
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->facModel->count_all(),
                "recordsFiltered" => $this->facModel->count_filtered(),
                "data" => $data,
            );

              //output to json format
            echo json_encode($output);

        }
    }



}
