<?php defined('BASEPATH') OR exit('No direct script access allowed');

//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');



 $tabella=$this->user->getMy("ordini");
    


?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        &nbsp;
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">I Miei ordini</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="panel">
                    
                    <div class="panel-heading">
                        <h3 class="panel-title"> Ordini</h3>
                    </div>
                    <div class="panel-body">
                        
                        <div class=''>
                                <div class='col-xs-12'>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>CodP</th>
                                                <th>Num. oggetti</th>
                                                <th>Data</th>
                                                <th>Stato ordine</th>
                                                <th>Stato pagamento</th>
                                                <th>Totale</th>
                                                
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($tabella as $t):
                                              //print_r($t);
                                       ?>
                                            <tr>
                                                
                                                <td>
                                                    <?=$t->rif_preventivo?>
                                                </td>
                                                
                                                <td>
                                                    <?=$t->totaleArticoli()?>
                                                </td>
                                                <td>
                                                    <?=date("d/m/Y",strtotime($t->data_creazione))?>
                                                </td>
                                                
                                                <td>
                                                   <?=$t->stato_ordine;?>
                                                </td>
                                                <td>
                                                   <?=$t->stato_pagamento;?>
                                                </td>
                                                
                                               
                                                
                                                <td>
                                                    € <?=$t->getTotale();?>
                                                </td>
                                                
                                                <td>
                                                     <a href="/preventivo/<?=$t->rif_preventivo?>" class="btn btn-default">
                                                        Preventivo
                                                    </a>
                                                    
                                                    <a href="/ordine/<?=$t->idordine?>" class="btn btn-default">
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