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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        &nbsp;
        
      </h1>
      <?php get_breadcrumbs();?>

    </section>


        <!-- Main content -->
    <section class="content">
        
        
        <?php 
        
        
        $this->view('limap/_barra_strumenti',
                array(
                    "buttons"=>array(
                        array("nome"=>t("nuovo"),"href"=>"/".getLanguage()."/contatto","class"=>"btn btn-actions-winnub1","icona"=>'<i class="fa fa-plus"></i>'),
                        array("nome"=>t("importa"),"href"=>"/".getLanguage()."/contatto/contattoexcle","class"=>"btn colore-secondario","icona"=>'<i class="fa fa-upload"></i>')
                    )
                )
                );?>
        
        
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="panel panel-default">
                    
                  
                    
                    <div class="panel-body">
                        
                        <?php if($this->session->flashdata('msg')){?>
                          <div class="alert alert-success">      
                            <?php echo $this->session->flashdata('msg')?>
                          </div>
                        <?php } ?>
                      
                       <table id="example" class="table table-striped datatabless" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      <th><?=t("Sr.no");?></th>
                                      <th><?=t("Nome");?></th>
                                      <th><?=t("Email");?></th>
                                      <th><?=t("Number");?></th>
                                      <th><?=t("Stato");?></th>
                                      <th><?=t("Data di creazione");?></th>
                                      <th><?=t("Action");?></th>
                                  </tr>
                              </thead>
                             
                              <tbody>
                              <?php $i = 1;
                               foreach ($contact as $conlist){?>
                                  <tr>
                                   <td><?php echo $i;?></td>
                                   <td><?php echo $conlist->nome;?></td>
                                   <td><?php echo $conlist->email;?></td>
                                   <td><?php echo $conlist->mobile;?></td>
                                   <td><?php echo t($conlist->leadstatus);?></td>
                                   <td><?php echo date(t('date-format-default'),strtotime($conlist->createdon));?></td>
                                    <td> <a href="/<?=getLanguage()?>/contatto/getcontact/<?=($conlist->codcontatto)?>"  class="btn btn-default btn-sm"> <?=t("modifica")?> </a>
                                       <a href="/<?=getLanguage()?>/contatto/delete/<?=($conlist->codcontatto)?>"  onClick="javascript: return confirm('Are you sure to delete this item?');" class="btn btn-danger btn-sm eliminacliente"> <?=t("elimina")?></a></td>
                                  </tr>
                                  <?php $i++; } ?>
                              </tbody>
                          </table>


                    
                
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript">
      $.fn.datepicker.defaults.format = "mm/dd/yyyy";
$('.datepicker').datepicker({
    startDate: '-3d'
});

$(document).ready(function() {
    $('#example').DataTable();
} );

  </script>
  

<?php
//includo l'header
$this->view('limap/_footer');