/**
 * CoinFinance Token (USDT) Functions
 * Gestion du token natif USDT pour le testnet 
 */

// Import de l'ABI complète depuis le fichier séparé
import { cfnTokenABI } from '../abi/cfnToken_abi.js';

/**
 * Obtient le contrat USDT Token
 */
function getCFNTokenContract(withSigner = false) {
    try {
        const provider = withSigner ? 
            window.walletUtils.getCurrentProvider() : 
            new ethers.providers.JsonRpcProvider(window.COINFINANCE_CONFIG.networks.rpc);
        
        const contract = new ethers.Contract(
            window.COINFINANCE_CONFIG.contracts.cfnToken,
            cfnTokenABI,
            withSigner ? window.walletUtils.getCurrentSigner() : provider
        );
        
        return contract;
    } catch (error) {
        console.error('❌ Error getting USDT contract:', error);
        throw new Error('Failed to get USDT contract instance');
    }
}

/**
 * Récupère les informations de base du token USDT
 */
async function getStablecoinInfo() {
    console.log('🪙 Fetching USDT token information...');
    
    try {
        const contract = getCFNTokenContract();
        
        const [name, symbol, decimals, totalSupply] = await Promise.all([
            contract.name(),
            contract.symbol(),
            contract.decimals(),
            contract.totalSupply()
        ]);
        
        const tokenInfo = {
            name,
            symbol,
            decimals,
            totalSupply: ethers.utils.formatUnits(totalSupply, decimals),
            address: window.COINFINANCE_CONFIG.contracts.cfnToken
        };
        
        console.log('✅ USDT token info fetched successfully:');
        console.log('🪙 Token info:', tokenInfo);
        
        return tokenInfo;
        
    } catch (error) {
        console.error('❌ Error fetching USDT token info:', error);
        throw error;
    }
}

/**
 * Récupère le solde USDT d'une adresse
 */
async function getCFNBalance(address) {
    console.log(`💰 Fetching USDT balance for: ${address}`);
    
    try {
        const contract = getCFNTokenContract();
        const balance = await contract.balanceOf(address);
        const formattedBalance = ethers.utils.formatEther(balance);
        
        console.log(`✅ USDT balance: ${formattedBalance} USDT`);
        
        return {
            raw: balance,
            formatted: formattedBalance,
            display: parseFloat(formattedBalance).toFixed(2)
        };
        
    } catch (error) {
        console.error('❌ Error fetching USDT balance:', error);
        throw error;
    }
}

/**
 * Transfert de tokens USDT
 */
