<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$cliente=$preventivo->getCliente();

$cliente=$cliente[0];
$totale=0;

$totale_aliquote=array();
$costi_servizi=array();

?>
<style type="text/css">
    .intestazionetable{
        display: block;
        padding-bottom: 12px;
        border-bottom: 1px solid #666;
    }
    .intestazione-utente{
        line-height: 9pt;
    }
    
    .areanote h3{
        margin: 0px;
    }
    
   
    
    table tr td div.blockdesc{
        line-height: 9pt;
    }
    table tr td div.blockdesc p,
    table tr td div.blockdesc br{
        padding: 0px;
        margin: 0px;
    }
    
    
</style>
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
    
<table class="intestazionetable" border='0' cellpadding="0" cellspacing="2">
        <tr>
            <td class="intestazione-utente"><?=$preventivo->template_intestazione?></td>

            <td class=''>
                <div style="text-align: center;border: 1px solid #000;">
                 <?=$intestazionecliente?>
                </div>
            </td>
        </tr>
</table>

<div class="areanote">
    <h3><?=t("Note")?></h3>
    <?=(!empty($preventivo->note))?nl2br($preventivo->note):t("nessuna-nota")?>
</div>

<hr/>
<br/>