<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <?=$PAGE_TITLE?>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
        
        <form method="post" action="<?=$frm_action?>">
            
            <?php 
            
            //print_r($prodotto);
            
            $this->view($form_file);
            
            
         ?>
           
            
        </form>
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
