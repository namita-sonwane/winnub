<?php

/* 
 * 
 */
$gruppi=$modelloprodotti->getGruppi();


?><div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=t("dashboard-block1-title")?></h3>
                    </div>
                    <div class="box-body">
                        <?php if(count($gruppi)>0){?>
                        <div class="products-list product-list-in-box">
                           <?php
                           
                            foreach($gruppi as $k=>$gruppo){ ?>
                            <div class="list-group-item">
                                <div class=" product-d">
                                      <?php  
                                        foreach($gruppo as $g){
                                      ?>
                                          <div class="btn btn-default btn-sm product-block">
                                              <a href="<?php echo base_url($lingua."/dashboard/configura/".$g["nome"]."/".$g["idcategoria"])?>">
                                                  <?=t($g["valore"])?>
                                              </a>
                                          </div>
                                      <?php }?>
                                </div>
                            </div>
                            <!-- /.item -->
                            <?php 
                        
                            
                       }?>
                       </div>
                       
                       <?php
                       }else{
                           ?>
                        <div class="text-center" style="padding: 90px 0px 90px;">
                            <h3 class="text-center"><?=t("crea-nuova-categoria")?></h3>
                            <a href='#' class='btn btn-default' data-toggle="modal" data-target="#modalcategoria"> 
                           <?=t("crea-nuova-categoria")?></a>
                        </div>
                               
                       
                        
                        <?php
                        }
                       
                   ?>
                        
                    </div>
                    <div class="box-footer text-center">
                        <a href="<?=base_url("$lingua/dashboard/configura")?>" class="uppercase">
                            <?=t("mostra-tutti")?>
                        </a>
                    </div>
                    
                </div>