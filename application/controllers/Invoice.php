<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * La classe Invoce gestisce tutte le chiamate verso la fatturazione
 * 
 */
class Invoice extends CI_Controller {
    
    
        public function __construct(){

            parent::__construct();
            
            
            $this->lang->load('invoice_lang');//importante deve esserci il file per ogni lingua

            $this->load->helper(array('form', 'url'));

            $this->load->library('parser');

            addJs(array(
                //"bower_components/angular/angular.js",
                //"bower_components/angular-route/angular-route.js",
                //"public/js/app/invoice/invoice.js"
            ));

        }

      
      
        public function send($codice){
          
            if(!_is_logged()) redirect('/');
            
            
            addCSS(array(
                "public/bower_components/AdminLTE/plugins/iCheck/flat/green.css"
            ));
            addJS(array("public/js/sendinvoice.js"));
            
            
            //la funzione legge solo l'MD5
            $fattura=$this->user->getInvoice(MD5($codice));
            
            
            if(count($fattura)){
               $fattura=$fattura[key($fattura)];  
            }
            
            
            if($codice!=""){
                
                $data=array(
                    "PAGE_TITLE"=>t("Invia-preventivo"),
                    "modo"=>"invia-preventivo", 
                    "codicefattura"=>$codice,
                    "modellofattura"=>$fattura,
                    "sezione"=>"invoice-index",
                    "pagina_active"=>"invia-fattura"
                );
                
                $this->parser->parse('invoice/invia_fattura',$data);
            }
            
        }
      
        /**
         * Gestisce l'invio delle email per la fattura pronta
         * 
         * @param type $codice
         */
        public function sendemail($codice){
          
          if(!_is_logged()) redirect('/');
          
            //print_r($_REQUEST);
            $modello_p=array(
                "style"=>""
            );
            
            
            $k_codicefattura=MD5($codice);
            $invoice=$this->user->getInvoice($k_codicefattura);
            
            if(count($invoice)){
               $invoice=$invoice[key($invoice)];   
               $data["invoice"]=$invoice;
            }
            
            $v = "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";
            
            $dataresult["status"]=false;
            
            $destinatario       =   strip_tags($_REQUEST["destinatario"]);
            $oggetto_messaggio  =   strip_tags($_REQUEST["oggetto"]);
            
            $verificamail=(bool)preg_match($v,$destinatario);
            
            if( isset($destinatario) && $verificamail ){
            
                $record_email   =   array(
                    "tipo_documento"=>'fattura',//mooolto importante
                    "utente"=>$this->user->iduser,
                    "email_destinatario"=>$destinatario,
                    "preventivo"=>$invoice->codfatt,
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
                    
                    $data["urlallegato"]  = "https://app.winnub.com/".getLanguage()."/invoice/download_pdf/$k_codicefattura";
                    $data["userimage"]    = "http://app.winnub.com/".$this->user->getPhoto();
                    
                   
                    
                    //load email library
                    $this->load->library('email');
                    
                    // prepare email
                    $this->email
                        ->from('no-reply@winnub.com',$this->user->getDenominazioneAzienda())
                        ->to($destinatario)
                        ->subject($oggetto_messaggio)
                        ->message($this->load->view('invoice/email_template',$data,true))
                        ->set_mailtype('html');
                    
                    
                    $this->invoicepdfemail($k_codicefattura);
                    // load attachment
                    $this->email->attach("public/tmp_invoice/invoice_$k_codicefattura".".pdf");
                    
                    
                    // send email
                    $this->email->send();
                    
                    $dataresult["status"]=true;
                    $dataresult["message"]=t("Messaggio spedito");
                    $dataresult["obj"]=$record_email;
                    
                    _report_log(
                             array(
                                 "message"=>"Inviata Email ".json_encode($data)."| ",
                                 "error"=>""));
                    
                    
                }else{
                    //ERRORE INSERIMENTO...
                    _report_log(array("message"=>"Send Email ","error"=>"Errore"));

                }
            }else{
                _report_log(array("message"=>t("Email non corretta "),"error"=>"Errore"));
                $dataresult["status"]=false;
                $dataresult["message"]=t("Email non valida o mancante");
                
            }
            
            
            header("Content-type: text/json");
            echo json_encode($dataresult);
            
            
            exit;
          
          
        }
        
        
        
