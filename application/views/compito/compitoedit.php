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
      <!--<h1>
        <?=$PAGE_TITLE?> 
        <small><?=$PAGE_SUB_TITLE?> </small>
      </h1>-->
      <?php //get_breadcrumbs();?>
    </section>


        <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="panel panel-default">
                    
                    <div class="panel-heading">
                        <!--<h3 class="panel-title"><?=t("Gestisci-i-tuoi-Compito")?></h3>-->
                    </div>
                    <div class="panel-body">
                        
                        <div class='list-group'>
                        <form class="form" action="/<?=getLanguage()?>/compito/Edit_compito" method="POST" id="formsavecompito" enctype="multipart/form-data">
    
    
        <div class="row">
            <?php
                
            
                if( is_array($singletask) ){

                    $singletask=$singletask[0];
                }
           
            ?>
            
            
            
            <div class="col-xs-12 col-sm-12 col-md-8 ">
                
                
                
                <div class="panel panel-default">
                    
                    <!--<div class="panel-heading">
                        <h3 class="panel-title">Dati compito</h3>
                    </div>-->
                    
                    
                    <div class="panel-body">
                        
                        
                        <div class="form-group">
                            <label><?=t("nome-utente")?></label>
                            <input type="text" name="nome" class="form-control" value="<?=$singletask->nome?>" required>
                        </div>
                   
                       <div class="form-group">
                            <label><?=t("Description")?></label>
                            <textarea name="description" class="form-control"><?php echo htmlspecialchars($singletask->description);?></textarea>
                           
                         </div>
                            
                         <div class="form-group">
                            <label><?=t("Stato ")?></label>
                            <select name="taskstatus"  class="form-control" required>
                             <option value="Inprogress" <?php if($singletask->status=='Inprogress'){ echo "selected";} ?>>In progress </option>
                                <option value="Pending" <?php if($singletask->status=='Pending'){ echo "selected";} ?>>Pending  </option>
                                <option value="Done" <?php if($singletask->status=='Done'){ echo "selected";} ?>>Done </option>
                            </select>
                        </div>


                           <div class="form-group">
                            <label><?=t("file")?></label>
                            <input type="file" name="taskdoc" class="form-control">
                           
                         </div>

                          <!--<div class="form-group">
                            <label><?=t("url")?></label>
                           <input type="url" name="compitourl" class="form-control" value="<?php echo $singletask->taskurl;?>" required>
                           
                         </div>-->

                          <!--<div class="form-group">
                            <label><?=t("Task Priority")?></label>
                            <div class="form-group">
                            <input type="checkbox" name="priority" value="Deadlinedate" <?php if($singletask->priority=='Deadlinedate'){ echo "checked";} ?>> Deadline date<br>
                            <input type="checkbox" name="priority" value="Highpriority" <?php if($singletask->priority=='Highpriority'){ echo "checked";} ?>> High priority<br>
                            </div>
                           
                         </div>-->

                       

                    </div>
                </div>
               
                
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-4">
                
                
                <div class="box">
                    
                     <div class="box">
					 <!--<div class="box-body">
                         <div class="input-group date">
                         <label><?=t("Choose color")?></label>                            
						 <?php
						 $choose_color = $singletask->choose_color;
						 if(empty($choose_color))
						 {
							 $choose_color = '#5367ce';
						 }
						 ?>
							<input id="choose_color" name="choose_color" type="text" class="form-control" value="<?php echo $choose_color;?>" />
                       
                        </div>
                    </div>-->
					<?php
						 $choose_color = $singletask->choose_color;
						 
						 $color_array = array('#00c0ef'=>'text-aqua','#0073b7'=>'text-blue',
						 '#0073b7'=>'text-light-blue',
						 '#39cccc'=>'text-teal',
						 '#f39c12'=>'text-yellow',
						 '#ff851b'=>'text-orange',
						 '#00a65a'=>'text-green',
						 '#01ff70'=>'text-lime',
						 '#dd4b39'=>'text-red',
						 '#605ca8'=>'text-purple',
						 '#f012be'=>'text-fuchsia',
						 '#777'=>'text-muted',
						 '#001f3f'=>'text-navy',
						 );

					?>
					<div class="input-group box-body">
					<input id="choose_color" name="choose_color" type="hidden" value="<?php echo $choose_color;?>" />
					<div><label><?=t("Choose color")?></label>  </div>
					<div class="btn-group" style="    width: 232px; margin-bottom: 10px;">                
                <ul class="fc-color-picker" id="color-chooser">
				
				<?php
				foreach($color_array as $key=>$color_name)
				{
					$selected = '' ;
					if($choose_color == $key)
					{
						$selected = "selected";
					}						
					?>
					<li class="<?php echo $selected; ?>"><a class="<?php echo $color_name;?>" data-color_code="<?php echo $key;?>" href="javascript:void(0)"><i class="fa fa-square rotate_selected_color"></i></a></li>
					<?php
				}
				?>                  
                </ul>
              </div>
			  </div>
					 
                     <div class="box-body">
                         <div class="input-group">
                         <label><?=t("start date")?></label>
						 <input type="date" name="strtday" class="form-control" value="<?php echo $singletask->createdon;?>">

						</div>
                    </div>


                    <div class="box-body">
                         <div class="input-group date">
                         <label><?=t("End date")?></label>
                            <input type="date" name="enddate" class="form-control" value="<?php echo $singletask->end_date;?>" required> 
                       
                        </div>
                    </div>
					
					
					
                </div>
                </div>
                
                
                

                       <div class="box box-default ">
                   
                    <div class="box-body">
                        <div class="form-group">
                            
                            <input type="hidden" name="codcompito" value="<?=$singletask->codcompito;?>">
                            
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
?>
<script type="text/javascript">
    /*  $.fn.datepicker.defaults.format = "mm/dd/yyyy";
$('.datepicker').datepicker({
    startDate: '-3d'
});*/


  $('ul#color-chooser li a').click(
    function(e) {		
        e.preventDefault(); // prevent the default action
        e.stopPropagation(); // stop the click from bubbling
		
		console.log('Datat tetste');
		var selected_color = $(this).data("color_code");
		console.log(selected_color);
		jQuery('#choose_color').val(selected_color);		
        $(this).closest('ul').find('.selected').removeClass('selected');
        $(this).parent().addClass('selected');
    })
  </script>
  <style>
  #color-chooser li.selected .rotate_selected_color{
	      transform: rotate(30deg);
  }
  </style>