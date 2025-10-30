/**
 * IPFS Utilities for CoinFinance Platform
 * Gestion de l'upload et récupération des métadonnées via Pinata
 */

const PINATA_API_URL = 'https://api.pinata.cloud';
const PINATA_GATEWAY = 'https://gateway.pinata.cloud/ipfs/';

/**
 * Upload des métadonnées d'une facture vers IPFS via Pinata
 */
async function uploadInvoiceMetadata(invoiceData) {
    console.log('📤 Uploading invoice metadata to IPFS...');
    
    try {
        // Prepare metadata structure
        const metadata = {
            name: `Invoice #${invoiceData.invoiceNumber || 'Unknown'}`,
            description: invoiceData.description || 'Invoice tokenized on CoinFinance',
            companyName: invoiceData.companyName,
            clientName: invoiceData.clientName,
            sector: invoiceData.sector,
            location: invoiceData.location,
            invoiceType: invoiceData.invoiceType,
            documentURI: invoiceData.documentURI,
            amount: invoiceData.amount,
            // dueDate: invoiceData.dueDate,
            createdAt: new Date().toISOString(),
            version: '1.0'
        };
        
        const response = await fetch(`${PINATA_API_URL}/pinning/pinJSONToIPFS`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'pinata_api_key': window.COINFINANCE_CONFIG.pinataApiKey,
                'pinata_secret_api_key': window.COINFINANCE_CONFIG.pinataSecretKey
            },
            body: JSON.stringify({
                pinataContent: metadata,
                pinataMetadata: {
                    name: `Invoice_${invoiceData.companyName}_${Date.now()}`,
                    keyvalues: {
                        type: 'invoice_metadata',
                        company: invoiceData.companyName,
                        sector: invoiceData.sector
                    }
                }
            })
        });
        
        if (!response.ok) {
            throw new Error(`IPFS upload failed: ${response.statusText}`);
        }
        
        const result = await response.json();
        const ipfsHash = result.IpfsHash;
        const metadataURI = `ipfs://${ipfsHash}`;
        
        console.log('✅ Invoice metadata uploaded successfully:');
        console.log(`🔗 IPFS Hash: ${ipfsHash}`);
        console.log(`🌐 URI: ${metadataURI}`);
        console.log('📊 Metadata:', metadata);
        
        // Log for developers with database suggestions
        window.uiUtils.logForDevelopers(
            'Invoice Metadata Upload',
            { ipfsHash, metadataURI, metadata },
            `
CREATE TABLE invoice_metadata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    ipfs_hash VARCHAR(60) NOT NULL,
    metadata_uri VARCHAR(100) NOT NULL,
    company_name VARCHAR(255),
    client_name VARCHAR(255),
    sector VARCHAR(100),
    location VARCHAR(100),
    invoice_type VARCHAR(50),
    tags JSON,
    document_uri TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id)
);
            `
        );
        
        return metadataURI;
        
    } catch (error) {
        console.error('❌ Failed to upload invoice metadata:', error);
        window.uiUtils.showErrorAlert('Failed to upload metadata to IPFS: ' + error.message);
        throw error;
    }
}

/**
 * Upload des métadonnées d'un pool vers IPFS via Pinata
 */
async function uploadPoolMetadata(poolData) {
    console.log('📤 Uploading pool metadata to IPFS...');
    
    try {
        // Prepare metadata structure
        const metadata = {
            description: poolData.description,
            theme: poolData.theme,
            riskLevel: poolData.riskLevel || 'medium',
            region: poolData.region,
            bannerURI: poolData.bannerURI,
            creationDate: new Date().toISOString(),
            version: '1.0'
            
        };
        
        const response = await fetch(`${PINATA_API_URL}/pinning/pinJSONToIPFS`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'pinata_api_key': window.COINFINANCE_CONFIG.pinataApiKey,
                'pinata_secret_api_key': window.COINFINANCE_CONFIG.pinataSecretKey
            },
            body: JSON.stringify({
                pinataContent: metadata,
                pinataMetadata: {
                    name: `Pool_${poolData.name}_${Date.now()}`,
                    keyvalues: {
                        type: 'pool_metadata',
                        theme: poolData.theme,
                        risk_level: poolData.riskLevel
                    }
                }
            })
        });
        
        if (!response.ok) {
            throw new Error(`IPFS upload failed: ${response.statusText}`);
        }
        
        const result = await response.json();
        const ipfsHash = result.IpfsHash;
        const metadataURI = `ipfs://${ipfsHash}`;
        
        console.log('✅ Pool metadata uploaded successfully:');
        console.log(`🔗 IPFS Hash: ${ipfsHash}`);
        console.log(`🌐 URI: ${metadataURI}`);
        console.log('📊 Metadata:', metadata);
        
        // Log for developers with database suggestions
        window.uiUtils.logForDevelopers(
            'Pool Metadata Upload',
            { ipfsHash, metadataURI, metadata },
            `
CREATE TABLE pool_metadata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pool_id INT NOT NULL,
    ipfs_hash VARCHAR(60) NOT NULL,
    metadata_uri VARCHAR(100) NOT NULL,
    pool_name VARCHAR(255),
    theme VARCHAR(100),
    risk_level ENUM('low', 'medium', 'high'),
    region VARCHAR(100),
    banner_uri TEXT,
    tags JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pool_id) REFERENCES pools(id)
);
            `
        );
        
        return metadataURI;
        
    } catch (error) {
        console.error('❌ Failed to upload pool metadata:', error);
        window.uiUtils.showErrorAlert('Failed to upload metadata to IPFS: ' + error.message);
        throw error;
    }
}

