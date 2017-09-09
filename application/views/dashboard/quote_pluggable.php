<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?><div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?=t("Ultimi preventivi")?></h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th><?=t("codice-quote")?></th>
                    <th><?=t("nome-quote")?></th>
                    <th><?=t("data-quote")?></th>
                    <th></th>
                  </tr>
                  </thead>
                  
                  
                  <tbody>
                      <?php 
               
               $tabella=$this->user->getMy("preventivi",null," ORDER BY idpreventivo DESC LIMIT 5 ");
               foreach($tabella as $tb){
                  // print_r($tb);
                   
                   $urls=base_url(getLanguage()."/quote/detail/".md5($tb->idpreventivo));
               ?>
                  <tr>
                      <td><a href="<?=$urls?>"><?=$tb->codice_utente?></a></td>
                    <td><?=$tb->titolo?></td>
                    <td><?=date("d/m/Y H:i",  strtotime($tb->data))?></td>
                    <td>
                        <a href="<?=$urls?>">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                  </tr>
                <?php }?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?=base_url(getLanguage()."/quote/create")?>" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="<?=base_url(getLanguage()."/quote/all")?>" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>
            <!-- /.box-footer -->
          </div>