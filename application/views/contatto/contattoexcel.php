<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//includo l'header
$this->view('limap/_header');


$this->view('limap/_sidebar');

?>

<style type="text/css">

.image-preview-input {
    position: relative;
  overflow: hidden;
  margin: 0px;    
    color: #333;
    background-color: #fff;
    border-color: #ccc;    
}
.image-preview-input input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  padding: 0;
  font-size: 20px;
  cursor: pointer;
  opacity: 0;
  filter: alpha(opacity=0);
}
.image-preview-input-title {
    margin-left:2px;
}

</style>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
     &nbsp;
      </h1>
      <?php get_breadcrumbs();?>
    </section>


        <!-- Main content -->
        
     <form class="form" action="/<?=getLanguage()?>/contatto/importexcel" method="post" name="upload_excel" enctype="multipart/form-data" >
             
    <section class="content">
        
        <div class="row">
            
            <div class="col-xs-12">
                
                <div class="panel panel-default">
                    
                  
                    
                    <div class="panel-body">
                        
                        
                          <?php if($this->session->flashdata('msg')){?>
                            <div class="alert alert-success">      
                              <?php echo $this->session->flashdata('msg')?>
                            </div>
                          <?php } ?>
                        
                        
                       
                           
                        <h4> Contatto Import XLS o CSV</h4>
                    
                    
                    <p><?=t("In questa sezione è possibile importare un file XLS o CSV. 
                    Attenzione la prima riga del tuo file deve contenere l'header con i nomi dei campi in modo che possano essere identificati. Il campo Nome è obbligatorio. ")?></p>
                    <p><?=t('Si consiglia di NON importare più di 400 righe per file poiché potrebbe risultare lenta la conferma d’importazione.')?></p>
                    <br>
                    <!-- <input type="file" name="file" id="file"  class="form-control" /> -->
                      <div class="btn btn-default image-preview-input">
                        <span class="glyphicon glyphicon-folder-open"></span>
                        <span class="image-preview-input-title">Choose File</span>
                       
                        <input type="file" accept="application/xls, application/xlsx, application/csv" name="file" id="file" class="form-control "/> <!-- rename it -->
                      </div>
                
                    </div>
                    
                    
                    <div class="panel-footer">
                        
                         <div class="form-group">
                            
                            <input type="hidden" name="codcontatto" value="<?=($contatto->codcontatto>0)?($contatto->codcontatto):0; ?>">
                            
                            <a class="btn btn-danger" href="/contatto"><?=t("Torna-indietro")?></a>
                            <button type="submit" class="btn btn-success" name="import" value="1"><?=t("Salva")?></button>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </section>
     </form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <script type="text/javascript">
      $.fn.datepicker.defaults.format = "mm/dd/yyyy";
$('.datepicker').datepicker({
    startDate: '-3d'
});


$(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview    
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");

    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });      
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
        }        
        reader.readAsDataURL(file);
    });  
});

  </script>
  

<?php
//includo l'header
$this->view('limap/_footer');