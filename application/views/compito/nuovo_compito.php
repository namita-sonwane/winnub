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
    <!--  <h1>
        <?=$PAGE_TITLE?> 
        <small><?=$PAGE_SUB_TITLE?> </small>
      </h1>-->
      <?php get_breadcrumbs();?>
    </section>


        <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="panel panel-default">
                    
                    <div class="panel-heading">
                        <!--<h3 class="panel-title"><?=t("Gestisci-i-tuoi-compito")?></h3>-->
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
                            <label><?=t("Nuovo Progetto")?></label>
                            <input type="text" name="nome" class="form-control" value="<?=$fornitori->nome_utente?>" required>
                        </div>
                   
                       
                          <div class="form-group">
                            <label><?=t("Descrizione")?></label>
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
                            <label><?=t("File")?></label>
                            <input type="file" name="taskdoc" class="form-control">
                           
                         </div>

                          <!--<div class="form-group">
                            <label><?=t("url")?></label>
                           <input type="url" name="compitourl" class="form-control">
                           
                         </div>-->

                          <!--<div class="form-group">
                            <label><?=t("Task Priority")?></label>
                            <div class="form-group">
                            <input type="checkbox" name="priority" value="Deadlinedate"> Deadline date<br>
                            <input type="checkbox" name="priority" value="Highpriority" > High priority<br>
                            </div>
                           
                         </div>-->
                       

                    </div>
                </div>
               
                
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-4">
                
                
                <div class="box">
				<!--<div class="box-body">
                         <div class="input-group date">
                         <label><?=t("Scegli colore")?></label>                            
						 <?php
						 $choose_color = $fornitori->choose_color;
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
					<input id="choose_color" name="choose_color" type="hidden" value="" />
					<div><label><?=t("Scegli colore")?></label>  </div>
					<div class="btn-group" style="    width: 232px; margin-bottom: 10px;">                
                <ul class="fc-color-picker" id="color-chooser">
				
				<?php
				foreach($color_array as $key=>$color_name)
				{
					$selected = '' ;
					if(in_array($choose_color,$color_array))
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
                         <div class="input-group date">
                         <label><?=t("Data di inizio progetto")?></label>
                            <input type="date" name="createdon" value="" class="form-control" required>
                       
                        </div>
                    </div>


                    <div class="box-body">
                         <div class="input-group date">
                         <label><?=t("Data di fine progetto")?></label>
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
?>

<script type="text/javascript">
    /*  $.fn.datepicker.defaults.format = "mm/dd/yyyy";
$('.datepicker').datepicker({
    startDate: '-3d'
});*/

$( document ).ready(function() {	
	$('#choose_color').colorpicker({ 
		format:'hex'
	});

});

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