<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');


//prelevo i costi di spedizione utente
$this->spedizione=$this->user->get_costi_Spedizione();//valore spedizione
  



?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=_PROJECT_NAME_?> 
        <small><?=t("Dettaglio ordine")?></small>
      </h1>
      <ol class="breadcrumb">
        
        <li class="active"><?=t("ordini")?></li>
       
        <li class="active"><?=t("dettaglio")?></li>
       
      </ol>
    </section>

    <!-- Main content -->
    <form class="form" id='ordine'>
        
    <section class="content">
        
        <div class="row">
            
        
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-striped">
                            <tr>
                                <td>Costo Prodotti</td>
                                <td>€ <?=$modelloordine->getTotale(); ?></td>
                            </tr>
                            
                             <tr>
                                <td>Spedizione</td>
                                <td>€ <?php
                             $costosped=$modelloordine->totaleArticoli()*($this->spedizione["costo_fisso"]); 
                             echo $costosped;
                             ?></td>
                            </tr>
                            
                            <tr>
                                <td>IVA</td>
                                <td> <?=$modelloordine->iva?>%</td>
                            </tr>
                            
                             <tr>
                                <td>TOTALE</td>
                                <td> € <?php
                            $totale=($modelloordine->getTotale()+$costosped);
                            $totale+=($totale * $modelloordine->iva)/100;
                            echo number_format($totale,2);
                          ?></td>
                            </tr>
                            
                        </table>
                    </div>
                    
                   
                   
                </div>
            </div>
        
        </div>
        
        <div class="row">
         
            <?php if($modelloordine->iva==4 || $modelloordine->iva==10):?>
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <div class="panel panel-danger">
                    <div class='panel-body'>
                            <h3>Carica i documenti </h3>
                            <p>
                                Per avere iva al 10% o al 4% devi compilare e caricare il documento 
                                per ottenere l'agevolazione fiscale.
                                <br/>
                                Nuova Costruzione o Ristrutturazione Edilizia
                            </p>
                    </div>
                    
                </div>
            </div>
            <?php endif;?>
        </div>
        
        
        <div class="row">
        
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <div class="panel panel-danger">
                     <div class='panel-body'>
                            <h3>Procedi al pagamento con i seguenti dati</h3>
                            <p>Bonifico Bancario intestato a:</p>
                            <code>
                            <h3>LIMAP...</h3>
                            <h3>VIA E INDIRIZZO </h3>
                            <h3>IBAN: 000000000000000000000000</h3>
                            </code>
                     </div>
                </div>
            </div>
        
        </div>
    </section>
    </form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  
  
  <div>
      
  </div>

<?php
//includo l'header
$this->view('limap/_footer');

