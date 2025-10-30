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
          $data['page'] = 'login';
          $this->load->view('tpl/menu'); 
        ?>
    </nav>
    <!-- Navbar End -->


    <!-- Contact Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">

                 <div class="col-xl-8 col-lg-12 wow slideInUp" data-wow-delay="0.1s">
                    <div style="background:#181f2a; border-radius:18px; box-shadow:0 2px 16px rgba(0,0,0,0.07); padding:32px 0; display:flex; justify-content:center; align-items:center; min-height:340px;">
                        <img class="img-fluid mx-auto rounded" src="<?php echo bowers_url('img/auth.jpg'); ?>" alt="" style="max-width:250px; max-height:320px; height:auto;">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 wow slideInUp" data-wow-delay="0.3s" id="idConnexion">
                    <legend style="text-align:center;"><b>CONNEXION</b></legend>
                    <form id="myFormLogin" action="<?php echo site_url('Accueil/connexion');?>" method="POST">
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" class="form-control border-0 bg-light px-4" placeholder="Email" style="height: 55px;"  required name="login">
                            </div>
                            <div class="col-12">
                                <input type="password" class="form-control border-0 bg-light px-4" placeholder="Mot de passe" style="height: 55px;" required name="password">
                            </div>

                            <div class="col-12 text-center">
                                <a href="#" id="password">Mot de passe oublié ?</a>
                            </div>
                            
                            <div class="col-12">
                                <button class="btn btn-dark w-100 py-3" type="submit">S'IDENTIFIER</button>
                            </div>

                            <div class="col-12 text-center">
                                <a href="#" id="inscription">Je crée mon compte coinFinance !</a>
                            </div>
                            
                        </div>
                    </form>
                </div>

                 <div class="col-xl-4 col-lg-6" id="idPassword" style="display: none;">
                    <legend style="text-align:center;"><b>MOT DE PASSE</b></legend>
                    <form action="<?php echo site_url('Accueil/password');?>" method="post">
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" name="loginLogin" class="form-control border-0 bg-light px-4" placeholder="Mobile" style="height: 55px;" value="+225" maxlength="14" minlength="14" required>
                            </div>                           
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">REINITIALISER</button>
                            
                            </div>
                            <div class="col-12 text-center">
                                <a href="<?php echo site_url('Accueil/login');?>" style="text-align:right !important;"><i class="fa fa-arrow-left"></i> Page de connexion</a>
                            
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-xl-4 col-lg-6" id="idInscription" style="display: none;">
                    <legend style="text-align:center;"><b>INSCRIPTION</b></legend>
                    <form class="comfirms1" action="<?php echo site_url('Accueil/inscription');?>" method="post">
                        <div class="row g-3">
                            

                            <div class="col-12">
                                <input type="text" class="form-control border-0 bg-light px-4" placeholder="Nom de la PME" style="height: 55px;" name="nom_pme" required>
                            </div>

                            <div class="col-12">
                            <textarea class="form-control border-0 bg-light px-4" 
          placeholder="Description" 
          name="description" 
          rows="4" 
          style="height: auto;" 
          required></textarea>
                            </div>

                            <div class="col-12">
                                <input type="text" class="form-control border-0 bg-light px-4" placeholder="Email" style="height: 55px;" name="email_pme" required>
                            </div>

                            <div class="col-12">
                                <input type="text" class="form-control border-0 bg-light px-4" placeholder="Mobile" style="height: 55px;" value="+225" maxlength="14" minlength="14" name="numero_telephone">
                            </div>

                            
                            
                            <div class="col-12">
                                <input type="password" class="form-control border-0 bg-light px-4" placeholder="Mot de passe" name="pass_pme" style="height: 55px;" require>
                            </div>

                            

                            <div class="col-12 text-center">
                                <input type="checkbox" id="conditions" name="isAgree" value="1" required>
                                <label for="conditions"><a target="_blank" href="">J'accepte les conditions d'utilisation</a></label>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit" id="comfirms1">INSCRIPTION</button>
                            </div>

                            <div class="col-12 text-center">
                                <a href="<?php echo site_url('Accueil/login');?>" style="text-align:right !important;"><i class="fa fa-arrow-left"></i> J'ai déjà un compte !</a>
                            
                            </div>

                        </div>
                    </form>
                </div>
               
            </div>
        </div>
    </div>
    <!-- Contact End -->


   
<?php $this->load->view('tpl/footer'); ?>
<!-- Footer End -->


<!-- Back to Top -->
<!-- <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="fa fa-arrow-up"></i></a> -->


<!-- JavaScript Libraries -->
<?php $this->load->view('tpl/js_files'); ?>

<script type="text/javascript">
//Initialize Select2 Elements
$('#password').click(function ()
{   
    $('#idPassword').show();
    $('#idConnexion').hide();
});

$('#inscription').click(function ()
{   
    $('#idInscription').show();
    $('#idConnexion').hide();
});

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