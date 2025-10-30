<!DOCTYPE html>
<html lang="fr">

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
  $data['page'] = 'contacts';
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
                <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Full Screen Search End -->


<!-- Hero Start -->
<div class="container-fluid bg-primary py-5 hero-header mb-5">
<div class="row py-3">
    <div class="col-12 text-center">
        <h1 class="display-3 text-white animated zoomIn">Nos Conditions</h1>
        <a href="<?php echo site_url('Accueil');?>" class="h4 text-white">Accueil</a>
        <i class="fa fa-circle text-white px-2"></i>
        <a href="<?php echo site_url('Accueil/contacts');?>" class="h4 text-white">CGNU</a>
    </div>
</div>
</div>
<!-- Hero End -->


<!-- Contact Start -->
<div class="container-fluid py-5">
<div class="container">
<h3 class="cont-head" align="center">CONDITIONS GENERALES D’UTILISATION !</h3>
<div class="d-grid align-form-map">
<p style="text-align:justify;">L’utilisateur, par l’accès, la navigation et/ou l’utilisation du site, https://vaccipha.com (le «Site »), accepte les conditions suivantes :</p>

<p style="text-align:justify;">Clause de non-responsabilité : Cette application n'est pas affiliée à une entité gouvernementale et ne représente pas le gouvernement ivoirien ou toute autre organisation gouvernementale.</p>

<p style="text-align:justify;">Vaccipha est le service de prise de rendez-vous pour la vaccination dans le secteur privé ivoirien aux personnes enregistrées via son portail Web et ses applications mobiles. Ce site web est maintenu et exploité par Enovpharm et le Programme Elargi de Vaccination (PEV) au sein du Ministère de la Santé de Côte d’Ivoire. L'utilisation de ces applications, y compris le contenu, le matériel et les informations disponibles (collectivement, les « matériaux »), pour accéder à ces services est soumise à l'acceptation des présentes Conditions d'Utilisation (les « conditions »).
</p>

<p style="text-align:justify;">Si vous n'acceptez pas ces conditions d'utilisation et/ou n'êtes pas éligible ou autorisé à accepter ces conditions d'utilisation, vous n'êtes pas autorisé à utiliser les applications et services pris en charge par Vaccipha. En utilisant cette application, vous acceptez ces conditions d'utilisation et êtes légalement lié par toutes les conditions de cet accord de conditions d'utilisation.</p>

<p style="text-align:justify;">Matériaux : À l’exception de certains documents fournis par le biais d’une zone protégée par mot de passe sur ce site web (voir ci-dessous), tous les documents sont fournis « tels quels », ne peuvent être invoqués à aucune fin et ne sont soumis à aucune garantie expresse ou implicite de quelque nature que ce soit. 

Dans le cadre de nos activités, nous sommes soumis à diverses obligations de confidentialité envers les patients, les partenaires et d’autres tiers. Toute déclaration que nous faisons peut être affectée par ces obligations de confidentialité, de sorte qu’il peut nous être interdit de faire des divulgations complètes. Sans limitation de l’effet des autres avertissements et avertissements énoncés dans les présentes Conditions, vous devez interpréter toutes les déclarations que nous faisons (sur ce site web ou autrement) dans ce contexte. 

Veuillez-vous assurer que votre propre sécurité informatique est complète et à jour. Nous n’acceptons aucune responsabilité pour les virus, les logiciels malveillants ou autres logiciels malveillants ou dommageables contenus dans les matériaux ou autrement.
</p>

<p style="text-align:justify;">Propriété des marques de commerce: Tous les textes, photos, graphiques, logos, contenus et autres documents de ce site Web sont protégés par les lois ivoiriennes et étrangères sur les droits d’auteur, les marques de commerce et autres lois applicables. En particulier, toutes les marques de commerce, noms commerciaux et logos affichés sur ce site web sont la propriété de Enovpharm ou de leurs propriétaires respectifs, et ce site web ne leur accorde aucune licence. Enovpharm /  Vaccipha et les différents logos sont nos marques déposées en Côte d’Ivoire et/ou dans d’autres pays.
</p>

