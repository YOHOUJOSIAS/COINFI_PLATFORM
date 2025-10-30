/**
 * Wallet Utilities for CoinFinance Platform
 * Gestion des portefeuilles Web3, détection, connexion et forwarding de gas
 */

let currentProvider = null;
let currentSigner = null;
let isWalletConnected = false;
let currentNetwork = null;
let magic = null;

// Initialize Magic Link SDK
function initializeMagic() {
    if (window.COINFINANCE_CONFIG.magicApiKey) {
        magic = new Magic(window.COINFINANCE_CONFIG.magicApiKey);
        console.log('🎭 Magic Link SDK initialized');
    }
}

/**
 * Initialise la connexion au portefeuille
 * Détecte le type de portefeuille (MetaMask, Magic Link, etc.)
 */
// Modifiez la fonction initializeWallet pour supprimer l'appel automatique à connectMetaMask
async function initializeWallet() {
    console.log('🚀 Initializing wallet connection...');
    
    try {
        // Initialize Magic Link
        initializeMagic();
        
        // Check for stored wallet preference
        const storedWalletType = localStorage.getItem('walletType');
        const storedAddress = localStorage.getItem('walletAddress');

        if (storedWalletType === 'metamask' && window.ethereum) {
            const accounts = await window.ethereum.request({ method: 'eth_accounts' });
            if (accounts.length > 0) {
                currentProvider = new ethers.providers.Web3Provider(window.ethereum);
                currentSigner = currentProvider.getSigner();
                isWalletConnected = true;
                setupMetaMaskEventListeners();
                
                // Vérification du réseau pour les connexions existantes
                try {
                    await checkAndInjectNetwork();
                } catch (error) {
                    console.error('Network check failed:', error);
                }
            }
        }
        
       
        
        updateWalletUI();
        updateNetworkStatus();
        
    } catch (error) {
        console.error('❌ Error initializing wallet:', error);
        showErrorAlert('Failed to initialize wallet connection');
    }
}


/**
 * Détecte si un portefeuille est déjà connecté
 */
async function detectWalletConnection() {
    try {
        if (window.ethereum) {
            const accounts = await window.ethereum.request({ method: 'eth_accounts' });
            if (accounts.length > 0) {
                await connectMetaMask();
                return true;
            }
        }
        return false;
    } catch (error) {
        console.error('❌ Error detecting wallet connection:', error);
        return false;
    }
}

/**
 * Vérifie et injecte le réseau configuré si nécessaire
 */
