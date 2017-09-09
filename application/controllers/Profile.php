<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    var $_RESULTS_=false;//gestisce lo sttao dei risultati sulle view
    
    public function __construct() {
        
         parent::__construct();
         
         $this->load->library('parser');
         
         
         if(!_is_logged()){
             header("location:".base_url());
         }else{
             //print_r();
             
             //$this->parser->('dashboard',$data);
         }

    }
    
    
    public function installcomponent(){
        //riassicuriamoci
        if(_is_logged() && $this->user->isAdmin() ){
            
            //installiamo le categorie base come copia sql
            $sql_categorie="INSERT INTO lm_categorie_prodotti"
                    . "('owner','azienda','name','valore','descrizione','gruppo') VALUES "
                    . "()";
            
        }
        
        exit;
    }
    
    
    public function payout(){
        
        print_r($_REQUEST);
        
        
        $pagamento=array(
            "durata"=>$_REQUEST["month_plan"],
            "codice_prodotto"=>$_REQUEST["product_code"]
        );
        
        $this->azienda->process_payment($pagamento);
        
        
        
        exit;
    }


    public function paymentconfirm($type=0){
            
        
        $data=array(
            "durata"=>$_REQUEST["durata"],
            "codiceprodotto"=>$_REQUEST["planref"],
            "utente"=>$this->user->id
        );

       if($type=='bank'){

            $datas["resp"]=$this->parser->parse('pagamenti/pagamentobancario',$data,true);

       }else if($type=="paypal"){


            $datas["resp"]=$this->parser->parse('pagamenti/paypalbutton',$data,true);

       }

       $this->output
              ->set_content_type('text/json')
              ->set_output(json_encode($datas));
        
    }


    public function dettaglio_pagamenti($codice=null){
          
          if($codice!=null){
              
            $modello=$this->azienda->getPayment($codice);

            $data=array(
                "codice"=>$codice,
                "modello"=>$modello,
                "modo"=>"ajax",
                
            );
            
          }else{
           
              die("Error");
              
          }
          
          $this->parser->parse('pagamenti/dettaglio_payment',$data);

    }
    
    
    
    public function upgrade($codice=null,$conferma=null){
          addJS(
             array(
                 "public/js/validate/jquery.validate.min.js",
                 "public/js/validate/additional-methods.min.js",
                 "public/js/validate/localization/messages_it.js",
                 
                 "public/js/attivazione_servizi.js"
             )
         );
         
         $data=array('PAGE_TITLE'=>t("attiva-il-tuo-account"),
             "codiceselezione"=>$codice);
         
        $this->parser->parse('profile/upgrade',$data);
        
    }
    
    
    
    
    public function service_status($codice=null,$conferma=null){
        
         addJS(
             array(
                 "public/js/validate/jquery.validate.min.js",
                 "public/js/validate/additional-methods.min.js",
                 "public/js/validate/localization/messages_it.js",
                 "public/js/attivazione_servizi.js"
             )
         );
         
         
         
         $data=array('PAGE_TITLE'=>t("attiva-il-tuo-account"),
             "codiceselezione"=>$codice);
         if(isset($conferma)){
             
             
            
             
         }else if(isset($codice)){
             
            $html=$this->load->view('pagamenti/conferma_dati',$data, TRUE);
             
            echo $html;
             
            exit;
             
             
         }else{
            $this->parser->parse('pagamenti/table',$data);
         }
         
        
    }
    
    
    /** MOSTRA IL PROFILO UTENTE**/
    //la chiamata fa redirect sul nuovo controller
    public function view($codice){
        
        redirect("/network/detail/".$codice);
        
        /*
        $data=array(
            'PAGE_TITLE'=>t("Profilo Utente ").$codice,
            "codice"=>$codice);
        
        $this->parser->parse('utente/profilo-dipendente',$data);
         
         */
        
    }
    
    
    
    public function index()
    {
        
         $provincie=array();
         $comuniprovincia=array();
         
         $query=$this->db->query("SELECT * FROM province",array());
         $provincie=$query->result_array();
         
         if( $this->user->profile["provincia"]>0 ){
             
              $query2=$this->db->query("SELECT * FROM comuni "
                      . " WHERE denominazione_provincia LIKE (SELECT nome_2 FROM province WHERE cod_ident=?)",
                      array($this->user->profile["provincia"]));
              $comuniprovincia=$query2->result_array();
                
         }
         
         $data=array(
               "PAGE_TITLE"=>t('profile_title_1'),
               "lista_provincie"=>$provincie,
               "lista_comuni"=>$comuniprovincia,
               "_RESULT_"=>($this->_RESULTS_!=null)?$this->_RESULTS_:null
         );
         addJS(
             array(
                 "public/js/validate/jquery.validate.min.js",
                 "public/js/validate/additional-methods.min.js",
                 "public/js/validate/localization/messages_it.js",
                 "public/bower_components/AdminLTE/dist/js/pages/dashboard2.js",
                 "public/js/profilo.js"
             )
         );
         $this->parser->parse('profilo',$data);
                
    }
    
     
    public function ordini()
    {
        if(!_is_logged()) redirect('/');
        
         $data=array(
             "PAGE_TITLE"=>t('profile_title_1'),
             "schema"=>"ordini",//sceglie lo schema sul profilo con getMy([schema])
             "sezione"=>"profilo-ordini"
         );
         
         addJS(array("public/bower_components/AdminLTE/dist/js/pages/dashboard2.js"));
         $this->parser->parse('i_miei_ordini',$data);
         
    }
    
    public function ordine($codice){
        
        if(!_is_logged()) redirect('/');
        
        
         $ordine=$this->user->getOrdine($codice);
         $ordine=$ordine[key($ordine)];
         
         $data=array(
             "PAGE_TITLE"=>t('profile_title_1'),
             "schema"=>"ordini",//sceglie lo schema sul profilo con getMy([schema])
             "modelloordine"=>$ordine
         );
         
         
         
         addJS(array("public/bower_components/AdminLTE/dist/js/pages/dashboard2.js"));
         $this->parser->parse('dettaglio_ordine',$data);
             
    }
    
    public function salva(){
        
         if(!_is_logged()) redirect('/');
         
         
         if($_REQUEST["saveprof"]==1){
             
             //print_r($this->user);
             
             
             $dataprofilo=array(
                 "nome"=>$_REQUEST["nome"],
                 "cognome"=>$_REQUEST["cognome"],
                 "telefono"=>$_REQUEST["telefono"],
                 "mobile"=>$_REQUEST["mobile"],
                 "comune"=>$_REQUEST["comune"],
                 "provincia"=>$_REQUEST["provincia"],
                 "indirizzo"=>$_REQUEST["indirizzo"],
                 "cap"=>$_REQUEST["cap"],
                 "stato_nazione"=>$_REQUEST["nazione"]
             );
             
             //print_r($_FILES);
                include_once(APPPATH.'core/uploadHandler.php');
                
             $urlfoto2="";
                
             if($_FILES && isset($_FILES["immagineprofilo"])){
                 
                
                
                //Start class
                $upload = new uploadHandler();
                //Set path
                $upload->setPath($this->user->check_image_path());
                
                //Prefix the file name
                $upload->setFilePrefix($this->user->iduser.'_prof_');
                //Allowed types
                $upload->setAllowed(array(
                    'dimensions'=>array('width'=>1200,'height'=>1200),
                    'types'=>array('image/png','image/jpg','image/gif','image/jpeg')));
                //form property name                   
                $upload->setInput('immagineprofilo');
                //Do upload
                $upload->upload();
                

                //notice
                if( $upload->output==uploadHandler::UPLOAD_SUCCESS ){
                    $urlfoto=$upload->getFileUrl();
                    $dataprofilo["foto"]=$urlfoto;
                }
                 
             }
             
             if($_FILES && isset($_FILES["immagine_intestazione"])){
                 
                
                
                //Start class
                $upload = new uploadHandler();
                
                //Set path
                $upload->setPath( $this->user->check_image_path() );
                
                //Prefix the file name
                $upload->setFilePrefix($this->user->iduser.'_'.time().'_');
                //Allowed types
                $upload->setAllowed(array(
                    'dimensions'=>array('width'=>1200,'height'=>1200),
                    'types'=>array('image/png','image/jpg','image/gif','image/jpeg')));
                //form property name                   
                $upload->setInput('immagine_intestazione');
                //Do upload
                $upload->upload();
                

                //notice
                if( $upload->output==uploadHandler::UPLOAD_SUCCESS ){
                    $urlfoto2=$upload->getFileUrl();
                    //$dataprofilo["foto"]=$urlfoto;
                }
                 
             }
             
             
             
             //chiamo l'aggiornamaneto al profilo
             $this->user->updateprofile($dataprofilo);
             
             _report_log(array("message"=>"Salvo Profilo Generico:".json_encode($dataprofilo)."  ","error"=>" "));
          
             
             //passiamo alla fatturazione
             $datafatturazione=array(
                 
                 "nome"    =>       $_REQUEST["nome_fatt"],
                 "cognome"  =>    $_REQUEST["cognome_fatt"],
                 "cod_cf"  =>     $_REQUEST["cod_fiscale"],  
                 "comune"   =>      $_REQUEST["comune"],
                 "indirizzo" =>  $_REQUEST["ind_fatt"],
                 "telefono"  =>      $_REQUEST["telefono_fatt"],
                 "emailf"   =>      $_REQUEST["email_fatt"]
                 
             );
             
             if(
                     $this->user->user_model==User_model::USER_PROFESSIONISTA
                     OR $this->user->isAdmin()
                     ){
                 
                 $datafatturazione["rag_sociale"]=$_REQUEST["rag_sociale"];
                 $datafatturazione["piva"]=$_REQUEST["p_iva"];
                 
             }
             
             $this->user->updateFatturazione($datafatturazione);
             
             _report_log(array("message"=>"Salvo Profilo Fatturazione:".json_encode($datafatturazione)." ","error"=>"  "));
         
             
             $this->_RESULTS_=true;
             
             // dati aziendali 
             
             $datiazienda=array(
                 "nome"=>"",
                 "intestazione"=>$_REQUEST["intestazione_a"],
                 "piva"=>$_REQUEST["piva_a"],
                 "comune"=>$_REQUEST["comune_a"],
                 "provincia"=>$_REQUEST["provincia_a"],
                 "indirizzo"=>$_REQUEST["indirizzo_a"],
                 "cap"=>$_REQUEST["cap_a"],
                 //"codice_subdomain"=>"",
                 "media_logo"=>"");
             
             //dati media intestazione...
             //$urlfoto2
             
             $testointestazione="testo";
             $templateintestazione["testo"]=$testointestazione;
             if($urlfoto2!=""){
                 $templateintestazione["logo"]=$urlfoto2;
             }
             
             if(count($templateintestazione)>0){
                $this->user->aggiorna_intestazione($templateintestazione);
             }
             
             $data["success"]="true";
             
         }
         
         
         //redirect("/".getLanguage()."/profile");
         
         header("Content-type: text/json");
         echo json_encode($data);
         
         exit;
    }
    
   


    public function profileimage(){
        
        if(!_is_logged()) redirect('/logout');
        
        //print_r($_FILES);
        include_once(APPPATH.'core/uploadHandler.php');
        
        //Start class
        $upload = new uploadHandler();
        //Set path
        $upload->setPath('/public/downloads/');
        //Prefix the file name
        $upload->setFilePrefix($this->user->iduser.'_prof_'.time());
        //Allowed types
        $upload->setAllowed(array(
            'dimensions'=>array('width'=>200,'height'=>200),
            'types'=>array('image/png','image/jpg','image/gif')));
        //form property name                   
        $upload->setInput('immagineprofilo');
        //Do upload
        $upload->upload();

        
        //notice
        if(isset($upload->output)){
            echo $upload->output;
        }
        
        
        exit;
    }
    
    
    public function me($type){
        
        if(!_is_logged()) redirect('/logout');
        
        $this->output->set_header('Content-Type: application/json; charset=utf-8');

        
        $data=array();
        switch($type){
            case "prodotti":
                
                $chiave=trim($_GET["q"]);
                
                $prodotti=$this->db->query(" SELECT * FROM lm_modelli_prodotti WHERE  "
                        . " ( ( lm_modelli_prodotti.nome LIKE '$chiave%'   "
                        . " OR  lm_modelli_prodotti.descrizione LIKE '$chiave%' ) "
                        . " )"
                        . " AND lm_modelli_prodotti.utente  ='".$this->user->iduser."' LIMIT 6");
                
                $prodot= $prodotti->result("Prodotto_model");
                $tmp=array();
                foreach($prodot as $i=>$prod){
                    //print_r($prod);
                    $costi=$prod->getCostiModello();
                    //print_r($costi);
                    
                    if($prod->carattere_prodotto=='servizio'){
                        $costi=$prod->prezzo_fisso;
                    }else if(count($costi)>0){
                        $costi=$costi[0];
                        $costi=$prod->prezzo_fisso;
                        
                    }else{
                        $costi=$prod->prezzo_fisso;
                    }
                    
                    
                    $tmp[$i]=array(
                        "codice_modello"=>$prod->codice_modello,
                        "carattere_prodotto"=>$prod->carattere_prodotto,
                        "nome"=>$prod->nome,
                        "raggruppamento"=>$prod->raggruppamento,
                        "codice_interno"=>$prod->codice_interno,
                        "costo"=>$costi,
                        "immagine"=>$prod->foto,
                        "descrizione"=>$prod->descrizione
                    );
                    
                    $html=$this->parser->parse("ajax/dettaglio_ricerca_servizio",$tmp[$i],true);
                    
                    $tmp[$i]["html"]=$html;
                    
                }
                
                $data["items"]=$tmp;
               
                
                break;
            
            case "status":
                
                  if($_REQUEST["hidehelp"]==true){
                      
                      setcookie("hidehelp","true", (time()+3600)*24*90 ) ;
                      
                  }else{

                    $data["hidehelp"]=$_COOKIE["hidehelp"];
                    $data["status"]=$this->user->statoProfilo();
                    //solo per admin
                    if($this->user->isAdmin()){

                          $statoservizio=($this->azienda->getStatusAccount());
                          
                          $datascadenza=$this->azienda->getScadenzaServizio();
                          $data["altro"]=$statoservizio;
                          
                          if($statoservizio == "scaduto"){
                              if($datascadenza==null){
                                  $datascadenza="Attiva subito!";
                              }

                              $data["scadenze"]=array(
                                  "stato"=>$statoservizio,
                                  "data"=>$datascadenza,
                                  "messaggio"=>"<p class='infoscadenza'>Rinnova il tuo servizio adesso, scade il ".$datascadenza." <a href='/profile/upgrade' class='btn btn-default btn-sm btn-flat'>".t("Rinnova")."</a></p>"
                              );

                          }else if($statoservizio=="attesa"){
                              $data["scadenze"]=array("stato"=>"attesa");
                          }else{
                              $data["scadenze"]=array("stato"=>"attivo");
                          }

                    }

                    $data["notifiche"]=$this->user->getNotification();
                    
                  }
                  
            break;
            
            case "clienti":
                
                    $chiave=strip_tags($_GET["q"]);
                    
                    if(strlen($chiave)>=3){
                        $qsearch=" AND ( rag_sociale_cliente LIKE ? OR  cognome_cliente LIKE ? ) ";

                        $query=$this->db->query("SELECT * FROM lm_profili_clienti WHERE utente=? $qsearch LIMIT 8 ",
                                array($this->user->iduser,
                                    "$chiave%",
                                    "$chiave%"));
                        $clienti=$query->result_array();

                        $data["status"]=1;

                        $data["total_count"]=count($clienti);
                        if($data["total_count"]>8){
                            $data["incomplete_results"]=true;
                        }else{
                            $data["incomplete_results"]=false;
                        }

                        foreach( $clienti as $i=>$cc){
                            $clienti[$i]["id"]=$cc["codcliente"];
                        }

                        $data["items"]=($clienti);
                    }else{
                        $data["items"]=array();
                    }
                    
                    if($_GET["mode"]==2){
                        
                        if(count($data["items"])){
                            foreach($data["items"] as $itm){
                                
                                $data["suggestions"][]=array("data"=>$itm,
                                    "value"=>($itm["rag_sociale_cliente"]!=null)?$itm["rag_sociale_cliente"]:$itm["cognome_cliente"]);
                                
                            }
                        }
                        
                    }
                    
            break;
        }
        
        
        $this->output
                  ->set_content_type('application/json')
                  ->set_output(json_encode($data));
        
    }
    
    public function messaggi($attr=null){
        
         if(!$this->user->isAdmin())  redirect("/dashboard");
         
        
    }
    
    
    /**
     * 
     * @param type $sezione
     */
    public function gestione($sezione=null,$codice=null)
    {
        
       if(!$this->user->isAdmin()) redirect("/dashboard");
         
       switch($sezione){
                case "categorie":
                    
                    
                  addJS(array("public/js/category.js"));
                  addBreadCrumbsItem("/dashboard","Dashboard");
                  addBreadCrumbsItem("/profilo","Profilo");
                  addBreadCrumbsItem("/profile/gestione/categorie","Categorie");
                  
                  $file="categorie";
                  $data=array(
                      "PAGE_TITLE"=>"Configura prdine",
                      "SECTION_TITLE"=>$this->lang->line('configuratore_key'),
                      "categoriabase"=>"gestione-categorie-prodotti",
                      "sezione"=>"gestione-categorie",
                      "MODAL"=>array(
                            "_MODALTITLE_"=>"Nuova Categoria",
                            "_MODALID_"=>"modalcategoria",
                            "_MODALCLASS_"=>"mymodal_categoria",
                            "_MODALCONTENT_"=>"",
                            "_MODALVIEW_"=>array(
                                "file"=>"forms/form_categoria",
                                "data"=>null
                            )
                       )
                      
                   );
                    
                break;
           
                default:
                    
                  $file="gestione";
                  $data=array(
                      "PAGE_TITLE"=>"Configura prdine",
                      "SECTION_TITLE"=>$this->lang->line('configuratore_key'),
                      "categoriabase"=>"admin-gestione",
                      "sezione"=>"gestione-categorie",
                      "codiceordine"=>$codice
                   );  
           
       }
       
       
        $this->parser->parse('utente/'.$file,$data);
        
        
    }    
    
    
    /**
     *  ADMIN CRUD OPERATIONS
     * @param type $args
     */
    public function action($sezione=null,$id=null){
        //comando -> salva
        
        if(!$this->user->isAdmin()) header("location: /dashboard");
        
        $command="";
        
        if($_POST["actionform"]=="salva"){
        
            switch($sezione){

                case "profilo":


                    $idedit=$id;


                    if($idedit==0){
                       $prodotto=$this->modello_prodotti;
                       $prodotto->inserisci_prodotto();

                    }else{

                       $query=$this->db->query("SELECT * FROM lm_prodotti WHERE idProdotto=?",array($idedit));
                       $prodotto=$query->row(0,"Prodotto_model");

                       $prodotto->aggiorna_prodotto();

                    }



                break;
                case "add-product":

                break;


            }
        
        }
        
        
        
        exit;
    }
    
    
    
    public function sendusermail(){
        
        $pp=$_REQUEST;
        $this->load->library('email');
         
        $data=array(
            "nome"=>$pp["nome"],
            "cognome"=>$pp["cognome"],
            "email"=>$pp["email"],
            "messaggio"=>$pp["messaggio"],
            "inviteurl"=>$this->azienda->getBusinessUrl().getLanguage()."/singup"
        );
        $htmlmail=$this->parser->parse('utente/nuovo-dipendente',$data,true);
        
        
        $this->email->from('no-reply@winnub.com', 'Winnub Team');
        $this->email->to($pp["email"],$pp["nome"]);
     
        $this->email->subject('Invito su winnub');
        $this->email->message($htmlmail);

        $this->email->send();

        
        $this->output
                  ->set_content_type('text/json')
                  ->set_output(json_encode($data));
         
    }
    
    
    
    public function adduser(){
        
            addJS(array("public/js/adduser.js"));
          
            addBreadCrumbsItem("/dashboard","Dashboard");
            addBreadCrumbsItem("/profile","Profilo");
            addBreadCrumbsItem("/profile/adduser","Nuvo collaboratore");
                  
           $data=array(
               'PAGE_TITLE'=>t("Nuovo Utente"),
                "codice"=>$codice,
               "sezione"=>"utenti",
               "categoriabase"=>"utenti-add"
               );
         $this->parser->parse('utente/nuovo-dipendente',$data);
        
    }
    
    
    
}