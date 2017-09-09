<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quote extends CI_Controller {

	
    
    
        public function __construct() {
           parent::__construct();
           
           $this->lang->load('quote_lang');//importante deve esserci il file per ogni lingua
           $this->load->library('parser');
        }
        
        
        public function vclear(){
            
            if(!_is_logged()) redirect('/');
            
            unset($_SESSION["carrello"]);
            
            
            
        }
        
        /**
         * Verifica l'esistenza di un preventivo in sessione
         */
        public function checkquote(){
            if(!_is_logged()) redirect('/');
            
            header("Content-type: text/json");
            
            $data["status"]=false;
            if(isset($_SESSION["carrello"]) && count($_SESSION["carrello"])>0 ){
                
                $data["status"]=true;
                
            }
            
            echo json_encode($data);
            
            
            exit;
        }
        
        
        public function duplica($codice=0){
            
            
            $preventivo=$this->user->getPreventivo($codice);
            
            if( !isset($_SESSION["carrello"]) && count($_SESSION["carrello"])==0){
                if(count($preventivo) && $preventivo!=null){

                    $preventivo=$preventivo[0];
                    //print_r($preventivo->getCarrello());
                    $cont=0;
                    foreach( $preventivo->getCarrello() as $oggetto){
                        $codicecart="wctA0$cont".time();


                        $_SESSION["carrello"][$codicecart]=$oggetto;
                        $this->carrello->insert($oggetto);
                        $cont++;
                    }
                    
                    _report_log(array("message"=>"Duplica Preventivo :".json_encode($preventivo)."| ","error"=>""));
                    
                    
                    save_stream_log(
                            array("azione"=>"duplicate_quote",
                                "descrizione"=>"duplica preventivo $codice ",
                                "style"=>""
                                    )
                            );
          

                    redirect("/quote/view");

                }else{

                    echo "Pagina errore generico";
                    _report_log(array("message"=>" Duplica Preventivo  ","error"=>"Errore"));
          

                }
            
            }else{
                echo "Il tuo carrello risulta in corso, vuoi sovrascrivere i dati del carrello attuale?";
            }
            
            exit;
        }
        
        
        
        public function pdfv2($codice=null,$modo=null){
            
            $this->load->library("PDF_Invoice");//carichiamo pdfinvoice
            
             $intestazione_cliente="";
            $preventivo=$this->user->getPreventivo($codice);
            
            
            if(count($preventivo) && $preventivo!=null){
                
                
                $preventivo=$preventivo[key($preventivo)];  
                $cliente=$preventivo->getCliente();
                if(count($cliente)!=null){
                    
                     $cliente=$cliente[0];

                     // create some HTML content
                     $riga1=array();
                     $riga2=array();
                     if(trim($cliente->indirizzo)!=""){
                         $riga1[]=$cliente->indirizzo;
                     }
                     if(trim($cliente->cap)!=""){
                         $riga1[]=$cliente->cap;
                     }
                     if(trim($cliente->comune)!=""){
                         $riga1[]=$cliente->comune;
                     }
                     if(trim($cliente->provincia)!=""){
                         $riga1[]=$cliente->provincia;
                     }

                     if(trim($cliente->PIVA )!=""){
                         $riga2[]="<b>".t("iva")."</b>".$cliente->PIVA;
                     }

                     if(trim($cliente->cod_fiscale)!=""){
                         $riga2[]="<b>".t("cod-fiscale")."</b>".$cliente->cod_fiscale;
                     }

                      $intestazione_cliente = ""
              .       "<h2>".((trim($cliente->rag_sociale_cliente)?$cliente->rag_sociale_cliente:""))."</h2>
                      <p>
                        ".implode(",",$riga1)."
                      </p>
                      <p>
                         ".implode(",",$riga2)."
                      </p>"
              . "";



                }else{
                    
                    $intestazione_cliente="<p>".$preventivo->titolo."</p>";

                }
               
                $htmlintestazione=$this->parser->parse("quote/pdf_intestazione",
                         array("preventivo"=>$preventivo,
                             "intestazionecliente"=>$intestazione_cliente),
                         true);
                 
            
            }
            
            
            try{

                    // create new PDF document
                    $pdf = new PDF_Invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true,'UTF-8',false,true);
                    // set document information
                    $pdf->SetCreator("winnub.com");
                    $pdf->SetAuthor('winnub');
                    $pdf->SetTitle('winnub quote '.$preventivo->codice_utente);
                    $pdf->SetSubject('http://app.winnnub.com');

                    //$urldocumento="http://app.winnub.com/".getLanguage()."/quote/create-pdf/$codice";
                    // set default header data
                    $urldocumento=" Winnub software ";
                    $pdf->SetHeaderData(
                            "", 
                            1, 
                            "", 
                            "$urldocumento");


                    $pdf->setFooterData("$urldocumento");


                    // set header and footer fonts
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

                    // set default monospaced font
                    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                    // set margins
                    $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);

                    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

                    // set auto page breaks
                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                    // set image scale factor
                    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


                    // ---------------------------------------------------------
                    //$pdf->setFontSubsetting(true);

                    // add a page
                    $pdf->AddPage();

                    // set font
                    $pdf->SetFont('helvetica',null,11,'',true);

                   
                    // output the HTML content
                    
                    $pdf->writeHTML($htmlintestazione,true,false,false,false);

                    $pdf->Ln();
                    
                    
                    //$pdf->addPage();
                    
                    $totale=0;
                    $i=0;
                    foreach($preventivo->getItems() as $item){
                        $itemprod=$this->modello_prodotti->getArticoloCarrello($item->prodotto);
                        $costoitem=floatval($item->costo*intval($item->quantita));

                        $showservizio="";

                        $vat=($item->codice_iva);
                        //print_r($item);
                        if($itemprod->carattere_prodotto!="servizio"){
                            //vanno calcolate sul prodotto scontato

                            $totale+=$costoitem;

                            //devo calcolarle le tasse aplicate sul prodotto socntato sul prodotto scontato
                            //
                            $valsconto=$costoitem;
                            if($preventivo->codice_sconto>0){
                                $valsconto=floatval($costoitem-(($costoitem*$preventivo->codice_sconto)/100));
                            }
                            $totale_aliquote[$vat]=(($valsconto*$vat)/100)+floatval($totale_aliquote[$vat]);


                        }else{
                            $showservizio=t("servizio");
                            $costi_servizi[]=array("nome"=>$item->descrizione,"valore"=>$costoitem);
                            $totale_aliquote[$vat]=(($costoitem*$vat)/100)+floatval($totale_aliquote[$vat]);

                        }
                        $img=$itemprod->foto;

                        $riga=array(
                            "<img src=\"$img\" />",
                            "<div class='blockdesc descrizione'><b>".strip_tags($item->descrizione)."</b><br/>".str_replace("<br>","",($item->descrizione_2))."</div>",
                            "€ ".number_format($item->costo,2,","," "),
                            $item->quantita,
                            "€ ".number_format($costoitem,2,","," "),
                            "".$vat."%"
                        );
                        $mis=array(65,290,90,45,90,45);
                        if( ($i%2) == 0 ){
                            $pdf->tableRow($riga,null,$mis);
                        }else{
                            
                            $pdf->tableRow($riga,array(180,180,180),$mis);
                        }
                        
                    
                        
                        $i++;
                    }
                    
                   
                    $pdf->controllaMargine();
                   
                    
                    $htmriepilogo=$this->parser->parse("quote/pdf_riepilogo",
                    array(
                        "totale_aliquote"=>$totale_aliquote,
                        "costi_servizi"=>$costi_servizi,
                        "totale"=>$totale,
                        "preventivo"=>$preventivo
                    ),
                    true);
                    
                    $pdf->writeHTML($htmriepilogo,true,false,false,false);



                    // reset pointer to the last page
                    $pdf->lastPage();
                    
                    
                    // ---------------------------------------------------------

                    //Close and output PDF document
                    $pdf->Output("quote_$codice.pdf", 'I');

                    //============================================================+
                    // END OF FILE
                    //============================================================+
            }catch(Exception $e){
                
               $this->parser->parse("errors/html/error_exception",array("error"=>$e));
            }
            
            
           
            $this->parser->parse("errors/html/error_general",array(
                "heading"=>t("Documento non trovato"),
                "message"=>"<p>".t("Preventivo non trovato o non hai i premessi sufficienti per leggere questo documento")."</p>"
                ));
            


            
            
        }
        public function create_pdf($codice=0){
            $this->pdfv2($codice);
        }
        
        /*
        public function create_pdf($codice=0){
            
             $this->load->library("PDF_Invoice");//carichiamo pdfinvoice
             
            $intestazione_cliente="";
            $preventivo=$this->user->getPreventivo($codice);
            
            
            if(count($preventivo) && $preventivo!=null){
               $preventivo=$preventivo[key($preventivo)];  
               $cliente=$preventivo->getCliente();
               $cliente=$cliente[0];
               
               // create some HTML content
               $riga1=array();
               $riga2=array();
               if(trim($cliente->indirizzo)!=""){
                   $riga1[]=$cliente->indirizzo;
               }
               if(trim($cliente->cap)!=""){
                   $riga1[]=$cliente->cap;
               }
               if(trim($cliente->comune)!=""){
                   $riga1[]=$cliente->comune;
               }
               if(trim($cliente->provincia)!=""){
                   $riga1[]=$cliente->provincia;
               }
               
               if(trim($cliente->PIVA )!=""){
                   $riga2[]="<b>".t("iva")."</b>".$cliente->PIVA;
               }
               
               if(trim($cliente->cod_fiscale)!=""){
                   $riga2[]="<b>".t("cod-fiscale")."</b>".$cliente->cod_fiscale;
               }
               
$intestazione_cliente = ""
        .       "<h2>".((trim($cliente->rag_sociale_cliente)?$cliente->rag_sociale_cliente:""))."</h2>
                <p>
                  ".implode(",",$riga1)."
                </p>
                <p>
                   ".implode(",",$riga2)."
                </p>"
        . "";


            $html=$this->parser->parse("quote/quote_pdf",
                    array("preventivo"=>$preventivo,"intestazionecliente"=>$intestazione_cliente),
                    true);
            
           
            
            try{

                    // create new PDF document
                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false,true);
                    // set document information
                    $pdf->SetCreator("winnub.com");
                    $pdf->SetAuthor('Winnub');
                    $pdf->SetTitle('Winnub Quote '.$preventivo->codice_utente);
                    $pdf->SetSubject('http://app.winnnub.com');

                    $urldocumento="http://app.winnub.com/".getLanguage()."/quote/create-pdf/$codice";
                    // set default header data
                    $pdf->SetHeaderData(
                            "", 
                            0, 
                            "", 
                            "$urldocumento");


                    $pdf->setFooterData("$urldocumento");


                    // set header and footer fonts
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

                    // set default monospaced font
                    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                    // set margins
                    $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);

                    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

                    // set auto page breaks
                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                    // set image scale factor
                    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


                    // ---------------------------------------------------------
                    $pdf->setFontSubsetting(true);

                    // add a page
                    $pdf->AddPage();

                    // set font
                    $pdf->SetFont('helvetica','', 10,'',true);

                   


                    // output the HTML content
                    

                    $pdf->writeHTML($html,true,false,false,false);



                    // reset pointer to the last page
                    $pdf->lastPage();
                   


                    // ---------------------------------------------------------

                    //Close and output PDF document
                    $pdf->Output("quote_$codice.pdf", 'I');

                    //============================================================+
                    // END OF FILE
                    //============================================================+
            }catch(Exception $e){
                
               $this->parser->parse("errors/html/error_exception",array("error"=>$e));
            }
            
            
            }else{
                $this->parser->parse("errors/html/error_general",array(
                    "heading"=>t("Documento non trovato"),
                    "message"=>t("<p>Preventivo non trovato o non hai i premessi sufficienti per leggere questo documento</p>")
                    ));
            }

            
        }**/
      
        
      
        /**
        * 
        * Pagina index principale
        * 
        */
	public function index($a=null)
	{
            $data=array(
                "PAGE_TITLE"=>t("titolo-welcome-index")
            );

            if( isset($_SESSION["LOGGEDIN"]["status"]) && 
                    $_SESSION["LOGGEDIN"]["status"]=1 && 
                    isset($_SESSION["LOGGEDIN"]) ){

                $this->create($a);

            }else{

                redirect("/");
            }

	}
        
        
      
        
      
        
        public function create($categoria=null,$codice=NULL,$carrelloid=NULL){
          
            if(!_is_logged()) redirect('/');
            //if(!$this->user->isAdmin()) redirect ("/");
          
            $previd=null;

            addCSS(array(
                "//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css",
                "public/bower_components/AdminLTE/plugins/iCheck/all.css",
            ));
            addJS(
                    array(
                        "public/bower_components/AdminLTE/plugins/iCheck/icheck.min.js",
                        "public/js/jquery.sortable.js",
                    ));

            if(isset($_GET["cartitem"])){
               $carrelloid=$_GET["cartitem"];
            }

            if( isset($_GET["quoteitem"])){
                $previd=$_GET["quoteitem"];
               
            } else if(isset($_REQUEST["quoteitem"])){
                $previd=$_REQUEST["quoteitem"];
            }
            
            
            $data=array(
               "PAGE_TITLE"=>t("Crea preventivo"),
               "SECTION_TITLE"=>t('configuratore_key'),
               "sezione"=>"quote",
               "pagina_active"=>"quote-new",
               "categoriabase"=>$categoria,
               "codicecategoria"=>$codice,
               "codicecarrello"=>$carrelloid,
               "codicepreventivo"=>$previd,
               "MODAL"=>null/*array(
                    "_MODALTITLE_"=>t('popup-prodotto-titolo'),
                    "_MODALID_"=>"modalcategoria",
                    "_MODALCLASS_"=>"mymodal_categoria",
                    "_MODALCONTENT_"=>"",
                    "_MODALVIEW_"=>array(
                        "file"=>"forms/form_categoria",
                        "data"=>null
                    )
               )*/

            );
            $data["modoajax"]=false;

            if( (isset($carrelloid) && $carrelloid!=NULL) || ($previd>0) ){

               if(isset($_SESSION["carrello"][$carrelloid])){

                  $data["datacarrello"]=$_SESSION["carrello"][$carrelloid];
                  addJS(array("public/js/configuratore-loader.js"));
                  
               }else if( isset($previd) && isset($carrelloid)){
                   
                  $itemquote=$this->modello_preventivo->getPreventivoItem($carrelloid);
                  //print_r($itemquote);
                  $data["datapreventivo"]=$itemquote;
                  $data["datacarrello"]=$itemquote;
                  $data["modo"]="preventivo";

                  addJS(array("public/js/configuratore-loader.js"));
               }
            
            }
         
            if( !isset($_GET["ajaxmode"]) ){
               
               
               
               $nomefile="seleziona_categoria";

               if( isset($categoria) && $codice>0){

                  $prodotto=$this->modello_prodotti->verificaCategoria($codice);
                  
                  if( $prodotto!== null ){
                       $nomefile="configuratore";
                  }else{
                      $configuratore="errors/errore_categoria";
                  }

               }else{
                  
                    addJS(array("public/js/category.js"));
                    
               }
            
              $this->parser->parse($nomefile,$data);
            
            
            
          }else{
            /**
                * Mi permette di modificare i link in modo 
                * da caricarmi la vist in ajax...
                * richiamerà template separati.
                */
             $data["modoajax"]=true;//imposto la mosalità link in ajax...
             if(isset($_REQUEST["categoria"])){
                 
               if($this->modello_prodotti->verificaCategoria($_REQUEST["categoria"])){

                   $this->parser->parse('seleziona_prodotto_ajax',$data);
               }
               
             }else{
                 $this->parser->parse('seleziona_categoria_ajax',$data);
             }
         }
      }
        
      
      
      
      /**
       * Dettaglio preventivo generato 
       * 
       * Visibile sul carrello del prodotto finale generato
       * importante è caricare le librerie javascript per typehead, ProductComposer, Application
       * -in casso di modifica questo genera i dati di autoselezione.
       * 
       * @param type $codice
       */
      public function detail($codice=null){
          
         if(!_is_logged()) redirect('/');
         
         //print_r($codice);
         //if($codice <= 0 || is_null($codice)) redirect("/access-error");//errore nei permessi
          
         addCSS(array(
             "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css",
             "//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css"
         ));
         addJS(array(
             "public/js/typeahead-js/dist/typeahead.jquery.min.js",
             "public/js/typeahead-js/dist/typeahead.bundle.min.js",
             "public/js/typeahead-js/dist/bloodhound.min.js",
             "public/js/handlebars.js",
             "public/js/carrello.js",    
             "//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"
         ));
         
         //print_r(mdecrypt_generic(MHASH_MD5,$codice));
          
         $preventivo=$this->user->getPreventivo($codice);
         if(count($preventivo) && $preventivo!=null){
            $preventivo=$preventivo[key($preventivo)];   
         }
         
         if($preventivo){
             
            $data=array(
                "PAGE_TITLE"=>"Preventivo",
                "modo"=>"preventivo",
                "carrello"=>$preventivo->getCarrello(),
                "codicepreventivo"=>$codice,
                "modellopreventivo"=>$preventivo,
                "pagina_active"=>"dettaglio-preventivo",
                "sezione"=>"quote"
            );
            
         }else{
             
            $ilcarrello=null;
            if(isset($_SESSION["carrello"])){
               $ilcarrello=$_SESSION["carrello"];
            }



            $data=array(
                "PAGE_TITLE"=>"Carrello",
                "modo"=>"carrello",
                "carrello"=>$ilcarrello,
                "sezione"=>"quote",
                "codicepreventivo"=>$codice,
                "modellopreventivo"=>0,
                "pagina_active"=>"dettaglio-carrello"
            );
         }
         
         $this->parser->parse('carrello',$data);
          
      }
      
      
      


      public function all(){
          if(!_is_logged()) redirect('/');
          
          
         $data=array(
             "PAGE_TITLE"=>t('titolo_pagina_preventivi_key'),
             "NOME_SEZIONE_DESCRIZIONE"=>t('descrizione_pagina_preventivi_key'),
             "sezione"=>"quote",
             "pagina_active"=>"quote-list"
             
         );
         
         //addJS(array("public/bower_components/AdminLTE/dist/js/pages/dashboard2.js"));
         //$this->parser->('dashboard',$data);
         addJS(array("public/js/quote-table.js"));
         
         $this->parser->parse('tablelist',$data);
         
      }
      
      
       public function getAjxCart(){
          
            $ilcarrello=null;
            if(isset($_SESSION["carrello"])){
               $ilcarrello=$_SESSION["carrello"];
            }

            $data=array(
                "PAGE_TITLE"=>"Carrello",
                "modo"=>"carrello",
                "carrello"=>$ilcarrello,
                "sezione"=>"dashboard-lista",
                "mode"=>"ajax",
                "lingua"=>getLanguage(),
                "qcode"=>$_GET["qcode"]
            );

            $html = $this->parser->parse('modal_configuratore_postadd', $data, TRUE);

             echo json_encode(array("responce"=>$html));
         
         exit;
          
      }
      
      
      
     /**
       * Pagina dalla selezione dei preventivi, mostra la lista dei preventivi
       * @param type $codice
       */
      public function view($codice=null){
          
         if(!_is_logged()) redirect('/');
          
          
         addCSS(array(
             "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css"
         ));
         
         addJS(
                 array(
                     "public/js/carrello.js",
                     "public/js/nquote.js"));
         
        
          
         $preventivo=$this->user->getPreventivo($codice);
         if(count($preventivo)){
            $preventivo=$preventivo[key($preventivo)];   
         }else{
             
         }
         
         
         if($preventivo){
            $data=array(
                "PAGE_TITLE"=>"Preventivo",
                "modo"=>"preventivo",
                "sezione"=>"quote",
                "carrello"=>$preventivo->getCarrello(),
                "codicepreventivo"=>$codice,
                "modellopreventivo"=>$preventivo,
                "pagina_active"=>"view-quote"
            );
         }else{
            $ilcarrello=null;
            if(isset($_SESSION["carrello"])){
               $ilcarrello=$_SESSION["carrello"];
            }
            $data=array(
                "PAGE_TITLE"=>"Carrello",
                "modo"=>"carrello",
                "carrello"=>$ilcarrello,
                "sezione"=>"quote",
                "codicepreventivo"=>null,
                "modellopreventivo"=>null,
                 "pagina_active"=>"view-quote"
            );
         }
         
         
         $this->parser->parse('carrello',$data);
          
          
    }
      
      
    public function send($codice=0){
          
           if(!_is_logged()) redirect('/');
          
          
            addCSS(array(
                "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css"
            ));
            addJS(array("public/js/sendquote.js"));

            

            $preventivo=$this->user->getPreventivo($codice);
            if(count($preventivo)){
               $preventivo=$preventivo[key($preventivo)];  
            }
            
            if($codice!=""){
                
                $data=array(
                    "PAGE_TITLE"=>t("Invia-preventivo"),
                    "modo"=>"invia-preventivo",
                    "carrello"=>$preventivo->getCarrello(),
                    "codicepreventivo"=>$codice,
                    "modellopreventivo"=>$preventivo,
                    "sezione"=>"quote",
                    "pagina_active"=>"invia-preventivo",
                    
                );
                
                $this->parser->parse('quote/invia_preventivo',$data);
            
            }else{
                
               $ilcarrello=null;
               if(isset($_SESSION["carrello"])){
                  $ilcarrello=$_SESSION["carrello"];
               }

               $data=array(
                   "PAGE_TITLE"=>"Carrello",
                   "modo"=>"carrello",
                   "carrello"=>$ilcarrello,
                   "sezione"=>"dashboard-lista"
               );
            }

            
      }
      
      
      public function sendemail($codice){
          
          if(!_is_logged()) redirect('/');
          
            //print_r($_REQUEST);
            $modello_p=array(
                "style"=>""
            );
            
            $preventivo=$this->user->getPreventivo($codice);
            if(count($preventivo)){
               $preventivo=$preventivo[key($preventivo)];   
               
               $data["preventivo"]=$preventivo;
               
              
            }
            
            $v = "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";
            
            $dataresult["status"]=false;
            
            $destinatario       =   strip_tags($_REQUEST["destinatario"]);
            $oggetto_messaggio  =   strip_tags($_REQUEST["oggetto"]);
            
            $verificamail=(bool)preg_match($v,$destinatario);
            
            if( isset($destinatario) && $verificamail ){
            
                $record_email   =   array(
                    "tipo_documento"=>"preventivo",//mooolto importante
                    "utente"=>$this->user->iduser,
                    "email_destinatario"=>$destinatario,
                    "preventivo"=>$preventivo->idpreventivo,
                    "oggetto"=>$oggetto_messaggio,
                    "messaggio"=>$_REQUEST["messaggio"],
                    "data_invio"=>date("Y-m-d H:i:s"),
                    "lettura"=>0,
                    "style_conf"=>json_encode($modello_p)
                );

                if($this->db->insert("lm_send_document",$record_email)){
                    $codiceinvio=$this->db->insert_id();

                    $data["nomeazienda"]  = $this->user->getDenominazioneAzienda();
                    $data["messaggio"]    = strip_tags($_REQUEST["messaggio"]);
                    $data["urlallegato"]  = "http://app.winnub.com/qdetail/".MD5(crypt($codiceinvio,PUBLIC_SALT));
                    $data["userimage"]    = "http://app.winnub.com/".$this->user->getPhoto();

                    //load email library

                    $this->load->library('email');

                    // prepare email
                    $this->email
                        ->from('no-reply@winnub.com',$this->user->getDenominazioneAzienda())
                        ->to($destinatario)
                        ->subject($oggetto_messaggio)
                        ->message($this->load->view('quote/email_template',$data,true))
                        ->set_mailtype('html');

                    // send email

                    $this->email->send();
                    
                    
                    save_stream_log(
                            array("azione"=>"send_quote",
                                "descrizione"=>"invio quote a $destinatario ",
                                "style"=>""
                            )
                        );
                        
                    
                    $dataresult["status"]=true;
                    $dataresult["message"]="Messaggio spedito";
                    
                     _report_log(
                             array(
                                 "message"=>"Inviata Email ".json_encode($data)."| ",
                                 "error"=>""));
                    

                }else{
                    //ERRORE INSERIMENTO...
                    _report_log(array("message"=>"Send Email ","error"=>"Errore"));

                }
            }else{
                _report_log(array("message"=>"Email non corretta ","error"=>"Errore"));
                $dataresult["status"]=false;
                $dataresult["message"]="Email non valida o mancante";
            }
            
            
            header("Content-type: text/json");
            echo json_encode($dataresult);
            
            
            exit;
      }
      
      
      public function ajx_quote($a=null){
         if(!_is_logged()) redirect('/');
          
         header("Content-type:text/json");
         $carrello=(isset($_SESSION["carrello"]))?$_SESSION["carrello"]: array();
         
         $data=array(
             "PAGE_TITLE"=>"Il tuo Carrello",
             "carrello"=>$carrello,
             "modo"=>"ajax"
         );
         
         $p=$this->load->view('limap/_ajax_cart_box',$data,true);
         
         $data["html"]=$p;
         
         
         echo json_encode($data);
         
         exit;
      }
      
      
      
      
      
      public function savequote($codice=null){
          if(!_is_logged()) redirect('/');
          
            save_stream_log(
                            array("azione"=>"save_quote",
                                "descrizione"=>"salvataggio quote codice: $codice ",
                                "style"=>""
                            )
                        );
          
            if($codice==null){
                
                
                $stato=$this->user->savePreventivo($_SESSION["carrello"]);
                
                if($stato>0){
                    $_SESSION["carrello"]=null;
                    unset($_SESSION["carrello"]);
                    //redirect("dashboard/lista/preventivi");
                }
                
                $this->output->set_header('Content-Type: text/json; charset=utf-8');
                $data["redirect"]=  "/".getLanguage().'quote/detail/'.$stato;
                
                echo json_encode($data);
            
            
                _report_log(array("message"=>"Aggiornamento Preventivo Carrello:".json_encode($data)."| ","error"=>""));
                
                 
                
            }else{
              
             
                $preventivo=$this->user->getMy("preventivi",$codice);

                $cliente=null;
 
                $codicecliente=intval($this->input->post('codicecliente'));
                
                $pivacliente=$this->input->post('pivacliente');

                if( $codicecliente>0 ){

                   
                    $querycliente=$this->db->query('SELECT * FROM lm_profili_clienti WHERE utente IN (SELECT iduser FROM lm_users WHERE lm_users.owner=?) AND '
                            . ' codcliente = ?',array($this->user->owner,$codicecliente));
                    $cliente=$querycliente->custom_row_object(0,'Cliente_model');
                    
                }else{

                    $codicecliente=0;
                    $cliente=new Cliente_model();

                }
              
                $cliente->PIVA=$pivacliente;
                
                $cliente->utente=$this->user->iduser;
                
                $cliente->rag_sociale_cliente=$this->input->post('ragsocialecliente');
                $cliente->comune=$this->input->post('capcomunecliente');
                $cliente->provincia=$this->input->post('provinciacliente');
                $cliente->indirizzo=$this->input->post('indirizzocliente');
                $cliente->note=$this->input->post('notecliente');
                $cliente->email=$this->input->post('emailcliente');
                $cliente->cod_fiscale=$this->input->post('cfcliente');
                
                
                //
                $modifiche=array(
                  "titolo"=>$this->input->post("titolo"),
                  "note"=>$this->input->post("noteordine"),
                  "iva"=>$this->input->post("imposte"),
                  "template_intestazione"=>$this->input->post("mce_0"),
                  "codice_sconto"=>$this->input->post("scontistica"),
                  "codice_utente"=>$this->input->post("codice_vp"),
                  "data"=>$this->input->post("data_preventivo"),
                  "prezzo_finale"=>$this->input->post("totale_finale")
                );
                
                
                
                if( $codicecliente > 0 ){

                    
                      $modifiche["cliente"]=$codicecliente;  
                      $cliente->update($codicecliente);


                }else{
                    
                    $codicecliente=$cliente->insert();
                    $modifiche["cliente"]=$codicecliente;
                    
                }
              
                $preventivo->update($modifiche);
                $itemelements=$_REQUEST["itemlist"];
                
                if(count($itemelements)>0){
                
                    foreach($itemelements as $item){
                        //aggiorno valore item, se occorre
                        $varianti="";
                        

                        //print_r($it);
                        $descr1=($this->input->post('editor1_'.$item));
                        $descr2=($this->input->post('editor2_'.$item));

                        $ds=array(
                            "descrizione"=>$descr1,
                            "descrizione_2"=>$descr2,
                            "quantita"=>    $_REQUEST["qty"][$item],
                            "codice_iva"=>  $_REQUEST["selectiva"][$item],
                            "costo"=>       $_REQUEST["costounitario"][$item]
                        );
                        $preventivo->aggiornaItem($item,$ds);

                        _report_log(array("message"=>"Aggiornamento Item Quote - Modifiche:".json_encode($ds)."| ","error"=>""));
                        
                    }
                }
                
                _report_log(array("message"=>"Aggiornamento Quote - Modifiche:".json_encode($modifiche)."| ","error"=>""));
          
            }
            
            
            exit;
      }
      
      
      
      
      
      public function result($products=null){
         
            if(!_is_logged()) redirect('/');

            addCSS(array(
                "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css"
            ));
            addJS(array(
                "public/js/carrello.js"));


            $ilcarrello=null;
            if(isset($_SESSION["carrello"])){
               $ilcarrello=$_SESSION["carrello"];
            }

            $data=array(
                "PAGE_TITLE"=>"Carrello",
                "modo"=>"carrello",
                "carrello"=>$ilcarrello,
                "sezione"=>"quote",
                "pagina_active"=>"result-preventivo"
            );         
            $this->parser->parse('carrello',$data);

      }
      
      
      
      
     /**
      * Mostrato sulla pagina di conferma ordine.
      * @param type $code
      */
     public function confirm($code=null){
         
            if(!_is_logged()) redirect('/');
         
            //addCSS(array("public/bower_components/AdminLTE/plugins/iCheck/flat/green.css" ));
            //addJS(array("public/js/confermaordine.js"));
            //prelevo i costi di spedizione utente
            
            $spedizione=$this->user->get_costi_Spedizione();//valore spedizione
            $totale=0;
         
            if($code>0){

                   $ordine=$this->user->getPreventivo($code);
                   $ordine=$ordine[0];
                   $costosped=$ordine->totaleArticoli()*($spedizione["costo_fisso"]); 

                   $totale=($ordine->getTotale());
                   $totale+=($totale * $ordine->iva)/100;
                   $totale+=$costosped;

                   if($ordine->stato==Ordine_model::STATO_BOZZA){

                       $ordine->generaOrdine($totale);//genero l'ordine solo se il preventivo è in bozza
                       //se il preventivo è in stato di attesa pagamento significa che l'accesso alla pagina è già avvenuto nella transazione
                       //disattiviamo anche il pulsante di pagamento dal preventivo
                   }else{

                   }
            }
         
            $data=array(
                "PAGE_TITLE"=>"Carrello",
                "modo"=>"ordine",
                "modelloordine"=>$ordine,
                "costosped"=>$costosped,
                "spedizione"=>$spedizione,
                "totale"=>$totale
            );
         
         
            $this->parser->parse('conferma_ordine',$data);
         
         
      }
      
      
      public function toinvoce($code){
          
            if(!_is_logged()) redirect('/');
            
            if(!isset($code)) exit;
         
            //addCSS(array("public/bower_components/AdminLTE/plugins/iCheck/flat/green.css" ));
            //addJS(array("public/js/confermaordine.js"));
            $ordine=null;

            //prelevo i costi di spedizione utente
            //$spedizione=$this->user->get_costi_Spedizione();//valore spedizione
            $totale=0;
         
            if($this->user->isAdmin()){

                    $ordine=$this->user->getPreventivo($code,'Invoice_model');//genero itam invoice ereditato da preventivo
                    if(count($ordine)>0){//verifico se trovato il valore

                        $fattura=$ordine[0];
                        //$costosped=$fattura->totaleArticoli(); //mantiene le classi

                        $totale=($fattura->getTotale());
                        //$totale+=($totale * $fattura->iva)/100;

                        //$totale+=$costosped;

                        if( $fattura->stato==Ordine_model::STATO_BOZZA OR $fattura->stato==Ordine_model::STATO_ATTESA){
                            
                            //$ordine->generaOrdine($totale);//genero l'ordine solo se il preventivo è in bozza
                            //se il preventivo è in stato di attesa pagamento significa che l'accesso alla pagina è già avvenuto nella transazione
                            //disattiviamo anche il pulsante di pagamento dal preventivo
                            $fattura->generaFattura(
                                    $_REQUEST["codice_fatt"],
                                    $_REQUEST["anno_fatt"],
                                    $totale);
                            
                             save_stream_log(
                            array("azione"=>"create_invoice",
                                "descrizione"=>"genero fattura da preventivo $code ",
                                "style"=>""
                                    )
                            );
                             
                            //
                            //clona item ordine in fatturazione...
                            //

                        }else if( $fattura->stato==Ordine_model::STATO_CONFERMATO){

                            $fattura->invoiceDetail();
                            //--> 


                            if( isset($_REQUEST["codice_fatt"]) ){
                                $fatts["codfatt"]=$_REQUEST["codice_fatt"];
                            }

                            if( isset($_REQUEST["anno_fatt"]) ){
                                $fatts["anno"]=$_REQUEST["anno_fatt"];
                            }

                            if( isset($_REQUEST["totale"]) ){
                                $fatts["totale"]=$_REQUEST["totale"];
                            }

                            if( isset($_REQUEST["template"]) ){
                                $fatts["template"]=$_REQUEST["template"];
                            }

                            $fattura->update($fatts);

                            

                            _report_log(array("message"=>"TO INVOICE :".json_encode($fatts)."| ","error"=>""));


                        }


                        $data=$fattura;
                    }
            
            }else{
                
                 $ordine=$this->user->getPreventivo($code);//genero itam invoice ereditato da preventivo
                if(count($ordine)>0){//verifico se trovato il valore

                    $preventivo=$ordine[0];
                    
                    $data=array("stato"=>Preventivo_Model::STATO_ATTESA);
                    
                    $preventivo->update($data);
                    
                    save_stream_log(
                            array("azione"=>"confirm_quote",
                                "descrizione"=>"confermo preventivo $code ",
                                "style"=>""
                            )
                    );

                }
                    
                
            }
            
            $this->output
                    ->set_content_type('text/json')
                    ->set_output(json_encode($data));
            
            
      }
      


        public function delete($codice){
          
            if($codice!="" && $codice!=" "){
                $preventivo=$this->user->getPreventivo($codice);
                if(count($preventivo)>0){
                  $preventivo=$preventivo[0];
                  //print_r($preventivo);
                  if( $preventivo->stato == Preventivo_model::STATO_BOZZA ){

                      $preventivo->elimina();

                     _report_log(array("message"=>"Elimina Preventivo : ".json_encode($preventivo)."| ","error"=>""));
                     
                  }
                }

            }

            redirect("/quote/all");         
        }
      
      
      public function remove($cosa=null,$codice=null){

            if($cosa=="item"){
                
                $tables = array('lm_preventivo_item');
                
                $this->db->select('preventivo_id');
                $this->db->where('idselezione',$codice); // Produces: WHERE name = 'Joe'
                $codicered=$this->db->get("lm_preventivo_item");
                
                $this->db->where('idselezione',$codice);
                $this->db->delete($tables);
                
                _report_log(array("message"=>"Elimina Preventivo : $codice | ","error"=>""));
          
                
                redirect("/".getLanguage()."/quote/detail/".md5($codicered));
                
            }else{
                
                if(isset($_SESSION["carrello"][$codice])){
                    unset($_SESSION["carrello"][$codice]);
                }
                
                _report_log(array("message"=>"Elimina Preventivo Carrello: $codice | ","error"=>""));
          
                
                redirect("/".getLanguage()."/quote/view");
            }
            
            
          
      }
      
      
      



}