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
      
      <?php get_breadcrumbs();?>
    </section>


        <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="">
                    
                    
                    <div class="panel-body">
<?php if($this->session->flashdata('msg')){?>
  <div class="alert alert-success">      
    <?php echo $this->session->flashdata('msg')?>
  </div>
<?php } ?>
                        
                        <div class='list-group'>
                        <form class="form" action="/<?=getLanguage()?>/contatto/save" method="POST" id="formsavecontatto">
    
                            <div class="row">
                                <div class="barra-azione">
                    
                            
                                <button type="submit" class="btn btn-success" name="savecontatto" value="1"><?=t("Salva")?></button>
                              
                              
                            
                                <a href="/<?=getLanguage()?>/contatto/contattoexcle" class="btn colore-secondario">
                                    <i class="fa fa-upload"></i><b>Import file</b>
                                </a>
                                    
                                <a class="btn btn-danger" href="/<?=getLanguage()?>/contacts"><?=t("Torna-indietro")?></a>
                            

                 
                          
                                 
                </div>
            
                            </div>
        <div class="row">
            <?php
                
            
                if( is_array($contatto) ){

                    $contatto=$contatto[0];
                }
                
                
               //print_r($cliente);
            ?>
            
            
            
            <div class="col-xs-12 col-sm-12 col-md-8 ">
                
                
                
                <div class="panel panel-default">
                    
                  
                    
                    
                    <div class="panel-body">
                        
                        
                        <div class="form-group">
                            <label><?=t("nome-utente")?></label>
                            <input type="text" name="nome" class="form-control" value="<?=$fornitori->nome_utente?>" required>
                        </div>
                          

                       
                          <div class="form-group">
                            <label><?=t("email-contatto")?></label>
                            <input type="email" name="email" class="form-control" value="<?=$fornitori->email?>" required>
                         </div>
                            
                       

                       <div class="form-group">
                            <label><?=t("mobile-contatto")?></label>
                            <input type="text" name="mobile" class="form-control" value="<?=$fornitori->mobile?>" required>
                        </div>

                        
                          <div class="form-group">
                            <label><?=t("Description-contatto")?></label>
                            <textarea name="description" class="form-control"></textarea>
                           
                         </div>

                         <div class="form-group">
                            <label><?=t("Stato Contatto")?></label>
                            <select name="leadstatus"  class="form-control" required>
                                <option value="Notattempted"><?=t("Notattempted")?></option>
                                <option value="Contacted"><?=t("Contacted")?></option>
                                <option value="Inprogress"><?=t("In progress")?></option>
                                <option value="Disqualifed"><?=t("Disqualifed")?></option>
                            </select>
                        </div>

                       

                    </div>
                </div>
               
                
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-4">
                
                
                <div class="box">
                    <div class="box-header">
                       <!--  <h3 class="box-title">Data di creazione</h3> -->
                    </div>
                    <div class="box-body">
                         <div class="input-group date">
                         <label><?=t("Data di creazione")?></label>
                            <input type="date" name="createdon" value="" class="form-control" required>
                       
                        </div>
                    </div>
                </div>
                
                
                
                     <input type="hidden" name="codcontatto" value="<?=($contatto->codcontatto>0)?($contatto->codcontatto):0; ?>">
                      


               
                
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
  
  <script type="text/javascript">
      $.fn.datepicker.defaults.format = "mm/dd/yyyy";
$('.datepicker').datepicker({
    startDate: '-3d'
});
  </script>
  

<?php
//includo l'header
$this->view('limap/_footer');