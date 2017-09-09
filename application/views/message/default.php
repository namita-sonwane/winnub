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



?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      
      <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        &nbsp;
      </h1>
      <ol class="breadcrumb">
          <li class=""><a href="/dashboard"><?=t("dashboard-sezione")?></a></li>
            <li class="active"><?=t("messaggi-sezione")?></li>
      </ol>
    </section>
      
      <script>
          var language="<?=getLanguage()?>";
          
     </script>
   
    <section class="content">
        <div class="row">
            
            
            <?php /** DISABLE ANGULAR <div ng-app="winnub" >
                <div ng-view></div>    
            </div>
            */
            ?>
             <div class="col-md-3 hidden">
         
     
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><?=t("Cartelle")?></h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                  
                <li class="<?=( $sezione=="message-index")?"active":""?>"><a href="/message/"><i class="fa fa-inbox"></i> Inbox
                  <span class="label label-primary pull-right"><?=count($newmessage)?></span></a>
                </li>
                  
                <li class="<?=( $sezione=="message-send")?"active":""?>"><a href="/message/send"><i class="fa fa-envelope-o"></i> Sent</a></li>
               
              
                <li class="<?=( $sezione=="message-trash")?"active":""?>"><a href="/message/trash"><i class="fa fa-trash-o"></i> Trash</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
                 
                 
          
        </div>
        <!-- /.col -->


        
        <div class="col-xs-12">
          <?php
          
               
                $this->view('message/list_inbox',array("messaggi"=>$messaggi));
                
          ?>
        </div>

    
            

        </div>
    
      
    </section>
      
  </div>
<?php


$this->view('limap/_footer');
?>