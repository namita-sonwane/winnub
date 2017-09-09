<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->view('limap/_header');


$this->view('limap/_sidebar');

?>
<link rel="stylesheet" href="/public/bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">


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
                        <h3 class="panel-title"><?=t("Gestisci-i-tuoi-RFQ")?></h3>
                    </div>
                    <div class="panel-body">
                        <?php if($this->session->flashdata('msg')){?>
                          <div class="alert alert-success">      
                            <?php echo $this->session->flashdata('msg')?>
                          </div>
                        <?php } ?>
                        
                        <div class='list-group'>

        <form class="form" action="/<?=getLanguage()?>/requestforquotation/save" method="POST" id="formsaverfq" enctype="multipart/form-data">
    
    
        <div class="row">
          
            
            
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                
                
                
                <div class="panel panel-default">
                    
                    <div class="panel-heading">
                        <h3 class="panel-title">CREATE RFQ</h3>
                    </div>
                    
                    
                    <div class="panel-body">
                        <?php
						
						if( is_array($rfqs_data) ){

							$rfqs=$rfqs_data[0];
						}
						?>
                        
                        <div class="form-group">
                            <label><?=t("RFQ Name/ID")?></label>
                            <input type="text" name="nome" class="form-control" value="<?=$rfqs->nome ?>" required>
                        </div>
                   
                        <div class="form-group">
                         <label><?=t("Description")?></label><div id="toolbar"></div>
                          <textarea id="editor" name="description" placeholder="Go on, start editing..."><?=$rfqs->description ?></textarea>
                        </div>
                      
                        <div class="form-group">
                            <label><?=t("Files")?></label>
                            <input type="file" name="rfq_fiel" class="form-control">
							<?php
							if($rfqs->rfq_fiel)
							{
								?>
								
								<?php
							}
								
							?>
                        </div>


                      
                    </div>
                </div>
				
				<div class="form-group">
				  <label>
				  <?=t("Product Group")?>
				  </label>
				  <div id="product_grp_data">
					<select class="form-control" id="product_group" name="product_group">
					  <option value="0">Please select</option>
					  <option <?php if($rfqs->product_group == "Upvc Windows"){ echo 'selected' ;}?> value="Upvc Windows">Upvc Windows</option>
					  <option <?php if( $rfqs->product_group == "Aluminum windows"){ echo 'selected'; }?> value="Aluminum windows">Aluminum windows</option>
					  <option <?php if( $rfqs->product_group == "Interior doors"){ echo 'selected'; }?> value="Interior doors">Interior doors</option>
					  <option <?php if( $rfqs->product_group == "Home Furnishing"){ echo 'selected';}?> value="Home Furnishing">Home Furnishing</option>
					</select>
					<?php
											  if($rfqs->product_group == 'Upvc Windows' || $rfqs->product_group == 'Aluminum windows' || $rfqs->product_group == 'Interior doors' || $rfqs->product_group == 'Home Furnishing')
											  {
												$another_pr_grp = '';
											  }
											  else
											  {
											   $another_pr_grp = $rfqs->product_group ;
											  }
											  ?>
					Or
					<input value="<?php echo $another_pr_grp;?>" class="form-control" placeholder="Add Other Product Group" type="text" name="another_pr_grp" class="editOption">
				  </div>
				</div>

                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=t("Manufacturing Process & Materials")?></h3>
                    </div>
                    
                    
                    <div class="panel-body">
                       
                   
                    <div class="form-group">
                        <label><?=t("Process/Services")?></label>
                        <input type="text" name="process_services" class="form-control" value="<?=$rfqs->process_services ?>" required>
                    </div>
                   
                    <div class="form-group">
                        <label><?=t("Materials")?></label>
                        <input type="text" name="materials" class="form-control" value="<?=$rfqs->materials?>">
                    </div>
                   
                    <div class="form-group">
                        <label><?=t("Finish/Color")?></label>
                        <input type="text" name="fcolor" class="form-control" value="<?=$rfqs->fcolor?>">
                    </div>
                   
                    
                    </div>
                    
                </div>
                
               	<div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=t("Quantity")?></h3>
                    </div>
                    
                    
                    <div class="panel-body">
                        

	                      <div class="form-group">
	                        <label><?=t("Quantity")?></label>
	                        <input type="number" name="quantity" class="form-control" value="<?=$rfqs->quantity?>">
	                    </div>
	                     <div class="form-group">
	                        <label><?=t("Order Per Year")?></label>
	                        <input type="number" name="quantityperyear" class="form-control" value="<?=$rfqs->quantityperyear?>">
	                    </div>

	                    <div class="form-group">
	                        <label><?=t("ProtoType")?></label>
                            <br>
							<?php
							$yes_protoType = $no_protoType = '';
							if($rfqs->protoType == 'no')
							{
								$no_protoType = 'checked';
							}
							else
							{
								$yes_protoType = 'checked';
							}
							?>
                             <input type="radio" <?php echo $yes_protoType ;?> name="protoType" value="yes" checked> Yes<br>
                             <input type="radio" <?php echo $no_protoType ;?> name="protoType" value="no" > No<br>
	                    </div>

                    </div>
                </div>

                  	<div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=t("Timming")?></h3>
                    </div>
                    
                    
                    <div class="panel-body">                      

							<div class="form-group">
	                        <label><?=t("Has Deadline")?></label>
                            <br>
							
							<?php
							$yes_hasdeadline = $no_hasdeadline = '';
							if($rfqs->hasdeadline == 'no')
							{
								$no_hasdeadline = 'checked';
							}
							else
							{
								$yes_hasdeadline = 'checked';
							}
							?>
	                        <input type="radio" <?php echo $yes_hasdeadline ;?> name="hasdeadline" class="" value="yes" selected>Yes
	                        <input type="radio" <?php echo $no_hasdeadline ;?> name="hasdeadline" class="" value="no">No
	                    </div>

	                      <div class="form-group">
	                        <label><?=t("Deadline")?></label>
	                        <input type="date" name="deadlinedate" class="form-control" value="<?php echo $rfqs->deadlinedate;?>">
	                    </div>  
                    </div>
                </div>


                    <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=t("Shipping")?><small>optional</small></h3>
                    </div>
                    
                    
                    <div class="panel-body">               
                          <div class="form-group">
                            <label><?=t("Country")?></label>
                           <input type="text" name="shippingcountry" class="form-control" value="<?=$rfqs->shippingcountry?>">


                        </div>  
                    </div>
                </div>



                  <div class="box box-default">
                   
                    <div class="box-body">
                        <div class="form-group">
                            <input type="hidden" name="codrfq" value="<?=($rfqs->codrfq>0)?($rfqs->codrfq):0; ?>">
                            <button type="submit" class="btn btn-success" name="saverfq" value="1"><?=t("Salva RFQ")?></button>                           
                            <button type="submit" class="btn btn-success" name="saverfq" value="1"><?=t("Submit RFQ")?></button>
                            
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
<?php $this->view('limap/_footer'); ?>

<!-- Bootstrap WYSIHTML5 -->

<!-- wysihtml core javascript with default toolbar functions --> 



 <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/wysihtml5/0.3.0/wysihtml5.min.js"></script> 
 <script type="text/javascript" src="https://cdn.jsdelivr.net/wysihtml5/0.3.0/wysihtml5-0.3.0.js"></script>

<script>
 var editor = new wysihtml5.Editor(document.querySelector('.editor'), {
    toolbar: document.querySelector('.toolbar'),
    parserRules:  wysihtml5ParserRules // defined in file parser rules javascript
  });
</script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea1").wysihtml5();
  });
</script>