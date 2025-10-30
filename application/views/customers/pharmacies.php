<!DOCTYPE html>
<html lang="fr">
<head>
<?php $this->load->view('tpl/css_files'); ?>
</head>
<body>

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
          $data['page'] = 'pharmacies';
          $this->load->view('tpl/menu'); 
        ?>
    </nav>
    <!-- Navbar End -->


	<div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">

				<!-- Sidebar -->
				<div class="col-lg-4">
					<div class="sidebar">

						<!-- Search -->
						<div class="sidebar_search">
							<legend style="text-align:center;"><b>Filtrer Par Commune</b></legend>
							<form action="<?php echo site_url('Pharmacies/rechercher');?>" method="post">
		                        <div class="row g-3">
		                            <div class="col-12">

			                        <select class="form-select border-0 bg-light px-4" name="communeId" style="height: 55px;">
				                          <?php foreach ($getCommunes as $commune) : ?>
				                            <option value="<?php echo $commune->id_commune; ?>" <?php if($this->session->userdata('communeId') == $commune->id_commune) echo "selected=true"; ?>><?php echo $commune->nom_commune; ?></option>
				                          <?php endforeach; ?>  
				                        </select>
		                            </div>
		                            
		                            <div class="col-12" align="center">
		                               <button class="btn btn-primary py-3" type="submit">Rechercher</button>
		                            </div>

		                        </div>
		                    </form>
						</div>			
					</div>
				</div>
				
				<!-- News Posts -->
				<div class="col-lg-8 wow">

					<?php if ($getPeriodesGarde) { ?>
					<div class="section-title mb-4">
                        <h2 class="mb-0 text-center">Semaine du <?php echo date("d/m/Y", strtotime($getPeriodesGarde->dateDebutPeriode)); ?> Au <?php echo date("d/m/Y", strtotime($getPeriodesGarde->dateFinPeriode)); ?></h2>
                    </div>
                    <?php } ; ?>

					<div class="news_posts">
						
						<?php foreach ($getPharmacies as $pharmacies) : ?> 
						<!-- News Post -->
						<div class="news_post" style="border:0.5px solid black; margin-bottom: 30px;">
							<div class="news_image">
								<img src="images/news_1.jpg" alt="">
								<div class="news_date d-flex flex-column align-items-center justify-content-center">
										<img class="img-fluid mx-auto rounded mb-4" src="<?php echo bowers_url('images/logo-pharmacie.jpeg'); ?>" alt="PHARMACIE" style="width: 130px; height:50px;">
								</div>
							</div>

							<div class="news_body">
								<div class="news_title text-center"><h4 class="mb-0 text-center"><?php echo $pharmacies->nom_entreprise; ?><h4></div>
								<div class="news_info text-center" style="margin-bottom: 15px; color: black;">
										<span class="fa fa-mobile"> <?php echo $pharmacies->contact_entreprise; ?> / <?php echo $pharmacies->contact2_entreprise; ?></span><br>
										<span class="fa fa-map-marker" > <?php echo $pharmacies->nom_commune; ?></span>
										<span class="fa fa-arrow-right"> <?php echo $pharmacies->situationGeoEntreprise; ?></span>
								</div>
								<div class="news_link" align="center" style="margin-bottom: 20px;"><a href="http://maps.google.com/maps?q=<?php echo urlencode($pharmacies->adresseGoogleEntreprise); ?>" class="btn btn-outline-primary">VOIR LA POSITION</a></div>
								<div class="news_link" align="center" style="margin-bottom: 20px;"><a href="<?php echo site_url('Pharmacies/listerLesAssurances')."/".$pharmacies->id_entreprise ; ?>" class="btn btn-outline-danger">VOIR LES ASSURANCES</a></div>
							</div>
						</div>

						<?php endforeach;?>


					</div>
				</div>

				

			</div>
		</div>
	</div>

<!-- Footer Start -->
<?php $this->load->view('tpl/footer'); ?>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="fa fa-arrow-up"></i></a>

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