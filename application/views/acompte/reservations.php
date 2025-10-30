<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('tpl/css_advanced'); ?>
</head>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">
  <?php $this->load->view('tpl/header'); ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php 
  $data['page'] = "res";
  $this->load->view('tpl/sidebar', $data); 
  ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Ventes & Caisses
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo site_url('Accueil');?>"><i class="fa fa-dashboard"></i> Accueil</a></li>
    <li class="active">Ventes & Caisses</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
<!-- Main row -->
<div class="row">
<!-- Left col -->
<div class="box">
<div class="box-header">
<h3 class="box-title" style="display: none;">Data Table With Full Features</h3>
<div class="btn-group" <?php if(empty($add_btn)) echo 'style="display : none !important;"'; ?>>
    <a href="<?php echo site_url('Reservations/ajouter');?>" role="button" class="btn btn-primary">
    <i class="fa fa-plus"></i> Ajouter une facture</a>
  </div>
</div>

<?php if ($affiche) { ?>
<!-- /.box-header -->
<div class="table-toolbar margin-bottom-25" align="center" style="margin-bottom: 25px;">
<form class="form-inline" action="<?php echo site_url('Reservations/rechercher');?>" method="post" role="form">
<div class="form-body">
  <span class="form-group">Période :</span>
   <div class="form-group">
    <div class="input-group date">
      <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </div>
      <input type="date" class="form-control"  name="date_min" 
      value="<?php echo $this->session->userdata('date_min'); ?>" placeholder="Début" required="">
    </div>
  </div>
  <div class="form-group">
    <div class="input-group date">
      <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </div>
    <input type="date" class="form-control" value="<?php echo $this->session->userdata('date_max'); ?>" name="date_max" placeholder="Final" required="">
    </div>
  </div>
  <div class="form-group">
  <div class="input-group date">
  <div class="input-group-addon">
    <i class="fa fa-flag"></i>
  </div>
  <select class="form-control" style="width: 100%" id="status" name="status">
    <option value="0" <?php if($this->session->userdata('status') == '0') echo "selected=true"; ?>> TOUS </option>
    <option value="1" <?php if($this->session->userdata('status') == '1') echo "selected=true"; ?>>EN COURS</option>
    <option value="3" <?php if($this->session->userdata('status') == '3') echo "selected=true"; ?>>PAYE</option>
    <option value="2" <?php if($this->session->userdata('status') == '2') echo "selected=true"; ?>>ANNULE</option>
  </select>
  </div>
</div>

  <input class="form-control btn-primary" name="search" type="submit"  value="Valider">
</div>
</form>
</div>

<div class="table-toolbar" align="center" style="margin-top: 25px;">
 <form class="form-inline">
    <div class="form-group" 
    style="font-size:16px;"> 
        <i class="fa fa-exchange" style="color:black;"></i> Chiffre d'affaires : <span style="color:black;"><?php 
          if($getStatsRes != NULL)
          {echo number_format((float)$getStatsRes->chiffre, 0, '.', ' ') ;}
          else
          {echo '0' ;}
          ; ?> F CFA</span>
    </div>  
    <span class="form-group" style="margin-left: 20px;"></span>
    <div class="form-group" 
    style="font-size:16px;">
        <i class="fa fa-money" style="color:red;"></i> Reste à Encaisser : 
        <span style="color:red;">
        <?php 
          if($getStatsRes != NULL)
          {echo number_format((float)$getStatsRes->restant, 0, '.', ' ') ;}
          else
          {echo '0' ;}
          ; ?> F CFA
        </span>
    </div> 
    <span class="form-group" style="margin-left: 20px;"></span>
    <div class="form-group" 
    style="font-size:16px;">
        <i class="fa fa-handshake-o" style="color:blue;"></i> Volume des réductions : 
        <span style="color:blue;">
        <?php 
          if($getStatsRes != NULL)
          {echo number_format((float)$getStatsRes->remise, 0, '.', ' ') ;}
          else
          {echo '0' ;}
          ; ?> F CFA
        </span>
    </div> 
    <span class="form-group" style="margin-left: 20px;"></span>
    <div class="form-group" 
    style="font-size:16px;">
        <i class="fa fa-money" style="color:green"></i> Montant En Caisse : 
        <span style="color:green;">
        <?php 
        if($getStatsRes != NULL)
        {echo number_format((float)$getStatsRes->montant, 0, '.', ' ') ;}
        else
        {echo "0" ;}
        ; ?> F CFA
        </span>
    </div>
</form>
</div>

<div class="box-body">
<table id="table" class="table table-bordered table-striped">
<thead>
<tr>
    <th>Code</th>
    <th>Clients (Mobile)</th>
    <th>Services (Catégories)</th>
    <th>Total</th>
    <th>En Caisse</th>
    <th>Remise</th>
    <th>Nombre Pers.</th>
    <th>Moyen Paie.</th>
    <th>Validité</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>

</tbody>
</table>
</div>
<!-- /.box-body -->
<?php } ; ?>

