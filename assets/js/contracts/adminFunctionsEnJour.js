/**
 * Admin Functions for CoinFinance Platform
 * Fonctions réservées aux administrateurs
 */

// Import de l'ABI complète depuis le fichier séparé
import { invoiceTokenABI } from '../abi/invoiceToken_abi.js';

/**
 * Obtient le contrat avec les fonctions admin
 */
function getAdminContract() {
    if (!window.walletUtils.isWalletReady()) {
        throw new Error('Wallet not connected');
    }
    
    return new ethers.Contract(
        window.COINFINANCE_CONFIG.contracts.invoiceToken,
        invoiceTokenABI,
        window.walletUtils.getCurrentSigner()
    );
}

/**
 * Vérifie si l'utilisateur actuel a le rôle admin
 */
async function checkAdminRole() {
    console.log('🔐 Checking admin role...');
    
    try {
        const contract = window.sharedFunctions.getInvoiceTokenContract();
        const userAddress = window.walletUtils.getCurrentWalletAddress();
        const adminRole = await contract.ADMIN_ROLE();
        
        const hasRole = await contract.hasRole(adminRole, userAddress);
        
        console.log(`✅ Admin role check: ${hasRole}`);
        return hasRole;
        
    } catch (error) {
        console.error('❌ Error checking admin role:', error);
        return false;
    }
}

/**
 * Accorde un rôle à un utilisateur
 */