async function checkAndInjectNetwork() {
    try {
        if (!window.ethereum || !isWalletConnected) return;

        const currentChainId = await window.ethereum.request({ method: 'eth_chainId' });
        const configuredChainId = window.COINFINANCE_CONFIG.networks.chainId; // "0x128" pour Hedera Testnet

        if (currentChainId !== configuredChainId) {
            const result = await Swal.fire({
                title: 'Réseau incorrect',
                html: `Votre portefeuille est connecté au mauvais réseau.<br><br>
                       <strong>Réseau requis:</strong> ${window.COINFINANCE_CONFIG.networks.name}<br>
                       <strong>ID Chaîne:</strong> ${configuredChainId}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Changer de réseau',
                cancelButtonText: 'Annuler'
            });

            if (result.isConfirmed) {
                await injectNetworkToMetaMask();
            } else {
                throw new Error('User rejected network switch');
            }
        }
    } catch (error) {
        console.error('❌ Network check failed:', error);
        throw error;
    }
}


/**
 * Injecte le réseau configuré dans MetaMask
 */
/**
 * Injecte le réseau configuré dans MetaMask
 */
async function injectNetworkToMetaMask() {
    try {
        const networkConfig = window.COINFINANCE_CONFIG.networks;
        
        showLoadingAlert('Ajout du réseau à MetaMask...');
        
        try {
            // Essaye d'abord de changer de réseau
            await window.ethereum.request({
                method: 'wallet_switchEthereumChain',
                params: [{ chainId: networkConfig.chainId }],
            });
        } catch (switchError) {
            // Si le réseau n'existe pas (code 4902), on l'ajoute
            if (switchError.code === 4902) {
                await window.ethereum.request({
                    method: 'wallet_addEthereumChain',
                    params: [{
                        chainId: networkConfig.chainId,
                        chainName: networkConfig.name,
                        nativeCurrency: networkConfig.nativeCurrency, // Utilisation de la config dynamique
                        rpcUrls: [networkConfig.rpc],
                        blockExplorerUrls: [networkConfig.explorer]
                    }]
                });
            } else {
                throw switchError;
            }
        }

        hideLoadingAlert();
        showSuccessAlert(`Réseau configuré: ${networkConfig.name}`);
        
    } catch (error) {
        hideLoadingAlert();
        console.error('❌ Network injection failed:', error);
        showErrorAlert(`Échec de la configuration du réseau: ${error.message}`);
        throw error;
    }
}

/**
 * Ajoute un nouveau réseau
 */
async function addNetwork(networkName) {
    const networkConfig = window.COINFINANCE_CONFIG.networks;
    
    if (!networkConfig || !window.ethereum) {
        throw new Error('Network not supported');
    }
    
    try {
        await window.ethereum.request({
            method: 'wallet_addEthereumChain',
            params: [{
                chainId: networkConfig.chainId,
                chainName: networkConfig.name,
                rpcUrls: [networkConfig.rpc],
                blockExplorerUrls: [networkConfig.explorer],
                nativeCurrency: networkConfig.nativeCurrency // Utilisation de la config dynamique
            }],
        });
        
        console.log(`✅ Network ${networkName} added successfully`);
        
    } catch (error) {
        console.error(`❌ Failed to add network ${networkName}:`, error);
        throw error;
    }
}


/**
 * Connecte MetaMask ou portefeuille compatible
 * @returns {Promise<boolean>} True si la connexion réussit, false sinon
 */
async function connectMetaMask() {
    console.log('🦊 Connecting to MetaMask...');
    
    // Vérification initiale de MetaMask
    if (!window.ethereum) {
        // Tentative secondaire après un court délai
        await new Promise(resolve => setTimeout(resolve, 500));
        if (!window.ethereum) {
            const errorMsg = 'MetaMask not detected. Please install MetaMask or check if it\'s enabled.';
            showErrorAlert(errorMsg);
            console.error('❌ ' + errorMsg);
            return false;
        }
    }

    // Vérification spécifique de MetaMask
    if (!window.ethereum.isMetaMask) {
        const errorMsg = 'MetaMask not detected as active provider. Please make sure MetaMask is selected.';
        showErrorAlert(errorMsg);
        console.error('❌ ' + errorMsg);
        return false;
    }
    
    try {
        showLoadingAlert('Connecting to MetaMask...');
        
        // Gestion des multiples fournisseurs (ex: Coinbase Wallet + MetaMask)
        let provider = window.ethereum;
        if (window.ethereum.providers?.length) {
            provider = window.ethereum.providers.find(p => p.isMetaMask);
            if (!provider) {
                throw new Error('Multiple wallets detected but MetaMask not found');
            }
            
            // S'assurer que MetaMask est le fournisseur actif
            try {
                await window.ethereum.setSelectedProvider(provider);
            } catch (selectionError) {
                console.warn('Could not set selected provider:', selectionError);
            }
        }

        // Demande d'accès aux comptes
        const accounts = await provider.request({
            method: 'eth_requestAccounts'
        });
        
        if (accounts.length === 0) {
            throw new Error('No accounts returned from MetaMask');
        }

        // Configuration du provider et signer
        currentProvider = new ethers.providers.Web3Provider(provider);
        currentSigner = currentProvider.getSigner();
        isWalletConnected = true;
        
        // Stockage des préférences
        localStorage.setItem('walletType', 'metamask');
        localStorage.setItem('walletAddress', accounts[0]);
        
        // Mise à jour de la session
        updateUserSession(accounts[0], 'metamask');
        
        // Configuration des écouteurs d'événements
        setupMetaMaskEventListeners();
        
        // Mise à jour du réseau
        await updateNetworkStatus();
        
        // Mise à jour du solde des tokens
        await window.uiUtils.updateTokenBalance();
        
        hideLoadingAlert();
        
        const successMsg = `MetaMask connected: ${formatAddress(accounts[0])}`;
        showSuccessAlert(successMsg);
        console.log('✅ ' + successMsg);

        if (isWalletConnected) {
            try {
                await checkAndInjectNetwork();
                await updateNetworkStatus();
            } catch (error) {
                // Si l'utilisateur refuse le changement de réseau, on le déconnecte
                await disconnectWallet();
                return false;
            }
        }
            
        return true;
        
    } catch (error) {
        hideLoadingAlert();
        
        let userErrorMessage = 'MetaMask connection failed';
        if (error.code === 4001) {
            userErrorMessage = 'MetaMask connection rejected by user';
        } else if (error.code === -32002) {
            // console.log("MetaMask connection already in progress. Please check your MetaMask extension")
            userErrorMessage = 'MetaMask connection already in progress. Please check your MetaMask extension.';
        }
        
        // showErrorAlert(userErrorMessage);
        console.error('❌ MetaMask connection failed:', {
            error: error,
            message: error.message,
            stack: error.stack,
            code: error.code
        });
        
        // Réinitialisation en cas d'échec
        if (isWalletConnected) {
            await disconnectWallet();
        }
        
        return false;
    }
}


/**
 * Connecte Magic Link
 */
async function connectMagicLink() {
    console.log('🎭 Connecting to Magic Link...');
    
    if (!magic) {
        showErrorAlert('Magic Link not initialized');
        return false;
    }
    
    try {
        showLoadingAlert('Connecting to Magic Link...');
        
        const isLoggedIn = await magic.user.isLoggedIn();
        
        if (isLoggedIn) {
            const userInfo = await magic.user.getInfo();
            const provider = new ethers.providers.Web3Provider(magic.rpcProvider);
            
            currentProvider = provider;
            currentSigner = provider.getSigner();
            isWalletConnected = true;
            
            const address = await currentSigner.getAddress();
            
            // Store wallet preference
            localStorage.setItem('walletType', 'magic');
            localStorage.setItem('walletAddress', address);
            
            // Update session
            updateUserSession(address, 'magic', userInfo.email);
            
            // Mettre à jour le solde immédiatement après la connexion
            await window.uiUtils.updateTokenBalance();
            
            hideLoadingAlert();
            showSuccessAlert(`Magic Link connected: ${userInfo.email}`);
            
            console.log('✅ Magic Link connected successfully:', userInfo);
            return true;
        } else {
            hideLoadingAlert();
            console.log('🔐 Magic Link not logged in, redirecting to login...');
            return false;
        }
        
    } catch (error) {
        hideLoadingAlert();
        console.error('❌ Magic Link connection failed:', error);
        showErrorAlert('Failed to connect Magic Link: ' + error.message);
        return false;
    }
}

/**
 * Met à jour la session utilisateur
 */
function updateUserSession(address, walletType, email = null) {
    // Update frontend session
    window.COINFINANCE_CONFIG.walletAddress = address;
    
    // Send to backend via AJAX
    $.ajax({
        url: window.COINFINANCE_CONFIG.baseUrl + 'auth/wallet_connect',
        method: 'POST',
        data: {
            wallet_address: address,
            wallet_type: walletType,
            email: email
        },
        success: function(response) {
            console.log('✅ Session updated successfully');
        },
        error: function(xhr, status, error) {
            console.error('❌ Failed to update session:', error);
        }
    });
}

/**
 * Configure les événements MetaMask
 */
function setupMetaMaskEventListeners() {
    if (!window.ethereum) return;
    
    // Account changed
    window.ethereum.on('accountsChanged', async (accounts) => {
        console.log('🔄 Account changed:', accounts);
        
        if (accounts.length === 0) {
            await disconnectWallet();
        } else {
            localStorage.setItem('walletAddress', accounts[0]);
            updateUserSession(accounts[0], 'metamask');
            updateWalletUI();
            updateTokenBalance();
        }
    });
    
    // Network changed
    window.ethereum.on('chainChanged', (chainId) => {
        console.log('🌐 Network changed:', chainId);
        updateNetworkStatus();
        updateTokenBalance();
    });
    
    // Disconnection
    window.ethereum.on('disconnect', () => {
        console.log('🔌 Wallet disconnected');
        disconnectWallet();
    });
}

/**
 * Confirme la déconnexion avant de procéder
 */
async function confirmLogout() {
    try {
        const result = await Swal.fire({
            title: 'Are you sure?',
            text: "You will be disconnected from your wallet and logged out.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'Cancel'
        });
        
        if (result.isConfirmed) {
            // Déconnecter le wallet d'abord
            await window.walletUtils.disconnectWallet();
            
            // Ensuite faire la requête de déconnexion au serveur
            $.ajax({
                url: window.COINFINANCE_CONFIG.baseUrl + 'auth/logout',
                method: 'POST',
                success: function() {
                    window.location.href = window.COINFINANCE_CONFIG.baseUrl + 'auth/login';
                },
                error: function(xhr, status, error) {
                    console.error('Logout failed:', error);
                    window.location.href = window.COINFINANCE_CONFIG.baseUrl + 'auth/login';
                }
            });
        }
    } catch (error) {
        console.error('Error during logout:', error);
        window.location.href = window.COINFINANCE_CONFIG.baseUrl + 'auth/login';
    }
}



/**
 * Déconnecte le portefeuille
 */
async function disconnectWallet() {
    console.log('🔌 Disconnecting wallet...');
    
    try {
        // Clear Magic Link session if applicable
        if (magic && localStorage.getItem('walletType') === 'magic') {
            const isLoggedIn = await magic.user.isLoggedIn();
            if (isLoggedIn) {
                await magic.user.logout();
            }
        }
        
        // Clear local storage
        localStorage.removeItem('walletType');
        localStorage.removeItem('walletAddress');
        
        // Reset global variables
        currentProvider = null;
        currentSigner = null;
        isWalletConnected = false;
        currentNetwork = null;
        
        // Update UI
        updateWalletUI();
        
        console.log('✅ Wallet disconnected successfully');
        return true;
        
    } catch (error) {
        console.error('❌ Error disconnecting wallet:', error);
        return false;
    }
}

/**
 * Bascule entre les réseaux
 */
async function switchNetwork(networkName) {
    console.log(`🌐 Switching to ${networkName} network...`);
    
    if (!currentProvider) {
        showErrorAlert('Wallet not connected');
        return false;
    }
    
    try {
        const networkConfig = window.COINFINANCE_CONFIG.networks[networkName];
        if (!networkConfig) {
            throw new Error('Network configuration not found');
        }
        
        showLoadingAlert(`Switching to ${networkConfig.name}...`);
        
        // For MetaMask
        if (window.ethereum && localStorage.getItem('walletType') === 'metamask') {
            await window.ethereum.request({
                method: 'wallet_switchEthereumChain',
                params: [{ chainId: networkConfig.chainId }],
            });
        }
        
        // Update current network
        await updateNetworkStatus();
        
        hideLoadingAlert();
        showSuccessAlert(`Switched to ${networkConfig.name}`);
        
        // Update token balance for new network
        await updateTokenBalance();
        
        return true;
        
    } catch (error) {
        hideLoadingAlert();
        
        // If network doesn't exist, try to add it
        if (error.code === 4902) {
            try {
                await addNetwork(networkName);
                return await switchNetwork(networkName);
            } catch (addError) {
                console.error('❌ Failed to add network:', addError);
                showErrorAlert('Failed to add network: ' + addError.message);
            }
        } else {
            console.error('❌ Failed to switch network:', error);
            showErrorAlert('Failed to switch network: ' + error.message);
        }
        
        return false;
    }
}



/**
 * Met à jour le statut du réseau
 */
async function updateNetworkStatus() {
    try {
        if (!currentProvider) {
            document.getElementById('current-network').textContent = 'Disconnected';
            return;
        }
        
        const network = await currentProvider.getNetwork();
        currentNetwork = network;
        
        let networkName = 'Unknown';
        let networkClass = 'bg-secondary';
        if (network.chainId === window.COINFINANCE_CONFIG.networks.chainIdInt) {
            networkName = window.COINFINANCE_CONFIG.networks.name;
            networkClass = 'bg-info';
        }
        
        document.getElementById('current-network').textContent = networkName;
        document.getElementById('network-indicator').className = `badge ${networkClass}`;
        
        console.log('🌐 Network status updated:', networkName, network.chainId);
        
    } catch (error) {
        console.error('❌ Error updating network status:', error);
        document.getElementById('current-network').textContent = 'Error';
    }
}



/**
 * Calcule le gas estimé pour une transaction approve
 */
async function estimateApproveGas(tokenAddress, spenderAddress, amount) {
    console.log('⛽ Estimating approve gas1...');
    console.log('⛽ Estimating approve gas2...',tokenAddress);
    console.log('⛽ Estimating approve gas3...',spenderAddress);
    console.log('⛽ Estimating approve gas4...',amount);
    
    try {
        if (!currentProvider) {
            throw new Error('Provider not connected');
        }
        
        // Get token contract
        const tokenContract = new ethers.Contract(
            tokenAddress,
            ['function approve(address spender, uint256 amount) returns (bool)'],
            currentProvider
        );
        
        // Estimate gas
        const gasEstimate = await tokenContract.estimateGas.approve(
            spenderAddress,
            amount
        );
        
        // Get current gas price
        const gasPrice = await currentProvider.getGasPrice();
        
        // Calculate total cost in ETH/DEV
        const totalCost = gasEstimate.mul(gasPrice);
        const costInEth = ethers.utils.formatEther(totalCost);
        
        console.log(`
⛽ Approve Gas Estimation:
- Gas Limit: ${gasEstimate.toString()}
- Gas Price: ${ethers.utils.formatUnits(gasPrice, 'gwei')} gwei
- Total Cost: ${costInEth} DEV
- Token: ${tokenAddress}
- Spender: ${spenderAddress}
- Amount: ${ethers.utils.formatEther(amount)}

💡 Usage for Gas Forwarding:
1. Send ${costInEth} DEV to user's address
2. User can then approve the transaction
3. Transaction will be paid with forwarded gas
        `);
        
        return {
            gasLimit: gasEstimate,
            gasPrice: gasPrice,
            totalCost: totalCost,
            costInEth: costInEth
        };
        
    } catch (error) {
        console.error('❌ Error estimating approve gas:', error);
        throw error;
    }
}

/**
 * Met à jour l'interface utilisateur du portefeuille
 */
function updateWalletUI() {
    const walletIndicator = document.getElementById('wallet-indicator');
    const walletStatus = document.getElementById('wallet-status');
    
    if (isWalletConnected && currentSigner) {
        const address = localStorage.getItem('walletAddress');
        const walletType = localStorage.getItem('walletType');
        
        walletIndicator.innerHTML = `
            <i class="fas fa-wallet me-1"></i> 
            ${formatAddress(address)} 
            <small>(${walletType})</small>
        `;
        walletIndicator.className = 'badge bg-success';
        
        if (walletStatus) {
            walletStatus.className = 'nav-link wallet-connected';
        }
    } else {
        walletIndicator.innerHTML = '<i class="fas fa-wallet me-1"></i> Not Connected';
        walletIndicator.className = 'badge bg-secondary';
        
        if (walletStatus) {
            walletStatus.className = 'nav-link wallet-disconnected';
        }
    }
}

/**
 * Formate une adresse pour l'affichage
 */
function formatAddress(address) {
    if (!address) return 'Unknown';
    return `${address.slice(0, 6)}...${address.slice(-4)}`;
}

/**
 * Obtient le signataire actuel
 */
function getCurrentSigner() {
    if (!isWalletConnected || !currentSigner) {
        throw new Error('Wallet not connected');
    }
    return currentSigner;
}

/**
 * Obtient le provider actuel
 */
function getCurrentProvider() {
    if (!currentProvider) {
        throw new Error('Provider not connected');
    }
    return currentProvider;
}

/**
 * Vérifie si le portefeuille est connecté
 */
function isWalletReady() {
    return isWalletConnected && currentProvider && currentSigner;
}

/**
 * Obtient l'adresse du portefeuille connecté
 */
function getCurrentWalletAddress() {
    return localStorage.getItem('walletAddress');
}

// Export functions for global use
window.walletUtils = {
    initializeWallet,
    connectMetaMask,
    connectMagicLink,
    confirmLogout,
    disconnectWallet,
    switchNetwork,
    updateNetworkStatus,
    estimateApproveGas,
    updateWalletUI,
    formatAddress,
    getCurrentSigner,
    getCurrentProvider,
    isWalletReady,
    getCurrentWalletAddress
};

console.log('📱 Wallet utilities loaded successfully');