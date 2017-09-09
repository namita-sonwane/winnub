/* 
 *  Application winnub script
 * 
 * @author: valerio zarba
 * @contact: webmaster [] winnub.com
 * 
 */

var totale_ordine=0;//il totale complessivo
var _totale_base_=0;//il valore del profilo
var _costi_=[];
var gestoreprodotti=null;
var stepstatus=0;
var variantiprodotti=[];
var configurazione={larghezza:0,altezza:0,varianti:[]};
var _costi_base_=[];
var metodocalcolo=0;

/*
 *  Aggiunge una nuova selezione alla sidebar widget nel pannello
 * @param {type} elemento
 * @param {type} nome
 * @param {type} costo
 * @param {type} descrizione
 * @returns {undefined}
 */

function add_selezione(elemento,nome,costo,descrizione){
    
   var box=$("<div id='box"+elemento+"'>"+
           "<div class='box-body'><h4>"+nome+
           "Costo <span class='label label-default'> € "+costo+"</span></h4>"+
           "<div>"+descrizione+"</div>"+
           "</div>"+"</div>").attr("class","box");
   
   $("#prodottipreconfigurati").html(box);
   
   
}
/*
 *  Elimina oggetto dalla selezione widget prodotto
 * @param {type} elemento
 * @returns {undefined}
 */
function remove_selezione(elemento){
   $("#box"+elemento).remove();
   
}

/* build table data */
function update_table( arr )
{        
    //ablevarianti.fnClearTable();
                                  
}


function stepProfile(step){
    
    swal(t("Installazione completata!"),"success");
    
}






