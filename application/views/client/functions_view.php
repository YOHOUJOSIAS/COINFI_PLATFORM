<div class="container my-5" data-page-module="client">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-orange">Panneau Client CoinFinance</h1>
        <a href="<?php echo site_url('Dashboard'); ?>" class="btn btn-secondary">Retour au Dashboard</a>
    </div>

    <ul class="nav nav-tabs" id="clientTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-orange" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices" type="button" role="tab">Mes Factures</button>
        </li>
       
        <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">Historique</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats" type="button" role="tab">Statistiques</button>
        </li>

         <li class="nav-item" role="presentation">
            <button class="nav-link text-orange" id="creation-tab" data-bs-toggle="tab" data-bs-target="#creation" type="button" role="tab">Création</button>
        </li>
    </ul>

    <div class="tab-content" id="clientTabContent">
        <!-- Onglet Factures -->
        <div class="tab-pane fade show active" id="invoices" role="tabpanel">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4 bg-dark text-white">
                        <div class="card-body">
                            <h5 class="card-title text-orange">📄 Mes Factures à Payer</h5>
                            <p class="card-text">Retrouvez ici toutes les factures que vous devez rembourser.</p>
                            
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="card bg-dark border-orange mb-3">
                                        <div class="card-body text-center">
                                            <h6 class="text-orange">Factures Actives</h6>
                                            <h3 id="active-invoices-count" class="text-white">0</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-dark border-orange mb-3">
                                        <div class="card-body text-center">
                                            <h6 class="text-orange">Montant Total</h6>
                                            <h3 id="total-invoices-amount" class="text-white">0 USDT</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-dark border-orange mb-3">
                                        <div class="card-body text-center">
                                            <h6 class="text-orange">En Retard</h6>
                                            <h3 id="overdue-invoices-count" class="text-white">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-dark text-white border-orange">Filtrer</span>
                                <select id="invoice-filter" class="form-control bg-dark text-white border-orange">
                                    <option value="all">Toutes les factures</option>
                                    <option value="active">Actives</option>
                                    <option value="overdue">En retard</option>
                                    <option value="ready">Prêtes à payer</option>
                                    <option value="paid">Payées</option>
                                </select>
                            </div>
                            
                            <div id="client-invoices-list" class="mt-4">
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

        <!-- Onglet Historique -->
        <div class="tab-pane fade" id="history" role="tabpanel">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4 bg-dark text-white">
                        <div class="card-body">
                            <h5 class="card-title text-orange">📊 Historique des Paiements</h5>
                            <p class="card-text">Consultez l'historique de vos paiements de factures.</p>
                            
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="card bg-dark border-orange mb-3">
                                        <div class="card-body text-center">
                                            <h6 class="text-orange">Factures Payées</h6>
                                            <h3 id="paid-invoices-count" class="text-white">0</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-dark border-orange mb-3">
                                        <div class="card-body text-center">
                                            <h6 class="text-orange">Montant Total</h6>
                                            <h3 id="total-paid-amount" class="text-white">0 USDT</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-dark border-orange mb-3">
                                        <div class="card-body text-center">
                                            <h6 class="text-orange">Intérêts Payés</h6>
                                            <h3 id="total-interest-paid" class="text-white">0 USDT</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="payment-history-list" class="mt-4">
                                <p class="text-muted text-center">Chargement de l'historique...</p>
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

        <!-- Onglet Statistiques -->
        <div class="tab-pane fade" id="stats" role="tabpanel">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4 bg-dark text-white">
                        <div class="card-body">
                            <h5 class="card-title text-orange">📈 Mes Statistiques</h5>
                            <p class="card-text">Analysez vos performances et votre historique de paiement.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card bg-darker mb-4">
                                        <div class="card-body">
                                            <h6 class="text-orange">Délai Moyen de Paiement</h6>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <h3 id="avg-payment-delay" class="text-white">0 jours</h3>
                                                <div id="delay-trend" class="text-success">
                                                    <i class="bi bi-arrow-up"></i> 0%
                                                </div>
                                            </div>
                                            <p class="text-muted small mt-2">Par rapport à la période précédente</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-darker mb-4">
                                        <div class="card-body">
                                            <h6 class="text-orange">Taux de Ponctualité</h6>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <h3 id="on-time-rate" class="text-white">0%</h3>
                                                <div id="on-time-trend" class="text-success">
                                                    <i class="bi bi-arrow-up"></i> 0%
                                                </div>
                                            </div>
                                            <p class="text-muted small mt-2">Factures payées à temps</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card bg-darker mb-4">
                                <div class="card-body">
                                    <h6 class="text-orange">Évolution des Paiements</h6>
                                    <div id="payments-chart" style="height: 300px;"></div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card bg-darker">
                                        <div class="card-body">
                                            <h6 class="text-orange">Répartition par Entreprise</h6>
                                            <div id="companies-chart" style="height: 250px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-darker">
                                        <div class="card-body">
                                            <h6 class="text-orange">Montants par Secteur</h6>
                                            <div id="sectors-chart" style="height: 250px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    </div>
