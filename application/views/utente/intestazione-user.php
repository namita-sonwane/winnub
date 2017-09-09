<?php
 $user=$this->user;
 $logos=$user->getLogo();
    //print_r($logos);
 ?>
<style>
    img.logo-intestazione-fattura{
        max-width: 150px;
        margin: 0px;
        padding: 0px;
    }
</style>

<?php if( $logos!=null ){?><img src="<?=($logos)?>" class='logo-intestazione-fattura' /><?php } ?>
<b><?=$user->fatturazione["rag_sociale"]?></b><br/>
<?=$user->fatturazione["indirizzo"]?>,<?=$user->resolveCap($user->fatturazione["comune"])?>, <?=$user->resolveComune($user->fatturazione["bcomune"])?><br/>
<?=$user->fatturazione["piva"]?> - <?=$user->fatturazione["cod_cf"]?><br/>
<?=$user->fatturazione["telefono"]?> - <?=$user->fatturazione["emailf"]?>