<?php

//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');

//questa chiamata è solo admin
$tabella=$this->user->getMy("categorie-prodotti");
    


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
                        array("nome"=>t("nuovo"),"href"=>"#","class"=>"btn btn-actions-winnub1","icona"=>'<i class="fa fa-plus"></i>',"datas"=>"data-target=\"#modalcategoria\" data-toggle=\"modal\""),
                        array("nome"=>t("prodotti"),"href"=>"/".getLanguage()."/prodotti/gestione","class"=>"btn colore-secondario","icona"=>'<i class="fa fa-upload"></i>')
                    )
                )
                );?>
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="box box-default">
                    
                 
                    <div class="box-body">
                        
                        
                        
                        <div class='list-group'>
                            
                            
                            <?php 

if(count($tabella)>0){
    
    ?>
                            <table class='table'>
                                <thead>
                                    <tr>
                                        
                                         <th>
                                            <?=t("Nome")?>
                                        </th>
                                        <th>
                                            <?=t("Gruppo")?>
                                        </th>
                                        <th>
                                            <?=t("Descrizione")?>
                                        </th>
                                        
                                        <th><?=t("Ordine")?></th>
                                        <th><?=t("Num. prodotti")?></th>
                                        <th></th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    
        <?php
    foreach($tabella as $riga){
        ?>
                            <tr>
                               
                                <td>
                                    <?=$riga["valore"]?>
                                </td>
                                
                                <td>
                                <?=$riga["gruppo"]?>
                                </td>
                                <td>
                                <?=$riga["descrizione"]?>
                                </td>
                                
                                <td><?=$riga["ordine"]?></td>
                                <td><?=$this->modello_prodotti->getNumberProductCategory($riga["idcategoria"])?></td>
                                <td class="text-right">
                                    <a href="#" class="btn btn-default editcategory" 
                                       data-code="<?=$riga["idcategoria"]?>" 
                                       data-nome="<?=$riga["valore"]?>"
                                       data-gruppo="<?=$riga["gruppo"]?>"
                                       data-descrizione="<?=$riga["descrizione"]?>"
                                       data-toggle="modal"
                                       data-target="#modalcategoria">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger deletecat" 
                                       data-code="<?=$riga["idcategoria"]?>">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>       
<?php
    }
    ?></tbody></table>
<?php
    
}else{
    
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