//do not delete this
// var data = new google.visualization.arrayToDataTable([
//   ["Category", "Performance"],
//1   ["Quality of Work", averages.avgQualityOfWork],
//2   ["Productivity", averages.avgProductivity],
//3   ["Problem Solving Skills", averages.avgProblemSolvingSkills],
//4   ["Attention to Detail", averages.avgAttentionToDetail],
//5   ["Initiative", averages.avgInitiative],
//6   ["Punctuality", averages.avgPunctuality],
//7   ["Appearance", averages.avgAppearance],
//8   ["Communication Skills", averages.avgCommunicationSkills],
//9   ["Respectfulness", averages.avgRespectfulness],
//10   ["Adaptability", averages.avgAdaptability],
//11  ["Willingness to Learn", averages.avgWillingnessToLearn],
//12   ["Application of Feedback", averages.avgApplicationOfFeedback],
//13   ["Self Improvement", averages.avgSelfImprovement],
//14   ["Skill Development", averages.avgSkillDevelopment],
//15   ["Knowledge Application", averages.avgKnowledgeApplication],
//16   ["Team Participation", averages.avgTeamParticipation],
//17   ["Cooperation", averages.avgCooperation],
//18   ["Conflict Resolution", averages.avgConflictResolution],
//19   ["Supportiveness", averages.avgSupportiveness],
//20   ["Contribution", averages.avgContribution],
//21   ["Enthusiasm", averages.avgEnthusiasm],
//22   ["Drive", averages.avgDrive],
//23   ["Resilience", averages.avgResilience],
//24   ["Commitment", averages.avgCommitment],
//25   ["Self Motivation", averages.avgSelfMotivation],
// ]);
//do not delete this

///////////////////////////////////////////////attitude and motivation CHART///////////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawStuffam);

function drawStuffam() {
  var data = new google.visualization.arrayToDataTable([
    ["Category", "Performance"],
    ["Enthusiasm", averages.avgEnthusiasm],
    ["Drive", averages.avgDrive],
    ["Resilience", averages.avgResilience],
    ["Commitment", averages.avgCommitment],
    ["Self Motivation", averages.avgSelfMotivation],
  ]);

  var options = {
    title: "Attitude and Motivation",
    height: "100%",
    width: "100%",
    legend: { position: "none" },
    chart: {
      title: "Attitude and Motivation",
      subtitle: "Student attitude and motivation from the work immersion",
    },
    bars: "horizontal",
    axes: {
      x: {
        0: { side: "top", label: "Performance" },
      },
    },
    bar: { groupWidth: "90%" },
  };

  var chart = new google.charts.Bar(document.getElementById("am-top-x-div"));
  chart.draw(data, options);
}
window.addEventListener("resize", function () {
  drawStufftc();
});
//////////////////////////////////////////////Team work and Collaboration CHART///////////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawStufftc);

