/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
   
    
    $("#form_carrello").submit(function(e){
        e.preventDefault();
        
        $.post(
        $(this).attr("action"),
        $(this).serialize())
        .done(function(result){
            
            console.log(result);
            
            if( result.status==true ){
                
                window.location.href="#tsend";
                window.location.reload();
                
            }else{
                swal(t("errore"), t(result.message), "error");
            }
            
        });

        return false;
    });
    
    if (location.hash === "#tsend") {
       swal(t("inviato"), t("messaggio-inviato"), "success");
    }

    
    
});