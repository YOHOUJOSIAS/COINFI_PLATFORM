<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $this->load->view('tpl/css_files'); ?>
    <style>
        body {
            background: #fff !important;
            color: #111;
        }
        .etape-card {
            background: #111 !important;
            color: #fff !important;
            border-radius: 16px;
            padding: 2rem 1.5rem 1.5rem 1.5rem;
            min-height: 260px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.10);
            margin-bottom: 2rem;
        }
        .etape-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 18px auto;
            font-size: 2rem;
            background: #222;
            color: #FFD700 !important;
        }
        .etape-card h5, .etape-card p {
            color: #fff !important;
        }
        .etape-num {
            font-size: 1.1rem;
            color: #FFD700;
            font-weight: bold;
            margin-bottom: 0.5rem;
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
      $data['page'] = 'commentcamarche';
      $this->load->view('tpl/menu'); 
    ?>
</nav>
<!-- Navbar End -->

<div class="container text-center my-5">
    <h1 class="display-5 fw-bold mb-3" style="color:#111;">Comment ça marche ?</h1>
    <div class="container-fluid py-5" style="background: #fff;">
    <div class="container">
        
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
                    <div style="color:black; font-size:1.2rem; font-weight:bold; margin-bottom:10px;">Investissements</div>
                    <div style="color:#222; font-size:1rem;">Les investisseurs achètent les tokens et reçoivent les remboursements automatiquement</div>
                </div>
            </div>
        </div>
    </div>
</div>
    <p class="lead mb-5" style="color:#444;">Découvrez les étapes simples pour investir dans la tokenisation de créances avec CoinFinance.</p>
    <div class="row justify-content-center g-4">
        <div class="col-md-6 col-lg-3 d-flex">
            <div class="etape-card flex-fill text-center">
                <div class="etape-icon"><i class="fa fa-user-plus"></i></div>
                <div class="etape-num">Étape 1</div>
                <h5>Inscription</h5>
                <p>Créez votre compte en quelques clics et complétez la vérification d'identité (KYC).</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 d-flex">
            <div class="etape-card flex-fill text-center">
                <div class="etape-icon"><i class="fa fa-search"></i></div>
                <div class="etape-num">Étape 2</div>
                <h5>Sélection des créances</h5>
                <p>Parcourez les créances disponibles, analysez les risques et choisissez celles qui correspondent à vos objectifs.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 d-flex">
            <div class="etape-card flex-fill text-center">
                <div class="etape-icon">🏪</div>
                <div class="etape-num">Étape 3</div>
                <h5>Investissement</h5>
                <p>Investissez le montant souhaité et recevez des tokens représentant votre part dans la créance.</p>
            </div>
            
        </div>
        <div class="col-md-6 col-lg-3 d-flex">
            <div class="etape-card flex-fill text-center">
                <div class="etape-icon">💰</div>
                <div class="etape-num">Étape 4</div>
                <h5>Retrait des gains</h5>
                <p>Recevez vos gains une fois la créance remboursée et retirez-les facilement sur votre compte.</p>
            </div>
        </div>
    </div>
</div>

 <h1 class="display-5 text-center fw-bold mb-3" style="color:#111;">Les avantages</h1>
<!-- Architecture Technologique & Sécurité -->
<div class="container mb-5">
    <div class="blog-card p-4" style="background:#111;">
        <div class="row">
            <div class="col-md-6">
                <h3 class="mb-3" style="color:#fff;">Architecture Technologique & Sécurité</h3>
                <div class="fw-bold mb-2" style="color:#fff;">Technologie Blockchain</div>
                <ul class="list-unstyled" style="color:#fff;">
                    <li class="mb-2"><span style="color:#2ee59d;"><i class="fa fa-check-circle"></i></span> Smart contracts ERC-1155</li>
                    <li class="mb-2"><span style="color:#2ee59d;"><i class="fa fa-check-circle"></i></span> Paiements en USDT sécurisés</li>
                    <li class="mb-2"><span style="color:#2ee59d;"><i class="fa fa-check-circle"></i></span> Traçabilité complète des transactions</li>
                   
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="mb-3 mt-4 mt-md-0" style="color:#fff;">Sécurité & Conformité</h5>
                <ul class="list-unstyled" style="color:#fff;">
                    <li class="mb-2"><span style="color:#2ee59d;"><i class="fa fa-check-circle"></i></span> Audits de sécurité réguliers</li>
                    <li class="mb-2"><span style="color:#2ee59d;"><i class="fa fa-check-circle"></i></span> Vérification KYC/AML automatisée</li>
                    <li class="mb-2"><span style="color:#2ee59d;"><i class="fa fa-check-circle"></i></span> Conformité réglementaire européenne</li>
                    <li class="mb-2"><span style="color:#2ee59d;"><i class="fa fa-check-circle"></i></span> Protection des données RGPD</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Commissions Transparentes -->
<div class="container mb-5">
    <div class="blog-card p-4" style="background:#111;">
        <h3 class="mb-4" style="color:#fff;">Commissions Transparentes</h3>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0" style="color:#fff;">
                        <tbody>
                            <tr>
                                <td>Commission de tokenisation</td>
                                <td class="text-end" style="color:#fff;font-weight:bold;">1%</td>
                            </tr>
                            <tr>
                                <td>Frais de réseau</td>
                                <td class="text-end" style="color:#fff;">~0.01 GLMR</td>
                            </tr>
                            <tr>
                                <td>Commission de remboursement</td>
                                <td class="text-end" style="color:#fff;font-weight:bold;">0.5%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('tpl/footer'); ?>
<?php $this->load->view('tpl/js_files'); ?>
</body>
</html> 