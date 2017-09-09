<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Accessorio_model extends CI_Model{
    
    var $idaccessorio;
    
    
     public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        
    }
    
    
    public function getCosto($misure){
        
        if(is_array($misure) && $this->tipo_calcolo=="misura"){
            
            $h=$misure["altezza"]/1000;
            $w=$misure["larghezza"]/1000;
           
            return ($h*$w)*$this->costo;
        }
        
        return $this->costo;
    }
    
}