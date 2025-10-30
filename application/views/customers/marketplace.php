<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $this->load->view('tpl/css_files'); ?>
    <style>
        body {
            background: #f8f9fa !important;
        }
        .market-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            padding: 2rem 1.5rem 1.5rem 1.5rem;
            margin-bottom: 2rem;
            min-height: 370px;
            transition: box-shadow 0.2s;
        }
        .market-card:hover {
            box-shadow: 0 4px 24px rgba(0,0,0,0.13);
        }
        .market-icon {
            color: #FFA500;
            margin-right: 6px;
        }
        .market-label {
            font-size: 1.1rem;
            color: #222;
            font-weight: 500;
        }
        .market-risk-low {
            color: #2ee59d;
            font-weight: bold;
        }
        .market-risk-medium {
            color: #FFD700;
            font-weight: bold;
        }
        .market-risk-high {
            color: #ff5858;
            font-weight: bold;
        }
        .market-progress {
            height: 7px;
            border-radius: 4px;
            background: #e9ecef;
            margin-bottom: 8px;
        }
        .market-progress-bar {
            height: 100%;
            border-radius: 4px;
            background: #FFD700;
        }
        .market-btn-yellow {
            background: #06A3DA;
            color: #fff;
            border: none;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.7rem 2rem;
            transition: background 0.2s;
        }
        .market-btn-yellow:hover {
            background: #e6a100;
            color: #fff;
        }
        .market-btn-black {
            background: #111;
            color: #fff;
            border: 1.5px solid #111;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.7rem 2rem;
            transition: background 0.2s, color 0.2s;
        }
        .market-btn-black:hover {
            background: #fff;
            color: #111;
        }
        .market-amount {
            font-size: 1.4rem;
            font-weight: bold;
            color: #111;
        }
        .market-yield {
            color: #2ee59d;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .market-stars {
            color: #FFD700;
            font-size: 1.1rem;
        }
        .market-stars-grey {
            color: #bbb;
        }
        .market-nft-image {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            margin-right: 8px;
            object-fit: cover;
            border: 2px solid #FFD600;
            box-shadow: 0 2px 8px rgba(255, 214, 0, 0.3);
        }
        .section-title {
            color: #111;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #FFD600;
            border-radius: 2px;
        }
    </style>
</head>
<body>
<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary m-1" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-dark m-1" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-secondary m-1" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Topbar Start -->
<div class="container-fluid bg-light ps-5 pe-0 d-none d-lg-block">
    <?php $this->load->view('tpl/header'); ?>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
    <?php 
      $data['page'] = 'marketplace';
      $this->load->view('tpl/menu'); 
    ?>
</nav>
<!-- Navbar End -->

<div class="container my-5">
    
    <h1 class="mb-4 fw-bold text-center" style="color:#111;">MarketPlace</h1>
    <p class="mb-5 text-center" style="font-size:1.1rem; color:#444;">
       Bienvenue sur notre MarketPlace ! Découvrez et investissez dans des pools sélectionnés, avec leurs secteurs, risques, rendements et avancements. Investissez en toute transparence et diversifiez votre portefeuille facilement.
    </p>
    
    <!-- Section Factures Uniques -->
    <h2 class="section-title mb-4">Factures Uniques</h2>
    <p>une facture unique désigne une créance commerciale individuelle émise par une entreprise à un client, qui peut être utilisée comme support pour obtenir un financement.</p>
    <div class="row g-4 mb-5">
        <!-- Card 1 -->
        <div class="col-md-6 col-lg-4 d-flex">
            <div class="market-card flex-fill p-0">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSqV7I24MMOxKLDHa3pjNiuF7Cku46fLGrCcg&s"
                     alt="Produit vedette"
                     style="width:100%; height:180px; object-fit:cover; border-top-left-radius:16px; border-top-right-radius:16px;">
                <div class="p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSqV7I24MMOxKLDHa3pjNiuF7Cku46fLGrCcg&s" alt="NFT Agro" class="market-nft-image" onerror="this.style.display='none'">
                            <span class="market-label">Pool Agro Juillet 2025</span>
                        </div>
                        <span class="market-stars">
                            <i class="fa fa-info-circle text-muted me-1"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star market-stars-grey"></i>
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="market-icon"><i class="fa fa-file-invoice"></i></span>Factures
                        <span class="ms-3 market-icon"><i class="fa fa-calendar"></i></span>Échéance: 30 jours
                    </div>
                    <div class="mb-2">
                        Secteur: Agriculture
                        <span class="ms-3">Risque: <span class="market-risk-low"><i class="fa fa-circle"></i> Faible</span></span>
                    </div>
                    <div class="mb-2">Financement complété</div>
                    <div class="market-progress mb-2">
                        <div class="market-progress-bar" style="width:75%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="text-muted" style="font-size:0.95rem;">Montant</div>
                            <div class="market-amount">5 000 000 FCFA</div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted" style="font-size:0.95rem;">Rendement estimé</div>
                            <div class="market-yield"><i class="fa fa-arrow-up"></i> 8.5%</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <button class="btn btn-blue flex-fill" onclick="window.location.href='<?php echo site_url('Auth'); ?>'">
    Investir
