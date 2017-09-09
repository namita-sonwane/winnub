<?php

/* 
 * Nel template per l'invoice, rispetto al template Quote, c'è in più il metodo di pagamento scelto
 * 
 
 */
//print_r($invoice);

$cliente=$invoice->getCliente();

$cliente=$cliente[0];
$totale=0;

$totale_aliquote=array();
$costi_servizi=array();

?><!DOCTYPE HTML>
<html>
    <head>
    <title>Quote</title>
    <style type="text/css" media="print">
        body{
            margin: 0px;
            padding: 0px;
            
            font-family: Arial,sans-serif;
            background-color: #fff;
        }
    table{
        border-color: #999;
        border: 0px solid #ffffff;
        border-spacing: 0px;
    }
    table > tr{
         vertical-align: middle;
         border: 0px solid #fff;
    }  
    
    table > tr > th,
    table > tr > td{
       vertical-align: middle;
       border: 0px solid #afafaf;
       padding: 32px;
       line-height: 33pt;
    }
    
    table#a > tr > td{
        padding: 12em!important;
        border-bottom: 2px solid #a9a9a9;
        
        
        vertical-align: middle;
       
    }
    .note{
        width: 100%;
        border: 0px solid #fff;
        padding: 12px;
        margin-top: 6px;
        
    }
    .note p{
        padding: 12px;
        margin-left: 12px;
        margin-right: 12px;
    }
    .footerquote p{
        padding: 0x;
        margin: 0px;
    }
    p{
        padding: 0px;
        margin: 0px;
    }
    
    table.noborder,
    table.noborder tr td,
    table.noborder tr{
        border: 0px solid #fff;
        vertical-align: middle;
        line-height: 12pt;
        text-align: right;
        font-size: 10pt;
        margin: 0px;
        border-spacing: 0px;
        border-collapse: collapse;
        
    }
    
    
    table.footerquote > tr > td{
        line-height: 12pt;
       
    }
    table.intestazionetable,
    table.intestazionetable tr,
    table.intestazionetable tr td{
        border: 0px solid #fff;
        line-height: 22px;
    }
    table.intestazionetable td{
        border: 0px solid #fff;
    }
    .block50{
        width: 200pt;
        float: left;
        
    }
    .block50 img{
        max-width: 100%;
    }
    
    .border{
        border: 1px solid #a1a1a1;
    }
    
    #intestazione{
        
    }
  
    .business-image img{
        margin-top: 0px;
    }
    
    table.noborder1,
    table.noborder1 tr,
    table.noborder1 tr td{
        border: 0px solid #fff;
        line-height: 16pt;
        margin-bottom: 22px;
    }
    
    
    table{
        border-top: 0px solid #fff;
    }
    
    
    .blocks-c{
        text-align: center;
        border: 1px solid #000;
    }
    
     .logo-intestazione-fattura{
         margin: 0px;
         max-height: 90px;
     }
     .logo-intestazione-fattura img{
         max-height: 100px;
     }
     h3{
         margin: 0px;
     }
       
</style>

</head>


<body>
    

<?=$bloccopagamento?>
<br/>
<br/>

<table style="font-size: 8pt;line-height: 15px;">
     
        <tr style="background-color: #efefef;height: 18px;line-height: 8pt;text-align: center;">

            <td width="90"><?=t("cod.")?></td>
            <td width="325"><?=t("descr.")?></td>
            <td width="40"><?=t("qty.")?></td>
            <td width="120"><?=t("totale")?></td>
            <td width="60"><?=t("imposte")?></td>

        </tr>
        
            <?php

                $lista_tasse=array();
                
                $totalecarrello=0;
                $codiciarticoli=array();
                $costiservizi=array();
                $sommasconti=0;

                foreach($invoice->getItems() as $itm){

                    //print_r($itm);
                    $codiciarticoli[]=intval($itm["idarticolo"]);
                    $RIFERIMENTO_PRODOTTO= json_decode($itm["altro"]);

                    //print_r($RIFERIMENTO_PRODOTTO);
                   ?>
                    <!--item invoice article-->
                    <tr>

                        <td style="vertical-align: middle;"><?=(($itm["tipo_prodotto"]=="servizio")?"".t("servizio")." - ":"")?><?=$itm["cod_articolo"]?></td>
                        <td ><?=strip_tags($itm["descrizione"])?></td>
                        <td style="text-align: center;"><?=$itm["quantita"]?></td>
                        <td style="text-align: center;">€ <?=number_format($itm["prezzo"],2,".","")?></td>
                        <td style="vertical-align:baseline;text-align: center;">
                            <?=$itm["iva"]?>
                        </td>
                    </tr>
                    <!--end item invoice article-->
                    <?php
                    $costopertasse=0;
                    $valoresconto=0;
                    if($itm["tipo_prodotto"]=="servizio"){

                        $costos=(floatval($itm["prezzo"])*intval($itm["quantita"]));


                        $costopertasse=( (floatval($costos)*intval($itm["iva"]))/100 );

                        $costiservizi[]=$costos;

                    }else{//i prodotti rispetto ai servizi non sono soggetti a sconti stiche applicate.
                        $costot=(floatval($itm["prezzo"])*intval($itm["quantita"]));
                        $totalecarrello+=$costot;

                        //devo sottrarre gli sconti
                        if($invoice->sconto>0){
                            $valoresconto=($costot*$invoice->sconto)/100;
                        }
                        $costot=$costot-$valoresconto;

                        $sommasconti+=$valoresconto;

                        $costopertasse=( (floatval($costot)*intval($itm["iva"]))/100 );
                    }
                    //nella tassazione devo calcolare lo sconto eventuale
                    $lista_tasse[$itm["iva"]]+=$costopertasse;

                }
                ?>
        </table>

