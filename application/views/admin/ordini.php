<?php

//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');

// NON ESISTE LA CHIAMATA DA VERIFICARE!
$tabella=$this->adminuser->getMy("pagamenti");
$tabella=array();

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=_PROJECT_NAME_?> 
        <small><?=t("gestione ordini e pagamenti")?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">I Miei ordini</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
            <div class="col-xs-12 col-sm-12">
                
                <div class="panel">
                    
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=t("Ordini")?></h3>
                    </div>
                    <div class="panel-body">
                        
                        <div class=''>
                            
                            <?php  
                            
                            $status=$this->azienda->getStatusAccount();
                            
                            
                            echo ($this->azienda->serivizioAttivo())?"SERVIZIO ATTIVO":"SERVIZIO SCADUTO";
                            
                            echo " - SCADE IL: ".$this->azienda->getScadenzaServizio();
                          
                            ?>
                                <div class='col-xs-12'>

                                    <table class="table table-bordered table-striped">
                                        
                                        <thead>
                                            <tr>
                                                <th><?=t("Prodotto")?></th>
                                                <th><?=t("Cliente")?></th>
                                                
                                                <th><?=t("Data")?></th>
                                                <th><?=t("Stato")?></th>
                                                
                                                <th><?=t("Durata")?></th>
                                                
                                                <th><?=t("Prezzo")?> </th>
                                                <th>
                                                    
                                                </th>
                                                
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            
                                            <?php foreach($status as $t):
                                              //print_r($t);
                                       ?>
                                            <tr>
                                                
                                                <td>
                                                    <?=$t->nome?>
                                                </td>
                                                
                                                <td>
                                                    <?=$t->codice_azienda?>
                                                </td>
                                                
                                                <td>
                                                    <?=$t->data_attivazione?>
                                                </td>
                                                
                                                <td>
                                                     <?=$t->stato?>
                                                </td>
                                                
                                                <td>
                                                     <?=$t->durata?>
                                                </td>
                                                
                                                <td>
                                                    €  <?=$t->prezzo?>
                                                </td>
                                                
                                                <td>
                                                  
                                                    <a href="/admin/gestione/ordini/<?=$t->idact?>" class="btn btn-default">
                                                        Mostra
                                                    </a>
                                                    
                                                </td>
                                            </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                        
                                        
                                    </table>
                                    
                                </div>
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