<?php if ($voirListeBails) { ?>
<div class="box-body">
<legend>Liste des réservations en attente de paiement pour :&nbsp;<b style="color: red"><?php echo $nomCompltetClient; ?></b></legend>
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
    <th>Code</th>
    <th>Clients (Mobile)</th>
    <th>Services (Catégories)</th>
    <th>Total</th>
    <th>En Caisse</th>
    <th>Restant</th>
    <th>Quantité</th>
    <th>Date Début</th>
    <th>Date Livraison</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($voirListeBails as $users) : ?>
<tr>
<td><?php echo $users->code_res; ?></td>
<td><?php echo $users->nom_clients; ?>&nbsp;<?php echo $users->prenom_clients; ?>&nbsp;(<?php echo $users->mobile_clients; ?>)</td>
<td><?php echo $users->libelle_services; ?>&nbsp;<?php echo $users->libelle_cat_services; ?>)</td>
<td><?php echo number_format((float)$users->montant_encaisser+(float)$users->montant_restant, 0, '.', ' '); ?></td>
<td><?php echo number_format((float)$users->montant_encaisser, 0, '.', ' '); ?></td>
<td><b style="color:red;"><?php echo number_format((float)$users->montant_restant, 0, '.', ' '); ?></b></td>
<td><?php echo (int)$users->nombreRes; ?></td>
<td><?php echo date("d-m-Y H:i:s", strtotime($users->date_visite_deb)); ?></td>
<td><?php echo date("d-m-Y H:i:s", strtotime($users->date_visite_end)); ?></td>
<td style="color:red;">EN ATTENTE</td>
<td><a class="btnStocks btn-default" href="#" data-id="<?php echo $users->code_res; ?>" data-label="<?php echo $users->code_res; ?>" data-montant="<?php echo $users->montant_restant; ?>" data-toggle="modal" data-target="#myModal" title="Faire un paiement individuel de facture"><i class="fa fa-money"></i></a></td>           
</tr>
<?php endforeach;?>   
</tbody>
</table>
</div>

<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title" align="center">Réservation numéro <b><span id="title"></span></b></h4>
</div>
<form class="comfirms1" action="<?php echo site_url('Reservations/versements')?>" method="post">
<div class="modal-body">
  <input type="hidden" name="codeRes" id="code" required>
  <div class="row form-group"> 
    <div class="col-md-4">
        <span>Type de Facturation :</span>
    </div>
    <div class="col-md-8"> 
    <label class="radio-inline">
      <input type="radio" name="typeradio" value="I"> Séparée (Individuelle)
    </label>
    <label class="radio-inline">
      <input type="radio" name="typeradio" value="G" checked> Cumulée (Groupée)
    </label>
    </div> 
  </div>
  <div class="row form-group">
    <div class="col-md-4">
        <span>Montant Net à Payer :</span>
    </div>
    <div class="col-md-8">
        <input type="text" readonly name="montant" placeholder="Montant" class="form-control" id="montantData">
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-4">
        <span>Moyens de Paiement :</span>
    </div>
    <div class="col-md-8">
      <select class="select2 form-control" name="modePayResID" required style="width:100%;">
      <?php foreach ($getModePay as $modes) : ?>
      <option value="<?php echo $modes->id_mode_pay; ?>"><?php echo $modes->libelle_mode_pay; ?></option>
      <?php endforeach; ?>  
   </select>
    </div>
  </div>
