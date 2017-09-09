<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$profile=$this->user->fatturazione;
$statoservizio=$this->azienda->serivizioAttivo();

 print_r($statoservizio);

?>

<div class="panel panel-default">
    
    <div class="panel-header">
        
    </div>
    
    <div class="panel-body">

        <form action="/<?=getLanguage()?>/profile/payout" method="post" class="form form-horizontal" id="formft">
            <div class="row">


                <div class="col-xs-12 col-sm-8">

                    <fieldset>
                        <legend>Dati di fatturazione</legend>

                        <div class="form-group-lg">
                            <label><?=t('ragione-sociale')?></label>
                            <input type="text" class="form-control" 
                                   value="<?=$profile["rag_sociale"]?>"
                                   name="denominazione" 
                                   placeholder="<?=t('ragione-sociale')?>" required>
                        </div>
                         <div class="form-group-lg">
                            <label><?=t('PIVA')?></label>
                            <input type="text" class="form-control" 
                                   value="<?=$profile["piva"]?>"
                                   name="denominazione" 
                                   placeholder="<?=t('partita-iva')?>" required>
                        </div>
                        <div class="form-group-lg">
                            <label><?=t('CF')?></label>
                            <input type="text" class="form-control" 
                                   value="<?=$profile["cod_cf"]?>"
                                   name="denominazione" 
                                   placeholder="<?=t('ragione-sociale')?>">
                        </div>

                        <div class="form-group-lg">
                            <label><?=t('nome')?></label>
                            <input type="text" class="form-control" 
                                   value="<?=$profile["nome"]?>"
                                   name="nome" 
                                   placeholder="<?=t('nome')?>" >
                        </div>
                        <div class="form-group-lg">
                            <label><?=t('cognome')?></label>
                            <input type="text" class="form-control" 
                                   value="<?=$profile["cognome"]?>"
                                   name="cognome" 
                                   placeholder="<?=t('cognome')?>" >
                        </div>
                        <div class="form-group-lg">
                            <label><?=t('indirizzo')?></label>
                            <input type="text" class="form-control" 
                                   value="<?=$profile["indirizzo"]?>"
                                   name="indirizzo" 
                                   placeholder="<?=t('indirizzo')?>">
                        </div>
                        
                        <div class="form-group-lg">
                            <label><?=t('citta')?></label>
                            <input type="text" class="form-control" 
                                   value="<?=$this->user->resolveComune($profile["comune"])?>"
                                   name="comune" 
                                   placeholder="<?=t('citta')?>" >
                        </div>
                        <div class="form-group-lg">
                            <label><?=t('provincia')?></label>
                            <input type="text" class="form-control" 
                                   value="<?=$profile["provincia"]?>"
                                   name="provincia" 
                                   placeholder="<?=t('provincia/Citta/state')?>">
                        </div>
                        <div class="form-group-lg">
                            <label><?=t('email')?></label>
                            <input type="text" class="form-control" 
                                   value="<?=$profile["emailf"]?>"
                                   name="email" 
                                   placeholder="<?=t('e-mail')?>" required>
                        </div>

                    </fieldset>

                </div>
                
                <div class="col-sm-4">
                    <div class="panel">
                            <?php 
                            $costo=49.00;
                                
                            
                               
                                
                               echo ($statoservizio)?"SERVIZIO ATTIVO":"SERVIZIO SCADUTO";
                            
                                echo " - SCADE IL: ".$this->azienda->getScadenzaServizio();
                                
                                
                            
                            ?>
                            <div class="panel-header">
                                <h3><?=t("Piano-upgrade")?></h3>
                                 <?=$codiceselezione?>
                            </div>
                            <div class="panel-body">
                                 Piano selezionato di € <?=$costo?>
                                 <br/>
                                 Cambia durata del contratto 
                                 <select class="form-control planmonth" name="month_plan" id="planmonth">
                                    
                                    
                                     <option value="12" selected=""><?=t("Annuale")?></option>
                                     <option value="24"><?=t("Biennale")?></option>
                                 </select>
                                 
                                 
                                 <br/>
                                 
                                 <h4><?=t("Seleziona metodo di pagamento")?></h4>
                                 <select class="form-control paymethod" name="paymethod">
                                     <option value="null"><?=t("Seleziona-metodo-pagamento")?></option>
                                     <option value="bank"><?=t("Pagamento-bancario")?></option>
                                     <option value="paypal"><?=t("Pagamento-Paypal")?></option>
                                 </select>
                            </div>
                        
                            <div class="panel-footer text-center">
                                
                                <input type="hidden" name="baseplan" value="<?=$costo?>" id="baseplan" />
                                
                                <h3 id="totale">Totale: € <?=number_format($costo,2)?>
                                    <small>Iva Compresa: €   <?=number_format($costo-($costo/1.22),2);?></small>
                                    
                                    <input type="hidden" name="totalec" id="totalec"/>
                                    
                                    
                                </h3>
                                
                               
                                
                                    
                            </div>
                        
                    </div>
                    
                    <div id="payout"></div>
                    
                </div>

            </div>
        </form>
        
    </div>
</div>