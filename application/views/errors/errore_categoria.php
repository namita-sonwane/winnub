<?php  defined('BASEPATH') OR exit('No direct script access allowed');

//includo l'header
$this->view('limap/_header');




?>

<?php $this->view('limap/_sidebar');?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Errore
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
        
        
        <h1>Access error...</h1>
        <p>Non hai le autorizzazioni per accedere a questa sezione</p>
        <?php
        
        $bannato="";
        $_SESSION["banned"]="true";
        //redirect("logout/");
        
        ?>
       
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
//includo l'header
$this->view('limap/_footer');