</div>
  <div class="modal-footer" style="text-align: center;">
    <button type="reset" class="btn btn-default" data-dismiss="modal">Annuler</button>
    <button id="comfirms1" type="submit" class="btn btn-success">Valider</button>
  </div>
</form>
</div>
</div>
</div>
<!-- PAGE CONTENT ENDS -->
<?php } ; ?>

<?php if ($modifier) { ?>
<!-- /.box-header -->
<div class="box-body">
<div class="">
<?php foreach ($modifier as $gets) : ?>
 <form class="comfirms1" action="<?php echo site_url('Reservations/update')?>" method="post" role="">
<legend style="text-align:center;">Modification de la réservation</legend>
<div class="form-body">
<input type="hidden" required name="code_res" value="<?php echo $gets->code_res; ?>"/>  

<div class="form-row">
<div class="form-group col-md-6">
  <label>Code :</label>
    <div class="input-group">
        <div class="input-group-addon">
             <i class="fa fa-lock"></i>
        </div>
      <input type="text" class="form-control" placeholder="Code" readonly="" name="code_res" value="<?php echo $gets->code_res; ?>"/>
    </div><!-- /.input group -->
</div>
<div class="form-group col-md-6">
<label>Date de saisie :</label>
<div class="input-group">
    <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control" placeholder="Date" value="<?php echo date("d-m-Y H:i:s", strtotime($gets->date_create_res)); ?>" readonly/>
  </div><!-- /.input group -->
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label>Client :</label>
<div class="input-group">
    <div class="input-group-addon">
        <i class="fa fa-users"></i>
    </div>
    <input type="text" class="form-control" placeholder="Client" name="montant_res" value="<?php echo $gets->nom_clients; ?>&nbsp;<?php echo $gets->prenom_clients; ?>&nbsp;(<?php echo $gets->mobile_clients; ?>)"  readonly/>
  </div><!-- /.input group -->
</div>
<div class="form-group col-md-6">
<label>Caissier(e) :</label>
<div class="input-group">
  <div class="input-group-addon">
      <i class="fa fa-user-secret"></i>
  </div>
  <input type="text" class="form-control" placeholder="Caissier" value="<?php echo $gets->nom_users; ?>&nbsp;<?php echo $gets->prenoms_users; ?>"  readonly/>
</div><!-- /.input group -->
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label>Montant Total :</label>
<div class="input-group">
  <div class="input-group-addon">
      <i class="fa fa-money"></i>
  </div>
  <input type="number" class="form-control" placeholder="Montant" required name="montant_res" value="<?php echo $gets->montant_res; ?>" min="0" <?php if($gets->adderResFK == NULL) echo "readonly"; ?>/>
</div><!-- /.input group -->
</div>
<div class="form-group col-md-6">
<label>Montant Encaissé :</label>
<div class="input-group">
  <div class="input-group-addon">
      <i class="fa fa-money"></i>
  </div>
  <input type="number" class="form-control" placeholder="Montant" required name="montant_encaisser" value="<?php echo $gets->montant_encaisser; ?>" min="0" <?php if($gets->adderResFK == NULL) echo "readonly"; ?>/>
</div><!-- /.input group -->
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label>Montant Restant :</label>
<div class="input-group">
    <div class="input-group-addon">
        <i class="fa fa-money"></i>
    </div>
    <input type="number" class="form-control" placeholder="Montant" required name="montant_restant" value="<?php echo $gets->montant_restant; ?>" min="0" <?php if($gets->adderResFK == NULL) echo "readonly"; ?>/>
  </div><!-- /.input group -->
</div>
<div class="form-group col-md-6">
<label>Montant de Remise :</label>
<div class="input-group">
  <div class="input-group-addon">
      <i class="fa fa-money"></i>
  </div>
  <input type="number" class="form-control" placeholder="Montant" required name="montant_variable" value="<?php echo abs($gets->montant_variable); ?>" min="0" <?php if($gets->adderResFK == NULL) echo "readonly"; ?>/>
</div><!-- /.input group -->
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
  <label>Date de Commande :</label>
    <div class="input-group">
      <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
      </div>
      <input type="date" class="form-control" placeholder="Date" required name="date_visite_deb" value="<?php echo date("Y-m-d", strtotime($gets->date_visite_deb)); ?>"/>
    </div><!-- /.input group -->
</div>
<div class="form-group col-md-6">
   <label>Date de Livraison :</label>
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="date" class="form-control" placeholder="Date" name="date_visite_end" value="<?php echo date("Y-m-d", strtotime($gets->date_visite_end)); ?>" required/>
      </div><!-- /.input group -->
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
  <label>Quantité demandée : :</label>
    <div class="input-group">
      <div class="input-group-addon">
          <i class="fa fa-pencil"></i>
      </div>
     <input type="number" class="form-control" placeholder="Nombre" name="nombreRes" value="<?php echo $gets->nombreRes; ?>" required <?php if($gets->adderResFK == NULL) echo "readonly"; ?>/>
    </div><!-- /.input group -->
</div>
<div class="form-group col-md-6">
<label>Commentaire / Détails :</label>
<div class="input-group">
<div class="input-group-addon">
    <i class="fa fa-pencil"></i>
</div>
<input type="text" class="form-control" placeholder="Commentaire" name="commentaire_res" value="<?php echo $gets->commentaire_res; ?>"/>
</div><!-- /.input group -->
</div>
</div>

  <!-- phone mask -->
</div>
<div class="form-group text-center">
<a class="btn btn-default" href="<?php echo site_url('Reservations');?>" class="form-control" >Annuler</a>
<input id="comfirms1" class="btn btn-primary" type="submit" class="form-control" value="Modifier"/>
</div>  
</form>
<?php endforeach;?>
</div>
</div>
<!-- /.box-body -->
<?php } ; ?>