</div>

<!-- Modal pour rembourser une facture -->
<div class="modal fade" id="repayInvoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-orange">Rembourser la facture <span id="modalRepayInvoiceId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <p>Vous êtes sur le point de rembourser la facture <strong id="repayInvoiceNumber"></strong> pour l'entreprise <strong id="repayCompanyName"></strong>.</p>
                    
                    <div class="card bg-darker mb-3">
                        <div class="card-body">
                            <h6 class="text-orange">Détails du Remboursement</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1"><small>Montant Facture:</small></p>
                                    <p class="mb-1"><small>Intérêts:</small></p>
                                    <p class="mb-1"><small>Frais:</small></p>
                                    <p class="mb-1"><small>Total à Payer:</small></p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="mb-1" id="repayInvoiceAmount">0 USDT</p>
                                    <p class="mb-1" id="repayInterestAmount">0 USDT</p>
                                    <p class="mb-1" id="repayFeesAmount">0 USDT</p>
                                    <p class="mb-1" id="repayTotalAmount">0 USDT</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="repay-balance-check" class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Vérification du solde en cours...
                    </div>
                    
                    <div id="repay-approval-check" class="alert alert-warning d-none">
                        <i class="bi bi-exclamation-triangle"></i> Une approbation est nécessaire avant de procéder au paiement.
                    </div>
                </div>
                
                <div class="alert alert-warning" id="overdue-warning" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> Cette facture est en retard! Des frais supplémentaires peuvent s'appliquer.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="approveRepaymentBtn" class="btn btn-warning d-none">Approuver USDT</button>
                <button type="button" id="confirmRepaymentBtn" class="btn btn-success">Confirmer le Paiement</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour voir les détails d'une facture -->
<div class="modal fade" id="invoiceDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-orange">Détails de la Facture <span id="detailInvoiceId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-orange">Informations générales</h6>
                            <p><strong>Entreprise:</strong> <span id="detailCompanyName"></span></p>
                            <p><strong>Montant:</strong> <span id="detailAmount"></span></p>
                            <p><strong>Taux d'intérêt:</strong> <span id="detailInterestRate"></span></p>
                            <p><strong>Secteur:</strong> <span id="detailSector"></span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-orange">Dates clés</h6>
                            <p><strong>Date d'émission:</strong> <span id="detailIssueDate"></span></p>
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
                    <h6 class="text-orange">Financement</h6>
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

