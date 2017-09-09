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
                        <h3 class="panel-title"><?=t("Gestisci-i-tuoi-Compito")?></h3>
                    </div>
                    <div class="panel-body">
                        <?php if($this->session->flashdata('msg')){?>
                          <div class="alert alert-success">      
                            <?php echo $this->session->flashdata('msg')?>
                          </div>
                        <?php } ?>
                        <div class='list-group'>
                       <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><?=t("Sr.no")?></th>
                <th><?=t("Nome")?></th>
                <th><?=t("Description")?></th>
                <th><?=t("Priority")?></th>
                <th><?=t("Stato")?> </th>
                <th><?=t("Data-creazione")?></th>
                 <th><?=t("Data-fine")?></th>
                <th><?=t("File")?></th>
                <th><?=t("Azioni")?></th>
            </tr>
        </thead>
       
        <tbody>
        <?php $i = 1;
         foreach ($tasklist as $task){?>
            <tr <?php if($task->priority=='Highpriority'){?> style="color:red;" <?php }?>>
             <td><?php echo $i;?></td>
             <td><?php echo $task->nome;?></td>
             <td><?php echo $task->description;?></td>
             <td><?php echo $task->priority;?></td>
             <td><?php echo $task->status;?></td>
             <td><?php echo $task->createdon;?></td>
             <td><?php echo $task->end_date;?></td>
              <td><?php if(isset($task->doctype) && $task->doctype=='jpg' && $task->doctype=='png' && $task->doctype=='gif') {
                ?><img src="<?php echo base_url();?>uploads/<?php echo $task->taskdoc;?>" style="height: 80px; width:80px;">
                <?php }else{
                  ?><i class="fa fa-file" aria-hidden="true"></i><?php
                  }?></td>
             
              <td> <a href="/<?=getLanguage()?>/compito/getcompito/<?=($task->codcompito)?>"  class="btn btn-default btn-sm"> <?=t("modifica")?> </a>
                 <a href="/<?=getLanguage()?>/compito/delete/<?=($task->codcompito)?>"  onClick="javascript: return confirm('Are you sure to delete this item?');" class="btn btn-danger btn-sm eliminacliente"> <?=t("elimina")?></a></td>
            </tr>
            <?php $i++; } ?>
        </tbody>
    </table>


                           
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