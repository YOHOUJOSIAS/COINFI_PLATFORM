/**
 * UI Utilities for CoinFinance Platform
 * Gestion des alertes, loaders, et interactions utilisateur
 */

/**
 * Affiche une alerte de succès avec SweetAlert2
 */
function showSuccessAlert(message, title = 'Success!') {
    Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        background: '#1e1e1e',
        color: '#ffffff',
        iconColor: '#28a745'
    });
    
    console.log('✅ Success:', message);
}

/**
 * Affiche une alerte d'erreur avec SweetAlert2
 */
function showErrorAlert(message, title = 'Error!') {
    Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        confirmButtonText: 'OK',
        confirmButtonColor: '#ff8c00',
        background: '#1e1e1e',
        color: '#ffffff',
        iconColor: '#dc3545'
    });
    
    console.error('❌ Error:', message);
}

/**
 * Affiche une alerte d'avertissement
 */
function showWarningAlert(message, title = 'Warning!') {
    Swal.fire({
        icon: 'warning',
        title: title,
        text: message,
        confirmButtonText: 'OK',
        confirmButtonColor: '#ff8c00',
        background: '#1e1e1e',
        color: '#ffffff',
        iconColor: '#ffc107'
    });
    
    console.warn('⚠️ Warning:', message);
}

/**
 * Affiche une alerte d'information
 */
function showInfoAlert(message, title = 'Information') {
    Swal.fire({
        icon: 'info',
        title: title,
        text: message,
        confirmButtonText: 'OK',
        confirmButtonColor: '#ff8c00',
        background: '#1e1e1e',
        color: '#ffffff',
        iconColor: '#17a2b8'
    });
    
    console.log('ℹ️ Info:', message);
}

/**
 * Affiche un loader de chargement
 */
function showLoadingAlert(message = 'Processing...', title = 'Please wait') {
    Swal.fire({
        icon: 'info',
        title: title,
        text: message,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
        background: '#1e1e1e',
        color: '#ffffff'
    });
    
    console.log('⏳ Loading:', message);
}

/**
 * Cache le loader de chargement
 */
function hideLoadingAlert() {
    Swal.close();
}

/**
 * Affiche une alerte de confirmation
 */
async function showConfirmAlert(message, title = 'Are you sure?', confirmText = 'Yes', cancelText = 'Cancel') {
    const result = await Swal.fire({
        icon: 'question',
        title: title,
        text: message,
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        confirmButtonColor: '#ff8c00',
        cancelButtonColor: '#6c757d',
        background: '#1e1e1e',
        color: '#ffffff',
        iconColor: '#17a2b8'
    });
    
    return result.isConfirmed;
}

/**
 * Affiche une alerte de saisie utilisateur
 */
async function showInputAlert(title, placeholder, inputType = 'text') {
    const result = await Swal.fire({
        title: title,
        input: inputType,
        inputPlaceholder: placeholder,
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#ff8c00',
        cancelButtonColor: '#6c757d',
        background: '#1e1e1e',
        color: '#ffffff',
        inputValidator: (value) => {
            if (!value) {
                return 'This field is required';
            }
        }
    });
    
    return result.isConfirmed ? result.value : null;
}

/**
 * Affiche une alerte avec transaction hash
 */
function showTransactionAlert(txHash, networkName = 'moonbase', title = 'Transaction Submitted') {
    let explorerUrl = window.COINFINANCE_CONFIG.networks.explorer;
    
    Swal.fire({
        icon: 'success',
        title: title,
        html: `
            <p>Your transaction has been submitted successfully!</p>
            <p><strong>Transaction Hash:</strong></p>
            <code style="word-break: break-all; color: #ff8c00;">${txHash}</code>
            <p style="margin-top: 15px;">
                <a href="${explorerUrl}${txHash}" target="_blank" style="color: #ff8c00;">
                    View on Explorer <i class="fas fa-external-link-alt"></i>
                </a>
            </p>
        `,
        confirmButtonText: 'OK',
        confirmButtonColor: '#ff8c00',
        background: '#1e1e1e',
        color: '#ffffff'
    });
    
    console.log(`🔗 Transaction: ${explorerUrl}${txHash}`);
}

/**
 * Affiche les détails d'une transaction revert
 */
