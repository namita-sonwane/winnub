<?php
$lingua=getLanguage();

//imposto un contenitore per il calcolo dei servizi


//print_r($_SESSION);
if( count($carrello)>0 ){ 
    
?>
<div class="carrello-header table-responsive">
    
    <table class="table table-striped table-full-width">
        <thead class="text-center">
            
            <th><?=t("q-colonna1")?></th>
            <th><?=t("q-colonna2")?></th>
           
            <th><?=t("q-colonna3")?></th>
           
            <th><?=t("q-colonna4")?></th>
            <th><?=t("q-colonna5")?></th>
            <th><?=t("q-colonna6")?></th>
            <th><?=t("q-colonna7")?></th>
            <th><?=t("q-colonna8")?></th>
            
        </thead>
        <tbody>
    <?php 
    
    $totale=0;
    $totale_prodotti=0;
    
   
    foreach ($carrello as $k=>$items): 
        
        
        
        //
    
        $codiceiva=$items["iva"];
        $variantis=$items["varianti"];
        $costovar=0;
        
        //print_r($items);
        
        //la funzione getArticoloCarrello mi rilascia i dati di un prodotto con le 
        //impostazioni del carrello la rappresentazione del carrello 
        $itemprod=$this->modello_prodotti->getArticoloCarrello($items["modello"]);
        
        if($itemprod!=null){ // TROVO il modello
            
                
                $cat=$itemprod->getNameCategory();
                $nomecat=url_title($cat->nome);
                $codicecategoria=$cat->idcategoria;
                $CODICEINTERNO=$itemprod->codice_interno;
                    
                
                if( isset($items["price"]) && $items["price"]>0 ){
                    $costo_misurato = $items["price"];
                }else{
                    $costo_misurato = getCostoMisura($items["larghezza"],$items["altezza"],$itemprod->costo);
                }
                
                $costo=$costo_misurato;
                
                $blocco1="";
                $blocco2="";
                
                if( isset($items["descrizione"]) && trim($items["descrizione"])!=""  ){
                    $blocco1=$items["descrizione"];
                }else{
                    $blocco1="".$itemprod->nome."";
                }           
                

                if( isset($items["descrizione2"]) && trim($items["descrizione2"])!="" ){
                     $blocco2=$items["descrizione2"];
                }else{
                    $label_misure="";
                    if($items["larghezza"]>0 && $items["altezza"]>0){
                        $label_misure="<span class=\"label label-info label-misure\">(".$items["larghezza"]." mm x ".$items["altezza"]." mm)</span> ";
                    }
                    $blocco2=$label_misure."<p>".$itemprod->descrizione_tecnica." </p>";
                   
                }
                
        }else{
            
               
        }   
        
        
        
        
        
        if(count($variantis)>0 && is_array($variantis)){
            
            foreach($variantis as $vat){
                
                //print_r($variantis);
              
                $itemvariante=$this->modello_prodotti->getArticoloCarrello($vat["codice"]);        
                
                $costovar=( $vat["costo"] );
                
                
                if( trim($items["descrizione2"])==""){
                    
                    $blocco2.="<p>".$itemvariante->nome.":".$itemvariante->descrizione_tecnica." </p>";
                }
                
                $costo+=$costovar;
              
            }
        }
        
        ?>
                <tr data-codicecarrello="<?=$k?>">
                    
                    <td>
                        <?=($itemprod->carattere_prodotto=="servizio")?"SERVIZIO":"";?>
                        <?=($CODICEINTERNO);?>
                        <?="<img src='".$itemprod->foto."' class=\"image\" style=\"max-height: 60px;\" />"?>
                        <input type="hidden" name="itemlist[]" value="<?=$k?>" />
                    </td>
                    
                    <td class="prod editable editor_descrizione" style="" id="editor1_<?=$k?>">
                        <?=$blocco1?>
                    </td>
                    
                    <td class="prod editable editor_descrizione" style="" id="editor2_<?=$k?>">
                        <?=$blocco2?>
                    </td>

                    <td class="prod text-center" style="vertical-align: middle;" width="100">
                       
                        <input type="number" name="costounitario[<?=$k?>]" value="<?=($costo)?>" class="form-control prezzi_input"  />
                        
                    </td>

                    <td class="prod text-center" style="vertical-align: middle;" width="100">
                        
                        
                         <input type="number" name="qty[<?=$k?>]" value="<?=$items["qty"]?>" 
                                class="form-control quantita_input"  data-indice='<?=$k?>' />
                        
                    </td>

                    <td class="prod text-center dependent" style="vertical-align: middle;">
                        € <span><?=number_format( ($costo)*$items["qty"],2)?></span>
                    </td>
                    

                    <td class="prod text-center" style="vertical-align: middle;" width="80">
                        <select name="selectiva[<?=$k?>]"><?=_selectVatCode($codiceiva)?></select>
                    </td>

                    <td style="vertical-align: middle;text-align: right;">
                        <?php

                        if($modo=="preventivo"){
                     ?>
                        <a href="<?=base_url(getLanguage()."/quote/create/$nomecat/$codicecategoria/?quoteitem=$codicepreventivo&cartitem=$k")?>" data-nolock="true">Modifica</a>
                        
                        <?php }else{?>
                        
                         <a href="<?=base_url(getLanguage()."/quote/create/$nomecat/$codicecategoria/?cartitem=$k")?>" data-nolock="true">Modifica</a>
                         
                        <?php }?>
                         
                        <a href="<?=("/".getLanguage()."/quote/remove/item/$k")?>" class="btn btn-danger btn-sm buttonremoveitem">
                            <i class="fa fa-trash-o"></i>
                        </a>
                          
                    </td>

                </tr>
                <!-- item END -->
                <?php

      
                //caolcolo separatamente i servizi
                //print_r($items);
                if($itemprod->carattere_prodotto=="servizio"){
                    
                    $itm_calcolo=($costo*$items["qty"]);
                    $this->costiservizi[]=array("nome"=>$items["descrizione"],"valore"=>$itm_calcolo);
                    //$totale+=$itm_calcolo;
                }else{
                    $itm_calcolo=($costo*$items["qty"]);
                    $totale+=($itm_calcolo);
                    
                }
      
                //$valoreiva=resolveVatCode($codiceiva); SOSTTUZIONE DEL CODICE CON IL VALORE IVA
                $valoreiva=intval($codiceiva);
                
                if($itemprod->carattere_prodotto!="servizio"){
                    //calcolo il valore dello sconto applicato in fondo preventivo
                    //altrimenti in fonto fattura il calcolo dell'va non iene effetturato correttamente
                    $prodottoscontato=$itm_calcolo;
                    if(isset($modellopreventivo)){
                        $prodottoscontato=floatval($itm_calcolo-(($modellopreventivo->codice_sconto*$itm_calcolo)/100));
                    }
                }else{
                    $prodottoscontato=$itm_calcolo;
                }
                
                if(!isset($this->calcoli_iva[$codiceiva])){
                    
                    $this->calcoli_iva[$codiceiva]=array(
                        "valore"=> floatval((($prodottoscontato)*intval($codiceiva) )/100),
                        "aliquota"=> $valoreiva
                     );

                }else{
                    
                    $vx=floatval($this->calcoli_iva[$codiceiva]["valore"]);
                    
                    $this->calcoli_iva[$codiceiva]=array(
                        "valore"=>floatval(($prodottoscontato*intval($valoreiva) )/100)+$vx,
                        "aliquota"=> $valoreiva
                     );
                  //$this->calcoli_iva[$codiceiva]= $this->calcoli_iva[$codiceiva]+(( $costo*$items["qty"]) * $valoreiva )/100;
                }
                
                $totale_prodotti+=$items["qty"];
    
    endforeach;?>
        </tbody>
        
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: center;"><?php //$totale_prodotti ?></th>
                <th style="text-align: center;">
                    
                   <?php //number_format($totale,2,","," ")?>
                    <input type='hidden' name='tot_cart' id='s_totcart' value='<?=number_format($totale,2,".","")?>' />
                    
                </th>
                
            </tr>
        </tfoot>
         
    </table>
    <br/>
    
</div>

    <?php if($modo=="ajax"):?>
    <div class="">

        <a href="<?=$lingua?>/carrello" class="btn btn-success">VAI AL CARRELLO</a>

    </div>

    <?php
    endif;

    $this->totale=$totale;
    $this->totale_prodotti=$totale_prodotti;


}else{?>

    <h1>Il tuo carrello è vuoto</h1>
    <p class="attachment-text">
        puoi sceglier creare il tio prodotto dal 
        <a href="<?=base_url($lingua."/quote")?>" data-nolock="true"><?=t("vai-al-configuratore")?></a>
    </p>
    
<?php

}
