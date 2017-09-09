/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
  
   $("#tableQuote").DataTable({
       
       "pageLength": 25,
       responsive: true,
       "order": [[ 0, "DESC" ]]
   });
  
   $(".filtertable").click(function(){
     
        var valore=$(this).val();
        
       console.log(valore);
   });
   
   
   $(".buildinvoice").on("click",function(e){
       e.preventDefault();
       
       $.get($(this).attr("href"),
            function(resp){
                console.log(resp);
                swal("Fattura Salvata","Controlla nelle tue fatture","success");
                document.location="/invoice/all";
            }
       );
       
       
       return false;
       
   });
   
   
   $('#modal-invoice').on('show.bs.modal',function(event){
       
        var button = $(event.relatedTarget); // Button that triggered the modal
        var recipient = button.data('whatever'); // Extract info from data-* attributes
        
        var modal = $(this);
        modal.find('.modal-title').text('New message to ' + recipient);
        modal.find('.modal-body input').val(recipient);
        var urlexec=button.data("action");
        modal.find('.modal-body input[name="actionurl"]').val(urlexec);
        
  });
  $("#formconfirminvocie").submit(function(){
           var modal = $("#modal-invoice");
           var form=$(this);
           
           
           $.ajax({
            method: "POST",
            url: modal.find('.modal-body input[name="actionurl"]').val(),
            data: $(this).serialize()
            }).done(function( msg ) {
                
              swal("Fattura Salvata","Controlla nelle tue fatture","success");
              
              $.each(form.find("input"),function(key){
                  $(this).val('');
              });
              
            });
           
           modal.modal('hide');
           
           return false;
   });
    
    
});

