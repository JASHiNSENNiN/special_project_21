///////////////////////////////////////////////attitude and motivation CHART///////////////////////////////////////
google.charts.load("current", {
  packages: ["bar"],
});
google.charts.setOnLoadCallback(drawStuffam);

function drawStuffam() {
  var data = new google.visualization.arrayToDataTable([
    ["Category", "Performance"],
    ["Enthusiasm for Tasks", avgEnthusiasmForTasks],
    ["Drive to Achieve Goals", avgDriveToAchieveGoals],
    ["Resilience to Challenges", avgResilienceToChallenges],
    ["Commitment to Experience", avgCommitmentToExperience],
    ["Self-Motivation Levels", avgSelfMotivationLevels],
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
    ["Category", "Performance"],
    ["Team Participation Opportunities", avgTeamParticipationOpportunities],
    ["Cooperation Among Peers", avgCooperationAmongPeers],
    ["Conflict Resolution Guidance", avgConflictResolutionGuidance],
    ["Supportiveness Among Peers", avgSupportivenessAmongPeers],
    ["Contribution To Team Success", avgContributionToTeamSuccess],
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
    ["Category", "Performance"],
    ["Willingness to Learn Encouragement", avgWillingnessToLearnEncouragement],
    ["Feedback Application Opportunities", avgFeedbackApplicationOpportunities],
    ["Self-Improvement Support", avgSelfImprovementSupport],
    ["Skill Development Assessment", avgSkillDevelopmentAssessment],
    ["Knowledge Application in Practice", avgKnowledgeApplicationInPractice],
    ["Overall Learning and Development", avgLearningAndDevelopment],
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
    ["Category", "Performance"],
    ["Punctuality Expectations", avgPunctualityExpectations],
    ["Professional Appearance Standards", avgProfessionalAppearanceStandards],
    ["Communication Training", avgCommunicationTraining],
    ["Respectfulness in Environment", avgRespectfulnessEnvironment],
    ["Adaptability to Challenges", avgAdaptabilityChallenges],
    ["Overall Professionalism", avgProfessionalism],
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
    ["Category", "Performance"],
    ["Quality of Experience", avgQualityOfExperience],
    ["Productivity of Tasks", avgProductivityOfTasks],
    ["Problem Solving Opportunities", avgProblemSolvingOpportunities],
    ["Attention to Detail in Guidance", avgAttentionToDetailInGuidance],
    ["Initiative Encouragement", avgInitiativeEncouragement],
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
    hAxis: {
      minValue: 5,
      ticks: [1, 2, 3, 4, 5],
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
    ["Category", "Average"],
    ["Experience", avgExperience],
    ["Professionalism", avgProfessionalism],
    ["Learning and Development", avgLearningAndDevelopment],
    ["Collaboration", avgCollaboration],
    ["Attitude and Motivation", avgAttitudeAndMotivation],
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
    ["Task", "Number of Students"],
    ["HUMSS", strandCounts.humss],
    ["GAS", strandCounts.gas],
    ["STEM", strandCounts.stem],
    ["TVL", strandCounts.tvl],
    ["ABM", strandCounts.abm],
  ]);
  // 'stem', 'humss', 'abm', 'gas', 'tvl'
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
