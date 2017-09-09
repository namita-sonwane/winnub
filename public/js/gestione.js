/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
  
    $("#tablex").DataTable();
    
    
    $('.list-group-sortable').sortable({
      placeholderClass: 'list-group-item'
    });
  
    $('.clickproduct').bind("click",function(){

        if(!$(this).hasClass("active")){
           $(this).addClass("active");

        }else{
           $(this).removeClass("active");

        }

        return false;
    });
  

    $("#saveproductmodel").submit(function(){
        
       
        $.post(
                $(this).attr("action"),
                $(this).serialize(),
                "json")
        .success(function(responce){
                     console.log(responce);
                     var responce=JSON.parse(responce);
                     //reseturl url for update information
                     if( responce.status == 1){
                         
                        $("#saveproductmodel").attr("action","/"+SITE_BASE_LANG+"/prodotti/save/"+responce.code);
                        
                            swal({ 
                                title: t("success"), 
                                text: t("prodotto-caricato"),  
                                type: "success",   
                                showCancelButton: false,  
                                closeOnConfirm: true 
                            }, function(){   
                               //
                               window.location="/"+SITE_BASE_LANG+"/prodotti/gestione";
                            });
                        
                     }
        }).fail(function(){
            swal({ 
                                title: t("errore"), 
                                text: t("verifica-dati-mancanti"),  
                                type: "error",   
                                showCancelButton: false,  
                                closeOnConfirm: true
                            }, function(){   
                               //
                            });
        });
        
        
        return false;
    });
    
   
   $('#uploadmodal').on('show.bs.modal', function (e) {
       // e.target // newly activated tab
       // e.relatedTarget // previous active tab
       
        
        var elf = $('#elfinder').elfinder({
                    lang: SITE_BASE_LANG,             // language (OPTIONAL)
                    url : '/'+SITE_BASE_LANG+'/media/elfinder'  // connector URL (REQUIRED),
                    ,
                    handlers : {
                        dblclick : function(event, elfinderInstance) {
                          event.preventDefault();
                           fileInfo = elfinderInstance.file(event.data.file);

                            if (fileInfo.mime != 'directory') {
                                //$("#editor").val(elfinderInstance.url(event.data.file));
                                //alert(elfinderInstance.url(event.data.file));
                                
                                //$("#anteprima").find(".img-responsive").attr("src",);
                                selectMedia(elfinderInstance.url(event.data.file));
                                elfinderInstance.destroy();
                                $("#uploadmodal").modal('hide');
                                //$('#elfinder').dialog('close');
                                return false; // stop elfinder
                            }
                    
                        }
                    },
            }).elfinder('instance');     
        
   });
   
   
   $(".listencarattere").change(function(){
       
      $("#rowvariante").show();
      var selected=$(this).filter(":selected").val();
      
      if( selected==="servizio" ){
          $("#rowvariante").hide();
      }else if( selected ==="variante"){
          $("#rowvariante").hide();
      }
      
       
   });

  
    
});

/** gestisce la libreria media**/
function reloadLibrary(num){
    
    if( $("#library").data("loadindex") === undefined ){
        $("#library").attr("data-loadindex",0);
    }
    
    if( $("#library").data("loadindex") < num ){
        
        $.ajax({
            url:"/"+SITE_BASE_LANG+"/media/library" ,
            dataType: "json"
        }).done(function( responce ) {
                    $("#library").data("loadindex",1);
            
                    $.each(responce,function(k,i){
                        console.log(i);
                        var img=$('<div class="mediagall"><img src="'+i.image+'" class="thumb "/></div>');
                        $("#library").append(img);
                    });

                    $(".mediagall").bind("click",function(){
                        var url=$(this).find("img").attr("src");
                        selectMedia(url);
                    });

         }).fail(function(){
             
         });
   }
}

function selectMedia(url){
    
    $("#uploadmodal").modal('hide');
    $("#anteprima").html("<img src='"+url+"' class='img-responsive' />\n\
<br/>\n\
<input type='hidden' name='immagineprodotto' value='"+url+"'>");
    
}
// Multiple images preview in browser
var imagesPreview = function(input, placeToInsertImagePreview) {

    if (input.files) {
        var filesAmount = input.files.length;

        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();

            reader.onload = function(event){

                $($.parseHTML('<img class=\"img-responsive\">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                //selectMedia(event.target.result);

            }

            reader.readAsDataURL(input.files[i]);
        }
    }

};

$(function() {
    

    $('#immagineprodotto').on('change', function() {
        
        
        imagesPreview(this,'#anteprima');
        
        $("#uploadmodal").modal('hide');
        
    });
    
    
      

});