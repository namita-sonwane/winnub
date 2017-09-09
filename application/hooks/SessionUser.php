<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SessionUser{
    
    public static $SU;
    
    private $CI;
    
    public $state_controller;
    
    
    function __construct(){
        
       
        
    }
    
    
            
    function SessionUser(){
        
         
        $this->CI=&get_instance();
        $ci=$this->CI;
        
        
        if(isset($_SESSION["LOGGEDIN"])){
        
            $loggedinfo = $ci->session->LOGGEDIN;

            $userid=$loggedinfo["userid"];
            $business=$loggedinfo["business"];

            $controller = $CI->router->class;
            
            //print_r($controller);
            
            $this->state_controller=$controller;
            
            if( ($controller !== 'welcome') && ($controller !== 'profile') ) {
               // redirect('dashboard');
            } 
        
        }
        
    }
    
    function index(){
        
        
        addJS(array( 
            "public/js/local/languages.js",
            "public/js/local/".getLanguage().".js",
            "bower_components/html5-boilerplate/dist/js/vendor/modernizr-2.8.3.min.js",
            
        ));
         
        
        
        if(isset($_SESSION["LOGGEDIN"]) && $this->state_controller!="signup"){
            
            
        
            addCSS(array(
                   "public/bower_components/bootstrap/dist/css/bootstrap.min.css",
                   "public/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.css",
                   "//cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css",
                    
                   "public/js/sweetalert/dist/sweetalert.css",

                   //"public/bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css",
                   "public/bower_components/AdminLTE/dist/css/AdminLTE.min.css",
                   "public/bower_components/AdminLTE/dist/css/skins/_all-skins.min.css",
                   "public/bower_components/AdminLTE/plugins/iCheck/all.css",
                   "public/bower_components/AdminLTE/plugins/morris/morris.css",
                   "public/bower_components/AdminLTE/plugins/select2/select2.min.css",

                   "public/css/animate.css",
                   "public/css/winnub.css"
            ));
            
            addJs(array(
                   "//cdn.socket.io/socket.io-1.4.5.js",
                   "public/bower_components/AdminLTE/plugins/fastclick/fastclick.js",
                   "public/js/sweetalert/dist/sweetalert.min.js",
                   "//cdn.jsdelivr.net/jquery.scrollto/2.1.2/jquery.scrollTo.min.js",
                   "//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js",
                   "public/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.js",

                   "public/bower_components/AdminLTE/plugins/knob/jquery.knob.js",

                   "//cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js",
                   "public/bower_components/AdminLTE/plugins/sparkline/jquery.sparkline.min.js",
                   "public/bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js",
                   "public/bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js",
                   "public/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js",
                   "public/bower_components/AdminLTE/plugins/chartjs/Chart.min.js",

                   "public/bower_components/AdminLTE/plugins/iCheck/icheck.min.js",
                   "public/js/bootstrap-notify/bootstrap-notify.min.js",
                   "public/bower_components/AdminLTE/plugins/select2/select2.full.min.js",
                   
                   "public/bower_components/AdminLTE/dist/js/app.js",
                   "public/js/winnub.js",
                   "public/js/winnub-skt.js"

            ));
         
         
             addJs(array( "public/js/Application.js"));
             
         }else{
             
             //da non loggato
               addCSS(array(
                   "public/bower_components/bootstrap/dist/css/bootstrap.min.css",
              
                   "public/bower_components/AdminLTE/dist/css/AdminLTE.min.css",
                   "public/css/animate.css",
                   "public/css/addon.css",
                   "public/css/winnubp.css"
                ));
               
                addJS(array( "public/js/winnub.js","public/js/login.js"));
             
         }
         
        
         
         //indifferentemente se loggato o meno
        
         addCSS(array("public/font/winnub_icon.css",
             "public/css/winnub-animation.css"));
    }
    
    
}