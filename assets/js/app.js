/**
 * Main Application JavaScript for CoinFinance Platform
 * Initialisation et fonctions globales
 */

// Global application state
window.COINFINANCE_APP = {
    initialized: false,
    currentUser: null,
    currentNetwork: null,
    currentLanguage: 'fr'
};

/**
 * Initialise l'application
 */
// app.js

/**
 * Initialise l'application de manière séquentielle et logique.
 */
async function initializeApp() {
    console.log('🚀 Initializing CoinFinance Application...');

    try {
        // 1. Initialiser la connexion au portefeuille (MetaMask, etc.)
        // C'est la première étape critique.
        await window.walletUtils.initializeWallet();

        // 2. Mettre à jour les éléments de base de l'UI qui dépendent du portefeuille
        await updateAllUIElements();

        // Force token balance update
        await window.uiUtils.updateTokenBalance();

        // 3. Mettre en place les écouteurs d'événements globaux
        setupGlobalEventListeners();

        // 4. Exécuter la logique spécifique à la page actuelle
        setupPageSpecificModules();

        // 5. Marquer l'application comme initialisée
        window.COINFINANCE_APP.initialized = true;
        console.log('✅ CoinFinance Application initialized successfully');

    } catch (error) {
        console.error('❌ Failed to initialize application:', error);
        // window.uiUtils.showErrorAlert('Failed to initialize application: ' + error.message);
    }


    
    // Démarrer le vérificateur d'échéance si admin
    if (window.walletUtils.isWalletReady()) {
        const isAdmin = await window.adminFunctions.checkAdminRole(window.walletUtils.getCurrentWalletAddress());
        if (isAdmin) {
            startDueDateChecker();
        }
    }
}

// Vérificateur d'échéance pour compensation automatique
function startDueDateChecker() {
    setInterval(async () => {
        try {
            const now = Math.floor(Date.now() / 1000);
            const invoices = await window.sharedFunctions.getAllInvoices();
            
            for (const invoice of invoices) {
                // Vérifier si la facture est en retard et non payée
                if (!invoice.financials.isPaid && 
                    now >= invoice.details.dueDate && 
                    invoice.financials.collectedAmount.gt(0)) {
                    
                    // Vérifier si la compensation n'a pas déjà été effectuée
                    const isCompensated = await window.adminFunctions.isInvoiceCompensated(invoice.details.invoiceId);
                    if (!isCompensated) {
                        console.log(`Compensating late invoice ${invoice.details.invoiceId}`);
                        await window.adminFunctions.compensateInvestors(invoice.details.invoiceId);
                    }
                }
            }
        } catch (error) {
            console.error('Error in due date checker:', error);
        }
    }, 3600000); // Vérifier toutes les heures
}

/**
 * Met à jour tous les éléments récurrents de l'interface utilisateur.
 */
async function updateAllUIElements() {
    try {
        if (!window.walletUtils.isWalletReady()) {
            console.warn("Wallet not ready, skipping some UI updates.");
        }
        window.walletUtils.updateWalletUI();
        await window.walletUtils.updateNetworkStatus();
        await window.uiUtils.updateTokenBalance();
        // updateUILanguage(); // Assurez-vous que cette fonction est définie
        console.log('✅ UI elements updated');
    } catch (error) {
        console.error('❌ Error updating UI elements:', error);
    }
}

/**
 * Détecte le module de la page actuelle et exécute le code correspondant.
 */
function setupPageSpecificModules() {
    const pageModuleElement = document.querySelector('[data-page-module]');
    const pageModule = pageModuleElement ? pageModuleElement.dataset.pageModule : null;

    console.log(`🔍 Detected page module: ${pageModule}`);

    switch (pageModule) {
        case 'admin':
            setupAdminForms();
            break;
        case 'enterprise':
            setupEnterpriseForms();
            // Charger les données spécifiques à l'entreprise
            if (window.enterpriseFunctions && window.enterpriseFunctions.loadCompanyInvoices) {
                 window.enterpriseFunctions.loadCompanyInvoices();
            }
            break;
        case 'investor':
            setupInvestorForms();
            break;
        case 'dashboard':
            // setupDashboardElements(); // Ex: charger des graphiques
            break;
        default:
            console.log('No specific page module logic to run.');
            break;
    }
}


/**
 * Configure les écouteurs d'événements globaux (présents sur toutes les pages).
 */
function setupGlobalEventListeners() {
    console.log('🎧 Setting up global event listeners...');

    // Boutons de connexion / déconnexion du portefeuille
    document.getElementById('connect-metamask')?.addEventListener('click', async () => {
        await window.walletUtils.connectMetaMask();
        await updateAllUIElements();
    });

    document.getElementById('connect-magic')?.addEventListener('click', async () => {
        await window.walletUtils.connectMagicLink();
        await updateAllUIElements();
    });

    document.getElementById('disconnect-wallet')?.addEventListener('click', async () => {
        await window.walletUtils.disconnectWallet();
        await updateAllUIElements();
    });

    // Sélecteur de réseau
    document.getElementById('network-switcher')?.addEventListener('change', async (e) => {
        await window.walletUtils.switchNetwork(e.target.value);
        await updateAllUIElements();
    });
    
    // Bouton pour copier une adresse
    document.body.addEventListener('click', (e) => {
        if (e.target && e.target.matches('.copy-address')) {
            const address = e.target.dataset.address;
            if (address) {
                window.uiUtils.copyToClipboard(address);
            }
        }
    });
}

/**
 * Met à jour tous les éléments de l'interface utilisateur
 */
async function updateAllUIElements() {
    try {
        // Update wallet status
        window.walletUtils.updateWalletUI();
        
        // Update network status
        await window.walletUtils.updateNetworkStatus();
        
        // Update token balance
        await window.uiUtils.updateTokenBalance();
        
        // Update language
        updateUILanguage();
        
        console.log('✅ UI elements updated');
        
    } catch (error) {
        console.error('❌ Error updating UI elements:', error);
    }
}

/**
 * Configure les écouteurs d'événements
 */
function setupEventListeners() {
    console.log('🎧 Setting up event listeners...');
    
    // Wallet connection buttons
    const connectMetaMaskBtn = document.getElementById('connect-metamask');
    if (connectMetaMaskBtn) {
        connectMetaMaskBtn.addEventListener('click', async () => {
            await window.walletUtils.connectMetaMask();
            await updateAllUIElements();
        });
    }
    
    const connectMagicBtn = document.getElementById('connect-magic');
    if (connectMagicBtn) {
        connectMagicBtn.addEventListener('click', async () => {
            await window.walletUtils.connectMagicLink();
            await updateAllUIElements();
        });
    }
    
    const disconnectBtn = document.getElementById('disconnect-wallet');
    if (disconnectBtn) {
        disconnectBtn.addEventListener('click', async () => {
            await window.walletUtils.disconnectWallet();
            await updateAllUIElements();
        });
    }
    
    // Network switching
    const networkSwitcher = document.getElementById('network-switcher');
    if (networkSwitcher) {
        networkSwitcher.addEventListener('change', async (e) => {
            await window.walletUtils.switchNetwork(e.target.value);
            await updateAllUIElements();
        });
    }
    
    // Refresh balance button
    const refreshBalanceBtn = document.getElementById('refresh-balance');
    if (refreshBalanceBtn) {
        refreshBalanceBtn.addEventListener('click', async () => {
            await window.uiUtils.updateTokenBalance();
        });
    }
    
    // Copy address buttons
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('copy-address')) {
            const address = e.target.dataset.address;
            if (address) {
                window.uiUtils.copyToClipboard(address);
            }
        }
    });
    
    // Investment forms
    setupInvestmentForms();
    
    // Admin forms
    setupAdminForms();
    
    // Enterprise forms
    setupEnterpriseForms();
    
    // Client forms
    setupClientForms();
    
    console.log('✅ Event listeners configured');
}

/**
 * Configure les formulaires d'investissement
 */
function setupInvestmentForms() {
    // Individual invoice investment
    const investForm = document.getElementById('invest-form');
    if (investForm) {
        investForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(investForm);
            const invoiceId = formData.get('invoiceId');
            const amount = formData.get('amount');
            
            if (!invoiceId || !amount) {
                window.uiUtils.showErrorAlert('Please fill in all required fields');
                return;
            }
            
            try {
                await window.investorFunctions.investInInvoice(invoiceId, amount);
                investForm.reset();
                await updateAllUIElements();
            } catch (error) {
                console.error('Investment failed:', error);
            }
        });
    }
    
    // Pool investment
    const poolInvestForm = document.getElementById('pool-invest-form');
    if (poolInvestForm) {
        poolInvestForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(poolInvestForm);
            const poolId = formData.get('poolId');
            const amount = formData.get('amount');
            
            if (!poolId || !amount) {
                window.uiUtils.showErrorAlert('Please fill in all required fields');
                return;
            }
            
            try {
                await window.investorFunctions.investInPool(poolId, amount);
                poolInvestForm.reset();
                await updateAllUIElements();
            } catch (error) {
                console.error('Pool investment failed:', error);
            }
        });
    }
    
    // Claim funds buttons
    document.addEventListener('click', async (e) => {
        if (e.target.classList.contains('claim-funds-btn')) {
            const invoiceId = e.target.dataset.invoiceId;
            if (invoiceId) {
                try {
                    await window.investorFunctions.claimFunds(invoiceId);
                    await updateAllUIElements();
                } catch (error) {
                    console.error('Claim failed:', error);
                }
            }
        }
    });
}

/**
 * Configure les formulaires admin
 */