<p style="text-align:justify;">Sites tiers: Nous n’acceptons aucune responsabilité pour les sites tiers disponibles via ce site web, via un lien hypertexte ou autrement. Nous vous encourageons à consulter les conditions d’utilisation applicables à ces sites. Tout accès ou utilisation d’un site tiers est à vos propres risques.</p>

<p style="text-align:justify;">Comptes d'utilisateurs: En tant que patient enregistré sur Vaccipha via le portail patient ou l'application mobile patient, vous pouvez accéder à votre compte utilisateur patient et aux services applicables, en utilisant les détails du compte utilisateur fournis par vous-même ou par les prestataires de soins. En vous inscrivant, vous acceptez que :
Vous n’usurpez l’identité d’aucune autre personne et utilisez votre véritable identité.
Les informations personnelles fournies lors du processus d’inscription sont vraies, exactes, à jour et complètes. Vous êtes tenu de revoir et de mettre à jour périodiquement vos données d'inscription pour vous assurer qu'elles sont toujours à jour et correctes.
Votre nom d'utilisateur et votre mot de passe vous sont uniques et vous acceptez de ne pas divulguer ou partager votre nom d'utilisateur et votre mot de passe à ou avec des tiers. Vous êtes responsable de garder votre mot de passe confidentiel et de nous informer immédiatement si votre mot de passe a été piraté ou volé.
Vous acceptez également que vous serez seul responsable de toutes les activités menées sur ou via le portail patient et/ou l'application mobile avec votre compte. Par la présente, vous dégagez Vaccipha de toute responsabilité résultant de l'utilisation non autorisée de votre compte par un tiers.</p>

<p style="text-align:justify;">Les comptes d'utilisateurs familiaux ajoutés sous votre compte d'utilisateur doivent être strictement ajoutés uniquement aux mineurs et aux personnes à charge de votre famille qui ne peuvent pas gérer leur propre compte d'utilisateur indépendant et qui ont consenti (si possible) à ce que vous le fassiez en leur nom. Les membres de la famille qui peuvent disposer de leur propre numéro de téléphone et/ou adresse e-mail doivent créer et gérer leur propre compte patient indépendant. Vous recevrez toutes les notifications relatives aux membres de votre compte familial et pourrez accéder à leurs comptes. Seul un maximum de 10 comptes d'utilisateurs familiaux peuvent être inclus sous votre compte utilisateur. En créant un compte d'utilisateur familial sous votre compte pour un membre adulte à charge de la famille, vous reconnaissez que vous l'avez fait avec le consentement nécessaire du membre de la famille.
Vaccipha se réserve le droit de refuser ou de révoquer l'accès à tout compte utilisateur à sa seule discrétion.
Cette application n'est qu'un outil permettant aux patients de Vaccipha de collaborer à leurs propres soins de santé, d'utiliser les services de planification et de communication et d'accéder à leur dossier de santé personnel conservé par Vaccipha.</p>

<p style="text-align:justify;">En tant qu'utilisateur de services via le portail patient et/ou l'application mobile de Vaccipha, vous acceptez de recevoir des notifications liées aux services essentiels sous forme de notifications SMS, e-mail, push mobile et WhatsApp. Des paramètres de notification permettant de désactiver les notifications par e-mail et SMS non essentielles sont disponibles. Des paramètres permettant de désactiver les notifications push mobile et WhatsApp sont disponibles.
S'agissant d'une application en ligne, il peut y avoir des problèmes imprévisibles de réseau et d'infrastructure, auquel cas l'application ne sera pas disponible tant que le problème n'est pas résolu. Dans de telles circonstances, veuillez contacter directement Vaccipha en personne pour tout service dont vous pourriez avoir besoin. Vaccipha n'est pas responsable des périodes d'indisponibilité de cette application.
En tant qu'utilisateur, vous ne pouvez pas utiliser d'outils automatisés ou de logiciels malveillants sur nos applications, ni provoquer une quelconque dégradation de nos services applicatifs. Vous ne pouvez pas compromettre la confidentialité et la sécurité des données utilisateur, ni provoquer leur modification, mauvaise utilisation ou destruction de quelque manière que ce soit.
L'utilisation de cette application ne rend pas les fournisseurs de technologie, tels que Google Play ou Apple App Store, prenant en charge cette application responsable des soins de santé et/ou autres services que vous utilisez via l'application, et n'entraîne aucune obligation implicite entre vous et les fournisseurs.
</p>

