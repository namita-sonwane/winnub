<?php

/* 
 * ----------------------------------
 * 
 * 
 * 
 * ----------------------------------
 * 
 */

class Cliente_model extends CI_Model{
    
    public $codcliente;
     
    public $utente=null;
    public $nome_cliente="";
    public $cognome_cliente="";
    public $rag_sociale_cliente="";
    public $comune="";
    public $provincia="";
    public $PIVA="";
    public $cod_fiscale="";
    public $note="";
    public $listino="";
    public $email="";
    public $indirizzo="";
    
   

    public $hidden=0;
    
    private $azienda_rif;
    
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
        
        $this->caricaAzienda();
        
    }
    
    
    	
    public function getAnaluseCustomerInfo($client_id){

            $utente = intval($_SESSION["LOGGEDIN"]["userid"]);				
            $sql="SELECT nome_cliente,rag_sociale_cliente FROM lm_profili_clienti WHERE codcliente = ".$client_id." ";
            $query = $this->db->query($sql);
            $rows = $query->result();
            return $rows;
    }
    
    
    
    public function NomeCompleto(){
        
        return $this->rag_sociale_cliente;
        
    }
    
    
    public static function getAll(){
        
        $ci=&get_instance();
        $ci->load->database();
        
        $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
        if( ($owner)>0 ){
                
            $query="SELECT * FROM lm_profili_clienti WHERE utente = $owner ";
            
            $result =   $ci->db->query($query);
            $righe  =   $result->result('Cliente_model');
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
        
        $this->db->where('codcliente',$codice);
        $this->db->update('lm_profili_clienti',$modello);
        
    }
    
    
    
    public function insert(){
        
        $this->utente=$_SESSION["LOGGEDIN"]["userid"];
        
        $object=clone $this;
        
        
        if( $this->codcliente==0 ){
            
            $status = $this->db->insert('lm_profili_clienti',$object);
            //print_r($status);
            $insert_id = $this->db->insert_id();
            
        }
        
        return $insert_id;
    }
    
    
    public static function get($codice=0){
        
        $righe=array();
        
        $ci=&get_instance();
        $ci->load->database();
        
        $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
         
        if( $codice === 0 ){
            
            $righe[]=new Cliente_model();
            
        }else{
            
            if( ($owner) ){
                
                if( ($codice)>0 ){
                
                    $query="SELECT * FROM lm_profili_clienti WHERE codcliente = '$codice' AND utente = $owner ";
                    
                }else{
                    
                    $query="SELECT * FROM lm_profili_clienti WHERE MD5(codcliente) = '$codice' AND utente = $owner  ";
                    
                }
                
                
                if($query){
                
                    $result=$ci->db->query($query);
                    if($result->num_rows()>0){
                        $righe[]=$result->custom_row_object(0,'Cliente_model');
                    }else{

                        $righe=array("error"=>"Not found data!");


                    }
                }
                 
            }
            
        }
        
        return $righe;
    }
    
    
    /**
     * Cancella il cliente
     */
    public function delete(){
        
        
        /*
        $this->db->where('codcliente',$this->codcliente);
        $this->db->delete('lm_profili_clienti');
        
        */
        
        if( $this->codcliente>0 ){
            
            $x=(($this->PIVA!=null)?$this->PIVA:$this->cod_fiscale);
            $data=array(
                "cliente"=>$this->codcliente,
                "data_r"=>date("Y-m-d h:i:s"),
                "modello"=>json_encode($this),
                "vat_key"=>$x
            );
            
            $status = $this->db->insert('_removed_clienti',$data);
            //print_r($status);
            
            $this->db->where('codcliente',$this->codcliente);
            $this->db->delete('lm_profili_clienti');
            return true;
        }
        
        
         return false;
    }
    
    
    /**
    * Statistiche preventivi sul clinete
    * 
    */
    public function statistichePreventivi(){
        
        $codicecliente=$this->codcliente;
        
        $query="SELECT count(*), utente as totale FROM lm_preventivo WHERE utente=? and cliente=?";
        $result = $this->db->query($query,array($this->utente,$codicecliente));
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
    
    
    public function utenteEsistente(){
        
        
            
    }
    
    
    
    public function getInfoTabella(){
        
        if(isset($this->rag_sociale_cliente)){
            return $this->rag_sociale_cliente;
        }
        
        
        return $this->cognome_cliente." ".$this->nome_cliente;
    }
    
    
   
    
}