function setupAdminForms() {

    // Dans setupAdminForms(), ajoutez:
    document.getElementById('invoices-tab')?.addEventListener('shown.bs.tab', loadAllInvoices);
    document.getElementById('pools-tab')?.addEventListener('shown.bs.tab', loadAllPools);

    // Fonction pour charger toutes les factures
    async function loadAllInvoices() {
        try {
            const invoices = await window.sharedFunctions.getAllInvoices();
            const tableBody = document.getElementById('invoices-list');
            
            tableBody.innerHTML = await Promise.all(invoices.map(async invoice => {
                const collateralDetails = await window.sharedFunctions.getCollateralDetails(invoice.details.invoiceId);
                const now = Math.floor(Date.now() / 1000);
                const invoiceAmount = parseFloat(ethers.utils.formatEther(invoice.details.amount));
                const collectedAmount = parseFloat(ethers.utils.formatEther(invoice.financials.collectedAmount));
                const fundingEnded = now >= invoice.details.fundingEndDate;
                const isFullyFunded = collectedAmount >= invoiceAmount;

                // Déclaration des variables pour les deux colonnes d'état
                let statusBadge, statusClass;
                let collateralBadge = 'N/A', collateralClass = 'bg-secondary';

                // Logique pour déterminer le statut principal
                if (invoice.financials.isPaid) {
                    statusBadge = 'Remboursée';
                    statusClass = 'bg-success';
                } else if (fundingEnded && parseFloat(collectedAmount) === 0) {
                    statusBadge = 'Non financée';
                    statusClass = 'bg-danger';
                } else if (fundingEnded && isFullyFunded) {
                    if (now >= invoice.details.dueDate) {
                        statusBadge = 'En retard';
                        statusClass = 'bg-danger';
                    } else {
                        statusBadge = 'À rembourser';
                        statusClass = 'bg-primary';
                    }
                } else if (isFullyFunded && parseFloat(collectedAmount) > 0) {
                    statusBadge = 'Entièrement Financée';
                    statusClass = 'bg-success';
                } else if (parseFloat(collectedAmount) > 0 && !isFullyFunded) {
                    statusBadge = 'Partiellement Financée';
                    statusClass = 'bg-info text-dark';
                } else {
                    statusBadge = 'En Attente';
                    statusClass = 'bg-secondary';
                }

                // Logique spécifique pour le collatéral
                const requireCollateral = !invoice.details.isActive; // Accès au 9ème élément du tableau details

                if (requireCollateral || collateralDetails.initialDeposit > 0) {
                // if (invoice.details.requireCollateral || collateralDetails.initialDeposit > 0) {
                    if (collateralDetails.initialDeposit > 0) {
                        collateralBadge = 'Payé';
                        collateralClass = 'bg-success';
                    } else {
                        collateralBadge = 'Requis';
                        collateralClass = 'bg-warning text-dark';
                    }
                } else {
                    collateralBadge = 'Non requis';
                    collateralClass = 'bg-secondary';
                }

                return `
                    <tr>
                        <td>${invoice.details.invoiceId}</td>
                        <td>${invoice.metadata.companyName || invoice.details.company}</td>
                        <td>${invoice.metadata.clientName || invoice.details.client}</td>
                        <td>${ethers.utils.formatEther(invoice.details.amount)} USDT</td>
                        <td><span class="badge ${statusClass}">${statusBadge}</span></td>
                        <td><span class="badge ${collateralClass}">${collateralBadge}</span></td>
                        <td>
                            <button class="btn btn-sm btn-orange view-invoice-btn" data-id="${invoice.details.invoiceId}">
                                Voir 
                            </button>
                            ${now >= invoice.details.dueDate && collateralDetails.initialDeposit > 0 ? 
                                `<button class="btn btn-sm btn-danger compensate-btn" data-id="${invoice.details.invoiceId}">
                                    Compenser
                                </button>` : ''}
                        </td>
                    </tr>
                `;
            }));

            // Ajouter les gestionnaires d'événements
            document.querySelectorAll('.view-invoice-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const invoiceId = e.target.dataset.id;
                    showInvoiceDetails(invoiceId);
                });
            });

            document.querySelectorAll('.compensate-btn').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    const invoiceId = e.target.dataset.id;
                    try {
                        await window.adminFunctions.compensateInvestors(invoiceId);
                        window.uiUtils.showSuccessAlert('Compensation effectuée avec succès!');
                        await loadAllInvoices();
                    } catch (error) {
                        console.error('Compensation failed:', error);
                        window.uiUtils.showErrorAlert('Erreur lors de la compensation: ' + error.message);
                    }
                });
            });
        } catch (error) {
            console.error('Error loading invoices:', error);
            window.uiUtils.showErrorAlert('Erreur lors du chargement des factures: ' + error.message);
        }
    }

    // Fonction pour charger tous les pools
    async function loadAllPools() {
        try {
            const pools = await window.sharedFunctions.getAllPools();
            const tableBody = document.getElementById('pools-list');
            
            tableBody.innerHTML = await Promise.all(pools.map(async pool => {
                const invoices = await window.sharedFunctions.getPoolInvoices(pool.poolId);
                
                // Calcul du montant total, collecté et montant des factures
                let totalAmount = 0;
                let collectedAmount = 0;
                let invoicesTotalAmount = 0;
                
                for (const invoice of invoices) {
                    const invoiceAmount = parseFloat(ethers.utils.formatEther(invoice.details.amount));
                    totalAmount += invoiceAmount;
                    collectedAmount += parseFloat(ethers.utils.formatEther(invoice.financials.collectedAmount));
                    invoicesTotalAmount += invoiceAmount;
                }
                
                const progress = totalAmount > 0 ? (collectedAmount / totalAmount * 100).toFixed(2) : 0;
                
                return `
                    <tr>
                        <td>${pool.poolId}</td>
                        <td>${pool.name}</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-success" 
                                    role="progressbar" 
                                    style="width: ${progress}%"
                                    aria-valuenow="${progress}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                    ${progress}%
                                </div>
                            </div>
                            <small class="text-muted">${invoices.length}/${pool.maxInvoiceCount} factures</small>
                        </td>
                        <td>${invoicesTotalAmount.toFixed(2)} USDT</td>
                        <td><span class="badge ${pool.isActive ? 'bg-success' : 'bg-secondary'}">
                            ${pool.isActive ? 'Actif' : 'Inactif'}
                        </span></td>
                        <td>
                            <button class="btn btn-sm btn-primary manage-pool-btn" data-id="${pool.poolId}">
                                Gérer
                            </button>
                        </td>
                    </tr>
                `;
            }));
            
            // Connecter les boutons "Gérer"
            document.querySelectorAll('.manage-pool-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const poolId = e.target.dataset.id;
                    showPoolManagementModal(poolId);
                });
            });
        } catch (error) {
            console.error('Error loading pools:', error);
            window.uiUtils.showErrorAlert('Erreur lors du chargement des pools: ' + error.message);
        }
    }


    async function showInvoiceDetails(invoiceId) {
        try {
            // Récupérer les détails de la facture
            const invoiceData = await window.sharedFunctions.getInvoiceDetails(invoiceId);
            const { invoice, metadata } = invoiceData;
            
            // Récupérer les détails du collatéral si nécessaire
            const collateralDetails = await window.sharedFunctions.getCollateralDetails(invoiceId);
            console.log('Détails de la facture:', { invoice, metadata, collateralDetails });

            // Fonction de conversion sécurisée
            const safeFormatEther = (value) => {
                try {
                    // Si c'est déjà un BigNumber, on le formate directement
                    if (value._isBigNumber) {
                        return ethers.utils.formatEther(value);
                    }
                    // Si c'est une chaîne avec un point décimal, on la convertit en entier
                    if (typeof value === 'string' && value.includes('.')) {
                        value = parseFloat(value).toFixed(0); // Enlève les décimales
                    }
                    return ethers.utils.formatEther(value.toString());
                } catch (e) {
                    console.error('Erreur de formatage:', e);
                    return '0.0';
                }
            };

            // Formater les dates
            const formatDate = (timestamp) => {
                return new Date(timestamp * 1000).toLocaleDateString('fr-FR');
            };

            // Remplir les informations du modal
            document.getElementById('modalInvoiceId').textContent = invoiceId;
            document.getElementById('modalCompanyName').textContent = metadata?.companyName || 'Non spécifié';
            document.getElementById('modalClientName').textContent = metadata?.clientName || 'Non spécifié';
            document.getElementById('modalAmount').textContent = `${safeFormatEther(invoice.details.amount)} USDT`;
            document.getElementById('modalInterestRate').textContent = `${invoice.details.interestRate / 100}%`;
            document.getElementById('modalFundingEndDate').textContent = formatDate(invoice.details.fundingEndDate);
            document.getElementById('modalDueDate').textContent = formatDate(invoice.details.dueDate);
            document.getElementById('modalDescription').textContent = metadata?.description || 'Aucune description disponible';

            // Statut du collatéral
            let collateralStatus = 'Non requis';
            if (invoice.details.requireCollateral || (collateralDetails?.initialDeposit > 0)) {
                collateralStatus = collateralDetails.initialDeposit > 0 
                    ? `Payé (${collateralDetails.initialDeposit} USDT)` 
                    : 'Requis';
            }
            document.getElementById('modalCollateralStatus').textContent = collateralStatus;

            // Progression du financement
            const amount = parseFloat(safeFormatEther(invoice.details.amount));
            const collected = parseFloat(safeFormatEther(invoice.financials.collectedAmount));
            const progress = amount > 0 ? (collected / amount * 100).toFixed(2) : 0;
            
            document.getElementById('modalCollectedAmount').textContent = `${collected.toFixed(2)} / ${amount.toFixed(2)} USDT (${progress}%)`;
            document.getElementById('modalFundingProgress').style.width = `${progress}%`;

            // Document de la facture
            const docPreview = document.getElementById('modalDocumentPreview');
            docPreview.innerHTML = '';
            
            if (metadata?.documentURI) {
                const docUrl = window.ipfsUtils.getIPFSGatewayURL(metadata.documentURI);
                docPreview.innerHTML = `
                    <img src="${docUrl}" class="img-fluid rounded border border-secondary" 
                        style="max-height: 300px; cursor: pointer;" 
                        onclick="window.open('${docUrl}', '_blank')" 
                        alt="Document de facture">
                `;
            } else {
                docPreview.innerHTML = '<p class="text-muted text-center">Aucun document disponible</p>';
            }

            // Afficher le modal
            const modal = new bootstrap.Modal(document.getElementById('invoiceDetailsModal'));
            modal.show();

        } catch (error) {
            console.error('Error showing invoice details:', error);
            window.uiUtils.showErrorAlert('Erreur lors du chargement des détails de la facture: ' + error.message);
        }
    }

    async function showPoolManagementModal(poolId) {
        try {
            // Récupérer les données du pool
            const pool = await window.sharedFunctions.getPoolDetails(poolId);
            console.log('Détails du pool00=>:', pool);
            const poolInvoices = await window.sharedFunctions.getPoolInvoices(poolId);
            const allInvoices = await window.sharedFunctions.getAllInvoices();
            
            // Filtrer les factures non déjà dans le pool
            const availableInvoices = allInvoices.filter(invoice => 
                !poolInvoices.some(poolInv => poolInv.details.invoiceId === invoice.details.invoiceId)
            );

            // Fonction de formatage sécurisée
            const safeFormatEther = (value) => {
                try {
                    // Vérifier d'abord si la valeur existe
                    if (!value) return '0.0';
                    
                    // Si c'est un BigNumber
                    if (value._isBigNumber) {
                        return ethers.utils.formatEther(value);
                    }
                    
                    // Si c'est une chaîne ou un nombre
                    return ethers.utils.formatEther(value.toString());
                } catch (e) {
                    console.error('Erreur de formatage:', e);
                    return '0.0';
                }
            };

            // Remplir les informations du modal
            document.getElementById('poolManagementId').textContent = poolId;
            document.getElementById('poolManagementName').textContent = pool.pool.name;
            document.getElementById('poolManagementStatus').textContent = pool.pool.isActive ? 'Actif' : 'Inactif';
            document.getElementById('poolManagementMinInvestment').textContent = `${safeFormatEther(pool.pool.minInvestment)} USDT`;
            document.getElementById('poolManagementMaxAmount').textContent = `${safeFormatEther(pool.pool.maxPoolAmount)} USDT`;
            document.getElementById('poolManagementCurrentInvoices').textContent = poolInvoices.length;
            document.getElementById('poolManagementMaxInvoices').textContent = pool.pool.maxInvoiceCount;
            document.getElementById('poolManagementDescription').textContent = pool.metadata?.description || 'Aucune description';

            // Afficher les factures du pool
            const invoicesList = document.getElementById('poolInvoicesList');
            // Dans la partie qui affiche les factures du pool
            invoicesList.innerHTML = poolInvoices.map(invoice => {
                const amount = parseFloat(safeFormatEther(invoice.details.amount));
                const collected = parseFloat(safeFormatEther(invoice.financials.collectedAmount));
                const progress = amount > 0 ? (collected / amount * 100).toFixed(2) : 0;
                
                return `
                    <div class="col-md-6 mb-3">
                        <div class="card bg-darker text-white">
                            <div class="card-body">
                                <h6 class="card-title text-orange">Facture #${invoice.details.invoiceId}</h6>
                                <p class="mb-1"><small>Montant: ${safeFormatEther(invoice.details.amount)} USDT</small></p>
                                <p class="mb-1"><small>Taux: ${invoice.details.interestRate / 100}%</small></p>
                                
                                <!-- Barre de progression -->
                                <div class="progress mt-2 mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-success" 
                                        role="progressbar" 
                                        style="width: ${progress}%"
                                        aria-valuenow="${progress}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="text-center small mb-2">${collected.toFixed(2)} / ${amount.toFixed(2)} USDT (${progress}%)</p>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            // Remplir le select des factures disponibles
            const addInvoiceSelect = document.getElementById('addInvoiceSelect');
            addInvoiceSelect.innerHTML = availableInvoices.map(invoice => `
                <option value="${invoice.details.invoiceId}">
                    #${invoice.details.invoiceId} - ${invoice.metadata?.companyName || invoice.details.company} - ${safeFormatEther(invoice.details.amount)} USDT
                </option>
            `).join('');

            // Gestionnaire pour le bouton d'ajout
            document.getElementById('addInvoiceToPoolBtn').onclick = async () => {
                const invoiceId = addInvoiceSelect.value;
                if (!invoiceId) return;
                
                try {
                    await window.adminFunctions.addInvoiceToPool(invoiceId, poolId);
                    window.uiUtils.showSuccessAlert('Facture ajoutée avec succès!');
                    showPoolManagementModal(poolId); // Recharger les données
                } catch (error) {
                    console.error('Error adding invoice:', error);
                    window.uiUtils.showErrorAlert('Erreur: ' + error.message);
                }
            };

            // Afficher le modal
            const modal = new bootstrap.Modal(document.getElementById('poolManagementModal'));
            modal.show();

        } catch (error) {
            console.error('Error showing pool details:', error);
            window.uiUtils.showErrorAlert('Erreur lors du chargement des détails du pool: ' + error.message);
        }
    }

    

    // Create invoice form
    // Dans setupAdminForms(), modifiez le gestionnaire de create-invoice-form
    const createInvoiceForm = document.getElementById('create-invoice-form');
    if (createInvoiceForm) {
        createInvoiceForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            try {
                window.uiUtils.showLoadingAlert('Traitement de la facture...');
                
                // 1. Upload du document
                const fileInput = document.getElementById('invoice-document');
                const file = fileInput.files[0];
                
                if (!file) {
                    throw new Error('Veuillez sélectionner un document');
                }
                
                // Validation du fichier (max 10MB, types autorisés)
                window.ipfsUtils.validateFile(file, 10 * 1024 * 1024, ['pdf', 'jpg', 'jpeg', 'png']);
                
                // Upload du document sur IPFS
                const documentURI = await window.ipfsUtils.uploadFileToIPFS(file, {
                    type: 'invoice_document',
                    name: `Facture_${Date.now()}`
                });
                
                // 2. Préparation des données
                const formData = new FormData(createInvoiceForm);
                const invoiceData = {
                    amount: formData.get('amount'),
                    fundingDuration: formData.get('fundingDuration'),
                    dueDate: formData.get('dueDate'),
                    interestRate: formData.get('interestRate'),
                    companyAddress: formData.get('companyAddress'),
                    clientAddress: formData.get('clientAddress'),
                    requireCollateral: formData.has('requireCollateral'),
                    companyName: formData.get('companyName'),
                    clientName: formData.get('clientName'),
                    sector: formData.get('sector'),
                    description: formData.get('description'),
                    location: formData.get('location'),
                    invoiceType: formData.get('invoiceType'),
                    documentURI: documentURI // Ajout du URI du document
                };
                
                // 3. Upload des métadonnées sur IPFS
                const metadataURI = await window.ipfsUtils.uploadInvoiceMetadata(invoiceData);
                
                // 4. Création de la facture avec les métadonnées
                await window.adminFunctions.createInvoice({
                    ...invoiceData,
                    metadataURI: metadataURI
                });
                
                createInvoiceForm.reset();
                window.uiUtils.showSuccessAlert('Facture créée avec succès!');
                await updateAllUIElements();
                
            } catch (error) {
                console.error('Invoice creation failed:', error);
                window.uiUtils.showErrorAlert('Erreur: ' + error.message);
            } finally {
                window.uiUtils.hideLoadingAlert();
            }
        });
    }
    
    
    // Create pool form
    // Dans setupAdminForms(), modifiez le gestionnaire de create-pool-form
    const createPoolForm = document.getElementById('create-pool-form');
    if (createPoolForm) {
        createPoolForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            try {
                window.uiUtils.showLoadingAlert('Création du pool en cours...');
                
                // 1. Upload de la bannière
                const bannerInput = document.getElementById('pool-banner');
                const bannerFile = bannerInput.files[0];
                
                if (!bannerFile) {
                    throw new Error('Veuillez sélectionner une image pour la bannière');
                }
                
                // Validation de l'image (max 5MB, types image)
                window.ipfsUtils.validateFile(bannerFile, 5 * 1024 * 1024, ['jpg', 'jpeg', 'png', 'gif']);
                
                const bannerURI = await window.ipfsUtils.uploadFileToIPFS(bannerFile, {
                    type: 'pool_banner',
                    name: `Banniere_${Date.now()}`
                });
                
                // 2. Préparation des données
                const formData = new FormData(createPoolForm);
                const poolData = {
                    name: formData.get('name'),
                    minInvestment: formData.get('minInvestment'),
                    maxInvoiceCount: formData.get('maxInvoiceCount'),
                    maxPoolAmount: formData.get('maxPoolAmount'),
                    description: formData.get('description'),
                    theme: formData.get('theme'),
                    riskLevel: formData.get('riskLevel'),
                    region: formData.get('region'),
                    bannerURI: bannerURI // Ajout du URI de la bannière
                };
                
                // 3. Upload des métadonnées sur IPFS
                const metadataURI = await window.ipfsUtils.uploadPoolMetadata(poolData);
                
                // 4. Création du pool avec les métadonnées
                await window.adminFunctions.createPool({
                    ...poolData,
                    metadataURI: metadataURI
                });
                
                createPoolForm.reset();
                window.uiUtils.showSuccessAlert('Pool créé avec succès!');
                await updateAllUIElements();
                
            } catch (error) {
                console.error('Pool creation failed:', error);
                window.uiUtils.showErrorAlert('Erreur: ' + error.message);
            } finally {
                window.uiUtils.hideLoadingAlert();
            }
        });
    }
    

    // On sélectionne le formulaire par son ID
    const roleForm = document.getElementById('grant-role-btn');

    // On ajoute un écouteur pour l'événement 'submit'
    roleForm.addEventListener('submit', async (e) => {
        // 1. On empêche le rechargement de la page (comportement par défaut du formulaire)
        e.preventDefault(); 

        // 2. On récupère les données du formulaire
        const formData = new FormData(roleForm);
        const userAddress = formData.get('userAddress');
        const roleType = formData.get('roleType');

        // 3. On identifie quel bouton a soumis le formulaire
        // e.submitter est le bouton sur lequel on a cliqué
        const action = e.submitter.value; // 'grant' ou 'revoke'

        // 4. On valide l'adresse avant de continuer
        if (!userAddress || !window.uiUtils.isValidAddress(userAddress)) {
            console.error('Adresse utilisateur invalide.');
            // Optionnel : Afficher une alerte à l'utilisateur
            window.uiUtils.showAlert('Erreur', 'Veuillez entrer une adresse valide.');
            return; 
        }

        // 5. On exécute la bonne fonction en fonction du bouton cliqué
        if (action === 'grant') {
            console.log(`Tentative d'accorder le rôle ${roleType} à ${userAddress}`);
            try {
                // Appel de votre fonction pour accorder le rôle
                await window.adminFunctions.grantRole(roleType, userAddress);
                console.log('Rôle accordé avec succès ! ✅');
            } catch (error) {
                console.error("L'octroi du rôle a échoué:", error);
            }
        } else if (action === 'revoke') {
            console.log(`Tentative de révoquer le rôle ${roleType} de ${userAddress}`);
            try {
                // Appel de votre fonction pour révoquer le rôle
                await window.adminFunctions.revokeRole(roleType, userAddress);
                console.log('Rôle révoqué avec succès ! ❌');
            } catch (error) {
                console.error("La révocation du rôle a échoué:", error);
            }
        }
    }); 


    // --- Ajout d'une facture à un pool ---
    const addInvoiceToPoolForm = document.getElementById('form-add-invoice-to-pool');
    if (addInvoiceToPoolForm) {
        addInvoiceToPoolForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            console.log("COMMMMENNVECE")
            const formData = new FormData(addInvoiceToPoolForm);
            const invoiceId = formData.get('invoiceId');
            const poolId = formData.get('poolId');
            console.log("invoiceId00=>",invoiceId,"poolId00=>",poolId)
            // Gestion du bouton de soumission
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Traitement...';

            try {

                // Vérifier l'état de la facture et du pool
                const [invoice, pool] = await Promise.all([
                    window.sharedFunctions.getInvoiceDetails(invoiceId),
                    window.sharedFunctions.getPoolDetails(poolId)
                ]);

                // Exécuter l'ajout
                console.log(`Ajout de la facture ${invoiceId} au pool ${poolId}`);
                const tx = await window.adminFunctions.addInvoiceToPool(invoiceId, poolId);

                // Succès
                window.uiUtils.showSuccessAlert('Facture ajoutée au pool avec succès!');
                addInvoiceToPoolForm.reset();

            } catch (error) {
                console.error("Erreur lors de l'ajout de la facture au pool:", error);
                
                let errorMessage = "Erreur lors de l'ajout de la facture au pool";
                if (error.message.includes("permission")) {
                    errorMessage = "Permission refusée : " + error.message;
                } else if (error.message.includes("non disponible")) {
                    errorMessage = "Fonctionnalité temporairement indisponible";
                } else {
                    errorMessage += `: ${error.message}`;
                }
                
                window.uiUtils.showErrorAlert(errorMessage);
            } finally {
                // Restaurer le bouton
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }

    // --- Activation / Désactivation d'un pool ---
    const setPoolStatusForm = document.getElementById('form-set-pool-status');
    if (setPoolStatusForm) {
        setPoolStatusForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(setPoolStatusForm);
            const poolId = formData.get('poolId');
            const action = e.submitter.value; // 'activate' ou 'deactivate'
            const isActive = (action === 'activate');
            
            console.log(`${action === 'activate' ? 'Activation' : 'Désactivation'} du pool ${poolId}`);
            try {
                await window.adminFunctions.setPoolActive(poolId, isActive);
                console.log('Statut du pool mis à jour !');
                setPoolStatusForm.reset();
            } catch(error) {
                console.error('Erreur mise à jour statut du pool:', error);
            }
        });
    }

    // --- Pause / Reprise du contrat ---
    const pauseBtn = document.getElementById('btn-pause-contract');
    if (pauseBtn) {
        pauseBtn.addEventListener('click', async () => {
            console.log("Mise en pause du contrat...");
            try {
                await window.adminFunctions.pause();
                console.log('Contrat mis en pause.');
            } catch(error) {
                console.error('Erreur lors de la mise en pause:', error);
            }
        });
    }

    const unpauseBtn = document.getElementById('btn-unpause-contract');
    if (unpauseBtn) {
        unpauseBtn.addEventListener('click', async () => {
            console.log("Reprise du contrat...");
            try {
                await window.adminFunctions.unpause();
                console.log('Contrat réactivé.');
            } catch(error) {
                console.error('Erreur lors de la réactivation:', error);
            }
        });
    }

    // --- Compensation des investisseurs ---
    const compensateForm = document.getElementById('form-compensate-investors');
    if (compensateForm) {
        compensateForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(compensateForm);
            const invoiceId = formData.get('invoiceId');
            console.log(`Compensation pour la facture ${invoiceId}`);
            try {
                await window.adminFunctions.compensateInvestors(invoiceId);
                console.log('Compensation effectuée.');
                compensateForm.reset();
            } catch(error) {
                console.error('Erreur de compensation:', error);
            }
        });
    }

    // --- Récupération de fonds d'urgence ---
    const recoverFundsForm = document.getElementById('form-recover-funds');
    if (recoverFundsForm) {
        recoverFundsForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(recoverFundsForm);
            const tokenAddress = formData.get('tokenAddress');
            const amount = formData.get('amount');
            console.log(`Récupération de ${amount} du token ${tokenAddress}`);
            try {
                await window.adminFunctions.executeEmergencyRecoverFunds(tokenAddress, amount);
                console.log('Fonds récupérés.');
                recoverFundsForm.reset();
            } catch(error) {
                console.error('Erreur de récupération des fonds:', error);
            }
        });
    }

    //
    // 📂 ONGLET CONFIGURATION
    //

    // --- Mise à jour Stablecoin ---
    const updateStablecoinForm = document.getElementById('form-update-stablecoin');
    if (updateStablecoinForm) {
        updateStablecoinForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(updateStablecoinForm);
            const newAddress = formData.get('stablecoinAddress');
            console.log(`Mise à jour de l'adresse du stablecoin vers ${newAddress}`);
            try {
                await window.adminFunctions.updateStablecoin(newAddress);
                console.log('Adresse Stablecoin mise à jour.');
                updateStablecoinForm.reset();
            } catch (error) {
                console.error("Erreur MAJ Stablecoin:", error);
            }
        });
    }
    
    // --- Mise à jour Trésorerie ---
    const updateTreasuryForm = document.getElementById('form-update-treasury');
    if (updateTreasuryForm) {
        updateTreasuryForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(updateTreasuryForm);
            const newAddress = formData.get('treasuryAddress');
            console.log(`Mise à jour de l'adresse de la trésorerie vers ${newAddress}`);
             try {
                await window.adminFunctions.updateFeeTreasury(newAddress);
                console.log('Adresse Trésorerie mise à jour.');
                updateTreasuryForm.reset();
            } catch (error) {
                console.error("Erreur MAJ Trésorerie:", error);
            }
        });
    }

    // --- Mise à jour des taux de collatéral ---
    const updateCollateralRatesForm = document.getElementById('form-update-collateral-rates');
    if (updateCollateralRatesForm) {
        updateCollateralRatesForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(updateCollateralRatesForm);
            const initialRate = formData.get('initialRate');
            const withheldRate = formData.get('withheldRate');
            console.log(`Mise à jour des taux de collatéral: Initial ${initialRate}%, Retenu ${withheldRate}%`);
             try {
                await window.adminFunctions.updateCollateralRates(initialRate, withheldRate);
                console.log('Taux de collatéral mis à jour.');
                updateCollateralRatesForm.reset();
            } catch (error) {
                console.error("Erreur MAJ taux collatéral:", error);
            }
        }); 
    }
    
    // --- Mise à jour des taux de commission ---
    const updateCommissionRatesForm = document.getElementById('form-update-commission-rates');
    if (updateCommissionRatesForm) {
        updateCommissionRatesForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(updateCommissionRatesForm);
            const rates = {
                entryFee: formData.get('entryFee'),
                performanceFee: formData.get('performanceFee'),
                poolFee: formData.get('poolFee'),
                issuanceFee: formData.get('issuanceFee'),
            };
            const action = e.submitter.value; // 'start' ou 'execute'
            
            if (action === 'start') {
                console.log("Initiation de la mise à jour des commissions (Timelock)...", rates);
                try {
                    await window.adminFunctions.startUpdateCommissionRates(rates.entryFee, rates.performanceFee, rates.poolFee, rates.issuanceFee);
                    console.log('Mise à jour des commissions initiée.');
                } catch (error) {
                    console.error("Erreur d'initiation:", error);
                }
            } else if (action === 'execute') {
                console.log("Exécution de la mise à jour des commissions...", rates);
                 try {
                    await window.adminFunctions.updateCommissionRates(rates.entryFee, rates.performanceFee, rates.poolFee, rates.issuanceFee);
                    console.log('Mise à jour des commissions exécutée.');
                } catch (error) {
                    console.error("Erreur d'exécution:", error);
                }
            }
        });
    }


    // Vérification des rôles
    document.getElementById('check-role-btn')?.addEventListener('click', async function() {
        const userAddress = document.querySelector('input[name="userAddress"]').value;
        
        if (!userAddress || !window.uiUtils.isValidAddress(userAddress)) {
            window.uiUtils.showErrorAlert('Veuillez entrer une adresse valide');
            return;
        }
        
        try {
            window.uiUtils.showLoadingAlert('Vérification du rôle...');
            
            const contract = window.sharedFunctions.getInvoiceTokenContract();
            const adminRole = await contract.ADMIN_ROLE();
            const operatorRole = await contract.OPERATOR_ROLE();
            
            const isAdmin = await contract.hasRole(adminRole, userAddress);
            const isOperator = await contract.hasRole(operatorRole, userAddress);
            
            let roleText = 'Aucun rôle';
            if (isAdmin) roleText = 'Administrateur';
            else if (isOperator) roleText = 'Opérateur';
            
            document.getElementById('current-role-display').innerHTML = `
                <strong>${roleText}</strong>
                <div class="small">${userAddress}</div>
            `;
            
            window.uiUtils.hideLoadingAlert();
            
        } catch (error) {
            window.uiUtils.hideLoadingAlert();
            console.error('Error checking role:', error);
            window.uiUtils.showErrorAlert('Erreur lors de la vérification du rôle');
        }
    });

    // Chargement des informations de configuration
    async function loadConfigData() {
        try {
            const contract = window.sharedFunctions.getInvoiceTokenContract();
        
            document.getElementById('contract-address').textContent = window.COINFINANCE_CONFIG.contracts.invoiceToken;
            document.getElementById('stablecoin-address').textContent = await window.COINFINANCE_CONFIG.contracts.cfnToken;
            document.getElementById('treasury-address').textContent = await contract.feeTreasury();
            
            // Récupération des taux de collatéral
            const collateralRates = await window.sharedFunctions.getCollateralDetails(0); //A revoir
            
            // Conversion des BigNumber en valeurs numériques
            const initialDepositRate = collateralRates.rates.initialDepositRate._hex;
            const withheldRate = collateralRates.rates.withheldRate._hex;
            
            // Conversion hexadécimale en décimal et division par 100 pour obtenir le pourcentage
            const initialRatePercent = parseInt(initialDepositRate, 16) / 100;
            const withheldRatePercent = parseInt(withheldRate, 16) / 100;
            
            document.getElementById('initial-collateral-rate').textContent = `${initialRatePercent}%`;
            document.getElementById('withheld-collateral-rate').textContent = `${withheldRatePercent}%`;
            
            // Récupération des taux de commission
            const commissionRates = await contract.commissionRates();
            document.getElementById('entry-fee-rate').textContent = `${commissionRates.entryFee / 100}%`;
            document.getElementById('performance-fee-rate').textContent = `${commissionRates.performanceFee / 100}%`;
            document.getElementById('pool-fee-rate').textContent = `${commissionRates.poolFee / 100}%`;
            document.getElementById('issuance-fee-rate').textContent = `${commissionRates.issuanceFee / 100}%`;
            
        } catch (error) {
            console.error('Error loading config data:', error);
            window.uiUtils.showErrorAlert('Failed to load configuration data');
        }
    }
    
    // Appeler loadConfigData quand l'onglet Configuration est affiché
    document.getElementById('config-tab')?.addEventListener('shown.bs.tab', loadConfigData);
}

