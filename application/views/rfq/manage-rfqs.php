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
                        <h3 class="panel-title"><?=t("Gestisci-i-tuoi-rfqs")?></h3>
                    </div>
                    <div class="panel-body">
					<?php if($this->session->flashdata('msg')){?>
                          <div class="alert alert-success">      
                            <?php echo $this->session->flashdata('msg')?>
                          </div>
                        <?php } ?>
                        
                        <div class='list-group'>
                            
                            <?php //print_r($rfqs_data);

if(count($rfqs_data)>0){
    
    ?>
                            <table class='table' id='tablerfqs'>
                                <thead>
                                    <tr>
										<th><?=t("ID")?></th>
                                        <th><?=t("RFQ Name/ID")?></th>
                                        <th>
                                            <?=t("Created on")?>
                                        </th>
                                         <th>
                                            <?=t("Product Group")?>
                                        </th>                                       
										
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
        <?php
//echo '<pre>';
//print_r($rfqs_data);
    foreach($rfqs_data as $key=>$riga){
		$counter = $key+1;
        ?>
                            <tr>
                                <td>
                                    <?php
									echo $counter ;
									?>
                                </td>
                                <td>
                                    <?php echo  $riga->nome?>
                                </td>
                                
                                <td>
                                    <?php echo  $riga->created_date?>
                                </td>
                                
                               <td>
									<?php
									if($riga->product_group != '')
									{
										echo $riga->product_group ;
									}
									else
									{
										echo 'N/A';
									}
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
                                                   <?=t("button-azioni-preventivi")?> <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">
                                                        <li>
                                                             <a href="<?=base_url()?>/requestforquotation/send/<?=MD5($riga->codrfq)?>" class="">
                                                              <i class="fa fa-at"></i>
                                                              <?=t("invia-preventivo")?>
                                                          </a>
                                                        </li>
                                                        <li>
														
														<a href="/<?=getLanguage()?>/requestforquotation/edit/<?=($riga->codrfq)?>"  class="">
																<i class="fa fa-eye"></i>
                                                                 <?=t("modifica")?> 
														</a>
                                                           
                                                        </li>
                                                       
                                                            <li>
															<a href="/<?=getLanguage()?>/requestforquotation/delete/<?=($riga->codrfq)?>" class="btn btn-danger btn-sm eliminarfqs"> 
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