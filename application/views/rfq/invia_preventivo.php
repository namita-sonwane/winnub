<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start('ob_gzhandler');
$lingua=getLanguage();
//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');

$modello=$modellopreventivo;
$cliente=$modello->getCliente();
if(count($cliente)>0){
    $cliente=$cliente[0];
}

?><!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=t("titolo-pagina-invia")?> 
        <small><?=t("sottotitolo-pagina-invia")?> </small>
      </h1>
      <ol class="breadcrumb">
        <li>
            <a href="<?=base_url("/dashboard")?>">
                <i class="fa fa-dashboard"></i> <?=t("dashboard")?>
            </a>
        </li>
        <li class="active"><?=t("prodotti")?></li>
         <li class="active"><?=t("preventivio")?></li>
      </ol>
    </section>

    <!-- Main content -->
    <form class="form" id='form_carrello_rfqs' method="post" action="/<?=getLanguage()?>/requestforquotation/sendemail/<?=$codicepreventivo?>">
        
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
                                     <a href="/requestforquotation/manage_rfqs" class='btn btn-danger'>Annulla</a>
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
                                        
                                        <ul class="list-group">
                                            
                                        <?php 
										
										$informazioni=$modellopreventivo->infoInvio();
                                        
                                        foreach($informazioni["dati"] as $dato){
											
                                            ?>
                                            <li class="list-group-item">
                                                Oggetto: <span class="label label-default"><?=$dato["oggetto"]?></span><br/>
                                                A: <span class="label label-default"><?=$dato["email_destinatario"]?></span>
                                                &nbsp; in data: <span class="label label-default"><?=date("d/m/Y",  strtotime($dato["data_invio"]))?></span>
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

$this->view('limap/_footer');
ob_end_flush();
?>