<!DOCTYPE html>
<html>


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS files -->
  <?php $this->load->view('tpl/css_files') ?>
  <style>
    .sidebar .active {
      background-color: rgba(255, 255, 255, .9) !important;
      color: #343a40 !important;
    }
  </style>

</head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <?php $this->load->view('tpl/header') ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php 
  $data['page'] = "facture";
  $this->load->view('tpl/sidebar', $data); 
  ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">FACTURES</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo site_url('Dashboard'); ?>">Accueil</a></li>
                <li class="breadcrumb-item active">Factures</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="card">
           

            <!-- row -->
            <div class="row px-4 pt-4">
              <div class="col-lg-12">
                
                <div class="card card-primary card-outline">
                  <div class="card-body">
                    <table id="table" class="display table table-bordered table-striped">
                      <thead>
                        <tr>
                           <th>Nom du Projet Pme</th>
                           <th>Description</th>
                          <th>Nom de l'entreprise</th>
                          <th>Nom du client</th>
                           <th>Nom de la PME</th>
                           <th>Pays</th>
                          <th>Montant investissement</th>
                          <th>Date de financement</th>
                          <th>Durée de financement</th>
                           <th>Adr entreprise</th>
                            <th>Adr Client</th>
                             <th>Date création</th>
                         
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div><!-- /.card -->
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer Start -->
    <?php $this->load->view('tpl/footer') ?>

    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>

  <!-- JS files -->
  <?php $this->load->view('tpl/js_files') ?>
  <!-- script table -->
  <script type="text/javascript">
    var table;
    $(document).ready(function() {
      //datatables
      $(document).ready(function() {
    //datatables
    table = $('#table').DataTable({ 
      "info": true,
      "lengthChange": true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "pageLength": 50,
        "dom":  "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          "buttons": [
          { extend: 'excel', className: 'btn-default', text: 'EXPORT EXCEL'},
          { extend: 'pdf', className: 'btn-default', text: 'EXPORT PDF' },
          ],
        "columnDefs": [ { orderable: false, targets: [0] } ],
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
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Demandes/ajax_list')?>",
            "type": "POST",
        },
    });

});

    });
  </script>
</body>

</html>