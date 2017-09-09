<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(!isset($_body_class)){
    $_body_class="hold-transition skin-blue-light sidebar-mini";
}

if(!isset($simpleheder)){
    $simpleheder=false;
}

if(!isset($_WRAPID_)){
    $_WRAPID_="WPAGE";
}


?><!DOCTYPE html>
<html lang="<?=getLanguage();?>">
    <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title><?=$PAGE_TITLE?> - <?=_config("site_name")?></title>
            <!-- Tell the browser to be responsive to screen width -->
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
            <!-- jvectormap -->
            <?php _getCss();//return all css meta loaded?>
            
            
            <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>

            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
            
           
            <?php 
            if(!empty($this->_HEADER_HTML_)){
                echo $this->_HEADER_HTML_;
                
            }?>
            
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-96233037-2', 'auto');
                ga('send', 'pageview');
  

            </script>


    </head>
    
<body class=" <?=$_body_class?> ">
    <div class="wrapper" id="<?=$_WRAPID_;?>">
    <script><!--// --> // JS
        var SITE_BASE_LANG="<?=getLanguage();?>";
    //-->
    </script>
    
    
     <?php if( _is_logged() AND $simpleheder==false ): // solo se si è loggati ?>
        <script>
              ga('set', 'userId',<?=$this->user->iduser?>); //Imposta l'ID utente utilizzando l'ID utente della persona che ha eseguito l'accesso.
        </script>
        
        <header class="main-header">
          <!-- Logo -->
          <a href="<?=  base_url(getLanguage()."/dashboard")?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">
                <img src="/public/img/logo-small.png" class="logomini" />
            </span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <img src="/public/img/logo-winnub.png" class="logo" />
            </span>

          </a>

          <?php 
          //barra di navigazione alta
          $this->view('limap/_header_nav');
          ?>

        </header>
        
        
        <script>
             var user_winnub=[{guuid:'<?=$this->user->iduser?>'}];
        </script>
        
    <?php endif;?>
