/**
 * Language Management for CoinFinance Platform
 * Gestion de l'internationalisation FR/EN
 */

// Language data
const LANGUAGES = {
    fr: {
        // Navigation
        'nav.dashboard': 'Tableau de bord',
        'nav.admin': 'Administration',
        'nav.enterprise': 'Entreprise',
        'nav.investor': 'Investisseur',
        'nav.client': 'Client',
        'nav.profile': 'Profil',
        'nav.settings': 'Paramètres',
        'nav.logout': 'Déconnexion',
        'nav.login': 'Connexion',
        'nav.register': 'Inscription',
        
        // Wallet
        'wallet.not_connected': 'Non connecté',
        'wallet.connected': 'Connecté',
        'wallet.connect': 'Connecter le portefeuille',
        'wallet.disconnect': 'Déconnecter',
        'wallet.balance': 'Solde',
        'wallet.network': 'Réseau',
        
        // Dashboard
        'dashboard.title': 'Tableau de bord',
        'dashboard.total_invoices': 'Total des factures',
        'dashboard.total_pools': 'Total des pools',
        'dashboard.total_invested': 'Total investi',
        'dashboard.active_invoices': 'Factures actives',
        
        // Invoices
        'invoice.title': 'Facture',
        'invoice.amount': 'Montant',
        'invoice.due_date': 'Date d\'échéance',
        'invoice.interest_rate': 'Taux d\'intérêt',
        'invoice.company': 'Entreprise',
        'invoice.client': 'Client',
        'invoice.status': 'Statut',
        'invoice.active': 'Active',
        'invoice.paid': 'Payée',
        'invoice.overdue': 'En retard',
        'invoice.funded': 'Financée',
        
        // Investment
        'investment.invest': 'Investir',
        'investment.amount': 'Montant d\'investissement',
        'investment.confirm': 'Confirmer l\'investissement',
        'investment.success': 'Investissement réussi',
        'investment.failed': 'Investissement échoué',
        'investment.claim': 'Réclamer les fonds',
        'investment.portfolio': 'Portefeuille',
        
        // Pools
        'pool.title': 'Pool',
        'pool.name': 'Nom du pool',
        'pool.min_investment': 'Investissement minimum',
        'pool.total_amount': 'Montant total',
        'pool.active': 'Actif',
        'pool.inactive': 'Inactif',
        
        // Forms
        'form.submit': 'Soumettre',
        'form.cancel': 'Annuler',
        'form.save': 'Enregistrer',
        'form.required': 'Requis',
        'form.optional': 'Optionnel',
        
        // Messages
        'message.success': 'Succès',
        'message.error': 'Erreur',
        'message.warning': 'Attention',
        'message.info': 'Information',
        'message.loading': 'Chargement...',
        'message.processing': 'Traitement en cours....',
        'message.confirm': 'Confirmer',
        
        // Errors
        'error.wallet_not_connected': 'Portefeuille non connecté',
        'error.insufficient_balance': 'Solde insuffisant',
        'error.invalid_amount': 'Montant invalide',
        'error.invalid_address': 'Adresse invalide',
        'error.transaction_failed': 'Transaction échouée',
        'error.network_error': 'Erreur réseau',
        
        // Time
        'time.days': 'jours',
        'time.hours': 'heures',
        'time.minutes': 'minutes',
        'time.seconds': 'secondes',
        
        // Actions
        'action.view': 'Voir',
        'action.edit': 'Modifier',
        'action.delete': 'Supprimer',
        'action.create': 'Créer',
        'action.update': 'Mettre à jour',
        'action.approve': 'Approuver',
        'action.reject': 'Rejeter'
    },
    
    en: {
        // Navigation
        'nav.dashboard': 'Dashboard',
        'nav.admin': 'Admin',
        'nav.enterprise': 'Enterprise',
        'nav.investor': 'Investor',
        'nav.client': 'Client',
        'nav.profile': 'Profile',
        'nav.settings': 'Settings',
        'nav.logout': 'Logout',
        'nav.login': 'Login',
        'nav.register': 'Register',
        
        // Wallet
        'wallet.not_connected': 'Not Connected',
        'wallet.connected': 'Connected',
        'wallet.connect': 'Connect Wallet',
        'wallet.disconnect': 'Disconnect',
        'wallet.balance': 'Balance',
        'wallet.network': 'Network',
        
        // Dashboard
        'dashboard.title': 'Dashboard',
        'dashboard.total_invoices': 'Total Invoices',
        'dashboard.total_pools': 'Total Pools',
        'dashboard.total_invested': 'Total Invested',
        'dashboard.active_invoices': 'Active Invoices',
        
        // Invoices
        'invoice.title': 'Invoice',
        'invoice.amount': 'Amount',
        'invoice.due_date': 'Due Date',
        'invoice.interest_rate': 'Interest Rate',
        'invoice.company': 'Company',
        'invoice.client': 'Client',
        'invoice.status': 'Status',
        'invoice.active': 'Active',
        'invoice.paid': 'Paid',
        'invoice.overdue': 'Overdue',
        'invoice.funded': 'Funded',
        
        // Investment
        'investment.invest': 'Invest',
        'investment.amount': 'Investment Amount',
        'investment.confirm': 'Confirm Investment',
        'investment.success': 'Investment Successful',
        'investment.failed': 'Investment Failed',
        'investment.claim': 'Claim Funds',
        'investment.portfolio': 'Portfolio',
        
        // Pools
        'pool.title': 'Pool',
        'pool.name': 'Pool Name',
        'pool.min_investment': 'Minimum Investment',
        'pool.total_amount': 'Total Amount',
        'pool.active': 'Active',
        'pool.inactive': 'Inactive',
        
        // Forms
        'form.submit': 'Submit',
        'form.cancel': 'Cancel',
        'form.save': 'Save',
        'form.required': 'Required',
        'form.optional': 'Optional',
        
        // Messages
        'message.success': 'Success',
        'message.error': 'Error',
        'message.warning': 'Warning',
        'message.info': 'Information',
        'message.loading': 'Loading...',
        'message.processing': 'Processing...',
        'message.confirm': 'Confirm',
        
        // Errors
        'error.wallet_not_connected': 'Wallet not connected',
        'error.insufficient_balance': 'Insufficient balance',
        'error.invalid_amount': 'Invalid amount',
        'error.invalid_address': 'Invalid address',
        'error.transaction_failed': 'Transaction failed',
        'error.network_error': 'Network error',
        
        // Time
        'time.days': 'days',
        'time.hours': 'hours',
        'time.minutes': 'minutes',
        'time.seconds': 'seconds',
        
        // Actions
        'action.view': 'View',
        'action.edit': 'Edit',
        'action.delete': 'Delete',
        'action.create': 'Create',
        'action.update': 'Update',
        'action.approve': 'Approve',
        'action.reject': 'Reject'
    }
};

