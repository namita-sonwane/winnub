<?php



class _Prodotto_model extends CI_Model{
    
    
     var $idProdotto=null;
     var $codice="";
     var $utente=0;
     var $nome="";
     var $descrizione="";
     var $foto="";
     var $classe_prodotto="";
     var $carattere_prodotto="";
     var $descrizione_tecnica="";
     var $isolamento_termico="";
     var $telaio="";
     var $foto_tecnica="";
     var $modello="";
     var $materiale="";
    
   public function __construct()
    {
       
       parent::__construct();
       
        if(isset($_SESSION["LOGGEDIN"])){
           $sess_user=$this->session->get_userdata('LOGGEDIN');
           $this->utente=$sess_user["LOGGEDIN"]["userid"];
        }
    }
    
   
    
    
    
    
    public function inserisci_prodotto(){
        
        
        $this->codice=$_POST['codice'];
        $this->nome=$_POST['nome'];
        $this->utente=$this->utente;//l'utente è restituito dalla sessione in automatico
        $this->descrizione=$_POST['descrizione'];
        $this->foto=$_POST['foto'];
        $this->classe_prodotto=$_POST['classe'];
        $this->carattere_prodotto=$_POST["carattereprodotto"];
        $this->descrizione_tecnica=$_POST['descrizione_tecnica'];
        $this->isolamento_termico=$_POST['isolamento_termico'];
        $this->telaio=$_POST['telaio'];
        $this->foto_tecnica=$_POST['foto_tecnica'];
        $this->modello=implode(",",$_POST['modello']);
        
        $this->materiale="";
        
        $this->db->insert('lm_prodotti', $this);
        
    }
    
    public function aggiorna_prodotto(){
        
        
        $this->codice=$_POST['codice'];
        $this->nome=$_POST['nome'];
        $this->descrizione=$_POST['descrizione'];
        $this->foto=$_POST['foto'];
        $this->classe_prodotto=$_POST['classe'];
        $this->carattere_prodotto=$_POST["carattereprodotto"];
        $this->descrizione_tecnica=$_POST['descrizione_tecnica'];
        $this->isolamento_termico=$_POST['isolamento_termico'];
        $this->telaio=$_POST['telaio'];
        $this->foto_tecnica=$_POST['foto_tecnica'];
        $this->modello=implode(",",$_POST['modello']);
       
        $this->materiale=$this->materiale;
         
        $this->db->update('lm_prodotti',$this,array('idProdotto' => $this->idProdotto));
        
    }
    
    
    function getColori($idcolore=null){
        
        
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
        
        
    }
    
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

