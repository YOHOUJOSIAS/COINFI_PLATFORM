</main>

    <!-- Footer -->
   <footer style="background: #181f2a; color: #cfd8dc; font-family: 'Montserrat', Arial, sans-serif; padding-top: 48px;">
  <div class="container py-4">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6">
        <h3 style="font-weight: 800; color: #fff;">
          CoinFinance<span style="color: #00e676;"></span>
        </h3>
        <p style="margin-bottom: 18px;">Plateforme d'affacturage tokenisé pour PME Africaine.</p>
        <div class="d-flex mb-3">
          <a href="#" style="color: #cfd8dc; font-size: 1.3rem; margin-right: 16px;"><i class="fa fa-facebook"></i></a>
          <a href="#" style="color: #cfd8dc; font-size: 1.3rem; margin-right: 16px;"><i class="fa fa-twitter"></i></a>
          <a href="#" style="color: #cfd8dc; font-size: 1.3rem; margin-right: 16px;"><i class="fa fa-instagram"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-md-6">
        <h5 style="color: #fff; font-weight: 700;">Liens rapides</h5>
        <ul class="list-unstyled">
          <li><a href="#" style="color: #cfd8dc; text-decoration: none;">Accueil</a></li>
          <li><a href="#" style="color: #cfd8dc; text-decoration: none;">Pools</a></li>
          <li><a href="#" style="color: #cfd8dc; text-decoration: none;">Marketplace</a></li>
          <li><a href="#" style="color: #cfd8dc; text-decoration: none;">Mon Compte</a></li>
          <li><a href="#" style="color: #cfd8dc; text-decoration: none;">Blog</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6">
        <h5 style="color: #fff; font-weight: 700;">Ressources</h5>
        <ul class="list-unstyled">
          <li><a href="#" style="color: #cfd8dc; text-decoration: none;">Tutoriels</a></li>
          <li><a href="#" style="color: #cfd8dc; text-decoration: none;">FAQ</a></li>
          <li><a href="#" style="color: #cfd8dc; text-decoration: none;">Réglementation BCEAO</a></li>
          <li><a href="#" style="color: #cfd8dc; text-decoration: none;">Lexique Fintech</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6">
        <h5 style="color: #fff; font-weight: 700;">Contact</h5>
        <ul class="list-unstyled" style="font-size: 1rem;">
          <li><i class="fa fa-map-marker" style="color: #FFD600; margin-right: 8px;"></i> Port-Bouet, Abidjan<br>Côte d'Ivoire</li>
          <li class="mt-2"><i class="fa fa-phone" style="color: #FFD600; margin-right: 8px;"></i>+225 07 58 13 22 24</li>
          <li class="mt-2"><i class="fa fa-envelope" style="color: #FFD600; margin-right: 8px;"></i>coinfinance@coinfi-ci.com</li>
        </ul>
      </div>
    </div>
    <hr style="border-color: #263043; margin: 32px 0 16px 0;">
    <div class="row align-items-center">
      <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
        <small>&copy; 2025 CoinFinance-CI. Tous droits réservés.</small>
      </div>
      <div class="col-md-6 text-center text-md-end">
        <a href="#" style="color: #cfd8dc; text-decoration: none; margin-right: 18px;">Conditions d'utilisation</a>
        <a href="#" style="color: #cfd8dc; text-decoration: none; margin-right: 18px;">Politique de confidentialité</a>
        <a href="#" style="color: #cfd8dc; text-decoration: none;">Mentions légales</a>
      </div>
    </div>
  </div>
</footer>



    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript Files -->
    <script type="module" src="<?php echo base_url('assets/js/contracts/adminFunctions.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/walletUtils.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/contracts/uiUtils.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/contracts/ipfsUtils.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/sharedFunctions.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/stablecoinCFN.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/adminFunctions.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/enterpriseFunctions.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/investorFunctions.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/clientFunctions.js'); ?>"></script> 
    <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo base_url('assets/js/language.js'); ?>"></script>


    
    <!-- Page-specific JavaScript -->
    <?php if(isset($additional_js)): ?>
        <?php foreach($additional_js as $js_file): ?>
            <script src="<?php echo base_url('assets/js/' . $js_file); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <script>
        // Initialize application when DOM is ready
        $(document).ready(function() {
            initializeWallet();
            updateUILanguage();
            
            // Auto-update token balance every 30 seconds
            setInterval(updateTokenBalance, 30000);
            
            // Auto-update network status every 10 seconds
            setInterval(updateNetworkStatus, 10000);
        });
    </script>
</body>
</html>