/**
 * Configure les formulaires entreprise
 */
function setupEnterpriseForms() {
    // Fonction pour charger et afficher les factures de l'entreprise
    async function loadCompanyInvoices() {
        const invoiceListContainer = document.getElementById('company-invoices-list');
        if (!invoiceListContainer) return;

        invoiceListContainer.innerHTML = `<div class="text-center py-4">
            <div class="spinner-border text-orange" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mt-2">Chargement de vos factures...</p>
        </div>`;

        try {
            if (!window.walletUtils.isWalletReady()) {
                invoiceListContainer.innerHTML = `<p class="alert alert-warning text-center">Veuillez connecter votre portefeuille pour voir vos factures.</p>`;
                return;
            }

            const userAddress = window.walletUtils.getCurrentWalletAddress();
            const allInvoices = await window.sharedFunctions.getAllInvoices();
            const companyInvoices = allInvoices.filter(invoice =>
                invoice.details.company.toLowerCase() === userAddress.toLowerCase()
            );

            if (companyInvoices.length === 0) {
                invoiceListContainer.innerHTML = `<p class="text-muted text-center">Vous n'avez pas encore émis de factures. Créez-en une via le panneau administrateur.</p>`;
                return;
            }

            invoiceListContainer.innerHTML = '<div class="row row-cols-1 row-cols-md-3 g-4" id="invoices-container"></div>';
            const container = document.getElementById('invoices-container');
            const now = Math.floor(Date.now() / 1000);

            for (const invoice of companyInvoices) {
                const collateralDetails = await window.enterpriseFunctions.getCollateralDetails(invoice.details.invoiceId);
                console.log("collateralDetails=>",invoice)
                const canWithdraw = await window.enterpriseFunctions.canWithdrawFunds(invoice.details.invoiceId, userAddress);
                const canRelease = await window.enterpriseFunctions.canReleaseCollateral(invoice.details.invoiceId);
                
                // Calculs
                const invoiceAmount = ethers.utils.formatEther(invoice.details.amount);
                const collectedAmount = ethers.utils.formatEther(invoice.financials.collectedAmount);
                const fundingPercentage = (collectedAmount / invoiceAmount * 100).toFixed(2);
                const collateralAmount = (invoiceAmount * collateralDetails.rates.initialDepositRate / 10000).toFixed(2);
                
                // Vérifications dates et statut
                const fundingEnded = now >= invoice.details.fundingEndDate;
                const isFullyFunded = parseFloat(collectedAmount) >= parseFloat(invoiceAmount);
                const showDepositCollateral = !invoice.details.isActive && !fundingEnded;
                const showWithdrawFunds = canWithdraw && (isFullyFunded || fundingEnded);

                // Détermination du statut principal
                let statusBadge, statusClass;
                if (invoice.financials.isPaid) {
                    statusBadge = 'Remboursée';
                    statusClass = 'bg-success';
                } else if (fundingEnded && parseFloat(collectedAmount) === 0) {
                    statusBadge = 'Non financée';
                    statusClass = 'bg-danger';
                } else if (fundingEnded && isFullyFunded) {
                    if (now >= invoice.details.dueDate) {
                        statusBadge = 'En retard';
                        statusClass = 'bg-danger';
                    } else {
                        statusBadge = 'À rembourser';
                        statusClass = 'bg-primary';
                    }
                } else if (isFullyFunded && parseFloat(collectedAmount) > 0) {
                    statusBadge = 'Entièrement Financée';
                    statusClass = 'bg-success';
                } else if (parseFloat(collectedAmount) > 0 && !isFullyFunded) {
                    statusBadge = 'Partiellement Financée';
                    statusClass = 'bg-info text-dark';
                } else {
                    statusBadge = 'En Attente';
                    statusClass = 'bg-secondary';
                }

                // Détermination du statut du collatéral
                let collateralBadge, collateralClass;
                // Détermination du statut du collatéral
                const requireCollateral = !invoice.details.isActive; // Accès au 9ème élément du tableau details

                if (requireCollateral || collateralDetails.initialDeposit > 0) {
                    if (collateralDetails.initialDeposit > 0) {
                        collateralBadge = 'Collatéral Payé';
                        collateralClass = 'bg-success';
                    } else {
                        collateralBadge = 'Collatéral Requis';
                        collateralClass = 'bg-warning text-dark';
                    }
                } else {
                    collateralBadge = 'Non requis';
                    collateralClass = 'bg-secondary';
                }

                // Construction de la carte
                container.innerHTML += `
                    <div class="col">
                        <div class="card mb-3 bg-dark text-white h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title text-orange">Facture #${invoice.details.invoiceId.toString()}</h5>
                                    <div>
                                        <span class="badge ${statusClass} me-1">${statusBadge}</span>
                                        <span class="badge ${collateralClass}">${collateralBadge}</span>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <p><strong>Client:</strong> ${invoice.metadata?.clientName || 'Non spécifié'}</p>
                                    <p><strong>Montant:</strong> ${invoiceAmount} USDT</p>
                                    <p><strong>Taux:</strong> ${invoice.details.interestRate / 100}%</p>
                                    <p><strong>Fin collecte:</strong> ${new Date(invoice.details.fundingEndDate * 1000).toLocaleDateString()}</p>
                                    <p><strong>Échéance:</strong> ${new Date(invoice.details.dueDate * 1000).toLocaleDateString()}</p>
                                </div>
                                
                                <div class="progress mt-auto mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: ${fundingPercentage}%"></div>
                                </div>
                                <p class="text-center small">${collectedAmount} / ${invoiceAmount} USDT (${fundingPercentage}%)</p>
                                
                                <div class="d-flex flex-wrap gap-2 mt-auto">
                                    ${showDepositCollateral ? `
                                    <button class="btn btn-warning btn-sm deposit-collateral-btn" 
                                            data-invoice-id="${invoice.details.invoiceId.toString()}"
                                            data-amount="${collateralAmount}">
                                        <i class="bi bi-coin"></i>Déposer Collatéral
                                    </button>` : ''}
                                    
                                    ${showWithdrawFunds ? `
                                    <button class="btn btn-success btn-sm withdraw-funds-btn" 
                                            data-invoice-id="${invoice.details.invoiceId.toString()}">
                                        <i class="bi bi-cash-stack"></i> Retirer
                                    </button>` : ''}
                                    
                                    ${canRelease ? `
                                    <button class="btn btn-info btn-sm release-collateral-btn" 
                                            data-invoice-id="${invoice.details.invoiceId.toString()}">
                                        <i class="bi bi-unlock"></i> Libérer
                                    </button>` : ''}
                                    
                                    <button class="btn btn-orange btn-sm view-invoice-details" 
                                            data-invoice-id="${invoice.details.invoiceId.toString()}">
                                        <i class="bi bi-eye-fill"></i> Détails
                                    </button>
                                </div>

                                <div class="card-footer bg-darker mt-2">
                                    <button class="btn btn-sm btn-outline-orange w-100 financial-details-btn" 
                                            data-invoice-id="${invoice.details.invoiceId.toString()}">
                                        <i class="bi bi-calculator"></i> Détails Financiers
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>`;
            }

            setupInvoiceActionListeners();

            // Les écouteurs pour les boutons de détails financiers
            document.querySelectorAll('.financial-details-btn').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    const invoiceId = e.currentTarget.dataset.invoiceId;
                    await showFinancialDetails(invoiceId);
                });
            });
            
            // Initialisez les filtres
            setupEnterpriseFilters();

        } catch (error) {
            console.error('Error loading company invoices:', error);
            invoiceListContainer.innerHTML = `<div class="alert alert-danger">Erreur lors du chargement des factures: ${error.message}</div>`;
        }
    }

    // Dans setupEnterpriseForms(), ajoutez ceci après loadCompanyInvoices()
    function setupEnterpriseFilters() {
        document.querySelectorAll('.filter-option').forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const filter = this.dataset.filter;
                filterInvoices(filter);
            });
        });
    }

    async function filterInvoices(filter) {
        const invoiceCards = document.querySelectorAll('#invoices-container .col');
        
        invoiceCards.forEach(card => {
            const statusBadge = card.querySelector('.badge');
            if (!statusBadge) return;
            
            const statusText = statusBadge.textContent.toLowerCase();
            const statusClass = statusBadge.className.toLowerCase();
            
            // Déterminer les différents états
            const isPaid = statusText.includes('remboursée') || statusClass.includes('bg-success');
            const isPartiallyFunded = statusText.includes('partiellement') || statusClass.includes('bg-info');
            const isFullyFunded = statusText.includes('entièrement') || statusText.includes('financée') || statusClass.includes('bg-success');
            const needsCollateral = statusText.includes('collatéral') || statusText.includes('requis') || statusClass.includes('bg-warning');
            const isPending = statusText.includes('attente') || statusClass.includes('bg-secondary');
            const isLate = statusText.includes('retard') || statusClass.includes('bg-danger');
            
            let showCard = false;
            
            switch(filter) {
                case 'all':
                    showCard = true;
                    break;
                case 'paid':
                    showCard = isPaid;
                    break;
                case 'unpaid':
                    showCard = !isPaid && (isPartiallyFunded || isFullyFunded || needsCollateral || isPending);
                    break;
                case 'partially':
                    showCard = isPartiallyFunded && !isFullyFunded;
                    break;
                case 'fully':
                    showCard = isFullyFunded;
                    break;
                case 'collateral-needed':
                    showCard = needsCollateral;
                    break;
                case 'no-collateral':
                    showCard = !needsCollateral;
                    break;
                default:
                    showCard = true;
            }
            
            card.style.display = showCard ? 'block' : 'none';
        });
    }

    // Fonction pour afficher les détails financiers
    async function showFinancialDetails(invoiceId) {
        try {
            const invoiceData = await window.sharedFunctions.getInvoiceDetails(invoiceId);
            console.log("Données de la facture:", invoiceData);

            // Extraction des données
            const details = invoiceData.invoice[0] || {};
            const financials = invoiceData.invoice[1] || {};

            if (!details.amount) {
                throw new Error("Montant de la facture non disponible");
            }
            
            // Récupération des paramètres
            const commissionRates = await window.sharedFunctions.getCommissionRates();
            const collateralDetails = await window.sharedFunctions.getCollateralDetails(invoiceId);
            console.log("collateralDetails000:", collateralDetails);
            
            // Conversion des montants
            const invoiceAmount = parseFloat(ethers.utils.formatEther(details.amount));
            const collectedAmount = parseFloat(ethers.utils.formatEther(financials.collectedAmount || details.amount));
            const interestRate = details.interestRate / 100;
            console.log("Montant de la facture:", invoiceAmount, "Montant collecté:", collectedAmount, "Taux d'intérêt:", interestRate);
            
            // Calcul de la durée en jours
            const fundingDuration = Math.round((details.dueDate - details.fundingEndDate) / (60 * 60 * 24));
            
            // Calcul des frais et intérêts
            const platformFee = collectedAmount * (commissionRates.issuanceFee / 10000);
            const interestAmount = collectedAmount * interestRate/100;
            const netAmount = collectedAmount - platformFee - interestAmount;
            
            // Calcul des collatéraux si nécessaire
            const initialCollateral = collateralDetails 
                ? invoiceAmount * (collateralDetails.rates.initialDepositRate / 10000) 
                : 0;
            const withheldCollateral = collateralDetails 
                ? netAmount * (collateralDetails.rates.withheldRate / 10000) 
                : 0;
            
            // Calcul du montant net sans le deuxième collatéral
            const netAmountWithoutSecondCollateral = netAmount - withheldCollateral;
            // Création du modal simplifié
            const modalHTML = `
                <div class="modal fade" id="financialDetailsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header">
                                <h5 class="modal-title text-orange">Détails Financiers - Facture #${invoiceId}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12}">
                                        <div class="card bg-darker mb-3">
                                            <div class="card-body">
                                                <h6 class="text-orange">Récapitulatif</h6>
                                                <table class="table table-dark table-sm">
                                                    <tr>
                                                        <td>Montant Facture Total:</td>
                                                        <td class="text-end">${invoiceAmount.toFixed(2)} USDT</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Montant Collecté:</td>
                                                        <td class="text-end">${collectedAmount.toFixed(2)} USDT</td>
                                                    </tr>
                                                    <tr class="text-danger">
                                                        <td>Frais Plateforme (${commissionRates.issuanceFee / 100}%):</td>
                                                        <td class="text-end">-${platformFee.toFixed(2)} USDT</td>
                                                    </tr>
                                                    <tr class="text-info">
                                                        <td>Intérêts (${interestRate}%):</td>
                                                        <td class="text-end">-${interestAmount.toFixed(2)} USDT</td>
                                                    </tr>
                                                    <tr class="">
                                                        <td><strong>Montant Net Disponible:</strong></td>
                                                        <td class="text-end"><strong>${netAmount.toFixed(2)} USDT</strong></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    ${details.requireCollateral || collateralDetails.initialDeposit >0? `
                                    <div class="col-md-12">
                                        <div class="card bg-darker mb-3">
                                            <div class="card-body">
                                                <h6 class="text-orange">Collatéraux</h6>
                                                <table class="table table-dark table-sm">
                                                    <tr>
                                                        <td>1er Collatéral (${collateralDetails.rates.initialDepositRate / 100}%):</td>
                                                        <td class="text-end">${initialCollateral.toFixed(2)} USDT</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2ème Collatéral (${collateralDetails.rates.withheldRate / 100}%):</td>
                                                        <td class="text-end">${withheldCollateral.toFixed(2)} USDT</td>
                                                    </tr>
                                                    <tr class="">
                                                        <td>Total Collatéral:</td>
                                                        <td class="text-end">${(initialCollateral + withheldCollateral).toFixed(2)} USDT</td>
                                                    </tr>
                                                    <tr class="">
                                                        <td>A recevoir sans le 2è collatéral:</td>
                                                        <td class="text-end">${(netAmountWithoutSecondCollateral).toFixed(2)} USDT</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    ` : ''}
                                </div>
                                
                                <div class="alert alert-info mt-3">
                                    <i class="bi bi-info-circle"></i> 
                                    Le montant net disponible est calculé après déduction des frais (${commissionRates.issuanceFee / 100}%) 
                                    et des intérêts (${interestRate}%) sur le montant collecté. Et si une facture est partiellement financée, on envoie le reste non financé à l'entreprise lorsque le client rembourse.
                                    <br/>Le montant net sans le 2ème collatéral est calculé en soustrayant le 2ème collatéral du montant net disponible que vous pouvez retirer si un collatéral est requis.
                                    Durée: ${fundingDuration} jours.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Ajout et affichage du modal
            document.body.insertAdjacentHTML('beforeend', modalHTML);
            const modal = new bootstrap.Modal(document.getElementById('financialDetailsModal'));
            modal.show();
            
            // Nettoyage après fermeture
            document.getElementById('financialDetailsModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
            
        } catch (error) {
            console.error('Error showing financial details:', error);
            window.uiUtils.showErrorAlert('Erreur lors du chargement des détails financiers: ' + error.message);
        }
    }

    // Ajoutez cette fonction pour charger les statistiques
    async function loadEnterpriseStats() {
        try {
            const userAddress = window.walletUtils.getCurrentWalletAddress();
            const allInvoices = await window.sharedFunctions.getAllInvoices();
            const companyInvoices = window.sharedFunctions.filterInvoicesByCompany(allInvoices, userAddress);

            let totalAmount = 0;
            let totalInterest = 0;
            let totalFees = 0;
            let withdrawableAmount = 0;
            let totalCollateral = 0;
            let releasableCollateral = 0;
            let stakedCollateral = 0;
            let withheldCollateral = 0;
            let collateralRates = [];
            const upcomingDueDates = [];
            const now = Math.floor(Date.now() / 1000);
            
            const commissionRates = await window.sharedFunctions.getCommissionRates();
            
            for (const invoice of companyInvoices) {
                const invoiceAmount = parseFloat(ethers.utils.formatEther(invoice.details.amount));
                const interestRate = invoice.details.interestRate / 100;
                const fundingDuration = (invoice.details.dueDate - invoice.details.fundingEndDate) / (60 * 60 * 24);
                
                totalAmount += invoiceAmount;
                totalFees += invoiceAmount * (commissionRates.issuanceFee / 10000);
                
                if (invoice.financials.isPaid) {
                    totalInterest += invoiceAmount * (interestRate / 100) * (fundingDuration / 365);
                } else if (invoice.financials.collectedAmount.gte(invoice.details.amount)) {
                    withdrawableAmount += invoiceAmount;
                }
                
                // Récupération des détails du collatéral
                const collateral = await window.enterpriseFunctions.getCollateralDetails(invoice.details.invoiceId);
                console.log("Détails collatéral:", collateral);
                
                // Conversion des montants
                const initialDeposit = parseFloat(collateral.initialDeposit || '0');
                const withheld = parseFloat(collateral.withheldAmount || '0');
                const staked = parseFloat(collateral.stakedAmount || '0');
                const total = parseFloat(collateral.totalAmount || '0');
                
                // Calcul des taux
                const initialRate = collateral.rates?.initialDepositRate 
                    ? parseFloat(ethers.utils.formatEther(collateral.rates.initialDepositRate)) * 100 
                    : 0;
                const withheldRate = collateral.rates?.withheldRate 
                    ? parseFloat(ethers.utils.formatEther(collateral.rates.withheldRate)) * 100 
                    : 0;
                
                // Sommes globales
                totalCollateral += total;
                withheldCollateral += withheld;
                stakedCollateral += staked;
                
                // Collatéral pouvant être libéré
                if (await window.enterpriseFunctions.canReleaseCollateral(invoice.details.invoiceId)) {
                    if (collateral.isReleased) {
                        releasableCollateral += 0; // Déjà libéré
                    } else {
                        // On peut libérer le collatéral initial moins ce qui est staké
                        releasableCollateral += Math.max(0, initialDeposit - staked);
                    }
                }
                
                // Pour le taux moyen, on considère seulement le taux initial
                if (initialRate > 0) {
                    collateralRates.push(initialRate);
                }
                
                // Échéances à venir
                if (!invoice.financials.isPaid && invoice.details.dueDate > now) {
                    upcomingDueDates.push({
                        id: invoice.details.invoiceId,
                        dueDate: new Date(invoice.details.dueDate * 1000),
                        amount: invoiceAmount,
                        collateralStatus: collateral.isReleased ? 'libéré' : collateral.isStaked ? 'staké' : 'déposé'
                    });
                }
            }
            
            // Mise à jour de l'interface utilisateur
            document.getElementById('total-amount').textContent = totalAmount.toFixed(2) + ' USDT';
            document.getElementById('withdrawable-amount').textContent = withdrawableAmount.toFixed(2) + ' USDT';
            document.getElementById('total-interest').textContent = totalInterest.toFixed(2) + ' USDT';
            document.getElementById('total-fees').textContent = totalFees.toFixed(2) + ' USDT';
            
            // Affichage des collatéraux
            document.getElementById('total-collateral').textContent = totalCollateral.toFixed(2) + ' USDT';
            document.getElementById('releasable-collateral').textContent = releasableCollateral.toFixed(2) + ' USDT';
            
            // Calcul du taux moyen
            const avgCollateralRate = collateralRates.length > 0 
                ? (collateralRates.reduce((a, b) => a + b, 0) / collateralRates.length)
                : 0;
            document.getElementById('avg-collateral-rate').textContent = avgCollateralRate.toFixed(2) + '%';
            
            // Affichage des échéances avec statut de collatéral
            const dueDatesContainer = document.getElementById('upcoming-due-dates');
            if (upcomingDueDates.length > 0) {
                upcomingDueDates.sort((a, b) => a.dueDate - b.dueDate);
                
                let html = '<div class="list-group">';
                upcomingDueDates.slice(0, 5).forEach(due => {
                    const statusClass = due.collateralStatus === 'libéré' ? 'bg-success' 
                                    : due.collateralStatus === 'staké' ? 'bg-info' 
                                    : 'bg-warning text-dark';
                    
                    html += `
                        <div class="list-group-item bg-darker text-white mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Facture #${due.id}</h6>
                                    <small>${due.dueDate.toLocaleDateString('fr-FR')}</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge ${statusClass}">
                                        ${due.collateralStatus}
                                    </span>
                                    <span class="badge bg-orange">
                                        ${due.amount.toFixed(2)} USDT
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                
                dueDatesContainer.innerHTML = html;
            } else {
                dueDatesContainer.innerHTML = '<p class="text-muted text-center">Aucune échéance à venir</p>';
            }
            
        } catch (error) {
            console.error('Error loading enterprise stats:', error);
            // Vous pouvez ajouter ici un affichage d'erreur dans l'UI si nécessaire
        }
    }

    // Dans setupEnterpriseForms(), ajoutez un écouteur pour l'onglet Statistiques
    const statsTabButton = document.getElementById('stats-tab');
    if (statsTabButton) {
        statsTabButton.addEventListener('shown.bs.tab', loadEnterpriseStats);
    }

    // Configurer les écouteurs d'événements pour les actions sur les factures
    function setupInvoiceActionListeners() {
        // Zoom sur l'image
        document.querySelectorAll('.invoice-image').forEach(img => {
            img.addEventListener('click', function() {
                const src = this.getAttribute('src');
                window.open(src, '_blank');
            });
        });
        // Dépôt de collatéral
        document.querySelectorAll('.deposit-collateral-btn').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                e.preventDefault();
                const invoiceId = e.currentTarget.dataset.invoiceId;
                const collateralAmount = e.currentTarget.dataset.amount;
                
                try {
                    const confirmed = await window.uiUtils.showConfirmAlert(
                        `Déposer ${collateralAmount} USDT comme collatéral?`,
                        'Cette action est irréversible.'
                    );
                    
                    if (confirmed) {
                        await window.enterpriseFunctions.depositCollateral(invoiceId);
                        await loadCompanyInvoices();
                        window.uiUtils.showSuccessAlert('Collatéral déposé avec succès!');
                    }
                } catch (error) {
                    console.error('Deposit failed:', error);
                    window.uiUtils.showErrorAlert('Erreur lors du dépôt: ' + error.message);
                }
            });
        });
        
        
        // Retrait des fonds
        document.querySelectorAll('.withdraw-funds-btn').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                e.preventDefault();
                const invoiceId = e.currentTarget.dataset.invoiceId;
                
                try {
                    await window.enterpriseFunctions.withdrawCollectedFunds(invoiceId);
                    await loadCompanyInvoices();
                    window.uiUtils.showSuccessAlert('Fonds retirés avec succès!');
                } catch (error) {
                    console.error('Withdrawal failed:', error);
                    window.uiUtils.showErrorAlert('Erreur lors du retrait: ' + error.message);
                }
            });
        });
        
        // Libération du collatéral
        document.querySelectorAll('.release-collateral-btn').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                e.preventDefault();
                const invoiceId = e.currentTarget.dataset.invoiceId;
                
                try {
                    await window.enterpriseFunctions.releaseCollateral(invoiceId);
                    await loadCompanyInvoices();
                    window.uiUtils.showSuccessAlert('Collatéral libéré avec succès!');
                } catch (error) {
                    console.error('Release failed:', error);
                    window.uiUtils.showErrorAlert('Erreur lors de la libération: ' + error.message);
                }
            });
        });
        
        // Affichage des détails
        document.querySelectorAll('.view-invoice-details').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                e.preventDefault();
                const invoiceId = e.currentTarget.dataset.invoiceId;
                await showInvoiceDetails(invoiceId);
            });
        });
    }
    
    // Fonction pour afficher les détails d'une facture dans un modal
    async function showInvoiceDetails(invoiceId) {
    try {
        // Récupérer les détails de la facture
        const invoiceData = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        const { invoice, metadata } = invoiceData;
        
        // Récupérer les détails du collatéral si nécessaire
        const collateralDetails = await window.sharedFunctions.getCollateralDetails(invoiceId);
        console.log('Détails de la facture:', { invoice, metadata, collateralDetails });

        // Fonction de conversion sécurisée
        const safeFormatEther = (value) => {
            try {
                // Si c'est déjà un BigNumber, on le formate directement
                if (value._isBigNumber) {
                    return ethers.utils.formatEther(value);
                }
                // Si c'est une chaîne avec un point décimal, on la convertit en entier
                if (typeof value === 'string' && value.includes('.')) {
                    value = parseFloat(value).toFixed(0); // Enlève les décimales
                }
                return ethers.utils.formatEther(value.toString());
            } catch (e) {
                console.error('Erreur de formatage:', e);
                return '0.0';
            }
        };

        // Formater les dates
        const formatDate = (timestamp) => {
            return new Date(timestamp * 1000).toLocaleDateString('fr-FR');
        };

        // Remplir les informations du modal
        document.getElementById('modalInvoiceId').textContent = invoiceId;
        document.getElementById('modalCompanyName').textContent = metadata?.companyName || 'Non spécifié';
        document.getElementById('modalClientName').textContent = metadata?.clientName || 'Non spécifié';
        document.getElementById('modalAmount').textContent = `${safeFormatEther(invoice.details.amount)} USDT`;
        document.getElementById('modalInterestRate').textContent = `${invoice.details.interestRate / 100}%`;
        document.getElementById('modalFundingEndDate').textContent = formatDate(invoice.details.fundingEndDate);
        document.getElementById('modalDueDate').textContent = formatDate(invoice.details.dueDate);
        document.getElementById('modalDescription').textContent = metadata?.description || 'Aucune description disponible';

        // Statut du collatéral
        let collateralStatus = 'Non requis';
        if (invoice.details.requireCollateral || (collateralDetails?.initialDeposit > 0)) {
            collateralStatus = collateralDetails.initialDeposit > 0 
                ? `Payé (${collateralDetails.initialDeposit} USDT)` 
                : 'Requis';
        }
        document.getElementById('modalCollateralStatus').textContent = collateralStatus;

        // Progression du financement
        const amount = parseFloat(safeFormatEther(invoice.details.amount));
        const collected = parseFloat(safeFormatEther(invoice.financials.collectedAmount));
        const progress = amount > 0 ? (collected / amount * 100).toFixed(2) : 0;
        
        document.getElementById('modalCollectedAmount').textContent = `${collected.toFixed(2)} / ${amount.toFixed(2)} USDT (${progress}%)`;
        document.getElementById('modalFundingProgress').style.width = `${progress}%`;

        // Document de la facture
        const docPreview = document.getElementById('modalDocumentPreview');
        docPreview.innerHTML = '';
        
        if (metadata?.documentURI) {
            const docUrl = window.ipfsUtils.getIPFSGatewayURL(metadata.documentURI);
            docPreview.innerHTML = `
                <img src="${docUrl}" class="img-fluid rounded border border-secondary" 
                    style="max-height: 300px; cursor: pointer;" 
                    onclick="window.open('${docUrl}', '_blank')" 
                    alt="Document de facture">
            `;
        } else {
            docPreview.innerHTML = '<p class="text-muted text-center">Aucun document disponible</p>';
        }

        // Afficher le modal
        const modal = new bootstrap.Modal(document.getElementById('invoiceDetailsModal'));
        modal.show();

    } catch (error) {
        console.error('Error showing invoice details:', error);
        window.uiUtils.showErrorAlert('Erreur lors du chargement des détails de la facture: ' + error.message);
    }
}
    

    function setupEnterpriseFilters() {
        // Initialiser tous les dropdowns Bootstrap
        const dropdowns = document.querySelectorAll('.dropdown-toggle');
        dropdowns.forEach(dropdown => {
            new bootstrap.Dropdown(dropdown);
        });

        // Gérer les clics sur les options de filtre
        document.querySelectorAll('.filter-option').forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Retirer la classe active de toutes les options
                document.querySelectorAll('.filter-option').forEach(opt => {
                    opt.classList.remove('active');
                });
                
                // Ajouter la classe active à l'option sélectionnée
                this.classList.add('active');
                
                // Mettre à jour le texte du bouton avec le filtre sélectionné
                const filterText = this.textContent;
                document.querySelector('#invoiceFilterDropdown .filter-text').textContent = filterText;
                
                // Appliquer le filtre
                const filter = this.dataset.filter;
                filterInvoices(filter);
            });
        });
    }
    
    async function filterInvoices(filter) {
        const invoiceCards = document.querySelectorAll('#invoices-container .col');
        
        invoiceCards.forEach(card => {
            const statusBadge = card.querySelector('.badge').textContent.toLowerCase();
            const isPaid = statusBadge.includes('remboursée');
            const isPartiallyFunded = statusBadge.includes('partiellement');
            const isFullyFunded = statusBadge.includes('entièrement') || statusBadge.includes('financée');
            const needsCollateral = statusBadge.includes('collatéral requis');
            
            let showCard = false;
            
            switch(filter) {
                case 'all':
                    showCard = true;
                    break;
                case 'paid':
                    showCard = isPaid;
                    break;
                case 'unpaid':
                    showCard = !isPaid;
                    break;
                case 'partially':
                    showCard = isPartiallyFunded && !isFullyFunded;
                    break;
                case 'fully':
                    showCard = isFullyFunded;
                    break;
                case 'collateral-needed':
                    showCard = needsCollateral;
                    break;
                case 'no-collateral':
                    showCard = !needsCollateral;
                    break;
                default:
                    showCard = true;
            }
            
            card.style.display = showCard ? 'block' : 'none';
        });
    }


    // Charger les factures au démarrage
    const invoicesTabButton = document.getElementById('invoices-tab');
    if (invoicesTabButton) {
        invoicesTabButton.addEventListener('shown.bs.tab', loadCompanyInvoices);
        if (invoicesTabButton.classList.contains('active')) {
            loadCompanyInvoices();
        }
    }
}


