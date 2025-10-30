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
$data['page'] = 'motdepasse';
$this->load->view('tpl/menu'); 
?>
</nav>
<!-- Navbar End -->


<div class="container-fluid py-5">
<div class="container">
<div class="row g-5">

<!-- Sidebar -->
<div class="col-lg-3">
	<div class="sidebar">

		<?php 
          $data['page'] = 'motdepasse';
          $this->load->view('tpl/sidebar'); 
        ?>		

	</div>
</div>

<!-- News Posts -->
<div class="col-lg-8 wow">
<div class="section-title mb-4">
<h2 class="mb-0 text-center" style="color:red;">Mise à jour du mot de passe !</h2>
</div>
<div class="news_posts" align="center">



<div class="col-xl-9 col-lg-9 text-center" align="center">
    <form class="comfirms1" action="<?php echo site_url('MonCompte/majPassword');?>" method="post" onSubmit="return confirm('Voulez Vous Faire Cette Mise à Jour ?')" >
        <div class="row g-3">
            

            <div class="col-12">
                <input type="password" class="form-control border-0 bg-light px-4" placeholder="Mot de passe" style="height: 55px;" name="oPassword" required id="oPassword">
            </div>

            <div class="col-12">
                <input type="password" class="form-control border-0 bg-light px-4" placeholder="Mot de passe" style="height: 55px;" name="password" required id="password">
            </div>
            
            <div class="col-12">
                <input type="password" class="form-control border-0 bg-light px-4" placeholder="Mot de passe" style="height: 55px;" name="rpassword" required id="rpassword"  onkeyup="checkPass()">
            </div>

            <div class="col-12">
		        <b style="color: red;"><div id="divcomp"></div></b>
		    </div>

            <div class="col-12">
                <button class="btn btn-primary w-100 py-3" type="submit" id="comfirmer1">MODIFIER</button>
            </div>

          

        </div>
    </form>
</div>


<!-- form -->

</div>
</div>





</div>
</div>
</div>

<!-- Footer Start -->
<?php $this->load->view('tpl/footer'); ?>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="fa fa-arrow-up"></i></a>

<?php $this->load->view('tpl/js_files'); ?>


<script type="text/javascript">
$(document).on("click", "#comfirmer1", function () 
{
	if (isEmpty($('#oPassword')) || isEmpty($('#password')) || isEmpty($('#rpassword')))
	{
		$.alert('Veuillez saisir les champs SVP !');
        return false;
    }
      
});

function checkPass()
{
	var password = document.getElementById("password").value;
	var rpassword = document.getElementById("rpassword").value;
	var div_comp = document.getElementById("divcomp");
	 
	if(password == rpassword & password.length >= 5)
	{
	  divcomp.innerHTML = "Les Mots De Passe Sont Corrects";
	}
	else if(password == rpassword & password.length < 5)
	{
	  divcomp.innerHTML = "Les Mots De Passe Doivent Avoir Une Longueur Supérieure à 5 Caractères!";
	}
	else
	{
	   divcomp.innerHTML = "Les Mots De Passe Ne Sont Pas Identiques!";
	}
}




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