<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($preventivo);

$cliente=$preventivo->getCliente();

$cliente=$cliente[0];
$totale=0;

$totale_aliquote=array();
$costi_servizi=array();

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Quote</title>
    <style type="text/css" media="print">
        
        table > tr > td > p{
            margin: 0px!important;
            padding-top: 0px!important;
        }
        
        body{
            margin: 0px;
            padding: 0px;
            line-height: 8px;
            font-family: Helvetica,sans-serif;
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
    table > tr > td{
        vertical-align: middle;
       border: 0px solid #afafaf;
       padding: 12px;
    }
    
    table#a > tr > td{
        padding: 12em!important;
        border-bottom: 2px solid #a9a9a9;
        
        vertical-align: middle;
        line-height: 18px;
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
        font-family: Helvetica,sans-serif;
    }
    
    
    table.footerquote > tr > td{
        line-height: 14pt;
    }
    table.intestazionetable,
    table.intestazionetable tr,
    table.intestazionetable tr td{
        border: 0px solid #fff;
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
    
</style>

</head>


<body>
<table class="noborder1" cellpadding='0' cellspacing='2' border='0'>
        <tr>
        <td>
            <b><?=t("preventivo")?></b> <?=$preventivo->codice_utente?> 
        </td>
        <td align="center">

            <b><?=t("data")?></b> <?=date("d/m/Y",  strtotime($preventivo->data))?>
        </td>

        </tr>
</table>
    
<br/><br/>


<table class="intestazionetable" border='0' cellpadding="0" cellspacing="2">
        <tr>
            <td><?=$preventivo->template_intestazione?></td>

            <td class=''>
                <div style="text-align: center;border: 1px solid #000;">
                 <?=$intestazionecliente?>
                </div>
            </td>
        </tr>
</table>
<br/>

<br/>
<br/>
<!-- elementi ordine -->
<table border="0" cellpadding="8" class="table_elementi">
   
         <tr bgColor="#ededed" align="center">
            <th><?=t("Prod.");?></th>
            <th width="300" colspan="3"><?=t("Descrizione");?></th>         
            <th><?=t("Prezzo U.");?></th>
            <th width="40"><?=t("Qty.");?></th>
            <th><?=t("Totale");?></th>
            <th width="40"><?=t("Aliq.");?></th>
        </tr>
        
        <?php 
        
        foreach($preventivo->getItems() as $item){
            $itemprod=$this->modello_prodotti->getArticoloCarrello($item->prodotto);
            $costoitem=floatval($item->costo*intval($item->quantita));
           
            $showservizio="";
            
            $vat=($item->codice_iva);
            //print_r($item);
            if($itemprod->carattere_prodotto!="servizio"){
                //vanno calcolate sul prodotto scontato
                
                $totale+=$costoitem;
                
                //devo calcolarle le tasse aplicate sul prodotto socntato sul prodotto scontato
                //
                $valsconto=$costoitem;
                if($preventivo->codice_sconto>0){
                    $valsconto=floatval($costoitem-(($costoitem*$preventivo->codice_sconto)/100));
                }
                $totale_aliquote[$vat]=(($valsconto*$vat)/100)+floatval($totale_aliquote[$vat]);
            
                
            }else{
                $showservizio=t("servizio");
                $costi_servizi[]=array("nome"=>$item->descrizione,"valore"=>$costoitem);
                $totale_aliquote[$vat]=(($costoitem*$vat)/100)+floatval($totale_aliquote[$vat]);
            
            }
            
            
            ?>

            <tr>
                   <td>
                      <?=$showservizio?>
                      <?=$item->codice_identificativo?>
                      <?php
                        
                      $img=$itemprod->foto;
                      echo "<img src=\"$img\">";
                      ?>
                   </td>
                   <td colspan="3" style="vertical-align: middle;line-height: 10pt;" >
                        <?=($item->descrizione)?>
                      
                       <?=($item->descrizione_2)?>
                   </td>
                   

                   <td align="center" style='vertical-align: middle;alignment-adjust: middle;' valign="middle">
                       <p>€ <?=number_format($item->costo,2,","," ")?></p>
                   </td>
                   <td align="center">
                       <p><?=$item->quantita?></p>
                   </td>
                   <td align="center">
                       
                       <p>€ <?=number_format($item->costo*$item->quantita,2,","," ")?></p>
                       
                   </td>
                   <td align="center">
                       <p>% <?=$vat?></p>
                   </td>
                   
           </tr>
        
        <?php 
              
        
        } ?>
  
    
</table>

<br/>
<br/>
<br/>


<table border="0" class="footerquote" id="finale" cellpadding="6" cellspacing='0'>
    
    <tr> 
        <td> <?php 
            //SEZIONE CON LE ALIQUOTE APPLICATE
            $tassetotali=0;
            
            echo "<b>".t("imposte-applicate")."</b>";
            foreach($totale_aliquote as $val=>$aliq): ?>
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
                       <?=number_format($totale,2,","," ");?>
                    </td>
                </tr>
            </table>
          
        
        </td> 
    </tr>
 
    <tr> 
        <td></td>
        
        <td>
            <div>
                <table class="noborder">
                    <tr>
                        <td><b><?=t("sconto")?></b></td>
                        <td>

                           <?php
                            //applico lo sconto
                            if($preventivo->codice_sconto>0){
                                $totale=floatval($totale-(($totale*$preventivo->codice_sconto)/100));

                                echo " $preventivo->codice_sconto % ";
                                echo " <br/> € ".number_format($totale,2,","," ");
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
     
    <tr>
        <td></td>
        
        <td>
            <div>
                    <table class="noborder">
                       <tr>
                           <td> 
                               <b><?=t("servizi")?></b>
                           </td>
                           <td>
                               <?php 
                   if(count($costi_servizi)>0){

                       foreach($costi_servizi as $cost_s){
                           ?>
                        <?=" <br/>".strip_tags($cost_s["nome"])?> <?=" € ".number_format($cost_s["valore"],2)?>
                   <?php
                           $totale+=floatval($cost_s["valore"]);
                       }

                   }
                   ?>
                           </td>
                       </tr>
                   </table>
            </div>
            
        </td>
    </tr>
    
    <tr>
        <td></td>
        
        <td>
            <div>
                <table class="noborder">
                    <tr>
                        <td><b><?=t("imponibile")?></b></td>
                        <td>
                            € <?=number_format($totale,2,","," ")?>
                        </td>
                    </tr>
                </table>
            </div>
            
        </td>
       
    </tr>
    
    
    <tr>
      
        <td align='right'></td>
        
        <td>
            <div>
                
                <table class="noborder">
                    <tr>
                        <td><b><?=t("imposte")?></b></td>
                        <td>
                            € <?=number_format($tassetotali,2,","," ");?> 
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    
    

    <tr align='center' >
        <td></td>
        
        <td align='center'>
            <div>
                 <table class="noborder">
                    <tr>
                        <td> <span style="font-size: 16pt;font-weight: 400;text-transform: uppercase;"><?=t("totale")?></span></td>
                        <td>
                            <div style="font-size: 13pt;text-align: right;margin-bottom: 12px;">€ <?=number_format($totale+$tassetotali,2,","," ");?></div>
                        </td>
                    </tr>
                </table>
            </div>
           
               
                
           
        </td>
    </tr>
   
    </table>

    <br/>

    <h3><?=t("Note")?></h3>
    <div class="note" style="padding: 12px;">
        <p ><?=(!empty($preventivo->note))?$preventivo->note:t("Nessuna nota da mostrare")?></p>
    </div>
    
</body>
</html>