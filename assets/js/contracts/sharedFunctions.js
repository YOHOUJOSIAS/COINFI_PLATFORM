/**
 * Shared Functions for CoinFinance Platform
 * Fonctions communes accessibles à tous les rôles utilisateurs
 */

// Import de l'ABI complète depuis le fichier séparé
import { invoiceTokenABI } from '../abi/invoiceToken_abi.js';


/**
 * Obtient le contrat Invoice Token
 */
function getInvoiceTokenContract(withSigner = false) {
    try {
        const provider = withSigner ? window.walletUtils.getCurrentProvider() : new ethers.providers.JsonRpcProvider(
            window.COINFINANCE_CONFIG.networks.rpc
        );
        
        const contract = new ethers.Contract(
            window.COINFINANCE_CONFIG.contracts.invoiceToken,
            invoiceTokenABI,
            withSigner ? window.walletUtils.getCurrentSigner() : provider
        );
        
        return contract;
    } catch (error) {
        console.error('❌ Error getting contract:', error);
        throw new Error('Failed to get contract instance');
    }
}

/**
 * Récupère toutes les factures
 */
/**
 * Récupère toutes les factures depuis le smart contract, puis enrichit chacune
 * avec ses métadonnées off-chain (stockées sur IPFS).
 * @returns {Promise<Array<Object>>} Une promesse qui se résout avec un tableau de factures complètes (données on-chain + metadata).
 */
async function getAllInvoices() {
    console.log('📄 Début de la récupération de toutes les factures...');
    
    try {
        window.uiUtils.showLoadingAlert('Chargement des factures depuis la blockchain...');
        
        const contract = getInvoiceTokenContract();
        const rawInvoices = await contract.getAllInvoices();
        
        console.log(`✅ ${rawInvoices.length} factures brutes récupérées. Enrichissement avec les métadonnées...`);
        window.uiUtils.showLoadingAlert(`Enrichissement de ${rawInvoices.length} factures...`);

        const enrichedInvoices = await Promise.all(
            rawInvoices.map(async (invoice) => {
                let metadata = {};
                const uri = invoice.details.metadataURI;

                if (uri && uri.startsWith('ipfs://')) {
                    try {
                        // Essayer plusieurs gateways avec fallback
                        const gateways = [
                            'https://ipfs.io/ipfs/',
                            'https://dweb.link/ipfs/',
                            'https://cf-ipfs.com/ipfs/',
                            'https://gateway.ipfs.io/ipfs/'
                        ];
                        
                        for (const gateway of gateways) {
                            try {
                                const url = uri.replace('ipfs://', gateway);
                                const response = await fetch(url);
                                
                                if (response.ok) {
                                    metadata = await response.json();
                                    console.log(`👍 Métadonnées chargées pour la facture #${invoice.details.invoiceId.toString()}`);
                                    break; // Sortir de la boucle si réussi
                                }
                            } catch (e) {
                                console.warn(`Échec avec le gateway ${gateway}`, e);
                                continue;
                            }
                        }
                    } catch (error) {
                        console.error(`❌ Impossible de charger les métadonnées pour la facture #${invoice.details.invoiceId.toString()}:`, error);
                    }
                }

                return {
                    ...invoice,
                    metadata
                };
            })
        );

        window.uiUtils.hideLoadingAlert();
        console.log('✅ Toutes les factures ont été enrichies avec succès');
        return enrichedInvoices;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Erreur critique lors de la récupération des factures:', error);
        window.uiUtils.showErrorAlert('Impossible de récupérer les factures: ' + error.message);
        throw error;
    }
}


/**
 * Récupère tous les pools
 */
