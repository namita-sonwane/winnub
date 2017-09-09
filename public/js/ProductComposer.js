/* 
 * 
 */

var Product=function(jsondata){
   
   var obj={
        larghezza:"",
        altezza:"",
        modello:"",
        quantita:"", 
        prezzo:"",
        type:""
   };
   
   if(jsondata !== undefined ){

          obj.altezza=jsondata.altezza;
          obj.larghezza=jsondata.larghezza;
          obj.modello=jsondata.modello;
          obj.prezzo=jsondata.price;
          obj.colore=jsondata.colore;
          obj.quantita=jsondata.qty;
          
   }

   
   obj.getCosto=function(){
       var costo_colore="";
       return obj.quantita*obj.prezzo;
   }
   
   obj.toString=function(){
      return  JSON.stringify(obj); 
   }
   
   
   
   return obj;
}


/**
 *  Preleva lo stato di un prodotto dalla sessione personale 
 *  da json
 * @type @new;_L16
 */
var ProductComposer=function(configuration){
    
   var prodotti=[];
   
   var composer = {};
   
   composer.addProdotto = function(prod){
       this.prodotti.push(prod);
       
   };
    
   composer.parseProduct = function(datap){
            
            if(datap!=null){
                
                $.each(datap,function(k,val){
                    var p=new Product(val);
                    
                    composer.addProdotto(p);
                    //console.log("CARRELLO: "+p);
                })
                
            }
            
   } 
   
   composer.loadProduct=function(commandstring){
       
       
       var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this);
                prodotti.push(this);
                
                return this.data;
            }
        };
        
        xmlhttp.open("GET",commandstring, true);
        xmlhttp.send();
       
   }
   
   return composer;
};




function loadCarrello(){
    
    gestoreprodotti=new ProductComposer();
    var prod=gestoreprodotti.loadProduct("/"+SITE_BASE_LANG+"/ajx_carrello");
    
    console.log(prod);
   
}


$(function(){
    
  
     //insert all your ajax callback code here. 
     //Which will run only after page is fully loaded in background.
     loadCarrello();
     
     
     
     $("#tabella_varianti").ready(function(){
        $('#tabella_varianti').DataTable({fixedHeader: true});
     });
     
     
});