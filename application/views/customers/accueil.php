<!DOCTYPE html>
<html lang="fr">

<head>
    <?php $this->load->view('tpl/css_files'); ?>
    <style>
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
         .btn-yellow {
            background: #FFD600;
            color: #222;
            border: none;
            font-weight: bold;
        }
        .btn-yellow:hover {
            background: #fff;
            color: #FFD600;
            border: 2px solid #FFD600;
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
          $data['page'] = 'index';
          $this->load->view('tpl/menu'); 
        ?>
    </nav>
    <!-- Navbar End -->


    <!-- Full Screen Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="background: rgba(9, 30, 62, .7);">
                <div class="modal-header border-0">
                    <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <div class="input-group" style="max-width: 600px;">
                        <input type="text" class="form-control bg-transparent border-primary p-3" placeholder="Type search keyword">
                        <button class="btn btn-primary px-4"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Full Screen Search End -->


<!-- Carousel Start -->
<div class="container-fluid p-0">
<div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
<div class="carousel-inner">
    <div class="carousel-item active">
        <img class="w-100" src="<?php echo bowers_url('img/lop.jpg'); ?>" alt="Image">
        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
            <div class="p-3" style="max-width: 900px;">
            <h1 class="display-1 text-white mb-md-4 animated zoomIn">Transformez vos créances en liquidité immédiate</h1>
            <p style="font-size: 1.5rem; color: #fff;">CoinFinance offre aux PME une solution rapide pour transformer leurs bons de commande et factures en trésorerie, et aux investisseurs un accès à des pools de créances diversifiés grâce à notre plateforme Web3.</p>

                <a href="<?php echo site_url('#'); ?>" class="btn btn-blue py-md-3 px-md-5 me-3 animated slideInLeft" <?php if(!empty($this->session->userdata('numero_telephone'))) echo 'style="display : none;"'; ?>>CLIQUER POUR VOIR PLUS !</a>

                <a href="<?php echo site_url('MonCompte/prendreRendezVous'); ?>" class="btn btn-blue py-md-3 px-md-5 me-3 animated slideInLeft" <?php if(empty($this->session->userdata('numero_telephone'))) echo 'style="display : none;"'; ?>>CLIQUER POUR VOUS INSCRIRE !</a>

            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- Carousel End -->

<!-- Statistiques Start -->
<div class="container-fluid py-5" style="background: #181f2a;">
    <div class="container d-flex flex-column align-items-center justify-content-center">
        <h2 class="mb-4" style="color:#FFD600; font-weight:800; font-size:2.2rem;">Découvrez CoinFinance en vidéo</h2>
        <p class="mb-4" style="color:#fff; font-size:1.15rem; max-width:600px; text-align:center;">
            Visionnez notre vidéo de présentation pour comprendre comment CoinFinance révolutionne le financement des PME grâce à la tokenisation et à la technologie Web3.
        </p>
        <a href="https://www.youtube.com/watch?v=VY72jR1406M" target="_blank" class="btn btn-blue" style="text-decoration:none;">
            <div style="border-radius:16px; padding:18px 38px; display:flex; align-items:center; gap:16px; box-shadow:0 2px 16px rgba(0,0,0,0.10); transition:background 0.2s; background:none;">
                <i class="fa fa-play-circle" style="font-size:2.5rem; color:#fff;"></i>
                <span style="font-size:1.3rem; font-weight:700;">Voir la vidéo de présentation</span>
            </div>
        </a>
    </div>
</div>
<!-- Statistiques End -->

<!-- Comment ça marche Start -->
<div class="container-fluid py-5" style="background: #fff;">
    <div class="container">
        <h2 class="text-center mb-3" style="color: black; font-size: 2.8rem; font-weight: 800;">Comment ça marche ?</h2>
        <p class="text-center mb-5" style="font-size: 1.2rem; color: #222;">Un processus simple et sécurisé en 4 étapes pour transformer vos créances en liquidité</p>
        <div class="row g-4 justify-content-center">
            <div class="col-md-3">
                <div style="border:1.5px solid #FFD600; border-radius:12px; background:#fff; text-align:center; padding:32px 16px; position:relative; min-height:270px;">
                    <div style="position:absolute; top:18px; right:18px; background:#FFD600; color:#222; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.2rem; box-shadow:0 0 12px #FFD60055;">1</div>
                    <div style="font-size:2.5rem; margin-bottom:10px;">📄</div>
                    <div style="color:black; font-size:1.2rem; font-weight:bold; margin-bottom:10px;">Soumission de créance</div>
                    <div style="color:#222; font-size:1rem;">Les PME soumettent leurs factures ou bons de commande sur la plateforme</div>
                </div>
            </div>
            <div class="col-md-3">
                <div style="border:1.5px solid #FFD600; border-radius:12px; background:#fff; text-align:center; padding:32px 16px; position:relative; min-height:270px;">
                    <div style="position:absolute; top:18px; right:18px; background:#FFD600; color:#222; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.2rem; box-shadow:0 0 12px #FFD60055;">2</div>
                    <div style="font-size:2.5rem; margin-bottom:10px;">🔍</div>
                    <div style="color:black; font-size:1.2rem; font-weight:bold; margin-bottom:10px;">Vérification & Tokenisation</div>
                    <div style="color:#222; font-size:1rem;">Nos algorithmes vérifient la créance et la transforment en token ERC-1155</div>
                </div>
            </div>
            <div class="col-md-3">
                <div style="border:1.5px solid #FFD600; border-radius:12px; background:#fff; text-align:center; padding:32px 16px; position:relative; min-height:270px;">
                    <div style="position:absolute; top:18px; right:18px; background:#FFD600; color:#222; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.2rem; box-shadow:0 0 12px #FFD60055;">3</div>
                    <div style="font-size:2.5rem; margin-bottom:10px;">🏪</div>
                    <div style="color:black; font-size:1.2rem; font-weight:bold; margin-bottom:10px;">Mise sur le marché</div>
                    <div style="color:#222; font-size:1rem;">Le token est proposé aux investisseurs avec toutes les informations nécessaires</div>
                </div>
            </div>
            <div class="col-md-3">
                <div style="border:1.5px solid #FFD600; border-radius:12px; background:#fff; text-align:center; padding:32px 16px; position:relative; min-height:270px;">
                    <div style="position:absolute; top:18px; right:18px; background:#FFD600; color:#222; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.2rem; box-shadow:0 0 12px #FFD60055;">4</div>
                    <div style="font-size:2.5rem; margin-bottom:10px;">💰</div>
                    <div style="color:black; font-size:1.2rem; font-weight:bold; margin-bottom:10px;">Investissement & Rendement</div>
                    <div style="color:#222; font-size:1rem;">Les investisseurs achètent les tokens et reçoivent les remboursements automatiquement</div>
                </div>
            </div>
        </div>
    </div>
</div>
 <div class="text-center mt-5">
            <a href="<?php echo site_url('Accueil/marche'); ?>" class="btn btn-blue btn-lg" style="font-weight: 700; padding: 1rem 3rem; border-radius: 12px; border: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(7, 64, 106, 0.15);">
                <i class="fa fa-arrow-right me-2"></i>Voir plus
            </a>
        </div>
<!-- Comment ça marche End -->

<!-- Intelligence Artificielle Intégrée Start -->
<div style="background:#fff; padding:60px 0;">
  <div class="container">
    <h2 class="text-center mb-5" style="color:#222; font-size:2.4rem; font-weight:800;">
      Comment CoinFinance fonctionne pour vous
    </h2>
    <div class="row justify-content-center g-4">
      <!-- PME -->
      <div class="col-md-4">
        <div style="background:#232e3e; border-radius:16px; padding:32px 24px; color:#fff; min-height:340px;">
          <div style="display:flex; align-items:center; justify-content:center; margin-bottom:18px;">
            <span style="background:#FFD600; color:#232e3e; border-radius:50%; width:48px; height:48px; display:flex; align-items:center; justify-content:center; font-size:2rem;">
              <i class="fas fa-file"></i>
            </span>
          </div>
          <h4 style="color:#FFD600; font-weight:700; text-align:center;">Pour les PME</h4>
          <ol style="margin-top:18px; padding-left:18px;">
            <li>Soumettez votre facture sur CoinFinance</li>
            <li>Elle est transformée en actif numérique (NFT)</li>
            <li>Recevez des fonds rapidement via notre réseau d’investisseurs</li>
          </ol>
        </div>
      </div>
      <!-- Investisseurs -->
      <div class="col-md-4">
        <div style="background:#232e3e; border-radius:16px; padding:32px 24px; color:#fff; min-height:340px;">
          <div style="display:flex; align-items:center; justify-content:center; margin-bottom:18px;">
            <span style="background:#FFD600; color:#232e3e; border-radius:50%; width:48px; height:48px; display:flex; align-items:center; justify-content:center; font-size:2rem;">
              <i class="fas-user-tie"></i>
            </span>
          </div>
          <h4 style="color:#FFD600; font-weight:700; text-align:center;">Pour les investisseurs</h4>
          <ol style="margin-top:18px; padding-left:18px;">
            <li>Accédez à des factures tokenisées vérifiées</li>
            <li>Investissez via stablecoins dans des actifs à faible risque</li>
            <li>Profitez de rendements transparents</li>
          </ol>
        </div>
      </div>
      <!-- Débiteurs -->
      <div class="col-md-4">
        <div style="background:#232e3e; border-radius:16px; padding:32px 24px; color:#fff; min-height:340px;">
          <div style="display:flex; align-items:center; justify-content:center; margin-bottom:18px;">
            <span style="background:#FFD600; color:#232e3e; border-radius:50%; width:48px; height:48px; display:flex; align-items:center; justify-content:center; font-size:2rem;">
              <i class="fa fa-user-friends"></i>
            </span>
          </div>
          <h4 style="color:#FFD600; font-weight:700; text-align:center;">Pour les débiteurs</h4>
          <ol style="margin-top:18px; padding-left:18px;">
            <li>Vos factures sont financées sans impact sur votre trésorerie</li>
            <li>Remboursez via des contrats automatisés sécurisés</li>
            <li>Gagnez en flexibilité</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="text-center mt-5">
            <a href="<?php echo site_url('Accueil/marche'); ?>" class="btn btn-blue btn-lg" style="font-weight: 700; padding: 1rem 3rem; border-radius: 12px; border: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(86, 106, 7, 0.15);">
                <i class="fa fa-arrow-right me-2"></i>Voir plus
            </a>
        </div>
<!-- Intelligence Artificielle Intégrée End -->

<!-- Avantages Plateforme Start -->
<div class="container-fluid py-5" style="background: #fff;">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-3">
                <div style="border:1.5px solid #FFD600; border-radius:12px; background:#181f2a; text-align:left; padding:32px 24px; min-height:270px; color:#fff; position:relative;">
                    <div style="position:relative; margin-bottom:18px;">
                        <span style="background:#FFD600; color:#181818; border-radius:12px; width:56px; height:56px; display:inline-flex; align-items:center; justify-content:center; font-size:2rem; box-shadow:0 0 18px #FFD60055;"><i class="fa fa-line-chart"></i></span>
                    </div>
                    <div style="color:#fff; font-size:1.2rem; font-weight:700; margin-bottom:10px;">Transformez vos créances en liquidité immédiate</div>
                    <div style="color:#fff; font-size:1rem;">Convertissez vos bons de commande et factures en tokens</div>
                </div>
            </div>
            <div class="col-md-3">
                <div style="border:1.5px solid #FFD600; border-radius:12px; background:#181f2a; text-align:left; padding:32px 24px; min-height:270px; color:#fff; position:relative;">
                    <div style="position:relative; margin-bottom:18px;">
                        <span style="background:#FFD600; color:#181818; border-radius:12px; width:56px; height:56px; display:inline-flex; align-items:center; justify-content:center; font-size:2rem; box-shadow:0 0 18px #FFD60055;"><i class="fa fa-shield"></i></span>
                    </div>
                    <div style="color:#fff; font-size:1.2rem; font-weight:700; margin-bottom:10px;">Sécurité Maximale</div>
                    <div style="color:#fff; font-size:1rem;">Smart contracts audités et processus sécurisés pour protéger vos investissements</div>
                </div>
            </div>
            <div class="col-md-3">
                <div style="border:1.5px solid #FFD600; border-radius:12px; background:#181f2a; text-align:left; padding:32px 24px; min-height:270px; color:#fff; position:relative;">
                    <div style="position:relative; margin-bottom:18px;">
                        <span style="background:#FFD600; color:#181818; border-radius:12px; width:56px; height:56px; display:inline-flex; align-items:center; justify-content:center; font-size:2rem; box-shadow:0 0 18px #FFD60055;"><i class="fa fa-bolt"></i></span>
                    </div>
                    <div style="color:#fff; font-size:1.2rem; font-weight:700; margin-bottom:10px;">Liquidité Instantanée</div>
                    <div style="color:#fff; font-size:1rem;">Accédez à vos fonds immédiatement grâce à notre réseau d'investisseurs</div>
                </div>
            </div>
            <div class="col-md-3">
                <div style="border:1.5px solid #FFD600; border-radius:12px; background:#181f2a; text-align:left; padding:32px 24px; min-height:270px; color:#fff; position:relative;">
                    <div style="position:relative; margin-bottom:18px;">
                        <span style="background:#FFD600; color:#181818; border-radius:12px; width:56px; height:56px; display:inline-flex; align-items:center; justify-content:center; font-size:2rem; box-shadow:0 0 18px #FFD60055;"><i class="fa fa-globe"></i></span>
                    </div>
                    <div style="color:#fff; font-size:1.2rem; font-weight:700; margin-bottom:10px;">Écosystème Web3</div>
                    <div style="color:#fff; font-size:1rem;">Plateforme décentralisée sur Moonbeam avec paiements USDT</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Avantages Plateforme End -->

<!-- Technologie Web3 Avancée Start -->
<div class="container-fluid py-5" style="display:none">
    <div class="container">
        <div style="border:2px solid #181f2a; border-radius:28px; background:#181f2a; padding:48px 32px;">
            <h2 class="text-center mb-3" style="color: #fff; font-size: 3rem; font-weight: 800;">Technologie Web3 Avancée</h2>
            <p class="text-center mb-5" style="font-size: 1.3rem; color: #fff;">Notre plateforme utilise les dernières innovations blockchain pour offrir transparence, sécurité et efficacité dans la tokenisation de créances.</p>
            <div class="row g-5 justify-content-center">
                <div class="col-md-4 text-center">
                    <div style="display:flex; flex-direction:column; align-items:center;">
                        <div style="background:#181f2a; border-radius:50%; width:100px; height:100px; display:flex; align-items:center; justify-content:center; margin-bottom:18px; box-shadow:0 0 24px #FFD60055;">
                            <span style="font-size:2.5rem; color:#FFD600;"><i class="fa fa-bolt"></i></span>
                        </div>
                        <div style="color:#fff; font-size:1.3rem; font-weight:700; margin-bottom:10px;">Smart Contracts</div>
                        <div style="color:#fff; font-size:1.05rem;">Contrats intelligents ERC-1155 audités sur Moonbeam</div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div style="display:flex; flex-direction:column; align-items:center;">
                        <div style="background:#181f2a; border-radius:50%; width:100px; height:100px; display:flex; align-items:center; justify-content:center; margin-bottom:18px; box-shadow:0 0 24px #FFD60055;">
                            <span style="font-size:2.5rem; color:#FFD600;"><i class="fa fa-lock"></i></span>
                        </div>
                        <div style="color:#fff; font-size:1.3rem; font-weight:700; margin-bottom:10px;">Sécurité Renforcée</div>
                        <div style="color:#fff; font-size:1.05rem;">Processus de vérification et audits de sécurité continus</div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div style="display:flex; flex-direction:column; align-items:center;">
                        <div style="background:#181f2a; border-radius:50%; width:100px; height:100px; display:flex; align-items:center; justify-content:center; margin-bottom:18px; box-shadow:0 0 24px #FFD60055;">
                            <span style="font-size:2.5rem; color:#FFD600;"><i class="fa fa-globe"></i></span>
                        </div>
                        <div style="color:#fff; font-size:1.3rem; font-weight:700; margin-bottom:10px;">Écosystème Décentralisé</div>
                        <div style="color:#fff; font-size:1.05rem;">Accès global et transparent pour tous les participants</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h1 class="mb-4 fw-bold text-center" style="color:#111;">MarketPlace</h1>
    <p class="mb-4 text-center" style="font-size:1.1rem; color:#444;">
        Investissez en toute transparence et diversifiez votre portefeuille selon vos préférences.
    </p>
    <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-6 col-lg-4 d-flex">
            <div class="market-card flex-fill p-0">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSqV7I24MMOxKLDHa3pjNiuF7Cku46fLGrCcg&s"
                     alt="Produit vedette"
                     style="width:100%; height:180px; object-fit:cover; border-top-left-radius:16px; border-top-right-radius:16px;">
                <div class="p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
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
                        <button class="market-btn-yellow flex-fill" data-bs-toggle="modal" data-bs-target="#investModal1">Investir</button>
                        <button class="market-btn-black flex-fill" data-bs-toggle="modal" data-bs-target="#detailsModal1">Détails</button>
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
                        <button class="market-btn-yellow flex-fill" data-bs-toggle="modal" data-bs-target="#investModal2">Investir</button>
                        <button class="market-btn-black flex-fill" data-bs-toggle="modal" data-bs-target="#detailsModal2">Détails</button>
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
                        <button class="market-btn-yellow flex-fill" data-bs-toggle="modal" data-bs-target="#investModal3">Investir</button>
                        <button class="market-btn-black flex-fill" data-bs-toggle="modal" data-bs-target="#detailsModal3">Détails</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bouton Voir plus -->
        <div class="text-center mt-5">
            <a href="<?php echo site_url('Accueil/market'); ?>" class="btn btn-blue btn-lg" style="font-weight: 700; padding: 1rem 3rem; border-radius: 12px; border: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(7, 64, 106, 0.15);">
                <i class="fa fa-arrow-right me-2"></i>Voir plus d'opportunités
            </a>
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
          <button type="submit" class="btn btn-primary">Valider l'investissement</button>
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
          <button type="submit" class="btn btn-primary">Valider l'investissement</button>
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
          <button type="submit" class="btn btn-primary">Valider l'investissement</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<!-- Technologie Web3 Avancée End -->




  



  


    <!-- Témoignages Web3 PME Start -->
    <div class="container-fluid py-5" style="background: #fff;">
        <div class="container">
            <h2 class="text-center mb-4" style="color: #FFD600; font-size: 2.2rem; font-weight: 800;">Ils financent leur croissance grâce à la blockchain</h2>
            <div class="row justify-content-center g-4">
                <div class="col-md-4">
                    <div style="background: #181f2a; border: 1.5px solid #FFD600; border-radius: 18px; box-shadow: 0 2px 16px rgba(0,0,0,0.07); padding: 32px 24px; text-align: center;">
                        <img src="<?php echo bowers_url('img/user.png'); ?>" alt="PME" style="width: 70px; height: 70px; border-radius: 50%; margin-bottom: 18px; border: 3px solid #FFD600;">
                        <p style="color: #fff; font-size: 1.1rem;">"Grâce à CoinFinance-CI, nous avons pu tokeniser nos factures et obtenir des financements en quelques heures. La transparence et la rapidité sont bluffantes !"</p>
                        <hr class="mx-auto w-25" style="border-color: #FFD600;">
                        <h5 style="color: #FFD600; font-weight: bold; margin-bottom: 0;">Fatou, CEO d'une PME ivoirienne</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="background: #181f2a; border: 1.5px solid #FFD600; border-radius: 18px; box-shadow: 0 2px 16px rgba(0,0,0,0.07); padding: 32px 24px; text-align: center;">
                        <img src="<?php echo bowers_url('img/user.png'); ?>" alt="Investisseur" style="width: 70px; height: 70px; border-radius: 50%; margin-bottom: 18px; border: 3px solid #FFD600;">
                        <p style="color: #fff; font-size: 1.1rem;">"Investir dans les créances tokenisées de PME africaines n'a jamais été aussi simple. J'ai un suivi en temps réel et des rendements attractifs."</p>
                        <hr class="mx-auto w-25" style="border-color: #FFD600;">
                        <h5 style="color: #FFD600; font-weight: bold; margin-bottom: 0;">Jean-Marc, Investisseur Web3</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="background: #181f2a; border: 1.5px solid #FFD600; border-radius: 18px; box-shadow: 0 2px 16px rgba(0,0,0,0.07); padding: 32px 24px; text-align: center;">
                        <img src="<?php echo bowers_url('img/user.png'); ?>" alt="PME" style="width: 70px; height: 70px; border-radius: 50%; margin-bottom: 18px; border: 3px solid #FFD600;">
                        <p style="color: #fff; font-size: 1.1rem;">"La plateforme CoinFinance-CI nous a permis d'accélérer notre trésorerie sans paperasse, tout est automatisé et sécurisé par la blockchain."</p>
                        <hr class="mx-auto w-25" style="border-color: #FFD600;">
                        <h5 style="color: #FFD600; font-weight: bold; margin-bottom: 0;">Awa, Directrice financière</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Témoignages Web3 PME End -->



<!-- Footer Start -->
<?php $this->load->view('tpl/footer'); ?>
<!-- Footer End -->


<!-- JavaScript Libraries -->
<?php $this->load->view('tpl/js_files'); ?>

<script type="text/javascript">
//Initialize Select2 Elements

jQuery(document).ready(function() {
<?php
if ($this->session->flashdata("success")){
  echo "toast_success('".$this->session->flashdata("success")."');";
   unset($_SESSION['success']);
}
?>
<?php
if ($this->session->flashdata("error")){
   echo "toast_error('".$this->session->flashdata("error")."');";
   unset($_SESSION['error']);
}
?>
});

</script>

<!-- Chatbot Widget (exemple Tidio) -->
<script src="//code.tidio.co/vcm8u9d7iwspta4ajkzthreqmdnftg2e.js" async></script></body>

</html>