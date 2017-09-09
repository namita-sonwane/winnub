<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$modelli=$prodotto->get_modelli();
$gruppi_prodotti=$this->user->getMy("categorie-prodotti");



?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        
      <h1>&nbsp;</h1>
      <ol class="breadcrumb">
          <li><a href="<?=base_url("dashboard/")?>"><i class="fa fa-dashboard"></i> <?=t("dashboard")?></a></li>
        <li><a href="<?=base_url("prodotti/gestione/")?>"><i class="fa fa-gears"></i> <?=t("prodotti")?></a></li>
         <li><a href="#"><i class="fa fa-edit"></i> <?=t("modifica")?></a></li>
      </ol>
    </section>

   

    <!-- Main content -->
    <section class="content">
        <form method="post" action="/<?=getLanguage()?>/prodotti/save/<?=$codiceinterno?>" id="saveproductmodel" class="form" enctype="multipart/form-data">

            <?php
            
            if(isset($segnala_attenzine)){
                
                ?>
            <div class="alert alert-error">
               
                <h2 class="title-evid"><?=t("attenzione")?>!</h2>
                <p class="message-html"><?=$segnala_attenzine["messaggio"]?></p>
            </div>
                  
            <?php
                
            }else{
            
            
            
            
            ?>
             <div class="box">
                    
             <div class="box-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-8 ">



                                    <div class="form-group">

                                        <label style="font-size: 1.2em;"><?=t("Scegli la tipologia di prodotto")?></label>

                                        <select name="carattere_prodotto" class="form-control input-lg listencarattere">
                                            <option value="articolo" <?=($prodotto->carattere_prodotto=="articolo" OR $prodotto->carattere_prodotto==null)?"selected":""?>><?=t("Prodotto")?></option>
                                            <option value="variante" <?=($prodotto->carattere_prodotto=="variante")?"selected":""?>><?=t("Variazione")?></option>

                                            <option value="entrambi" <?=($prodotto->carattere_prodotto=="entrambi")?"selected":""?>><?=t("Prodotto Combinato")?></option>

                                            <option value="servizio" <?=($prodotto->carattere_prodotto=="servizio")?"selected":""?>><?=t("Servizio")?></option>
                                        </select>

                                    </div>


                        </div>

                        <div class="col-xs-12 col-sm-4 ">

                            <dl>

                                <dt><b><?=t("Prodotto")?></b> </dt>
                                <dd><p><?=t("Crea un prodotto come semplice articolo.")?></p></dd>

                                <dt><b><?=t("Variazione")?></b></dt>
                                <dd><p><?=t("Crea un prodotto che può essere solo inserito tra le variazioni di un prodotto, come ad esempio la colorazione.")?></p></dd>

                                <dt><b><?=t("Prodotto Combinato")?></b></dt>
                                <dd><p><?=t("Crea un prodotto che ha le caratteristiche di prodotto semplice e variazione.")?></p></dd>
                                
                                <dt><b> <?=t("Servizio")?></b></dt>
                                <dd> <p><?=t("Crea un tipo di servizio specifico.")?></p></dd>
                                
                            </dl>


                        </div>
                    </div>
                 
            </div>

            </div>


            <div class="row">

            <div class="col-xs-12 col-sm-12">

                <div class="box box-default">

                        <div class="box-body">

                            <div class="row">

                                <div class="col-xs-12 col-sm-6">

                                    <div class="form-group">
                                                <label><?=t("nome-prodotto")?></label>
                                                <input type="text" name="nome" value="<?=$prodotto->nome?>" class="form-control"/>
                                    </div>

                                    <div class="form-group">
                                         <div class="col-xs-5">

                                         <label><?=t("categoria-prodotto")?></label>
                                         <?php
                                    //ottengo i miei gruppi di prodotto     
                                    // su $gruppi_prodotti  
                                      if(count($gruppi_prodotti)>0){
                                    ?>
                                         <select name="categoria_prodotto" class="form-control">
                                             <?php foreach($gruppi_prodotti as $gr):?>

                                                <option value="<?=$gr["idcategoria"]?>" <?=($prodotto->categoria==$gr["idcategoria"])?"selected":""?>>
                                                     <?=$gr["valore"]?> 
                                                    
                                                </option>
                                                
                                             <?php endforeach;?>
                                         </select>
                                         <?php 

                                      }?>
                                         </div>
                                         <div class="col-xs-2 text-center">
                                             <br/>
                                            <?=t("oppure")?>
                                         </div>

                                         <div class="col-xs-5">

                                            <label><?=t("crea-nuova-categoria")?></label>
                                            <input type="text" name="categoria_prodotto_new" class="form-control">
                                         </div>
                                    </div>

                                    <div class="form-group">

                                    <label><?=t("descrizione-semplice")?></label>
                                    <textarea class="form-control" name="basedescription"><?=$prodotto->descrizione;?></textarea>

                                    </div>



                                </div>

                                <div class="col-xs-12 col-sm-6">
                                     <div class="form-group">
                                            <label><?=t("codice-interno")?></label>
                                            <input type="text" name="codiceinterno" value="<?=$prodotto->codice_interno?>" class="form-control"/>
                                        </div>
										<!--
                                       <div class="form-group">
                                         <label><?=t("larghezza-minima")?></label>
                                        <input type="text" name="largh_min" class="form-control" value='<?=$prodotto->getLarghezza();?>'>
                                    </div>

                                    <div class="form-group">
                                         <label><?=t("altezza-minima")?></label>
                                        <input type="text" name="alt_min" class="form-control" value='<?=$prodotto->getAltezza();?>'>
                                    </div>

                                     <div class="form-group">
                                         <label><?=t("Minimo Fattuabile/Prezzo di vendita")?></label>
                                        <input type="text" name="minfatturabile" class="form-control" value='<?=$prodotto->min_fatt;?>'>
                                    </div>
                                    
                                    <div class="form-group">
                                           <label><?=t("Minimo Fattuabile/Costo prodotto")?></label>
                                          <input type="text" name="costo_min_fatturabile" class="form-control input-lg" value="<?=$prodotto->costi["costo_min_fatturabile"]?>">
                                     </div>-->

                                </div>

                            </div>
							
							<!--row ends-->
							

                        </div>

                </div>

            </div>
            </div>
			
			 <div class="row">

            <div class="col-xs-12 col-sm-12">

                <div class="box box-default">

                        <div class="box-body">

                            <div class="row">

                                <div class="col-xs-12 col-sm-6">
									
									   <div class="form-group">
										 <label><?=t("larghezza-minima")?></label>
										<input type="text" name="largh_min" class="form-control" value='<?=$prodotto->getLarghezza();?>'>
									</div>

									<div class="form-group">
										 <label><?=t("altezza-minima")?></label>
										<input type="text" name="alt_min" class="form-control" value='<?=$prodotto->getAltezza();?>'>
									</div>
                                </div>
								
								<div class="col-xs-12 col-sm-6">
								<div class="form-group">
										 <label><?=t("Minimo Fattuabile/Prezzo di vendita")?></label>
										<input type="text" name="minfatturabile" class="form-control" value='<?=$prodotto->min_fatt;?>'>
									</div>
									
									<div class="form-group">
										   <label><?=t("Minimo Fattuabile/Costo prodotto")?></label>
										  <input type="text" name="costo_min_fatturabile" class="form-control input-lg" value="<?=$prodotto->costi["costo_min_fatturabile"]?>">
									 </div>

                                </div>

                            </div>
							
							<!--row ends-->
							

                        </div>

                </div>

            </div>
</div>
            
            
            <div class="row">
                
                
                <div class="col-xs-12 col-sm-12">


                                    <div class="box">
                                    <div class="box-header">
                                      <h3 class="box-title"><?=t("descrizione-tecnica-prodotto")?></h3>
                                      <p><?=t("descrizione-tecnica-prodotto-info")?></p>
                                      
                                      <!-- tools box -->
                                      <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                          <i class="fa fa-minus"></i></button>

                                      </div>
                                      <!-- /. tools -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body ">

                                        <div class="row">

                                            <div class="col-xs-12 col-sm-3">


                                                <div class="row" style="padding: 0px;">

                                                        <a href="#" class="btn btn-lg" data-toggle="modal" data-target="#uploadmodal">
                                                            <?=t("carica-foto-prodotto")?> <i class="fa fa-upload"></i>
                                                        </a>
                                                </div>
                                                <figure id="anteprima">
                                                    <img src='<?=$prodotto->foto?>' class='img-responsive'>
                                                </figure>



                                            </div>

                                            <div class="col-xs-12 col-sm-9 pad">
                                                <textarea name="descrizione_tecnica" class="textarea" 
                                                  placeholder="Place some text here" 
                                                  style="width: 90%; height: 200px; 
                                                  font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?=$prodotto->descrizione_tecnica?></textarea>
                                            </div>

                                        </div>



                                    </div>
                                  </div>




                        </div>
            </div>
            
            
            
            <div class="row">
                
                <div class="col-xs-12 col-sm-6">


                        <div class="box">
                        <div class="box-header">
                                
                          <h3 class="box-title"><?=t("Costi base")?> <!--<small><?=t("gesisci i costi")?></small>--></h3>


                          <!-- tools box -->
                          <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                              <i class="fa fa-minus"></i></button>

                          </div>
                          <!-- /. tools -->
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="row">
                                                 <div class="col-xs-4">
                                                     <label><?=t("Costo")?> al m<sup>2</sup></label>
                                                </div>
                                                <div class="col-xs-8">
                                                    <input type="text" name="costo" class="form-control input-lg" value="<?=$prodotto->costi["costo"]?>">
                                                </div>
                                        </div>


                                    </li>

                                    <li class="list-group-item">

                                        <div class="row">
                                                 <div class="col-xs-4">
                                                    <label><?=t("Costo fisso")?></label>
                                                </div>
                                                <div class="col-xs-8">
                                                    <input type="text" name="costo_fisso" class="form-control input-lg" value="<?=$prodotto->costi["importo_unitario"]?>">
                                                </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="row">
                                                 <div class="col-xs-4">
                                                    <label><?=t("Costo al metro lineare")?></label>
                                                </div>
                                                <div class="col-xs-8">
                                                    <input type="text" name="costo_metro_lineare" class="form-control input-lg" value="<?=$prodotto->costi["prezzo_m_lineare"]?>">
                                                </div>
                                        </div>
                                    </li>
                                    
                                

                                </ul>
                        </div>
                      </div>

                </div>
                
                
                <div class="col-xs-12 col-sm-6">


                        <div class="box">
                        <div class="box-header">
                                
                          <h3 class="box-title"><?=t("Prezzo Vendita")?> <!--<small>Gestisci le variazioni dei prezzi</small>--y></h3>


                          <!-- tools box -->
                          <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                              <i class="fa fa-minus"></i></button>

                          </div>
                          <!-- /. tools -->
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="row">
                                                 <div class="col-xs-4">
                                                     <label><?=t("Prezzo")?> al m<sup>2</sup></label>
                                                </div>
                                                <div class="col-xs-8">
                                                    <input type="text" name="prezzo" class="form-control input-lg" value="<?=$prodotto->prezzo_mq?>">
                                                </div>
                                        </div>


                                    </li>

                                    <li class="list-group-item">

                                        <div class="row">
                                                 <div class="col-xs-4">
                                                    <label><?=t("Prezzo fisso")?></label>
                                                </div>
                                                <div class="col-xs-8">
                                                    <input type="text" name="prezzo_fisso" class="form-control input-lg" value="<?=$prodotto->prezzo_fisso?>">
                                                </div>
                                        </div>


                                    </li>

                                    <li class="list-group-item">
                                        <div class="row">
                                                 <div class="col-xs-4">
                                                    <label><?=t("Prezzo al metro lineare")?></label>
                                                </div>
                                                <div class="col-xs-8">
                                                    <input type="text" name="prezzo_metro_lineare" class="form-control input-lg" value="<?=$prodotto->prezzo_m_lineare?>">
                                                </div>
                                        </div>
                                    </li>


                                </ul>
                        </div>
                      </div>

                </div>
                
            </div>

            <div class="row">        
                <!--- costi -->        
            


                <div class="col-xs-12 col-sm-12" id="rowvariante">


                        <div class="box">
                        <div class="box-header">
                            <!--<h3 class="box-title"><?=t("product-combined")?></h3>-->
                                
                          <!-- tools box -->
                          <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" 
                                    data-widget="collapse" 
                                    data-toggle="tooltip" title="Collapse">
                              <i class="fa fa-minus"></i></button>
                          </div>
                          <!-- /. tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body pad">
                            <!--<p>
                                <?=t("product-information")?>
                            </p>-->

                            <div class="">

                               <?php

                               
                               $varianti=$this->modello_prodotti->getVarianti();
                               
                               if(isset($prodotto) && $prodotto->codice_modello){
                                   
                                    $variantiprodotto=$prodotto->getArrayVarianti();
                                    
                               }
                               
                             
                               
                               ?>
 <div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered datatabless" id="tabella_varianti">
                                            <thead>
                                                <tr>
                                                    <th> </th>
                                                    <th><?=t("Nome-variante")?></th>
                                                    <th><?=t("descrizione-variante")?></th>
                                                    <th><?=t("codice-riferimento")?></th>
                                                    <th><?=t("medoto-prezzo")?></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 

                                            if(count($varianti)>0){

                                                foreach($varianti as $var){
                                                    
                                                    //print_r($var);
                                                    $lavariante=array("metodo_prezzo"=>"fisso");
                                                    $checked_box="";
                                                    
                                                    if(isset($variantiprodotto) && count($variantiprodotto)>0){
                                                        $checked_box=(multidimensional_search($variantiprodotto,
                                                        array("variante"=>$var->codice_modello)))?"CHECKED":"";

                                                        if(isset($variantiprodotto[$var->codice_modello])>0){
                                                            $lavariante=$variantiprodotto[$var->codice_modello];
                                                        }
                                                    }
                                                ?>
                                                  <tr>
                                                      <td>
                                                          <input type="checkbox" 
                                                                 name="select_varianti[<?=$var->codice_modello?>]" <?=$checked_box?>>
                                                      </td>
                                                      <td><?=$var->nome?></td>
                                                      <td><?=$var->descrizione?></td>
                                                      <td><?=$var->codice_interno?></td>
                                                      <td>
                                                          <select class="form-control" name="metodo_prezzo_variante[<?=$var->codice_modello?>]">
                                                              <option value="fisso" <?=($lavariante["metodo_prezzo"]=="fisso")?"SELECTED":""?>>fisso</option>
                                                              <option value="misure" <?=($lavariante["metodo_prezzo"]=="misure")?"SELECTED":""?>>misure</option>
                                                              <option value="percentuale" <?=($lavariante["metodo_prezzo"]=="percentuale")?"SELECTED":""?>>percentuale</option>
                                                          </select>
                                                        
                                                      </td>
                                                  </tr>

                                         <?php  
                                         
                                                }
                                         
                                            }
                                         ?>

                                            </tbody>
                                       </table>

                                    </div>
                                </div>


                            </div>
                        </div>
                      </div>




            </div>



            </div>

                    <div class="row">



                    <div class="col-xs-12">
                            <input type="submit" name="actionform" value="Salva" class="btn btn-default"/>
                    </div>
                    </div>



                <!-- /.content -->

              <!-- /.content-wrapper -->
              <div id="uploadmodal" class="modal fade" role="modal" tabindex="-1">
    
    <div class="modal-dialog modallarge" role="document">
        <div class="modal-content">
            <div class="modal-body">
                   <div id="elfinder"></div>
              </div>
        </div>
        
    </div>
    
</div>
              <input type="hidden" name="codiceprodotto_codsec" value="<?=$codiceinterno?>" />
            
              <?php
            }
              ?>
            </form>
    </section>
</div>

