<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * Tabella generica per la gestione della vista a tabella
 * 
 * 
 */
$this->view('limap/_header');

 
$this->view('limap/_sidebar');

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
        
            if($this->user->isAdmin()): 
                $this->view('limap/_barra_strumenti',
                    array(
                        "buttons"=>array(
                            array("nome"=>t("nuovo"),"href"=>"/".getLanguage()."/profile/adduser","class"=>"btn btn-actions-winnub1","icona"=>'<i class="fa fa-plus"></i>'),
                            //array("nome"=>t("categorie"),"href"=>"/".getLanguage()."/prodotti/gestione/categorie","class"=>"btn colore-secondario","icona"=>'<i class="fa fa-cubes"></i>')
                        )
                    )
                );
            endif;
            
            ?>
                
        <div class="row">
            
            <div class="col-xs-10 col-xs-push-1">
                

                <div class="network-users">
                        <?php
                            $dipendenti=$this->user->getAccountDipendenti();
                            foreach($dipendenti as $dp): 
                                //print_r($dp);
                            ?>
                                <div class="single-user <?=($dp->isAdmin()?"admin":"")?>">
                                    <a href="<?=base_url("/".getLanguage()."/network/user/".$dp->username)?>">
                                        <figure class="icon-user">
                                        <?php
                                            $a=$dp->getPhoto();
                                            if($a!=null){
                                                echo "<img src='/$a'class='img-circle' with='42'>";
                                            }
                                        ?>
                                        </figure>
                                        <span><?=$dp->username?></span>
                                        <div class="infos ">
                                            <a href="#" class="label label-primary"><i class="fa fa-commenting"></i> <span>1</span></a>
                                            <a href="#" class="label label-primary"><i class="fa fa-star"></i> <span>11</span></a>
                                        </div>
                                    </a>
                                </div>
                        <?php
                            endforeach;    


                        ?>




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