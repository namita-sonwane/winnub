/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
    
   
  
    if(carrellomap!=undefined){
        
        
        
        //seleziono il prodotto;
       
        $(".prodotto").each(function(k){
          
          if($(this).data("codice") == carrellomap.modello){
              
              $(this).addClass("active");
              if(stepstatus==0){
                    $("#step1").removeClass("hide");
                    /*$("#step2").removeClass("hide");*/
                    $("#boxprimary").removeClass("collapsed-box");
                    stepstatus++;
              }
              
              
              
              $("#calcolo_larghezza").val(carrellomap.larghezza);
              $("#calcolo_altezza").val(carrellomap.altezza);
              var altezza=parseFloat();
              var larghezza=parseFloat();
              
              $("#quantita").val(carrellomap.qty);
              
              loadProdotti(carrellomap.modello,
              
                function(){
                  //eseguo il callback dopo essesi caricate le varianti...
                  $.each(carrellomap.varianti,function(k){
                      
                      var cv=carrellomap.varianti[k].codice;
                      var checkvr=$("#tablevarianti").find("#htvar"+cv);
                      $(checkvr).iCheck('check');
                      console.log("--------->"+cv);
                  });
                  
                  
                });
              

              if(carrellomap.larghezza>0 && carrellomap.altezza>0 ){
                    controllaCosti(carrellomap.modello);
              }

          }
            
        });
    }
    
});