$(function(){
    
    $('[data-toggle="tooltip"]').tooltip();
    
    
    $(".buttonremoveitem").on("click",function(){
       
       
        
    });
    
    
    $("select.codiceiva").change(function(){
        
    });
    
    //inizializzo l'oggetto di stato per il profilo personale
    //mi restituisce un valore sullo stato del profilo..
    
    $.get( "/"+SITE_BASE_LANG+"/profile/me/status", function( data ){
        
        var urls=window.location.pathname;
        
        if( typeof data  === "object"){
        
            if(data.scadenze.stato == "scaduto" ){
                $(".content-header").before("<div class='messagepy'>"+data.scadenze.messaggio+"</div>").slideDown();
            }
            if(data.notifiche.length>0){

                $.each(data.notifiche,function(k,not){
                    //console.log(not);

                    $.notify({
                        message: not.message
                    },{
                        type: not.type,
                        placement: {
                                from: "bottom",
                                align: "right"
                        },
                        timer: 1200,
                        delay: 5000,
                    });

                });

            }
        
        }
        
        //
        //console.log("Controllo status SU:"+urls);
        
        if( urls.indexOf("/profile") == -1 && 
            urls.indexOf("/profilo") == -1 ){//se per caso è la pagina profile o profilo
            
            if(data.status.valore < 50){
                
               
                swal({ 
                   title: t("benvenuto"), 
                   text: t("profilo-non-completo")+data.status.html,  
                   imageUrl: "https://app.winnub.com/public/img/logo-small.png",
                   showCancelButton: true,  
                   closeOnConfirm: false,   
                   showLoaderOnConfirm: false,
                   html: true
                }, function(){
                    
                    document.location="/profile";
                });
               
            }
            
            
            $("#screenface").css("background-image","url('/"+data.status.photo+"')");
            
        }
      
    },"json");
    
    
    
   //$("#modalformsLimap").
   $(".modallogindismiss").click(function(){
      $(".fullscreen").hide();
      $("#modalGuest").hide();
   });
   
   $('[data-toggle="popover"]').popover();
   
    
   
   $(".modalaction").bind("click",function(){
       
       var formelement=$(".modalact-wA2").find("form");
       
       $.post($(formelement).attr("action"),$(formelement).serialize(),function(){
           window.location.reload();
       });
       
       
       
       return false;
   });
   
   // controlla i cambiamenti di quantita
   $("#quantita").change(ricalcolaTotale);
   
   
   //classe ascolta per i cambiamenti dei prodotti
   $(".ascolta").change(function(){
       
        $("#guidamisurebox").hide();
       
        var modello=$(".prodotto.active").data("codice");
        
        if($(this).hasClass("error")){
            $(this).removeClass("error");//segnalo l'errore'
        }
        
        var altezza=parseFloat($("#calcolo_altezza").val());
        var larghezza=parseFloat($("#calcolo_altezza").val());
        var metodocalcolo=$("select[name=metodo_calcolo] option").filter(":selected").val();
        
        if( (altezza>0 && larghezza>0) || metodocalcolo==3 ){
            //controllaCosti(modello);
        }
        
        
        if( metodocalcolo == 2 ){
            $(".riga-misure").show();
            $(".riga-misure:first").hide();
        }else{
            $(".riga-misure").show();
            
        }
        
        
        if( metodocalcolo == 3){
             $(".riga-misure").hide();
        }
        
   });
    
   $("input.ascolta").bind("change",function(e){
       e.preventDefault();
       
       $("#guidamisurebox").hide();
      
       var modello=$(".prodotto.active").data("codice");
       
       var altezza=parseFloat($("#calcolo_altezza").val());
       var larghezza=parseFloat($("#calcolo_larghezza").val());
       var metodocalcolo=$("select[name=metodo_calcolo]").val();
        
        
       configurazione.altezza=altezza;
       configurazione.larghezza=larghezza;
        
        
       $("#listaconversioni").html("");

       if( (altezza>0 && larghezza>0) || metodocalcolo==1 ){
            
          $("#listaconversioni").append("<li>"+t("In centimetri:")+" "+(larghezza/10)+"cm X "+(altezza/10)+" cm </li>");
          $("#listaconversioni").append("<li>"+t("In metri:")+" "+(larghezza/1000)+"m X "+(altezza/1000)+" m </li>");
          $("#listaconversioni").append("<li>"+t("Area di:")+"  "+( (larghezza/1000)*(altezza/1000) ).toFixed(2)+" m<sup>2</sup> </li>");
          
          _costi_base_=[];
          
           loadProdotti(modello);
           
           controllaCosti(modello);
           
           $("#guidamisurebox").show();
           
           
       }
        
        
        
    });
    
    
    
    
    
    
    $(".prodotto").click(function(e){
        
        e.preventDefault();
        
        _costi_base_=[];
        
        $(".prodotto.active").removeClass("active");
        $(this).addClass("active");
        
        
        if(stepstatus==0){
            $("#step1").removeClass("hide");
            /*$("#step2").removeClass("hide");*/
            $("#boxprimary").removeClass("collapsed-box");
            stepstatus++;
            
        }
        
        var modello=$(this).data("codice");
        var mh=$(this).data("mh");
        var mw=$(this).data("mw");
        
        $("#calcolo_altezza").val(mh);
        $("#calcolo_larghezza").val(mw);
        
        //alert("Codice:"+modello);
        //controllaCosti(modello);

        loadProdotti(modello);
        
        var altezza=parseFloat($("#calcolo_altezza").val());
        var larghezza=parseFloat($("#calcolo_larghezza").val());
        
        if(altezza>0 && larghezza>0 ){
            //controllaCosti(modello);
        }
        
        $(document).scrollTo($("#st1"),800,{axis:'y'});
        
        
       
    });
     
    
    
    
    $("#addtocart").click(function(e){
        
        e.preventDefault();
        
        if($("form_preventivo").hasClass("formerrror")){
             $.notify({
                   type: 'warning',
                   message:t("verifica-dati")+response.error_message
             });
        }else{
            
           var modello=$(".prodotto.active").data("codice");
           var l=$("#calcolo_larghezza").val();
           var h=$("#calcolo_altezza").val();
                
                //console.log($(this).val());
           var procedo=false;
           var test=$("select.metodo_calcolo").find("option:selected").val();
           switch( parseInt(test) ){
               case 1:
                   if(l>0 && h>0){
                       
                       procedo=true;
                       
                   }else{
                        procedo=false;
                        $.notify({
                                type: 'danger',
                                message:t("measure not found")
                        });
                   }
               break;
               
               default:
                   
                    
                    procedo=true;
           }
           
           
           
           
           if( procedo ){
               
               
               //verifica del prezzo immesso
               var prezzo_a=$("#prezzo").val();
               var prezzo_sing=$("#prezzosingolo").val();
               var totales=parseFloat($("#totale").text());
               
               if( !(totales > 0) ){
                   
                   swal({
                    title: t("attenzione"),
                    text: t("errore-prezzo-zero"),
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: t("Inserisci importo")
                  },
                  function(inputValue){
                      
                    if (inputValue === false) return false;

                    if (inputValue === "") {
                      //swal.showInputError("You need to write something!");
                      return false;
                      
                    }
                        
                    //swal("Ok!", "Il totale di questo prodotto sarà: " + inputValue, "success");

                    $("#prezzosingolo").val(inputValue);

                    send_cart_form(modello);

                    
                  });
               }else{
                   send_cart_form(modello);
               }
               
               
                
           }
        
        }
        
        return false;
    });
    
    
   
    $('#modalformsWinnub').on('show.bs.modal', function (e) {
        // do something...
        var box= $(this).find(".modal-body");
        //console.log("Carico il carrello...");
        var pcode=$("#codicepreventivo").val();
        var pstring="";
        if(pcode !== undefined && pcode !== null ){
            var pstring="?qcode="+pcode;
        }
        $.get("/"+SITE_BASE_LANG+'/quote/getAjxCart'+pstring,function(data){
            //console.log(data);
           $(box).html(data.responce);
           
        },"JSON");
        
        
            
    });
    
    
   $("#loadermedia").bind("click",function(e){
        e.preventDefault();
        
        $("#mediafiles").find("media-image");
        
        return false;
   });

});

