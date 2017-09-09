<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SubdomainGestion{
    
    
    
    
    
    function index(){
        
        $ci=&get_instance();
        
       
        $loggedinfo = $ci->session->LOGGEDIN;
        
        
        $userid=$loggedinfo["userid"];
        $business=$loggedinfo["business"];
        
        $subdomain_arr = explode('.',$_SERVER['HTTP_HOST'],2); //creates the various parts
        $subdomain_name = $subdomain_arr[0]; //assigns the first part
        //verifico se il sottodominio merita di essere visto...
        if($userid>0 && $subdomain_name!="web"){
            
            
            if($subdomain_name!="app"){
                //seleziono i dati aziendali base
                $query=$ci->db->query("SELECT * FROM lm_azienda WHERE codazienda = ?  ",array($business));

                $row = $query->row(0);
                
                if($query->num_rows()>0){
                
                    if( $row->codice_subdomain!=$subdomain_name ){
                        //print_r($row);
                        header("location:"."https://".$row->codice_subdomain.".winnub.com/".getLanguage()."/logout");
                    }

                }else{
                    //header("location: https://app.winnub.com/");
                }

            }else{
                
                
                
            }

                
        }else if($ci->router->fetch_class()=="invoice"){
                    //echo $ci->router->fetch_method(); // for method name
            
            

        }
        
        
    }
            
    function initialize(){
        
    }
}