<?php if ($ajouter) { ?>
<!-- /.box-header -->
<div class="box-body">
<div class="col-md-8">
<div class="box box-solid">
<div class="box-header with-border">
  <i class="fa fa-text-width"></i>
  <h3 class="box-title">Formulaire de caisses et ventes</h3>
</div>
<!-- /.box-header -->
<!-- /.box-header -->
<div class="box-body">
<div class="">
<form class="comfirms1" class="form-horizontal" action="<?php echo site_url('Reservations/inserer')?>" enctype="multipart/form-data" method="post" role="form">
<div class="form-body">

<div class="form-row">
<div class="form-group col-md-6">
<label>Type d'entrée :</label>
<div class="input-group">
  <div class="input-group-addon">
       <i class="fa fa-pencil"></i>
  </div>
  <select class="select2 form-control" name="typesDeTickets" id="typesDeTickets" required>
    <option value="0" selected="">MENU DU JOUR</option>
    <option value="1">RESERVATION</option>
  </select>
</div><!-- /.input group -->
</div>

<div class="form-group col-md-6">
<label>Date de réservation :</label>
<div class="input-group">
  <div class="input-group-addon">
       <i class="fa fa-calendar"></i>
  </div>
   <input type="date" class="form-control" placeholder="Date" required name="date_visite_res" id="date_visite_end" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>" readonly/>
</div><!-- /.input group -->
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label>Êtes vous déjà client ? :</label>
  <div class="input-group">
      <div class="input-group-addon">
           <i class="fa fa-users"></i>
      </div>
    <select class="select2 form-control" name="typeClients" id="typeClients">
      <option value="O" selected="">OUI</option>
      <option value="N">NON</option>
    </select>
  </div><!-- /.input group -->
</div>
<div class="form-group col-md-6" id="getClientsDiv">
    <label>Clients :</label>
    <div class="input-group">
      <div class="input-group-addon">
           <i class="fa fa-user"></i>
      </div>
      <select class="select2 form-control" name="ClientsId" id="ClientsId">
          <option>-----</option>
          <?php foreach ($getClients as $clis) : ?>
          <option value="<?php echo $clis->id_clients; ?>">   
           <?php echo $clis->nom_clients; ?>&nbsp;<?php echo $clis->prenom_clients; ?>&nbsp;(<?php echo $clis->mobile_clients; ?>)
          </option>
          <?php endforeach; ?>
      </select>
    </div><!-- /.input group -->
</div>
<div class="getClientsDivClass form-group col-md-6" style="display: none;">
    <label>Client :</label>
    <div class="input-group">
      <div class="input-group-addon">
           <i class="fa fa-user"></i>
      </div>
      <input type="text" class="form-control" placeholder="Nom & Prénoms" name="nameClient" />
    </div><!-- /.input group -->
</div>
</div>

<div class="getClientsDivClass form-row" style="display: none;">
<div class="form-group col-md-6">
  <label>Mobile :</label>
    <div class="input-group">
        <div class="input-group-addon">
             <i class="fa fa-phone"></i>
        </div>
      <input type="text" class="form-control" placeholder="+2250151889933" name="mobileClient" />
    </div><!-- /.input group -->
</div>
<div class="form-group col-md-6">
    <label>Email :</label>
    <div class="input-group">
        <div class="input-group-addon">
             <i class="fa fa-at"></i>
        </div>
      <input type="email" class="form-control" placeholder="Email" name="emailClient" />
    </div><!-- /.input group -->
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label>Catégories de services :</label>
<div class="input-group">
  <div class="input-group-addon">
       <i class="fa fa-home"></i>
  </div>
  <select class="select2 form-control" name="categorieProdFK" required="" id="categorieProdFK">
    <option>-----</option>
    <?php foreach ($getCategories as $types) : ?>
    <option value="<?php echo $types->id_cat_services; ?>"><?php echo $types->libelle_cat_services; ?></option>
     <?php endforeach; ?>   
  </select>
</div><!-- /.input group -->
</div>
<div class="form-group col-md-6">
<label>Liste des plats et boissons :</label>
<div class="input-group">
  <div class="input-group-addon">
       <i class="fa fa-shopping-bag"></i>
  </div>
  <input type="hidden" class="form-control" name="coutsProduits"  id="coutsProduits"/>
  <select class="select2 form-control" name="servicesFk" id="idProduitsEntreprise">
      
  </select>
</div><!-- /.input group -->
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label>Quantité Commandée :</label>
  <div class="input-group">
      <div class="input-group-addon">
           <i class="fa fa-shopping-cart"></i>
      </div>
    <input type="number" class="form-control" placeholder="Nombre" required name="nombre" min="1" value="1" id="nombre" max="10" />
  </div><!-- /.input group -->
</div>
<div class="form-group col-md-6">
<label>Type de Paiement :</label>
<div class="input-group">
    <div class="input-group-addon">
         <i class="fa fa-truck"></i>
    </div>
    <select class="form-control" name="typePaiement" required="" id="modeLivraison">
      <option value="I" selected>Immédiat</option>
      <option value="D">Cumule de factures</option>
    </select>
</div><!-- /.input group -->
</div>
</div>

<!-- Date dd/mm/yyyy -->
<div class="form-row" style="display: none;" id="getDivMontant">
<div class="form-group col-md-6">
<label>Montant Total à Payer:</label>
<div class="input-group">
  <div class="input-group-addon">
       <i class="fa fa-money"></i>
  </div>
<input type="number" class="form-control" placeholder="Montant" name="montant" id="montTotal" min="0" readonly="" />
</div><!-- /.input group -->
</div>
<div class="form-group col-md-6">
<label>Remise Appliquée :</label>
<div class="input-group">
<div class="input-group-addon">
     <i class="fa fa-handshake-o"></i>
</div>
  <input type="number" class="form-control" placeholder="Remise Appliquée" required name="montant_variable" value="0" min="0" id="montant_remise" />
</div><!-- /.input group -->
</div>
</div>

<!-- Date dd/mm/yyyy -->
<div class="form-row" style="display: none;" id="getDivComment">
<div class="form-group col-md-6">
<label>Moyen de paiement:</label>
  <div class="input-group">
      <div class="input-group-addon">
           <i class="fa fa-money"></i>
      </div>
    <select class="form-control" name="modePaysId" required="" id="modePaysId">
      <?php foreach ($getModePay as $modes) : ?>
      <option value="<?php echo $modes->id_mode_pay; ?>"><?php echo $modes->libelle_mode_pay; ?></option>
      <?php endforeach; ?>   
    </select>
  </div><!-- /.input group -->
</div>
<div class="form-group col-md-6">
<label>Détails / Commentaire :</label>
<div class="input-group">
    <div class="input-group-addon">
         <i class="fa fa-pencil"></i>
    </div>
    <input type="text" class="form-control" placeholder="Plat offert (100% réductions)" required name="commentaire_res" />
</div><!-- /.input group -->
</div>
</div>

</div>
<div class="form-group text-center" id="getDivSearch">
<input id="btnDivSearch" class="btn btn-primary" type="button" class="form-control" value="Rechercher"/>
</div>  
<div class="form-group text-center" style="display: none;" id="getDivFinal">
<a class="btn btn-default" href="<?php echo site_url('Reservations');?>" class="form-control" >Annuler</a>
<input id="comfirms1" class="btn btn-primary" type="submit" class="form-control" value="Confirmer"/>
</div>                                          
</form>
</div>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>

<div class="col-md-4" id="listeDesCoutsServices">
<div class="box box-solid">
<div class="box-header with-border">
<i class="fa fa-pencil"></i>
<h3 class="box-title">Présentation du menu du jour</h3>
</div>
<!-- /.box-header -->
<div class="box-body">
<!-- <p id="ligne_clotus"></p> -->
<table class="table table-bordered table-striped">
<thead>
  <th>Plats et boissons</th>
  <th>Montants</th>
  <th>Disponibilité / Quantité</th>
</thead>
<tbody>
<?php foreach ($getServices as $prods) : ?>
<tr>
<td><?php echo $prods->libelle_services; ?></td>
<td align="center"><?php echo number_format((float)$prods->couts_services, 0, '.', ' '); ?></td>
<td><?php echo $prods->quantite_dispo; ?></td>
<?php endforeach;?>   
</tbody>
</table>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>

<div class="col-md-4" id="facturesENattentes" style="display:none;">
<div class="box box-solid">
<div class="box-header with-border">
  <i class="fa fa-pencil"></i>
  <h3 class="box-title">Factures en attente de paiement</h3>
</div>
<!-- /.box-header -->
<div class="box-body">
<!-- <p id="ligne_clotus"></p> -->
<table class="table table-bordered table-striped">
<thead>
  <th>Code</th>
  <th>Chambres</th>
  <th>Date de Sortie</th>
</thead>
<tbody  id="ligne_clotus">
  
</tbody>
</table>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>

</div>
<!-- /.box-body -->
<?php } ; ?>

