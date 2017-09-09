<?php



class Prodotto_model extends CI_Model{
    
    
     
   var $codice_modello="";
   var $categoria="";
   var $utente=0;
   var $nome="";
   var $descrizione="";
   var $descrizione_tecnica="";
   var $foto="";
   var $materiale="";
   var $codice_interno="";
   
   var $raggruppamento="";
   
   var $min_fatt="";
   var $carattere_prodotto="";
   var $modello="";
   
   var $min_height=0;
   var $min_width=0;
   var $prezzo_mq=0;
   var $prezzo_fisso=0;
   
   var $prezzo_m_lineare=0;
   var $prezzo_funzionale="";
   
   var $azienda;
   var $iva;
   
   var $costi;
   
    
   public function __construct()
    {
       
       parent::__construct();
       
        $this->verificaAppartenenza();
        
        if($this->codice_modello>0){
            
            
            $infomisure=$this->getCostiModello();
            
            if(count($infomisure)>0){
                $infomisure=$infomisure[0];
               
                $this->min_height=$infomisure->altezza;
                $this->min_width=$infomisure->larghezza;
                $this->prezzo_mq=$infomisure->costo;
                $this->prezzo_fisso=$infomisure->importo_unitario;
                $this->prezzo_m_lineare=$infomisure->prezzo_m_lineare;
                $this->prezzo_funzionale=$infomisure->prezzo_funzionale;
            }
            
            $costib=$this->getCostiBaseModello();
            
            if($costib){
                $costib=$costib[0];
                $this->costi=array(
                    
                    "costo"=>$costib->costo,
                    "prezzo_m_lineare"=>$costib->prezzo_m_lineare,
                    "prezzo_funzionale"=>$costib->prezzo_funzionale,
                    "importo_unitario"=>$costib->importo_unitario,
                    "costo_min_fatturabile"=>$costib->costo_min_fatturabile
                        
                );
            }
            
            
         
        }
        
        
    }
    
    
    /*
     * Attenzione questo metodo stabilisce i permessi a livello sessione per il prodotto
     * come giusto dovrebbe assegnare il prodotto con una select verso prodotti azienda
     * DA FERIFICARNE IL COMPORTAMENTO
     */
    public function verificaAppartenenza(){
        
            $sess_user=$this->session->get_userdata('LOGGEDIN');
            $this->utente=$sess_user["LOGGEDIN"]["userid"];
            if(isset($sess_user["LOGGEDIN"]["business"])){
                
                $this->azienda=$sess_user["LOGGEDIN"]["business"];
                 
                
            }
            
         
    }
    
    public function load($codice){
        
        $query=$this->db->query("SELECT * FROM lm_modelli_prodotti"
                        . " WHERE codice_modello=? "
                        . "  ",array($codice));
        
        $prodotto=$query->row(0,"Prodotto_model");
        
        return    $prodotto; 
    }
    
    
    public function getFoto(){
        if(!empty($this->foto)){
            return $this->foto;
        }
        
        return "http://app.winnub.com/public/img/noimage.jpg";
        
    }



    
    public function salva($model){
        
        if($this->codice_modello==0){
            
            $this->db->insert("lm_modelli_prodotti",$model);
            $idprodotto=$this->db->insert_id();
            
            $this->codice_modello=$idprodotto;
            $dat=array(
                "codiceprodotto"=>$idprodotto,
                "azienda"=>$this->user->owner,
                "data_creazione"=>date("Y-m-d h:i:s"),
                "tipologia_prodotto"=>$model["carattere_prodotto"]
            );

            
            $this->db->insert("lm_prodotti_azienda",$dat);
           
        }else{
            
            $this->db->where('codice_modello', $this->codice_modello);
            $this->db->update("lm_modelli_prodotti",$model);
            $idprodotto=$this->codice_modello;
            
            $this->db->where('codiceprodotto', $this->codice_modello);
            $this->db->update("lm_prodotti_azienda",array("data_modifica"=>date("Y-m-d H:i:s")));
            
            
        }
        
        return $idprodotto;
    }
    
