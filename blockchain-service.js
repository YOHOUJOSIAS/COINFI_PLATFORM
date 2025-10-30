const express = require('express');
const cors = require('cors');
const { ethers } = require('ethers');
const axios = require('axios');

const app = express();
const PORT = 3001;

app.use(cors());
app.use(express.json());

// Configuration du provider blockchain
const provider = new ethers.JsonRpcProvider('https://votre-rpc-blockchain.com');
const contractAddress = 'VOTRE_CONTRACT_ADDRESS';
const contractABI = [...]; // Votre ABI complet

async function getAllInvoices() {
    console.log('📄 Début de la récupération de toutes les factures...');
    
    try {
        const contract = new ethers.Contract(contractAddress, contractABI, provider);
        const rawInvoices = await contract.getAllInvoices();
        
        console.log(`✅ ${rawInvoices.length} factures brutes récupérées. Enrichissement...`);

        const enrichedInvoices = await Promise.all(
            rawInvoices.map(async (invoice) => {
                let metadata = {};
                const uri = invoice.details.metadataURI;

                if (uri && uri.startsWith('ipfs://')) {
                    try {
                        const gateways = [
                            'https://ipfs.io/ipfs/',
                            'https://dweb.link/ipfs/',
                            'https://cf-ipfs.com/ipfs/'
                        ];
                        
                        for (const gateway of gateways) {
                            try {
                                const url = uri.replace('ipfs://', gateway);
                                const response = await axios.get(url, { timeout: 5000 });
                                metadata = response.data;
                                break;
                            } catch (e) {
                                continue;
                            }
                        }
                    } catch (error) {
                        console.error('❌ Erreur métadonnées:', error);
                    }
                }

                return {
                    ...invoice,
                    metadata
                };
            })
        );

        console.log('✅ Toutes les factures enrichies');
        return enrichedInvoices;
        
    } catch (error) {
        console.error('❌ Erreur critique:', error);
        throw error;
    }
}

// Route API pour CodeIgniter
app.get('/api/invoices', async (req, res) => {
    try {
        const invoices = await getAllInvoices();
        res.json({ success: true, data: invoices });
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

app.listen(PORT, () => {
    console.log(`🚀 Blockchain service running on port ${PORT}`);
});