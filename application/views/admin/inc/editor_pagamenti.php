<?php
/*
 * TMODEL
 *  *

$campi_tmp=array(
    "field"=>array(
        array(
            "id"=>"f1",
            "name"=>"iban",
            "value"=>"",
            "class"=>"",
            "label"=>"IBAN",
        ),
        array(
            "id"=>"f1",
            "name"=>"iban",
            "value"=>"",
            "class"=>"",
            "label"=>"IBAN",
        )
    )
);

 *  */



//print_r($modello);
$pagamento=null;
if(isset($modello[0])){
    $pagamento=$modello[0];
}else{
    $pagamento=$modello;
}

$campi=$pagamento["campi"];
$campi=json_decode($campi);


//print_r(json_encode($campi_tmp));?>


<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title"><?=t("modifica-pagamento")?></h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label><?=t("label-nome-pagamento")?></label>
        <input type="text" name="nome" value="<?=$pagamento["nome"]?>" class="form-control"/>
    </div>
     <div class="form-group">
        
        <label><?=t("label-descrizione-pagamento")?></label>
        <textarea class="form-control" name="descrizione"><?=$pagamento["descrizione"]?></textarea>
    </div>
    
    <?php
    /**
     * 
     */
    if(count($campi->field)>0){
            foreach($campi->field as $field){
                
                ?>
            <div class="row">
                <div class="col-xs-10">
                    <label><?=t($field->label)?></label>
                    <input type="text" name="fielddata[<?=$field->name?>]" 
                           class="form-control <?=$field->class?>"
                           value="<?=$field->value?>" />

                 </div>
                 <div class="col-xs-2">
                    <input type="checkbox" name="removeidem[]" class="" value="<?=$field->id?>">
                 </div>
            </div>
              <?php
            }
    
    }
    ?>
    <hr/>
    <?php /** NOT IMPLEMED*/?>
    <div class="form-group">
        <label>Crea un nuovo campo</label>
        <input type="text" name="new_label" class="form-control" value="" placeholder="Label" />
        <input type="text" name="new_name" class="form-control" value="" placeholder="Nome Variabile" />
        <input type="text" name="new_value" class="form-control" value="" placeholder="Valore Variabile" />
    </div>
    <?php /***/ ?>
    
</div>
<div class="modal-footer">
   <input type="hidden" name="uptype" value="<?=$pagamento["ptype"]?>" />
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <button type="submit" class="btn btn-primary btnsave">Save changes</button>
</div>
    