<script>
// Cette partie sera ajoutée à app.js dans la section client
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des onglets
    const invoicesTab = document.getElementById('invoices-tab');
    if (invoicesTab) {
        invoicesTab.addEventListener('shown.bs.tab', loadClientInvoices);
        if (invoicesTab.classList.contains('active')) {
            loadClientInvoices();
        }
    }

    const historyTab = document.getElementById('history-tab');
    if (historyTab) {
        historyTab.addEventListener('shown.bs.tab', loadPaymentHistory);
    }

    const statsTab = document.getElementById('stats-tab');
    if (statsTab) {
        statsTab.addEventListener('shown.bs.tab', loadClientStats);
    }

    // Filtre des factures
    const invoiceFilter = document.getElementById('invoice-filter');
    if (invoiceFilter) {
        invoiceFilter.addEventListener('change', loadClientInvoices);
    }

    // Gestionnaire pour le bouton de remboursement dans le modal de détails
    document.getElementById('repayFromDetailsBtn')?.addEventListener('click', function() {
        const invoiceId = document.getElementById('detailInvoiceId').textContent;
        const modal = bootstrap.Modal.getInstance(document.getElementById('invoiceDetailsModal'));
        modal.hide();
        showRepayInvoiceModal(invoiceId);
    });
});

/**
 * Charge les factures du client
 */
async function loadClientInvoices() {
    try {
        const container = document.getElementById('client-invoices-list');
        container.innerHTML = `
            <p class="text-muted text-center">Chargement de vos factures...</p>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-orange" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;


        const filter = document.getElementById('invoice-filter').value;
        const invoices = await window.clientFunctions.getClientInvoices();
        
        // Appliquer le filtre
        let filteredInvoices = invoices;
        if (filter === 'active') {
            filteredInvoices = invoices.filter(i => !i.isPaid && !i.isOverdue);
        } else if (filter === 'overdue') {
            filteredInvoices = invoices.filter(i => i.isOverdue);
        } else if (filter === 'ready') {
            filteredInvoices = invoices.filter(i => i.canRepay);
        } else if (filter === 'paid') {
            filteredInvoices = invoices.filter(i => i.isPaid);
        }

        // Mettre à jour les compteurs
        document.getElementById('active-invoices-count').textContent = 
            invoices.filter(i => !i.isPaid).length;
        document.getElementById('overdue-invoices-count').textContent = 
            invoices.filter(i => i.isOverdue).length;
        
        const totalAmount = invoices
            .filter(i => !i.isPaid)
            .reduce((sum, i) => sum + parseFloat(i.amount), 0);
        document.getElementById('total-invoices-amount').textContent = 
            totalAmount.toFixed(2) + ' USDT';

        if (filteredInvoices.length === 0) {
            container.innerHTML = `
                <div class="text-center py-4">
                    <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Aucune facture trouvée</h5>
                    <p class="text-muted">Aucune facture ne correspond aux critères sélectionnés.</p>
                </div>
            `;
            return;
        }

        let html = '';
        filteredInvoices.forEach(invoice => {
            const dueDate = new Date(invoice.dueDate).toLocaleDateString();
            const fundingEndDate = new Date(invoice.fundingEndDate).toLocaleDateString();
            
            let statusBadge, statusClass;
            if (invoice.isPaid) {
                statusBadge = 'Payée';
                statusClass = 'bg-success';
            } else if (invoice.isOverdue) {
                statusBadge = 'En Retard';
                statusClass = 'bg-danger';
            } else if (invoice.canRepay) {
                statusBadge = 'Prête à Payer';
                statusClass = 'bg-warning text-dark';
            } else {
                statusBadge = 'Active';
                statusClass = 'bg-info';
            }

            html += `
                <div class="card mb-3 bg-dark text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title text-orange">Facture #${invoice.invoiceId} <span class="badge ${statusClass}">${statusBadge}</span></h5>
                                <p class="mb-1"><small>Entreprise: ${invoice.company}</small></p>
                                <p class="mb-1"><small>Montant: ${invoice.amount} USDT</small></p>
                                <p class="mb-1"><small>Taux: ${invoice.interestRate}%</small></p>
                            </div>
                            <div class="text-end">
                                <p class="mb-1"><small>Fin collecte: ${fundingEndDate}</small></p>
                                <p class="mb-1"><small>Échéance: ${dueDate}</small></p>
                                ${window.uiUtils.isDeadlinePassed(invoice.dueDate) ? `
                                <button class="btn btn-success btn-sm repay-btn mt-2" data-invoice-id="${invoice.invoiceId}">
                                    <i class="bi bi-cash-coin"></i> Rembourser
                                </button>` : ''}
                                <button class="btn btn-orange btn-sm details-btn mt-2" data-invoice-id="${invoice.invoiceId}">
                                    <i class="bi bi-eye"></i> Détails
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;

        // Ajouter les gestionnaires d'événements
        document.querySelectorAll('.repay-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const invoiceId = this.getAttribute('data-invoice-id');
                showRepayInvoiceModal(invoiceId);
            });
        });

        document.querySelectorAll('.details-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const invoiceId = this.getAttribute('data-invoice-id');
                showInvoiceDetailsModal(invoiceId);
            });
        });

    } catch (error) {
        console.error('Error loading client invoices:', error);
        document.getElementById('client-invoices-list').innerHTML = `
            <div class="alert alert-danger text-center">
                Erreur lors du chargement des factures: ${error.message}
            </div>
        `;
    }
}

