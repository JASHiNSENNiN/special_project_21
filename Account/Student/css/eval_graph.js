///////////////////////////////////////////////attitude and motivation CHART///////////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
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
    width: 900,
    legend: { position: "none" },
    chart: {
      title: "Attitude and Motivation",
      subtitle: "Student attitude and motivation from the work immersion",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: { side: "top", label: "Performance" }, // Top x-axis.
      },
    },
    bar: { groupWidth: "90%" },
  };

  var chart = new google.charts.Bar(document.getElementById("am_top_x_div"));
  chart.draw(data, options);
}

//////////////////////////////////////////////Team work and Collaboration CHART///////////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
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
    width: 900,
    legend: { position: "none" },
    chart: {
      title: "Team work and Collaboration",
      subtitle: "Student team work and collaboration from the work immersion",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: { side: "top", label: "Performance" }, // Top x-axis.
      },
    },
    bar: { groupWidth: "90%" },
  };

  var chart = new google.charts.Bar(document.getElementById("tc_top_x_div"));
  chart.draw(data, options);
}

///////////////////////////////////////////////Learning and Development CHART///////////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
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
    width: 900,
    legend: { position: "none" },
    chart: {
      title: "Learning and Development",
      subtitle: "Student learning and development from the work immersion",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: { side: "top", label: "Performance" }, // Top x-axis.
      },
    },
    bar: { groupWidth: "90%" },
  };

  var chart = new google.charts.Bar(document.getElementById("ld_top_x_div"));
  chart.draw(data, options);
}
///////////////////////////////////////////////Professionalism CHART///////////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
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
    width: 900,
    legend: { position: "none" },
    chart: {
      title: "Professionalism",
      subtitle: "Student professionalism from the work immersion",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: { side: "top", label: "Performance" }, // Top x-axis.
      },
    },
    bar: { groupWidth: "90%" },
  };

  var chart = new google.charts.Bar(document.getElementById("pro_top_x_div"));
  chart.draw(data, options);
}
///////////////////////////////////////////////WORK PERFORMANCE CHART///////////////////////////////////////
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
    title: "Work performance",
    width: 900,
    legend: {
      position: "none",
    },
    chart: {
      title: "Work performance ",
      subtitle: "Student performance from the work immersion",
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

  var chart = new google.charts.Bar(document.getElementById("wp_top_x_div"));
  chart.draw(data, options);
}

google.charts.load("current", {
  packages: ["corechart"],
});

// ///////////////////////////////////PIE CART ////////////////////////////////////////
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ["Task", "Hours per Day"],
    ["Work Performance", 11],
    ["Professionalism", 2],
    ["Learning and Development", 2],
    ["Team work and Collaboration", 2],
    ["Attitude and Motivation", 7],
  ]);

  var options = {
    title: "Total Work Performance",
    is3D: true,
  };

  var chart = new google.visualization.PieChart(
    document.getElementById("piechart_3d")
  );
  chart.draw(data, options);
}
// ///////////////////////////////////DAILY PERFORMACE CART ////////////////////////////////////////
google.charts.load("current", { packages: ["corechart", "line"] });
google.charts.setOnLoadCallback(drawBasicdp);

function drawBasicdp() {
  var dp_data = new google.visualization.DataTable();
  dp_data.addColumn("number", "X");
  dp_data.addColumn("number", "Rating");

  dp_data.addRows([
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
    height: 500,
    width: 1050,
    hAxis: {
      title: "Day",
    },
    vAxis: {
      title: "Performance rate",
    },
  };

  var dp_chart = new google.visualization.LineChart(
    document.getElementById("dp_chart_div")
  );

  dp_chart.draw(dp_data, options);
}
