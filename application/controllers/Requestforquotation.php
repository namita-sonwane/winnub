<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requestforquotation extends CI_Controller {    
    
        public function __construct() {
           parent::__construct();    
				
				$this->load->model('Rfqs_model');		   
        	     if( !_is_logged() ){
                 header("location: ".base_url());
                }        
				$this->load->library('parser');
				$this->load->library('session');// load session library 
				$this->load->library('upload');// load file upload library
				$this->load->helper('form'); // load form library
				$this->load->helper('url'); //// load url library 
				$this->load->helper('html');// load html library
				$this->load->library('form_validation');// load form_validation library
				$this->load->database();// load database library				
				//$this->load->model('Compito_model');// load model library
				//addJS(array("public/js/rfqs.js"));
        }
    
      
	  public function edit($codice=null){
            if(!_is_logged()) redirect('/');
            
            $codice_tmp    =   str_replace('"',"",($codice));
            $rfqs   =  Rfqs_model::get($codice_tmp);
            
            if( $codice==0 || is_object($rfqs[0])){
                
                if(isset($rfqs[0])){
                    if( !$rfqs[0]->verificaAppartenenza() ){

                    }
                }
                
                
                 $data=array(
              
				"PAGE_TITLE"=>"Manage Rfqs",
			   "PAGE_SUB_TITLE"=>"Manage Rfqs",
			   "sezione"=>"rfqs",
			  "pagina_active"=>"rfqs",
			   "codice"=>$codice,
			    "rfqs_data"=>$rfqs
                );
                $this->parser->parse('rfq/nuovo_form',$data);
                
            }else{
                
                $data=array(
				
                "PAGE_TITLE"=>"Manage Rfqs",
			   "PAGE_SUB_TITLE"=>"Manage Rfqs",
			   "sezione"=>"rfqs",
			  "pagina_active"=>"rfqs",
			   "codice"=>$codice,
			   "rfqs_data"=>$rfqs
                );                
                $this->parser->parse('rfq/error-not-found',$data);         
            }
            
        }
	  public function getall(){
          
          $rfqs=Rfqs_model::getAll();
          $this->output
                  ->set_content_type('application/json')
                  ->set_output(json_encode($rfqs));
          
      }
      
      public function getfornitore($codice){
          
          $rfqs=Rfqs_model::getAll();
          $this->output
                  ->set_content_type('application/json')
                  ->set_output(json_encode($rfqs[0]));
          
      }

      public function index(){
      		 $data=array(
                   "PAGE_TITLE"=>"RFQ ",
                   "PAGE_SUB_TITLE"=>"gestione dei RFQ ",
                   "sezione"=>"RFQ ",
                  "pagina_active"=>"RFQ",
                   "codice"=>$codice
              );

        $this->load->view('rfq/nuovo_form',$data);

      }
      /************************************
      *Function : save()
	  * Parameter@ array()
      ***********************************/
      public function save(){

		if(isset($_REQUEST['codrfq'])  && $_REQUEST['codrfq'] > 0)
		{
			$this->Edit_RFQs();
		}
		else
		{
			$tt=rand(10,10000);     
           $userfile1= $tt.$_FILES['rfq_fiel']['name'];
           if (!empty($_FILES['rfq_fiel']['name'])){
           $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "msword" => "application/msword","doc" => "application/doc", "pdf" => "application/pdf", "xls" => "application/xls");
                  $filename = $_FILES["rfq_fiel"]["name"];
                  $filetype = $_FILES["rfq_fiel"]["type"];
                  $filesize = $_FILES["rfq_fiel"]["size"]; 
                  $filename1= $tt.$_FILES['rfq_fiel']['name']; 
                  // Verify file extension
                  $ext = pathinfo($filename1, PATHINFO_EXTENSION);
                  if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file Video format.");
                   // Verify file size - 5MB maximum
                  $maxsize = 5 * 2448 * 2448;
                  if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");    
                  // Verify MYME type of the file
                  if(in_array($filetype, $allowed)){
                      // Check whether file exists before uploading it
                      if(file_exists("uploads/" . $filename1)){
                          //echo $msg= $filename1 . " is already exists.";
                          $msg= $this->session->set_flashdata('msg', $filename1 . " is already exists.");
                      } else{
                          move_uploaded_file($_FILES["rfq_fiel"]["tmp_name"], "uploads/" . $filename1);
                          $msg= $this->session->set_flashdata('msg', 'Your file  was uploaded successfully. !!');

                      } 
                  }               
        }else{
          $userfile1=$this->input->post('rfq_fiel');
          $filetype = $_FILES["rfq_fiel"]["type"];
          }



          $this->form_validation->set_rules('nome', 'nome', 'required');
          $this->form_validation->set_rules('description', 'description', 'required');
          $this->form_validation->set_rules('process_services', 'Process services', 'required');
          $this->form_validation->set_rules('rfq_fiel', 'taskdoc', 'required');
          $this->form_validation->set_rules('materials', 'materials', 'required');
          $this->form_validation->set_rules('fcolor', 'fcolor', 'required');
          $this->form_validation->set_rules('quantity', 'quantity', 'required');
          $this->form_validation->set_rules('quantityperyear', 'quantityperyear', 'required');
          $this->form_validation->set_rules('protoType', 'protoType', 'required');
          $this->form_validation->set_rules('hasdeadline', 'hasdeadline', 'required');
          $this->form_validation->set_rules('deadlinedate', 'deadlinedate', 'required');
          $this->form_validation->set_rules('shippingcountry', 'shippingcountry', 'required');



          $nome = $this->input->post('nome');
          $description = $this->input->post('description');
          $process_services = $this->input->post('process_services');
          $materials = $this->input->post('materials');
          $fcolor = $this->input->post('fcolor');         				
          $quantity = $this->input->post('quantity');
          $quantityperyear = $this->input->post('quantityperyear');
          $protoType = $this->input->post('protoType');
          $hasdeadline = $this->input->post('hasdeadline');
          $deadlinedate = $this->input->post('deadlinedate');
          $shippingcountry = $this->input->post('shippingcountry');
          $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
		  
		  
			$product_group = '';	   
			if($_REQUEST["product_group"] != "0")
			{
				$product_group = $_REQUEST["product_group"];
			}
			else
			{
				$product_group = $_REQUEST["another_pr_grp"];
			}
			
				
		  

           $formdata  = array('utente' =>$owner,                      
                              'nome'=>$nome,
                              'description'=>$description,
                              'process_services'=>$process_services,
                              'rfq_files'=>$userfile1,
                              'materials'=>$materials,
                              'fcolor'=>$fcolor,
                              'quantity'=>$quantity,
                              'quantityperyear'=>$quantityperyear,
                              'protoType'=>$protoType,
                              'hasdeadline'=>$hasdeadline,
                              'deadlinedate'=>$deadlinedate,
                              'shippingcountry'=>$shippingcountry,
                              'created_date'=>date('m/d/Y'),
							  'product_group'=>$product_group
                              );
                        
                         $this->db->insert('lm_Rfq', $formdata);
                        // $data['formdata'] = $this->load->Contatto_model->Insert($formdata);
                		//$this->load->view('contatto/nuovo_contatto',$data);
                		 $msg= $this->session->set_flashdata('msg', 'RFQs Created Successfully !!');
                		 redirect("requestforquotation");
				}
                   
     	 }

      /***************************************
      * Function @: contattolist() 
      *Response @:  get array()
      ***************************************/	

      public function compitolist(){
      	 $data=array(
                   "PAGE_TITLE"=>"Compito ",
                   "PAGE_SUB_TITLE"=>"gestione dei Compito  Lista",
                   "sezione"=>"Compito ",
                  "pagina_active"=>"gestione21",
                   "codice"=>$codice
              );
      	 $data['tasklist'] = $this->Compito_model->Getall();
      	$this->load->view('rfq/compitolist',$data);

      }

      /***************************************
      * Function : Edit() 
      *Parametre@ id and array()
      ***************************************/	
      public function getcompito($id){
          $task_id =$this->uri->segment(2); 
         
      		 $data=array(
                   "PAGE_TITLE"=>"Edit compito",
                   "PAGE_SUB_TITLE"=>"gestione dei compito  Lista",
                   "sezione"=>"compito ",
                  "pagina_active"=>"gestionet",
                   "codice"=>$codice
              );
      	 $data['singletask'] = $this->Compito_model->getsingle($task_id);      	
      	 $this->load->view('compito/compitoedit',$data);
      }
   /***************************************
      * Function : Edit_contatto() 
      *Parametre@ form value $_POST() 
      ***************************************/
      public function Edit_RFQs(){
      

        $tt=rand(10,10000);     
           $userfile1= $tt.$_FILES['rfq_fiel']['name'];
           if (!empty($_FILES['rfq_fiel']['name'])){
           $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "msword" => "application/msword","doc" => "application/doc", "pdf" => "application/pdf", "xls" => "application/xls");
                  $filename = $_FILES["rfq_fiel"]["name"];
                  $filetype = $_FILES["rfq_fiel"]["type"];
                  $filesize = $_FILES["rfq_fiel"]["size"]; 
                   $filename1= $tt.$_FILES['rfq_fiel']['name']; 
                  // Verify file extension
                  $ext = pathinfo($filename1, PATHINFO_EXTENSION);
                  if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file Video format.");
                   // Verify file size - 5MB maximum
                  $maxsize = 5 * 2448 * 2448;
                  if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");    
                  // Verify MYME type of the file
                  if(in_array($filetype, $allowed)){
                      // Check whether file exists before uploading it
                      if(file_exists("uploads/" . $filename1)){
                          //echo $msg= $filename1 . " is already exists.";
                          $msg= $this->session->set_flashdata('msg', $filename1 . " is already exists.");
                      } else{
                          move_uploaded_file($_FILES["rfq_fiel"]["tmp_name"], "uploads/" . $filename1);
                          $msg= $this->session->set_flashdata('msg', 'Your file  was uploaded successfully. !!');

                      } 
                  }               
        }else{
          $userfile1=$this->input->post('rfq_fiel');
          $filetype = $_FILES["rfq_fiel"]["type"];
          }



          $this->form_validation->set_rules('nome', 'nome', 'required');
          $this->form_validation->set_rules('description', 'description', 'required');
          $this->form_validation->set_rules('process_services', 'Process services', 'required');
          $this->form_validation->set_rules('rfq_fiel', 'taskdoc', 'required');
          $this->form_validation->set_rules('materials', 'materials', 'required');
          $this->form_validation->set_rules('fcolor', 'fcolor', 'required');
          $this->form_validation->set_rules('quantity', 'quantity', 'required');
          $this->form_validation->set_rules('quantityperyear', 'quantityperyear', 'required');
          $this->form_validation->set_rules('protoType', 'protoType', 'required');
          $this->form_validation->set_rules('hasdeadline', 'hasdeadline', 'required');
          $this->form_validation->set_rules('deadlinedate', 'deadlinedate', 'required');
          $this->form_validation->set_rules('shippingcountry', 'shippingcountry', 'required');


          $codrfq = $this->input->post('codrfq');
          $nome = $this->input->post('nome');
          $description = $this->input->post('description');
          $process_services = $this->input->post('process_services');
          $materials = $this->input->post('materials');
          $fcolor = $this->input->post('fcolor');                 
          $quantity = $this->input->post('quantity');
          $quantityperyear = $this->input->post('quantityperyear');
          $protoType = $this->input->post('protoType');
          $hasdeadline = $this->input->post('hasdeadline');
          $deadlinedate = $this->input->post('deadlinedate');
          $shippingcountry = $this->input->post('shippingcountry');
          $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
		  
		  $product_group = '';	   
			if($_REQUEST["product_group"] != "0")
			{
				$product_group = $_REQUEST["product_group"];
			}
			else
			{
				$product_group = $_REQUEST["another_pr_grp"];
			}

           $formdata  = array('utente' =>$owner,                      
                              'nome'=>$nome,
                              'description'=>$description,
                              'process_services'=>$process_services,
                              'rfq_files'=>$userfile1,
                              'materials'=>$materials,
                              'fcolor'=>$fcolor,
                              'quantity'=>$quantity,
                              'quantityperyear'=>$quantityperyear,
                              'protoType'=>$protoType,
                              'hasdeadline'=>$hasdeadline,
                              'deadlinedate'=>$deadlinedate,
                              'shippingcountry'=>$shippingcountry,
                              'created_date'=>date('m/d/Y'),
							  'product_group'=>$product_group
							  
                              );
       
           $this->Rfqs_model->update($codrfq,$formdata);
           $msg= $this->session->set_flashdata('msg', 'RFQ Update Successfully !!');
           redirect("requestforquotation/manage_rfqs" );
          
      }

   /***************************************
      * Function : delete() 
      *Parametre@ id
      ***************************************/
	  public function delete($codice){
            
            if(!_is_logged()) die('Access restricted!');
            
            //print_r($codice);
            
            $owner=$_SESSION["LOGGEDIN"]["userid"];
            
            if(is_string($codice)){
               $codice=str_replace('"','',$codice);
            }else{
               $codice=intval($codice)*1;
            }
            
            $rfqs=Rfqs_model::get($codice);
            
            $data=array();
            
            $data["codice"]=$codice;
            $data["subject"]=$rfqs;
            $data["status"]=0;
            
            if(is_array($rfqs)){
                 $rfqs=$rfqs[0];
            }
            
            if($rfqs){
            
                if(  (MD5(intval($rfqs->codrfq))==$codice || $rfqs->codrfq==$codice) &&
                        $owner==$rfqs->utente
                ){

                    $rfqs->delete();

                    $data["status"]=1;

                }
            
            }
            
            
            return $this->output
                ->set_content_type('text/json')
                ->set_status_header(200)
                ->set_output(json_encode($data));
              
            
        }


	  
	  
	  public function marketplace (){
      		 $data=array(
                   "PAGE_TITLE"=>"Marketplace",
                   "PAGE_SUB_TITLE"=>"Marketplace",
                   "sezione"=>"Marketplace",
                  "pagina_active"=>"Marketplace",
                   "codice"=>$codice
              );

        $this->load->view('marketplace/marketplace',$data);

      }
	  
	  public function manage_rfqs($nome=null){          
          $rfqs_data=Rfqs_model::getAll();
          //$this->output
                  //->set_content_type('application/json')
                  //->set_output(json_encode($rfqs));
				  
		
		 if(!_is_logged()) redirect('/');

		  addCSS(array(
			  "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css"
		  ));
		 addJS(array(
			  "bower_components/jquery-validation/dist/jquery.validate.min.js",
			  "public/js/rfqs.js"));

		  $data=array(
			   "PAGE_TITLE"=>"Manage Rfqs",
			   "PAGE_SUB_TITLE"=>"Manage Rfqs",
			   "sezione"=>"rfqs",
			  "pagina_active"=>"rfqs",
			   "codice"=>$codice,
			   "rfqs_data"=>$rfqs_data
		  );
		  $this->parser->parse('rfq/manage-rfqs',$data);
          
      }
	  
	  public function send($codice=0){
          
           if(!_is_logged()) redirect('/');
          error_reporting(0);
          ob_start('ob_gzhandler');
            addCSS(array(
                "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css"
            ));
           addJS(array("public/js/sendquote_rfq.js"));

            

            $getRfQs=$this->user->getRfQs($codice);
            if(count($getRfQs)){
               $getRfQs=$getRfQs[key($getRfQs)];  
            }
         
            if($codice!=""){
                
                $data=array(
                    "PAGE_TITLE"=>t("Invia-Rfqs"),
                    "modo"=>"invia-rfqs",
                    "carrello"=>array(),
                    "codicepreventivo"=>$codice,
                    "modellopreventivo"=>$getRfQs,
                    "sezione"=>"quote",
                    "pagina_active"=>"invia-rfqs",
                    
                );
                
                $this->parser->parse('rfq/invia_preventivo',$data);
				//$this->parser->parse('rfq/rfq_send',$data);
            
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

            
      }
	  
	   public function sendemail($codice){
          
          if(!_is_logged()) redirect('/');
          
            //print_r($_REQUEST);
			
			
            $modello_p=array(
                "style"=>""
            );
            
            $rfqs=$this->user->getRfQs($codice);
            if(count($rfqs)){
               $rfqs=$rfqs[key($rfqs)];   
               
               $data["rfqs"]=$rfqs;
               
              
            }
            
            $v = "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";
            
            $dataresult["status"]=false;
            
            $destinatario       =   strip_tags($_REQUEST["destinatario"]);
            $oggetto_messaggio  =   strip_tags($_REQUEST["oggetto"]);
            
            $verificamail=(bool)preg_match($v,$destinatario);
           
            if( isset($destinatario) && $verificamail ){
            
                $record_email   =   array(
                    "tipo_documento"=>"rfqs",//mooolto importante
                    "utente"=>$this->user->iduser,
                    "email_destinatario"=>$destinatario,
                    "preventivo"=>$rfqs->codrfq,
                    "oggetto"=>$oggetto_messaggio,
                    "messaggio"=>$_REQUEST["messaggio"],
                    "data_invio"=>date("Y-m-d H:i:s"),
                    "lettura"=>0,
                    "style_conf"=>json_encode($modello_p)
                );

                if($this->db->insert("lm_send_document",$record_email)){
                    $codiceinvio=$this->db->insert_id();

                    $data["nomeazienda"]  = $this->user->getDenominazioneAzienda();
                    $data["messaggio"]    = strip_tags($_REQUEST["messaggio"]);
                    $data["urlallegato"]  = "http://app.winnub.com/qdetail/".MD5(crypt($codiceinvio,PUBLIC_SALT));
                    $data["userimage"]    = "http://app.winnub.com/".$this->user->getPhoto();

                    //load email library

                    $this->load->library('email');

                    // prepare email
                    $this->email
                        ->from('no-reply@winnub.com',$this->user->getDenominazioneAzienda())
                        ->to($destinatario)
                        ->subject($oggetto_messaggio)
                        ->message($this->load->view('quote/email_template',$data,true))
                        ->set_mailtype('html');

                    // send email

                    $this->email->send();
                    
                    $dataresult["status"]=true;
                    $dataresult["message"]="Messaggio spedito";
                    
                     _report_log(
                             array(
                                 "message"=>"Inviata Email ".json_encode($data)."| ",
                                 "error"=>""));
                    

                }else{
                    //ERRORE INSERIMENTO...
                    _report_log(array("message"=>"Send Email ","error"=>"Errore"));

                }
            }else{
                _report_log(array("message"=>"Email non corretta ","error"=>"Errore"));
                $dataresult["status"]=false;
                $dataresult["message"]="Email non valida o mancante";
            }
            
            
            header("Content-type: text/json");
            echo json_encode($dataresult);
            
            
            exit;
      }

	  
}