/**
 * Configure les formulaires investisseur
 */
function setupInvestorForms() {
    console.log('💰 Setting up investor forms...');
    
    // Initialisation des onglets
    const investorTab = document.getElementById('portfolio-tab');
    if (investorTab) {
        investorTab.addEventListener('shown.bs.tab', loadInvestorPortfolio);
        
        // Si l'onglet est actif au chargement
        if (investorTab.classList.contains('active')) {
            loadInvestorPortfolio();
        }
    }
    
    // Gestionnaires d'événements pour les filtres
    const invoiceFilter = document.getElementById('invoice-filter');
    if (invoiceFilter) {
        invoiceFilter.addEventListener('change', loadAvailableInvoices);
    }
    
    const invoiceSort = document.getElementById('invoice-sort');
    if (invoiceSort) {
        invoiceSort.addEventListener('change', loadAvailableInvoices);
    }
    
    const poolFilter = document.getElementById('pool-filter');
    if (poolFilter) {
        poolFilter.addEventListener('change', loadInvestmentPools);
    }
    
    const poolSort = document.getElementById('pool-sort');
    if (poolSort) {
        poolSort.addEventListener('change', loadInvestmentPools);
    }
    
    // Gestionnaire pour l'onglet Investir
    const investTab = document.getElementById('invest-tab');
    if (investTab) {
        investTab.addEventListener('shown.bs.tab', loadAvailableInvoices);
    }
    
    // Gestionnaire pour l'onglet Pools
    const poolsTab = document.getElementById('pools-tab');
    if (poolsTab) {
        poolsTab.addEventListener('shown.bs.tab', loadInvestmentPools);
    }
    
    console.log('✅ Investor forms configured');
}

