/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var spacestatus=true;//lo spazio di lavoro... non va e cominciamo bene...
//ma lo voglo verificare per accertatmi che tutto può  andare al meglio
//bisogna essere positivi nella vita!
//quindi...
function checkFormIntegrity()
{
    
    if(!spacestatus){
         return false;
    }
    
    if($("#emailc").val()===""){
        $("#emailc").addClass("error");
        return false;
    }else{
        $("#emailc").removeClass("error");
    }
    
    
    return true;
}

$(function(){
    
   
   $("#emailc").bind("change",function(){
      
       
       $.get("/"+SITE_BASE_LANG+"/userext",{"typed":$(this).val()},
       function(results){
           
           console.log(results);
           
           if(results.status==="true"){
               $("#emailc").addClass("error");
               spacestatus=false;
           }else{
               $("#emailc").removeClass("error");
               spacestatus=true;
           }
           
       },"JSON");
       
       
       
   });
   
   
   $("#formaddus").submit(function(){
      
      if(checkFormIntegrity()){
          
          $.post(
                $(this).attr("action"),
                $(this).serialize(),
                function(resp){
              
                    //console.log(resp);
                     swal({ 
                                title: t("Inviato"), 
                                text: t("Email d'invito inviata con successo!"),  
                                type: "success",   
                                showConfirmButton: true,  
                                closeOnConfirm: true

                            }, function(isConfirm){  

                                if(isConfirm){
                                    document.location="/dashboard";
                                }
                               
                            });
                    
                }
          ,"JSON");
          
        }
      
      return false;
       
   });
   
    
});