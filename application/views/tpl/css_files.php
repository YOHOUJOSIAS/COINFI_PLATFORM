<?php
/**
 * User: Abou KONATE
 * Date: 01/09/2023
 */ 
?>

<!-- Required meta tags -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($page_title) ? $page_title : "Website"; ?></title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- Bootstrap CSS (CDN) -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Icon Fonts -->
<link href="<?php echo bowers_url('css/bootstrap-icons.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo bowers_url('font-awesome/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?php echo bowers_url('Ionicons/css/ionicons.min.css'); ?>">

<!-- Libraries Stylesheet -->
<link href="<?php echo lib_url('owlcarousel/assets/owl.carousel.min.css'); ?>" rel="stylesheet">
<link href="<?php echo lib_url('animate/animate.min.css'); ?>" rel="stylesheet">
<link href="<?php echo lib_url('tempusdominus/css/tempusdominus-bootstrap-4.min.css'); ?>" rel="stylesheet">
<link href="<?php echo lib_url('twentytwenty/twentytwenty.css'); ?>" rel="stylesheet">

<!-- Customized Bootstrap Stylesheet -->
<link href="<?php echo bowers_url('css/bootstrap.min.css'); ?>" rel="stylesheet">

<!-- Template Stylesheet -->
<link href="<?php echo bowers_url('css/style.css'); ?>" rel="stylesheet">

<!-- Toast & Confirm Styles -->
<link rel="stylesheet" href="<?php echo bowers_url('toasts/jquery.toast.css'); ?>">
<link rel="stylesheet" href="<?php echo bowers_url('comfirms/confirms.css'); ?>">

<!-- Favicon -->
<link rel="icon" href="<?php echo bowers_url('images/1.png'); ?>" type="image/png">

<style>
/* Bouton personnalisé */
.btn-blue {
    background: #07406A !important;
    color: #fff !important;
    border: none !important;
    font-weight: 600;
    transition: background 0.2s ease-in-out;
}
.btn-blue:hover, 
.btn-blue:focus {
    background: #05345A !important;
    color: #fff !important;
}
</style>
