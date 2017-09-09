<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<style>
    
    table.intestazione-tb{
        border: 1px solid #a4a4a4;
        width: 100%;
        padding: 8px;
    }
    
    .logo-intestazione-fattura{
        max-width: 200px;
    }
    .blocco-cliente{
        border: 1px solid #000;
        padding: 8px;
        margin-top: 6px;
    }
    
</style>
<table class="intestazione-tb">
        <tr>
            <td>
                <b><?=t("Fattura-seq")?></b> <?=$invoice->codice_seq?>  
                
                <b><?=t("Fattura-Anno")?></b> <?=$invoice->anno?> 
            </td>
            
            <td align="">

                <b><?=t("Fattura-Data")?></b>
                <?php 
                    if(!empty($invoice->data)){
                        echo date("d/m/y",strtotime($invoice->data));
                    }else{
                        echo date("d/m/y");
                    }
                ?>
            </td>
        
        </tr>
</table>
<br/><hr/><br/>

<table class="intestazionetable">
        <tr>
            <td><?php
                    $this->view('utente/intestazione-user');
                ?>
            </td>
            
            <td style="line-height: 13px;">
                <br/><br/>
                <table class="blocco-cliente">
                    <tr><td><?=$intestazionecliente?></td></tr>
                </table>
            </td>
        </tr>
</table>