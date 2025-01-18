google.charts.load("current", {
  packages: ["corechart"],
});
google.charts.setOnLoadCallback(initializedaily);

function initializedaily() {
  const dropdown = document.getElementById("dayDropdown");
  dropdown.addEventListener("change", drawChartdaily);
  drawChartdaily();

  // Add window resize listener
  window.addEventListener("resize", drawChartdaily);
}

function drawChartdaily() {
  const dropdown = document.getElementById("dayDropdown");
  const selectedDay = dropdown.value;
  const day = parseInt(selectedDay.replace(" Day ", ""));

  const data1 = google.visualization.arrayToDataTable(
    getChartData1(selectedDay)
  );
  const data2 = google.visualization.arrayToDataTable(
    getChartData2(selectedDay)
  );
  const data3 = google.visualization.arrayToDataTable(
    getChartData3(selectedDay)
  );

  const options1 = {
    title: `Work Habits graph ${selectedDay}`,
    hAxis: {
      title: "Performace",
      minValue: 0,
    },
    vAxis: {
      title: "Category",
      minValue: 0,
    },
    legend: "none",
    height: "100%",
    width: "100%",
  };

  const options2 = {
    title: `Work Skills graph ${selectedDay}`,
    hAxis: {
      title: "Performace",
      minValue: 0,
    },
    vAxis: {
      title: "Category",
      minValue: 0,
    },
    legend: "none",
    height: "100%",
    width: "100%",
  };

  const options3 = {
    title: `Social Skills graph ${selectedDay}`,
    hAxis: {
      title: "Performace",
      minValue: 0,
    },
    vAxis: {
      title: "Category",
      minValue: 0,
    },
    legend: "none",
    height: "100%",
    width: "100%",
  };

  const chart1 = new google.visualization.BarChart(
    document.getElementById("chart_div_daily1")
  );
  chart1.draw(data1, options1);

  const chart2 = new google.visualization.BarChart(
    document.getElementById("chart_div_daily2")
  );
  chart2.draw(data2, options2);

  const chart3 = new google.visualization.BarChart(
    document.getElementById("chart_div_daily3")
  );
  chart3.draw(data3, options3);
}

function getChartData1(day) {
  switch (day) {
    case "Day 1":
      return [
        ["category", "score"],
        ["A", 10],
        ["B", 20],
        ["C", 30],
        ["A", 10],
        ["B", 20],
        ["C", 30],
        ["C", 30],
      ];
    case "Day 2":
      return [
        ["category", "score"],
        ["A", 15],
        ["B", 25],
        ["C", 5],
        ["A", 15],
        ["B", 25],
        ["C", 5],
        ["C", 5],
      ];
    case "Day 3":
      return [
        ["category", "score"],
        ["A", 20],
        ["B", 30],
        ["C", 25],
        ["A", 20],
        ["B", 30],
        ["C", 25],
        ["C", 25],
      ];
    case "Day 4":
      return [
        ["category", "score"],
        ["A", 25],
        ["B", 10],
        ["C", 15],
        ["A", 25],
        ["B", 10],
        ["C", 15],
        ["C", 15],
      ];
    case "Day 5":
      return [
        ["category", "score"],
        ["A", 30],
        ["B", 25],
        ["C", 20],
        ["A", 30],
        ["B", 25],
        ["C", 20],
        ["C", 20],
      ];
    case "Day 6":
      return [
        ["category", "score"],
        ["A", 5],
        ["B", 30],
        ["C", 40],
        ["A", 5],
        ["B", 30],
        ["C", 40],
        ["C", 40],
      ];
    case "Day 7":
      return [
        ["category", "score"],
        ["A", 20],
        ["B", 10],
        ["C", 35],
        ["A", 20],
        ["B", 10],
        ["C", 35],
        ["C", 35],
      ];
    case "Day 8":
      return [
        ["category", "score"],
        ["A", 15],
        ["B", 25],
        ["C", 30],
        ["A", 15],
        ["B", 25],
        ["C", 30],
        ["C", 30],
      ];
    case "Day 9":
      return [
        ["category", "score"],
        ["A", 40],
        ["B", 10],
        ["C", 15],
        ["A", 40],
        ["B", 10],
        ["C", 15],
        ["C", 15],
      ];
    case "Day 10":
      return [
        ["category", "score"],
        ["A", 20],
        ["B", 30],
        ["C", 20],
        ["A", 20],
        ["B", 30],
        ["C", 20],
        ["C", 20],
      ];
    default:
      return [
        ["category", "score"],
        ["A", 0],
        ["B", 0],
        ["C", 0],
        ["A", 0],
        ["B", 0],
        ["C", 0],
        ["C", 0],
      ];
  }
}

