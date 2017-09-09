/*
 * 
 */

$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event){
                    
                    $($.parseHTML('<img class=\"img-responsive\">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#immagineprofilo').on('change', function() {
        imagesPreview(this,'div.anteprima');
    });
    
    
    $('#immaginelogo').on('change', function() {
        $("div.anteprima_logo").html("");
        imagesPreview(this,'div.anteprima_logo');
    });
    
    
    
    
});

$(function(){
    
      
 
  
  
  $(".ascolta").on("change",function(e){
      
      e.preventDefault();
      
      var objp=$(this).attr("id");
      var codice=$(this).val();
      
      var destinazione=$(this).data("relay");
      
      $(objp).change(function(){
          var cap=$(this).find("option:selected").data("cap");
          $(document).find("input[name=cap]").val(cap);
      });
      console.log(destinazione);
      
      $.getJSON("getComuni/"+codice,{mode:"seach"},
         function(datas){
                
                $("#"+destinazione).find("option").remove();
                
                if( datas !== undefined){
                    
                  $.each( datas,function(key,value){
                      //console.log(value);
                      $('<option/>',{ 
                        value: value.id,
                        text: value.nome_comune,
                        "data-cap":value.cap
                      }).appendTo('#'+destinazione);
                      $(document).find("input[name=cap]").val("");
                  });
               }
               
               
            
            }
         );
      
      
      return true;
   });
    
    
   $("#formprofilo").validate({
        rules: {
            email: {
              required: true,
              email: true

            }
        },
        submitHandler: function(form){
            
            var formdata = new FormData(form);
            
            $.ajax({
                type: "POST",
                url: $(form).attr("action"),
                data: formdata,
                contentType: false,
                mimeTypes:"multipart/form-data",
                dataType:"JSON",
                cache: false,
                processData:false,
                success: function(responce){
                    if(responce.success === "true"){
                        swal(t("riuscito"), t("profile-riuscito-message"), "success");
                    }else{
                        swal(t("errore"), t("profile-errore-message"), "error");
                    }
                }
            });
            //form.submit();
            
            return false;
        }
   });
    
  

    
});


function salvatutto(){
    
    
   
}