<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$lingua=getLanguage();

//print_r($this->user);
if(!isset($pagina_active)){
    $pagina_active="";
}

if(!isset($sezione)){
    $sezione="";
}



//conto il numero di prodotti nel carrello
$prodotti=WinnubCart();
if(isset($prodotti["qty"])){
    $numeroprodotti=$prodotti["qty"];
}else{
    $numeroprodotti="";
}

?>


<?php _getSidebarModule("hook_left");?>

<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="min-height: 60px;">
        
        <div class="info" style=''>
            <?=$this->user->profile["nome"]?>
            <?=$this->user->profile["cognome"]?>
        </div>
          
      </div>
      <!-- search form -->
      <?php /*
      <form action="<?=base_url(getLanguage()."/search/")?>" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="<?=t('search');?>...">
           <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
           </span>
        </div>
      </form>
       * 
       */?>
      
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
          
         <li class="treeview <?=(($sezione=="")?"active":"")?>">
            <a href="/<?=$lingua?>/">
              <i class="fa fa-tachometer" aria-hidden="true"></i>
              <span><?=t('Dashboard');?></span>
            </a>
          
        </li>
        
        <li class="treeview <?=(($sezione=="Contatti")?"active":"")?>">
            
            <a href="/<?=$lingua?>/contacts">
                      <i class="fa fa-users"></i>
                      <span><?=t('Contatti');?></span>
            </a>
            
        </li>
        
      
        
        <!--li class="treeview <?=(($sezione=="Contatti")?"active":"")?>">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span><?=t('Contatto');?></span>
          </a>
          <ul class="treeview-menu">
              <li class="<?=($pagina_active=="quote-new")?"active":""?>">
                  <a href="/<?=$lingua?>/contatto">
                     <i class="fa fa-circle-o"></i> <?=t('nuovo-contatto');?></a>
             </li>
             <li class="<?=($pagina_active=="listacontatti")?"active":""?>">
                 <a href="/<?=$lingua?>/contatto/contattolist">
                     <i class="fa fa-circle-o"></i> <?=t('lista-contatti');?></a>
             </li>
            
             
          </ul>
        </li-->
        
        
        
       
        <li class="<?=(($sezione=="quote")?"active":"")?>">
          <a href="/<?=$lingua?>/quote/all">
            <i class="fa fa-files-o"></i>
            <span><?=t('Preventivi');?></span>
          </a>
          
        </li>
        
        
        <?php if($this->user->isAdmin()): //verifica se l'utente è incaricato alla gestione'?>
        
          <li class="<?=(($sezione=="invoice-index")?"active":"")?>">
          <a href="/<?=$lingua?>/invoice/all">
            <i class="fa fa-files-o"></i>
            <span><?=t('Fatture');?></span>
          </a>
          
        </li>
        
        
        <?php endif; ?>
        
        
        
          <?php if($this->user->isAdmin()): //verifica se l'utente è incaricato alla gestione'?>
        <!--Task menu  start-->
  
         
        
         
        <!--Task menu  start-->
 
         <!--<li class="treeview <?=(($sezione=="Compito ")?"active":"")?>">
            
            <a href="#" class="">
                <i class="fa fa-tasks" aria-hidden="true"></i>  <span><?=t("Progetti")?></span>
            </a>
            <ul class="treeview-menu">
                 <li class="<?=($pagina_active=="gestionet")?"active":""?>">
                    <a href="<?php echo base_url($lingua."/compito")?>"><i class="fa fa-circle-o"></i> <?=t("Nuovo")?></a>
                </li>
                
                <li class="<?=($pagina_active=="gestione21")?"active":""?>">
                    <a href="<?php echo base_url($lingua."/compito/compitolist")?>"><i class="fa fa-circle-o"></i> <?=t("Calendario")?></a>
                </li>
               
            </ul>
             
        </li>-->
          <!--Task menu End-->
        <!--Task menu End-->
          
		 <!--Start PDL -->
		  <li class="treeview <?=(($sezione=="PDL")?"active":"")?>">
            
            <a href="#" class="">
                <i class="fa fa-tasks" aria-hidden="true"></i>  <span><?=t("PDL")?></span>
            </a>
            <ul class="treeview-menu">
                 <li class="<?=($pagina_active=="nuovo_lista")?"active":""?>">
                    <a href="<?php echo base_url($lingua."/pdl")?>"><i class="fa fa-circle-o"></i> <?=t("Nuovo/Lista")?></a>
                </li>
                
                <li class="<?=($pagina_active=="ruoli")?"active":""?>">
                    <a href="<?php echo base_url($lingua."/pdl/ruoli")?>"><i class="fa fa-circle-o"></i> <?=t("Ruoli")?></a>
                </li>
				
				<li class="<?=($pagina_active=="ordinidelgiorno")?"active":""?>">
                    <a href="<?php echo base_url($lingua."/pdl/ordinidelgiorno")?>"><i class="fa fa-circle-o"></i> <?=t("Ordini del Giorno")?></a>
                </li>
               
            </ul>
             
        </li>
		 <!--END PDL -->
		  
        <?php endif;?>
          
        <!---//  //-->
        
        <!--li class="treeview <?=(($sezione=="messagge-index")?"active":"")?>">
            
            <a href="<?php echo base_url($lingua."/message")?>">
                <i class="fa fa-commenting-o" aria-hidden="true"></i>  <span><?=t("Messaggi")?></span>
            </a>
            
           
             
        </li-->
        
        
          
        <?php if($this->user->isAdmin()): //verifica se l'utente è incaricato alla gestione'?>
        
      
        <li class=" <?= (($sezione=="media-index")?"active":"") ?>">
          <a href="<?=base_url("$lingua/media/")?>">
            <i class="fa fa-hdd-o" aria-hidden="true"></i>
            <span><?=t('winnub-drive');?></span>
          </a>
           
            
        </li>
        
        <?php endif;?>
        
        
        
        <!--li class="treeview <?=(($sezione=="profilo-ordini")?"active":"")?>">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span><?=$this->lang->line('ordini');?></span>
            <span class="label label-primary pull-right"><?=$this->user->getTotaleOrdini()?></span>
          </a>
          <ul class="treeview-menu">
            <li>
                <a href="<?php echo base_url("$lingua/profilo/ordini/")?>">
                    <i class="fa fa-circle-o"></i><?=$this->lang->line('mostra-ordini');?>
                </a>
            </li>
           
            <li>
                <a href="<?php echo base_url("$lingua/oridini/impostazioni/")?>">
                    <i class="fa fa-circle-o"></i><?=$this->lang->line('impostazioni-ordini');?>
                </a>
            </li>
            
          </ul>
        </li-->
        
        <li class="<?=(($sezione=="clienti")?"active":"")?>">
            
            <a href="/<?=$lingua?>/clienti" class="">
                <i class="fa fa-users"></i> <span><?=t("Clienti")?></span>
            </a>
            
           
             
        </li>
        
        
        
          <?php if($this->user->isAdmin()): //verifica se l'utente è incaricato alla gestione'?>
        
        
          <li class="<?=(($sezione=="fornitori")?"active":"")?>">
            
            <a href="/<?=$lingua?>/fornitori" class="">
                <i class="fa fa-users"></i>  <span><?=t("Fornitori")?></span>
            </a>
            
           
             
            </li>
        
        
        
        
       
      
        
        <li class="<?=(($sezione=="gestione-prodotto")?"active":"")?>">
            
            <a href="<?php echo base_url("$lingua/prodotti/gestione/")?>" class="">
                <i class="fa fa-cloud"></i> 
                <span><?=t("Prodotti")?></span>
            </a>
        </li>
        
        
        <!-- Purchase  menu-->
        <li class=" <?=(($sezione=="purchases")?"active":"")?>">            
            <a href="<?php echo base_url("$lingua/purchases/shopping")?>" class="">
                <i class="fa fa-shopping-cart"></i>  <span><?=t("Spese di acquisto")?></span>
            </a>            
			
                    
        </li>
        
        
        <?php endif;?>
        
       </ul>
        
       
      
        <ul class="sidebar-menu">
          
           
            
            <li class="treeview <?=(($sezione=="network")?"active":"")?>">
                
                <a href="<?="/".getLanguage()."/network/"?>"> <i class="fa fa-share-alt" aria-hidden="true"></i>
                    <span><?=t("utenti-attivi")?></span>
                    
                </a>
                
                
                
            </li>
            
        </ul>
      
      
      <?php if($this->user->isAdmin()): //verifica se l'utente è incaricato alla gestione'?>
      
        <ul class="sidebar-menu">
          
            <li class="header">
                <?=t('Marketing')?>
            </li>
            
            <li class="treeview ">
                
                <a href="#" class="disabled"> 
                    <i  class="fa fa-paper-plane-o" aria-hidden="true"></i>
                    <span><?=t("Email")?><small class="label label-warning pull-right"><?=t("Presto disponibile")?></small></span>
                    
                </a>
                
                
                
            </li>
        </ul>
      
      
      
      <ul class="sidebar-menu">
                <li class="header"> <?=t('Profilo');?> </li>

                <li class="treeview <?=(($sezione=="settings")?"active":"")?>">

                    <a href="#" class="">
                        <i class="fa fa-gears"></i> 
                        <span><?=t('Gestione profilo');?></span>
                    </a>

                    <ul class="treeview-menu">

                   
                  
                    <li class="<?=($sezione=="profili")?"active":""?>">
                        <a href="<?php echo base_url("$lingua/profile")?>"><i class="fa fa-circle-o"></i>
                            <?=t('Impostazioni-profilo');?>
                        </a>
                    </li>
                    
                      <li class="<?=($categoriabase=="menu-impostazioni")?"active":""?>">
                        <a href="<?php echo base_url("$lingua/admin/impostazioni")?>"><i class="fa fa-circle-o"></i>
                            <?=t('pagamenti-aliquote');?>
                        </a>
                    </li>
                    
                     <li class="<?=($sezione=="gestione-ordini")?"active":""?>">
                        <a href="<?php echo base_url("$lingua/admin/gestione/ordini")?>"><i class="fa fa-circle-o"></i> 
                            <?=t('pagamenti-licenze');?> 
                        </a>
                    </li>

                  </ul>
                </li>
        
        </ul>
      
      
        <?php endif;?>
      
      
    
    </section>
    <br/><br/>
    <!-- /.sidebar -->
  </aside>