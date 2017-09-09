/*
 * 
 * 
 * 
 */
 var _tmpl_="<div class='direct-chat-msg <%class%>' data-messagescd='<%idmessaggio%>''>\n\
             <div class='direct-chat-info clearfix'>\n\
                 <span class='direct-chat-name pull-left'><%user%></span>\n\
                 <span class='direct-chat-timestamp pull-right'><%data%></span>\n\
             </div>\n\
             <img class=\"direct-chat-img\" src=\"<%immagine%>\" alt=\"message user image\">\n\
             <div class=\"direct-chat-text\"><%message%>\n\
                </div>\n\
             </div>";

var _recentchat_='<li>\n\
              <a href="/network/user/<%user%>">\n\
                <img class="contacts-list-img" src="<%immagine%>" alt="Contact <%user%>">\n\
                <div class="contacts-list-info">\n\
                  <span class="contacts-list-name">\n\
                    <%user%>\n\
                    <small class="contacts-list-date pull-right"><%data%></small>\n\
                  </span>\n\
                  <span class="contacts-list-msg"><%last_message%></span>\n\
                </div><!-- /.contacts-list-info -->\n\
              </a>\n\
            </li><!-- End Contact Item -->';

function loadSalesChart(periodo){
    
    
     var c = document.getElementById("statChart");
     var salesChartCanvas =  $("#statChart").get(0).getContext("2d");
     
     salesChartCanvas.clearRect(0, 0, c.width, c.height);
     salesChartCanvas.beginPath();
     var userdet=$("#statChart").data("userdet");
     
     $.getJSON("/"+SITE_BASE_LANG+"/admin/salesJs/"+userdet,function(datas){
         
           
            
          if(datas.dataset){
           
                var salesChart = new Chart(salesChartCanvas);

                var salesChartData = {

                       datasets: [
                        {
                          fill: false,
                          label: "Preventivi",
                          fillColor: "rgb(110, 214, 122)",
                          strokeColor: "rgb(110, 214, 122)",
                          pointColor: "rgb(110, 214, 122)",
                          pointStrokeColor: "#000",
                          pointHighlightFill: "#444",
                          pointHighlightStroke: "rgb(110,214,122)",
                          data: datas.dataset[0],
                          spanGaps: false,
                        }

                        ]
                 };

                 //var salesChartData= (JSON.parse(data));
                 salesChartData.labels=new Array();
                 $.each(datas.labels,function(item,value){

                     salesChartData.labels.push(value);

                });


               
                var salesChartOptions = {
                  //Boolean - If we should show the scale at all
                  showScale: true,
                  //Boolean - Whether grid lines are shown across the chart
                  scaleShowGridLines: true,
                  //String - Colour of the grid lines
                  scaleGridLineColor: "rgba(0,0,0,.05)",
                  //Number - Width of the grid lines
                  scaleGridLineWidth: 1,
                  //Boolean - Whether to show horizontal lines (except X axis)
                  scaleShowHorizontalLines: true,
                  //Boolean - Whether to show vertical lines (except Y axis)
                  scaleShowVerticalLines: true,
                  //Boolean - Whether the line is curved between points
                  bezierCurve: true,
                  //Number - Tension of the bezier curve between points
                  bezierCurveTension: 0.3,
                  //Boolean - Whether to show a dot for each point
                  pointDot: true,
                  //Number - Radius of each point dot in pixels
                  pointDotRadius: 2,
                  //Number - Pixel width of point dot stroke
                  pointDotStrokeWidth: 1,
                  //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                  pointHitDetectionRadius: 10,
                  //Boolean - Whether to show a stroke for datasets
                  datasetStroke: true,
                  //Number - Pixel width of dataset stroke
                  datasetStrokeWidth: 2,
                  //Boolean - Whether to fill the dataset with a color
                  datasetFill: true,
                  //String - A legend template
                  legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datas.dataset[0].length; i++){%><li><span style=\"background-color:<%=datas.dataset[0].lineColor[i]%>\"></span><%=datas.dataset[0].labels[0]%></li><%}%></ul>",
                  //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                  maintainAspectRatio: true,
                  //Boolean - whether to make the chart responsive to window resizing
                  responsive: true,
                  scales: {
                    xAxes: [{
                        type: 'linear',
                        position: 'bottom'
                    }]
                    }
                };
            
                
                //Create the line chart
                salesChart.Line(salesChartData, salesChartOptions);
            }
        });
}

function loadChart(){
    
    
  //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
  var pieChart = new Chart(pieChartCanvas);
  var PieData=[];
  
  var userdet=$("#pieChart").data("userdet");
  $.get("/admin/chartGlobal/"+userdet,function(datas){
        
        PieData=datas;
      
        var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 1,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
          //String - A tooltip template
          tooltipTemplate: "€ <%=value %> <%=label%> "
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);
  });
  
  
}



function loadRecet(){
    
    $.getJSON("/network/recentchat/",function(responce){
        $.each(responce.messaggi,function(id,jsn){
            $("#recentchat").prepend(parseTemplate(_recentchat_,jsn));
        });
    });
    
}


function loadMessages(limit){
    
    
    var username=$("#chatmessages").data("username");   
   
    $.getJSON("/"+SITE_BASE_LANG+"/network/getnetworkmessage/"+username,
        {'limit':limit}
        ,function(responce){
            
            if(responce.messaggi.length>0){
                
                $.each(responce.messaggi,function(id,jsn){
                    $("#chatmessages").prepend(parseTemplate(_tmpl_,jsn));
                });
               
                if(limit==0 || limit == undefined){
                    goToLast();
                }else{
                    
                }
                $("#chatmessages").data("limits",responce.limits);
            }

        
        }
    );
    
    
}


function goToLast(){
    
    /*
    $("#chatmessages").animate({
	scrollTop: $("div.direct-chat-msg").last().offset().top
     },500);*/
    $("#chatmessages").scrollTop($("div.direct-chat-msg").last().offset().top);
     
}


$(function(){
   
    $("#userstream").load("/network/stream");
   
    if($(".boxchat").hasClass("opened")){
        loadMessages();
        
        $( "#chatmessages" ).scroll(function(){
        
            console.log("scroll chat: --> "+$(this).scrollTop());

            if($(this).scrollTop()<=0){
                loadMessages($("#chatmessages").data("limits"));
            }
            
        });
    }
    
    var username=$("#chatmessages").data("username");   
    
    $("#sendmessage").on("click",function(e){
        
        
       /* SOCKET NOTIIFCATION*/
       //socket.emit('chat message', $("#messaggiochat").val());
        
        $.post("/"+SITE_BASE_LANG+"/network/sendMessage/",
            {
                messaggio : $("#messaggiochat").val(),
                reciver   : username
            },
            function(response){
                console.log(response);
                $("#chatmessages").append(parseTemplate(_tmpl_,response));
                $("#messaggiochat").val("");
                
                
                
                goToLast();
            }
        ,"json");
        
         
        
        return false;
    });
    
   

   
   loadChart();
   loadSalesChart();
   
    
});

