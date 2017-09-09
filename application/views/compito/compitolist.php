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
        &nbsp;
      </h1>
      <?php get_breadcrumbs();?>
    </section>


        <!-- Main content -->
		
		<section class="content">
		<?php
		
		$edit_mode = false;
		$subtask_project_id = '';	
		$sub_task_id = 0 ;
		$add_edit_text = 'Create-Task';
		if(isset($singleTaskDetails))
		{			
			$edit_mode = true;
			$add_edit_text = 'Update-Task';
			$sub_task_id = $singleTaskDetails->sub_task_id;
			$subtask_project_id = $singleTaskDetails->codcompito ;
		}
		?>		
	<form class="form" onsubmit="return validate_form();" action="/<?=getLanguage()?>/compito/subtasks" method="POST" id="add_task_data">
      <div class="row">
        <div class="col-md-3">
		 <?php if($this->session->flashdata('msg')){?>
		  <div class="alert alert-success">      
			<?php echo $this->session->flashdata('msg')?>
		  </div>
		<?php } ?>
		
          <div class="box box-solid">
            <div class="box-header with-border">
              <h4 class="box-title"><?=t("Projects-list")?></h4>
            </div>
            <div class="box-body">
              <!-- the events -->
              <div id="external-events">
			  <?php
			  if(count($tasklist) > 0)
			  {							  
				  foreach($tasklist as $tl)
				  {
					  $choose_cor_task = '#00a65a';
					  $selected_project =''; 
					  if(!empty($tl->choose_color))
					  {
						  $choose_cor_task = $tl->choose_color;
					  }
					  if($tl->codcompito == $subtask_project_id)
					  {
						  $selected_project = "selected";
					  }
						?>
						<div data-project_id="<?php echo $tl->codcompito;?>" style="background-color:<?php echo $choose_cor_task;?>" class="external-event <?php echo $selected_project;?>"><?php echo $tl->nome;?></div>
						<?php
				  }
					?>
					
					<input type="hidden" value="<?php echo $subtask_project_id; ?>" id="hdn_project_id" name="hdn_project_id" />
					<?php
			  }
			  
			  ?>                
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $add_edit_text;?></h3>
            </div>
            <div class="box-body">
              
              <!-- /btn-group -->
              <div class="input-group box-body">
                <input id="sub_task_title" name="sub_task_title" required="required" type="text" class="form-control" value="<?php echo $singleTaskDetails->sub_task_title;?>" placeholder="Task Title">
                
                <!-- /btn-group -->
              </div>			  
              
			  <div class="input-group box-body">
					<input id="choose_color" name="choose_color" type="hidden" value="<?php echo $singleTaskDetails->sub_task_color;?>" />
					<div><label><?=t("Choose-color")?></label>  </div>
					<div class="btn-group" style="    width: 232px; margin-bottom: 10px;">                
                <ul class="fc-color-picker" id="color-chooser">
				
				<?php
				 $choose_color = $singleTaskDetails->sub_task_color;
						 
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
                         <label><?=t("Start-date")?></label>
						 
						 <?php
						 $start_date = '' ;
						 if(!empty($singleTaskDetails->start_date))
						 {								
							$start_date = date("Y-m-d", strtotime($singleTaskDetails->start_date));
						 }
						 ?>
						 
						 <input type="date" name="strtday" required="required" class="form-control" value="<?php echo $start_date;?>">

						</div>
                    </div>


                    <div class="box-body">
                         <div class="input-group date">
                         <label><?=t("End-date")?></label>
						 <?php
						 $end_date = '' ;
						 if(!empty($singleTaskDetails->end_date))
						 {								
							$end_date = date("Y-m-d", strtotime($singleTaskDetails->end_date));
						 }
						 ?>
						
                            <input type="date" name="enddate" class="form-control" required="required" value="<?php echo $end_date;?>" > 
                       
                        </div>
                    </div>
					
					 <div class="box box-default">
                   
                    <div class="box-body">
                        <div class="form-group">
                            <input type="hidden" id="hdn_sub_task_id" name="hdn_sub_task_id" value="<?php echo $sub_task_id;?>">
							<button id="add-new-subtask" type="submit" class="btn btn-success"><?php
							echo $add_edit_text;
							?></button>
							<?php
							if($sub_task_id != 0)
							{
								?>
								<a href="/<?=getLanguage()?>/compito/delete_sub_task/<?=($sub_task_id)?>"  onClick="javascript: return confirm('Are you sure to delete this task?');" class="btn btn-danger"> <?=t("Delete Task")?></a>
								<?php
							}
							?>							
								
                        </div>
                    </div>
                </div> 
			  
			  
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar">			  
			  </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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
                <th><?=t("Nome")?></th>
                <th><?=t("Description")?></th>                
                <th><?=t("Stato")?> </th>
                <th><?=t("Data di creazione")?></th>
                 <th><?=t("End Date")?></th>
                <th><?=t("File")?></th>
                <th><?=t("Action")?></th>
            </tr>
        </thead>
       
        <tbody>
        <?php $i = 1;
         foreach ($tasklist as $task){?>
            <tr>
             <td><?php echo $i;?></td>
             <td><?php echo $task->nome;?></td>
             <td><?php echo $task->description;?></td>             
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
 
  

<?php
//includo l'header
$this->view('limap/_footer');
/*echo '<pre> Project arr';
		print_r($calendar_data_arr);
		echo '</pre>';*/
?>
<script type="text/javascript">
$(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

    

      });
    }

    ini_events($('#external-events div.external-event'));

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month'
      },
      buttonText: {
        today: 'Today',
        month: 'Month',        
      },
      //Random default events
      events: [
	  
	  <?php
	  foreach($calendar_data_arr as $calendar_data)
	  {		  
		  ?>
		  {
			  title: '<?php echo $calendar_data['title']?>',
			  start: new Date("<?php echo $calendar_data['start_date']?>"),
			  end: new Date("<?php echo $calendar_data['end_date']?>"),
			  backgroundColor: "<?php echo $calendar_data['choose_color']?>",
			  borderColor: "<?php echo $calendar_data['choose_color']?>",
			  allDay: false,
			  url: '<?php echo $calendar_data['edit_url']?>',
		  },
		  <?php
	  }
	  ?>        
      ],
      editable: false,
      droppable: false, // this allows things to be dropped onto the calendar !!!
    });

    /* ADDING EVENTS */
    var currColor = "#00a65a"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-subtask').css({"background-color": currColor, "border-color": currColor});
    });
		
    /*$("#add-new-subtask").click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0) {
        return;
      }

      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
    });*/
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
    });
	
	$('#external-events div').click(
    function(e) {		
        e.preventDefault(); // prevent the default action
        e.stopPropagation(); // stop the click from bubbling		
		console.log('Project clicked');
		var project_id = $(this).data("project_id");
		console.log(project_id);
		jQuery('#hdn_project_id').val(project_id);		
		$('#external-events div').removeClass('selected');        
        $(this).addClass('selected');
    });
	
	function validate_form()
	{
		if($('#hdn_project_id').val() == '')
		{
			alert('Please select the project!');
			return false;
		}
	}
  
</script>
<style>
.fc-content .fc-time
{
	display:none;
}
.fc-content .fc-title
{
	    padding-left: 3px;
}

#color-chooser li.selected .rotate_selected_color{
	      transform: rotate(30deg);
  }
  #external-events
  {
	min-height: 21px;
    overflow-y: scroll;
    max-height: 140px;
  }
  #external-events .external-event
  {	
    cursor: pointer;  
	color:white;
  }
    #external-events .external-event.selected
	{
		border-radius: 20px;
	}
	
</style>