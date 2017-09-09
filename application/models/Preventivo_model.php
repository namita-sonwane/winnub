<?php



class Preventivo_model extends CI_Model{
    
    const STATO_BOZZA='bozza';
    const STATO_ATTESA='attesa';
    
    const STATO_CONFERMATO='confermato';
    const STATO_CANCELLATO='cancellato';
    
    
    public $idpreventivo;
    public $codice_utente;
    public $utente;
    public $cliente;
    public $titolo;
    public $data;
    public $note;
    public $stato;
    public $json_model;
    public $iva;
    public $codice_sconto;
    public $accessori;
    public $template_intestazione;
    
    private $prod_items;//array dei prodotti
    
    public $codice_sessione;
    public $IP;
    
    public $prezzo_finale;
    
    
    
    
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
        
        if($this->idpreventivo>0){
            
            
            
            $carrello=array();
            
            $this->loadProductItems();
            
            foreach($this->prod_items as $item){
                
                $varianti=array();
                if(isset($item->varianti)){
                    $varianti=json_decode($item->varianti,true);
                }
                //print_r($item);
                
                $oggetto=array(
                    "modello"=>$item->prodotto,
                    "altezza"=>$item->altezza,
                    "larghezza"=>$item->larghezza,
                    "qty"=>$item->quantita,
                    "price"=> $item->costo,
                    "descrizione"=>$item->descrizione,
                    "descrizione2"=>$item->descrizione_2,
                    "varianti"=>$varianti,
                    "iva"=>$item->codice_iva,
                    
                );
                
                $carrello[$item->idselezione]=$oggetto;
                 
                
            }
            //creo sessione di carrello
            
            $this->carrello=$carrello;
            
        }
    }
    
    public function setidPrev($id){
        $this->idpreventivo=$id;
    }
    
    /**
     * Restituisce le informazioni sull'invio del preventivo
     * raccoglie e analizza tutti gli invvi del suddetto preventivio
     * 
     */
    public function infoInvio(){
        $query = $this->db->query('SELECT * FROM lm_send_document WHERE '
                    . ' preventivo=? ',
                    array($this->idpreventivo)
        );
        $dati=$query->result_array();
        
        return array("numero_risultati"=>$query->num_rows(),"dati"=>$dati);
    }
    
    
    /**
     * Sempre sulla tabella degli invvi aggiorna lo stato di lettura
     * della email inviata in corrispondenza al preventivo
     */
    public function aggiornaStatoVista($codice,$incremento=1){
       
        //DA IMPLEMENTARE IN FUTURO..
        
        
    }
    
    /**
     * Restituisce il dettaglio del cliente come Oggetto
     * @return Object Cliente
     */
    public function getCliente($cl=null){
        $dati=array();
        
        
        if($this->cliente>0 && $cl==null){
            $cl=$this->cliente;
        }
        
        $query = $this->db->query('SELECT * FROM lm_profili_clienti WHERE '
                    . ' codcliente=? ',
                    array($cl)
                    );
        $dati=$query->custom_result_object("Cliente_model");
        
        return $dati;
    }
    
    
    /**
     * Restituisce il dettaglio del preventivo
     * se settato codicficato a true, cerca il codice come hash criptato.
     * @param STRING/INT $idpreventivo
     * @param BOOLEAN $codificato
     * @return MIXED
     */
    public function getPreventivo($idpreventivo,$codificato=false){
        
        $chiavepreventivo="idpreventivo";
        if($codificato==true){
            $chiavepreventivo=" MD5(idpreventivo)";
            
        }
        
        $query = $this->db->query("SELECT * FROM lm_preventivo WHERE  ".$chiavepreventivo."=? ",
                array($this->idpreventivo));
        $dati = $query->row_array();
        
        if($dati!=null){
            return $dati;
        }
        return null;
    }
    
   
    public function getItems(){
        return $this->prod_items;
    }

    public function getPreventivoItem($code=null){
        
        
        if($code==null){
            
        }else{
            $query = $this->db->query('SELECT * FROM lm_preventivo_item WHERE '
                . 'lm_preventivo_item.idselezione=? ',
                array($code)
                );
            $dati = $query->row_array();
        }
        
        
        if( count($dati)>0){

                    $oggetto=array(
                        "modello"=>$dati["prodotto"],
                        "altezza"=>$dati["altezza"],
                        "larghezza"=>$dati["larghezza"],
                        "qty"=>$dati["quantita"],
                        "price"=>$dati["costo"],
                        "varianti"=>json_decode($dati["varianti"]),
                        "descrizione"=>$dati["descrizione"],
                        "descrizione2"=>$dati["descrizione_2"],
                        "iva"=>$dati["codice_iva"],
                        
                    );

                    return $oggetto;
        }
        
        
        
    }
    
    /**
     * Restituisce il totale degli articoli nel carrello
     * 
     * @return type
     */
    public function totaleArticoli(){
        $totale=0;
        
        foreach($this->carrello as $item){
            $totale+=$item["qty"];
        }
        
        return $totale;
        
    }

    
    public function getNome(){
        return $this->titolo;
    }
    
    

    /**
     * Carica gli elementi del carrello
     */
    protected function loadProductItems(){
        if($this->idpreventivo>0){
            $query=$this->db->query('SELECT * FROM lm_preventivo_item WHERE preventivo_id=? ',
                array($this->idpreventivo));
            $this->prod_items = $query->result();
        }
    }

    /**
     * Effettual il calcolo totale
     * FIX totale esclsione dei dati riguardanti i costi di trasporto...
     * @return type
     */
    public function getTotale($mode=0){
        $totale=0;
        
        $servizi=array();
        $ivatipo=array();
        
        foreach($this->carrello as $c){
            
            $modelloinfo=$this->modello_prodotti->getArticoloCarrello($c["modello"]);
            //print_r($modelloinfo);
            if($modelloinfo->carattere_prodotto=="servizio"){
                
                $t=floatval(floatval($c["price"])*intval($c["qty"]));
                $servizi[]=$t;
               
            }else{ 
                
                $t=floatval(floatval($c["price"])*intval($c["qty"]));
                if($this->codice_sconto>0){
                    $t=$t-floatval(($t*$this->codice_sconto)/100);
                }
                $totale+=($t);
            }
            
            if( $c["iva"]>0){
                $vx=$ivatipo[$c["iva"]];
                $ivatipo[$c["iva"]]=floatval((resolveVatCode($c["iva"]) * $t)/100)+$vx;
            }  
            
        }
        
        
        //print_r($this->codice_sconto);
        $sconti=($totale*$this->codice_sconto)/100;
        
        //$totale=floatval($total);
        
        $costiservizi=0;
        foreach($servizi as $v){
            $costiservizi+=$v;
        }
        
        $iva=0;
        foreach($ivatipo as $ivaval){
            $iva+=$ivaval;
        }
        
        
        return $totale+$iva+$costiservizi;
    }
    
    
    /*
     * carico un preventivo dal modello
     */
    public function fromCarrello($item){
        
    }
    
    /**
     * 
     * @return type
     */
    public function getCarrello(){
        if(count($this->carrello)>0){
            return $this->carrello;
        }
        return null;
    }
    
    public function __toString() {
        return $this->titolo." ";
    }
    
    
    /** 
     *  DA FERIFICARE ??????
     * @param type $valore
     * @return type
     */
    public function aggiornaStato($valore){
        
        
         $controllo_utente=" ( utente='".$this->utente."' "
                 . "OR  "
                 . " utente IN () "
                 . " )";
         
        
         $where = " $controllo_utente  AND idpreventivo = '".$this->idpreventivo."' ";

         $str = $this->db->update_string('lm_user_profile',$dataprofile,$where);
            
         return $this->db->query($str);
         
         
    }
    
    
    public function aggiornaItem($id,$data){
        
        $this->db->where('idselezione', $id);
        $this->db->update('lm_preventivo_item',$data);    
        
    }
    
    public function addItem($data){
        
        
        $this->db->insert('lm_preventivo_item',$data);   
        
    }
    
    
    public function resolveId($codice){
        if( $codice !== ""){
            $query=$this->db->query('SELECT * FROM lm_preventivo WHERE MD5(idpreventivo)=? ',
                array($codice));
            $result = $query->result_array(0);
            return $result[0]["idpreventivo"];
        }
    }
    
    public function elimina(){
        
       if($this->idpreventivo>0){
           
            $this->db->where("idpreventivo",$this->idpreventivo);
            $this->db->update('lm_preventivo',array("stato"=>Preventivo_model::STATO_CANCELLATO));    
            //$this->db->delete('lm_preventivo', array('idpreventivo' => $this->idpreventivo));
            //$this->db->delete('lm_preventivo_item', array('preventivo_id' => $this->idpreventivo));
            _report_log(array("message"=>"Elimina Preventivo : $this->idpreventivo ".json_encode($this)."| ","error"=>" "));
       }
        
    }
    
    
    
    public function generaOrdine($totale){
        
         //verifico che non esista già l'ordine generato
         $query=$this->db->query('SELECT * FROM lm_preventivo_item WHERE preventivo_id=? ',
                array($this->idpreventivo));
          $this->prod_items = $query->result();
         
         $datas=array(
                "idordine"=>unique_code_generator(),
                "rif_preventivo"=>$this->idpreventivo,
                "data_creazione"=>date("Y-m-d h:i:s"),
                "stato_ordine"=>Ordine_model::STATO_ORDINE_ATTESA_PAGAMENTO,
                "costo_totale"=>$totale,
                "iva"=>$this->iva,
                "cliente"=>$this->utente,
                "stato_pagamento"=>Ordine_model::STATO_ATTESA,
                "payment_tx"=>"",
                "data_pay"=>"",
                "code_response"=>"",
                "codice_oggetto"=>"",
                "note"=>"",
                "data_spedizione"=>""
         );
            
         $status = $this->db->insert('lm_ordini',$datas);
         //print_r($status);
         $insert_id = $this->db->insert_id();
         
         $this->idordine=$insert_id;
         
         
            
    }
    
    /*
     * Aggiornamento del model
     */
    public function update($data){
        
        $this->db->where('idpreventivo',$this->idpreventivo);
        $status = $this->db->update('lm_preventivo',$data);
        
    }
    
    
    
    /*
     * Trova il preventivo di riferimento...
     * 
     */
    public function findInvoice(){
        
        $query=$this->db->query('SELECT * FROM lm_fatture_generate WHERE preventivo=? ',
                array($this->idpreventivo));
         $data = $query->result('Invoice_model');
         
         return $data;
    }
    
    
    
}