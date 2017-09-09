<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<?php if( $this->user->getUserType()==User_model::USER_PROFESSIONISTA 
        OR $this->user->isAdmin() ){ ?>
<div class="row form-group">
    <div class="col-xs-12">
    <label>Rag Sociale.</label>

         <input type="text" name="rag_sociale" class="form-control" value='<?=$this->user->fatturazione["rag_sociale"]?>' />

    </div>
</div>

<div class="row form-group">
     <div class="col-xs-12">
        <label>P.IVA</label>

         <input type="text" name="p_iva" class="form-control" value='<?=$this->user->fatturazione["piva"]?>' />

    </div>
</div>

<?php }?>

<div class="row form-group">
    <div class="col-xs-12 col-sm-6">
    <label>Nome</label>

         <input type="text" name="nome_fatt" class="form-control" value='<?=$this->user->fatturazione["nome"]?>' />

    </div>
    <div class="col-xs-12 col-sm-6">
    <label>Cognome</label>

         <input type="text" name="cognome_fatt" class="form-control" value='<?=$this->user->fatturazione["cognome"]?>' />

    </div>
</div>

<div class="row form-group">
    <div class="col-xs-12">
    <label>Codice Fiscale</label>

         <input type="text" name="cod_fiscale" class="form-control" value='<?=$this->user->fatturazione["cod_cf"]?>' />

    </div>
</div>
<div class="row form-group">

    <div class="col-xs-12">
        <label>Comune</label>

         <input type="text" name="com_fatt" class="form-control" value='<?=$this->user->fatturazione["comune"]?>' />

    </div>
</div>
<div class="row form-group">
    <div class="col-xs-12">
        <label>Indirizzo</label>
        <div>
             <input type="text" name="ind_fatt" class="form-control" value='<?=$this->user->fatturazione["indirizzo"]?>' />

        </div>
    </div>


</div>

<div class="row form-group">
    <div class="col-xs-12">
    <label>Telefono</label>

         <input type="text" name="telefono_fatt" class="form-control" value='<?=$this->user->fatturazione["telefono"]?>' />

    </div>
</div>
<div class="row form-group">
    <div class="col-xs-12">
    <label>Email</label>

         <input type="text" name="email_fatt" class="form-control" value='<?=$this->user->fatturazione["emailf"]?>' />

    </div>
</div>
<hr/>
<div id="rigamed" class="row form-group">
<div class="col-xs-12">

<h4><?=t("carica logo aziendale per intestazione")?></h4>
<div class="anteprima_logo">

    <?=$this->user->getLogoIntestazione()?>

</div>
<input id="immaginelogo" type="file" accept="image/*" name="immagine_intestazione">

</div>

</div>
