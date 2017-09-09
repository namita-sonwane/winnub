<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$modelli=$prodotto->get_modelli();

$selezione=explode(",",$prodotto->modello);

//print_r($prodotto->modello);

?>


<div class="col-xs-12">
            
    <div class="box">

        <div class="box-body">
            
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="row">


                        <div class="col-xs-12 col-sm-6">
                                <label>Nome</label>
                                <input type="text" name="nome" value="<?=$prodotto->nome?>" class="form-control"/>

                        </div>

                        <div class="col-xs-12 col-sm-6">

                                <label>Codice</label>
                                <input type="text" name="codice" value="<?=$prodotto->codice?>" class="form-control"/>

                        </div>
                    
                        

                 </div>
                <br/>
                <div class="row">
                
                        <div class="col-xs-12 col-sm-6">

                            <label>Modello</label>
                            <select name="classe" class="form-control input-lg" multiple>
                                
                                <?php foreach($modelli as $mod):?>
                                <option value="<?=$mod->nome?>" <?=(in_array($mod->nome,$selezione))?"SELECTED":""?>><?=$mod->valore?></option>
                                <?php endforeach;?>
                            </select>

                        </div>
                    
                        <div class="col-xs-12 col-sm-6">

                            <label>Materiale</label>
                            <select name="classe_prodotto" class="form-control">
                                <option>Seleziona una classe</option>
                                 <option value="pvc">PVC</option>
                                 <option value="alluminio">Alluminio</option>
                            </select>

                        </div>

                </div>
                </div>
                
                <div class="col-xs-12 col-sm-6">
                     
                     <div class="form-group">
                         <label>Variazione prezzo in % </label>
                         <input type="text" name="variazione" class="form-control"/>
                     </div>
                    
                    
                </div>
                <div class="col-xs-12 col-sm-6">
                     
                    <label>Foto</label>
                     <input type="file" name="fototecnica" class="form-control"/>
                    
                </div>
                
            </div>

                

            </div>

    </div>
    
</div>

<div class="col-xs-12">
            
            
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Descrizione tecnica</h3>
              <p>Inserisci qui la descrizione tenica del prodotto</p>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
             
                <textarea name="descrizione_tecnica" class="textarea" 
                          placeholder="Place some text here" 
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?=$prodotto->descrizione_tecnica?></textarea>
              
            </div>
          </div>
    
    
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Descrizione</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
             
                <textarea class="textarea" name="descrizione"
                          placeholder="Place some text here" 
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?=$prodotto->descrizione?></textarea>
              
            </div>
          </div>

</div>

<div class="col-xs-12">
        <input type="submit" name="actionform" value="Salva" class="btn btn-default"/>
</div>


