<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messaggi extends CI_Controller {
    
    
    public function __construct(){
        
         parent::__construct();
         
         $this->load->helper(array('form', 'url'));
         
         $this->load->library('parser');
         
            $this->load->model("Messaggio_model");
        
         addCSS(array(
               
         ));
         
         addJs(array(
                
                  
             "bower_components/html5-boilerplate/dist/js/vendor/modernizr-2.8.3.min.js",
             //"bower_components/angular/angular.js",
             //"bower_components/angular-route/angular-route.js",
            
              
         ));
         
      }
      
      
        public function index($codice=null){
            if(!_is_logged()) redirect('/');

            addJs(array(

               //"public/js/app/appmessage.js",
                 "public/js/messages.js",

           ));

            
            $data=array(
                 "PAGE_TITLE"=>t("Messaggi"),
                 "SECTION_TITLE"=>t('message_page'),
                 "categoriabase"=>"messagge",
                 "sezione"=>"messagge-index",
                 "newmessage"=>$this->Messaggio_model->getNewMessage(),
                 "messaggi"=> $this->Messaggio_model->getAll(" AND subject != 'CHAT-MESSAGE' AND esternalcode!=NULL group by esternalcode ")
            );
            $this->parser->parse('message/default',$data);
            
           
        }
        
        
        public function send(){
            if(!_is_logged()) redirect('/');

            addJs(array(

              "public/js/messages.js",

           ));

           

            
            $data=array(
                 "PAGE_TITLE"=>t("Messaggi"),
                 "SECTION_TITLE"=>t('message_page'),
                 "categoriabase"=>"messagge",
                 "sezione"=>"messagge-send",
                 "error"=>"",
                 "messaggi"=> $this->Messaggio_model->getSend(" AND subject != 'CHAT-MESSAGE' ")
            );
            $this->parser->parse('message/default',$data);
              

        }
        
        
        public function view($codice){
            
            
                if(!_is_logged()) redirect('/');

                addJs(array(



               ));

               
            
                $data=array(
                     "PAGE_TITLE"=>t("Messaggi"),
                     "SECTION_TITLE"=>t('message_page'),
                     "categoriabase"=>"messagge",
                     "sezione"=>"messagge-view",
                     "error"=>"",
                     "codice"=>$codice
                );
                $this->parser->parse('message/detail_message',$data);

        }
      
      
      
        
      
      
      
      
      
        public function all(){
          
          if(!_is_logged()) redirect('/');
          
          $data=array();
          
          $this->load->model("Messaggio_model");
          
         
          $data=$this->Messaggio_model->getAll();
          
          
          
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data)
            );
          
          
          
      }
      
      
       public function get($cod){
           
          $data=array();
          
          $this->load->model("Messaggio_model");
          
         
          $data=$this->Messaggio_model->get($cod);
          
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data)
            ); 
           
       }
      
      
       
       public function delete($codice){
           
            $this->load->model("Messaggio_model");
            
            $data=$this->Messaggio_model->get($codice);
            
            _report_log(array("message"=>"Elimina Gruppo Messaggi  : ".json_encode($data)."| ","error"=>""));
            
            $data->removeexternal();
            
            $datas["status"]=true;
            
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($datas)
            ); 
            
          
           
       }
      
      
      
      

      
      
}