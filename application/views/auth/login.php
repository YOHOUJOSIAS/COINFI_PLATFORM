<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <!-- Logo and Title -->
                    <div class="text-center mb-4">
                        <h2 class="text-primary-custom fw-bold">Content de te revoir</h2>
                        <p class="text-muted">Connectez votre portefeuille pour accéder à CoinFinance</p>
                    </div>

                    <!-- Wallet Connection Options -->
                    <div class="d-grid gap-3 mb-4">
                        <button id="connect-metamask" class="btn btn-primary btn-lg">
                            <i class="fab fa-ethereum me-2"></i>
                            Connectez-vous avec MetaMask
                        </button>
                        
                        <button id="connect-magic" class="btn btn-outline-primary btn-lg" style="display: none;">
                            <i class="fas fa-magic me-2"></i>
                            Connectez-vous avec Magic Link
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="text-center mb-4" style="display:none">
                        <span class="text-muted">or</span>
                    </div>

                    <!-- Magic Link Email Form -->
                    <form id="magic-email-form" class="mb-4" style="display:none">
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="Enter your email" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-envelope me-2"></i>
                            Se connecter par email
                        </button>
                    </form>

                    <!-- Features -->
                    <div class="row text-center mb-4">
                        <div class="col-4">
                            <i class="fas fa-shield-alt fa-2x text-success mb-2"></i>
                            <small class="d-block text-muted">Sécurisé</small>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-bolt fa-2x text-warning mb-2"></i>
                            <small class="d-block text-muted">Rapide</small>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-globe fa-2x text-info mb-2"></i>
                            <small class="d-block text-muted">Décentralisé</small>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center">
                        <small class="text-muted">
                            Vous n'avez pas de portefeuille ? 
                            <a href="https://metamask.io/download" target="_blank" class="text-primary-custom">
                                Obtenez MetaMask
                            </a>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Commencer
                    </h6>
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-1">
                            <i class="fas fa-check text-success me-2"></i>
                           Connectez votre portefeuille pour accéder à la plateforme
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-check text-success me-2"></i>
                            Utilisez le réseau de test pour une expérimentation en toute sécurité
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-check text-success me-2"></i>
                            Obtenez des jetons de test à partir du robinet
                        </li>
                        <li>
                            <i class="fas fa-check text-success me-2"></i>
                            Commencez à investir dans les factures tokenisées
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Check if already connected
    if (window.walletUtils && window.walletUtils.isWalletReady()) {
        window.location.href = window.COINFINANCE_CONFIG.baseUrl + 'dashboard';
        return;
    }

    $('#connect-metamask').click(async function() {
    const btn = $(this);
    const originalText = btn.html();

    try {
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Connecting...');
        btn.prop('disabled', true);

        const success = await window.walletUtils.connectMetaMask();
        if (success) {
            // Appel AJAX pour créer la session et obtenir l’URL
            $.post('<?= base_url("index.php/Auth/metaMaskLogin") ?>', { didToken: "dummyToken" }, function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    alert(response.message);
                }
            }, 'json');
        }
    } catch (error) {
        console.error('MetaMask connection failed:', error);
    } finally {
        btn.html(originalText);
        btn.prop('disabled', false);
    }
});


    // Magic Link connection
$('#connect-magic').click(async function() {
    const btn = $(this);
    const originalText = btn.html();
    
    try {
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Connecting...');
        btn.prop('disabled', true);
        
        if (!window.magic) {
            window.magic = new Magic(window.COINFINANCE_CONFIG.magicApiKey);
        }

        // Vérifie si déjà connecté
        const isLoggedIn = await window.magic.user.isLoggedIn();
        if (!isLoggedIn) {
            window.uiUtils.showErrorAlert('Please login with your email first.');
            return;
        }

        // Récupère le DID Token pour le backend
        const didToken = await window.magic.user.getIdToken();

        // Envoie le token au backend pour créer la session et rediriger
        $.post(window.COINFINANCE_CONFIG.baseUrl + "index.php/Auth/magicLogin", 
            { didToken: didToken }, 
            function(response) {
                if (response.success) {
                    // 🚀 Redirection envoyée par PHP
                    window.location.href = response.redirect;
                } else {
                    window.uiUtils.showErrorAlert(response.message);
                }
            },
            "json"
        );

    } catch (error) {
        console.error('Magic Link connection failed:', error);
        window.uiUtils.showErrorAlert('Connection failed: ' + error.message);
    } finally {
        btn.html(originalText);
        btn.prop('disabled', false);
    }
});



    // Magic Link email form
    $('#magic-email-form').submit(async function(e) {
        e.preventDefault();
        
        const email = $('#email').val();
        const btn = $(this).find('button[type="submit"]');
        const originalText = btn.html();
        
        if (!email) {
            window.uiUtils.showErrorAlert('Please enter your email address');
            return;
        }

        try {
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Sending...');
            btn.prop('disabled', true);
            
            // Initialize Magic if not already done
            if (!window.magic) {
                window.magic = new Magic(window.COINFINANCE_CONFIG.magicApiKey);
            }
            
            // Send magic link
            await window.magic.auth.loginWithMagicLink({ email });
            
            window.uiUtils.showSuccessAlert('Magic link sent! Check your email and click the link to login.');
            
            // Check for login completion
            const checkLogin = setInterval(async () => {
                const isLoggedIn = await window.magic.user.isLoggedIn();
                if (isLoggedIn) {
                    clearInterval(checkLogin);
                    await window.walletUtils.connectMagicLink();
                    window.location.href = window.COINFINANCE_CONFIG.baseUrl + 'dashboard';
                }
            }, 2000);
            
        } catch (error) {
            console.error('Magic Link failed:', error);
            window.uiUtils.showErrorAlert('Failed to send magic link: ' + error.message);
        } finally {
            btn.html(originalText);
            btn.prop('disabled', false);
        }
    });

    

    // Check for URL parameters (error messages, etc.)
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    
    if (error === 'invalid_token') {
        window.uiUtils.showErrorAlert('Invalid or expired magic link. Please try again.');
    }
});
</script>