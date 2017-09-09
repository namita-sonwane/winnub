<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//$fullreports=$this->user->fullReportDashboard();
//$statistiche=($this->user->getStatisticheVendite());

//
        $adminbloc=false;
        if($this->user->isAdmin()){
            $adminbloc=true;
            
            $dataursers=$this->adminuser->getInfoUsers();
            
        }else{
            
        }
    
        $datariferimento=" Dal ".date("d/m/y",strtotime(("- 7 day ")))." - ".date("d/m/Y")." ";
    
    

?><div class="row">
    
        <div class="col-xs-12 col-md-8">
            
            
            
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title"><?=t("Report annuale")?></h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="row">

                      <div class="col-xs-12 <?=($adminbloc)?" col-xs-12 col-sm-12 col-md-12":" col-md-12";?> ">

                          <p class="text-center hidden">
                              <strong id="date-reference-stat"> <?=$datariferimento?> </strong> &nbsp;
                              <select name="periodostatistiche" class="selezionastat">
                                  <option value='365'> Annuale </option>
                                  <option value='30'> Mensile </option>
                                  <option value='7'> Settimanale </option>
                              </select>
                          </p>

                          <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="salesChart" style="height: 320px;"></canvas>
                          </div>
                        <!-- /.chart-responsive -->
                      </div>
                      <!-- /.col -->

                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
          <!-- /.box -->
        </div>
    
        <div class="<?=($adminbloc)?"col-xs-12 col-md-4":"hidden";?>">
            
            <?php if($adminbloc){?>
            <div class="panel">
                      <p class="text-center">
                        <strong><?=t("dashboard-users-stats")?></strong>
                      </p>

                      <div id="usernetwork">
                          <ul class="user-list">   
                       <?php //print_r($dataursers);
                            //$this->useer
                       
                            foreach($dataursers as $data){
                                echo " <li class='menu-item'>"
                                        . " <div class='sfaces'><img src='/".$data->media."'></div>"
                                        . " <b>".$data->username."</b> - € ".number_format($data->totale,2,","," ").""
                                    . " </li>";
                            }


                            ?></ul>
                      </div>


                      <!-- /.progress-group -->
             </div>
            <?php }?>
            
            
            <div class="panel panel-default hidden">
               <div class="box-header with-border">
                               <h4><?=t("aggiornamenti")?></h4>
                           </div>

                   <div class="panel-body">




                           <div class="cardnews">

                                   <?php
                                           $urls="https://winnub.com/".getLanguage()."/feed/";     
                                           winnub_feed($urls);


                                   ?>

                           </div>

                   </div>
            </div>
            
    </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
<?php //} ?>