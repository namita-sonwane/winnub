<?php  defined('BASEPATH') OR exit('No direct script access allowed');

//
//
// QUOTE PAGE VIEW
//
$this->view('limap/_header');

$tabella=$this->user->getMy("preventivi",null," ORDER BY codice_utente DESC ");

if(isset($schema)){
    
    if(is_array($schema)){
         $tabella=$schema;
         $schema="fatture";
    }else{
    //
        $tabella=$this->user->getMy($schema);
    }
    $_header_=array(
        t("h-codice"),
        t("h-cliente"),
        t("h-utente"),
        t("h-anno"),
        t("h-data"),
        
        t("h-totale"),
        
        t("h-azioni"),
    );
    
}else{
    $schema="preventivi";
    $_header_[]= t("h-codice");
    
    if($this->user->isAdmin()){
       
       $_header_[]= t("h-utente");
    }
    
    //$_header_[]=t("h-nome");
    $_header_[]=t("h-cliente");
    $_header_[]=t("h-data");
    $_header_[]=t("h-stato");
    $_header_[]=t("h-totale");
    $_header_[]=t("h-numarticoli");
    $_header_[]=t("h-azioni");
   
}



$this->view('limap/_sidebar');

?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       &nbsp;
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
        
        
            <?php
            
        if($schema=="preventivi"){         
            $this->view('limap/_barra_strumenti',
                array(
                    "buttons"=>array(
                        array("nome"=>t("nuovo"),"href"=>"/".getLanguage()."/quote","class"=>"btn btn-actions-winnub1","icona"=>'<i class="fa fa-plus"></i>'),
                        array("nome"=>t("Messaggi"),"href"=>base_url($lingua."/message"),"class"=>"btn colore-secondario","icona"=>'<i class="fa fa-envelope"></i>')
                    )
                )
                );
        
        }else if($schema=="fatture"){
             $this->view('limap/_barra_strumenti',
                array(
                    "buttons"=>array(
                        array("nome"=>t("nuova"),"href"=>"/".getLanguage()."/invoice/create","class"=>"btn btn-actions-winnub1","icona"=>'<i class="fa fa-plus"></i>'),
                        //array("nome"=>t("Messaggi"),"href"=>base_url($lingua."/message"),"class"=>"btn colore-secondario","icona"=>'<i class="fa fa-envelope"></i>')
                    )
                )
                );
        }
