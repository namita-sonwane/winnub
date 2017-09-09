/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
   
    var table=$("#tablerfqs").dataTable();
    
    table.on( 'draw.dt',function(){
       loaddel();
    });
    
    
    
   
});


function loaddel(){
    
    
    
    $(".eliminarfqs").bind("click",function(e){
        e.preventDefault();
        var urls=$(this).attr("href");

        swal({
             title: t("Vuoi eliminare questo rfqs?"),
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
						   
                           swal(t("Eliminato"),t("Rfq eliminato con successo"), "success");
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
    
});