    public function getLarghezza(){
        
       return $this->min_width;
    }
    public function getAltezza(){
       
       return $this->min_height; 
    }
   
    
    public function registraCategoria($datas=null,$codice=0){
        
         $params=array(
                "nome"=>        url_title(strtolower($datas["nomecategoria"])),
                "valore"=>      $datas["nomecategoria"],
                "descrizione"=>  $datas["descrizione"],
                "foto"=>        $datas["fotourl"],
                "gruppo"=>      ($datas["gruppo"]),
                "ordine"=>0     ,
                "azienda"=>     $this->azienda
         );
         
        
         if($codice==0){
             
            $params["owner"]=$this->utente;
            
            
            $this->db->insert('lm_categorie_prodotti',$params);
            
         }else{
            
            //verifico se la categoria mi appartiene
            if($this->verificaCategoria($codice)){
                $this->db->where("idcategoria",$codice);
                $this->db->update('lm_categorie_prodotti',$params," idcategoria = $codice AND owner= ".$this->utente);
            }
         }
        
         
         
    }
    
    /**
     * Restituisce il numero di prodotti presenti in questa categoria
     * @param type $codice
     */
    public function getNumberProductCategory($codice){
        
        
        if($codice>0){
           
            $query=$this->db->get_where(" lm_modelli_prodotti ",
                    array("categoria"=>$codice
                        ));
        }
        
        
        
        return $query->num_rows();
    }

    
    public function getNameCategory(){
        
       $query=$this->db->get_where("lm_categorie_prodotti",array("idcategoria"=>$this->categoria));
       return $query->row(0);
    }


    /**
     *  NON USATO
     *
    public function inserisci_prodotto(){
        
        
        $this->codice_modello=$_POST['codice_modello'];
        $this->nome=$_POST['nome'];
        $this->utente=$this->utente;//l'utente è restituito dalla sessione in automatico
        $this->descrizione=$_POST['descrizione'];
        $this->descrizione_tecnica=$_POST['descrizione_tecnica'];
        
        $this->foto=$_POST['foto'];
        $this->classe_prodotto=$_POST['classe'];
        $this->carattere_prodotto=$_POST["carattereprodotto"];
        
        $this->isolamento_termico=$_POST['isolamento_termico'];
        $this->telaio=$_POST['telaio'];
        $this->foto_tecnica=$_POST['foto_tecnica'];
        
        
        $this->min_fatt=$_POST["minimo_fatt"];
        
        $this->db->insert('lm_modelli_prodotti', $this);
        
    }
    */
    
    /**
     * 
     */
    public function aggiorna_prodotto(){
        
        
        $this->codice=              $_POST['codice_modello'];
        $this->nome=                $_POST['nome'];
        $this->descrizione=         $_POST['descrizione'];
        $this->foto=                strip_tags($_POST['foto']);
        $this->classe_prodotto=     $_POST['classe'];
        $this->carattere_prodotto=  $_POST["carattereprodotto"];
        $this->descrizione_tecnica= $_POST['descrizione_tecnica'];

        $this->foto_tecnica=        $_POST['foto_tecnica'];
        
        $this->db->update('lm_modelli_prodotti',$this,array('codice_modello' => $this->idProdotto));
    }
    
    
    /* IN DISUSO ----> function getColori($idcolore=null){
        
        
        if($idcolore==null){
            
            $query=$this->db->get("lm_colorazioni_prodotti");
        }else if(is_int($idcolore)){
            
            $query=$this->db->get_where("lm_colorazioni_prodotti",array("idcolore"=>$idcolore));
        }else{
             $query=$this->db->get_where("lm_colorazioni_prodotti",array("classe"=>$idcolore));
        }
        
        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        
        return null;
        
        
    }*/
    
    
    
   /**
     * Restituisce una lista di accessori dall'insieme di id
     * @param Mixed array $accessori
     * @return Mixed array
     */
    public function findAccessori($accessori){
       
        if(is_array($accessori)){
            
            foreach($accessori as $k=>$v){
                if($v==1){
                    $chiavi[]=$k;
                }
            }
            
            
            if(isset($chiavi)){
                $query = $this->db->query('SELECT * FROM lm_accessori WHERE idaccessorio IN ('.join(",",$chiavi).') ',
                        array());
                $dati = $query->custom_result_object('Accessorio_model');

                if($dati!=null){
                    return $dati;
                }
            }
        }else if( is_string($accessori) && $accessori!="" ){
             
             $query = $this->db->query('SELECT * FROM lm_accessori WHERE idaccessorio IN ('.$accessori.') ',
                        array());
                $dati = $query->custom_result_object('Accessorio_model');

                if( $dati!= null){
                    return $dati;
                }
        }
        
        return null;
    }
    
    
    /**
     * 
     * @param type $cod
     * @return type
     */
    public function getServizi($cod=null){
        
        if( $cod!=null ){
            $ww="nome LIKE '%$cod%' ";
            $this->db->where($ww);
        }
        
        $this->db->where("carattere_prodotto = 'servizio' ");
        $query=$this->db->get("lm_modelli_prodotti");
        
        $datas = $query->result();
        
        return $datas;
    }
    
