<?php

/* 
 * ----------------------------------
 * 
 * Fornitori_model
 * 
 * ----------------------------------
 * 
 */

class Fornitori_model extends CI_Model{
    
    
    public $utente=null;
    public $nome_fornitori="";
    public $cognome_fornitori="";
    public $rag_sociale_fornitori="";
    public $comune="";
    public $provincia="";
    public $PIVA="";
    public $cod_fiscale="";
    public $note="";
    public $listino="";
    public $email="";
    public $indirizzo="";
    public $codfornitori=0;
	public $product_group=0;

    public $hidden=0;
    
    private $azienda_rif;
    
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
                
            $query="SELECT * FROM lm_profili_fornitori WHERE utente = $owner ";
            
            $result =   $ci->db->query($query);
            $righe  =   $result->result('Fornitori_model');
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
        
        $this->db->where('codfornitori',$codice);
        $this->db->update('lm_profili_fornitori',$modello);
        
    }
    
    
    
    public function insert(){
        
        $this->utente=$_SESSION["LOGGEDIN"]["userid"];
        
        $object=clone $this;
        
        
        if( $this->codfornitori==0 ){
            
            $status = $this->db->insert('lm_profili_fornitori',$object);
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
            
            $righe[] = new Fornitori_model();
            
        }else{
            
            if( ($owner) ){
            
                if( ($codice)>0 ){
                
                    $query="SELECT * FROM lm_profili_fornitori WHERE codfornitori = '$codice' AND utente = $owner ";
                    
                }else{
                    
                    $query="SELECT * FROM lm_profili_fornitori WHERE MD5(codfornitori) = '$codice' AND utente = $owner ";
                    
                }
                
                $result=$ci->db->query($query);
                if($result->num_rows()>0){
                    $righe[]=$result->custom_row_object(0,'Fornitori_model');
                }else{
                    $righe=array("error"=>"Not found data!");
                }
               
                 
            }
            
        }
        
        return $righe;
    }
    
    
    
    public function delete(){
        
        $this->db->where('codfornitori',$this->codfornitori);
        $this->db->delete('lm_profili_fornitori');
        
    }
    
    
    /**
    * Funzioni statistiche
    * 
    */
    public function statistichePreventivi(){
        
        $codicefornitore=$this->codfornitori;
        
        $query="SELECT count(*) as totale FROM lm_preventivo WHERE utente=? and fornitori=?";
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
        
        if(isset($this->rag_sociale_codfornitori)){
            return $this->rag_sociale_codfornitori;
        }
        
        
        return $this->cognome_codfornitori." ".$this->nome_codfornitori;
    }
    
    
   
    
}