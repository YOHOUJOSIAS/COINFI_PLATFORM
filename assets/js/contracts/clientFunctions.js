/**
 * Client Functions for CoinFinance Platform
 * Fonctions destinées aux clients pour le remboursement des factures
 */

// Import de l'ABI complète depuis le fichier séparé
import { invoiceTokenABI } from '../abi/invoiceToken_abi.js';

/**
 * Obtient le contrat avec les fonctions client
 */
function getClientContract() {
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
 * Rembourse une facture
 */
async function repayInvoice(invoiceId) {
    console.log(`💳 Repaying invoice ${invoiceId}...`);
    
    if (!window.walletUtils.isWalletReady()) {
        throw new Error('Wallet not connected');
    }
    
    try {
        const userAddress = window.walletUtils.getCurrentWalletAddress();
        
        // Get invoice details first
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        // Verify user is the client
        if (invoice.details.client.toLowerCase() !== userAddress.toLowerCase()) {
            throw new Error('Only the invoice client can repay this invoice');
        }
        
        // Check if invoice is already paid
        if (invoice.financials.isPaid) {
            throw new Error('Invoice has already been paid');
        }
        
        // Check if funds have been withdrawn by company
        if (!invoice.financials.fundsWithdrawn) {
            throw new Error('Company must withdraw funds before client can repay');
        }
        
        // Get current stablecoin
        const currentStablecoin = window.stablecoinCFN.getStablecoinInfo();
        if (!currentStablecoin) {
            throw new Error('No stablecoin available for current network');
        }
        
        // Calculate repayment amount (full invoice amount)
        const repaymentAmount = ethers.utils.formatEther(invoice.details.amount);
        const collectedAmount = ethers.utils.formatEther(invoice.financials.collectedAmount);
        const surplus = parseFloat(repaymentAmount) - parseFloat(collectedAmount);
        
        // Check balance
        const balanceCheck = await window.stablecoinCFN.checkCFNBalance(repaymentAmount, userAddress);
        
        if (!balanceCheck.hasEnough) {
            throw new Error(`Insufficient balance. Required: ${repaymentAmount} ${currentStablecoin.symbol}, Available: ${balanceCheck.balance} ${currentStablecoin.symbol}`);
        }
        
      
            const approveConfirmed = await window.uiUtils.showConfirmAlert(
                `You need to approve ${repaymentAmount} ${currentStablecoin.symbol} for the contract first.\n\nApprove now?`,
                'Approval Required',
                'Approve',
                'Cancel'
            );
            
            if (!approveConfirmed) {
                console.log('❌ Approval cancelled by user');
                return null;
            }
            
            await window.stablecoinCFN.approveCFN(window.COINFINANCE_CONFIG.contracts.invoiceToken, repaymentAmount);
            
            
        
        // Calculate breakdown for display
        const interestWithheld = ethers.utils.formatEther(invoice.financials.interestWithheld);
        const commissionRates = await window.sharedFunctions.getCommissionRates();
        const performanceFee = parseFloat(interestWithheld) * (commissionRates.performanceFee / 10000);
        const netInterest = parseFloat(interestWithheld) - performanceFee;
        const investorPayment = parseFloat(repaymentAmount) + netInterest;
        
        // Check if invoice is overdue
        const isOverdue = window.uiUtils.isDeadlinePassed(invoice.details.dueDate);
        const overdueWarning = isOverdue ? '\n⚠️ This invoice is overdue!' : '';
        
        // Confirmation with breakdown
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Repay invoice #${invoiceId}?${overdueWarning}\n\nBreakdown:\nInvoice Amount: ${repaymentAmount} ${currentStablecoin.symbol}\nCollected by Investors: ${collectedAmount} ${currentStablecoin.symbol}\nSurplus to Company: ${surplus.toFixed(6)} ${currentStablecoin.symbol}\n\nInterest Withheld: ${interestWithheld} ${currentStablecoin.symbol}\nPerformance Fee: ${performanceFee.toFixed(6)} ${currentStablecoin.symbol}\nNet Interest to Investors: ${netInterest.toFixed(6)} ${currentStablecoin.symbol}\n\nTotal to Investors: ${investorPayment.toFixed(6)} ${currentStablecoin.symbol}`,
            'Confirm Invoice Repayment',
            'Repay Invoice',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Invoice repayment cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Processing repayment...');
        
        const clientContract = getClientContract();
        const tx = await clientContract.repayInvoice(invoiceId, userAddress);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Repayment Submitted');
        
        console.log('🔄 Repayment transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Invoice repaid successfully! Paid: ${repaymentAmount} ${currentStablecoin.symbol}`);
        
        console.log('✅ Repayment confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Repay Invoice',
            { 
                invoiceId, 
                repaymentAmount,
                collectedAmount,
                surplus,
                interestWithheld,
                performanceFee,
                netInterest,
                investorPayment,
                isOverdue,
                tokenType: currentStablecoin.symbol,
                txHash: tx.hash, 
                receipt 
            },
            `
CREATE TABLE invoice_repayments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT NOT NULL,
    client_address VARCHAR(42) NOT NULL,
    repayment_amount DECIMAL(20,8) NOT NULL,
    collected_amount DECIMAL(20,8) NOT NULL,
    surplus_amount DECIMAL(20,8) NOT NULL,
    interest_withheld DECIMAL(20,8) NOT NULL,
    performance_fee DECIMAL(20,8) NOT NULL,
    net_interest DECIMAL(20,8) NOT NULL,
    investor_payment DECIMAL(20,8) NOT NULL,
    is_overdue BOOLEAN NOT NULL,
    token_type VARCHAR(10) NOT NULL,
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
        console.error('❌ Invoice repayment failed:', error);
        window.uiUtils.logTransactionError(error, 'Repay Invoice');
        window.uiUtils.showRevertAlert(error, 'Repayment Failed');
        throw error;
    }
}

/**
 * Obtient les factures d'un client
 */
async function getClientInvoices(clientAddress = null) {
    console.log('📄 Getting client invoices...');
    
    try {
        const address = clientAddress || window.walletUtils.getCurrentWalletAddress();
        
        // Get all invoices and filter by client
        const allInvoices = await window.sharedFunctions.getAllInvoices();
        const clientInvoices = window.sharedFunctions.filterInvoicesByClient(allInvoices, address);
        
        // Add additional information for each invoice
        const invoicesWithDetails = clientInvoices.map(invoice => {
            const amount = ethers.utils.formatEther(invoice.details.amount);
            const collectedAmount = ethers.utils.formatEther(invoice.financials.collectedAmount);
            const repaymentAmount = invoice.financials.isPaid ? 
                ethers.utils.formatEther(invoice.financials.repaymentAmount) : '0';
            
            const isOverdue = !invoice.financials.isPaid && 
                window.uiUtils.isDeadlinePassed(invoice.details.dueDate);
            
            const canRepay = !invoice.financials.isPaid && 
                invoice.financials.fundsWithdrawn;
            
            return {
                invoiceId: invoice.details.invoiceId.toNumber(),
                company: invoice.details.company,
                amount: amount,
                collectedAmount: collectedAmount,
                repaymentAmount: repaymentAmount,
                interestRate: invoice.details.interestRate / 100,
                dueDate: new Date(invoice.details.dueDate * 1000),
                fundingEndDate: new Date(invoice.details.fundingEndDate * 1000),
                isPaid: invoice.financials.isPaid,
                fundsWithdrawn: invoice.financials.fundsWithdrawn,
                isActive: invoice.details.isActive,
                isOverdue: isOverdue,
                canRepay: canRepay,
                status: invoice.financials.isPaid ? 'paid' : 
                        isOverdue ? 'overdue' : 
                        canRepay ? 'ready_to_pay' : 
                        invoice.financials.fundsWithdrawn ? 'funds_withdrawn' : 'active'
            };
        });
        
        console.log('✅ Client invoices retrieved:', invoicesWithDetails);
        
        return invoicesWithDetails;
        
    } catch (error) {
        console.error('❌ Error getting client invoices:', error);
        throw error;
    }
}

/**
 * Calcule le montant total à payer pour une facture
 */
async function calculateRepaymentAmount(invoiceId) {
    console.log(`💰 Calculating repayment amount for invoice ${invoiceId}...`);
    
    try {
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        if (invoice.financials.isPaid) {
            return {
                totalAmount: '0',
                breakdown: null,
                message: 'Invoice already paid'
            };
        }
        
        const invoiceAmount = ethers.utils.formatEther(invoice.details.amount);
        const collectedAmount = ethers.utils.formatEther(invoice.financials.collectedAmount);
        const interestWithheld = ethers.utils.formatEther(invoice.financials.interestWithheld);
        
        // Get commission rates for performance fee calculation
        const commissionRates = await window.sharedFunctions.getCommissionRates();
        const performanceFee = parseFloat(interestWithheld) * (commissionRates.performanceFee / 10000);
        const netInterest = parseFloat(interestWithheld) - performanceFee;
        
        const surplus = parseFloat(invoiceAmount) - parseFloat(collectedAmount);
        const totalToInvestors = parseFloat(invoiceAmount) + netInterest;
        
        const breakdown = {
            invoiceAmount: parseFloat(invoiceAmount),
            collectedAmount: parseFloat(collectedAmount),
            surplus: surplus,
            interestWithheld: parseFloat(interestWithheld),
            performanceFee: performanceFee,
            netInterest: netInterest,
            totalToInvestors: totalToInvestors
        };
        
        console.log('✅ Repayment calculation:', breakdown);
        
        return {
            totalAmount: invoiceAmount,
            breakdown: breakdown,
            message: null
        };
        
    } catch (error) {
        console.error('❌ Error calculating repayment amount:', error);
        throw error;
    }
}

/**
 * Vérifie si un client peut rembourser une facture
 */
async function canRepayInvoice(invoiceId, clientAddress = null) {
    try {
        const address = clientAddress || window.walletUtils.getCurrentWalletAddress();
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        // Check if user is the client
        if (invoice.details.client.toLowerCase() !== address.toLowerCase()) {
            return { canRepay: false, reason: 'Not the invoice client' };
        }
        
        // Check if already paid
        if (invoice.financials.isPaid) {
            return { canRepay: false, reason: 'Invoice already paid' };
        }
        
        // Check if funds have been withdrawn
        if (!invoice.financials.fundsWithdrawn) {
            return { canRepay: false, reason: 'Company must withdraw funds first' };
        }
        
        return { canRepay: true, reason: null };
        
    } catch (error) {
        console.error('❌ Error checking repayment eligibility:', error);
        return { canRepay: false, reason: 'Error checking eligibility' };
    }
}

/**
 * Obtient l'historique des paiements d'un client
 */
async function getPaymentHistory(clientAddress = null) {
    try {
        const address = clientAddress || window.walletUtils.getCurrentWalletAddress();
        const clientInvoices = await getClientInvoices(address);
        
        // Toujours retourner un objet avec invoices comme tableau
        return {
            totalInvoices: clientInvoices.length || 0,
            paidInvoices: clientInvoices.filter(i => i.isPaid).length || 0,
            overdueInvoices: clientInvoices.filter(i => i.isOverdue).length || 0,
            pendingInvoices: clientInvoices.filter(i => !i.isPaid && !i.isOverdue).length || 0,
            totalPaid: clientInvoices.filter(i => i.isPaid).reduce((sum, i) => sum + parseFloat(i.amount), 0) || 0,
            totalOverdue: clientInvoices.filter(i => i.isOverdue).reduce((sum, i) => sum + parseFloat(i.amount), 0) || 0,
            totalPending: clientInvoices.filter(i => !i.isPaid && !i.isOverdue).reduce((sum, i) => sum + parseFloat(i.amount), 0) || 0,
            invoices: clientInvoices || [] // Toujours un tableau, même vide
        };
        
    } catch (error) {
        console.error('Error getting payment history:', error);
        // Retourner un objet vide avec invoices comme tableau vide en cas d'erreur
        return {
            totalInvoices: 0,
            paidInvoices: 0,
            overdueInvoices: 0,
            pendingInvoices: 0,
            totalPaid: 0,
            totalOverdue: 0,
            totalPending: 0,
            invoices: []
        };
    }
}

/**
 * Vérifie le statut d'une facture pour un client
 */
function getInvoiceStatus(invoice) {
    if (invoice.financials.isPaid) {
        return {
            status: 'paid',
            label: 'Paid',
            color: 'success',
            canRepay: false
        };
    }
    
    const isOverdue = window.uiUtils.isDeadlinePassed(invoice.details.dueDate);
    
    if (isOverdue) {
        return {
            status: 'overdue',
            label: 'Overdue',
            color: 'danger',
            canRepay: invoice.financials.fundsWithdrawn
        };
    }
    
    if (invoice.financials.fundsWithdrawn) {
        return {
            status: 'ready_to_pay',
            label: 'Ready to Pay',
            color: 'warning',
            canRepay: true
        };
    }
    
    if (invoice.details.isActive) {
        return {
            status: 'active',
            label: 'Active',
            color: 'info',
            canRepay: false
        };
    }
    
    return {
        status: 'inactive',
        label: 'Inactive',
        color: 'secondary',
        canRepay: false
    };
}

// Export functions for global use
window.clientFunctions = {
    getClientContract,
    repayInvoice,
    getClientInvoices,
    calculateRepaymentAmount,
    canRepayInvoice,
    getPaymentHistory,
    getInvoiceStatus
};

console.log('👤 Client functions loaded successfully');