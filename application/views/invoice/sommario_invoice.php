<style>
    
    .footerquote{
        border: 1px solid #e4e4e4;
        line-height: 38px;
    }
    table.noborder{
        border-bottom: 1px solid #a4a4a4;
        line-height: 38px;
        text-align: left;
    }
    
    table.t1{
        width: 100%;
        float: left;
       
    }
    table.t2{
        width: 100%;
        float: left;
    }
    
</style>
<hr/>
<h3><?=t("riepilogo-fattura")?></h3>
<table style='margin: 0px;padding: 0px;' collspacing='0' cellspacing='0' border='0'>
    
    <tr>
        <td>
            <table class="t1 footerquote" border="0" style='margin: 0px;padding: 0px;' colspacing='0' celspacing='0'>
                <tr>
                    <td style="line-height: 23px;padding-left: 22px;"><?php 
                        //SEZIONE CON LE ALIQUOTE APPLICATE
                        $tassetotali=0;

                        echo " <b>".t("imposte-applicate")."</b><br/>";
                        foreach($lista_tasse as $val=>$aliq): ?>
                            <?="&nbsp;&nbsp; $val % : € ".number_format($aliq,2,","," ")."<br/>"?>
                        <?php
                            $tassetotali+=$aliq;

                        endforeach;
                        ?>
                    </td>
                </tr>
            </table>
        </td>

        
    <td>
    <table border="0" class="t2 footerquote">
    
    <tr> 
        
        <td>
            <table class="noborder">
                <tr>
                    <td><b><?=t("totale-base")?></b></td>
                    <td>€ <?=number_format($totalecarrello,2,","," ");?></td>
                </tr>
            </table>
          
        
        </td> 
    </tr>
 
    <tr> 
       
        <td>
           
                <table class="noborder">
                    <tr>
                        <td><b><?=t("sconto")?></b></td>
                        <td><?php
                            //applico lo sconto
                            if($invoice->codice_sconto>0){
                                
                                $totalecarrello=floatval($totalecarrello-($sommasconti));

                                echo " $invoice->codice_sconto % ";
                                echo " - € ".number_format($sommasconti,2,","," ");
                            }
                            ?>
                        </td>
                    </tr>
                </table>
          
            
        </td>
    </tr>
     
    <tr>
        
        <td>
            
                    <table class="noborder">
                       <tr>
                           <td><b><?=t("servizi")?></b>
                           </td>
                           <td><?php 
                            if(count($costiservizi)>0){

                                foreach($costiservizi as $cost_s){
                                    ?><?="<br/> € ".number_format($cost_s,2)?>
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
        
        
        <td>
           
                <table class="noborder">
                    <tr>
                        <td><b><?=t("imponibile")?></b></td>
                        <td>€ <?=number_format($totalecarrello,2,","," ")?></td>
                    </tr>
                </table>
           
            
        </td>
       
    </tr>
    
    
    <tr>
      
       
        
        <td>
            
                
                <table class="noborder">
                    <tr>
                        <td><b><?=t("imposte")?></b></td>
                        <td>€ <?=number_format($tassetotali,2,","," ");?></td>
                    </tr>
                </table>
            
        </td>
    </tr>
    
    

    <tr align='center' >
       
        
        <td align='center'>
          
                 <table class="noborder">
                    <tr>
                        <td><span style="font-size: 16pt;font-weight: 400;"><?=t("Totale")?></span></td>
                        <td><div style="font-size: 13pt;text-align: left;">€ <?=number_format($totalecarrello+$tassetotali,2,","," ");?></div>
                        </td>
                    </tr>
                </table>
           
        </td>
    </tr>
   
</table>
</td>
    </tr>
    
</table>



