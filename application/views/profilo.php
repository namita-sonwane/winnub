<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
        <li><a href="/dashboard"><i class="fa fa-dashboard"></i> <?=t("Dashboard")?></a></li>
        <li class="active"><?=t("Profilo")?></li>
      </ol>
    </section>
    
   

    <!-- Main content -->
    <section class="content">
        
        
         <?php if($_RESULT_):?>
    <div class="panel panel-success">
        <h3>Aggiornato con successo!</h3>
    </div>
           
   <?php endif;?>
        
       
        
        
        <div class="row">
            <form class="for form-inlinem" enctype="multipart/form-data" method="post" action="<?=base_url(getLanguage()."/profilo/salva")?>" id="formprofilo">
                  
            <div class="col-xs-12 col-sm-8">
                <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab1" data-toggle="tab"><?=t("Profilo")?></a></li>
                
              <li><a href="#tabfatt" data-toggle="tab"> <?=t("Intestazione")?></a></li>
              
              <li><a href="#tabaccount" data-toggle="tab"><?=t("Dati-accesso")?></a></li>
              
              <?php if($this->user->isAdmin()){?>
              <li><a href="#tabazienda" data-toggle="tab"><?=t("impostazioni-azienda")?></a></li>
              <?php }?>
              
              <li class="pull-right header">
                  <button type="submit" class="btn btn-success" name="saveprof" value="1"> 
                      <i class="fa fa-th"></i> Salva Profilo 
                  </button>
              </li>
            </ul>
            <div class="tab-content">
             
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="tab1">
                  
                  <?php
                  
                  $this->view("profile/tab_profilo");
                  
                  ?>
                   
              </div>
              <!-- /.tab-pane -->
              
               
              <div class="tab-pane" id="tabfatt">
                  
                   <?php
                  
                  $this->view("profile/tab_intestazione");
                  
                  ?>
                  
              </div>
              <!-- /.tab-pane -->
              
              
              <div class="tab-pane" id="tabaccount">
                  
                  
                   <?php
                  
                  $this->view("profile/tab_accesso");
                  
                  ?>
                  
                   
                  
              </div>
              
                <div class="tab-pane" id="tabazienda">
                      <?php
                  
                  $this->view("profile/tab_azienda");
                  
                  ?>
                 </div>
              
            </div>
            <!-- /.tab-content -->
            </div>
                
            </div>
                  
                 
                
                <div class="col-md-4">
                    
                    
                    <?php
                
                    $this->view('limap/_widget_user_info');
                        
                ?>
          
          
          
                    <div class="panel">
                          <div class="panel-body">
                              <h4><?=t("carica immagine personale")?></h4>
                              <input id="immagineprofilo" type="file" accept="image/*" name="immagineprofilo">
                          </div>
                          
                    </div>
          
                </div>
                  
                  
                  
            </form>
            
            
            
        </div>
        
        
        
        

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
//includo l'header
$this->view('limap/_footer');