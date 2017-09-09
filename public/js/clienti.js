/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
   
    var table=$("#tableclienti").dataTable();
    
    table.on( 'draw.dt',function(){
       loaddel();
    });
    
    
    
   
});


function loaddel(){
    
    
    $(".eliminacliente").bind("click",function(e){
        e.preventDefault();

        var urls=$(this).attr("href");

        swal({
             title: t("Vuoi eliminare questo cliente?"),
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
                           swal(t("Eliminato"),t("Cliente eliminato con successo"), "success");
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
    
    
       $("#formsavecliente").validate({
           
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
                $("#formsavecliente").attr("action"),
                $("#formsavecliente").serialize(), "JSON").done(function(result){
                    
                    if(result.status){
                            
                            swal({ 
                                title: "Updated", 
                                text: result.status.html,  
                                type: "success",   
                                showConfirmButton: true,  
                                closeOnConfirm: true

                            }, function(isConfirm){  

                                if(isConfirm){
                                    document.location="/clienti/edit/"+result.id;
                                }
                               
                            });
                    }
                    
                    
                });
            
                return false;
            }
    });
    
    
    
});