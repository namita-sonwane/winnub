<?php

//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');

//questa chiamata è solo admin
//$tabella=$this->adminuser->getMy("ordini");
    


?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=_PROJECT_NAME_?> 
        <small> panel Model </small>
      </h1>
        
      <?php get_breadcrumbs();?>
     
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="panel">
                    
                    <div class="panel-heading">
                        <h3 class="panel-title"> Seleziona cosa gestire</h3>
                    </div>
                    <div class="panel-body">
                        
                        <div class=''>
                            
                            <?php 
print_r($this->user);

?>
                               
                        </div>
                
                    </div>
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