async function getAllPools() {
    console.log('🏊 Fetching all pools...');
    
    try {
        window.uiUtils.showLoadingAlert('Loading pools...');
        
        const contract = getInvoiceTokenContract();
        const rawPools = await contract.getAllPools();
        
        console.log('✅ Raw pools data fetched, now enriching with metadata...');
        
        // Enrich each pool with its metadata
        const enrichedPools = await Promise.all(
            rawPools.map(async (pool) => {
                let metadata = {};
                
                if (pool.metadataURI && pool.metadataURI.startsWith('ipfs://')) {
                    try {
                        metadata = await window.ipfsUtils.fetchMetadataFromIPFS(pool.metadataURI);
                    } catch (ipfsError) {
                        console.warn(`⚠️ Could not fetch IPFS metadata for pool ${pool.poolId}:`, ipfsError);
                    }
                }
                
                return {
                    ...pool,
                    metadata
                };
            })
        );
        
        window.uiUtils.hideLoadingAlert();
        
        console.log('✅ All pools fetched and enriched successfully:');
        console.log(`📊 Total pools: ${enrichedPools.length}`);
        console.log('🏊 Pools data:', enrichedPools);
        
        // Log for developers with database suggestions
        window.uiUtils.logForDevelopers(
            'Get All Pools',
            { count: enrichedPools.length, pools: enrichedPools },
            `
                CREATE TABLE pools_cache (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    pool_id BIGINT NOT NULL,
                    pool_name VARCHAR(255),
                    invoice_ids JSON,
                    total_amount DECIMAL(20,8),
                    min_investment DECIMAL(20,8),
                    creation_date BIGINT,
                    is_active BOOLEAN,
                    max_invoice_count INT,
                    max_pool_amount DECIMAL(20,8),
                    metadata_uri TEXT,
                    metadata JSON,
                    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    UNIQUE KEY unique_pool (pool_id)
                );
            `
        );
        
        return enrichedPools;
        
    } catch (error) {
        window.uiUtils.hideLoadingAlert();
        console.error('❌ Error fetching pools:', error);
        window.uiUtils.showErrorAlert('Failed to fetch pools: ' + error.message);
        throw error;
    }
}

/**
 * Récupère les détails d'une facture spécifique
 */
async function getInvoiceDetails(invoiceId) {
    console.log(`📄 Fetching invoice details for ID: ${invoiceId}`);
    
    try {
        const contract = getInvoiceTokenContract();
        const invoice = await contract.invoices(invoiceId);
        
        console.log('✅ Invoice details fetched successfully:');
        console.log('📊 Invoice data 1:', invoice);
        
        // Récupérer également les métadonnées IPFS
        let metadata = null;
        if (invoice.details.metadataURI) {
            try {
                metadata = await window.ipfsUtils.fetchMetadataFromIPFS(invoice.details.metadataURI);
            } catch (ipfsError) {
                console.warn('⚠️ Could not fetch IPFS metadata:', ipfsError);
            }
        }
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Get Invoice Details',
            { invoiceId, invoice, metadata }
        );
        
        return { invoice, metadata };
        
    } catch (error) {
        console.error('❌ Error fetching invoice details:', error);
        window.uiUtils.showErrorAlert('Failed to fetch invoice details: ' + error.message);
        throw error;
    }
}

/**
 * Récupère les détails d'un pool spécifique
 */
async function getPoolDetails(poolId) {
    console.log(`🏊 Fetching pool details for ID: ${poolId}`);
    
    try {
        const contract = getInvoiceTokenContract();
        const pool = await contract.pools(poolId);
        
        console.log('✅ Pool details fetched successfully:');
        console.log('📊 Pool data:', pool);
        
        // Récupérer également les métadonnées IPFS
        let metadata = null;
        if (pool.metadataURI) {
            try {
                metadata = await window.ipfsUtils.fetchMetadataFromIPFS(pool.metadataURI);
            } catch (ipfsError) {
                console.warn('⚠️ Could not fetch IPFS metadata:', ipfsError);
            }
        }
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Get Pool Details',
            { poolId, pool, metadata }
        );
        
        return { pool, metadata };
        
    } catch (error) {
        console.error('❌ Error fetching pool details:', error);
        window.uiUtils.showErrorAlert('Failed to fetch pool details: ' + error.message);
        throw error;
    }
}

/**
 * Récupère les factures d'un pool
 */
