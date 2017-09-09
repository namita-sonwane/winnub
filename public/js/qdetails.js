


$(document).ready(function(){
    
    $.get("/discussion-board/"+$("#refcode").val(),function(response){
        
        console.log(response);
        
        
        $.each(response.messages,function(k,obj){
            
            $("#discussion").append("<div class='box-discussion "+obj.class+" '><h6 class='info-user'>"+obj.mittente+" scrive:  </h6><p>"+obj.message+"</p></div>");
            
        });
        
        
    },"json");
    
    $("#formreply").submit(function(e){
        e.preventDefault();

        
        $.post( $(this).attr("action"),
                $(this).serialize(),
               function(resp){

                
                    console.log(resp);
                    
                
            },"json");


        return false;

    });
    
    


});
    