    /*
    
    public function getAccessori(){
        
        $query=$this->db->get("lm_accessori");
        $datas = $query->result();
        
        return $datas;
    }*/
    
    
    
    /** IN DISUSO
    function getVetri($id=0){
        
        if($id==0){
         $query=$this->db->query(""
                 . "SELECT * FROM lm_modelli_vetri ",
                array() );
        
         if($query->num_rows()>0){
            $datas = $query->result();
        
        
            return $datas;
        
         }
        }else{
            
            $query=$this->db->query(""
                 . "SELECT * FROM lm_modelli_vetri WHERE idVetro=?",
                array($id) );
            if($query->num_rows()>0){
                $datas = $query->result();

                
                return $datas[0];
        
            }
        }
        
         return null;
    }*/
    
   
    /**
     * 
     * @param type $modello
     * @return type
     */
    function getArticoloCarrello($modello){
        
        if($modello>0){
            
            $query=$this->db->query("SELECT *  FROM lm_modelli_prodotti,lm_costi_dimensioni  WHERE "              
                    . "  "
                    . " lm_modelli_prodotti.codice_modello= ? AND"
                    . " lm_costi_dimensioni.codice_modello = lm_modelli_prodotti.codice_modello ",

                    array($modello) );


            $datas = $query->row(0,'Prodotto_model');
            
            return $datas;

           
        }
        
        
        return null;
        
    }
    
    
   
    
    /**
     * 
     * @param type $idp
     * @return type
     */
    public function get_id($idp,$CRIPTED=FALSE){
        
        $chu="lm_modelli_prodotti.codice_modello";
        if($CRIPTED){
            $chu=" MD5(lm_modelli_prodotti.codice_modello)";
        }
        
         $query=$this->db->query("SELECT * FROM lm_modelli_prodotti JOIN lm_costi_dimensioni "
                 . " ON lm_modelli_prodotti.codice_modello=lm_costi_dimensioni.codice_modello "
                 . " "
                 . " WHERE $chu =? ",array($idp) );
         
         //$datas=$query->result();//
         $datas = $query->result('Prodotto_model');
         //print_r($datas);
         return $datas;
    }
    
    
    
    
    /**
     * 
     * @param type $categoria
     * @return type
     */
    public function get_modelli($categoria=null){
        
         if(($categoria!=null)){
                
                $query=$this->db->query("SELECT lm_modelli_prodotti.* FROM "
                . " lm_prodotti_azienda JOIN lm_modelli_prodotti ON lm_prodotti_azienda.codiceprodotto=lm_modelli_prodotti.codice_modello "
                . " JOIN lm_categorie_prodotti ON lm_categorie_prodotti.idcategoria = lm_modelli_prodotti.categoria "
                . " WHERE lm_categorie_prodotti.nome = ? AND lm_modelli_prodotti.carattere_prodotto IN ('articolo','entrambi') "
                . " AND "
                . " lm_prodotti_azienda.azienda = ? "
                ." ",array($categoria,$this->azienda));
                //$datas=$query->result();//
                
                $prodottinew="SELECT * FROM ";
         
         }else{
             $query=$this->db->query("SELECT * FROM lm_modelli_prodotti "
                     . "WHERE lm_modelli_prodotti.carattere_prodotto "
                     . "IN ('articolo','entrambi')",array(""));
         }
         $datas = $query->result();
         
         
         
         return $datas;//mi restituisce i modelli delle finestre
        
    }
    
    
    
    
    /**
     * 
     * @param type $prodotto
     * @return type
     */
    public function getVarianti($prodotto=null){
        
        
        if(!isset($prodotto)){
            
            $query=$this->db->query("SELECT "
                    . " "
                    . " lm_modelli_prodotti.* "
                    . " FROM "
                    . " lm_prodotti_azienda JOIN lm_modelli_prodotti "
                    . " ON lm_prodotti_azienda.codiceprodotto=lm_modelli_prodotti.codice_modello  "
                    . " WHERE "
                    . " lm_modelli_prodotti.carattere_prodotto IN ('variante','entrambi') "
                    . " AND lm_prodotti_azienda.azienda = ? ",
                    array($this->azienda));
            
            $datas = $query->result();
            
        }else{
            //metodo di "calcolo" specifica come si comporta la variante con il prezzo del prodotto selezionato precedentemente
            $query=$this->db->query("SELECT lm_modelli_prodotti.*,"
                    . " lm_varianti_prodotto.gruppo as gruppo_variante,"
                    . " lm_varianti_prodotto.metodo_prezzo as calcolo "
                    . " FROM "
                    . " lm_varianti_prodotto JOIN lm_modelli_prodotti  "
                    . " ON lm_varianti_prodotto.variante = lm_modelli_prodotti.codice_modello "
                    . " WHERE "
                    . " lm_modelli_prodotti.carattere_prodotto IN ('variante','entrambi') "
                    . " AND lm_varianti_prodotto.codice_prodotto = ? ",
                    array($prodotto));
            
            $datas = $query->result();
            
        }
        
        return $datas;
    }
    
