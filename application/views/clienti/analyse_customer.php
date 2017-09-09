<?php

//includo l'header
$this->view('limap/_header');

$this->view('limap/_sidebar');

$analyse_data1 = $this->user->getMy("customer_analyse1",$client_id," ORDER BY codice_utente DESC ");

$analyse_data2 = $this->user->getMy("customer_analyse2",$client_id," ORDER BY codice_utente DESC ");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 1027px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        &nbsp;
      </h1>
      <?php get_breadcrumbs();?>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
            <div class="col-xs-12">
                
                    
				<h2 class="text-center"><?=t("Analizza Cliente")?></h2>	
                                
                                <div class="panel panel-default">
                                    
                                    <div class="panel-body">
				<?php
					echo '<h1 class="text-center">'.$client_name.'</h1>';
				?>
				<table class="table table-bordered table-hover">
						<thead>
						  <tr>
                                                        <th><?=t("Cod.")?></th>
							<th><?=t("Data Doc.")?></th>
                                                        <th><?=t("tipologia")?></th>
							<th><?=t("Descrizione")?></th>
							<th><?=t("Totale")?></th>
                                                        
							<th><?=t("Doc. link")?></th>
						  </tr>
						</thead>
						<tbody>
                <?php
				if(count($analyse_data1) > 0)
				{
					?>
											
					<?php					
					foreach($analyse_data1 as $analyse)
					{						
						?>
						 <tr>
                                                        <td><?=$analyse->codice_utente?></td>
							<td>							
							<?=date("d/m/Y ",strtotime($analyse->data))?>
							
							</td>
                                                        <td><?=t("Preventivo")?></td>
							<td><?=$analyse->titolo;?></td>
							<td>
							€ <?=number_format($analyse->getTotale(),2,"."," ");?>
							</td>
                                                        
                                                        
							<td>
							
							<a class="btn btn-success" href="<?php echo '/'.getLanguage().'/quote/detail/'.MD5($analyse->idpreventivo); ?>" target="_blank">View Quote</a>							
							</td>
						  </tr>
						<?php
					}
				}
				else
				{
					echo '<tr class="text-center" colspan="6"><td><p class="text-center">No Record Found For Quote!</p></td></tr>';
				}
				if(count($analyse_data2) > 0)
				{
					foreach($analyse_data2 as $analyse)
					{						
						?>
						 <tr>
                                                        <td><?=$analyse->codice_seq?></td>
							<td>							
							<?=date("d/m/Y ",strtotime($analyse->data))?>
							
							</td>
                                                        <td><?=t("fattura")?></td>
							<td>
							<?php
								//echo $analyse->titolo;
								echo 'Invoice';
							?>
							</td>
							<td>
							€ <?=number_format($analyse->totale,2,"."," ")?>
							</td>
                                                        
							<td>
							
<a href="<?=base_url("/".getLanguage()."/invoice/view/".($analyse->codfatt));?>" target="_blank" class="btn btn-default btn-info">
                                                        
																	View Invoice
                                                    </a>
							
							</td>
						  </tr>
						<?php
					}
				}
				else
				{
					echo '<tr><td colspan="6"><p class="text-center">No Record Found For Invoice!</p></td></tr>';
				}
					
					
					?>
					</tbody>
					 </table>
					  <?php
				
				?>
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