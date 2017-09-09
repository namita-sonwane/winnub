/* +++
 * 
 * Gestione della categoria
 */



$(document).ready(function(){
    
    
    
    
    
    $('#modalcategoria').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var codice = button.data('code'); // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this);
      modal.find('#codicecategoria').val(codice);

      modal.find("#nomeCategoria").val(button.data("nome"));
      modal.find("#nomeCategoria").val(button.data("nome"));
      modal.find("#descrizionecategoria").val(button.data("descrizione"));


    });


    $(".column").sortable({
        items :'.boxcat',
        connectWith: ".column",
        handle: ".boxcat-header",
        cancel: ".boxcat-toggle",
        placeholder: "portlet-placeholder ui-corner-all",
        stop:function(){
            alert("Stop!");
        }
   });
 

    $(".column").bind( "sortupdate", function(event, ui) {
        var elemento=$(ui.item).data("codice");
        var sposta=$(ui.item.parent()).data("grupid");

      
        //all update
        $.ajax({
            url:"/"+SITE_BASE_LANG+"/prodotti/updatect",
            data:{"category":elemento,"in":sposta}
        }).done(function(rsp){
            console.log(rsp);
        });


    });

 
    $(".boxcat").addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
    .find(".boxcat-header")
    .addClass( "ui-widget-header ui-corner-all");
    
    
 
    $( ".boxcat-toggle" ).on( "click", function() {
      var icon = $( this );
      icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
      icon.closest( ".boxcat" ).find( ".boxcat-content" ).toggle();
    });
    
    
    $(".deletecat").bind("click",function(e){
       e.preventDefault();
       
        //all update
        $.ajax({
            url:"/"+SITE_BASE_LANG+"/prodotti/deletecategory/"+$(this).data("code")
        }).done(function(rsp){
            console.log(rsp);
        });
        
       return false;
    });


    $.get("/"+SITE_BASE_LANG+"/quote/checkquote").done(function(response){
        
        if( response.status ){
            
            swal({
                title: t("title-sovrascittura"),
                text: t("text-sovrascittura"),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: t("button-confirm-sovrascittura"),
                cancelButtonText: t("button-cancel-sovrascittura"),
                closeOnConfirm: true,
                closeOnCancel: true
              },
              function(isConfirm){
                if (isConfirm) {
                        $.post("/quote/vclear",function(resp){
                            
                            // window.location="/";
                            swal(t("cancellato"),t("success-delete"), "success");
                            
                            return true;
                        },"json");
                } else {
                  
                }
              });
            
        }
        
    });
    
    
 
});