</button>

                       <!--  <button class="btn btn-blue flex-fill" data-bs-toggle="modal" data-bs-target="#investModal1">Investir</button> -->
                        <button class="btn btn-blue flex-fill" data-bs-toggle="modal" data-bs-target="#detailsModal1">Détails</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="col-md-6 col-lg-4 d-flex">
            <div class="market-card flex-fill p-0">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJ8d0MuYdBFcnRb6BvTaacHpERJ0qlWkBSpQ&s"
                     alt="Produit vedette"
                     style="width:100%; height:180px; object-fit:cover; border-top-left-radius:16px; border-top-right-radius:16px;">
                <div class="p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJ8d0MuYdBFcnRb6BvTaacHpERJ0qlWkBSpQ&s" alt="NFT Tech" class="market-nft-image" onerror="this.style.display='none'">
                            <span class="market-label">Pool Tech Solutions Q2</span>
                        </div>
                        <span class="market-stars">
                            <i class="fa fa-info-circle text-muted me-1"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star market-stars-grey"></i>
                            <i class="fa fa-star market-stars-grey"></i>
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="market-icon"><i class="fa fa-file-contract"></i></span>Bons de Commande
                        <span class="ms-3 market-icon"><i class="fa fa-calendar"></i></span>Échéance: 60 jours
                    </div>
                    <div class="mb-2">
                        Secteur: Technologies
                        <span class="ms-3">Risque: <span class="market-risk-medium"><i class="fa fa-circle"></i> Moyen</span></span>
                    </div>
                    <div class="mb-2">Financement complété</div>
                    <div class="market-progress mb-2">
                        <div class="market-progress-bar" style="width:45%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="text-muted" style="font-size:0.95rem;">Montant</div>
                            <div class="market-amount">12 500 000 FCFA</div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted" style="font-size:0.95rem;">Rendement estimé</div>
                            <div class="market-yield"><i class="fa fa-arrow-up"></i> 9.2%</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <button class="btn btn-blue flex-fill" onclick="window.location.href='<?php echo site_url('Auth'); ?>'">
    Investir
</button>

                        <!-- <button class="btn btn-blue flex-fill" data-bs-toggle="modal" data-bs-target="#investModal2">Investir</button> -->
                        <button class="btn btn-blue flex-fill" data-bs-toggle="modal" data-bs-target="#detailsModal2">Détails</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="col-md-6 col-lg-4 d-flex">
            <div class="market-card flex-fill p-0">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDa9dTJ4ICbyE7vAaWJGIx4HkkDGqBVJfoT7aLG0DI_4cBrxCOQ0nsqZ60j7ntI0crpFU&usqp=CAU"
                     alt="Produit vedette"
                     style="width:100%; height:180px; object-fit:cover; border-top-left-radius:16px; border-top-right-radius:16px;">
                <div class="p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDa9dTJ4ICbyE7vAaWJGIx4HkkDGqBVJfoT7aLG0DI_4cBrxCOQ0nsqZ60j7ntI0crpFU&usqp=CAU" alt="NFT Retail" class="market-nft-image" onerror="this.style.display='none'">
                            <span class="market-label">Pool Retail Express</span>
                        </div>
                        <span class="market-stars">
                            <i class="fa fa-info-circle text-muted me-1"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="market-icon"><i class="fa fa-file-invoice"></i></span>Factures
                        <span class="ms-3 market-icon"><i class="fa fa-calendar"></i></span>Échéance: 45 jours
                    </div>
                    <div class="mb-2">
                        Secteur: Commerce de détail
                        <span class="ms-3">Risque: <span class="market-risk-low"><i class="fa fa-circle"></i> Faible</span></span>
                    </div>
                    <div class="mb-2">Financement complété</div>
                    <div class="market-progress mb-2">
                        <div class="market-progress-bar" style="width:92%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="text-muted" style="font-size:0.95rem;">Montant</div>
                            <div class="market-amount">3 800 000 FCFA</div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted" style="font-size:0.95rem;">Rendement estimé</div>
                            <div class="market-yield"><i class="fa fa-arrow-up"></i> 7.8%</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <button class="btn btn-blue flex-fill" onclick="window.location.href='<?php echo site_url('Auth'); ?>'">
    Investir
