<?php

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
        <?=$PAGE_TITLE?> 
        <small><?=$PAGE_SUB_TITLE?> </small>
      </h1>
      <?php get_breadcrumbs();?>
    </section>


        <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="panel panel-default">
                    
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=t("Gestisci-i-tuoi-compito")?></h3>
                    </div>
                    <div class="panel-body">
                        <?php if($this->session->flashdata('msg')){?>
                          <div class="alert alert-success">      
                            <?php echo $this->session->flashdata('msg')?>
                          </div>
                        <?php } ?>
                        
                        <div class='list-group'>
                        <form class="form" action="/<?=getLanguage()?>/compito/save" method="POST" id="formsavecompito" enctype="multipart/form-data">
    
    
        <div class="row">
            <?php
                
            
                if( is_array($compito) ){

                    $compito=$compito[0];
                }
                
                
               //print_r($cliente);
            ?>
            
            
            
            <div class="col-xs-12 col-sm-12 col-md-8 ">
                
                
                
                <div class="panel panel-default">
                    
                   <!--  <div class="panel-heading">
                        <h3 class="panel-title">Dati compito</h3>
                    </div> -->
                    
                    
                    <div class="panel-body">
                        
                        
                        <div class="form-group">
                            <label><?=t("nome-utente")?></label>
                            <input type="text" name="nome" class="form-control" value="<?=$fornitori->nome_utente?>" required>
                        </div>
                   
                       
                          <div class="form-group">
                            <label><?=t("Description")?></label>
                            <textarea name="description" class="form-control"></textarea>
                           
                         </div>
                            
                         <div class="form-group">
                            <label><?=t("Stato ")?></label>
                            <select name="taskstatus"  class="form-control" required>
                             <option value="Inprogress">In progress </option>
                                <option value="Pending">Pending  </option>
                                <option value="Done">Done </option>
                            </select>
                        </div>


                           <div class="form-group">
                            <label><?=t("file")?></label>
                            <input type="file" name="taskdoc" class="form-control">
                           
                         </div>

                          <div class="form-group">
                            <label><?=t("url")?></label>
                           <input type="url" name="compitourl" class="form-control">
                           
                         </div>

                          <div class="form-group">
                            <label><?=t("Task Priority")?></label>
                            <div class="form-group">
                            <input type="checkbox" name="priority" value="Deadlinedate"> <?=t("Deadline date")?><br>
                            <input type="checkbox" name="priority" value="Highpriority" > <?=t("High priority")?><br>
                            </div>
                           
                         </div>
                       

                    </div>
                </div>
               
                
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-4">
                
                
                <div class="box">
                     <div class="box-body">
                         <div class="input-group date">
                         <label><?=t("Data di creazione")?></label>
                            <input type="date" name="createdon" value="" class="form-control" required>
                       
                        </div>
                    </div>


                    <div class="box-body">
                         <div class="input-group date">
                         <label><?=t("End date")?></label>
                            <input type="date" name="enddate" value="" class="form-control" required>
                       
                        </div>
                    </div>
                </div>
                
                
                

                       <div class="box box-default <?=(!isset($smart) && $smart==false)?"":"hidden"?>">
                   
                    <div class="box-body">
                        <div class="form-group">
                            
                            <input type="hidden" name="codcompito" value="<?=($contatto->codcontatto>0)?($contatto->codcontatto):0; ?>">
                            
                            <a class="btn btn-danger" href="/compito"><?=t("Torna-indietro")?></a>
                            <button type="submit" class="btn btn-success" name="savecompito" value="1"><?=t("Salva")?></button>
                            
                        </div>
                    </div>
                </div>


               
                
            </div>
        </div>
            
</form>


                           
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