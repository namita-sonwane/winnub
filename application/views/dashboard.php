<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lingua=getLanguage();

//includo l'header
$this->view('limap/_header');

$this->view('limap/_sidebar');


//<a href="https://api.whatsapp.com/send?phone=393396350498" target="_blank" class="btn btn-danger">Scrivi messaggio</a>
        

?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      
     
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
      <ol class="breadcrumb">
       
        <li class="active"><?=t('dashboard');?></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <?php if($this->user->isAdmin()):?>
        <div class="row button-bars">
            
            <div class="col-xs-6 col-sm-3 text-center">
                <a href="/quote" class="btn btn-secondary btn-block-dash">
                    <i class="flaticon-edit sizex2"></i>
                    <br/>
                    <?=t("nuovo-preventivo-button-dash")?>
                </a>
                
            </div>
            <div class="col-xs-6 col-sm-3 text-center">
                
                <a href="/prodotti/create" class="btn btn-block-dash">
                     <i class="flaticon-cloud-computing sizex2"></i>
                    <br/>
                    <?=t("nuovo-prodotto-button-dash")?></a>
            </div>
            <div class="col-xs-6 col-sm-3 text-center">
                <a href="/invoice/create" class="btn btn-block-dash">
                    <i class="flaticon-list sizex2"></i>
                    <br/>
                    <?=t("nuova-fattura-button-dash")?></a>
            </div>
            <div class="col-xs-6 col-sm-3 text-center">
                <a href="/clienti/nuovo" class="btn btn-block-dash">
                    <i class="flaticon-user sizex2"></i>
                    <br/>
                    <?=t("nuovo-cliente-button-dash")?></a>
            </div>
            
            
        </div>
        <?php endif;?>
        
        <br/><br/>
        
        
         <?php 
         
            $this->view(
                "dashboard/report_fullpage_pluggable",
                    array(
                        "utente"=>$this->user,
                        "modelloprodotti"=>$this->modello_prodotti,
                        "lingua"=>getLanguage()
                    )
            ); ?>
        
        
        
        <?php /** DISABLED
        <div class="row hidden">
            
            
            <div class="col-xs-12 col-xs-4">
                <?php $this->view("dashboard/sales_pluggable.php"); ?>
            </div>
            
            <div class="col-xs-12 col-xs-4">
                <?php $this->view("dashboard/calendario.php"); ?>
            </div>
            
            <div class="col-xs-12 col-xs-4">
                 
                
                <?php   $this->view("dashboard/box_user_info",
                            array(  "modelloprodotti"=>$this->modello_prodotti,
                                    "lingua"=> getLanguage()
                                )
                        ); ?>
                
            </div>
            
        </div> */ ?>
        
        
        
        
        
        
        <div class="row">
            
           
            
            
            <div class="col-xs-12 col-sm-12 col-md-6 connectedSortable">
                
                 <?php $this->view("dashboard/quote_pluggable.php"); ?>
            </div>
            
             <div class="col-xs-12 col-sm-12 col-md-6 connectedSortable">
                
                <?php $this->view("dashboard/prodcategory_pluggable.php",
                        array("modelloprodotti"=>$this->modello_prodotti,
                            "lingua"=> getLanguage())); ?>
                
            </div>
            
        </div>
        
        
        
        
        
        
        

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
//includo l'header
$this->view('limap/_footer');