async function transferCFN(toAddress, amount) {
    console.log(`💸 Transferring ${amount} USDT to: ${toAddress}`);
    
    if (!window.walletUtils.isWalletReady()) {
        throw new Error('Wallet not connected');
    }
    
    try {
        // Validation
        if (!window.uiUtils.isValidAddress(toAddress)) {
            throw new Error('Invalid recipient address');
        }
        
        if (!window.uiUtils.isValidAmount(amount)) {
            throw new Error('Invalid amount');
        }
        
        // Confirmation
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Transfer ${amount} USDT to ${window.walletUtils.formatAddress(toAddress)}?`,
            'Confirm Transfer',
            'Transfer',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Transfer cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Processing transfer...');
        
        const contract = getCFNTokenContract(true);
        const amountWei = ethers.utils.parseEther(amount.toString());
        
        // Execute transfer
        const tx = await contract.transfer(toAddress, amountWei);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Transfer Submitted');
        
        console.log('🔄 Transfer transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Successfully transferred ${amount} USDT!`);
        
        console.log('✅ Transfer confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'USDT Transfer',
            { to: toAddress, amount, txHash: tx.hash, receipt },
            `
CREATE TABLE cfn_transfers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    from_address VARCHAR(42) NOT NULL,
    to_address VARCHAR(42) NOT NULL,
    amount DECIMAL(20,8) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    gas_used BIGINT,
    status ENUM('pending', 'confirmed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        // Update UI balance
        await window.uiUtils.updateTokenBalance();
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ USDT transfer failed:', error);
        window.uiUtils.logTransactionError(error, 'USDT Transfer');
        window.uiUtils.showRevertAlert(error, 'Transfer Failed');
        throw error;
    }
}

/**
 * Approve des tokens USDT pour un contrat
 */
async function approveCFN(spenderAddress, amount) {
    console.log(`✅ Approving ${amount} USDT for: ${spenderAddress}`);
    
    if (!window.walletUtils.isWalletReady()) {
        throw new Error('Wallet not connected');
    }
    
    try {
        // Validation
        if (!window.uiUtils.isValidAddress(spenderAddress)) {
            throw new Error('Invalid spender address');
        }
        
        const contract = getCFNTokenContract(true);
        const amountWei = ethers.utils.parseEther(amount.toString());
        
        // Estimate gas first for forwarding
        // const gasEstimate = await window.walletUtils.estimateApproveGas(
        //     window.COINFINANCE_CONFIG.contracts.cfnToken,
        //     spenderAddress,
        //     amountWei
        // );
        
        // // Show gas estimation to user
        // const confirmed = await window.uiUtils.showConfirmAlert(
        //     `Approve ${amount} USDT for ${window.walletUtils.formatAddress(spenderAddress)}?\n\nEstimated gas cost: ${gasEstimate.costInEth} DEV`,
        //     'Confirm Approval',
        //     'Approve',
        //     'Cancel'
        // );
        
        // if (!confirmed) {
        //     console.log('❌ Approval cancelled by user');
        //     return null;
        // }
        
        window.uiUtils.showLoadingAlert('Processing approval...');
        
        // Execute approval
        const tx = await contract.approve(spenderAddress, amountWei);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Approval Submitted');
        
        console.log('🔄 Approval transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Successfully approved ${amount} USDT!`);
        
        console.log('✅ Approval confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'USDT Approval',
            { spender: spenderAddress, amount, txHash: tx.hash, receipt },
            `
CREATE TABLE cfn_approvals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    owner_address VARCHAR(42) NOT NULL,
    spender_address VARCHAR(42) NOT NULL,
    amount DECIMAL(20,8) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    block_number BIGINT,
    gas_used BIGINT,
    status ENUM('pending', 'confirmed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            `
        );
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ USDT approval failed:', error);
        window.uiUtils.logTransactionError(error, 'USDT Approval');
        window.uiUtils.showRevertAlert(error, 'Approval Failed');
        throw error;
    }
}

/**
 * Vérifie l'allowance USDT
 */
async function getCFNAllowance(ownerAddress, spenderAddress) {
    console.log(`🔍 Checking USDT allowance: ${ownerAddress} -> ${spenderAddress}`);
    
    try {
        const contract = getCFNTokenContract();
        const allowance = await contract.allowance(ownerAddress, spenderAddress);
        const formattedAllowance = ethers.utils.formatEther(allowance);
        
        console.log(`📊 USDT allowance: ${formattedAllowance} USDT`);
        
        return {
            raw: allowance,
            formatted: formattedAllowance,
            display: parseFloat(formattedAllowance).toFixed(2)
        };
        
    } catch (error) {
        console.error('❌ Error checking USDT allowance:', error);
        throw error;
    }
}

/**
 * Faucet USDT pour le testnet (fonction de test uniquement)
 */
async function requestCFNFromFaucet(recipient, amount) {
    console.log(`🚰 Demande de ${amount} USDT depuis le faucet pour ${recipient}...2`);
    if (!window.walletUtils.isWalletReady()) throw new Error('Wallet not connected');
    if (!ethers.utils.isAddress(recipient)) throw new Error('Adresse destinataire invalide');

    // Validation stricte du montant
    if (isNaN(parseFloat(amount)) || !isFinite(amount)) {
        throw new Error('Le montant doit être un nombre valide');
    }
    
    // Conversion sécurisée
    let amountWei;
    try {
        amountWei = ethers.utils.parseEther(amount.toString());
    } catch (e) {
        throw new Error('Montant invalide: ' + e.message);
    }

    const contract = getCFNTokenContract();
    const owner = await contract.owner();
    const current = await window.walletUtils.getCurrentWalletAddress();
    if (owner.toLowerCase() !== current.toLowerCase()) throw new Error('Seul le propriétaire peut mint');

    const confirmed = await window.uiUtils.showConfirmAlert(
        `Mint ${amount} USDT vers ${window.walletUtils.formatAddress(recipient)}?`,
        'Confirmation Mint', 'Mint Tokens', 'Annuler'
    );
    if (!confirmed) return null;

    window.uiUtils.showLoadingAlert('Mint en cours...');
    const contractSigner = getCFNTokenContract(true);
    const tx = await contractSigner.mint(recipient, amountWei);
    window.uiUtils.hideLoadingAlert();
    window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Mint soumis');

    await tx.wait();
    window.uiUtils.hideLoadingAlert();
    window.uiUtils.showSuccessAlert(`${amount} USDT mintés !`);

    if (recipient.toLowerCase() === current.toLowerCase()) await window.uiUtils.updateTokenBalance();
    return tx;
}