<p style="text-align:justify;">Données: L'application stocke des données, y compris des données personnelles, des communications et des données d'utilisation, y compris, mais sans s'y limiter, l'emplacement, le type d'appareil, le système d'exploitation, le navigateur, la date, l'heure et l'utilisation du contexte, dans une infrastructure cloud conforme à la HIPAA et au RGPD. Tous les stockages et transmissions de données sont cryptés.
L'exactitude, l'intégrité et l'exhaustivité des informations personnelles sur la santé que vous saisissez, synchronisées directement à partir de capteurs de santé et/ou synchronisées depuis vos autres comptes de santé ou de remise en forme vers votre dossier de santé, relèvent de votre responsabilité et Vaccipha n'assume aucune responsabilité à cet égard.
Toutes les données que vous insérez dans votre dossier de santé personnel dans l'application sont stockées en toute sécurité dans votre dossier de santé personnel dans notre stockage cloud sécurisé. Les données de votre dossier de santé personnel seront accessibles et modifiables par les prestataires de soins de santé agréés du Ministère en charge de la Santé dans le but de vous fournir des services de santé.</p>

<p style="text-align:justify;">Les principales informations requises pour la prise de rendez-vous de vaccination de routine ou de COVID-19 sont les suivantes :
-       Nom du patient
-       Date de naissance
-       Liste des vaccins administrés
-       Dates de vaccination
-       Dernier résultat positif à la COVID-19
Une analyse système non personnalisée des données non identifiables peut être effectuée pour permettre de meilleurs résultats pour Vaccipha. Toutefois, l'identité des utilisateurs individuels restera totalement anonyme lors de cette analyse.
Toutes les données des utilisateurs sont couvertes par la politique de confidentialité de Vaccipha.
</p>

<p style="text-align:justify;">Zones protégées par mot de passe: Certains documents peuvent être mis à disposition par le biais d’une zone protégée par mot de passe sur ce site web. Chaque mot de passe est destiné à être confidentiel et utilisé uniquement par la personne ou l’entité à qui il est émis. Ne divulguez pas votre mot de passe à une personne non autorisée. 

Si vous accédez aux matériaux par le biais d’une zone protégée par mot de passe, veuillez noter que les accords écrits entre vous et Vaccipha sont applicables, ainsi que toute disposition énoncée dans ce Matériel, régissent les droits et obligations respectifs des parties à l’égard de ces Documents. 

En particulier, les documents fournis par le biais d’une zone protégée par mot de passe sont généralement confidentiels et soumis à des limitations de divulgation et d’utilisation, et Vaccipha jouit d’une responsabilité limitée en ce qui concerne l’exactitude et l’exhaustivité de ces documents.
</p>

<p style="text-align:justify;">Services de Santé: Les applications et plateformes Vaccipha dont la coordination du développement a été initialement confiée à Enovpharm est placée sous la responsabilité de la Programme Elargi de Vaccination (PEV) du Ministère de la Santé de Côte d’Ivoire. Sa conception a pour objet :
La sensibilisation des utilisateurs de l’application sur les disponibilités de vaccins dans les pharmacies et cliniques privées dans leur alentours ;
L’obtention d’informations sanitaires en lien avec la vaccination de routine et de la Covid-19 avec possibilité de filtrage par lieu d’intérêt ;
La conservation des données de vaccination et de tests négatifs/positifs à la Covid-19, et de contre-indication à la vaccination ;
D’informer les utilisateurs de l’application de leur éligibilité au rappel vaccinal et de l’expiration de leur protection vaccinale en leur adressant des messages ciblés sur la base des données présents dans le Carnet ou le DSP.</p>