async function grantRole(roleType, userAddress) {
    console.log(`👤 Granting ${roleType} role to: ${userAddress}`);
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const contract = getAdminContract();
        
        // Get role hash
        let roleHash;
        switch(roleType.toLowerCase()) {
            case 'admin':
                roleHash = await contract.ADMIN_ROLE();
                break;
            case 'operator':
                roleHash = await contract.OPERATOR_ROLE();
                break;
            default:
                throw new Error('Invalid role type');
        }
        
        // Confirmation
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Grant ${roleType} role to ${window.walletUtils.formatAddress(userAddress)}?`,
            'Confirm Role Grant',
            'Grant Role',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Role grant cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Granting role...');
        
        const tx = await contract.grantRole(roleHash, userAddress);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Role Grant Submitted');
        
        console.log('🔄 Role grant transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Successfully granted ${roleType} role!`);
        
        console.log('✅ Role grant confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Grant Role',
            { roleType, userAddress, txHash: tx.hash, receipt },
            `
CREATE TABLE role_grants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    grantor_address VARCHAR(42) NOT NULL,
    grantee_address VARCHAR(42) NOT NULL,
    role_type VARCHAR(20) NOT NULL,
    role_hash VARCHAR(66) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Role grant failed:', error);
        window.uiUtils.logTransactionError(error, 'Grant Role');
        window.uiUtils.showRevertAlert(error, 'Role Grant Failed');
        throw error;
    }
}

/**
 * Révoque un rôle d'un utilisateur
 */
async function revokeRole(roleType, userAddress) {
    console.log(`🚫 Revoking ${roleType} role from: ${userAddress}`);
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const contract = getAdminContract();
        
        // Get role hash
        let roleHash;
        switch(roleType.toLowerCase()) {
            case 'admin':
                roleHash = await contract.ADMIN_ROLE();
                break;
            case 'operator':
                roleHash = await contract.OPERATOR_ROLE();
                break;
            default:
                throw new Error('Invalid role type');
        }
        
        // Confirmation
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Revoke ${roleType} role from ${window.walletUtils.formatAddress(userAddress)}?`,
            'Confirm Role Revocation',
            'Revoke Role',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Role revocation cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Revoking role...');
        
        const tx = await contract.revokeRole(roleHash, userAddress);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Role Revocation Submitted');
        
        console.log('🔄 Role revocation transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Successfully revoked ${roleType} role!`);
        
        console.log('✅ Role revocation confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Revoke Role',
            { roleType, userAddress, txHash: tx.hash, receipt }
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Role revocation failed:', error);
        window.uiUtils.logTransactionError(error, 'Revoke Role');
        window.uiUtils.showRevertAlert(error, 'Role Revocation Failed');
        throw error;
    }
}

/**
 * Met le contrat en pause
 */
async function pauseContract() {
    console.log('⏸️ Pausing contract...');
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const confirmed = await window.uiUtils.showConfirmAlert(
            'Pause the contract? This will stop all operations until unpaused.',
            'Confirm Contract Pause',
            'Pause Contract',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Contract pause cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Pausing contract...');
        
        const contract = getAdminContract();
        const tx = await contract.pause();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Pause Submitted');
        
        console.log('🔄 Pause transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Contract paused successfully!');
        
        console.log('✅ Contract pause confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Pause Contract',
            { txHash: tx.hash, receipt }
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Contract pause failed:', error);
        window.uiUtils.logTransactionError(error, 'Pause Contract');
        window.uiUtils.showRevertAlert(error, 'Pause Failed');
        throw error;
    }
}

/**
 * Retire le contrat de la pause
 */
async function unpauseContract() {
    console.log('▶️ Unpausing contract...');
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const confirmed = await window.uiUtils.showConfirmAlert(
            'Unpause the contract? This will resume all operations.',
            'Confirm Contract Unpause',
            'Unpause Contract',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Contract unpause cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Unpausing contract...');
        
        const contract = getAdminContract();
        const tx = await contract.unpause();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Unpause Submitted');
        
        console.log('🔄 Unpause transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Contract unpaused successfully!');
        
        console.log('✅ Contract unpause confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Unpause Contract',
            { txHash: tx.hash, receipt }
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Contract unpause failed:', error);
        window.uiUtils.logTransactionError(error, 'Unpause Contract');
        window.uiUtils.showRevertAlert(error, 'Unpause Failed');
        throw error;
    }
}

/**
 * Crée une nouvelle facture (admin)
 */
async function createInvoice(invoiceData) {
    console.log('📄 Creating new invoice...');
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        // Upload metadata to IPFS first
        window.uiUtils.showLoadingAlert('Uploading metadata to IPFS...');
        const metadataURI = await window.ipfsUtils.uploadInvoiceMetadata(invoiceData);
        
        // Prepare contract parameters
        const amount = ethers.utils.parseEther(invoiceData.amount.toString());
        const fundingDuration = invoiceData.fundingDuration * 24 * 60 * 60; // Convert days to seconds
        const dueDate = Math.floor(new Date(invoiceData.dueDate).getTime() / 1000);
        const interestRate = invoiceData.interestRate * 100; // Convert to basis points
        
        window.uiUtils.showLoadingAlert('Creating invoice on blockchain...');
        
        const contract = getAdminContract();
        const tx = await contract.createInvoice(
            amount,
            fundingDuration,
            dueDate,
            interestRate,
            metadataURI,
            invoiceData.companyAddress,
            invoiceData.clientAddress,
            invoiceData.requireCollateral || false
        );
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Invoice Creation Submitted');
        
        console.log('🔄 Invoice creation transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Invoice created successfully!');
        
        console.log('✅ Invoice creation confirmed:', receipt);
        
        // Extract invoice ID from events
        const invoiceCreatedEvent = receipt.events?.find(e => e.event === 'InvoiceCreated');
        const invoiceId = invoiceCreatedEvent?.args?.invoiceId?.toNumber();
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Create Invoice',
            { invoiceId, invoiceData, metadataURI, txHash: tx.hash, receipt },
            `
CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT UNIQUE NOT NULL,
    company_address VARCHAR(42) NOT NULL,
    client_address VARCHAR(42) NOT NULL,
    amount DECIMAL(20,8) NOT NULL,
    funding_duration INT NOT NULL,
    due_date BIGINT NOT NULL,
    interest_rate INT NOT NULL,
    metadata_uri TEXT,
    require_collateral BOOLEAN DEFAULT FALSE,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return { invoiceId, receipt, metadataURI };
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Invoice creation failed:', error);
        window.uiUtils.logTransactionError(error, 'Create Invoice');
        window.uiUtils.showRevertAlert(error, 'Invoice Creation Failed');
        throw error;
    }
}

/**
 * Crée un nouveau pool (admin)
 */
async function createPool(poolData) {
    console.log('🏊 Creating new pool...');
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        // Upload metadata to IPFS first
        window.uiUtils.showLoadingAlert('Uploading metadata to IPFS...');
        const metadataURI = await window.ipfsUtils.uploadPoolMetadata(poolData);
        
        // Prepare contract parameters
        const minInvestment = ethers.utils.parseEther(poolData.minInvestment.toString());
        const maxPoolAmount = poolData.maxPoolAmount ? ethers.utils.parseEther(poolData.maxPoolAmount.toString()) : 0;
        
        window.uiUtils.showLoadingAlert('Creating pool on blockchain...');
        
        const contract = getAdminContract();
        const tx = await contract.createPool(
            poolData.name,
            minInvestment,
            poolData.maxInvoiceCount || 0,
            maxPoolAmount,
            metadataURI
        );
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Pool Creation Submitted');
        
        console.log('🔄 Pool creation transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Pool created successfully!');
        
        console.log('✅ Pool creation confirmed:', receipt);
        
        // Extract pool ID from events
        const poolCreatedEvent = receipt.events?.find(e => e.event === 'PoolCreated');
        const poolId = poolCreatedEvent?.args?.poolId?.toNumber();
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Create Pool',
            { poolId, poolData, metadataURI, txHash: tx.hash, receipt },
            `
CREATE TABLE pools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pool_id BIGINT UNIQUE NOT NULL,
    pool_name VARCHAR(255) NOT NULL,
    min_investment DECIMAL(20,8) NOT NULL,
    max_invoice_count INT DEFAULT 0,
    max_pool_amount DECIMAL(20,8) DEFAULT 0,
    metadata_uri TEXT,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return { poolId, receipt, metadataURI };
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Pool creation failed:', error);
        window.uiUtils.logTransactionError(error, 'Create Pool');
        window.uiUtils.showRevertAlert(error, 'Pool Creation Failed');
        throw error;
    }
}

/**
 * Ajoute une facture à un pool
 */
async function addInvoiceToPool(invoiceId, poolId) {
    console.log(`📄➡️🏊 Adding invoice ${invoiceId} to pool ${poolId}...`);
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Add invoice #${invoiceId} to pool #${poolId}?`,
            'Confirm Invoice Assignment',
            'Add to Pool',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Invoice assignment cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Adding invoice to pool...');
        
        const contract = getAdminContract();
        const tx = await contract.addInvoiceToPool(invoiceId, poolId);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Invoice Assignment Submitted');
        
        console.log('🔄 Invoice assignment transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Invoice successfully added to pool!');
        
        console.log('✅ Invoice assignment confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Add Invoice to Pool',
            { invoiceId, poolId, txHash: tx.hash, receipt }
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Invoice assignment failed:', error);
        window.uiUtils.logTransactionError(error, 'Add Invoice to Pool');
        window.uiUtils.showRevertAlert(error, 'Assignment Failed');
        throw error;
    }
}

/**
 * Active/désactive un pool
 */
async function setPoolActive(poolId, active) {
    console.log(`🏊 Setting pool ${poolId} active status to: ${active}`);
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const action = active ? 'activate' : 'deactivate';
        const confirmed = await window.uiUtils.showConfirmAlert(
            `${action.charAt(0).toUpperCase() + action.slice(1)} pool #${poolId}?`,
            `Confirm Pool ${action.charAt(0).toUpperCase() + action.slice(1)}`,
            action.charAt(0).toUpperCase() + action.slice(1),
            'Cancel'
        );
        
        if (!confirmed) {
            console.log(`❌ Pool ${action} cancelled by user`);
            return null;
        }
        
        window.uiUtils.showLoadingAlert(`${action.charAt(0).toUpperCase() + action.slice(1)}ing pool...`);
        
        const contract = getAdminContract();
        const tx = await contract.setPoolActive(poolId, active);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', `Pool ${action.charAt(0).toUpperCase() + action.slice(1)} Submitted`);
        
        console.log(`🔄 Pool ${action} transaction submitted:`, tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Pool ${active ? 'activated' : 'deactivated'} successfully!`);
        
        console.log(`✅ Pool ${action} confirmed:`, receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Set Pool Active',
            { poolId, active, txHash: tx.hash, receipt }
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error(`❌ Pool ${active ? 'activation' : 'deactivation'} failed:`, error);
        window.uiUtils.logTransactionError(error, 'Set Pool Active');
        window.uiUtils.showRevertAlert(error, `Pool ${active ? 'Activation' : 'Deactivation'} Failed`);
        throw error;
    }
}

/**
 * Compense les investisseurs (en cas de défaut)
 */
async function compensateInvestors(invoiceId) {
    console.log(`💰 Compensating investors for invoice ${invoiceId}...`);
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Compensate investors for invoice #${invoiceId}?\n\nThis will use collateral to pay investors and cannot be undone.`,
            'Confirm Investor Compensation',
            'Compensate',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Investor compensation cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Processing investor compensation...');
        
        const contract = getAdminContract();
        const tx = await contract.compensateInvestors(invoiceId);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Compensation Submitted');
        
        console.log('🔄 Compensation transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Investors compensated successfully!');
        
        console.log('✅ Compensation confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Compensate Investors',
            { invoiceId, txHash: tx.hash, receipt },
            `
CREATE TABLE investor_compensations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT NOT NULL,
    admin_address VARCHAR(42) NOT NULL,
    compensation_amount DECIMAL(20,8),
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Investor compensation failed:', error);
        window.uiUtils.logTransactionError(error, 'Compensate Investors');
        window.uiUtils.showRevertAlert(error, 'Compensation Failed');
        throw error;
    }
}

/**
 * Met à jour les taux de commission (avec timelock)
 */
async function startUpdateCommissionRates(entryFee, performanceFee, poolFee, issuanceFee) {
    console.log('💰 Starting commission rates update...');
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Start commission rates update?\n\nEntry Fee: ${entryFee/100}%\nPerformance Fee: ${performanceFee/100}%\nPool Fee: ${poolFee/100}%\nIssuance Fee: ${issuanceFee/100}%\n\nChanges will be effective after 48h timelock.`,
            'Confirm Commission Update',
            'Start Update',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Commission update cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Starting commission update...');
        
        const contract = getAdminContract();
        const tx = await contract.startUpdateCommissionRates(entryFee, performanceFee, poolFee, issuanceFee);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Commission Update Started');
        
        console.log('🔄 Commission update start transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Commission rates update started! Changes will be effective after timelock period.');
        
        console.log('✅ Commission update start confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Start Commission Update',
            { entryFee, performanceFee, poolFee, issuanceFee, txHash: tx.hash, receipt }
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Commission update start failed:', error);
        window.uiUtils.logTransactionError(error, 'Start Commission Update');
        window.uiUtils.showRevertAlert(error, 'Commission Update Failed');
        throw error;
    }
}


/**
 * Met à jour les taux de collatéral
 */
async function updateCollateralRates(initialRate, withheldRate) {
    console.log(`📊 Updating collateral rates - Initial: ${initialRate}%, Withheld: ${withheldRate}%`);
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Update collateral rates?\n\nInitial Rate: ${initialRate}%\nWithheld Rate: ${withheldRate}%`,
            'Confirm Collateral Rates Update',
            'Update Rates',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Collateral rates update cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Updating collateral rates...');
        
        const contract = getAdminContract();
        const tx = await contract.updateCollateralRates(initialRate, withheldRate);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Collateral Rates Update Submitted');
        
        console.log('🔄 Collateral rates update transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Collateral rates updated successfully!');
        
        console.log('✅ Collateral rates update confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Update Collateral Rates',
            { initialRate, withheldRate, txHash: tx.hash, receipt },
            `
CREATE TABLE collateral_rate_changes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    initial_rate INT NOT NULL,
    withheld_rate INT NOT NULL,
    admin_address VARCHAR(42) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Collateral rates update failed:', error);
        window.uiUtils.logTransactionError(error, 'Update Collateral Rates');
        window.uiUtils.showRevertAlert(error, 'Collateral Rates Update Failed');
        throw error;
    }
}

/**
 * Met à jour les taux de commission (après timelock)
 */
async function updateCommissionRates(entryFee, performanceFee, poolFee, issuanceFee) {
    console.log('💰 Updating commission rates...');
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Update commission rates?\n\nEntry Fee: ${entryFee/100}%\nPerformance Fee: ${performanceFee/100}%\nPool Fee: ${poolFee/100}%\nIssuance Fee: ${issuanceFee/100}%`,
            'Confirm Commission Rates Update',
            'Update Rates',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Commission rates update cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Updating commission rates...');
        
        const contract = getAdminContract();
        const tx = await contract.updateCommissionRates(entryFee, performanceFee, poolFee, issuanceFee);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Commission Rates Update Submitted');
        
        console.log('🔄 Commission rates update transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Commission rates updated successfully!');
        
        console.log('✅ Commission rates update confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Update Commission Rates',
            { entryFee, performanceFee, poolFee, issuanceFee, txHash: tx.hash, receipt },
            `
CREATE TABLE commission_rate_changes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    entry_fee INT NOT NULL,
    performance_fee INT NOT NULL,
    pool_fee INT NOT NULL,
    issuance_fee INT NOT NULL,
    admin_address VARCHAR(42) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Commission rates update failed:', error);
        window.uiUtils.logTransactionError(error, 'Update Commission Rates');
        window.uiUtils.showRevertAlert(error, 'Commission Rates Update Failed');
        throw error;
    }
}

/**
 * Met à jour l'adresse du stablecoin
 */
async function updateStablecoin(newTokenAddress) {
    console.log(`🔄 Updating stablecoin address to: ${newTokenAddress}`);
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Update stablecoin address to ${window.walletUtils.formatAddress(newTokenAddress)}?`,
            'Confirm Stablecoin Update',
            'Update Stablecoin',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Stablecoin update cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Updating stablecoin address...');
        
        const contract = getAdminContract();
        const tx = await contract.updateStablecoin(newTokenAddress);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Stablecoin Update Submitted');
        
        console.log('🔄 Stablecoin update transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Stablecoin address updated successfully!');
        
        console.log('✅ Stablecoin update confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Update Stablecoin',
            { newTokenAddress, txHash: tx.hash, receipt },
            `
CREATE TABLE stablecoin_updates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    new_token_address VARCHAR(42) NOT NULL,
    admin_address VARCHAR(42) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Stablecoin update failed:', error);
        window.uiUtils.logTransactionError(error, 'Update Stablecoin');
        window.uiUtils.showRevertAlert(error, 'Stablecoin Update Failed');
        throw error;
    }
}

/**
 * Met à jour l'adresse du trésor des frais
 */
async function updateFeeTreasury(newTreasuryAddress) {
    console.log(`💰 Updating fee treasury address to: ${newTreasuryAddress}`);
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Update fee treasury address to ${window.walletUtils.formatAddress(newTreasuryAddress)}?`,
            'Confirm Treasury Update',
            'Update Treasury',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Treasury update cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Updating fee treasury address...');
        
        const contract = getAdminContract();
        const tx = await contract.updateFeeTreasury(newTreasuryAddress);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Treasury Update Submitted');
        
        console.log('🔄 Treasury update transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Fee treasury address updated successfully!');
        
        console.log('✅ Treasury update confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Update Fee Treasury',
            { newTreasuryAddress, txHash: tx.hash, receipt },
            `
CREATE TABLE treasury_updates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    new_treasury_address VARCHAR(42) NOT NULL,
    admin_address VARCHAR(42) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Treasury update failed:', error);
        window.uiUtils.logTransactionError(error, 'Update Fee Treasury');
        window.uiUtils.showRevertAlert(error, 'Treasury Update Failed');
        throw error;
    }
}

