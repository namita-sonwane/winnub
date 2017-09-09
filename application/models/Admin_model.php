<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_model extends User_model{
    
    
    
    
    
     public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
       
    }
    
    
    
    public function getInfoUsers(){
        
        
        $query=$this->db->query(" SELECT DISTINCT lm_users.iduser, "
                . " (SELECT SUM(totale) FROM lm_fatture_generate t WHERE t.utente = a.utente  ) as totale, "
                . " (SELECT foto FROM lm_user_profile WHERE lm_user_profile.user=a.utente ) as media ,"
                . " lm_users.username"
                . "  FROM  lm_fatture_generate a JOIN lm_users "
                . "  ON a.utente=lm_users.iduser"
                . "  WHERE  lm_users.owner=?  ",array($this->owner));
         
        
        return $query->result();
    }
    
    
    
    /**
     * Funzione di installazione boostrap dei dati
     * la funzione dovrebbe essere richiamata subito dopo
     * l'attivazione del profilo Admin al primo accesso
     * installa e configura le impostazioni utente Admin azienda
     * 
     */
    function installBusinessComponent(){
        
        
        $routine_query=array(
            
            "lm_modelli_prodotti"=>array(
                "codice_modello"=>null,
                "categoria"=>-1,
                "utente"=>$this->iduser,
                "nome"=>t("Prodotto-senza-nome"),
                "descrizione"=>"",
                "carattere_prodotto"=>"articolo"
                
            ),
            
            "lm_prodotti_azienda"=>array(
                "codiceprodotto"=>"%idprodotto",
                "azienda"=>$this->owner,
                "data_creazione"=>data("Y-m-d H:i:s"),
                "tipologia_prodotto"=>"articolo"
            ),
            
            "lm_types_listini"=>array(
                "types"=>null,
                "valore"=>0,
                "descrizione"=>t("Listino-base"),
                "owner"=>$this->owner
            ),
            ""
           
        );
        
        
        
    }
    
    /**
     * Lista ordini del modello user
     */       
    public function getOrdini(){
        
        $query = $this->db->get('lm_ordini WHERE 1');
        $datas=$query->result("Ordine_model");
        
        return $datas;
    }
    
    
    
    /**
     * Restituisce la lista prodotti apaprtenenti all'aziende
     * 
     * @return type
     */
    function getProdotti(){
         $query=$this->db->query("SELECT lb.* "
                 . " FROM lm_modelli_prodotti lb JOIN lm_prodotti_azienda la ON "
                 . " lb.codice_modello=la.codiceprodotto "
                 . "  WHERE  la.azienda=? ",array($this->owner));
         return $query;
    }
    
    
    /**
     *  Restituisce un gruppo di operazioni 
     * 
     * @param type $cosa
     * @param type $idrif
     * @param type $limit
     * @param type $select
     * @return type
     */
    function getMy($cosa,$idrif=null,$limit="",$select=""){
        
        $datas=array();
        
        $datas=parent::getMy($cosa,$idrif,$limit,$select);//chiamo il parent file
        
        addJS(array("public/js/admin.js"));
        //sovrascrive i metodi per admin...
        switch($cosa){
            
            case "preventivi":
                
                $q=$this->db->query("SELECT lm_preventivo.* FROM lm_preventivo JOIN lm_users "
                        . " ON lm_preventivo.utente=lm_users.iduser "
                        . "WHERE lm_users.owner = ? OR  $limit ",array($this->owner));
                
                $datas=$query->result("Preventivo_model");
                
            break;
            
            case "prodotti":
                
                if($idrif!=null)
                {
                    $query=$this->db->query("SELECT * FROM lm_modelli_prodotti WHERE codice = ? ",array($idrif));
                    $datas=$query->result("Prodotto_model");
                    
                }else{
                    
                    $query=$this->db->query("SELECT lb.* "
                 . " FROM lm_modelli_prodotti lb JOIN lm_prodotti_azienda la ON "
                 . " lb.codice_modello=la.codiceprodotto "
                 . "  WHERE  la.azienda=? ",array($this->owner));
                    $datas=$query->result("Prodotto_model");
                    
                }   
                
            break;
            
            case "ordini":
                
                $query=$this->db->query("SELECT * FROM lm_ordini JOIN lm_preventivo "
                        . "ON  lm_ordini.rif_preventivo=lm_preventivo.idpreventivo "
                        . "JOIN lm_user_profile ON lm_user_profile.user=lm_ordini.cliente   "
                        . " ");
               
                $datas=$query->result();
                
               
                
            break;
            
        }
        
        
        return $datas;
    }
    
    /**
     * DEPRECATED NOT USED
     * @return type
     */
    function getOrdiniAttivi(){
         $datas=array();
         $query=$this->db->query("SELECT * FROM lm_ordini JOIN lm_preventivo "
                        . "ON  lm_ordini.rif_preventivo=lm_preventivo.idpreventivo "
                        . "JOIN lm_user_profile ON lm_user_profile.user=lm_ordini.cliente   "
                        . " AND ");
               
         $datas=$query->result("Ordine_model");
         return $datas;
        
    }
    
    /**
     * Restituisce un Modello user dall'username
     * 
     * @param type $username
     * @return Object User_model
     */
    function getUserProfile($codice){
         $datas=array();
         $query=$this->db->query("SELECT * FROM lm_users JOIN lm_user_profile"
                 . " ON lm_user_profile.user=lm_users.iduser "
                 . " WHERE lm_users.iduser=?",array($codice));
               
         $datas=$query->result("User_model",0);
         
         return $datas[0];
    }
    
    
    
}