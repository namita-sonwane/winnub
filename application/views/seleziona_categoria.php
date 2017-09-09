<?php defined('BASEPATH') OR exit('No direct script access allowed');


//includo l'header
$this->view('limap/_header');

$gruppi=$this->modello_prodotti->getGruppi();


?>

<?php $this->view('limap/_sidebar');?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       &nbsp;
      </h1>
      <ol class="breadcrumb">
          <li><a href="/<?=getLanguage()?>/dashboard"><i class="fa fa-dashboard"></i> <?=t("dashboard")?></a></li>
        <li class="active"> <?=t("preventivo")?> </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
        
        
        <div class="col-xs-12 col-sm-12">
            
            <div class='panel'>
                
                <div class='panel-body'>
                    
               
            <ul class="nav nav-tabs" role="tablist">
                <?php
                if(count($gruppi)>0){
                    $i=0;
            foreach($gruppi as $k=>$gruppo){?>
                <li role="presentation" class="<?=($i==0)?"active":""?>">
                    <a href="#grups<?=url_title($k)?>"  aria-controls="#grups<?=url_title($k)?>" role="tab" data-toggle="tab">
                    <?=ucfirst(t($k))?></a>
                </li>
                <?php 
                
                $i++;
            }
            }?>
                
            </ul>
            
            <div class="tab-content">
            <?php
            $i=0;
            //print_r($gruppi);
            if(count($gruppi)>0){
            foreach($gruppi as $k=>$gruppo){
                
            ?>
            
            <div role="tabpanel" class="tab-pane <?=($i==0)?"active":""?>" id="grups<?=url_title($k)?>">
                
               
                <br/>
                <div class="">
                    
                     <div class="list-group" data-grupid="<?=url_title($k)?>">
                         
        <?php   foreach($gruppo as $g){ 
                    
                    //verifico la presenza di richieste
                    $getparams="";
                    
                    if(count($_GET)>0){
                        
                        foreach ($_GET as $key => $value)
                        {
                             $getparams[] = $key.'='.$value;
                        }
                        
                        $getparams="?".implode("&",$getparams);
                    }?>
                         <a class="list-group-item" href="<?=base_url("/".getLanguage()."/quote/create/".$g["nome"]."/".$g["idcategoria"].$getparams)?>">
                            <h4><?=$g["valore"]?></h4>
                            <p>
                                <?=$g["descrizione"]?>
                            </p>
                         </a>
                    <?php
                    
                    /*PRIMA VERSIONE DELLA LISTA
        ?>
                         
                        <div class="boxcat" data-codice="<?=$g["idcategoria"]?>">
                            <div class="boxcat-header">
                                <h5><?=$g["valore"]?></h5>
                            </div>
                            <div class="boxcat-content">
                            <a href="<?=base_url("/".getLanguage()."/quote/create/".$g["nome"]."/".$g["idcategoria"].$getparams)?>">
                               <?=t("seleziona")?>
                            </a>
                            </div>
                            
        <?php           */          
                    //verifico se si tratta del proprietario o di un collaboratore ?>
                            
                        
                        
        <?php   } ?>
                    </div>
                         
                    
                </div>
                
            </div>
            <?php 
            
            $i++;
            
            }
            
            
          }else{
             
         ?>
            <div class="text-center">
                    <br/><br/>
                
            <a href="/<?=getLanguage()?>/prodotti/gestione/categorie" class="btn btn-default btn-lg button-startcategory"><?=t("Crea nuova categoria")?></a>
            </div>
            <?php }?>
            
            </div>
                    
         </div>
                
        </div>
       
            
            
            
        </div>
        </div>
        <?php 
        /*<div class="row text-center">
            <div class="col-xs-12 col-sm-2 text-center">
                            <a href='#' class='btn btn-default' 
                               data-toggle="modal" 
                               data-target="#modalcategoria"><?=t("Crea nuovo gruppo")?></a>
                         </div>
        </div>*/
        ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
//includo l'header
$this->view('limap/_footer');