<div class="container my-5" data-page-module="investor">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-orange">Panneau Investisseur CoinFinance</h1>
        <a href="<?php echo site_url('Dashboard'); ?>" class="btn btn-secondary">Retour au Dashboard</a>
    </div>

    <ul class="nav nav-tabs" id="investorTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-orange" id="portfolio-tab" data-bs-toggle="tab" data-bs-target="#portfolio" type="button" role="tab">Mon Portefeuille</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="invest-tab" data-bs-toggle="tab" data-bs-target="#invest" type="button" role="tab">Investir</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="pools-tab" data-bs-toggle="tab" data-bs-target="#pools" type="button" role="tab">Pools d'Investissement</button>
        </li>
    </ul>

    <div class="tab-content" id="investorTabContent">
        <!-- Onglet Portefeuille -->
        <div class="tab-pane fade show active" id="portfolio" role="tabpanel">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4 bg-dark text-white">
                        <div class="card-body">
                            <h5 class="card-title text-orange">📊 Mon Portefeuille d'Investissements</h5>
                            <p class="card-text">Retrouvez ici toutes vos participations dans les factures et pools.</p>
                            
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="card bg-dark border-orange mb-3">
                                        <div class="card-body text-center">
                                            <h6 class="text-orange">Investissements Actifs</h6>
                                            <h3 id="active-investments-count" class="text-white">0</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-dark border-orange mb-3">
                                        <div class="card-body text-center">
                                            <h6 class="text-orange">Montant Total Investi</h6>
                                            <h3 id="total-invested-amount" class="text-white">0 USDT</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-dark border-orange mb-3">
                                        <div class="card-body text-center">
                                            <h6 class="text-orange">Fonds à Réclamer</h6>
                                            <h3 id="total-claimable-amount" class="text-white">0 USDT</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="investor-portfolio-list" class="mt-4">
                                <p class="text-muted text-center">Chargement de votre portefeuille...</p>
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

        <!-- Onglet Investir -->
        <div class="tab-pane fade" id="invest" role="tabpanel">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4 bg-dark text-white">
                        <div class="card-body">
                            <h5 class="card-title text-orange">💸 Investir dans des Factures</h5>
                            <p class="card-text">Sélectionnez une facture disponible pour investir et bénéficier des intérêts.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-dark text-white border-orange">Filtrer</span>
                                        <select id="invoice-filter" class="form-control bg-dark text-white border-orange">
                                            <option value="all">Toutes les factures</option>
                                            <option value="active">Actives</option>
                                            <option value="funded">Financées</option>
                                            <option value="high-interest">Taux d'intérêt élevé</option>
                                            <option value="short-term">Court terme</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-dark text-white border-orange">Trier par</span>
                                        <select id="invoice-sort" class="form-control bg-dark text-white border-orange">
                                            <option value="newest">Plus récentes</option>
                                            <option value="oldest">Plus anciennes</option>
                                            <option value="amount-asc">Montant (croissant)</option>
                                            <option value="amount-desc">Montant (décroissant)</option>
                                            <option value="interest-asc">Intérêt (croissant)</option>
                                            <option value="interest-desc">Intérêt (décroissant)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="available-invoices-list" class="mt-4">
                                <p class="text-muted text-center">Chargement des factures disponibles...</p>
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

        <!-- Onglet Pools -->
        <div class="tab-pane fade" id="pools" role="tabpanel">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4 bg-dark text-white">
                        <div class="card-body">
                            <h5 class="card-title text-orange">🏊 Pools d'Investissement</h5>
                            <p class="card-text">Investissez dans des pools diversifiés pour réduire les risques.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-dark text-white border-orange">Filtrer</span>
                                        <select id="pool-filter" class="form-control bg-dark text-white border-orange">
                                            <option value="all">Tous les pools</option>
                                            <option value="active">Actifs</option>
                                            <option value="low-risk">Faible risque</option>
                                            <option value="high-return">Haut rendement</option>
                                            <option value="thematic">Thématiques</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-dark text-white border-orange">Trier par</span>
                                        <select id="pool-sort" class="form-control bg-dark text-white border-orange">
                                            <option value="newest">Plus récents</option>
                                            <option value="oldest">Plus anciens</option>
                                            <option value="min-invest-asc">Min. invest (croissant)</option>
                                            <option value="min-invest-desc">Min. invest (décroissant)</option>
                                            <option value="size-asc">Taille (croissant)</option>
                                            <option value="size-desc">Taille (décroissant)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="investment-pools-list" class="mt-4">
                                <p class="text-muted text-center">Chargement des pools disponibles...</p>
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
    </div>
</div>

