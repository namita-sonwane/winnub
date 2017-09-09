<?php defined('BASEPATH') OR exit('No direct script access allowed');

//includo l'header
$this->view('limap/_header',
        array(
    "_body_class"=>"login-page"
    
));

?>
<div class="login-box">
    
    <div class="login-logo">
        <img src="/public/img/logo-winnub.png">
    </div>
    
    <div class="login-box-body">
       
        <form class="form" action="<?=base_url("/".getLanguage()."/signin")?>" method="post" id="formlogin">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Username" class="form-control"/>
            </div>

            <div class="form-group">
                <label>password</label>
                <input type="password" name="password" placeholder="Password" class="form-control"/>
            </div>

            <div class="form-group text-center">
                <input type="submit" value="Accedi" class="btn btn-primary btn-flat btn-lg"/>
            </div>

        </form>
        
          
        <!-- /.social-auth-links -->
        
        
        <a href="/<?=getLanguage()?>/signup" class="text-center btn btn-default btn-flat"><?=t("Registrati")?></a>
        
        <?php
        /* DISABLE DEMO ACCESS
        ?>
       <form class="form" action="/en/guestlogin" method="post" id="guestlogin">
            
            <div class="form-group text-center">
                <h3>Accesso temporaneo</h3>
                <input type="submit" value="Accedi come ospite" class="btn btn-primary btn-danger"/>

            </div>

        </form>
       
       <?php */ ?>
        <p class="text-right"><a href="/<?=getLanguage()?>/restore">I forgot my password</a></p>
        

        
    </div>
    
    
    
	
</div>
<?php
//includo l'header
$this->view('limap/_footer');