async function getPoolInvoices(poolId) {
    console.log(`📄 Fetching invoices for pool ID: ${poolId}`);
    
    try {
        const contract = getInvoiceTokenContract();
        const invoices = await contract.getPoolInvoices(poolId);
        
        console.log('✅ Pool invoices fetched successfully:');
        console.log(`📊 Total invoices in pool: ${invoices.length}`);
        console.log('📋 Pool invoices data:', invoices);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Get Pool Invoices',
            { poolId, count: invoices.length, invoices }
        );
        
        return invoices;
        
    } catch (error) {
        console.error('❌ Error fetching pool invoices:', error);
        window.uiUtils.showErrorAlert('Failed to fetch pool invoices: ' + error.message);
        throw error;
    }
}

/**
 * Récupère les factures d'un investisseur
 */
async function getInvestorInvoices(investorAddress) {
    console.log(`📄 Fetching invoices for investor: ${investorAddress}`);
    
    try {
        const contract = getInvoiceTokenContract();
        const invoices = await contract.getInvestorInvoices(investorAddress);
        
        console.log('✅ Investor invoices fetched successfully:');
        console.log(`📊 Total investor invoices: ${invoices.length}`);
        console.log('📋 Investor invoices data:', invoices);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Get Investor Invoices',
            { investorAddress, count: invoices.length, invoices }
        );
        
        return invoices;
        
    } catch (error) {
        console.error('❌ Error fetching investor invoices:', error);
        window.uiUtils.showErrorAlert('Failed to fetch investor invoices: ' + error.message);
        throw error;
    }
}

/**
 * Récupère les investisseurs d'une facture
 */
async function getInvoiceInvestors(invoiceId) {
    console.log(`👥 Fetching investors for invoice ID: ${invoiceId}`);
    
    try {
        const contract = getInvoiceTokenContract();
        const investors = await contract.getInvoiceInvestors(invoiceId);
        
        console.log('✅ Invoice investors fetched successfully:');
        console.log(`📊 Total investors: ${investors.length}`);
        console.log('👥 Investors:', investors);
        
        // Log for developers
        window.uiUtils.logForDevelopers(
            'Get Invoice Investors',
            { invoiceId, count: investors.length, investors }
        );
        
        return investors;
        
    } catch (error) {
        console.error('❌ Error fetching invoice investors:', error);
        window.uiUtils.showErrorAlert('Failed to fetch invoice investors: ' + error.message);
        throw error;
    }
}

/**
 * Récupère le solde de parts ERC1155 d'un utilisateur
 */
async function getUserBalance(userAddress, invoiceId) {
    console.log(`💰 Fetching balance for user ${userAddress} on invoice ${invoiceId}`);
    
    try {
        const contract = getInvoiceTokenContract();
        const balance = await contract.balanceOf(userAddress, invoiceId);
        
        console.log('✅ User balance fetched successfully:');
        console.log(`📊 Balance: ${ethers.utils.formatEther(balance)}`);
        
        return balance;
        
    } catch (error) {
        console.error('❌ Error fetching user balance:', error);
        throw error;
    }
}

/**
 * Récupère les soldes multiples d'un utilisateur
 */
async function getUserBalances(userAddress, invoiceIds) {
    console.log(`💰 Fetching balances for user ${userAddress} on multiple invoices`);
    
    try {
        const contract = getInvoiceTokenContract();
        const addresses = Array(invoiceIds.length).fill(userAddress);
        const balances = await contract.balanceOfBatch(addresses, invoiceIds);
        
        console.log('✅ User balances fetched successfully:');
        console.log('📊 Balances:', balances.map(b => ethers.utils.formatEther(b)));
        
        return balances;
        
    } catch (error) {
        console.error('❌ Error fetching user balances:', error);
        throw error;
    }
}

/**
 * Récupère les parts d'un investisseur sur une facture
 */
async function getInvestorShares(investorAddress, invoiceId) {
    console.log(`📊 Fetching shares for investor ${investorAddress} on invoice ${invoiceId}`);
    
    try {
        const contract = getInvoiceTokenContract();
        const shares = await contract.investorShares(invoiceId, investorAddress);
        
        console.log('✅ Investor shares fetched successfully:');
        console.log(`📊 Shares: ${ethers.utils.formatEther(shares)}`);
        
        return shares;
        
    } catch (error) {
        console.error('❌ Error fetching investor shares:', error);
        throw error;
    }
}

