<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



?><form class="form" action="/<?=getLanguage()?>/fornitori/save" method="POST" id="formsavefornitore">
    
    
        <div class="row">
            <?php
                
            
                if( is_array($fornitori) ){

                    $fornitori=$fornitori[0];
                }
                
                
               //print_r($cliente);
            ?>
            
            
            
            <div class="col-xs-12 col-sm-12 col-md-8 ">
                
                
                
                <div class="panel panel-default">
                    
                    <div class="panel-heading">
                        <!--<h3 class="panel-title">Dettagli fornitore</h3>-->
                    </div>
                    
                    
                    <div class="panel-body">
                        
                        
                        <div class="form-group">
                            <label><?=t("Nome Referente")?></label>
                            <input type="text" name="nome" class="form-control" value="<?=$fornitori->nome_fornitori?>" required>
                        </div>
                   
                        <div class="form-group">
                            <label><?=t("Cognome Referente")?></label>
                            <input type="text" name="cognome" class="form-control" value="<?=$fornitori->cognome_fornitori?>">
                        </div>
                        
                        
                        <div class="form-group">
                            <label><?=t("Telefono")?></label>
                            <input type="text" name="telefono" class="form-control" value="<?=$fornitori->telefono?>">
                        </div>

                       <div class="form-group">
                            <label><?=t("Mobile")?></label>
                            <input type="text" name="mobile" class="form-control" value="<?=$fornitori->mobile?>">
                        </div>
               
                    
                   
                    <div class="form-group">
                        <label><?=t("Ragione Sociale")?></label>
                        <input type="text" name="rag_sociale" class="form-control" value="<?=$fornitori->rag_sociale_fornitori?>" required>
                    </div>
                   
                    <div class="form-group">
                        <label><?=t("Comune")?></label>
                        <input type="text" name="comune" class="form-control" value="<?=$fornitori->comune?>">
                    </div>
                   
                    <!--<div class="form-group">
                        <label><?=t("Provincia")?></label>
                        <input type="text" name="provincia" class="form-control" value="<?=$fornitori->provincia?>">
                    </div>-->
                   
                    <div class="form-group">
                        <label><?=t("Cap")?></label>
                        <input type="text" name="cap" class="form-control" value="<?=$fornitori->cap?>">
                    </div>
                   
                   <div class="form-group">
                        <label>* <?=t("P. lva")?></label>
                        <input type="text" name="piva" class="form-control" value="<?=$fornitori->PIVA?>" required>
                    </div>
                   
                                  
                  
                   <div class="form-group">
                        <label><?=t("Categoria Prodotto")?></label>
						<div id="product_grp_data">
							<select class="form-control" id="product_group" name="product_group">
							  <option value="0">Please select</option>
							  
							  <option <?php if($fornitori->product_group == "Upvc Windows"){ echo 'selected' ;}?> value="Upvc Windows">Upvc Windows</option>
							  <option <?php if( $fornitori->product_group == "Aluminum windows"){ echo 'selected'; }?> value="Aluminum windows">Aluminum windows</option>
							  <option <?php if( $fornitori->product_group == "Interior doors"){ echo 'selected'; }?> value="Interior doors">Interior doors</option>
							  <option <?php if( $fornitori->product_group == "Home Furnishing"){ echo 'selected';}?> value="Home Furnishing">Home Furnishing</option>
							</select>
							  <?php
							  if($fornitori->product_group == 'Upvc Windows' || $fornitori->product_group == 'Aluminum windows' || $fornitori->product_group == 'Interior doors' || $fornitori->product_group == 'Home Furnishing')
							  {
							  	$another_pr_grp = '';
							  }
							  else
							  {
							   $another_pr_grp = $fornitori->product_group ;
							  }
							  ?>
							Or						
							<input value="<?php echo $another_pr_grp;?>" class="form-control" placeholder="Aggiungi una nuova categoria" type="text" name="another_pr_grp" class="editOption">
						</div>						
                    </div>
                   
                  
                   
                   <div class="form-group">
                        <label><?=t("Email")?></label>
                        <input type="text" name="email" class="form-control" value="<?=$fornitori->email?>">
                    </div>
                   
                   

                    
                    
                
                
               
                   
                      </div>
                </div>  
               
                
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-4">
                
                
                <!--<div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Note</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="note" class="form-control"><?=$fornitori->note?></textarea>
                        </div>
                    </div>
                </div>-->
                
                
                <div class="box box-default <?=(!isset($smart) && $smart==false)?"":"hidden"?>">
                   
                    <div class="box-body">
                        <div class="form-group">
                            
                            <input type="hidden" name="codfornitori" value="<?=($fornitori->codfornitori>0)?($fornitori->codfornitori):0; ?>">
                            
                            <a class="btn btn-danger" href="/fornitori"><?=t("Torna-indietro")?></a>
                            <button type="submit" class="btn btn-success" name="savefornitori" value="1"><?=t("Salva")?></button>
                            
                        </div>
                    </div>
                </div>
               
                
            </div>
        </div>
            
</form>

