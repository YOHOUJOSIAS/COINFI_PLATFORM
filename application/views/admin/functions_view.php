<!-- /application/views/admin/functions_view.php -->

<!-- L'attribut data-page-module indique à app.js quel script charger pour cette page -->
<div class="container my-5" data-page-module="admin">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-orange">Panneau Administrateur Complet</h1>
        <a href="<?php echo site_url('Dashboard'); ?>" class="btn btn-secondary">Retour au Dashboard</a>
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="adminTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-orange" id="creation-tab" data-bs-toggle="tab" data-bs-target="#creation" type="button" role="tab">Création</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="gestion-tab" data-bs-toggle="tab" data-bs-target="#gestion" type="button" role="tab">Gestion & Rôles</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="config-tab" data-bs-toggle="tab" data-bs-target="#config" type="button" role="tab">Configuration</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices" type="button" role="tab">Factures</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="pools-tab" data-bs-toggle="tab" data-bs-target="#pools" type="button" role="tab">Pools</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="demandes-tab" data-bs-toggle="tab" data-bs-target="#demandes" type="button" role="tab">Demandes de tokenisation</button>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="adminTabContent">
        <!-- ================================================== -->
        <!-- Onglet Création -->
        <!-- ================================================== -->
        <div class="tab-pane fade show active" id="creation" role="tabpanel">
            <div class="row mt-4">
                <div class="col-lg-6">
                    <!-- Créer une Facture -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">🧾 Créer une Facture</h5>
                            <form id="create-invoice-form">
                                <h6 class="text-white mt-3">Données On-Chain</h6>
                                <input type="text" name="companyAddress" class="form-control mb-2" placeholder="Adresse Ethereum de l'Entreprise" required>
                                <input type="text" name="clientAddress" class="form-control mb-2" placeholder="Adresse Ethereum du Client" required>
                                <input type="number" step="0.01" name="amount" class="form-control mb-2" placeholder="Montant (USDT)" required>
                                <input type="number" step="0.01" name="interestRate" class="form-control mb-2" placeholder="Taux d'intérêt (%)" required>
                                <input type="number" name="fundingDuration" class="form-control mb-2" placeholder="Durée financement (jours)" required>
                                <label class="form-label">Date d'échéance</label>
                                <input type="date" name="dueDate" class="form-control mb-2" required>

                                <h6 class="text-white mt-4">Métadonnées (IPFS)</h6>
                                <input type="text" name="companyName" class="form-control mb-2" placeholder="Nom de l'entreprise" required>
                                <input type="text" name="clientName" class="form-control mb-2" placeholder="Nom du client" required>
                                <input type="text" name="sector" class="form-control mb-2" placeholder="Secteur d'activité" required>
                                <input type="text" name="location" class="form-control mb-2" placeholder="Localisation (Pays/Ville)" required>
                                <select name="invoiceType" class="form-select mb-2" required>
                                    <option value="">Type de facture</option>
                                    <option value="Services">Services</option>
                                    <option value="Produits">Produits</option>
                                    <option value="Mixte">Mixte</option>
                                </select>
                                <textarea name="description" class="form-control mb-2" placeholder="Description détaillée" required></textarea>
                                <div class="mb-3">
                                   <label for="invoice-document" class="form-label">Document de la facture (PDF, JPG...)</label>
                                   <input class="form-control" type="file" name="document" id="invoice-document" required>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="requireCollateral" id="requireCollateral" value="true">
                                    <label class="form-check-label" for="requireCollateral">
                                        Requérir un collatéral pour cette facture
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-orange w-100">Créer la Facture</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- Créer un Pool -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">🏊 Créer un Pool</h5>
                             <form id="create-pool-form">
                                <h6 class="text-white mt-3">Données On-Chain</h6>
                                <input type="text" name="name" class="form-control mb-2" placeholder="Nom du Pool" required>
                                <input type="number" step="0.01" name="minInvestment" class="form-control mb-2" placeholder="Investissement Minimum" required>
                                <input type="number" name="maxInvoiceCount" class="form-control mb-2" placeholder="Nb max de factures" required>
                                <input type="number" step="0.01" name="maxPoolAmount" class="form-control mb-2" placeholder="Montant max du pool" required>

                                <h6 class="text-white mt-4">Métadonnées (IPFS)</h6>
                                <select name="theme" class="form-select mb-2" required>
                                    <option value="">Thème du pool</option>
                                    <option value="Technologie">Technologie</option>
                                    <option value="Santé">Santé</option>
                                    <option value="Energie">Energie</option>
                                    <option value="Agriculture">Agriculture</option>
                                </select>
                                <select name="riskLevel" class="form-select mb-2" required>
                                    <option value="">Niveau de risque</option>
                                    <option value="Faible">Faible</option>
                                    <option value="Modéré">Modéré</option>
                                    <option value="Élevé">Élevé</option>
                                </select>
                                <select name="region" class="form-select mb-2" required>
                                    <option value="">Région</option>
                                    <option value="Afrique">Afrique</option>
                                    <option value="Europe">Europe</option>
                                    <option value="Amérique">Amérique</option>
                                    <option value="Asie">Asie</option>
                                    <option value="Global">Global</option>
                                </select>
                                <textarea name="description" class="form-control mb-2" placeholder="Description du Pool" required></textarea>
                                <div class="mb-3">
                                   <label for="pool-banner" class="form-label">Bannière du pool (Image)</label>
                                   <input class="form-control" type="file" name="banner" id="pool-banner" accept="image/*" required>
                                </div>
                                <button type="submit" class="btn btn-orange w-100">Créer le Pool</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================================================== -->
        <!-- Onglet Gestion & Rôles -->
        <!-- ================================================== -->
        <div class="tab-pane fade" id="gestion" role="tabpanel">
            <div class="row mt-4">
                <div class="col-lg-6">
                    <!-- Gestion des Rôles -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">🔐 Gestion des Rôles</h5>
                            <form id="grant-role-btn">
                                <div class="mb-3">
                                    <label class="form-label">Adresse de l'utilisateur</label>
                                    <input type="text" name="userAddress" class="form-control mb-2" placeholder="0x..." required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Rôle actuel</label>
                                    <div id="current-role-display" class="alert alert-info py-2">
                                        <small>Aucune adresse saisie</small>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Action</label>
                                    <select name="roleType" class="form-select mb-2">
                                        <option value="OPERATOR_ROLE">Opérateur</option>
                                        <option value="ADMIN_ROLE">Admin</option>
                                    </select>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <button type="submit" name="action" value="grant" class="btn btn-success flex-grow-1">Accorder</button>
                                    <button type="submit" name="action" value="revoke" class="btn btn-danger flex-grow-1">Révoquer</button>
                                    <button type="button" id="check-role-btn" class="btn btn-info flex-grow-1">Vérifier Rôle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Gestion des Pools -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">🔗 Gestion des Pools</h5>
                            <form id="form-add-invoice-to-pool" class="mb-3">
                                <input type="number" name="invoiceId" class="form-control mb-2" placeholder="ID de la facture" required>
                                <input type="number" name="poolId" class="form-control mb-2" placeholder="ID du pool" required>
                                <button type="submit" class="btn btn-primary">Ajouter Facture au Pool</button>
                            </form>
                            <hr>
                            <form id="form-set-pool-status">
                                <input type="number" name="poolId" class="form-control mb-2" placeholder="ID du pool" required>
                                <button type="submit" name="action" value="activate" class="btn btn-success">Activer</button>
                                <button type="submit" name="action" value="deactivate" class="btn btn-warning">Désactiver</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- Gestion du Contrat -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">⚙️ Gestion du Contrat</h5>
                            <p>Suspendre ou reprendre les fonctions critiques du contrat.</p>
                            <button id="btn-pause-contract" class="btn btn-warning">Mettre en Pause</button>
                            <button id="btn-unpause-contract" class="btn btn-success">Réactiver</button>
                        </div>
                    </div>
                    <!-- Fonctions d'Urgence -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">🚨 Fonctions d'Urgence</h5>
                            <form id="form-compensate-investors" class="mb-3">
                                <input type="number" name="invoiceId" class="form-control mb-2" placeholder="ID Facture en défaut" required>
                                <button type="submit" class="btn btn-danger">Compenser Investisseurs</button>
                            </form>
                            <hr>
                            <form id="form-recover-funds">
                                <p class="small text-muted">Retirer des fonds ERC20 envoyés par erreur au contrat.</p>
                                <input type="text" name="tokenAddress" class="form-control mb-2" placeholder="Adresse du Token à récupérer" required>
                                <input type="number" step="0.01" name="amount" class="form-control mb-2" placeholder="Montant à récupérer" required>
                                <button type="submit" class="btn btn-danger">Récupérer les Fonds</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================================================== -->
        <!-- Onglet Configuration -->
        <!-- ================================================== -->
        <div class="tab-pane fade" id="config" role="tabpanel">
            <div class="row mt-4">
                <div class="col-lg-6">
                    <!-- Section Affichage des Adresses -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">📜 Adresses du Système</h5>
                            <div class="table-responsive">
                                <table class="table table-dark table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Contrat Principal</td>
                                            <td id="contract-address" class="text-end text-monospace">Chargement...</td>
                                        </tr>
                                        <tr>
                                            <td>Stablecoin (USDT)</td>
                                            <td id="stablecoin-address" class="text-end text-monospace">Chargement...</td>
                                        </tr>
                                        <tr>
                                            <td>Trésorerie</td>
                                            <td id="treasury-address" class="text-end text-monospace">Chargement...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Section Taux de Collatéral Actuels -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">🛡️ Taux de Collatéral Actuels</h5>
                            <div class="table-responsive">
                                <table class="table table-dark table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Dépôt Initial</td>
                                            <td id="initial-collateral-rate" class="text-end">Chargement...</td>
                                        </tr>
                                        <tr>
                                            <td>Retenu sur Financement</td>
                                            <td id="withheld-collateral-rate" class="text-end">Chargement...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mise à jour des adresses -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">🔧 Adresses du Contrat</h5>
                            <form id="form-update-stablecoin" class="mb-3">
                                <label class="form-label">Adresse du Stablecoin</label>
                                <input type="text" name="stablecoinAddress" class="form-control mb-2" placeholder="Nouvelle adresse du token stable" required>
                                <button type="submit" class="btn btn-primary w-100">Mettre à jour Stablecoin</button>
                            </form>
                            <hr>
                            <form id="form-update-treasury">
                                <label class="form-label">Adresse de la Trésorerie</label>
                                <input type="text" name="treasuryAddress" class="form-control mb-2" placeholder="Nouvelle adresse de trésorerie" required>
                                <button type="submit" class="btn btn-primary w-100">Mettre à jour Trésorerie</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <!-- Section Taux de Commission Actuels -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">💸 Taux de Commission Actuels</h5>
                            <div class="table-responsive">
                                <table class="table table-dark table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Frais d'Entrée</td>
                                            <td id="entry-fee-rate" class="text-end">Chargement...</td>
                                        </tr>
                                        <tr>
                                            <td>Frais de Performance</td>
                                            <td id="performance-fee-rate" class="text-end">Chargement...</td>
                                        </tr>
                                        <tr>
                                            <td>Frais de Pool</td>
                                            <td id="pool-fee-rate" class="text-end">Chargement...</td>
                                        </tr>
                                        <tr>
                                            <td>Frais d'Émission</td>
                                            <td id="issuance-fee-rate" class="text-end">Chargement...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Mise à jour des taux de collatéral -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">📊 Mise à jour Taux de Collatéral</h5>
                            <form id="form-update-collateral-rates">
                                <label class="form-label">Taux Dépôt Initial (%)</label>
                                <input type="number" step="0.01" name="initialRate" class="form-control mb-2" placeholder="Ex: 10 pour 10%" required>
                                <label class="form-label">Taux Retenu sur Financement (%)</label>
                                <input type="number" step="0.01" name="withheldRate" class="form-control mb-2" placeholder="Ex: 5 pour 5%" required>
                                <button type="submit" class="btn btn-primary w-100">Mettre à jour les Taux</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Mise à jour des commissions -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">📈 Mise à jour Taux de Commission</h5>
                            <form id="form-update-commission-rates">
                                <label class="form-label">Frais d'Entrée (%)</label>
                                <input type="number" step="0.01" name="entryFee" class="form-control mb-2" placeholder="Ex: 1.5" required>
                                <label class="form-label">Frais de Performance (%)</label>
                                <input type="number" step="0.01" name="performanceFee" class="form-control mb-2" placeholder="Ex: 15" required>
                                <label class="form-label">Frais de Pool (%)</label>
                                <input type="number" step="0.01" name="poolFee" class="form-control mb-2" placeholder="Ex: 0.5" required>
                                <label class="form-label">Frais d'Émission (%)</label>
                                <input type="number" step="0.01" name="issuanceFee" class="form-control mb-2" placeholder="Ex: 1" required>
                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" name="action" value="start" class="btn btn-warning flex-grow-1">Initier (Timelock)</button>
                                    <button type="submit" name="action" value="execute" class="btn btn-success flex-grow-1">Exécuter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet Factures -->
        <div class="tab-pane fade" id="invoices" role="tabpanel">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">📋 Liste des Factures</h5>
                            <div class="mb-3">
                                <input type="text" id="invoice-search" class="form-control" placeholder="Rechercher une facture...">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Entreprise</th>
                                            <th>Client</th>
                                            <th>Montant</th>
                                            <th>État</th>
                                            <th>collatéral</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoices-list">
                                        <!-- Les factures seront chargées ici -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet Pools -->
        <div class="tab-pane fade" id="pools" role="tabpanel">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">🏊 Liste des Pools</h5>
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>Factures</th>
                                            <th>Montant</th>
                                            <th>État</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pools-list">
                                        <!-- Les pools seront chargés ici -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


         <!-- ================================================== -->
        <!-- DEMANDES TOKENISATION============================== -->
        <div class="tab-pane fade" id="demandes" role="tabpanel">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-orange">📋 Liste des Factures</h5>
                            <div class="mb-3">
                                <input type="text" id="invoice-search" class="form-control" placeholder="Rechercher une facture...">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Entreprise</th>
                                            <th>Client</th>
                                            <th>Montant</th>
                                            <th>État</th>
                                            <th>collatéral</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoices-list">
                                        <!-- Les factures seront chargées ici -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal pour les détails de facture -->
