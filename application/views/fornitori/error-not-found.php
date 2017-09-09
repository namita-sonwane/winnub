<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->view('limap/_header');


$this->view('limap/_sidebar');

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
            <div class="col-md-10 col-md-offset-1" style="margin-top: 160px;">
                 <div class="panel panel-af panel-default panel-danger">
                     <div class="panel-title text-center">
                           <h2 class=""><?=t("Attenzione! ")?></h2>
                           <h4><?=t("Utente non trovato")?></h4>
                     </div>
                     <div class="panel-body">
                          <p><?=t("Stai accendendo ad un dato non presente o non consentito dai tuoi permessi")?></p>
                          <p><?=t("Se il problema persiste contattare il <a href=''>servizio clienti</a> o <a href=''>apri un ticket</a>")?></p>
                     </div>
                    </div>
            </div>
            
           
            
        </div>
       
        
        
    </section>
    
     
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
$this->view('limap/_footer');