<p style="text-align:justify;">En tant qu'utilisateur de Vaccipha, vous devez informer votre professionnel de la santé de toutes les maladies, problèmes de santé, interventions chirurgicales, allergies, médicaments actuels et antérieurs avant toute prestation de soins de santé ou toute vaccination. 
Bien que notre équipe soignante puisse vous aider à mettre à jour votre Dossier de Soins Partagé (DSP) sur la base d’un accord mutuel, il est de votre responsabilité de mettre à jour tous les aspects du DSP de manière complète et correcte.
Pour un suivi efficace et des services de santé appropriés, le patient est tenu de saisir toutes les données de santé vitales via le système selon le calendrier et le niveau de détail recommandé. Les informations sur la santé, les lectures des signes vitaux, les dates, les horaires et les notes enregistrées par vous ou en votre nom doivent être exactes.
Les données des patients resteront confidentielles par Vaccipha et ne seront divulguées à personne dans des circonstances normales, sauf si la loi l'exige ou en cas d'urgence à la demande d'un autre prestataire de soins de santé.
</p>

<p style="text-align:justify;">L’équipe soignante vous fournira des instructions basées sur les signes vitaux que vous avez saisis. Le non-respect des instructions de l’équipe soignante sera considéré comme un non-respect des présentes conditions.
Le service en ligne de Vaccipha vise uniquement à aider à la prise de rendez-vous et à mieux comprendre l'état sanitaire sur la base des informations fournies pour démontrer son aptitude à la vaccination selon les lignes directives du Ministère en charge de la Santé. Vaccipha n'assumera aucune responsabilité légale quant à l'état de santé du patient. 
Le prestataire de soins de santé ne s'occupe pas des urgences via cette application. Dans ces circonstances, le patient doit contacter immédiatement le Service d'Aide Médicale Urgent (SAMU) au 185 ou l'hôpital le plus proche. 
</p>

<p style="text-align:justify;">Paiements: Tous les frais pour les services via les interfaces d'applications mobiles et Web de Vaccipha doivent être payés selon les conditions du service que vous utilisez. La collecte des paiements hors ligne pour certains de ces services est également prise en charge. Veuillez contacter l'équipe Vaccipha à ce sujet lors de votre rendez-vous.
Vaccipha pourra introduire d'autres services dans le système dont les tarifs vous seront communiqués au fur et à mesure de la mise en place de ces services. Le tarif applicable à un moment donné sera le tarif affiché au moment de l'utilisation du service.
Les paiements effectués pour tout service demandé ne seront pas remboursés si vous décidez d'y mettre fin.
</p>

<p style="text-align:justify;">Politique de confidentialité:Les données des applications de Vaccipha peuvent être créées par vos prestataires de soins de santé chez Vaccipha et par vous-même (le patient). Après vous être connecté à l'application avec votre compte utilisateur, les informations collectées sur notre portail Web et notre application mobile comprennent les éléments suivants :
Informations personnelles : les informations personnelles incluent le nom et l'adresse e-mail que vous fournissez lors de votre inscription. Il comprend également le numéro de téléphone, l'adresse et d'autres informations personnelles identifiables que vous pouvez choisir d'ajouter au profil de votre compte utilisateur. Aucune information sur le mode de paiement n'est stockée par cette application.
</p>

