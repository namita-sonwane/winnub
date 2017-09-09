<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$cliente=new Cliente_model();
$dataprev=date("Y-m-d");
if(isset($modellopreventivo->data)){
    $dataprev=$modellopreventivo->data;
}
?>
<!--// careellointestazione box -->
<div class="row row-border">
    <div class="col-xs-4">
        <label><?=t("titpologia")?></label>
        <br/><?=t("preventivo")?>
    </div>
    <div class="col-xs-4">
         <label><?=t("data-preventivo")?></label>
         
         <input type="date" 
                value="<?=date("Y-m-d",strtotime($dataprev));?>" 
                name="data_preventivo" class="form-control" />
    </div>
    <div class="col-xs-4">
         <label><?=t("numerazione-preventivo")?></label>
         <input type="text" name="codice_vp" value="<?=$modellopreventivo->codice_utente?>" class="form-control">
    </div>
</div>
 <div class="row row-border">
    <div class='col-xs-12 col-sm-6' id='intestazioneaziendale'>
        
        <div class="bloccoazienda editable">
            <?php 
            
            if( isset($modellopreventivo) && $modellopreventivo->template_intestazione!=NULL){
                echo $modellopreventivo->template_intestazione;
                
                if($modellopreventivo->cliente>0){
                    $cliente=$modellopreventivo->getCliente();
                    $cliente=$cliente[0];
                }
                
            }else{
         ?>
            
                    <?php $logos=$this->user->getLogo();
                    if(isset($logos)){?>
                    <div class='business-image'>
                        <img src='/<?=$logos?>' class='img-responsive'>
                    </div>
                    <?php }?>
                    <h3><?=$this->user->fatturazione["rag_sociale"]?></h3>
                    <p><?=$this->user->fatturazione["indirizzo"]?>,  
                    <?=$this->user->resolveCap($this->user->fatturazione["comune"])?>, 
                    <?=$this->user->resolveComune($this->user->fatturazione["comune"])?></p>
                    <p>
                        <?=$this->user->fatturazione["piva"]?> -   <?=$this->user->fatturazione["cod_cf"]?>
                    </p>
                    <p>
                        <?=$this->user->fatturazione["telefono"]?> -   <?=$this->user->fatturazione["emailf"]?>
                    </p>
            <?php } ?>
        </div>
        
    </div>
    <div class='col-xs-12 col-sm-6'  id='intestazionecliente'>
       
        <div class="bloccoazienda">
            <br/>
            <div class="form-horizontal">
                
               <div class="form-group">
                   
                    <label for="inputcodclientes" class="col-sm-4 control-label"><?=t("seleziona-ciente")?></label>
                    <div class="col-sm-8">
                        
                        <select class="form-control" 
                                name="codicecliente" 
                                id="inputcodclientes" style="max-width: 90%;" >
                                
                               <?php 
                               if( $cliente->codcliente>0 ){ 
                                   echo "<option value='".$cliente->codcliente."' data-text='".$cliente->rag_sociale_cliente."' selected>".$cliente->rag_sociale_cliente."</option>";
                               }else{
                                   echo "<option value=\"null\" selected>Seleziona Cliente</option>";
                               }
                               ?>
                        </select>

                    </div>
               </div>
                
               <div class="form-group">
                   
                    <label for="inputrgs" class="col-sm-4 control-label">
                       <?=t("Rag-Sociale")?>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="inputrgs" placeholder="Ragione sociale" 
                             name="ragsocialecliente"
                             value="<?=$cliente->rag_sociale_cliente?>">
                    </div>
                  </div>
                <div class="form-group">
                   
                    <label for="inputcl2" class="col-sm-4 control-label">
                     <?=t("Indirizzo-cliente")?>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="inputcl2" placeholder="Indirizzo" 
                             name="indirizzocliente"
                             value="<?=$cliente->indirizzo?>">
                    </div>
                </div>
                <div class="form-group">
                   
                    <label for="inputcl3" class="col-sm-4 control-label">
                        <?=t("comune-cliente")?>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="inputcl3" placeholder="Cap, Comune" 
                             name="capcomunecliente"
                             value="<?=$cliente->comune?>">
                    </div>
                </div>
                <div class="form-group">
                   
                    <label for="inputcl4" class="col-sm-4 control-label">
                                       <?=t("piva-cliente")?></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="inputcl4" placeholder="P.IVA" name="pivacliente"
                             value="<?=$cliente->PIVA?>">
                    </div>
                </div>
                <div class="form-group">
                   
                    <label for="inputcl5" class="col-sm-4 control-label">
                        <?=t("cod-fiscale-cliente")?>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="inputcl5" placeholder="Codice Fiscale" name="cfcliente"
                             value="<?=$cliente->cod_fiscale?>">
                    </div>
                </div>
                <div class="form-group">
                   
                    <label for="inputcl6" class="col-sm-4 control-label">
                        <?=t("email-cliente")?>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="inputcl6" placeholder="Email" name="emailcliente"
                             value="<?=$cliente->email?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>