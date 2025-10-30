<!DOCTYPE html>
<html lang="<?php echo $this->session->userdata('language') ?? 'fr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'CoinFinance'; ?></title>
    
    <!-- Favicon -->
<link rel="icon" href="<?php echo bowers_url('images/1.png'); ?>" type="image/png">
    
    <!-- CSS Framework -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/cssw/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/cssw/dark-theme.css'); ?>" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Ethers.js -->
    <script src="https://cdn.jsdelivr.net/npm/ethers@5.7.2/dist/ethers.umd.min.js"></script>
    
    <!-- Magic SDK -->
    <script src="https://auth.magic.link/sdk"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Configuration JavaScript -->
    <script>
        window.COINFINANCE_CONFIG = {
            baseUrl: '<?php echo base_url(); ?>',
            contracts: {
                invoiceToken: '<?php echo $_ENV['INVOICE_TOKEN_ADDRESS'] ?? ''; ?>',
                cfnToken: '<?php echo $_ENV['CFN_TOKEN_ADDRESS'] ?? ''; ?>',
            },

           networks: {
            chainId: '<?php echo $_ENV['CHAIN_ID'] ?? ''; ?>',
            chainIdInt: <?php echo $_ENV['CHAIN_ID_INT'] ?? ''; ?>,
            name: "<?php echo $_ENV['NETWORK_NAME'] ?? 'Hedera Testnet'; ?>",
            rpc: '<?php echo $_ENV['NETWORK_RPC'] ?? ''; ?>',
            explorer: '<?php echo $_ENV['NETWORK_EXPLORER'] ?? ''; ?>',
            nativeCurrency: {
                name: '<?php echo $_ENV['NATIVE_CURRENCY_NAME'] ?? 'HBAR'; ?>',
                symbol: '<?php echo $_ENV['NATIVE_CURRENCY_SYMBOL'] ?? 'HBAR'; ?>',
                decimals: <?php echo $_ENV['NATIVE_CURRENCY_DECIMALS'] ?? 18; ?>
            }
        },
            
            magicApiKey: '<?php echo $_ENV['MAGIC_LINK_API_KEY'] ?? ''; ?>',
            pinataApiKey: '<?php echo $_ENV['PINATA_API_KEY'] ?? ''; ?>',
            pinataSecretKey: '<?php echo $_ENV['PINATA_SECRET_API_KEY'] ?? ''; ?>',
            userRole: '<?php echo $this->session->userdata('user_role') ?? 'guest'; ?>',
            walletAddress: '<?php echo $this->session->userdata('wallet_address') ?? ''; ?>',
            language: '<?php echo $this->session->userdata('language') ?? 'fr'; ?>'
        };
    </script>
