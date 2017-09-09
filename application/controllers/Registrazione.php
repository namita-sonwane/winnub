<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrazione extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
      public function __construct(){
          
        parent::__construct();
        
        if( _is_logged() ){
            header("location: /dashboard");
        }
         
         
        $this->lang->load('emails_lang');//importante deve esserci il file per ogni lingua
		
        
         
        $this->load->library('parser');
         
        
         
         
      }
      
        public function installconfirm(){
            
            print_r($_REQUEST);
            
            exit;
        }
      
        
        
        public function signup($step=null){
            
            
            $this->load->library('email');
             
            $statusregister=null;
            
            
            
            
            if(  isset($_REQUEST["singupsend"]) && 
                    isset($_REQUEST["registrazione"])
                    
                    && (    isset($_REQUEST["nomeazienda"]) OR $_REQUEST["codiceazienda"]>0 )
                    
                    ){
                
                
                
                if(isset($_REQUEST["codiceazienda"])){

                    $idazienda=$_REQUEST["codiceazienda"];
                    $ischild=true;
                    
                }else{
                
                    $nomeazienda=strip_tags($_REQUEST["nomeazienda"]);
                    $datiazienda=array(
                        "nome"=>$nomeazienda,
                        "codice_subdomain"=>"NULL"
                    );
                    $idazienda=$this->azienda->creaAzienda($datiazienda);
                    
                }
                
                
                if($idazienda>0){
                    
                    if( isset($_REQUEST["password"]) && $_REQUEST["password"]!="" ){
                        $password = sha1( $_REQUEST["password"]);
                    }else{
                        die("Invalid request, verifica i parametri inseriti");
                        exit;
                    }
                    
                    $email=strip_tags($_REQUEST["email"]);
                    $username=strip_tags($_REQUEST["username"]);
                    
                    $utente=array(
                        "username"=>$username,
                        "password"=>$password,
                        "email"=>$email,
                        "data_reg"=>date("Y-m-d h:i:s"),
                        "status"=>1,
                        "owner"=>$idazienda,
                        "type"=>1,
                        "user_model"=>(($ischild)?2:1)
                    );
                    

                    $profilo=array(
                        "nome"=>" Nome ",
                        "cognome"=>" Cognome "
                    );

                    $fatt=array(
                        "piva"=>$_REQUEST["piva"],
                        "cod_cf"=>$_REQUEST["piva"]
                    );
                    
                    $status=$this->user->creautente($utente,$profilo,$fatt);
                    if($status>0){
                         
                         
                        $destinatario=$email;
                         
                        //tutto è andato bene...
                        //
                        //
                        //logghiamo l'amico
                        $errors='';
                        $ps=trim($_REQUEST["password"]);
                        
                        $logged=winnub_caller(
                              'https://app.winnub.com/'.getLanguage().'/signin',
                               array(
                                   "username"=>$username,
                                   "password"=>$ps
                              ),'POST',$errors
                        );
                        //effettuo la chiamata verso wordpress per aggiungere il nuovo account
                        //
                        if($logged){
                            _report_log(array("message"=>" HO LOGGATO VIA CURL ".json_encode($logged)."   ","error"=>" $errors "));
                            
                        }
                        
                        $cod_email=crypt($email,PUBLIC_SALT);
                         
                        //invio email di registrazione
                       
                        $data=array(
                            "azienda"=>"$idazienda",
                            "urlaccesso"=>"http://app.winnub.com/".getLanguage()."/login?econfirm=$cod_email&tk=".time()
                        );
                        
                        
                        
                        // prepare email
                        $this->email
                            ->from('no-reply@winnub.com','Winnub Account')
                            ->to($destinatario)
                            ->subject(t("Benvenuto su Winnub"))
                            ->message($this->load->view('email/email_registrazione',$data,true))
                            ->set_mailtype('html');

                        // send email
                        $this->email->send();
                        
                        
                          // prepare email
                        $this->email
                            ->from('no-reply@winnub.com','Winnub Registrazione')
                            ->to("contact@winnub.com")
                            ->subject("Registrazione nuovo utente")
                            ->message(" Si è registrato un nuovo utente su winnub.com email: $destinatario - Username: $username ")
                            ->set_mailtype('html');
                        
                        // send email
                        $this->email->send();
                        
                        
                        save_stream_log(
                            array(
                                "azione"=>"registrazione",
                                "descrizione"=>"registrazione",
                                "style"=>""
                            ),
                            $status
                        );
                        
                        
                        
                        _report_log(array("message"=>"Send Email ".json_encode($data)."| ","error"=>""));
                         
                        //provo a loggare l'utente
                         
                        redirect("/".getLanguage()."dashboard");
                        
                        exit;
                     }
                
                }else{
                    _report_log(array("message"=>"Error Register".json_encode($data)."| ","error"=>"Registrazione id Azienda nullo"));
                    
                    
                }
                            
                
            }else{
                
                switch($step){
                    
                    case "installconfirm":
                        
                        $this->installconfirm();
                        
                    break;
                    
                    case "install":
                        
                         redirect("/".getLanguage()."dashboard");
                        
                        
                         addJS(array( "public/js/particles.min.js",
                             "bower_components/jquery-validation/dist/jquery.validate.min.js",
                             "public/js/installazione.js"));

                            $data=array(
                                "PAGE_TITLE"=>t("Winnub configura profilo"), 
                                "_body_class"=>"hold-transition register-page",
                                "_WRAPID_"=>"wib_login",
                                "simpleheder"=>true

                            );
                            //se $a non ha valore non esiste nessuna chiama o codice di accesso..
                            //includo l'header
                            $this->load->view('limap/_header',$data);
                            $this->load->view('registrazione_success',$statusregister);
                            $this->load->view('limap/_footer',$data);
                            
                    break;

                    default:
                        
                        
                       $dati=infoAzienda();
                        
                            
                        addJS(
                           array("public/js/particles.min.js",
                            "bower_components/jquery-validation/dist/jquery.validate.min.js",
                            "public/js/registrazione.js",
                         ));

                        $data=array(
                            "PAGE_TITLE"=>"Registrazione", 
                            "_body_class"=>"hold-transition register-page",
                            "_WRAPID_"=>"wib_login",
                            "infoazienda"=>$dati,
                            "statusregister"=>$statusregister
                        );
                        //se $a non ha valore non esiste nessuna chiama o codice di accesso..
                        //includo l'header
                        $this->load->view('limap/_header',$data);
                        $this->load->view('registrazione',$data);
                        $this->load->view('limap/_footer');
                }
            }
            
            
        }
        
        
      
    public function completato(){


        echo "Pagina registrazione avvenuta...step di configurazione";

        exit;

    }


    public function restore(){

        addJS(array("public/js/registrazione.js"));

        $data=array(
            "PAGE_TITLE"=>"Registrazione", 
            "_body_class"=>"hold-transition register-page"

        );
        //se $a non ha valore non esiste nessuna chiama o codice di accesso..
        //includo l'header
        $this->load->view('limap/_header',$data);
        $this->load->view('recupera_account');
        $this->load->view('limap/_footer');
    }


    public function index(){
          
         
         if(isset($_REQUEST["registrazione"])){
             
             
             //print_r($_REQUEST); 
             //
             //crea profilo utente
             //registrazione=1
             //email=
             //tipologia=
             //
             //
            if(!isset($_REQUEST["password"])){
                $password = md5( str_shuffle( "0123456789abcdefghijklmnoABCDEFGHIJ" ) );
            }else{
                $password = strip_tags(trim($_REQUEST["password"]));
            }
            
            $utente=array(
                "username"=>$_REQUEST["email"],
                "password"=>$password,
                "email"=>$_REQUEST["email"],
                "data_reg"=>date("Y-m-d h:i:s"),
                "status"=>0,
                "type"=>$_REQUEST["tipologia"],
                "user_model"=>($_REQUEST["tipologia"]==1)?1:2
            );
            
            $profilo=array(
                "nome"=>$_REQUEST["nome"],
                "cognome"=>$_REQUEST["cognome"]
            );
            
            $fatt=array("piva"=>$_REQUEST["piva"],
                "cod_cf"=>$_REQUEST["piva"]);
            
             $status=$this->user->creautente($utente,$profilo,$fatt);
             if($status>0){
                 redirect("/"+getLanguage()+"/registrazione/completato");
             }
             
         }
         
        addCSS(array(
             "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css"
        ));
        addJS(array("public/js/registrazione.js"));
          
        $data=array(
             "PAGE_TITLE"=>"Registrazione", 
             "_body_class"=>"hold-transition register-page"     
        );
         
         $query=$this->db->query("SELECT * FROM lm_type_users ",array());
         $tip = $query->result_array();
               
         $tipologie=array(
             "tipologie"=>$tip
         );
         
        //includo l'header
         $this->load->view('limap/_header',$data);
         $this->load->view('registrazione',$tipologie);
         $this->load->view('limap/_footer');
         
         
    }
      
      
      
      
        
        
        
}
