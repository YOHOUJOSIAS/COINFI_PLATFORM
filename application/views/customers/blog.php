<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $this->load->view('tpl/css_files'); ?>
    <style>
        body {
            background: #fff !important;
        }
        .blog-card {
            background: #111 !important;
            color: #fff !important;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .blog-card * {
            color: #fff !important;
        }
        .bi, .fa {
            color: #FFD700 !important;
        }
        .blog-header-img {
            max-height: 120px;
        }
        .blog-meta {
            font-size: 0.95em;
            color: #FFD700 !important;
        }
        .btn-primary {
            background: #FFD700 !important;
            color: #111 !important;
            border: none;
        }
        .btn-primary:hover {
            background: #e6c200 !important;
            color: #111 !important;
        }
    </style>
</head>
<body>
<div class="container-fluid bg-light ps-5 pe-0 d-none d-lg-block">
<?php $this->load->view('tpl/header'); ?>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
<?php 
  $data['page'] = 'blogs';
  $this->load->view('tpl/menu'); 
?>
</nav>
<!-- Navbar End -->
    <!-- Header avec image -->
    <div class="container-fluid bg-primary py-5 hero-header mb-5">
        <div class="row py-3">
            <div class="col-12 text-center">
                <!-- <img src="<?php echo base_url('assets/img/lop.jpg'); ?>" alt="Blog CoinFinance" class="img-fluid animated zoomIn blog-header-img"> -->
                <h1 class="display-5 text-white mt-3">Blog & Ressources CoinFinance</h1>
                <p class="text-white">Actualités, éducation et insights sur la finance décentralisée</p>
            </div>
        </div>
    </div>
    <!-- Blog Content -->
    <div class="container">
        <div class="row justify-content-center">
            <!-- Article vedette sur toute la largeur -->
            <div class="col-12">
                <div class="blog-card p-4 mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-rocket fa-2x me-2"></i>
                        <span class="badge bg-primary">Article en vedette</span>
                    </div>
                    <h2 class="fw-bold">L'avenir de la tokenisation des factures : Révolution Web3</h2>
                    <p>Découvrez comment la tokenisation transforme le financement des PME et démocratise l'accès à la liquidité.</p>
                    <div class="blog-meta mb-2">
                        <i class="fa fa-user me-1"></i> Marie Dubois
                        <i class="fa fa-calendar ms-3 me-1"></i> 15/01/2024
                        <i class="fa fa-clock ms-3 me-1"></i> 5 min de lecture
                    </div>
                    <a href="https://www.idenfy.com/blog/rwa-tokenization-kyc/" class="btn btn-primary mt-2">Lire l'article <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Article 1 -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="blog-card p-4 flex-fill">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-robot fa-2x me-2"></i>
                        <span class="badge bg-secondary">IA & Technologie</span>
                    </div>
                    <h4>Intelligence Artificielle et Évaluation des Risques</h4>
                    <p>Comment notre IA analyse plus de 50 facteurs pour évaluer le risque de chaque facture en temps réel.</p>
                    <div class="blog-meta mb-2">
                        <i class="fa fa-user me-1"></i> Dr. Jean Martin
                        <i class="fa fa-clock ms-3 me-1"></i> 7 min
                    </div>
                    <a href="https://www.comparateurbanque.com/meilleurs-placements/cryptomonnaies-defi-nft/implications-chatgpt-ia-fintech-et-banque/" class="btn btn-primary btn-sm">Lire <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <!-- Article 2 -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="blog-card p-4 flex-fill">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-book fa-2x me-2"></i>
                        <span class="badge bg-success">Éducation</span>
                    </div>
                    <h4>Guide Complet : Investir dans les Factures Tokenisées</h4>
                    <p>Tout ce que vous devez savoir pour commencer à investir dans les factures tokenisées en toute sécurité.</p>
                    <div class="blog-meta mb-2">
                        <i class="fa fa-user me-1"></i> Sophie Chen
                        <i class="fa fa-clock ms-3 me-1"></i> 10 min
                    </div>
                    <a href="https://www.coinhouse.com/fr/blog/actualites/crypto-ai-2024" class="btn btn-primary btn-sm">Lire <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <!-- Article 3 (exemple supplémentaire) -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="blog-card p-4 flex-fill">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-lightbulb fa-2x me-2"></i>
                        <span class="badge bg-warning text-dark">Innovation</span>
                    </div>
                    <h4>Blockchain et Transparence Financière</h4>
                    <p>La blockchain révolutionne la traçabilité et la sécurité des transactions pour les entreprises.</p>
                    <div class="blog-meta mb-2">
                        <i class="fa fa-user me-1"></i> Amadou Diop
                        <i class="fa fa-clock ms-3 me-1"></i> 8 min
                    </div>
                    <a href="#" class="btn btn-primary btn-sm">Lire <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <!-- Article Blockchain -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="blog-card p-4 flex-fill">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-moon fa-2x me-2"></i>
                        <span class="badge bg-info text-dark">Blockchain</span>
                    </div>
                    <h4>Moonbeam et l'Écosystème DeFi : Pourquoi ce Choix ?</h4>
                    <p>Les avantages techniques et économiques de notre intégration avec la blockchain Moonbeam.</p>
                    <div class="blog-meta mb-2">
                        Alex Thompson &bull; 6 min
                    </div>
                    <a href="https://journalducoin.com/actualites/chatgpt-fausses-crypto-scams/" class="btn btn-primary btn-sm">Lire <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <!-- Article Sécurité -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="blog-card p-4 flex-fill">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-shield-alt fa-2x me-2"></i>
                        <span class="badge bg-primary">Sécurité</span>
                    </div>
                    <h4>Détection de Fraude : Notre Approche Multi-Couches</h4>
                    <p>Plongée dans notre système de détection de fraude basé sur l'IA et les smart contracts.</p>
                    <div class="blog-meta mb-2">
                        Dr. Lisa Wang &bull; 8 min
                    </div>
                    <a href="https://journalducoin.com/actualites/victime-arnaque-crypto-faire-savoir/" class="btn btn-primary btn-sm">Lire <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <!-- Article Conformité -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="blog-card p-4 flex-fill">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-balance-scale fa-2x me-2"></i>
                        <span class="badge bg-secondary">Conformité</span>
                    </div>
                    <h4>Conformité KYC/AML : Automatisation et Efficacité</h4>
                    <p>Comment nous automatisons les processus de conformité tout en maintenant les plus hauts standards.</p>
                    <div class="blog-meta mb-2">
                        Pierre Moreau &bull; 5 min
                    </div>
                    <a href="http://www.revue-banque.fr/management-fonctions-supports/article/intelligence-artificielle-dans-kyc-quels-benefices" class="btn btn-primary btn-sm">Lire <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ Section -->
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="blog-card p-4">
                    <h2 class="text-center mb-4">Foire Aux Questions</h2>
                    <div class="accordion accordion-flush" id="faqAccordion">
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                    Comment fonctionne la tokenisation de créances ?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    La tokenisation transforme une créance en un actif numérique échangeable sur la blockchain.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    Quels sont les frais appliqués ?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Des frais de gestion de 2% sont prélevés sur chaque transaction.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    Comment sont sélectionnées les créances ?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Les créances sont sélectionnées selon des critères stricts de solvabilité et de conformité.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="faq4">
                                <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    Quels sont les risques pour les investisseurs ?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Comme tout investissement, il existe un risque de défaut de paiement de la part du débiteur.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="faq5">
                                <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    Comment récupérer mes gains ?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Vos gains sont crédités sur votre portefeuille et peuvent être retirés à tout moment.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="faq6">
                                <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                    La plateforme est-elle régulée ?
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="faq6" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Oui, la plateforme est enregistrée auprès des autorités compétentes et respecte la réglementation en vigueur.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php $this->load->view('tpl/footer'); ?>
    <?php $this->load->view('tpl/js_files'); ?>
</body>
</html> 