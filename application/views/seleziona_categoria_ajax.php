<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lingua=getLanguage();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$gruppi=$this->modello_prodotti->getGruppi();

?>


        
        <div class="row">
        
        <div class="col-xs-12">
            
            <?php
            
            //print_r($gruppi);
            if(count($gruppi)>0){
            foreach($gruppi as $k=>$gruppo){
                
            ?>
            
            <div class="box box-default">
                
                <div class="box-header">
                    <h2 class="box-title with-border"><?=strtoupper($k)?></h2>
                </div>
                <div class="box-body">
                     <div class="row">
                    <?php 
                    
                foreach($gruppo as $g){ 
                    
                    //verifico la presenza di richieste
                    $getparams="";
                    
                    if(count($_GET)>0){
                        
                        foreach ($_GET as $key => $value)
                        {
                             $getparams[] = $key.'='.$value;
                        }
                        
                        $getparams="?".implode("&",$getparams);
                    }
                    
                    ?>
                         
                        <div class="col-xs-12 col-sm-2 text-center">
                            
                            <a href="<?php echo base_url($lingua."/quote/create/".$g["nome"]."/".$g["idcategoria"]."/".$getparams)?>" 
                               data-target="modalConfiguratore"
                               data-toggle="modal">
                                <h5><?=$g["valore"]?></h5>
                                <figure class="thumbnail">
                                   <img src="<?=$g["foto"]?>" class="img-responsive">
                                 
                                </figure>
                                
                            </a>
                            <?php //verifico se si tratta del proprietario o di un collaboratore ?>
                            
                        
                        </div>
                        
                        
                   
                    
                 <?php }?>
                         
                    </div>
                </div>
                
            </div>
            <?php 
            }
          }else{
             
         ?>
            
            <a href="/" class="btn btn-pig">Crea nuovo gruppo</a>
            
            <?php }?>
        
        
            
            
            
        </div>
</div>
        
    