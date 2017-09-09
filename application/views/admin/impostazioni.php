<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');


?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
        <h1>&nbsp;</h1>
      
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> <?=t("Dashboard");?></a></li>
        <li class="active"><?=t("Impostazioni");?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
                
            <div class="col-xs-12">
                
                <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              
              <li class="active"><a href="#pagamenti" data-toggle="tab"><?=t("Pagamenti")?></a></li>
              <li><a href="#tasse" data-toggle="tab"><?=t("Tassazioni")?></a></li>
              
              
              <li class="pull-right">
                  <!--a href="#" class="btn btn-success"><i class="fa fa-save"></i> <?=t("Salva")?></a-->
              </li>
            </ul>
                    
            <div class="tab-content">
              <div class="tab-pane active" id="pagamenti">
                <?php
                $this->view('admin/inc/pagamenti.php');
                ?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tasse">
                <?php
                $this->view('admin/inc/tasse.php');
                ?>
              </div>
             
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
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