<!-- Modal pour investir dans une facture -->
<div class="modal fade" id="investInvoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-orange">Investir dans la facture <span id="modalInvoiceId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Montant à investir (USDT)</label>
                    <input type="number" id="investmentAmount" class="form-control bg-dark text-white" placeholder="Montant en USDT">
                </div>
                
                <div class="card bg-darker mb-3">
                    <div class="card-body">
                        <h6 class="text-orange">Détails de l'investissement</h6>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><small>Montant:</small></p>
                                <p class="mb-1"><small>Frais d'entrée:</small></p>
                                <p class="mb-1"><small>Investissement net:</small></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-1" id="investmentGrossAmount">0 USDT</p>
                                <p class="mb-1" id="investmentEntryFee">0 USDT (0%)</p>
                                <p class="mb-1" id="investmentNetAmount">0 USDT</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Le montant net sera investi dans la facture après déduction des frais.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="confirmInvestInvoice" class="btn btn-orange">Confirmer l'investissement</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour investir dans un pool -->
<div class="modal fade" id="investPoolModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-orange">Investir dans le pool <span id="modalPoolName"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Montant à investir (USDT)</label>
                    <input type="number" id="poolInvestmentAmount" class="form-control bg-dark text-white" placeholder="Montant en USDT">
                    <small class="text-muted">Minimum: <span id="poolMinInvestment">10</span> USDT</small>
                </div>
                
                <div class="card bg-darker mb-3">
                    <div class="card-body">
                        <h6 class="text-orange">Détails de l'investissement</h6>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><small>Montant:</small></p>
                                <p class="mb-1"><small>Frais d'entrée:</small></p>
                                <p class="mb-1"><small>Frais de pool:</small></p>
                                <p class="mb-1"><small>Investissement net:</small></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-1" id="poolInvestmentGrossAmount">0 USDT</p>
                                <p class="mb-1" id="poolInvestmentEntryFee">0 USDT (0%)</p>
                                <p class="mb-1" id="poolInvestmentPoolFee">0 USDT (0%)</p>
                                <p class="mb-1" id="poolInvestmentNetAmount">0 USDT</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Votre investissement sera réparti entre plusieurs factures du pool.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="confirmInvestPool" class="btn btn-orange">Confirmer l'investissement</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour réclamer des fonds -->
<div class="modal fade" id="claimFundsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-orange">Réclamer les fonds</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Vous êtes sur le point de réclamer les fonds pour la facture <strong id="claimInvoiceId"></strong>.</p>
                
                <div class="card bg-darker mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><small>Vos parts:</small></p>
                                <p class="mb-1"><small>Montant à réclamer:</small></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-1" id="claimSharesPercentage">0%</p>
                                <p class="mb-1" id="claimableAmount">0 USDT</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> Cette action brûlera vos tokens ERC1155 pour cette facture.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="confirmClaimFunds" class="btn btn-success">Réclamer les fonds</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour voir les détails d'une facture -->
<div class="modal fade" id="invoiceDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-orange">Détails de la facture <span id="detailInvoiceId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-orange">Informations générales</h6>
                            <p><strong>Entreprise:</strong> <span id="detailCompanyName"></span></p>
                            <p><strong>Client:</strong> <span id="detailClientName"></span></p>
                            <p><strong>Montant:</strong> <span id="detailAmount"></span></p>
                            <p><strong>Taux d'intérêt:</strong> <span id="detailInterestRate"></span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-orange">Dates clés</h6>
                            <p><strong>Fin de collecte:</strong> <span id="detailFundingEndDate"></span></p>
                            <p><strong>Échéance:</strong> <span id="detailDueDate"></span></p>
                            <p><strong>Statut:</strong> <span id="detailStatus" class="badge"></span></p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-orange">Description</h6>
                    <p id="detailDescription" class="text-muted"></p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-orange">Progression du financement</h6>
                    <div class="progress mb-2" style="height: 10px;">
                        <div id="detailFundingProgress" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                    </div>
                    <p class="text-end"><small><span id="detailCollectedAmount"></span> / <span id="detailTotalAmount"></span> USDT</small></p>
                </div>
                
                <div id="detailDocumentPreview" class="text-center mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour voir les détails d'un pool -->
<div class="modal fade" id="poolDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-orange">Détails du pool <span id="detailPoolName"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <img id="poolBannerImage" src="" class="img-fluid rounded" style="max-height: 200px;" alt="Bannière du pool">
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="text-orange">Informations générales</h6>
                                    <p><strong>Thème:</strong> <span id="detailPoolTheme"></span></p>
                                    <p><strong>Niveau de risque:</strong> <span id="detailPoolRisk"></span></p>
                                    <p><strong>Région:</strong> <span id="detailPoolRegion"></span></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="text-orange">Conditions</h6>
                                    <p><strong>Investissement minimum:</strong> <span id="detailPoolMinInvestment"></span></p>
                                    <p><strong>Factures actives:</strong> <span id="detailPoolActiveInvoices"></span></p>
                                    <p><strong>Statut:</strong> <span id="detailPoolStatus" class="badge"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-orange">Description</h6>
                    <p id="detailPoolDescription" class="text-muted"></p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-orange">Factures du pool</h6>
                    <div id="poolInvoicesList" class="mt-3">
                        <p class="text-muted text-center">Chargement des factures...</p>
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border text-orange" role="status">
                                <span class="visually-hidden">Loading...</span>
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



