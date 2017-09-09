<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$tasse=$this->azienda->getTassazioni();


?>
<table class="table table-bordered">
    <tr>
        <th><?=t("codice")?></th>
        <th><?=t("descrizione")?></th>
        <th><?=t("aliquota")?></th>
        
        <th></th>
    </tr>    
    <?php 
    
    if(count($tasse)>0){
    
    foreach($tasse as $tassa):
        
        ?>
    <tr>
        <td><?=$tassa["nome_tassazione"]?></td>
        <td><?=$tassa["descrizione"]?></td>
        <td><?=$tassa["aliquota"]?></td>
        
        <td>
            <a href="<?="/".getLanguage()."/admin/settings-tassazioni/".$tassa["idTassazione"]?>" class="btn btn-default btn-sm" 
               data-target="#tassemodal" 
               data-toggle="modal"
               data-type="ajax"
               data-load-remote="<?="/".getLanguage()."/admin/settings-pagamenti/".$tassa["idTassazione"]?>"
               data-vref="<?=$tassa["idTassazione"]?>"><i class="fa fa-edit"></i>
               
            </a>
              <a href="/<?=getLanguage()?>/admin/tasse/elimina/<?=$tassa["idTassazione"]?>" class="btn btn-danger">
                
                <i class="fa fa-trash"></i>
            </a>
        </td>
    </tr>
    
    <?php endforeach;
    }?>
    
</table>


<a href="<?="/".getLanguage()."/admin/settings-tassazioni/new";?>" class="btn btn-default btn-md"
   data-target="#tassemodal" 
    data-toggle="modal"
    data-type="ajax"><?=t("Aggiungi")?>  <i class="fa fa-plus"></i> </a>

 <form class="form" method="post" action="/<?=getLanguage()?>/admin/save-settings-tasse" name="fmod2" id="fmod02">
          
<div class="modal fade" tabindex="-1" role="dialog" id="tassemodal" aria-labelledby="remoteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?=t("modifica-tassazione")?></h4>
      </div>
      <div class="modal-body">

       </div>
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</form>