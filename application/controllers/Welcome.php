<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
        var $lingua_intercettata;
    
        public function __construct() {
           parent::__construct();
           
           
           $this->lang->load('emails_lang');//importante deve esserci il file per ogni lingua
		
           $this->load->library('user_agent');
           
           $this->load->library('parser');
           $this->load->helper("url");

          

        }
        
        //API CALL
        
        
        function oauth(){
            
        }
        
        function switchlang($lgn){
            $this->load->helper('cookie');
             $this->load->library('user_agent');
            
             // user isnt logged in. store the referrer URL in a var.
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $redirect_to = str_replace(base_url(),'',$_SERVER['HTTP_REFERER']);
            }
            else
            {
                $redirect_to = $this->uri->uri_string();
            }  
            
            
            if($lgn){
                
                //echo "$lgn";
                $this->session->set_userdata('site_lang',$lng);
                
                $this->input->set_cookie('user_lang', $lgn);
                
                //salvo le informazioni sul db
                redirect("$lng/",'location');
                
            }
            
            exit;
            
        }
        
        
        
        
        //END API CALL
        
        
        
        function mostra_email_user(){
            
            
            
            $this->load->view("email/email_invite_user");
             
        }
        
        function mostra_email(){
            
            
            
            $this->load->view("email/email_registrazione");
             
        }
        
        
        

      /**
       * Gestione delle pagine di errore
       * @param type $page
       */
      public function error($page=null){
          
          $data=array(
              "heading"=>"Errore nei permessi",
              "message"=>"<p>Errore di accesso nella pagina</p>"
              . "<p>Tutti i tentativi di accesso a pagine non autorizzate sono loggati nel sistema.</p>");
          
          
          $this->parser->parse("errors/html/error_general",$data);
          
      }
      
      public function search($data=null){
          
        
        //NOT ACTIVE
        //print_r($_REQUEST);
        $chiave=$_REQUEST["q"];
          
         
        $query=$this->db->query("SELECT * FROM lm_profili_clienti");
        
        $datas["models"]=$query->result("Cliente_model");
        
        $datas["html"]=$this->parser->parse("ricerca",$datas,true);
          
        $this->output
            ->set_content_type('application/json') //set Json header
            ->set_output(json_encode($datas));// make output json encoded
        
          
      }
      
      
      
      public function discussion_board($codice){
          
            $qr="SELECT * FROM lm_message WHERE esternalcode=?";
            $result=$this->db->query($qr,array($codice));
            $result=$result->result_array();
            
            $lista=array();
            foreach($result as $i=>$m){
                $lista[$i]=$m;
                if($m["user"]==0){
                    $lista[$i]["mittente"]=$m["esternal"];
                    $lista[$i]["class"]="color";
                }else{
                    $user= User_model::getUser($m["user"]);
                    $user= $user[0];
                    $lista[$i]["class"]="neutro";
                    $lista[$i]["mittente"]=$user->getNomeCompleto();
                }
            }
          
            $datas["messages"]=$lista;
            
            $this->output
            ->set_content_type('text/json') //set Json header
            ->set_output(json_encode($datas));// make output json encoded
      }
      
      
      public function replymessage(){
          
            $datas["status"]=false;
            if(isset($_REQUEST["refcode"])){
              
                $codice=$_REQUEST["refcode"];
              
                $qr="SELECT * FROM lm_send_document WHERE MD5(ENCRYPT(idSpedizione,'".PUBLIC_SALT."'))=?";
                $result=$this->db->query($qr,array($codice));
                $result=$result->result_array();
                if(count($result)>0){
                    
                    
                    
                    if(!_is_logged()){//invio da utente non loggato
                        
                        $messaggio=array(
                        "user"=>0,
                        "reciver"=>$result[0]["utente"],
                        "esternal"=>$result[0]["email_destinatario"],
                        "subject"=>"RE:".$result[0]["oggetto"],
                        "message"=>$_REQUEST["messaggio"],
                        "data"=>date("Y-m-d H:i:s"),
                        "letto"=>"00",
                      
                        "esternalcode"=>$codice
                        );
                        
                         
                    }else{
                        
                        
                        
                         
                        $messaggio=array(
                            
                            "user"=>$_SESSION["LOGGEDIN"]["userid"],
                            "reciver"=>$result[0]["email_destinatario"],
                            "esternal"=>"",
                            "subject"=>"RE:".$result[0]["oggetto"],
                            "message"=>$_REQUEST["messaggio"],
                            "data"=>date("Y-m-d H:i:s"),
                            "letto"=>"00",
                            "esternalcode"=>$codice
                            
                        );
                        
                    }
                    
                    
                    //print_r($_REQUEST);
                    
                    $this->db->insert('lm_message', $messaggio);
                    
                    $datas["status"]=true;
                    $datas["sender"]=$result[0]["email_destinatario"];
                    
                    
                }

            }
          
          $this->output
            ->set_content_type('text/json') //set Json header
            ->set_output(json_encode($datas));// make output json encoded
          
      }
      
      /*
       * Ottiene il dettaglio con il codice pubblico criptato
       */
      public function qdetail($codice){
          
           
           //$codice=decrypt($codice,PUBLIC_SALT);
           $qr="SELECT * FROM lm_send_document WHERE MD5(ENCRYPT(idSpedizione,'".PUBLIC_SALT."'))=?";
           $result=$this->db->query($qr,array($codice));
           $result=$result->result_array();
           
           if(count($result)>0){
               
                $send_document=$result[0];
               
                //print_r($result);
                if($_REQUEST["reader"]=="clt" && isset($_REQUEST["reader"])){
                    $updt=array("lettura"=>$result[0]["lettura"]+1);
                    $w=" preventivo='".$result[0]["preventivo"]."' AND ENCRYPT(idSpedizione,'".PUBLIC_SALT."')='$codice' ";
                
                    $this->db->update("lm_send_document",$updt,$w);
                }
                
               
                
                //print_r($result);
                
                $query = $this->db->query('SELECT * FROM lm_preventivo WHERE idpreventivo = ? ',
                    array($result[0]["preventivo"])
                         );
                $result = $query->custom_result_object("Preventivo_model");
                //$result=$this->user->getPreventivo(MD5($result[0]["preventivo"]));
                
                addJS(array(
                     "public/js/qdetails.js",
                ));
                  
                $preventivo=$result;
                $data=array(
                    "sendocument"=>$send_document,
                    "preventivo"=>$preventivo,
                    "codice"=>$codice,
                    "messaggio"=>"Messaggio di prova...",
                    "userimage"=>"http://app.winnub.com/".$this->user->getPhoto()
                 );
                $this->load->view("quote/public_quote",$data);
                
                
                
           }else{
                  $data=array(
              "heading"=>"Errore nei permessi",
              "message"=>"<p>Errore di accesso nella pagina</p>"
              . "<p>Tutti i tentativi di accesso a pagine non autorizzate sono loggati nel sistema.</p>");
          
          
                $this->parser->parse("errors/html/error_general",$data);
          
           }
           
           
      }
      
      
      
      /**
       * 
       * Pagina index principale
       * 
       */
	public function index()
	{
            
           
            
            
            $data=array(
                "PAGE_TITLE"=>t("titolo-welcome-index"),
                "linguasessione"=>getLanguage(),
                "_WRAPID_"=>"wib_login"
            );
            
            
            addJS(array(
                 "public/js/particles.min.js",
                  "public/js/login.js",
            ));

            if( isset($_SESSION["LOGGEDIN"]["status"]) && 
                    $_SESSION["LOGGEDIN"]["status"]=1 && 
                    isset($_SESSION["LOGGEDIN"]) ){

                redirect('/dashboard');

                
                
            }else{

               $this->parser->parse('login',$data);
            }
            
            
            
         
            
	}
       
        
        
        public function login()
	{
         $data=array(
             "PAGE_TITLE"=>t("titolo-welcome-index"),
             "_WRAPID_"=>"wib_login"
         );
         
         addJS(array(
              "public/js/particles.min.js",
             "public/js/login.js",
            ));
       
            
         if( isset($_SESSION["LOGGEDIN"]["status"]) && 
                 $_SESSION["LOGGEDIN"]["status"]=1 && 
                 isset($_SESSION["LOGGEDIN"]) ){
             
             redirect('/dashboard');
             
         }
            
            
         $this->parser->parse('login',$data);
         
            
	}
      
      /**
       * Metodo di logout
       */
      public function logout(){
          session_destroy();
          redirect('/');
      }
      
      public function userext(){
          
          
          header("Content-type:text/json");
          
          $email=$_GET["typed"];
          
          $query2=$this->db->query("SELECT * FROM lm_users "
                  . " WHERE email=? ",
                  array($email)
          );
          $status=$query2->result_array();

         //print_r($status);
         
         if( count($status)>0 ){
             echo json_encode(array("status"=>"true"));
         }else{
             echo json_encode(array("status"=>"false"));
         }
         
         exit;
      }
      
     /**
       * Pagina dalla selezione dei preventivi, mostra la lista dei preventivi
       * @param type $codice
       */
      public function preventivo($codice=null){
         if(!_is_logged()) redirect('/');
          
          
         addCSS(array(
             "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css"
         ));
         addJS(array("public/js/carrello.js"));
          
         $preventivo=$this->user->getPreventivo($codice);
         if(count($preventivo)){
            $preventivo=$preventivo[key($preventivo)];   
         }
         if($preventivo){
         $data=array(
             "PAGE_TITLE"=>"Preventivo",
             "modo"=>"preventivo",
             "carrello"=>$preventivo->getCarrello(),
             "codicepreventivo"=>$codice,
             "modellopreventivo"=>$preventivo
         );
         }else{
            $ilcarrello=null;
            if(isset($_SESSION["carrello"])){
               $ilcarrello=$_SESSION["carrello"];
            }



            $data=array(
                "PAGE_TITLE"=>"Carrello",
                "modo"=>"carrello",
                "carrello"=>$ilcarrello,
                "sezione"=>"dashboard-lista"
            );
         }
         
         $this->parser->parse('carrello',$data);
          
          
      }
      
      
      
      public function ajx_carrello($a=null){
         if(!_is_logged()) redirect('/');
          
         header("Content-type:text/json");
         $carrello=(isset($_SESSION["carrello"]))?$_SESSION["carrello"]: array();
         
         $data=array(
             "PAGE_TITLE"=>"Il tuo Carrello",
             "carrello"=>$carrello,
             "modo"=>"ajax"
         );
         
         $p=$this->load->view('limap/_ajax_cart_box',$data,true);
         
         $data["html"]=$p;
         
         
         echo json_encode($data);
         
         exit;
      }
      
      
      
      
      public function getCostiZone($regione=null){
          
          
          if(!_is_logged()) redirect('/');
          
          header("Content-type:text/json");
          
          $data=$this->user->get_costi_Spedizione();
          
          echo json_encode($data);
          
         
          exit;
      }
      
      public function savecart(){
          if(!_is_logged()) redirect('/');
          
          
          $stato=$this->user->savePreventivo($_SESSION["carrello"]);
          
          if($stato>0){
              $_SESSION["carrello"]=null;
              unset($_SESSION["carrello"]);
              //redirect("dashboard/lista/preventivi");
          }
          
          $this->output->set_header('Content-Type: text/json; charset=utf-8');
          $data["redirect"]='dashboard/lista/preventivi';
          
          echo json_encode($data);
          
          exit;
      }
      
      
      
      
      
      public function carrello($products=null){
         
         if(!_is_logged()) redirect('/');
          
         addCSS(array(
             "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css"
         ));
         addJS(array(
             "public/js/carrello.js"));
         
         
         $ilcarrello=null;
         if(isset($_SESSION["carrello"])){
            $ilcarrello=$_SESSION["carrello"];
         }
         
         
         
         $data=array(
             "PAGE_TITLE"=>"Carrello",
             "modo"=>"carrello",
             "carrello"=>$ilcarrello,
             "sezione"=>"dashboard-lista"
         );
         
         
         
         $this->parser->parse('carrello',$data);
         
         
      }
      
      
     /**
      * Mostrato sulla pagina di conferma ordine.
      * @param type $code
      */
     public function confermaordine($code=null){
         
         if(!_is_logged()) redirect('/');
         
         //addCSS(array("public/bower_components/AdminLTE/plugins/iCheck/flat/green.css" ));
         //addJS(array("public/js/confermaordine.js"));
         
         
         //prelevo i costi di spedizione utente
         $spedizione=$this->user->get_costi_Spedizione();//valore spedizione
         $totale=0;
         
         if($code>0){
             
            $ordine=$this->user->getPreventivo($code);
            $ordine=$ordine[0];
            $costosped=$ordine->totaleArticoli()*($spedizione["costo_fisso"]); 
                         
            $totale=($ordine->getTotale()+$costosped);
            $totale+=($totale*$ordine->iva)/100;
            
            
            if($ordine->stato==Ordine_model::STATO_BOZZA){
                $ordine->generaOrdine($totale);//genero l'ordine solo se il preventivo è in bozza
                //se il preventivo è in stato di attesa pagamento significa che l'accesso alla pagina è già avvenuto nella transazione
                //disattiviamo anche il pulsante di pagamento dal preventivo
            }else{
                
            }
            
            
         }
         
         
         
         $data=array(
             "PAGE_TITLE"=>"Carrello",
             "modo"=>"ordine",
             "modelloordine"=>$ordine,
             "costosped"=>$costosped,
             "spedizione"=>$spedizione,
             "totale"=>$totale
         );
         
         
         
         $this->parser->parse('conferma_ordine',$data);
         
         
      }


      public function eliminaordine($codice){
          
          if($codice!="" && $codice!=" "){
              $preventivo=$this->user->getPreventivo($codice);
              if(count($preventivo)>0){
                $preventivo=$preventivo[0];
                //print_r($preventivo);
                if( $preventivo->stato==Preventivo_model::STATO_BOZZA ){
                   $preventivo->elimina();
                }
              }
              
          }
          
      }


      /*
      public function guestlogin(){
          
            $uid=uniqid();
            $session_hash=MD5($uid.time());
            $status=array(
                "status"=>true,
                "GUEST_ID"=>$uid,
                "sessionhash"=>$session_hash,
                "userid"=> session_id(),
                "LOGGEDIN"=>TRUE
            );
            $_SESSION["LOGGEDIN"]=true;
            $_SESSION["GUEST_ID"]=$uid;
            $_SESSION["token"]=$session_hash;
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            //set_cookie("sessione",$status,mktime()*24*10);
            $this->session->set_userdata('LOGGEDIN', $status);
            echo json_encode( $status );
            
            
            exit;
      }
        */
      
      
      
      /**
       * Richiama una funzione ajax
       * @param type $provincia
       */
      public function getComuni($provincia){
          
          $this->output->set_header('Content-Type: application/json; charset=utf-8');
          
          $status=null;
          
          if( $provincia>0 ){
             
              $query2=$this->db->query("SELECT * FROM comuni "
                      . " WHERE denominazione_provincia LIKE (SELECT nome_2 FROM province WHERE cod_ident=?)",
                      array($provincia)
              );
              $comuniprovincia=$query2->result_array();
              $status=$comuniprovincia;
         }
         
         echo utf8_decode((json_encode($status)));
          
         
      }

      public function signin(){
          
          $username=strip_tags($_POST["username"]);
          $password=sha1(strip_tags($_POST["password"]));
          
          $status["status"]=false;
          $user=$this->user->login($username,$password);
          
          //print_r($user);
          $statoservizio=$this->azienda->getStatusAccount();
          //print_r($statoservizio);
              
          if(isset($user) && $user["type"]>=1){
              
            
            if( $user["status"]==1 /*&& $this->azienda->serivizioAttivo()*/  ){
                  
                
                $session_hash=MD5(uniqid().time());
                
                $status=array(
                    "status"=>true,
                    "userid"=>$user["iduser"],
                    "sessionhash"=>$session_hash,
                    "business"=>$user["owner"],
                    "username"=>$user["username"]
                ); 
                //$_SESSION["LOGGEDIN"]=true;
                $_SESSION["token"]=$session_hash;
                
                $this->output->set_header('Content-Type: application/json;charset=utf-8');
          
                //set_cookie("sessione",$status,mktime()*24*10);
                $this->session->set_userdata('LOGGEDIN',$status);
                
                save_stream_log(
                        array("azione"=>"login",
                            "descrizione"=>"login",
                            "style"=>""
                        ));
                
                //se il servizio non è attivo
                if(!$this->azienda->serivizioAttivo()){
                    if( $user["status"]==1 ){

                        echo json_encode( $status );
                        
                    }else{
                        
                        $this->session->set_userdata('LOGGEDIN',null);
                        session_destroy();
                        unset($_SESSION);
                        echo json_encode( array("exiperd"=>1,"user"=>$user) );
                        
                        
                    }
                }else{
                     echo json_encode( $status );
                }
                
            }else if( $user["status"]== -1 ){

                echo json_encode( array("notactived"=>-1,"user"=>$user) );
            }
                
          }else{
              $this->output->set_status_header('501');
              echo "Restricted access";
          }
          
         
          exit;
          
          
      }
      
      
      
      /**
       * Tutti i metodi di validazione
       */
      public function validate($method){
          
          
          if(isset($method)){
            
            //$this->output->set_header('Content-Type: application/json; charset=utf-8');

            switch($method){
                case "email":
                   
                   $email=($_GET["email"]);
                    
                    //verifico la non presenza
                    $query2=$this->db->query("SELECT * FROM lm_users WHERE email=? ",
                       array($email) 
                    );
                    $n=$query2->num_rows();
                    if($n>0){
                        echo json_encode(array("status"=>false,"email"=>"Email existis"));
                        exit;
                    }
                    echo "true";
                   exit;
                   
                break;
                case "username":
                    
                    $username=($_GET["username"]);
                    //verifico la non presenza
                    $query2=$this->db->query("SELECT * FROM lm_users WHERE username = ? ",
                       array($username) 
                    );
                    $n=$query2->num_rows();
                    if($n>0){
                        echo json_encode(array("status"=>false,"username"=>"Username existis"));
                        exit;
                    }
                    
                    echo "true";
                    
                break;
                case "nome":
                    //stessa cosa di prima ma per le aziende
                   return true;
                    
                break;
            }
            
            
          }else{
              $this->output->set_status_header('501');
              echo "Restricted access";
          }
          exit;
      }
}
