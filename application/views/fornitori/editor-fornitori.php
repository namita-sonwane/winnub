<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');

//questa chiamata è solo admin





?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <!-- <h1>
        <?=$PAGE_TITLE?> 
        <small><?=$PAGE_SUB_TITLE?> </small>
      </h1>-->
      <?php get_breadcrumbs();?>
    </section>

    <!-- Main content -->
    <section class="content">
        
       
        
        <?php
        
        //print_r($codice);
         
        $this->view('fornitori/form_fornitori',array("fornitori"=>$fornitore));
        
        ?>
    </section>
    
     
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  

<?php
//includo l'header
$this->view('limap/_footer');