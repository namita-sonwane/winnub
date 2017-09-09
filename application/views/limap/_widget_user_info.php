<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($this->user)){
    
?>
<!-- Widget: user widget style 1 -->
<div class="box box-widget widget-user">
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header bg-aqua-active" style="background-image: url(/<?=$this->user->profile["foto"]?>);">
    <h3 class="widget-user-username"><?=$this->user->profile["nome"]?> <?=$this->user->profile["cognome"]?></h3>
    <h5 class="widget-user-desc"><?=$this->user->email?></h5>
  </div>

  <div class='box-body'>
      
      <ul class='list-group'>
          <li class='list-group-item'>
            <?=$this->user->profile["nome"]?> <?=$this->user->profile["cognome"]?>
          </li>
          <li class='list-group-item'>
            Ruolo: <?=$this->user->risolviRuolo()?> 
          </li>
      </ul>
      
  </div>

  <!--<div class="box-footer">
    <div class="row">
      <div class="col-sm-4 border-right">
        <div class="description-block">
          <h5 class="description-header">3,200</h5>
          <span class="description-text">Ordini attivi</span>
        </div>
     
      </div>
     
      <div class="col-sm-4 border-right">
        <div class="description-block">
          <h5 class="description-header">13,000</h5>
          <span class="description-text">Preventivi</span>
        </div>
      
      </div>
  
      <div class="col-sm-4">
        <div class="description-block">
          <h5 class="description-header">35</h5>
          <span class="description-text">Richieste</span>
        </div>
    
      </div>
  
    </div>
 
  </div>-->
</div>
<!-- /.widget-user -->
<?php }?>