?>
        
        
            <div class="box box-default">
                
              
                <div class="box-body">
                    
                    <div class="table-responsive">
                        
                        <table class="table table-striped" id="tableQuote">
                            <thead>
                                <tr>
                                   <?php 
                                    foreach($_header_ as $h){ echo "<th>$h</th>";}?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(isset($tabella)){
                                    
                                    
                                foreach($tabella as $t):
                                        
                                switch($schema){
                                        case "preventivi":
                                            
                                            $cliente=Cliente_model::get($t->cliente);
                                                
                                            
                                            
                                            //print_r($cliente);
                                            
                                            $infosend=$t->infoInvio();
                            ?>
                                <tr>
                                        <td>
                                            <?=$t->codice_utente?>
                                        </td>
                                        
                                        
                                        <?php  if($this->user->isAdmin()){
                                            
                                                $utenteproprietario= User_model::getUser($t->utente);
                                                
                                                if(count($utenteproprietario)){
                                                    $utenteproprietario=($utenteproprietario[0]);
                                            
                                            ?>
                                                    <td><?=$utenteproprietario->username?></td>
                                        
                                        <?php   }
                                            }
                                        ?>
                                        
                                        
                                        
                                        <td>
                                            <?php if(empty($cliente["error"])):
                                                $cliente=$cliente[0];
                                                ?>
                                                <div <?php if($t->cliente==0):?> data-toggle="tooltip" data-placement="top" title="Cliente assente!" <?php endif;?>>
                                                <a href="/clienti/edit/<?=$t->cliente?>" data-modal="#"><?=$cliente->NomeCompleto()?></a>
                                            <?php endif;?>
                                        </td>
                                        
                                        <td>
                                            <?=date("d/m/Y ",strtotime($t->data))?>
                                        </td>
                                        <td>
                                            <label class="labelstato label-<?=$t->stato?>"><?=t($t->stato)?></label>
                                        </td>
                                        
                                        <td>
                                            € <?=number_format($t->getTotale(),2,"."," ");?>
                                        </td>

                                        <td class="text-center">
                                            
                                                <div class="dropdown">
                                                    
                                                    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"  id="dropdownMenu1">
                                                        <i class='fa fa-paper-plane' aria-hidden="true"></i>
                                                     <span class="caret"></span>
                                                    </button>
                                                    
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                        
                                                    <?php
                                                        $ki=$infosend["numero_risultati"];
                                                         if( $ki >0 ){
                                                             $testo="Inviata %d ".(($ki==1)?"volta":"volte");
                                                             ?>
                                                        <h6 class="dropdown-header"><?php printf(t($testo),$ki)?></h6>
                                                             <?php
                                                             foreach($infosend["dati"] as $invio){
                                                                 $urls="qdetail/".MD5(crypt($invio["idSpedizione"],PUBLIC_SALT));
                                                                 echo "<li class='dropdown-item'><a href='/".getLanguage()."/$urls' class='' target='new'><i class='fa fa-eye'></i>".t("mostra")."</a></li>";
                                                             }
                                                             
                                                         }else{
                                                             echo "<li> ".t("l'elemento non è stato inviato")." </li>";
                                                         }
                                                    ?>
                                                     </ul>
                                                    
                                                </div>
                                            
                                        </td>
                                  
                                    
                                    
                                        <td class="text-center">
                                            
                                            <!-- Small button group -->
                                            <div class="btn-group">
                                                  <button class="btn btn-default btn-sm dropdown-toggle" 
                                                          type="button" 
                                                          data-toggle="dropdown" 
                                                          aria-haspopup="true" 
                                                          aria-expanded="true">
                                                      <i class='fa fa-gears'></i>
                                                      
                                                   <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="<?=base_url()."".getLanguage()?>/quote/send/<?=MD5($t->idpreventivo)?>" class="">
                                                              <i class="fa fa-at"></i>
                                                              <?=t("invia-preventivo")?>
                                                            </a>
                                                        </li>
                                                        
                                                        <li>
                                                             <a href="<?=base_url(getLanguage()."/quote/create-pdf/".MD5($t->idpreventivo)."");?>" class="" target="new">
                                                              <i class="fa fa-download"></i>
                                                              <?=t("scarica-preventivo")?>
                                                            </a>
                                                        </li>
                                                        
                                                        <li>
                                                            <a href="<?=base_url(getLanguage()."/quote/detail/".MD5($t->idpreventivo));?>" class="">
                                                              <i class="fa fa-eye"></i>
                                                             <?=t("mostra-preventivo")?>
                                                         </a>
                                                        </li>
                                                        <li>
                                                            <a  href="<?=base_url(getLanguage()."/quote/duplica/".MD5($t->idpreventivo));?>">
                                                                <i class="fa fa-clone"></i>
                                                                 <?=t("clona-preventivo")?>
                                                            </a>
                                                        </li>
                                                        <li role="separator" class="divider"> </li>
                                                        
                                                        <?php 
                                                        if($this->user->isAdmin()){
                                                            if($t->stato==Preventivo_model::STATO_CONFERMATO):
                                                                $invoice=$t->findInvoice();
                                                                if(count($invoice)>0){
                                                                $invoice=$invoice[0];
                                                               
                                                            ?>
                                                            <li>
                                                                 <a href="<?=base_url(getLanguage()."/invoice/view/".$invoice->codfatt);?>" 
                                                                    class=" ">
                                                                     <i class="fa fa-archive"></i>
                                                                      <?=t("apri-fattura")?>
                                                                  </a>
                                                            </li>
                                                            
                                                        <?php }
                                                            endif;
                                                        }?>
                                                            
                                                        <?php if($t->stato==Preventivo_model::STATO_BOZZA || $t->stato==Preventivo_model::STATO_ATTESA):?>
                                                            <li>
                                                                 <a href="<?=base_url(getLanguage()."/quote/toinvoce/".MD5($t->idpreventivo));?>" 
                                                                    class="buildinvoice">
                                                                     <i class="fa fa-archive"></i>
                                                                     <?php if($this->user->isAdmin()){?>
                                                                        <?=t("genera-fattura-admin")?>
                                                                     <?php }else{?>
                                                                        <?=t("genera-fattura")?>
                                                                     <?php }?>
                                                                  </a>
                                                            </li>
                                                            
                                                        <?php endif; ?>
                                                            
                                                        <li role="separator" class="divider"> </li>
                                                            <li>
                                                                <a href="<?=base_url(getLanguage()."/quote/delete/".MD5($t->idpreventivo));?>" class="">
                                                                      <i class="fa fa-trash-o"></i> <?=t("elimina")?>
                                                                  </a>
                                                            </li>
                                                        
                                                  </ul>
                                            </div>
                                                       
                                                      
                                                       

                                                       
                                            
                                        </td>
                                
                                </tr>
                              <?php
                               break;
                                       /** SEZIONE FATTURA**/
                                        case "fatture":
                                            
                                            //print_r($t);
                                            $cliente=null;
                                            $nocliente=true;
                                            if( $t->cliente > 0 ){
                                                
                                                $cliente=Cliente_model::get(MD5($t->cliente));
                                                if(count($cliente)>0){
                                                    $cliente=$cliente[0];
                                                    $nocliente=false;
                                                }else{
                                                   
                                                }
                                            }else{
                                                //print_r($t);
                                            }
                               ?>
                                            <tr <?php if($_REQUEST["codice"]==$t->codice_seq){ echo "selezionato";}?>>
                                                <td>
                                                    <?=$t->codice_seq?>
                                                </td>
                                                 
                                                <td>
                                                    
                                                    <?php if($t->cliente>0 && !$nocliente ){?>
                                                    
                                                    <a href="/<?=getLanguage()?>/clienti/edit/<?=$t->cliente?>" data-toggle="tooltip" data-placement="top" title="<?=t("Gestisci cliente")?>" class="btn btn-default btn-sm">
                                                        <?php
                                                        if(isset($cliente->cognome_cliente) && $cliente->cognome_cliente!=""){
                                                            echo $cliente->cognome_cliente;
                                                        }else{
                                                            echo t("Mostra cliente");
                                                        }?>
                                                    </a>
                                                    <?php }else{ ?>
                                                        <?=t("No client data!")?>
                                                   <?php }?>
                                                    
                                                    
                                                </td>
                                                <td>
                                                <?php // if($this->user->isAdmin()){
                                                
                                                    $utenteproprietario=User_model::getUser($t->utente);
                                                    
                                                    if(count($utenteproprietario)){
                                                        $utenteproprietario=($utenteproprietario[0]);
                                            
                                                    ?>
                                                    <a href="/<?=getLanguage()?>/network/user/<?=$utenteproprietario->username?>"><?=$utenteproprietario->username?></a>
                                                    <?php   }
                                                    //}
                                                ?>
                                                </td>
                                                 <td>
                                                     <?=$t->anno?>
                                                </td>
                                                 <td>
                                                     <?php printf(t("fattura del %s "),date(t("date-format-default"),strtotime($t->data)))?>
                                                </td>
                                                
                                                <td>
                                                     € <?=number_format($t->totale,2,"."," ")?>
                                                </td>
                                                

                                                <td class="text-center">
                                                    
                                                    <a href="<?=base_url()."".getLanguage()?>/invoice/create_pdf/<?=MD5($t->codfatt)?>" class="btn btn-default btn-xs" target="new"><i class="fa fa-print"></i></a>
                                                    
                                                    <a href="<?=base_url()."".getLanguage()?>/invoice/send/<?=($t->codfatt)?>" class="btn btn-default btn-xs"><i class="fa fa-at"></i></a>
                                                    
                                                    <a href="<?=base_url()."".getLanguage()?>/invoice/download_pdf/<?=MD5($t->codfatt)?>" class="btn btn-default btn-xs"><i class="fa fa-download"></i></a>
                                                    
                                                    <a href="<?=base_url("/".getLanguage()."/invoice/view/".($t->codfatt));?>" class="btn btn-default btn-info btn-xs">
                                                         <i class="fa fa-inverse fa-eye"></i>

                                                    </a>
                                                </td>

                                        </tr>
                                            <?php
                                            break;
                                       
                                }        
                                        
                                ?>
                                        
                                        
                                        
                                    
                                <?php endforeach; 
                                
                                }?>
                                
                            </tbody>
                            
                           
                            
                        </table>
                        
                    </div>
                   
                </div>
            </div>
       
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <div class="modal fade" id="modal-invoice" tabindex="-1" role="dialog" aria-labelledby="modal-invoiceLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><?=t("Imposta-fattura")?></h4>
      </div>
      <form action="<?=base_url(getLanguage()."/quote/toinvoce/")?>" method='post' id='formconfirminvocie'> 
      <div class="modal-body">
          <div class="content">
              <div class="row">
                  <label><?=t('label-codice')?></label>
                  <input type="text" name="codice_fatt" class="form-control"/>
              </div>
              <div class="row">
                  <label><?=t('label-anno')?></label>
                  <input type="text" name="anno_fatt" class="form-control "/>
              </div>
              <input type="hidden" name="actionurl"/>
              <input type="hidden" name="code"/>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Conferma dati</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
//includo l'header
$this->view('limap/_footer');