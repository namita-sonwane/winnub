<?php


if($this->user->isLogged()){
    //dati utente loggato in questo modo non traccio la visita
     //print_r($preventivo);
    
}else{
    
    
     
   //print_r($preventivo);
   
}

$cliente=null;
if(isset($preventivo)){
    $cliente=$preventivo[0]->getCliente();
}




?><html lang="<?=getLanguage()?>">
     <head>
        <title>Winnub <?=t("Preventivo")?></title>
       
        <link rel="stylesheet" href="/public/bower_components/bootstrap/dist/css/bootstrap.min.css">
         
        <script src="/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/bower_components/admin-lte/bootstrap/js/bootstrap.js"></script>
         
        <style type="text/css" media="screen,print">
                body{
                    background-color: #54a3d8;
                    font-family: Helvetica,sans-serif;
                    font-weight: 100;
                    
                }
                .divider1{
                    min-height: 20%;
                    display: block;
                    clear: both;
                    width: 100%;
                }
                
                .box-discussion{
                    background-color: #eee;
                    padding: 12px 32px;
                    margin-top: 12px;
                }
                
                .box-discussion.neutro{
                    background-color: #3c8dbc;
                    color: #fff;
                }

                #wrapper{

                    max-width: 960px;
                    margin: .01% auto .2%;
                    background-color: #fff;
                    padding: 8px;

                }
             
                .box-cliente{
                    border: 2px solid #dedede;
                    padding: 12px 8px 22px;
                    text-align: center;
                    min-height: 200px;
                }
                
                
                
                .box-cliente ul{
                    list-style: none;
                    padding: 0px;
                    margin: 0px;
                }

                .rigainfo{
                   padding: 8px 0px 8px;
                   border-bottom: 2px solid #aaa;
                   margin-bottom: 12px;
                }

                .box-shadow{
                    box-shadow:0px 2px 12px rgba(0,0,0,.4);
                }
                
                table tr th{
                    background-color: #eee;
                    font-size: .7em;
                    text-align: center;
                }
                .table tr td{
                    vertical-align: middle!important;
                    text-align: center;
                }
                .table-footer tr td{
                    text-align: left;
                }
                
                .info-user{
                    font-weight: 600;
                }
                
                
                @media(max-width: 768px){
                    
                    #wrapper{
                       width: 100%;
                    }
                    
                }
             
             
        </style>
        <script type="text/javascript">
             
            var SITE_BASE_LANG="<?=getLanguage()?>";
            
        </script>
    </head>
    <body>
        
        <div class="divider1 hidden-print"></div>
        <div id="wrapper" class="box-shadow">
            
            <div class="container-fluid">
                
                <div class="row rigainfo">
                    <div class="col-xs-4 col-sm-4">
                        <h4 style="margin: 0px;padding: 0px;"><?=$preventivo[0]->titolo?></h4>
                    </div>
                    <div class="col-xs-4 col-sm-4">
                       <?=t("CODICE")?>: <?=$preventivo[0]->codice_utente?>
                    </div>
                    <div class="col-xs-4 col-sm-4 text-right">
                       <?=t("DATA")?>:   <?=date("d/m/Y",strtotime($preventivo[0]->data))?>
                    </div>
                   
                </div>
                
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <?=$preventivo[0]->template_intestazione?>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="box-cliente">
                            <h4><?=$cliente[0]->rag_sociale_cliente?></h4>
                            <ul>
                                <li><?=$cliente[0]->indirizzo?></li>
                                <li><?=$cliente[0]->cap?></li>
                                <li><?=$cliente[0]->comune?></li>
                                <li><?=$cliente[0]->provincia?></li>
                            </ul>
                            
                        </div>
                    </div>
                    
                </div>
                
                <div class="row">
                    
                </div>
                
                <div class="row">
                    <div class="col-xs-12">
                        
                        <div class="table-responsive">
                            
                        
                        <table class="table table-bordered">
                            <tr>
                                <th><?=t("prod.")?></th>
                                <th><?=t("desc.")?>.</th>
                                
                                <th><?=t("pric.")?></th>
                                <th><?=t("qunt.")?></th>
                                
                                <th><?=t("tota.")?></th>
                                
                                <th><?=t("aliq.")?></th>
                                
                            </tr>
                            <?php 
                            
                            $aliquote=array();
                            $servizi=array();
                            $totale=0;
                            $scontistica=0;
                            
                            if(count($preventivo[0]->getItems())){
                            foreach($preventivo[0]->getItems() as $itm){
                                $modello=$this->modello_prodotti->get_id($itm->prodotto);
                                //print_r($modello);
                                
                                //verifichiam la presenza dello sconto
                                $sconto=$preventivo[0]->codice_sconto;
                                $costop=($itm->costo*$itm->quantita);
                                
                                //$iva=resolveVatCode($itm->codice_iva,'aliquota',getOwnerUser($preventivo[0]->utente));
                                $iva=$itm->codice_iva;
                               ?>
                                <tr>
                                    <td>    <?=$itm->descrizione?>  </td>
                                    <td width="360">
                                            <?=$itm->descrizione_2?>
                                    </td>
                                    
                                    <td>€   <?=number_format($itm->costo,2,","," ")?></td>
                                    <td>    <?=$itm->quantita?></td>
                                    
                                    <td>€   <?=number_format($costop,2,","," ")?></td>
                                    
                                    <td>    <?=$iva?> % </td>
                                    
                                </tr>
                               <?php
                               
                               if($modello->carattere_prodotto=="servizio"){
                                   
                                   
                                   $servizi[]=array("nome"=>"".$itm->descrizione,"costo"=>$costop);
                                   $totale+=$costop;
                                   
                               }else{
                                   
                                   
                                   
                                   if(intval($sconto)>0){
                                        $scontoc=floatval(($costop*$sconto)/100);
                                        $scontistica+=$scontoc;
                                        $costop=($costop-$scontoc);
                                        //echo "-->".$costop;
                                        
                                        $totale+=$costop;
                                   }else{
                                        $totale+=$costop;
                                   }
                                   
                                  
                                   
                               }
                               
                               
                                $aliquote[$iva]+=(($costop*$iva)/100);
                                
                               

                            }
                            
                        }
    ?>
                        </table>
                            
                        </div>
                    </div>
                </div>
                
                <hr/>
                
                <div class="row">
                    <div class="col-xs-12">
                            <table class="table table-bordered table-footer">

                            <tr>
                                <td>
                                    <?=t("Imposte")?>
                                    <?php 
                                    
                                    $totalealiquote=0;
                                    foreach($aliquote as $key=>$imp){
                                        echo "<p> $key % - € $imp</p>";
                                        $totalealiquote+=floatval($imp);
                                    }
                                    ?>
                                </td>
                                <td width="300">
                                    <?=t("cart-label-importo")?>
                                    <p class="text-right"><?=$totale?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td width="300">
                                     <?=t("cart-label-sconto")?> &nbsp; &nbsp;<?=$sconto?>%
                                    
                                    <p class="text-right">€ <?=$scontistica;//questa va in differenza?></p>
                                </td>
                            </tr>
                            
                            
                            
                            <tr>
                                <td>

                                </td>
                                <td width="300">
                                     <?=t("imponibile-label")?> 
                                    <p class="text-right"><?php $imponibile=($totale-$scontistica);
                                        echo "€ ".number_format($imponibile,2);
                                            ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td width="300">
                                    <?=t("cart-label-tasse")?> 
                                    <p class="text-right">€ <?=  number_format($totalealiquote,2)?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td width="300">
                                    <h3><?=t("cart-label-totale")?> </h3>
                                    <p class="text-right">€ <?=number_format(($imponibile+$totalealiquote),2,","," ");?></p>
                                </td>
                            </tr>

                        </table>
                    
                    </div>
                    
                </div>
                
                <div class="row hidden-print">
                    <div class="col-xs-12 text-center">
                        
                        <button type="button" class="btn btn-primary" onclick="window.print();"><?=t("Stampa")?></button>
                        
                        <a href="<?="/".getLanguage()."/quote/create-pdf/".MD5($preventivo[0]->idpreventivo)?>" class="btn btn-info" target="_black">
                            <i class="fa fa-file-pdf-o"></i> <?=t("PDF")?> 
                        </a>
                        
                    </div>
                   
                </div>
                
                <br/>
                
                <div class="row hidden-print">
                
                    <div class="col-xs-12">
                        <h4><?=t("Apri una discussione sul preventivo")?></h4>
                        <form action="/<?=getLanguage()?>/replymessage" id="formreply" method="post" class="text-center">

                            <input type='hidden' name='refcode' value='<?=$codice?>' id="refcode">

                            <textarea name="messaggio" class="form-control" style="max-width: 100%;min-height: 120px;" placeholder="<?=t("Scrivi un messaggio come nota")?>"></textarea>
                            <br/>

                            <input type='submit' class="btn btn-success" value="Invia">
                        </form>
                    </div>
                    
                    <hr/>
                    
                    

                </div>
                
                <div class="row hidden-print">
                
                    <div class="col-xs-12" id="discussion"></div>

                </div>
                
            </div>
            
        </div>
        <div class="divider1 hidden-print">
            
          
            
            
            
            
        </div>
        
        
        
        <!-- altri file js -->
<?php _getJs() ?>
        
        
        
    </body>
</html>