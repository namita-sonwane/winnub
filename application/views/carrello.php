<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * ATTENZIONE IL MODELLO carrello.php viene caricato dal 
 * controller "Quote" e utilizzato per mostrare i dati del preventivo.
 * 
 * 
 * 
 */

$lingua=getLanguage();
//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar',array("pagina-active"=>$pagina_active,"sezione"=>$sezione));?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       &nbsp;
      </h1>
      <ol class="breadcrumb">
        <li>
            <a href="<?=  base_url("/dashboard")?>">
                <i class="fa fa-dashboard"></i> <?=t("dashboard")?>
            </a>
        </li>
        <li class="active"><?=t("prodotti")?></li>
         <li class="active"><?=t("preventivo")?></li>
      </ol>
    </section>

    <!-- Main content -->
    <form class="form" id='form_carrello' method="post" style='margin-top: 32px'>
        
        <?php
        if(isset($codicepreventivo) && is_object($modellopreventivo)){?>
        
        <div class="col-xs-10 col-sm-10 col-sm-push-1">
            
            <div class="box">
                <div class="box-body">
                    
                    <label><?=t("titolo-preventivo")?></label>
                    <input name="titolo" value="<?=$modellopreventivo->titolo?>" class="form-control input-lg">
                    
                    <input type="hidden" name="cod_carrello_tpx" value="<?=$codicepreventivo?>" id="cod_carrello_tpx" />
                    
                </div>
            </div>
        </div>
        
        <?php
        
        }
        
       ?>

<?php

//codice preventivo...
$this->view('carrello_content',array(
    "mode"=>"page",
    "lingua"=>$lingua,
    "codicepreventivo"=>$codicepreventivo,
    "modellopreventivo"=>$modellopreventivo,
    "carrello"=>$carrello
));



?>
        
         </form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <div class="modal fade" id="modalConfiguratore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="">
                  <div class="box box-solid">
                                    
                                    <div class="box-header">
                                         <div class="row">
                                            <div class="col-sm-12">
                                                <h4>
                                                    <?=t("Modal-title-note")?>
                                                </h4>
                                            </div>
                                         </div>
                                    </div>
                                    
                                    <div class="box-body">
                                        
                                        <div class="row">
                                            
                                            <div class="col-sm-12">
                                                    <div id="searchservices">

                                                   <div class="input-group">

                                                      <input type="text" name="services_search" class="form-control"  placeholder="<?=t("Cerca-servizi");?>"/>
                                                      <span class="input-group-btn">
                                                          <button type="button" class="btn btn-default btnadd">Cerca</button>
                                                       </span>
                                                   </div><!-- /input-group -->

                                               </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="container-fluid">
                                            
                                            <div class="col-xs-12">
                                                <div id="contentResultA1"></div>
                                            </div>
                                           
                                        </div>
                                       
                                    </div>
                                </div>
                                
                            </div>
                            
        </div>
    </div>
  </div>
<?php

//includo l'header
$this->view('limap/_footer');