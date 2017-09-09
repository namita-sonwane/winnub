<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller {
    
    
    public function __construct(){
        
         parent::__construct();
         
         $this->load->helper(array('form', 'url','html'));
         
         $this->load->library('parser');
         
         
         //if(!$this->user->isAdmin()) header("location: /dashboard");
         
              
        
         addCSS(array(
                "public/js/fancybox/jquery.fancybox.css",
         ));
         
         addJs(array(
                
                "public/js/fancybox/jquery.fancybox.pack.js",
                "//npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js",
               // "//cdnjs.cloudflare.com/ajax/libs/require.js/2.3.2/require.min.js",
            
         ));
         
      }
      
      
      /**
       * Mi restituisce le immagini presenti in directory personale
       * o se settato name l'immagine selezionata
       * @param type $name
       */
      public function images($img_name=null){
          
          $userpath=$this->user->check_image_path();
          
          if(empty($img_name) || $img_name=="null"){
              
              echo file_get_contents("/public/image/noimage.jpg");
              
          }else if($userpath!=""){
              
                
                $immagine = $userpath.$img_name;
                echo file_get_contents($immagine);
                
          }
          
         
          exit;
        
      }
      
      public function elfinder(){
          
          
           $this->load->helper('path');
           
           $userpath=$this->user->check_image_path();
           
           $sharedpath="public/downloads/shared/";
           
            $opts = array(
                'debug' => false, 
                
                'roots' => array(
                   
                    array( 
                        'tmbCrop'    => false,
                        
                        'driver' => 'LocalFileSystem', 
                        'alias' => 'WinnubShared',
                        'path'   => set_realpath($sharedpath), 
                        'URL'    => ("/$sharedpath").'',
                        'uploadDeny' => array('all'), ///# allow any images
                        'defaults'   => array('read' => true, 'write' => false),
                        'accessControl' => 'access' , 
                        'attributes' => array(
                            array(// hide anything else
                                'pattern' => '!^/exportForms!',
                                'hidden' => true
                            )
                        ),
                      // more elFinder options here
                        "tmbSize"=> 500
                        
                    ),
                    array( 
                        'tmbCrop'    => false,
                        
                        'alias' => 'Private Driver',
                        'driver' => 'LocalFileSystem', 
                        'path'   => set_realpath($userpath), 
                        'URL'    => ("/$userpath").'',
                        'accessControl' => 'access' , 
                        'attributes' => array(
                            array(// hide anything else
                                'pattern' => '!^/exportForms!',
                                'hidden' => true
                            )
                        )
                      // more elFinder options here
                        ,"tmbSize"=> 500
                        
                    ),
                    
               
              )
                
            );
            $this->load->library('elfinder_lib', $opts);
            
            
           
           //$this->parser->parse('media',$data);
      }
      
      
      public function index(){
          
           if(!$this->user->isLogged()) redirect("/");
          
           $this->load->helper('path');
           $media=array_slice($this->user->get_user_media_file(),0,12);
           
           $data=array(
                      "PAGE_TITLE"=>"media",
                      "SECTION_TITLE"=>t('media_page'),
                      "categoriabase"=>"media",
                      "sezione"=>"media-index",
                      "error"=>"",
                      "mediafile"=>$media
           );
           
           
           
           
           
           /* $opts = array(
              //'debug' => true, 
              'roots' => array(
                array( 
                  'driver' => 'LocalFileSystem', 
                  'path'   => set_realpath('public/downloads/'), 
                  'URL'    => site_url('public/downloads/') . '/'// more elFinder options here
                ) 
              )
            );
            $this->load->library('elfinder_lib', $opts);
  */
            addJs(array(
                
                "public/js/elfinder/js/elfinder.min.js",
                "public/js/media.js",	
                
             ));
            addCSS(array(
                "//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css",
                
                "public/css/elfinder/css/elfinder.min.css",
                "public/css/elfinder/css/winnubtheme.css",
                
            ));
        
            
            
      // $this->_HEADER_HTML_="<script data-main=\"/public/css/elfinder/css/main.default.js\" src=\"//cdnjs.cloudflare.com/ajax/libs/require.js/2.3.2/require.min.js\"></script>";
            
           $this->parser->parse('media',$data);
          
           
          
      }
      
      
      public function shared($file=null){
            
            //print_r($file);
            
            $config['source_image'] = "public/downloads/shared/".$file;
            $config['create_thumb'] = false;
            
            $config["dynamic_output"]=TRUE;

            $this->load->library('image_lib', $config);

            
            
            if ( ! $this->image_lib->resize() )
            {
                echo $this->image_lib->display_errors();
            }
            
      }
      
      
      public function resize($w,$h,$file){

          
          
      }
      
      
      public function next($pagina=0,$limit=12){
          
           header("content-type: text/json");
           
           $media=$this->user->get_user_media_file();
           $media=array_slice($media,($pagina*$limit),$limit);
           
           
           echo json_encode($media);
           exit;
      }
      
      
      public function library($pagina=0){
          
          $this->next($pagina);
          exit;
      }



        public function do_upload_media(){
          
            if(isset($this->user)){
                    $config['upload_path']          = $this->user->check_image_path();
                    $config['allowed_types']        = 'gif|jpg|png';
                    $config['max_size']             = 300;
                    $config['max_width']            = 1600;
                    $config['max_height']           = 1600;

                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload('userfile'))
                    {
                             $error = array('error' => $this->upload->display_errors());

                             $this->load->view('media', $error);
                    }else{
                             $data = array('upload_data' => $this->upload->data());

                             $this->load->view('media', $data);
                    }
            }
        }
        
         public function upload_editor(){
            
            header("Content-type:text/json");
             
            if(isset($this->user)){
                    $path=$this->user->check_image_path();
                    $config['upload_path']          = $path;
                    $config['allowed_types']        = 'gif|jpg|png';
                    $config['max_size']             = 300;
                    $config['max_width']            = 1600;
                    $config['max_height']           = 1600;

                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload('file'))
                    {
                        header("HTTP/1.0 500 File Type Error");
                             $data = array('error' => $this->upload->display_errors());
                    }else{
                         header("content-type: text/json");
                             $datas=$this->upload->data();
                             $data = array('upload_data' => $datas,
                                 "location"=>"http://app.winnub.com/$path".$datas["file_name"]
                             );
                             
                    }
            }
            
           
            echo json_encode($data);
            
            exit;
            
        }
      
      
      
      

      
      
}