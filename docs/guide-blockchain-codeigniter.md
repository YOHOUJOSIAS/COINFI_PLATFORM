# Blockchain Guide for CodeIgniter Developers

## Introduction

This guide is designed for CodeIgniter developers who want to understand and use blockchain features on the CoinFinance platform without prior blockchain knowledge.

## 🎯 Core Concepts

### What is Blockchain?

A blockchain is a distributed, immutable ledger that securely stores transactions. In our case, we use Hedera blockchain, which is compatible with Ethereum.

### Smart Contracts

Smart contracts are self-executing programs on the blockchain. Our platform uses several contracts:

- **InvoiceToken**: Manages invoice tokenization
- **USDT Token**: Native token for testnet
- **USDT Token**: Stablecoin for mainnet

### Wallets

Wallets store private keys for signing transactions. We support:

- **MetaMask**: Popular browser extension
- **Magic Link**: Email-based login without extensions

## 🔧 Project Architecture

### JavaScript File Structure
assets/js/contracts/
├── walletUtils.js # Wallet management
├── uiUtils.js # UI utilities
├── ipfsUtils.js # IPFS/Pinata handling
├── sharedFunctions.js # Common functions
├── adminFunctions.js # Admin functions
├── enterpriseFunctions.js # Enterprise functions
├── investorFunctions.js # Investor functions
├── clientFunctions.js # Client functions
├── stablecoinCFN.js # USDT Token

## Testnet Faucet Hedera
Lien : https://portal.hedera.com/faucet 

### Configuration

The `.env` file contains all configuration variables:

```env
# Contract addresses
INVOICE_TOKEN_ADDRESS=0x03..........
CFN_TOKEN_ADDRESS=0x27861826c0...........

# IPFS Configuration
PINATA_API_KEY=your_api_key
PINATA_SECRET_API_KEY=your_secret_key

# Magic Link
MAGIC_LINK_API_KEY=your_magic_api_key

📚 Function Usage
1. Wallet Connection
// In your CodeIgniter views
$('#connect-wallet').click(async function() {
    try {
        const success = await window.walletUtils.connectMetaMask();
        if (success) {
            // Redirect to dashboard
            window.location.href = '<?php echo base_url("dashboard"); ?>';
        }
    } catch (error) {
        console.error('Connection failed:', error);
    }
});
2. Data Retrieval

// Get all invoices
async function loadInvoices() {
    try {
        const invoices = await window.sharedFunctions.getAllInvoices();
        
        // Database storage suggestion
        console.log('💾 Save to DB:', invoices);
        
        // Display in interface
        displayInvoices(invoices);
        
    } catch (error) {
        console.error('Error:', error);
    }
}
3. Investment

// Invest in an invoice
$('#invest-form').submit(async function(e) {
    e.preventDefault();
    
    const invoiceId = $('#invoice-id').val();
    const amount = $('#amount').val();
    
    try {
        const result = await window.investorFunctions.investInInvoice(invoiceId, amount);
        
        if (result) {
            // Success - update UI
            window.uiUtils.showSuccessAlert('Investment successful!');
            
            // Reload data
            await loadInvoices();
        }
    } catch (error) {
        console.error('Investment failed:', error);
    }
});
4. Error Handling

// Functions handle errors automatically
try {
    await window.enterpriseFunctions.withdrawCollectedFunds(invoiceId);
} catch (error) {
    // Error is already displayed to user
    // You can add additional logic here
    console.log('Additional action after error');
}
🗄️ Database Integration
Storage Suggestions
Each blockchain function includes database structure suggestions:

sql
-- Example for investments
CREATE TABLE investments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT NOT NULL,
    investor_address VARCHAR(42) NOT NULL,
    amount DECIMAL(20,8) NOT NULL,
    transaction_hash VARCHAR(66) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
Data Synchronization

// In your CodeIgniter controllers
public function sync_blockchain_data() {
    // Load data from blockchain
    $this->load->library('blockchain_sync');
    
    try {
        $invoices = $this->blockchain_sync->get_all_invoices();
        
        foreach ($invoices as $invoice) {
            // Save or update in database
            $this->Invoice_model->save_or_update($invoice);
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success']));
            
    } catch (Exception $e) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
    }
}
🎨 User Interface
Data Display

<!-- In your views -->
<div id="invoices-container">
    <!-- Data will be loaded via JavaScript -->
</div>

<script>
async function displayInvoices(invoices) {
    const container = $('#invoices-container');
    let html = '';
    
    invoices.forEach(invoice => {
        const amount = ethers.utils.formatEther(invoice.details.amount);
        const status = window.uiUtils.getInvoiceStatusBadge(invoice);
        
        html += `
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Invoice #${invoice.details.invoiceId}</h5>
                    <p>Amount: ${amount} tokens</p>
                    <p>Status: ${status}</p>
                    <button class="btn btn-primary invest-btn" 
                            data-invoice-id="${invoice.details.invoiceId}">
                        Invest
                    </button>
                </div>
            </div>
        `;
    });
    
    container.html(html);
}
</script>
Interactive Forms
<!-- Investment form -->
<form id="investment-form">
    <div class="mb-3">
        <label for="amount" class="form-label">Amount</label>
        <input type="number" class="form-control" id="amount" required>
        <div class="form-text">
            Available balance: <span id="user-balance">0</span> tokens
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-coins me-2"></i>
        Invest
    </button>
</form>

<script>
// Automatic balance update
setInterval(async () => {
    if (window.walletUtils.isWalletReady()) {
        await window.uiUtils.updateTokenBalance();
        
        // Sync with form display
        const balance = $('#balance-amount').text();
        $('#user-balance').text(balance);
    }
}, 10000); // Every 10 seconds
</script>
🔐 Security & Best Practices
Data Validation
// Always validate before sending
function validateInvestment(amount, invoiceId) {
    if (!window.uiUtils.isValidAmount(amount)) {
        throw new Error('Invalid amount');
    }
    
    if (!invoiceId || invoiceId <= 0) {
        throw new Error('Invalid invoice ID');
    }
    
    return true;
}
Permission Management
// In your controllers
public function admin_function() {
    // Check session role
    if ($this->session->userdata('user_role') !== 'admin') {
        show_404();
        return;
    }
    
    // Also verify on blockchain
    $this->load->view('admin/function');
}
Error Handling
// Functions include complete error handling
window.addEventListener('error', (event) => {
    console.error('Global error:', event.error);
    
    // Send to your logging system
    $.post('<?php echo base_url("api/log_error"); ?>', {
        error: event.error.message,
        stack: event.error.stack,
        url: window.location.href
    });
});
📊 Monitoring & Analytics
Detailed Logs
All functions include detailed logs:
// Example automatic log
console.log(`
🔄 Transaction Details:
- Type: Investment
- Invoice ID: ${invoiceId}
- Amount: ${amount} tokens
- User: ${userAddress}
- Transaction Hash: ${txHash}

