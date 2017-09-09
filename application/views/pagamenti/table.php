<?php defined('BASEPATH') OR exit('No direct script access allowed');

//includo l'header
$this->view('limap/_header');

$this->view('limap/_sidebar');

?>
    
   
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=t('Attiva-servizio')?>
        <small><?=t("stato-dei-pagamenti")?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Profilo</li>
      </ol>
    </section>
    
   

    <!-- Main content -->
    <section class="content">
        
        <div class="row" id="step1">
            
            
            <div class="col-xs-12 col-sm-6 bloccoprezzo">
                <div class="panel panel-default ">
                    <div class="panel-header text-center">
                        <h3 class=""><?=t('Profilo-base')?></h3>
                    </div>
                    <div class="panel-body">
                        
                        <div class="label-warning text-center" style="padding: 25px 0px 25px;">
                            <h1>GRATIS</h1>
                        </div>
                        
                        <ul class="list-group">
                            <li class="list-group-item">
                                Gestione prodotti
                                <span class="fa fa-check-circle-o fa-2x pull-right text-green"></span>
                            </li>
                            <li class="list-group-item">
                                Gestione clienti
                                <span class="fa fa-check-circle-o fa-2x pull-right text-green"></span>
                            </li>
                            <li class="list-group-item">
                                Gestione dipendenti
                                <span class="fa fa-check-circle-o fa-2x pull-right text-green"></span>
                            </li>
                            
                            <li class="list-group-item">
                                 <span class="fa fa-check-circle-o fa-2x pull-right text-yellow"></span>
                                Gestione dipendenti<br/>
                                <i>massimo 2 utenti di sistema</i>
                               
                            </li>
                            
                            <li class="list-group-item">
                                Mail marketing
                                <span class="fa fa-check-circle-o fa-2x pull-right text-gray"></span>
                            </li>
                            <li class="list-group-item">
                                Sales reporting
                                <span class="fa fa-check-circle-o fa-2x pull-right text-gray"></span>
                            </li>
                            
                        </ul>
                        
                        <div class="text-center">
                            <button type="button" class="btn btn-success btn-lg addplan" data-ajax="<?=base_url("/".getLanguage()."/profile/service-status/A")?>" data-container="#containerform"> Acquista adesso </a>
                        </div>
                       
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-6 bloccoprezzo">
                <div class="panel panel-default ">
                    <div class="panel-header text-center">
                        <h3 class=""><?=t('Profilo-business')?></h3>
                    </div>
                    <div class="panel-body">
                        
                        <div class="label-warning text-center" style="padding: 25px 0px 25px;">
                            <h1>€ 49,00/mese</h1>
                        </div>
                        
                        <ul class="list-group">
                            <li class="list-group-item">
                                Gestione prodotti
                                <span class="fa fa-check-circle-o fa-2x pull-right text-green"></span>
                            </li>
                            <li class="list-group-item">
                                Gestione clienti
                                <span class="fa fa-check-circle-o fa-2x pull-right text-green"></span>
                            </li>
                            <li class="list-group-item">
                                Gestione dipendenti
                                <span class="fa fa-check-circle-o fa-2x pull-right text-green"></span>
                            </li>
                            
                            <li class="list-group-item">
                                 <span class="fa fa-check-circle-o fa-2x pull-right text-yellow"></span>
                                Gestione dipendenti<br/>
                                <i>massimo 2 utenti di sistema</i>
                               
                            </li>
                            
                            <li class="list-group-item">
                                Mail marketing
                                <span class="fa fa-check-circle-o fa-2x pull-right text-gray"></span>
                            </li>
                            <li class="list-group-item">
                                Sales reporting
                                <span class="fa fa-check-circle-o fa-2x pull-right text-gray"></span>
                            </li>
                            
                        </ul>
                        
                        <div class="text-center">
                            <button type="button" class="btn btn-success btn-lg addplan" data-ajax="<?=base_url("/".getLanguage()."/profile/service-status/B")?>" data-container="#containerform"> Acquista adesso </a>
                        </div>
                       
                    </div>
                </div>
            </div>
            
            
            
           
            
            
            
        </div>
        
        <div id="containerform">
            
        </div>
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
//includo l'header
$this->view('limap/_footer');