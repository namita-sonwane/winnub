<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contatto extends CI_Controller {    
    
        public function __construct() {
           parent::__construct();
           
           
           $this->lang->load('contatto_lang');//importante deve esserci il file per ogni lingua
           
            $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));       
            if( !_is_logged() ){
                 header("location: ".base_url());
            }    

            $this->load->library('session');// load session library 
            $this->load->library('upload');// load file upload library
            $this->load->helper('form'); // load form library
            $this->load->helper('url'); //// load url library 
            $this->load->helper('html');// load html library
            $this->load->library('form_validation');// load form_validation library
            $this->load->database();// load database library				
            $this->load->model('Contatto_model');// load model library
            
        }
    
      

      public function index (){
          
      		 $data=array(
                   "PAGE_TITLE"=>"Contatti ",
                   "PAGE_SUB_TITLE"=>"gestione dei Contatti ",
                   "sezione"=>"Contatti",
                   "pagina_active"=>"gestione21",
                   "codice"=>$codice
              );

            $this->load->view('contatto/nuovo_contatto',$data);

      }
      
      
      public function contacts(){
          $this->contattolist();
      }




      /************************************
      *Function : save()
      * * Parameter@ array()
      ***********************************/
      public function save(){
                
                $this->form_validation->set_rules('nome', 'nome', 'required');
                 $this->form_validation->set_rules('description', 'description', 'required');
                $this->form_validation->set_rules('email', 'email', 'required');
                $this->form_validation->set_rules('mobile', 'mobile', 'required');
                $this->form_validation->set_rules('leadstatus', 'leadstatus', 'required');
                $this->form_validation->set_rules('data_fatt', 'data_fatt', 'required');

               
                /*if ($this->form_validation->run() == FALSE) {
				   $this->load->view('contatto/nuovo_contatto');
				} else {*/
					$nome = $this->input->post('nome');
          $description = $this->input->post('description');
					$email = $this->input->post('email');
					$mobile = $this->input->post('mobile');
					$leadstatus = $this->input->post('leadstatus');
					$data_fatt = $this->input->post('data_fatt');				
					
                	$owner=intval($_SESSION["LOGGEDIN"]["userid"]);

                      $formdata  = array('utente' =>$owner,                      
                                              'nome'=>$nome,
                                              'description'=>$description,
                                              'email'=>$email,
                                              'mobile'=>$mobile,
                                              'leadstatus'=>$leadstatus,
                                              'createdon'=>$data_fatt,
                                              'created_date'=>date('m/d/Y'),
                                              'hidden'=>""
                                              );
                        
                         $this->db->insert('lm_contatto', $formdata);
                        // $data['formdata'] = $this->load->Contatto_model->Insert($formdata);
                		//$this->load->view('contatto/nuovo_contatto',$data);
                		 $msg= $this->session->set_flashdata('msg', 'Contatto Created Successfully !!');
                                 
                         save_stream_log(
                            array("azione"=>"generate_lead",
                                "descrizione"=>"genera nuovo contatto ",
                                "style"=>""
                                    )
                            );         
                        
                		 redirect("contatto");
     	 }

      /***************************************
      * Function @: contattolist() 
      *Response @:  get array()
      ***************************************/	

      public function contattolist(){
      	 $data=array(
                   "PAGE_TITLE"=>"Contatti ",
                   "PAGE_SUB_TITLE"=>"gestione dei Contatti  Lista",
                   "sezione"=>"Contatti",
                   "pagina_active"=>"listacontatti",
                   "codice"=>$codice
              );
      	 $data['contact'] = $this->Contatto_model->Getall();
      	$this->load->view('contatto/contattolist',$data);

      }

      /***************************************
      * Function : Edit() 
      *Parametre@ id and array()
      ***************************************/	
      public function getcontact($id){
          
          $contact_id =$this->uri->segment(2);          
      		 $data=array(
                   "PAGE_TITLE"=>"Edit Contatti",
                   "PAGE_SUB_TITLE"=>"gestione dei Contatti  Lista",
                   "sezione"=>"Contatti",
                  "pagina_active"=>"gestione21",
                   "codice"=>$codice
              );
      	 $data['contacti'] = $this->Contatto_model->getsingle($contact_id);      	
      	 $this->load->view('contatto/contattoedit',$data);
         
      }
   /***************************************
      * Function : Edit_contatto() 
      *Parametre@ form value $_POST() 
      ***************************************/
      public function Edit_contatto(){
          
			$this->form_validation->set_rules('nome', 'nome', 'required');
      $this->form_validation->set_rules('description', 'description', 'required');
			$this->form_validation->set_rules('email', 'email', 'required');
			$this->form_validation->set_rules('mobile', 'mobile', 'required');
			$this->form_validation->set_rules('leadstatus', 'leadstatus', 'required');
			$this->form_validation->set_rules('createdon', 'createdon', 'required');
      $id = $this->input->post('codcontatto');
			$nome = $this->input->post('nome');
      $description = $this->input->post('description');
			$email = $this->input->post('email');
			$mobile = $this->input->post('mobile');
			$leadstatus = $this->input->post('leadstatus');
			$createdon = $this->input->post('createdon');					
            $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
                      $formdata  = array('utente' =>$owner,                      
	                                      'nome'=>$nome,
                                        'description'=>$description,
	                                      'email'=>$email,
	                                      'mobile'=>$mobile,
	                                      'leadstatus'=>$leadstatus,
	                                      'createdon'=>$createdon,
	                                      'created_date'=>date('m/d/Y'),
	                                      'hidden'=>""
	                                      );
            $this->Contatto_model->update_contatto($id,$formdata);
            
            
            save_stream_log(
                            array("azione"=>"update_lead",
                                "descrizione"=>"aggiorna nuovo contatto $id ",
                                "style"=>""
                                    )
                            );        
            
             $msg= $this->session->set_flashdata('msg', 'Contatti Update Successfully !!');
			       redirect("contatto" );

      }


      /**********************************************
      * Function @contattoexcle();
      * Parameter @ Page
      ****************************************************/
      public function contattoexcle(){
        $data=array(
                   "PAGE_TITLE"=>"Contatti ",
                   "PAGE_SUB_TITLE"=>"gestione dei Contatti  excel Import",
                   "sezione"=>"Contatti",
                  "pagina_active"=>"gestione21",
                   "codice"=>$codice
              );
         //$data['contact'] = $this->Contatto_model->Getall();
        $this->load->view('contatto/contattoexcel',$data);


      }

    //import excel and csv file data in database 
      public function importexcel(){
        $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
        $fileName = time().$_FILES['file']['name'];
         
        $config['upload_path'] = 'uploads/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 400;
         
        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('file') )
        $this->upload->display_errors();
             
        $media = $this->upload->data('file');
         $inputFileName = 'uploads/'.$fileName;
         
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
             
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                                                 
                //Sesuaikan sama nama kolom tabel di database  
                if(empty($rowData[0][1])){
                  $this->session->set_flashdata('msg', 'Plese check Your Excel/csv Sheet nome Are Not Null ..');
                 redirect("contatto/contattolist",'refresh' ); 
                }else{                             
                 $data = array(
                    "codcontatto"=> $rowData[0][0],
                    "nome"=> $rowData[0][1],
                    "email"=> $rowData[0][2],
                    "mobile"=> $rowData[0][3],
                    "utente"=> $owner,
                    "createdon"=>date('Y-m-d'),
                    "created_date"=>date('m/d/Y')
                );
                 }
                
                //sesuaikan nama dengan nama tabel
                 $insert = $this->Contatto_model->insertCSV($data);
               
                     
            }
                $this->session->set_flashdata('msg', 'Data are imported successfully..');
                 redirect("contatto/contattolist",'refresh' ); 
    
      }


   /***************************************
      * Function : delete() 
      *Parametre@ id
      ***************************************/
      public function delete(){
         $contact_id =$this->uri->segment(2); 
         $this->Contatto_model->contatto_delete($contact_id);
         $msg= $this->session->set_flashdata('msg', 'Contatti delete Successfully !!');
         redirect('contatto/contattolist');
      }
}