/**
 * Upload d'un fichier vers IPFS via Pinata
 */
async function uploadFileToIPFS(file, metadata = {}) {
    console.log('📁 Uploading file to IPFS...');
    
    try {
        const formData = new FormData();
        formData.append('file', file);
        
        // Add metadata
        formData.append('pinataMetadata', JSON.stringify({
            name: metadata.name || file.name,
            keyvalues: {
                type: metadata.type || 'document',
                uploaded_by: metadata.uploadedBy || 'coinfinance_user',
                ...metadata.keyvalues
            }
        }));
        
        const response = await fetch(`${PINATA_API_URL}/pinning/pinFileToIPFS`, {
            method: 'POST',
            headers: {
                'pinata_api_key': window.COINFINANCE_CONFIG.pinataApiKey,
                'pinata_secret_api_key': window.COINFINANCE_CONFIG.pinataSecretKey
            },
            body: formData
        });
        
        if (!response.ok) {
            throw new Error(`File upload failed: ${response.statusText}`);
        }
        
        const result = await response.json();
        const ipfsHash = result.IpfsHash;
        const fileURI = `ipfs://${ipfsHash}`;
        
        console.log('✅ File uploaded successfully:');
        console.log(`🔗 IPFS Hash: ${ipfsHash}`);
        console.log(`🌐 URI: ${fileURI}`);
        console.log(`📁 File: ${file.name} (${file.size} bytes)`);
        
        // Log for developers with database suggestions
        window.uiUtils.logForDevelopers(
            'File Upload',
            { ipfsHash, fileURI, fileName: file.name, fileSize: file.size },
            `
CREATE TABLE ipfs_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ipfs_hash VARCHAR(60) NOT NULL,
    file_uri VARCHAR(100) NOT NULL,
    original_name VARCHAR(255),
    file_size BIGINT,
    mime_type VARCHAR(100),
    uploaded_by VARCHAR(42),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return fileURI;
        
    } catch (error) {
        console.error('❌ Failed to upload file:', error);
        window.uiUtils.showErrorAlert('Failed to upload file to IPFS: ' + error.message);
        throw error;
    }
}

/**
 * Récupère les métadonnées depuis IPFS
 */
async function fetchMetadataFromIPFS(metadataURI) {
    console.log(`📥 Fetching metadata from IPFS: ${metadataURI}`);
    
    // Expanded list of gateways with priorities
    const GATEWAYS = [
        'https://gateway.pinata.cloud/ipfs/',
        'https://ipfs.io/ipfs/',
        'https://dweb.link/ipfs/',
        'https://cf-ipfs.com/ipfs/',
        'https://gateway.ipfs.io/ipfs/',
        'https://ipfs.infura.io/ipfs/',
        'https://nftstorage.link/ipfs/',
        'https://cloudflare-ipfs.com/ipfs/'
    ];
    
    try {
        // If it's not an IPFS URI, return directly
        if (!metadataURI.startsWith('ipfs://')) {
            const response = await fetch(metadataURI);
            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
            return await response.json();
        }
        
        const hash = metadataURI.replace('ipfs://', '');
        let lastError = null;
        
        // Try each gateway with exponential backoff
        for (let i = 0; i < GATEWAYS.length; i++) {
            try {
                const url = GATEWAYS[i] + hash;
                console.log(`🔍 Trying gateway: ${url}`);
                
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                
                if (!response.ok) {
                    throw new Error(`Gateway responded with ${response.status}`);
                }
                
                const metadata = await response.json();
                console.log('✅ Metadata fetched successfully from', GATEWAYS[i]);
                return metadata;
                
            } catch (err) {
                console.warn(`⚠️ Failed with gateway ${GATEWAYS[i]}:`, err);
                lastError = err;
                
                // Implement exponential backoff (wait 2^i * 100 ms)
                const delay = Math.pow(2, i) * 100;
                await new Promise(resolve => setTimeout(resolve, delay));
                continue;
            }
        }
        
        throw lastError || new Error('All IPFS gateways failed');
        
    } catch (error) {
        console.error('❌ Failed to fetch metadata:', error);
        throw error;
    }
}

/**
 * Obtient l'URL de la gateway pour un hash IPFS
 */
function getIPFSGatewayURL(ipfsHash) {
    if (ipfsHash.startsWith('ipfs://')) {
        return ipfsHash.replace('ipfs://', PINATA_GATEWAY);
    }
    return `${PINATA_GATEWAY}${ipfsHash}`;
}

/**
 * Liste les fichiers épinglés sur Pinata (pour admin)
 */
async function listPinnedFiles(options = {}) {
    console.log('📋 Listing pinned files...');
    
    try {
        const params = new URLSearchParams({
            status: 'pinned',
            pageLimit: options.limit || 10,
            pageOffset: options.offset || 0,
            ...options.filters
        });
        
        const response = await fetch(`${PINATA_API_URL}/data/pinList?${params}`, {
            headers: {
                'pinata_api_key': window.COINFINANCE_CONFIG.pinataApiKey,
                'pinata_secret_api_key': window.COINFINANCE_CONFIG.pinataSecretKey
            }
        });
        
        if (!response.ok) {
            throw new Error(`Failed to list files: ${response.statusText}`);
        }
        
        const result = await response.json();
        
        console.log('✅ Files listed successfully:');
        console.log(`📊 Total: ${result.count} files`);
        console.log('📁 Files:', result.rows);
        
        return result;
        
    } catch (error) {
        console.error('❌ Failed to list files:', error);
        throw error;
    }
}

/**
 * Supprime un fichier épinglé (unpin)
 */
async function unpinFile(ipfsHash) {
    console.log(`🗑️ Unpinning file: ${ipfsHash}`);
    
    try {
        const response = await fetch(`${PINATA_API_URL}/pinning/unpin/${ipfsHash}`, {
            method: 'DELETE',
            headers: {
                'pinata_api_key': window.COINFINANCE_CONFIG.pinataApiKey,
                'pinata_secret_api_key': window.COINFINANCE_CONFIG.pinataSecretKey
            }
        });
        
        if (!response.ok) {
            throw new Error(`Failed to unpin file: ${response.statusText}`);
        }
        
        console.log('✅ File unpinned successfully');
        return true;
        
    } catch (error) {
        console.error('❌ Failed to unpin file:', error);
        throw error;
    }
}

/**
 * Valide un fichier avant upload
 */
function validateFile(file, maxSize = 10 * 1024 * 1024, allowedTypes = []) {
    console.log(`🔍 Validating file: ${file.name}`);
    
    // Check file size (default 10MB)
    if (file.size > maxSize) {
        throw new Error(`File too large. Maximum size: ${maxSize / (1024 * 1024)}MB`);
    }
    
    // Check file type if specified
    if (allowedTypes.length > 0) {
        const fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedTypes.includes(fileExtension)) {
            throw new Error(`File type not allowed. Allowed types: ${allowedTypes.join(', ')}`);
        }
    }
    
    console.log('✅ File validation passed');
    return true;
}

/**
 * Prévisualise un fichier image
 */
function previewImageFile(file, previewElementId) {
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewElement = document.getElementById(previewElementId);
            if (previewElement) {
                previewElement.src = e.target.result;
                previewElement.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    }
}

/**
 * Crée un template de métadonnées pour une facture
 */
function createInvoiceMetadataTemplate(basicData) {
    return {
        companyName: basicData.companyName || '',
        clientName: basicData.clientName || '',
        sector: basicData.sector || '',
        description: basicData.description || '',
        documentURI: basicData.documentURI || '',
        location: basicData.location || '',
        invoiceType: basicData.invoiceType || 'standard',
        tags: basicData.tags || []
    };
}

/**
 * Crée un template de métadonnées pour un pool
 */
function createPoolMetadataTemplate(basicData) {
    return {
        description: basicData.description || '',
        theme: basicData.theme || '',
        riskLevel: basicData.riskLevel || 'medium',
        region: basicData.region || '',
        bannerURI: basicData.bannerURI || '',
        tags: basicData.tags || []
    };
}

// Export functions for global use
window.ipfsUtils = {
    uploadInvoiceMetadata,
    uploadPoolMetadata,
    uploadFileToIPFS,
    fetchMetadataFromIPFS,
    getIPFSGatewayURL,
    listPinnedFiles,
    unpinFile,
    validateFile,
    previewImageFile,
    createInvoiceMetadataTemplate,
    createPoolMetadataTemplate
};

console.log('🌐 IPFS utilities loaded successfully');