function drawStufftc() {
  var data = new google.visualization.arrayToDataTable([
    ["Category", "Performance"],
    ["Team Participation", averages.avgTeamParticipation],
    ["Cooperation", averages.avgCooperation],
    ["Conflict Resolution", averages.avgConflictResolution],
    ["Supportiveness", averages.avgSupportiveness],
    ["Contribution", averages.avgContribution],
  ]);

  var options = {
    title: "Team work and Collaboration",
    height: "100%",
    width: "100%",
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

  var chart = new google.charts.Bar(document.getElementById("tc-top-x-div"));
  chart.draw(data, options);
}
window.addEventListener("resize", function () {
  drawStufftc();
});
///////////////////////////////////////////////Learning and Development CHART///////////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawStuffld);

function drawStuffld() {
  var data = new google.visualization.arrayToDataTable([
    ["Category", "Performance"],
    ["Willingness to Learn", averages.avgWillingnessToLearn || 0],
    ["Application of Feedback", averages.avgApplicationOfFeedback || 0],
    ["Self Improvement", averages.avgSelfImprovement || 0],
    ["Skill Development", averages.avgSkillDevelopment || 0],
    ["Knowledge Application", averages.avgKnowledgeApplication || 0],
  ]);

  var options = {
    title: "Learning and Development",
    height: "100%",
    width: "100%",
    legend: { position: "none" },
    chart: {
      title: "Learning and Development",
      subtitle: "Student learning and development from the work immersion",
    },
    bars: "horizontal",
    axes: {
      x: {
        0: { side: "top", label: "Performance" },
      },
    },
    bar: { groupWidth: "90%" },
  };

  var chart = new google.charts.Bar(document.getElementById("ld-top-x-div"));
  chart.draw(data, options);
}

// Redraw chart on window resize
window.addEventListener("resize", function () {
  drawStuffld();
});
///////////////////////////////////////////////Professionalism CHART///////////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawStuffprof);

function drawStuffprof() {
  var data = new google.visualization.arrayToDataTable([
    ["Category", "Performance"],
    ["Punctuality", averages.avgPunctuality || 0],
    ["Appearance", averages.avgAppearance || 0],
    ["Communication Skills", averages.avgCommunicationSkills || 0],
    ["Respectfulness", averages.avgRespectfulness || 0],
    ["Adaptability", averages.avgAdaptability || 0],
  ]);

  var options = {
    title: "Professionalism",
    height: "100%",
    width: "100%",
    legend: { position: "none" },
    chart: {
      title: "Professionalism",
      subtitle: "Student professionalism from the work immersion",
    },
    bars: "horizontal",
    axes: {
      x: {
        0: { side: "top", label: "Performance" },
      },
    },
    bar: { groupWidth: "90%" },
  };

  var chart = new google.charts.Bar(document.getElementById("pro-top-x-div"));
  chart.draw(data, options);
}

// Redraw chart on window resize
window.addEventListener("resize", function () {
  drawStuffprof();
});
///////////////////////////////////////////////WORK PERFORMANCE CHART///////////////////////////////////////
google.charts.load("current", {
  packages: ["bar"],
});
google.charts.setOnLoadCallback(drawStuff);

function drawStuff() {
  var data = new google.visualization.arrayToDataTable([
    ["Category", "Performance"],
    ["Quality of Work", averages.avgQualityOfWork || 0],
    ["Productivity", averages.avgProductivity || 0],
    ["Problem Solving Skills", averages.avgProblemSolvingSkills || 0],
    ["Attention to Detail", averages.avgAttentionToDetail || 0],
    ["Initiative", averages.avgInitiative || 0],
  ]);

  var options = {
    title: "Work performance",
    height: "100%", // Set height to 100%
    width: "100%", // Set width to 100%
    legend: {
      position: "none",
    },
    chart: {
      title: "Work Performance",
      subtitle: "Student work performance from the work immersion",
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

// Redraw chart on window resize
window.addEventListener("resize", function () {
  drawStuff();
});

// ///////////////////////////////////PIE CART ////////////////////////////////////////
google.charts.setOnLoadCallback(drawChart);
var totalWorkPerformance =
  Number(averages.avgQualityOfWork || 0) +
  Number(averages.avgProductivity || 0) +
  Number(averages.avgProblemSolvingSkills || 0);

var totalProfessionalism =
  Number(averages.avgPunctuality || 0) +
  Number(averages.avgAppearance || 0) +
  Number(averages.avgCommunicationSkills || 0) +
  Number(averages.avgRespectfulness || 0);

var totalLearningAndDevelopment =
  Number(averages.avgWillingnessToLearn || 0) +
  Number(averages.avgApplicationOfFeedback || 0) +
  Number(averages.avgSelfImprovement || 0) +
  Number(averages.avgSkillDevelopment || 0) +
  Number(averages.avgKnowledgeApplication || 0);

var totalTeamWorkAndCollaboration =
  Number(averages.avgTeamParticipation || 0) +
  Number(averages.avgCooperation || 0) +
  Number(averages.avgConflictResolution || 0) +
  Number(averages.avgSupportiveness || 0);

var totalAttitudeAndMotivation =
  Number(averages.avgEnthusiasm || 0) +
  Number(averages.avgDrive || 0) +
  Number(averages.avgResilience || 0) +
  Number(averages.avgCommitment || 0) +
  Number(averages.avgSelfMotivation || 0);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ["Category", "Score"],
    ["Work Performance", totalWorkPerformance],
    ["Professionalism", totalProfessionalism],
    ["Learning and Development", totalLearningAndDevelopment],
    ["Team Work and Collaboration", totalTeamWorkAndCollaboration],
    ["Attitude and Motivation", totalAttitudeAndMotivation],
  ]);
  console.log("Total Work Performance:", totalWorkPerformance);
  console.log("Total Professionalism:", totalProfessionalism);
  console.log("Total Learning and Development:", totalLearningAndDevelopment);
  console.log(
    "Total Team Work and Collaboration:",
    totalTeamWorkAndCollaboration
  );
  console.log("Total Attitude and Motivation:", totalAttitudeAndMotivation);
  var options = {
    title: "Total Work Performance",
    height: "100%",
    width: "100%",
    is3D: true,
  };

  var chart = new google.visualization.PieChart(
    document.getElementById("piechart_3d")
  );
  chart.draw(data, options);
  window.addEventListener("resize", function () {
    if (chart) {
      drawChart();
    }
  });
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
    height: "100%",
    width: "100%",
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
window.addEventListener("resize", function () {
  drawBasicdp();
});
