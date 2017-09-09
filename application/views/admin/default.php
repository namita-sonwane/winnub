<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');


$tabella=$this->user->getMy("ordini");
    


?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=_config("site_name")?>  
        <small><?=t("Impostazioni Winnub ");?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?=t("Dashboard");?></a></li>
        <li class="active"><?=t("Impostazioni");?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
            <form action="<?=  base_url("/admin/saveprofile")?>" role="form" class="form">
                
            <div class="col-xs-8">
                
                <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#business" data-toggle="tab"><?=t("Dati azienda")?></a></li>
              <li><a href="#tasse" data-toggle="tab"><?=t("Tassazioni")?></a></li>
              <li><a href="#trasporto" data-toggle="tab"><?=t("Spedizioni")?></a></li>
              
              <li class="pull-right">
                  <a href="#" class="btn btn-success"><i class="fa fa-save"></i> <?=t("Salva")?></a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="business">
                <?php
                $this->view('admin/inc/business.php');
                ?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tasse">
                <?php
                $this->view('admin/inc/tasse.php');
                ?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="trasporto">
                <?php
                $this->view('admin/inc/trasporto.php');
                ?>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
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