</div>
<!-- right col -->
</div>
<!-- /.row (main row) -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $this->load->view('tpl/footer'); ?>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<?php $this->load->view('tpl/js_advanced'); ?>

<script type="text/javascript">
//Initialize Select2 Elements
$('.select2').select2();

$('#comfirms1').off('dblclick'); 

$('#montant_remise').change(function ()
{   
    var montant = $("#idProduitsEntreprise option:selected").attr("getMontant");
    var nombre = $('#nombre').val();
    var montant_remise = $('#montant_remise').val();
    
    var montant_net = parseInt(montant)*nombre - parseInt(montant_remise);
    $("#montTotal").val(parseInt(montant_net));            
});

$("#typesDeTickets").change(function(){
    var typesDeTickets = $("#typesDeTickets").val();
    console.log(typesDeTickets);
    if(typesDeTickets == '1') 
    {   
        $("#date_visite_end").removeAttr("readonly");
    } 
    else 
    {   
        $("#date_visite_end").attr("readonly");
    } 
});

$('#categorieProdFK').change(function ()
{ 
    $('#idProduitsEntreprise').empty();
    var categoriesID = $('#categorieProdFK').val();
    $.post("<?php echo site_url("Reservations/getServicesByCategories") ?>", {categoriesID : categoriesID})
        .done(function (data) {
        
        if(data !== "")
        {    
            data = JSON.parse(data);
            $("#categorieProdFK").attr('disabled', true);    

            $("#idProduitsEntreprise").append('<option>-----</option>');
            $.each(data, function (index, value)
            {  
              $("#idProduitsEntreprise").append('<option value="' + value["id_services"] + '" getMontant="' + value["couts_services"] + '">' + value["libelle_services"] + ' (' + value["couts_services"] + ')</option>');
            });

        }
        else
        {  
            $.alert('Aucun service disponible pour le moment !');  
        }
        
    })
    .fail(function (error) {
        console.log(error);
    });           
});

