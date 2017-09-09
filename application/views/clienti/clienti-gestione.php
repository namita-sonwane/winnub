<?php

//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');

//questa chiamata è solo admin
$tabella=$this->user->getMy("clienti");
    

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        &nbsp;
      </h1>
      <?php get_breadcrumbs();?>
    </section>

    <!-- Main content -->
    <section class="content">
        
        
        <?php
        
        
         $this->view('limap/_barra_strumenti',
                array(
                    "buttons"=>array(
                        array("nome"=>t("nuovo"),"href"=>"/".getLanguage()."/clienti/nuovo","class"=>"btn btn-actions-winnub1","icona"=>'<i class="fa fa-plus"></i>'),
                        //array("nome"=>t("Messaggi"),"href"=>base_url($lingua."/message"),"class"=>"btn colore-secondario","icona"=>'<i class="fa fa-envelope"></i>')
                    )
                )
                );
         ?>
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="box box-default">
                    
                    
                    <div class="box-body">
                        
                        <div class='list-group'>
                            
                            
                            <?php 

if(count($tabella)>0){
    
    ?>
                            <table class='table' id='tableclienti'>
                                <thead>
                                    <tr>
                                        <th><?=t("Cod.")?></th>
                                        <th>
                                            <?=t("Ragione sociale")?>
                                        </th>
                                         <th>
                                            <?=t("Nome")?>
                                        </th>
                                        <th>
                                            <?=t("Cognome")?>
                                        </th>
                                        <th><?=t("P. lva")?></th>
                                        <th><?=t("Email")?></th>
                                        <th><?=t("Mobile")?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
        <?php
    foreach($tabella as $riga){
        ?>
                            <tr>
                                <td>
                                    <?=$riga->codcliente?>
                                </td>
                                <td>
                                    <?=$riga->rag_sociale_cliente?>
                                </td>
                                
                                <td>
                                    <?=$riga->nome_cliente?>
                                </td>
                                <td>
                                    <?=$riga->cognome_cliente?>
                                </td>
                               
                                <td>
                                    <?=$riga->PIVA?>
                                </td>
                                
                                <td>
                                    <?=$riga->email?>
                                </td>
                                <td>
                                    <?=$riga->mobile?>
                                </td>
                                
                                <td>
                                    
                                    <a href="/<?=getLanguage()?>/clienti/analyse_customer/<?=($riga->codcliente)?>" class="btn btn-default btn-sm"><i class='fa fa-search'></i></a>
                                    <a href="/<?=getLanguage()?>/clienti/edit/<?=($riga->codcliente)?>"  class="btn btn-default btn-sm"> <i class='fa fa-edit'></i> </a>
                                    <a href="/<?=getLanguage()?>/clienti/delete/<?=($riga->codcliente)?>" class="btn btn-danger btn-sm eliminacliente"><i class='fa fa-trash'></i></a>
                                    
                                </td>
                                
                                
                            </tr>       
<?php
    }
    ?></tbody></table>
<?php
    
}else{
    echo "<h3>Non hai ancora inserito dei clienti</h3>";
    echo "<p>Creane uno adesso <a href=\"#\" class='btn btn-default'>Crea cliente</a></p>";
    echo "<br/><br/>";
}

?>
                               
                        </div>
                
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  

<?php
//includo l'header
$this->view('limap/_footer');