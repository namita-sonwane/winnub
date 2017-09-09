<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class='row'>
    
    <div class='col-xs-12'>
        
        <h1><?=t("Prodotto inserito correttamente")?></h1>
        <?php if( isset($qcode)):
            $codice=$qcode;
            ?>
             <a href='<?="/".getLanguage()."/quote/detail/$codice"?>'><?=t("Vai al dettaglio")?></a>
               <a href='<?="/".getLanguage()."/quote/?quoteitem=$codice"?>'><?=t("Nuovo prodotto")?></a>
        <?php else:?>
             <a href='<?="/".getLanguage()."/quote/view"?>'><?=t("Vai al dettaglio")?></a>
               <a href='<?="/".getLanguage()."/quote"?>'><?=t("Nuovo prodotto")?></a>
        <?php endif;?>
       
      
        
    </div>
    
</div>
