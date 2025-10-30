<!DOCTYPE html>
<html lang="fr">

<head>
    <?php $this->load->view('tpl/css_files'); ?>
</head>

<body>
<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
<div class="spinner-grow text-primary m-1" role="status">
    <span class="sr-only">Loading...</span>
</div>
<div class="spinner-grow text-dark m-1" role="status">
    <span class="sr-only">Loading...</span>
</div>
<div class="spinner-grow text-secondary m-1" role="status">
    <span class="sr-only">Loading...</span>
</div>
</div>
<!-- Spinner End -->


<!-- Topbar Start -->
<div class="container-fluid bg-light ps-5 pe-0 d-none d-lg-block">
<?php $this->load->view('tpl/header'); ?>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
<?php 
  $data['page'] = 'assurances';
  $this->load->view('tpl/menu'); 
?>
</nav>
<!-- Navbar End -->


<!-- Full Screen Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1">
<div class="modal-dialog modal-fullscreen">
    <div class="modal-content" style="background: rgba(9, 30, 62, .7);">
        <div class="modal-header border-0">
            <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex align-items-center justify-content-center">
            <div class="input-group" style="max-width: 600px;">
                <input type="text" class="form-control bg-transparent border-primary p-3" placeholder="Type search keyword">
                <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Full Screen Search End -->


<!-- Hero Start -->
<div class="container-fluid bg-primary py-5 hero-header mb-5">
<div class="row py-3">
    <div class="col-12 text-center">
        <h1 class="display-3 text-white animated zoomIn">Nos Assurances</h1>
        <a href="<?php echo site_url('Accueil');?>" class="h4 text-white">Accueil</a>
        <i class="fa fa-circle text-white px-2"></i>
        <a href="<?php echo site_url('Pharmacies');?>" class="h4 text-white">Assurances</a>
    </div>
</div>
</div>
<!-- Hero End -->


<!-- Contact Start -->
<div class="container-fluid py-5">
<div class="container">

<?php if ($getPharmacies) { ?>
<h3 class="cont-head" align="center">Liste des assurances acceptées par : <?php echo $getPharmacies->nom_entreprise; ?></h3>
<?php } ; ?>

<div class="d-grid align-form-map">
<!-- Team Start -->
<div class="container-fluid py-5">
<div class="container">
<div class="row g-5">

<?php foreach ($getListeAssur as $assur) : ?> 
<div class="col-lg-4 wow slideInUp" data-wow-delay="0.1s">
    <div class="team-item">
        <div class="position-relative rounded-top" style="z-index: 1;">
            <!-- <img class="img-fluid rounded-top w-100" src="<?php echo bowers_url('images/logo-pharmacie.jpeg'); ?>" alt="PHARMACIE"> -->
            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-ambulance"></i></a>
            </div>
        </div>
        <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
            <h4 class="mb-2"><?php echo $assur->libelle_assurances; ?></h4>
            <p class="text-primary mb-0"><?php echo $assur->contact_assurances; ?></p>
        </div>
    </div>
</div>
<?php endforeach;?>


</div>
</div>
</div>
<!-- Team End -->

</div>
</div>
<!-- Contact End -->


   
<?php $this->load->view('tpl/footer'); ?>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="fa fa-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<?php $this->load->view('tpl/js_files'); ?>

<script type="text/javascript">
//Initialize Select2 Elements

jQuery(document).ready(function() {
<?php
if ($this->session->flashdata("success")){
  echo "toast_success('".$this->session->flashdata("success")."');";
   unset($_SESSION['success']);
}
?>
<?php
if ($this->session->flashdata("error")){
   echo "toast_error('".$this->session->flashdata("error")."');";
   unset($_SESSION['error']);
}
?>
});

</script>

   
</body>

</html>