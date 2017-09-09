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
        <form class="form" action="/<?=getLanguage()?>/pdl/save" method="POST" id="formsavefornitore">
    
    
        <div class="row">
            <?php
				//echo '<pre>';
				//print_r($singlepdl);
                if( is_array($singlepdl) ){

                    $pdl=$singlepdl[0];
                }
				else
				{
					$pdl=$singlepdl;
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
									<label><?=t("Produzione")?></label>
									<input type="text" name="dir_produzione" class="form-control" value="<?=$pdl->dir_produzione?>" required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label><?=t("Regia")?></label>
									<input type="text" name="regia" class="form-control" value="<?=$pdl->regia?>" required>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label><?=t("Organizzatore Generale")?></label>
									<input type="text" name="organizzatore_generale" class="form-control" value="<?=$pdl->organizzatore_generale?>" required>
								</div>
							</div>
							
                            <div class="col-md-3">
                                <div class="form-group">
                                <label><?=t("Dir. Fotografia")?></label>
                                <input type="text" name="dirf_otografia" class="form-control" value="<?=$pdl->dirf_otografia?>" required>
                                </div>
                            </div>
							
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?=t("Scenografia")?></label>
                                    <input type="text" name="scenografia" class="form-control" value="<?=$pdl->scenografia?>" required>
                                </div>
                            </div>
							
							<div class="col-md-3">
                                <div class="form-group">
                                <label><?=t("Custumi")?></label>
                                <input type="text" name="localita" class="form-control" value="<?=$pdl->localita?>" required>
                                </div>
                            </div>
							
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?=t("Suono")?></label>
                                    <input type="text" name="suono" class="form-control" value="<?=$pdl->suono?>" required>
                                </div>
                            </div>
                            
							<div class="col-md-3">
                                <div class="form-group">
                                    <label><?=t("Aiuto Regia")?></label>
                                    <input type="text" name="aiuto_regia" class="form-control" value="<?=$pdl->aiuto_regia?>" required>
                                </div>
                            </div>
							
							<div class="col-md-3">
								<div class="form-group">
								<label><?=t("Sceneggiatura")?></label>
								<input type="text" name="sceneggiatura" class="form-control" value="<?=$pdl->sceneggiatura?>" required>
								</div>
							</div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?=t("Data di inizio")?></label>
                                    <input type="date" name="data_di_inizio" class="form-control" value="<?=$pdl->data_di_inizio?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?=t("Data di fine lavoro")?></label>
                                    <input type="date" name="data_di_fine_lavoro" class="form-control" value="<?=$pdl->data_di_fine_lavoro?>" required>
                                </div>
                            </div>

							
						  </div>
						  
						  <div class="form-group">

                            
                            <input type="hidden" name="codpdl" value="<?=($pdl->id>0)?($pdl->id):0; ?>">
                            
                            <a class="btn btn-danger" href="/pdl"><?=t("Torna-indietro")?></a>
                            <button type="submit" class="btn btn-success" name="savepdl" value="1"><?=t("Salva")?></button>
                            
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
                <th><?=t("Sr_no")?></th>
                <th><?=t("Sceneggiatura")?></th>
                <th><?=t("Regia")?></th>                
                <th><?=t("Dir produzione")?> </th>
                <th><?=t("Organizzatore generale")?></th>
                 <th><?=t("Dirf otografia")?></th>
                <th><?=t("Scenografia")?></th>
                <th><?=t("Suono")?></th>
                <th><?=t("Action")?></th>
            </tr>
        </thead>
       
        <tbody>
        <?php $i = 1;
		
		if(count($pdl_data) > 0)
		{
			
		
         foreach ($pdl_data as $task){?>
            <tr>
             <td><?php echo $i;?></td>
             <td><?php echo $task->sceneggiatura;?></td>
             <td><?php echo $task->regia;?></td>  
             <td><?php echo $task->dir_produzione;?></td>             
             <td><?php echo $task->organizzatore_generale;?></td>
             <td><?php echo $task->dirf_otografia;?></td>
             <td><?php echo $task->scenografia;?></td>
              <td><?php echo $task->suono;?></td>
             
			 <td class="text-center">
                                            
				<!-- Small button group -->
				<div class="btn-group">
					  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						  <i class="fa fa-gears"></i>
						  
					   <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" style="margin-left: -64px;">
							<li>
							<a href="/<?=getLanguage()?>/pdl/getpdl/<?=($task->id)?>"  class="btn btn-default btn-sm"> 							
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
							<a href="/<?=getLanguage()?>/pdl/delete/<?=($task->id)?>"  onClick="javascript: return confirm('Are you sure to delete this item?');" class="btn btn-default btn-sm"> 							
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