function send_cart_form(modello){
    
    $.ajax({ 
            type : "POST",
            //set the data type
            data: $("#form_preventivo").serialize()+"&modello="+modello,
            dataType:'json',
            url: "/"+SITE_BASE_LANG+'/prodotti/addtocart', // target element(s) to be updated with server response 

            //check this in firefox browser
            success : function(response){ 

                if( response.error ){

                    swal("Errore!",response.error,"error");

                }else{
                    //alert(response);
                    //$("#modalformsWinnub").modal("show");
                    swal({
                      title: t("success-send_cart_form"),
                      text: t("success-send_cart_form-text"),
                      html: true,
                      type: "success",
                      showConfirmButton: true,
                      showCancelButton: false
                    },function(isConfirm){
                        if (isConfirm){
                            if(response.pcode !== undefined){
                                 window.location="/"+SITE_BASE_LANG+"/quote/detail/"+response.pcode;
                            }else{
                                window.location="/"+SITE_BASE_LANG+"/quote/view?status=1";
                            }
                        }else{
                            
                        }
                                                
                    },"success");
                    
                }

            },
            error: function(){
                //alert("Error");//animazione di vibrazione finestra...
                 $.notify({
                    type: 'warning',
                    message: t("errore-send-cart")
                });
            }
    });
    
}

/**
 * Controlla costi prodotto selezionato
 * @param {int} modello
 * @param {int} variante
 * @param {function} _callback
 * @returns {Boolean}
 */
