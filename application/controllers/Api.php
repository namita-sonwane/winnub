<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');

class Api extends REST_Controller {
    
    
    
    protected $methods = [
            'access' => ['level' => 10, 'limit' => 10],
            'users' => ['level' => 10],
            'message' => ['level' => 10],
            'ordercreate' => ['level' => 1]
            
    ];
     
    public function __construct(){
        
        
         parent::__construct();
         
         //$this->load->library('parser');
    }
    
    
    
    
    public function ordercreate($data=null){
        echo "OK!";
    }
    
    
    function index(){
        
        //echo "API V 1.0";
        
         print_r($_REQUEST);
         
    }
    
    
    function autentica($c=null){
    
        $this->set_response($_SESSION, 200); // 200 being the HTTP response code
       
    }
    
    
    
    
    function users($codice)
    {
        
        if(!$this->get('id'))
        {
            $this->response(NULL, 400);
        }
 
        $user = $this->utente->get( $this->get('id') );
         
        if($user)
        {
            $this->response($user, 200); // 200 being the HTTP response code
        }else{
            $this->response(NULL, 404);
        }
      
    }
    
    function message(){
        
        $messaggi = $this->utente->getMy('messaggi');
        
        $this->set_response($messaggi, 200); // 200 being the HTTP response code
       
        
    }
    
    
    
     
    
    
    
}