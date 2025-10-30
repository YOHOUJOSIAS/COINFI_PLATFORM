
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>">
    
    <!-- CSS Framework -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/dark-theme.css'); ?>" rel="stylesheet">
    
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


<!-- Top Bar -->
<div class="row gx-0">
<div class="col-md-6 text-center text-lg-start mb-2 mb-lg-0">
    <div class="d-inline-flex align-items-center">
        <small class="py-2"><i class="far fa-clock text-primary me-2"></i>Support en ligne: Lundi - Samedi : 7h00min - 22h00min , Dimanche Fermé </small>

    </div>
</div>
<div class="col-md-6 text-center text-lg-end">
    <div class="position-relative d-inline-flex align-items-center top-shape px-5" style="background:#07406A; color:#fff;">
        <div class="me-3 pe-3 border-end py-2">
            <p class="m-0 text-white"><i class="fa fa-envelope-open me-2"></i>coinfinance@coinfi-ci.com</p>
        </div>
        <div class="py-2">
            <p class="m-0 text-white"><i class="fa fa-phone-alt me-2"></i>+225 07 58 13 22 24</p>
        </div>
    </div>
</div>
</div>