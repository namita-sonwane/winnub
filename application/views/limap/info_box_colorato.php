<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<!-- Apply any bg-* class to to the info-box to color it -->
<div class="info-box <?=$classe?>">
  <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
  <div class="info-box-content">
    <span class="info-box-text"><?=$testo?></span>
    <span class="info-box-number"><?=$numero?></span>
    <!-- The progress section is optional -->
    <div class="progress">
      <div class="progress-bar" style="width: <?=$valore?>%"></div>
    </div>
    <span class="progress-description">
      <?=$testo2?>
    </span>
  </div><!-- /.info-box-content -->
</div><!-- /.info-box -->