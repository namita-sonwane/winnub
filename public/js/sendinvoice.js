/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
   
    
    $("#form_send_invoice").submit(function(e){
        e.preventDefault();
        
        $.post(
        $(this).attr("action"),
        $(this).serialize())
        .done(function(result){
            
            console.log(result);
            
            if( result.status==true ){
                
                swal(t("inviato"), t("messaggio-inviato"), "success");
                
                $("#itemsend").append("\
                        <li class=\"list-group-item\">"+result.obj.oggetto+"\
                        <span class=\"label label-default\">"+"</span> spedito a \n\
                                <span class=\"label label-default\">"+result.obj.email_destinatario+"</span> <br/>\n\
                        in data <span class=\"label label-default\">"+result.obj.data_invio+"</span>\n\
                        </li>");
                        
               
            }else{
                swal(t("errore"), t(result.message), "error");
            }
            
        });
        

        return false;
    });

    
});