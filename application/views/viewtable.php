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
         &nbsp;
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
        
          <?php 
        
        
        $this->view('limap/_barra_strumenti',
                array(
                    "buttons"=>array(
                        array("nome"=>t("nuovo"),"href"=>"/".getLanguage()."/prodotti/modifica/0","class"=>"btn btn-actions-winnub1","icona"=>'<i class="fa fa-plus"></i>'),
                        array("nome"=>t("categorie"),"href"=>"/".getLanguage()."/prodotti/gestione/categorie","class"=>"btn colore-secondario","icona"=>'<i class="fa fa-cubes"></i>')
                    )
                )
                );?>
        
        
            <div class="box box-default">
                
                <div class="box-body">
                    
                    
                    
                    <div class="table-responsive">
                        
                        <table class="table table-striped datatabless" id="tablex" data-page-length='50'>
                            <thead>
                                 <tr>
                                    
                                   <?php 
                                   if(count($tabella_fields)>0){
                                        foreach($tabella_fields as $field){
                                            //ottengo la linea di traduzione
                                            $nometradotto=t("header_gestione_prodotti");

                                            echo "<th>".$nometradotto[$field]."</th>";

                                        }
                                   }
                            ?>
                                     <th></th>
                                     
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                               
                                
                            if(isset($tabella) && count($tabella)>0){
                              foreach($tabella as $t):?>
                                        <tr>
                                            <?php foreach($tabella_fields as $field):?>
                                            <td>
                                                <?=$t[$field]?>
                                            </td>
                                            <?PHP endforeach;?>
                                            
                                            <td>
                                                <a href="<?=$action_url_edit?>/<?=$t[$pkey]?>" class="btn btn-default">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                  
                                                
                                                <a href="<?=$action_url_delete?>/<?=$t[$pkey]?>" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i> 
                                                </a>
                                                
                                                
                                            </td>
                                            
                                        </tr>
                                <?php endforeach; 
                                
                            }?>
                            </tbody>
                            
                           
                            
                        </table>
                        
                        
                        
                    </div>
                   
                </div>
            </div>
       
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
