$(function () {

  'use strict';
  

$('input.checkstyle').iCheck({
  checkboxClass: 'iradiobox_flat',
  radioClass: 'iradio_minimal-red'
}); 
 

$('input').on('ifChecked', function(){
    
   var valore=parseFloat($("#s_totcart").val());
   //var spedizione=parseFloat($("#costo_spedizione").val());
   
   //valore+=spedizione;
   
   var valsel=parseInt($(this).val());
   
   valore=((valore * valsel )/100).toFixed(2);
  
   updateTotale();
    
    
});

$('input').on('ifUnchecked', function(){
    
    var valore=parseFloat($("#s_totcart").val());
    //var spedizione=$("#costo_spedizione").val();
   
    //valore+=spedizione;
   
    valore=((valore*22)/100).toFixed(2);
    
    $("#rigaiva").removeClass("evid");
   
    $("#rigaiva").html("\n\
        <td class='text-right'>IVA AL 22%</td>\n\
        <td>€ <span id='valiva'>"+valore+"</span><input type='hidden' id='valoreiva' name='valoreiva' value='"+valore+"'></td>\n\
     ");
    
    
    
    updateTotale();
});


  $(".updatecarrello").click(function(){
        event.preventDefault();
        
      
        var indice= $(this).data("indice");
        var valore=$("input[name='qty["+indice+"]']").val();
        
        //alert("Aggiorno ->"+indice+" con il valore: "+valore);
        //console.log($(this).val());
        
        var procedi=true;
        if(valore==0){
            
            procedi = confirm("Stai eliminando un prodotto dal carrello, vuoi continuare?");
        }
        
        if(procedi==true){
            $.ajax({ 
                type : "POST",
                //set the data type
                data: {"prif":indice,"valore":valore},
                dataType:'json',
                url: "/"+SITE_BASE_LANG+'/prodotti/updatecart', // target element(s) to be updated with server response 

                //check this in firefox browser
                success : function(response){ 

                    //alert(response);
                    window.location.reload();
                    
                },
                error: function(){
                    //alert("Error");//animazione di vibrazione finestra...

                }
            }); 
        }
        return false;
    });
});

function verificaDati(){
    
    
 
}

function sendConfigurazione(action,inputValue){
    
         var nomepreventivo="Modello Preventivo ";

         if(inputValue!==null){
             
            if (inputValue === false) return false;

            if (inputValue === "") {  
                return false;
            }else{  
                nomepreventivo=inputValue;
            }
            //conservo il nome del preventivo mettendolo nel 
            //form di salvataggio...
            var ipt=$("<input />")
              .attr("name",'titolopreventivo')
              .attr("value",nomepreventivo)
              .attr("type","hidden");   
            $("#form_carrello").append(ipt);
            
            
        }
         //
         //seleziono tutti gli editor della pagina
        $.each($(".editor_descrizione"),function(codice,elemento){
            var ideditor=$(this).attr("id");
            console.log("Editor-->"+ideditor);
            
            var forminpp=$("input[name='"+ideditor+"']");
            $(forminpp).val($(this).html());
            
         });
         
         $("input[name='mce_0']").val($("#mce_0").html());

         $.ajax({
                url: action,
                method:"post",
                data: $("#form_carrello").serialize()
         }).done(function(response){
                swal("OK", "Controlla i tuoi preventivi","success");
                window.location="/quote/all";
               //return  response;
         });
         
    
}