/**
 * Fonction d'urgence pour récupérer des fonds
 */
async function executeEmergencyRecoverFunds(tokenAddress, amount) {
    console.log(`🚨 Executing emergency fund recovery - Token: ${tokenAddress}, Amount: ${amount}`);
    
    if (!await checkAdminRole()) {
        throw new Error('Insufficient permissions');
    }
    
    try {
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Execute emergency fund recovery?\n\nToken: ${window.walletUtils.formatAddress(tokenAddress)}\nAmount: ${window.uiUtils.formatAmount(amount)}\n\nThis is an emergency function!`,
            'Confirm Emergency Recovery',
            'Recover Funds',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Emergency recovery cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Executing emergency recovery...');
        
        const contract = getAdminContract();
        const tx = await contract.executeEmergencyRecoverFunds(tokenAddress, amount);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Emergency Recovery Submitted');
        
        console.log('🔄 Emergency recovery transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Emergency fund recovery executed successfully!');
        
        console.log('✅ Emergency recovery confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Emergency Recover Funds',
            { tokenAddress, amount, txHash: tx.hash, receipt },
            `
CREATE TABLE emergency_recoveries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token_address VARCHAR(42) NOT NULL,
    amount DECIMAL(20,8) NOT NULL,
    admin_address VARCHAR(42) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Emergency recovery failed:', error);
        window.uiUtils.logTransactionError(error, 'Emergency Recover Funds');
        window.uiUtils.showRevertAlert(error, 'Emergency Recovery Failed');
        throw error;
    }
}

