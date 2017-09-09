<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?><div class="">
                             
                            <div class="form-group">
                                <label><?=t("label_nome");?></label>
                                <input type="text" name="nome" class="form-control" value='<?=$this->user->profile["nome"]?>' />
                            </div>
                            <div class="form-group">
                                <label><?=t("label_cognome");?></label>
                                <input type="text" name="cognome" class="form-control" value='<?=$this->user->profile["cognome"]?>' />
                            </div>
                            
    
                            <div class="form-group">
                                <label><?=t("label_nazione");?></label>
                                <input type="text" name="nazione" class="form-control" value='<?=$this->user->profile["stato_nazione"]?>' />
                            </div>
                            
                             
                            <div class="form-group">
                                <label><?=t("label-indirizzo");?></label>
                                <input type="text" name="indirizzo" class="form-control" value='<?=$this->user->profile["indirizzo"]?>' />
                            </div>
                           
                            <div class="row form-group">
                                
                                 <div class='col-xs-4'>
                                   
                                    <label><?=t("label-provincia");?></label>
                                    <input name="provincia" class="form-control" 
                                            id="select_provincie" 
                                            type="text" value="<?=$this->user->profile["provincia"]?>">
                                        
                                  
                                    
                                 </div>
                                
                                 <div class='col-xs-4'>
                                    <label><?=t("label-comune");?></label>
                                    
                                     <input type="text" name="comune" class="form-control" 
                                            id="select_comune" value="<?=$this->user->profile["comune"]?>">
                                        
                                   
                                 </div>
                                
                                <div class='col-xs-4'>
                                    <label><?=t("label-cap");?></label>
                                    <?php
                             //controllo del cap
                             $caps=$this->user->profile["cap"];
                             if( !isset($caps) && $memcom["id"]>0){
                                 $caps=$memcom["cap"];
                             }
                                    ?>
                                    <input type="text" name="cap" class="form-control" value='<?=$caps?>' />
                          
                                 </div>
                                  
                                
                            </div>
                             
                            <div class="form-group">
                                <label><?=t("label-telefono");?></label>
                                <input type="text" name="telefono" class="form-control" value='<?=$this->user->profile["telefono"]?>' />
                            </div>
                             
                             <div class="form-group">
                                <label><?=t("label-mobile");?></label>
                                <input type="text" name="mobile" class="form-control" value='<?=$this->user->profile["mobile"]?>' />
                            </div>

                  </div>   