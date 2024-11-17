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
    console.log("Strand numbers: ", data); // Log the raw response
    try {
      const jsonData = JSON.parse(data); // Attempt to parse JSON
      var chartData = [["Strand", "Count"]]; // Initialize with header row
      for (var strand in jsonData) {
        chartData.push([
          strand.charAt(0).toUpperCase() + strand.slice(1),
          jsonData[strand],
        ]);
      }
      drawChart(chartData);
    } catch (error) {
      console.error("Error parsing JSON:", error);
    }
  })
  .catch((error) => console.error("Error fetching data:", error));

// Draw the chart function
function drawChart(chartData) {
  // Create the DataTable
  var data = google.visualization.arrayToDataTable(chartData);

  // Example: Drawing the chart (you can customize options)
  var options = {
    title: "Strand Distribution",
    is3D: true,
    responsive: true,
  };

  var chart = new google.visualization.PieChart(
    document.getElementById("piechart_3d")
  );
  chart.draw(data, options);
}
