<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Mi restituisce i prodotti preparati nel carrello
 */
function WinnubCart(){
    
    $prodotti=array();
    
    
    return $prodotti;
}


/**
 * Restituisce le informazioni sull'azienda in url
 */
function infoAzienda(){
    
    $ci=&get_instance();
    
    $subdomain_arr = explode('.',$_SERVER['HTTP_HOST'],2); //creates the various parts
    $subdomain_name = $subdomain_arr[0]; //assigns the first part
   

    if($subdomain_name!="app"){
        //seleziono i dati aziendali base
        $query=$ci->db->query("SELECT * FROM lm_azienda WHERE codice_subdomain = ?  ",array($subdomain_name));
        $data = $query->row(0);
        $codiceazienda=$data->codiceazienda;
    }
    
    return array("codice"=>$codiceazienda,"data"=>$data);
    
}


/*+
 * Utility funcion per ottenere una stringa riferira al file lingua
 */
function _s($stringa,$file="global_lang"){
    
    $ci=&get_instance();
    
    $idiom = $ci->session->get_userdata('language');
   
    
    $valore = $ci->lang->line($stringa,$idiom);
    
    
    //print_r($valore);
     
    return $valore;
}

function _getGruppiCategorie(){
    
    $ci=&get_instance();
    
    $user=null;
    if(isset($_SESSION["LOGGEDIN"])){
           $sess_user=$ci->session->get_userdata('LOGGEDIN');
           $user=$sess_user["LOGGEDIN"]["userid"];
           
           $query = $ci->db->query('SELECT DISTINCT gruppo FROM lm_categorie_prodotti WHERE owner = ? ',array($user));
    
        return $query->result_array();
    }
    
    
    return null;
}

/**
 * Crea un codice unico per il carrello
 * in sessione
 */
function genera_codice_carrello(){
    
    $ci=&get_instance();
    $ci->load->helper('string');
    
    
    //$codicecart="wctA00".time();
    
    $codice=random_string('alnum',4);
    
    return $codice.time();
}


function _report_log($data){
    
    $ci=&get_instance();
    $ip="null";
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    $user="";
    
    if(isset($_SESSION["LOGGEDIN"])){
           $sess_user=$ci->session->get_userdata('LOGGEDIN');
           $user=$sess_user["LOGGEDIN"]["userid"];
    }
    
    $datas=array(
        "time"=>date("Y-m-d H:i:s"),
        "user"=>$user,
        "message"=>addslashes($data["message"]),
        "error"=> $data["error"],
        "ip"=>$ip,
        "sessione"=>session_id(),
        "URI"=>$_SERVER["REQUEST_URI"]
    );
    
   
    $query = $ci->db->insert('lm_log',$datas);
    
    //$ci->db->close();
    
}

function _is_logged(){
    
    
    return ( isset($_SESSION['LOGGEDIN']) && ( $_SESSION['LOGGEDIN']["status"]==1 ) )? true:false;
    
}


function winnub_feed($feed_url){
    
    $html="";
    $content = @file_get_contents(($feed_url));
    if($content){
        $x = new SimpleXmlElement($content);

        $html.="<ul>";
        if(is_object($x)){
            //print_r($x);
            if(isset($x->channel->item)){
                foreach($x->channel->item as $entry) {
                    $html.= "<li><a href='$entry->link' title='$entry->title' target='new'>" . $entry->title . "</a>"
                            . "<p>".$entry->description."</p>"
                            . "</li>";
                }
            }
        }
        $html.="</ul>";
    }
    
    echo $html;
    
    
}


function unique_code_generator($prefix='',$post_fix='')
{
    
    $ci=&get_instance();
    
    $t=time();
     
    
    $find=false;
    $valore=( rand(0,100000)+1 );
    do{

       $query = $ci->db->query('SELECT * FROM lm_configuration WHERE idordine = ?',array($valore));
       $righe=$query->num_rows();
       if($righe>0){
           $find=true;
           $valore=( rand(0,100000)+1 );
       }
      
        
    }while($find);
        
    
    
}


function _getColori(){
     
        $ci=&get_instance();
        
        
        $query=$ci->database->get("lm_colorazioni_prodotti");
        
        $datas = $query->result();
        
        
        return $datas;
}

function getCostoMisura($w,$h,$costo,$minfatt=null){
    
    $ci=&get_instance();
        
    $m2_totali=( ($w/1000)*($h/1000) );

    if( $m2_totali < $minfatt ){
        $m2_totali=($minfatt==null)? 1 : $minfatt;
    }
    
    $costo=(floatval($m2_totali * $costo));
             
   return $costo;
}



