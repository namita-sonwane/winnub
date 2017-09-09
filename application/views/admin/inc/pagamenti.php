<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$pagamenti=$this->azienda->getPaymentTypes();


?>

<table class="table table-bordered">
    <tr>
        
        <th><?=t("codice")?></th>
        <th><?=t("descrizione")?></th>
        <th></th>
    </tr>    
    <?php foreach($pagamenti as $pay): ?>
    <tr>
        
        <td><?=$pay["nome"]?></td>
        <td><?=$pay["descrizione"]?></td>
        <th><a href="<?="/".getLanguage()."/admin/settings-pagamenti/".$pay["ptype"]?>" class="btn btn-default btn-sm" 
               data-target="#paymodal" 
               data-toggle="modal"
               data-type="ajax"
               data-load-remote="<?="/".getLanguage()."/admin/settings-pagamenti/".$pay["ptype"]?>"
               data-vref="<?=$pay["ptype"]?>"><i class="fa fa-edit"></i>
            </a>
        
            <a href="/<?=getLanguage()?>/admin/pagamenti/elimina/<?=$pay["ptype"]?>" class="btn btn-danger">
                
                <i class="fa fa-trash"></i>
            </a>
        
        </th>
    </tr>
    <?php endforeach;?>
</table>

<a href="<?="/".getLanguage()."/admin/settings-pagamenti/new";?>" class="btn btn-default btn-md"
   data-target="#paymodal" 
    data-toggle="modal"
    data-type="ajax"><?=t("Aggiungi")?> <i class="fa fa-plus"></i></a>

 <form class="form" method="post" action="/<?=getLanguage()?>/admin/save-settings-pagamenti" name="fmod" id="fmod01">
          
<div class="modal fade" tabindex="-1" role="dialog" id="paymodal" aria-labelledby="remoteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?=t("modifica-pagamento")?></h4>
      </div>
         <div class="modal-body">

            </div>
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</form>