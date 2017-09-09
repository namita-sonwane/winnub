<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases extends CI_Controller {    
    
        public function __construct() {
           parent::__construct();    
           
           
            $this->lang->load('purchases_lang');//importante deve esserci il file per ogni lingua
				
            $this->load->model('Purchases_model');	
        
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
				
        }
   

      public function index(){
		
            $purchases_category = $this->Purchases_model->get_purchase_category();
      		 $data=array(
                   "PAGE_TITLE"=>"Registra acquisto ",
                   "PAGE_SUB_TITLE"=>"Registra acquisto",
                   "sezione"=>"purchases",
                  "pagina_active"=>"Registra acquisto",
                   "codice"=>$codice,
				   "purchases_category"=>$purchases_category
              );

            $this->load->view('purchases/purchase_registration',$data);

      }
	  
	  /************************************
      *Function : save()
	  * Parameter@ array()
      ***********************************/
    public function save()
	{
		if(isset($_REQUEST['purchase_id'])  && $_REQUEST['purchase_id'] > 0)
		{
			$this->edit_purchases();
		}
		else
		{
		   $tt=rand(10,10000);     
           $userfile1= $tt.$_FILES['purchase_reg_file']['name'];
           if (!empty($_FILES['purchase_reg_file']['name'])){
           $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "msword" => "application/msword","doc" => "application/doc", "pdf" => "application/pdf", "xls" => "application/xls");
                  $filename = $_FILES["purchase_reg_file"]["name"];
                  $filetype = $_FILES["purchase_reg_file"]["type"];
                  $filesize = $_FILES["purchase_reg_file"]["size"]; 
                   $filename1= $tt.$_FILES['purchase_reg_file']['name']; 
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
                          move_uploaded_file($_FILES["purchase_reg_file"]["tmp_name"], "uploads/" . $filename1);
                          $msg= $this->session->set_flashdata('msg', 'Your file  was uploaded successfully. !!');

                      } 
                  }               
        }else{
          $userfile1=$this->input->post('purchase_reg_file');
          $filetype = $_FILES["purchase_reg_file"]["type"];
          }
		  
		$this->form_validation->set_rules('purchase_supplier', 'purchase_supplier', 'required');
                $this->form_validation->set_rules('purchase_category', 'purchase_category', 'required');
                $this->form_validation->set_rules('purchase_start_date', 'purchase_start_date', 'required');		  
                $this->form_validation->set_rules('purchase_total', 'purchase_total', 'required');
		$this->form_validation->set_rules('purchase_balance_date', 'purchase_balance_date', 'required');
          
          
		  
		$purchase_supplier = $this->input->post('purchase_supplier');
                $purchase_start_date = $this->input->post('purchase_start_date');
                $purchase_invoice = $this->input->post('purchase_invoice');
                $purchase_taxable = $this->input->post('purchase_taxable');
                $purchase_vat = $this->input->post('purchase_vat');         				
                $purchase_total = $this->input->post('purchase_total');
                
                $purchase_balance_date=null;
                if(($this->input->post('purchase_balance_date'))!=NULL){
                    $purchase_balance_date =$this->input->post('purchase_balance_date');
                }
                $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
		  
		$purchase_category = 0;	   
                if($_REQUEST["purchase_category"] != "0")
                {				
                        $purchase_category = $_REQUEST["purchase_category"];
                }
                else
                {	
                        $purchase_category_another = $_REQUEST["another_purchase_category"];
                        if(!empty($purchase_category_another))
                        {					
                                $purchase_category = $this->Purchases_model->process_product_category($purchase_category_another) ;	
                        }				
                }			

                $formdata  = array('utente' =>$owner,                      
                    'purchase_category'=>$purchase_category,
                    'purchase_start_date'=>$purchase_start_date,
                    'purchase_invoice'=>$purchase_invoice,
                    'purchase_reg_file'=>$userfile1,
                    'purchase_taxable'=>$purchase_taxable,
                    'purchase_vat'=>$purchase_vat,
                    'purchase_total'=>$purchase_total,
                    'purchase_balance_date'=>$purchase_balance_date,                             
                    'created_date'=>date('Y-m-d'),
                    'purchase_supplier'=> $purchase_supplier
                );
                        
                         $this->db->insert('lm_purchases', $formdata);
                        // $data['formdata'] = $this->load->Contatto_model->Insert($formdata);
                		//$this->load->view('contatto/nuovo_contatto',$data);
                		 $msg= $this->session->set_flashdata('msg', 'Purchase Registration Created Successfully !!');
                		 redirect("purchases");
		}
	  
                           
	}
	
	 /***************************************
      * Function : edit_purchases() 
      *Parametre@ form value $_POST() 
      ***************************************/
      public function edit_purchases(){
      

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

		$this->form_validation->set_rules('purchase_supplier', 'purchase_supplier', 'required');
          $this->form_validation->set_rules('purchase_category', 'purchase_category', 'required');
          $this->form_validation->set_rules('purchase_start_date', 'purchase_start_date', 'required');		  
          $this->form_validation->set_rules('purchase_total', 'purchase_total', 'required');
		  $this->form_validation->set_rules('purchase_balance_date', 'purchase_balance_date', 'required');
          
          $purchase_id = $this->input->post('purchase_id');		  
		  $purchase_supplier = $this->input->post('purchase_supplier');
            $purchase_start_date = $this->input->post('purchase_start_date');
            $purchase_invoice = $this->input->post('purchase_invoice');
            $purchase_taxable = $this->input->post('purchase_taxable');
            $purchase_vat = $this->input->post('purchase_vat');         				
            $purchase_total = $this->input->post('purchase_total');
              $purchase_balance_date=null;
              if(($this->input->post('purchase_balance_date'))!=NULL){
                  $purchase_balance_date =$this->input->post('purchase_balance_date');
              }

          $owner=intval($_SESSION["LOGGEDIN"]["userid"]);
		  
		  $purchase_category = 0;	   
			if($_REQUEST["purchase_category"] != "0")
			{				
				$purchase_category = $_REQUEST["purchase_category"];
			}
			else
			{	
				$purchase_category_another = $_REQUEST["another_purchase_category"];
				if(!empty($purchase_category_another))
				{					
					$purchase_category = $this->Purchases_model->process_product_category($purchase_category_another) ;	
				}				
			}

           $formdata  = array('utente' =>$owner,                      
                              'purchase_category'=>$purchase_category,
                              'purchase_start_date'=>$purchase_start_date,
                              'purchase_invoice'=>$purchase_invoice,
                              'purchase_reg_file'=>$userfile1,
                              'purchase_taxable'=>$purchase_taxable,
                              'purchase_vat'=>$purchase_vat,
                              'purchase_total'=>$purchase_total,
                              'purchase_balance_date'=>$purchase_balance_date,                             
                              'created_date'=>date('m/d/Y'),
							  'purchase_supplier' => $purchase_supplier
                              );
       
           $this->Purchases_model->update($purchase_id,$formdata);
           $msg= $this->session->set_flashdata('msg', 'Purchase Registration Updated Successfully !!');
           redirect("purchases/shopping" );
          
      }
	  
	  public function get_purchase_total_by_category()
	  {
		$marketing = $this->Purchases_model->get_category_totals('Marketing')->Total ;
		$Spese_Legali = $this->Purchases_model->get_category_totals('Spese Legali')->Total ;
		$Assicurazioni = $this->Purchases_model->get_category_totals('Assicurazioni')->Total ;
		$Stipendi = $this->Purchases_model->get_category_totals('Stipendi')->Total ;
		$Acquisti = $this->Purchases_model->get_category_totals('Acquisti')->Total ;
		
		if(empty($marketing)){$marketing =0;}
		if(empty($Spese_Legali)){$Spese_Legali =0;}
		if(empty($Assicurazioni)){$Assicurazioni =0;}
		if(empty($Stipendi)){$Stipendi =0;}
		if(empty($Acquisti)){$Acquisti =0;}
		
		$data_total_category['Marketing'] = $marketing ;
		$data_total_category['Spese_Legali'] = $Spese_Legali ;
		$data_total_category['Assicurazioni'] = $Assicurazioni ;
		$data_total_category['Stipendi'] = $Stipendi ;
		$data_total_category['Acquisti'] = $Acquisti ;
		
		return $data_total_category;
	  }
	  
	  public function get_purchase_month_totals()
	  {
		$jan = $this->Purchases_model->get_monthly_totals(1)->Total ;
		$feb = $this->Purchases_model->get_monthly_totals(2)->Total;
		$mar = $this->Purchases_model->get_monthly_totals(3)->Total;
		$apr = $this->Purchases_model->get_monthly_totals(4)->Total;		
		$may = $this->Purchases_model->get_monthly_totals(5)->Total;
		$jun = $this->Purchases_model->get_monthly_totals(6)->Total;
		$jul = $this->Purchases_model->get_monthly_totals(7)->Total;
		$aug = $this->Purchases_model->get_monthly_totals(8)->Total;
		$sep = $this->Purchases_model->get_monthly_totals(9)->Total;
		$oct = $this->Purchases_model->get_monthly_totals(10)->Total;
		$nov = $this->Purchases_model->get_monthly_totals(11)->Total;
		$dec = $this->Purchases_model->get_monthly_totals(12)->Total;
		if(empty($jan)){$jan =0;}
		if(empty($feb)){$feb =0;}
		if(empty($mar)){$mar =0;}
		if(empty($apr)){$apr =0;}
		if(empty($may)){$may =0;}
		if(empty($jun)){$jun =0;}
		if(empty($jul)){$jul =0;}
		if(empty($aug)){$aug =0;}
		if(empty($sep)){$sep =0;}
		if(empty($oct)){$oct =0;}
		if(empty($nov)){$nov =0;}
		if(empty($dec)){$dec =0;}				
		
		$data_totals['jan'] = $jan ;
		$data_totals['feb'] = $feb;
		$data_totals['mar'] = $mar;
		$data_totals['apr'] = $apr;
		$data_totals['may'] = $may ;
		$data_totals['jun'] = $jun;
		$data_totals['jul'] = $jul;
		$data_totals['aug'] = $aug;
		$data_totals['sep'] = $sep ;
		$data_totals['oct'] = $oct;
		$data_totals['nov'] = $nov;
		$data_totals['dec'] = $dec;
		return $data_totals;
	  }
	  
	   public function shopping($nome=null){   
	   
                $purchase_data=Purchases_model::getAll();
         
		if(!_is_logged()) redirect('/');

		  addCSS(array(
			  "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css",
			  "public/css/purchases_style.css",
			  
		  ));
		  //"public/js/Chart.min.js"
                  addJS(array("public/js/purchases.js"));
                
                
		$this->load->helper('purchase_category');

		$data_total_category = $this->Purchases_model->get_category_sum_total();
		$data=array(
			   "PAGE_TITLE"=>"Manage Purchases",
			   "PAGE_SUB_TITLE"=>"Manage Purchases",
			   "sezione"=>"purchases",
			  "pagina_active"=>"shopping",
			   "codice"=>$codice,
			   "purchase_data"=>$purchase_data,
			   "data_totals"=>$this->get_purchase_month_totals(),
			   'data_total_category'=>$data_total_category
		  );
		  
		  
		  $this->parser->parse('purchases/manage_purchase_registration',$data);
          
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
            
            $purchases=Purchases_model::get($codice);
			
            $data=array();
            
            $data["codice"]=$codice;
            $data["subject"]=$purchases;
            $data["status"]=0;
            
            if(is_array($purchases)){
                 $purchases=$purchases[0];
            }
            
            if($purchases){
				
				
                if(  (MD5(intval($purchases->purchase_id))==$codice || $purchases->purchase_id==$codice) &&
                        $owner==$purchases->utente
                ){

                    $purchases->delete();

                    $data["status"]=1;

                }
            
            }
            
            
            return $this->output
                ->set_content_type('text/json')
                ->set_status_header(200)
                ->set_output(json_encode($data));
              
            
        }
		
		 public function edit($codice=null){
			 
			 
            if(!_is_logged()) redirect('/');
            
            $codice_tmp    =   str_replace('"',"",($codice));
            $purchases_data   =  Purchases_model::get($codice_tmp);
			
			$purchases_category = $this->Purchases_model->get_purchase_category();
			 
            
            if( $codice==0 || is_object($purchases_data[0])){
                
                if(isset($purchases_data[0])){
                    if( !$purchases_data[0]->verificaAppartenenza() ){

                    }
                }

				$data=array(
                   "PAGE_TITLE"=>"Registra acquisto ",
                   "PAGE_SUB_TITLE"=>"Registra acquisto",
                   "sezione"=>"purchases",
                  "pagina_active"=>"Registra acquisto",
                   "codice"=>$codice,
				   "purchases_data"=>$purchases_data,
				   "purchases_category"=>$purchases_category
              );
                
                 
                
				$this->load->view('purchases/purchase_registration',$data);
                
            }else{
			
			$data=array(
                   "PAGE_TITLE"=>"Registra acquisto ",
                   "PAGE_SUB_TITLE"=>"Registra acquisto",
                   "sezione"=>"purchases",
                  "pagina_active"=>"Registra acquisto",
                   "codice"=>$codice,
				   "purchases_data"=>$purchases_data,
				   "purchases_category"=>$purchases_category
              );
                
                          
            
				$this->load->view('purchases/purchase_registration',$data);				
            }
            
        }
	  
	  
  
}