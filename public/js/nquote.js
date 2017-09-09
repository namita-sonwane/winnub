/*
 * Nuew quote action events 
 * 
 * data-nolock="true"
*/
$(function(){
   
    $("a:not([data-nolock='true'])").bind("click",function(e){
        
        e.preventDefault();
        
        var action=$("#savecart").attr("href");

        verificaDati();
        
        
       
        swal({   
            title: t("title-save-quote"),   
            text: t("text-save-quote"),   
            type: "input",   
            showCancelButton: true,   
            closeOnConfirm: false,
            cancelButtonText: "Delete",
            animation: "slide-from-top", 
            allowEscapeKey: false,
            inputPlaceholder: t("placeholder-save-quote"),
            closeOnCancel: false
            
        },function(inputValue){  
           
            if (inputValue === false){
                
                swal({
                    title: t("title-elimina-preventivo"),
                    text: t("text-elimina-preventivo"),
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: t("confirm-elimina-preventivo"),
                    cancelButtonText: t("cancel-elimina-preventivo"),
                    closeOnConfirm: false,
                    closeOnCancel: true
                  },
                  function(isConfirm){
                    if (isConfirm) {
                     
                      $.post("/quote/vclear").done(function(responce){
                    
                            // window.location="/";
                            swal(t("cancellato!"), t("success-delete"), "success");
                            
                            window.location="/"+SITE_BASE_LANG+"/quote";

                         });
                    } else {
                        //ritorno al configuratore
                        //swal("Cancelled", "Your imaginary file is safe :)", "error");
                        
                    }
                 });
                
                
                
                
                
            }else{
           
                if (inputValue === "") {

                   swal.showInputError(t("errore-input-type"));

                   

                } else {

                   sendConfigurazione(action,inputValue);

                    //swal("Cancelled", "Your imaginary file is safe :)", "error");

                }

            }
           
        });
        
        if($(this).attr("href")==="/it/quote"){
            
            return true;
        }
        
        return false;
    
    });
    
});