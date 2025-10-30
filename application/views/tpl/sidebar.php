<!-- Search -->
<div class="sidebar_search" style="border:0.5px solid black;">
	<legend style="text-align:center;color: black;margin-bottom: 15px;"><b>Menu Principal</b></legend>

	<a href="<?php echo site_url('MonCompte');?>" <?php if($page == 'comptes') echo 'style="background : #dc3545; margin-bottom: 15px; color:white;"'; ?> class="form-control btn btn-outline-primary"  style="font: bold; margin-bottom: 15px;" >Mon Compte</a>

    <a href="<?php echo site_url('MonCompte/MesRendezVous');?>" <?php if($page == 'rendezvous') echo 'style="background : #dc3545; margin-bottom: 15px; color:white;"'; ?> class="form-control btn btn-outline-primary" style="font: bold; margin-bottom: 15px;">Mes Rendez-vous</a>

    <a href="<?php echo site_url('MonCompte/MesRappelsVaccins');?>" <?php if($page == 'listedesrappels') echo 'style="background : #dc3545; margin-bottom: 15px; color:white;"'; ?> class="form-control btn btn-outline-primary" style="font: bold; margin-bottom: 15px;">Mes Rappels de Vaccins</a>

    <a href="<?php echo site_url('MonCompte/MesDossiers');?>" <?php if($page == 'dossiers') echo 'style="background : #dc3545; margin-bottom: 15px; color:white;"'; ?> class="form-control btn btn-outline-primary" style="font: bold; margin-bottom: 15px;">Mes Carnets & Dossiers</a>

    <a href="<?php echo site_url('MonCompte/Password');?>" <?php if($page == 'motdepasse') echo 'style="background : #dc3545; margin-bottom: 15px; color:white;"'; ?> class="form-control btn btn-outline-primary" style="font: bold; margin-bottom: 15px;">Mot de passe</a>

    <a href="<?php echo site_url('Deconnexion');?>" class="form-control btn btn-outline-primary" style="font: bold; margin-bottom: 5px;">Déconnexion</a>
	
</div>	