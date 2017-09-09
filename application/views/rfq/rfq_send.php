<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lingua=getLanguage();
//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');
?><!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=t("titolo-pagina-invia")?> 
        <small><?=t("sottotitolo-pagina-invia")?> </small>
      </h1>
      <ol class="breadcrumb">
        <li>
            <a href="<?=base_url("/dashboard")?>">
                <i class="fa fa-dashboard"></i> <?=t("dashboard")?>
            </a>
        </li>
        <li class="active"><?=t("prodotti")?></li>
         <li class="active"><?=t("preventivio")?></li>
      </ol>
    </section>

    <!-- Main content -->
    <form class="form" id='form_carrello' method="post" action="/<?=getLanguage()?>/quote/sendemail/<?=$codicepreventivo?>">
        
           
  </div>
  <!-- /.content-wrapper -->
  
  
<?php
exit;
$this->view('limap/_footer');
?>