$('#typeClients').change(function ()
{   
    var types = $('#typeClients').val();
    if (types == "N") 
    {
        $('#getClientsDiv').hide();
        $('.getClientsDivClass').show(); 
    }
    else
    {
        $('#getClientsDiv').show();
        $('.getClientsDivClass').hide(); 
    }
});

$('#idProduitsEntreprise').change(function ()
{   
    var nombre = $('#nombre').val();
    var montant = $("#idProduitsEntreprise option:selected").attr("getMontant");
    var montant_remise = $('#montant_remise').val();
    
    var montant_net = parseInt(montant)*nombre - parseInt(montant_remise);
    $("#montTotal").val(parseInt(montant_net));        
            
});


$('#nombre').change(function ()
{   
    var nombre = $('#nombre').val();
    var montant = $("#idProduitsEntreprise option:selected").attr("getMontant");
    var montant_remise = $('#montant_remise').val();
    
    var montant_net = parseInt(montant)*nombre - parseInt(montant_remise);
    $("#montTotal").val(parseInt(montant_net));
            
});

$('#modeLivraison').change(function ()
{   
    var radioValue = $('#modeLivraison').val();
    if(radioValue == 'D') 
    {   
        $('#ligne_clotus').empty();
        var ClientsId = $('#ClientsId').val();
        $.post("<?php echo site_url("Reservations/getListeFacturesImpayers") ?>", {ClientsId : ClientsId})
          .done(function (data) {
            
            console.log(data);
            if(data !== "")
            {    
               data = JSON.parse(data);
               $('#listeDesCoutsServices').hide();
               $('#facturesENattentes').show();      

               $.each(data, function (index, value)
               {  
                  $("#ligne_clotus").append('<tr><td>' + value["code_res"] + '</td><td>' + value["libelle_chambres"] + '</td><td>' + value["date_visite_end"] + '</td></tr>');
               });

            }
            else
            {   
                var montant = $('#montTotal').val();
                $('#listeDesCoutsServices').show();
                $('#facturesENattentes').hide();  
            }
            
        })
        .fail(function (error) {
            console.log(error);
        });
    } 
    else 
    {   
        $('#listeDesCoutsServices').show();
        $('#facturesENattentes').hide();  
    } 

});

