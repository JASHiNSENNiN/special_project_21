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
  const data = google.visualization.arrayToDataTable(getChartData(selectedDay));

  const options = {
    title: `Evaluation graph ${selectedDay}`,
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

  const chart = new google.visualization.BarChart(
    document.getElementById("chart_div_daily")
  );
  chart.draw(data, options);
}

function getChartData(day) {
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
