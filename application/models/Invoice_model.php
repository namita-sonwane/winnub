<?php

/* ---
 * Modello gestione ordini
 * ---
 * 
 * 
 */

class Invoice_model extends Preventivo_model{
   
   private static $db;
    
   var $rif_preventivo;
   
   var $codfatt=0;
   var $preventivo=0;
   var $codice_seq=0;
   var $anno=0;
   var $data=0;
   var $totale=0;
   var $utente;
   
   var $cliente;
   
   var $titolo="";
   var $price=" ";
   var $qty="";
   var $tipologia_pagamento="";
   var $note_fattura="";
   var $sconto="";
   
   var  $template;
   
   var $items=array();
   
   var $intestazione;
   
   var $pagamento_selezione;
   
   //introduzione del tipo
   var $tipo_prodotto="prodotto";
   
   
     
   public function __construct()
   {
       
        
        // Call the Model constructor
        parent::__construct();
        
        self::$db = &get_instance()->db;
        
        //se risulta caricato il riferimento del preventivo
        //ottengo le informazioni ereditate.
        if($this->idpreventivo>0){
          
           $this->preventivo=$this->idpreventivo;
           $this->template=$this->template_intestazione;
           
            
        }
        
        $this->intestazione="";
        
        //$this->loadRigheFattura(); se non serve è inutile caricarlo
        //lo richiamo quando serve il dettaglio
        //carico le informazioni per mostrarle sulla tabella
        
      
        
    }
    
    
    /*
     * Genera il codice di sequenza per il codice_seq;
     */
    public function generaCodiceSequenza(){
       
        $utente=$this->utente;
        
        if($utente==null OR $utente==0){
            $utente=$_SESSION["LOGGEDIN"]["userid"];
        }
        
        $query=$this->db->query("SELECT max(codice_seq) as max FROM lm_fatture_generate WHERE utente=? ",array($utente));
        
        $result=$query->result_array();
        if(count($result)>0){
            $result=intval($result[0]["max"]);
            $result++;
        }else{
            $result=1;
        }
        
        
        return $result;
    }


    /**
     * Restituisce l'indirizzo completo per il documento
     * @return String
     */
    public function getDocumentUrl($view="create_pdf"){
        
        return "/".getLanguage()."/invoice/$view/".MD5($this->codfatt);
        
    }
    
    
    public function elementiInviati(){
        
        $result=$this->db->query("SELECT * FROM lm_send_document WHERE tipo_documento='fattura' AND preventivo=? ",array($this->codfatt));
        $obj=$result->result_array();
        
        return $obj;
    }




    public static function getInvoice($codice,$CRIPTED=false){
        if(!$CRIPTED){
            $obj=self::$db->where('codfatt',$codice)->get('lm_fatture_generate')->result('Invoice_model');
        }else{
            $obj=self::$db->where('MD5(codfatt)',$codice)->get('lm_fatture_generate')->result('Invoice_model');
        }
        return $obj[0];
    }


    public function invoiceDetail(){
        
        if($this->codfatt>0){
            $this->loadUtenza();
            
            
            $this->loadInfoCliente();
            
            $this->loadRigheFattura();
        }
        
    }
    
    
    public function getItem($id){
        
        $this->db->where("idarticolo",$id);
        $result=$this->db->get("lm_fatture_items");
        $obj=$result->result_array();
        return $obj[0];
    }
    
      public function getItems(){
        
        $this->db->where("codfattura",$this->codfatt);
        $result=$this->db->get("lm_fatture_items");
        $obj=$result->result_array();
        return $obj;
    }
    
    public function generaDescrizioneItem($rigaitem){
        
        
         $query="SELECT * FROM lm_modelli_prodotti WHERE codice_modello=?   LIMIT 1 ";
         $result=$this->db->query($query,array($rigaitem->prodotto));
         $b=$result->result_array(0);
         $prodotto=$b[0];
        
         $html="".$prodotto["nome"]." ".$rigaitem->larghezza."X".$rigaitem->altezza.
                 "<br/><img src='".$prodotto["foto"]."'>";
         $html.="<p>".$prodotto["descrizione_tecnica"]."</p>";
         
         return $html;
    }
    
    
   
    
    
