<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compito extends CI_Controller {    
    
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
				$this->load->model('Compito_model');// load model library
        }
    
      

      public function index (){
		  
            addCSS(array(
                  "public/css/bootstrap-colorpicker.min.css"
            ));
            addJS(array(                  
                  "public/js/bootstrap-colorpicker.js"
            ));
            $data=array(
                   "PAGE_TITLE"=>"Compito ",
                   "PAGE_SUB_TITLE"=>"gestione dei Compito ",
                   "sezione"=>"Compito ",
                  "pagina_active"=>"gestionet",
                   "codice"=>$codice
            );

        $this->load->view('compito/nuovo_compito',$data);

      }
      /************************************
      *Function : save()
	  * Parameter@ array()
      ***********************************/
      public function save(){


        $tt=rand(10,10000);     
           $userfile1= $tt.$_FILES['taskdoc']['name'];
           if (!empty($_FILES['taskdoc']['name'])){
           $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "msword" => "application/msword","doc" => "application/doc", "pdf" => "application/pdf", "xls" => "application/xls");
                  $filename = $_FILES["taskdoc"]["name"];
                  $filetype = $_FILES["taskdoc"]["type"];
                  $filesize = $_FILES["taskdoc"]["size"]; 
                   $filename1= $tt.$_FILES['taskdoc']['name']; 
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
                          move_uploaded_file($_FILES["taskdoc"]["tmp_name"], "uploads/" . $filename1);
                          $msg= $this->session->set_flashdata('msg', 'Your file  was uploaded successfully. !!');

                      } 
                  }               
        }else{
          $userfile1=$this->input->post('taskdoc');
          $filetype = $_FILES["taskdoc"]["type"];
          }



          $this->form_validation->set_rules('nome', 'nome', 'required');
          $this->form_validation->set_rules('description', 'description', 'required');
          $this->form_validation->set_rules('taskstatus', 'status', 'required');
          $this->form_validation->set_rules('taskdoc', 'taskdoc', 'required');
          $this->form_validation->set_rules('compitourl', 'compitourl', 'required');
          $this->form_validation->set_rules('priority', 'priority', 'required');
          $this->form_validation->set_rules('createdon', 'createdon', 'required');
          $this->form_validation->set_rules('enddate', 'enddate', 'required');



					$nome = $this->input->post('nome');
					$description = $this->input->post('description');
					//$compitourl = $this->input->post('compitourl');
					$taskstatus = $this->input->post('taskstatus');
					$priority = $this->input->post('priority');         				
          $createdon = $this->input->post('createdon');
          $enddate = $this->input->post('enddate');
					$owner=intval($_SESSION["LOGGEDIN"]["userid"]);
			$choose_color = $this->input->post('choose_color');				
           $formdata  = array('utente' =>$owner,                      
                                          'nome'=>$nome,
                                          'description'=>$description,
                                          'status'=>$taskstatus,
                                          'createdon'=>$createdon,
                                          'taskdoc'=>$userfile1,
                                          'doctype'=>$filetype,
                                          //'taskurl'=>$compitourl,
                                          'priority'=>$priority,
                                          'end_date'=>$enddate,
                                          'created_date'=>date('m/d/Y'),
										  'choose_color'=>$choose_color
                                          );
                        
                         $this->db->insert('lm_task', $formdata);
                        // $data['formdata'] = $this->load->Contatto_model->Insert($formdata);
                		//$this->load->view('contatto/nuovo_contatto',$data);
                		 $msg= $this->session->set_flashdata('msg', 'task Created Successfully !!');
                		 redirect("compito");
                   
     	 }

      /***************************************
      * Function @: contattolist() 
      *Response @:  get array()
      ***************************************/	

      public function compitolist($edit_task_id = 0 ){
		  
                addCSS(array(
                  "public/css/bootstrap-colorpicker.min.css",
				  "public/css/fullcalendar.min.css",				  
                ));
                addJS(array(                  
                  "public/js/bootstrap-colorpicker.js",
				  "public/js/moment.min.js",
				  "public/js/fullcalendar.min.js",
				  )
                );
				  
		$all_projects = $this->Compito_model->Getall();
		$calendar_data_arr = array();
		
		/*echo '<pre> Project arr';
		print_r($all_projects);
		echo '</pre>';*/
		
		$counter = 0 ;
		if(count($all_projects) > 0)
		{
			foreach($all_projects as $project)
			{
					$calendar_data_arr[$counter]['title'] = $project->nome;
					$start_date = $project->createdon;
					$start_date = str_replace('-',',',$start_date);
					$calendar_data_arr[$counter]['start_date'] = $start_date;
										
					$end_date = date('Y-m-d', strtotime($project->end_date . ' +1 day'));										
					$end_date = str_replace('-',',',$end_date);
					$calendar_data_arr[$counter]['end_date'] = $end_date;
					$calendar_data_arr[$counter]['id'] = $project->codcompito;
					$calendar_data_arr[$counter]['edit_url'] = site_url().'/compito/getcompito/'.$project->codcompito;
					$color_code = $project->choose_color;
					if(empty($color_code))
					{
						$color_code = '#00a65a';
					}						
					$calendar_data_arr[$counter]['choose_color'] = $color_code;					
					$counter++;
			}
		}
		
		$counter2 = max(array_keys($calendar_data_arr)) + 1;

		$projects_subtasks = $this->Compito_model->getProjectAndTasks();
		if(count($projects_subtasks) > 0)
		{
			foreach($projects_subtasks as $subtasks)
			{
				$calendar_data_arr[$counter2]['title'] = $subtasks->sub_task_title;
				$start_date = date("Y-m-d", strtotime($subtasks->start_date));							
				$start_date = str_replace('-',',',$start_date);
				$calendar_data_arr[$counter2]['start_date'] = $start_date;
				
				$end_date = date("Y-m-d", strtotime($subtasks->end_date));              
				$end_date = date('Y-m-d', strtotime($end_date . ' +1 day'));		
				$end_date = str_replace('-',',',$end_date);
				$calendar_data_arr[$counter2]['end_date'] = $end_date;
				$calendar_data_arr[$counter2]['id'] = $subtasks->sub_task_id;	
				
				$calendar_data_arr[$counter2]['edit_url'] = site_url().'/compito/compitolist/'.$subtasks->sub_task_id;
				$color_code = $subtasks->sub_task_color;
				if(empty($color_code))
				{
					$color_code = '#00a65a';
				}
				
				$calendar_data_arr[$counter2]['choose_color'] = $color_code ;				
				$counter2++;
			}			
		}
			
		
		
			
      	 $data=array(
                   "PAGE_TITLE"=>"Compito ",
                   "PAGE_SUB_TITLE"=>"gestione dei Compito  Lista",
                   "sezione"=>"Compito ",
                  "pagina_active"=>"gestione21",
                   "codice"=>$codice
              );
      	$data['tasklist'] = $all_projects;
		$data['calendar_data_arr'] = $calendar_data_arr;
		
		
		
		if($edit_task_id != 0 )
		{
			$singleTaskDetails = $this->Compito_model->getSingleSubtask($edit_task_id);	
			$data['singleTaskDetails'] = $singleTaskDetails;
			
		}		
		
      	$this->load->view('compito/compitolist',$data);

      }

      /***************************************
      * Function : Edit() 
      *Parametre@ id and array()
      ***************************************/	
      public function getcompito($id){
          $task_id =$this->uri->segment(2); 
         
		 addCSS(array(
                  "public/css/bootstrap-colorpicker.min.css"
              ));
             addJS(array(                  
                  "public/js/bootstrap-colorpicker.js"));
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
      public function Edit_compito(){
      

          $tt=rand(10,10000);     
           $userfile1 = $tt.$_FILES['taskdoc']['name'];
           $filetype = $tt.$_FILES['taskdoc']['type'];
           if (!empty($_FILES['taskdoc']['name'])){
           $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "msword" => "application/msword","doc" => "application/doc", "pdf" => "application/pdf", "xls" => "application/xls");
                  $filename = $_FILES["taskdoc"]["name"];
                  $filetype = $_FILES["taskdoc"]["type"];
                  $filesize = $_FILES["taskdoc"]["size"]; 
                   $filename1= $tt.$_FILES['taskdoc']['name']; 
                  // Verify file extension
                  $ext = pathinfo($filename1, PATHINFO_EXTENSION);
                  if(!array_key_exists($ext, $allowed)) die($msg= $this->session->set_flashdata('msg', 'Error: Please select a valid file!!'));
                   // Verify file size - 5MB maximum
                  $maxsize = 5 * 2448 * 2448;
                  if($filesize > $maxsize) die($msg= $this->session->set_flashdata('msg', 'Error: File size is larger than the allowed limit.'));    
                  // Verify MYME type of the file
                  if(in_array($filetype, $allowed)){
                      // Check whether file exists before uploading it
                      if(file_exists("uploads/" . $filename1)){
                          //echo $msg= $filename1 . " is already exists.";
                          $msg= $this->session->set_flashdata('msg', $filename1 . " is already exists.");
                      } else{
                          move_uploaded_file($_FILES["taskdoc"]["tmp_name"], "uploads/" . $filename1);
                          $msg= $this->session->set_flashdata('msg', 'Your file  was uploaded successfully. !!');

                      } 
                  }               
        }else{
          $userfile1=$this->input->post('taskdoc');
           $filetype1 = $filetype;
          }

          $this->form_validation->set_rules('nome', 'nome', 'required');
          $this->form_validation->set_rules('description', 'description', 'required');
          $this->form_validation->set_rules('taskstatus', 'status', 'required');
          $this->form_validation->set_rules('taskdoc', 'taskdoc', 'required');
          $this->form_validation->set_rules('compitourl', 'compitourl', 'required');
          $this->form_validation->set_rules('priority', 'priority', 'required');
          $this->form_validation->set_rules('strtday', 'strtday', 'required');
          $this->form_validation->set_rules('enddate', 'enddate', 'required');

          $nome = $this->input->post('nome');
           $taskid = $this->input->post('codcompito');
          $description = $this->input->post('description');
          $compitourl = $this->input->post('compitourl');
          $taskstatus = $this->input->post('taskstatus');
          $priority = $this->input->post('priority');                 
          $strtday = $this->input->post('strtday');
          $enddate = $this->input->post('enddate');
          $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
		  $choose_color = $this->input->post('choose_color');
           $formdata  = array('utente' =>$owner,                      
                              'nome'=>$nome,
                              'description'=>$description,
                              'status'=>$taskstatus,
                              'createdon'=>$strtday,
                              'taskdoc'=>$userfile1,
                              'doctype'=>$filetype1,
                              'taskurl'=>$compitourl,
                              'priority'=>$priority,
                              'end_date'=>$enddate,
							  'choose_color'=>$choose_color
                          );
       
           $this->Compito_model->update_compito($taskid,$formdata);
           $msg= $this->session->set_flashdata('msg', 'compito Update Successfully !!');
           redirect("compito/compitolist" );
          
      }

   /***************************************
      * Function : delete() 
      *Parametre@ id
      ***************************************/
      public function delete(){
         $taskid =$this->uri->segment(2); 
         $this->Compito_model->compito_delete($taskid);
         $msg= $this->session->set_flashdata('msg', 'compito delete Successfully !!');
         redirect('compito/compitolist');
      }
	  
	  public function delete_sub_task(){
         $taskid =$this->uri->segment(2); 
         $this->Compito_model->sub_task_delete($taskid);
         $msg= $this->session->set_flashdata('msg', 'Task Deleted Successfully !!');
         redirect('compito/compitolist');
      }	  
	  
	  
	  public function subtasks()
	  {		          
	  
	  
		
		$hdn_sub_task_id = $this->input->post('hdn_sub_task_id');
		
		$codcompito = $this->input->post('hdn_project_id');
		$sub_task_title = $this->input->post('sub_task_title');
		$sub_task_color = $this->input->post('choose_color');
		$start_date = $this->input->post('strtday');
		$end_date = $this->input->post('enddate');         				          
		$owner=intval($_SESSION["LOGGEDIN"]["userid"]);
           $formdata  = array('utente' =>$owner,                      
                                          'codcompito'=>$codcompito,
                                          'sub_task_title'=>$sub_task_title,
                                          'start_date'=>$start_date,
                                          'end_date'=>$end_date,
                                                                                    
										  'sub_task_color'=>$sub_task_color
                                          );
										  
                                if($hdn_sub_task_id != 0)
                                {
                                        $this->Compito_model->update_sub_tasks($hdn_sub_task_id,$formdata);
                                        $msg= $this->session->set_flashdata('msg', 'Task Updated Successfully !!');
                                }
                                else
                                {
                                        $this->db->insert('lm_sub_task', $formdata);							
                                        $msg= $this->session->set_flashdata('msg', 'Task Created Successfully !!');
                                }
                                                 
                		redirect("compito/compitolist");
	  }
}