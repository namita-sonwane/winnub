<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');



?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=_PROJECT_NAME_?> <small>media</small>
      </h1>
      <ol class="breadcrumb">
          <li class=""><a href="/dashboard">Dashboard</a></li>
        <li class="active">Media</li>
      </ol>
    </section>
    
  <section class="content">
        
        
        <div class="row">
            <div class="col-xs-12">
                <div id="elfinder"></div>
            </div>
             
        </div>
        <?php /*
        <div class="row">
            
            <div class="col-xs-3">
                
              <div class="box box-default">
                  <div class="box-title">
                      <h4>Risorse</h4>
                  </div>
                  <div class="box-body">
                        <ul class="list-unstyled" id="fileexplorer">
                            <li>
                                <a href="#" class="folder-link"><i class="fa fa-folder-o"></i>Private Document</a>
                                <ul class="list-data">
                                    
                                </ul>
                            </li>
                            <li><a href="#" class="folder-link"><i class="fa fa-folder-o"></i>Shared Document</a></li>
                        </ul>
                   </div>
                  
              </div>
            </div>
            <div class="col-xs-9">
                
                <div class="panel panel-default">
                    <div class="panel-header" style="padding-left: 22px;">
                        <br/>
                        <ul class="nav nav-pills">
                            <li role="presentation" class=""><a href="#" class="btn btn-default">Nuova cartella</a></li>
                            <li role="presentation"><a href="#" class="btn btn-default">Carica documento</a></li>
                            <li role="presentation"><a href="#" class="btn btn-default">Gestione</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <?php
                        //open default private document
                        $directory=$this->user->get_user_media_path();
                        $dir=opendir($this->user->get_user_media_path());
                        
                        while($d=readdir($dir)){
                            $fileimage="http://app.winnub.com/".$directory.$d;
                            echo "<div class='system-icon'>"
                            . "<a href='$fileimage' style=\"background-image: url('$fileimage');\"><span>".basename($fileimage)."</span></a>"
                                    . "</div>";
                        }
                        //print_r($files);
                        ?>
                    </div>
                </div>
            </div>
            
        </div>
        
        
    </section>

   
    <section class="content">
        
        <div class="row">
            
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-header">
                        <h3 class="">Carica media</h3>
                    </div>
                    <div class="panel-body">
                        
                        <?php echo $error;?>

                        <?php echo form_open_multipart('media/do_upload_media');?>

                        <input type="file" name="userfile" />

                        <br /><br />

                        <input type="submit" value="Carica" class="btn btn-default " />

                        </form>
                        
                        <hr/>
                        <div class="button-group filter-button-group">
                            <button data-filter="*">show all</button>
                            <button data-filter=".user">Personali</button>
                            <button data-filter=".shared">Pubbliche</button>
                            
                        </div>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                 <a href="#" class="btn btn-default loadmore"> Load More</a>
                            </div>
                           <hr/>
                        </div>
                        
                        <div class="grid" id="gridmedia">
                            <?php
                            
                        $files=$mediafile;
                        if( ($files)!=null){
                           foreach($files as $f){
                      ?>
                            <div class="grid-item <?=$f['class']?>">
                                
                                <a href="<?=$f["image"]?>" class='thumbnail modalimg' rel="media">
                                        <img src="<?=$f["image"]?>" class="img-responsive" />
                                </a>
                                
                            </div>
                                  
                                
                         <?php }
                            
                      }
                        ?>
                        </div>
                        
                     
                        
                    </div>
                
                </div>
            </div>
            
          
            
        
        </div>
        
        
    </section>*/?>

    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  
  
  <div>
      
  </div>

<?php
//includo l'header
$this->view('limap/_footer');

