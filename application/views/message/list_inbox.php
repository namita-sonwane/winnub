<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
              
                
                
              
              <div class="table-responsive mailbox-messages">
                  
                  
                <table class="table table-hover table-striped" id="messagetable">
                    <thead>
                        <tr>
                            
                            <td><?=t("email")?></td>
                            <td><?=t("oggetto")?></td>
                            <td><?=t("data")?></td>
                            
                            <td></td>
                        </tr>
                        
                    </thead>
                  <tbody>
                      
                      
                      <?php 
                      
                      if(count($messaggi)>0){
                      /**
                       * 
                       */
                      foreach($messaggi as $mess):?>
                  <tr>
                      
                   
                   
                    <td class="mailbox-name">
                       
                        
                      
                           <?php    
                                    if($mess->user==0){ ?>
                           
                                        <?=$mess->esternal?>
                           
                           <?php    }else{
                               
                                        $uinfo=  User_model::getUser($mess->user);
                                        $uinfo=$uinfo[0];
                            ?>
                                        <?=$uinfo->getNomeCompleto()?>
                           <?php    }?>
                      
                       
                       
                    </td>
                    <td class="mailbox-subject">
                           <?=$mess->subject?>
                    </td>
                    
                  
                    <td class="mailbox-date">
                        
                        <?=$mess->data?>
                        
                    </td>
                     
                    <td class="text-right">
                     
                         <?php if(isset($mess->esternalcode)):?>
                            <a href="/<?=getLanguage()?>/qdetail/<?=$mess->esternalcode?>" class="btn btn-sm btn-info"><?=t("vai al preventivo")?></a>
                        <?php endif;?>
                      
                        <a href="/<?=getLanguage()?>/message/delete/<?=$mess->idmessage?>" class="btn btn-sm btn-danger messageremove"><?=t("elimina")?></a>
                    </td>
                  </tr>
                  <?php endforeach;
                   }else{?>
                        <tr>
                            <td colspan="4" class="text-center">
                                <?=t("Non ci son messaggi da mostrare")?>
                            </td>
                        </tr>
                  <?php }?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              &nbsp;
            </div>
          </div>
          <!-- /. box -->