</button>

                        <!-- <button class="btn btn-blue flex-fill" data-bs-toggle="modal" data-bs-target="#investModal3">Investir</button> -->
                        <button class="btn btn-blue flex-fill" data-bs-toggle="modal" data-bs-target="#detailsModal3">Détails</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Fin row factures uniques -->

    <!-- Section Factures Groupées -->
    <h2 class="section-title mb-4">Factures Groupées</h2>
    <p>une facture groupée est une facture qui regroupe plusieurs ventes ou prestations effectuées pour un même client sur une période donnée, afin de ne lui envoyer qu’un seul document de paiement.</p>
    <div class="row g-4 mb-5">
        <!-- Card Facture groupée : Pool d'affacturage -->
        <div class="col-md-6 col-lg-4 d-flex">
            <div class="market-card flex-fill p-0">
                <img src="https://img.freepik.com/free-photo/stack-bills-receipts-invoice-concept_53876-133948.jpg"
                     alt="Facture groupée"
                     style="width:100%; height:180px; object-fit:cover; border-top-left-radius:16px; border-top-right-radius:16px;">
                <div class="p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="NFT Group" class="market-nft-image" onerror="this.style.display='none'">
                            <span class="market-label">Facture groupée : Pool d'affacturage</span>
                        </div>
                        <span class="market-stars">
                            <i class="fa fa-info-circle text-muted me-1"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="market-icon"><i class="fa fa-layer-group"></i></span>Factures groupées
                        <span class="ms-3 market-icon"><i class="fa fa-calendar"></i></span>Échéance: 90 jours
                    </div>
                    <div class="mb-2">
                        Secteur: Multi-secteurs
                        <span class="ms-3">Risque: <span class="market-risk-low"><i class="fa fa-circle"></i> Faible</span></span>
                    </div>
                    <div class="mb-2">Financement complété</div>
                    <div class="market-progress mb-2">
                        <div class="market-progress-bar" style="width:68%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="text-muted" style="font-size:0.95rem;">Montant</div>
                            <div class="market-amount">25 000 000 FCFA</div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted" style="font-size:0.95rem;">Rendement estimé</div>
                            <div class="market-yield"><i class="fa fa-arrow-up"></i> 6.8%</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <button class="btn btn-blue flex-fill" data-bs-toggle="modal" data-bs-target="#investModal4">Investir</button>
                        <button class="btn btn-blue flex-fill" data-bs-toggle="modal" data-bs-target="#detailsModal4">Détails</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Fin row factures groupées -->

    <!-- Carte produit style Alibaba -->
  

    <!-- Pourquoi choisir CoinFinance ? -->
    <div class="container my-5">
        <div style="background:#fff; border-radius:18px; box-shadow:0 2px 16px rgba(0,0,0,0.08); padding:36px 18px 28px 18px;">
            <h2 class="text-center mb-2" style="color:#111; font-weight:800; font-size:1.7rem;">Pourquoi choisir CoinFinance ?</h2>
            <div class="text-center mb-4" style="color:#06A3DA; font-size:1.1rem;">Les avantages de notre plateforme Web3</div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div style="background:#f8f9fa; border-radius:14px; padding:28px 18px; text-align:center; box-shadow:0 1px 8px rgba(0,0,0,0.04);">
                        <div style="display:flex; justify-content:center; align-items:center; margin-bottom:18px;">
                            <span style="background:linear-gradient(135deg,#7b2ff2,#f357a8); color:#fff; border-radius:50%; width:56px; height:56px; display:flex; align-items:center; justify-content:center; font-size:2rem; box-shadow:0 0 12px #7b2ff255;">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                        <div style="color:#232e3e; font-size:1.15rem; font-weight:700; margin-bottom:8px;">Sélection Rigoureuse</div>
                        <div style="color:#444; font-size:1rem;">Toutes les créances sont vérifiées et analysées par nos experts avec des algorithmes avancés</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="background:#f8f9fa; border-radius:14px; padding:28px 18px; text-align:center; box-shadow:0 1px 8px rgba(0,0,0,0.04);">
                        <div style="display:flex; justify-content:center; align-items:center; margin-bottom:18px;">
                            <span style="background:linear-gradient(135deg,#1de9b6,#1dc4e9); color:#fff; border-radius:50%; width:56px; height:56px; display:flex; align-items:center; justify-content:center; font-size:2rem; box-shadow:0 0 12px #1de9b655;">
                                <i class="fa fa-random"></i>
                            </span>
                        </div>
                        <div style="color:#232e3e; font-size:1.15rem; font-weight:700; margin-bottom:8px;">Diversification</div>
                        <div style="color:#444; font-size:1rem;">Accès à un large éventail de créances de différents secteurs pour optimiser votre portefeuille</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="background:#f8f9fa; border-radius:14px; padding:28px 18px; text-align:center; box-shadow:0 1px 8px rgba(0,0,0,0.04);">
                        <div style="display:flex; justify-content:center; align-items:center; margin-bottom:18px;">
                            <span style="background:linear-gradient(135deg,#FFD600,#ff9800); color:#fff; border-radius:50%; width:56px; height:56px; display:flex; align-items:center; justify-content:center; font-size:2rem; box-shadow:0 0 12px #FFD60055;">
                                <i class="fa fa-bolt"></i>
                            </span>
                        </div>
                        <div style="color:#232e3e; font-size:1.15rem; font-weight:700; margin-bottom:8px;">Technologie Web3</div>
                        <div style="color:#444; font-size:1rem;">Transparence et sécurité grâce à la blockchain, smart contracts audités</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modals Détails -->
