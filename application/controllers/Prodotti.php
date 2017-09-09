<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prodotti extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct() {
         parent::__construct();
         
        $this->load->library('parser');
         
         
        $this->lang->load('controller_prodotti');//importante deve esserci il file per ogni lingua
		
         
        if(!_is_logged()){
             header("location:".base_url());
        }else{
             //print_r();
             
        }
         
         
         addCSS(array(
                "public/js/fancybox/jquery.fancybox.css",
         ));
         
         addJs(array(
                
                "public/js/fancybox/jquery.fancybox.pack.js",
                "//npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js",
               // "//cdnjs.cloudflare.com/ajax/libs/require.js/2.3.2/require.min.js",
            
         ));
        
         
      }
      
	public function index()
	{
            if(!_is_logged()) redirect('/');
      }
      
      
       
      
      /**
       * 
       * @param type $nome
       * @param type $modo
       */
      public function editor($nome=null,$codice=""){
          
          if(!_is_logged()) redirect('/');
          
          if(!$this->user->isAdmin()) header("location: /dashboard");
          
          
          $this->load->helper('url');

          $slug = url_title($this->input->post('title'), 'dash', TRUE);
          //print_r($slug);
          
          $data=array(
              "pagina_active"=>"gestione",
              "PAGE_TITLE"=>"Gestione Prodotti",
              "NOME_SEZIONE_DESCRIZIONE"=>"Gestisci i prodotti",
              "sezione"=>$nome
          );
          addCSS(array(
             
              "public/bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"
          ));
          addjs(
             array(
                 
                 "public/bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"
                 ,
                 "public/js/editor.js")
          );
          
          //print_r($codice);
          
          $idedit=explode(":",$codice);
          $idedit=$idedit[1];
          
          switch ($nome){
              
              case "profili":
               
               $data["frm_action"]="/profile/action/profilo/$idedit";
               $data["pkey"]="idProdotto";
               $data["nome_sigolare"]="profilo";
               
               $prodotto=$this->modello_prodotti;
               
               if($idedit>0){
                   $query=$this->db->query("SELECT * FROM lm_prodotti WHERE idProdotto=?",array($idedit));
                   $prodotto=$query->row(0,"Prodotto_model");
                   //print_r($prodotto);
                   $data["tabella_fields"] = $query->list_fields();//tutti i field
                   $data["tabella"] = $query->result_array();
               }
               
               $data["form_file"]="forms/editor_profilo";//nome della vista da caricare per l'editor
                  
              break;
          }
         
          $data["prodotto"]=$prodotto;
          
          
          $this->load->view('limap/_header',$data);
          $this->load->view('limap/_sidebar',$data);
          
          $this->load->view("form_admin_editor", $data);
          
          $this->load->view('limap/_footer',$data);
          
      }
      
      public function create(){
          
          if(!_is_logged()) redirect('/dashboard');
          
          $this->modifica(0);
      }
      
      
      public function elimina($codice){
          
            
            $this->db->where('codice_modello', $codice);
            $this->db->delete('lm_modelli_prodotti');
          
            redirect("prodotti/gestione");
      }


      public function modifica($codice=0){
          
          if(!_is_logged()) redirect('/');
          if(!$this->user->isAdmin()) redirect("/dashboard");
          
          $this->load->helper('url');
          
         

          $slug = url_title($this->input->post('title'), 'dash', TRUE);
          //print_r($slug);
          
          
          addCSS(array(
              "//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css",
                
                "public/css/elfinder/css/elfinder.min.css",
                "public/css/elfinder/css/theme.css",
              "public/bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"
          ));
          addjs(
             array(
                 
                "public/bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js",
                "public/js/elfinder/js/elfinder.min.js",
             
                "public/js/editor.js",
                "public/js/jquery.sortable.js",
                "public/js/gestione.js"
             )
          );
          
         
          $data=array(
              "pagina_active"=>"edit",
              "PAGE_TITLE"=>"Modifica Prodotto",
              "NOME_SEZIONE_DESCRIZIONE"=>"Modifica prodotto",
              "sezione"=>"gestione-prodotto",
              "codiceinterno"=>$codice
          );
          
          
          $prodotto=$this->modello_prodotti;
               
         if($codice>0){
              
                $query=$this->db->query("SELECT lb.* FROM lm_modelli_prodotti lb"
                        . " WHERE codice_modello=? "
                        . " AND (SELECT la.azienda FROM lm_prodotti_azienda la"
                 . " WHERE la.codiceprodotto=lb.codice_modello)=? ",array($codice,$this->user->owner));
                
                $prodotto=$query->row(0,"Prodotto_model");
                
                if(is_object($prodotto)){
                    //print_r($prodotto);
                    $data["tabella_fields"] = $query->list_fields();//tutti i field
                    $data["tabella"] = $query->result_array();
                }else if ($codice>0) {
                    
                       
                    
                       $data["segnala_attenzine"]=array(
                           "type"=>"codice_errato",
                           "messaggio"=>"Codice errato, se il problema persiste contattare l'assistenza. Sconsigliamo di operare sulla "
                           . "pagina con il presente errore per evitare incongruenze o perdite di dati."
                           );//mi segnala un codice di ??!
                   
                       $prodotto=$this->modello_prodotti;
                       //verifichiamo a chi appartiene
                       
                       
                }else{
                    redirect("/access_error");
                    exit;
                }
         }
          
          $data["prodotto"]=$prodotto;
          
         
           
          $this->load->view('limap/_header',$data);
          $this->load->view('limap/_sidebar',$data);
          
          $this->load->view('forms/editor_prodotto',$data);
          
          $this->load->view('limap/_footer',$data);
          
      }
      
      
      public function espandi($datas){
          
          $prod=$this->modello_prodotti->get_id($datas,true);//il true mi permette di criptare il codice
          $prod=$prod[0];
          
          if(isset($_GET["confermaespandi"])){
              $codicecliente=$_REQUEST["cliente"];
              
              
              
              $html= "..clonazione del prodotto su ".$_REQUEST["cliente"]." avvenuta <br/><br/>";
              
              
              
              
          }
          
          
          $data=array("prodotto"=>$prod,"codice_prodotto"=>$datas,"html"=>$html);
          
          $this->load->view('limap/_header',$data);
          $this->load->view('limap/_sidebar',$data);
          
          $this->load->view('forms/espandi_prodotto',$data);
          
          $this->load->view('limap/_footer',$data);
          
          
         
      }
        
      
      /**
       * Gestione dei prodotti lato admin per amministrazione
       * 
       * @param type $p
       * @param type $modo
       */
      public function gestione($nome=null,$modo=null){
          
          if(!_is_logged()) redirect('/');
          
          //if(!$this->user->isAdmin()) header("location: /dashboard");
          
         
          //print_r($modo);
          
          $data=array(
              "pagina_active"=>"gestione-prodotto",
              "PAGE_TITLE"=>"Gestione Prodotti",
              "NOME_SEZIONE_DESCRIZIONE"=>"Gestisci i prodotti",
              "sezione"=>$nome
          );
          
          
            switch ($nome){
              
              
              case "categorie":
                    
                    
                  addJS(array("public/js/category.js"));
                  
                  addBreadCrumbsItem("/dashboard","Dashboard");
                  addBreadCrumbsItem("/profilo","Profilo");
                  addBreadCrumbsItem("/profile/gestione/categorie","Categorie");
                  
                  $file="categorie";
                  $data=array(
                      "PAGE_TITLE"=>"Categorie",
                      "SECTION_TITLE"=>$this->lang->line('configuratore_key'),
                      "categoriabase"=>"gestione-categorie-prodotto",
                      "sezione"=>"gestione-prodotto",
                      
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
                  
                   $this->parser->parse('utente/'.$file,$data);
                    
              break;
           
              
              
              
              case "tipologie":
                  
               $data["pkey"]="carattere_prodotto";
               $data["nome_sigolare"]="tipologie-prodotto";
               
               $data["sezione"]="gestione-prodotto";
               $data["pagina_active"]="tipologie";
               
               
               $data["action_url_edit"]="/prodotti/gestione/tipologie";
               
               $query=$this->db->query("SELECT DISTINCT carattere_prodotto FROM lm_modelli_prodotti ",array());
               $data["tabella_fields"] = $query->list_fields();//tutti i field
               $data["tabella"] = $query->result_array();
               
                
                $this->load->view('limap/_header',$data);
                $this->load->view('limap/_sidebar',$data);

                $this->load->view('viewtable',$data);

                $this->load->view('limap/_footer',$data);
                  
              break;
              
              
              default:
                
                addjs(
                    array("public/bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"
                         ,
                         "public/js/gestione.js")
                     );
                  
                $data["pkey"]="codice_modello";
                $data["nome_sigolare"]="nuovo_prodotto";
                $data["sezione"]="gestione-prodotto";
                $data["pagina_active"]="gestione";

                $data["action_url_edit"]=  "/".getLanguage()."/prodotti/modifica";
                $data["action_url_delete"]=  "/".getLanguage()."/prodotti/elimina";

                $query=$this->adminuser->getProdotti();

                $data["tabella_fields"] = $query->list_fields();//tutti i field
                $data["tabella_fields"]=array("codice_interno","nome","descrizione","carattere_prodotto");
                $data["tabella"] = $query->result_array();


                $this->load->view('limap/_header',$data);
                $this->load->view('limap/_sidebar',$data);

                $this->load->view('viewtable',$data);

                $this->load->view('limap/_footer',$data);
               
               break;
          }
         
      }
      
      /**EVENTO DRAG elementi categorie
       * Aggiorna categoria in sugli spostamenti
       * dei gruppi
       */
      public function updatect(){
          
          if(!_is_logged()) redirect('/');
          
          $this->output->set_header('Content-Type: application/json; charset=utf-8');
          
          $data=array();
          $data["error_code"]=0;
          //$prodotto=null;
          $variante=null;
          $modello=null;
          
          //print_r($_GET);
          $categoria=$_GET["category"];
          $in=$_GET["in"];
          $azienda=$this->user->owner;
          
          $sql="UPDATE lm_categorie_prodotti SET "
                  . " gruppo='$in' "
                  . " WHERE ( (azienda='$azienda' OR owner='-1') AND idcategoria='$categoria' ) ";
          
          $this->db->query($sql);
          
          
          echo json_encode($data);
          
          exit;
      }
      
     
      
      public function savecategoria($datas=null){
          
          //print_r($_REQUEST);
          $gruppo="product";
          
          $codice=($_REQUEST["codice"]);
          

          if( !empty($_REQUEST["grupponew"]) && trim($_REQUEST["grupponew"])!="" ){
              $gruppo=url_title(strtolower($_REQUEST["grupponew"]));
          }else{
              $gruppo=strtolower($_REQUEST["gruppo"]);
          }
          
          if( trim($_REQUEST["nomecategoria"]) != "" && trim($gruppo)!=""){
              
            $datas=array(
                "nomecategoria"=>$_REQUEST["nomecategoria"],
                "descrizione"=>$_REQUEST["descrizione"],
                "gruppo"=>$gruppo,
                "fotourl"=>$_REQUEST["urlfoto"]
            );
            
            if($codice>0){
                $this->modello_prodotti->registraCategoria($datas,$codice);//modifica
            }else{
                $this->modello_prodotti->registraCategoria($datas);
            }
            
            
            if( isset($_SERVER['HTTP_REFERER'])){
              redirect($_SERVER['HTTP_REFERER']);
            }

            if( isset($_REQUEST['referarl'])){
              redirect($_REQUEST['referarl']);
            }

            redirect("dashboard");
          
          }
          
          exit;
          
      }
      
      
      /**
        * 
        * @param type $cod
        */
      public function servizi($cod=null){
          
          if(!_is_logged()) redirect('/');
          
          $accessori=$this->modello_prodotti->getServizi($cod);
          
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($accessori)
            );
      }

      /**
       * 
       * @param type $prodotto
       */
      public function accessori($prodotto){
          
          if(!_is_logged()) redirect('/');
          $accessori=$this->modello_prodotti->getAccessori();
          print_r($accessori);
          
      }
        
        
      public function updatecart(){
          if(!_is_logged()) redirect('/');
          
          $indice=$_POST["prif"];
          $valore=$_POST["valore"];
          
          if($valore>0){
            $_SESSION["carrello"][$indice]["qty"]=$valore;
          
            $data=$_SESSION["carrello"][$indice];
          
            $this->carrello->update($data);
          }else{
               $_SESSION["carrello"][$indice]=null;
              unset($_SESSION["carrello"][$indice]);
           
            
          }
          echo "{success:true}";
          
          exit;
      }
      
      
      /**
       * Questo metodo agisce solo con il modal che compare sulla pagina ma esegue 
       * le stesse cose della funzione sotto...
       * DA UNIRE o UNIFORMARE per evitare rindondanza
       */
      public function insertcartelement(){
          
          //print_r($_REQUEST);
          $codice=$_REQUEST["detail"];
            
          if(preg_match('/^[a-f0-9]{32}$/i',$codice)){//lo caffuddo dentro il db
              
                
                $insert_id=$this->modello_preventivo->resolveId($codice);
                 
                 
                $ds=array(
                    "preventivo_id"=>$insert_id,
                    "codice_identificativo"=>"",
                    "prodotto"=>$_REQUEST["modello"],
                    "quantita"=>$_REQUEST["quantita"],
                    "costo"=>$_REQUEST["prezzo"],
                    "codice_iva"=>$_REQUEST["codiceiva"]
                );
                 
                $this->modello_preventivo->addItem($ds);
              
              
          }else{//altrimenti me lo tengo caro sulla sessione...
                
                $codicecart=genera_codice_carrello();
                 
                $oggetto=array(
                    "modello"=>$_REQUEST["modello"],
                    "qty"=>$_REQUEST["quantita"],
                    "price"=> $_REQUEST["prezzo"],
                    "varianti"=>$varianti,
                    "iva"=>$_REQUEST["codiceiva"]
                 );
                
                //creo sessione di carrello
                $_SESSION["carrello"][$codicecart]=$oggetto;
                $this->carrello->insert($oggetto);
              
          }
          
          exit;
      }


      public function addtocart($p=null){
          if(!_is_logged()) redirect('/');
          
          
          $data=$_REQUEST;
          $varianti=array();
          
          
          $IVA_IMPOSTA_GLOBALE=resolveVatCode($_REQUEST["codiceiva"],"aliquota");//mi restituisce il valore iva associato
          
         
          
          if(!isset($_REQUEST["codicecarrello"])){
            $codicecart="wctA00".time();
                      
          }else{
            $codicecart=$_REQUEST["codicecarrello"];
          }
          
              
          
          if( /*$_REQUEST["profilo"]!=null &&*/ 
                  $_REQUEST["modello"]!=null 
                  && ( isset($_REQUEST["prezzo"]) || isset($_REQUEST["prezzosingolo"]) || isset($_REQUEST["totalebase"]) )
                  &&  $_REQUEST["quantita"]>0
                  
                  ){
              
            
              
            if(isset($_REQUEST["varianti"])){
                $var=$_REQUEST["varianti"];
                $prezzivar=$_REQUEST["prezzovariante"];
                $quantvariante=$_REQUEST["quantit_varianti"];
                $itemvar=$_REQUEST["prezzo_item"];//deovrebbe essere il costo singolo...
                if(count($var)>0){
                    foreach($var as $k=>$va){
                        
                        $varianti[]=array("codice"=>$k,
                            "costo"=>$prezzivar[$k],
                            "qty"=>$quantvariante
                         );
                    }
                }
            }
            
            
            //correggo il prezzo finale maggiorato
            //il prezzo finale è quello ottenuto nel preventivo...
            $prezzofinale=floatval($_REQUEST["totalebase"]);//questo è il prezzo finale...
            if(!isset($_REQUEST["totalebase"])){
                $prezzofinale=floatval($_REQUEST["prezzosingolo"]);
            }
            
            
            if( isset($_REQUEST["codicecarrello"]) && isset($_REQUEST["codicepreventivo"]) ){
                
                $oggetto=array(
                    
                    "prodotto"      =>      strip_tags($_REQUEST["modello"]),
                    "altezza"       =>      strip_tags($_REQUEST["altezza"]),
                    "larghezza"     =>      strip_tags($_REQUEST["larghezza"]),
                    "quantita"      =>      strip_tags($_REQUEST["quantita"]),
                    "costo"         =>      $prezzofinale,
                    "varianti"      =>      json_encode($varianti),
                    "codice_iva"    =>      $_REQUEST["codiceiva"],
                    "descrizione"   =>      (isset($_REQUEST["descrizione"]))?$_REQUEST["descrizione"]:"",
                    "descrizione_2 "    =>  (isset($_REQUEST["descrizione2"]))?$_REQUEST["descrizione2"]:"",
                 );
                
                $idprev= intval($_REQUEST["codicecarrello"]);
                $this->modello_preventivo->aggiornaItem($idprev,$oggetto);
                
                
                
            }else if(isset($_REQUEST["codicepreventivo"])){
                //inserisce in un preventivo esistente...
                 
                 if( is_int($_REQUEST["codicepreventivo"]) ){
                     $insert_id=$_REQUEST["codicepreventivo"];
                 }else{
                    $insert_id=$this->modello_preventivo->resolveId($_REQUEST["codicepreventivo"]);
                 }
                 
                 
                 
                 $ds=array(
                    "preventivo_id"=>$insert_id,
                    "codice_identificativo"=>"",
                    "prodotto"=>    $_REQUEST["modello"],
                    "quantita"=>    $_REQUEST["quantita"],
                    "larghezza"=>   $_REQUEST["larghezza"],
                    "altezza"=>     $_REQUEST["altezza"],
                    "costo"=>       $prezzofinale,
                    "varianti"=>  json_encode($varianti),
                    "codice_iva"=>$_REQUEST["codiceiva"],
                    "descrizione"=>(isset($_REQUEST["descrizione"]))?$_REQUEST["descrizione"]:"",
                    "descrizione_2"=>(isset($_REQUEST["descrizione2"]))?$_REQUEST["descrizione2"]:"",
                );
                 
                $this->modello_preventivo->addItem($ds);
                //redirect("/".getLanguage()."/quite/detail/".$_REQUEST["codicepreventivo"]);
                
                $data["pcode"]=($_REQUEST["codicepreventivo"]);
                
                
            }else{
                
                $oggetto=array(
                    "modello"=>$_REQUEST["modello"],
                    "altezza"=>$_REQUEST["altezza"],
                    "larghezza"=>$_REQUEST["larghezza"],
                    "qty"=>$_REQUEST["quantita"],
                    "price"=> $prezzofinale,
                    "descrizione"=>(isset($_REQUEST["descrizione"]))?   $_REQUEST["descrizione"]:"",
                    "descrizione_2"=>(isset($_REQUEST["descrizione2"]))? $_REQUEST["descrizione"]:"",
                    "varianti"=>$varianti,
                    "iva"=>$_REQUEST["codiceiva"]
                 );
                
                //creo sessione di carrello
                $_SESSION["carrello"][$codicecart]=$oggetto;
                $this->carrello->insert($oggetto);
                
                
              }


                echo json_encode($data);
              
          }else{
               echo json_encode(array("error"=>"Error price or quantity"));
          }
          
          exit;
      }
      
      
      public function getprofili(){
          
          if(!_is_logged()) redirect('/');
          
          header("Content-type: text/javascript");
          
          $modello =   ($_GET["modello"]);
          $materiale =  ($_GET["materiale"]);
          
          $lista=$this->modello_prodotti->get_profilo($materiale,$modello);
          
          echo json_encode($lista);
          
          exit;
          
      }
      
      
     
      /**
       *  Mi restituisce la  variante di un prodotto...
       * 
       */
      public function variante($codice=null){
          
            header("Content-type: text/json");

            $modello = strip_tags($_GET["modello"]);

            $lista=$this->modello_prodotti->getVarianti($modello);
            //print_r($_GET["modello"]);
            //
            //organizzo le varianti ottenute per le categorie
            //
            $varianti=array();

            foreach($lista as $i=>$v){
              
                $infovariante=$this->modello_prodotti->getCostiModello($v->codice_modello);
             
                //print_r($infovariante);
              
                $varianti[$i]=array(
                    "idProdotto"=>$v->codice_modello,
                    "codice"=>$v->codice_interno,
                    "nome"=>$v->nome,
                    "metodoprezzo"=>$v->calcolo,
                    "foto"=>$v->foto
                );
                if(count($infovariante)>0){

                    $infovariante=$infovariante[0];


                    $c=getCostoMisura($_GET["w"],$_GET["h"],$infovariante->costo);


                    $varianti[$i]["prezzo_unitario"]=$infovariante->importo_unitario;

                    $varianti[$i]["prezzo"]=$infovariante->costo;

                    $varianti[$i]["prezzo_mq"]=$c;


                }
              
            }
            $datas=array(
                      "draw"=>1,
                      "recordsTotal"=>count($varianti),
                      "data"=>$varianti
                      );

            echo json_encode($datas);

            exit;
      }
      
      public function getProductSelection($modello,$materiale){
          
          if(!_is_logged()) redirect('/');
          
          $this->modello_prodotti->get_profilo($categoriabase);
          
          
      }
      
      public function creaOrdine(){
          
          if(!_is_logged()) redirect('/');
          
          //tipo di pagamento
          $pagamento=$_REQUEST["mode_payement"];
          //trasposto
          $trasporto=$_REQUEST["mode_trasport"];
          //ristrutturazione
          $riduzione_iva=$_REQUEST["riduzione_iva"];
          
          
          
      }
      
         
       
      public function ordini($nome=null){
            
          if(!_is_logged()) redirect('/');
          
            $data=array(
             "PAGE_TITLE"=>"Ordini"
            );
            //addJS(array("public/bower_components/AdminLTE/dist/js/pages/dashboard2.js"));
            //$this->parser->('dashboard',$data);
            
            addJS(array("public/js/dashboard2.js"));
            $this->parser->parse('tablelist',$data);

      }
      
      /**
       * Salvataggio di un prodotto...
       * Gestione admin
       * @param type $cosa
       */
      public function save($cosa){
          if(!_is_logged()) redirect('/');
          if(!$this->user->isAdmin()) redirect ("/");
          
          if($_REQUEST["codiceprodotto_codsec"]!=$cosa){
              header("HTTP/1.0 500 Access error product...! accesso non consentito! ");
              exit;
          }
          

          $this->output->set_header('Content-Type: text/json; charset=utf-8');
          
          
          $immagineprodotto=$this->input->post("immagineprodotto");
          //controllo i media
          
          if( !empty($_FILES["mediafile"]["name"]) ){
              
              //upload method
                $config['upload_path']          =$this->user->check_image_path();
                $config['allowed_types']        = 'gif|jpg|png|JPG';
                $config['max_size']             = 300;
                $config['max_width']            = 1600;
                $config['max_height']           = 1600;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                    
                if ( ! $this->upload->do_upload('mediafile'))
                {
                         $error = array('errorupload' => $this->upload->display_errors());
                         exit;
                }else{
                    
                    $data = array('upload_data' => $this->upload->data());
                    $immagineprodotto="".$data["upload_data"]["full_path"];

                }
               
          }
          
          
          if(  $_REQUEST["codiceprodotto_codsec"]==$cosa){
                
                 $this->load->helper('url');
                 

                //print_r($_REQUEST);
                 
               

                //_report_log(array("message"=>"Save product...","error"=>""));

                $categoria=$this->input->post('categoria_prodotto');

                if( !empty($_REQUEST["categoria_prodotto_new"])){
                    //ricevo quella generata...
                    $categoria_nome=$this->input->post('categoria_prodotto_new');
                    $excaped_nome= url_title($categoria_nome);
                    $px=array(
                        "owner"=>$this->user->iduser,
                        "azienda"=>$this->user->owner,
                        "nome"=>$excaped_nome,
                        "valore"=>$categoria_nome,
                        "gruppo"=>$excaped_nome
                        
                    );
                    $this->db->insert("lm_categorie_prodotti",$px);
                    $categoria=$this->db->insert_id();
                }

                $dataprodotto=array(
                    "categoria"=>$categoria,
                    "nome"=>$this->input->post('nome'),
                    "codice_interno"=>$this->input->post('codiceinterno'),
                    "descrizione"=>$this->input->post('basedescription'),
                    "descrizione_tecnica"=> $this->input->post('descrizione_tecnica'),   
                    "min_fatt"=>$this->input->post('minfatturabile'),
                    "carattere_prodotto"=>$this->input->post('carattere_prodotto'),
                );
                
                if( $immagineprodotto!="" OR isset($immagineprodotto) ){
                    //verifico che sia disponibile il sottominio
                    //riformulo il nome dell'immagine come url completo
                    $immagineprodotto= str_replace("http://","",$immagineprodotto);
                    $immagineprodotto= str_replace("app.winnub.com","",$immagineprodotto);
                    $immagineprodotto="http://app.winnub.com".$immagineprodotto;
                    
                    $dataprodotto["foto"]=$immagineprodotto;
                }
                
                
                $prodotto=new Prodotto_model();
                if($cosa==0){
                    $dataprodotto["utente"]=$this->user->iduser;
                    $idprodotto=$prodotto->salva($dataprodotto);
                }else{
                    //aggiorno...
                    $prodotto=$prodotto->load($cosa);
                    
                    $prodotto->salva($dataprodotto);
                    
                    $idprodotto=$cosa;
                }
                
                if($prodotto->codice_modello>0){//se va a buon fine l'inserimento del prodotto...proseguiamo
                        
                       
                        $costiprodotto=array(
                            "larghezza"=>$this->input->post('largh_min'),
                            "altezza"=>$this->input->post('alt_min'),
                            "stato"=>1,
                            "costo"=>$this->input->post('prezzo'),
                            "importo_unitario"=>$this->input->post('prezzo_fisso'),
                            "prezzo_m_lineare"=>$this->input->post("prezzo_metro_lineare")
                        );
                        
                        
                        
                        $prodotto->aggiornaCostiModello($costiprodotto);
                        
                        
                        //step dei costi
                        
                        $costibase=array(
                            "larghezza"=>$this->input->post('largh_min'),
                            "altezza"=>$this->input->post('alt_min'),
                            "stato"=>1,
                            "costo"=>$this->input->post('costo'),
                            "importo_unitario"=>$this->input->post('costo_fisso'),
                            "prezzo_m_lineare"=>$this->input->post("costo_metro_lineare"),
                            "costo_min_fatturabile"=>$this->input->post('costo_min_fatturabile')
                        );
                        
                        $prodotto->aggiornaCostiBaseModello($costibase);
                        
                        
                        $data["status"]=1;
                        $data["code"]=$idprodotto;
                        
                        
                        //operazioni sulle varianti
                        $varianti=$this->input->post("select_varianti");
                        $variantiprodotto=$prodotto->getArrayVarianti();
                        if(isset($varianti)){
                            
                            
                            
                            $obj_vars=array();
                            $obj_update=array();
                            if( count($varianti)>0 ){
                                
                                foreach($varianti as $codv=>$v){
                                    
                                    if(!multidimensional_search($variantiprodotto,
                                            array("codice_prodotto"=>$idprodotto,"variante"=>$codv))){
                                        
                                        $metodoprezzo=$this->input->post("metodo_prezzo_variante[$codv]");
                                        $obj_vars[]=array(
                                                "codice_prodotto"=>$idprodotto,
                                                "variante"=>$codv,
                                                "gruppo"=>"",
                                                "metodo_prezzo"=>$metodoprezzo
                                            );
                                            
                                    }else{
                                        $metodoprezzo=$this->input->post("metodo_prezzo_variante[$codv]");
                                        $obj_update[]=array(                                            
                                            "metodo_prezzo"=>$metodoprezzo,
                                            "variante"=>$codv
                                        );
                                    }
                                    
                                }
                                
                                if(count($obj_vars)>0){
                                    $this->db->insert_batch('lm_varianti_prodotto',$obj_vars);
                                }
                                if(count($obj_update)>0){
                                    $this->db->where('codice_prodotto',$idprodotto);
                                    $this->db->where('variante',$codv);
                                    $this->db->update_batch('lm_varianti_prodotto',$obj_update,'variante');
                                }
                            }
                        
                          
                        }
                         
                        if(count($variantiprodotto)>0){
                            foreach($variantiprodotto as $var_del=>$vd){

                                if(!isset($varianti[$vd["variante"]])){
                                    $this->db->where('idvariante',$vd["idvariante"]);
                                    $this->db->delete('lm_varianti_prodotto');
                                }


                            }
                        }
                            
                        //se il prodotto possiede già le stesse varianti
                        //aggiorno gli eventuali parametri nuovi
                        //--UPDATE
                        
                        
                        //se non risulta presente
                        //inserisco parametri
                        
                        //se ho saltato qualche variante, la elimino dalla lista
                        
                        //FINE

                }
                
                

                echo json_encode($data);
            }
          
          
            exit;
      }
      
      
      public function deletecategory($codice){
           if(!_is_logged()) redirect('/');
          
          $this->output->set_header('Content-Type: application/json; charset=utf-8');
          
          if($codice>0){
              $data["status"]=$this->modello_prodotti->removeCategoria($codice);
          }
          
           echo json_encode($data);
                
          exit;
          
      }
      
        
      public function events($p=null){
          if(!_is_logged()) redirect('/');
          
          $this->output->set_header('Content-Type: application/json; charset=utf-8');
          
          $data=array();
          $data["error_code"]=0;
          //$prodotto=null;
          $variante=null;
          $modello=null;
          
          $metodo_calcolo=$_REQUEST["metodo_calcolo"];
          
          
          if( isset($_REQUEST["profilo"]) OR  isset($_REQUEST["variante"]) ){
              
            //calcolo il costo del prodotto
              //$costo=_getCostiMisure($_GET["modello"],$_GET["larghezza"],$_GET["altezza"]);
              //
              $model=$_REQUEST["model"];
              
              $variante=$_REQUEST["variante"];
              
              $modelloprod=$this->modello_prodotti->get_id($model);
              $modelloprod=$modelloprod[0];
              
              if($model>0){
                $modello=$this->modello_prodotti->getCostiModello($model);
                if(count($modello)>0){
                    $modello=$modello[0];
                }
              }
              
              
              if($variante!="undefined" && $variante>0 ){
                  
                $variante=$this->modello_prodotti->getCostiModello($variante);
                if(count($variante)>0){
                    $variante=$variante[0];
                }
              }else{
                  $variante=null;
              }
              
              
              if( /*is_object($prodotto) &&*/ is_object($modello) ){

                //print_r($modelli);
                
                $w=$_REQUEST["larghezza"];//converto da mm in cm
                $h=$_REQUEST["altezza"];//---->
                
                //Richiede le misurazioni è un prodotto con le misure impostate
                $not_misure=(($modello->larghezza==0 && $modello->altezza)  )?true:false;
                
                if( ($w >= $modello->larghezza && $h >= $modello->altezza ) OR $not_misure OR $metodo_calcolo==3 ){

                    $data["variante"]=$variante;

                    $data["modello"]=$modello;
                    $data["costo_base"]=0;
                    
                    //mi calcola in metri q il costo del singolo oggetto...
                    
                    if($metodo_calcolo==1){
                        
                        $costo=getCostoMisura($w,$h,$modello->costo,$modello->min_fatt);
                        $data["costo_base"]=getCostoMisura($w,$h,$modelloprod->costi["costo"],$modelloprod->costi["costo_min_fatturabile"]);
                        
                    }else if($metodo_calcolo==2){
                        
                        $costo=(($w/100)*$modello->prezzo_m_lineare);
                        $data["costo_base"]=$modelloprod->costi["prezzo_m_lineare"];
                        
                        
                    }else if($metodo_calcolo==3){
                        
                        $costo=$modello->importo_unitario;
                        $data["costo_base"]=$modelloprod->costi["importo_unitario"];
                        
                        
                    }


                    //$sconto=$this->user->getSconti();
                    if( $this->user->getUserType()==2 ){

                        $prezzo_s=$this->user->get_incremento_listino($costo,$data);

                        if($prezzo_s>0){
                            $costo=$prezzo_s;
                        }
                      

                    }
                  
                  
                    if( isset($variante) && $variante!=null ){

                        if($variante->costo>0){
                            $costo+=(($costo*$variante->costo)/100);

                        }
                        if($variante->importo_unitario>0){
                            $costo+=($variante->importo_unitario);
                        }
                    }
                    
                    
                    
                    $data["costo"]= $costo;
                  
                  
                }else{
                  
                   
                    header("HTTP/1.0 500 Misura non consentita");

                    $data["costo"]=0;
                    $data["error_message"]="Attenzione! La misura è inferiore a qualla consentita"
                            . " LARG MIN: $modello->larghezza - Altezza MINIMA: $modello->altezza ";
                    $data["error_code"]=102;

                  
                }
                
              }else{
                  
                  header("HTTP/1.0 500 Modello non trovato! [".$_REQUEST["model"]."]! Errore interno! ");
                  
                  $data["error_code"]=100;
                  $data["costo"]=0;
              }
              
          }
          
          
          
          echo json_encode($data);
                
          exit;
      }
      
     
      public function seleziona_prodotto($categoria=null,$codice=NULL,$carrelloid=NULL){
          
         addCSS(array("public/bower_components/AdminLTE/plugins/iCheck/all.css",));
         addJS(array("public/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"));
         
         if(isset($_GET["cartitem"])){
            $carrelloid=$_GET["cartitem"];
         }
         
         if(isset($_GET["quoteitem"])){
            $pevid=$_GET["quoteitem"];
         }
         
         
         $data=array("PAGE_TITLE"=>"Configura prodotto",
            "SECTION_TITLE"=>$this->lang->line('configuratore_key'),
            "sezione"=>"dashboard-configura",
            "categoriabase"=>$categoria,
            "codicecategoria"=>$codice,
            "codicecarrello"=>$carrelloid,
            "MODAL"=>array(
                 "_MODALTITLE_"=>$this->lang->line('popup-prodotto-titolo'),
                 "_MODALID_"=>"modalcategoria",
                 "_MODALCLASS_"=>"mymodal_categoria",
                 "_MODALCONTENT_"=>"",
                 "_MODALVIEW_"=>array(
                     "file"=>"forms/form_categoria",
                     "data"=>null
                 )
            ),
            "datacarrello"=>null
         );
         
         if( isset($carrelloid) && $carrelloid!=NULL){
             
            if(isset($_SESSION["carrello"][$carrelloid])){
                
               $data["datacarrello"]=$_SESSION["carrello"][$carrelloid];
               addJS(array("public/js/configuratore-loader.js"));
               
            }else if( isset($pevid) ){
               
               $itemquote=$this->modello_preventivo->getPreventivoItem($pevid);
               $data["datapreventivo"]=$itemquote;
               $data["datacarrello"]=$itemquote;
                
               addJS(array("public/js/configuratore-loader.js"));
            }
            
         }
         
         if(!isset($_GET["ajaxmode"])){
            if( isset($categoria)){
               if($this->modello_prodotti->verificaCategoria($codice)){
                   
                  $this->parser->parse('configuratore',$data);
                  
               }else{
                   $this->parser->parse('errors/errore_categoria',$data);
               }
               
               
               
            }else{
                $this->parser->parse('seleziona_categoria',$data);
            }
         }else{
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
        
        
      
}