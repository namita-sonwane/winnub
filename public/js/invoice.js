/* 
 * INVOICE SCRIPT
 * 
 */
function pulisciDati(){
    
    $.each($("#areacliente").find("input"),function(k,i){
        $(i).val();
    });
    
    $("#infocliente").html("");
    
} 

function decompilaForm(){
    
}

function compilaCliente(cliente){
        
            $("#infocliente").removeClass('hidden');
            $("#infocliente").html("");     
            
            /*
            
          
            
            $("#areacliente").find("input[name=ragione_sociale_cliente]").val(cliente.rag_sociale_cliente);
            
            $("#areacliente").find("input[name=p_iva_cliente]").val(cliente.p_iva_cliente);
            
            $("#areacliente").find("input[name=codice_ficale_cliente]").val(cliente.cod_fiscale);
            
            $("#areacliente").find("input[name=indirizzo_cliente]").val(cliente.indirizzo);
            
            $("#areacliente").find("input[name=cap_cliente]").val(cliente.cap);
           
            $("#areacliente").find("input[name=comune_cliente]").val(cliente.comune);
           
            $("#areacliente").find("input[name=provincia_cliente]").val(cliente.provincia);
           
            $("#areacliente").find("input[name=email_cliente]").val(cliente.email);
            
            $("#areacliente").removeClass('hidden');
            
    
            */
           
            $(".btnselect2c").removeClass("hidden");
            
            $("#areacliente").find("input[name=codicecliente]").val(cliente.codcliente);
            
            $("#infocliente").removeClass("hidden");
            
            //$("#infocliente").append("<p>"+cliente.codcliente+"</p>");
            $("#infocliente").append("<p>"+cliente.rag_sociale_cliente+"</p>");
            
            $("#infocliente").append("<p>"+cliente.p_iva_cliente+"</p>");
            $("#infocliente").append("<p>"+cliente.cod_fiscale+"</p>");
            $("#infocliente").append("<p>"+cliente.indirizzo+"</p>");
            $("#infocliente").append("<p>"+cliente.cap+"</p>");
            $("#infocliente").append("<p>"+cliente.comune+"</p>");
            $("#infocliente").append("<p>"+cliente.provincia+"</p>");
            $("#infocliente").append("<p>"+cliente.email+"</p>");
            
}


$(function(){
    /*
     * $.ajax( {
          url: "/"+SITE_BASE_LANG+"/profile/me/clienti",
          dataType: "jsonp",
          data: {
            q: request.term
          },
          success: function( data ) {
            response( data );
            
            
          }
        } );
     */
    
    
    var codc=$("#infocliente").attr("rel");
    if(codc>0){
        $.get("/"+SITE_BASE_LANG+"/clienti/getcliente/"+codc,function(resp){
            compilaCliente(resp);
        },"json");
    }
    
    $("#bloccointestazione").on("mouserhover",function(){
        
    });
    
    
    
    $(".saveCliente").click(function(e){
        e.preventDefault();
        
        var forms=$("#formsavecliente").serialize();
        $.ajax({
            method: "POST",
            dataType: 'json',
            url: $("#formsavecliente").attr("action"),
            data: forms
        }).done(function(res){
                compilaCliente(res.cliente);
                $('#modaladdcliente').modal('hide');
                $("#formsavecliente").find("input").val("");
        });
        
        
        return false;
        
    });
   
   
   $(".actionclient").click(function(e){
        
        e.preventDefault();
        
        var azione=$(this).data("rest");
        switch(azione){
            
            
            case "add":
                    
                    $('#modaladdcliente').modal();
            break;
            
            case 'removeselection':
                
                 $("#search_cliente").val("");
               
                 pulisciDati();
                 
                 $("#areacliente").addClass('hidden');
                 $(this).addClass("hidden");
                    
            break;
            
        }
        
        
        return false;
   });
    
    $('#search_cliente').autocomplete({
        serviceUrl:  "/"+SITE_BASE_LANG+"/profile/me/clienti?mode=2",
        paramName: 'q',
        onSelect: function (suggestion){
            
            pulisciDati();
            //alert('You selected: ' + suggestion.value +'');
            console.log(suggestion.data); 
            
            compilaCliente(suggestion.data);
            
            
          
        }
    });

            
    
    
    $("#savebtn").bind("click",function(e){
        
        e.preventDefault();
        
        
        tinymce.triggerSave();
       
        var forms=$("#form1").serialize();
       
        
        $.post("/"+SITE_BASE_LANG+"/invoice/saveInvoice",forms)
                 .done(function(responce){
           
            swal({ 
                   title: t("completato"), 
                   text: t("text-save-invoice"),  
                   type: "success",   
                   showCancelButton: true,  
                   closeOnConfirm: false,   
                   showLoaderOnConfirm: false,
                   html: true
               }, function(){
                  document.location="/invoice/all";
               });
           return false;
           
       },"json");
       
       
       
        return false;
    });
    
    
    $("#selezionepagamenti").change(function(e){
       e.preventDefault();
       
       var valore=$(this).find("option:selected").val();
       
       var urls="/"+SITE_BASE_LANG+"/profile/dettaglio-pagamenti/"+valore;
       $("#content-pagamento").html("");
       $("#content-pagamento").load(urls);
       
    });
    
    
    
    $(".addrow").bind("click",function(e){
       
       e.preventDefault();
       
       var nuovo_codice=$("#footerinvoice").find("input[name=newvalue_id]").val();
       var nuova_qty=$("#footerinvoice").find("input[name=newvalue_qty]").val();
       var textelement=$("#footerinvoice").find(".editable").html();
       var nuovo_price=$("#footerinvoice").find("input[name=newvalue_prezzo]").val();
       var nuova_imposta=$("#footerinvoice").find("input[name=newvalue_iva]").find("option:selcted").val();
       var is_servizio=($("#footerinvoice").find("input[name=newvalue_servizio]").is(':checked'))?"selezionato":"";
       
       var oggetto={
           "newitem":nuovo_codice,
           "qty":nuova_qty,
           "descrizione":textelement,
           "price":nuovo_price,
           "imposta":nuova_imposta,
           "invoicecode":$("#invoicecode").val(),
           "tipologiaservizio":is_servizio
       };
       
       $.post("/"+SITE_BASE_LANG+"/invoice/update",oggetto)
               .done(function(responce){
           if(responce.status>0){
               //window.location.reload();
               console.log(responce);
               
               var tr=$("<tr data-articleitem='"+responce.status+"' id=\"articl_"+responce.status+"\" />");
               $(tr).append("<td>"+responce.item.checkbox+"</td>");
               $(tr).append("<td>"+responce.item.cod_articolo+"</td>");
               $(tr).append("<td class=\"editable\">"+responce.item.descrizione+"</td>");
               $(tr).append("<td>"+responce.item.quantita+"</td>");
               $(tr).append("<td>"+responce.item.prezzo+"</td>");
               $(tr).append("<td>"+responce.item.iva+"</td>");
               $(tr).append("<td></td>");
               
               $("#tableelement").append(tr);
               
               if(responce.codice>0){
                   
                   window.location="/"+SITE_BASE_LANG+"/invoice/view/"+responce.codice;
                   
               }else{
                   window.location.reload();
               }
               
           }
       },"json");
       
       return false; 
    });
    
    
    $(".variant").change(function(){
        
    });
    
    
});


function ricalcola(){
    
}