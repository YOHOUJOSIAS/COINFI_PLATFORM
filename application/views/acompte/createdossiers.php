<!DOCTYPE html>
<html lang="fr">
<head>
<?php $this->load->view('tpl/css_files'); ?>
</head>
<body>


<!-- Topbar Start -->
<div class="container-fluid bg-light ps-5 pe-0 d-none d-lg-block">
<?php $this->load->view('tpl/header'); ?>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
<?php 
  $data['page'] = 'dossiers';
  $this->load->view('tpl/menu'); 
?>
</nav>
<!-- Navbar End -->


<div class="container-fluid py-5">
<div class="container">
<div class="row g-5">

<!-- Sidebar -->
<div class="col-lg-3">
<div class="sidebar">

<?php 
  $data['page'] = 'dossiers';
  $this->load->view('tpl/sidebar'); 
?>		

</div>
</div>

<!-- News Posts -->
<div class="col-lg-9 wow">

<!-- Mon Compte -->
<div class="news_post" style="margin-bottom: 30px;">
	
	<legend align="center">Création d'un dossier</legend>           

	<form class="comfirms1" action="<?php echo site_url('MonCompte/createCompteUsers');?>" method="post">
	  <div class="row">
	    <div class="col">
	    	<label style="padding-bottom: 10px;">Nom</label>
	      <input type="text" class="form-control" placeholder="Nom *" name="nom_patients" required=""  style="color: black;">
	    </div>
	    <div class="col">
	    	<label style="padding-bottom: 10px;">Prénom(s)</label>
	      <input type="text" class="form-control" placeholder="Prénom(s) *" name="prenoms_patients" required="" style="color: black;">
	    </div>
	  </div>

	  <div class="row" style="margin-top: 20px;">
	    <div class="col">	 
	     <label style="padding-bottom: 10px;">Catégorie Patient</label>     
	      <select class="form-select" name="catVaccinsID" id="catVaccinsID" required style="color: black; ">
	      	<option>Choisissez une catégorie</option>
            <?php foreach ($getCatVaccins as $catVaccins) : ?>
              <option value="<?php echo $catVaccins->id_cat_vaccins; ?>"><?php echo $catVaccins->nom_cat_vaccins; ?></option>
            <?php endforeach; ?> 
        </select>
	    </div>

	    <div class="col">
	    	<label style="padding-bottom: 10px;">Sous Catégorie Patient</label> 
	        <select name="sousVaccinsID" class="form-select" id="idProduitsEntreprise" required style="color: black; ">
	            <option>Choisissez une sous Catégorie</option>
	        </select>
	    </div>
	    </div>


	  <div class="row" style="margin-top: 20px; display: none;">
	    <div class="col">
	    	<label style="padding-bottom: 10px;">Mobile Patient</label> 
	      <input type="text" class="form-control" placeholder="Mobile *" name="contact_patients"  style="color: black;" maxlength="14" minlength="14" readonly value="<?php echo $this->session->userdata('numero_telephone'); ?>">
	    </div>
	    <div class="col">
	    	<label style="padding-bottom: 10px;">Email Patient</label> 
	      <input type="email" class="form-control" placeholder="Email" name="email_patients" style="color: black;" readonly value="<?php echo $this->session->userdata('email_users'); ?>">
	    </div>
	  </div>
	  <div class="row" style="margin-top: 20px;">
	    <div class="col">
	    	<label style="padding-bottom: 10px;">Sexe Patient</label> 
	      <select class="form-select" name="sexe_patients" style="color: black;" required>
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
          </select>   
	    </div>
	    <div class="col">
	    	<label style="padding-bottom: 10px;">Date Naissance Patient</label> 
	      <input class="form-control" type="date" placeholder="Date" name="dateNaisPatients" value="<?php echo date("Y-m-d"); ?>" required="" max="<?php echo date("Y-m-d"); ?>" style="color: black; ">
	    </div>
	  </div>

	  <div class="row" style="margin-top: 20px;">
	    <div class="col">
	    	<label style="padding-bottom: 10px;">Métier Patient</label> 
	      <select class="form-select" name="metiersID" style="color: black; ">
            <?php foreach ($getMetiers as $metiers) : ?>
              <option value="<?php echo $metiers->id_metiers; ?>"><?php echo $metiers->libelle_metiers; ?></option>
            <?php endforeach; ?>  
          </select>   
	    </div>
	    <div class="col">
	    	<label style="padding-bottom: 10px;">Groupe Sanguin</label> 
	      <select class="form-select" name="groupeSangPatients" style="color: black; " required>
            <?php foreach ($getGroupeSanguins as $getGroupe) : ?>
              <option value="<?php echo $getGroupe->libelle_groupes_sanguins; ?>"><?php echo $getGroupe->libelle_groupes_sanguins; ?></option>
            <?php endforeach; ?>  
          </select>  
	    </div>
	    </div>

	    <div class="row" style="margin-top: 20px;">
	    <div class="col">
	    	<label style="padding-bottom: 10px;">Commune Patient</label> 
	      <select class="form-select" name="communePatientsId" style="color: black; ">
            <?php foreach ($getCommunes as $commune) : ?>
              <option value="<?php echo $commune->id_commune; ?>"><?php echo $commune->nom_commune; ?></option>
            <?php endforeach; ?>  
          </select> 
	    </div>
	    <div class="col">
	    	<label style="padding-bottom: 10px;">Adresse Patient</label> 
	      <input type="text" class="form-control" placeholder="Adresse" name="adresse_patients" style="color: black;">
	    </div>
	    </div>


	  
	  <div class="row text-center" style="margin-top: 20px;">
	  	<div class="col">
	 	 <button type="submit" class="btn btn-primary" id="comfirms1">AJOUTER</button>
	 	</div>
	  </div>
	</form>


</div>


</div>
</div>



</div>
</div>
</div>

<!-- Footer Start -->
<?php $this->load->view('tpl/footer'); ?>
<!-- Footer End -->


<!-- Back to Top -->
<!-- <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="fa fa-arrow-up"></i></a> -->

<?php $this->load->view('tpl/js_files'); ?>

<script type="text/javascript">
//Initialize Select2 Elements
$(document).on("change", "#catVaccinsID", function () 
{
	$('#idProduitsEntreprise').empty();
	var catVaccinsID = $("#catVaccinsID").val(); 
    
    $.post("<?php echo site_url("MonCompte/jqueryListeSousVaccinsByCatVaccins") ?>", {catVaccinsID : catVaccinsID})
        .done(function (data) {
        
        if(data !== "")
        {    
            data = JSON.parse(data);
            $("#idProduitsEntreprise").append('<option>Choisissez un sous vaccin</option>');
            $.each(data, function (index, value)
            {  
              $("#idProduitsEntreprise").append('<option value="' + value["id_sous_vaccins"] + '" getMontant="' + value["id_sous_vaccins"] + '">' + value["nom_sous_vaccins"] + ' </option>');
            });

        }
        else
        {  
            $.alert('Aucun sous vaccin disponible pour le moment !');  
        }
        
    })
    .fail(function (error) {
        console.log(error);
    });  

});



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