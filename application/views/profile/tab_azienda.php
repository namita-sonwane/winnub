<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="form-group">
    <label>Denominazione</label>
    <input type="text" name="denominazione_a" class="form-control" value="<?=$this->user->BUSINESS->nome?>" />
</div>
<div class="form-group">
    <label>Intestazione</label>
    <input type="text" name="intestazione_a" class="form-control" value="<?=$this->user->BUSINESS->intestazione?>">
</div>
<div class="form-group">
    <label>P.Iva/Codice Fiscale</label>
    <input type="text" name="piva_a"  class="form-control" value="<?=$this->user->BUSINESS->piva?>">
</div>
<div class="form-group">
    <label>Indirizzo</label>
    <input type="text" name="indirizzo_a"  class="form-control" value="<?=$this->user->BUSINESS->indirizzo?>">
</div>
<div class="row form-group">
    <div class="col-xs-12 col-sm-6">
         <label>Comune</label>
          <input type="text" name="comune_a"  class="form-control" value="<?=$this->user->BUSINESS->comune?>">

    </div>
    <div class="col-xs-12 col-sm-6">

          <label>Cap</label>
          <input type="text" name="cap_a"  class="form-control" value="<?=$this->user->BUSINESS->cap?>">

    </div>
</div>
<div class="form-group">
    <label>Provincia</label>
    <input type="text" name="provincia_a"  class="form-control" value="<?=$this->user->BUSINESS->provincia?>">
</div>



<div class="row form-group">
     <!--<div class='col-xs-12 col-sm-6'>

    <label>Indirizzo-web piattaforma:</label>
     <br/>
    http://<b><?=$this->user->BUSINESS->codice_subdomain?></b>.winnub.com
    </div>-->
    <div class='col-xs-12 col-sm-6 text-center'>
        <!--<h3 class='message'>
        Puoi richiedere l'indirizzo personalizzato come: http://<b>tuonome</b>.winnub.com/ (OFFERTA GOLD)
        </h3>-->
        <br/><br/>
        <a href="/<?=getLanguage()?>/profile/upgrade" class="btn btn-info btn-lg" target="new"> Upgrade profilo </a>
    </div>
</div>