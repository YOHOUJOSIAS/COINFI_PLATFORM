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
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
<?php 
$data['page'] = 'prendrerdv';
$this->load->view('tpl/menu'); 
?>
</nav>
<!-- Navbar End -->


<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
        <h1 class="fw-bold" style="color:#111; margin-bottom:0;">Tableau de Bord</h1>
        <?php if (!empty($this->session->userdata('numero_telephone'))) : ?>
    <div class="text-center mt-4">
       <a href="#" class="btn btn-blue btn-lg" style="font-weight:700; border-radius:12px;" data-toggle="modal" data-target="#ajouterFactureModal">
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
            <div style="font-size:1.6rem; font-weight:800; margin:8px 0;">
                <?php
    if (!empty($getFactureTokeniserPmeActif) && isset($getFactureTokeniserPmeActif->texte_score)) {
        echo htmlspecialchars($getFactureTokeniserPmeActif->texte_score);
    } else {
        echo 'Aucun montant disponible';
    }
    ?>

            F CFA</div>
            <div style="color:#2ee59d; font-size:0.95rem;">+12% ce mois</div>
        </div>
    </div>

    <!-- Bloc 2 : Liquidité Obtenue -->
    <div class="col-md-3">
        <div style="background:#101623; border-radius:16px; color:#fff; padding:24px 18px; min-height:140px; box-shadow:0 2px 16px rgba(0,0,0,0.1);">
            <div style="font-weight:600;">Liquidité Obtenue</div>
            <div style="font-size:1.6rem; font-weight:800; margin:8px 0;">
            <?php
    if (!empty($getLiquiditeObtenueActif) && isset($getLiquiditeObtenueActif->texte_score)) {
        echo htmlspecialchars($getLiquiditeObtenueActif->texte_score);
    } else {
        echo 'Aucun montant disponible';
    }
    ?>

            F CFA</div>
            <div style="color:#7ecbff; font-size:0.95rem;">Instantanée</div>
        </div>
    </div>

    <!-- Bloc 3 : Score Entreprise -->
    <div class="col-md-3">
        <div style="background:#101623; border-radius:16px; color:#fff; padding:24px 18px; min-height:140px; box-shadow:0 2px 16px rgba(0,0,0,0.1);">
            <div style="font-weight:600;">Score Entreprise</div>
            <div style="font-size:1.6rem; font-weight:800; margin:8px 0;">
                
                 <p style="font-size: 17px;">
               <?php
    if (!empty($getScorePmeActif) && isset($getScorePmeActif->texte_score)) {
        echo htmlspecialchars($getScorePmeActif->texte_score);
    } else {
        echo 'Aucun score disponible';
    }
    ?>
        </p>
            </div>
            <div style="color:#FFD600; font-size:0.95rem;">Bon</div>
        </div>
    </div>

    <!-- Bloc 4 : Factures Actives -->
    <div class="col-md-3">
        <div style="background:#101623; border-radius:16px; color:#fff; padding:24px 18px; min-height:140px; box-shadow:0 2px 16px rgba(0,0,0,0.1);">
            <div style="font-weight:600;">Factures Actives</div>
            <div style="font-size:1.6rem; font-weight:800; margin:8px 0;">
                 <?php
    if (!empty($getFacture) && isset($getFacture->nombre)) {
        echo htmlspecialchars($getFacture->nombre);
    } else {
        echo 'Aucun score disponible';
    }
    ?>
            </div>
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


<a href="<?= site_url('factures/liste') ?>" class="btn btn-primary btn-lg d-block mx-auto py-2" style="width: 80%; max-width: 400px;">
    <i class="fas fa-file-invoice me-2"></i> Liste complète des factures
</a>
<!-- Modal de détail -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <!-- Contenu du modal... -->
</div>


<div class="container-fluid py-5">
<div class="container">
<div class="row g-5">

</div>
</div>
</div>
</div>
<!-- Bouton Voir -->

<div class="modal fade" id="ajouterFactureModal" tabindex="-1" role="dialog" aria-labelledby="ajouterFactureLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?php echo site_url('Factures/ajouter'); ?>" method="POST">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="ajouterFactureLabel">Ajouter une facture</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

         <div class="form-group">
  <label for="date">Date de la facture</label>
  <input type="date" class="form-control" name="date" 
         value="<?php echo date('Y-m-d'); ?>" 
         readonly>