</head>
<body class="dark-theme" style="background-color: white;">
    <!-- Loading Spinner -->
    <div id="loading-spinner" class="loading-spinner d-none">
        <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="<?php echo site_url('Accueil'); ?>">
                <span class="fw-bold text-warning">CoinFinance</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if($this->session->userdata('is_logged_in')): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($active_page) && $active_page == 'dashboard') ? 'active' : ''; ?>" 
                               href="<?php echo site_url('dashboard'); ?>">
                                <i class="fas fa-home me-1"></i> Dashboard
                            </a>
                        </li>
                        
                        <?php if($this->session->userdata('user_role') == 'admin'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog me-1"></i> Admin
                                </a>
                                <ul class="dropdown-menu bg-dark">
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('admin'); ?>">Dashboard</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('admin/users'); ?>">Users</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('admin/invoices'); ?>">Invoices</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('admin/pools'); ?>">Pools</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('admin/settings'); ?>">Settings</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <?php if(in_array($this->session->userdata('user_role'), ['enterprise', 'admin'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="enterpriseDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-building me-1"></i> Enterprise
                                </a>
                                <ul class="dropdown-menu bg-dark">
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('enterprise'); ?>">Dashboard</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('enterprise/invoices'); ?>">My Invoices</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('enterprise/create_invoice'); ?>">Submit Invoice</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('enterprise/funds'); ?>">Withdraw Funds</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <?php if(in_array($this->session->userdata('user_role'), ['investor', 'admin'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="investorDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-chart-line me-1"></i> Investor
                                </a>
                                <ul class="dropdown-menu bg-dark">
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('investor'); ?>">Dashboard</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('investor/marketplace'); ?>">Marketplace</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('investor/pools'); ?>">Pools</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('investor/portfolio'); ?>">Portfolio</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('investor/claims'); ?>">Claims</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <?php if(in_array($this->session->userdata('user_role'), ['client', 'admin'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="clientDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user me-1"></i> Client
                                </a>
                                <ul class="dropdown-menu bg-dark">
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('client'); ?>">Dashboard</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('client/invoices'); ?>">My Invoices</a></li>
                                    <li><a class="dropdown-item text-light" href="<?php echo site_url('client/payment_history'); ?>">Payment History</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>

                <!-- Right Side Menu -->
                <ul class="navbar-nav">
                    <!-- Wallet Connection Status -->
                    <li class="nav-item">
                        <div id="wallet-status" class="nav-link">
                            <span id="wallet-indicator" class="badge bg-secondary">
                                <i class="fas fa-wallet me-1"></i> Non connecté
                            </span>
                        </div>
                    </li>
                    
                    <!-- Network Status -->
                    <li class="nav-item">
                        <div id="network-status" class="nav-link">
                            <span id="network-indicator" class="badge bg-info">
                                <i class="fas fa-network-wired me-1"></i> <span id="current-network"></span>
                            </span>
                        </div>
                    </li>
                    
                    <!-- Token Balance -->
                    <li class="nav-item">
                        <div id="token-balance" class="nav-link">
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-coins me-1"></i> <span id="balance-amount">0</span> <span id="balance-symbol">USDT</span>
                            </span>
                        </div>
                    </li>
                    
                    <!-- Language Switcher -->
                   <li class="nav-item dropdown" style="display: none;">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-globe me-1"></i> 
                            <?php echo $this->session->userdata('language') == 'en' ? 'EN' : 'FR'; ?>
                        </a>
                        <ul class="dropdown-menu bg-dark">
                            <li><a class="dropdown-item text-light" href="#" onclick="switchLanguage('fr')">Français</a></li>
                            <li><a class="dropdown-item text-light" href="#" onclick="switchLanguage('en')">English</a></li>
                        </ul>
                    </li>

                    <?php if($this->session->userdata('is_logged_in') || !empty($this->session->userdata('wallet_address'))): ?>
                        <!-- User Menu -->
                        <li  class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> 
                                <?php echo $this->session->userdata('email') ?? substr($this->session->userdata('wallet_address'), 0, 6) . '...'; ?>
                            </a>
                            <ul class="dropdown-menu bg-dark">
                                <li><a class="dropdown-item text-light" href="<?php echo site_url('Dashboard/profile'); ?>">Profile</a></li>
                                <li><a class="dropdown-item text-light" href="<?php echo site_url('Dashboard/settings'); ?>">Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-light" href="<?php echo site_url('Auth/logout'); ?>">Déconnexion</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                    <!-- Login/Register -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('auth/login'); ?>">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li> -->
                    <li class="nav-item" style="display:none">
                        <a class="nav-link" href="#" onclick="confirmLogout()">
                            <i class="fas fa-sign-in-alt me-1"></i> Logout
                        </a>
                    </li>

                   <!--  <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('auth/register'); ?>">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </a>
                    </li> -->
                <?php endif; ?>  

                </ul>
            </div>
        </div>

        
    </nav>

    <!-- Main Content -->
    <main class="main-content">

    <script>
        // Fonction globale accessible depuis le menu
        function confirmLogout() {
            window.walletUtils.confirmLogout();
        }
    </script>

