/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var steppagine=1;

$(function(){
  

    var elf = $('#elfinder').elfinder({
            height: $(window).height() - 20,
            lang: SITE_BASE_LANG,             // language (OPTIONAL)
            url : '/'+SITE_BASE_LANG+'/media/elfinder',  // connector URL (REQUIRED)
            
    }).elfinder('instance');         
    
    // fit to window.height on window.resize
    var resizeTimer = null;
    $(window).resize(function() {
        resizeTimer && clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            var h = parseInt($(window).height()) - 20;
            if (h != parseInt($('#elfinder').height())) {
                elf.resize('100%', h);
            }
        }, 200);
    });

});



$(document).ready(function() {
    
$(".modalimg").fancybox();
                
                  
             // init Isotope
        var $grid = $('.grid').imagesLoaded( function() {
          // init Isotope after all images have loaded
          $grid.isotope({
            itemSelector: '.grid-item',
            layoutMode: 'masonry'
          });
        });


        // filter items on button click
        $('.filter-button-group').on( 'click', 'button', function() {
          var filterValue = $(this).attr('data-filter');
          $grid.isotope({ filter: filterValue });
        });


        $(".loadmore").click(function(e){
            e.preventDefault();
            
            
            $.get("/"+SITE_BASE_LANG+"/media/next/"+steppagine+"/",function(response){
              
              var datas=(response);
              var elementi="";
              $.each(datas,function(key,value){
                  var obj=response[key];
                  elementi+="<div class='grid-item "+obj.class+"'><a href='"+obj.image+"' class='thumbnail modalimg' rel=\"media\"><img src='"+obj.image+"' /></a></div>";
                  
              });
              $items=$(elementi);
              $('.grid').imagesLoaded( function() {
                    // init Isotope after all images have loaded
                    $('.grid').prepend( $items ).isotope('prepended',$items );
                    
              });
              $('.grid').imagesLoaded(function(){
                    
                    // init Isotope after all images have loaded
                    $('.grid').isotope({
                      layoutMode: 'masonry'
                    });
                    
              });
              
             
              
              steppagine++;
            },"JSON");
           
            return false;
        });

});