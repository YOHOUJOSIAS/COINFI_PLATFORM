<!DOCTYPE html>
<html lang="fr">

<head>
    <?php $this->load->view('tpl/css_files'); ?>
</head>

<body>
   
    <!-- Topbar Start -->
    <div class="container-fluid bg-light ps-5 pe-0 d-none d-lg-block">
        <?php $this->load->view('tpl/header'); ?>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
        <?php 
          $data['page'] = 'entreprise';
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


    <!-- About Start -->
    <div id="about-us" class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title mb-4">
                        <h1 class="display-5 mb-0">A Propos de Nous</h1>
                    </div>
                    <h4 class="text-body fst-italic mb-4">Enovpharm est un pôle d'innovation pharmaceutique qui propose des services adaptés aux établissements de santé privés pour faciliter leur implication dans les interventions de santé publique.</h4>
                    <p class="mb-4">Nous sommes fiers de contribuer à améliorer l’accès aux produits de santé publique essentiels grâce à notre engagement envers le secteur privé et la technologie.</p>
                    <div class="row g-3">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.3s">
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Consultant Santé publique</h5>
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Assistance technique privé-public</h5>
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Formation continue & Encadrement</h5>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.6s">
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Gestion de projet</h5>
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Solutions numériques et robotique</h5>
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Plaidoyer pour les avantages de la santé</h5>
                        </div>
                    </div>
                    <a href="https://www.enovpharm.com/" class="btn btn-primary py-3 px-5 mt-4 wow zoomIn" data-wow-delay="0.6s" target="_blank">Visiter Notre Site Web</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s" src="<?php echo bowers_url('img/about.jpg'); ?>" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

      <!-- Team Start -->
    <div class="container-fluid py-5" id="our-team" style="display: none;">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 wow slideInUp" data-wow-delay="0.1s">
                    <div class="section-title bg-light rounded h-100 p-5">
                        <h5 class="position-relative d-inline-block text-primary text-uppercase">Notre Equipe</h5>
                        <h3 class="mb-4">Nous sommes fiers de compter parmi nous une équipe talentueuse et dévouée qui travaille ensemble pour atteindre nos objectifs. Découvrez les visages derrière notre succès :</h3>
                    </div>
                </div>
                <div class="col-lg-4 wow slideInUp" data-wow-delay="0.3s">
                    <div class="team-item">
                        <div class="position-relative rounded-top" style="z-index: 1;">
                            <img class="img-fluid rounded-top w-100" src="<?php echo bowers_url('images/3.jpeg'); ?>" alt="">
                            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-linkedin fw-normal"></i></a>

                            </div>
                        </div>
                        <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                            <h4 class="mb-2">Dr. Yvan J. Agbassi</h4>
                            <p class="text-primary mb-0">General Manager</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow slideInUp" data-wow-delay="0.6s">
                    <div class="team-item">
                        <div class="position-relative rounded-top" style="z-index: 1;">
                            <img class="img-fluid rounded-top w-100" src="<?php echo bowers_url('images/2.jpeg'); ?>" alt="">
                            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                               <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-linkedin fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                            <h4 class="mb-2">Leonie Dindji</h4>
                            <p class="text-primary mb-0">Engagement Specialist</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow slideInUp" data-wow-delay="0.1s">
                    <div class="team-item">
                        <div class="position-relative rounded-top" style="z-index: 1;">
                            <img class="img-fluid rounded-top w-100" src="<?php echo bowers_url('images/1.jpeg'); ?>" alt="">
                            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                               <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-linkedin fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                            <h4 class="mb-2">Jean Guy BONI</h4>
                            <p class="text-primary mb-0">Grants & Partnerships</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow slideInUp" data-wow-delay="0.3s">
                    <div class="team-item">
                        <div class="position-relative rounded-top" style="z-index: 1;">
                            <img class="img-fluid rounded-top w-100" src="<?php echo bowers_url('images/4.jpeg'); ?>" alt="">
                            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                               <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-linkedin fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                            <h4 class="mb-2">Dr. Akani Bangaman</h4>
                            <p class="text-primary mb-0">Director of Programs</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow slideInUp" data-wow-delay="0.6s">
                    <div class="team-item">
                        <div class="position-relative rounded-top" style="z-index: 1;">
                            <img class="img-fluid rounded-top w-100" src="<?php echo bowers_url('images/2.jpg'); ?>" alt="">
                            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                               <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fa fa-linkedin fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                            <h4 class="mb-2">Aristide Yao</h4>
                            <p class="text-primary mb-0">Project Manager</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


    
<!-- Footer Start -->
<?php $this->load->view('tpl/footer'); ?>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="fa fa-arrow-up"></i></a>


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

</body>

</html>