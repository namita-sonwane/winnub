<?php

//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');


$tabella=$this->user->getMy("prodotti");

if(isset($codiceprodotto))
{
    
    
    $prodotto=$this->user->getMy("prodotti",$codiceprodotto);
    
    ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       
        &nbsp;
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
        <?php
        
        print_r($prodotto);
        
        ?>
        <form>
            
            <div>
                <label>Codice Interno. </label>
            </div>
            
            <div>
                <label>Nome prodotto </label>
            </div>
            
            <div>
                <label>Descrizione </label>
            </div>
            
            <div>
                <label>Descrizione Tecnica</label>
            </div>
            
            <div>
                <label>Gruppo </label>
            </div>
            
            <div>
                <label>Immagini </label>
            </div>
            
            <hr/>
            
            
            <div>
                <label>Carattere prodotto</label>
            </div>
            
            <hr/>
            <h3>Vendita</h3>
            
            <div>
                <label>Unità di misura</label>
            </div>
            <div>
                <label>Prezzo fisso</label>
            </div>
            <div>
                <label>Prezzo proporzionato alle misure</label>
            </div>
            <div>
                <label>Percentuale di variazione</label>
                
            </div>
            
            
            
            <div>
                <label>Trasporto</label>
                
            </div>
            <div>
                <label>Posa in opera</label>
            </div>
            
            
             <h3>Varianti</h3>
             <input type="text" name="cerca" id="cercagruppo" placeholder="Cerca variante"/>
             <table>
                 <tr>
                     <td></td>
                 </tr>
             </table>
            
            
            
        </form>
    </section>
  </div>
<?php


}else{  


?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        LIMAP 
        <small>Limap panel Model</small>
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
                            
                            <?php  ?>
                                <div class='col-xs-12'>

                                    <table class="table table-bordered" id="tableprodotti">
                                        <thead>
                                            <tr>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($tabella as $t):
                                              
                                       ?>
                                            <tr>
                                                
                                                <td>
                                                    <?=$t->codice?>
                                                </td>
                                                
                                                <td>
                                                    <?=$t->nome?>
                                                </td>
                                                
                                                <td>
                                                  <?=$t->carattere_prodotto?>
                                                </td>
                                                
                                                <td>
                                                   <?=$t->modello;?>
                                                </td>
                                                
                                                
                                                <td>
                                                  
                                                    <a href="/admin/gestione/prodotti/<?=$t->codice?>" class="btn btn-default">
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
}

$this->view('limap/_footer');