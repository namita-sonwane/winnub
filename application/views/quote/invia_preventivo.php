<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        &nbsp;
       
      </h1>
      <ol class="breadcrumb">
        <li>
            <a href="<?=base_url("/".getLanguage()."/dashboard")?>">
                <i class="fa fa-dashboard"></i> <?=t("dashboard")?>
            </a>
        </li>
        <li class="active"><a href="<?=base_url("/".getLanguage()."/quote/all")?>"><?=t("preventivi")?></a></li>
        
        <li class="active"><?=t("inviati")?></li>
      </ol>
    </section>

    <!-- Main content -->
    <form class="form" id='form_carrello' method="post" action="/<?=getLanguage()?>/quote/sendemail/<?=$codicepreventivo?>">
        
            <div class="content">
                
                
                
                
                <?php
                
                  $this->view('limap/_barra_strumenti',
                array(
                    "buttons"=>array(
                        //array("nome"=>t("nuovo-preventivo"),"href"=>"/".getLanguage()."/quote","class"=>"btn btn-actions-winnub1","icona"=>'<i class="fa fa-plus"></i>'),
                        array("nome"=>t("tutti-preventivi"),"href"=>base_url($lingua."/quote/all"),"class"=>"btn colore-secondario","icona"=>'<i class="fa fa-envelope"></i>')
                    )
                )
                );?>
                
                
              

                <div class="row">
                    
                    <div class="col-xs-12 col-sm-7">
                        
                        <div class="nav-tabs-custom">
                    
                                <ul class="nav nav-tabs">

                                    <li class="active">
                                        <a href="#sendnew" data-toggle="tab"><?=t('Nuovo invio')?></a>
                                    </li>

                                    <li>
                                        <a href="#activiti" data-toggle="tab"><?=t('Storico invii')?></a>
                                    </li>

                                </ul>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="sendnew">
                                        
                                        <div class="panel panel-default">
                            
                                            
                                           <!--// -->

                                           <div class="panel-body">
                                              

                                                <div class="form-group">
                                                   <label class=""><?=t("email-destinatario")?></label>
                                                   <input type="text" name="destinatario"
                                                          class="form-control input-md" 
                                                          value="<?=$cliente->email?>">
                                                </div>
                                                 <div class="form-group">
                                                   <label class="control-label"><?=t("oggetto-messaggio")?></label>
                                                   <input type="text" name="oggetto" class="form-control input-md">
                                                </div>
                                               
                                               <label><?=t("scrivi-messaggio")?></label>
                                               <textarea class='form-control' style='height: 200px;' name='messaggio'></textarea>
                                           </div>

                                           <div class='panel-footer'>
                                               <div class='form-control-static'>
                                                    <a href="/quote/all" class='btn btn-danger'>Annulla</a>
                                                   <button class='btn btn-success  pull-right' type='submit'>Spedici</button>

                                               </div>
                                           </div>
                                       </div>
                                        
                                    </div>
                                    <div class="tab-pane" id="activiti">
                                        
                                         <ul class="list-group">
                                            
                                        <?php 

                                        $informazioni=$modellopreventivo->infoInvio();
                                        //print_r($informazioni);
                                        foreach($informazioni["dati"] as $dato){
                                            
                                            ?>
                                            <li class="list-group-item">
                                                <?=t("Oggetto")?>: <span class="label label-default"><?=$dato["oggetto"]?></span><br/>
                                                <?=t("A")?>: <span class="label label-default"><?=$dato["email_destinatario"]?></span>
                                                &nbsp; <?=t("in data")?>: <span class="label label-default"><?=date("d/m/Y",  strtotime($dato["data_invio"]))?></span>
                                                <br><?=t("Messaggio")?>:<p><?php echo $dato["messaggio"]?></p>
                                            </li>
                                                
                                            <?php
                                        }
                                        
                                        /*
                                        <div class="box-header">
                                            <h4><?=t("Note")?></h4>
                                        </div>

                                            <?=($modellopreventivo->note==null)?"<p class='text-center'>".t("Non ci sono note")."</p>":$modellopreventivo->note?>

                                        */

                                        ?>
                                            </ul>
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
                                        
                                        <iframe src="<?="/".getLanguage()."/quote/create_pdf/".($codicepreventivo)?>" width="100%" height="500px"></iframe>
                                        
                                        
                                       
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