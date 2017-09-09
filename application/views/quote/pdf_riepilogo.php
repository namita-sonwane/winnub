<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */






/*
<style type="text/css" media="print">
        
        table > tr > td > p{
            margin: 0px!important;
            padding-top: 0px!important;
            line-height: 11pt!important;
        }
        
        body{
            margin: 0px;
            padding: 0px;
            line-height: 8px;
            font-family: Helvetica,sans-serif;
            background-color: #fffff;
        }
        table{
            background-color: #ffffff;
            border-color: #ffffff;
            border: 1px solid #ffffff;
            border-spacing: 0px;
            
        }
        table > tr{
             vertical-align: middle;
             border: 1px solid #ffffff;
             background-color: #ffffff;
        }  
        table > tr > td{
            vertical-align: middle;
            border: 1px solid #afafaf;
            padding: 12px;
            background-color: #ffffff;
        }
    
    table#a > tr > td{
        padding: 1em!important;
        border: 1px solid #a9a9a9;
        
        vertical-align: middle;
        
    }
    .note{
        width: 100%;
        border: 0px solid #ffffff;
        padding: 12px;
        margin-top: 6px;
        
    }
    .note p{
        padding: 12px;
        margin-left: 12px;
        margin-right: 12px;
    }
    .footerquote p{
        padding: 0px;
        margin: 0px;
    }
    p{
        padding: 0px;
        margin: 0px;
    }
    
    table.noborder,
    table.noborder tr td,
    table.noborder tr{
       
        vertical-align: middle;
        line-height: 12pt;
        text-align: right;
        font-size: 10pt;
        margin: 0px;
        border-spacing: 0px;
        border-collapse: collapse;
        border: 0px;
        font-family: Helvetica,sans-serif;
    }
  
    table.footerquote{
        border: 0px;
        background-color: #ffffff;
        padding: 0px;
        margin: 0px;
    }
    table.footerquote tr{
        border: 0px solid #fff;
        background-color: #ffffff;
    }
    table.footerquote > tr > td{
        line-height: 14pt;
        background-color: #ffffff;
    }
    table.intestazionetable,
    table.intestazionetable tr,
    table.intestazionetable tr td{
        border: 0px solid #ffffff;
    }
    table.intestazionetable td{
        border: 0px solid #ffffff;
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
        border: 0px solid #ffffff;
        line-height: 14pt;
        margin-bottom: 22px;
    }
    
    
    
    table{
      
    }
    table.noborder,
    table.noborder tr,
    table.noborder tr td{
        border-width: 0px!important;
        padding: 12px;
    }
    
    
   
</style>
 * 
 */?>
<style type='text/css'>
    table.footerquote{
        max-width: 90%;
        padding: 22px;
    }
    table.noborder{
        text-align: right;
        
    }
</style>
<br/>
<br/>
<table border="0" class="footerquote" id="finale" cellpadding="0" cellspacing='0'>
    
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
                       € <?=number_format($totale,2,","," ");?>
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
                 <table class="noborder" >
                    <tr>
                        <td> <span style="font-size: 16pt;font-weight: 400;"><?=t("totale")?></span></td>
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

   
    
