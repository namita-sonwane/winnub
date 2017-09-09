<?php

/* ---
 * Modello gestione ordini
 * ---
 * 
 * 
 */

class Ordine_model extends Preventivo_model{
    
    
    const STATO_ORDINE_LAVORAZIONE="lavorazione";
    const STATO_ORDINE_SPEDITO="spedito";
    const STATO_ORDINE_TRANSITO="transito";
    const STATO_ORDINE_CONSEGNATO="consegnato";
    const STATO_ORDINE_ANNULLATO="annullato";
    const STATO_ORDINE_ATTESA_PAGAMENTO="attesa_pagamento";
    
    
    const STATO_PAGAMENTO_COMPLETED="Completed";
    const STATO_PAGAMENTO_PEDING="Pending";
    const STATO_PAGAMENTO_REFUNDED="Refunded";
    
    

    var $idordine;
    var $data_creazione;
    var $stato_ordine;
    var $costo_totale;
    var $iva;
    var $cliente;
    var $stato_pagamento;
    var $payment_tx;
    var $data_pay;
    var $code_response;
    var $note;
    var $data_spedizione;
    var $rif_preventivo;
    
     
    public function __construct()
    {
       
        
       //se risulta caricato il riferimento del preventivo
        //ottengo le informazioni ereditate.
        if($this->rif_preventivo>0){
            $this->setidPrev($this->rif_preventivo);
        }
        
        // Call the Model constructor
        parent::__construct();
        
         
        
    }
    
    protected function ordineDetail(){
        
        if($this->rif_preventivo>0){
            
        }
    }
    
    
   
    
    
    
   
    
    
}