function showRevertAlert(error, title = 'Transaction Failed') {
    let message = 'Transaction was reverted by the network.';
    let details = '';
    
    // Parse error message
    if (error.message) {
        if (error.message.includes('user rejected')) {
            message = 'Transaction was rejected by user.';
        } else if (error.message.includes('insufficient funds')) {
            message = 'Insufficient funds to complete the transaction.';
        } else if (error.message.includes('revert')) {
            const revertMatch = error.message.match(/revert (.+?)"/);
            if (revertMatch) {
                details = revertMatch[1];
            }
        }
    }
    
    Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        footer: details ? `<small>Details: ${details}</small>` : '',
        confirmButtonText: 'OK',
        confirmButtonColor: '#ff8c00',
        background: '#1e1e1e',
        color: '#ffffff',
        iconColor: '#dc3545'
    });
    
    console.error('🔄 Transaction Reverted:', error);
}

/**
 * Met à jour le solde des tokens dans l'UI
 */
async function updateTokenBalance() {
    try {
        if (!window.walletUtils || !window.walletUtils.isWalletReady()) {
            // document.getElementById('balance-amount').textContent = '0';
            // document.getElementById('balance-symbol').textContent = 'USDT';
            return;
        }
        
        const provider = window.walletUtils.getCurrentProvider();
        const address = window.walletUtils.getCurrentWalletAddress();
        const network = await provider.getNetwork();
        
        let tokenAddress, tokenSymbol;
        
        // Determine which token to show based on network
        tokenAddress = window.COINFINANCE_CONFIG.contracts.cfnToken;
        tokenSymbol = 'USDT';
        
        
        if (!tokenAddress) {
            document.getElementById('balance-amount').textContent = '0';
            document.getElementById('balance-symbol').textContent = 'USDT';
            console.error('Token address not configured for this network');
            return;
        }
        
        // Get token contract
        const tokenContract = new ethers.Contract(
            tokenAddress,
            ['function balanceOf(address) view returns (uint256)'],
            provider
        );
        
        // Get balance
        const balance = await tokenContract.balanceOf(address);
        const formattedBalance = ethers.utils.formatEther(balance);
        
        // Update UI
        document.getElementById('balance-amount').textContent = parseFloat(formattedBalance).toFixed(2);
        document.getElementById('balance-symbol').textContent = tokenSymbol;
        
        console.log(`💰 Token balance updated: ${formattedBalance} ${tokenSymbol}`);
        
    } catch (error) {
        console.error('❌ Error updating token balance:', error);
        document.getElementById('balance-amount').textContent = 'Error';
        document.getElementById('balance-symbol').textContent = 'N/A';
    }
}

/**
 * Formate un montant pour l'affichage
 */
function formatAmount(amount, decimals = 18, displayDecimals = 2) {
    try {
        const formatted = ethers.utils.formatUnits(amount, decimals);
        const number = parseFloat(formatted);
        return number.toFixed(displayDecimals);
    } catch (error) {
        console.error('❌ Error formatting amount:', error);
        return '0.00';
    }
}

/**
 * Formate une date pour l'affichage
 */
function formatDate(timestamp) {
    try {
        const date = new Date(timestamp * 1000);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
    } catch (error) {
        console.error('❌ Error formatting date:', error);
        return 'Invalid Date';
    }
}

/**
 * Calcule et affiche une barre de progression
 */
function updateProgressBar(elementId, current, target, suffix = '') {
    try {
        const percentage = target > 0 ? (current / target) * 100 : 0;
        const clampedPercentage = Math.min(100, Math.max(0, percentage));
        
        const progressBar = document.getElementById(elementId);
        if (progressBar) {
            progressBar.style.width = `${clampedPercentage}%`;
            progressBar.setAttribute('aria-valuenow', clampedPercentage);
            
            // Update color based on progress
            progressBar.className = 'progress-bar';
            if (clampedPercentage >= 100) {
                progressBar.classList.add('bg-success');
            } else if (clampedPercentage >= 75) {
                progressBar.classList.add('bg-warning');
            } else {
                progressBar.classList.add('bg-primary');
            }
            
            // Update text if element exists
            const textElement = document.getElementById(elementId + '-text');
            if (textElement) {
                textElement.textContent = `${formatAmount(current)} / ${formatAmount(target)} ${suffix}`;
            }
        }
        
        console.log(`📊 Progress updated: ${clampedPercentage.toFixed(1)}%`);
        
    } catch (error) {
        console.error('❌ Error updating progress bar:', error);
    }
}

/**
 * Active/désactive un bouton avec état de chargement
 */
