<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//print_r($_SESSION);
if( count($carrello)>0 ){ 
    
    
?>
<div class="col-xs-12">
    
    
    <div class="card">
        
    
      <div class="content">
    <?php 
    
    $totale=0;
    $totale_prodotti=0;
    
    foreach ($carrello as $k=>$items): 
        
        //print_r($items);
        
        $itemprod=$this->modello_prodotti->getArticoloCarrello($items["modello"],$items["profilo"]);
        
        
    
        $costo_misurato= getCostoMisura($items["larghezza"],$items["altezza"],$itemprod->costo);
        
                
        if($this->user->type==2){
            
          $sconto=$this->user->getSconti();
         
          $costo= $costo_misurato - (($costo_misurato*$sconto->valore)/100);
          
        }else{
            $costo=$costo_misurato;
        }
        
   ?>
        <div class="row">
            <div class="col-xs-12">
                <h5><?=$itemprod->nome_modello?></h5>
                <img src='<?=$itemprod->foto_modello?>' class="image" style="max-height: 40px;">
            
                <p><?=$items["materiale"]?></p>
                <p>Larghezza: <?=$items["larghezza"]?></p>
                <p>Altezza:  <?=$items["altezza"]?></p>
                <p>Profilo: <?=$items["profilo_codice"]?></p>
                <p>Colore: <?=$items["colore"]?></p>
                <p>Vetro: <?=$items["vetro"]?>
                 
                € <?=number_format($costo*$items["qty"],2)?>
                
            </div>
            
        </div>
        <hr/>
          
          
             
            
       
    <?php 
        $totale+=($costo*$items["qty"]);
        
        $totale_prodotti+=$items["qty"];
    
    endforeach;?>
       
        <div class="row">
            
            Totale:
            € <?=number_format($totale,2,","," ")?>
            <input type='hidden' name='tot_cart' id='s_totcart' value='<?=number_format($totale,2,".","")?>' />
            <br/>
            
        </div>
              
    
    </div>
    <div class="footer">
        
        <a href="/carrello" class="btn btn-success">VAI AL CARRELLO</a>

    </div>
    
    </div>
<?php

    $this->totale=$totale;
    $this->totale_prodotti=$totale_prodotti;


}else{?>
    <h1>Il tuo carrello è vuoto</h1>
    <p class="attachment-text">
        puoi sceglier creare il tio prodotto dal <a href="/dashbaord/configura">configuratore</a>
    </p>
    
<?php

}



?>