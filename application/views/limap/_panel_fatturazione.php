<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



?>

                
<div class="box box-success">
                    
        <div class="box-header with-border">
            <h3 class="panel-title"> 
                Dati Fatturazione
            </h3>
        </div>
        <div class="box-body">
            
            
            
 <?php if( $this->user->getUserType()==User_model::USER_PROFESSIONISTA 
         OR $this->user->getUserType()==User_model::USER_ADMIN
      ){ ?>
            <div class="row">
                <div class="col-xs-12">
                    <label>Rag. Sociale </label>
                    <input type="text" name="rag_sociale" value="<?=$this->user->fatturazione["rag_sociale"]?>" class="form-control">
                </div>
                
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <label>P.IVA </label>
                    <input type="text" name="p_iva" value="<?=$this->user->fatturazione["piva"]?>" class="form-control">
                </div>
            </div>
       <?php }?>
            
            <div class="row">
                <div class="col-xs-12">
                    <label>C.FISCALE </label>
                    <input type="text" name="cod_fiscale" value="<?=$this->user->fatturazione["cod_cf"]?>" class="form-control">
                </div>
                 
               
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <label>Nome </label>
                    <input type="text" name="cod_fiscale" value="<?=$this->user->fatturazione["nome"]?>" class="form-control">
                </div>
                 
               <div class="col-xs-12 col-sm-6">
           
                     <label>Cognome </label>
                    <input type="text" name="comune" value="<?=$this->user->fatturazione["cognome"]?>" class="form-control">
               </div>
            </div>
            
            
            
            <div class="row">
                <div class="col-xs-6">
                    <label>Provincia </label>
                    <input type="text" name="fatt_provincia" value="<?=$this->user->fatturazione["provincia"]?>" class="form-control">
                </div>
                 
               <div class="col-xs-6">
           
                     <label>Comune </label>
                    <input type="text" name="fatt_comune" value="<?=$this->user->fatturazione["comune"]?>" class="form-control">
               </div>
                
            </div>
            
             
             <div class="row">
                 <div class="col-xs-12">
                    <label>Indirizzo </label>
                    <input type="text" name="indirizzo" value="<?=$this->user->fatturazione["indirizzo"]?>" class="form-control">
                 </div>
            </div>
             <div class="row">
                 <div class="col-xs-12">
                    <label>Telefono </label>
                    <input type="text" name="telefono" value="<?=$this->user->fatturazione["telefono"]?>" class="form-control">
                 </div>
            </div>
        </div>
</div>

