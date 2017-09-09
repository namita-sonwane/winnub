<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
        public function __construct(){

           parent::__construct();

           if( !_is_logged() ){
               header("location: ".base_url());
           }

           $this->load->library('parser');
           //$this->load->library('ReportSystem');
           $this->load->helper('date');

        }
      
      
        public function install(){

            echo "INSTALLAZIONE GUIDATA";


            exit;
        }
        
        
        public function salesJs($types=null){
            
            header("Content-type: application/json");
            
            $giorni =   365;
            
            if($types>0){
                $giorni =   $types;
            }
            
            
            $oggi   =   time();
            $fine   =   date($oggi);

            $statistiche=($this->user->getStatisticheVendite($giorni));//restituisce
            //print_r($statistiche);

            $statpreventivi=($this->user->getStatistichePreventivi($giorni));
            
            //visualizzazione per mese
            $datas=array(
                "labels"=>array(),
                "dataset"=>array()
            );

            
            
            $dater= date_range( date("Y-m-d",strtotime("-$giorni day")),date("Y-m-d"));
            $namem=array("Gen","Feb","Mar","Apr","Mag","Giu","Lug","Ago","Set","Ott","Nov","Dic");
            
            if(count($dater)){
                
                foreach($dater as $i=>$dat){
                    
                    if($giorni>=31){
                        
                        $data_p=$namem[(date("m",strtotime($dat))-1)];//il mese come stringa
                        $indice_p=(date("m-y",strtotime($dat)));
                       
                        $datas["labels"][$indice_p]=$data_p;
                        $datas["dataset"][0][$indice_p]=floatval($statistiche[$dat]["totale"])+$datas["dataset"][0][$indice_p];
                        
                        $datas["dataset"][1][$indice_p]=floatval($statpreventivi[$dat]["totale"])+$datas["dataset"][1][$indice_p];
                        
                        
                        
                    }else{
                        
                        
                         if( isset($statistiche[$dat]) ){

                            $datas["labels"][]=date("d/m/y",strtotime($dat));
                            $datas["dataset"][0][]=floatval($statistiche[$dat]["totale"]);
                            $datas["dataset"][1][]=floatval($statpreventivi[$dat]["totale"]);
                            

                        }else{
                            $datas["labels"][]=date("d/m/y",strtotime($dat));
                            $datas["dataset"][0][]=null;
                            $datas["dataset"][1][]=null;
                            
                        }
                    }

                }
            }
            
            
            echo json_encode($datas);
            
            exit;
            
        }
      
	public function index(){
         
                
                $data=array(
                    "PAGE_TITLE"=>t("titolo-welcome-index"),

                    "MODAL"=>array(
                        "_MODALTITLE_"=>$this->lang->line('popup-prodotto-titolo'),
                        "_MODALID_"=>"modalcategoria",
                        "_MODALCLASS_"=>"mymodal_categoria",
                        "_MODALCONTENT_"=>"",
                        "_MODALVIEW_"=>array(
                            "file"=>"forms/form_categoria",
                            "data"=>null
                        )
                    )
                );
                addCss(
                    array(
                        "//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.css",
                        "//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.print.css"
                    )
                );
                
                addJS(array(

                     "//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js",
                     "public/bower_components/AdminLTE/plugins/morris/morris.min.js",
                     "public/bower_components/AdminLTE/plugins/sparkline/jquery.sparkline.min.js",
                     "//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.js",
                     "public/js/dashboard.js",

                ));

                $this->parser->parse('dashboard',$data);
         
         
         
	}
        
        
     
      
        
      public function lista($nome=null){
          
         
         $data=array(
             "PAGE_TITLE"=>$this->lang->line('titolo_pagina_preventivi_key'),
             "NOME_SEZIONE_DESCRIZIONE"=>$this->lang->line('descrizione_pagina_preventivi_key'),
             "sezione"=>"dashboard-lista",
         );
         //addJS(array("public/bower_components/AdminLTE/dist/js/pages/dashboard2.js"));
         //$this->parser->('dashboard',$data);
         //addJS(array("public/js/dashboard2.js"));
         
         $this->parser->parse('tablelist',$data);
         
         
      }

     

        
        
      public function configura($categoria=null,$codice=NULL,$carrelloid=NULL){
          
         
         
         addCSS(array("public/bower_components/AdminLTE/plugins/iCheck/all.css",));
         addJS(array("public/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"));
         
         
         $data=array(
            "PAGE_TITLE"=>"Configura prodotto",
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
            )
         );
         
         if(!isset($_REQUEST["ajaxmode"])){
             
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
      
      
      
        
        
        
}