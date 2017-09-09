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
        <form class="form" action="/<?=getLanguage()?>/pdl/saveRuoli" method="POST" id="formsavefornitore">
    
    
        <div class="row">
            <?php
				//echo '<pre>';
				//print_r($singleruoli);
                if( is_array($singleruoli) ){

                    $ruoli=$singleruoli[0];
                }
				else
				{
					$ruoli=$singleruoli;
				}
                
            ?>
            
            
            
            <div class="col-xs-12">
                
                
                
                <div class="panel panel-default">
                    
                    <div class="panel-heading">
                        <!--<h3 class="panel-title">Dettagli fornitore</h3>-->
                    </div>
                    
                    
                    <div class="panel-body">
                        
						  <div class="row">
							<div class="col-md-3">
								<div class="form-group">
								<label><?=t("Interprete")?></label>
								<input type="text" name="interprete" class="form-control" value="<?=$ruoli->interprete?>" required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label><?=t("Ruolo")?></label>
									<input type="text" name="ruolo" class="form-control" value="<?=$ruoli->ruolo?>" required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label><?=t("ID")?></label>
									<input type="number"  name="data_id" class="form-control" value="<?=$ruoli->data_id;?>" required>
								</div>
							</div>
					
                        
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?=t("Data")?></label>
                                    <input type="date" name="data" class="form-control" value="<?=$ruoli->data?>" required>
                                </div>
                            </div>

							
						  </div>
						  
						  <div class="form-group">

                            
                            <input type="hidden" name="ruoli_id" value="<?=($ruoli->id>0)?($ruoli->id):0; ?>">
                            
                            <a class="btn btn-danger" href="/pdl/ruoli"><?=t("Torna-indietro")?></a>
                            <button type="submit" class="btn btn-success" name="saveruoli" value="1"><?=t("Salva")?></button>
                            
                        </div>
                        
                        
                   
                      </div>
                </div>  
				
				
               
                
            </div>
            
        </div>
            
</form>
    </section>


    
<!--End calendar-->
    <section class="content">
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="panel panel-default">
                    
                    <div class="panel-heading">
                        <!--<h3 class="panel-title"><?=t("Gestisci-i-tuoi-Compito")?></h3>-->
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
                <th><?=t("Interprete")?></th>
                <th><?=t("Ruolo")?></th>
                <th><?=t("ID")?></th>                
                <th><?=t("Data")?> </th>               
                <th><?=t("Action")?></th>
            </tr>
        </thead>
       
        <tbody>
        <?php $i = 1;
		
		if(count($ruoli_data) > 0)
		{
			
		
         foreach ($ruoli_data as $task){?>
            <tr>             
             <td><?php echo $task->interprete;?></td>
             <td><?php echo $task->ruolo;?></td>  
             <td><?php echo $task->data_id;?></td>             
             <td><?php echo $task->data;?></td>            
             
			 <td class="text-center">
                                            
				<!-- Small button group -->
				<div class="btn-group">
					  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						  <i class="fa fa-gears"></i>
						  
					   <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" style="margin-left: -64px;">
							<li>
							<a href="/<?=getLanguage()?>/pdl/getruoli/<?=($task->id)?>"  class="btn btn-default btn-sm"> 							
							<i class="fa fa-at"></i>
								  <?=t("modifica")?>
							</a>								
							</li>
							
							<li>
							<a href="#"  class="btn btn-default btn-sm"> 							
							<i class="fa fa-download"></i>
								  <?=t("Export in Excel")?>
							</a>								
							</li>
							
							
							<li>
							<a href="/<?=getLanguage()?>/pdl/deleteruoli/<?=($task->id)?>"  onClick="javascript: return confirm('Are you sure to delete this item?');" class="btn btn-default btn-sm"> 							
							<i class="fa fa-eye"></i>
							<?=t("elimina")?>
							</a>								
							</li>
						  
							
					  </ul>
				</div>                                                      
			</td>

            </tr>
            <?php $i++; }
			}
			else
			{
				echo '<tr ><td colspan="9">No record found!</td></tr>';
			}
			?>
        </tbody>
    </table>


                           
                        </div>
                
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
    
     
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
//includo l'header
$this->view('limap/_footer');
?>
<script>

$( document ).ready(function() {
    console.log( "ready!" );
	$('input[name="data_id"]').keypress(function() {
		if(this.value != '')
		{
			if (this.value.length >= 6) {
				return false;
			}
		}    
});
});
  
</script>