$('#ClientsId').change(function ()
{   
    $('#ligne_clotus').empty();
    var ClientsId = $('#ClientsId').val();
    $.post("<?php echo site_url("Reservations/getListeFacturesImpayers") ?>", {ClientsId : ClientsId})
      .done(function (data) {
        
        console.log(data);
        if(data !== "")
        {    
           data = JSON.parse(data);
           $('#listeDesCoutsServices').hide();
           $('#facturesENattentes').show();      

           $.each(data, function (index, value)
           {  
              $("#ligne_clotus").append('<tr><td>' + value["code_res"] + '</td><td>' + value["libelle_chambres"] + '</td><td>' + value["date_visite_end"] + '</td></tr>');
           });

        }
        else
        {   
            var montant = $('#montTotal').val();
            $('#listeDesCoutsServices').show();
            $('#facturesENattentes').hide();  
            $.alert('Ce client n\'est pas hébergé au sein de l\'hotel');
        }
        
    })
    .fail(function (error) {
        console.log(error);
    });

});

$('#idServicesEntreprise').change(function ()
{   
    $('#getDivComment').hide();
    $('#getDivMontant').hide(); 
    $('#getDivFinal').hide(); 
    $('#btnDivSearch').show();

});


$('#btnDivSearch').click(function ()
{   
    var produitsID = $('#idProduitsEntreprise').val();
    var nombre = $('#nombre').val();
    var categorieProdFK = $('#categorieProdFK').val();
    var ClientsId = $('#ClientsId').val();
    var montant_remise = $('#montant_remise').val();

    if (ClientsId == '-----') 
    {
        $.alert('Prière choisir un client avant de continuer SVP !');
        return false;
    }

    if (categorieProdFK == '-----') 
    {
        $.alert('Prière choisir une catégorie de services SVP !');
        return false;
    }

    if (produitsID == '-----' || produitsID == null) 
    {
        $.alert('Prière choisir un service avant de continuer SVP !');
        return false;
    }

    $.post("<?php echo site_url("Produits/verifyStockProduits") ?>", {nombre : nombre, produitsID : produitsID})
        .done(function (data) 
        {
            console.log(data);
            if(data !== "OK")
            {    
                 $.alert('est insuffisant(e) pour cette opération !',  + data);
                 return false;
            }
            
        })
        .fail(function (error) {
            console.log(error);
        }); 

        $('#getDivComment').show();
        $('#getDivMontant').show(); 
        $('#getDivFinal').show(); 
        $('#btnDivSearch').hide();

        var getMontant = $("#idProduitsEntreprise option:selected").attr("getMontant");
        $("#coutsProduits").val(parseInt(getMontant)); 

        var montant_net = parseInt(getMontant*nombre) - parseInt(montant_remise);
        $("#montTotal").val(parseInt(montant_net)); 

});