/**
 * Obtient l'administrateur d'un rôle spécifique
 */
async function getRoleAdmin(roleType) {
    console.log(`👑 Getting admin for role: ${roleType}`);
    
    try {
        const contract = getAdminContract();
        
        // Get role hash
        let roleHash;
        switch(roleType.toLowerCase()) {
            case 'admin':
                roleHash = await contract.ADMIN_ROLE();
                break;
            case 'operator':
                roleHash = await contract.OPERATOR_ROLE();
                break;
            case 'default':
                roleHash = await contract.DEFAULT_ADMIN_ROLE();
                break;
            default:
                // Assume it's already a bytes32 role hash
                roleHash = roleType;
        }
        
        const adminRole = await contract.getRoleAdmin(roleHash);
        
        console.log(`✅ Role admin for ${roleType}: ${adminRole}`);
        return adminRole;
        
    } catch (error) {
        console.error('❌ Error getting role admin:', error);
        window.uiUtils.showErrorAlert('Failed to get role admin');
        throw error;
    }
}

// Dans adminFunctions.js
// async function checkPoolAdminPermissions() {
//     try {
//         // Vérifie si l'utilisateur connecté a le rôle ADMIN ou POOL_ADMIN
//         const hasAdminRole = await this.hasRole('ADMIN');
//         const hasPoolAdminRole = await this.hasRole('POOL_ADMIN');
        
