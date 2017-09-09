<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cad extends CI_Controller {
    
      public function __construct(){
        
        parent::__construct();
           
         if( !_is_logged() ){
             header("location: ".base_url());
         }
         
         
        
         //addJS(array("public/js/clienti.js"));
         
         
      }
}

