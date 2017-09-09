<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LanguageLoader{
    
    
    function initialize(){
        
        $ci =&get_instance();
        
        $ci->load->helper('language');
        
        $siteLang = $ci->session->userdata('site_lang');
        
        
    }
    
}