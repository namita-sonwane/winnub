<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdl extends CI_Controller {    
    
        public function __construct() {
           parent::__construct();       
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
				$this->load->model('Pdl_model');// load model library
        }
    
      

      public function index (){
		  
            
			$pdl_data = $this->Pdl_model->getAll();
            $data=array(
                   "PAGE_TITLE"=>"PDL",
                   "PAGE_SUB_TITLE"=>"PDL",
                   "sezione"=>"PDL",
                  "pagina_active"=>"nuovo_lista",
                   "codice"=>$codice,
				   "pdl_data" => $pdl_data
            );
		
			
          
        $this->load->view('pdl/nuovo_lista',$data);

      }
	  
	  
	  public function ruoli(){
		  
			$ruoli_data = $this->Pdl_model->getAllRuoli();
            $data=array(
                   "PAGE_TITLE"=>"Ruoli",
                   "PAGE_SUB_TITLE"=>"Ruoli",
                   "sezione"=>"PDL",
                  "pagina_active"=>"ruoli",
                   "codice"=>$codice,
				   "ruoli_data" => $ruoli_data
            );
		
			
          
        $this->load->view('pdl/ruoli',$data);

      }
	  
      /************************************
      *Function : save()
	  * Parameter@ array()
      ***********************************/
      public function save(){
          $codpdl=$this->input->post('codpdl');
        if(isset($codpdl)  && $codpdl > 0)
        {
          $this->Edit_pdl();
        }
        else
        {

  				$sceneggiatura = $this->input->post('sceneggiatura');
					$regia = $this->input->post('regia');
					$dir_produzione = $this->input->post('dir_produzione');
					$organizzatore_generale = $this->input->post('organizzatore_generale');
					$dirf_otografia = $this->input->post('dirf_otografia');         				
          $scenografia = $this->input->post('scenografia');
          $suono = $this->input->post('suono');
					$owner=intval($_SESSION["LOGGEDIN"]["userid"]);
          $aiuto_regia = $this->input->post('aiuto_regia');
          $localita = $this->input->post('localita');
          $data_di_inizio = $this->input->post('data_di_inizio');
          $data_di_fine_lavoro = $this->input->post('data_di_fine_lavoro');

           $formdata  = array('utente' =>$owner,                      
                                          'sceneggiatura'=>$sceneggiatura,
                                          'regia'=>$regia,
                                          'dir_produzione'=>$dir_produzione,
                                          'organizzatore_generale'=>$organizzatore_generale,
                                          'dirf_otografia'=>$dirf_otografia,
                                          'scenografia'=>$scenografia,
                                          'suono'=>$suono,
                                          'aiuto_regia'=>$aiuto_regia,
                                          'localita'=>$localita,
                                          'data_di_inizio'=>$data_di_inizio,
                                          'data_di_fine_lavoro'=>$data_di_fine_lavoro
                                          );
                        
                         $this->db->insert('lm_pdl', $formdata);
                        // $data['formdata'] = $this->load->Contatto_model->Insert($formdata);
                		//$this->load->view('contatto/nuovo_contatto',$data);
                		 $msg= $this->session->set_flashdata('msg', 'Pdl Created Successfully !!');
                		 redirect("pdl");
            }
     	 }
		 
		public function saveRuoli(){
			$ruoli_id=$this->input->post('ruoli_id');
			if(isset($ruoli_id)  && $ruoli_id > 0)
			{
			  $this->Edit_ruoli();
			}
			else
			{

				$interprete = $this->input->post('interprete');
				$ruolo = $this->input->post('ruolo');
				$data_id = $this->input->post('data_id');
				$organizzatore_generale = $this->input->post('organizzatore_generale');
				$data = $this->input->post('data');         				          
				$owner=intval($_SESSION["LOGGEDIN"]["userid"]);
			  
				$formdata  = array('utente' =>$owner,                      
											  'interprete'=>$interprete,
											  'ruolo'=>$ruolo,
											  'data_id'=>$data_id,                                          
											  'data'=>$data,
											  );
							
							 $this->db->insert('lm_ruoli', $formdata);                                        		
							 $msg= $this->session->set_flashdata('msg', 'Pdl Created Successfully !!');
							 redirect("pdl/ruoli");
				}
		}

      /***************************************
      * Function : Edit() 
      *Parametre@ id and array()
      ***************************************/	
      public function getpdl($id){
          $pdl_id =$this->uri->segment(2); 
		
      		   $pdl_data = $this->Pdl_model->getAll();
			   
			   $data=array(
                   "PAGE_TITLE"=>"Edit PDL",
                   "PAGE_SUB_TITLE"=>"Edit PDL",
                   "sezione"=>"PDL",
                  "pagina_active"=>"nuovo_lista",
                   "codice"=>$pdl_id,
				   'pdl_data' => $pdl_data
            );
      	 $data['singlepdl'] = $this->Pdl_model->getsingle($pdl_id);      	
      	 $this->load->view('pdl/nuovo_lista',$data);
      }
	  
	  public function getruoli($id){
          $ruoli_id =$this->uri->segment(2); 
	
      		   $ruoli_data = $this->Pdl_model->getAllRuoli();
			   
			   $data=array(
                   "PAGE_TITLE"=>"Edit Ruoli",
                   "PAGE_SUB_TITLE"=>"Edit Ruoli",
                   "sezione"=>"PDL",
                  "pagina_active"=>"ruoli",
                   "codice"=>$ruoli_id,
				   'ruoli_data' => $ruoli_data
            );
      	 $data['singleruoli'] = $this->Pdl_model->getsingleRuoli($ruoli_id);      	
      	 $this->load->view('pdl/ruoli',$data);
      }
   /***************************************
      * Function : Edit_contatto() 
      *Parametre@ form value $_POST() 
      ***************************************/
      public function Edit_pdl(){
         $codpdl = $this->input->post('codpdl');
           $sceneggiatura = $this->input->post('sceneggiatura');
          $regia = $this->input->post('regia');
          $dir_produzione = $this->input->post('dir_produzione');
          $organizzatore_generale = $this->input->post('organizzatore_generale');
          $dirf_otografia = $this->input->post('dirf_otografia');                 
          $scenografia = $this->input->post('scenografia');
          $suono = $this->input->post('suono');
          $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
          $aiuto_regia = $this->input->post('aiuto_regia');
          $localita = $this->input->post('localita');
          $data_di_inizio = $this->input->post('data_di_inizio');
          $data_di_fine_lavoro = $this->input->post('data_di_fine_lavoro');

           $formdata  = array('utente' =>$owner,                      
                                          'sceneggiatura'=>$sceneggiatura,
                                          'regia'=>$regia,
                                          'dir_produzione'=>$dir_produzione,
                                          'organizzatore_generale'=>$organizzatore_generale,
                                          'dirf_otografia'=>$dirf_otografia,
                                          'scenografia'=>$scenografia,
                                          'suono'=>$suono,
                                          'aiuto_regia'=>$aiuto_regia,
                                          'localita'=>$localita,
                                          'data_di_inizio'=>$data_di_inizio,
                                          'data_di_fine_lavoro'=>$data_di_fine_lavoro
                                          );
                        
 
           $this->Pdl_model->update_pdl($codpdl,$formdata);
           $msg= $this->session->set_flashdata('msg', 'Pdl Update Successfully !!');
           redirect("pdl" );
          
      }
	  
	   public function Edit_ruoli(){
		  $ruoli_id = $this->input->post('ruoli_id');
		  $interprete = $this->input->post('interprete');
		  $ruolo = $this->input->post('ruolo');
		  $data_id = $this->input->post('data_id');
		  $data = $this->input->post('data');	  
		  $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
		  
		  $formdata  = array('utente' =>$owner,                      
										  'interprete'=>$interprete,
										  'ruolo'=>$ruolo,
										  'data_id'=>$data_id,
										  'data'=>$data,
										  
										  );
						

		   $this->Pdl_model->update_ruoli($ruoli_id,$formdata);
		   $msg= $this->session->set_flashdata('msg', 'Ruoli Update Successfully !!');
		   redirect("pdl/ruoli" );
          
    }

   /***************************************
      * Function : delete() 
      *Parametre@ id
      ***************************************/
      public function delete(){
         $codpdl =$this->uri->segment(2); 
         $this->Pdl_model->delete($codpdl);
         $msg= $this->session->set_flashdata('msg', 'Pdl delete Successfully !!');
         redirect('pdl');
      }
	  
	  public function deleteruoli(){
         $id =$this->uri->segment(2); 
         $this->Pdl_model->deleteRuoli($id);
         $msg= $this->session->set_flashdata('msg', 'Ruoli Deleted Successfully !!');
         redirect('pdl/ruoli');
      }
	  
	  
}