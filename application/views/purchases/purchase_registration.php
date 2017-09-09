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
                        array("nome"=>t("nuovo"),"href"=>"/".getLanguage()."/purchases","class"=>"btn btn-actions-winnub1","icona"=>'<i class="fa fa-plus"></i>'),
                        array("nome"=>t("Acquisti"),"href"=>"/".getLanguage()."/purchases/shopping","class"=>"btn colore-secondario","icona"=>'<i class="fa fa-cubes"></i>')
                    )
                )
                );?>
        
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

        <form class="form" action="/<?=getLanguage()?>/purchases/save" method="POST" id="purchase_registration" enctype="multipart/form-data">
    
    
        <div class="row">
          
            
            
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                
                
                
                
                <!-- panel start-->
                <div class="panel panel-default">
                    
                    
                    
                    <div class="panel-body">
                        <?php
						
						if( is_array($purchases_data) ){

							$purchases=$purchases_data[0];
						}
						?>
						
						<div class="form-group">
                                                    <label><?=t("Fornitore")?></label>
                                                    <input type="text" required="required" name="purchase_supplier" value="<?=$purchases->purchase_supplier?>" class="form-control">							
                                                </div>

                                               <div class="form-group">
						  <label>
						  <?=t("Categoria acquisto")?>
						  </label>
						  <div id="purchase_category_data">
						
							<select class="form-control" id="purchase_category" name="purchase_category">
							  <option value="0">Please select</option>
							  <?php
							 foreach($purchases_category as $cat)
							 {
								 $selected = '';
								 if($purchases->purchase_category == $cat->purchase_category_id)
								 {
									 $selected = 'selected';
								 }
								 echo "<option ".$selected." value=".$cat->purchase_category_id.">".$cat->purchase_category_name."</option>";
							 }
							  ?>
							  <!--<option <?php if($purchases->purchase_category == "Marketing"){ echo 'selected' ;}?> value="Marketing">Marketing</option>
							  <option <?php if( $purchases->purchase_category == "Spese Legali"){ echo 'selected'; }?> value="Spese Legali">Spese Legali</option>
							  <option <?php if( $purchases->purchase_category == "Assicurazioni "){ echo 'selected'; }?> value="Assicurazioni ">Assicurazioni </option>
							  <option <?php if( $purchases->purchase_category == "Stipendi"){ echo 'selected';}?> value="Stipendi">Stipendi</option>
							  <option <?php if( $purchases->purchase_category == "Acquisti"){ echo 'selected';}?> value="Acquisti">Acquisti</option>-->
							  
							</select>							
							Or
							<input value="" class="form-control" placeholder="Add Other Purchase Category" type="text" name="another_purchase_category" class="editOption">
							</div>
							</div>
									
						<div class="form-group">
                            <label><?=t("Data")?></label>
							<?php
							$newDate1 = '' ;
							if(!empty($purchases->purchase_start_date))
							{
								$newDate1 = date("Y-m-d", strtotime($purchases->purchase_start_date));	
							}							
							
							?>
                            <input type="date" required="required" name="purchase_start_date" value="<?=$newDate1?>" class="form-control">							
                        </div>
						
						<div class="form-group">
                            <label><?=t("N. Fattura acquisto")?></label>
                            <input type="text" name="purchase_invoice" value="<?=$purchases->purchase_invoice?>" class="form-control">							
                        </div>
						
			<div class="form-group">
                            <label><?=t("Imponibile")?></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-eur"></i>
                                </div>
                                <input type="text" name="purchase_taxable" value="<?=$purchases->purchase_taxable?>" class="form-control">		
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label><?=t("Iva")?></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-eur"></i>
                                </div>
                                <input type="text" name="purchase_vat" value="<?=$purchases->purchase_vat?>" class="form-control pull-right" placeholder="Valore ">	
                            </div>
                            
                           						
                        </div>
                        <div class="form-group">
                            
                            <label><?=t("Totale")?></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-eur"></i>
                                </div>
                                <input type="number" name="purchase_total" value="<?=$purchases->purchase_total;?>" class="form-control">	
                            </div>
                        </div>
						
						<div class="form-group">
                            <label><?=t("Carica Doc")?></label>
                            <input type="file" name="purchase_reg_file" class="form-control">
							<?php
							if($purchases->purchase_reg_file)
							{
								?>
								
								<?php
							}
								
							?>
                        </div>
						
						 <div class="form-group">
                            <label><?=t("Data di saldo")?></label>
							<?php
							$newDate2 = NULL ;
							if(!empty($purchases->purchase_balance_date))
							{
								$newDate2 = date("Y-m-d", strtotime($purchases->purchase_balance_date));
							}
												
							?>
							
                            <input type="date" name="purchase_balance_date" value="<?=$newDate2;?>" class="form-control">							
                        </div>

                    </div>
                    
                    
                    <div class="panel-footer">
                        <div class="form-group">
                            <input type="hidden" name="purchase_id" value="<?=($purchases->purchase_id>0)?($purchases->purchase_id):0; ?>">
                            <button type="submit" class="btn btn-success" name="savepurchases" value="1"><?=t("Salva")?></button>                           
                            <a class="btn btn-danger" href="<?php echo base_url().'/'.getLanguage().'/purchases/'?>" ><?=t("Cancel")?></a>
                            
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
