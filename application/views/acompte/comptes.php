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
          $data['page'] = 'comptes';
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
				          $data['page'] = 'comptes';
				          $this->load->view('tpl/sidebar'); 
				        ?>		

					</div>
				</div>
				
				<!-- News Posts -->
				<div class="col-lg-9 wow">
					
                     <div class="row g-5">
                     	<div class="col-lg-4">
	                    <div class="team-item">
	                        <div class="position-relative rounded-top" style="z-index: 1;">
	                            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
	                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-calendar fw-normal" style="size: 60px;"></i></a>
	                            </div>
	                        </div>
	                        <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
	                            <!-- <h4 class="mb-2"><?php echo (int)$getRDVsPendings->nombre; ?></h4> -->
	                            <p class="text-primary mb-0">RDVs À VENIR</p>
	                        </div>
	                    </div>
		                </div>
		                <div class="col-lg-4">
		                    <div class="team-item">
		                        <div class="position-relative rounded-top" style="z-index: 1;">
		                            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
		                               <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-clock-o fw-normal" style="size: 60px;"></i></a>
		                            </div>
		                        </div>
		                        <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
		                          <!--   <h4 class="mb-2"><?php echo (int)$getRappelsPendings->nombre; ?></h4>-->
		                            <p class="text-primary mb-0">RAPPELS À VENIR</p>
		                        </div>
		                    </div>
		                </div>
		                <div class="col-lg-4">
	                    <div class="team-item">
	                        <div class="position-relative rounded-top" style="z-index: 1;">
	                            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
	                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-folder fw-normal" style="size: 60px;"></i></a>

	                            </div>
	                        </div>
	                        <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
	                            <!--  <h4 class="mb-2"><?php echo (int)$getTotalDossiers->nombre; ?></h4>-->
	                            <p class="text-primary mb-0">MES DOSSIERS</p>
	                        </div>
	                    </div>
		                </div>
		               
	                </div>

	                 <!-- <?php if (empty($getDossiers->dateMajDossiers)) { ?>
					<div class="section-title mb-4"  style="margin-top: 20px;">
				        <h2 class="mb-0 text-center" style="color:red; font: bold;">Veuillez mettre à jour votre dossier médical SVP !</h2>
                    </div>
                    <?php } ; ?> -->

					<div class="news_posts">

						<!-- Mon dossier -->
						<!-- <div class="news_post" style="margin-top: 30px; margin-bottom: 30px;">

							<div class="contact-right">
						    <h5 style="text-align:center;">Mon Dossier Médical</h5>
						    <table class="table table-bordered table-striped" style="color:black; text-align: center;">
						    <thead>
						    <tr>
						        <th>Date de Création</th>
						        <th>Catégorie</th>
						        <th>Sous Catégorie</th>
						        <th>Dernière Mise à Jour</th>
						        <th>Actions</th>
						    </tr>
						    </thead>
						    <tbody>
						    <?php if ($getDossiers) { ?>
						        <tr style="color:black; text-align: center;">
						        <td><?php echo date("d-m-Y H:i:s", strtotime($getDossiers->dateCreateDossiers)); ?></td>
						        <td><?php echo $getDossiers->nom_cat_vaccins; ?></td>
						        <td><?php echo $getDossiers->nom_sous_vaccins; ?></td>
						        <?php if (empty($getDossiers->dateMajDossiers)) { ?>
						        <td style="color:red;font: bold;">Non Validé</td>
						        <?php }else{?>
						        <td><?php echo date("d-m-Y H:i:s", strtotime($getDossiers->dateMajDossiers)); ?></td>
						        <?php } ; ?>
						        <td><a type="button" id="idModifierMajDossiers"><i class="fa fa-pencil" title="Modifier le dossier"></i></a></td>
						      </tr>
						      <?php } ; ?>
						    
						    </tbody>
						</table>
						</div>
						</div> -->


						<!-- Mise à jour du dossier -->
						<!-- <div id="getDossiersDiv"  class="news_post" style="margin-top: 30px; margin-bottom: 30px; display: none;">

							<div align="center">
							<legend style="text-align:center;color: red;"><b>MODIFIER MON DOSSIER</b></legend>
						    <form class="comfirms2 col-md-6" action="<?php echo site_url('MonCompte/majDossiersPersos');?>" method="post">
                            <div class="row g-3">

                            <div class="col-12">
                            <span>Choisissez une Catégorie</span>
                            <select class="form-select bg-light border-0 px-4" name="catVaccinsID" style="height: 55px;" id="catVaccinsID">
                                <?php foreach ($getCatVaccins as $catVaccins) : ?>
				                  <option value="<?php echo $catVaccins->id_cat_vaccins; ?>" <?php if($getDossiers->catVaccinsID == $catVaccins->id_cat_vaccins) echo "selected=true"; ?>><?php echo $catVaccins->nom_cat_vaccins; ?></option>
				                <?php endforeach; ?> 
                            </select>
                            </div>


                            <div class="col-12" style="margin-top:15px;display: none;" id="getSousVaccinsDivs">
                            	<span>Choisissez une Sous Catégorie</span>
                                <select name="sousVaccinsID" class="form-select bg-light border-0 px-4" style="height: 55px; " id="idProduitsEntreprise" required>
                                    
                                </select>
                            </div>
                            
                         
                            <div class="col-12 text-center">
                            	<a class="btn btn-outline-primary" href="" class="form-control" >Annuler</a>
                                <input id="comfirms2" class="btn btn-primary" type="button" class="form-control" value="Modifier" style="display: none;" />
  								
                            </div>


                        </div>
                    </form>
                    </div>
						
						</div> -->

						 <!-- <?php if (!empty($getDossiers->dateMajDossiers) && empty($getDossiers->date_maj_patients)) { ?>
						<div class="section-title mb-4"  style="margin-top: 20px;">
					        <h2 class="mb-0 text-center" style="color:red; font: bold;">Veuillez mettre à jour votre profil SVP !</h2>
	                    </div>
	                    <?php } ; ?> -->
						
						<!-- Mon Compte -->
						<div class="news_post" style="margin-top: 30px; margin-bottom: 30px;">
							
							<legend align="center">Mise à jour du compte</legend>           
    						<?php foreach ($getComptes as $gets) : ?> 
							<form class="comfirms1" action="<?php echo site_url('MonCompte/majCompteUsers');?>" method="post">
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
							      <label style="padding-bottom: 10px;">Mobile</label>
							      <input type="text" class="form-control" placeholder="Mobile *" name="contact_patients" required="" value="<?php echo $gets->contact_patients; ?>" style="color: black;" maxlength="14" minlength="14" readonly>
							    </div>
							    <div class="col">
							     <label style="padding-bottom: 10px;">Email</label>
							      <input type="email" class="form-control" placeholder="Email" name="email_patients" value="<?php echo $gets->email_patients; ?>" style="color: black;">
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
							      <label style="padding-bottom: 10px;">Date de Naissance</label>
							      <input class="form-control" type="date" placeholder="Date" name="dateNaisPatients" value="<?php echo $gets->dateNaisPatients; ?>" required="" max="<?php echo date("Y-m-d"); ?>" style="color: black; ">
							    </div>
							  </div>
							  <div class="row" style="margin-top: 20px;">
							    <div class="col">
							      <label style="padding-bottom: 10px;">Métiers / Fonction</label>
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