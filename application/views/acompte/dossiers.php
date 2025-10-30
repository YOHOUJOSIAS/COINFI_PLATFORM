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
	<div class="section-title mb-4">
        <div class="btn-group">
            <a href="<?php echo site_url('MonCompte/ajouter');?>" role="button" class="btn btn-primary">
            <i class="fa fa-plus"></i> Ajouter un dossier</a>
        </div>
    </div>
     

	<div class="news_posts">
		
		<!-- News Post -->
		<div class="news_post" style="margin-bottom: 30px;">

			<div class="contact-right">
		    <h5 style="text-align:center;">Liste Des Dossiers</h5>
		    <table id="table" class="table table-bordered table-striped">
		    <thead>
		    <tr>
		        <th>Nom</th>
            <th>Prénoms</th>
		        <th>Sexe</th>
		        <th>Date Naissance</th>
		        <th>Groupe Sanguin</th>
		        <th>Actions</th>
		    </tr>
		    </thead>
		    <tbody>
		    <?php foreach ($getListeDossiers as $ListeDossiers) : ?>
		        <tr>
		        <td><?php echo $ListeDossiers->nom_patients; ?></td>
                <td><?php echo $ListeDossiers->prenoms_patients; ?></td>
		        <td><?php echo $ListeDossiers->sexe_patients; ?></td>
		        <td><?php echo date("d-m-Y", strtotime($ListeDossiers->dateNaisPatients)); ?></td>
		        <td><?php echo $ListeDossiers->groupeSangPatients; ?></td>
                
                <?php if ((int)$ListeDossiers->id_patients == (int)$this->session->userdata('id_users')) { ?>
		        <td><a href="<?php echo site_url('MonCompte');?>"  title="Modifier le dossier"><i class="fa fa-pencil"></i></a></td>
                <?php }else{?>
                    <td><a href="<?php echo site_url("MonCompte/voirDossiers")."/".$ListeDossiers->id_patients ; ?>"  title="Modifier le dossier"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="<?php echo site_url("MonCompte/suppression")."/".$ListeDossiers->id_patients ; ?>" onClick="return confirm('Voulez Vous Faire Cette Suppression ?')" title="Annuler le RDV"><i class="fa fa-trash"></i></a></td>
                <?php } ; ?>
                
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