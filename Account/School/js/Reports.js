google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawStufftsw);

function drawStufftsw() {
  var datatsw = new google.visualization.arrayToDataTable([
    ["Opening ", "Percentage"],
    ["Work habit's", 15],
    ["Work skills'", 20],
    ["Social skills ", 12],
  ]);

  var options = {
    title: "Chess opening moves",
    legend: { position: "none" },
    chart: {
      title: "Overall rating",
      subtitle: "Work habit, Work skills, Social skills",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: { side: "top", label: "Percentage" }, // Top x-axis.
      },
    },
    bar: { groupWidth: "50%" },
  };

  var chart = new google.charts.Bar(document.getElementById("top_x_div_tsw"));
  chart.draw(datatsw, options);
}

// Handle window resize to redraw the chart
window.addEventListener("resize", drawStufftsw);
