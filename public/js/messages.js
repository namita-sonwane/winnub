

$(function(){
    
    
    $(".messageremove").on("click",function(e){
        e.preventDefault();
        
    
            $.get(
                $(this).attr("href"),
                function(resp){
                    
                    console.log(resp);
                    if(resp.status){
                        
                            swal({ 
                                title: t("Eliminato"), 
                                text: t("Messaggio eliminato con successo"),  
                                type: "success",   
                                showConfirmButton: true,  
                                closeOnConfirm: true

                            }, function(isConfirm){  

                                if(isConfirm){
                                    document.location.reload();
                                }
                               
                            });
                    }
                    
                }
          ,"JSON");
          
          return false;
          
    });
});