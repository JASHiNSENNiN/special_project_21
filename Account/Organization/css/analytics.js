// ///////////////////////////////////COMPANY PERFORMACE CART ////////////////////////////////////////
google.charts.load("current", {
  packages: ["corechart", "line"],
});
google.charts.setOnLoadCallback(drawBasiccom);

function drawBasiccom() {
  var com_data = new google.visualization.DataTable();
  com_data.addColumn("number", "X");
  com_data.addColumn("number", "Rating");

  com_data.addRows([
    [0, 0],
    [1, 10],
    [2, 23],
    [3, 17],
    [4, 18],
    [5, 9],
    [6, 11],
    [7, 27],
    [8, 33],
    [9, 40],
    [10, 32],
    [11, 35],
    [12, 30],
    [13, 40],
    [14, 42],
    [15, 47],
    [16, 44],
    [17, 48],
    [18, 52],
    [19, 54],
    [20, 42],
    [21, 55],
    [22, 56],
    [23, 57],
    [24, 60],
    [25, 50],
    [26, 52],
    [27, 51],
    [28, 49],
    [29, 53],
    [30, 55],
    [31, 60],
    [32, 61],
    [33, 59],
    [34, 62],
    [35, 65],
    [36, 62],
    [37, 58],
    [38, 55],
    [39, 61],
    [40, 64],
    [41, 65],
    [42, 63],
    [43, 66],
    [44, 67],
    [45, 69],
    [46, 69],
    [47, 70],
    [48, 72],
    [49, 68],
    [50, 66],
    [51, 65],
    [52, 67],
    [53, 70],
    [54, 71],
    [55, 72],
    [56, 73],
    [57, 75],
    [58, 70],
    [59, 68],
    [60, 64],
    [61, 60],
    [62, 65],
    [63, 67],
    [64, 68],
    [65, 69],
    [66, 70],
    [67, 72],
    [68, 75],
    [69, 80],
  ]);

  var options = {
    title: "Daily Performance",
    height: 200,
    responsive: true,

    hAxis: {
      title: "Day",
    },
    vAxis: {
      title: "Performance rate",
    },
  };

  var com_chart = new google.visualization.LineChart(
    document.getElementById("com_chart_div")
  );

  com_chart.draw(com_data, options);
}
// ///////////////////////////////////total strands PIE CART ////////////////////////////////////////
google.charts.setOnLoadCallback(drawChart);

// Make API call to retrieve chart data
fetch("../../../backend/php/get_student_strand_num.php?chart_data=true")
  .then((response) => {
    return response.text(); // Change to text to see raw response
  })
  .then((data) => {
    console.log(data); // Log the raw response
    try {
      const jsonData = JSON.parse(data); // Attempt to parse JSON
      var chartData = [["Strand", "Count"]]; // Initialize with header row
      for (var strand in jsonData) {
        chartData.push([strand, jsonData[strand]]);
      }
      drawChart(chartData);
    } catch (error) {
      console.error("Error parsing JSON:", error);
    }
  })
  .catch((error) => console.error("Error fetching data:", error));

// Draw the chart function
function drawChart(chartData) {
  var jsonData = { stem: 1, humss: 0, abm: 0, gas: 0, tvl: 0 };

  // Convert JSON to array format for Google Charts
  var chartData = [["Task", "Hours per Day"]]; // Initialize with header

  // Map through the JSON object to add data to the array
  Object.keys(jsonData).forEach(function (strand) {
    var formattedStrand = strand.charAt(0).toUpperCase() + strand.slice(1); // Capitalize first letter
    chartData.push([formattedStrand, jsonData[strand]]);
  });

  // Create the DataTable
  var data = google.visualization.arrayToDataTable(chartData);

  // Example: Drawing the chart (you can customize options)
  var options = {
    title: "Population",
    is3D: true,
    responsive: true,
  };

  var chart = new google.visualization.PieChart(
    document.getElementById("piechart_3d")
  );
  chart.draw(data, options);
}