<div class="modal fade" id="invoiceDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-orange">Détails complets de la facture <span id="modalInvoiceId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-orange">Informations générales</h6>
                            <p><strong>Entreprise:</strong> <span id="modalCompanyName"></span></p>
                            <p><strong>Client:</strong> <span id="modalClientName"></span></p>
                            <p><strong>Secteur:</strong> <span id="modalSector"></span></p>
                            <p><strong>Localisation:</strong> <span id="modalLocation"></span></p>
                            <p><strong>Type de facture:</strong> <span id="modalInvoiceType"></span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-orange">Détails financiers</h6>
                            <p><strong>Montant:</strong> <span id="modalAmount"></span></p>
                            <p><strong>Taux d'intérêt:</strong> <span id="modalInterestRate"></span></p>
                            <p><strong>Fin de collecte:</strong> <span id="modalFundingEndDate"></span></p>
                            <p><strong>Échéance:</strong> <span id="modalDueDate"></span></p>
                            <p><strong>Statut collatéral:</strong> <span id="modalCollateralStatus"></span></p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-orange">Description</h6>
                    <p id="modalDescription" class="text-muted"></p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-orange">Statut de financement</h6>
                    <p><strong>Montant collecté:</strong> <span id="modalCollectedAmount"></span></p>
                    <div class="progress mb-2">
                        <div id="modalFundingProgress" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
                
                <div class="text-center mt-3" id="modalDocumentPreview">
                    <!-- Document sera inséré ici dynamiquement -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
    

