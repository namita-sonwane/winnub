<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Email Winnub</title>
        <style>
            body{
                font-family: Verdana, sans-serif;
                font-size: 10pt;
                font-weight: 100;
            }
            #infomess{
                width: 100%;
                max-width: 600px;
                margin: 0px auto 0px;
            }
            

            .btn1{
                padding: 22px 23px;
                background-color: #aeae4e;
                color: #f4f4f4;
                text-align: center;
                text-decoration: none;
                text-transform: uppercase;
                
            }
           
            .row-user{
                clear: both;
                padding: 6px 0px 22px;
                display: block;
            }
            .row-user h3{
                margin: 12px 0px 12px;
            }
            .row-user p{
                padding: 0px;
                margin: 0px;
            }
            .row-user .icon-user{
                width: 64px;
                height: 64px;
                float: left;
                border: 1px solid #eee;
                margin-left: 32px;
                margin-right: 12px;
                overflow: hidden;
                vertical-align: middle;
                background-repeat: no-repeat;
                background-position: center;
                background-size: contain;
                border-radius: 8px;
            }
            

            
.messaggio {
  position:relative;
  padding:15px;
  margin:12px 0 0.5em;
  color:#333;
  background:#eee;
  /* css3 */
  -webkit-border-radius:10px;
  -moz-border-radius:10px;
  border-radius:10px;
}

.messaggio p {font-size:28px; line-height:1.25em;}

/* this isn't necessary, just saves me having to edit the HTML of the demo */
.messaggio:before {
  content:url(twitter-logo.gif);
  position:absolute;
  top:-60px;
  left:0;
  width:155px;
  height:36px;
  /* reduce the damage in FF3.0 */
  display:block;
}

/* creates the triangle */
.messaggio:after {
  content:"";
  position:absolute;
  top:-30px;
  left:50px;
  border:15px solid transparent;
  border-bottom-color:#eee;
  /* reduce the damage in FF3.0 */
  display:block;
  width:0;
}



/* display of quote author (alternatively use a class on the element following the blockquote) */
.messaggio + p {padding-left:15px; font:14px Arial, sans-serif;}


            
        </style>
    </head>
    <body>
        
        <div class='body-email'>
            
            <div id="infomess">
                   
                

                        <div class="row-user">
                            <div class="icon-user" style="background-image: url(<?=$userimage?>);"></div>
                            <h3>
                                <?=$this->user->getDenominazioneAzienda()?>
                                <small><?=$this->user->getNomeCompleto()?></small>
                            </h3>
                            
                            <p><?=t("il preventivo richiesto è pronto")?></p>
                            
                        </div>
                        <div class="messaggio">
                            <div class="arrow"></div>
                            
                            <p><?=$messaggio?></p> 
                        </div>


                    <div class="schema-prodotto">
                        <?=$schemaprodotto?>
                    </div>


                    
                    <div style="text-align: center;padding: 12px 0px 12px;">
                        
                        <br/>
                            <a href='<?=$urlallegato?>' class='btn1'> <?=t("Vai al preventivo")?></a>
                        <br/>
                        
                    </div>
             </div>   
            
        </div>
        
    </body>
</html>