// ///////////////////////////////////COMPANY PERFORMACE CART ////////////////////////////////////////
google.charts.load("current", { packages: ["corechart", "line"] });
google.charts.setOnLoadCallback(drawBasiccom);

function drawBasiccom() {
  var com_data = new google.visualization.DataTable();
  com_data.addColumn("date", "Date"); // Change this from "number" to "date"
  com_data.addColumn("number", "Average Rating");

  // Convert timestamp (in milliseconds) to Date objects and add rows
  dailyPerformance.forEach(function (row) {
    var date = new Date(row[0]); // Convert the timestamp to a Date object
    var avgRating = row[1];
    com_data.addRow([date, avgRating]); // Add the date and the average rating
  });

  var options = {
    title: "Daily Performance",
    height: 200,
    responsive: true,
    hAxis: {
      title: "Date",
      format: "M/d/yy",
    },
    vAxis: {
      title: "Average Rating",
      minValue: 0,
      maxValue: 5,
    },
  };

  var com_chart = new google.visualization.LineChart(
    document.getElementById("com_chart_div")
  );
  com_chart.draw(com_data, options);
}
// ///////////////////////////////////total strands PIE CART ////////////////////////////////////////
google.charts.load("current", { packages: ["corechart"] });
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
