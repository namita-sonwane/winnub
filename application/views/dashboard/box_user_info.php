<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?><div class="spanelinfo">

        <?php $statoprofilo=($this->user->statoProfilo());

       $progress=intval($statoprofilo["valore"]);
       //print_r($statoprofilo);
       //echo $progress;
       /*
       $this->view('limap/info_box_colorato',
            array(
            "classe"=>"bg-yellow",
            "testo"=>"Il tuo profilo",
            "valore"=>$progress,
            "testo2"=>"Prova",
            "numero"=>$progress,
            ""=>""
           )
       );*/
  ?>

        <div class="small-box bg-yellow">
            <div class="inner">
              <h4> <?=t("saluta")?> 
                  <?=$this->user->getProfile("nome")?> <?=$this->user->getProfile("cognome")?>
                <br/>
              </h4>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>

            <a href="<?=base_url("/profilo")?>" class="small-box-footer">
              <?=t("aggiorna")?> <i class="fa fa-arrow-circle-right"></i>
            </a>
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                        <li>
                            <a href="<?php echo base_url("$lingua/profilo")?>">
                              <?=t("messaggio-stato-profilo")?> <?=$progress."%"?>
                            </a>
                        </li>

                        <li>
                             <a href="<?php echo base_url("$lingua/clienti")?>">
                                <?=t("clienti")?>
                             </a>
                        </li>
                </ul>
            </div>
        </div>

</div>