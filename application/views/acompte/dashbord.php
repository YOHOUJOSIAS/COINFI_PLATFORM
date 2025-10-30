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
$data['page'] = 'dashbord';
$this->load->view('tpl/menu'); 
?>
</nav>
<!-- Navbar End -->


<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
        <h1 class="fw-bold" style="color:#111; margin-bottom:0;">Tableau de Bord</h1>
        <?php if (!empty($this->session->userdata('numero_telephone'))) : ?>
    <div class="text-center mt-4">
        <a href="<?php echo site_url('Facture/ajouter'); ?>" class="btn btn-blue btn-lg" style="font-weight:700; border-radius:12px;">
            <i class="fa fa-plus me-2"></i>Ajouter une facture
        </a>
    </div>
<?php endif; ?>
    </div>
   
    <p style="color:#06A3DA;">Gérez vos investissements et tokenisations en temps réel</p>
    <div class="row g-4 mb-5">
    <!-- Bloc 1 : Factures Tokenisées -->
    <div class="col-md-3">
        <div style="background:#101623; border-radius:16px; color:#fff; padding:24px 18px; min-height:140px; box-shadow:0 2px 16px rgba(0,0,0,0.1);">
            <div style="font-weight:600;">Factures Tokenisées</div>
            <div style="font-size:1.6rem; font-weight:800; margin:8px 0;">€125K</div>
            <div style="color:#2ee59d; font-size:0.95rem;">+12% ce mois</div>
        </div>
    </div>

    <!-- Bloc 2 : Liquidité Obtenue -->
    <div class="col-md-3">
        <div style="background:#101623; border-radius:16px; color:#fff; padding:24px 18px; min-height:140px; box-shadow:0 2px 16px rgba(0,0,0,0.1);">
            <div style="font-weight:600;">Liquidité Obtenue</div>
            <div style="font-size:1.6rem; font-weight:800; margin:8px 0;">€100000</div>
            <div style="color:#7ecbff; font-size:0.95rem;">Instantanée</div>
        </div>
    </div>

    <!-- Bloc 3 : Score Entreprise -->
    <div class="col-md-3">
        <div style="background:#101623; border-radius:16px; color:#fff; padding:24px 18px; min-height:140px; box-shadow:0 2px 16px rgba(0,0,0,0.1);">
            <div style="font-weight:600;">Score Entreprise</div>
            <div style="font-size:1.6rem; font-weight:800; margin:8px 0;">7.1/10</div>
            <div style="color:#FFD600; font-size:0.95rem;">Bon</div>
        </div>
    </div>

    <!-- Bloc 4 : Factures Actives -->
    <div class="col-md-3">
        <div style="background:#101623; border-radius:16px; color:#fff; padding:24px 18px; min-height:140px; box-shadow:0 2px 16px rgba(0,0,0,0.1);">
            <div style="font-weight:600;">Factures Actives</div>
            <div style="font-size:1.6rem; font-weight:800; margin:8px 0;">15</div>
            <div style="color:#b57eff; font-size:0.95rem;">En cours</div>
        </div>
    </div>
</div>


    <!-- Historique d'investissement -->
    <div class="card p-4" style="border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
        <h3 class="mb-4" style="color:#07406A;">Historique d'investissement</h3>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr style="color:#07406A;">
                        <th>Date</th>
                        <th>Projet</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Rendement</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12/04/2024</td>
                        <td>Pool Agro Juillet 2025</td>
                        <td>€10 000</td>
                        <td><span class="badge bg-success">En cours</span></td>
                        <td>8.5%</td>
                    </tr>
                    <tr>
                        <td>28/03/2024</td>
                        <td>Pool Tech Solutions Q2</td>
                        <td>€5 000</td>
                        <td><span class="badge bg-warning text-dark">En attente</span></td>
                        <td>9.2%</td>
                    </tr>
                    <tr>
                        <td>10/02/2024</td>
                        <td>Pool Retail Express</td>
                        <td>€2 500</td>
                        <td><span class="badge bg-secondary">Terminé</span></td>
                        <td>7.8%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Liste des factures ajoutées -->
<div class="container my-5">
    <div class="card p-4" style="border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,0.08);">
        <h3 class="mb-4" style="color:#07406A;">Mes factures ajoutées</h3>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr style="color:#07406A;">
                        <th>Date</th>
                        <th>Numéro</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>15/04/2024</td>
                        <td>FAC-2024-001</td>
                        <td>1 200 000 FCFA</td>
                        <td><span class="badge bg-success">Validée</span></td>
                        <td><a href="#" class="btn btn-blue btn-sm">Voir</a></td>
                    </tr>
                    <tr>
                        <td>10/04/2024</td>
                        <td>FAC-2024-002</td>
                        <td>850 000 FCFA</td>
                        <td><span class="badge bg-warning text-dark">En attente</span></td>
                        <td><a href="#" class="btn btn-blue btn-sm">Voir</a></td>
                    </tr>
                    <tr>
                        <td>02/04/2024</td>
                        <td>FAC-2024-003</td>
                        <td>2 500 000 FCFA</td>
                        <td><span class="badge bg-secondary">Rejetée</span></td>
                        <td><a href="#" class="btn btn-blue btn-sm">Voir</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="container-fluid py-5">
<div class="container">
<div class="row g-5">


<!-- News Posts -->


<!-- Formulaire -->




</div>
</div>
</div>
</div>

</body>
</html>