    public function aggiornaCostiModello($costiprodotto){
        
        //controllo se esistono i costi
        $costi=$this->getCostiModello($this->codice_modello);
        
        if( count($costi) > 0 ){
            
            $this->db->where('codice_modello',$this->codice_modello);
            $this->db->update("lm_costi_dimensioni",$costiprodotto);
           
            
        }else{

            $costiprodotto["codice_modello"]=$this->codice_modello;
            $this->db->insert("lm_costi_dimensioni",$costiprodotto);

        }
        
                        
    }
    
    
    /*
     * Effettua l'aggiornamento sulla tabella lm_costi_base
     */
    public function aggiornaCostiBaseModello($modello){
        
        if($this->codice_modello>0){
            //controllo se esistono i costi
            $costi=$this->getCostiBaseModello($this->codice_modello);

            if( count($costi) > 0 ){

                $this->db->where('codice_modello',$this->codice_modello);
                $this->db->update("lm_costi_base",$modello);


            }else{
                
                    $modello["codice_modello"]=$this->codice_modello;
                    $this->db->insert("lm_costi_base",$modello);
                
            }

        }    
    }
    
    
    
    
    /**
     * 
     * @param type $codice
     * @return type
     */
    public function getCostiModello($codice=null){
        
        if($codice==null){
            $codice=$this->codice_modello;
        }
        
        $query=$this->db->query("SELECT * FROM "
                . " lm_modelli_prodotti JOIN lm_costi_dimensioni "
                . " ON lm_modelli_prodotti.codice_modello = lm_costi_dimensioni.codice_modello "
                . " WHERE lm_modelli_prodotti.codice_modello = ? ",array($codice));
        
         //$datas=$query->result();//
         $datas = $query->result();
         
         
         return $datas;
    }
    
    
     /**
     * 
     * @param type $codice
     * @return type
     */
    public function getCostiBaseModello($codice=null){
        
        if($codice==null){
            $codice=$this->codice_modello;
        }
        
        $query=$this->db->query("SELECT * FROM "
                . " lm_modelli_prodotti JOIN lm_costi_base "
                . " ON lm_modelli_prodotti.codice_modello = lm_costi_base.codice_modello "
                . " WHERE lm_modelli_prodotti.codice_modello = ? ",array($codice));
        
         //$datas=$query->result();//
         $datas = $query->result();
         
         
         return $datas;
    }
    
    
    
    
    /**
     * 
     * @param type $id
     * @return Prodotto_model
     
    public function getProdotto($id){
        
        $query=$this->db->query("SELECT * FROM lm_prodotti  "
           . "WHERE lm_prodotti.idProdotto=?  ",array($id) );
      
        //$datas=$query->result();//
        $datas = $query->custom_result_object('Prodotto_model');
         
        return $datas;
        
       
    }
    */
    
    
    /**
     * 
     * Restituisce la lista dei profili in base al materiale=>classe e modello=>porte,finestre,scorrevoli...
     * se passo solo pvc mi da tutti i profili in pvc per 
     * 
     * @param type $classe_materiale
     * @param type $modello
     * @return type
     */
    public function get_profilo($classe_materiale,$modello=null){
        
         if( $modello!=null ){
             
              $query=$this->db->query("SELECT * FROM lm_prodotti "
                 . "WHERE lm_prodotti.classe_prodotto=? AND "
                      . "FIND_IN_SET(?,lm_prodotti.modello) ",array($classe_materiale,$modello));
              
         }else{
        
            $query=$this->db->query("SELECT * FROM lm_prodotti "
                 . "WHERE lm_prodotti.classe_prodotto=? ",array($classe_materiale));
         }
         
         //$datas=$query->result();//
         $datas = $query->result();
         
         return $datas;
    }
    
    
    
    
    /**
     * 
     * @param type $prodotto
     * @param type $w
     * @param type $h
     * 
     * @return Array or Object
     */
    public function getPrezziDimensioni($prodotto,$w,$h){
        
         if($prodotto==null && $w==null && $h==nukk){
             $query=$this->db->query("SELECT * FROM "
                . " lm_costi_dimensioni "
                . " "
                . " WHERE lm_costi_dimensioni.codice_prodotto = ?  ",array($this->modello));
            //$datas=$query->result();//
            $datas = $query->result_array();
         }else{
        
         $query=$this->db->query("SELECT * FROM "
                . " lm_costi_dimensioni "
                . " "
                . " WHERE lm_costi_dimensioni.codice_prodotto = ? AND largezza <= ? AND altezza <= ? ",array($prodotto,$w,$h));
         //$datas=$query->result();//
         $datas = $query->result();
         }
         
         return $datas;
    }
    
    
    /**
     * Restituisce i gruppi di prodotto per l'utente loggato
     * 
     * @return Array
     */
    public function getGruppi(){
        
         if($this->azienda>0){
            $cosa=(" azienda = ".$this->azienda." OR owner=-1 ");

            $this->db->from("lm_categorie_prodotti");
            
            $this->db->where($cosa);

            $query=$this->db->get();

            //$datas=$query->result();//
            $datas = $query->result_array();
            if(count($datas)>0){
                   $gruppi=array();
                   foreach($datas as $g){
                       if($g["foto"]==null){
                           $g["foto"]="/public/img/noimage.jpg";
                       }
                       $gruppi[$g["gruppo"]][]=$g;
                   }
            }else{
                   $cosa=("owner = ".$this->utente." OR owner = -1");
                   $this->db->from("lm_categorie_prodotti");
                   $this->db->where($cosa);

                   $query=$this->db->get();
                   $datas = $query->result_array();
                   $gruppi=array();
                   foreach($datas as $g){
                       
                        if($g["foto"]==null){
                            $g["foto"]="/public/img/noimage.jpg";
                        }
                        $gruppi[$g["gruppo"]][]=$g;
                        
                   }
            }
            
         }else{
             redirect("/");
         }
         
         return $gruppi;
    }
    
    
    /**
     * 
     * @return type
     */
    public function getGruppoProdotti(){
        
         $this->db->from("lm_categorie_prodotti");
         $this->db->where(" azienda = ".$this->azienda." OR owner = -1");
         $query=$this->db->get();
         
         //$datas=$query->result();//
         $datas = $query->result_array();
         $gruppi=array();
         foreach($datas as $g){
             $gruppi[$g["gruppo"]][]=$g;
         }
         return $gruppi;
    }
    
    
    /**
     * 
     * @param type $categoria
     * @return boolean
     */
    public function verificaCategoria($categoria){
        
        if($categoria ==  0) return false;
        if($categoria   ==  NULL) return false;
        
        $condition=array(" owner = ".$this->utente." OR owner = -1 OR azienda=".$this->azienda,"idcategoria"=>$categoria);
        
        $this->db->where($condition);
        
        $count=$this->db->count_all_results("lm_categorie_prodotti");
        
        if($count>0){
            return true;
        }
        
        return false;
    }
    
    
    public function removeCategoria($codice){
        
        if($this->verificaCategoria($codice)){
            
            $this->db->delete("lm_categorie_prodotti",array('idcategoria' => $codice));
            
             return TRUE;
        }
        
        return FALSE;
    }
    
    
    /** 
     * 
     * metodo di utilità 
     * restitusice una lista di varianti del prodotto
     * richiede codice modello come classe definito
     * 
    **/
    public function getArrayVarianti(){
        
        $condition=array("codice_prodotto"=>$this->codice_modello);
        
        $this->db->where($condition);
        
        $q=$this->db->get("lm_varianti_prodotto");
        
        $var=$q->result_array();
        $obj=array();
        if(count($var)>0){
            foreach($var as $v){
                $obj[$v["idvariante"]]=$v;
            }
        }
        return $obj;
    }
    
}