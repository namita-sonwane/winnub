<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(count($modello)>0){
    $tassa=$modello[0];
}
//print_r($tassa);

?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title"><?=t("modifica-tassazioni")?></h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label><?=t("label-nome-tassazione")?></label>
        <input type="text" name="nome_tassazione" value="<?=$tassa["nome_tassazione"]?>" class="form-control"/>
    </div>
    <div class="form-group">
        
        <label><?=t("label-descrizione-tassazione")?></label>
        <textarea class="form-control" name="descrizione"><?=$tassa["descrizione"]?></textarea>
    </div>
    
    <div class="form-group">
        
        <label><?=t("label-aliquota-tassazione")?></label>
        <textarea class="form-control" name="aliquota"><?=$tassa["aliquota"]?></textarea>
    </div>
    
</div>
<div class="modal-footer">
    <div class="form-group">
        <input type='hidden' name='ttype' value='<?=$codice?>'>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btnsave"><?=t("Salva")?></button>
    </div>
   
</div>