$(document).ready(function(){
    

   $(".buttonremoveitem").on("click",function(ev){
      
      ev.preventDefault();
      
      var rows=$(this).parent().parent();
      var links=$(this).attr("href");
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false,
        closeOnCancel: true
      },
      function(isConfirm){
          
          if (isConfirm) {
              
                swal("Deleted!", "L'elemento è stato elminato con successo", "success");
                $.post(links,function(resp){
                    $(rows).remove();
                    window.location.reload();
                });
          }

      });

      return false;
       
    });
 
   $("#savecart").bind("click",function(ev){
      
      ev.preventDefault();
      
      var action=$(this).attr("href");
      
      verificaDati();
     
      
      swal({   
          title: "Vuoi salvare il preventivo?",   
          text: "Dai un nome al tuo preventivo:",   
          type: "input",   
          showCancelButton: true,   
          closeOnConfirm: true,   
          animation: "slide-from-top",   
          inputPlaceholder: "Il mio Preventivo" 
      },function(inputValue){  
         
         sendConfigurazione(action,inputValue);
         
         
      });
       
      return false;
     
   });
   
   $("#update_cart").bind("click",function(ev){
      
      ev.preventDefault();
      
      var action=$(this).attr("href");
      
      
      swal({
        title: t("title-update-cart"),
        text:  t("text-update-cart"),
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: t("conferma"),
        closeOnConfirm: false
      },
      function(){

        sendConfigurazione(action,null);
        
      });

       
   });
   
   
   
    $("#inputcodclientes").select2({
       
        ajax:{
            type    : "GET",
            url: "/"+SITE_BASE_LANG+"/profile/me/clienti",
            dataType: 'json',
            delay: 250,
            data: function(params){
              return {
                q: params.term, // search term
                page: params.page
              };
            }, 
            processResults: function(data,params){
                //console.log(data);
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                
                return {
                  results: data.items,
                  pagination: {
                    more: (params.page * 30) < data.total_count
                  }
                };
                
            },
            cache: true
        },
        placeholder: "Select cliente",
        escapeMarkup:function(markup){return markup;}, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatoclienteSelection // omitted for brevity, see the source of this page
   });
   
  
    $("#searchservices input").on("keyup",function(a){
   
         //remote search term datatables
         var chiave=$(this).val();
         if(chiave.length>=3)
         {
             
           
            $.ajax({ 
                dataType: "json",
                url: "/"+SITE_BASE_LANG+"/profile/me/prodotti",
                data:{
                    'q':chiave
                },
                method:'get'
            }).done(function(results){
                
                //console.log(results.items);
                $("#contentResultA1").html("");
                //alert(results);
                $.each(results.items,function(k,obj){
                    
                     
                            console.log(obj);
                  
                   var riga_obj=obj;
                   var immagine=riga_obj.immagine; ///media/images/
                   
                   if(immagine==null){
                       immagine="/media/images/";
                   }
                   
                   var riga=$(riga_obj.html);
                   $("#contentResultA1").append(riga);
                    
                });
                
                
                $("#contentResultA1").ready(function(){
                    
                    $(".select-product-service").bind("click",function(e){
                        e.preventDefault();
                        
                        var mdr=$(this).parent().parent();
                        
                        var oggetto={
                            "modello"   :   $(this).data("modello"),
                            "altezza"   :   0,
                            "larghezza" :   0,
                            "quantita"  :   $(mdr).find("input[name='qty_modal']").val(),
                            "prezzo"    :   $(mdr).find("input[name='price_modal']").val(),
                            "detail"    :   $("#cod_carrello_tpx").val()
                        };
                        
                        $.post("/"+SITE_BASE_LANG+"/prodotti/insertcartelement",oggetto)
                        .done(function(dat){
                            $("#modalConfiguratore").modal('toggle');
                            window.location.reload();
                        });
                        
                        return false;
                    });
                });
                
            });
         }else{
              $("#contentResultA1").html("");
         }
     });
       
      
     $("#inputcodclientes").on("select2:select",selezioneCliente);
     
    
     $(".quantita_input").on("click",aggiornaQuantitaTable);
     $(".prezzi_input").on("change",aggiornaPrezziTable);
     
      
});

function aggiornaPrezziTable(){
    
    
    var elemento_chiamante=$(this);
    var valore=$(this).val();
    //moltiplico questo valore per il precedente
    //e il risultato il inserisco nel modulo successivo
    var costounitario   =  parseFloat($(elemento_chiamante).val());
    var unita   =          parseInt($(this).parent().parent().find(".quantita_input").val());
    var risultato       =  (parseFloat(costounitario*unita)).toFixed(2);
    
    $(this).parent().parent().find("td.dependent > span").text(risultato);
    
    //la differenza tra l'inizio e il valore finale
    var bvalue=parseFloat($("#tt-lab").find("span").text());
    var funzione=(bvalue-costounitario)+risultato;
    $("#tt-lab").find("span").text( parseFloat(funzione) );
    
}


function aggiornaQuantitaTable(){
    var elemento_chiamante=$(this);
    var valore=$(this).val();
    //moltiplico questo valore per il precedente
    //e il risultato il inserisco nel modulo successivo
    var costounitario   =  parseFloat($(this).parent().parent().find(".prezzi_input").val());
    var risultato       =      (parseFloat(costounitario*valore)).toFixed(2);
    
    $(this).parent().parent().find("td.dependent > span").text(risultato);
    //la differenza tra l'inizio e il valore finale
    var bvalue=parseFloat($("#tt-lab").find("span").text());
    var funzione=(bvalue-costounitario)+risultato;
    $("#tt-lab").find("span").text( parseFloat(funzione) );
    
}


function updateTotale(){
    
    var carrello    =   parseFloat($("#s_totcart").val()*1);
    // var numeroprod= parseFloat( $("#costo_spedizione").val()*1 );
    //var valsconto   =   parseFloat($("#scontistica").val()*1);
    var valsconto   =   0;
    var vsconto     =   parseFloat( (carrello*valsconto)/100 );
    
    var ivas        =   parseFloat( $("#valoreiva").val()*1 );
    
    var totale      =   parseFloat( (carrello) - vsconto ) + ivas;
    
    $("#totalecarrello1").val( (totale).toFixed(2) );
    
}



function formatRepo(repo){
    if (repo.id===null) return repo.text;
    var markup = "<span class='selcx' data-codice='"+repo.id+"'>";
    markup += repo.rag_sociale_cliente+" , "+repo.indirizzo+", ";
    markup += repo.PIVA+"</span>";
    
    repo.text=repo.rag_sociale_cliente;
   
    return markup;
}

function formatoclienteSelection(repo){
    
    return repo.text+"("+repo.id+")" || repo.id;
    
}

function selezioneCliente(e){
    
    //alert("Cliente : "+e.currentTarget.value);
    
    var oggetto=e.params.data;
    var id=oggetto.id;
    $("#inputrgs").val(oggetto.rag_sociale_cliente);
    $("#inputcl2").val(oggetto.indirizzo);
    $("#inputcl3").val(oggetto.comune);
    $("#inputcl4").val(oggetto.PIVA);
    $("#inputcl5").val(oggetto.cod_fiscale);
    $("#inputcl6").val(oggetto.email);
    
    $("#inputcodclientes").find("option").removeAttr("selected");
    $("#inputcodclientes").find("option[value="+id+"]").attr("selected","selected");
    
}