var table;
$(document).ready(function() {
    //datatables
    table = $('#table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "pageLength": 50,
        "dom":  "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          "buttons": [
          { extend: 'excel', className: 'btn-default', text: 'EXPORT EXCEL'},
          { extend: 'pdf', className: 'btn-default', text: 'EXPORT PDF' },
          ],
        "columnDefs": [ { orderable: false, targets: [0] } ],
        "language" : {
          "sEmptyTable":     "Aucune donnée disponible dans le tableau",
          "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
          "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
          "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
          "sInfoPostFix":    "",
          "sInfoThousands":  ",",
          "sLengthMenu":     "Afficher _MENU_ éléments",
          "sLoadingRecords": "Chargement...",
          "sProcessing":     "Traitement...",
          "sSearch":         "Rechercher :",
          "sZeroRecords":    "Aucun élément correspondant trouvé",
          "oPaginate": {
            "sFirst":    "Premier",
            "sLast":     "Dernier",
            "sNext":     "Suivant",
            "sPrevious": "Précédent"
          },
          "oAria": {
            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
          },
          "select": {
                  "rows": {
                    "_": "%d lignes sélectionnées",
                    "0": "Aucune ligne sélectionnée",
                    "1": "1 ligne sélectionnée"
                  }  
          }
        },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Reservations/ajax_list')?>",
            "type": "POST",
        },
    });

});

$(document).on("click", ".btnStocks", function () {
    console.log($(this).attr("data-label"));
    $("#myModal").find('#title').text($(this).attr("data-label"));
    $("#myModal").find('#montantData').val($(this).attr("data-montant"));
    $("#myModal").find('#code').val($(this).attr("data-id"));
});
</script>
</body>
</html>