/**
 * Affiche le modal de remboursement
 */
async function showRepayInvoiceModal(invoiceId) {
    
    try {
        // 1. D'abord récupérer les données
        const invoiceData = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        const repayment = await window.clientFunctions.calculateRepaymentAmount(invoiceId);
        
        // 2. Valider la structure des données
        if (!invoiceData || !invoiceData.invoice || !invoiceData.invoice.details?.dueDate) {
            console.error('Invalid invoice data structure:', invoiceData);
            window.uiUtils.showErrorAlert('Structure des données de facture invalide');
            return;
        }
        
        const { invoice, metadata } = invoiceData;
        
        // 3. Convertir les BigNumber en valeurs utilisables avec gestion des erreurs
        const formatSafeEther = (value) => {
            try {
                let valueStr;

                // Si c'est déjà un BigNumber, on le formate pour l'affichage.
                if (ethers.BigNumber.isBigNumber(value)) {
                    valueStr = ethers.utils.formatEther(value);
                } else {
                // Sinon, on s'assure que c'est une chaîne de caractères pour le manipuler.
                    valueStr = value.toString();
                }
                
                // On retourne la valeur formatée pour l'affichage (pas pour les calculs)
                // parseFloat est utilisé pour nettoyer la chaîne avant de fixer les décimales.
                return parseFloat(valueStr).toFixed(4); // Affichez 4 décimales pour plus de précision

            } catch (e) {
                console.error('Error formatting value:', value, e);
                return "0.00"; // Retourne une valeur par défaut propre
            }
        };

        const invoiceAmount = formatSafeEther(repayment.breakdown.invoiceAmount);
        const interestAmount = formatSafeEther(repayment.breakdown.netInterest);
        const feesAmount = formatSafeEther(repayment.breakdown.performanceFee);
        const totalAmount = formatSafeEther(repayment.breakdown.totalToInvestors);

        // Remplir les informations de base
        document.getElementById('modalRepayInvoiceId').textContent = invoiceId;
        document.getElementById('repayInvoiceNumber').textContent = `#${invoiceId}`;
        document.getElementById('repayCompanyName').textContent = metadata?.companyName || 'Inconnue';
        
        // Remplir les montants avec 2 décimales
        document.getElementById('repayInvoiceAmount').textContent = 
            `${parseFloat(invoiceAmount).toFixed(2)} USDT`;
        document.getElementById('repayInterestAmount').textContent = 
            `${parseFloat(interestAmount).toFixed(2)} USDT`;
        document.getElementById('repayFeesAmount').textContent = 
            `${parseFloat(feesAmount).toFixed(2)} USDT`;
        document.getElementById('repayTotalAmount').textContent = 
            `${parseFloat(totalAmount).toFixed(2)} USDT`;
        
        
        // Vérification du stablecoin
        const currentStablecoin = window.stablecoinCFN.getStablecoinInfo();
        if (!currentStablecoin) {
            throw new Error('No stablecoin available for current network');
        }

        // Vérifier le solde
        const balanceCheck = document.getElementById('repay-balance-check');
        let hasEnough;

        hasEnough = await window.stablecoinCFN.checkCFNBalance(
            totalAmount,
            window.walletUtils.getCurrentWalletAddress()
        );

        // Gestion de l'affichage du solde
        if (hasEnough.hasEnough) {
            balanceCheck.innerHTML = `
                <i class="bi bi-check-circle"></i> Solde suffisant: ${hasEnough.balance} ${currentStablecoin.symbol} disponible
            `;
            balanceCheck.className = 'alert alert-success';
        } else {
            balanceCheck.innerHTML = `
                <i class="bi bi-exclamation-triangle"></i> Solde insuffisant. Nécessaire: ${parseFloat(totalAmount).toFixed(2)} ${currentStablecoin.symbol}, Disponible: ${hasEnough.balance} ${currentStablecoin.type}
            `;
            balanceCheck.className = 'alert alert-danger';
            document.getElementById('confirmRepaymentBtn').disabled = true;
            return;
        }
        
        // Vérifier l'approbation
        const approvalCheck = document.getElementById('repay-approval-check');
        const approveBtn = document.getElementById('approveRepaymentBtn');
        const confirmBtn = document.getElementById('confirmRepaymentBtn');
        

        
        // Afficher l'avertissement si en retard
        if (window.uiUtils.isDeadlinePassed(invoice.details.dueDate)) {
            document.getElementById('overdue-warning').style.display = 'block';
        }
        
        // Gestionnaire de confirmation
        confirmBtn.addEventListener('click', async function() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('repayInvoiceModal'));
            modal.hide();
            
            try {
                await window.clientFunctions.repayInvoice(invoiceId);
                loadClientInvoices();
                window.uiUtils.showSuccessAlert('Facture remboursée avec succès!');
            } catch (error) {
                console.error('Repayment failed:', error);
            }
        });
        
        // Afficher le modal
        const modal = new bootstrap.Modal(document.getElementById('repayInvoiceModal'));
        modal.show();
        
    } catch (error) {
        console.error('Error showing repay modal:', error);
        window.uiUtils.showErrorAlert('Erreur lors du chargement des détails de la facture');
    }
}