/**
 * Configure les formulaires client
 */
function setupClientForms() {
    // Repay invoice buttons
    document.addEventListener('click', async (e) => {
        if (e.target.classList.contains('repay-invoice-btn')) {
            const invoiceId = e.target.dataset.invoiceId;
            if (invoiceId) {
                try {
                    await window.clientFunctions.repayInvoice(invoiceId);
                    await updateAllUIElements();
                } catch (error) {
                    console.error('Invoice repayment failed:', error);
                }
            }
        }
    });
}

/**
 * Charge les données de la page selon le contexte
 */
async function loadPageData() {
    const currentPage = window.location.pathname;
    
    try {
        if (currentPage.includes('/dashboard')) {
            await loadDashboardData();
        } else if (currentPage.includes('/investor')) {
            await loadInvestorData();
        } else if (currentPage.includes('/enterprise')) {
            await loadEnterpriseData();
        } else if (currentPage.includes('/client')) {
            await loadClientData();
        } else if (currentPage.includes('/admin')) {
            await loadAdminData();
        }
    } catch (error) {
        console.error('❌ Error loading page data:', error);
    }
}

/**
 * Charge les données du dashboard
 */
async function loadDashboardData() {
    try {
        const stats = await window.sharedFunctions.getGlobalStatistics();
        updateDashboardStats(stats);
    } catch (error) {
        console.error('❌ Error loading dashboard data:', error);
    }
}

