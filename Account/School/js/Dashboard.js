// $(".wrapper").click(function () {
//   setInterval(function () {
//     $(".nav li:nth-child(1)").addClass("animated fadeInRight");
//     $(".review_category ul li").removeClass("animated fadeInRight");
//   }, 500);
//   setInterval(function () {
//     $(".nav li:nth-child(2)").addClass("animated fadeInRight");
//     $(".review_category ul li").removeClass("animated fadeInRight");
//   }, 600);
//   setInterval(function () {
//     $(".nav li:nth-child(3)").addClass("animated fadeInRight");
//     $(".review_category ul li").removeClass("animated fadeInRight");
//   }, 700);
//   setInterval(function () {
//     $(".nav li:nth-child(4)").addClass("animated fadeInRight");
//     $(".review_category ul li").removeClass("animated fadeInRight");
//   }, 800);
//   setInterval(function () {
//     $(".nav li:nth-child(5)").addClass("animated fadeInRight");
//     $(".review_category ul li").removeClass("animated fadeInRight");
//   }, 900);
//   setInterval(function () {
//     $(".nav li:nth-child(6)").addClass("animated fadeInRight");
//     $(".review_category ul li").removeClass("animated fadeInRight");
//   }, 1000);
//   setInterval(function () {
//     $(".nav li:nth-child(7)").addClass("animated fadeInRight");
//     $(".review_category ul li").removeClass("animated fadeInRight");
//   }, 1100);
//   $(".nav li").removeClass("animated fadeInRight");
// });
// $(document).ready(function () {
//   $template = $(".rating").clone();
//   $(".myrate").append($template);
//   $(".myrate input#star4").attr("checked", "checked");
// });

// //////////////////////////////////top student work habits ///////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawStuffwh);

function drawStuffwh() {
  var datawh = new google.visualization.arrayToDataTable(
    topStudentsDataWorkHabits
  );

  var options = {
    legend: { position: "none" },
    bars: "horizontal",
    axes: {
      x: {
        0: { side: "top", label: "Rating" },
      },
    },
    bar: { groupWidth: "50%" },
  };

  var chart = new google.charts.Bar(document.getElementById("top_x_div_wh"));
  chart.draw(datawh, options);

  // Redraw the chart on window resize
  window.addEventListener("resize", function () {
    chart.draw(datawh, options);
  });
}
// //////////////////////////////////top student Work skill ///////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawStuffws);

function drawStuffws() {
  var dataws = new google.visualization.arrayToDataTable(
    topStudentsDataWorkSkills
  );

  var options = {
    legend: { position: "none" },
    bars: "horizontal",
    axes: {
      x: {
        0: { side: "top", label: "Rating" },
      },
    },
    bar: { groupWidth: "50%" },
  };

  var chart = new google.charts.Bar(document.getElementById("top_x_div_ws"));
  chart.draw(dataws, options);

  // Redraw the chart on window resize
  window.addEventListener("resize", function () {
    chart.draw(dataws, options);
  });
}
// //////////////////////////////////top student ///////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawStufftp);

function drawStufftp() {
  var datatp = new google.visualization.arrayToDataTable(topStudentsData);

  var options = {
    legend: { position: "none" },
    bars: "horizontal",
    axes: {
      x: {
        0: { side: "top", label: "Rating" },
      },
    },
    bar: { groupWidth: "50%" },
  };

  var chart = new google.charts.Bar(document.getElementById("top_x_div_tp"));
  chart.draw(datatp, options);

  window.addEventListener("resize", function () {
    chart.draw(datatp, options);
  });
}
// //////////////////////////////////top student Social skill ///////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawStuffss);

function drawStuffss() {
  var datass = new google.visualization.arrayToDataTable(
    topStudentsDataSocialSkills
  );

  var options = {
    legend: { position: "none" },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: { side: "top", label: "Rating" }, // Top x-axis.
      },
    },
    bar: { groupWidth: "50%" },
  };

  var chart = new google.charts.Bar(document.getElementById("top_x_div_ss"));
  chart.draw(datass, options);

  // Redraw the chart on window resize
  window.addEventListener("resize", function () {
    chart.draw(datass, options);
  });
}
// ////////////////////////////////// total skills student ////////////////////////////////////
/////////////////////////////////AVERAGE COMPANY AND STRAND //////////////////////////////////
google.charts.load("current", {
  packages: ["corechart"],
});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable(companyAverageData);

  var options = {
    title: "Company overall average",
  };

  var chart = new google.visualization.PieChart(
    document.getElementById("piechart-ave")
  );

  chart.draw(data, options);
}

//////////////////////////////////////////////////////////////////
google.charts.load("current", {
  packages: ["corechart"],
});
google.charts.setOnLoadCallback(drawVisualization);

function drawVisualization() {
  var data = google.visualization.arrayToDataTable(strandComparisonData);

  var options = {
    title: "Total Average per strand with overall average",
    vAxis: {
      title: "Rating",
    },
    hAxis: {
      title: "Strand",
    },
    seriesType: "bars",
    series: {
      [strandComparisonData[0].length - 2]: {
        type: "line",
      },
    },
  };

  var chart = new google.visualization.ComboChart(
    document.getElementById("chart_div_ave")
  );
  chart.draw(data, options);
}