function controllaCosti(modello,variante,_callback){
    
    Event.preventDefault();
    
    remove_selezione("prodotto_base_01");
    
    
    $.ajax({ 
            type : "POST",
            //set the data type
            data: $("#form_preventivo").serialize()+'&model='+modello+"&variante="+variante,
            dataType:'json',
            url: "/"+SITE_BASE_LANG+'/prodotti/events',// target element(s) to be updated with server response 
            
            //check this in firefox browser
            success : function(response){ 
                
                //console.log(response); 
                //alert(response);
               
                if( response.error_code === 0){
                    
                        $("#errormessages").html("");

                        
                        
                        _totale_base_=parseFloat(response.costo);
                        if( _totale_base_ <=  0 ){

                             $.notify({
                                message: t("costi-prezzo-errato")
                            },{type: 'info'});

                        }
                        _costi_base_.push(response.costo_base);
                        
                        
                        if( response.modello!=null ){
                           
                            
                            add_selezione("prodotto_base_01",
                            response.modello.codice_interno,
                            response.costo_base,
                            response.modello.descrizione+"<img src='"+ response.modello.foto+"' class='img-responsive' />");
                            
                            
                            $("#infoselezione").html("\
        <h4>"+response.modello.descrizione+"</h4>\n\
        <p>"+response.modello.descrizione_tecnica+"</p>");
                            
                            
                            
                        }


                        $("#form_preventivo").removeClass("formerror");

                        $(".riga-misure").find("input").removeClass("error");//elimino ogni l'errore'

                    
                }else{
                    
                        _totale_base_=0;
                        _costi_base_=[];

                        $(".riga-misure").find("input").addClass("error");//segnalo l'errore'

                        if(response.error_message !== undefined){

                            $.notify({
                                message:" "+response.error_message+" "
                            },{type: 'danger'});

                            $("#form_preventivo").addClass("formerror");
                        }
                }
                
                ricalcolaTotale();
                
                return true;
            },
            error: function(response){
                
                   
                   $.notify({
                      message: t("attenzione")+response.statusText+"!"
                   },{ type: 'danger'});
                   
                   if(
                       $("#calcolo_larghezza").val()=="" || $("#calcolo_altezza").val()==""){
                       $(".riga-misure").find("input").addClass("error");//segnalo l'errore'
                       $('#calcolo_larghezza').tooltip('show');
                       $('#calcolo_altezza').tooltip('show');
                   }
                   
                   $("#form_preventivo").addClass("formerror");
               
            }
   }); 
   
   
   return false;
}




/**
 * 
 * @param {type} aggiungi
 * @returns {undefined}
 */
function ricalcolaTotale(aggiungi){
    
   
    var costi_agg=0;
    var numero_prodotti=parseInt($("#quantita").val());
    
    if(numero_prodotti === 0){
        numero_prodotti=1;
        $("#quantita").val(1);
    }
    
    if( aggiungi>0 && aggiungi !== NaN){
        _costi_.push(aggiungi);
    }
    
    //console.log(_costi_);
    
    var val;
    for (val in _costi_) {
        
        var valore=parseFloat(_costi_[val]);
        
        //console.log("COSTO:--->"+val+" prezzo:"+valore);
        
        if(valore !== NaN){
            
            //si tratta del calcolo di accessori...
            if( val>0 )
            {
                costi_agg+=parseFloat(_costi_[val]);
            }
            else
            {
                if( valore > 0 && valore !== NaN )
                {
                  costi_agg+=parseFloat( (valore*_totale_base_/100) );
                }
            }
        }
    }
    if( costi_agg>0 ){
        totale_ordine= (costi_agg+_totale_base_)*numero_prodotti;
    }else{
        totale_ordine= _totale_base_*numero_prodotti;
    }
    
    $("#prezzosingolo").val( parseFloat(_totale_base_+costi_agg) );
    
    $("#totale").text(totale_ordine.toFixed(2));
    $("#price").val(totale_ordine);
    
    
    var basec;
    var tt=0;
    for(basec in _costi_base_){
        var vc=parseFloat(_costi_base_[basec]);
        tt+=vc;
    }
    $("#costobase").text(tt);
    
}


