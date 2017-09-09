<?php

/* 
 * ----------------------------------
 * 
 * Rfqs_model
 * 
 * ----------------------------------
 * 
 */

class Rfqs_model extends CI_Model{
    
    
    public $utente=null;
    public $nome="";
    public $description="";
    public $process_services="";
    public $rfq_files="";
    public $materials="";
    public $fcolor="";
    public $quantity="";
    public $quantityperyear="";
    public $protoType="";
    public $hasdeadline="";
    public $deadlinedate="";
    public $shippingcountry='';
	public $created_date='';
	
	public $product_group='';

    public $hidden=0;
	public $codrfq=0;
	
    
    
    public function __construct(){
        // Call the Model constructor

        parent::__construct();
        $this->load->database();
        $this->caricaAzienda();
        
    }
    
    

    public static function getAll(){
        
        $ci=&get_instance();
        $ci->load->database();
        
        $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
        if( ($owner)>0 ){
                
            $query="SELECT * FROM lm_Rfq WHERE utente = $owner ";
            
            $result =   $ci->db->query($query);
            $righe  =   $result->result('Rfqs_model');
        }

        return $righe;
        
    }
    
    
    public function caricaAzienda(){
        
       
        $query = $this->db->query("SELECT * FROM lm_users WHERE iduser='".$this->utente."'  LIMIT 1");
        $userinfo=$query->row();
        $this->azienda_rif=$userinfo->owner;
        
    }
    
    
    public function update($codice,$modello=null){
        
        if($modello==null){
            $modello=clone $this;
        }
        
        $this->db->where('codrfq',$codice);
        $this->db->update('lm_Rfq',$modello);
		
        
    }
    
    
    
    public function insert(){
        
        $this->utente=$_SESSION["LOGGEDIN"]["userid"];
        
        $object=clone $this;
        
        
        if( $this->codrfq==0 ){
            
            $status = $this->db->insert('lm_Rfq',$object);
            //print_r($status);
            $insert_id = $this->db->insert_id();
            
        }
        
        return $insert_id;
    }
    
    
    public static function get($codice=0){
        //echo $codice;
        $righe=array();
        
        $ci=&get_instance();
        $ci->load->database();
        
        $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
         
        if( $codice === 0 ){
            
            $righe[] = new Rfqs_model();
            
        }else{
            
            if( ($owner) ){
            
                if( ($codice)>0 ){
                
                    $query="SELECT * FROM lm_Rfq WHERE codrfq = '$codice' AND utente = $owner ";
                    
                }else{
                    
                    $query="SELECT * FROM lm_Rfq WHERE MD5(codrfq) = '$codice' AND utente = $owner ";
                    
                }
                
                $result=$ci->db->query($query);
                if($result->num_rows()>0){
                    $righe[]=$result->custom_row_object(0,'Rfqs_model');
                }else{
                    $righe=array("error"=>"Not found data!");
                }
               
                 
            }
            
        }
        
        return $righe;
    }
    
    
    
    public function delete(){
        
        $this->db->where('codrfq',$this->codrfq);
        $this->db->delete('lm_Rfq');
        
    }
    
    
    /**
    * Funzioni statistiche
    * 
    */
    public function statistichePreventivi(){
        
        $codicefornitore=$this->codrfq;
        
        $query="SELECT count(*) as totale FROM lm_preventivo WHERE utente=? and Rfqs=?";
        $result = $this->db->query($query,array($this->utente,$codicefornitore));
        $rows=$result->result_array();
        
        return $rows;
    }
    
    
    
    public function verificaAppartenenza($owner=null){
        
        $user=intval($_SESSION["LOGGEDIN"]["userid"]);
        if($this->utente == $user){

            if($owner==null){
                return true;
            }else{
                if( $owner == $this->azienda_rif ){
                    return true;
                }
            }

        }

        return false;
    }
    
    
    
    public function getInfoTabella(){
        
        if(isset($this->rag_sociale_codrfq)){
            return $this->rag_sociale_codrfq;
        }
        
        
        return $this->cognome_codrfq." ".$this->nome_codrfq;
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
     * Restituisce le informazioni sull'invio del preventivo
     * raccoglie e analizza tutti gli invvi del suddetto preventivio
     * 
     */
    public function infoInvio(){
        $query = $this->db->query('SELECT * FROM lm_send_document WHERE '
                    . ' preventivo=? ',
                    array($this->codrfq)
        );
		
        $dati=$query->result_array();		
		return array("numero_risultati"=>$query->num_rows(),"dati"=>$dati);
    }
   
    
}