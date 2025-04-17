// google.charts.load("current", { packages: ["corechart"] });
// google.charts.setOnLoadCallback(drawChart);

// function drawChart() {
//   var data = google.visualization.arrayToDataTable([
//     ["Year", "City Hall", "LTO"],
//     ["2013", 1000, 500],
//     ["2014", 1170, 460],
//     ["2015", 660, 1120],
//     ["2016", 1030, 540],
//   ]);

//   var options = {
//     title: "Partner Industry Performance",
//     hAxis: { title: "Year", titleTextStyle: { color: "#333" } },
//     vAxis: { minValue: 0 },
//     legend: { position: "top", maxLines: 3 },
//     axes: {
//       y: {
//         distance: {label: 'parsecs'}, // Left y-axis.
        
//       }
//     },
//     vAxes: {
//       // Adds titles to each axis.
//       0: {title: 'Average'},
      
//     },
    
//   };
  

//   var chart = new google.visualization.AreaChart(
//     document.getElementById("area-chart")
//   );
//   chart.draw(data, options);  

// }

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart1);
function drawChart1() {
  var data = google.visualization.arrayToDataTable([
    ['Year', 'Jollibee', 'NIA'],
    ['2004',  1000,      400],
    ['2005',  1170,      460],
    ['2006',  660,       1120],
    ['2007',  1030,      540]
  ]);

  var options = {
    title: 'Company Performance',
    hAxis: {title: 'Year', titleTextStyle: {color: '#333'}},
    vAxis: { minValue: 0 },
        legend: { position: "top", maxLines: 3 },
        axes: {
          y: {
            distance: {label: 'average'}, // Left y-axis.
            
          }
        },
        vAxes: {
          // Adds titles to each axis.
          0: {title: 'Average'},
          
        },

 };

var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
  chart.draw(data, options);
}

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart2);
function drawChart2() {
  var data = google.visualization.arrayToDataTable([
    ['Year', 'Jollibee', 'NIA'],
    ['2013',  1000,      400],
    ['2014',  1170,      460],
    ['2015',  660,       1120],
    ['2016',  1030,      540]
  ]);

  var options = {
    title: 'Company Performance',
    hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
    vAxis: {minValue: 0},
    vAxis: { minValue: 0 },
    legend: { position: "top", maxLines: 3 },
    axes: {
      y: {
        distance: {label: 'average'}, // Left y-axis.
        
      }
    },
    vAxes: {
      // Adds titles to each axis.
      0: {title: 'Average'},
      
    },
  };

  var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
  chart.draw(data, options);
}

$(window).resize(function(){
  drawChart1();
  drawChart2();
});

// Reminder: you need to put https://www.google.com/jsapi in the head of your document or as an external resource on codepen //