/**
 * Charge les données investisseur
 */
async function loadInvestorData() {
    if (!window.walletUtils.isWalletReady()) return;
    
    try {
        await loadInvestorPortfolio();
        await loadAvailableInvoices();
        await loadInvestmentPools();
    } catch (error) {
        console.error('❌ Error loading investor data:', error);
    }
}

/**
 * Charge les données entreprise
 */
async function loadEnterpriseData() {
    if (!window.walletUtils.isWalletReady()) return;
    
    try {
        const userAddress = window.walletUtils.getCurrentWalletAddress();
        const allInvoices = await window.sharedFunctions.getAllInvoices();
        const companyInvoices = window.sharedFunctions.filterInvoicesByCompany(allInvoices, userAddress);
        updateEnterpriseInvoices(companyInvoices);
    } catch (error) {
        console.error('❌ Error loading enterprise data:', error);
    }
}

/**
 * Charge les données client
 */
async function loadClientData() {
    if (!window.walletUtils.isWalletReady()) return;
    
    try {
        const clientInvoices = await window.clientFunctions.getClientInvoices();
        updateClientInvoices(clientInvoices);
    } catch (error) {
        console.error('❌ Error loading client data:', error);
    }
}

/**
 * Charge les données admin
 */
async function loadAdminData() {
    try {
        const [invoices, pools] = await Promise.all([
            window.sharedFunctions.getAllInvoices(),
            window.sharedFunctions.getAllPools()
        ]);
        
        updateAdminData(invoices, pools);
    } catch (error) {
        console.error('❌ Error loading admin data:', error);
    }
}

