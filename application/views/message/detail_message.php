<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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
          <li class=""><a href="/dashboard"><?=t("dashboard-sezione")?></a></li>
            <li class="active"><?=t("messaggi-sezione")?></li>
      </ol>
    </section>
      
      <script>
          var language="<?=getLanguage()?>";
          
     </script>
   
    <section class="content">
        <div class="row">

        <!-- /.col -->
        <div class="col-md-9">
          <?php
          
               $mess=$this->Messaggio_model->get($codice);
               
               
               $messagereply=$mess->getReplicheMessaggi();
               
               //print_r ($messagereply);
                
          ?>
            <div class="box box-default">
                    
                <div class="box-header">
                    <h4><?=$mess->subject?></h4>
                </div>
                <div class="box-body">
                    <p>
                        <?=$mess->message?>
                    </p>
                </div>
                
                <div class="box-footer">
                    <?php foreach($messagereply as $repl):
                        
                        $dati=array(
                            "messaggio"=>$repl->message,
                            "subject"=>$repl->subject." - ".t("inviato in data: ").$repl->data
                            );
                        $this->view("message/repl_message",$dati);
                        
                        endforeach;?>
                    
                </div>
                
            </div>
        </div>

        
        <div class="col-md-3">
            
            <?php if(isset($mess->esternalcode)):?>
                <a href="/<?=getLanguage()?>/qdetail/<?=$mess->esternalcode?>" class="btn btn-default btn-block">Mostra preventivo pubblico</a>
            <?php endif;?>
            <div id="dettagli">
                
                
                
            </div>
            
        </div>
    
            

        </div>
    
      
    </section>
      
  </div>
<?php


$this->view('limap/_footer');
?>