/**
 * Récupère les taux de commission actuels
 */
async function getCommissionRates() {
    console.log('💰 Fetching commission rates...');
    
    try {
        const contract = getInvoiceTokenContract();
        const rates = await contract.commissionRates();
        
        console.log('✅ Commission rates fetched successfully:');
        console.log(`📊 Entry Fee: ${rates.entryFee} (${rates.entryFee / 100}%)`);
        console.log(`📊 Performance Fee: ${rates.performanceFee} (${rates.performanceFee / 100}%)`);
        console.log(`📊 Pool Fee: ${rates.poolFee} (${rates.poolFee / 100}%)`);
        console.log(`📊 Issuance Fee: ${rates.issuanceFee} (${rates.issuanceFee / 100}%)`);
        
        return rates;
        
    } catch (error) {
        console.error('❌ Error fetching commission rates:', error);
        throw error;
    }
}


/**
 * Récupère les détails du collatéral pour une facture spécifique
 * @param {number} invoiceId - ID de la facture
 * @returns {Promise<Object>} Détails du collatéral
 */
/**
 * Récupère les détails du collatéral pour une facture spécifique
 * @param {number|string} invoiceId - ID de la facture
 * @returns {Promise<Object>} Détails du collatéral
 */
async function getCollateralDetails(invoiceId) {
    console.log(`🔍 Fetching collateral details for invoice ID: ${invoiceId}`);
    // First validate the invoiceId
    if (invoiceId === undefined || invoiceId === null) {
        console.error('Invoice ID is undefined or null');
        return getDefaultCollateralDetails();
    }

    try {
        // Convert to number if it's a string
        const id = typeof invoiceId === 'string' ? parseInt(invoiceId, 10) : invoiceId;
        
        if (isNaN(id)) {
            console.error('Invalid invoice ID:', invoiceId);
            return getDefaultCollateralDetails();
        }

        const contract = await getInvoiceTokenContract();
        if (!contract) {
            console.error("Contract not initialized");
            return getDefaultCollateralDetails();
        }

        const collateral = await contract.invoiceCollaterals(id);
        
        if (!collateral) {
            console.warn(`No collateral found for invoice ${id}`);
            return getDefaultCollateralDetails();
        }

        // Safe value extraction
        const getSafeValue = (value, defaultValue = '0') => {
            return value !== undefined && value !== null ? value : defaultValue;
        };

        // Safe ethers formatting
        const safeFormatEther = (value) => {
            try {
                return value ? ethers.utils.formatEther(value) : '0';
            } catch (e) {
                console.warn(`FormatEther error for value ${value}:`, e);
                return '0';
            }
        };

        return {
            initialDeposit: safeFormatEther(collateral.initialDeposit),
            withheldAmount: safeFormatEther(collateral.withheldAmount),
            totalAmount: safeFormatEther(collateral.totalAmount),
            isStaked: getSafeValue(collateral.isStaked, false),
            isReleased: getSafeValue(collateral.isReleased, false),
            isWithdrawable: getSafeValue(collateral.isWithdrawable, false),
            stakingPlatform: getSafeValue(collateral.stakingPlatform, ''),
            stakingContract: getSafeValue(collateral.stakingContract, ''),
            stakedAmount: safeFormatEther(collateral.stakedAmount),
            rates: {
                initialDepositRate: getSafeValue(collateral.rates?.initialDepositRate, 0),
                withheldRate: getSafeValue(collateral.rates?.withheldRate, 0)
            }
        };
    } catch (error) {
        console.error(`Error getting collateral details for invoice ${invoiceId}:`, error);
        return getDefaultCollateralDetails();
    }
}