    public function generaFattura($codice,$anno=null,$totale=null){
        
        if($anno==null OR $anno==0){
            $anno = date("Y");
        }
        
        if($codice==0){
            $codice=$this->generaCodiceSequenza();
        }
        
        
        
        if($this->idpreventivo>0){
            

             $data=array(
                 "utente"=>$this->utente,//genera dal preventivo
                 "preventivo"=>$this->idpreventivo,
                 "codice_seq"=>$codice,
                 "anno"=>$anno,
                 "data"=>date("Y-m-d H:i:s"),
                 "totale"=>$totale,
                 "cliente"=>$this->cliente,
                 "sconto"=>$this->codice_sconto,
                 "intestazione"=>$this->template_intestazione,
                 "pagamento_selezione"=>$this->pagamento_selezione,
                 "tipologia_pagamento"=>$this->tipologia_pagamento,
                 
             );
             $this->db->insert("lm_fatture_generate",$data);
             $this->codfatt=$this->db->insert_id();
             if($this->codfatt>0){
                  $this->clonaRighePreventivo($this->idpreventivo);
             }
             
             
        }else{
            
            $data=array(
                 "utente"=>$_SESSION["LOGGEDIN"]["userid"],//genera dal preventivo
                 "preventivo"=>0,
                 "codice_seq"=>$codice,
                 "anno"=>$anno,
                 "data"=>date("Y-m-d H:i:s"),
                 "totale"=>$totale,
                 "cliente"=> $this->cliente,
                 "sconto"=>0,
                 "intestazione"=>"",
                 "pagamento_selezione"=>$this->pagamento_selezione,
                 "tipologia_pagamento"=>$this->tipologia_pagamento,
             );
            $this->db->insert("lm_fatture_generate",$data);
            $this->codfatt=$this->db->insert_id();
            
        }
       
        return $this->codfatt;
    }
    
    
    public function getElementiData(){
        
        $lista_tasse=array();
        $totale_tassazioni=0;
        $totalecarrello=0;
        $codiciarticoli=array();
        $costiservizi=array();
        $sommasconti=0;
        
        $elementi=array();

        foreach($this->getItems() as $itm){

                    //print_r($itm);
                    $codiciarticoli[]       =       intval($itm["idarticolo"]);
                    $RIFERIMENTO_PRODOTTO   =       json_decode($itm["altro"]);


                    //print_r($RIFERIMENTO_PRODOTTO);
                    $elementi[]=array(
                        $itm["cod_articolo"],
                        $itm["descrizione"],
                        $itm["quantita"],
                        $itm["prezzo"],
                        $itm["iva"]
                    );
                   
                    
                    $costopertasse=0;
                    $valoresconto=0;
                    if($itm["tipo_prodotto"]=="servizio"){

                        $costos=(floatval($itm["prezzo"])*intval($itm["quantita"]));


                        $costopertasse=( (floatval($costos)*intval($itm["iva"]))/100 );

                        $costiservizi[]=$costos;

                    }else{//i prodotti rispetto ai servizi non sono soggetti a sconti stiche applicate.
                        $costot=(floatval($itm["prezzo"])*intval($itm["quantita"]));
                        $totalecarrello+=$costot;

                        //devo sottrarre gli sconti
                        if($invoice->sconto>0){
                            $valoresconto=($costot*$invoice->sconto)/100;
                        }
                        $costot=$costot-$valoresconto;

                        $sommasconti+=$valoresconto;

                        $costopertasse=( (floatval($costot)*intval($itm["iva"]))/100 );
                    }
                    //nella tassazione devo calcolare lo sconto eventuale
                    $lista_tasse[$itm["iva"]]+=$costopertasse;

        }
                
        return array(
            "elementi"=>$elementi,
            "tasse"=>$lista_tasse,
            "servizi"=>$costiservizi,
            "totale"=>$costot,
            "totalesconti"=>$sommasconti);
    }
    
    public function update($data,$items=null){
        
        if($this->codfatt>0 && isset($data)){
            
            if(isset($data["codfatt"])){
                unset($data["codfatt"]);//protect data id
            }
            
            $this->db->where('codfatt',$this->codfatt);
            $this->db->update("lm_fatture_generate",$data);
            
            if(count($items)>0 && $items!=null){
                
                foreach($items as $key=>$itm){
                    $this->db->where('idarticolo',$key);
                    $this->db->update("lm_fatture_items",$itm);
                }
                
            }
            
            return array("status"=>1,"update"=>"success");
            
       }else{
           
           //in questo caso siamo nella parte di inserimento nuovo
           $this->db->insert("lm_fatture_generate",$data);
           
           return array("status"=>$this->db->insert_id(),"insert"=>"success");
           
       }
       
       return array("status"=>0,"update"=>"error");
       
    }
    
    
    
