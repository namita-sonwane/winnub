<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//includo l'header
$this->view('limap/_header');

$this->view('limap/_sidebar');

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      
      <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=t("Fatturazione")?> <small><?=t("messaggi-sezione")?></small>
      </h1>
      <ol class="breadcrumb">
          <li class=""><a href="/dashboard"><?=t("dashboard-sezione")?></a></li>
            <li class="active"><?=t("messaggi-sezione")?></li>
      </ol>
    </section>

   
    <section class="content" ng-app="winnub">

     
          
          
        <div ng-view></div>

       
          
      
      
    </section>
      
  </div>
<?php


$this->view('limap/_footer');
?>