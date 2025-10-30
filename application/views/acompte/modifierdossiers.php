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
		
		<legend align="center">Mise à jour du compte</legend>           
		<?php foreach ($getComptes as $gets) : ?> 
		<form class="comfirms1" action="<?php echo site_url('MonCompte/majDossiersPatients');?>" method="post">

		  <input type="hidden" class="form-control" required name="id_patients" value="<?php echo $gets->id_patients; ?>">

		  <div class="row">
		    <div class="col">
		      <label style="padding-bottom: 10px;">Nom</label> 
		      <input type="text" class="form-control" placeholder="Nom *" name="nom_patients" required="" value="<?php echo $gets->nom_patients; ?>" style="color: black;">
		    </div>
		    <div class="col">
		      <label style="padding-bottom: 10px;">Prénom(s)</label> 
		      <input type="text" class="form-control" placeholder="Prénom(s) *" name="prenoms_patients" required="" value="<?php echo $gets->prenoms_patients; ?>" style="color: black;">
		    </div>
		  </div>

		  <div class="row" style="margin-top: 20px;">
		    <div class="col">
		     <label style="padding-bottom: 10px;">Catégorie</label> 	      
		      <select class="form-select" name="catVaccinsID" id="catVaccinsID" required style="color: black; ">
		      	<option>Choisissez une catégorie</option>
	            <?php foreach ($getCatVaccins as $catVaccins) : ?>
	              <option value="<?php echo $catVaccins->id_cat_vaccins; ?>" <?php if($gets->catVaccinsID == $catVaccins->id_cat_vaccins) echo "selected=true"; ?>><?php echo $catVaccins->nom_cat_vaccins; ?></option>
	            <?php endforeach; ?> 
	        </select>
		    </div>

	    <div class="col">
	    	<label style="padding-bottom: 10px;">Sous Catégorie</label> 
	        <select name="sousVaccinsID" class="form-select" id="idProduitsEntreprise" required style="color: black; ">
	            <option>Choisissez un sous vaccin</option>
	        </select>
	    </div>
	    </div>

		  <div class="row" style="margin-top: 20px;">
		    <div class="col">
		    	<label style="padding-bottom: 10px;">Sexe</label> 
		      <select class="form-select" name="sexe_patients" style="color: black; ">
                <option value="Homme" <?php if($gets->sexe_patients == "Homme") echo "selected=true"; ?>>Homme</option>
                <option value="Femme" <?php if($gets->sexe_patients == "Femme") echo "selected=true"; ?>>Femme</option>
              </select>   
		    </div>
		    <div class="col">
		    	<label style="padding-bottom: 10px;">Date Naissance</label> 
		      <input class="form-control" type="date" placeholder="Date" name="dateNaisPatients" value="<?php echo $gets->dateNaisPatients; ?>" required="" max="<?php echo date("Y-m-d", strtotime('- 15 years')); ?>" style="color: black; ">
		    </div>
		  </div>
		  <div class="row" style="margin-top: 20px;">
		    <div class="col">
		    	<label style="padding-bottom: 10px;">Métier</label> 
		      <select class="form-select" name="metiersID" style="color: black; ">
                <?php foreach ($getMetiers as $metiers) : ?>
                  <option value="<?php echo $metiers->id_metiers; ?>" <?php if($gets->metiersID == $metiers->id_metiers) echo "selected=true"; ?>><?php echo $metiers->libelle_metiers; ?></option>
                <?php endforeach; ?>  
              </select>   
		    </div>
		    <div class="col">
		    	<label style="padding-bottom: 10px;">Groupe Sanguin</label> 
		      <select class="form-select" name="groupeSangPatients" style="color: black; " required>
                <?php foreach ($getGroupeSanguins as $getGroupe) : ?>
                  <option value="<?php echo $getGroupe->libelle_groupes_sanguins; ?>" <?php if($gets->groupeSangPatients == $getGroupe->libelle_groupes_sanguins) echo "selected=true"; ?>><?php echo $getGroupe->libelle_groupes_sanguins; ?></option>
                <?php endforeach; ?>  
              </select>  
		    </div>
		    </div>

		    <div class="row" style="margin-top: 20px;">
		    <div class="col">
		    	<label style="padding-bottom: 10px;">Commune</label> 
		      <select class="form-select" name="communePatientsId" style="color: black; ">
                <?php foreach ($getCommunes as $commune) : ?>
                  <option value="<?php echo $commune->id_commune; ?>" <?php if($gets->communePatientsId == $commune->id_commune) echo "selected=true"; ?>><?php echo $commune->nom_commune; ?></option>
                <?php endforeach; ?>  
              </select> 
		    </div>
		    <div class="col">
		    	<label style="padding-bottom: 10px;">Adresse</label> 
		      <input type="text" class="form-control" placeholder="Adresse" name="adresse_patients" value="<?php echo $gets->adresse_patients; ?>" style="color: black;">
		    </div>
		  </div>
		  
		  <div class="row text-center" style="margin-top: 20px;">
		  	<div class="col">
		 	 <button type="submit" class="btn btn-primary" id="comfirms1">MODIFIER</button>
		 	</div>
		  </div>
		</form>
		<?php endforeach;?>

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
$(document).on("click", "#catVaccinsID", function () 
{
	$('#idProduitsEntreprise').empty();
	$('#getSousVaccinsDivs').show();
	$('#comfirms2').show();

	var catVaccinsID = $("#catVaccinsID").val(); 
    
    $.post("<?php echo site_url("MonCompte/jqueryListeSousVaccinsByCatVaccins") ?>", {catVaccinsID : catVaccinsID})
        .done(function (data) {
        
        if(data !== "")
        {    
            data = JSON.parse(data);
            //$("#idProduitsEntreprise").append('<option>-----</option>');
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

$(document).on("change", "#catVaccinsID", function () 
{
	$('#idProduitsEntreprise').empty();
	var catVaccinsID = $("#catVaccinsID").val(); 
    
    $.post("<?php echo site_url("MonCompte/jqueryListeSousVaccinsByCatVaccins") ?>", {catVaccinsID : catVaccinsID})
        .done(function (data) {
        
        if(data !== "")
        {    
            data = JSON.parse(data);
            //$("#idProduitsEntreprise").append('<option>-----</option>');
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


$('#idModifierMajDossiers').click(function ()
{   
    $('#getDossiersDiv').show();
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