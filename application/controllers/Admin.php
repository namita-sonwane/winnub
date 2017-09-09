<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
      public function __construct(){
        
        parent::__construct();
           
         if( !_is_logged() ){
             header("location: ".base_url());
         }
         
         
        
         
         $this->load->library('parser');
         $this->load->helper('date');
         
         addJS(array("public/js/settings.js"));
         
      }
      
      
      public function index(){
          
            if(!_is_logged()){ 
                
               header("location: ".base_url());
                
            }
            
            
      }
      
      
      public function languages($status=null){
          
          
           $file="impostazioni-lingua";
           $data=array(
                "PAGE_TITLE"=>t('Lingue winnub'),
                "SECTION_TITLE"=>t('language-settings'),
                "categoriabase"=>"menu-impostazioni",
                "sezione"=>"languages",

           );
           
           
           $this->parser->parse('admin/'.$file,$data);
          
           
          
      }
      
      
      
      public function impostazioni($section=null){
          
           if(!$this->user->isAdmin()){
              header("location: ".base_url());
         }
         
          
           $file="impostazioni";
           $data=array(
                "PAGE_TITLE"=>t('Impostazioni winnub'),
                "SECTION_TITLE"=>t('winnub-settings'),
                "categoriabase"=>"menu-impostazioni",
                "sezione"=>"settings",

           );
           $this->parser->parse('admin/'.$file,$data);
           
      }
      
        /**
         * Statistiche dell'utente sul network...
         * rilascia i dati
         * @param type $user
         */
        public function chartGlobal($user){
            
            $userb=$this->adminuser->getUserProfile($user);
            $q=" SELECT SUM(lm_fatture_generate.totale) as fatt_aziendale, "
                    . ""
                    . " (SELECT SUM(lm_fatture_generate.totale) "
                    . " FROM lm_fatture_generate JOIN lm_preventivo ON lm_preventivo.idpreventivo=lm_fatture_generate.preventivo "
                    . "  WHERE lm_preventivo.utente=?   "
                    . " ) as fatture_utente "
                    . ""
                    . "FROM lm_fatture_generate "
                . " WHERE lm_fatture_generate.utente IN (SELECT iduser FROM lm_users WHERE lm_users.owner=? ) "
                . "   ";
            $query=$this->db->query($q,array($user,$this->adminuser->owner));
            
            $datas=$query->result_array();
            
            
            
            $fatt_aziendale=$datas[0]["fatt_aziendale"];
            $fatt_utente=$datas[0]["fatture_utente"];
            
            $fatt_diverso=$fatt_aziendale-$fatt_utente;
            $datas=array();
            
            $datas[]=array(
                "value"=>number_format($fatt_aziendale,2,".",""),
                "color"=> "#f569A4",
                "highlight"=> "#f56954",
                "label"=> "Fatture Aziendali"
            );
            
            $datas[]=array(
                "value"=>number_format($fatt_utente,2,".",""),
                "color"=> "#f500a3",
                "highlight"=> "#f500a3",
                "label"=> "Fatture da Utente"
            );
            
            
            $datas[]=array(
                "value"=>number_format($fatt_diverso,2,".",""),
                "color"=> "#f500a3",
                "highlight"=> "#f500a3",
                "label"=> " Altri del network"
            );
            
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datas));
        }
      
      
        /*
         * 
         */
        public function salesJs($user=null){
            
            header("Content-type: application/json");
            
            $giorni =   365;
            
            $oggi   =   time();
            $fine   =   date($oggi);
            
            $userb=$this->adminuser->getUserProfile($user);
            
            //$statistiche=($userb->getStatisticheVendite($giorni));//restituisce
            //print_r($statistiche);
            
            $statpreventivi=($userb->getStatistichePreventivi($user,TRUE));
            
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
                        //$datas["dataset"][0][$indice_p]=floatval($statistiche[$dat]["totale"])+$datas["dataset"][0][$data_p];
                        
                        $datas["dataset"][0][$indice_p]=floatval($statpreventivi[$dat]["totale"])+$datas["dataset"][0][$data_p];
                        
                        
                        
                    }else{
                         if( isset($statistiche[$dat]) ){

                            $datas["labels"][]=date("d/m/y",strtotime($dat));
                            //$datas["dataset"][0][]=floatval($statistiche[$dat]["totale"]);
                            $datas["dataset"][0][]=floatval($statpreventivi[$dat]["totale"]);
                            

                        }else{
                            $datas["labels"][]=date("d/m/y",strtotime($dat));
                            //$datas["dataset"][0][]=null;
                            $datas["dataset"][0][]=null;
                        }
                    }

                }
            }
            
            
            echo json_encode($datas);
            
            exit;
            
        }
      


        public function gestione($sezione=null,$codice=null){
          
          
          $data=array();
          $file="default";
          
          //print_r($codice);
          
          switch($sezione){
             
              case "ordini":
                  
                  $file="ordini";
                  $data=array(
                      "PAGE_TITLE"=>"Configura ordine",
                      "SECTION_TITLE"=>t('configuratore_key'),
                      "categoriabase"=>"admin-gestione",
                      "sezione"=>"gestione-ordini",
                      "codiceordine"=>$codice
                   );
                      
              break;
              
              /*
              case "prodotti":
                  $file="prodotti";
                  $data=array(
                      "PAGE_TITLE"=>"Configura prodotto",
                      "SECTION_TITLE"=>t('configuratore_key'),
                      "categoriabase"=>"admin-gestione",
                      "sezione"=>"gestione-ordini",
                      "codiceprodotto"=>$codice
                   );
                  break;
              */
              case "impostazioni":
                  $file="default";
                  $data=array(
                      "PAGE_TITLE"=>t('Configurazioni winnub'),
                      "SECTION_TITLE"=>t('winnub-settings'),
                      "categoriabase"=>"admin-gestione",
                      "sezione"=>"gestione-ordini",
                      "codiceprodotto"=>$codice
                   );
              break;
              default:
                  $file="default";
                  $data=array(
                      "PAGE_TITLE"=>t('Configurazioni winnub'),
                      "SECTION_TITLE"=>t('winnub-settings'),
                      "categoriabase"=>"admin-gestione",
                      "sezione"=>"gestione-ordini",
                      "codiceprodotto"=>$codice
                   );
              break;
              
          }
         
         $this->parser->parse('admin/'.$file,$data);
         
      }
      
      
      public function pagamenti($azione,$codice){
          
      }
      
      public function tasse($azione,$codice){
          
      }
      
      public function settings_pagamenti($code){
          
          //header("Content-type: text/json");
          if($code>0){
            $modello=$this->azienda->getPayment($code);

            $data=array(
                "codice"=>$code,
                "modello"=>$modello
            );
          }else if($code=="new"){
            $modello=array(
                "ptype"=>"new",
                "campi"=>""
            );
            $data=array(
                "codice"=>0,
                "modello"=>$modello
            ); 
              
          }else{
              die("Error");
          }
          
          $this->parser->parse('admin/inc/editor_pagamenti',$data);
          
              
          
      }
      
      public function settings_tassazioni($code){
          //header("Content-type: text/json");
          if($code>0){
              
                $modello=$this->azienda->getTassazioni($code);

                $data=array(
                    "codice"=>$code,
                    "modello"=>$modello
                );
            
          }else if($code=="new"){
              
                $modello=array(
                    "ttype"=>"new",
                    
                );
                $data=array(
                    "codice"=>0,
                    "modello"=>$modello
                ); 
              
          }else{
                die("Error");
          }
          
          $this->parser->parse('admin/inc/editor_tassazioni',$data);
      }
      
      
      public function save_settings_tasse($p=null){
          
          $codice=intval($_REQUEST["ttype"]);
           
          //print_r($_REQUEST);
          
          $datitasse=array(
              "nome_tassazione"        =>  (strip_tags($_REQUEST["nome_tassazione"])),
              "descrizione" =>  addslashes(strip_tags($_REQUEST["descrizione"])),
              "aliquota"     => intval($_REQUEST["aliquota"]),
              "default"       =>  0
          );
          
         
          if($codice>0){
                $this->db->where('idTassazione',$codice);
                $this->db->update('lm_tassazioni',$datitasse); 
          }else if($codice=="new"){
              
              $datitasse["azienda"]=$this->azienda->codazienda;
              $this->db->insert('lm_tassazioni',$datitasse); 
              
          }
          
          
          //redirect("/admin/impostazioni");
      }
      
      public function save_settings_pagamenti($p=null){
          
          $codice=intval($_REQUEST["uptype"]);
          
          
          $fdata=$_REQUEST["fielddata"];
          
          $modello=$this->azienda->getPayment($codice);
          $modello=$modello[0];
          
          $oldfield=json_decode($modello["campi"]);
         
          
          $fields=array("field"=>array());
        
          //devo clonare il json
          //new label 
          if(count($oldfield->field)){
                $count=0;
                foreach($oldfield->field as $ff){
                    $fields["field"][]=array(
                        "id"=>$ff->id,
                        "name"=>$ff->name,
                        "value"=>$fdata[$ff->name],
                        "class"=>$ff->class,
                        "label"=>$ff->label
                    );
                    $count++;
                }
          }
          //new label 
          if(   !empty($_REQUEST["new_label"]) 
                  &&
                !empty($_REQUEST["new_name"]) 
                  &&
                !empty($_REQUEST["new_value"]) 
                  
                  ){
              
              $fields["field"][]=array(
                  "id"=>"cp".$count,
                  "name"=>$_REQUEST["new_name"],
                  "value"=>$_REQUEST["new_value"],
                  "class"=>"",
                  "label"=>$_REQUEST["new_label"]
              );
              
          }
          
          $datipagamento=array(
              "nome"        =>  url_title(strip_tags($_REQUEST["nome"])),
              "descrizione" =>  addslashes(strip_tags($_REQUEST["descrizione"])),
              "modello"     =>  null,
              "campi"       =>  json_encode($fields)
          );
          
         
          if($codice>0){
                $this->db->where('ptype',$codice);
                $this->db->update('lm_tipologie_pagamento',$datipagamento); 
          }else if($codice=="new"){
              
              $datipagamento["azienda"]=$this->user->owner;
              $this->db->insert('lm_tipologie_pagamento',$datipagamento); 
              
          }
          
          redirect("/admin/impostazioni");
      }
      
      
      
      public function saveprofile(){
          
          if(!$this->user->isAdmin()) header("location: /");
          
      }
      
      
      
}