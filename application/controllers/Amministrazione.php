<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Amministrazione extends CI_Controller {
    
    public function __construct(){
        
        parent::__construct();
           
         if( !_is_logged() ){
             header("location: ".base_url());
         }
         
         
         
         $this->load->library('parser');
         $this->load->helper('date');
         
         addJS(array("public/js/settings.js"));
         
      }
      
      
      public function index(){
          
               $file="impostazioni-lingua";
           $data=array(
                "PAGE_TITLE"=>t('Lingue winnub'),
                "SECTION_TITLE"=>t('language-settings'),
                "categoriabase"=>"menu-impostazioni",
                "sezione"=>"languages",

           );
           $this->parser->parse('admin/'.$file,$data);
            
      }
      
      
    
    
}