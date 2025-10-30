<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
</head>
<body >

<div class="container-fluid px-0 py-5">
    <!-- Hero Section -->
    <div class="hero-section bg-gradient-primary py-6 py-lg-8">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold text-white mb-3">Tokenisez vos factures simplement</h1>
                    <p class="lead text-white-80 mb-4">
                        La première plateforme décentralisée de financement d'entreprises par tokenisation de créances.
                        Transformez vos factures en actifs liquides en quelques clics.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg px-4">
                            Commencer maintenant
                        </a>
                        <a href="#how-it-works" class="btn btn-outline-light btn-lg px-4">
                            Voir comment ça marche
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-illustration bg-white rounded p-4">
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <i class="fas fa-chart-line fa-5x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section py-4 bg-white">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="text-center">
                        <div class="display-5 fw-bold text-primary">25M€+</div>
                        <div class="text-muted">De factures tokenisées</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="text-center">
                        <div class="display-5 fw-bold text-primary">1,200+</div>
                        <div class="text-muted">Entreprises utilisatrices</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="text-center">
                        <div class="display-5 fw-bold text-primary">4.2%</div>
                        <div class="text-muted">Taux moyen avantageux</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="text-center">
                        <div class="display-5 fw-bold text-primary">24h</div>
                        <div class="text-muted">Délai moyen de financement</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-7 bg-light">
        <div class="container">
            <div class="text-center mb-6">
                <h2 class="fw-bold">Comment fonctionne notre plateforme</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">
                    Une solution simple en 3 étapes pour transformer vos factures en liquidités immédiates
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="icon-step bg-primary-light text-primary rounded-circle mx-auto mb-4">
                                <i class="fas fa-file-invoice fa-2x"></i>
                            </div>
                            <h4 class="mb-3">1. Déposez vos factures</h4>
                            <p class="text-muted">
                                Importez vos factures clients directement depuis votre ERP ou saisissez-les manuellement.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="icon-step bg-primary-light text-primary rounded-circle mx-auto mb-4">
                                <i class="fas fa-token fa-2x"></i>
                            </div>
                            <h4 class="mb-3">2. Tokenisation automatique</h4>
                            <p class="text-muted">
                                Nos smart contracts transforment vos factures en tokens sécurisés sur la blockchain.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="icon-step bg-primary-light text-primary rounded-circle mx-auto mb-4">
                                <i class="fas fa-coins fa-2x"></i>
                            </div>
                            <h4 class="mb-3">3. Financement immédiat</h4>
                            <p class="text-muted">
                                Recevez jusqu'à 90% du montant de vos factures en moins de 24 heures.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-7">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="bg-light rounded p-5 text-center">
                        <i class="fas fa-desktop fa-5x text-muted mb-4"></i>
                        <h3 class="h4">Interface intuitive</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Une plateforme complète pour votre trésorerie</h2>
                    <div class="feature-list">
                        <div class="d-flex mb-4">
                            <div class="me-4">
                                <i class="fas fa-check-circle text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Financement sans dilution</h5>
                                <p class="text-muted mb-0">
                                    Obtenez des liquidités sans céder de parts de votre entreprise.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="me-4">
                                <i class="fas fa-check-circle text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Taux compétitifs</h5>
                                <p class="text-muted mb-0">
                                    Bénéficiez de taux avantageux grâce à notre marché décentralisé.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="me-4">
                                <i class="fas fa-check-circle text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Suivi en temps réel</h5>
                                <p class="text-muted mb-0">
                                    Visualisez l'état de vos factures et le suivi des paiements.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-7 bg-light">
        <div class="container">
            <div class="text-center mb-6">
                <h2 class="fw-bold">Ils nous font confiance</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">
                    Des centaines d'entreprises ont déjà révolutionné leur gestion de trésorerie
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="mb-4">
                                "Grâce à cette solution, nous avons réduit notre BFR de 30 jours et pu investir dans notre croissance."
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-secondary me-3" style="width: 48px; height: 48px;"></div>
                                <div>
                                    <h6 class="mb-0">Pierre Martin</h6>
                                    <small class="text-muted">CEO, TechSolutions</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="mb-4">
                                "La simplicité d'utilisation et la rapidité de financement ont transformé notre gestion de trésorerie."
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-secondary me-3" style="width: 48px; height: 48px;"></div>
                                <div>
                                    <h6 class="mb-0">Sophie Lambert</h6>
                                    <small class="text-muted">Directrice Financière, GreenEnergy</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <p class="mb-4">
                                "En tant qu'investisseur, cette plateforme me permet de diversifier mon portefeuille avec des actifs réels."
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-secondary me-3" style="width: 48px; height: 48px;"></div>
                                <div>
                                    <h6 class="mb-0">Thomas Dubois</h6>
                                    <small class="text-muted">Investisseur institutionnel</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-7 bg-gradient-primary text-white">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-4">Prêt à révolutionner votre trésorerie ?</h2>
                    <p class="lead mb-5 opacity-75">
                        Rejoignez la première plateforme de tokenisation de factures et bénéficiez de liquidités immédiates.
                    </p>
                    <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg px-5 py-3">
                        Créer un compte gratuit
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .icon-step {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bg-primary-light {
        background-color: rgba(102, 126, 234, 0.1);
    }
    
    .hero-illustration {
        height: 300px;
        position: relative;
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
</style>

</body>
</html>
