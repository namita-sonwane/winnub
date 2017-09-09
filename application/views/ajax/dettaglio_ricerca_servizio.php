<?php


?>
<div class='row row-border result-product'>
    <div class='col-xs-12 col-sm-3'>
        
        <span class="thumbnail">
             <img src='<?=$immagine?>' class='img-responsive' style='max-height: 90px;'>
        </span>
           
    </div>
    
    <div class='col-xs-12 col-sm-3'>
        <h5><?=$nome?></h5>
        <hr/>
        <?=$descrizione?>
       
    </div>
    
    <div class='col-xs-12 col-sm-3'>
        
        <label><?=t("Prezzo")?>  € </label><input type='number' name='price_modal' value='<?=$costo?>'>
        <hr/>
        <label><?=t("Quantità")?> </label>   <input type='number' name='qty_modal' value='1' class='form-control'>
        
    </div>
    <div class='col-xs-12 col-sm-3'>
        <button type='button' class='btn btn-default select-product-service' data-modello='<?=$codice_modello?>'><?=t("Seleziona")?></button>
    </div>
</div>
