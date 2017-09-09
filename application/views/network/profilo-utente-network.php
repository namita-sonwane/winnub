<?php defined('BASEPATH') OR exit('No direct script access allowed');

//includo l'header
$this->view('limap/_header');

$this->view('limap/_sidebar');


$user=$this->adminuser->getUserProfile($codice);   



//print_r($user);
?>
    
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       &nbsp;
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?=t("dashboard")?></a></li>
        <li class="active"><?=t("profilo")?></li>
      </ol>
    </section>
    
   

    <!-- Main content -->
    <section class="content">
        
        
        
        
        <div class="row">
            
            
            <div class="col-sm-4">
                
                <div class="box box-primary">
                    
                    <div class="box-body box-profile">
                        
                        <?php if($user->iduser==$this->user->iduser){?>
                        <a href="/profile/" class="btn btn-sm pull-right"><?=t("Modifica")?> <i class="fa fa-edit"></i></a>
                        <?php }?>

                        <div class="imageuser-network">
                        <?php

                        $a=$user->getPhoto();
                        if($a!=null){
                            echo "<img src='/$a'class='profile-user-img img-responsive img-circle'>";
                        }
                        ?>
                            <h3 class="profile-username text-center" id="network-username">@<?=$user->username?></h3>
                        </div>

                            <ul class='list-group'>

                               
                                <li class='list-group-item'>
                                    <i class="fa fa-user"></i>&nbsp;<?=$user->profile["nome"]?> <?=$user->profile["cognome"]?>
                                </li>
                              
                                <li class='list-group-item'>
                                   <i class="fa fa-map-marker"></i>&nbsp; <?=$user->profile["indirizzo"].", ".$user->profile["cap"].", ".$user->profile["comune"].", ".$user->profile["provincia"]?>
                                </li>

                                <li class='list-group-item'>
                                    <i class="fa fa-phone"></i>&nbsp; <?=$user->profile["telefono"]?> 
                                </li>
                                
                                <li class='list-group-item'>
                                  <i class="fa fa-mobile-phone"></i>&nbsp; <?=$user->profile["mobile"]?>
                                </li>

                                  <li class='list-group-item'>
                                   <i class="fa fa-empire"></i>&nbsp; <?=$user->email?>
                                </li>


                            </ul>
                    </div>
                    
                </div>
                
                
                
                
                <div class="boxchat <?=($codice!=$this->user->iduser )?"opened":""?>">
                    
                    <?php
                        
                        if( $codice!=$this->user->iduser ){
                            $this->view("network/chat-network",array("username"=>$user->username));
                        }else{
                             $this->view("network/recent-chat-network");
                        }
                        
                    ?>
                    
                </div>
                
                
                
            </div>
            
            
            <div class="hidden-sm hidden-md hidden-lg col-xs-12">
                <div class="img-thumbnail ">
                    <?php
                        $a=$user->getPhoto();
                        if($a!=null){
                            echo "<img src='/$a' class='img-responsive'>";
                        }
                    ?>
                </div>
            </div>
            
            
            <div class="col-xs-12 col-sm-8">
                
                
                <div class="nav-tabs-custom">
                    
                    <ul class="nav nav-tabs">
                        
                        <li class="active">
                            <a href="#stat" data-toggle="tab">Statistiche</a>
                        </li>
                        
                        <li>
                            <a href="#activity" data-toggle="tab">Timeline</a>
                        </li>
                        
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="stat">
                            <div class="box">
                        
                        <div class="box-body">
                            <div class="row">
                                
                                 <div class="col-xs-12 col-sm-8">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">

                                                <label><?=t("Preventivi")?></label>
                                                <canvas id="statChart" data-userdet="<?=$codice?>" style="height: 360px;width: 100%;"></canvas>
                                            </div>

                                        </div>
                                    </div>
                         
                                </div>
                    
                                <div class="col-xs-12 col-sm-4">
                                     <div class="panel">

                                         <div class="panel-header">
                                             <h4>Globals</h4>
                                         </div>
                                         <div class="panel-body">
                                             <div class="row">
                                                <div id="legend2"></div>
                                                <canvas id="pieChart" data-userdet="<?=$codice?>" style="height: 260px;width: 100%;"></canvas>
                                             </div>

                                         </div>
                                     </div>
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                        </div>
                        <div class="tab-pane" id="activity">
                            
                              
                                    <?php

                                        if($this->user->isAdmin() && !$user->isAdmin()){

                                            $logs=$user->getTimelineLog();


                                            $this->view('network/timeline',array("timeline"=>$logs));

                                        }

                                    ?>

                        </div>
                    </div>
                    
                </div>
                
                
                    
                    
                    
                    
                    
                    
                    
               
               
               
                
                <hr/>
                
            
                
            </div>
            
            
            
            
        </div>
        
        
      
        
        
        <div class="row">
            
                <section class="streamspace">
                    <div id="userstream"></div>
                </section>
                
                
              
        </div>
        
        
        
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
//includo l'header
$this->view('limap/_footer');