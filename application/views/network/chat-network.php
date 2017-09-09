<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>

<!-- Construct the box with style you want. Here we are using box-danger -->
<!-- Then add the class direct-chat and choose the direct-chat-* contexual class -->
<!-- The contextual class should match the box, so we are using direct-chat-danger -->
<div class="box box-danger direct-chat direct-chat-danger">
  <div class="box-header with-border">
    <h3 class="box-title">Direct Chat</h3>
    <div class="box-tools pull-right">
      <span data-toggle="tooltip" title="3 New Messages" class="badge bg-red" id='newmessages'></span>
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <!-- In box-tools add this button if you intend to use the contacts pane -->
      <button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
      
    </div>
  </div><!-- /.box-header -->
  <div class="box-body">
    <!-- Conversations are loaded here -->
    <div class="direct-chat-messages" id="chatmessages" data-username="<?=$username?>" data-limits="8">
        
        
      
    </div><!-- /.box-body -->
  
  <div class="box-footer">
    <div class="input-group">
        
     
            <input type="text" name="message" placeholder="Type Message ..." class="form-control" id='messaggiochat'>
            
            <span class="input-group-btn">
              <button type="button" class="btn btn-danger btn-flat" id='sendmessage'>Send</button>
            </span>       
        
        
    </div>
  </div><!-- /.box-footer-->
  
  
</div><!--/.direct-chat -->

</div>