    public function loadUtenza(){
        
        
         if($this->utente==0 && $this->preventivo>0){

            $query="SELECT utente FROM lm_preventivo WHERE idpreventivo=?  LIMIT 1 ";
            $result=$this->db->query($query,array($this->preventivo));
            $b=$result->result_array(0);
            $this->utente=$b[0]["utente"];
            
        }
        
    }
    
    public function loadRigheFattura(){
        
        
            
        if($this->codfatt>0){ 
            
            $this->db->where("codfattura",$this->codfatt);
            $result=$this->db->get("lm_fatture_items");
            
            $this->items=$result->result_array();
            
        }
        
        
       
    }
    
    
    
    public function loadInfoCliente(){
        
        //tento nel recupero esterno.
        //un tentaivo forzato ma credo ottimale in caso di errore...
        if($this->cliente==0){
            $this->loadUtenza();
        }
        
        if($this->cliente>0){
            
            $query="SELECT * FROM lm_profili_clienti WHERE "
                    . " codcliente = (SELECT cliente FROM lm_fatture_generate WHERE codfatt=? ) "
                    . " LIMIT 1 ";
            $result=$this->db->query($query,array($this->codfatt));
            $b=$result->result_array();
            if(isset($b[0])){
                $this->cliente_profile=$b[0];
            }
            
        }
    }
    
    
    public function addItem($data){
        
        //parent::addItem($data); chiamerebbe quella del preventivo...ATTENZIONE
        if($this->codfatt==0){
           
        }
        $values=array(
                "codfattura"=>$this->codfatt,
                "cod_articolo"=>$data["newitem"],
                "descrizione"=>$data["descrizione"],
                "unita_mis"=>"",
                "quantita"=>$data["qty"],
                "prezzo"=>$data["price"],
                "sconto"=>"",
                "altro"=>"(null,null)",
                "iva"=>$data["imposta"],
                "tipo_prodotto"=>(($data["tipologiaservizio"]=="selezionato")? "servizio":"prodotto")
        );
        $this->db->insert("lm_fatture_items",$values);
        
        return $this->db->insert_id();
        
    }


    /**
     * Crea la copia delle righe del preventivo sulla fattura
     */
    public function clonaRighePreventivo($codicepreventivo){
            
           
            $this->db->where("preventivo_id",$codicepreventivo);
            $items=$this->db->get("lm_preventivo_item");
            
            $values=array();
            $righe_preventivo=$items->result();
            
            if(count($righe_preventivo)>0){
                //print_r($righe_preventivo);
                $values=array();
                foreach($righe_preventivo as $row){
                    
                    $tipologiaprodotto="prodotto";
                    if($row->prodotto>0){        
                        
                        $prodotto_mod=$this->modello_prodotti->get_id($row->prodotto,true);
                        $prodotto_mod=$prodotto_mod[0];
                        $tipologiaprodotto=($prodotto_mod->carattere_prodotto=="servizio")?"servizio":"prodotto";
                    }
                    
                    $descrizione="";
                    if(isset($this->descrizione) && $this->descrizione!=0
                            && isset($this->descrizione_2) && $this->descrizione_2!=0){
                        $descrizione=$this->descrizione+$this->descrizione_2;
                    }else{
                        $descrizione=$this->generaDescrizioneItem($row);
                    }
                    
                    $values[]=array(
                        "codfattura"=>$this->codfatt,
                        "cod_articolo"=>$row->codice_identificativo,
                        "descrizione"=>$descrizione,
                        "unita_mis"=>"",
                        "quantita"=>$row->quantita,
                        "prezzo"=>$row->costo,
                        "sconto"=>"",
                        "altro"=>"(".$row->prodotto.", ".$row->varianti.")",
                        "iva"=>$row->codice_iva,
                        "tipo_prodotto"=>$tipologiaprodotto
                        
                    );
                }
                //inserisco su lm_fatture_items
                $this->db->insert_batch("lm_fatture_items",$values);
                
            }
            //se possibile corregge eventuali conteggi non corretti...
        
        
    }
    
    
    /**
     * Carica un nuovo invoice in base alla selezione dell'id
     * @param type $id
     * @return type
     */
    function get($id){
        
        $this->db->where("codfatt",$id);
        $query=$this->db->get("lm_fatture_generate");
        $dati=$query->custom_result_object("Invoice_model",0);
        $dati=$dati[0];
        
        $dati->invoiceDetail();
        
        $dati->loadRigheFattura();
        
        return $dati;
        
    }
    
    
    
    function getTemplate(){
        
        if( !empty($this->template_intestazione) ){
            
            return $this->template_intestazione;
            
        }
        
        return $this->template;
    }
   
    
    
}