function loadProdotti(modello,callbackfn){
  
    var box=$("#selezione_profilo_product");
    var tabellav=$("#tablevarianti");
    var l=$("#calcolo_larghezza").val();
    var h=$("#calcolo_altezza").val();
    
    $(box).html("<ul class='lista-profili varianti'></ul>");
    $(tabellav).find("tbody").remove();
    //$("#tablevarianti").ajax.url('/prodotti/variante/?modello='+modello).load();
    if(modello>0){
        
        $.ajax({ 
            type : "GET",
            //set the data type
            data: {
                "modello":modello,
                "w":l,
                "h":h
            },
            dataType:'json',
            url: "/"+SITE_BASE_LANG+'/prodotti/variante/', // target element(s) to be updated with server response 
            //check this in firefox browser
            success : function(response){ 

                if( response!=null){

                    $(tabellav).append("<tbody />");
                     var selectm="";
                        var selectf="";
                        
                    $.each(response.data,function(key,obj){
                        var prezzo=0;
                       
                        switch(obj.metodoprezzo){
                            case "misure":
                                prezzo=obj.prezzo_mq;
                                selectm="SELECTED";
                            break;
                            case "fisso":
                                prezzo=obj.prezzo_unitario;
                                selectf="SELECTED";
                            break;
                        }
                        var fotov="";
                        if(obj.foto!=null){
                             fotov="<img src='"+obj.foto+"' class='thumbnail' style='max-height: 64px;'>";
                        }else{
                            fotov="<img src='http://app.winnub.com/public/img/noimage.jpg' class='thumbnail no-foto' style='max-height: 64px;'>";
                        }
                        var riga=$("<tr class='varianti' \n\
    data-variante='"+obj.idProdotto+"'>\n\
    <td width='60'><input type='hidden' name='quantit_varianti["+obj.idProdotto+"]' class='form-control' value='1'></td>\n\
    <td>"+fotov+"</td>\n\
    <td>"+obj.nome+"</td>\n\
    <td>\n\
        <select name='prezzo_item["+obj.idProdotto+"]' class='ascoltas1' data-codes='"+obj.idProdotto+"'>\n\
            <option value='"+obj.prezzo_mq+"' "+selectm+">"+t("C-Misure")+"</option>\n\
            <option value='"+obj.prezzo_unitario+"' "+selectf+">"+t("C-Fisso")+"</option>\n\
        </select>\n\
    </td>\n\
    <td style=\"width: 90px;\"><input type='text' name='prezzovariante["+obj.idProdotto+"]' value='"+prezzo+"' class='' /></td>\n\
    <td><input id='htvar"+obj.idProdotto+"' type=\"checkbox\" name='varianti["+obj.idProdotto+"]' value='0' class='ascoltavariante stylcheck' \n\
data-codiceprod='"+obj.idProdotto+"' data-price='"+obj.prezzo_mq+"' data-calcolo='"+obj.metodoprezzo+"' ></td></tr>");
                        
                        $(tabellav).find("tbody").append(riga);

                        $(tabellav).DataTable();

                        $('.stylcheck').iCheck({
                           checkboxClass: 'icheckbox_flat-orange',
                           radioClass: 'iradio_flat-orange',
                           increaseArea: '20%' // optional
                        });
                    });

                    $(".ascoltas1").change(function(){
                        
                        var codice=$(this).data("codes");
                        var dest=$(this).parent().parent().find("input[name='prezzovariante["+codice+"]']");
                        
                        var quantita=$("#tablevarianti_wrapper").find("input[name='quantit_varianti["+codice+"']").val();
                        if(quantita<=0 || quantita === undefined){
                            quantita=1;
                        }//valore di quantita elementi
                        
                        var valore=($(this).find("option:SELECTED").val()  );
                        
                        $(dest).val(valore);
                        //alert(valore);
                        
                        $("#htvar"+codice).val(valore);
                        
                        //rivedo i costi
                        if($("#htvar"+codice).is(':checked')){
                            rimuoviVariante($("#htvar"+codice),codice);
                            aggiungoVariante($("#htvar"+codice),codice);
                        }
                    });
                    
                    // ifClicked è ottenuto dal javascript di iCheck.
                    $(".ascoltavariante").on("ifClicked",_evt_click_variante);
                    $('.ascoltavariante').on('ifChecked', function(event){
                        
                        var codice=$(this).data("codiceprod");
                        var dest=$(document).find("input[name='prezzovariante["+codice+"]']");
                        var valore=$(dest).val();
                        
                        
                        //console.log(dest);
                        
                        aggiungoVariante(this,codice);
                    });
                     $('.ascoltavariante').on('ifUnchecked', function(event){
                        
                        var codice=$(this).data("codiceprod");
                        var dest=$(document).find("input[name='prezzovariante["+codice+"]']");
                        var valore=$(dest).val();
                        //console.log(dest);
                        
                        rimuoviVariante(this,codice);
                    });
                    
                    
                    $("#step_prof").removeClass("hide").slideDown();
                    
                    
                    
                }else{

                }
                
                
            },
            error: function(){
                //alert("Error");//animazione di vibrazione finestra...

            }
       }); 
   }
   
   if( callbackfn && typeof callbackfn == "function"){
        callbackfn(modello);
     }
     
     return false;
}