//         return hasAdminRole || hasPoolAdminRole;
//     } catch (error) {
//         console.error('Error checking admin permissions:', error);
//         return false;
//     }
// }

// N'oubliez pas d'exposer la fonction à window
// window.adminFunctions = window.adminFunctions || {};
// window.adminFunctions.checkPoolAdminPermissions = checkPoolAdminPermissions;

// Ajouter les nouvelles fonctions à l'export
window.adminFunctions = {
    ...window.adminFunctions, // Conserver les fonctions existantes
    updateCollateralRates,
    updateCommissionRates,
    updateStablecoin,
    updateFeeTreasury,
    executeEmergencyRecoverFunds,
    getRoleAdmin,
};

console.log('👑 Additional admin functions loaded successfully');
// Export functions for global use
window.adminFunctions = {
    // Fonctions de base et gestion de contrat
    getAdminContract,
    checkAdminRole,
    pauseContract,
    unpauseContract,
    
    // Gestion des rôles
    grantRole,
    revokeRole,
    getRoleAdmin,
    
    // Gestion des factures
    createInvoice,
    addInvoiceToPool,
    compensateInvestors,
    
    // Gestion des pools
    createPool,
    setPoolActive,
    
    // Gestion des commissions
    startUpdateCommissionRates,
    updateCommissionRates,
    
    // Gestion des taux et paramètres
    updateCollateralRates,
    updateStablecoin,
    updateFeeTreasury,
    
    // Fonctions d'urgence
    executeEmergencyRecoverFunds
};

console.log('👑 Admin functions loaded successfully');
