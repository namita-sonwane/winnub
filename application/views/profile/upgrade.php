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
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Profilo</li>
      </ol>
    </section>
    
   

    <!-- Main content -->
    <section class="content">
        
        
        <div id="" class="row">
            <div class="col-xs-12 col-sm-10">
                
                <?php
                    
                    $status=$this->azienda->getStatusAccount();  
                    $statoaccount=$this->azienda->getStatusAccount();
                    
                    //
                    if(count($statoaccount)>0){
                        $statoaccount=$statoaccount[0];
                        //print_r($statoaccount);
                    }
                    
                    if($statoaccount->stato=='attivo'){
                            
                        $this->view('pagamenti/conferma_dati');
                        
                    }else if($statoaccount->stato=='attesa'){
                        
                         $this->view('pagamenti/inattesa');
                         
                    }else if($statoaccount->stato=='scaduto'){
                        
                        $this->view('pagamenti/conferma_dati');
                        
                    }
                
                ?>
                
            </div>
        </div>
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
//includo l'header
$this->view('limap/_footer');