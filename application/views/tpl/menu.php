

<a href="<?php echo site_url('Accueil');?>" class="navbar-brand p-0" <?php if(!empty($this->session->userdata('numero_telephone'))) echo 'style="display : none;"'; ?>>
  <h1 class="m-0 text-warning">
    <img src="<?php echo base_url('assets/img/1.png'); ?>" alt="CoinFinance Logo" style="height:38px; margin-right:10px; vertical-align:middle;">
    CoinFinance
  </h1>
</a>
<a href="<?php echo site_url('MonCompte');?>" class="navbar-brand p-0" <?php if(empty($this->session->userdata('numero_telephone'))) echo 'style="display : none;"'; ?>>
  <img src="<?php echo bowers_url('images/1.png'); ?>" style="width: 40px; height:40px" >
</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarCollapse">
    <div class="navbar-nav ms-auto py-0">
        <a href="<?php echo site_url('Accueil');?>" class="nav-item nav-link <?php if($page == 'index') echo 'active';?>">Accueil</a>
        <a href="<?php echo site_url('Accueil/marche');?>" class="nav-item nav-link <?php if($page == 'commentcamarches') echo 'active';?>">Comment ça marche ?</a>
        <a href="<?php echo site_url('Accueil/market');?>" class="nav-item nav-link <?php if($page == 'marketplace') echo 'active';?>">Marketplace </a>
        <a href="<?php echo site_url('Accueil/presentation');?>" class="nav-item nav-link <?php if($page == 'apropos') echo 'active';?>">A propos de nous</a>
        <a href="<?php echo site_url('Accueil/blogs');?>" class="nav-item nav-link <?php if($page == 'blogs') echo 'active';?>">Blog & FAQ</a>

    </div>
   
   
    <a href="<?php echo site_url('MonCompte/prendreRendezVous');?>" class="btn btn-warning py-2 px-4 ms-3" <?php if(empty($this->session->userdata('numero_telephone'))) echo 'style="display : none;"'; ?> style="background: #06A3DA;color: white;">Tableau de bord</a>

    <a style="display: none;" href="<?php echo site_url('Accueil/login');?>" class="btn btn-warning" <?php if(!empty($this->session->userdata('numero_telephone'))) echo 'style="display : none;"'; ?>>Connexion / Inscription</a>
    <select class="btn text-dark" onchange="javascript:window.location.href='<?php echo site_url(); ?>/LanguageSwitcher/switchLang/'+this.value;" style="display : none;">
      <option value="francais" <?php if($this->session->userdata('site_lang') == "francais") echo 'selected="selected"'; ?>><?php echo $this->lang->line('francais'); ?></option>
      <option value="english" <?php if($this->session->userdata('site_lang') == "english") echo 'selected="selected"'; ?>><?php echo $this->lang->line('anglais'); ?></option>
    </select>

    <select class="btn text-dark" style="display: none;" onchange="javascript:window.location.href='https://vaccipha.com:444/'+this.value;" <?php if(!empty($this->session->userdata('numero_telephone'))) echo 'style="display : none;"'; ?>>
      <option value="vaccipha">NOS ESPACES</option>
      <option value="dash-pharma">PME</option>
      <option value="dash-cliniq">DEBITEUR</option>
      <option value="dash-district">INVESTISSEUR</option>
    
    </select>
    
    <div class="nav-item dropdown" <?php if(empty($this->session->userdata('numero_telephone'))) echo 'style="display : none;"'; ?>>
        <a href="<?php echo site_url('MonCompte');?>" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" <?php if($page == 'comptes') echo 'style="color : #ffba00 !important;"';?> style="color: black;"><b>Mon Compte</b></a>
        <div class="dropdown-menu m-0">
            <a href="<?php echo site_url('MonCompte');?>" class="dropdown-item">Mon Profil</a>
            <a href="<?php echo site_url('Deconnexion');?>" class="dropdown-item">Déconnexion</a>
        </div>
    </div>
    
    <div class="nav-item dropdown" <?php if(!empty($this->session->userdata('numero_telephone'))) echo 'style="display : none;"'; ?> style="margin-left: 10px;"
     <?php if(!empty($this->session->userdata('numero_telephone'))) echo 'style="display : none;"'; ?>
     >
        
    <button class="btn dropdown-toggle d-flex align-items-center gap-2" type="button" id="walletDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background:#07406A; color:#fff; border:none;">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path fill="#fff" d="M3 7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7Z"/><rect width="18" height="14" x="3" y="5" fill="#fff" rx="2"/><rect width="18" height="14" x="3" y="5" stroke="#06A3DA" stroke-width="2" rx="2"/><rect width="4" height="4" x="17" y="10" fill="#06A3DA" rx="2"/></svg>
        Connect Wallet
    </button>
    <ul class="dropdown-menu" aria-labelledby="walletDropdown" style="min-width:220px;">
        <li class="dropdown-header">Choisis ton wallet</li>
        <li>

           
            <a class="dropdown-item d-flex align-items-center gap-2" href="<?php echo site_url('Auth'); ?>">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3ymr3UNKopfI0NmUY95Dr-0589vG-91KuAA&s" alt="MetaMask" style="height:22px;width:22px;">
                MetaMask
            </a>
        </li>

        <li>
  <a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0);" 
     onclick="Swal.fire('En cours de finalisation...', 'Merci de patienter', 'info')">
      <img src="https://media.graphcms.com/resize=w:1024,h:1024,fit:crop/auto_image/compress/XHQzmJyDRmaCwGoEcb8i" 
           alt="MagicLink" style="height:22px;width:22px;">
      MagicLink
  </a>
</li>

        
        <!-- <li>
            <a class="dropdown-item d-flex align-items-center gap-2" href="https://magic.link/">
                <img src="https://media.graphcms.com/resize=w:1024,h:1024,fit:crop/auto_image/compress/XHQzmJyDRmaCwGoEcb8i" alt="WalletConnect" style="height:22px;width:22px;">
                MagicLink
            </a>
        </li> -->
    </ul>
</div>
</div>