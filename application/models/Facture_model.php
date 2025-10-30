<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facture_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_factures_from_blockchain() {
        try {
            // URL de votre service Node.js
            $api_url = 'http://localhost:3001/api/invoices';
            
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FAILONERROR => true
            ]);
            
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            if ($http_code === 200) {
                $result = json_decode($response, true);
                
                if ($result['success'] && isset($result['data'])) {
                    return $this->format_factures($result['data']);
                }
            }
            
            log_message('error', "Erreur API blockchain: HTTP $http_code - $error");
            return [];
            
        } catch (Exception $e) {
            log_message('error', 'Exception blockchain: ' . $e->getMessage());
            return [];
        }
    }
    
    private function format_factures($invoices) {
        $factures_formatees = [];
        
        foreach ($invoices as $invoice) {
            $details = $invoice['details'] ?? [];
            $metadata = $invoice['metadata'] ?? [];
            
            // Conversion BigInt en string pour éviter les overflow
            $invoiceId = isset($details['invoiceId']) ? $details['invoiceId']->toString() : 'N/A';
            $amount = isset($details['amount']) ? $this->format_ether($details['amount']) : 0;
            
            $factures_formatees[] = [
                'id' => $invoiceId,
                'non_entreprise' => $metadata['entreprise'] ?? $details['entreprise'] ?? 'Non spécifié',
                'non_client' => $metadata['client'] ?? $details['client'] ?? 'Non spécifié',
                'montant' => $amount,
                'etat_facture' => $this->get_etat_facture($details['status'] ?? 0),
                'desc_facture' => $metadata['description'] ?? $details['description'] ?? '',
                'date' => $details['invoiceDate'] ?? $metadata['date'] ?? date('Y-m-d'),
                'secteur' => $metadata['secteur'] ?? 'Non spécifié',
                'pays' => $metadata['pays'] ?? 'Non spécifié',
                'type_facture' => $metadata['type'] ?? 'Standard',
                'metadata' => $metadata,
                'raw_data' => $invoice // Données brutes pour debug
            ];
        }
        
        return $factures_formatees;
    }
    
    private function format_ether($wei) {
        // Conversion Wei → Ether
        return floatval(ethers.formatEther($wei));
    }
    
    private function get_etat_facture($statut) {
        $etats = [
            0 => 'en attente',
            1 => 'active',
            2 => 'payée',
            3 => 'annulée',
            4 => 'en litige'
        ];
        
        return $etats[$statut] ?? 'inconnu';
    }
}