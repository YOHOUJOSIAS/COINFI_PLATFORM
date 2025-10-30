<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blockchain extends CI_Controller {
    
    public function invoices() {
        header('Content-Type: application/json');
        
        try {
            // Ici, vous intégrerez la logique pour appeler getAllInvoices()
            // Soit via Node.js, soit directement en PHP avec web3.php
            
            $invoices = $this->call_blockchain_service();
            
            echo json_encode([
                'success' => true,
                'data' => $invoices,
                'count' => count($invoices)
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    private function call_blockchain_service() {
        // Implémentez la connexion à votre service blockchain ici
        // Cela peut être un appel à un service Node.js ou l'utilisation de web3.php
        return [];
    }
}