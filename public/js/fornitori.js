/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
   
    var table=$("#tablefornitori").dataTable();
    
    table.on( 'draw.dt',function(){
       loaddel();
    });
    
    
    
   
});


function loaddel(){
    
    
    
    $(".eliminafornitori").bind("click",function(e){
        e.preventDefault();
        var urls=$(this).attr("href");

        swal({
             title: t("Vuoi eliminare questo fornitori?"),
             text: t("L\'operazione di rimozione non è reversibile"),
             type: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: t("Si, elimina"),
             closeOnConfirm: false
           },
           function(){
                
                $.get(urls,
                    function(response)
                    {
                       if(response.status)
                       {
                           swal(t("Eliminato"),t("fornitori eliminato con successo"), "success");
						   location.reload();
                       }
                        else
                       {
                           swal(t("Errore"),t("Se l\'errore persiste contattare l\'amministrazione"), "error");
                       }
                    }
                ,"json");

        });


        return false;
     });
}

$(document).ready(function(){
    
      loaddel();
    
    
       $("#formsavefornitore").validate({
           
            invalidHandler: function(event, validator){
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();

                if (errors) {
                     swal({ 
                            title:t("errore"), 
                            text: t("verifica-dati-mancanti"),  
                            type: "danger"
                        });
                }else{

                }
            },
            submitHandler: function(form){
             
                $.post(
                $("#formsavefornitore").attr("action"),
                $("#formsavefornitore").serialize(), "JSON").done(function(result){
                    
                    if(result.status){
                            
                            swal({ 
                                title: "Updated", 
                                text: result.status.html,  
                                type: "success",   
                                showConfirmButton: true,  
                                closeOnConfirm: true

                            }, function(isConfirm){  

                                if(isConfirm){
                                    document.location="/fornitori/edit/"+result.id;
                                }
                               
                            });
                    }
                    
                    
                });
            
                return false;
            }
    });
    
    
    
});