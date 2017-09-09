<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
    
 <?php if( _is_logged() AND $simpleheder==false ): // solo se si è loggati ?>


<?php 
    //print_r($MODAL);
    
if(isset($MODAL)){
    $this->view("limap/popup",$MODAL);// chiama la funzione dlel'helper pe ri popup 
}


//show modal form in guest registration
if( $this->user->isGuest() ){ ?>

                <div id="modalGuest">
                    <div class="modal-body">
                        <form class="form form-horizontal">
                            
                            <h3>Registrati subito</h3>
                            <hr/>
                            <div class="form-group">
                            
                                <label class="col-sm-3">Nome</label>
                                <div class="col-sm-9">
                                     <input type="text" name="nomeaz" class="form-control" />
                                </div>

                            </div>
                             <div class="form-group">
                            
                                <label class="col-sm-3">Cognome</label>
                                <div class="col-sm-9">
                                     <input type="text" name="cognomeaz" class="form-control" />
                                </div>

                            </div>
                            <div class="form-group">
                            
                                    <label class="col-sm-3">E-mail</label>
                                    <div class="col-sm-9">
                                         <input type="text" name="email" class="form-control" />
                                    </div>

                            </div>
                            
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <input type="submit" name="saveaz" value="Salva" class="btn btn-default bg-green-gradient"/>
                                
                                    <input type="reset" name="ann" value="Annulla" class="btn btn-default btn-md modallogindismiss" />
                                </div>
                            </div>
                          
                        </form>
                    </div>
                </div>

<div class="fullscreen"></div>

<?php   } ?>

    




    <footer class="main-footer">
       
       
      <div class="pull-right hidden-xs">
        &copy; winnub.com  2017 (BETA) <b>Version</b> 0.0.1
      </div>
        <p><?php echo ($db["default"]["database"]);?></p>
    </footer>
    </div>
    
  
<?php endif;//fine del controllo loggati ?>
  
</div>
<!-- ./wrapper -->



<!-- start js file-->
<script src="/public/bower_components/jquery/dist/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="/public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/isotope-layout@3.0/dist/isotope.pkgd.js"></script>

<!-- altri file js -->
<?php _getJs() ?>



<?php if( _is_logged() AND $simpleheder==false ): // solo se si è loggati ?>

        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script type="text/javascript">
            
                tinymce.init({
                    selector: 'h2.editable',
                    inline: true,
                    toolbar: 'undo redo',
                    menubar: false
                });

                tinymce.init({
                    selector: '.editable',
                    inline: true,
                    plugins: [
                      'advlist autolink lists link image charmap print preview anchor',
                      'searchreplace visualblocks code',
                      'insertdatetime media table contextmenu paste'
                    ],
                    automatic_uploads: true,
                    file_picker_types: 'image',
                    paste_data_images: true,
                    convert_urls: false,

                    file_picker_callback: function(cb, value, meta) {
                        var input = document.createElement('input');
                        input.setAttribute('type', 'file');
                        input.setAttribute('accept', 'image/*');

                        // Note: In modern browsers input[type="file"] is functional without 
                        // even adding it to the DOM, but that might not be the case in some older
                        // or quirky browsers like IE, so you might want to add it to the DOM
                        // just in case, and visually hide it. And do not forget do remove it
                        // once you do not need it anymore.

                        input.onchange = function() {
                          var file = this.files[0];

                          // Note: Now we need to register the blob in TinyMCEs image blob
                          // registry. In the next release this part hopefully won't be
                          // necessary, as we are looking to handle it internally.
                          var id = 'blobid' + (new Date()).getTime();
                          var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                          var blobInfo = blobCache.create(id, file);
                          blobCache.add(blobInfo);

                          // call the callback and populate the Title field with the file name
                          cb(blobInfo.blobUri(), { title: file.name });
                    };

                    input.click();
                    },
                    images_upload_url: "/"+SITE_BASE_LANG+'/media/upload_editor',
                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',

                    images_upload_handler: function (blobInfo, success, failure) {
                        var xhr, formData;

                        xhr = new XMLHttpRequest();
                        xhr.withCredentials = false;
                        xhr.open('POST', "/"+SITE_BASE_LANG+'/media/upload_editor');

                        xhr.onload = function() {
                          var json;

                          if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                          }

                          json = JSON.parse(xhr.responseText);

                          if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                          }

                          success(json.location);
                        };

                        formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());

                        xhr.send(formData);
                    }
                });
     </script>

     <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
     
<?php endif;?>

</body>
</html>