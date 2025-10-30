<!DOCTYPE html>
<html lang="fr">
<head>
<?php $this->load->view('tpl/css_files'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>


<!-- Topbar Start -->
<div class="container-fluid bg-light ps-5 pe-0 d-none d-lg-block">
<?php $this->load->view('tpl/header'); ?>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->

<!-- Navbar End -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .btn-blue {
        background-color: #07406A;
        color: white;
    }
    .btn-blue:hover {
        background-color: #0a5a8a;
        color: white;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.75em;
    }
    .bg-success { background-color: #28a745 !important; }
    .bg-warning { background-color: #ffc107 !important; }
    .bg-secondary { background-color: #6c757d !important; }
</style>

<div class="container my-5">
    <div class="card p-4" style="border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
        
        
        <?php if (empty($factures)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>Aucune facture enregistrée pour le moment.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="facturesTable">
                    <thead>
                        <tr style="color:#07406A;">
                            <th>Date création</th>
                            <th>Numéro de facture</th>
                            <th>Montant du financement</th>
                            
                             <th>Nom du client</th>
                            <th>Secteur d'activité</th>
                            <th>Durée (Jour)</th>
                           
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($factures as $facture): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($facture['date'])) ?></td>
                                <td>FAC-<?= date('Y', strtotime($facture['date'])) ?>-<?= str_pad($facture['id'], 3, '0', STR_PAD_LEFT) ?></td>
                                <td><?= number_format($facture['montant'], 0, ',', ' ') ?> USDT/CFN </td>
                                
                               
                                  <td><?= htmlspecialchars($facture['nom_client']) ?></td>
                                  <td><?= htmlspecialchars($facture['secteur']) ?></td>
                                   
                                    <td><?= htmlspecialchars($facture['duree']) ?> Jours</td>
                                </td> 
                                <td>
                                
                                    <a href="<?= site_url('factures/supprimer/'.$facture['id']) ?>" class="btn btn-outline-danger btn-sm" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de détail -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="infoModalLabel">Détails de la facture</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Le contenu sera chargé ici via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('tpl/js_files'); ?>
<?php $this->load->view('tpl/css_files'); ?>
<!-- CDN JS à placer avant la fermeture du body -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Initialisation de DataTable avec options avancées
    $('#facturesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        order: [[0, 'desc']],
        responsive: true,
        dom: '<"top"lf>rt<"bottom"ip><"clear">',
        columnDefs: [
            { responsivePriority: 1, targets: 0 }, // Date
            { responsivePriority: 2, targets: 3 }, // Statut
            { responsivePriority: 3, targets: 2 }, // Montant
            { responsivePriority: 4, targets: 1 }, // Numéro
            { responsivePriority: 5, targets: -1 } // Actions
        ]
    });

    // Gestion des clics sur les liens "Voir" pour charger le modal
    $(document).on('click', 'a[href*="factures/detail"]', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        
        $.get(url, function(data) {
            $('#modalContent').html(data);
            $('#infoModal').modal('show');
        }).fail(function() {
            $('#modalContent').html('<div class="alert alert-danger">Erreur lors du chargement des détails</div>');
            $('#infoModal').modal('show');
        });
    });
});

// Fonction pour confirmer la suppression
function confirmDelete(url) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette facture ?')) {
        window.location.href = url;
    }
}
</script>