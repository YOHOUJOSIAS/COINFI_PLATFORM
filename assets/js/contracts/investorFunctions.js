/**
 * Investor Functions for CoinFinance Platform
 * Fonctions destinées aux investisseurs
 */

// Import de l'ABI complète depuis le fichier séparé
import { invoiceTokenABI } from '../abi/invoiceToken_abi.js';

/**
 * Obtient le contrat avec les fonctions investisseur
 */
function getInvestorContract() {
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
 * Investit dans une facture individuelle
 */
async function investInInvoice(invoiceId, amount) {
    console.log(`💰 Investing ${amount} in invoice ${invoiceId}...`);
    
    if (!window.walletUtils.isWalletReady()) {
        throw new Error('Wallet not connected');
    }
    console.log("Wallet est bien connecté ooook")
    try {
        const userAddress = window.walletUtils.getCurrentWalletAddress();
        
        // Get invoice details first
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        console.log("Invoice::::=>",invoice)
        
        // Validation checks
        if (!window.sharedFunctions.canInvestInInvoice(invoice)) {
            throw new Error('Invoice is not available for investment');
        }
        
        if (!window.uiUtils.isValidAmount(amount)) {
            throw new Error('Invalid investment amount');
        }
        
        // Check if user is not the company or client
        if (invoice.details.company.toLowerCase() === userAddress.toLowerCase()) {
            throw new Error('Company cannot invest in its own invoice');
        }
        
        if (invoice.details.client.toLowerCase() === userAddress.toLowerCase()) {
            throw new Error('Client cannot invest in their own invoice');
        }
        
        // Get current stablecoin
        const currentStablecoin = window.stablecoinCFN.getStablecoinInfo();
        if (!currentStablecoin) {
            throw new Error('No stablecoin available for current network');
        }
        
        // Check balance
        const balanceCheck = await window.stablecoinCFN.checkCFNBalance(amount, userAddress);
        
        if (!balanceCheck.hasEnough) {
            throw new Error(`Insufficient balance. Required: ${amount} ${currentStablecoin.symbol}, Available: ${balanceCheck.balance} ${currentStablecoin.symbol}`);
        }
        
        // Check allowance
        const allowance = await window.stablecoinCFN.getCFNAllowance(userAddress, window.COINFINANCE_CONFIG.contracts.invoiceToken);
        
        if (parseFloat(allowance.formatted) < parseFloat(amount)) {
            // Need approval first
            const approveConfirmed = await window.uiUtils.showConfirmAlert(
                `You need to approve ${amount} ${currentStablecoin.symbol} for the contract first.\n\nApprove now?`,
                'Approval Required',
                'Approve',
                'Cancel'
            );
            
            if (!approveConfirmed) {
                console.log('❌ Approval cancelled by user');
                return null;
            }
            
            // Execute approval
            await window.stablecoinCFN.approveCFN(window.COINFINANCE_CONFIG.contracts.invoiceToken, amount);
            
        }
        
        // Calculate fees and net investment
        const commissionRates = await window.sharedFunctions.getCommissionRates();
        const entryFee = parseFloat(amount) * (commissionRates.entryFee / 10000);
        const netInvestment = parseFloat(amount) - entryFee;
        const remainingAmount = ethers.utils.formatEther(invoice.details.amount.sub(invoice.financials.totalSupply));
        
        // Confirmation with details
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Invest in invoice #${invoiceId}?\n\nInvestment: ${amount} ${currentStablecoin.symbol}\nEntry Fee: ${entryFee.toFixed(6)} ${currentStablecoin.symbol}\nNet Investment: ${netInvestment.toFixed(6)} ${currentStablecoin.symbol}\n\nRemaining Amount: ${remainingAmount} ${currentStablecoin.symbol}\nInterest Rate: ${invoice.details.interestRate / 100}%`,
            'Confirm Investment',
            'Invest',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Investment cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Processing investment...');
        
        const amountWei = ethers.utils.parseEther(amount.toString());
        const investorContract = getInvestorContract();
        const spenderAddress = window.COINFINANCE_CONFIG.contracts.invoiceToken;
        console.log("Adresse du contrat utilisée pour l'approbation et l'investissement :", spenderAddress);

        const tx = await investorContract.invest(invoiceId, amountWei, userAddress);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Investment Submitted');
        
        console.log('🔄 Investment transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Investment successful! Invested: ${netInvestment.toFixed(6)} ${currentStablecoin.symbol}`);
        
        console.log('✅ Investment confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Invest in Invoice',
            { 
                invoiceId, 
                amount,
                entryFee,
                netInvestment,
                tokenType: currentStablecoin.symbol,
                txHash: tx.hash, 
                receipt 
            },
            `
CREATE TABLE investments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT NOT NULL,
    investor_address VARCHAR(42) NOT NULL,
    gross_amount DECIMAL(20,8) NOT NULL,
    entry_fee DECIMAL(20,8) NOT NULL,
    net_amount DECIMAL(20,8) NOT NULL,
    token_type VARCHAR(10) NOT NULL,
    interest_rate DECIMAL(5,2) NOT NULL,
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
        console.error('❌ Investment failed:', error);
        window.uiUtils.logTransactionError(error, 'Invest in Invoice');
        window.uiUtils.showRevertAlert(error, 'Investment Failed');
        throw error;
    }
}

/**
 * Investit dans un pool
 */
async function investInPool(poolId, amount) {
    console.log(`🏊💰 Investing ${amount} in pool ${poolId}...`);
    
    if (!window.walletUtils.isWalletReady()) {
        throw new Error('Wallet not connected');
    }
    
    try {
        const userAddress = window.walletUtils.getCurrentWalletAddress();
        
        // Get pool details first
        const { pool } = await window.sharedFunctions.getPoolDetails(poolId);
        
        // Validation checks
        if (!(await window.sharedFunctions.canInvestInPool(pool))) {
            throw new Error('Pool is not available for investment (no active invoices or funding period ended)');
        }
        // if (!window.sharedFunctions.canInvestInPool(pool)) {
        //     throw new Error('Pool is not available for investment');
        // }
        
        if (!window.uiUtils.isValidAmount(amount)) {
            throw new Error('Invalid investment amount');
        }
        
        // Check minimum investment
        const minInvestment = ethers.utils.formatEther(pool.minInvestment);
        if (parseFloat(amount) < parseFloat(minInvestment)) {
            throw new Error(`Investment amount below minimum. Minimum: ${minInvestment} tokens`);
        }
        
        // Get current stablecoin
        const currentStablecoin = window.stablecoinCFN.getStablecoinInfo();
        if (!currentStablecoin) {
            throw new Error('No stablecoin available for current network');
        }
        
        // Check balance
        const balanceCheck = await window.stablecoinCFN.checkCFNBalance(amount, userAddress);
        
        if (!balanceCheck.hasEnough) {
            throw new Error(`Insufficient balance. Required: ${amount} ${currentStablecoin.symbol}, Available: ${balanceCheck.balance} ${currentStablecoin.symbol}`);
        }
        
        // Check allowance
        const allowance = await window.stablecoinCFN.getCFNAllowance(userAddress, window.COINFINANCE_CONFIG.contracts.invoiceToken);
        
        if (parseFloat(allowance.formatted) < parseFloat(amount)) {
            // Need approval first
            const approveConfirmed = await window.uiUtils.showConfirmAlert(
                `You need to approve ${amount} ${currentStablecoin.symbol} for the contract first.\n\nApprove now?`,
                'Approval Required',
                'Approve',
                'Cancel'
            );
            
            if (!approveConfirmed) {
                console.log('❌ Approval cancelled by user');
                return null;
            }
            
            // Execute approval
            await window.stablecoinCFN.approveCFN(window.COINFINANCE_CONFIG.contracts.invoiceToken, amount);
            
        }
        
        // Calculate fees
        const commissionRates = await window.sharedFunctions.getCommissionRates();
        const totalFeeRate = commissionRates.entryFee + commissionRates.poolFee;
        const totalFees = parseFloat(amount) * (totalFeeRate / 10000);
        const netInvestment = parseFloat(amount) - totalFees;
        
        // Get pool invoices for display
        const poolInvoices = await window.sharedFunctions.getPoolInvoices(poolId);
        const activeInvoices = poolInvoices.filter(inv => window.sharedFunctions.canInvestInInvoice(inv));
        
        // Confirmation with details
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Invest in pool "${pool.name}"?\n\nInvestment: ${amount} ${currentStablecoin.symbol}\nTotal Fees: ${totalFees.toFixed(6)} ${currentStablecoin.symbol}\nNet Investment: ${netInvestment.toFixed(6)} ${currentStablecoin.symbol}\n\nActive Invoices: ${activeInvoices.length}\nMinimum Investment: ${minInvestment} ${currentStablecoin.symbol}`,
            'Confirm Pool Investment',
            'Invest',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Pool investment cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Processing pool investment...');
        
        const amountWei = ethers.utils.parseEther(amount.toString());
        const investorContract = getInvestorContract();
        const tx = await investorContract.investInPool(poolId, amountWei, userAddress);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Pool Investment Submitted');
        
        console.log('🔄 Pool investment transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Pool investment successful! Invested: ${netInvestment.toFixed(6)} ${currentStablecoin.symbol}`);
        
        console.log('✅ Pool investment confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Invest in Pool',
            { 
                poolId, 
                poolName: pool.name,
                amount,
                totalFees,
                netInvestment,
                tokenType: currentStablecoin.symbol,
                activeInvoices: activeInvoices.length,
                txHash: tx.hash, 
                receipt 
            },
            `
CREATE TABLE pool_investments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pool_id BIGINT NOT NULL,
    investor_address VARCHAR(42) NOT NULL,
    gross_amount DECIMAL(20,8) NOT NULL,
    total_fees DECIMAL(20,8) NOT NULL,
    net_amount DECIMAL(20,8) NOT NULL,
    token_type VARCHAR(10) NOT NULL,
    active_invoices_count INT,
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
        console.error('❌ Pool investment failed:', error);
        window.uiUtils.logTransactionError(error, 'Invest in Pool');
        window.uiUtils.showRevertAlert(error, 'Pool Investment Failed');
        throw error;
    }
}

/**
 * Réclame les fonds d'une facture payée
 */
async function claimFunds(invoiceId) {
    console.log(`💸 Claiming funds for invoice ${invoiceId}...`);
    
    if (!window.walletUtils.isWalletReady()) {
        throw new Error('Wallet not connected');
    }
    
    try {
        const userAddress = window.walletUtils.getCurrentWalletAddress();
        
        // Get invoice details first
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        // Check if invoice is paid
        if (!invoice.financials.isPaid) {
            throw new Error('Invoice has not been paid yet');
        }
        
        // Check investor shares
        const shares = await window.sharedFunctions.getInvestorShares(userAddress, invoiceId);
        if (shares.eq(0)) {
            throw new Error('You have no shares in this invoice');
        }
        
        // Calculate claimable amount
        const sharesFormatted = ethers.utils.formatEther(shares);
        const repaymentAmount = ethers.utils.formatEther(invoice.financials.repaymentAmount);
        const claimableAmount = (parseFloat(repaymentAmount) * parseFloat(sharesFormatted)) / 1e18;
        
        // Get current stablecoin type for display
        const currentStablecoin = window.stablecoinCFN.getStablecoinInfo();
        const tokenSymbol = currentStablecoin ? currentStablecoin.symbol : 'tokens';
        
        // Confirmation
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Claim funds for invoice #${invoiceId}?\n\nYour shares: ${(parseFloat(sharesFormatted) * 100).toFixed(6)}%\nClaimable amount: ${claimableAmount.toFixed(6)} ${tokenSymbol}\n\nNote: This will burn your ERC1155 tokens for this invoice.`,
            'Confirm Funds Claim',
            'Claim Funds',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Funds claim cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Claiming funds...');
        
        const investorContract = getInvestorContract();
        const tx = await investorContract.claimFunds(invoiceId, userAddress);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Funds Claim Submitted');
        
        console.log('🔄 Funds claim transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Funds claimed successfully! Received: ${claimableAmount.toFixed(6)} ${tokenSymbol}`);
        
        console.log('✅ Funds claim confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Claim Funds',
            { 
                invoiceId, 
                shares: sharesFormatted,
                claimableAmount,
                tokenSymbol,
                txHash: tx.hash, 
                receipt 
            },
            `
CREATE TABLE funds_claims (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT NOT NULL,
    investor_address VARCHAR(42) NOT NULL,
    shares_percentage DECIMAL(10,6) NOT NULL,
    claimed_amount DECIMAL(20,8) NOT NULL,
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
        console.error('❌ Funds claim failed:', error);
        window.uiUtils.logTransactionError(error, 'Claim Funds');
        window.uiUtils.showRevertAlert(error, 'Funds Claim Failed');
        throw error;
    }
}

/**
 * Obtient le portefeuille d'investissements d'un utilisateur
 */
async function getInvestorPortfolio(investorAddress = null) {
    const address = investorAddress || window.walletUtils.getCurrentWalletAddress();
    const invoices = await window.sharedFunctions.getInvestorInvoices(address);
    
    let totalInvested = 0;
    let totalClaimable = 0;
    let activeInvestments = 0;
    
    const portfolio = [];
    const contract = window.sharedFunctions.getInvoiceTokenContract();
    
    for (const invoice of invoices) {
        const shares = await contract.balanceOf(address, invoice.details.invoiceId);
        const totalAmount = invoice.details.amount;
        const totalSupply = invoice.financials.totalSupply;

        const sharesDecimal = Number(ethers.utils.formatUnits(shares, 18));
        const totalAmountDecimal = Number(ethers.utils.formatUnits(totalAmount, 18));
        const totalSupplyDecimal = Number(ethers.utils.formatUnits(totalSupply, 18));

        const investedAmount = sharesDecimal * totalAmountDecimal;

       
        const sharesPercentage = totalAmountDecimal > 0 
            ? (investedAmount / totalAmountDecimal) * 100
            : 0;
  

        let claimableAmount = 0;
        if (invoice.financials.isPaid) {
            const repaymentAmount = Number(ethers.utils.formatUnits(invoice.financials.repaymentAmount, 18));
            claimableAmount = (investedAmount / totalAmountDecimal) * repaymentAmount;
            totalClaimable += claimableAmount;
        } else {
            activeInvestments++;
        }
        
        totalInvested += investedAmount;

        portfolio.push({
            invoiceId: invoice.details.invoiceId.toNumber(),
            company: invoice.details.company,
            amount: totalAmountDecimal.toFixed(2),
            interestRate: invoice.details.interestRate / 100,
            dueDate: new Date(invoice.details.dueDate * 1000),
            shares: sharesDecimal,
            sharesPercentage: sharesPercentage,
            investedAmount: investedAmount,
            claimableAmount: claimableAmount,
            isPaid: invoice.financials.isPaid,
            canClaim: invoice.financials.isPaid && sharesDecimal > 0
        });
    }
    
    return {
        totalInvestments: invoices.length,
        activeInvestments,
        paidInvestments: invoices.length - activeInvestments,
        totalInvested,
        totalClaimable,
        portfolio
    };
}


/**
 * Calcule le rendement potentiel d'un investissement
 */
function calculateInvestmentReturn(amount, interestRate, durationDays) {
    try {
        const principal = parseFloat(amount);
        const rate = parseFloat(interestRate) / 100;
        const interest = principal * rate;
        const totalReturn = principal + interest;
        const roi = (interest / principal) * 100;
        
        return {
            principal,
            interest,
            totalReturn,
            roi,
            durationDays
        };
    } catch (error) {
        console.error('❌ Error calculating return:', error);
        return null;
    }
}

/**
 * Vérifie si un investisseur peut investir dans une facture
 */
async function canInvestInInvoice(invoiceId, investorAddress = null) {
    try {
        const address = investorAddress || window.walletUtils.getCurrentWalletAddress();
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        // Check basic eligibility
        if (!window.sharedFunctions.canInvestInInvoice(invoice)) {
            return { canInvest: false, reason: 'Invoice not available for investment' };
        }
        
        // Check if user is company or client
        if (invoice.details.company.toLowerCase() === address.toLowerCase()) {
            return { canInvest: false, reason: 'Cannot invest in own invoice' };
        }
        
        if (invoice.details.client.toLowerCase() === address.toLowerCase()) {
            return { canInvest: false, reason: 'Client cannot invest in their invoice' };
        }
        
        return { canInvest: true, reason: null };
        
    } catch (error) {
        console.error('❌ Error checking investment eligibility:', error);
        return { canInvest: false, reason: 'Error checking eligibility' };
    }
}

/**
 * Vérifie si un investisseur peut réclamer des fonds
 */
async function canClaimFunds(invoiceId, investorAddress = null) {
    try {
        const address = investorAddress || window.walletUtils.getCurrentWalletAddress();
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        const shares = await window.sharedFunctions.getInvestorShares(address, invoiceId);
        
        return invoice.financials.isPaid && shares.gt(0);
        
    } catch (error) {
        console.error('❌ Error checking claim eligibility:', error);
        return false;
    }
}

// Export functions for global use
window.investorFunctions = {
    getInvestorContract,
    investInInvoice,
    investInPool,
    claimFunds,
    getInvestorPortfolio,
    calculateInvestmentReturn,
    canInvestInInvoice,
    canClaimFunds
};

console.log('📈 Investor functions loaded successfully');