// Default values for collateral
function getDefaultCollateralDetails() {
    return {
        initialDeposit: '0',
        withheldAmount: '0',
        totalAmount: '0',
        isStaked: false,
        isReleased: false,
        isWithdrawable: false,
        stakingPlatform: '',
        stakingContract: '',
        stakedAmount: '0',
        rates: {
            initialDepositRate: 0,
            withheldRate: 0
        }
    };
}
// async function getCollateralDetails(invoiceId) {
//     try {
//         const contract = await getInvoiceTokenContract();
//         const collateral = await contract.invoiceCollaterals(invoiceId);
        
//         return {
//             initialDeposit: ethers.utils.formatEther(collateral.initialDeposit),
//             withheldAmount: ethers.utils.formatEther(collateral.withheldAmount),
//             totalAmount: ethers.utils.formatEther(collateral.totalAmount),
//             isStaked: collateral.isStaked,
//             isReleased: collateral.isReleased,
//             isWithdrawable: collateral.isWithdrawable,
//             stakingPlatform: collateral.stakingPlatform,
//             stakingContract: collateral.stakingContract,
//             stakedAmount: ethers.utils.formatEther(collateral.stakedAmount),
//             rates: {
//                 initialDepositRate: collateral.rates.initialDepositRate,
//                 withheldRate: collateral.rates.withheldRate
//             }
//         };
//     } catch (error) {
//         console.error('Error getting collateral details:', error);
//         throw error;
//     }
// }


/**
 * Filtre les factures par entreprise
 */
function filterInvoicesByCompany(invoices, companyAddress) {
    return invoices.filter(invoice => 
        invoice.details.company.toLowerCase() === companyAddress.toLowerCase()
    );
}

/**
 * Filtre les factures par client
 */
function filterInvoicesByClient(invoices, clientAddress) {
    return invoices.filter(invoice => 
        invoice.details.client.toLowerCase() === clientAddress.toLowerCase()
    );
}

/**
 * Filtre les factures par statut
 */
function filterInvoicesByStatus(invoices, status) {
    return invoices.filter(invoice => {
        switch(status) {
            case 'active':
                return invoice.details.isActive && !invoice.financials.isPaid;
            case 'funded':
                return invoice.financials.totalSupply >= invoice.details.amount;
            case 'paid':
                return invoice.financials.isPaid;
            case 'overdue':
                return !invoice.financials.isPaid && window.uiUtils.isDeadlinePassed(invoice.details.dueDate);
            default:
                return true;
        }
    });
}

/**
 * Trie les factures par date d'échéance
 */
function sortInvoicesByDueDate(invoices, ascending = true) {
    return [...invoices].sort((a, b) => {
        const dateA = parseInt(a.details.dueDate);
        const dateB = parseInt(b.details.dueDate);
        return ascending ? dateA - dateB : dateB - dateA;
    });
}

/**
 * Trie les factures par montant
 */
function sortInvoicesByAmount(invoices, ascending = true) {
    return [...invoices].sort((a, b) => {
        const amountA = parseFloat(ethers.utils.formatEther(a.details.amount));
        const amountB = parseFloat(ethers.utils.formatEther(b.details.amount));
        return ascending ? amountA - amountB : amountB - amountA;
    });
}

/**
 * Calcule les statistiques globales
 */
async function getGlobalStatistics() {
    console.log('📊 Calculating global statistics...');
    
    try {
        const contract = getInvoiceTokenContract();
        
        // Récupérer les données de base
        const [invoices, pools, totalInvested, nextInvoiceId, nextPoolId] = await Promise.all([
            contract.getAllInvoices(),
            contract.getAllPools(),
            contract.totalInvestedAmounts(),
            contract.nextInvoiceId(),
            contract.nextPoolId()
        ]);
        
        // Calculer les statistiques
        const stats = {
            totalInvoices: nextInvoiceId.toNumber(),
            totalPools: nextPoolId.toNumber(),
            totalInvested: ethers.utils.formatEther(totalInvested),
            activeInvoices: invoices.filter(inv => inv.details.isActive && !inv.financials.isPaid).length,
            paidInvoices: invoices.filter(inv => inv.financials.isPaid).length,
            activePools: pools.filter(pool => pool.isActive).length,
            averageInvoiceAmount: invoices.length > 0 ? 
                parseFloat(ethers.utils.formatEther(
                    invoices.reduce((sum, inv) => sum.add(inv.details.amount), ethers.BigNumber.from(0))
                )) / invoices.length : 0
        };
        
        console.log('✅ Global statistics calculated:');
        console.log('📊 Stats:', stats);
        
        return stats;
        
    } catch (error) {
        console.error('❌ Error calculating statistics:', error);
        throw error;
    }
}