<div class="modal fade" id="detailsModal1" tabindex="-1" aria-labelledby="detailsModal1Label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModal1Label">Détails - Pool Agro Juillet 2025</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <!-- Détails projet à gauche -->
            <div class="col-md-6">
            <div style="font-weight:bold;margin-bottom:8px;">PME</div>
                <ul>
                    <li>Type de financement : Factures</li>
                    <li>Échéance : 30 jours</li>
                    <li>Secteur : Agriculture</li>
                    <li>Montant total : 5 000 000 FCFA</li>
                    <li>Rendement estimé : 8.5%</li>
                    <li>Risque : Faible</li>
                    <li>Avancement : 75% financé</li>
                </ul>
            </div>
            <!-- Détails débiteur à droite -->
            <div class="col-md-6">
                <div style="font-weight:bold;margin-bottom:8px;">Débiteur</div>
                <ul>
                    <li>Nom : Société Agricole du Nord</li>
                    <li>Secteur : Agriculture</li>
                    <li>Contact : contact@societeagronord.com</li>
                    <!-- Ajoute ici logo ou autre info si tu veux -->
                </ul>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="detailsModal2" tabindex="-1" aria-labelledby="detailsModal2Label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModal2Label">Détails - Pool Tech Solutions Q2</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <!-- Détails projet à gauche -->
            <div class="col-md-6">
            <div style="font-weight:bold;margin-bottom:8px;">PME</div>
                <ul>
                    <li>Type de financement : Bons de Commande</li>
                    <li>Échéance : 60 jours</li>
                    <li>Secteur : Technologies</li>
                    <li>Montant total : 12 500 000 FCFA</li>
                    <li>Rendement estimé : 9.2%</li>
                    <li>Risque : Moyen</li>
                    <li>Avancement : 45% financé</li>
                </ul>
            </div>
            <!-- Détails débiteur à droite -->
            <div class="col-md-6">
                <div style="font-weight:bold;margin-bottom:8px;">Débiteur</div>
                <ul>
                    <li>Nom : Tech Innov SARL</li>
                    <li>Secteur : Technologies</li>
                    <li>Contact : contact@techinnov.com</li>
                    <!-- Ajoute ici logo ou autre info si tu veux -->
                </ul>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="detailsModal3" tabindex="-1" aria-labelledby="detailsModal3Label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModal3Label">Détails - Pool Retail Express</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <!-- Détails projet à gauche -->
            <div class="col-md-6">
            <div style="font-weight:bold;margin-bottom:8px;">PME</div>
                <ul>
                    <li>Type de financement : Factures</li>
                    <li>Échéance : 45 jours</li>
                    <li>Secteur : Commerce de détail</li>
                    <li>Montant total : 3 800 000 FCFA</li>
                    <li>Rendement estimé : 7.8%</li>
                    <li>Risque : Faible</li>
                    <li>Avancement : 92% financé</li>
                </ul>
            </div>
            <!-- Détails débiteur à droite -->
            <div class="col-md-6">
                <div style="font-weight:bold;margin-bottom:8px;">Débiteur</div>
                <ul>
                    <li>Nom : Retail Express Côte d'Ivoire</li>
                    <li>Secteur : Commerce de détail</li>
                    <li>Contact : contact@retailexpress.ci</li>
                    <!-- Ajoute ici logo ou autre info si tu veux -->
                </ul>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="detailsModal4" tabindex="-1" aria-labelledby="detailsModal4Label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModal4Label">Détails - Facture groupée : Pool d'affacturage</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <!-- Détails projet à gauche -->
            <div class="col-md-6">
            <div style="font-weight:bold;margin-bottom:8px;">PME</div>
                <ul>
                    <li>Type de financement : Factures groupées</li>
                    <li>Échéance : 90 jours</li>
                    <li>Secteur : Multi-secteurs</li>
                    <li>Montant total : 25 000 000 FCFA</li>
                    <li>Rendement estimé : 6.8%</li>
                    <li>Risque : Faible</li>
                    <li>Avancement : 68% financé</li>
                </ul>
            </div>
            <!-- Détails débiteur à droite -->
            <div class="col-md-6">
                <div style="font-weight:bold;margin-bottom:8px;">Débiteurs</div>
                <ul>
                    <li>Pool de 15 PME diversifiées</li>
                    <li>Secteurs : Agriculture, Commerce, Services</li>
                    <li>Contact : contact@coinfinance.ci</li>
                    <!-- Ajoute ici logo ou autre info si tu veux -->
                </ul>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<!-- Modals Investir -->
