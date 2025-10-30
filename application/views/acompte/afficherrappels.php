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
          $data['page'] = 'listedesrappels';
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
				          $data['page'] = 'listedesrappels';
				          $this->load->view('tpl/sidebar'); 
				        ?>		

					</div>
				</div>
				
				<!-- News Posts -->
				<div class="col-lg-9 wow">
					

					<div class="news_posts">

						<!-- Mon dossier -->
						<div class="news_post" style="margin-bottom: 30px;">

							<div class="contact-right">
						    <h5 style="text-align:center;">RAPPEL N°&nbsp;<?php echo $getCodeRes->code_res; ?>&nbsp;de&nbsp;<?php echo $getCodeRes->nom_patients; ?>&nbsp;<?php echo $getCodeRes->prenoms_patients; ?></h5>
						    <table class="table table-bordered table-striped" style="color:black; text-align: center;">
						    <thead>
						    <tr>
						        <th>Centre</th>
						        <th>Catégorie De Patient</th>
						        <th>Sous Catégorie de Patient</th>
						        <th>Date du Rappel</th>
						    </tr>
						    </thead>
						    <tbody>
						    <?php if ($getCodeRes) { ?>
						        <tr style="color:black; text-align: center;">
						        <td><?php echo $getCodeRes->nom_entreprise; ?></td>
						        <td><?php echo $getCodeRes->nom_cat_vaccins; ?></td>
						        <td><?php echo $getCodeRes->nom_sous_vaccins; ?></td>
						        <td><?php echo date("d-m-Y H:i:s", strtotime($getCodeRes->date_res_deb)); ?></td>
						      </tr>
						      <?php } ; ?>
						    
						    </tbody>
						</table>
						</div>
						</div>


					<!-- Mise à jour du dossier -->
					<div class="news_post" style="margin-top: 30px; margin-bottom: 30px; ">

					<div align="center">
					<legend style="text-align:center;color: red;"><b>Liste des vaccins du rappel</b></legend>

                     <div class="row g-5">

                     	<?php foreach ($getListeVaccins as $ListeVaccins) : ?> 
                     	<div class="col-lg-4">
	                    <div class="team-item">
	                        <div class="position-relative rounded-top" style="z-index: 1;">
	                            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
	                                <input type="checkbox" checked disabled style="width: 30px; height: 30px;" value="">
	                            </div>
	                        </div>
	                        <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
	                            <h6 class="mb-2"><?php echo $ListeVaccins->nomVaccins; ?></h6>
	                            <p style="display: none;"><?php echo $ListeVaccins->maladieTraitee; ?></p>
	                            <p class="text-primary mb-0"><?php echo $ListeVaccins->maladieTraitee; ?></p>
	                        </div>
	                    </div>
		                </div>
		               <?php endforeach;?>
		               
            		</div>

                    </div>
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