/**
 * Charge l'historique des paiements
 */
/**
 * Charge l'historique des paiements avec une meilleure gestion des erreurs
 */
async function loadPaymentHistory() {
    const container = document.getElementById('payment-history-list');
    
    try {
        // Afficher le loader
        container.innerHTML = `
            <p class="text-muted text-center">Chargement de l'historique...</p>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-orange" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

        // Vérifier que le wallet est connecté
        if (!window.walletUtils.isWalletReady()) {
            container.innerHTML = `
                <div class="alert alert-warning text-center">
                    Veuillez connecter votre portefeuille pour voir votre historique.
                </div>
            `;
            return;
        }

        // Récupérer l'historique
        const history = await window.clientFunctions.getPaymentHistory();
        
        // Valider la structure des données
        if (!history || !Array.isArray(history.invoices)) {
            throw new Error('Données d\'historique invalides');
        }

        // Filtrer les factures payées et valider chaque entrée
        const paidInvoices = history.invoices.filter(invoice => {
            return invoice && 
                   invoice.isPaid && 
                   typeof invoice.amount !== 'undefined' && 
                   typeof invoice.interestRate !== 'undefined';
        });

        // Calculer les totaux avec vérification des types
        const paidInvoicesCount = paidInvoices.length;
        
        const totalPaid = paidInvoices.reduce((sum, invoice) => {
            const amount = parseFloat(invoice.amount) || 0;
            return sum + amount;
        }, 0);

        const totalInterest = paidInvoices.reduce((sum, invoice) => {
            const amount = parseFloat(invoice.amount) || 0;
            const rate = parseFloat(invoice.interestRate) || 0;
            return sum + (amount * rate / 100);
        }, 0);

        // Mettre à jour les compteurs avec vérification
        document.getElementById('paid-invoices-count').textContent = 
            Number.isInteger(paidInvoicesCount) ? paidInvoicesCount : '0';
        
        document.getElementById('total-paid-amount').textContent = 
            !isNaN(totalPaid) ? totalPaid.toFixed(2) + ' USDT' : '0.00 USDT';
        
        document.getElementById('total-interest-paid').textContent = 
            !isNaN(totalInterest) ? totalInterest.toFixed(2) + ' USDT' : '0.00 USDT';

        // Afficher un message si aucun historique
        if (paidInvoicesCount === 0) {
            container.innerHTML = `
                <div class="text-center py-4">
                    <i class="bi bi-clock-history text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Aucun historique de paiement</h5>
                    <p class="text-muted">Vous n'avez pas encore remboursé de factures.</p>
                </div>
            `;
            return;
        }

        // Générer le tableau HTML
        let html = `
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Facture</th>
                            <th>Entreprise</th>
                            <th>Montant</th>
                            <th>Intérêts</th>
                            <th>Date Paiement</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        paidInvoices.forEach(invoice => {
            try {
                // Formater les données avec valeurs par défaut
                const invoiceId = invoice.invoiceId || 'N/A';
                const company = invoice.company || 'Inconnue';
                const amount = parseFloat(invoice.amount) || 0;
                const rate = parseFloat(invoice.interestRate) || 0;
                const interest = (amount * rate / 100).toFixed(2);
                const paymentDate = invoice.paymentDate 
                    ? new Date(invoice.paymentDate).toLocaleDateString() 
                    : 'Date inconnue';
                
                html += `
                    <tr>
                        <td>#${invoiceId}</td>
                        <td>${company}</td>
                        <td>${amount.toFixed(2)} USDT</td>
                        <td>${interest} USDT</td>
                        <td>${paymentDate}</td>
                        <td><span class="badge bg-success">Payée</span></td>
                    </tr>
                `;
            } catch (e) {
                console.error('Error processing invoice row:', invoice, e);
            }
        });
        
        html += '</tbody></table></div>';
        container.innerHTML = html;

    } catch (error) {
        console.error('Error loading payment history:', error);
        container.innerHTML = `
            <div class="alert alert-danger text-center">
                Erreur lors du chargement de l'historique: ${error.message || 'Erreur inconnue'}
            </div>
        `;
    }
}

