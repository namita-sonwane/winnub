<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="modal fade <?=$_MODALCLASS_?>" id="<?=$_MODALID_?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?=$_MODALTITLE_?></h4>
      </div>
        
      <div class="modal-body">
          
            <div class="modalact-wA2">
              

                <?php

                if(isset($_MODALCONTENT_) ){
                    echo $_MODALCONTENT_;
                }

                if(isset($_MODALVIEW_)){
                    $this->view($_MODALVIEW_["file"],$_MODALVIEW_["data"]);
                }

               ?>  
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary modalaction">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
