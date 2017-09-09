<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="panel panel-default">
            <div class="box-header with-border">
                <h4><?=t("aggiornamenti")?></h4>
            </div>
                
    <div class="panel-body">
        
        
       
            
            <div class="cardnews">

                    <?php
                           $urls="https://winnub.com/".getLanguage()."/feed/";     
                           $html=winnub_feed($urls);
                           
                           print_r($html);
                    ?>

            </div>
        
    </div>
    
</div>
    