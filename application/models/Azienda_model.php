<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Azienda_model extends CI_Model{
  
    private $DBCORE;
    
    public $codazienda;
    public $nome;
    public $intestazione;
    public $piva;
    public $comune;
    public $provincia;
    public $indirizzo;
    public $cap;
    public $codice_subdomain;
    public $media_logo;
    
    
    
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        $this->DBCORE=$this->load->database('winnubsubdomain',TRUE);
        $this->DBCORE->set_dbprefix('wb_');
        
        //legge le informazioni dell'azienda appartenenete 
        //e e carica i dati dalla sessione
        if(isset($_SESSION["LOGGEDIN"])){
           $owner=$_SESSION["LOGGEDIN"]["business"];
           $this->loadMe($owner);
        }
        
       
    }
    
    
    
    
    
    public function creaAzienda($dati){
        
        $this->db->insert("lm_azienda",$dati);   
        $insert_id = $this->db->insert_id();
        
        
        //attivo il servizio free
        $this->DBCORE->insert("activation",
                array(
                    "codice_azienda"=>$insert_id,
                    "codice_prodotto"=>1,
                    "data_acquisto"=>date("Y-m-d H:i:s"),
                    "data_attivazione"=>date("Y-m-d H:i:s"),
                    "stato"=>"attivo",
                    "durata"=>1,//sono i mesi di contratto
                )
        );
        
        
        return $insert_id;
        
        
        
    }

    
    /**
     * Inserisce un pagamento e lo pone in stato di attesa
     * @param type $data
     * @return type
     */
    public function process_payment($data){
        $db=$this->DBCORE;
        
        $data["codice_azienda"]=$this->codazienda;
        $data["data_attivazione"]=date("Y-m-d h:i:s");
        $data["data_acquisto"]=date("Y-m-d h:i:s");
        $data["stato"]="attesa";
        
        $db->insert("wb_activation",$data);
        $insert_id = $db->insert_id();
        
        return $insert_id;
    }
    
    public function update_payment($code){
        
    }
    

    public function getPaymentTypes($azienda=0){
        $cod=0;
        if($azienda>0){
                $cod=$azienda;
        }else{
            $cod=$this->codazienda;
        }
        $query = $this->db->query("SELECT * FROM lm_tipologie_pagamento WHERE azienda=?",array($cod));
        return $query->result_array();
    }
    
    public function getPayment($codice){
        
        $query = $this->db->query("SELECT * FROM lm_tipologie_pagamento WHERE ptype=? ",array($codice));
        return $query->result_array();
    }
    
    public function getTassazioni($codice=null){
        $t=null;
        if($codice==null){
            $query = $this->db->query('SELECT * FROM lm_tassazioni '
                    . ' WHERE azienda = ? ',array($this->codazienda));

            $t = $query->result_array();
        }else{
            
             $query = $this->db->query('SELECT * FROM lm_tassazioni '
                    . ' WHERE azienda = ? AND idTassazione=?  ',array($this->codazienda,$codice));
             
             $t = $query->result_array();
            
        }
        
        return $t;
        
        
    }



    public function getScadenzaServizio(){
        
        $stat=$this->getStatusAccount();
        if(count($stat)>0){
            $stat=$stat[0];
            
            //print_r($stat);

            if( $stat!=NULL ){

                $dataemissione=(($stat->data_attivazione));
                $durata=$stat->durata;

                $oggi=date("y-m-d");
                $datascadenza = date('d/m/Y', strtotime("+ $durata month",strtotime($dataemissione)));
                //echo date_diff($datascadenza, $oggi) ;
                return $datascadenza;
                
            }
        
        }
        
        return null;
        
    }
    
    
    

    public function serivizioAttivo(){
        
        
        $stat=$this->getStatusAccount();
        
        if(!empty($stat)){
            
            $statoservizio=$stat->attivo;
            
            if($statoservizio=="attivo"){
                $dataemissione=$stat->data_attivazione;
                $durata=$stat->durata;

                $oggi=date("Y-n-d");
                $effectiveDate = date('Y-m-d', strtotime("+$durata month", strtotime($dataemissione)));

                if($effectiveDate>$oggi){
                    return false;
                }else{
                    return true;
                }
            }
            
            return false;
        }
        
        
        return false;
    }
    
    public function getStatusAccount(){
        
        $db=$this->DBCORE;
        $obj=null;
        if(isset($_SESSION["LOGGEDIN"])){
          
             
           $owner=$_SESSION["LOGGEDIN"]["business"];
           
           $query = $db->query('SELECT * FROM wb_activation JOIN wb_products ON wb_products.product_code=wb_activation.codice_prodotto '
                   . ' WHERE wb_activation.codice_azienda = ?  ORDER BY wb_activation.idact DESC ',array($owner));
           $obj =   $query->result();
           
        }
        
        return $obj;
    }


    public function getBusinessUrl(){
        
        return "https://".trim($this->codice_subdomain).".winnub.com/";
        
    }
    
    
    public function loadMe($owner){
        
        if($owner>0){
        
            $query = $this->db->query('SELECT * FROM lm_azienda WHERE codazienda = ? ',array($owner));
            $obj =    $query->row(0);
            if ( isset($obj) ){
                
                $this->codazienda       =   $obj->codazienda;
                $this->nome             =   $obj->nome;
                $this->intestazione     =   $obj->intestazione;
                $this->piva             =   $obj->piva;
                $this->comune           =   $obj->comune;
                $this->provincia        =   $obj->provincia;
                $this->indirizzo        =   $obj->indirizzo;
                $this->cap              =   $obj->cap;
                $this->codice_subdomain =   $obj->codice_subdomain;
                $this->media_logo       =   $obj->media_logo;
                
            }
        }else{
            redirect("/logout");
        }
        
    }
    
   
    
}