</div>


          <div class="form-group">
            <label for="projet">Nom de l'entreprise</label>
            <input type="text" class="form-control" name="nom_entreprise" required>
          </div>

          <div class="form-group">
            <label for="projet">Nom du client</label>
            <input type="text" class="form-control" name="nom_client" required>
          </div>

         <div class="form-group">
  <label for="projet">Secteur d'activité</label>
  <select class="form-control" name="secteur" required>
    <option value="">-- Sélectionnez un secteur --</option>
    <option>Agroalimentaire</option>
    <option>Artisanat</option>
    <option>Commerce de détail</option>
    <option>Construction / BTP</option>
    <option>Éducation / Formation</option>
    <option>Énergie / Environnement</option>
    <option>Finance / Assurance</option>
    <option>Hôtellerie / Restauration</option>
    <option>Immobilier</option>
    <option>Industrie manufacturière</option>
    <option>Informatique / Télécom</option>
    <option>Logistique / Transport</option>
    <option>Mode / Textile</option>
    <option>Production audiovisuelle / Médias</option>
    <option>Santé / Bien-être</option>
    <option>Services aux entreprises</option>
    <option>Services personnels</option>
    <option>Tourisme / Loisirs</option>
  </select>
</div>


          <div class="form-group">
            <label for="projet">Pays</label>
            <input type="text" class="form-control" name="Pays" required>
          </div>

          <div class="form-group">
            <label for="projet">Adresse Ethereum de l'entreprise</label>
            <input type="text" class="form-control" name="adresse_entreprise" required>
          </div>

          <div class="form-group">
            <label for="projet">Adresse Ethereum du client</label>
            <input type="text" class="form-control" name="adresse_client" required>
          </div>

          <div class="form-group">
    <label for="type_facture">Type de facture</label>
    <select class="form-control" name="type_facture" id="type_facture" required>
        <?php 
        // Liste fixe des types de factures PME
        $types_factures = [
            "Facture standard",
            "Facture pro forma",
            "Facture d'acompte",
            "Facture intermédiaire",
            "Facture de solde",
            "Facture rectificative",
            "Facture d'avoir",
            "Facture simplifiée"
        ];

        foreach ($types_factures as $index => $libelle) : 
            $selected = ($this->session->userdata('type_facture') == ($index+1)) ? 'selected' : '';
        ?>
            <option value="<?php echo $index+1; ?>" <?php echo $selected; ?>>
                <?php echo $libelle; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


          <div class="form-group">
            <label for="projet">Description</label>
            <input type="text" class="form-control" name="desc_facture" required>
          </div>

        
          <div class="form-group">
            <label for="montant">Montant (USDT/CFN)</label>
            <input type="number" class="form-control" name="montant" step="0.01" required>
          </div>

          <div class="form-group">
            <label for="taux">Durée de financement (Jour)</label>
            <input type="number" class="form-control" name="duree" required>
          </div>

          <div class="form-group">
  <label for="taux">Date d’échéance</label>
  <input type="date" class="form-control" name="date_financement" id="date_financement" required>
</div>

<script>
  // Récupère la date d'aujourd'hui au format YYYY-MM-DD
  let today = new Date().toISOString().split('T')[0];
  // Définit la date minimale sur l'input
  document.getElementById("date_financement").setAttribute('min', today);
</script>


        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        </div>

      </div>
    </form>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="infoModalLabel">Détails de la facture</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <ul style="list-style: none; padding-left: 0;">
          <li><strong>Date :</strong> 12/04/2024</li>
          <li><strong>Projet :</strong> Pool Agro Juillet 2025</li>
          <li><strong>Montant :</strong> €10 000</li>
          <li><strong>Statut :</strong> En cours</li>
          <li><strong>Rendement :</strong> 8.5%</li>
        </ul>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
      
    </div>
  </div>
</div>


<?php $this->load->view('tpl/js_files'); ?>
<?php $this->load->view('tpl/css_files'); ?>

<script>
    $(document).ready(function() {
    $('.table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
        },
        "order": [[0, "desc"]] // Tri par date décroissante par défaut
    });
});
</script>


</body>



</html>