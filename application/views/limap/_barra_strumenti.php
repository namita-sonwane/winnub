<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?> <div class="row">
            <div class="col-xs-12">
                
                <div class="barra-azione">
                    
                    <?php foreach($buttons as $btn){?>
                    <a href="<?=$btn["href"]?>" class="<?=$btn["class"]?>" <?=$btn["datas"]?>><?=$btn["nome"]?> <?=$btn["icona"]?></a>
                    <?php }?>
                    
                </div>
            </div>
    
</div>