function toggleButtonLoading(buttonId, isLoading, loadingText = 'Processing...') {
    const button = document.getElementById(buttonId);
    if (!button) return;
    
    if (isLoading) {
        button.disabled = true;
        button.dataset.originalText = button.innerHTML;
        button.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
            ${loadingText}
        `;
    } else {
        button.disabled = false;
        button.innerHTML = button.dataset.originalText || button.innerHTML;
    }
}

/**
 * Copie du texte dans le presse-papiers
 */
async function copyToClipboard(text, successMessage = 'Copied to clipboard!') {
    try {
        await navigator.clipboard.writeText(text);
        showSuccessAlert(successMessage);
    } catch (error) {
        console.error('❌ Failed to copy to clipboard:', error);
        showErrorAlert('Failed to copy to clipboard');
    }
}

/**
 * Vérifie si une deadline est dépassée
 */
// function isDeadlinePassed(timestamp) {
//     return Date.now() / 1000 > timestamp;
// }

/**
 * Vérifie si une date est passée
 * @param {string|number} deadline - Date limite à vérifier
 * @returns {boolean} true si la date est passée
 */
function isDeadlinePassed(deadline) {
    try {
        const deadlineDate = new Date(deadline);
        const now = new Date();
        return now >= deadlineDate;
    } catch (e) {
        console.error('Error checking deadline:', e);
        return false;
    }
};
/**
 * Obtient le badge de statut pour une facture
 */
function getInvoiceStatusBadge(invoice) {
    if (invoice.financials.isPaid) {
        return '<span class="status-badge status-paid">Paid</span>';
    } else if (isDeadlinePassed(invoice.details.dueDate)) {
        return '<span class="status-badge status-overdue">Overdue</span>';
    } else if (invoice.financials.totalSupply >= invoice.details.amount) {
        return '<span class="status-badge status-funded">Funded</span>';
    } else if (invoice.details.isActive) {
        return '<span class="status-badge status-active">Active</span>';
    } else {
        return '<span class="status-badge status-inactive">Inactive</span>';
    }
}

/**
 * Console.log pédagogique avec suggestions pour les développeurs
 */
function logForDevelopers(action, data, suggestions = null) {
    console.group(`🔧 Developer Info: ${action}`);
    console.log('📊 Data:', data);
    
    if (suggestions) {
        console.log('💡 Database Storage Suggestions:');
        console.log(suggestions);
    }
    
    console.log('🕐 Timestamp:', new Date().toISOString());
    console.groupEnd();
}

/**
 * Affiche une notification toast personnalisée
 */
function showToast(message, type = 'info', duration = 3000) {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast, { delay: duration });
    bsToast.show();
    
    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

/**
 * Crée le conteneur de toast s'il n'existe pas
 */
function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'toast-container position-fixed top-0 end-0 p-3';
    container.style.zIndex = '9999';
    document.body.appendChild(container);
    return container;
}

/**
 * Valide une adresse Ethereum
 */
function isValidAddress(address) {
    return ethers.utils.isAddress(address);
}

/**
 * Valide un montant
 */
function isValidAmount(amount) {
    try {
        const parsed = ethers.utils.parseEther(amount.toString());
        return parsed.gt(0);
    } catch {
        return false;
    }
}

/**
 * Affiche les détails d'une erreur de transaction
 */
function logTransactionError(error, context = '') {
    console.group('❌ Transaction Error' + (context ? ` - ${context}` : ''));
    console.error('Error object:', error);
    
    if (error.code) {
        console.log('Error code:', error.code);
    }
    
    if (error.reason) {
        console.log('Reason:', error.reason);
    }
    
    if (error.transaction) {
        console.log('Transaction:', error.transaction);
    }
    
    if (error.receipt) {
        console.log('Receipt:', error.receipt);
    }
    
    console.groupEnd();
}

// Export functions for global use
window.uiUtils = {
    showSuccessAlert,
    showErrorAlert,
    showWarningAlert,
    showInfoAlert,
    showLoadingAlert,
    hideLoadingAlert,
    showConfirmAlert,
    showInputAlert,
    showTransactionAlert,
    showRevertAlert,
    updateTokenBalance,
    formatAmount,
    formatDate,
    updateProgressBar,
    toggleButtonLoading,
    copyToClipboard,
    isDeadlinePassed,
    getInvoiceStatusBadge,
    logForDevelopers,
    showToast,
    isValidAddress,
    isValidAmount,
    logTransactionError
};


console.log('🎨 UI utilities loaded successfully');