        public function invoicepdfemail($codice=0){

            
            
            $this->create_pdf_new($codice,"F","public/tmp_invoice/");
            
            
        }
      
        
        public function invoicepdf($codice=0){

             $this->create_pdf_new($codice,"D");
        }
      
        public function download_pdf($codice){
            $this->create_pdf_new($codice,"D");
        }

        public function create_pdf_new($codice=0,$modo='I',$pdir=""){
          
           if(!_is_logged()) redirect('/');
          
           $this->load->library("PDF_Invoice");
          
           $invoice=$this->user->getInvoice($codice);
           $invoice=$invoice[key($invoice)];  
           
           $intestazione_cliente="";
            $riga1=array();
            $riga2=array();
            
            
            $cliente=$invoice->getCliente();
            $cliente=$cliente[0];
            
            $htmlcliente=$this->parser->parse('invoice/intestazione_cliente',array("mod"=>$invoice),TRUE);
           
            if($invoice){
               
            
               $htmlpagamento="";
                if(!empty($invoice->tipologia_pagamento)){


                    $modello=$this->azienda->getPayment($invoice->tipologia_pagamento);

                    $pdata=array(
                        "codice"=>$code,
                        "modello"=>$modello,
                        "modo"=>"print",
                        "selezione"=>$invoice->pagamento_selezione
                    );
                    $htmlpagamento=$this->parser->parse('pagamenti/dettaglio_payment',$pdata,TRUE);

                }

                
                $blocco_pagamento=$htmlpagamento;
                $htmlintestazione=$this->parser->parse("invoice/intestazione",
                    array(
                        "invoice"=>$invoice,
                        "intestazionecliente"=>$htmlcliente,
                        "bloccopagamento"=>$blocco_pagamento,
                        
                       
                    ),
                    true);
                
                
                $htmlpagamento="";
                if(!empty($invoice->tipologia_pagamento)){


                    $modello=$this->azienda->getPayment($invoice->tipologia_pagamento);

                    $pdata=array(
                        "codice"=>$code,
                        "modello"=>$modello,
                        "modo"=>"print"
                    );
                    $htmlpagamento=$this->parser->parse('pagamenti/dettaglio_payment',$pdata,TRUE);


                }
                $blocco_pagamento=$htmlpagamento;
               
                try{

                    // create new PDF document
                    $pdf = new PDF_Invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false,true);
                    // set document information
                    $pdf->SetCreator("winnub.com");
                    $pdf->SetAuthor('Winnub');
                    $pdf->SetTitle('Winnub Quote '.$invoice->codice_seq);
                    $pdf->SetSubject('http://app.winnnub.com');

                    $urldocumento="";//"http://app.winnub.com/".getLanguage()."/invioce/create-pdf/$codice";
                    // set default header data
                    
                    $pdf->SetHeaderData("",0,"","$urldocumento");
                    
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

                    $dd=$invoice->getElementiData();
                    
                    // output the HTML content
                    
                    // set font
                    $pdf->SetFont('helvetica',null,10,'',true);
                    
                    // output the HTML content
                    $pdf->writeHTML($htmlintestazione,true,false,false,false);
                    
                    $pdf->Ln();
                    
                    $pdf->writeHTML($html,true,false,false,false);
                    // reset pointer to the last page
                    
                    $pdf->Ln();
                    
                    $pdf->writeHTML('<hr/>',true,false,false,false);
                    $lista_tasse=array();
                
                    $totalecarrello=0;
                    $codiciarticoli=array();
                    $costiservizi=array();
                    $sommasconti=0;
                    
                    $riga=array(
                            t("codice-pdf"),
                            t("descrizione-pdf"),
                            t("prezzo-pdf"),
                            t("quantita-pdf"),
                            t("aliquota-pdf"),
                            t("totale-pdf")
                    );
                        
                    $pdf->tableRow($riga);

                    foreach( $invoice->getItems() as $itm ){

                        //print_r($itm);
                        $codiciarticoli[]=intval($itm["idarticolo"]);
                        $RIFERIMENTO_PRODOTTO= json_decode($itm["altro"]);
                        
                        $costopertasse=0;
                        $valoresconto=0;
                        
                        if($itm["tipo_prodotto"]=="servizio"){

                            $costos=(floatval($itm["prezzo"])*intval($itm["quantita"]));


                            $costopertasse=( (floatval($costos)*intval($itm["iva"]))/100 );

                            $costiservizi[]=$costos;

                        }else{//i prodotti rispetto ai servizi non sono soggetti a sconti stiche applicate.

                            $costot=(floatval($itm["prezzo"])*intval($itm["quantita"]));
                            $totalecarrello+=$costot;

                            //devo sottrarre gli sconti
                            if($invoice->sconto>0){
                                $valoresconto=($costot*$invoice->sconto)/100;
                            }
                            $costot=$costot-$valoresconto;

                            $sommasconti+=$valoresconto;

                            $costopertasse=( (floatval($costot)*intval($itm["iva"]))/100 );
                        }
                        //nella tassazione devo calcolare lo sconto eventuale
                        $lista_tasse[$itm["iva"]]+=$costopertasse;
                        
                        $riga=array( 
                            $itm["cod_articolo"],
                            strip_tags($itm["descrizione"]),
                            "€ ".number_format($itm["prezzo"],2,".",""),
                            $itm["quantita"],
                            $itm["iva"],
                            "€ ".$costopertasse
                        );
                        
                        $pdf->tableRow($riga);

                    }
                    
                    // reset pointer to the last page
                    //$pdf->lastPage();
                    
                    $pdf->writeHTML('<hr/>',true,false,false,false);
                     

                    $pdf->controllaMargine(60);
                    
                    
                    $pdf->writeHTML($blocco_pagamento);
                    
                    $pdf->Ln();
                    
                    $pdf->controllaMargine();
                   
                    
                    $htmriepilogo=$this->parser->parse("invoice/sommario_invoice",
                    array(
                         "totalecarrello"=>$totalecarrello,
                        "codiciarticoli"=>$codiciarticoli,
                        "costiservizi"=>$costiservizi,
                        "sommasconti"=>$sommasconti,
                        "lista_tasse"=>$lista_tasse
                    ),
                    true);
                    
                    $pdf->writeHTML($htmriepilogo,true,false,false,false);
                    
                    
                   
                    
                    $pdf->Ln();
                     
                    // reset pointer to the last page
                    $pdf->lastPage();
                    
                    

                    // ---------------------------------------------------------
                   
                    //Close and output PDF document
                    $pdf->Output($pdir."invoice_$codice.pdf",$modo);
                   
                    
                    
                    //============================================================+
                    // END OF FILE
                    //============================================================+

                }catch(Exception $e){

                    //$this->parser->parse("errors/html/error_exception",array("error"=>$e));
                    
                }
            
            
            }else{
                $this->parser->parse("errors/html/error_general",array(
                    "heading"=>t("Documento non trovato"),
                    "message"=>t("<p>Preventivo non trovato o non hai i premessi sufficienti per leggere questo documento</p>")
                    ));
            }
          
      }
      
      
      
      
      public function create_pdf($codice=0){
            
            $this->create_pdf_new($codice);
            /* DA rimuovere dipo verifica....
             * 
             * 
             *
             * 
             *
            $intestazione_cliente="";
            $riga1=array();
            $riga2=array();
            
            $invoice=$this->user->getInvoice($codice);
            
            
            if(count($invoice) && $invoice!=null){
                
               $invoice=$invoice[key($invoice)];  
               
               $cliente=$invoice->getCliente();
               $cliente=$cliente[0];
               
               // create some HTML content
              
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
               
                $intestazione_cliente = "<div class='blocks-c'>"
                ."<h2>".((trim($cliente->rag_sociale_cliente)?$cliente->rag_sociale_cliente:""))."</h2>
                <p>
                  ".implode(",",$riga1)."
                </p>
                <p>
                   ".implode(",",$riga2)."
                </p>"
            . "</div>";


            $htmlpagamento="";
            if(!empty($invoice->tipologia_pagamento)){


                $modello=$this->azienda->getPayment($invoice->tipologia_pagamento);

                $pdata=array(
                    "codice"=>$code,
                    "modello"=>$modello,
                    "modo"=>"print"
                );
                $htmlpagamento=$this->parser->parse('pagamenti/dettaglio_payment',$pdata,TRUE);
                

            }


            $blocco_pagamento=$htmlpagamento;
            

                $html=$this->parser->parse("invoice/invoice_pdf",
                    array(
                        "invoice"=>$invoice,
                        "intestazionecliente"=>$intestazione_cliente,
                        "bloccopagamento"=>$blocco_pagamento
                    ),
                    true);
            
                $htmlintestazione=$this->parser->parse("invoice/intestazione",
                    array(
                        "invoice"=>$invoice,
                        "intestazionecliente"=>$intestazione_cliente,
                        "bloccopagamento"=>$blocco_pagamento,
                        
                       
                    ),
                    true);
            
                $this->load->library("PDF_Invoice");

                try{

                        // create new PDF document
                        $pdf = new PDF_Invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false,true);
                        // set document information
                        $pdf->SetCreator("winnub.com");
                        $pdf->SetAuthor('Winnub');
                        $pdf->SetTitle('Winnub Quote '.$invoice->codice_seq);
                        $pdf->SetSubject('http://app.winnnub.com');

                        $urldocumento="";//"http://app.winnub.com/".getLanguage()."/invioce/create-pdf/$codice";
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

                        $dd=$invoice->getElementiData();
                        
                        /*$pdf->tableData(
                                array(
                                    "cod_articolo",
                                    "descrizione",
                                    "quantita",
                                    "prezzo",
                                    "iva"),$dd["elementi"]);


                        // output the HTML content
                        
                        // set font
                    $pdf->SetFont('helvetica',null,11,'',true);

                   
                    // output the HTML content
                    
                    $pdf->writeHTML($htmlintestazione,true,false,false,false);
                    

                    $pdf->Ln();


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

                   //$this->parser->parse("errors/html/error_exception",array("error"=>$e));
                }
            
            
            }else{
                $this->parser->parse("errors/html/error_general",array(
                    "heading"=>t("Documento non trovato"),
                    "message"=>t("<p>Preventivo non trovato o non hai i premessi sufficienti per leggere questo documento</p>")
                    ));
            }

            */
      }
      
     
      
      public function index(){
          
          
          
            $data=array(
                      "PAGE_TITLE"=>"invoice",
                      "SECTION_TITLE"=>t('invoice-section'),
                      "categoriabase"=>"invoice",
                      "sezione"=>"invoice-index",
                      "error"=>""
             );
           $this->parser->parse('invoice/default',$data);
          
          
      }
      
      
      public function all(){
          if(!_is_logged()) redirect('/');
          
          
         $data=array(
             "PAGE_TITLE"=>t('titolo_pagina_fatture_key'),
             "NOME_SEZIONE_DESCRIZIONE"=>t('descrizione_pagina_fatture_key'),
             "sezione"=>"invoice-index",
             "categoriabase"=>"invoice",
             "pagina_active"=>"invoice-all",
             
             "schema"=>$this->user->getMy("fatture")

         );
         
         //addJS(array("public/bower_components/AdminLTE/dist/js/pages/dashboard2.js"));
         //$this->parser->('dashboard',$data);
         addJS(array("public/js/quote-table.js"));
         
         $this->parser->parse('tablelist',$data);
         
         
      }
      
      public function emails(){
          
          
            $data=array(
                      "PAGE_TITLE"=>"invoice",
                      "SECTION_TITLE"=>t('invoice-section'),
                      "categoriabase"=>"invoice",
                      "sezione"=>"invoice-index",
                      "error"=>""
             );
           $this->parser->parse('invoice/email_send',$data);
          
          
      }
      
      
      /**
       * 
       */
      public function create(){
          
          if(!_is_logged()) redirect('/');
          
          $this->view();
      }
    
      
      public function view($codice=0){
          
            
            $invoice=new Invoice_model();
            
            if($codice>0){
                
                $invoice=$invoice->get($codice);
               
            }
            
            addJS(array(
                
                "public/js/validate/jquery.validate.min.js",
                "public/js/validate/additional-methods.min.js",
                "public/js/jquery.autocomplete.min.js",
                "public/js/invoice.js"
            ));
            
            addCSS(array("public/css/jquery.auto-complete.css"));
            
          //variant
            $data=array(
                      "PAGE_TITLE"=>"invoice",
                      "SECTION_TITLE"=>t('invoice-detail'),
                      "categoriabase"=>"invoice",
                      "sezione"=>"invoice-index",
                      "error"=>"",
                      "invoice"=>$invoice
            );
            
           $this->parser->parse('invoice/detail',$data);
          
          
      }
      
      /**
       * Effettua le operazioni di aggiornamento dei dati.
       */
      public function update(){
          
          $result["status"]=FALSE;
          $codice=$_REQUEST["invoicecode"];
          
          if($codice==0){
              $invoice=new Invoice_model();
              $codice=$invoice->generaFattura(0,date("Y"),0);
              
              $result["codice"]=$codice;
              
          }else{
              $invoice=Invoice_model::getInvoice($codice);
          }
          
          //print_r($invoice);
          
          $itemcode=$invoice->addItem($_REQUEST);
          
          if($itemcode>0){
                $result["item"]=$invoice->getItem($itemcode);
                $result["status"]=$itemcode;
                
          }
          
          $this->output
            ->set_content_type('text/json') //set Json header
            ->set_output(json_encode($result));// make output json encoded
          
         
      }
      
      public function testInvoice($codice){
          
           
            //print_r($_REQUEST);

            if($codice==0){
                $invoice=new Invoice_model();
            }else{
                $invoice=Invoice_model::getInvoice($codice);

            }
          
            $pagamenti_request=array();
            
            $modello    =   $this->azienda->getPayment($invoice->tipologia_pagamento);
            
            $modello    =   json_encode($modello[0]);
            
            print_r($modello);
            
            
            if(count($_REQUEST['pagamenti'])>0){
                foreach($_REQUEST['pagamenti'] as $key=>$pmidm){
                    $pagamenti_request[]=array("name"=>$key,"value"=>$pmidm);
                }
            }
            
            
             print_r($pagamenti_request);
            
          
          exit;
      }
      
      
      /**
       * Salva la fattura
       * 
       */
      public function saveInvoice(){
          
            $codice=$_REQUEST["invoicecode"];
            //print_r($_REQUEST);

            if($codice==0){
                $invoice=new Invoice_model();
            }else{
                $invoice=Invoice_model::getInvoice($codice);

            }
            
            $pagamenti_request  =   array();
            $modello            =   $this->azienda->getPayment($_REQUEST["t_pagamento"]);
            $json_record        =   json_decode($modello[0]["campi"]);
            
            
            
            $newfields=array();
            
            if(count($json_record->field)>0){
                
                foreach ($json_record->field as $i=>$obj){
                    
                    $vf=$_REQUEST['pagamenti'][$obj->name];
                    
                    $newfields["field"][]=array(
                        "id"        =>  $obj->id,
                        "value"     =>  $vf,
                        "name"      =>  $obj->name,
                        "class"     =>  $obj->class,
                        "label"     =>  $obj->label
                    );
                    
                  
                }
                
            }
            
            
          
            $oggettoinvoice=array(
             
              "utente"=>$this->user->iduser,
              "preventivo"=>$invoice->preventivo,
              "intestazione"=>$_REQUEST["bloccointestazione"],
              "cliente"=>$_REQUEST["codicecliente"],
              "codice_seq"=>$_REQUEST["numero_fatt"],
              "anno"=>$_REQUEST["anno_fatt"],
              "data"=>$_REQUEST["data_fatt"],
              "totale"=>floatval(str_replace(" ","",str_replace(",",".",$_REQUEST["totale_invoice"]))),
              "template"=>"",
              "sconto"=>$_REQUEST["scontistica"],
              "tipologia_pagamento"=>$_REQUEST["t_pagamento"],
              "note_fattura"=>"",
              "pagamento_selezione"=>json_encode($newfields)
            );
            
            
            $itemslist=json_decode($_REQUEST["itemcodes"]);
            $itemslis=array();
            if(count($itemslist)>0){
                foreach($itemslist as $key=>$it){
                    
                    $tiposerv=($_REQUEST["tipologiaservizio"][$it]=="selezionato")?"servizio":"prodotto";

                    $itemslis[$it]=array(

                            "idarticolo"=>$it,
                            "codfattura"=>(isset($_REQUEST["invoicecode"]))?$_REQUEST["invoicecode"]:null,
                            "cod_articolo"=>$_REQUEST["codicearticolo"][$it],
                            "descrizione"=>$_REQUEST["descrizione"][$it],
                            "unita_mis"=>"",
                            "quantita"=>$_REQUEST["qty"][$it],
                            "prezzo"=>$_REQUEST["price"][$it],
                            "sconto"=>"",
                            "altro"=>"",
                            "iva"=>$_REQUEST["vat"][$it],
                            "tipo_prodotto"=>$tiposerv,
                            "ordinamento"=>$_REQUEST["ordinamento"][$it]

                    );
                }
            
            }
            $result=$invoice->update($oggettoinvoice,$itemslis);
            
            echo json_encode($result);
            
          exit;
      }
      
      
      public function sendInvoice(){
          
          
          
      }

      
      
}