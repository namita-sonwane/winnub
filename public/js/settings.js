/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
    
    
    $("#paymodal").on('loaded.bs.modal', function (e) {
  // do something...
       console.log(e);
       //$(e.target).removeData("bs.modal").find(".modal-content").empty();
       
        //$(e.target).removeData("bs.modal").find(".modal-content")
       $(e.target).find(".btnsave").on("click",function(){
          
          
           $.post();
       });
    });
    
    $("#paymodal").on('hidden.bs.modal', function (e){
        $(e.target).removeData("bs.modal").find(".modal-content").empty();
        
    });
    
    $("#tassemodal").on('loaded.bs.modal', function (e) {
  // do something...
       console.log(e);
       //$(e.target).removeData("bs.modal").find(".modal-content").empty();
       
        //$(e.target).removeData("bs.modal").find(".modal-content")
       $(e.target).find(".btnsave").on("click",function(){
          
           console.log("SAVE EVENT--->");
           
       });
    });
    
    $("#tassemodal").on('hidden.bs.modal', function (e){
        $(e.target).removeData("bs.modal").find(".modal-content").empty();
        
    });
    
    
});