/**
 * Charge les statistiques du client
 */
async function loadClientStats() {
    try {
        if (!window.walletUtils.isWalletReady()) {
            document.getElementById('avg-payment-delay').textContent = '-- jours';
            document.getElementById('on-time-rate').textContent = '--%';
            return;
        }

        const history = await window.clientFunctions.getPaymentHistory();
        
        if (!history || !history.invoices) {
            console.error('Invalid payment history data');
            return;
        }

        // Filter and validate paid invoices
        const paidInvoices = history.invoices.filter(i => i && i.isPaid && i.dueDate);
        
        if (paidInvoices.length === 0) {
            document.getElementById('avg-payment-delay').textContent = '0 jours';
            document.getElementById('on-time-rate').textContent = '0%';
            return;
        }

        let totalDelay = 0;
        let onTimeCount = 0;
        
        paidInvoices.forEach(invoice => {
            try {
                const dueDate = new Date(invoice.dueDate);
                const paymentDate = invoice.paymentDate ? new Date(invoice.paymentDate) : new Date();
                const delay = Math.max(0, (paymentDate - dueDate) / (1000 * 60 * 60 * 24));
                
                totalDelay += delay;
                if (delay <= 0) onTimeCount++;
            } catch (e) {
                console.error('Error processing invoice:', invoice, e);
            }
        });
        
        const avgDelay = (totalDelay / paidInvoices.length).toFixed(1);
        const onTimeRate = (onTimeCount / paidInvoices.length * 100).toFixed(1);
        
        document.getElementById('avg-payment-delay').textContent = `${avgDelay} jours`;
        document.getElementById('on-time-rate').textContent = `${onTimeRate}%`;
        
        // Initialize charts with the full history data
        initializeClientCharts(history);

    } catch (error) {
        console.error('Error loading client stats:', error);
        document.getElementById('avg-payment-delay').textContent = '-- jours';
        document.getElementById('on-time-rate').textContent = '--%';
    }
}