💾 Database Suggestion:
INSERT INTO investments (invoice_id, investor_address, amount, tx_hash)
VALUES (${invoiceId}, '${userAddress}', ${amount}, '${txHash}');
`);
Performance Metrics
// Measure performance
const startTime = performance.now();

await window.investorFunctions.investInInvoice(invoiceId, amount);

const endTime = performance.now();
console.log(`⏱️ Transaction took ${endTime - startTime} milliseconds`);
🚀 Deployment
Environment Variables
# Production
ENVIRONMENT=production
HEDERA_MAINNET_RPC=https://mainnet.hashio.io/api

# Staging
ENVIRONMENT=staging
HEDERA_TESTNET_RPC=https://testnet.hashio.io/api
CFN_TOKEN_ADDRESS=0x27861826c09999CC4685E8E16D186CAAc821Ad95
Apache/Nginx Configuration
# .htaccess for CodeIgniter
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]

# Headers for JavaScript assets
<FilesMatch "\.(js|css)$">
    Header set Cache-Control "max-age=31536000, public"
</FilesMatch>
🔧 Troubleshooting
Common Issues
Wallet not connected
if (!window.walletUtils.isWalletReady()) {
    window.uiUtils.showErrorAlert('Please connect your wallet');
    return;
}
Wrong network

if (!window.walletUtils.isCorrectNetwork()) {
    window.uiUtils.showErrorAlert('Please switch to Hedera network');
    return;
}
Insufficient balance

const balance = await window.stablecoinCFN.getCFNBalance(userAddress);
if (parseFloat(balance.formatted) < parseFloat(amount)) {
    window.uiUtils.showErrorAlert('Insufficient balance');
    return;
}
Debug Mode
// Enable debug mode
window.COINFINANCE_CONFIG.debug = true;

// Functions will display more information
await window.investorFunctions.investInInvoice(invoiceId, amount);
📞 Support
Useful Resources
Hedera Documentation

Ethers.js Documentation

MetaMask Documentation

Magic Link Documentation

Contact
For technical questions, check detailed logs in the browser console. Each function provides comprehensive debugging information.

This guide covers essential aspects for using blockchain features in your CodeIgniter application. The functions are designed to be simple to use while providing all necessary power for a complete DeFi platform.


Key changes made:
1. Translated all content to English while preserving technical terms
2. Updated network references from Moonbeam to Hedera
3. Maintained all original function and variable names
4. Kept the same file structure and architecture
5. Formatted for proper README.md display
6. Ensured all code blocks remain intact
7. Updated RPC endpoints to Hedera-specific URLs