<?php
/**
 * User: Abou KONATE
 * Date: 01/09/2023
 */ 
?>

<!-- Charger jQuery en premier -->
<script src="<?php echo bowers_url('js/jquery-3.4.1.min.js'); ?>"></script>

<!-- Plugins nécessaires -->
<script src="<?php echo bowers_url('toasts/jquery.toast.js'); ?>" type="text/javascript"></script>
<script src="<?php echo bowers_url('comfirms/confirms.js'); ?>" type="text/javascript"></script>

<!-- Autres librairies -->
<script src="<?php echo lib_url('wow/wow.min.js'); ?>"></script>
<script src="<?php echo lib_url('easing/easing.min.js'); ?>"></script>
<script src="<?php echo lib_url('waypoints/waypoints.min.js'); ?>"></script>
<script src="<?php echo lib_url('owlcarousel/owl.carousel.min.js'); ?>"></script>
<script src="<?php echo lib_url('tempusdominus/js/moment.min.js'); ?>"></script>
<script src="<?php echo lib_url('tempusdominus/js/moment-timezone.min.js'); ?>"></script>
<script src="<?php echo lib_url('tempusdominus/js/tempusdominus-bootstrap-4.min.js'); ?>"></script>
<script src="<?php echo lib_url('twentytwenty/jquery.event.move.js'); ?>"></script>
<script src="<?php echo lib_url('twentytwenty/jquery.twentytwenty.js'); ?>"></script>

<!-- Bootstrap (bundle complet) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo bowers_url('js/bootstrap.bundle.min.js'); ?>"></script>

<!-- Template Javascript -->
<script src="<?php echo bowers_url('js/main.js'); ?>"></script>

<script>
$(function () {
  $('.navbar-toggler').click(function () {
    $('body').toggleClass('noscroll');
  });
});

// Confirmations
$('#comfirms1, #comfirms2, #comfirms3, #comfirms4').each(function () {
    let id = $(this).attr('id');
    $(this).confirm({
        theme: 'material',
        title: 'CONFIRMATION !',
        content: 'Voulez-vous faire cette action ?',
        buttons: {
            cancel: {
                text: 'Retour',
                btnClass: 'btn-default',
            },
            confirm: {
                text: 'Valider',
                btnClass: 'btn-blue',
                action: function () {
                    $("." + id).submit();
                }
            },
        }
    });
});

// Validation avant submit
$('#comfirms1, #comfirms2, #comfirms3, #comfirms4').on("click", function () {
    let formClass = "." + $(this).attr("id");
    $(formClass).find('select, textarea, input').each(function() {
        if ($(this).prop('required') && !$(this).val()) {
            fail = true;
            name = $(this).attr('name');
            fail_log += name + " is required \n";
        }
    });
});

// Toast functions
function toast_warning(texte){
    $.toast({
        text: texte,
        heading: 'Attention',
        icon: 'warning',
        showHideTransition: 'fade',
        allowToastClose: true,
        hideAfter: 5000,
        stack: 5,
        position: 'top-right',
        textAlign: 'left',
        loader: true,
        loaderBg: '#9EC600',
    });
}

function toast_information(texte){
    $.toast({
        text: texte, // corrigé
        heading: 'Information',
        icon: 'info',
        showHideTransition: 'fade',
        allowToastClose: true,
        hideAfter: 5000,
        stack: 5,
        position: 'top-right',
        textAlign: 'left',
        loader: true,
        loaderBg: '#9EC600',
    });
}

function toast_success(texte){
    $.toast({
        text: texte,
        heading: 'Succès',
        icon: 'success',
        showHideTransition: 'fade',
        allowToastClose: true,
        hideAfter: 5000,
        stack: 5,
        position: 'top-right',
        textAlign: 'left',
        loader: true,
        loaderBg: '#9EC600',
    });
}

function toast_error(texte){
    $.toast({
        text: texte,
        heading: 'Erreur',
        icon: 'error',
        showHideTransition: 'fade',
        allowToastClose: true,
        hideAfter: 5000,
        stack: 5,
        position: 'top-right',
        textAlign: 'left',
        loader: true,
        loaderBg: '#9EC600',
    });
}

// Détection mobile
function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}
if (isMobile()) {
    window.location.href = "<?php echo base_url('non-compatible'); ?>";
}
</script>
