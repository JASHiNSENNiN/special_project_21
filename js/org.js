///////////////////////////////////////////////attitude and motivation CHART///////////////////////////////////////
google.charts.load("current", {
  packages: ["bar"],
});
google.charts.setOnLoadCallback(drawStuffam);

function drawStuffam() {
  var data = new google.visualization.arrayToDataTable([
    ["", "Performance"],
    ["Excellent", 25],
    ["Good", 23],
    ["Average", 30],
    ["Poor", 15],
    ["Very poor", 1],
  ]);

  var options = {
    title: "Attitude and Motivation",
    height: "100%",
    width: "100%",
    legend: {
      position: "none",
    },
    chart: {
      title: "Attitude and Motivation",
      // subtitle: "Student attitude and motivation from the work immersion",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: {
          side: "top",
          label: "Performance",
        }, // Top x-axis.
      },
    },
    bar: {
      groupWidth: "90%",
    },
  };

  var chart = new google.charts.Bar(document.getElementById("am-top-x-div"));
  chart.draw(data, options);
}

window.addEventListener("resize", function () {
  drawStuffam();
});

//////////////////////////////////////////////Team work and Collaboration CHART///////////////////////////////////////
google.charts.load("current", {
  packages: ["bar"],
});
google.charts.setOnLoadCallback(drawStufftc);

function drawStufftc() {
  var data = new google.visualization.arrayToDataTable([
    ["", "Performance"],
    ["Excellent", 35],
    ["Good", 20],
    ["Average", 10],
    ["Poor", 15],
    ["Very poor", 5],
  ]);

  var options = {
    title: "Team work and Collaboration",
    height: "100%",
    width: "100%",
    legend: {
      position: "none",
    },
    chart: {
      title: "Team work and Collaboration",
      // subtitle: "Student team work and collaboration from the work immersion",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: {
          side: "top",
          label: "Performance",
        }, // Top x-axis.
      },
    },
    bar: {
      groupWidth: "90%",
    },
  };

  var chart = new google.charts.Bar(document.getElementById("tc-top-x-div"));
  chart.draw(data, options);
}
window.addEventListener("resize", function () {
  drawStufftc();
});

///////////////////////////////////////////////Learning and Development CHART///////////////////////////////////////
google.charts.load("current", {
  packages: ["bar"],
});
google.charts.setOnLoadCallback(drawStuffld);

function drawStuffld() {
  var data = new google.visualization.arrayToDataTable([
    ["", "Performance"],
    ["Excellent", 27],
    ["Good", 30],
    ["Average", 20],
    ["Poor", 2],
    ["Very poor", 1],
  ]);

  var options = {
    title: "Learning and Development",
    height: "100%",
    width: "100%",
    legend: {
      position: "none",
    },
    chart: {
      title: "Learning and Development",
      // subtitle: "Student learning and development from the work immersion",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: {
          side: "top",
          label: "Performance",
        }, // Top x-axis.
      },
    },
    bar: {
      groupWidth: "90%",
    },
  };

  var chart = new google.charts.Bar(document.getElementById("ld-top-x-div"));
  chart.draw(data, options);
}
window.addEventListener("resize", function () {
  drawStuffld();
});
///////////////////////////////////////////////Professionalism CHART///////////////////////////////////////
google.charts.load("current", {
  packages: ["bar"],
});
google.charts.setOnLoadCallback(drawStuffprof);

function drawStuffprof() {
  var data = new google.visualization.arrayToDataTable([
    ["", "Performance"],
    ["Excellent", 40],
    ["Good", 35],
    ["Average", 20],
    ["Poor", 0],
    ["Very poor", 0],
  ]);

  var options = {
    title: "Professionalism",
    height: "100%",
    width: "100%",
    legend: {
      position: "none",
    },
    chart: {
      title: "Professionalism",
      // subtitle: "Student professionalism from the work immersion",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: {
          side: "top",
          label: "Performance",
        }, // Top x-axis.
      },
    },
    bar: {
      groupWidth: "90%",
    },
  };

  var chart = new google.charts.Bar(document.getElementById("pro-top-x-div"));
  chart.draw(data, options);
}

window.addEventListener("resize", function () {
  drawStuffprof();
});
///////////////////////////////////////////////Work Immerssion Experience CHART///////////////////////////////////////
google.charts.load("current", {
  packages: ["bar"],
});
google.charts.setOnLoadCallback(drawStuff);

function drawStuff() {
  var data = new google.visualization.arrayToDataTable([
    ["", "Performance"],
    ["Excellent", 40],
    ["Good", 20],
    ["Average", 0],
    ["Poor", 0],
    ["Very poor", 0],
  ]);

  var options = {
    title: "Work Immerssion Experience",
    height: "100%",
    width: "100%",
    legend: {
      position: "none",
    },
    chart: {
      title: "Work Immerssion Experience",
      // subtitle: "Student experience from the work immersion",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: {
          side: "top",
          label: "Performance",
        }, // Top x-axis.
      },
    },
    bar: {
      groupWidth: "90%",
    },
  };

  var chart = new google.charts.Bar(document.getElementById("wp-top-x-div"));
  chart.draw(data, options);
}

// google.charts.load("current", {
//   packages: ["corechart"],
// });

window.addEventListener("resize", function () {
  drawStuff();
});
/////////////////////////////////////rating graph and pie chart ///////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawStuffrating);

function drawStuffrating() {
  var data = new google.visualization.arrayToDataTable([
    ["Star", "Percentage"],
    ["5", 50],
    ["4", 31],
    ["3", 12],
    ["2", 10],
    ["1", 3],
  ]);

  var options = {
    title: "Chess opening moves",
    width: "100%", // Set width to 100% for responsiveness
    legend: { position: "none" },
    chart: {
      title: "Rating of Work Immersion ",
      subtitle: "popularity by rating",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: { side: "top", label: "Rating" }, // Top x-axis.
      },
    },
    bar: { groupWidth: "90%" },
  };

  var chart = new google.charts.Bar(
    document.getElementById("top_x_div_rating")
  );
  chart.draw(data, options);
}

// Redraw the chart on window resize
window.addEventListener("resize", drawStuffrating);

// ///////////////////////////////pie chart/////////////////
google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawChartts);

function drawChartts() {
  var datats = google.visualization.arrayToDataTable([
    ["Task", "Hours per Day"],
    ["Humss", 11],
    ["Gass", 2],
    ["Stem", 2],
    ["Tvl", 2],
  ]);

  var optionsts = {
    title: "Total Student Applied",
    pieSliceText: "label",
  };

  var chartts = new google.visualization.PieChart(
    document.getElementById("total-student")
  );
  chartts.draw(datats, optionsts);
}

// Redraw the chart on window resize
window.addEventListener("resize", drawChartts);
