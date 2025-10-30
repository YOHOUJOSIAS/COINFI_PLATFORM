<div class="container my-5" data-page-module="enterprise">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-orange">Panneau Entreprise CoinFinance</h1>
        <a href="<?php echo site_url('Dashboard'); ?>" class="btn btn-secondary">Retour au Dashboard</a>
    </div>

    <ul class="nav nav-tabs" id="entrepriseTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-orange" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices" type="button" role="tab">Mes Factures</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats" type="button" role="tab">📈 Statistiques</button>
        </li>
         <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="creation-tab" data-bs-toggle="tab" data-bs-target="#creation" type="button" role="tab">Demande de tokenisation</button>
        </li>
    </ul>

    <div class="tab-content" id="entrepriseTabContent">
        <div class="tab-pane fade show active" id="invoices" role="tabpanel">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4 bg-dark text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title text-orange">📊 Aperçu de mes Factures</h5>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="invoiceFilterDropdown" data-bs-toggle="dropdown">
                                        <i class="bi bi-funnel"></i> <span class="filter-text">Filtrer</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end bg-dark">
                                        <li><a class="dropdown-item text-white filter-option active" href="#" data-filter="all">Toutes les factures</a></li>
                                        <li><hr class="dropdown-divider bg-secondary"></li>
                                        <li><a class="dropdown-item text-white filter-option" href="#" data-filter="paid">Remboursées</a></li>
                                        <li><a class="dropdown-item text-white filter-option" href="#" data-filter="unpaid">Non remboursées</a></li>
                                        <li><a class="dropdown-item text-white filter-option" href="#" data-filter="partially">Partiellement financées</a></li>
                                        <li><a class="dropdown-item text-white filter-option" href="#" data-filter="fully">Entièrement financées</a></li>
                                        <li><a class="dropdown-item text-white filter-option" href="#" data-filter="collateral-needed">Collatéral requis</a></li>
                                        <li><a class="dropdown-item text-white filter-option" href="#" data-filter="no-collateral">Sans collatéral</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div id="company-invoices-list" class="mt-4">
                                <p class="text-muted text-center">Chargement de vos factures...</p>
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border text-orange" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="stats" role="tabpanel">
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card mb-4 bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title text-orange">💵 Aperçu Financier</h5>
                        <div class="row">
                            <div class="col-6">
                                <div class="p-3 bg-darker rounded mb-3">
                                    <h6 class="text-muted">Montant Total</h6>
                                    <h4 id="total-amount">0 USDT</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-darker rounded mb-3">
                                    <h6 class="text-muted">À Retirer</h6>
                                    <h4 id="withdrawable-amount">0 USDT</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="p-3 bg-darker rounded mb-3">
                                    <h6 class="text-muted">Intérêts Totaux</h6>
                                    <h4 id="total-interest">0 USDT</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-darker rounded mb-3">
                                    <h6 class="text-muted">Frais Plateforme</h6>
                                    <h4 id="total-fees">0 USDT</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card mb-4 bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title text-orange">🛡️ Collatéraux</h5>
                        
                        <div class="p-3 bg-darker rounded mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Total Collatéral</h6>
                                    <h4 id="total-collateral">0 USDT</h4>
                                </div>
                                <span class="badge bg-secondary">
                                    <i class="bi bi-wallet2"></i> Dépôt
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-3 bg-darker rounded mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Disponible à Libérer</h6>
                                    <h4 id="releasable-collateral">0 USDT</h4>
                                </div>
                                <span class="badge bg-success">
                                    <i class="bi bi-unlock"></i> Libérable
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-3 bg-darker rounded mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Retenu (2ème collatéral)</h6>
                                    <h4 id="withheld-collateral">0 USDT</h4>
                                </div>
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-lock"></i> Retenu
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-3 bg-darker rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Taux Moyen</h6>
                                    <h4 id="avg-collateral-rate">0%</h4>
                                </div>
                                <span class="badge bg-info">
                                    <i class="bi bi-percent"></i> Taux
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-4 bg-dark text-white">
            <div class="card-body">
                <h5 class="card-title text-orange">📅 Calendrier des Échéances</h5>
                <div id="upcoming-due-dates" class="mt-3">
                    <!-- Les échéances seront ajoutées ici dynamiquement -->
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- Onglet Création -->
        <!-- ================================================== -->
        <div class="tab-pane fade" id="creation" role="tabpanel">
            <div class="row mt-4">
                <div class="col-lg-12">
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
                    <div class="card mb-4" style="display: none;">
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

<!-- Modal pour le dépôt de collatéral -->
<div class="modal fade" id="depositCollateralModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-orange">Déposer le Collatéral</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Montant du collatéral requis:</label>
                    <input type="text" id="collateralAmount" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pourcentage appliqué:</label>
                    <input type="text" id="collateralRate" class="form-control" readonly>
                </div>
                <div class="progress mb-3">
                    <div id="collateralProgress" class="progress-bar bg-orange" role="progressbar" style="width: 0%"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="confirmDepositCollateral" class="btn btn-orange">Confirmer le dépôt</button>
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
                    <!-- Document sera inséré ici -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
