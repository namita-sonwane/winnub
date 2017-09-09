<?php defined('BASEPATH') OR exit('No direct script access allowed');

//includo l'header
$this->view('limap/_header');

$this->view('limap/_sidebar');


//$user=$this->adminuser->getUserProfile($codice);   
//print_r($user);
?>
    
   
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=t("Nuovo-Profilo-utente")?>
        <small><?=t("iscrivi un nuovo collaboratore o dipendente")?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Iscrizione</li>
      </ol>
    </section>
    
   

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <br/>  <br/>   <br/>
            <div class='col-xs-12 col-sm-10 col-sm-push-1'>
                <?php
                
                    if(count($errors)>0){
                        echo "<ul>";
                        foreach($errors as $er){
                            echo "<li>".$er["message"]."</li>";
                        }
                        echo "</ul>";
                    }
                
                ?>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        <form class='form' method="post" action="<?="/".getLanguage()."/profile/sendusermail"?>" id="formaddus">
                            
                            
                            
                            <div class='form-group'>
                                <label><?=t("Nome")?></label>
                                <input type='text' name='nome' class='form-control'/>
                            </div>

                           
                            
                            <div class='form-group'>
                                <label><?=t("Email collaboratore")?></label>
                                <input type='email' name='email' class='form-control' id="emailc"/>
                            </div>
                            
                            <div class='form-group'>
                                <label><?=t("Messaggio")?></label><br/>
                                <textarea name="messaggio" class="form-control" style="max-width: 100%;width: 100%;"></textarea>
                            </div>
                            
                            
                            
                            <div  class='form-group text-center'>
                                <button type='submit' name='addcollab' class="btn btn-primary"><?=t("Aggiungi")?></button>
                            </div>
                        </form>
                        
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