function _getSidebarModule($position){
    $ci=&get_instance();
    //$js=$ci->config->item('global_js');
    $html="";
    
    
    return $html;
}


function getLanguage(){
    
     $ci=&get_instance();
     
     return $ci->config->item('language_abbr');
}
    


function addJS($url,$type="text/javascript",$content=null){
    $ci=&get_instance();
    $js=$ci->config->item('global_js');
     if(is_array($url)){
            foreach ($url as $link){
                array_push($js,array("src"=>$link,"type"=>$type,"content"=>null));
                //array_push($js,array("src"=>$url,"type"=>$type,"content"=>$content));
            }
    }else{
        array_push($js,array("src"=>$url,"type"=>$type,"content"=>$content));
    }
    

    $ci->config->set_item('global_js',$js);


}


function addCSS($url,$type="text/css",$content=null){
    $ci=&get_instance();
    
    $css=$ci->config->item('global_css');
    
    if(isset($url) && $url!=null){
        if(is_array($url)){
            foreach ($url as $link){
                array_push($css,array("href"=>$link,"type"=>$type,"content"=>null));
            }
        }else{
                array_push($css,array("href"=>$url,"type"=>$type,"content"=>$content));
        }
        $ci->config->set_item('global_css',$css);
    }
}



function addBreadCrumbsItem($url,$value){
    $ci=&get_instance();
    
    $css=$ci->config->item('site_breadcrumbs');
    
    if(isset($url) && $url!=null){
        
        
        array_push($css,array("url"=>$url,"value"=>$value));
     
        
    }
    
    $ci->config->set_item('site_breadcrumbs',$css);
    
}




function get_breadcrumbs(){
    
    $ci=&get_instance();
    $html="";
    $css=$ci->config->item('site_breadcrumbs');
    //array_reverse($css)
    if(count($css)>0){
        foreach($css as $item){
            $html.="<li ><a href='".$item["url"]."'>".$item["value"]."</a></li>";
                   
        }
    }
    
    $html="<ol class='breadcrumb'>".$html."</ol>";
    
    echo $html;
}
    
/**
 *  Print all meta tag css
 * @return type
 */
function _getCss(){
    
    $ci=&get_instance();
    $html="";
    $css=$ci->config->item('global_css');
    //array_reverse($css)
    if(count($css)>0){
        foreach($css as $item){
            $html="<link type='".$item["type"]."' href=\"/".$item["href"]."\" rel=\"stylesheet\" />\n";
            echo ($html);            
        }
    }
    //print($html);
}

function _getJs(){
    
    $ci=&get_instance();
    $html="";
    
    $css=$ci->config->item('global_js');
    
    if(count($css)>0){
        foreach($css as $item){
            $html="<script type='".$item["type"]."' src=\"/".$item["src"]."\" >".$item["content"]."</script>\n";
            echo ($html);

        }
    }
    
    
    
}


/**
 * 
 * @param type $parents
 * @param type $searched
 * @return boolean
 */
function multidimensional_search($parents, $searched) { 
  if (empty($searched) || empty($parents)) { 
    return false; 
  } 

  foreach ($parents as $key => $value) { 
    $exists = true; 
    foreach ($searched as $skey => $svalue) { 
      $exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue); 
    } 
    if($exists){ return $key; } 
  } 

  return false; 
} 


/**
 * Metodo per la visualizzazione dei parametei chiave => valore delle impostazioni
 * globali del sito direttamente nel database
 * 
 * @param type $chiave
 * @param type $inputcode
 */
function _config($chiave,&$inputcode=null){
    
   $ci=&get_instance();
   
   $ci->load->database();
   
   $query = $ci->db->query('SELECT * FROM lm_configuration WHERE nome LIKE ?',array($chiave));

   $righe=$query->row();
   
   return ($righe->valore);
  
}


/**
 * Restituisce una lista di option per creare una select di dati presenti sul 
 * parametro code formattato in JSON
 * @param type $chiave
 * @param type $selection
 * @return type
 */
function _select_option_configuration($chiave,$selection=null){
    
    $ci=&get_instance();
   
   $ci->load->database();
   
   $query = $ci->db->query('SELECT * FROM lm_configuration WHERE nome LIKE ?',array($chiave));

   $righe=$query->row_array(0);
   $rows=json_decode($righe["codice"]);
   $html=array();
           
   foreach($rows as $c){
       $selected=($selection==$c->value)?"selected":"";
       $html[]="<option value='".$c->value."' $selected >".$c->name."</option>";
   }
   
   return join("",$html);
}

/**
 * Risolve il codice iva
 * @description Resolve codice iva/vat number
 * @param Int $id
 * 
 */
