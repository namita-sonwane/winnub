/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function recalculate(valore){
    
    //alert(valore);
    
    
    
}


$(function(){
    
    
    
    $("button.addplan").click(function(){
        
        var azione=$(this).data("ajax");
        var destinazione=$(this).data("container");
        
        $(destinazione).load(azione,function(){
            
            $(destinazione).ready(function(){
                
                $(".planmonth").change(function(){
                   
                   var valore=$(this).filter(":selected").val();
                    
                });
                
                $("#confirm2").click(function(){
                    
                    alert("Ciao");
                    $("#formft").validate({
                        submitHandler: function(form) {
                          $(form).ajaxSubmit();
                        }
                      });

                    return false;
                });
                
            });
            
        });
        
        
        
    });
    
    $(".planmonth").change(function(e){
        
        e.preventDefault();
        
        recalculate($(this).find("option:selected").val());
        
        
    });
    
    $(".paymethod").change(function(e){
       e.preventDefault();
       
       $.ajax({
            type: "POST",
            url:"/"+SITE_BASE_LANG+"/profile/paymentconfirm/"+$(this).find("option:selected").val(),
            data:{'planref':$("#baseplan").val(),'durata':$("#planmonth").find("option:selected").val()},
            success: function(result){
                
                $("#payout").html(result.resp)
                console.log(result);
                
            },
            dataType:'JSON'
        });
        
        
    });
    
    
});