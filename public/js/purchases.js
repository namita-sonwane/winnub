/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
var ctx = document.getElementById('purchases_reprentation').getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug','Ago','Set','Ott', 'Nov', 'Dic'],
    datasets: [{
      label: t('Purchases'),
      data: purchase_datas,
      backgroundColor: "rgba(51,106,255,0.4)"
    }]
  }
});
*/
$(function(){
   
    var table=$("#tablepurchases").dataTable();
    
    table.on( 'draw.dt',function(){
       loaddel();
    });
    
    
    
   
});


function loaddel(){
    
    
    
    $(".eliminapurchases").bind("click",function(e){
        e.preventDefault();
        var urls=$(this).attr("href");		
		console.log(urls);
        swal({
             title: t("Vuoi eliminare questo Purchasess?"),
             text: t("L\'operazione di rimozione non è reversibile"),
             type: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: t("Si, elimina"),
             closeOnConfirm: false
           },
           function(){
                
                $.get(urls,
                    function(response)
                    {
						console.log(response);
				
                       if(response.status)
                       {						   
                           swal(t("Eliminato"),t("Purchases eliminato con successo"), "success");
						    location.reload();
                       }
                        else
                       {
						   console.log('Error');
                           swal(t("Errore"),t("Se l\'errore persiste contattare l\'amministrazione"), "error");
                       }
                    }
                ,"json");

        });
        return false;
     });
}

$(document).ready(function(){
    
      loaddel();
      
    
    
});