function resolveVatCode($id,$chiave="aliquota",$owner=null){
   
   $ci=&get_instance();
   
    if(isset($_SESSION["LOGGEDIN"])){

            $sess_user=$ci->session->get_userdata('LOGGEDIN');
            $owner=$sess_user["LOGGEDIN"]["business"];
    }
    
    $ci->load->database();

    $query = $ci->db->query('SELECT * FROM lm_tassazioni WHERE aliquota=?  AND azienda=? LIMIT 1',array($id,$owner));

    $righe=$query->row_array(0);

    if(is_array($chiave)){

        foreach($chiave as $n){
           $valore.=" ".$righe[$n]; 
        }

    }else{
         $valore=$righe[$chiave];
    }
    
    return $valore;
     
     
}


/**
 * 
 * @param type $id
 * @return type
 */
function getOwnerUser($id){
    $ci=&get_instance();
    $query = $ci->db->query('SELECT * FROM lm_users WHERE iduser=? ',array($id));

    $righe=$query->row_array(0);
    
    return $righe["owner"];
}


/**
 * 
 * @param type $preselect
 * @return string
 */
function _selectVatCode($preselect=null){
    
    $ci = &get_instance();
    
  if(isset($_SESSION["LOGGEDIN"])){
        
           $sess_user=$ci->session->get_userdata('LOGGEDIN');
           $owner=$sess_user["LOGGEDIN"]["business"];
           
           $ci->load->database();

           $query = $ci->db->query('SELECT * FROM lm_tassazioni WHERE azienda=? ',array($owner));

           $righe=$query->result_array();
        
           $tasse=$righe;
        
            $html="";
            
            foreach ($tasse as $t){
                
                if( $preselect==NULL ){
                    $preselect=($t["default"]==1)?$t["aliquota"]:null;
                }
                
                $select=($preselect==$t["aliquota"] )?"SELECTED":"";
                
                $html.="<option value='".$t["aliquota"]."' $select>".$t["nome_tassazione"]." - ".$t["aliquota"]."% </option>";
            }
            
        return $html;
        
  }
  return "";
}


/**
 * Serve ad effettuare le chiamate curl verso funzioni json già impostate nel progetto.
 * 
 * @param type $url
 * @param type $data
 * @param type $method
 * @return type
 */
function winnub_caller($url,$data,$method="POST",&$errors=null){
    

    $data_string = json_encode($data);

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST,$method);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
    );
    
    // Send the request
    $result = curl_exec($curl);
    
    if(  $errors!== null){
        $errors.=" $data_string ";
        $errors.="Errore CURL->".curl_error($curl);
        $errors.="NUMBER CURL->".curl_errno($curl);
    }
    // Free up the resources $curl is using
    curl_close($curl);

    return $result;
}


if ( ! function_exists('model_exists')){
    
    /**
     * 
     * @param type $name
     * @return boolean
     */
    function model_exists($name){
        $CI = &get_instance();
        foreach($CI->config->_config_paths as $config_path)if(file_exists(FCPATH . $config_path . 'models/' . $name . '.php'))return true;
        return false;
    }
}



if ( ! function_exists('t')){
    /**
     * 
     * @global type $LANG
     * @param type $line
     * @return type
     */
    function t($line) {
        global $LANG;
        //print_r($LANG);
        return ($t = $LANG->line($line)) ? $t : $line;
        
    }
}

if(!function_exists('verifica_permessi')){
    /**
     * 
     * @param type $utente
     * @param type $livello
     */
    function verifica_permessi($utente,$livello) {
       
    }
}


if(!function_exists('__adminListClienti')){
    /**
     * questa funzione è aggiunta per dare ulteriore specifica sul pannello di amminisrazione
     * @return string
     */
    function __adminListClienti(){

         $ci = &get_instance();

         $ci->load->database();

        $query = $ci->db->query('SELECT * FROM lm_users  ');
        $html="";
        $righe=$query->result_array();
        foreach($righe as $ra){
            $html.="<option value='".$ra["iduser"]."'>".$ra["username"]."</option>";
        }

        return $html;
    }
}


if(!function_exists('save_stream_log')){
    
    function save_stream_log($datas,$user=null){
        $ci = &get_instance();
        
        if($user==null){
            $sess_user=$ci->session->get_userdata('LOGGEDIN');
            $user=$sess_user["LOGGEDIN"]["userid"];
        }
        
        if($user!=null){
            $datas["user"]=$user;
            $datas["data"]=date("Y-m-d h:i:s");

            $ci->load->database();

            $ci->db->insert('lm_timeline_log',$datas);
        }
       
    }
}