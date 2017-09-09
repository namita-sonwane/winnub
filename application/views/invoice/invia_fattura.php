<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lingua=getLanguage();
//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');

$modello=$modellofattura;
$cliente=$this->modello_cliente->get($modello->cliente);
if(count($cliente)>0){
    $cliente=$cliente[0];
}


?><!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=t("titolo-pagina-invia-fattura")?> 
        <small><?=t("sottotitolo-pagina-invia-fattura")?> </small>
      </h1>
      <ol class="breadcrumb">
        <li>
            <a href="<?=base_url("/dashboard")?>">
                <i class="fa fa-dashboard"></i> <?=t("dashboard")?>
            </a>
        </li>
        <li class="active"><?=t("fattue")?></li>
        <li class="active"><?=t("invia-fattura")?></li>
      </ol>
    </section>

    <!-- Main content -->
    <form class="form" id='form_send_invoice' method="post" action="/<?=getLanguage()?>/invoice/sendemail/<?=$codicefattura?>">
        
            <div class="content">

                <div class="row">
                    
                    <div class="col-xs-12 col-sm-7">
                        
                        <div class="panel panel-default">
                            
                             <div class="panel-heading">
                                 
                                 <div class="form-group">
                                     
                                    <label class="control-label"><?=t("oggetto-messaggio")?></label>
                                    <input type="text" name="oggetto" class="form-control input-md">
                                 </div>
                                 
                                 <div class="form-group">
                                    <label class=""><?=t("email-destinatario")?></label>
                                    <input type="text" name="destinatario"
                                           class="form-control input-md" 
                                           value="<?=$cliente->email?>">
                                 </div>
                            </div>
                            <!--// -->
                            
                            <div class="panel-body">
                                <label><?=t("scrivi-messaggio")?></label>
                                <textarea class='form-control' style='height: 200px;' name='messaggio'></textarea>
                            </div>
                            
                            <div class='panel-footer'>
                                <div class='form-control-static'>
                                     <a href="/quote/all" class='btn btn-danger'><?=t("annulla");?></a>
                                    <button class='btn btn-success  pull-right' type='submit'>Spedici</button>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class='col-xs-12 col-sm-5'>
                        
                        <div id='dataquote'>
                            <div class=''>
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title"><?=t("Informazioni-invio")?></h3>
                                    </div>
                                    <div class="box-body">
                                        <p>
                                          <?=t("Informazioni sul documento allegato");?>
                                        </p>
                                        
                                        <iframe src="<?="/".getLanguage()."/invoice/create_pdf/".MD5($modello->codfatt)?>" width="100%" height="500px"></iframe>
                                        
                                        <ul class="list-group" id="itemsend">
                                            
                                        <?php 
                                        //print_r($modello);
                                        $elementi_inviati=$modello->elementiInviati();
                                        ?><br/>
                                            
                                            <?php
                                      
                                       foreach($elementi_inviati as $elm){
                                           ?>
                                            <li class="list-group-item">
                                                <?=t("Oggetto");?>: <span class="label label-default"><?=$elm["oggetto"]?></span> <?=t("spedito a:");?> <span class="label label-default"><?=$elm["email_destinatario"]?></span>
                                                <br/>
                                                &nbsp; <?=t("in data: ");?><span class="label label-default"><?=date("d/m/Y",  strtotime($elm["data_invio"]))?></span>
                                            </li>
                                        <?php
                                                }

                                        ?>
                                            </ul>
                                    </div>
                                </div>
                                <br/>
                                
                                
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                      
            </div>
    </form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
<?php

//includo l'header
$this->view('limap/_footer');