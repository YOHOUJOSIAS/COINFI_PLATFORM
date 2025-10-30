<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $this->load->view('tpl/css_files'); ?>
    <style>
        body {
            background: #fff !important;
            color: #111;
        }
        .apropos-header {
            margin-top: 60px;
            margin-bottom: 40px;
        }
        .apropos-title {
            font-size: 2.8rem;
            font-weight: bold;
            color: #111;
        }
        .apropos-subtitle {
            color: #007bff;
            font-size: 1.3rem;
            margin-bottom: 40px;
        }
        .apropos-section-title {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 30px;
            color: #111;
        }
        .apropos-card {
            border-radius: 16px;
            padding: 2.5rem 2rem 2rem 2rem;
            margin-bottom: 2rem;
            color: #fff;
            min-height: 320px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.10);
            background: #111 !important;
        }
        .apropos-card-mission {
            background: linear-gradient(135deg, #3a3a8c 0%, #2b235a 100%);
        }
        .apropos-card-vision {
            background: linear-gradient(135deg, #0e6b4c 0%, #0b3c2c 100%);
        }
        .apropos-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            font-size: 2.2rem;
            background: #222;
            color: #FFD700 !important;
        }
        .apropos-icon-vision {
            background: #222;
        }
        .apropos-card h3,
        .apropos-card div {
            color: #fff !important;
        }
        @media (max-width: 991px) {
            .apropos-card {
                min-height: unset;
            }
        }
    </style>
</head>
<body>
    
<head>
    <?php $this->load->view('tpl/css_files'); ?>
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
  $data['page'] = 'apropos';
  $this->load->view('tpl/menu'); 
?>
</nav>
<!-- Navbar End -->

    <div class="container apropos-header text-center">
        <div class="apropos-title">À Propos de CoinFinance</div>
        <div class="apropos-subtitle">
            Nous révolutionnons le financement des entreprises en démocratisant l'accès à la<br>
            liquidité grâce à la tokenisation des créances et la technologie Web3.
        </div>
        <div class="apropos-section-title">Notre Vision & Mission</div>
    </div>
    <div class="container mb-5">
        <div class="row g-4 justify-content-center">
            <div class="col-md-6">
                <div class="apropos-card apropos-card-mission text-center h-100">
                    <div class="apropos-icon">
                        <i class="fa fa-line-chart"></i>
                    </div>
                    <h3 class="mb-3">Notre Mission</h3>
                    <div>
                        Démocratiser l'accès au financement pour les PME en transformant leurs créances en actifs liquides grâce à la technologie blockchain. Nous créons un écosystème financier plus inclusif, transparent et efficace basé sur Web3.
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="apropos-card apropos-card-vision text-center h-100">
                    <div class="apropos-icon apropos-icon-vision">
                        <i class="fa fa-globe"></i>
                    </div>
                    <h3 class="mb-3">Notre Vision</h3>
                    <div>
                        Devenir la plateforme de référence mondiale pour la tokenisation des créances, en créant un marché secondaire liquide et en offrant aux investisseurs des opportunités d'investissement transparentes et rentables dans l'économie réelle via Web3.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Valeurs Fondamentales -->
    <div class="container mb-5">
        <div class="blog-card p-4" style="background:#111;">
            <h2 class="text-center mb-5" style="color:#fff;">Nos Valeurs Fondamentales</h2>
            <div class="row text-center g-4">
                <div class="col-md-3">
                    <div class="mb-3">
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#7ecbff,#a084ee);font-size:2.2rem;color:#fff;"><i class="fa fa-shield"></i></span>
                    </div>
                    <h5 style="color:#fff;font-weight:bold;">Sécurité</h5>
                    <div style="color:#fff;">Protection maximale des données et des fonds</div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#2ee59d,#0e6b4c);font-size:2.2rem;color:#fff;"><i class="fa fa-check-circle"></i></span>
                    </div>
                    <h5 style="color:#fff;font-weight:bold;">Transparence</h5>
                    <div style="color:#fff;">Tous les processus sont auditables et vérifiables</div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#ff7e5f,#feb47b);font-size:2.2rem;color:#fff;"><i class="fa fa-users"></i></span>
                    </div>
                    <h5 style="color:#fff;font-weight:bold;">Accessibilité</h5>
                    <div style="color:#fff;">Démocratisation de l'accès au financement</div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#f857a6,#ff5858);font-size:2.2rem;color:#fff;"><i class="fa fa-certificate"></i></span>
                    </div>
                    <h5 style="color:#fff;font-weight:bold;">Excellence</h5>
                    <div style="color:#fff;">Innovation continue et qualité irréprochable</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Notre Équipe -->
    <div class="container mb-5">
        <div class="blog-card p-4" style="background:#111;">
            <h2 class="text-center mb-2" style="color:#fff;">Notre Équipe</h2>
            <div class="text-center mb-4" style="color:#7ecbff;">Des experts passionnés par l'innovation financière</div>
            <div class="row text-center g-4">
                <div class="col-md-3">
                    <div class="mb-3">
                        <span style="display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, #7ecbff, #a084ee);">
                            <img src="<?php echo bowers_url('img/br.png'); ?>" alt="Image" style="width: 150px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;">
                        </span>
                    </div>
                    <h4 style="color:#fff;font-weight:bold;">Brice</h4>
                    <div style="color:#7ecbff;font-weight:bold;">
                        CEO
                        <a href="https://www.linkedin.com/in/brice-kouassi-kpa-aba57a18a/" target="_blank" style="margin-left:8px;">
                            <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" alt="LinkedIn" style="width:18px;vertical-align:middle;">
                        </a>
                    </div>
                    <div style="color:#fff;">CEO, Consultant Blockchain , Chef d'entreprise</div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <span style="display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, #7ecbff, #a084ee);">
                            <img src="<?php echo bowers_url('img/alan.jpeg'); ?>" alt="Image" style="
            width: 150px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;">
                        </span>
                    </div>
                    <h4 style="color:#fff;font-weight:bold;">Alan</h4>
                    <div style="color:#7ecbff;font-weight:bold;">
                        Product Manager
                        <a href="https://www.linkedin.com/in/alan-emmanuel-559544360/" target="_blank" style="margin-left:8px;">
                            <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" alt="LinkedIn" style="width:18px;vertical-align:middle;">
                        </a>
                    </div>
                    <div style="color:#fff;">Gestion de produit, UX/UI, Innovation</div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <span style=" display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, #7ecbff, #a084ee);">
                        <img class="w-100" src="<?php echo bowers_url('img/zie.jpeg'); ?>" alt="Image" 
                        style="width: 150px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;">
                        </span>
                    </div>
                    <h4 style="color:#fff;font-weight:bold;">Zie</h4>
                    <div style="color:#7ecbff;font-weight:bold;">
                        Développeur
                        <a href="https://www.linkedin.com/in/zi%C3%A9-arouna-kone-000385159/" target="_blank" style="margin-left:8px;">
                            <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" alt="LinkedIn" style="width:18px;vertical-align:middle;">
                        </a>
                    </div>
                    <div style="color:#fff;">Blockchain, Smart Contracts, Web3</div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                       <span style="
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, #7ecbff, #a084ee);
">
    <img 
        src="<?php echo bowers_url('img/abel.jfif'); ?>" 
        alt="Image" 
        style="
            width: 150px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        ">
</span>

                    </div>
                    <h4 style="color:#fff;font-weight:bold;">Josias</h4>
                    <div style="color:#7ecbff;font-weight:bold;">
                        Développeur
                        <a href="https://www.linkedin.com/in/abel-josias-yohou-295856191/" target="_blank" style="margin-left:8px;">
                            <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" alt="LinkedIn" style="width:25px; height : 25px ;vertical-align:middle;">
                        </a>
                    </div>
                    <div style="color:#fff;">Frontend, Backend, Architecture système</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Notre plan pour 2025 -->
    <div class="container mb-5">
        <div class="blog-card p-4" style="background:#111;">
            <h2 class="text-center mb-5" style="color:#fff; font-size:2.5rem; font-weight:800;">Notre plan pour 2025</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="d-flex flex-column align-items-center">
                        <!-- Q2 2025 -->
                        <div class="d-flex align-items-center mb-4" style="width:100%;">
                            <div class="me-4">
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:80px;height:80px;border-radius:50%;background:#FFD600;color:#111;font-weight:bold;font-size:1.1rem;box-shadow:0 4px 12px rgba(255,214,0,0.3);">
                                    Q2 2025
                                </span>
                            </div>
                            <div style="flex:1;">
                                <h4 style="color:#fff;font-weight:bold;margin-bottom:8px;">Idéation et conception</h4>
                                <p style="color:#ccc;margin:0;">Conception de la plateforme et validation du concept.</p>
                            </div>
                        </div>
                        
                        <!-- Q3 2025 -->
                        <div class="d-flex align-items-center mb-4" style="width:100%;">
                            <div class="me-4">
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:80px;height:80px;border-radius:50%;background:#FFD600;color:#111;font-weight:bold;font-size:1.1rem;box-shadow:0 4px 12px rgba(255,214,0,0.3);">
                                    Q3 2025
                                </span>
                            </div>
                            <div style="flex:1;">
                                <h4 style="color:#fff;font-weight:bold;margin-bottom:8px;">Test MVP</h4>
                                <p style="color:#ccc;margin:0;">Tests techniques et premiers retours utilisateurs.</p>
                            </div>
                        </div>
                        
                        <!-- Q4 2025 -->
                        <div class="d-flex align-items-center mb-5" style="width:100%;">
                            <div class="me-4">
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:80px;height:80px;border-radius:50%;background:#FFD600;color:#111;font-weight:bold;font-size:1.1rem;box-shadow:0 4px 12px rgba(255,214,0,0.3);">
                                    Q4 2025
                                </span>
                            </div>
                            <div style="flex:1;">
                                <h4 style="color:#fff;font-weight:bold;margin-bottom:8px;">Lancement officiel</h4>
                                <p style="color:#ccc;margin:0;">Ouverture publique et intégrations bancaires.</p>
                            </div>
                        </div>
                        
                        <!-- Bouton CTA -->
                        <div class="text-center">
                            <button class="btn btn-lg" style="background:#FFD600;color:#111;font-weight:bold;padding:12px 32px;border-radius:8px;border:none;box-shadow:0 4px 12px rgba(255,214,0,0.3);transition:all 0.3s ease;">
                                Inscrivez-vous pour tester tôt
                            </button>
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