/**
 * Initialise les graphiques pour les statistiques
 */
function initializeClientCharts(history) {
    try {
        // Filtrer seulement les factures payées
        const paidInvoices = history.invoices.filter(i => i.isPaid);
        
        // Helper function to create charts safely
        const createChart = (containerId, type, data, options) => {
            const container = document.getElementById(containerId);
            if (!container) return null;
            
            // Clear container and create new canvas
            container.innerHTML = '';
            const canvas = document.createElement('canvas');
            container.appendChild(canvas);
            
            // Get context
            const ctx = canvas.getContext('2d');
            if (!ctx) {
                console.error(`Could not get 2D context for ${containerId}`);
                return null;
            }
            
            return new Chart(ctx, {
                type: type,
                data: data,
                options: options
            });
        };
        
        // 1. Graphique d'évolution des paiements (ligne)
        const monthlyData = paidInvoices.reduce((acc, invoice) => {
            const date = new Date(invoice.paymentDate || invoice.dueDate);
            const monthYear = `${date.getMonth()+1}/${date.getFullYear()}`;
            
            if (!acc[monthYear]) {
                acc[monthYear] = 0;
            }
            acc[monthYear] += parseFloat(invoice.amount);
            
            return acc;
        }, {});
        
        const labels = Object.keys(monthlyData).sort();
        const data = labels.map(label => monthlyData[label]);
        
        createChart('payments-chart', 'line', {
            labels: labels,
            datasets: [{
                label: 'Montant payé (USDT)',
                data: data,
                borderColor: '#fd7e14',
                backgroundColor: 'rgba(253, 126, 20, 0.1)',
                tension: 0.1,
                fill: true
            }]
        }, {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: '#fff' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#fff' },
                    grid: { color: 'rgba(255, 255, 255, 0.1)' }
                },
                x: {
                    ticks: { color: '#fff' },
                    grid: { color: 'rgba(255, 255, 255, 0.1)' }
                }
            }
        });
        
        // 2. Graphique de répartition par entreprise (doughnut)
        const companiesData = paidInvoices.reduce((acc, invoice) => {
            const company = invoice.company || 'Inconnue';
            acc[company] = (acc[company] || 0) + parseFloat(invoice.amount);
            return acc;
        }, {});
        
        createChart('companies-chart', 'doughnut', {
            labels: Object.keys(companiesData),
            datasets: [{
                data: Object.values(companiesData),
                backgroundColor: Object.keys(companiesData).map((_, i) => {
                    const hue = (i * 137.508) % 360;
                    return `hsl(${hue}, 70%, 60%)`;
                }),
                borderColor: '#343a40',
                borderWidth: 1
            }]
        }, {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: { color: '#fff' }
                }
            }
        });
        
        // 3. Graphique de répartition par secteur (barre)
        const sectorsData = paidInvoices.reduce((acc, invoice) => {
            const sector = invoice.sector || 'Autre';
            acc[sector] = (acc[sector] || 0) + parseFloat(invoice.amount);
            return acc;
        }, {});
        
        createChart('sectors-chart', 'bar', {
            labels: Object.keys(sectorsData),
            datasets: [{
                label: 'Montant (USDT)',
                data: Object.values(sectorsData),
                backgroundColor: 'rgba(253, 126, 20, 0.7)',
                borderColor: 'rgba(253, 126, 20, 1)',
                borderWidth: 1
            }]
        }, {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: '#fff' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#fff' },
                    grid: { color: 'rgba(255, 255, 255, 0.1)' }
                },
                x: {
                    ticks: { color: '#fff' },
                    grid: { color: 'rgba(255, 255, 255, 0.1)' }
                }
            }
        });
        
    } catch (error) {
        console.error('Error initializing charts:', error);
    }
}

/**
 * Affiche les détails d'une facture
 */
