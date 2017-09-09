<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//print_r($modello);
$pagamento=null;
if(isset($modello[0])){
    $pagamento=$modello[0];
}else{
    $pagamento=$modello;
    
}

$campi=json_decode($selezione);




if($modo=="print"){?>

    <style type="text/css" media="print">
        body{
            margin: 0px;
            padding: 0px;
            
            font-family: Arial,sans-serif;
            background-color: #fff;
        }
    table{
        border-color: #999;
        border: 0px solid #ffffff;
        border-spacing: 0px;
    }
    table > tr{
         vertical-align: middle;
         border: 0px solid #fff;
    }  
    
    table > tr > th,
    table > tr > td{
       vertical-align: middle;
       border: 0px solid #afafaf;
       padding: 32px;
       line-height: 33pt;
    }
    
    table#a > tr > td{
        padding: 12em!important;
        border-bottom: 2px solid #a9a9a9;
        
        
        vertical-align: middle;
       
    }
    .note{
        width: 100%;
        border: 0px solid #fff;
        padding: 12px;
        margin-top: 6px;
        
    }
    .note p{
        padding: 12px;
        margin-left: 12px;
        margin-right: 12px;
    }
    .footerquote p{
        padding: 0x;
        margin: 0px;
    }
    p{
        padding: 0px;
        margin: 0px;
    }
    
    table.noborder,
    table.noborder tr td,
    table.noborder tr{
        border: 0px solid #fff;
        vertical-align: middle;
        line-height: 12pt;
        text-align: right;
        font-size: 10pt;
        margin: 0px;
        border-spacing: 0px;
        border-collapse: collapse;
        
    }
    
    
    table.footerquote > tr > td{
        line-height: 12pt;
       
    }
    table.intestazionetable,
    table.intestazionetable tr,
    table.intestazionetable tr td{
        border: 0px solid #fff;
        line-height: 12px;
    }
    table.intestazionetable td{
        border: 0px solid #fff;
    }
    .block50{
        width: 200pt;
        float: left;
        
    }
    .block50 img{
        max-width: 100%;
    }
    
    .border{
        border: 1px solid #a1a1a1;
    }
    
    #intestazione{
        
    }
  
    .business-image img{
        margin-top: 0px;
    }
    
    table.noborder1,
    table.noborder1 tr,
    table.noborder1 tr td{
        border: 0px solid #fff;
        line-height: 16pt;
        margin-bottom: 22px;
    }
    
    
    table{
        border-top: 0px solid #fff;
    }
    
    
    .blocks-c{
        text-align: center;
        border-bottom: 1px solid #000;
    }
    
     .logo-intestazione-fattura{
         margin: 0px;
         max-height: 90px;
     }
     .logo-intestazione-fattura img{
         max-height: 100px;
     }
     h3{
         margin: 0px;
         padding: 0px;
     }
       
     table.payment tr td{
         padding: 22px 26px;
         
     }
</style>

<h3><?=t("metodo-di-pagamento")?></h3>
<table class="payment">
    
    <tr>
        <td colspan="2">    <b><?=$pagamento["descrizione"]?></b></td>
    </tr>
    
    <?php 
    if(count($campi->field)>0){
    foreach($campi->field as $field){?>
        <tr>
            <td>    <?=t($field->label)?></td>
            <td>    <?=$field->name?> - <?=$field->value?></td>
        </tr>
    <?php }
    
    }?>
</table>
    
    
<?php 

}else{
//print_r(json_encode($campi_tmp));
    
    if($modo=="ajax" && $codice!=0 ){
        $campi=$pagamento["campi"];
        $campi=json_decode($campi);
    }else{
        $campi=json_decode($selezione);
    }

 ?>

<div class="row row-divider">

   <div class="col-xs-12">
        <p><?=$pagamento["descrizione"]?></p>
   </div>
  
</div>

<?php
/**
* 
*/

if(count($campi->field)>0){
       foreach($campi->field as $field){

           ?>
       <div class="row row-border">

               <label class="col-xs-2"><?=t($field->label)?></label>
               <div class="col-xs-10">
                <input type="text" name="pagamenti[<?=$field->name?>]" class="form-control <?=$field->class?>" value="<?=$field->value?>" />
               </div>

       </div>
         <?php
       }

}
?>
<hr/>
<?php } ?>