<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->view('limap/_header');

$this->view('limap/_sidebar');

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
                     <div class="row text-center">
                         
                         <label>Cambia Lingua</label>
                         
                     </div>
                </div>
                <div class="box-body">
                    
                    <?php
                        global $LANG;
                    ?>
                    
                    <div class="table-responsive">
                        
                        <h4>File lingua: <?=getLanguage()?></h4>
                        
                        <table class="table table-striped datatabless" id="tablex" data-page-length='50'>
                            <tr>
                                <th>Chiave da tradurre</th>
                                <th>Traduzione</th>
                            </tr>
                            
                            <?php
                            
                            
                            
                            foreach($LANG->language as $parola=>$testo){
                                
                                
                                ?>
                            <tr>
                                <td><?=$parola?></td>
                                <td><?php
                                    
                                    if(is_array($testo)){
                                        
                                        foreach ($testo as $k=>$i){
                                            echo " {".$k." : ".$i."}<br/>";
                                        }
                                        
                                    }else{
                                        echo $testo;
                                    }
                                    ?></td>
                            </tr>    
                                    
                                <?php
                            }
                            ?>
                            
                        </table>
                        
                        
                        
                    </div>
                   
                </div>
            </div>
       
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php

$this->view('limap/_footer');