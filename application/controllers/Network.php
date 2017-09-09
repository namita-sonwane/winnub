<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Network extends CI_Controller {
    
    
    
    var $_RESULTS_=false;//gestisce lo sttao dei risultati sulle view
    
    public function __construct() {
        
         parent::__construct();
         
         $this->load->library('parser');
         
         
         if(!_is_logged()){
             header("location:".base_url());
         }else{
             //print_r();
             
             //$this->parser->('dashboard',$data);
         }

    }
    
    
    public function index(){
         addJS(array(
            "public/js/network.js"
        ));
        addCSS(array(
            "public/css/timeline.css"
        ));
        
        
        $data=array(
            'PAGE_TITLE'=>t("Profilo Utente ").$username,
            "sezione"=>'network',
            "categoriabase"=>'utenti-add',
            
        );
        
        
        $this->parser->parse('network/network-table',$data);
    }
    
    
    public function getnetworkmessage($username){
        
        $codice=$this->user->resolveUsername($username);
        $this->load->model("Messaggio_model");
        
        $limit=8;
        $limite=$limit;
        if( isset($_GET["limit"]) && $_GET["limit"]>0){
           $limit=" ".($_GET["limit"]+1).",8";
           
        }
        
        $messaggi = $this->Messaggio_model->getMessage($codice,$limit);
        
        $messaggi_tmp=array();
        foreach($messaggi as $mess){
            
            $utentedettaglio=User_model::getUser($mess->user);
            if(count($utentedettaglio)>0){
                $utentedettaglio=$utentedettaglio[0];
                $messaggi_tmp[]=array(
                    "idmessaggio"=>$mess->idmessage,
                    "class"=>($codice==$mess->reciver)?"right":"",
                    "message"=>$mess->message,
                    "data"=>$mess->data,
                    "user"=>$utentedettaglio->username,
                    "immagine"=>"/".$utentedettaglio->getPhoto()
                );
                
                $limite=intval($_GET["limit"]+8);
            }
            
            
        }
        
        
        
        
        $this->output
                  ->set_content_type('application/json')
                  ->set_output(json_encode(array("messaggi"=>$messaggi_tmp,"limits"=>$limite)));
    }
    
    
    public function getuser($username){
        
        $codice=$this->user->resolveUsername($username);
        
        //print_r($codice);
        
        $this->detail($codice,$username);
        
    }




    public function stream(){
        
        $this->load->model("Stream_model");
        
        $stream=$this->Stream_model->getStream();
        
        $this->output
                  ->set_content_type('application/json')
                  ->set_output(json_encode($stream));
        
    }
    
    
    public function detail($codice=null,$username=null){
        
        addJS(array(
            "public/js/network.js"
        ));
        addCSS(array(
            "public/css/timeline.css"
        ));
        
        
        $data=array(
            'PAGE_TITLE'=>t("Profilo Utente ").$username,
            "sezione"=>'network',
            "categoriabase"=>'utenti-add',
            "codice"=>$codice,
            
        );
        
        
        $this->parser->parse('network/profilo-utente-network',$data);
    }
    
    
    public function recentchat(){
        
        
        $codice=$this->user->resolveUsername($username);
        $this->load->model("Messaggio_model");
        
        $recenti = $this->Messaggio_model->getRecentChat($codice);
        
        
        $this->output
                  ->set_content_type('application/json')
                  ->set_output(json_encode($recenti));
         
    }
    
    
    public function sendMessage(){
        
        $codice=$this->user->resolveUsername($_REQUEST["reciver"]);
        
        
        $messaggio=array(
            "user"=>$_SESSION["LOGGEDIN"]["userid"],
            "reciver"=>$codice,
            "esternal"=>"",
            "subject"=>"CHAT-MESSAGE",
            "message"=>$_REQUEST["messaggio"],
            "data"=>date("Y-m-d H:i:s"),
            "letto"=>"00"
        );
        
        
        //print_r($_REQUEST);

       $this->db->insert('lm_message', $messaggio);
       $utentedettaglio=User_model::getUser($_SESSION["LOGGEDIN"]["userid"]);
        
        if(count($utentedettaglio)>0){
           
            $utentedettaglio=$utentedettaglio[0];
           
            $messaggi_tmp=array(
                         "idmessaggio"=>'',
                         "class"=>"right",
                         "message"=>$messaggio["message"],
                         "data"=>$messaggio["data"],
                         "immagine"=>"/".$utentedettaglio->getPhoto(),
                         "user"=>$utentedettaglio->username
            );
            
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($messaggi_tmp));
        
    }
    
    
}