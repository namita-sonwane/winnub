<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fornitori extends CI_Controller {
    
      public function __construct(){
        
        parent::__construct();
            $this->load->model('Fornitori_model');
         if( !_is_logged() ){
             header("location: ".base_url());
         }
         
        $this->load->library('parser');
        
         addJS(array(
             "bower_components/jquery-validation/dist/jquery.validate.min.js","public/js/fornitori.js"));
          
      }     

  
      
      public function getall(){
          
          
          
          
          $fornitori=Fornitori_model::getAll();
          
          
          $this->output
                  ->set_content_type('application/json')
                  ->set_output(json_encode($fornitori));
          
      }
      
      public function getfornitore($codice){
          
          $fornitore=Fornitori_model::get($codice);
          
          
          $this->output
                  ->set_content_type('application/json')
                  ->set_output(json_encode($fornitore[0]));
          
      }
      
      
      
      
      
    


      public function nuovo(){
         
            
            $this->edit(0);
          
      }
      
      
        public function save(){
            //print_r($_REQUEST);
            header("content-type: text/json");
            
            if( $_REQUEST["savefornitori"]!=1 ) redirect ("/fornitori/");
            
            $status=false;
            
            $codice=trim($_REQUEST["codfornitori"]);
            
            if( isset($_REQUEST["nome"]) && isset($codice) ){
                
                if($codice>0){
                    $fornitore=Fornitori_model::get($codice);
                }else{
                    $fornitore=new Fornitori_model();
                }
                
                if(is_array($fornitore))
                {
                    $fornitore=$fornitore[0];
                }
                
                if(is_object($fornitore)){
                
                    $fornitore->nome_fornitori=$_REQUEST["nome"];
                    $fornitore->cognome_fornitori=$_REQUEST["cognome"];
                    $fornitore->rag_sociale_fornitori=$_REQUEST["rag_sociale"];
                    $fornitore->comune=$_REQUEST["comune"];
                    $fornitore->indirizzo=$_REQUEST["indirizzo"];
                    $fornitore->provincia=$_REQUEST["provincia"];
                    $fornitore->cap=$_REQUEST["cap"];
                    $fornitore->PIVA=$_REQUEST["piva"];
                    //$fornitore->cod_fiscale=$_REQUEST["cod_fiscale"];
                    $fornitore->note=$_REQUEST["note"];
                    $fornitore->listino="";
                    $fornitore->email=$_REQUEST["email"];
                    $fornitore->telefono=$_REQUEST["telefono"];
                    $fornitore->mobile=$_REQUEST["mobile"];
               
					$product_group = '';	   
			   		if($_REQUEST["product_group"] != "0")
					{
						$product_group = $_REQUEST["product_group"];
					}
					else
					{
						$product_group = $_REQUEST["another_pr_grp"];
					}
					
				   $fornitore->product_group = $product_group;
			   
			   
                  
                    if($fornitore->codfornitori > 0){

                        //$cliente->codcliente=$codice;
                        $fornitore->update($fornitore->codfornitori);
                        $id=$fornitore->codfornitori;

                    }else{
                       $fornitore->codfornitori;
                        $id=$fornitore->insert();

                        $fornitore->codfornitori=$id;
                        
                        
                    }
                
                
                    $status=true;
                    _report_log(array("message"=>"Salvo fornitori :".json_encode($fornitore)."| $id ","error"=>" STATUS : $status "));
          
                }else{
                    $status=false;
                    _report_log(array("message"=>"Salvo fornitori :".json_encode($fornitore)."| $id ","error"=>" ERRORE : $status "));
          
                }
                
            }
            
            
            if($id>0){
                echo json_encode(array("status"=>$status,"id"=>$id,"fornitore"=>$fornitore));
            }else{
                echo json_encode(array("status"=>null,"id"=>0,"fornitore"=>null));
            }
            
            redirect('/fornitori');
            exit;
        }


        public function edit($codice=null){
            if(!_is_logged()) redirect('/');
            
            

            addCSS(array( ));
            
            
            addJS(array(
                "bower_components/jquery-validation/dist/jquery.validate.min.js",
                "public/js/fornitori.js"));
            
            
            $codice_tmp    =   str_replace('"',"",($codice));
            $fornitore   =  Fornitori_model::get($codice_tmp);
            
            if( $codice==0 || is_object($fornitore[0])){
                
                if(isset($fornitore[0])){
                    if( !$fornitore[0]->verificaAppartenenza() ){



                    }
                }
                
                
                 $data=array(
                "PAGE_TITLE"=>"fornitori",
                "PAGE_SUB_TITLE"=>"nuovo dei fornitori",
                "sezione"=>"fornitori",
                "codice"=>$codice_tmp,
                "pagina_active"=>"nuovo",
                "fornitore"=>$fornitore
                );
                $this->parser->parse('fornitori/editor-fornitori',$data);
                
            }else{
                
                $data=array(
                "PAGE_TITLE"=>"fornitori",
                "PAGE_SUB_TITLE"=>"nuovo dei fornitori",
                "sezione"=>"fornitori",
                "codice"=>$codice_tmp,
                "pagina_active"=>"nuovo",
                "fornitore"=>$fornitore
                );
                
                $this->parser->parse('fornitori/error-not-found',$data);
                
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
            
            $fornitore=Fornitori_model::get($codice);
            
            $data=array();
            
            $data["codice"]=$codice;
            $data["subject"]=$fornitore;
            $data["status"]=0;
            
            if(is_array($fornitore)){
                 $fornitore=$fornitore[0];
            }
            
            if($fornitore){
            
                if(  (MD5(intval($fornitore->codfornitori))==$codice || $fornitore->codfornitori==$codice) &&
                        $owner==$fornitore->utente
                ){

                    $fornitore->delete();

                    $data["status"]=1;


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
                  "https://app.winnub.com/bower_components/jquery-validation/dist/jquery.validate.min.js",
                  "public/js/fornitori.js"));

              $data=array(
                   "PAGE_TITLE"=>"Fornitori",
                   "PAGE_SUB_TITLE"=>"gestione dei fornitori",
                   "sezione"=>"fornitori",
                   "pagina_active"=>"gestione1",
                   "codice"=>$codice
              );
              $this->parser->parse('fornitori/fornitori-gestione',$data);
        }
        

           
}
      
      