/**
 * Vérifie si une facture peut être investie
 */
function canInvestInInvoice(invoice) {
    const now = Math.floor(Date.now() / 1000);
    const checks = {
        isActive: invoice.details.isActive,
        notPaid: !invoice.financials.isPaid,
        fundingNotEnded: now < invoice.details.fundingEndDate,
        notFullyFunded: invoice.financials.totalSupply.lt(invoice.details.amount)
    };
    
    console.log('Investment checks:', {
        invoiceId: invoice.details.invoiceId.toString(),
        checks,
        fundingEndDate: new Date(invoice.details.fundingEndDate * 1000),
        currentTime: new Date(now * 1000),
        totalSupply: ethers.utils.formatEther(invoice.financials.totalSupply),
        amount: ethers.utils.formatEther(invoice.details.amount)
    });
    
    return checks.isActive && checks.notPaid && checks.fundingNotEnded && checks.notFullyFunded;
}


/**
 * Vérifie si un pool peut recevoir des investissements
 */
/**
 * Vérifie si un pool peut recevoir des investissements
 */
async function canInvestInPool(pool) {
    try {
        // Vérifie d'abord que le pool est actif
        if (!pool.isActive) {
            console.log(`Pool ${pool.poolId} is not active`);
            return false;
        }

        // Récupère les factures du pool
        const poolInvoices = await getPoolInvoices(pool.poolId);
        
        // Vérifie qu'il y a au moins une facture dans le pool
        if (poolInvoices.length === 0) {
            console.log(`Pool ${pool.poolId} has no invoices`);
            return false;
        }

        // Vérifie qu'au moins une facture est active et peut recevoir des investissements
        const now = Math.floor(Date.now() / 1000);
        const hasActiveInvoice = poolInvoices.some(invoice => {
            return invoice.details.isActive && 
                   !invoice.financials.isPaid && 
                   now < invoice.details.fundingEndDate &&
                   invoice.financials.totalSupply.lt(invoice.details.amount);
        });

        if (!hasActiveInvoice) {
            console.log(`Pool ${pool.poolId} has no active invoices available for investment`);
            return false;
        }

        return true;
    } catch (error) {
        console.error(`Error checking pool ${pool.poolId} investment availability:`, error);
        return false;
    }
}

// Formatage des dates complètes avec heures et minutes
// function formatFullDateTime(timestamp) {
//     const date = new Date(timestamp * 1000);
//     return date.toLocaleString('fr-FR', {
//         timeZone: 'UTC',
//         day: '2-digit',
//         month: '2-digit',
//         year: 'numeric',
//         hour: '2-digit',
//         minute: '2-digit',
//         hour12: false,
//         timeZoneName: 'short'
//     }).replace(',', '').replace('UTC', 'GMT');
// };



// Export functions for global use
window.sharedFunctions = {
    getInvoiceTokenContract,
    getAllInvoices,
    getAllPools,
    getInvoiceDetails,
    getPoolDetails,
    getPoolInvoices,
    getInvestorInvoices,
    getInvoiceInvestors,
    getUserBalance,
    getUserBalances,
    getInvestorShares,
    getCommissionRates,
    getCollateralDetails,
    filterInvoicesByCompany,
    filterInvoicesByClient,
    filterInvoicesByStatus,
    sortInvoicesByDueDate,
    sortInvoicesByAmount,
    getGlobalStatistics,
    canInvestInInvoice,
    canInvestInPool: async (pool) => canInvestInPool(pool),
};

console.log('🔗 Shared functions loaded successfully');