/**
 * Obtient la langue actuelle
 */
function getCurrentLanguage() {
    return window.COINFINANCE_CONFIG.language || 'fr';
}

/**
 * Change la langue de l'application
 */
function switchLanguage(lang) {
    if (!LANGUAGES[lang]) {
        console.error('❌ Language not supported:', lang);
        return;
    }
    
    console.log(`🌐 Switching language to: ${lang}`);
    
    // Update config
    window.COINFINANCE_CONFIG.language = lang;
    
    // Store in localStorage
    localStorage.setItem('language', lang);
    
    // Update session via AJAX
    $.ajax({
        url: window.COINFINANCE_CONFIG.baseUrl + 'lang/' + lang,
        method: 'GET',
        success: function() {
            console.log('✅ Language updated in session');
        },
        error: function(xhr, status, error) {
            console.error('❌ Failed to update language in session:', error);
        }
    });
    
    // Update UI
    updateUILanguage();
    
    // Update dropdown indicator
    const languageDropdown = document.getElementById('languageDropdown');
    if (languageDropdown) {
        languageDropdown.innerHTML = `<i class="fas fa-globe me-1"></i> ${lang.toUpperCase()}`;
    }
    
    // Show success message
    window.uiUtils.showSuccessAlert(
        lang === 'fr' ? 'Langue changée en français' : 'Language changed to English'
    );
}

/**
 * Met à jour l'interface utilisateur avec la langue actuelle
 */
function updateUILanguage() {
    const currentLang = getCurrentLanguage();
    const translations = LANGUAGES[currentLang];
    
    if (!translations) {
        console.error('❌ No translations found for language:', currentLang);
        return;
    }
    
    console.log(`🔄 Updating UI language to: ${currentLang}`);
    
    // Update elements with data-translate attribute
    document.querySelectorAll('[data-translate]').forEach(element => {
        const key = element.getAttribute('data-translate');
        if (translations[key]) {
            if (element.tagName === 'INPUT' && element.type === 'submit') {
                element.value = translations[key];
            } else if (element.tagName === 'INPUT' && element.placeholder !== undefined) {
                element.placeholder = translations[key];
            } else {
                element.textContent = translations[key];
            }
        }
    });
    
    // Update page title if it has translation
    const titleElement = document.querySelector('title');
    if (titleElement && titleElement.getAttribute('data-translate')) {
        const titleKey = titleElement.getAttribute('data-translate');
        if (translations[titleKey]) {
            titleElement.textContent = translations[titleKey] + ' - CoinFinance';
        }
    }
    
    // Update document language attribute
    document.documentElement.lang = currentLang;
    
    console.log('✅ UI language updated');
}

