/*
 *
 **/


function loadSalesChart(periodo){
    
    
     var c = document.getElementById("salesChart");
     var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
     
     salesChartCanvas.clearRect(0, 0, c.width, c.height);
     salesChartCanvas.beginPath();
     
     $.getJSON("/"+SITE_BASE_LANG+"/dashboard/salesJs/"+periodo,function(datas){
         
            
          if(datas.dataset){
           
                var salesChart = new Chart(salesChartCanvas);

                var salesChartData = {

                       datasets: [
                            {
                              fill:                 true,
                              label:                "Fatture",
                              fillColor:            "rgba(255, 86, 33, .8)",
                              strokeColor:          "rgb(255, 86, 33)",
                              pointColor:           "rgb(255, 86, 33)",
                              
                              pointStrokeColor:     "#000",
                              pointHighlightFill:   "#444",
                              
                              data: datas.dataset[0],
                              spanGaps: false
                            }
                            ,
                            {
                              fill:                 true,
                              label:                "Preventivi",
                              fillColor:            "rgba(141, 195, 227,.8)",
                              strokeColor:          "rgb(141, 195, 227)",
                              pointColor:           "rgb(141, 195, 227)",
                              
                              pointStrokeColor:     "#000",
                              pointHighlightFill:   "#444",
                              
                              data: datas.dataset[1],
                              spanGaps: false
                            }
                        ]
                 };

                //var salesChartData= (JSON.parse(data));
                salesChartData.labels=new Array();
                $.each(datas.labels,function(item,value){

                    //---
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
                    pointDotRadius: 1,
                    //Number - Pixel width of point dot stroke
                    pointDotStrokeWidth: 1,
                    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                    pointHitDetectionRadius: 0,
                    //Boolean - Whether to show a stroke for datasets
                    datasetStroke: true,
                    //Number - Pixel width of dataset stroke
                    datasetStrokeWidth: 1,
                    //Boolean - Whether to fill the dataset with a color
                    datasetFill: true,
                    //String - A legend template
                    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\">\n\
  <% for (var i=0; i<datas.dataset[0].length; i++){%><li\n\
  ><span style=\"background-color:<%=datas.dataset[i].lineColor[i]%>\"\n\
  ></span><%=datas.dataset[i].labels[0]%></li><%}%></ul>",
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

$(function () {

  "use strict";
  
  
  $(".selezionastat").on("change",function(e){
     
     e.preventDefault();
     
     loadSalesChart($(this).val());
     
  });
  
    // Get context with jQuery - using jQuery's .get() method.
 
  // This will get the first returned node in the jQuery collection.

  
       
    loadSalesChart(365);
        
    
  

  //Make the dashboard widgets sortable Using jquery UI
  $(".connectedSortable").sortable({
    placeholder: "sort-highlight",
    connectWith: ".connectedSortable",
    handle: ".box-header, .nav-tabs",
    forcePlaceholderSize: true,
    zIndex: 999999
  });
  
  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

  //jQuery UI sortable for the todo list
  $(".todo-list").sortable({
    placeholder: "sort-highlight",
    handle: ".handle",
    forcePlaceholderSize: true,
    zIndex: 999999
  });

  //bootstrap WYSIHTML5 - text editor
  //$(".textarea").wysihtml5();

  $('.daterange').daterangepicker({
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate: moment()
  }, function (start, end) {
    window.alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  });

  /* jQueryKnob */
  $(".knob").knob();


  //The Calender
  $("#fullcalendar").fullCalendar();
  $("#calendar").datepicker();

  //SLIMSCROLL FOR CHAT WIDGET
  $('#usernetwork').slimScroll({
    height: '250px'
  });

/* Morris.js Charts */
  // Sales char
  /*
  var area = new Morris.Area({
    element: 'revenue-chart',
    resize: true,
    data: [
      {y: '2011 Q1', item1: 2666, item2: 2666},
      {y: '2011 Q2', item1: 2778, item2: 2294},
      {y: '2011 Q3', item1: 4912, item2: 1969},
      {y: '2011 Q4', item1: 3767, item2: 3597},
      {y: '2012 Q1', item1: 6810, item2: 1914},
      {y: '2012 Q2', item1: 5670, item2: 4293},
      {y: '2012 Q3', item1: 4820, item2: 3795},
      {y: '2012 Q4', item1: 15073, item2: 5967},
      {y: '2013 Q1', item1: 10687, item2: 4460},
      {y: '2013 Q2', item1: 8432, item2: 5713}
    ],
    xkey: 'y',
    ykeys: ['item1', 'item2'],
    labels: ['Item 1', 'Item 2'],
    lineColors: ['#a0d0e0', '#3c8dbc'],
    hideHover: 'auto'
  });*/
 
 /*
  var line = new Morris.Line({
    element: 'line-chart',
    resize: true,
    data: _stat_vendite_,
    xkey: 'data',
    ykeys: ['quantita','totale'],
    labels: ['quantita','totale'],
    lineColors: ['#efefef','#ffff00'],
    lineWidth: 2,
    hideHover: 'auto',
    gridTextColor: "#fff",
    gridStrokeWidth: 0.4,
    pointSize: 4,
    pointStrokeColors: ["#efefef",'#ffff00'],
    gridLineColor: "#efefef",
    gridTextFamily: "Open Sans",
    gridTextSize: 10
  });*/

  //Donut Chart
  /*
  var donut = new Morris.Donut({
    element: 'sales-chart',
    resize: true,
    colors: ["#3c8dbc", "#f56954", "#00a65a"],
    data: [
      {label: "Download Sales", value: 12},
      {label: "In-Store Sales", value: 30},
      {label: "Mail-Order Sales", value: 20}
    ],
    hideHover: 'auto'
  });*/

  //Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function () {
    area.redraw();
    donut.redraw();
    line.redraw();
  });

  /* The todo list plugin */
  $(".todo-list").todolist({
    onCheck: function (ele) {
      window.console.log("The element has been checked");
      return ele;
    },
    onUncheck: function (ele) {
      window.console.log("The element has been unchecked");
      return ele;
    }
  });

});
