/**
 * Enterprise Functions for CoinFinance Platform
 * Fonctions destinées aux entreprises
 */

// Import de l'ABI complète depuis le fichier séparé
import { invoiceTokenABI } from '../abi/invoiceToken_abi.js';

/**
 * Obtient le contrat avec les fonctions entreprise
 */
function getEnterpriseContract() {
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
 * Dépose un collatéral pour une facture
 */
async function depositCollateral(invoiceId) {
    console.log(`🏦 Depositing collateral for invoice ${invoiceId}...`);
    
    if (!window.walletUtils.isWalletReady()) {
        throw new Error('Wallet not connected');
    }
    
    try {
        const userAddress = window.walletUtils.getCurrentWalletAddress();
        
        // Get invoice details first
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        // Verify user is the company
        if (invoice.details.company.toLowerCase() !== userAddress.toLowerCase()) {
            throw new Error('Only the invoice company can deposit collateral');
        }
        
        // Check if collateral already deposited
        if (invoice.details.isActive) {
            throw new Error('Collateral already deposited for this invoice');
        }
        
        // Get collateral information
        const contract = window.sharedFunctions.getInvoiceTokenContract();
        const collateral = await contract.invoiceCollaterals(invoiceId);
        
        if (collateral.rates.initialDepositRate === 0) {
            throw new Error('No collateral required for this invoice');
        }
        
        // Calculate collateral amount
        const collateralRate = collateral.rates.initialDepositRate; // in basis points
        const invoiceAmount = invoice.details.amount;
        const collateralAmount = invoiceAmount.mul(collateralRate).div(10000);
        const collateralAmountFormatted = ethers.utils.formatEther(collateralAmount);
        
        // Check stablecoin balance
        const currentStablecoin = window.stablecoinCFN.getStablecoinInfo();
        if (!currentStablecoin) {
            throw new Error('No stablecoin available for current network');
        }
        
        const balanceCheck = await window.stablecoinCFN.checkCFNBalance(collateralAmountFormatted, userAddress);
        
        if (!balanceCheck.hasEnough) {
            throw new Error(`Insufficient balance. Required: ${collateralAmountFormatted} ${currentStablecoin.symbol}, Available: ${balanceCheck.balance} ${currentStablecoin.symbol}`);
        }
        
            // Need approval first
            const approveConfirmed = await window.uiUtils.showConfirmAlert(
                `You need to approve ${collateralAmountFormatted} ${currentStablecoin.symbol} for the contract first.\n\nApprove now?`,
                'Approval Required',
                'Approve',
                'Cancel'
            );
            
            if (!approveConfirmed) {
                console.log('❌ Approval cancelled by user');
                return null;
            }
            
            // Execute approval
            await window.stablecoinCFN.approveCFN(window.COINFINANCE_CONFIG.contracts.invoiceToken, collateralAmountFormatted);
           
        
        // Confirmation
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Deposit ${collateralAmountFormatted} ${currentStablecoin.symbol} as collateral for invoice #${invoiceId}?\n\nCollateral Rate: ${collateralRate/100}%`,
            'Confirm Collateral Deposit',
            'Deposit Collateral',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Collateral deposit cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Depositing collateral...');
        
        const enterpriseContract = getEnterpriseContract();
        const tx = await enterpriseContract.depositCollateral(invoiceId, userAddress);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Collateral Deposit Submitted');
        
        console.log('🔄 Collateral deposit transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert('Collateral deposited successfully! Invoice is now active.');
        
        console.log('✅ Collateral deposit confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Deposit Collateral',
            { 
                invoiceId, 
                collateralAmount: collateralAmountFormatted,
                collateralRate: collateralRate/100,
                tokenType: currentStablecoin.symbol,
                txHash: tx.hash, 
                receipt 
            },
            `
CREATE TABLE collateral_deposits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT NOT NULL,
    company_address VARCHAR(42) NOT NULL,
    collateral_amount DECIMAL(20,8) NOT NULL,
    collateral_rate DECIMAL(5,2) NOT NULL,
    token_type VARCHAR(10) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Collateral deposit failed:', error);
        window.uiUtils.logTransactionError(error, 'Deposit Collateral');
        window.uiUtils.showRevertAlert(error, 'Collateral Deposit Failed');
        throw error;
    }
}

/**
 * Retire les fonds collectés d'une facture
 */
async function withdrawCollectedFunds(invoiceId) {
    console.log(`💰 Withdrawing collected funds for invoice ${invoiceId}...`);
    
    if (!window.walletUtils.isWalletReady()) {
        throw new Error('Wallet not connected');
    }
    
    try {
        const userAddress = window.walletUtils.getCurrentWalletAddress();
        
        // Get invoice details first
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        // Verify user is the company
        if (invoice.details.company.toLowerCase() !== userAddress.toLowerCase()) {
            throw new Error('Only the invoice company can withdraw funds');
        }
        
        // Check if invoice is active
        if (!invoice.details.isActive) {
            throw new Error('Invoice is not active');
        }
        
        // Check if funds already withdrawn
        if (invoice.financials.fundsWithdrawn) {
            throw new Error('Funds have already been withdrawn');
        }
        
        // Check if there are funds to withdraw
        if (invoice.financials.collectedAmount.eq(0)) {
            throw new Error('No funds available to withdraw');
        }
        
        const collectedAmount = ethers.utils.formatEther(invoice.financials.collectedAmount);
        const interestRate = invoice.details.interestRate;
        const interest = parseFloat(collectedAmount) * (interestRate / 10000);
        
        // Calculate fees and withheld amounts
        const commissionRates = await window.sharedFunctions.getCommissionRates();
        const platformFee = parseFloat(collectedAmount) * (commissionRates.issuanceFee / 10000);
        
        // Get collateral info for withheld calculation
        const contract = window.sharedFunctions.getInvoiceTokenContract();
        const collateral = await contract.invoiceCollaterals(invoiceId);
        const withheldRate = collateral.rates.withheldRate;
        const withheldAmount = (parseFloat(collectedAmount) - interest - platformFee) * (withheldRate / 10000);
        
        const netAmount = parseFloat(collectedAmount) - interest - platformFee - withheldAmount;
        
        // Confirmation with breakdown
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Withdraw funds for invoice #${invoiceId}?\n\nBreakdown:\nCollected: ${collectedAmount} tokens\nInterest withheld: ${interest.toFixed(6)} tokens\nPlatform fee: ${platformFee.toFixed(6)} tokens\nWithheld for guarantee: ${withheldAmount.toFixed(6)} tokens\n\nNet amount to receive: ${netAmount.toFixed(6)} tokens`,
            'Confirm Funds Withdrawal',
            'Withdraw Funds',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Funds withdrawal cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Withdrawing collected funds...');
        
        const enterpriseContract = getEnterpriseContract();
        const tx = await enterpriseContract.withdrawCollectedFunds(invoiceId, userAddress);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Funds Withdrawal Submitted');
        
        console.log('🔄 Funds withdrawal transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Funds withdrawn successfully! Received: ${netAmount.toFixed(6)} tokens`);
        
        console.log('✅ Funds withdrawal confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Withdraw Collected Funds',
            { 
                invoiceId, 
                collectedAmount,
                interest,
                platformFee,
                withheldAmount,
                netAmount,
                txHash: tx.hash, 
                receipt 
            },
            `
CREATE TABLE funds_withdrawals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT NOT NULL,
    company_address VARCHAR(42) NOT NULL,
    collected_amount DECIMAL(20,8) NOT NULL,
    interest_withheld DECIMAL(20,8) NOT NULL,
    platform_fee DECIMAL(20,8) NOT NULL,
    withheld_amount DECIMAL(20,8) NOT NULL,
    net_amount DECIMAL(20,8) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        // Update token balance
        await window.uiUtils.updateTokenBalance();
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Funds withdrawal failed:', error);
        window.uiUtils.logTransactionError(error, 'Withdraw Funds');
        window.uiUtils.showRevertAlert(error, 'Funds Withdrawal Failed');
        throw error;
    }
}

/**
 * Libère le collatéral après paiement de la facture
 */
async function releaseCollateral(invoiceId) {
    console.log(`🔓 Releasing collateral for invoice ${invoiceId}...`);
    
    if (!window.walletUtils.isWalletReady()) {
        throw new Error('Wallet not connected');
    }
    
    try {
        const userAddress = window.walletUtils.getCurrentWalletAddress();
        
        // Get invoice details first
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        // Check if invoice is paid
        if (!invoice.financials.isPaid) {
            throw new Error('Invoice must be paid before releasing collateral');
        }
        
        // Get collateral info
        const contract = window.sharedFunctions.getInvoiceTokenContract();
        const collateral = await contract.invoiceCollaterals(invoiceId);
        
        if (collateral.isReleased) {
            throw new Error('Collateral has already been released');
        }
        
        if (collateral.totalAmount.eq(0)) {
            throw new Error('No collateral to release');
        }
        
        const collateralAmount = ethers.utils.formatEther(collateral.totalAmount);
        
        // Confirmation
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Release ${collateralAmount} tokens collateral for invoice #${invoiceId}?`,
            'Confirm Collateral Release',
            'Release Collateral',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Collateral release cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Releasing collateral...');
        
        const enterpriseContract = getEnterpriseContract();
        const tx = await enterpriseContract.releaseCollateral(invoiceId);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Collateral Release Submitted');
        
        console.log('🔄 Collateral release transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Collateral released successfully! Received: ${collateralAmount} tokens`);
        
        console.log('✅ Collateral release confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Release Collateral',
            { 
                invoiceId, 
                collateralAmount,
                txHash: tx.hash, 
                receipt 
            },
            `
CREATE TABLE collateral_releases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT NOT NULL,
    company_address VARCHAR(42) NOT NULL,
    collateral_amount DECIMAL(20,8) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        // Update token balance
        await window.uiUtils.updateTokenBalance();
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Collateral release failed:', error);
        window.uiUtils.logTransactionError(error, 'Release Collateral');
        window.uiUtils.showRevertAlert(error, 'Collateral Release Failed');
        throw error;
    }
}

/**
 * Obtient les détails du collatéral d'une facture
 */
async function getCollateralDetails(invoiceId) {
    console.log(`🔍 Getting collateral details for invoice ${invoiceId}...`);
    
    try {
        const contract = window.sharedFunctions.getInvoiceTokenContract();
        const collateral = await contract.invoiceCollaterals(invoiceId);
        
        const details = {
            initialDeposit: ethers.utils.formatEther(collateral.initialDeposit),
            withheldAmount: ethers.utils.formatEther(collateral.withheldAmount),
            totalAmount: ethers.utils.formatEther(collateral.totalAmount),
            isStaked: collateral.isStaked,
            isReleased: collateral.isReleased,
            isWithdrawable: collateral.isWithdrawable,
            stakingPlatform: collateral.stakingPlatform,
            stakingContract: collateral.stakingContract,
            stakedAmount: ethers.utils.formatEther(collateral.stakedAmount),
            rates: {
                initialDepositRate: collateral.rates.initialDepositRate,
                withheldRate: collateral.rates.withheldRate
            }
        };
        
        console.log('✅ Collateral details:', details);
        
        return details;
        
    } catch (error) {
        console.error('❌ Error getting collateral details:', error);
        throw error;
    }
}

/**
 * Calcule le montant de collatéral requis pour une facture
 */
function calculateCollateralAmount(invoiceAmount, collateralRate) {
    try {
        const amount = ethers.utils.parseEther(invoiceAmount.toString());
        const collateral = amount.mul(collateralRate).div(10000);
        return ethers.utils.formatEther(collateral);
    } catch (error) {
        console.error('❌ Error calculating collateral amount:', error);
        return '0';
    }
}

/**
 * Vérifie si l'entreprise peut retirer les fonds
 */
async function canWithdrawFunds(invoiceId, companyAddress) {
    try {
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        return (
            invoice.details.company.toLowerCase() === companyAddress.toLowerCase() &&
            invoice.details.isActive &&
            !invoice.financials.fundsWithdrawn &&
            invoice.financials.collectedAmount.gt(0)
        );
    } catch (error) {
        console.error('❌ Error checking withdrawal eligibility:', error);
        return false;
    }
}

/**
 * Vérifie si l'entreprise peut libérer le collatéral
 */
async function canReleaseCollateral(invoiceId) {
    try {
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        const contract = window.sharedFunctions.getInvoiceTokenContract();
        const collateral = await contract.invoiceCollaterals(invoiceId);
        
        return (
            invoice.financials.isPaid &&
            !collateral.isReleased &&
            collateral.totalAmount.gt(0)
        );
    } catch (error) {
        console.error('❌ Error checking collateral release eligibility:', error);
        return false;
    }
}

// Export functions for global use
window.enterpriseFunctions = {
    getEnterpriseContract,
    depositCollateral,
    withdrawCollectedFunds,
    releaseCollateral,
    getCollateralDetails,
    calculateCollateralAmount,
    canWithdrawFunds,
    canReleaseCollateral
};

console.log('🏢 Enterprise functions loaded successfully');