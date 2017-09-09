<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="col-xs-12 col-sm-12">
    

<div class="box box-success">
                    
        <div class="box-header with-border">
            <h3 class="panel-title"> 
                Dati Spedizione
            </h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-6">
                    <label>Nome </label>
                    <input type="text" name="nome" value="<?=$this->user->profile["nome"]?>" class="form-control" required>
                </div>
                
            
                <div class="col-xs-6">
                    <label>Cognome </label>
                    <input type="text" name="cognome" value="<?=$this->user->profile["cognome"]?>" class="form-control" required>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-xs-6">
                    <label>Comune </label>
                    <input type="text" name="comune" value="<?=$this->user->resolveComune()?>" class="form-control" required>
                </div>
                 
               <div class="col-xs-6">
           
                     <label>Provincia </label>
                    <input type="text" name="comune" value="<?=$this->user->resolveProvincia()?>" class="form-control">
               </div>
            </div>
            <hr/>
             <div class="row">
                 <div class="col-xs-12">
                    <label>Indirizzo comprensivo di numero civico </label>
                    <input type="text" name="comune" value="<?=$this->user->profile["indirizzo"]?>" class="form-control" required> 
                 </div>
            </div>
            <hr/>
             <div class="row">
                 <div class="col-xs-12">
                    <label>CAP </label>
                    <input type="text" name="comune" value="<?=$this->user->resolveCap()?>" class="form-control" required>
                 </div>
            </div>
        </div>
</div>
    
</div>

<div class="col-xs-12 col-sm-6">
       <?php
       //echo $this->spedizione["note"]." € ".($this->spedizione["costo_fisso"]*$this->totale_prodotti);        

       ?>

</div>