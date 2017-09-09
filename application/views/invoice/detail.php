<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//includo l'header
$this->view('limap/_header');

$this->view('limap/_sidebar');

if( $invoice->data!=null ){
    $datainvoice= date("Y-m-d", strtotime($invoice->data) );
}else{
    $datainvoice= date("Y-m-d");
}

//precompilo  i dati di default;
    $codice_seq=0;
    if($invoice->codice_seq==0){
        $codice_seq=$this->modello_fattura->generaCodiceSequenza();
    }else{
        $codice_seq=$invoice->codice_seq;
    }
    
    
    $anno_fattura=date("Y");
    if(isset($invoice->anno)){
        $anno_fattura=$invoice->anno;
    }                                                 

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      
      <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=t("Fatturazione")?> <small><?=t("invoice-detail-sezione")?></small>
      </h1>
      <ol class="breadcrumb">
          <li class=""><a href="/dashboard"><?=t("dashboard-sezione")?></a></li>
          <li class=""><a href="/dashboard/invoice/all"><?=t("lista-fatture")?></a></li>
          <li class="active"><?=t("dettaglio-fattura")?></li>
      </ol>
    </section>

   
    <section class="content" ng-app="winnub">
        
        
        
        <form method="post" action="" id='form1'>
            
            <input type="hidden" name="invoicecode" value="<?=$invoice->codfatt?>" id='invoicecode'/>
             
            <div class="row">
            <div class="col-xs-12">
                <div class="invoice">
                    
                    
                    
                    <div class="invoice-title ">
                        
                        <div class="row">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>
                                                    <label>Tipo Documento</label>
                                                    <p class="text-center">Fattura</p>
                                                </td>
                                                <td>
                                                    <?=t("Fattura N°")?> 
                                                    <?php
                                                        
                                                    ?>
                                                     <input type="text" name="numero_fatt" value="<?=$codice_seq?>" class="form-control">
                                                </td>
                                                <td>
                                                    <?=t("Anno")?>  <input type="text" name="anno_fatt" value="<?=$anno_fattura?>" class="form-control">
                                                </td>
                                                <td>
                                                    <?=t("Data")?>  <input type="date" name="data_fatt" value="<?=$datainvoice?>" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                        <div class="row">
                        
                                <div class="col-xs-12 col-sm-6 ">
                                    
                                <?php

                               // print_r($invoice);

                                /*if(empty($invoice->intestazione)){
                                    $invoice->intestazione="[default_intestazione]";
                                    $invoice->intestazione=$invoice->template;
                                }*/
                                
                                

                                ?>
                                
                                    <div class="row">
                                        
                                        <div class="col-xs-12" id="bloccointestazione">
                                            
                                            
                                            <?php $logos=$this->user->getLogo();
                                                if(isset($logos)){?>
                                                <div class='business-image'>
                                                    <img src='/<?=$logos?>' class='img-responsive'>
                                                </div>
                                            <?php }?>
                                            
                                                <h4><?=$this->user->fatturazione["rag_sociale"]?></h4>
                                                <p>
                                                    <?=$this->user->fatturazione["indirizzo"]?>,  
                                                    <?=$this->user->resolveCap($this->user->fatturazione["comune"])?>, 
                                                    <?=$this->user->resolveComune($this->user->fatturazione["comune"])?>
                                                    <br/>
                                                    <?=$this->user->fatturazione["piva"]?> - <?=$this->user->fatturazione["cod_cf"]?>
                                                     <br/>
                                                    <?=$this->user->fatturazione["telefono"]?> -   <?=$this->user->fatturazione["emailf"]?>
                                                </p>
                                                
                                        </div>
                                       
                                    </div>
                                    
                                </div>

                                <div class="col-xs-12 col-sm-6 form-infocliente">
                                    
                                        
                                        
                                            
                                        <div class="input-group">
                                            <input id="search_cliente" type="text" class="form-control" name="cercacliente" placeholder="Search for..." value="<?=$invoice->cliente_profile["rag_sociale_cliente"]?>">
                                            <span class="input-group-btn">
                                                
                                                <button class="btn btn-default actionclient" type="button" data-
                                                        toggle="modal" data-rest="add" data-target="#modaladdcliente">+</button>
                                                
                                                <button class="btn btn-default actionclient btnselect2c <?=(($invoice->cliente>0)?"":"hidden")?>" type="button" data-rest="removeselection">X</button>
                                                
                                            </span>
                                        </div><!-- /input-group -->
                                      
                                        <div id='infocliente' class='<?=($invoice->cliente>0)?"":"hidden"?>' rel="<?=$invoice->cliente?>">
                                            <p><?=$invoice->cliente_profile["rag_sociale_cliente"]?></p>
                                            <p><?=$invoice->cliente_profile["PIVA"]?></p>
                                        </div>
                                            
                                        <div id='areacliente' class='<?=($invoice->cliente>0)?"":"hidden"?>'>
                                            
                                                 
                                                    <input type="hidden" name="codicecliente" class="form-control" value="<?=$invoice->cliente?>">
                                                    
                                                  <?php
                                                  /*
                                                    
                                                    <div class="form-group">
                                                        <label class="control-label"><?=t("ragione-sociale-cliente")?></label>
                                                        <div class="">
                                                                <input type="text" name="ragione_sociale_cliente" class="form-control" value="<?=$invoice->cliente_profile["rag_sociale_cliente"]?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label"><?=t("p-iva-cliente")?></label>
                                                        <div class="">
                                                            <input type="text" name="p_iva_cliente" class="form-control" value="<?=$invoice->cliente_profile["PIVA"]?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label"><?=t("codice-fiscale-cliente")?></label>
                                                        <div class="">
                                                            <input type="text" name="codice_ficale_cliente" class="form-control" value="<?=$invoice->cliente_profile["cod_fiscale"]?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class=" control-label"><?=t("indirizzo")?></label>
                                                        <div class="">
                                                         <input type="text" name="indirizzo_cliente" class="form-control" value="<?=$invoice->cliente_profile["indirizzo"]?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class=" control-label"><?=t("cap-cliente")?></label>
                                                        <div class="">
                                                            <input type="text" name="cap_cliente" class="form-control" value="<?=$invoice->cliente_profile["cap"]?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class=" control-label"><?=t("comune-cliente")?></label>
                                                        <div class="">
                                                            <input type="text" name="comune_cliente" class="form-control" value="<?=$invoice->cliente_profile["comune"]?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class=" control-label"><?=t("provincia-cliente")?></label>
                                                        <div class="">
                                                            <input type="text" name="provincia_cliente" class="form-control"  <?=$invoice->cliente_profile["provincia"]?>>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class=" control-label"><?=t("email-cliente")?></label>
                                                        <div class="">
                                                            <input type="text" name="email_cliente" class="form-control" value="<?=$invoice->cliente_profile["email"]?>">
                                                        </div>
                                                    </div>
                                                   */?>
                                            </div>
                                </div>
                        </div>
                        
                        <div class="row-divider">
                            <h3 class=""><?=t("medotodi-di-pagamento")?></h3>
                           
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-xs-12 col-md-4">
                            
                                <label><?=t("seleziona-metodo-di-pagamento")?></label>
                                <select name="t_pagamento" class="form-control" id="selezionepagamenti">
                                    <option value="0"><?=t("Seleziona un metodo di pagamento")?></option>
                                <?php
                                $pagamenti=$this->azienda->getPaymentTypes();
                                foreach($pagamenti as $pag){
                                    
                                    echo "<option value=\"".$pag["ptype"]."\">".$pag["nome"]."</option>";
                                }
                                ?>
                                </select>
                                <?php
                                $htmlpagamento="";
                                if(!empty($invoice->tipologia_pagamento)){
                                    $htmlpagamento="";
                                   
                                    $modello=$this->azienda->getPayment($invoice->tipologia_pagamento);

                                    $pdata=array(
                                        "codice"=>$code,
                                        "modello"=>$modello,
                                        "selezione"=>($invoice->pagamento_selezione)
                                    );
                                    $htmlpagamento=$this->parser->parse('pagamenti/dettaglio_payment',$pdata,TRUE);
                                    
          
                                }
                                ?>
                                
                               
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <br/>
                                <div class="panel panel-default panel-collapse">
                                   
                                     <div id="content-pagamento" class="panel-body"><?=$htmlpagamento?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="invoice-body">
                        
                        <div class="row ">
                            <div class="col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered " id="tableelement">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th style="width: 60px;"><?=t("cod.")?></th>

                                            <th>descrizione</th>
                                            <th style="width: 90px;"><?=t("qty.")?></th>
                                           
                                            <th style="width: 120px;"><?=t("totale")?></th>
                                            <th style="width: 200px;"><?=t("imposte")?></th>
                                            <th style="width: 120px;"><?=t("azioni")?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                    <?php
                                    
                                    
                                    $lista_tasse=array();
                                    $totale_tassazioni=0;
                                    $totalecarrello=0;
                                    $codiciarticoli=array();
                                    $costiservizi=array();
                                    $sommasconti=0;
                                    
                                    foreach($invoice->items as $itm){
                                        
                                        //print_r($itm);
                                        $codiciarticoli[]=intval($itm["idarticolo"]);
                                        $RIFERIMENTO_PRODOTTO= json_decode($itm["altro"]);
                                        
                                        
                                        //print_r($RIFERIMENTO_PRODOTTO);
                                       ?>
                                        <!--item invoice article-->
                                        <tr data-articleitem="<?=$itm["idarticolo"]?>" id="articl_<?=$itm["idarticolo"]?>">
                                            <td> <input type="checkbox" name="tipologiaservizio[<?=$itm["idarticolo"]?>]" value="selezionato" <?=($itm["tipo_prodotto"]=="servizio")?"checked":"";?>></td>
                                            <td style="vertical-align: middle;" width="90"><input type="text" class="form-control" name="codicearticolo[<?=$itm["idarticolo"]?>]" value="<?=$itm["cod_articolo"]?>"></td>
                                            <td class="rigadescrizione editable" style="vertical-align: middle;" id="descrizione[<?=$itm["idarticolo"]?>]"><?=strip_tags($itm["descrizione"])?></td>
                                            <td style="vertical-align: middle;"><input type='number' name='qty[<?=$itm["idarticolo"]?>]' class="form-control variant" value="<?=$itm["quantita"]?>" /></td>
                                            <td style="vertical-align: middle;"><input type="number" 
                                                                                       name="price[<?=$itm["idarticolo"]?>]" 
                                                                                       value="<?=number_format($itm["prezzo"],2,".","")?>" 
                                                                                       class="form-control variant"/></td>
                                            <td style="vertical-align: middle;">
                                                <select name="vat[<?=$itm["idarticolo"]?>]" class="form-control variant" ><?=_selectVatCode($itm["iva"])?></select>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                            <!-- Small button group -->
                                                            <div class="btn-group">
                                                              <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                               <?=t("label-azioni")?> <span class="caret"></span>
                                                              </button>
                                                              <ul class="dropdown-menu">
                                                                  <li><a href="#"><?=t("label-elimina")?></a></li>
                                                                  
                                                              </ul>
                                                            </div>
                                            </td>
                                        </tr>   
                                        <!--end item invoice article-->
                                        <?php
                                        $costopertasse=0;
                                        $valoresconto=0;
                                        if($itm["tipo_prodotto"]=="servizio"){
                                            
                                            $costos=(floatval($itm["prezzo"])*intval($itm["quantita"]));
                                            
                                            
                                            $costopertasse=( (floatval($costos)*intval($itm["iva"]))/100 );
                                            
                                            $costiservizi[]=$costos;
                                            
                                        }else{//i prodotti rispetto ai servizi non sono soggetti a sconti stiche applicate.
                                            $costot=(floatval($itm["prezzo"])*intval($itm["quantita"]));
                                            $totalecarrello+=$costot;
                                            
                                            //devo sottrarre gli sconti
                                            if($invoice->sconto>0){
                                                $valoresconto=($costot*$invoice->sconto)/100;
                                            }
                                            $costot=$costot-$valoresconto;
                                            
                                            $sommasconti+=$valoresconto;
                                                    
                                            $costopertasse=( (floatval($costot)*intval($itm["iva"]))/100 );
                                        }
                                        //nella tassazione devo calcolare lo sconto eventuale
                                        $lista_tasse[$itm["iva"]]+=$costopertasse;
                                        
                                    }
                                    
                                    ?>
                                    </tbody>
                                    
                                </table>
                            
                            </div>
                            </div>
                            
                        </div>
                        
                        
                    </div>
                    
                    <div class="invoice-footer">
                        <div class="row">
                            <div class="col-xs-12">
                                <table class="table">
                                    <tbody style="background-color: #f1f1f1;" class="footerinvoice" id="footerinvoice">
                                            <tr>
                                                <td>
                                                    <label><?=t("codice")?></label>
                                                    <input type="text" class="form-control" name="newvalue_id" placeholder="<?=t("inserisci-codice")?>"/> 
                                                </td>
                                                <td class="editable">
                                                    <?=t('edita-descrizione-prodotto');?>
                                                </td>
                                                <td>
                                                    <label><?=t("quantita")?></label>
                                                    <input type="number" class="form-control" name="newvalue_qty" placeholder="<?=t("inserisci-quantita")?>"/> 
                                                </td>
                                                 <td>
                                                     <label><?=t("prezzo-singolo")?></label>
                                                    <input type="number" class="form-control" name="newvalue_prezzo" placeholder="<?=t("inserisci-prezzo")?>"/> 
                                                </td>
                                                <td>
                                                    <label><?=t("imposta")?></label>
                                                    <select name="newvalue_iva" class="form-control variant">
                                                       <?=_selectVatCode()?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <label>
                                                        <?=t("seleziona-servizio")?>
                                                        <input type="checkbox" id="lbserv" name="newvalue_servizio" value="servizio">
                                                    </label>
                                                   
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    
                                                    <button class="btn btn-default btn-success addrow btn-inverse"><i class="fa fa-plus-circle"></i> Inserisci</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <p>
                                                        <?=t("Il valore di selezione come servizio imposta un prodotto esente dalla scontistica "
                                                                . ", senza escluderlo dalla tassazione.")?>
                                                    </p>
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                            <table class="table table-bordered">
                                 <tr>
                                     <td style="width: 40%;">
                                         <?=t("tassazioni-applicate")?>
                                         <br/>
                                         <?php 
                                         
                                            foreach($lista_tasse as $id=>$tax){
                                              echo "<br/> € ".number_format($tax,2,'.','')." - ".resolveVatCode($id,"nome_tassazione");
                                              $totale_tassazioni+=$tax;
                                            }
                                            
                                        ?>
                                         
                                     </td>
                                     
                                    <td style="vertical-align: middle;"><?=t("totale-fattura")?></td>
                                    <td style="vertical-align: middle;">
                                        <div class="input-group">
                                        <span class="input-group-addon" id="ttotc">€</span>
                                        <input  name="totalecarrello" class="form-control" value="<?=number_format($totalecarrello,2,","," ")?>" id="ttotc" ng-model="totalecarrello"/>
                                        </div>
                                        <?php
                                        
                                        
                                        ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="width: 50%;"></td>
                                    <td><?=t("scontistica-fattura")?></td>
                                    <td>
                                        <div class="input-group">
                                        <span class="input-group-addon" id="sizing-addonsconto">%</span>
                                         <input  type="number" id="sizing-addonsconto" name="scontistica" class="form-control" value="<?=$invoice->sconto?>" ng-model='scontistica'/>
                                        </div>
                                        <?php
                                        
                                       
                                        
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;"></td>
                                    <td><?=t("totale-sconto")?></td>
                                    <td>
                                        <div class="input-group">
                                        <span class="input-group-addon" id="sizing-addon1">€</span>
                                         <input type="text" name="sconti" class="form-control" value="<?=number_format($sommasconti,2,","," ")?>"/>
                                        </div>
                                        <?php
                                        
                                        $totalecarrello=($totalecarrello-$sommasconti);
                                        
                                        
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                    $costi_serv=0;
                                    if(count($costiservizi)>0){?>
                                <tr>
                                    <td style="width: 40%;"></td>
                                     <td><?=t("totale-servizi")?></td>
                                    <td>
                                        <div class="input-group">
                                        <?php 
                                        
                                            foreach($costiservizi as $cs){
                                                $costi_serv+=$cs;
                                            }
                                       
                                        
                                        ?>
                                        <span class="input-group-addon" id="sizing-addon1">€</span>
                                         <input type="text"  name="totserv" class="form-control" value="<?=number_format($costi_serv,2,","," ")?>"/>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <?php }?>
                                
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td><?=t("totale-imponibile")?></td>
                                    <td>
                                        <div class="input-group input-group-md">
                                             <span class="input-group-addon" id="sizing-addon1">€</span>
                                            <input type="text"  name="imponibile" class="form-control" value="<?=number_format($totalecarrello,2,',',' ')?>"/>
                                        </div>
                                        
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td><?=t("totale-imposte")?></td>
                                    <td>
                                        <div class="input-group input-group-md">
                                             <span class="input-group-addon" id="sizing-addon1">€</span>
                                            <input type="text"  name="tassetotali" class="form-control" value="<?=number_format($totale_tassazioni,2,',',' ')?>"/>
                                        </div>
                                        
                                    </td>
                                </tr>
                               
                                 <tr>
                                    <td style="width: 40%;"></td>
                                    <td><?=t("totale-fattura")?></td>
                                    <td>
                                        <?php
                                        
                                        $t_T=number_format($totalecarrello+$totale_tassazioni,2,".","");
                                        ?>
                                        
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon" id="sizing-addon1">€</span>
                                                <input type="text" name="totale_invoice" class="form-control" value="<?=number_format($t_T,2,","," ")?>"  aria-describedby="sizing-addon1"/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    
                    <div class="row" style="margin-top: 36px;">
                        <div class="col-xs-12">
                            <!-- exlusive-->
                               <input type="hidden" name="itemcodes" value="<?=json_encode($codiciarticoli);?>" />
                                
                               
                            <ul class="nav nav-pills pull-right">
                               
                               <li role="">
                                   <button type="button" class="btn btn-success" id="savebtn">Save</button>
                               </li>
                               <li role="presentation"><a href="#" class="btn btn-info">Close</a></li>
                               <li role="presentation"><a href="#" class="btn btn-default">Reload</a></li>
                               <li role="presentation"><a href="<?="/".getLanguage()."/quote/detail/".md5($invoice->preventivo)?>" class="btn btn-default">Apri Preventivo</a></li>
                               
                             </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        
    </form>
      
    </section>
      
      
 </div>

<div class="modal fade modal-cliente" tabindex="-1" role="dialog" id='modaladdcliente'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?=t("Nuovo-cliente")?></h4>
      </div>
      <div class="modal-body">
          <?php  
          
                $cliente=$invoice->cliente;
                $this->view('clienti/form_cliente',array("cliente"=>$cliente,"smart"=>true));
                
          ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary saveCliente">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<?php


$this->view('limap/_footer');

