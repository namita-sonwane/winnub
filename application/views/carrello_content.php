<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



?>
   
    <div class="content">
        
        <div class="row">
            
            <div class="col-xs-12 col-sm-12">
                <div class="box">
                    <div class="box-body">
                        
                            <div class=''>
                            
                            <?php 
                            
                        /*
                         * L'iva viene calcolata in gruppo
                         * [codiceiva]=>totale es iva[1]=>100 iva[2]=>200
                         */
                        $this->calcoli_iva=array();
                        $this->costiservizi=array();
                           
                        if(isset($carrello) && count($carrello)>0):
                                    
                            if($mode!="ajax"){
                                
                                 $this->view('limap/carrello_intestazione_box',
                                         array("carrello"=>$carrello,
                                             "modellopreventivo"=>$modellopreventivo));


                                 $this->spedizione=$this->user->get_costi_Spedizione();//valore spedizione
                                 
                            }
                      ?>
                            
                            
                           
                          <hr/>
                           
                                 
                            <div class="table-responsive">
                                <?php $this->view('limap/_cart_box',array("carrello"=>$carrello,"modo"=>$modo));?>
                            </div>
                             
                            
                            <hr/>
                            
                            <?php  if($mode!="ajax"):?>
                            
                            
                           
                            
                            
                            
                            
                            <?php
                            
                         
                                $baseiva=22;

                                if($modo=="preventivo"){
                                    //print_r($modellopreventivo);
                                    $baseiva=$modellopreventivo->iva;

                                }  ?>
                            
                            <!-- riga iva-->
                            <div class="row">
                                
                                <div class="col-xs-12 col-sm-12 text-center">
                                    
                                
                                <?php
                                
                                /*
                                    $aliquote=$this->user->getAliquoteTasse(); 
                                    if(count($aliquote)>0){
                                    foreach($aliquote as $tassa){

                                    ?>
                                           <div class="col-xs-12">
                                               <label class="input-md"> 
                                                   <input type="radio" name="imposte" 
                                                          class="input-checkbox checkstyle" 
                                                          value="<?=$tassa["aliquota"]?>" 
                                                          <?=($baseiva== $tassa["aliquota"] )?"checked":""?>> 
                                                       &nbsp; <?=$tassa["descrizione"]?>
                                               </label>
                                           </div>
                                           <?php }

                                    }else{

                                        ?>
                                           <div class="message message-html">
                                               <p>Mancano le imposte iva 
                                                   <?php if($this->user->isAdmin()){?>
                                                   <a href="<?=base_url($lang."/admin/gestione/configurazioni")?>">gestisci tassazioni</a>
                                                   <?php }?>
                                               </p>
                                           </div>

                                <?php }  
                                */
                                
                                ?>
                                
                                    <div class="message">
                                        <p>
                                            <?=t("note-carrello-altro")?>
                                        </p> 
                                    </div>
                                    <button type="button" class="btn btn-inverse btn-lg" 
                                            data-toggle="modal" 
                                            data-target="#modalConfiguratore">
                                <?=t("aggiungi-servizi")?>
                                    </button>
                                </div>
                            </div>
                            
                             <?php endif;//fine verifica se la view è ajax?>
                             
                            
                            
                                
                            <?php else:
                                
                                echo "<h1>".t("preventivo-vuoto")."</h1>";
                                echo "<p>".t("crea-nuovo-prevenivo-indicazioni")."</p>";
                           
                           endif;
                      ?>
                            
                        </div>
                        
                
                    </div>
                    
                    
                </div>
            </div>
            
        </div>
        
        
        
       
       
        
        
        
        
        <div class="row">
            
            
            
            
                
                    
          

                <?php if( ($carrello!=null OR $modellopreventivo!=null)  && $mode!="ajax"):?>
                <div class="col-xs-12 col-sm-6 pull-right" >
                <div id="sidebarpage">
                <div class="box box-comment">
                    <div class="box-body">
                        
                        <?php 
                    
                   
                        
                    //SE l'utente è un privato non richiedo dati di fatturazione come PIVA
                    if( (isset($carrello)) ){
                        
                        //print_r($carrello);
                        
                       
                        $baseiva=22;
                        if($modo=="preventivo"){
                             //print_r($modellopreventivo);
                             //$baseiva=$modellopreventivo->iva;
                             
                             //print_r($modellopreventivo);
                             $scontistica=$modellopreventivo->codice_sconto;
                             
                        }else{
                            
                            $scontistica=0;
                        }  
                        
                   ?>
                        
                        <div class="row">
                            
                            <div class="col-xs-12">
                                <table id="table-cart" class="table table-bordered" style="font-size: 1.6em;">
                                
                                <tr>
                                    <td class="ftindicazione text-right"><?=t("cart-label-totale")?></td>
                                    <td> 
                                     <div class="input-group">
                                                <span class="input-group-addon" id="tt-lab">€</span>
                                                <span class="form-control" >
                                                    <?=number_format($this->totale,2,".","")?> 
                                                 </span>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- // -->
                                
                                <tr>
                                    <td class="ftindicazione text-right"> <?=t("cart-label-sconto")?> </td>
                                    <td>
                                         <div class="input-group">
                                                <span class="input-group-addon" id="scontistica-lab">%</span>
                                                <input type="text" name="scontistica" class="form-control" value="<?=$scontistica?>" id="scontistica"/>
                                        </div>
                                        
                                    </td>
                                </tr>
                                
                                
                                <?php
                                 //calcolo lo sconto...
                                    $sconto=($this->totale*$scontistica)/100;
                                    if($sconto>0){
                                        $this->totale = $this->totale - $sconto;
                                    }
                                ?>
                                
                                <tr>
                                    <td class="ftindicazione text-right"> <?=t("sconto-label-totale")?> </td>
                                    <td>
                                        
                                        
                                         <div class="input-group">
                                                    <span class="input-group-addon" id="sizing-addon2">€</span>
                                                    <input type="text" name="valore_sconto_2" class="form-control" value="<?=$this->totale?>"/>
                                            </div>
                                    </td>
                                </tr>
                                <?php
                                if(count($this->costiservizi)>0):
                                ?>
                                <tr>
                                    <td class="ftindicazione text-right">
                                         <?=t("servizi-label")?>
                                    </td>
                                    
                                    <td>
                                        <table>
                                    <?php 
                                   
                                    
                                    foreach($this->costiservizi as $servizio):
                                        
                                    ?>
                                       
                                    <tr>
                                        <td><?=$servizio["nome"]?></td>
                                        <td>
                                             <div class="input-group">
                                                    <span class="input-group-addon" id="sizing-addon2">€</span>
                                                    <span class='form-control'>
                                                       <?=number_format($servizio["valore"],2,".","")?>
                                                    </span>
                                            </div>
                                        </td>
                                     </tr>
                                    <?php 
                                    //aggiungo il costo del servizio
                                    $this->totale+=$servizio["valore"];
                                    
                                    endforeach;
                                    
                                    
                                    
                                    ?>
                                          </table>
                                    </td>
                                </tr> 
                                <?php endif;?>
                                
                                <tr>
                                    <td class="ftindicazione text-right"> <?=t("imponibile-label")?> </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="sizing-addon2">€</span>
                                            <span class='form-control form-inline'>
                                                <?=number_format($this->totale,2,".","")?>
                                            </span>
                                        </div>
                                        
                                    </td>
                                </tr>
                                
                                <tr id='rigaiva'>
                                    
                                    <td class="ftindicazione text-right"> <?=t("cart-label-tasse")?> </td>
                                    <td> <?php 
                                    $iva=0;
                                    
                                    //print_r($this->calcoli_iva);
                                    echo "<ul class='list list-unstyled' style='font-size: .8em;'>";
                                    
                                    foreach($this->calcoli_iva as $cod=>$valore_iva){
                                        echo "<li> %".$valore_iva["aliquota"]." - € ".number_format($valore_iva["valore"],2,".","")."</li>";
                                        $iva+=$valore_iva["valore"];
                                    }
                                    
                                    echo "</ul>";
                                    
                                    //echo "€ ".number_format($iva,2);
                                    
                                ?> 
                                    
                                    </td>
                                </tr>
                                
                                <tr id='rowtotale'>
                                    
                                    <td class="ftindicazione text-right"> <?=t("cart-label-totale")?> </td>
                                    <td>
                                    
                                        <div class="input-group">
                                                <span class="input-group-addon" id="sizing-addon2">€</span>
                                                <input type="text" 
                                                  id="totalecarrello1" value="<?=number_format($this->totale+$iva,2,".","")?>" 
                                                  name="totale_finale" > 
                                      </div>
                                    </td>
                                </tr>
                                
                            </table>
                            
                            </div>
                            
                            
                        </div>
                        
                        <?php }else{?>
                                <h3>Il tuo carrello è vuoto</h3>
                                <p>Devi inserire dei prodotti nel configuratore</p>
                        <?php }?>
                            
                            
                        
                        
                    </div>
                    
                    
                    
                </div>
                 
                
            </div>
            
            </div>
            <?php endif;?>
            
            
            <!-- start box buttons-->
            
            <div class='col-xs-12 col-sm-6'>
                    
                    
                     <!-- start note page -->
                        <div class='row'>
                             <?php  if(isset($codicepreventivo) && is_object($modellopreventivo)) :?>
                                    <div class="col-xs-12">
                                        <div class="box">
                                             <div class="box-header">
                                                <h3 class="box-title"><?=t("note-ordine")?></h3>
                                            </div>
                                            <div class="box-body">
                                                <textarea class="form-control" name="noteordine" 
                                                          style="
                                                          max-width: 100%;
                                                          min-height: 260px;"><?=$modellopreventivo->note?></textarea>
                                            </div>

                                        </div><!-- SEZIONE SCONTO -->
                                    </div>
                            <?php endif;?>
                        </div>
                        <!-- end note page -->
                    
                <?php if($modo=="carrello"):?>
                    
                        <?php  if( !isset($codicepreventivo) || isset($modellopreventivo) ){?>
                            <div class="panel">
                                <div class="panel-body">
                           
                                    <a href="<?=base_url("/".$lingua."/quote/savequote")?>" class="btn btn-default" id="savecart">
                                       <?=t("salva-preventivo")?>
                                    </a>

                                    <a href="/<?=$lingua?>/quote" class="pull-right btn btn-success" data-nolock="true">
                                        <?=t("aggiungi-altri-prodotti")?>
                                    </a>
                                </div>


                            </div>
                        
                    
               
                
                        <?php }?>
                        
                        
                 <?php else:?>
                    
                    <div class="panel">
                                <div class="panel-body">
                                    

                                  
                                    <a href="<?=base_url($lingua."/quote/create-pdf/".($codicepreventivo)."");?>" class="btn btn-default" target="new">
                                    <?=t("scarica-pdf")?>
                                    </a>
                                    
                                    <a href="<?=base_url($lingua."/quote/?quoteitem=$codicepreventivo")?>" class=" btn btn-info">
                                        <?=t("aggiungi-altro")?>
                                    </a>
                                    
                                      <a href="<?=base_url($lingua."/quote/savequote/$codicepreventivo")?>" class="btn btn-inverse btn-success pull-right" id="update_cart">
                                       <?=t("salva-modifiche")?>
                                    </a>
                                    
                                    
                                </div>


                            </div>
                    
                <?php endif;?>
                
               </div>
           
        </div>
        
        

    </div>
   