/**
 * Burn des tokens USDT (détruire)
 */
async function burnCFN(amount) {
    console.log(`🔥 Burning ${amount} USDT...`);
    
    if (!window.walletUtils.isWalletReady()) {
        throw new Error('Wallet not connected');
    }
    
    try {
        // Validation
        if (!window.uiUtils.isValidAmount(amount)) {
            throw new Error('Invalid amount');
        }
        
        // Check balance
        const userAddress = window.walletUtils.getCurrentWalletAddress();
        const balance = await getCFNBalance(userAddress);
        
        if (parseFloat(balance.formatted) < parseFloat(amount)) {
            throw new Error('Insufficient USDT balance');
        }
        
        // Confirmation
        const confirmed = await window.uiUtils.showConfirmAlert(
            `Burn ${amount} USDT tokens?\n\nThis action cannot be undone!`,
            'Confirm Burn',
            'Burn Tokens',
            'Cancel'
        );
        
        if (!confirmed) {
            console.log('❌ Burn cancelled by user');
            return null;
        }
        
        window.uiUtils.showLoadingAlert('Burning tokens...');
        
        const contract = getCFNTokenContract(true);
        const amountWei = ethers.utils.parseEther(amount.toString());
        
        // Execute burn
        const tx = await contract.burn(amountWei);
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showTransactionAlert(tx.hash, 'moonbase', 'Burn Submitted');
        
        console.log('🔄 Burn transaction submitted:', tx.hash);
        
        // Wait for confirmation
        window.uiUtils.showLoadingAlert('Waiting for confirmation...');
        const receipt = await tx.wait();
        
        window.uiUtils.hideLoadingAlert();
        window.uiUtils.showSuccessAlert(`Successfully burned ${amount} USDT!`);
        
        console.log('✅ Burn confirmed:', receipt);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'USDT Burn',
            { amount, txHash: tx.hash, receipt }
        );
        
        // Update UI balance
        await window.uiUtils.updateTokenBalance();
        
        return receipt;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ USDT burn failed:', error);
        window.uiUtils.logTransactionError(error, 'USDT Burn');
        window.uiUtils.showRevertAlert(error, 'Burn Failed');
        throw error;
    }
}

/**
 * Vérifie si l'utilisateur a assez de USDT pour une transaction
 */
async function checkCFNBalance(requiredAmount, userAddress = null) {
    try {
        const address = userAddress || window.walletUtils.getCurrentWalletAddress();
        const balance = await getCFNBalance(address);
        
        const hasEnough = parseFloat(balance.formatted) >= parseFloat(requiredAmount);
        
        console.log(`💰 USDT Balance check: ${balance.formatted} USDT >= ${requiredAmount} USDT = ${hasEnough}`);
        
        return {
            hasEnough,
            balance: balance.formatted,
            required: requiredAmount,
            difference: parseFloat(balance.formatted) - parseFloat(requiredAmount)
        };
        
    } catch (error) {
        console.error('❌ Error checking USDT balance:', error);
        throw error;
    }
}

// Export functions for global use
window.stablecoinCFN = {
    getCFNTokenContract,
    getStablecoinInfo,
    getCFNBalance,
    transferCFN,
    approveCFN,
    getCFNAllowance,
    requestCFNFromFaucet,
    burnCFN,
    checkCFNBalance
};

console.log('🪙 USDT Token utilities loaded successfully');