<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<!-- Header Navbar: style can be found in header.less -->
 <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only"><?=t("Toggle navigation")?></span>
    </a>
      
     
        
      

      
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <?php
            /*
            ?>
            <li>
                  <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown">
                    <i class="fa fa-plus"></i> 
                    <span><?=t("new-action-nav");?></span>
                   </a>
                    <ul class="dropdown-menu menu-action-nav">
                           
                        <li>
                            <a href="/<?=getLanguage()?>/quote"><?=t("nuovo-preventivo")?></a>
                        </li>
                        <li>
                            <a href="/<?=getLanguage()?>/invoice/create"><?=t("nuova-fattura")?></a>
                        </li>
                        <li>
                            <a href="/<?=getLanguage()?>/prodotti/create"><?=t("nuovo-prodotto")?></a>
                        </li>
                        <li>
                            <a href=""><?=t("nuovo-categoria")?></a>
                        </li>
                        <li>
                            <a href=""><?=t("nuovo-messaggio")?></a>
                        </li>
                        <li>
                            <a href=""><?=t("nuovo-cliente")?></a>
                        </li>
                    </ul>
                    
              </li>
            <?php
                */
                 if(false/*$this->user->isAdmin()*/){
            ?>
            <li class="upgrade-btn">
                <a href="/<?=getLanguage()?>/profile/upgrade">
                    <i class="fa fa-plus-square"></i>
                    <span><?=t("Upgrade")?></span>
                </a>
            </li>
            <?php  
            
                } 
            
            
            /**
            ?>
            
            <li class="dropdown quote active-quote">
                
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   <i class="fa fa-server"></i>
                   
                   <span class="label label-primary"><?=$this->user->getQuoteArticoli()?></span>
                </a>
                
                <ul class="dropdown-menu">
                    <li class="header"><?php
                        printf(t(" Ci sono %u prodotti nel preventivo "),$this->user->getQuoteArticoli())?></li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <div class="innerscroll-nav">
                      <ul class="menu">
                          
                            <li><!-- start message -->
                              
                            </li>
                    <!-- end message -->
                    </ul>
                  </div>
                </li>
               
              </ul>
                
            </li>
             * 
             */?>
            
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
              
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user"></i>
              
            </a>
              
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header bgimage">
                <div id="screenface">
                    <span>
                        <?=$this->user->username?>
                    </span>
                  
                
                </div>
              </li>
              <!-- Menu Body -->
              <li class="user-body text-center">
               
                  
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/profilo" class="btn btn-default btn-flat"><?=t("Profilo")?></a>
                </div>
                <div class="pull-right">
                  <a href="/logout" class="btn btn-default btn-flat"><?=t("Log out")?></a>
                </div>
              </li>
            </ul>
          </li>
          
          <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-globe"></i>
                    <span class="label label-success">
                        <?php

                echo getLanguage();

                ?>
                  </span>
                </a>
              <ul class="dropdown-menu">
                  <li><a href="/en/switchlang">EN</a></li>
                  <li><a href="/it/switchlang">IT</a></li>
                  
              </ul>
          </li>
          
          <?php /*<!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
          */?>
        </ul>
        
    </div>
</nav>