async function showInvoiceDetailsModal(invoiceId) {
    try {
        const { invoice, metadata } = await window.sharedFunctions.getInvoiceDetails(invoiceId);
        
        // Remplir les informations de base
        document.getElementById('detailInvoiceId').textContent = invoiceId;
        document.getElementById('detailCompanyName').textContent = metadata?.companyName || 'Inconnue';
        document.getElementById('detailAmount').textContent = 
            `${ethers.utils.formatEther(invoice.details.amount)} USDT`;
        document.getElementById('detailInterestRate').textContent = 
            `${invoice.details.interestRate / 100}%`;
        document.getElementById('detailSector').textContent = 
            metadata?.sector || 'Non spécifié';
        document.getElementById('detailDescription').textContent = 
            metadata?.description || 'Aucune description disponible';
        
        // Dates
        document.getElementById('detailIssueDate').textContent = 
            new Date(invoice.details.creationDate * 1000).toLocaleDateString();
        document.getElementById('detailFundingEndDate').textContent = 
            new Date(invoice.details.fundingEndDate * 1000).toLocaleDateString();
        document.getElementById('detailDueDate').textContent = 
            new Date(invoice.details.dueDate * 1000).toLocaleDateString();
        
        // Statut
        let statusText, statusClass;
        if (invoice.financials.isPaid) {
            statusText = 'Payée';
            statusClass = 'bg-success';
        } else if (window.uiUtils.isDeadlinePassed(invoice.details.dueDate)) {
            statusText = 'En Retard';
            statusClass = 'bg-danger';
        } else if (invoice.financials.fundsWithdrawn) {
            statusText = 'Prête à Payer';
            statusClass = 'bg-warning text-dark';
        } else if (invoice.details.isActive) {
            statusText = 'Active';
            statusClass = 'bg-info';
        } else {
            statusText = 'Inactive';
            statusClass = 'bg-secondary';
        }
        
        const statusElement = document.getElementById('detailStatus');
        statusElement.textContent = statusText;
        statusElement.className = `badge ${statusClass}`;
        
        // Financement
        const amount = parseFloat(ethers.utils.formatEther(invoice.details.amount));
        const collected = parseFloat(ethers.utils.formatEther(invoice.financials.collectedAmount));
        const progress = (collected / amount * 100).toFixed(2);
        
        document.getElementById('detailTotalAmount').textContent = amount.toFixed(2);
        document.getElementById('detailCollectedAmount').textContent = collected.toFixed(2);
        document.getElementById('detailFundingProgress').style.width = `${progress}%`;
        
        // Document
        const docPreview = document.getElementById('detailDocumentPreview');
        docPreview.innerHTML = '';
        
        if (metadata?.documentURI) {
            const docUrl = window.ipfsUtils.getIPFSGatewayURL(metadata.documentURI);
            docPreview.innerHTML = `
                <img src="${docUrl}" class="img-fluid rounded border border-secondary" 
                     style="max-height: 300px; cursor: pointer;" 
                     onclick="window.open('${docUrl}', '_blank')" 
                     alt="Document de facture">
                <p class="text-center mt-2">
                    <a href="${docUrl}" target="_blank" class="text-orange">
                        <i class="bi bi-download"></i> Télécharger le document
                    </a>
                </p>
            `;
        } else {
            docPreview.innerHTML = '<p class="text-muted text-center">Aucun document disponible</p>';
        }
        
        // Activer/désactiver le bouton de remboursement
        const repayBtn = document.getElementById('repayFromDetailsBtn');
        const canRepay = await window.clientFunctions.canRepayInvoice(invoiceId);
        repayBtn.disabled = !canRepay.canRepay;
        
        // Afficher le modal
        const modal = new bootstrap.Modal(document.getElementById('invoiceDetailsModal'));
        modal.show();
        
    } catch (error) {
        console.error('Error showing invoice details:', error);
        window.uiUtils.showErrorAlert('Erreur lors du chargement des détails de la facture');
    }
}
</script>