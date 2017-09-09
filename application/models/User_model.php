<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_model extends CI_Model{
    
    
    
    const USER_PRIVATO=1;
    const USER_PROFESSIONISTA=2;
    const USER_ADMIN=0;
    

    var $fatturazione;
    var $profile;
    var $nome_model;
    var $iduser;
   
    var $username;
    var $email;
    var $status;
    var $type;
    var $user_model;
    
    var $owner; //il mio codice azienda per prodotti e categorie
    
    var $BUSINESS;
    
    
    
    
    function getTimelineLog($limit="LIMIT 12"){
        
   
        $query = $this->db->query("SELECT * FROM lm_timeline_log WHERE user = ?  $limit ",array($this->iduser));
        
        
        
        $logs=$query->result_array();
        
        
        return $logs;
        
    }
    
    function isGuest(){
        return ($this->owner == null);
    }
    
    
    function risolviRuolo($codice=null){
        
        if($codice==null){
            $codice=$this->user->type;
        }
        
        switch ($codice){
            case 1:
                return t("Azienda");
            case 2:
                return t("Rivenditore");
            case 3:
                return t("Costruttore");
            case 4:
                return t("Showroom");
           
            case 4:
                return t("Agente");
            
            default :
                return t("User");
        }
        
    }
    
    /**
     * Verifica i permessi utente in base alla sezione di azione, quindi il controller e la tipologia di azione da compiere
     * esempio: scrittura, lettura.
     * @param String $controller -> nome del controller
     * @param Char $azione -> r(read) w(write)
     */
    public function verificaPermessi($controller,$azione){
        
        //devo leggere la mappatura dei permessi utente assegnata
        //dall'azienda.
        if($this->isAdmin()){//l'azienda ha tutti i permessi
            return true;
        }
        
        
        return true;
        
    }
    
    
    public function getNotification(){
        
        //$notifica[]=array();
        
        $this->db->where('user',$this->iduser);
        $query=$this->db->get("lm_message");
        $cc=count($query);
        if($cc>1){
            $notifica[]=array(
                "id"=>0,
                'message'=>"Hai (".$cc.") Nuovi messaggi <a href='#' class='btn btn-default btn-sm btn-inverse pull-right'>Apri</a>",
                'type'=>"notification",
                'url'=>""
            );
        }
        //$notifica[]=array("id"=>0,'message'=>"Hai (".(rand(0,100)).") Nuovi messaggi ",'type'=>"info");
        //$notifica[]=array("id"=>0,'message'=>" Nuovi preventivi da confermare ",'type'=>"danger");
        
        
        return $notifica;
        
    }
    
    public function getDenominazioneAzienda(){
        
        $this->db->where('codazienda',$this->owner);
        $query=$this->db->get("lm_azienda");
        $azienda=$query->result_array();
        
        return $azienda[0]["nome"];
        
    }
    
     
    public function aggiorna_intestazione($model){
        
        //prelevo i dati dell'intestazione
        $this->db->where('user',$this->iduser);
        $query=$this->db->get("lm_modello_intestazione");
        if($query->num_rows()>0){
            
           $this->db->where('user',$this->iduser);
           $this->db->update("lm_modello_intestazione",$model);
            
        }else{
            
           $model["user"]=$this->iduser;
           
           $this->db->set($model);
           $this->db->insert("lm_modello_intestazione");
        }
        
    }
    
    public function getStatistichePreventivi($time=null,$onlyuser=FALSE){
        
        $controlla[]=$this->owner;
        $isuser="";
        
        if(!$this->isAdmin() OR $onlyuser){
            $isuser=" AND  PR1.utente = ? ";
            if($onlyuser){
                $controlla[]=$time;
            }else{
                $controlla[]=$this->iduser;
            }
        }
        
        $timegap="";
        
        if($time!=null){
            
            $oggi=date("Y-m-d");
            $date = strtotime($oggi);
            $date = strtotime("-$time day", $date);
            
            $timegap="AND date(PR1.data) BETWEEN '$date' AND '$oggi' ";
            
        }
        
        $raggruppa=" GROUP BY date(PR1.data) ";
        
        if($time>30){
            $raggruppa=" GROUP BY date(PR1.data) ";
        }
        
        $query=$this->db->query("SELECT date(PR1.data) as data,"
                . " (SELECT count(*) FROM lm_preventivo WHERE date(lm_preventivo.data)=date(PR1.data) ) as quantita, "
                . " (SELECT SUM(lm_preventivo_item.costo*lm_preventivo_item.quantita) FROM lm_preventivo_item WHERE  "
                . "     lm_preventivo_item.preventivo_id=PR1.idpreventivo ) as totale  "
                . " FROM lm_preventivo PR1 WHERE "
                . " PR1.utente IN(SELECT iduser FROM lm_users WHERE owner=? ) $isuser $timegap "
                
                . " $raggruppa  ",$controlla);
        
        
        $datas=$query->result_array();
        
        $obj=array();
        foreach($datas as $r){
            $obj[$r["data"]]=$r;
        }
        
        return $obj;
        
    }
    

    /** Calcolo delle vendite**/
    public function getStatisticheVendite($time=null){
        
        
        $controlla[]=$this->owner;
        $isuser="";
        
        if( !$this->isAdmin() ){
            $isuser=" AND  FA1.utente = ? ";
            $controlla[]=$this->iduser;
        }
        
        $timegap="";
        
        if($time!=null){
            
            $oggi=  date("Y-m-d");
            $date = strtotime($oggi);
            $dateg = strtotime("-$time day", $date);
            
            $timegap="AND date(FA1.data) BETWEEN '$dateg' AND '$oggi' ";
            
        }
        
         $raggruppa=" GROUP BY date(FA1.data) ";
        
        if($time>30){
            $raggruppa=" GROUP BY month(FA1.data) ";
        }
        
        
        $query=$this->db->query("SELECT date(FA1.data) as data,"
                . " (SELECT count(*) FROM lm_fatture_generate WHERE date(lm_fatture_generate.data)=date(FA1.data) ) as quantita, "
                . " (SELECT SUM(lm_fatture_generate.totale) FROM lm_fatture_generate WHERE lm_fatture_generate.codfatt=FA1.codfatt ) as totale  "
                . " FROM lm_fatture_generate FA1 WHERE "
                . " "
                . "  "
                . " FA1.utente IN(SELECT iduser FROM lm_users WHERE owner=? ) $isuser $timegap "
                . " "
                . " $raggruppa  ",$controlla);
        
        $datas=$query->result_array();
        
        $obj=array();
        
        
        foreach($datas as $r){
            $obj[$r["data"]]=$r;
        }
        
        return $obj;
    }
    
    /**
     *  Restituisce le tassazioni standard impostate dall'azienda
     */
    function getAliquoteTasse(){
        
        $query = $this->db->query('SELECT * FROM lm_tassazioni '
                . ' WHERE azienda = ? ',array($this->owner));
        
        $t = $query->result_array();
              
        return $t;
        
        
    }
    
    function getLogo($modo=null){
        
        
        
        
        $this->db->where('user',$this->iduser);
        $query=$this->db->get("lm_modello_intestazione");
        $img=$query->row_array(0);
        if($img!=""){
            
            if($modo=='assolutepath'){
                return site_url($img["logo"]);
            }else{
                return $img["logo"];
            }
            
            
        }
        
        
        return null;
    }
    
    function getLogoIntestazione(){
        
        $this->db->where('user',$this->iduser);
        $query=$this->db->get("lm_modello_intestazione");
        $img=$query->row_array(0);
        if($img!=""){
            return "<img src='/".($img["logo"])."'>";
        }
        
        return "";
    }
    
    
    
    
    function selectOptionIvaCode($preselect=null){
        
        $tasse=$this->getAliquoteTasse();
        
        $html="";
        foreach ($tasse as $t){
            $select=($preselect==$t["aliquota"])?"selected":"";
            $html.="<option value='".$t["aliquota"]."' $select>".$t["nome_tassazione"]." - ".$t["aliquota"]."% </option>";
        }
        return $html;
        
    }
    
   
    /**
     *  Utilizzato per restituire il conteggio dei prodotti nel carrello
     *  mi restuisce la composizione di tutti i prodotti
     * @return type
     */
    function getQuoteArticoli($contavarianti=true){
        
        $conta=0;
        if(isset($_SESSION["carrello"])>0){
            $qq=$_SESSION["carrello"];
        //conto i prodotti
        foreach($qq as $prod){
          
            $v=$prod["varianti"];
            $conta+=(1*$prod["qty"]);
            
            if($contavarianti && count($v)>0){
                foreach($v as $variant){
                    //conto le varianti
                    if(isset($variant["qty"])){
                        //$conta+=(1 * $variant["qty"]);//se la variante non ha la proprietà qty settata...
                        
                    }else{
                        $conta+=(1 * $prod["qty"]);//proprietà qty settata per la variante
                    }
                }
            }
            
        }
        }
        
        return $conta;
    }

    
    public function getAccountDipendenti(){
        
        $query  =    $this->db->query('SELECT * FROM lm_users WHERE owner=?   ',array($this->owner));
        $datas  =    $query->result("User_model");
        
        return $datas;
    }
    
    /**
     * 
     */      
    function login($username,$password){
        
        $query = $this->db->query('SELECT * FROM lm_users '
                . 'WHERE username=? '
                . 'AND password=? LIMIT 1',array($username,$password),1);
        $user = $query->row_array();
        
        if($user!=null){
            return $user;
        }
        
        return null;
        
    }
    
    
    
    
    /**
     * Restituisce la stringa con il nome e cognome da mostrare in modo completo 
     * dove serve:
     *  -sidebar top
     * @return type
     */
    function getNomeCompleto(){
        return $this->profile["nome"]." ".$this->profile["cognome"];
    }
    
    
    
     /**
     * Return media image path form user
     * @return Array
     */
    public function get_media_path(){
        //
        //save on lm_media_location
        //
       $query = $this->db->query('SELECT * FROM lm_media_location WHERE user=? ',
                array($this->iduser));
        $mediapath = $query->row_array(0);
        if(!isset($mediapath) || count($mediapath)==0){
            
            //creo il nuovo media path
            
        }
        return $mediapath;
    }
    
    
    /**
     * 
     */
    public function getUploadUrl(){
        
    }
    
    /**
     * 
     * @param type $action
     * @return string
     */
    function check_image_path($action=false){
        //
        //costruisco il path per le immaigni di questo utente
        //
        $path="public/downloads/";
        
        $query = $this->db->query('SELECT * FROM lm_media_location WHERE user=? ',
                array($this->iduser));
        $path_media = $query->row_array(0);
        
        if(isset($path_media["user"])){
            
            
            $path="".$path_media["path"];
            
        }else{
            
            $codes=md5(time()*$this->iduser);
            $path.=$codes."/";
            if(!is_dir($path)){
                $datas=array("user"=>$this->iduser,"path"=>$path,"name"=>"");
            
                $this->db->insert("lm_media_location",$datas);
            
                @mkdir($path);//creo la cartella...
            }
            
        }
        
        //----        
        return $path;
    }
    
    /**
     * Utilizzato per restituire il riferimento della directory di destinazione.
     * @return string
     */
    function get_user_media_path(){
         
        //$path="public/downloads/";
        $path="";
       
        $query = $this->db->query('SELECT * FROM lm_media_location WHERE user=? OR azienda=? ',
                array($this->iduser,$this->owner));
        $path_media = $query->row_array(0);
        
        if(isset($path_media["user"])){
             $path.=$path_media["path"]."";

             return $path;
        }

        return null;
       
    }
    
    
    function get_user_media_file(){
        
        $path="public/downloads/";
        
       
        $query = $this->db->query('SELECT * FROM lm_media_location WHERE user=? OR azienda=? ',
                array($this->iduser,$this->owner));
        $path_media = $query->row_array(0);
        
        $files=array();
        
        if(isset($path_media["user"])){
            $path="".$path_media["path"]."";
            $pat=glob($path."*.*");
            foreach($pat as $f){
                $files[]=array(
                    "image"=>"/".$f,
                    "class"=>" user ");
            }
        }
        
        //carico le risorse condivise...
        $path2="public/downloads/shared/";
        $ppp=glob($path2."*.*");
        //print_r($path2);
        
        foreach($ppp as $ff){
            
            if(file_exists($ff)){
                 $nome=basename($ff);
                 $files[]=array(
                        "image"=>base_url(getLanguage()."/media/shared/$nome"),
                        "class"=>" shared ");
            }
        }
            
        
        return $files;
        
    }
    
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function get_by_id($id){
        
        $query = $this->db->query('SELECT * FROM lm_users WHERE lm_users.iduser=? ',
                array($id));
        $user = $query->row_array();
        
        if($user!=null){
            return $user;
        }
        
    }
    
    
    public static function getUser($id){
        $ci=&get_instance();
        $query = $ci->db->query('SELECT * FROM lm_users WHERE lm_users.iduser=? LIMIT 1',array($id));
        $user = $query->result('User_model');
        return $user;
    }
    
    
    public function resolveCap($comune=null){
        
        $cap=$this->profile["cap"];
        $comune=($comune==null)?$this->profile["comune"]:$comune;
        
        if( $cap=="" && $comune>0){
            $comune=$this->profile["comune"];
            $query = $this->db->query('SELECT * FROM comuni WHERE id=? ',
                array($comune));
          $dati = $query->row_array(0);
          $cap=$dati["cap"];
        }
        
        return $cap;
    }
    
    
    public function resolveUsername($username){
        
        $query = $this->db->query('SELECT * FROM lm_users WHERE username=? LIMIT 1',array($username));
        $user = $query->result('User_model');
        if(count($user)){
            $user=$user[0];
            
            return $user->iduser;
        }
        return null;
    }
    
    
    public function resolveComune($cod=null){
         $comune=($cod==null)?$this->profile["comune"]:$cod;
         $query = $this->db->query('SELECT * FROM comuni WHERE id=? ',
                array($comune));
          $dati = $query->row_array(0);
          return $dati["nome_comune"];
    }
    
    public function resolveProvincia($cod=null,$BYCOMUNE=FALSE){
        
           
         $provincia=($cod==null)?$this->profile["provincia"]:$cod;
         
         if($BYCOMUNE){
              $query = $this->db->query('SELECT * FROM province WHERE cod_ident=(SELECT ) ',
                array($provincia));
         }else{
            $query = $this->db->query('SELECT * FROM province WHERE cod_ident=? ',
                array($provincia));
         }
         $dati = $query->row_array(0);
         return $dati["nome"];
    }
    
    
    
    /* VECCHIA VERSIONE ---> NON IMPLEMENTATA*/
    public function get_costi_Spedizione(){
        
       /* $provincia=$this->profile["provincia"];
        
        $query = $this->db->query('SELECT * FROM province WHERE cod_ident=? ',
                array($provincia));
        $datiprov = $query->row_array(0);
        //print_r($datiprov);
        
        $regione=$datiprov["regione"];
        
        $query = $this->db->query(' SELECT * FROM lm_costi_zone_gruppi,lm_costi_zone '
                . ' WHERE lm_costi_zone.idcostozona=lm_costi_zone_gruppi.costo_zona '
                . ' AND lm_costi_zone_gruppi.regione=? ',
                array($regione));
        
        $costi = $query->row_array();
        
        if( $query->num_fields()>0){
            
             $query = $this->db->query(' SELECT * FROM lm_costi_zone WHERE idcostozona=?',array("1"));
             $costi = $query->row_array();
             
             return $costi;
        }*/
        
        
        return 0;
    }
    
    
    
    
    
    
    
    
    
    public function __construct()
    {
       // Call the Model constructor
       parent::__construct();
        
       $this->me(); 
       //cambia il model
       $this->updateModel();
       
       
    }
    
    
    

    public function isLogged(){
       return (isset($_SESSION["LOGGEDIN"]))?true:false;
    }
    
    
    public function isAdmin(){
        
        //è admin per la sua azienda
        if ( $this->user_model == 1 ) {
                return true;
        } 
        
        return false;
    }
    
    public function getUserType(){
        
        return $this->user_model;
    }
    
    
    
    public function getPhoto(){
        if($this->profile["foto"]!=""){
            return $this->profile["foto"];
        }
        return "public/img/noimage.jpg";
    }
    
    
    
    /**
     * Calcola lo stato del profilo personale in base ai dati compilati. Dove i dati sono
     * compilati assegna un valore +1
     * Vedere questo calcolo come lo stato di completezza del profilo
     * 
     * @return Mixed Array
     */
    public function statoProfilo(){
        
        $status=0;
        $messages=array();
        $messages2=array();
        //#1
        if( $this->profile["nome"]!=""  ){
            $status++;
        }else{
            $messages[]="nome";
        }
        
         //#2
        if( $this->profile["cognome"]!=""  ){
            $status++;
        }else{
            $messages[]="cognome";
        }
        
        //#3
        if( $this->profile["telefono"]!=""  ){
            $status++;
        }else{
            $messages[]="telefono";
        }
        
        //#4
        if( $this->profile["stato_nazione"]!=""  ){
            $status++;
        }else{
            $messages[]="stato nazione";
        }
        
         //#4
        if( $this->profile["mobile"]!=""  ){
            $status++;
        }else{
            $messages[]="mobile";
        }
         //#5
        if( $this->profile["provincia"]!="" OR $this->profile["provincia"]!="" ){
            $status++;
        }else{
            $messages[]="provincia";
        }
         //#6
        if( $this->profile["comune"]!="" OR $this->profile["comune"]!="" ){
            $status++;
        }else{
            $messages[]="comune";
        }
         //#7
        if( $this->profile["indirizzo"]!=""  ){
            $status++;
        }else{
            $messages[]="indirizzo";
        }
        
         //#8
        if( $this->profile["foto"]!=""  ){
            $status++;
        }else{
            $messages[]="foto";
        }
        
        if($status>5){
            $messages2[]="Verifica i tuoi dati";
        }
        
        
        //devo calcolare la quantità di aliquote caricate ma solo come 
        //admin azienda
        if($this->isAdmin()){
            $tass=$this->getAliquoteTasse();
            if(count($tass)==0){
                $status++;
                $messages2[]="Verifica le aliquote";
            }
            
            //pagamenti
            
        }
        
        //come calcolo la percentuale?
        // ($status*8)/100
        //se restituisce 
        $percentuale=($status*100)/9;
        
        return array(
            "photo"=>$this->getPhoto(),
            "valore"=>$percentuale,
            "messaggi"=>$messages,
            "html"=>""
            . "<br/><hr/><ul class='list-group'><li class='list-group-item'>"
            .  join("</li><li class='list-group-item'>",$messages2)
            . "</li></ul>"
            . "<div id='cookiebox'>"
            . "<p><input type='checkbox' name='hidehelp' class='checkbox' />".t("Nascondi-guida")."</p>"
            . "</div>");
        
    }
    
    
    function getProfile($val){
        if(isset($this->profile[$val])){
            return $this->profile[$val];
        }
        
        return "_ERROR_";
    }
    
    /*
     * Con questo metodo mi carico tutte le informazioni 
     * dell'utente loggato
     */
    function me()
    {
        
        $myid=0;
        $businessid=0;
       
        if($this->iduser>0 && $this->owner>0){
            
            $myid=$this->iduser;
            $businessid=$this->owner;
            
        }else if(isset($_SESSION["LOGGEDIN"])){
            
            $sess_user=$this->session->get_userdata('LOGGEDIN');
            //$this->session->set_userdata('language',"it");
            //print_r($sess_user["LOGGEDIN"]);
            $myid=$sess_user["LOGGEDIN"]["userid"];

        }
        
        
        $query = $this->db->query('SELECT * FROM lm_users JOIN lm_user_profile ON  lm_users.iduser=lm_user_profile.user'
                . ' WHERE  lm_users.iduser=? AND lm_users.status=\'1\' LIMIT 1 ',
                array(
                    $myid
                )
        );
        
        $user = $query->row();
        
        //$user = $query->custom_result_object("Preventivo_model");
        if($user){
            
            $this->iduser=$user->iduser;
            $this->username=$user->username;
            $this->email=$user->email;
            $this->status=$user->status;
            $this->type=$user->type;
            $this->user_model=$user->user_model;
            $this->profile=array(
                "idprof"=>$user->idprofile,
                "nome"=>$user->nome,
                "cognome"=>$user->cognome,
                "telefono"=>$user->telefono,
                "mobile"=>$user->mobile,
                "comune"=>$user->comune,
                "provincia"=>$user->provincia,
                "telefono"=>$user->telefono,
                "indirizzo"=>$user->indirizzo,
                "cap"=>$user->cap,
                "foto"=>$user->foto,
                "stato_nazione"=>$user->stato_nazione
            );
            
            
            $this->owner=$user->owner;
            
            $query2 = $this->db->query('SELECT * FROM lm_azienda WHERE codazienda=? LIMIT 1 ',
                array(
                    $this->owner
                )
            );
            $businessid=$this->owner;
            
            $this->BUSINESS = $query2->row();
            
            
            
        }else if(isset($_SESSION["GUEST_USER"]) && $sess_user["LOGGEDIN"]["userid"]==session_id() ){

               $unqid=$_SESSION["GUEST_ID"];

               $this->iduser=session_id();
               $this->username="GUEST_$unqid";
               $this->mail="GUEST_$unqid"."@business.limap.it";
               $this->status=1;
               $this->type=1;
               $this->user_model=1;
               $this->profile=array(

                   "nome"=>"Guest",
                   "cognome"=>"Guest",
                   "telefono"=>"",
                   "mobile"=>"",
                   "comune"=>"",
                   "provincia"=>"",
                   "telefono"=>"",
                   "indirizzo"=>"",
                   "cap"=>""
               );
               $this->owner=-1;
        }

        //carico le informazioni di fatturazione
        if($this->iduser>0){

               $s = $this->db->query('SELECT * FROM lm_dati_fatturazione '
               . ' WHERE codcliente=? ', array($this->iduser) );

               $this->fatturazione = $s->row_array(0);


        }
         
        
        
        
        
    }
    
    
    public function updateModel(){
        
        $tipologia=$this->type;//mi identifica i livelli amministrativi di accesso
        $usermodel=$this->user_model;//mi identifica il tipo
        $valore_tipo="User";
        switch($usermodel){
            case 0:
                $valore_tipo="Admin";
            break;
            case 1:
                $valore_tipo="Privato";
            break;
            case 2:
                $valore_tipo="Dipendente";
            break;
        }
        
        $this->nome_model= $valore_tipo."_model";//mi da per esempio il Privato_model
        if(!model_exists($this->nome_model)){
            $this->nome_model="Privato";
        }
        
    }   
    
    
    /**
     * 
     */
    static function CreateUserModel(){
        
        $tipologia=$this->type;//mi identifica i livelli amministrativi di accesso
        $usermodel=$this->user_model;//mi identifica il tipo
        $valore_tipo="";
        switch($usermodel){
            case 0:
                $valore_tipo="Admin";
            break;
            case 1:
                $valore_tipo="Privato";
            break;
            case 2:
                $valore_tipo="Professionista";
            break;
        }
        
        $this->nome_model= $valore_tipo."_model";//mi da per esempio il Privato_model
        if(!model_exists($this->nome_model)){
            $this->nome_model="Privato";
        }
        
    }
    
    
    function getMy($cosa,$idrif=null,$limit="",$selezione=""){
        
        $datas=array();
        if(isset($cosa)){
            switch ($cosa){

                case "messaggi":

                     if($idrif!=null)
                    {
                         $query=$this->db->query("SELECT * FROM lm_message WHERE user=? AND idmessage=? ",array($this->iduser,$idrif));
                        $datas=$query->result("Messaggio_model");

                    }else{
                        $query=$this->db->query("SELECT * FROM lm_message WHERE user=?",array($this->iduser));
                        $datas=$query->result("Messaggio_model");
                    }  

                break;

                case "clienti":

                    if($idrif!=null)
                    {
                        $query=$this->db->query("SELECT * FROM lm_profili_clienti WHERE utente=? AND codcliente=? ",array($this->iduser,$idrif));
                        $datas=$query->result("Cliente_model");

                    }else{

                        $query=$this->db->query("SELECT * FROM lm_profili_clienti WHERE utente=? ",array($this->iduser));
                        $datas=$query->result("Cliente_model");


                    }  


                break;

                
                case "fatture":

                    //if(!$this->richiedePrivilegi('fatture')) return null;

                    if($idrif!=null)
                    {
                        $query=$this->db->query("SELECT * FROM lm_fatture_generate WHERE utente IN (SELECT iduser FROM lm_users WHERE lm_users.owner=?) "
                                . " AND MD5(codfatt) = ? $selezione LIMIT 1 ",array($this->owner,$idrif));
                        $datas=$query->row(0,"Invoice_model");
                        
                    }else{

                        if($limit==""){
                            $limit.=" ORDER BY data DESC";
                        }
                        $query=$this->db->query("SELECT * FROM "
                                . " lm_fatture_generate "
                                . " WHERE lm_fatture_generate.utente IN (SELECT iduser FROM lm_users WHERE lm_users.owner=?) $selezione $limit ",array($this->owner));
                        $datas=$query->result("Invoice_model");
                    }  

                break;
                
                
                  case "fornitori":
                
                    if($idrif!=null)
                    {
                        $query=$this->db->query("SELECT * FROM lm_profili_fornitori WHERE utente=? AND codfornitori=? ",array($this->iduser,$idrif));
                        $datas=$query->result("Fornitori_model");

                    }else{

                        $query=$this->db->query("SELECT * FROM lm_profili_fornitori WHERE utente=? ",array($this->iduser));
                        $datas=$query->result("Fornitori_model");


                    }  


                 break;

                case "preventivi":

                    if($idrif!=null)
                    {
                        if($this->isAdmin()){
                            $query=$this->db->query("SELECT * FROM lm_preventivo WHERE "
                                . "utente IN (SELECT iduser FROM lm_users WHERE lm_users.owner=?) AND MD5(idpreventivo) = ? LIMIT 1 ",array($this->owner,$idrif));
                        }else{
                            $query=$this->db->query("SELECT * FROM lm_preventivo WHERE "
                                . "utente=? AND MD5(idpreventivo) = ? LIMIT 1 ",array($this->iduser,$idrif));
                        }

                        $datas=$query->row(0,"Preventivo_model");


                    }else{
                        
                        if($this->isAdmin()){
                             $query=$this->db->query("SELECT * FROM lm_preventivo WHERE utente IN (SELECT iduser FROM lm_users WHERE lm_users.owner=?) $limit  ",array($this->owner));
                            $datas=$query->result("Preventivo_model");
                        }else{
                            //$limit.=" ORDER BY idpreventivo DESC";
                            $query=$this->db->query("SELECT * FROM lm_preventivo WHERE utente=? $limit  ",array($this->iduser));
                            $datas=$query->result("Preventivo_model");
                        }
                    }                
                break;

               case "ordini":

                    $query=$this->db->query("SELECT * FROM lm_ordini JOIN lm_preventivo "
                            . "ON  lm_ordini.rif_preventivo=lm_preventivo.idpreventivo WHERE  "
                            . " lm_ordini.cliente=?",array($this->iduser));

                    $datas=$query->result("Ordine_model");


                break;

                case "prodotti":

                    $query=$this->db->query("SELECT lm_modelli_prodotti.* FROM lm_prodotti_azienda JOIN lm_modelli_prodotti ON "
                            . " lm_prodotti_azienda.codiceprodotto = lm_modelli_prodotti.codice_modello WHERE "
                            . " lm_prodotti_azienda.azienda=? $limit ",array($this->owner));

                    $datas=$query;

                break;

                case "categorie-prodotti":

                    $query=$this->db->query("SELECT * FROM lm_categorie_prodotti WHERE  "
                            . " lm_categorie_prodotti.azienda=? OR owner= -1 ",array($this->owner));

                    $datas=$query->result_array();

                    break;
                
                case "customer_analyse1":
                
                    $sql = "SELECT * FROM lm_preventivo WHERE utente = ".$this->iduser." AND cliente = ".$idrif." ";
                    $query = $this->db->query($sql);
                    $datas = $query->result('Preventivo_model');				
				
                break;

                case "customer_analyse2":  		

                        $sql = "SELECT * FROM lm_fatture_generate WHERE utente = ".$this->iduser." AND cliente = ".$idrif." ";
                        $query = $this->db->query($sql);			
                        $datas = $query->result('Invoice_model');				
                        //$datas=$query->row(0,"Invoice_model");				

                break;

            }
        }else{
            throw new Exception("Not define parametro");
        }
        
        
        return $datas;
    }
    
    
    
    /**
     * 
     * @param type $categoria
     * @param type $codice
     * @return type
     */
    public function get_modelli($categoria=null,$codice=null){
        $datas=null;
         if( !empty($categoria) ){
                
                $query=$this->db->query("SELECT lm_modelli_prodotti.* FROM "
                . " lm_prodotti_azienda JOIN lm_modelli_prodotti ON lm_prodotti_azienda.codiceprodotto=lm_modelli_prodotti.codice_modello "
                . " JOIN lm_categorie_prodotti ON lm_categorie_prodotti.idcategoria = lm_modelli_prodotti.categoria "
                . " WHERE (lm_categorie_prodotti.nome LIKE ? OR lm_categorie_prodotti.idcategoria=? ) "
                        . " AND lm_modelli_prodotti.carattere_prodotto IN ('articolo','entrambi') "
                . " AND "
                . " lm_prodotti_azienda.azienda = ? "
                ." ",array($categoria,$codice,$this->owner));
                //$datas=$query->result();//
                
                $prodottinew="SELECT * FROM ";
                 $datas = $query->custom_result_object("Prodotto_model");
         
         }
        
         
         
         return $datas;//mi restituisce i modelli delle finestre
        
    }
    
   
    
    
    /**
     * L'incremento di listino in base alla tipologia di utente
     */
    function get_incremento_listino($valorebase=null,&$data=null){
        
        $query = $this->db->query('SELECT * FROM lm_types_listini WHERE types=? AND owner=? LIMIT 1',array($this->type,$this->owner),1);
        $user = $query->row_array();
        
        $data["_log_user_"]=$user;
        
        if( $valorebase > 0 ){
            
            return $valorebase - ( floatval( $valorebase * $user["valore"] ) /100 );
            
        }
        
        return $valorebase;
    }
    
    
    /**
      *  Stessa funzione a meno del calcolo
      * @return type
      */
    public function getSconti(){
        
        $query = $this->db->query('SELECT * FROM lm_types_listini WHERE types=? ',array($this->type));
        $listino = $query->row();
        
        return $listino;
    }
    
    
    public function getInvoice($codice,$modello='Invoice_model'){
        
        if( isset($codice) ){
        
            $query = $this->db->query('SELECT * FROM lm_fatture_generate WHERE utente=? AND MD5(codfatt) = ? ',
                    array($this->iduser,$codice));
            $invoice = $query->custom_result_object($modello);

            //print_r($preventivi);
            if(count($invoice)>0){
                return $invoice;
            }
            
            
        }
        
        return null;
        
       
    }
    
  
    /**
     *   //mi restituisce un preventivo di questo utente... unico per lui
     *   //se non gli appartiene non esiste...
     * @param type $codice
     * @param type $modello
     * 
     * @return Object
     */
    public function getPreventivo($codice,$modello='Preventivo_model'){
        
        if( isset($codice) ){
            
            if($this->isAdmin()){
                
                 $query = $this->db->query('SELECT * FROM lm_preventivo WHERE utente IN (SELECT iduser FROM lm_users WHERE owner=? ) AND MD5(idpreventivo) = ? ',
                    array($this->owner,$codice));
                
            }else{
        
                $query = $this->db->query('SELECT * FROM lm_preventivo WHERE utente=? AND MD5(idpreventivo) = ? ',
                    array($this->iduser,$codice));
            }
            
            
            $preventivi = $query->custom_result_object($modello);

            //print_r($preventivi);
            if(count($preventivi)>0){
                return $preventivi;
            }
            
            
            
            
        }
        
        return null;
        
       
    }
    
    public function savePreventivo( $data=NULL ){
        
        //$daa["message"]="Salvataggio nuovo preventivo...";
        //_report_log($daa);
        
        $codice_preventivo=$this->input->post('codice_vp');
        if(empty($codice_preventivo)){
            $maxid_preventivo=0;
            
            
            $rows = $this->db->query('SELECT codice_utente FROM `lm_preventivo` WHERE utente='.$this->iduser.' ')->result_array();
            
            
            if (count($rows)>0) {
                foreach($rows as $c){
                    $codice=intval($c["codice_utente"]);
                    if($maxid_preventivo<=$codice){
                        $maxid_preventivo=$codice;
                    }
                }

                $maxid_preventivo+=1;
            }
            
        }else{
            $maxid_preventivo=$codice_preventivo;
        }
       
        
        $iva=intval($this->input->post('imposte'));
        
        $note=$this->input->post("noteordine");
        if($note==null){
            $note="";
        }
        
        $nome=$this->input->post("titolopreventivo");
        if( $nome==null  OR $nome==""){
            $nome=t('senza-nome');
        }
        
        $codicecliente=intval($this->input->post('codicecliente'));
        $pivacliente=$this->input->post('pivacliente');
        
        if($codicecliente==0 && !empty($pivacliente) && $pivacliente!=""){
            
            $querycliente=$this->db->query('SELECT *  FROM lm_profili_clienti WHERE utente=? AND PIVA=?',array($this->iduser,$pivacliente));
            $daticliente=$querycliente->row_array(0);

            if( isset($daticliente["codicecliente"]) ){
                $codicecliente=$daticliente["codicecliente"];
            }
            
            
        
        }
        
        if($codicecliente==0 && isset($pivacliente) && trim($pivacliente)!=""){
           
            $daticliente=array(
                
                "utente"=>$this->iduser,
                "rag_sociale_cliente"=>$this->input->post('ragsocialecliente'),
                "comune"=>$this->input->post('capcomunecliente'),
                "provincia"=>$this->input->post('provinciacliente'),
                "indirizzo"=>$this->input->post('indirizzocliente'),
                "PIVA"=>$pivacliente,
                "note"=>$this->input->post('notecliente'),
                "email"=>$this->input->post('emailcliente'),
                "cod_fiscale"=>$this->input->post('cfcliente')
            );
            //verifico che questo codice cliente non appartiene al proprietario...
            //in caso contrario creo un rollback come errore...
            $this->db->insert('lm_profili_clienti',$daticliente);
            $codicecliente = $this->db->insert_id();
        }
        
        //
        $dat=array(
            "idpreventivo"=>null,
            "codice_utente"=>intval($maxid_preventivo),//mi serve come riferimento pubblico, nei dati vista passo MD5(idpreventivo) & codice_utente
            "utente"=>$this->iduser,
            "cliente"=>$codicecliente,
            "titolo"=>$nome,
            "data"=>date("Y-m-d h:i:s"),
            "note"=>$note,
            "stato"=>"bozza",
            "json_model"=> json_encode($data),
            "iva"=>( ($iva==0)?22:$iva ),
            "template_intestazione"=>$this->input->post("mce_0")
        );
        
        $status = $this->db->insert('lm_preventivo',$dat);
        //print_r($status);
        $insert_id = $this->db->insert_id();
        
        if($status && count($data)>0){
            
            
            foreach($data as $codicecarrello=>$it){
                
                if(trim($codicecarrello)!==""){
                    $varianti="";

                    if(count($it["varianti"]>0)){

                        $varianti=json_encode($it["varianti"]);
                    }
                    //print_r($it);
                    $descr1=($this->input->post('editor1_'.$codicecarrello));
                    $descr2=($this->input->post('editor2_'.$codicecarrello));

                    $iva=$this->input->post('selectiva['.$codicecarrello.']');
                    $costo=$this->input->post('costounitario['.$codicecarrello.']');
                    $quantita=$this->input->post('qty['.$codicecarrello.']');
                    $ds=array(

                        "preventivo_id"=>$insert_id,

                        "prodotto"=>$it["modello"],
                        "descrizione"=>$descr1,
                        "descrizione_2"=>$descr2,
                        "quantita"=>$quantita,
                        "larghezza"=>$it["larghezza"],
                        "altezza"=>$it["altezza"],
                        "costo"=>$costo,
                        "codice_iva"=>$iva,
                        "varianti"=>$varianti
                    );
                    $this->db->insert('lm_preventivo_item',$ds);
                }else{
                    $data["message"]="Attenzione questo elemento "
                            . "se è un servizio ha generato un errore...verificare!#".json_encode($it);
                    _report_log($data);
                }
            }
        }
        
        if($insert_id>0){
            return $insert_id;
        }
        
    }
    
    
    public function updateprofile($dataprofile){
        
        if($dataprofile!=null){
        
            $where = " user='".$this->iduser."' AND idprofile = '".$this->profile["idprof"]."' ";

            $str = $this->db->update_string('lm_user_profile',$dataprofile, $where);
            
           return $this->db->query($str);
          
        }
        
        
        
    }
    
    
    public function updateFatturazione($datas){
        
        if($datas!=null){
            
           
           if($this->fatturazione==null){
               $datas["codcliente"]=$this->iduser;
               $status = $this->db->insert('lm_dati_fatturazione',$datas);
                //print_r($status);
                $insert_id = $this->db->insert_id();
           }else{
        
            $where = " codcliente='".$this->iduser."' ";

            $str = $this->db->update_string('lm_dati_fatturazione',$datas, $where);

            return $this->db->query($str);
            
           }
          
        }
        
        
        
    }
    
    
    
   public function creautente($datas,$profilo=null,$fatturazione=null){
        
            
        $status = $this->db->insert('lm_users',$datas);
        //print_r($status);
        $insert_id = $this->db->insert_id();

        if($insert_id>0 && $profilo!=null){

            $profilo["user"]=$insert_id;
            $st2 = $this->db->insert('lm_user_profile',$profilo);

        }

        if($insert_id>0 && $fatturazione!=null){

            $fatturazione["codcliente"]=$insert_id;
            $st2 = $this->db->insert('lm_dati_fatturazione',$fatturazione);

        }

        return $insert_id;
         
   }
   
   
   
   /**
    * Restituisce il modello ordine da un id cercato
    * @param int $id
    * @return $object
    */
   public function getOrdine($id){
        
        $query = $this->db->query('SELECT * FROM lm_ordini WHERE cliente=? AND idordine=?',
                array($this->iduser,$id));
        $datas=$query->result("Ordine_model");
        
        if($datas!=null){
            return $datas;
        }
        
    }
    
    
    
    /**
     * Lista ordini del modello user
     */       
    public function getOrdini(){
        
        $query = $this->db->query('SELECT * FROM lm_ordini WHERE cliente=? AND idordine=?',
                array($this->iduser,$id));
        $datas=$query->result("Ordine_model");
        
        return $datas;
    }
    
    /**
     * Restituisce il numero di ordini in totale presenti nel profilo utente
     */
    public function getTotaleOrdini(){
        
        $query = $this->db->query('SELECT * FROM lm_ordini WHERE cliente=? ',array($this->iduser));

        $totale=$query->num_rows();

        return $totale;
    }
    
    
    
    
    /**
     * 
     * 
     */
    public function richiedePrivilegi($pr){
        return true;
    }
    
    
 
 
 
}