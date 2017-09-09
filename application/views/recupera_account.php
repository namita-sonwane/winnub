<?php defined('BASEPATH') OR exit('No direct script access allowed');

//print_r($tipologie);

?>
<div class="register-box">
    
    
  <div class="register-logo">
    <img src="/public/img/logo-winnub.png">
  </div>

  <div class="register-box-body">
      
      
      <h3 class="login-box-msg text-left">
          <?=t("Recupera account");?>
      </h3>
      <p>
          <?=t("Richiedi tramite email la procedura di recupero della password.")?>
      </p>

      <form action="<?="/".getLanguage()."/restore"?>" method="post" class="form clearfix">
        
        <?php
        if(isset($errors)){//mostra la lista di errori nella registrazione
            
            
            
        }
      ?>
        
        
        <div class="formselection formregistrazione">
            
           
             
           
            
            <div class="form-group has-feedback">
              <input type="email" name="email" class="form-control" placeholder="Email di registrazione" required>
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            
            

            <div class="form-group has-feedback">
                <div class="">
                    <div class="col-xs-6">
                     
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">
                        <input type="hidden" name="registrazione" value="1">
                      <button type="submit" class="btn btn-primary btn-block btn-flat"><?=t("Invia-email-di-recupero")?></button>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
       </div>
        
    </form>
    
    <hr/>

   

    <a href="<?="/".getLanguage()."/login"?>" class="text-center">Sono già registrato</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<?php
//includo l'header
