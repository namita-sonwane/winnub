<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="form-group">
   <label>Username </label>
   <input id="username" type="text" name="username" class="form-control" value='<?=$this->user->username?>' disabled=""/>
</div>

<div class="form-group">
    <label>Email</label>
    <input id="fr_email" type="email" name="email" class="form-control" value='<?=$this->user->email?>' required/>
</div>



<div>
  <p>Puoi cambiare la password del tuo account, ricorda di inserire la tua password attuale</p>
</div>

<div class="form-group">
   <label>Password Attuale</label>
   <input type="password" name="password" class="form-control" value='' />
</div>
<hr/>
<div class="form-group">
   <label>Nuova password</label>
   <input type="password" name="newpassword" class="form-control" value='' />
</div>
<div class="form-group">
   <label>Conferma nuova password</label>
   <input type="password" name="confirm_newpassword" class="form-control" value='' />
</div>