// *************************INVESTOR*******************************
// Fonction pour charger le portefeuille de l'investisseur
async function loadInvestorPortfolio() {
    try {
        $('#investor-portfolio-list').html(`
            <p class="text-muted text-center">Chargement de votre portefeuille...</p>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-orange" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);
        
        if (!window.walletUtils.isWalletReady()) {
            $('#investor-portfolio-list').html(`
                <div class="alert alert-warning text-center">
                    Veuillez connecter votre portefeuille pour voir votre portefeuille d'investissements.
                </div>
            `);
            return;
        }
        
        const portfolio = await window.investorFunctions.getInvestorPortfolio();

        console.log("Investor portfolio data0000:", portfolio);
        
        // Mettre à jour les statistiques
        // Mettre à jour les statistiques - AJOUTER UNE VÉRIFICATION
        $('#active-investments-count').text(portfolio.activeInvestments);
        
        // Afficher 0.00 si le montant est inférieur à 0.01 USDT
        const displayTotalInvested = portfolio.totalInvested < 0.01 ? '0.00' : portfolio.totalInvested.toFixed(2);
        $('#total-invested-amount').text(displayTotalInvested + ' USDT');
        
        const displayTotalClaimable = portfolio.totalClaimable < 0.01 ? '0.00' : portfolio.totalClaimable.toFixed(2);
        $('#total-claimable-amount').text(displayTotalClaimable + ' USDT');
        
        if (portfolio.portfolio.length === 0) {
            $('#investor-portfolio-list').html(`
                <div class="text-center py-4">
                    <i class="bi bi-wallet2 text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Aucun investissement trouvé</h5>
                    <p class="text-muted">Vous n'avez pas encore investi dans des factures ou pools.</p>
                    <a href="#invest" class="btn btn-orange" data-bs-toggle="tab">Commencer à investir</a>
                </div>
            `);
            return;
        }
        
        let html = '';
        portfolio.portfolio.forEach(invoice => {
            const dueDate = new Date(invoice.dueDate).toLocaleDateString();
            const statusBadge = invoice.isPaid ? 
                `<span class="badge bg-success">Payée</span>` : 
                `<span class="badge bg-info">Active</span>`;
            
            const claimButton = invoice.canClaim ? 
                `<button class="btn btn-success btn-sm claim-funds-btn" data-invoice-id="${invoice.invoiceId}">
                    <i class="bi bi-cash-coin"></i> Réclamer
                </button>` : '';
            
            // Formatage du montant investi
            const displayInvested = invoice.investedAmount === 0 ? '0.00' : 
                invoice.investedAmount < 0.01 ? '0.00' : 
                invoice.investedAmount.toFixed(2);
            
            html += `
                <div class="card mb-3 bg-dark text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title text-orange">Facture #${invoice.invoiceId} ${statusBadge}</h5>
                                <p class="mb-1"><small>Entreprise: ${invoice.company}</small></p>
                                <p class="mb-1"><small>Montant: ${invoice.amount} USDT</small></p>
                                <p class="mb-1"><small>Taux d'intérêt: ${invoice.interestRate}%</small></p>
                                <p class="mb-1"><small>Échéance: ${dueDate}</small></p>
                            </div>
                            <div class="text-end">
                                <p class="mb-1"><small>Vos parts: ${invoice.sharesPercentage.toFixed(2)}%</small></p>
                                <p class="mb-1"><small>Investi: ${displayInvested} USDT</small></p>
                                ${invoice.isPaid ? `<p class="mb-1"><small>À réclamer: ${invoice.claimableAmount.toFixed(2)} USDT</small></p>` : ''}
                                ${claimButton}
                                <button class="btn btn-orange btn-sm view-invoice-btn" data-invoice-id="${invoice.invoiceId}">
                                    <i class="bi bi-eye"></i> Détails
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#investor-portfolio-list').html(html);
        
        // Ajouter les gestionnaires d'événements
        $('.claim-funds-btn').click(async function() {
            const invoiceId = $(this).data('invoice-id');
            await showClaimFundsModal(invoiceId);
        });
        
        $('.view-invoice-btn').click(async function() {
            const invoiceId = $(this).data('invoice-id');
            await showInvoiceDetailsModal(invoiceId);
        });
        
    } catch (error) {
        console.error('Error loading investor portfolio:', error);
        $('#investor-portfolio-list').html(`
            <div class="alert alert-danger text-center">
                Erreur lors du chargement du portefeuille: ${error.message}
            </div>
        `);
    }
}

// Fonction pour charger les factures disponibles
async function showFinancialDetails(invoiceId) {
    try {
        const invoiceData = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        console.log("Données de la facture:", invoiceData);

        // Extraction des données
        const details = invoiceData.invoice[0] || {};
        const financials = invoiceData.invoice[1] || {};

        if (!details.amount) {
            throw new Error("Montant de la facture non disponible");
        }
        
        // Récupération des paramètres
        const commissionRates = await window.sharedFunctions.getCommissionRates();
        
        // Conversion des montants
        const invoiceAmount = parseFloat(ethers.utils.formatEther(details.amount));
        const collectedAmount = parseFloat(ethers.utils.formatEther(financials.collectedAmount || details.amount));
        const interestRate = details.interestRate / 100; // Conversion en décimal (10% → 0.10)
        
        // Calcul de la durée en jours
        const fundingDuration = Math.round((details.dueDate - details.fundingEndDate) / (60 * 60 * 24));
        
        // Calcul des frais et intérêts (CORRIGÉ)
        const platformFee = collectedAmount * (commissionRates.issuanceFee / 10000); // 3% = 300 en base 10000
        const interestAmount = collectedAmount * interestRate; // 0.10 pour 10%
        const netAmount = collectedAmount - platformFee - interestAmount;
        
        // Création du modal
        const modalHTML = `
            <div class="modal fade" id="financialDetailsModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title text-orange">Détails Financiers - Facture #${invoiceId}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card bg-darker mb-3">
                                <div class="card-body">
                                    <h6 class="text-orange">Récapitulatif</h6>
                                    <table class="table table-dark table-sm">
                                        <tr>
                                            <td>Montant Facture Total:</td>
                                            <td class="text-end">${invoiceAmount.toFixed(2)} USDT</td>
                                        </tr>
                                        <tr>
                                            <td>Montant Collecté:</td>
                                            <td class="text-end">${collectedAmount.toFixed(2)} USDT</td>
                                        </tr>
                                        <tr class="text-danger">
                                            <td>Frais Plateforme (${commissionRates.issuanceFee / 100}%):</td>
                                            <td class="text-end">-${platformFee.toFixed(2)} USDT</td>
                                        </tr>
                                        <tr class="text-info">
                                            <td>Intérêts (${(interestRate * 100).toFixed(2)}%):</td>
                                            <td class="text-end">-${interestAmount.toFixed(2)} USDT</td>
                                        </tr>
                                        <tr class="${netAmount >= 0 ? 'table-success' : 'table-danger'}">
                                            <td><strong>Montant Net Disponible:</strong></td>
                                            <td class="text-end"><strong>${netAmount.toFixed(2)} USDT</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="alert ${netAmount >= 0 ? 'alert-info' : 'alert-warning'} mt-3">
                                <i class="bi bi-info-circle"></i> 
                                Calcul: ${collectedAmount.toFixed(2)} - ${platformFee.toFixed(2)} (frais) - ${interestAmount.toFixed(2)} (intérêts) = ${netAmount.toFixed(2)} USDT
                                <br>Durée: ${fundingDuration} jours | Taux: ${(interestRate * 100).toFixed(2)}% annuel
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Ajout et affichage du modal
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        const modal = new bootstrap.Modal(document.getElementById('financialDetailsModal'));
        modal.show();
        
        // Nettoyage après fermeture
        document.getElementById('financialDetailsModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
        
    } catch (error) {
        console.error('Error showing financial details:', error);
        window.uiUtils.showErrorAlert('Erreur lors du chargement des détails financiers: ' + error.message);
    }
}

// Fonction pour charger les factures disponibles
async function loadAvailableInvoices() {
    try {
        $('#available-invoices-list').html(`
            <p class="text-muted text-center">Chargement des factures disponibles...</p>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-orange" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);
        
        if (!window.walletUtils.isWalletReady()) {
            $('#available-invoices-list').html(`
                <div class="alert alert-warning text-center">
                    Veuillez connecter votre portefeuille pour voir les factures disponibles.
                </div>
            `);
            return;
        }
        
        const allInvoices = await window.sharedFunctions.getAllInvoices();
        const now = Math.floor(Date.now() / 1000); // Timestamp actuel en secondes
        
        // Formatage des dates complètes avec heures et minutes
        const formatFullDateTime = (timestamp) => {
            const date = new Date(timestamp * 1000);
            return date.toLocaleString('fr-FR', {
                timeZone: 'UTC',
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
                timeZoneName: 'short'
            }).replace(',', '').replace('UTC', 'GMT');
        };
        

        // Filtrer les factures disponibles pour l'investissement
        const availableInvoices = allInvoices.filter(invoice => {
            // Vérification précise avec heures et minutes
            const isActive = invoice.details.isActive;
            const fundingNotEnded = now < invoice.details.fundingEndDate;
            const notFullyFunded = invoice.financials.collectedAmount.lt(invoice.details.amount);
            
            return isActive && fundingNotEnded && notFullyFunded;
        });
        
        if (allInvoices.length === 0) {
            $('#available-invoices-list').html(`
                <div class="text-center py-4">
                    <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Aucune facture disponible</h5>
                    <p class="text-muted">Toutes les factures ont été financées ou ne sont pas encore disponibles.</p>
                </div>
            `);
            return;
        }
        
        // Appliquer les filtres et tris
        const filter = $('#invoice-filter').val();
        const sort = $('#invoice-sort').val();
        
        let filteredInvoices = [...allInvoices];
        
        // Filtrage avec prise en compte des heures/minutes
        if (filter === 'active') {
            filteredInvoices = filteredInvoices.filter(invoice => invoice.details.isActive);
        } else if (filter === 'funded') {
            filteredInvoices = filteredInvoices.filter(invoice => 
                invoice.financials.collectedAmount.gte(invoice.details.amount.div(2)));
        } else if (filter === 'high-interest') {
            filteredInvoices = filteredInvoices.filter(invoice => 
                invoice.details.interestRate > 1500);
        } else if (filter === 'short-term') {
            // Moins de 30 jours (précis jusqu'à la minute)
            filteredInvoices = filteredInvoices.filter(invoice => {
                const secondsRemaining = invoice.details.dueDate - now;
                return secondsRemaining < 30 * 24 * 60 * 60;
            });
        }
        
        // Tri sécurisé
        if (sort === 'newest') {
            filteredInvoices.sort((a, b) => b.details.invoiceId - a.details.invoiceId);
        } else if (sort === 'oldest') {
            filteredInvoices.sort((a, b) => a.details.invoiceId - b.details.invoiceId);
        } else if (sort === 'amount-asc') {
            filteredInvoices.sort((a, b) => {
                const aAmount = parseFloat(ethers.utils.formatEther(a.details.amount));
                const bAmount = parseFloat(ethers.utils.formatEther(b.details.amount));
                return aAmount - bAmount;
            });
        } else if (sort === 'amount-desc') {
            filteredInvoices.sort((a, b) => {
                const aAmount = parseFloat(ethers.utils.formatEther(a.details.amount));
                const bAmount = parseFloat(ethers.utils.formatEther(b.details.amount));
                return bAmount - aAmount;
            });
        } else if (sort === 'interest-asc') {
            filteredInvoices.sort((a, b) => a.details.interestRate - b.details.interestRate);
        } else if (sort === 'interest-desc') {
            filteredInvoices.sort((a, b) => b.details.interestRate - a.details.interestRate);
        }
        
        let html = '<div class="row">';
        filteredInvoices.forEach(invoice => {
            const amount = ethers.utils.formatEther(invoice.details.amount);
            const collected = ethers.utils.formatEther(invoice.financials.collectedAmount);
            const progress = (collected / amount * 100).toFixed(2);
            const interestRate = (invoice.details.interestRate / 100).toFixed(2);
            
            // Dates formatées complètes avec heures et minutes
            const fundingEndDate = formatFullDateTime(invoice.details.fundingEndDate);
            const dueDate = formatFullDateTime(invoice.details.dueDate);
            
            // Vérification précise de la disponibilité
            const isFundingEnded = now >= invoice.details.fundingEndDate;
            const isActive = invoice.details.isActive;
            const isFullyFunded = invoice.financials.collectedAmount.gte(invoice.details.amount);
            const canInvest = isActive && !isFundingEnded && !isFullyFunded;
            
            // Calcul du rendement potentiel
            const daysToDue = Math.max(0, (invoice.details.dueDate - now) / (24 * 60 * 60));
            if (window.investorFunctions && window.investorFunctions.getInvestorPortfolio) {
                const returnInfo = window.investorFunctions.calculateInvestmentReturn(
                    100, 
                    interestRate, 
                    daysToDue
                );
            } else {
                console.error('investorFunctions ou getInvestorPortfolio non disponible');
            }
            // const returnInfo = window.investorFunctions.calculateInvestmentReturn(
            //     100, 
            //     interestRate, 
            //     daysToDue
            // );
            
            // Image de la facture
            const invoiceImage = invoice.metadata?.documentURI ? 
                window.ipfsUtils.getIPFSGatewayURL(invoice.metadata.documentURI) : 
                'https://via.placeholder.com/300x150?text=Facture';
            
            html += `
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white h-100">
                        <img src="${invoiceImage}" class="card-img-top" style="height: 150px; object-fit: cover; cursor: pointer;" 
                             onclick="window.open('${invoiceImage}', '_blank')" 
                             alt="Document de facture">
                        <div class="card-body">
                            <h5 class="card-title text-orange">Facture #${invoice.details.invoiceId.toString()}</h5>
                            <p class="mb-1"><small>Entreprise: ${invoice.metadata?.companyName || 'Inconnue'}</small></p>
                            <p class="mb-1"><small>Montant: ${amount} USDT</small></p>
                            <p class="mb-1"><small>Taux: ${interestRate}%</small></p>
                            <p class="mb-1"><small>Fin collecte: ${fundingEndDate}</small></p>
                            <p class="mb-1"><small>Échéance: ${dueDate}</small></p>
                            
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: ${progress}%"></div>
                            </div>
                            <p class="text-end small mt-1">${collected} / ${amount} USDT (${progress}%)</p>
                            
                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-info btn-sm view-invoice-btn" data-invoice-id="${invoice.details.invoiceId.toString()}">
                                    <i class="bi bi-eye"></i> Détails
                                </button>
                                <button class="btn btn-orange btn-sm invest-invoice-btn" 
                                        data-invoice-id="${invoice.details.invoiceId.toString()}"
                                        ${canInvest ? '' : 'disabled'}>
                                    <i class="bi bi-coin"></i> ${canInvest ? 'Investir' : 'Indisponible'}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        
        $('#available-invoices-list').html(html);
        
        // Gestionnaires d'événements
        $('.invest-invoice-btn:not(:disabled)').click(async function() {
            const invoiceId = $(this).data('invoice-id');
            await showInvestInvoiceModal(invoiceId);
        });
        
        $('.view-invoice-btn').click(async function() {
            const invoiceId = $(this).data('invoice-id');
            await showInvoiceDetailsModal(invoiceId);
        });
        
    } catch (error) {
        console.error('Error loading available invoices:', error);
        $('#available-invoices-list').html(`
            <div class="alert alert-danger text-center">
                Erreur lors du chargement des factures: ${error.message}
            </div>
        `);
    }
}

// Fonction pour charger les pools d'investissement
async function loadInvestmentPools() {
    try {
        // Afficher le loader
        $('#investment-pools-list').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-orange" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-3 text-muted">Chargement des pools d'investissement...</p>
            </div>
        `);

        // Vérifier la connexion du portefeuille
        if (!window.walletUtils.isWalletReady()) {
            $('#investment-pools-list').html(`
                <div class="alert alert-warning text-center py-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Veuillez connecter votre portefeuille pour voir les pools disponibles
                </div>
            `);
            return;
        }

        // Récupérer tous les pools
        const allPools = await window.sharedFunctions.getAllPools();

        // Enrichir chaque pool avec ses données
        const enrichedPools = await Promise.all(allPools.map(async pool => {
            try {
                const poolInvoices = await window.sharedFunctions.getPoolInvoices(pool.poolId);
                
                // Calcul des montants
                let totalAmount = ethers.BigNumber.from(0);
                let collectedAmount = ethers.BigNumber.from(0);
                
                if (poolInvoices?.length > 0) {
                    poolInvoices.forEach(invoice => {
                        totalAmount = totalAmount.add(invoice.details?.amount || 0);
                        collectedAmount = collectedAmount.add(invoice.financials?.collectedAmount || 0);
                    });
                }
                
                const progress = totalAmount.gt(0) ? 
                    collectedAmount.mul(100).div(totalAmount).toNumber() : 0;
                
                // Déterminer l'état du pool
                const hasMaxInvoices = poolInvoices.length >= pool.maxInvoiceCount;
                const canInvest = hasMaxInvoices && pool.isActive && 
                    await window.sharedFunctions.canInvestInPool({
                        ...pool,
                        invoiceIds: poolInvoices.map(i => i.details.invoiceId)
                    });

                // Déterminer le type de pool pour le style
                let poolType = '';
                if (!pool.isActive) {
                    poolType = 'inactive';
                } else if (!hasMaxInvoices) {
                    poolType = 'waiting';
                } else if (canInvest) {
                    poolType = 'ready';
                } else {
                    poolType = 'unavailable';
                }

                return {
                    ...pool,
                    poolType,
                    totalAmount,
                    collectedAmount,
                    progress,
                    invoiceCount: poolInvoices.length,
                    hasMaxInvoices,
                    canInvest,
                    missingInvoices: pool.maxInvoiceCount - poolInvoices.length
                };
            } catch (error) {
                console.error(`Error enriching pool ${pool.poolId}:`, error);
                return {
                    ...pool,
                    poolType: 'error',
                    totalAmount: ethers.BigNumber.from(0),
                    collectedAmount: ethers.BigNumber.from(0),
                    progress: 0,
                    invoiceCount: 0,
                    hasMaxInvoices: false,
                    canInvest: false,
                    missingInvoices: pool.maxInvoiceCount
                };
            }
        }));

        // Trier les pools (ready > waiting > inactive)
        enrichedPools.sort((a, b) => {
            const typeOrder = { 'ready': 1, 'waiting': 2, 'inactive': 3, 'unavailable': 4, 'error': 5 };
            return typeOrder[a.poolType] - typeOrder[b.poolType] || a.poolId - b.poolId;
        });

        // Générer le HTML
        let html = '<div class="row g-4">';
        
        enrichedPools.forEach(pool => {
            const minInvestment = ethers.utils.formatEther(pool.minInvestment || 0);
            const bannerUrl = pool.metadata?.bannerURI ? 
                window.ipfsUtils.getIPFSGatewayURL(pool.metadata.bannerURI) : 
                'https://via.placeholder.com/600x200?text=' + encodeURIComponent(pool.name);
            
            // Styles dynamiques en fonction du type de pool
            const cardClasses = {
                'ready': 'border-success pool-card-ready',
                'waiting': 'border-warning pool-card-waiting',
                'inactive': 'border-secondary pool-card-inactive',
                'unavailable': 'border-danger pool-card-unavailable',
                'error': 'border-dark pool-card-error'
            }[pool.poolType];

            const headerClasses = {
                'ready': 'bg-success-dark text-white',
                'waiting': 'bg-warning-dark text-dark',
                'inactive': 'bg-secondary-dark text-white',
                'unavailable': 'bg-danger-dark text-white',
                'error': 'bg-dark text-white'
            }[pool.poolType];

            const statusBadge = {
                'ready': `<span class="badge bg-success"><i class="bi bi-check-circle"></i> Prêt</span>`,
                'waiting': `<span class="badge bg-warning text-dark"><i class="bi bi-hourglass"></i> En attente (${pool.missingInvoices} facture${pool.missingInvoices > 1 ? 's' : ''})</span>`,
                'inactive': `<span class="badge bg-secondary"><i class="bi bi-pause-circle"></i> Inactif</span>`,
                'unavailable': `<span class="badge bg-danger"><i class="bi bi-slash-circle"></i> Indisponible</span>`,
                'error': `<span class="badge bg-dark"><i class="bi bi-exclamation-triangle"></i> Erreur</span>`
            }[pool.poolType];

            html += `
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 ${cardClasses}">
                        <div class="card-header d-flex justify-content-between align-items-center ${headerClasses}">
                            <div>${statusBadge}</div>
                            <small class="text-muted">#${pool.poolId}</small>
                        </div>
                        
                        <div class="card-img-container position-relative">
                            <img src="${bannerUrl}" class="card-img-top ${pool.poolType !== 'ready' ? 'img-disabled' : ''}" 
                                 alt="${pool.name}" style="height: 160px; object-fit: cover;">
                                 
                            ${pool.poolType === 'waiting' ? `
                                <div class="pool-waiting-overlay">
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-hourglass"></i> ${pool.missingInvoices} facture${pool.missingInvoices > 1 ? 's' : ''} manquante${pool.missingInvoices > 1 ? 's' : ''}
                                    </span>
                                </div>
                            ` : ''}
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title text-orange">${pool.name}</h5>
                            <p class="card-text text-muted small">${pool.metadata?.description?.substring(0, 120) || 'Aucune description disponible'}...</p>
                            
                            <div class="pool-stats">
                                <div class="stat-item">
                                    <i class="bi bi-coin"></i>
                                    <span>Min: ${minInvestment} USDT</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-receipt"></i>
                                    <span>${pool.invoiceCount}/${pool.maxInvoiceCount} factures</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi ${pool.metadata?.riskLevel?.toLowerCase().includes('low') ? 'bi-shield-check' : 'bi-shield-exclamation'}"></i>
                                    <span>${pool.metadata?.riskLevel || 'Risque moyen'}</span>
                                </div>
                            </div>
                            
                            <div class="progress mt-3" style="height: 6px;">
                                <div class="progress-bar ${pool.progress >= 100 ? 'bg-success' : 'bg-info'}" 
                                     style="width: ${Math.min(100, pool.progress)}%" 
                                     role="progressbar" 
                                     aria-valuenow="${pool.progress}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                            <small class="text-muted d-block text-end mt-1">
                                ${ethers.utils.formatEther(pool.collectedAmount || 0)} / ${ethers.utils.formatEther(pool.totalAmount || 0)} USDT
                            </small>
                        </div>
                        
                        <div class="card-footer bg-darker border-0">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-orange btn-sm view-pool-btn" 
                                        data-pool-id="${pool.poolId}">
                                    <i class="bi bi-eye-fill"></i> Voir détails
                                </button>
                                
                                <button class="btn ${pool.canInvest ? 'btn-orange' : 'btn-secondary'} btn-sm invest-pool-btn" 
                                        data-pool-id="${pool.poolId}" 
                                        data-min-investment="${minInvestment}"
                                        ${pool.canInvest ? '' : 'disabled'}
                                        data-bs-toggle="tooltip" 
                                        data-bs-html="true"
                                        title="${pool.canInvest ? 
                                            '<span>Investir dans ce pool</span>' : 
                                            !pool.hasMaxInvoices ? 
                                                `<span>En attente de ${pool.missingInvoices} facture${pool.missingInvoices > 1 ? 's' : ''}<br>Minimum requis: ${pool.maxInvoiceCount}</span>` :
                                            !pool.isActive ? 
                                                '<span>Le pool est actuellement inactif</span>' : 
                                                '<span>Investissement temporairement indisponible</span>'}">
                                    <i class="bi ${pool.canInvest ? 'bi-coin' : 'bi-lock'}"></i>
                                    ${pool.canInvest ? 'Investir' : 'Indisponible'}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        // Cas où il n'y a aucun pool
        if (enrichedPools.length === 0) {
            html = `
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
                        <h5 class="mt-3 text-muted">Aucun pool disponible</h5>
                        <p class="text-muted">Aucun pool d'investissement n'est actuellement disponible.</p>
                    </div>
                </div>
            `;
        }

        html += '</div>'; // Fermer la row
        
        $('#investment-pools-list').html(html);
        
        // Activer les tooltips
        $('[data-bs-toggle="tooltip"]').tooltip({
            trigger: 'hover',
            placement: 'top'
        });
        
        // Gestionnaires d'événements
        $('.invest-pool-btn').click(async function() {
            const poolId = $(this).data('pool-id');
            const minInvestment = $(this).data('min-investment');
            
            // Double vérification avant d'investir
            const poolDetails = await window.sharedFunctions.getPoolDetails(poolId);
            const poolInvoices = await window.sharedFunctions.getPoolInvoices(poolId);
            
            if (poolInvoices.length < poolDetails.maxInvoiceCount) {
                window.uiUtils.showErrorAlert(
                    `Ce pool nécessite encore ${poolDetails.maxInvoiceCount - poolInvoices.length} ` +
                    `facture${poolDetails.maxInvoiceCount - poolInvoices.length > 1 ? 's' : ''} ` +
                    `pour être disponible à l'investissement.`
                );
                return;
            }
            
            await showInvestPoolModal(poolId, minInvestment);
        });
        
        $('.view-pool-btn').click(async function() {
            const poolId = $(this).data('pool-id');
            await showPoolDetailsModal(poolId);
        });

    } catch (error) {
        console.error('Error loading investment pools:', error);
        $('#investment-pools-list').html(`
            <div class="alert alert-danger text-center py-4">
                <i class="bi bi-exclamation-octagon-fill me-2"></i>
                Une erreur est survenue lors du chargement des pools.<br>
                <small class="text-muted">${error.message || 'Erreur inconnue'}</small>
            </div>
        `);
    }
}


