<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

    
    <label>
        INTESTAZIONE: <?=_config("intestazione_pagamento")?>
    </label>
    <label>
        IBAN : <?=_config("iban_pagamento")?>
    </label>
    <label>
        CAUSALE : <?=_config("causale_pagamento")?>
    </label>
    <br/>
    
    <input type="hidden" name="product_code" value="<?=$codiceprodotto?>">
    <input type="hidden" name="durata" value="<?=$durata?>">
    <button type="submit"  class="btn btn-success btn-lg btn-block">Conferma Attivazione</button>
    