function getChartData2(day) {
  switch (day) {
    case "Day 1":
      return [
        ["category", "score"],
        ["A", 15],
        ["B", 25],
        ["C", 5],
        ["A", 15],
        ["B", 25],
        ["C", 5],
        ["C", 5],
      ];
    case "Day 2":
      return [
        ["category", "score"],
        ["A", 20],
        ["B", 30],
        ["C", 25],
        ["A", 20],
        ["B", 30],
        ["C", 25],
        ["C", 25],
      ];
    case "Day 3":
      return [
        ["category", "score"],
        ["A", 25],
        ["B", 10],
        ["C", 15],
        ["A", 25],
        ["B", 10],
        ["C", 15],
        ["C", 15],
      ];
    case "Day 4":
      return [
        ["category", "score"],
        ["A", 30],
        ["B", 25],
        ["C", 20],
        ["A", 30],
        ["B", 25],
        ["C", 20],
        ["C", 20],
      ];
    case "Day 5":
      return [
        ["category", "score"],
        ["A", 5],
        ["B", 30],
        ["C", 40],
        ["A", 5],
        ["B", 30],
        ["C", 40],
        ["C", 40],
      ];
    case "Day 6":
      return [
        ["category", "score"],
        ["A", 20],
        ["B", 10],
        ["C", 35],
        ["A", 20],
        ["B", 10],
        ["C", 35],
        ["C", 35],
      ];
    case "Day 7":
      return [
        ["category", "score"],
        ["A", 15],
        ["B", 25],
        ["C", 30],
        ["A", 15],
        ["B", 25],
        ["C", 30],
        ["C", 30],
      ];
    case "Day 8":
      return [
        ["category", "score"],
        ["A", 40],
        ["B", 10],
        ["C", 15],
        ["A", 40],
        ["B", 10],
        ["C", 15],
        ["C", 15],
      ];
    case "Day 9":
      return [
        ["category", "score"],
        ["A", 20],
        ["B", 30],
        ["C", 20],
        ["A", 20],
        ["B", 30],
        ["C", 20],
        ["C", 20],
      ];
    case "Day 10":
      return [
        ["category", "score"],
        ["A", 10],
        ["B", 40],
        ["C", 40],
        ["A", 20],
        ["B", 40],
        ["C", 10],
        ["C", 40],
      ];
    default:
      return [
        ["category", "score"],
        ["A", 0],
        ["B", 0],
        ["C", 0],
        ["A", 0],
        ["B", 0],
        ["C", 0],
        ["C", 0],
      ];
  }
}

function getChartData3(day) {
  switch (day) {
    case "Day 1":
      return [
        ["category", "score"],
        ["A", 10],
        ["B", 20],
        ["C", 30],
        ["A", 10],
        ["B", 28],
        ["C", 30],
        ["C", 30],
      ];
    case "Day 2":
      return [
        ["category", "score"],
        ["A", 15],
        ["B", 25],
        ["C", 5],
        ["A", 15],
        ["B", 25],
        ["C", 5],
        ["C", 5],
      ];
    case "Day 3":
      return [
        ["category", "score"],
        ["A", 20],
        ["B", 30],
        ["C", 25],
        ["A", 20],
        ["B", 30],
        ["C", 25],
        ["C", 25],
      ];
    case "Day 4":
      return [
        ["category", "score"],
        ["A", 25],
        ["B", 10],
        ["C", 15],
        ["A", 25],
        ["B", 10],
        ["C", 15],
        ["C", 15],
      ];
    case "Day 5":
      return [
        ["category", "score"],
        ["A", 30],
        ["B", 25],
        ["C", 20],
        ["A", 30],
        ["B", 25],
        ["C", 20],
        ["C", 20],
      ];
    case "Day 6":
      return [
        ["category", "score"],
        ["A", 5],
        ["B", 30],
        ["C", 40],
        ["A", 5],
        ["B", 30],
        ["C", 40],
        ["C", 40],
      ];
    case "Day 7":
      return [
        ["category", "score"],
        ["A", 20],
        ["B", 10],
        ["C", 35],
        ["A", 20],
        ["B", 10],
        ["C", 35],
        ["C", 35],
      ];
    case "Day 8":
      return [
        ["category", "score"],
        ["A", 15],
        ["B", 25],
        ["C", 30],
        ["A", 15],
        ["B", 25],
        ["C", 30],
        [" C", 23],
      ];
    case "Day 9":
      return [
        ["category", "score"],
        ["A", 40],
        ["B", 10],
        [" C", 15],
        [" A", 40],
        [" B", 10],
        [" C", 15],
        [" C", 15],
      ];
    case "Day 10":
      return [
        ["category", "score"],
        ["A", 20],
        ["B", 30],
        ["C", 20],
        ["A", 20],
        ["B", 30],
        ["C,", 20],
        ["C,", 20],
      ];
    default:
      return [
        ["category", "score"],
        ["A", 0],
        ["B", 0],
        ["C", 0],
        ["A", 0],
        ["B", 0],
        ["C,", 0],
        ["C,", 0],
      ];
  }
}