function attiva_colori(){
    
    $("#colorsbox").removeClass("collapsed-box");
    $("#step3").removeClass("hide");
    $("#step3").show();
    
    $("#sel_prof").removeClass("hide");
    
}

/*Ricalcolo sulla variante
 * 
 * @param {type} event
 * @returns {undefined}
 */
function _evt_click_variante(modo){
    
    var codice=$(this).data("codiceprod");
    var dest=$("#tablevarianti_wrapper").find("input[name='prezzo_item["+codice+"]']");
    var valore=$(dest).find("option:SELECTED").val();
    //console.log("Costo accessorio:"+valore);
    var costos=valore;
    var cod=$(this).data("codice");
    var calcolo=$(this).data("calcolo");
    //$("#selezioneprofilo").val(profilo);
    //alert(codice+" - "+calcolo+" - "+costos);
    //aggiornaVariante(this,codice,calcolo,costos);
}



function aggiungoVariante(elemento,cod){
    
    var codice=cod;
    
    var dest=$("#tablevarianti_wrapper").find("input[name='prezzo_item["+codice+"]']");
    //aggiungo quantita
    
    
    var valore=$(dest).find("option:SELECTED").val();
    var calcolo=$(elemento).data("calcolo");
    var costos=valore*quantita;
    var input_form=elemento;
    
    //alert("Aggiungo costo...."+calcolo);
    switch(calcolo){

        case "misure":
            var misure=(configurazione.altezza/1000)*(configurazione.larghezza/1000);
            costos=parseFloat(misure*costos);
        break;
        case "fisso":
            costos = parseFloat(costos);
        break;
        case 'percentuale':
             costos = parseInt(costos);
        break;
        case 'lineare':
            
        break;
        
    }
    
    _costi_[cod]= parseFloat( $("input[name='prezzovariante["+codice+"]").val() );
    
    configurazione.varianti.push(cod);
    
    $(input_form).val(1);
        
    ricalcolaTotale();
}

function rimuoviVariante(elemento,cod){
    
    $(elemento).removeClass("active");
    var tmp;
    var _costtmp=[];
    if(_costi_.length>0){
        for( tmp in  _costi_){
            if( tmp!=cod ){
                _costtmp[tmp]=_costi_[tmp];
            }
        }
        _costi_=_costtmp;//riporto tutto all'inizio...
    } 
    
    ricalcolaTotale();
}

function aggiornaVariante(elemento,cod,calcolo,cost){
    
    var costos=cost;
    var input_form=elemento;
    var codice=cod;
    
    if( $(elemento).checked ){//il caso di rimuovere l'accessorio
        
       
        
        $(this).removeClass("active");
        var tmp;
        var _costtmp=[];
        if(_costi_.length>0){
            for( tmp in  _costi_){
                if( tmp!=codice ){
                    _costtmp[tmp]=_costi_[tmp];
                }
            }
            _costi_=_costtmp;//riporto tutto all'inizio...
        }
        
        remove_selezione(codice);
    }

    ricalcolaTotale();
 
}

/**
 * Aggiorno al click il profilo selezionato
 * @param {type} pf
 * @returns {undefined}
 */
function _evt_cambio_profilo(event){
    
        
    $(this).parent().find("li").removeClass("active");
    $(this).addClass("active");
    
    
    var profilo=$(this).data("profilo");
    var modello=$(".prodotto.active").data("codice");
    $("#selezioneprofilo").val(profilo);
        
    controllaCosti(modello,profilo)
    
    attiva_colori();
    
    if( !$("#row_accessori").hasClass("visibile") ){
      console.log("Profilo selezione...");
      $("#row_accessori").removeClass("hidden");
      $("#row_accessori").addClass("visibile");
    }
    
}


/**
 * 
 * FILE EXPLORER
 */
$(function(){
    
    $("#fileexplorer").ready(function(){
        
        
        
    });
    
   
});