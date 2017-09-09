<?php
$lingua=getLanguage();
//includo l'header


    $this->view('limap/_header');



    $this->view('limap/_sidebar');
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          &nbsp;
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?=t("dashboard")?></a></li>
        <li class="active"><?=t('configuratore_key');?></li>
      </ol>
        
    </section>
    
    

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
        <form method="post" action="<?=$lingua?>/profile/aggiungialcarrello/" id="form_preventivo" class="form form-horizontal" role="form">
            
        <input type="hidden" name="categoriaprodotto" value="<?=$categoriabase?>" id="categoriaprodotto">
        <input type="hidden" name="idcategoria" value="<?=$codicecategoria?>" id="idcategoria">
        
        
        <?php if(isset($codicecarrello)):?>
            <input type="hidden" name="codicecarrello" value="<?=$codicecarrello?>" id="codicecarrrello">
            <script><!--//
                    var carrellomap=<?=json_encode($datacarrello)?>;
                //--></script>
        <?php endif;?>
            
         <?php if(isset($codicepreventivo) && trim($codicepreventivo)!="" ):?>
            <input type="hidden" name="codicepreventivo" value="<?=$codicepreventivo?>" id="codicepreventivo">
        <?php endif;?>
            
            
        <?php if( isset($datacarrello) && is_array($datacarrello)  ){?>
            <script><!--//
                    var carrellomap=<?=json_encode($datacarrello)?>;
                //--></script>
         <?php }?>
       
        <div class="col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                     <h4 class="box-title"><?=t('configuratore_title_key');?></h4>
                </div>
                <div class="content">
                    <div class="row" id="rigammodelli">
                        <?php 
                        
                       
                        $modelli=$this->user->get_modelli($categoriabase,$codicecategoria);
                        
                       
                        
                        if( count($modelli)>0 ){

                            foreach($modelli as $prod):
                                //print_r($prod);
                                ?>
                                        <div class="prodotto" data-codice="<?=$prod->codice_modello?>" 
                                             data-mw='<?=$prod->min_width?>' data-mh='<?=$prod->min_height?>'>
                                            <div class="mask"> </div>
                                                <figure class="thumbnail text-center">
                                                    <img src="<?=$prod->getFoto()?>" class="img-responsive" style='max-height: 120px;'/>
                                                </figure>
                                                    
                                                <div class="content">
                                                        <h4><?=$prod->nome?></h4>
                                                        <p><?=$prod->descrizione?></p>
                                                </div>
                                           
                                        </div>
                                <?php endforeach;

                        }else{?>
                        <div class="hero text-center">
                              <h3>Non sono presenti prodotti  in questa sezione, comincia caricandone uno</h3>
    
                              <a href="<?="/".getLanguage()."/prodotti/create"?>" class="btn btn-primary btn-lg">
 Crea nuovo prodotto
</a>
                        </div>
                       

                     
                        <?php }



                    ?>


                    </div>
                    
                    
                  
                    
                </div>
            </div>
        </div>
        
    <?php  if( count($modelli)>0 ):?>
            
        
        <div class="col-xs-12 col-sm-9" id="st1">
        
        
         <!-- SELECT2 EXAMPLE -->
         <div class="box box-default collapsed-box" id="boxprimary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?=t("configura-prodotto")?></h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
            
                    <div class="col-xs-12">
                
                    <div class="hide" id="step1">
                
                    <div class="riga-calcolo form-group">


                        <label class=" col-xs-2">* <?=t("Seleziona-metodo-calcolo")?> </label> 
                        <div class="col-xs-8">
                            <select class="form-control ascolta" name="metodo_calcolo">
                                
                                <option value="3" selected> Prezzo fisso </option>
                                <option value="1" > Mq - Metro Quadrato</option>
                                <option value="2"> M - Metro Lineare</option>
                                
                                
                            </select>
                        </div>


                    </div>
                        
                    <div class="riga-misure form-group">


                        <label class=" col-xs-2">* <?=t("Larghezza")?> </label> 
                        <div class="col-xs-8">
                            <input type="text" name="larghezza" 
                                   class="form-control input-lg ascolta" 
                                   placeholder="<?=t("Inserisci-larghezza")?>" id="calcolo_larghezza" required/>
                            
                        </div>


                    </div>
                    <div class="riga-misure form-group">

                        <label class="col-xs-2">* <?=t("Altezza")?> </label>
                        <div class="col-xs-8">

                          <input type="text" name="altezza" class="form-control input-lg ascolta" placeholder="<?=t("Inserisci-altezza")?>" 
                                 id="calcolo_altezza" 
                                
                                 required/>
                        </div>


                    </div>

                    <div class="row">
                         <div id="errormessages"></div>
                    </div>

                </div>

                
            
            
                
                
            <hr/>
           
        
          </div><!-- /.colonna-->
          <!-- /.row -->
        </div>
                
        
        </div>
         
         <div class="box">
             <div class="box-header">
                 <h3 class="title-evid"><?=t("varianti-prodotto")?> </h3>
             </div>
             <div class="box-body">
                 
                 <div class="row" id="step_prof">
                
                     <div class="col-xs-12">
                         
                    
                    <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="tablevarianti">
                             <thead>
                                 <tr>
                                     <th><?=t("qty.")?></th>
                                     <th><?=t("immagine")?></th>
                                     <th><?=t("nome")?></th>
                                     <th><?=t("calcolo")?></th>
                                     <th></th>
                                     <th><?=t("seleziona")?></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr></tr>
                             </tbody>
                         </table>
                    </div>
                         
                     </div>
                     
                     
                     <div class="card">
                        <div class="card-header"></div>
                        <div class="content">
                            <div id="selezione_profilo_product"></div>
                        </div>
                    </div>
                
               
                </div>
                 
             </div>
             
         </div>
         
       
        
      <!-- /.box -->
      
      <?php /*
        <div class="row hidden" id="row_accessori">
          
          <div class="col-sm-12">
              
                <div class="box">
                    
                    <div class="box-header">
                        <h3 class="box-title"> Accessori</h3>
                    </div>
                    
                    <div class="box-body" id="viewaccessori">

                        <?php 
                   $accessori=$this->modello_prodotti->getAccessori();
                   foreach($accessori as $ac){?>
                            
                            <div class="accessorio" 
                          data-price="<?=$ac->costo?>" 
                          data-calcolo="<?=$ac->tipo_calcolo?>"
                          id="acc_<?=$ac->idaccessorio?>"
                          data-codice="<?=$ac->idaccessorio?>">
                                
                                <h3><?=$ac->nome?></h4>
                                <p><?=$ac->descrizione?></p>
                                <label class="costo_accessorio">€<span class="price"> <?=$ac->costo?></span></label>
                                <input type='hidden' name="accessorio[<?=$ac->idaccessorio?>]" value="0"/>
                            </div>
                        <?php }?>

                    </div>
                </div>
              
              
          </div>
          
        
          
        </div>
       */ ?>
      
    </div><!-- fine colonna sinistra-->
      
      
      
         
        <div class="col-xs-12 col-sm-3 ">
             
             <div class="panel panel-info">
                 <div class="panel-body" id="prodottipreconfigurati"></div>
             </div>
             
             <div class="panel panel-af hidden" id="guidamisurebox">
                 
                 
                 
                <div class="panel-header">
                    <h4 class="title"><?=t("Guida-misure")?></h4>
                </div>
                <div class="panel-body">
                    
                    <ul id="listaconversioni"></ul>
                </div>
                 
            </div>
             
            <div class="box">
                 
                 <div class="box-body">
                     
                     <div class="row">
                        
                          <div class="col-xs-12">


                                <label><?=t("codice-iva")?></label>

                               <div class="">
                                   <select name="codiceiva" class="form-control"><?=$this->user->selectOptionIvaCode()?></select>
                               </div>
                          </div>
                        
                    </div>
                     
                    <div class="row">
                        
                          <div class="col-xs-12">


                                <label><?=t("quantità")?></label>

                               <div class="">
                                   <input type="text" name="quantita" value="1" class="form-control input-lg" id="quantita"/>
                               </div>
                          </div>
                        
                    </div>
                     
                    <div style="margin: 0px;padding: 0px;font-size: 2em;">
                        <?=t("totale")?>: € <span id="totale">00.00</span>
                    </div>
                     
                     <div style="margin: 0px;padding: 0px;font-size: 1.2em;">
                        <?=t("costo-base")?>: € <span id="costobase">00.00</span>
                    </div>
                     
                    <input type="hidden" name="prezzo" id="price"/>
                    
                    <input type="hidden" name="prezzosingolo" id="prezzosingolo"/>
                    
                    
                    <br/>
                    <?php
                    
                    $testopulsante="aggiungi-al-preventivo";
                    
                    if( isset($codicecarrello) ){
                        
                        if( $codicepreventivo!="" ){
                            $testopulsante="salva-elemento-preventivo";
                        }
                    }
                    
                    ?>
                    <input type="button" name="conferma" value="<?=t($testopulsante)?>"  
                           class="btn btn-block btn-primary btn-lg" id="addtocart" />
                    
                 </div>
                 
                 
             </div>
             
         </div>
    
    <?php else:?>
    
    
    <?php endif;
?>
      
        </form>
            
       </div><!-- end row-->
        
    </section>
    <!-- /.content -->
    
    
     
  <!-- MODAL STATO CARRELLO--->
  <div class="modal fade" tabindex="-1" role="dialog" id="modalformsWinnub">
  <div class="modal-dialog">
    <form>
          
        <div class="modal-content">
          

          <div class="modal-body">

            <p>Il tuo carrello...il contenuto è richiamato tramite ajax...</p>
            <div class="content_carrello table-responsive"></div>
            
          </div>


          <div class="modal-footer">
           
            <a href="#" class="btn btn-success"><?=t("salva")?></a>
             <a href="#" class="btn btn-inverse" data-dismiss="modal" aria-label="Close"><?=t("annulla")?></a>
          </div>
        </div><!-- /.modal-content -->
    
    </form>
      
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  </div>
  <!-- /.content-wrapper -->
 

<?php

 $this->view('limap/_footer');