<!DOCTYPE html>
<html lang="fr">
<head>
<?php $this->load->view('tpl/css_files'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo bowers_url('DataTables/datatables.min.css'); ?>">

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
	<div class="section-title mb-4">
        <!-- <h2 class="mb-0 text-center">Semaine du 01 Septembre Au 15 Septembre 2023</h2> -->
    </div>
     <div class="row g-5">
     	<div class="col-lg-4">
        <div class="team-item">
            <div class="position-relative rounded-top" style="z-index: 1;">
                <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                    <i class="fa fa-calendar fw-normal" style="size: 80px; color: green;"></i>
                </div>
            </div>
            <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                <h4 class="mb-2"><?php echo (int)$getRappelsEffectues->nombre; ?></h4>
                <p class="text-primary mb-0">RAPPELS EFFECTUÉS</p>
            </div>
        </div>
        </div>
        <div class="col-lg-4">
            <div class="team-item">
                <div class="position-relative rounded-top" style="z-index: 1;">
                    <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                       <i class="fa fa-clock-o fw-normal" style="size: 80px;color: black;"></i>
                    </div>
                </div>
                <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                    <h4 class="mb-2"><?php echo (int)$getRappelsPendings->nombre; ?></h4>
                    <p class="text-primary mb-0">RAPPELS À VENIR</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
        <div class="team-item">
            <div class="position-relative rounded-top" style="z-index: 1;">
                <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                    <i class="fa fa-times fw-normal" style="size: 80px;color: red;"></i>

                </div>
            </div>
            <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                <h4 class="mb-2"><?php echo (int)$getRappelsAnnules->nombre; ?></h4>
                <p class="text-primary mb-0">RAPPELS ANNULÉS</p>
            </div>
        </div>
        </div>
       
    </div>

	<div class="news_posts">
		
		<!-- News Post -->
		<div class="news_post" style="margin-top: 30px; margin-bottom: 30px;">

			<div class="contact-right">
		    <h5 style="text-align:center;">Liste Des Rendez-vous</h5>
		    <table id="table" class="table table-bordered table-striped">
		    <thead>
		    <tr>
		        <th>Code</th>
                <th>Patients</th>
		        <th>Centres de santé</th>
		        <th>Date du RDV</th>
		        <th>Montant</th>
		        <th>Nombre Vaccins</th>
                <th>Status</th>
		        <th>Actions</th>
		    </tr>
		    </thead>
		    <tbody>
		    <?php foreach ($getMesRappelsVaccins as $MesRappelsVaccins) : ?>
		        <tr>
		        <td><?php echo $MesRappelsVaccins->code_res; ?></td>
                <td><?php echo $MesRappelsVaccins->nom_patients; ?>&nbsp;&nbsp;<?php echo $MesRappelsVaccins->prenoms_patients; ?></td>
		        <td><?php echo $MesRappelsVaccins->nom_entreprise; ?></td>
		        <td><?php echo date("d-m-Y H:i:s", strtotime($MesRappelsVaccins->date_res_deb)); ?></td>
		        <td><?php echo $MesRappelsVaccins->montant_res; ?></td>
		        <td><?php echo $MesRappelsVaccins->qteProduits; ?></td>
                
                <?php if ($MesRappelsVaccins->status_res == 'A') { ?>
                <td style="color:red;">Annulé</td>
                <?php }else if ($MesRappelsVaccins->status_res == 'P') {?>
                <td style="color:black;">En Cours</td>
                <?php }else{?>
                <td style="color:green;">Effectué</td>
                <?php } ; ?>

               <td><a href="<?php echo site_url("Reservations/voirListesRappels")."/".$MesRappelsVaccins->code_res ; ?>"  title="Voir Les Vaccins"><i class="fa fa-eye"></i></a></td>
		      </tr>
		    <?php endforeach; ?> 
		    </tbody>
		</table>

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
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="fa fa-arrow-up"></i></a>

<?php $this->load->view('tpl/js_files'); ?>
<!-- DataTables -->
<script src="<?php echo bowers_url('DataTables/datatables.min.js'); ?>"></script>

<script type="text/javascript">
$(function () {
    $('#table').DataTable({
    	"ordering": false,
    	"buttons": [
          { extend: 'pdf', className: 'btn-default', text: 'EXPORTER EN PDF' },
          ],
    	"dom":  "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    	"language" : {
          "sEmptyTable":     "Aucune donnée disponible dans le tableau",
          "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
          "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
          "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
          "sInfoPostFix":    "",
          "sInfoThousands":  ",",
          "sLengthMenu":     "Afficher _MENU_ éléments",
          "sLoadingRecords": "Chargement...",
          "sProcessing":     "Traitement...",
          "sSearch":         "Rechercher :",
          "sZeroRecords":    "Aucun élément correspondant trouvé",
          "oPaginate": {
            "sFirst":    "Premier",
            "sLast":     "Dernier",
            "sNext":     "Suivant",
            "sPrevious": "Précédent"
          },
          "oAria": {
            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
          },
          "select": {
                  "rows": {
                    "_": "%d lignes sélectionnées",
                    "0": "Aucune ligne sélectionnée",
                    "1": "1 ligne sélectionnée"
                  }  
          }
        },
    }
    )
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