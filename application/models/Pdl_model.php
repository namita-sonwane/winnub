<?php

/* 
 * ----------------------------------
 * 
 * 
 * 
 * ----------------------------------
 * 
 */

class Pdl_model extends CI_Model{
    
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
        
        //$this->caricaAzienda();
        
    }
    
 
	
	public static function getAll(){        
        $ci=&get_instance();
        $ci->load->database();
        
        $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
        if( ($owner)>0 ){
                
             $query="SELECT * FROM lm_pdl WHERE utente = $owner ";
            
            $result =   $ci->db->query($query);
            $righe  =   $result->result('Pdl_model');
        }

        return $righe;
        
    }
	
	public static function getAllRuoli(){        
        $ci=&get_instance();
        $ci->load->database();
        
        $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
        if( ($owner)>0 ){
                
             $query="SELECT * FROM lm_ruoli WHERE utente = $owner ";
            
            $result =   $ci->db->query($query);
            $righe  =   $result->result('Pdl_model');
        }

        return $righe;
        
    }
    
    
    
    // get single contatto
    public function getsingle($id){
          $this->db->SELECT('*');
          $this->db->from('lm_pdl');
          $this->db->where('id',$id);       
          $query = $this->db->get();
          $this->db->last_query();
          return $query->row();
    }
	
	 public function getsingleRuoli($id){
          $this->db->SELECT('*');
          $this->db->from('lm_ruoli');
          $this->db->where('id',$id);       
          $query = $this->db->get();
          $this->db->last_query();
          return $query->row();
    }


    
    
    public function insert(){
        
        $this->utente=$_SESSION["LOGGEDIN"]["userid"];
        
        $object=clone $this;
        
        
        if( $this->codcliente==0 ){
            
            $status = $this->db->insert('lm_pdl',$object);
            //print_r($status);
            $insert_id = $this->db->insert_id();
            
        }
        
        return $insert_id;
    }
	
	 public function insertRuoli(){
        
        $this->utente=$_SESSION["LOGGEDIN"]["userid"];
        
        $object=clone $this;
        
        
        if( $this->codcliente==0 ){
            
            $status = $this->db->insert('lm_ruoli',$object);
            //print_r($status);
            $insert_id = $this->db->insert_id();
            
        }
        
        return $insert_id;
    }
    
    
    /**
     * Cancella il cliente
     */
    public function delete($id){
  
		$this->db->where('id',$id);
		$this->db->delete('lm_pdl');
		return true;
        
    }
	
	     
    public function deleteRuoli($id){
  
		$this->db->where('id',$id);
		$this->db->delete('lm_ruoli');
		return true;
        
    }
    
    


    // update leads category
   public function update_pdl($taskid,$formdata){
        $this->db->where('id',$taskid);
        $this->db->update('lm_pdl',$formdata);
         $this->db->last_query();
    }
    /**
    * Statistiche preventivi sul clinete
    * 
    */
	
	 public function update_ruoli($taskid,$formdata){
        $this->db->where('id',$taskid);
        $this->db->update('lm_ruoli',$formdata);
         $this->db->last_query();
    }
 
    
}