<br/>
<br/>

<table border="0" class="footerquote" id="finale" cellpadding="6" cellspacing='0'>
    
    <tr> 
        <td> <?php 
            //SEZIONE CON LE ALIQUOTE APPLICATE
            $tassetotali=0;
            
            echo "<b>".t("imposte-applicate")."</b>";
            foreach($lista_tasse as $val=>$aliq): ?>
            <?="<span>&nbsp;&nbsp;&nbsp; $val % : € ".number_format($aliq,2,","," ")."</span>"?>
            <?php
                $tassetotali+=$aliq;
            
            endforeach;
            ?>
             
            
        </td>
        
        <td>
            <table class="noborder">
                <tr>
                    <td> <b><?=t("totale-prodotti")?></b></td>
                    <td>
                       <?=number_format($totalecarrello,2,","," ");?>
                    </td>
                </tr>
            </table>
          
        
        </td> 
    </tr>
 
    <tr> 
        <td></td>
        
        <td>
           
                <table class="noborder">
                    <tr>
                        <td><b><?=t("sconto")?></b></td>
                        <td>

                           <?php
                            //applico lo sconto
                            if($invoice->codice_sconto>0){
                                
                                $totalecarrello=floatval($totalecarrello-($sommasconti));

                                echo " $invoice->codice_sconto % ";
                                echo " <br/> € ".number_format($sommasconti,2,","," ");
                            }
                            ?>
                        </td>
                    </tr>
                </table>
          
            
        </td>
    </tr>
     
    <tr>
        <td></td>
        
        <td>
            
                    <table class="noborder">
                       <tr>
                           <td> 
                               <b><?=t("servizi")?></b>
                           </td>
                           <td>
                               <?php 
                            if(count($costiservizi)>0){

                                foreach($costiservizi as $cost_s){
                                    ?>
                                 <?="<br/> € ".number_format($cost_s,2)?>
                            <?php
                                    $totalecarrello+=floatval($cost_s);
                                }

                            }
                            ?>
                           </td>
                       </tr>
                   </table>
         
            
        </td>
    </tr>
    
    <tr>
        <td></td>
        
        <td>
           
                <table class="noborder">
                    <tr>
                        <td><b><?=t("imponibile")?></b></td>
                        <td>
                            € <?=number_format($totalecarrello,2,","," ")?>
                        </td>
                    </tr>
                </table>
           
            
        </td>
       
    </tr>
    
    
    <tr>
      
        <td align='right'></td>
        
        <td>
            
                
                <table class="noborder">
                    <tr>
                        <td><b><?=t("imposte")?></b></td>
                        <td>
                            € <?=number_format($tassetotali,2,","," ");?> 
                        </td>
                    </tr>
                </table>
            
        </td>
    </tr>
    
    

    <tr align='center' >
        <td></td>
        
        <td align='center'>
          
                 <table class="noborder">
                    <tr>
                        <td> <span style="font-size: 16pt;font-weight: 400;text-transform: uppercase;"><?=t("totale")?></span></td>
                        <td>
                            <div style="font-size: 13pt;text-align: right;margin-bottom: 12px;">€ <?=number_format($totalecarrello+$tassetotali,2,","," ");?></div>
                        </td>
                    </tr>
                </table>
           
        </td>
    </tr>
   
    </table>

    
</html>