<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//print_r($cliente);

?>
<form class="form" action="/<?=getLanguage()?>/clienti/save" method="POST" id="formsavecliente">
    
    
        <div class="row">
            
            <?php
                
            
                if( is_array($cliente) ){

                    $cliente=$cliente[0];
                }
                
                
               //print_r($cliente);
            ?>
            
            
            
            <div class="col-xs-12 col-sm-12 col-md-8 ">
                
                <div class="panel-group" id="datiutente" role="tablist" aria-multiselectable="true">
                
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h3 class="panel-title"><?=t("Dati Cliente")?></h3>
                        </div>


                        <div class="panel-body">


                            <div class="form-group">
                                <label><?=t("nome-cliente")?></label>
                                <input type="text" name="nome" class="form-control" value="<?=$cliente->nome_cliente?>" required>
                            </div>

                            <div class="form-group">
                                <label><?=t("cognome-cliente")?></label>
                                <input type="text" name="cognome" class="form-control" value="<?=$cliente->cognome_cliente?>">
                            </div>


                            <div class="form-group">
                                <label><?=t("telefono-cliente")?></label>
                                <input type="text" name="telefono" class="form-control" value="<?=$cliente->telefono?>">
                            </div>

                           <div class="form-group">
                                <label><?=t("mobile-cliente")?></label>
                                <input type="text" name="mobile" class="form-control" value="<?=$cliente->mobile?>">
                            </div>
                        </div>
                    </div>
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?=t("Dati-azienda-cliente")?></h3>
                        </div>


                        <div class="panel-body">
                           
                                <div class="form-group">
                                    <label><?=t("ragione-sociale-cliente")?></label>
                                    <input type="text" name="rag_sociale" class="form-control" value="<?=$cliente->rag_sociale_cliente?>" required>
                                </div>

                                <div class="form-group">
                                    <label><?=t("comune-cliente")?></label>
                                    <input type="text" name="comune" class="form-control" value="<?=$cliente->comune?>">
                                </div>

                                <div class="form-group">
                                    <label><?=t("provincia-cliente")?></label>
                                    <input type="text" name="provincia" class="form-control" value="<?=$cliente->provincia?>">
                                </div>

                                <div class="form-group">
                                    <label><?=t("cap-cliente")?></label>
                                    <input type="text" name="cap" class="form-control" value="<?=$cliente->cap?>">
                                </div>

                               <div class="form-group">
                                    <label>* <?=t("piva-cliente")?></label>
                                    <input type="text" name="piva" class="form-control" value="<?=$cliente->PIVA?>" required>
                                </div>

                               <div class="form-group">
                                    <label>* <?=t("cod-fisc-cliente")?></label>
                                    <input type="text" name="cod_fiscale" class="form-control" value="<?=$cliente->cod_fiscale?>">
                                </div>
                            
                                <div class="form-group">
                                     <label><?=t("email-cliente")?></label>
                                     <input type="text" name="email" class="form-control" value="<?=$cliente->email?>">
                                 </div>

                        </div>

                    </div>
                
                </div>
                   
                   
               
                
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-4">
                
                
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?=t("Note")?></h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            
                            <textarea name="note" class="form-control"><?=$cliente->note?></textarea>
                        </div>
                    </div>
                </div>
                
                
                <div class="box box-default <?=(!isset($smart) && $smart==false)?"":"hidden"?>">
                   
                    <div class="box-body">
                        <div class="form-group">
                            
                            <input type="hidden" name="codcliente" value="<?=($cliente->codcliente>0)?($cliente->codcliente):0; ?>">
                            
                            <a class="btn btn-danger" href="/clienti"><?=t("Torna-indietro")?></a>
                            <button type="submit" class="btn btn-success" name="savecliente" value="1"><?=t("Salva")?></button>
                            
                        </div>
                    </div>
                </div>
               
                
            </div>
        </div>
            
</form>