<p style="text-align:justify;">Informations personnelles sur la santé : informations personnelles sur la santé que les utilisateurs patients eux-mêmes ou les personnes autorisés de Vaccipha ou les prestataires de soins du Ministre de la Santé saisissent dans le dossier de santé personnel comprennent l'âge, le sexe, les problèmes de santé connus, les allergies, les vaccinations, et autres antécédents.
Données d'exploitation : afin d'améliorer votre expérience d'utilisation, l'application utilise des cookies, des journaux de serveur et d'autres mécanismes similaires pour activer certaines fonctionnalités et améliorer les services. Les cookies sont utilisés pour enregistrer les préférences de l'utilisateur, préserver les paramètres de session, faciliter l'authentification automatique des services fréquemment utilisés si vos paramètres l'exigent et pour permettre d'autres exigences fonctionnelles similaires. 
</p>


<p style="text-align:justify;">Vous pouvez utiliser les paramètres du navigateur pour désactiver les cookies lorsque vous utilisez nos services Web. Les seuls cookies tiers utilisés par l'application sont les cookies d'équilibrage de charge nécessaires au fonctionnement de cette application. Les cookies internes utilisés par cette application sont uniquement destinés à des fins de sécurité et d'authentification.
Le fournisseur de technologie prenant en charge cette plate-forme n'est pas responsable du respect de la politique de confidentialité des utilisateurs ayant accès aux données qu'elle contient. C'est la seule responsabilité de Vaccipha.
</p>

<p style="text-align:justify;">Utilisation des informations: Les informations personnelles et de santé ajoutées via cette application, lors de l'utilisation de ses services par les patients et les prestataires de soins de santé de Vaccipha, ne seront pas partagées, divulguées ou affichées à quiconque autre que les personnes autorisées par Vaccipha et les prestataires de soins de santé. Ils pourront mettre à jour les informations personnelles sur la santé de leurs propres patients en mettant à jour le profil de santé du patient, en ajoutant des notes et des rappels de vaccins.


Vous avez le droit de demander la suppression de votre compte utilisateur auprès de Vaccipha. Votre compte et toutes les données qu'il contient seront alors complètement supprimés. Nous nous réservons le droit de conserver les données de facturation uniquement pour nos dossiers financiers.
</p>

<p style="text-align:justify;">Informations de contact : la plateforme de services vous enverra des communications (e-mail et autres notifications), conformément à vos paramètres de notification, dans le cadre du fonctionnement essentiel des services dont vous pouvez bénéficier, tels que les informations de prise de rendez-vous, les alertes liées aux examens et aux consultations de votre service de santé. fournisseurs. Au moment de l'inscription, il vous sera demandé de vérifier votre adresse e-mail/contact. Vos coordonnées peuvent également être utilisées pour les services d’assistance client. De plus, nous pouvons utiliser vos coordonnées pour vous fournir des informations sur nos services. Si vous décidez à tout moment que vous ne souhaitez plus recevoir de telles informations ou communications de notre part, veuillez modifier les paramètres de notification applicables dans votre compte. Vos coordonnées ne sont partagées avec aucun tiers.
</p>


<p style="text-align:justify;">Données anonymisées : Vaccipha peut analyser les données anonymisées et agrégées collectées via les services, à des fins d'évaluation des résultats des soins de santé, des modèles d'exigences en matière de soins de santé et de mesurer l'efficacité des services et du contenu. Ces informations anonymisées et agrégées ne sont pas considérées comme des informations personnelles.
</p>

<p style="text-align:justify;">Divulgation d'informations: Nous pouvons divulguer toute information au gouvernement ou aux responsables de l'application de la loi si nous pensons que cela est nécessaire pour nous conformer à l'application de la loi et à la procédure judiciaire ; pour empêcher ou arrêter toute activité illégale, contraire à l'éthique ou pouvant donner lieu à des poursuites judiciaires ; pour protéger vos droits et votre sécurité, les nôtres ou ceux des autres.
Nous pouvons divulguer vos informations personnelles sur votre propre demande accompagnée de votre autorisation.
Vaccipha se réserve cependant le droit de désactiver ou de supprimer les comptes de tout utilisateur jugé en violation de nos conditions d'utilisation.
</p>