<!-- Modal de gestion de pool -->
<div class="modal fade" id="poolManagementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-orange">Gestion du Pool <span id="poolManagementId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-darker mb-3">
                            <div class="card-body">
                                <h5 class="card-title text-orange">Informations du Pool</h5>
                                <p><strong>Nom:</strong> <span id="poolManagementName"></span></p>
                                <p><strong>Statut:</strong> <span id="poolManagementStatus"></span></p>
                                <p><strong>Investissement minimum:</strong> <span id="poolManagementMinInvestment"></span></p>
                                <p><strong>Montant maximum:</strong> <span id="poolManagementMaxAmount"></span></p>
                                <p><strong>Factures:</strong> <span id="poolManagementCurrentInvoices"></span>/<span id="poolManagementMaxInvoices"></span></p>
                                <p><strong>Description:</strong> <span id="poolManagementDescription"></span></p>
                            </div>
                        </div>
                        
                        <div class="card bg-darker">
                            <div class="card-body">
                                <h5 class="card-title text-orange">Ajouter une Facture</h5>
                                <select id="addInvoiceSelect" class="form-select mb-3">
                                    <option value="">Sélectionner une facture</option>
                                </select>
                                <button id="addInvoiceToPoolBtn" class="btn btn-orange w-100">Ajouter au Pool</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card bg-darker h-100">
                            <div class="card-body">
                                <h5 class="card-title text-orange">Factures dans ce Pool</h5>
                                <div class="row" id="poolInvoicesList">
                                    <!-- Les factures seront affichées ici -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
</div>



<!-- Bootstrap JS pour les onglets -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>