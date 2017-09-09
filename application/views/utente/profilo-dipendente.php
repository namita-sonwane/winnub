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
        <?=t('Profilo-utente')?> <?=$codice?> 
        <small><?=t("dashboard utente")?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?=t("dashboard")?></a></li>
        <li class="active"><?=t("profilo")?></li>
      </ol>
    </section>
    
   

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
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
            
            <div class="col-xs-12 col-sm-9">
                
            </div>
            
            
            <div class="hidden-xs col-sm-3">
                
                
                <div class="img-thumbnail ">
                <?php
                
                $a=$user->getPhoto();
                if($a!=null){
                    echo "<img src='/$a' class='img-responsive'>";
                }
                ?>
                </div>
                <div class="panel panel-default ">
                    
                    
                    
                    <ul class='list-group'>
                        
                        <li class='list-group-item'>
                            username: <?=$user->username?> 
                        </li>
                        <li class='list-group-item'>
                            <?=$user->profile["nome"]?> <?=$user->profile["cognome"]?>
                        </li>
                        <li class='list-group-item'>
                            <?=$user->profile["cognome"]?>
                        </li>
                        <li class='list-group-item'>
                            <?=$user->profile["indirizzo"].", ".$user->profile["cap"].", ".$user->profile["comune"].", ".$user->profile["provincia"]?>
                        </li>
                        
                         <li class='list-group-item'>
                            <?=$user->profile["telefono"]?> -  <?=$user->profile["mobile"]?>
                        </li>
                       
                         
                         
                    </ul>
                </div>
                
            </div>
            
        </div>
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
//includo l'header
$this->view('limap/_footer');