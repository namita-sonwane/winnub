<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clienti extends CI_Controller {
    
      public function __construct(){
        
        parent::__construct();
        
        
        $this->lang->load('clients_lang');//importante deve esserci il file per ogni lingua
		
           
         if( !_is_logged() ){
             header("location: ".base_url());
         }
         
         $this->load->library('parser');
        
         addJS(array("public/js/clienti.js"));
         
      }
      
      
      
      public function getall(){
          
          $clienti=Cliente_model::getAll();
          
          
          $this->output
                  ->set_content_type('application/json')
                  ->set_output(json_encode($clienti));
          
      }
      
      public function getcliente($codice){
          
          $cliente=Cliente_model::get($codice);
          
          
          $this->output
                  ->set_content_type('application/json')
                  ->set_output(json_encode($cliente[0]));
          
      }
      
      
      
      
      
    


      public function nuovo(){
         
            
            $this->edit(0);
          
      }
      
      
        public function save(){
            //print_r($_REQUEST);
            header("content-type: text/json");
            
            if( $_REQUEST["savecliente"]!=1 ) redirect ("/clienti/");
            
            $status=false;
            
            $codice=trim($_REQUEST["codcliente"]);
            
            if( isset($_REQUEST["nome"]) && isset($codice) ){
                
                if($codice>0){
                    $cliente=Cliente_model::get($codice);
                }else{
                    $cliente=new Cliente_model();
                }
                
                if(is_array($cliente))
                {
                    $cliente=$cliente[0];
                }
                
                if(is_object($cliente)){
                
                    $cliente->nome_cliente=$_REQUEST["nome"];
                    $cliente->cognome_cliente=$_REQUEST["cognome"];
                    $cliente->rag_sociale_cliente=$_REQUEST["rag_sociale"];
                    $cliente->comune=$_REQUEST["comune"];
                    $cliente->indirizzo=$_REQUEST["indirizzo"];
                    $cliente->provincia=$_REQUEST["provincia"];
                    $cliente->cap=$_REQUEST["cap"];
                    $cliente->PIVA=$_REQUEST["piva"];
                    $cliente->cod_fiscale=$_REQUEST["cod_fiscale"];
                    $cliente->note=$_REQUEST["note"];
                    $cliente->listino="";
                    $cliente->email=$_REQUEST["email"];
                    $cliente->telefono=$_REQUEST["telefono"];
                    $cliente->mobile=$_REQUEST["mobile"];
               
                
                    if($cliente->codcliente > 0){

                        //$cliente->codcliente=$codice;
                        $cliente->update($cliente->codcliente);
                        $id=$cliente->codcliente;

                    }else{

                        $id=$cliente->insert();

                        $cliente->codcliente=$id;
                        
                        save_stream_log(
                            array("azione"=>"new_client",
                                "descrizione"=>"crea nuovo cliente $id ",
                                "style"=>""
                            )
                        );
                        
                        
                    }
                
                
                    $status=true;
                    _report_log(array("message"=>"Salvo cliente :".json_encode($cliente)."| $id ","error"=>" STATUS : $status "));
          
                }else{
                    $status=false;
                    _report_log(array("message"=>"Salvo cliente :".json_encode($cliente)."| $id ","error"=>" ERRORE : $status "));
          
                }
                
            }
            
            
            if($id>0){
                echo json_encode(array("status"=>$status,"id"=>$id,"cliente"=>$cliente));
            }else{
                echo json_encode(array("status"=>null,"id"=>0,"cliente"=>null));
            }
            
            
            exit;
        }


        public function edit($codice=null){
            if(!_is_logged()) redirect('/');
            
            

            addCSS(array( ));
            
            
            addJS(array(
                "bower_components/jquery-validation/dist/jquery.validate.min.js",
                "public/js/clienti.js"));
            
            
            $codice_tmp    =   str_replace('"',"",($codice));
            $cliente   =  Cliente_model::get($codice_tmp);
            
            if( $codice==0 || is_object($cliente[0])){
                
                if(isset($cliente[0])){
                    if( !$cliente[0]->verificaAppartenenza() ){



                    }
                }
                
                
                 $data=array(
                "PAGE_TITLE"=>t("Clienti"),
                "PAGE_SUB_TITLE"=>"nuovo dei cliente",
                "sezione"=>"clienti",
                "codice"=>$codice_tmp,
                "pagina_active"=>"nuovo",
                "cliente"=>$cliente
                );
                $this->parser->parse('clienti/editor-cliente',$data);
                
            }else{
                
                $data=array(
                "PAGE_TITLE"=>"Clienti",
                "PAGE_SUB_TITLE"=>"nuovo dei cliente",
                "sezione"=>"clienti",
                "codice"=>$codice_tmp,
                "pagina_active"=>"nuovo",
                "cliente"=>$cliente
                );
                
                $this->parser->parse('clienti/error-not-found',$data);
                
            }
            
            
           
            
        }
        
        
        public function delete($codice){
            
            if(!_is_logged()) die('Access restricted!');
            
            //print_r($codice);
            
            $owner=$_SESSION["LOGGEDIN"]["userid"];
            
            if(is_string($codice)){
               $codice=str_replace('"','',$codice);
            }else{
               $codice=intval($codice)*1;
            }
            
            $cliente=Cliente_model::get($codice);
            
            $data=array();
            
            $data["codice"]=$codice;
            $data["subject"]=$cliente;
            $data["status"]=0;
            
            if(is_array($cliente)){
                 $cliente=$cliente[0];
            }
            
            if($cliente){
            
                if(  (MD5(intval($cliente->codcliente))==$codice || $cliente->codcliente==$codice) &&
                        $owner==$cliente->utente
                ){

                    $cliente->delete();

                    $data["status"]=1;
                    
                    save_stream_log(
                            array("azione"=>"delete_client",
                                "descrizione"=>"cancello cliente $codice ",
                                "style"=>""
                            )
                        );


                    //redirect("/clienti?cd=$cliente->codcliente");
                }
            
            }
            
            
            return $this->output
                ->set_content_type('text/json')
                ->set_status_header(200)
                ->set_output(json_encode($data));
              
            
        }

      
        public function index($nome=null) {
             if(!_is_logged()) redirect('/');

              addCSS(array(
                  "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css"
              ));
              addJS(array(
                  "bower_components/jquery-validation/dist/jquery.validate.min.js",
                  "public/js/clienti.js"));

              $data=array(
                   "PAGE_TITLE"=>"Clienti",
                   "PAGE_SUB_TITLE"=>"gestione dei clienti",
                   "sezione"=>"clienti",
                  "pagina_active"=>"gestione",
                   "codice"=>$codice
              );
              $this->parser->parse('clienti/clienti-gestione',$data);
        }
        
        /**
         * Analizza clienti
         */
        public function analyse_customer($nome=null) {
             if(!_is_logged()) redirect('/');

                addCSS(array(
                    "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css"
                ));

                if($nome != '')
                {

                      $this->load->model('Cliente_model');			

                      $client_name_obj =  $this->Cliente_model->getAnaluseCustomerInfo($nome);
                      $client_name = $client_name_obj[0]->nome_cliente ;
                      if(empty($client_name))
                      {					
                              $client_name = $client_name_obj[0]->rag_sociale_cliente ;
                      }

                      $data=array(
                                "PAGE_TITLE"=>"Clienti",
                                "PAGE_SUB_TITLE"=>"Analizza Cliente",
                                "sezione"=>"clienti",
                                "pagina_active"=>"analizza",
                                "codice"=>$codice,
                                "client_id"=>$nome,
                                "client_name"=>$client_name,				   
                      );
                      $this->parser->parse('clienti/analyse_customer',$data);
                }
                else
                {
                        redirect('/');
                }
			 
        }		
       
}
      
      