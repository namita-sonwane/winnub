<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <meta charset="UTF-8" >
        <title>Registrazione su winnub</title>
        <style type="text/css">
           body{
                font-family: 'Geneva',sans-serif;
                /*background-color: #3c8dbc; */
                background-color: #c4c4c4;
                font-weight: 200;
            }
            p{
                color: #424242;
            }
            
            #wrapper{
                background-color: #fff;
                padding: 30px 22px 30px;
                max-width: 800px;
                margin: 12% auto 0px;
               
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                -o-border-radius: 8px;
                
                border-radius: 8px;
            }
            .center{
                padding: 12px 0px 12px;
            }
            .centered{
                text-align: center;
            }
            
            .logotops{
                max-height: 90px;
                float: right;
                margin-top: -55px;
                position: relative;
            }
            
            h1.titolo1{
                text-transform: uppercase;
                color: #3c8dbc;
            }
            
            a.btn-url{
                padding: 18px 22px;
                background-color: #aaa;
                margin: 30px;
                text-align: center;
                text-decoration: none;
                color: #fff;
                 background-color: #aC0601;
            }
            
            a.btn-url:hover{
               
                background-color: #DC3601;
            }
            
        </style>
    </head>
    <body>
        
        <div id="wrapper">
            
            <img src='https://app.winnub.com/public/img/logo-small.png' class='logotops' />
            
            <h1 class="titolo1"><?=t("Benvenuto in Winnub")?></h1>

            <?=t("testo-email-registrazione")?>
            <br/>
            <a href='<?=$urlaccesso?>'><?=t("Conferma la tua e-mail")?></a>
             <br/>
            <p><?=t("messaggio-email-brouser-support")?> <?=$urlaccesso?></p>
            
            
            <br/><br/>
            
            <div style="text-align: center;padding-bottom: 50px;">
                <a href="https://app.winnub.com/" class="btn-url">
                    <?=t("Accedi su winnub")?>
                </a>
                    
            </div>
            
            
        </div>
        
        
        
        
    </body>
</html>