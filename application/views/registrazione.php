<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="register-box">
    
    <div class="register-logo">
            <img src="/public/img/logo-winnub.png" />
    </div>
    
    

    <div class="register-box-body">
      
      
        <h2 class="login-box-msg text-left">
            <?=t("Crea il tuo account");?>
        </h2>
        <h4>
            <?=t("Prova nuovi strumenti aziendali per il tuo network di professionisti del settore.")?>
        </h4>
        
        <hr/>

        <form action="<?="/".getLanguage()."/signup"?>" method="post" class="form clearfix" id="formregister">
        
        <?php
        if(isset($errors)){//mostra la lista di errori nella registrazione
            
            foreach($errors as $err){
                echo "<p class='error-display'>"
                . "".$err["messaggio"]
                . "</p>";
            }
            
            
        }
        ?>
        
        
        <div class="formselection formregistrazione">
            
           
            <?php 
            
            //print_r($infoazienda["data"]);
            
            if($infoazienda["data"]->codazienda==0):?>
                <div class="form-group has-feedback">
                    <input type="text" name="nomeazienda" id="nomeazienda" class="form-control" placeholder="<?=t("Nome-azienda")?>" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div id="resultdomain"></div>
            <?php  else:?>
                <label><?=t("Ti stai registrando con")?> <?=$infoazienda["data"]->nome;?></label>
                <input type="hidden" name="codiceazienda" value="<?=$infoazienda["data"]->codazienda;?>" />
            <?php endif;?>
                
                <div class="form-group has-feedback">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
              </div>
            
            <hr/>
            
              
                
            <div class="form-group has-feedback">
              <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" required>
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            
            
           <div class="form-group has-feedback">
              <input type="email" name="repemail" class="form-control" id="repemail" placeholder="Ripeti E-mail" required>
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            
            
            <div class="form-group has-feedback">
              <input type="password" name="password" class="form-control" placeholder="Password" id="password" required>
              <span class="glyphicon glyphicon-open form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" name="re-password" class="form-control"  id="re_password" placeholder="Ripeti Password" required>
              <span class="glyphicon glyphicon-open form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <div class="">
                    <div class="col-xs-6">
                      <div class="checkbox icheck">
                        <label class="">
                            <input type="checkbox" class="checkbox" id="accetta"> <?=t("Accetta")?> <a href="#"><?=t("condizioni di servizio")?></a>
                        </label>
                      </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">
                        <input type="hidden" name="registrazione" value="1">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="singupsend" value="true"><?=t("Registrati")?></button>
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
