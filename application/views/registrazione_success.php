<?php defined('BASEPATH') OR exit('No direct script access allowed');

//print_r($tipologie);

?>
<div class="register-box">
    
    
  <div class="register-logo">
    <img src="/public/img/logo-winnub.png">
  </div>

  <div class="register-box-body">
      <form class="form" method="post" action="/<?=getLanguage()?>/singup/installconfirm">
        <?php
        if(isset($errors)){//mostra la lista di errori nella registrazione
            
            foreach($errors as $err){
                echo "<p class='error-display'>"
                . "".$err["messaggio"]
                . "</p>";
            }
            
            
        }else{?>
          <h2 class="login-box-msg text-left">
          <?=t("Registrazione avvenuta con successo");?>
      </h2>
              <?=t("Riceverete una email con il link per l'attivazione del vostro profilo.")?>
            
        <?php }
      ?>
        
        <hr/>
        <div class="row row-border ">
            
            <div class="col-xs-12">
                
                

                <div class="form-group ">
                    <label><?=t("Seleziona La lingua")?></label>
                    <select class="form-control">
                        <option value="en">English</option>
                        <option value="it">Italian</option>
                        
                    </select>
                </div>
                
                
            </div>
    
        </div>
         <hr/>
        <div class="row row-border">
            
            <div class="col-xs-12">
                
                <h4 class="title"><?=t("Dati Utente")?></h4>
            

                <div class="form-group">
                    <label><?=t("nome")?></label>
                    <input type="text" name="nome" placeholder="<?=t("tuo nome")?>" class="form-control">
                </div>
                <div class="form-group">
                    <label><?=t("cognome")?></label>
                    <input type="text" name="cognome" placeholder="<?=t("il tuo cognome")?>" class="form-control">
                    
                </div>
                <div class="form-group">
                    <label><?=t("cognome")?></label>
                    <input type="text" name="cognome" placeholder="<?=t("il tuo cognome")?>" class="form-control">  
                </div>
                <div class="form-group">
                    <label><?=t("cognome")?></label>
                    <input type="text" name="cognome" placeholder="<?=t("il tuo cognome")?>" class="form-control">  
                </div>
                
                
            </div>
    
        </div>
          <hr/>
        
        <a href="/dashboard" class="btn btn-bitbucket">Salta Configurazione</a>

        <button name="confirm" class="btn btn-default pull-right btnconfirm" type="submit">
            Conferma Dati
        </button>


      </form>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<?php