/**
 * Obtient une traduction pour une clé donnée
 */
function translate(key, lang = null) {
    const targetLang = lang || getCurrentLanguage();
    const translations = LANGUAGES[targetLang];
    
    if (!translations || !translations[key]) {
        console.warn(`⚠️ Translation not found for key: ${key} in language: ${targetLang}`);
        return key; // Return the key itself as fallback
    }
    
    return translations[key];
}

/**
 * Formate une date selon la langue actuelle
 */
function formatDateLocalized(date, options = {}) {
    const currentLang = getCurrentLanguage();
    const locale = currentLang === 'fr' ? 'fr-FR' : 'en-US';
    
    const defaultOptions = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    
    const formatOptions = { ...defaultOptions, ...options };
    
    try {
        return new Intl.DateTimeFormat(locale, formatOptions).format(date);
    } catch (error) {
        console.error('❌ Error formatting date:', error);
        return date.toLocaleString();
    }
}

/**
 * Formate un nombre selon la langue actuelle
 */
function formatNumberLocalized(number, options = {}) {
    const currentLang = getCurrentLanguage();
    const locale = currentLang === 'fr' ? 'fr-FR' : 'en-US';
    
    try {
        return new Intl.NumberFormat(locale, options).format(number);
    } catch (error) {
        console.error('❌ Error formatting number:', error);
        return number.toString();
    }
}

/**
 * Formate une devise selon la langue actuelle
 */
function formatCurrencyLocalized(amount, currency = 'EUR') {
    const currentLang = getCurrentLanguage();
    const locale = currentLang === 'fr' ? 'fr-FR' : 'en-US';
    
    try {
        return new Intl.NumberFormat(locale, {
            style: 'currency',
            currency: currency
        }).format(amount);
    } catch (error) {
        console.error('❌ Error formatting currency:', error);
        return `${amount} ${currency}`;
    }
}

/**
 * Obtient le texte de statut localisé pour une facture
 */
function getLocalizedInvoiceStatus(status) {
    const statusMap = {
        'active': 'invoice.active',
        'paid': 'invoice.paid',
        'overdue': 'invoice.overdue',
        'funded': 'invoice.funded'
    };
    
    const key = statusMap[status];
    return key ? translate(key) : status;
}

/**
 * Obtient le texte de statut localisé pour un pool
 */
function getLocalizedPoolStatus(isActive) {
    return translate(isActive ? 'pool.active' : 'pool.inactive');
}

/**
 * Initialise la langue au chargement de la page
 */
function initializeLanguage() {
    console.log('🌐 Initializing language system...');
    
    // Get language from localStorage or default
    const storedLang = localStorage.getItem('language');
    const defaultLang = window.COINFINANCE_CONFIG.language || 'fr';
    const currentLang = storedLang || defaultLang;
    
    // Validate language
    if (LANGUAGES[currentLang]) {
        window.COINFINANCE_CONFIG.language = currentLang;
        updateUILanguage();
    } else {
        console.warn('⚠️ Invalid stored language, using default');
        window.COINFINANCE_CONFIG.language = 'fr';
        localStorage.setItem('language', 'fr');
        updateUILanguage();
    }
    
    console.log(`✅ Language system initialized with: ${window.COINFINANCE_CONFIG.language}`);
}

/**
 * Ajoute des traductions dynamiquement
 */
function addTranslations(lang, translations) {
    if (!LANGUAGES[lang]) {
        LANGUAGES[lang] = {};
    }
    
    Object.assign(LANGUAGES[lang], translations);
    
    console.log(`✅ Added translations for ${lang}:`, Object.keys(translations));
    
    // Update UI if current language
    if (getCurrentLanguage() === lang) {
        updateUILanguage();
    }
}

/**
 * Obtient toutes les traductions pour une langue
 */
function getAllTranslations(lang = null) {
    const targetLang = lang || getCurrentLanguage();
    return LANGUAGES[targetLang] || {};
}

// Export functions for global use
window.languageUtils = {
    getCurrentLanguage,
    switchLanguage,
    updateUILanguage,
    translate,
    formatDateLocalized,
    formatNumberLocalized,
    formatCurrencyLocalized,
    getLocalizedInvoiceStatus,
    getLocalizedPoolStatus,
    initializeLanguage,
    addTranslations,
    getAllTranslations
};

// Initialize language system when script loads
document.addEventListener('DOMContentLoaded', () => {
    initializeLanguage();
});

console.log('🌐 Language management system loaded');