// Fonction pour afficher le modal d'investissement dans une facture
async function showInvestInvoiceModal(invoiceId) {
    try {
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        $('#modalInvoiceId').text(invoiceId);
        $('#investmentAmount').val('');
        $('#investmentGrossAmount').text('0 USDT');
        $('#investmentEntryFee').text('0 USDT (0%)');
        $('#investmentNetAmount').text('0 USDT');
        
        const investModal = new bootstrap.Modal(document.getElementById('investInvoiceModal'));
        investModal.show();
        
        // Calcul des frais en temps réel
        $('#investmentAmount').on('input', async function() {
            const amount = parseFloat($(this).val());
            if (isNaN(amount)) return;
            
            const rates = await window.sharedFunctions.getCommissionRates();
            const entryFee = amount * (rates.entryFee / 10000);
            const netAmount = amount - entryFee;
            
            $('#investmentGrossAmount').text(`${amount.toFixed(2)} USDT`);
            $('#investmentEntryFee').text(`${entryFee.toFixed(2)} USDT (${rates.entryFee / 100}%)`);
            $('#investmentNetAmount').text(`${netAmount.toFixed(2)} USDT`);
        });
        
        // Confirmation de l'investissement
        $('#confirmInvestInvoice').off('click').click(async function() {
            const amount = parseFloat($('#investmentAmount').val());
            
            if (isNaN(amount)) {
                window.uiUtils.showErrorAlert('Veuillez entrer un montant valide');
                return;
            }
            
            investModal.hide();
            
            try {
                await window.investorFunctions.investInInvoice(invoiceId, amount);
                loadInvestorPortfolio();
                loadAvailableInvoices();
            } catch (error) {
                console.error('Investment failed:', error);
            }
        });
        
    } catch (error) {
        console.error('Error showing invest modal:', error);
        window.uiUtils.showErrorAlert('Erreur lors du chargement des détails de la facture');
    }
}

// Fonction pour afficher le modal d'investissement dans un pool
async function showInvestPoolModal(poolId, minInvestment) {
    try {
        const { pool } = await window.sharedFunctions.getPoolDetails(poolId);
        
        $('#modalPoolName').text(pool.name);
        $('#poolInvestmentAmount').val(minInvestment);
        $('#poolMinInvestment').text(minInvestment);
        $('#poolInvestmentGrossAmount').text(`${minInvestment} USDT`);
        $('#poolInvestmentEntryFee').text('0 USDT (0%)');
        $('#poolInvestmentPoolFee').text('0 USDT (0%)');
        $('#poolInvestmentNetAmount').text(`${minInvestment} USDT`);
        
        const investModal = new bootstrap.Modal(document.getElementById('investPoolModal'));
        investModal.show();
        
        // Calcul des frais en temps réel
        $('#poolInvestmentAmount').on('input', async function() {
            const amount = parseFloat($(this).val());
            if (isNaN(amount)) return;
            
            const rates = await window.sharedFunctions.getCommissionRates();
            const entryFee = amount * (rates.entryFee / 10000);
            const poolFee = amount * (rates.poolFee / 10000);
            const totalFees = entryFee + poolFee;
            const netAmount = amount - totalFees;
            
            $('#poolInvestmentGrossAmount').text(`${amount.toFixed(2)} USDT`);
            $('#poolInvestmentEntryFee').text(`${entryFee.toFixed(2)} USDT (${rates.entryFee / 100}%)`);
            $('#poolInvestmentPoolFee').text(`${poolFee.toFixed(2)} USDT (${rates.poolFee / 100}%)`);
            $('#poolInvestmentNetAmount').text(`${netAmount.toFixed(2)} USDT`);
        });
        
        // Confirmation de l'investissement
        $('#confirmInvestPool').off('click').click(async function() {
            const amount = parseFloat($('#poolInvestmentAmount').val());
            
            if (isNaN(amount)) {
                window.uiUtils.showErrorAlert('Veuillez entrer un montant valide');
                return;
            }
            
            if (amount < minInvestment) {
                window.uiUtils.showErrorAlert(`Le montant minimum est de ${minInvestment} USDT`);
                return;
            }
            
            investModal.hide();
            
            try {
                await window.investorFunctions.investInPool(poolId, amount);
                loadInvestorPortfolio();
                loadInvestmentPools();
            } catch (error) {
                console.error('Pool investment failed:', error);
            }
        });
        
    } catch (error) {
        console.error('Error showing pool invest modal:', error);
        window.uiUtils.showErrorAlert('Erreur lors du chargement des détails du pool');
    }
}

// Fonction pour afficher le modal de réclamation de fonds
async function showClaimFundsModal(invoiceId) {
    try {
        const { invoice } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        const userAddress = window.walletUtils.getCurrentWalletAddress();
        const shares = await window.sharedFunctions.getInvestorShares(userAddress, invoiceId);
        
        const sharesFormatted = ethers.utils.formatEther(shares);
        const sharesPercentage = parseFloat(sharesFormatted) * 100;
        const claimableAmount = (parseFloat(ethers.utils.formatEther(invoice.financials.repaymentAmount)) * parseFloat(sharesFormatted) / 1e18);
        
        $('#claimInvoiceId').text(invoiceId);
        $('#claimSharesPercentage').text(`${sharesPercentage.toFixed(6)}%`);
        $('#claimableAmount').text(`${claimableAmount.toFixed(2)} USDT`);
        
        const claimModal = new bootstrap.Modal(document.getElementById('claimFundsModal'));
        claimModal.show();
        
        // Confirmation de la réclamation
        $('#confirmClaimFunds').off('click').click(async function() {
            claimModal.hide();
            
            try {
                await window.investorFunctions.claimFunds(invoiceId);
                loadInvestorPortfolio();
            } catch (error) {
                console.error('Claim funds failed:', error);
            }
        });
        
    } catch (error) {
        console.error('Error showing claim modal:', error);
        window.uiUtils.showErrorAlert('Erreur lors du chargement des détails de la facture');
    }
}

// Fonction pour afficher les détails d'une facture
async function showInvoiceDetailsModal(invoiceId) {
    try {
        const { invoice, metadata } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        $('#detailInvoiceId').text(invoiceId);
        $('#detailCompanyName').text(metadata?.companyName || 'Inconnue');
        $('#detailClientName').text(metadata?.clientName || 'Inconnu');
        $('#detailAmount').text(`${ethers.utils.formatEther(invoice.details.amount)} USDT`);
        $('#detailInterestRate').text(`${invoice.details.interestRate / 100}%`);
        $('#detailFundingEndDate').text(new Date(invoice.details.fundingEndDate * 1000).toLocaleDateString());
        $('#detailDueDate').text(new Date(invoice.details.dueDate * 1000).toLocaleDateString());
        $('#detailDescription').text(metadata?.description || 'Aucune description disponible');
        
        // Statut
        let statusText, statusClass;
        if (invoice.financials.isPaid) {
            statusText = 'Payée';
            statusClass = 'bg-success';
        } else if (window.uiUtils.isDeadlinePassed(invoice.details.dueDate)) {
            statusText = 'En retard';
            statusClass = 'bg-danger';
        } else if (invoice.financials.totalSupply.gte(invoice.details.amount)) {
            statusText = 'Financée';
            statusClass = 'bg-primary';
        } else if (invoice.details.isActive) {
            statusText = 'Active';
            statusClass = 'bg-info text-dark';
        } else {
            statusText = 'Inactive';
            statusClass = 'bg-secondary';
        }
        $('#detailStatus').text(statusText).removeClass().addClass(`badge ${statusClass}`);
        
        // Progression
        const amount = parseFloat(ethers.utils.formatEther(invoice.details.amount));
        const collected = parseFloat(ethers.utils.formatEther(invoice.financials.collectedAmount));
        const progress = (collected / amount * 100).toFixed(2);
        
        $('#detailTotalAmount').text(amount.toFixed(2));
        $('#detailCollectedAmount').text(collected.toFixed(2));
        $('#detailFundingProgress').css('width', `${progress}%`);
        
        // Document
        const docPreview = $('#detailDocumentPreview');
        docPreview.empty();
        
        if (metadata?.documentURI) {
            const docUrl = window.ipfsUtils.getIPFSGatewayURL(metadata.documentURI);
            docPreview.html(`
                <img src="${docUrl}" class="img-fluid rounded border border-secondary" style="max-height: 300px; cursor: pointer;" onclick="window.open('${docUrl}', '_blank')" alt="Document de facture">
                <p class="text-center mt-2">
                    <a href="${docUrl}" target="_blank" class="text-orange">
                        <i class="bi bi-download"></i> Télécharger le document
                    </a>
                </p>
            `);
        } else {
            docPreview.html('<p class="text-muted text-center">Aucun document disponible</p>');
        }
        
        const detailModal = new bootstrap.Modal(document.getElementById('invoiceDetailsModal'));
        detailModal.show();
        
    } catch (error) {
        console.error('Error showing invoice details:', error);
        window.uiUtils.showErrorAlert('Erreur lors du chargement des détails de la facture');
    }
}

// Fonction pour afficher les détails d'un pool
async function showPoolDetailsModal(poolId) {
    try {
        const { pool, metadata } = await window.sharedFunctions.getPoolDetails(poolId);
        const poolInvoices = await window.sharedFunctions.getPoolInvoices(poolId);
        
        $('#detailPoolName').text(pool.name);
        $('#detailPoolTheme').text(metadata?.theme || 'Général');
        $('#detailPoolRisk').text(metadata?.riskLevel || 'Moyen');
        $('#detailPoolRegion').text(metadata?.region || 'Global');
        $('#detailPoolMinInvestment').text(`${ethers.utils.formatEther(pool.minInvestment)} USDT`);
        $('#detailPoolActiveInvoices').text(poolInvoices.length);
        $('#detailPoolDescription').text(metadata?.description || 'Aucune description disponible');
        
        // Statut
        $('#detailPoolStatus').text(pool.isActive ? 'Actif' : 'Inactif')
            .removeClass()
            .addClass(`badge ${pool.isActive ? 'bg-success' : 'bg-secondary'}`);
        
        // Bannière
        if (metadata?.bannerURI) {
            $('#poolBannerImage').attr('src', window.ipfsUtils.getIPFSGatewayURL(metadata.bannerURI));
        } else {
            $('#poolBannerImage').attr('src', 'https://via.placeholder.com/600x200?text=Pool+Banner');
        }
        
        // Factures du pool
        const invoicesList = $('#poolInvoicesList');
        invoicesList.empty();
        
        if (poolInvoices.length === 0) {
            invoicesList.html('<p class="text-muted text-center">Aucune facture dans ce pool</p>');
        } else {
            let html = '<div class="row">';
            
            poolInvoices.forEach(invoice => {
                const amount = ethers.utils.formatEther(invoice.details.amount);
                const collected = ethers.utils.formatEther(invoice.financials.collectedAmount);
                const progress = (collected / amount * 100).toFixed(2); 
                const fundingEndDate = new Date(invoice.details.fundingEndDate * 1000).toLocaleDateString();
                const dueDate = new Date(invoice.details.dueDate * 1000).toLocaleDateString();
                
                html += `
                    <div class="col-md-6 mb-3">
                        <div class="card bg-darker text-white">
                            <div class="card-body">
                                <h6 class="card-title text-orange">Facture #${invoice.details.invoiceId.toString()}</h6>
                                <p class="mb-1"><small>Montant: ${amount} USDT</small></p>
                                <p class="mb-1"><small>Taux: ${invoice.details.interestRate / 100}%</small></p>
                                <p class="mb-1"><small>Fin collecte: ${fundingEndDate}</small></p>
                                <p class="mb-1"><small>Échéance: ${dueDate}</small></p>
                                
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: ${progress}%"></div>
                                </div>
                                <p class="text-end mt-1"><small>${progress}% financé</small></p>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            invoicesList.html(html);
        }
        
        // Bouton d'investissement
        $('#investInPoolBtn').off('click').click(async function() {
            const detailModal = bootstrap.Modal.getInstance(document.getElementById('poolDetailsModal'));
            detailModal.hide();
            
            await showInvestPoolModal(poolId, ethers.utils.formatEther(pool.minInvestment));
        });
        
        const detailModal = new bootstrap.Modal(document.getElementById('poolDetailsModal'));
        detailModal.show();
        
    } catch (error) {
        console.error('Error showing pool details:', error);
        window.uiUtils.showErrorAlert('Erreur lors du chargement des détails du pool');
    }
}

// **************************FIN**************************************

/**
 * Met à jour les statistiques du dashboard
 */
function updateDashboardStats(stats) {
    const elements = {
        'total-invoices': stats.totalInvoices,
        'total-pools': stats.totalPools,
        'total-invested': stats.totalInvested,
        'active-invoices': stats.activeInvoices
    };
    
    Object.entries(elements).forEach(([id, value]) => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = typeof value === 'number' ? 
                value.toLocaleString() : value;
        }
    });
}

/**
 * Met à jour le portefeuille investisseur
 */
function updateInvestorPortfolio(portfolio) {
    const container = document.getElementById('investor-portfolio');
    if (!container) return;
    
    // Implementation would depend on the specific HTML structure
    console.log('📊 Portfolio data ready for display:', portfolio);
}

/**
 * Met à jour les factures entreprise
 */
function updateEnterpriseInvoices(invoices) {
    const container = document.getElementById('enterprise-invoices');
    if (!container) return;
    
    // Implementation would depend on the specific HTML structure
    console.log('🏢 Enterprise invoices ready for display:', invoices);
}

/**
 * Met à jour les factures client
 */
function updateClientInvoices(invoices) {
    const container = document.getElementById('client-invoices');
    if (!container) return;
    
    // Implementation would depend on the specific HTML structure
    console.log('👤 Client invoices ready for display:', invoices);
}

/**
 * Met à jour les données admin
 */
function updateAdminData(invoices, pools) {
    console.log('👑 Admin data ready for display:', { invoices, pools });
}

/**
 * Gère les erreurs globales
 */
window.addEventListener('error', (event) => {
    console.error('🚨 Global error:', event.error);
    
    // Don't show alerts for network errors or minor issues
    if (event.error && event.error.message && 
        !event.error.message.includes('Network') &&
       /* !event.error.message.includes('fetch')) {
        window.uiUtils.showErrorAlert('An unexpected error occurred. Please refresh the page.');
    }*/
});

/**
 * Gère les erreurs de promesses non capturées
 */
window.addEventListener('unhandledrejection', (event) => {
    console.error('🚨 Unhandled promise rejection:', event.reason);
    
    // Prevent default browser behavior
    event.preventDefault();
    
    // Show user-friendly error
    if (event.reason && event.reason.message) {
        window.uiUtils.showErrorAlert('Operation failed: ' + event.reason.message);
    }
});

// Initialize application when DOM is ready
document.addEventListener('DOMContentLoaded', async () => {
    console.log('📄 DOM loaded, initializing application...');
    
    // Small delay to ensure all scripts are loaded
    setTimeout(async () => {
        await initializeApp();
        await loadPageData();
    }, 100);
});

// Auto-refresh data every 30 seconds
setInterval(async () => {
    if (window.COINFINANCE_APP.initialized && window.walletUtils.isWalletReady()) {
        await updateAllUIElements();
    }
}, 30000);


console.log('🎯 Main application script loaded');