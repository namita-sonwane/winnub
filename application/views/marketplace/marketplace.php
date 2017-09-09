<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->view('limap/_header');


$this->view('limap/_sidebar');

?>
<link rel="stylesheet" href="/public/bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?=$PAGE_TITLE?>
      <small>
      <?=$PAGE_SUB_TITLE?>
      </small> </h1>
    <?php get_breadcrumbs();?>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <?php if($this->session->flashdata('msg')){?>
            <div class="alert alert-success"> <?php echo $this->session->flashdata('msg')?> </div>
            <?php } ?>
            <div class='list-group'>
				<img src="/uploads/marketplace.png" height="592" alt="Marketplace" title="Marketplace" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $this->view('limap/_footer'); ?>