                if($dati!=null){
                    return $dati;
                }
        }
        
        return null;
    }
    
    
    public function getAccessori(){
        
        $query=$this->db->get("lm_accessori");
        $datas = $query->result();
        
        return $datas;
    }
    
    
    
    
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
    }
    
   
    function getArticoloCarrello($modello,$profilo){
        
        $query=$this->db->query("SELECT lm_prodotti.*,lm_modelli_prodotti.foto as foto_modello,lm_modelli_prodotti.nome as nome_modello "
                . ", lm_costi_dimensioni.costo  FROM lm_prodotti,lm_modelli_prodotti,lm_costi_dimensioni  WHERE "              
                . " lm_prodotti.idProdotto=? AND "
                . " lm_modelli_prodotti.codice_modello=? AND"
                . " lm_costi_dimensioni.codice_modello = lm_modelli_prodotti.codice_modello ",
                array($profilo,$modello) );
        
        
        $datas = $query->result();
        
        
        return $datas[0];
        
    }
    
    
   
    
    
    function get_id($idp){
        
         $query=$this->db->query("SELECT * FROM lm_prodotti JOIN lm_costi_dimensioni "
                 . "ON lm_prodotti.idProdotto=lm_costi_dimensioni.codice_prodotto "
                 . ""
                 . "WHERE lm_prodotti.idProdotto=? ",array($idp) );
         //$datas=$query->result();//
         $datas = $query->result();
         //print_r($datas);
         return $datas;
    }
    
    
    public function get_modelli($categoria=null){
        
         if(($categoria!=null)){
                
                $query=$this->db->query("SELECT lm_modelli_prodotti.* FROM "
                . "lm_modelli_prodotti JOIN lm_categorie_prodotti "
                . "ON lm_categorie_prodotti.idcategoria = lm_modelli_prodotti.categoria "
                . "WHERE lm_categorie_prodotti.nome = ? AND lm_modelli_prodotti.carattere_prodotto IN ('articolo','entrambi') ",array($categoria));
                //$datas=$query->result();//
         
         }else{
             $query=$this->db->query("SELECT * FROM lm_modelli_prodotti WHERE lm_modelli_prodotti.carattere_prodotto IN ('articolo','entrambi')",array(""));
         }
         $datas = $query->result();
         
         
         
         return $datas;//mi restituisce i modelli delle finestre
        
    }
    
    public function getVarianti($prodotto=null){
        
        if(!isset($prodotto)){
            
            $query=$this->db->query("SELECT * "
                    . " FROM "
                    . " lm_modelli_prodotti "
                    . " "
                    . " WHERE "
                    . " lm_modelli_prodotti.carattere_prodotto IN ('variante','entrambi') "
                    . " AND lm_modelli_prodotti.utente=?",
                    array($this->utente));
            $datas = $query->result();
            
        }else{
            $query=$this->db->query("SELECT lm_modelli_prodotti.*,"
                    . " lm_varianti_prodotto.gruppo as gruppo_variante,"
                    . " lm_varianti_prodotto.metodo_prezzo as calcolo "
                    . " FROM "
                    . " lm_varianti_prodotto JOIN lm_modelli_prodotti "
                    . " ON lm_varianti_prodotto.variante=lm_modelli_prodotti.codice_modello "
                    . " WHERE "
                    . " lm_modelli_prodotti.carattere_prodotto IN ('variante','entrambi') "
                    . " AND lm_varianti_prodotto.codice_prodotto=? AND lm_modelli_prodotti.utente=?",
                    array($prodotto,$this->utente));
            $datas = $query->result();
        }
        return $datas;
    }
    
    public function colori_profilo($profilo){
        
    }
    
    
    
    public function getCostiModello($codice){
        
        $query=$this->db->query("SELECT * FROM "
                . "lm_modelli_prodotti JOIN lm_costi_dimensioni "
                . "ON lm_modelli_prodotti.codice_modello = lm_costi_dimensioni.codice_modello "
                . " WHERE lm_modelli_prodotti.codice_modello = ? ",array($codice));
         //$datas=$query->result();//
         $datas = $query->result();
         if(count($datas)>0){
          return $datas[0];//mi restituisce i modelli delle finestre
         }
        
        return null;
    }
    
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function getProdotto($id){
        
        $query=$this->db->query("SELECT * FROM lm_prodotti  "
           . "WHERE lm_prodotti.idProdotto=?  ",array($id) );
      
        //$datas=$query->result();//
        $datas = $query->result();
         
        if( count($datas)>0){
             return $datas[0];
        }
        
        return array("null");
    }
    
    
    
   /*
     * Mi restituisce la lista dei profili in base al materiale=>classe e modello=>porte,finestre,scorrevoli...
     * se passo solo pvc mi da tutti i profili in pvc per 
     * 
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
    
    
    
    
    
    public function getPrezziDimensioni($prodotto,$w,$h){
        
         $query=$this->db->query("SELECT * FROM "
                . " lm_costi_dimensioni "
                . " "
                . " WHERE lm_costi_dimensioni.codice_prodotto = ? AND largezza <= ? AND altezza <= ? ",array($prodotto,$w,$h));
         //$datas=$query->result();//
         $datas = $query->result();
         return $datas;
    }
    
    
    public function getGruppi(){
        
         $this->db->from("lm_categorie_prodotti");
         $this->db->where("owner",$this->utente);
         $query=$this->db->get();
         
         //$datas=$query->result();//
         $datas = $query->result_array();
         $gruppi=array();
         foreach($datas as $g){
             $gruppi[$g["gruppo"]][]=$g;
         }
         return $gruppi;
    }
    
    public function getGruppoProdotti(){
        
         $this->db->from("lm_categorie_prodotti");
         $this->db->where("owner",$this->utente);
         $query=$this->db->get();
         
         //$datas=$query->result();//
         $datas = $query->result_array();
         $gruppi=array();
         foreach($datas as $g){
             $gruppi[$g["gruppo"]][]=$g;
         }
         return $gruppi;
    }
    
}