<div class="modal fade" id="investModal1" tabindex="-1" aria-labelledby="investModal1Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="investModal1Label">Investir - Pool Agro Juillet 2025</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>Vous souhaitez investir dans le pool <strong>Agro Juillet 2025</strong> ?<br>
        Montant minimum conseillé : <strong>100 000 FCFA</strong></p>
        <form>
          <div class="mb-3">
            <label for="investAmount1" class="form-label">Montant à investir (FCFA)</label>
            <input type="number" class="form-control" id="investAmount1" min="100000" placeholder="Entrez le montant">
          </div>
          <button type="submit" class="btn btn-blue">Valider l'investissement</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="investModal2" tabindex="-1" aria-labelledby="investModal2Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="investModal2Label">Investir - Pool Tech Solutions Q2</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>Vous souhaitez investir dans le pool <strong>Tech Solutions Q2</strong> ?<br>
        Montant minimum conseillé : <strong>200 000 FCFA</strong></p>
        <form>
          <div class="mb-3">
            <label for="investAmount2" class="form-label">Montant à investir (FCFA)</label>
            <input type="number" class="form-control" id="investAmount2" min="200000" placeholder="Entrez le montant">
          </div>
          <button type="submit" class="btn btn-blue">Valider l'investissement</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="investModal3" tabindex="-1" aria-labelledby="investModal3Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="investModal3Label">Investir - Pool Retail Express</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>Vous souhaitez investir dans le pool <strong>Retail Express</strong> ?<br>
        Montant minimum conseillé : <strong>50 000 FCFA</strong></p>
        <form>
          <div class="mb-3">
            <label for="investAmount3" class="form-label">Montant à investir (FCFA)</label>
            <input type="number" class="form-control" id="investAmount3" min="50000" placeholder="Entrez le montant">
          </div>
          <button type="submit" class="btn btn-blue">Valider l'investissement</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="investModal4" tabindex="-1" aria-labelledby="investModal4Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="investModal4Label">Investir - Facture groupée : Pool d'affacturage</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>Vous souhaitez investir dans le pool <strong>Facture groupée : Pool d'affacturage</strong> ?<br>
        Montant minimum conseillé : <strong>500 000 FCFA</strong></p>
        <form>
          <div class="mb-3">
            <label for="investAmount4" class="form-label">Montant à investir (FCFA)</label>
            <input type="number" class="form-control" id="investAmount4" min="500000" placeholder="Entrez le montant">
          </div>
          <button type="submit" class="btn btn-blue">Valider l'investissement</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('tpl/footer'); ?>
<?php $this->load->view('tpl/js_files'); ?>
</body>
</html> 