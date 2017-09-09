<?php

/* 
 * ----------------------------------
 * 
 * Purchases_model
 * 
 * ----------------------------------
 * 
 */

class Purchases_model extends CI_Model{
    
    public $purchase_id=0;
    public $utente=null;
    public $purchase_category="";
    public $purchase_start_date="";
    public $purchase_invoice="";
    public $purchase_taxable="";
    public $purchase_vat="";
    public $purchase_total=0;
    public $purchase_reg_file="";
    public $purchase_balance_date="";
    
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
                
            $query="SELECT * FROM lm_purchases WHERE utente = $owner ";
            
            $result =   $ci->db->query($query);
            $righe  =   $result->result('Purchases_model');
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
        
        $this->db->where('purchase_id',$codice);
        $this->db->update('lm_purchases',$modello);
		
        
    }
    
    
    
    public function insert(){
        
        $this->utente=$_SESSION["LOGGEDIN"]["userid"];
        
        $object=clone $this;
        
        
        if( $this->purchase_id==0 ){
            
            $status = $this->db->insert('lm_purchases',$object);
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
            
            $righe[] = new Purchases_model();
            
        }else{
            
            if( ($owner) ){
            
                if( ($codice)>0 ){
                
                    $query="SELECT * FROM lm_purchases WHERE purchase_id = '$codice' AND utente = $owner ";
                    
                }else{
                    
                    $query="SELECT * FROM lm_purchases WHERE MD5(purchase_id) = '$codice' AND utente = $owner ";
                    
                }
                
                $result=$ci->db->query($query);
                if($result->num_rows()>0){
                    $righe[]=$result->custom_row_object(0,'Purchases_model');
                }else{
                    $righe=array("error"=>"Not found data!");
                }
               
                 
            }
            
        }
        
        return $righe;
    }
    
    
    
    public function delete(){
        
        $this->db->where('purchase_id',$this->purchase_id);
        $this->db->delete('lm_purchases');
        
    }
    
    
    /**
    * Funzioni statistiche
    * 
    */
    public function statistichePreventivi(){
        
        $codicefornitore=$this->purchase_id;
        
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
        
        if(isset($this->rag_sociale_purchase_id)){
            return $this->rag_sociale_purchase_id;
        }
        
        
        return $this->cognome_purchase_id." ".$this->nome_purchase_id;
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
                    array($this->purchase_id)
        );
		
        $dati=$query->result_array();		
		return array("numero_risultati"=>$query->num_rows(),"dati"=>$dati);
    }
	
	public function get_monthly_totals($theMonth)
	{		
		$sql= "SELECT DATE_FORMAT(purchase_start_date, '%m') AS Month, SUM(purchase_total) AS Total
		FROM lm_purchases WHERE DATE_FORMAT(purchase_start_date, '%m') = ".$theMonth."  GROUP BY DATE_FORMAT(purchase_start_date, '%m')";
		$query = $this->db->query($sql);
		return $query->result()[0];
	}
	
	public function get_category_totals($category)
	{		
		$sql= "SELECT SUM(purchase_total) AS Total
		FROM lm_purchases WHERE purchase_category = '".$category."'";
		$query = $this->db->query($sql);
		return $query->result()[0];
	}
	public function get_purchase_category()
	{
		$utente=intval($_SESSION["LOGGEDIN"]["userid"]);
		$sql="SELECT * FROM lm_purchase_category WHERE utente=".$utente." ";
        $query = $this->db->query($sql);
        $rows = $query->result();        
        return $rows;
	}
	public function process_product_category($cat_name)
	{
		$utente = intval($_SESSION["LOGGEDIN"]["userid"]);
		$sql="SELECT purchase_category_id FROM lm_purchase_category WHERE utente=".$utente." AND purchase_category_name = '".$cat_name."' ";
        $query = $this->db->query($sql);
        $rows = $query->result();   		
		if(count($rows) == 0)
		{
			$data = array('utente'=>$utente,'purchase_category_name'=>$cat_name);
			var_dump($query);
			$purchase_category_id = $this->db->insert('lm_purchase_category',$data);			
			$purchase_category_id = $this->db->insert_id();


		}
		else
		{			
			$purchase_category_id = $rows[0]->purchase_category_id;
		}
        return $purchase_category_id;
	}
	
	public function get_category_sum_total()
	{
		$utente = intval($_SESSION["LOGGEDIN"]["userid"]);
		$sql="SELECT SUM(purchase_total) as total,pc.purchase_category_id,pc.purchase_category_name FROM lm_purchases as pr INNER JOIN lm_purchase_category as pc on pr.purchase_category = pc.purchase_category_id WHERE pr.utente = ".$utente." group by pr.purchase_category order by pc.purchase_category_id ASC";
        $query = $this->db->query($sql);
        $rows = $query->result();
        return $rows;
	}
	

}