<p style="text-align:justify;">Sécurité du transport et du stockage: Toutes les données sont stockées uniquement sur les serveurs de notre fournisseur de technologie sur la plateforme hautement sécurisée OVH Control (qui est conforme à la réglementation HIPAA). Les mesures nécessaires pour assurer la transmission sécurisée des informations personnelles sur la santé avant qu'elles ne soient transférées sur Internet à partir de vos appareils personnels sont assurées. Cependant, vous devez être conscient des risques possibles liés à la transmission d'informations sur Internet, car aucune transmission de données ne peut être garantie comme étant sécurisée à 100 % et du risque que d'autres puissent trouver un moyen de contrecarrer nos systèmes de sécurité. Par conséquent, même si nous nous efforçons de protéger vos informations personnelles, nous ne pouvons assurer ou garantir la sécurité et la confidentialité des informations personnelles que vous nous transmettez, et vous le faites à vos propres risques.
</p>

<p style="text-align:justify;">Restriction sur l'âge: Tous les utilisateurs du portail patient et de l’application mobile de Vaccipha doivent être âgés de plus de 18 ans. Les parents, tuteurs/tuteurs et prestataires de soins de santé sont autorisés à fournir et à stocker des informations personnelles sur autrui, y compris les mineurs et les enfants. Tout utilisateur fournissant, stockant ou soumettant des informations au nom d'un enfant/personne sous tutelle assume l'entière responsabilité de la soumission, de l'utilisation et de la transmission de ces informations.
</p>

<p style="text-align:justify;">Divers: Ce site web est exploité et contrôlé par Enovpharm, partenaire technique de la DCPEV et du Ministère en charge de la Santé en Côte d’Ivoire. S’il est illégal ou interdit dans votre pays d’origine d’accéder ou d’utiliser ce site web, vous ne devez pas le faire.

Ceux qui choisissent d’accéder à ce site web en dehors de la Côte d’Ivoire y accèdent de leur propre initiative et sont responsables du respect de toutes les lois et réglementations locales. Ces Conditions, et tout litige relatif à ces Conditions ou à votre utilisation de ce site web ou du Matériel, seront régis à tous égards par les lois de l’État de Côte d’Ivoire, sans égard aux principes de conflits de lois. 
</p>

<p style="text-align:justify;">Sauf accord contraire écrit de Enovpharm, tout litige relatif aux présentes Conditions sera résolu exclusivement devant les tribunaux ivoiriens. Ces Conditions énoncent l’intégralité de l’accord entre vous et nous en ce qui concerne l’objet des présentes et remplacent tous les accords antérieurs relatifs à cet objet. 

Dans le cas où une disposition des présentes Conditions est jugée invalide ou inapplicable, cette disposition sera réputée séparée du reste des présentes Conditions et remplacée par une disposition valide et exécutoire aussi similaire dans l’intention que raisonnablement possible à la disposition ainsi séparée, et ne causera pas l’invalidité ou l’inapplicabilité du reste des présentes Conditions.
</p>

<p style="text-align:justify;">Modifications de cette politique: Veuillez noter que cette politique de confidentialité peut changer de temps en temps à mesure que nous continuons à proposer des services évolutifs. En cas de modification de notre politique de confidentialité, la version mise à jour sera publiée ici et prendra effet dès sa publication.
Les conditions mentionnées ci-dessus sont applicables tant que vous êtes une personne enregistrée utilisant le portail Web et les applications mobile de Vaccipha.
</p>


<p style="text-align:justify;">Coordonnées: Toute question, préoccupation ou plainte concernant ces Conditions doit être envoyée au Centre de Régulation  Vaccipha à vaccipha@enovpharm.com ou +225 25 22 01 86 44.
Date d'entrée en vigueur : 01/01/2023
©2022 Enovpharm/Vaccipha. Tous les droits sont réservés.
</p>


</div>
</div>
<!-- Contact End -->


   
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