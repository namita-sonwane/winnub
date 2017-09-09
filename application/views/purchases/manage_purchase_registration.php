<?php

//includo l'header
$this->view('limap/_header');
$this->view('limap/_sidebar');
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=t($PAGE_TITLE)?> 
        <!--<small><?=$PAGE_SUB_TITLE?> </small>-->
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
	
	<!--STart Graph representation -->
	<div class="row">
	<div class="col-md-8">
		<div class="box">
			<div class="box-header with-border">
				<!--<h3 class="box-title"><?=t("Report-shopping")?></h3>-->
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove">
						<i class="fa fa-times"></i>
					</button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body" style="display: block;">
				<div class="row">
					<div class="col-xs-12 col-md-12 ">
						
						<div class="chart">
							<!-- Sales Chart Canvas -->							
              <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
              </canvas><canvas id="purchases_reprentation" style="height: 280px; width: 454px;" width="454" height="280"></canvas>
              <script type="text/javascript">
              var ctx = document.getElementById('purchases_reprentation').getContext('2d');
              var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                  labels: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug','Ago','Set','Ott', 'Nov', 'Dic'],
                  datasets: [{
                    label: ('Purchases'),
                    data: [<?php echo $data_totals['jan']?>, <?php echo $data_totals['feb']?>, <?php echo $data_totals['mar']?>, <?php echo $data_totals['apr']?>, <?php echo $data_totals['may']?>, <?php echo $data_totals['jun']?>, <?php echo $data_totals['jul']?>,<?php echo $data_totals['aug']?>,<?php echo $data_totals['sep']?>,<?php echo $data_totals['oct']?>,<?php echo $data_totals['nov']?>,<?php echo $data_totals['dec']?>],
                    backgroundColor: "rgba(51,106,255,0.4)"
                  }]
                },
				options: {
					legend: {
						display: false
					}
				}
              });
              </script>

						</div>
						<!-- /.chart-responsive -->
					</div>
					<!-- /.col -->
					
							<!-- /.col -->
						</div>
						<!-- /.row -->
					</div>
				</div>
				<!-- /.box -->
			</div>
			<div class="col-md-4">
				<div class="box">
					
					<div class="box-header with-border">
				<h3 class="box-title"><?=t("Purchase Category")?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove">
						<i class="fa fa-times"></i>
					</button>
				</div>
			</div>
		
					<div class="panel-body box-body category_dro_down">
					<?php
					if(count($data_total_category) > 0)
					{
						foreach($data_total_category as $key=>$cat)
						{
							$icon = 'fa-shopping-cart';
							$bg = 1;
							if($key == 0)
							{
								$icon = 'fa-shopping-cart';	
								$bg = 1;
							}
							if($key == 1)
							{
								$icon = 'fa-legal';	
								$bg = 2;
							}
							if($key == 2)
							{
								$icon = 'fa-hand-lizard-o';	
								$bg = 3;
							}
							if($key == 3)
							{
								$icon = 'fa-money';	
								$bg = 4;
							}
							if($key == 4)
							{
								$icon = 'fa-buysellads';	
								$bg = 5;
							}
							?>
							<div class="info-box0">
														
								<div class="cat_price_cotainer">
                                                                    <strong class="cat_name"><?php echo $cat->purchase_category_name;?></strong> <span class="cat_price">- &euro; 
                                                                    <?php echo $cat->total; ?></span>
								</div>
                                                            
							</div>
							<?php
						}
					}
					?>																								
					</div>
				</div>
			</div>
			<!-- /.col -->
		</div>
	<!--End Graph reprentation -->
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="panel panel-default">
                    
                    <!--<div class="panel-heading">
                        <h3 class="panel-title"><?=t("Gestisci-i-tuoi-purchases")?></h3>
                    </div>-->
                    <div class="panel-body">
					<?php if($this->session->flashdata('msg')){?>
                          <div class="alert alert-success">      
                            <?php echo $this->session->flashdata('msg')?>
                          </div>
                        <?php } ?>
                        
                        <div class='list-group'>
                            
                            <?php //print_r($purchase_data);

if(count($purchase_data)>0){
    
    ?>
                            <table class='table' id='tablepurchases'>
                                <thead>
                                    <tr>
										
                                        <th><?=t("Fornitore")?></th>
										
                                        <th><?=t("Category")?></th>
										
                                        <th>
                                            <?=t("Data")?>
                                        </th>
                                        <th>
                                            <?=t("N. Fattura acquisto")?>
                                        </th>										
                                         <th>
                                            <?=t("Data di Saldo")?>
                                        </th>                                       
					<th>
                                            <?=t("Totale")?>
                                        </th>
                                        <th><?=t("Action")?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
        <?php
//echo '<pre>';
//print_r($purchase_data);
    foreach($purchase_data as $key=>$riga){
		
        ?>
                            <tr>
                                
                                <td>
                                    <?php echo  $riga->purchase_supplier?>
                                </td>
								<td>
                                    <?php 		
									$cat_name = 'N/A';
									if(!empty($riga->purchase_category))
									{
									$cat_name = get_category_name_by_id($riga->purchase_category)[0]->purchase_category_name;	
									}
									echo $cat_name ;									
									?>
                                </td>
								
                                
                                <td>
                                    <?php 																		
									$newDate1 = date("Y-m-d", strtotime($riga->purchase_start_date));
									echo $newDate1;?>									
                                </td>
								
								<td>
                                    <?php echo  $riga->purchase_invoice?>
                                </td>
                                
                               <td>
									<?php
									if($riga->purchase_balance_date!=null){
                                                                            $date2 = date(t("date-format-default"), strtotime($riga->purchase_balance_date));
                                                                            echo $date2;			
                                                                        }
									?>
                                </td>
								<td>
									<?php
									echo $riga->purchase_total ;
									?>
                                </td>

								
                                <td>
								
								 <!-- Small button group -->
                                            <div class="btn-group">
                                                  <button class="btn btn-default btn-sm dropdown-toggle" 
                                                          type="button" 
                                                          data-toggle="dropdown" 
                                                          aria-haspopup="true" 
                                                          aria-expanded="false">
                                                   <?=t("button-azioni-purchases")?> <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">
                                                      
                                                        <li>
														
														<a href="/<?=getLanguage()?>/purchases/edit/<?=($riga->purchase_id)?>"  class="">
																<i class="fa fa-eye"></i>
                                                                 <?=t("modifica")?> 
														</a>
                                                           
                                                        </li>
                                                       
                                                            <li>
															<a href="/<?=getLanguage()?>/purchases/delete/<?=($riga->purchase_id)?>" class="btn btn-danger btn-sm eliminapurchases"> 
															 <i class="fa fa-trash-o"></i> <?=t("elimina")?>
															</a>
															
                                                            
                                                            </li>
                                                        
                                                            
                                                        
                                                  </ul>
                                            </div>
                                    
                                </td>
                                
                                
                            </tr>       
<?php
    }
    ?></tbody></table>
<?php
    
}else{
    echo "<h3>Non hai ancora inserito dei fornitori</h3>";
    echo "<p>Creane uno adesso <a href=\"#\" class='btn btn-default'>Crea cliente</a></p>";
    echo "<br/><br/>";
}

?>
                               
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
