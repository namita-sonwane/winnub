<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * Tabella generica per la gestione della vista a tabella
 * 
 * 
 */
 $user=($this->user);
 
 
 
 
?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <?=$PAGE_TITLE?> - <?=_config("site_name")?> 
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
        
        
            <div class="box box-default">
                <div class="box-title">
                     <br/>
                    
                </div>
                <div class="box-body">
                    
                    <?php
                    
                    
                    print_r($prodotto);
                    echo $html;
                    
                    ?>
                    <form action="<?="/".getLanguage()."/prodotti/espandi/$codice_prodotto"?>" method="get">
                        
                        <select name="cliente" class="form-control">
                            <option>Seleziona utente su cui espanderlo</option>
                            <?=__adminListClienti();?>
                        </select>
                        </br>
                        <button type="submit" name="confermaespandi" class="btn btn-default" value="1"> Conferma </button>
                    </form>
                    
                   
                </div>
            </div>
       
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
