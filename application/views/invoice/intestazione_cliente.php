<?php

    $cliente=$mod->getCliente();
    if(count($cliente)>0){
    $cliente=$cliente[0];
    //$cliente=$mod;


    // create some HTML content
    
    $riga1[]="";
    $riga2[]="";
    
    if(trim($cliente->indirizzo)!=""){
        $riga1[]=$cliente->indirizzo;
    }
    if(trim($cliente->cap)!=""){
        $riga1[]=$cliente->cap;
    }
    if(trim($cliente->comune)!=""){
        $riga1[]=$cliente->comune;
    }
    if(trim($cliente->provincia)!=""){
        $riga1[]=$cliente->provincia;
    }

    if( trim($cliente->PIVA )!="" ){
        $riga2[]="<b>".t("iva-invoice-print")."</b> ".$cliente->PIVA;
    }
    
    if(trim($cliente->cod_fiscale)!=""){
        $riga2[]="<b>".t("cod-fiscale-invoice-print")."</b> ".$cliente->cod_fiscale;
    }
  ?>
<style>
  
    .blocks-c{
        line-height: 12px;
    }
    p{
        margin: 0px;
        padding: 0px;
    }
</style>
<div class='blocks-c'>
<p><b><?=((trim($cliente->rag_sociale_cliente)?$cliente->rag_sociale_cliente:""))?></b></p>
<p><?=implode(", ",$riga1)?></p>
<p><?=implode(" ",$riga2)?></p>
</div>
<?php }?>