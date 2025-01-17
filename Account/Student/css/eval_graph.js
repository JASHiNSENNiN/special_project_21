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
// google.charts.load("current", { packages: ["bar"] });
// google.charts.setOnLoadCallback(drawStuffam);

// function drawStuffam() {
//   var data = new google.visualization.arrayToDataTable([
//     ["Category", "Performance"],
//     ["Enthusiasm", averages.avgEnthusiasm],
//     ["Drive", averages.avgDrive],
//     ["Resilience", averages.avgResilience],
//     ["Commitment", averages.avgCommitment],
//     ["Self Motivation", averages.avgSelfMotivation],
//   ]);

//   var options = {
//     title: "Attitude and Motivation",
//     height: "100%",
//     width: "100%",
//     legend: { position: "none" },
//     chart: {
//       title: "Attitude and Motivation",
//       subtitle: "Student attitude and motivation from the work immersion",
//     },
//     bars: "horizontal",
//     axes: {
//       x: {
//         0: { side: "top", label: "Performance" },
//       },
//     },
//     bar: { groupWidth: "90%" },
//   };

//   var chart = new google.charts.Bar(document.getElementById("am-top-x-div"));
//   chart.draw(data, options);
// }
// window.addEventListener("resize", function () {
//   drawStufftc();
// });
//////////////////////////////////////////////Team work and Collaboration CHART///////////////////////////////////////
// google.charts.load("current", { packages: ["bar"] });
// google.charts.setOnLoadCallback(drawStufftc);

// function drawStufftc() {
//   var data = new google.visualization.arrayToDataTable([
//     ["Category", "Performance"],
//     ["Team Participation", averages.avgTeamParticipation],
//     ["Cooperation", averages.avgCooperation],
//     ["Conflict Resolution", averages.avgConflictResolution],
//     ["Supportiveness", averages.avgSupportiveness],
//     ["Contribution", averages.avgContribution],
//   ]);

//   var options = {
//     title: "Team work and Collaboration",
//     height: "100%",
//     width: "100%",
//     legend: { position: "none" },
//     chart: {
//       title: "Team work and Collaboration",
//       subtitle: "Student team work and collaboration from the work immersion",
//     },
//     bars: "horizontal",
//     axes: {
//       x: {
//         0: { side: "top", label: "Performance" },
//       },
//     },
//     bar: { groupWidth: "90%" },
//   };

//   var chart = new google.charts.Bar(document.getElementById("tc-top-x-div"));
//   chart.draw(data, options);
// }
// window.addEventListener("resize", function () {
//   drawStufftc();
// });
/////////////////////////////////////////////// Social Skills CHART ///////////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawSocialSkillsChart);

function drawSocialSkillsChart() {
  var data = new google.visualization.arrayToDataTable([
    ["Category", "Performance"],
    ["Tact in Dealing with People", averages.avgTactInDealingWithPeople || 0],
    ["Respect and Courtesy", averages.avgRespectAndCourtesy || 0],
    ["Helps Others", averages.avgHelpsOthers || 0],
    ["Learns from Co-Workers", averages.avgLearnsFromCoWorkers || 0],
    ["Shows Gratitude", averages.avgShowsGratitude || 0],
    ["Poise and Self Confidence", averages.avgPoiseAndSelfConfidence || 0],
    ["Emotional Maturity", averages.avgEmotionalMaturity || 0],
  ]);

  var options = {
    title: "Social Skills",
    height: "100%",
    width: "100%",
    legend: { position: "none" },
    chart: {
      title: "Social Skills",
      subtitle: "Student social skills from the work immersion",
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
  drawSocialSkillsChart();
});
/////////////////////////////////////////////// WORK SKILLS CHART ///////////////////////////////////////
google.charts.load("current", { packages: ["bar"] });
google.charts.setOnLoadCallback(drawWorkSkillsChart);

function drawWorkSkillsChart() {
  var data = new google.visualization.arrayToDataTable([
    ["Category", "Performance"],
    ["Ability to Operate Machines", averages.avgAbilityToOperateMachines || 0],
    ["Handles Details", averages.avgHandlesDetails || 0],
    ["Shows Flexibility", averages.avgShowsFlexibility || 0],
    [
      "Thoroughness & Attention to Detail",
      averages.avgThoroughnessAttentionToDetail || 0,
    ],
    ["Understands Task Linkages", averages.avgUnderstandsTaskLinkages || 0],
    ["Offers Suggestions", averages.avgOffersSuggestions || 0],
  ]);

  var options = {
    title: "Work Skills",
    height: "100%",
    width: "100%",
    legend: { position: "none" },
    chart: {
      title: "Work Skills",
      subtitle: "Student work skills from the work immersion",
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
  drawWorkSkillsChart();
});
/////////////////////////////////////////////// WORK HABITS CHART ///////////////////////////////////////
google.charts.load("current", {
  packages: ["bar"],
});
google.charts.setOnLoadCallback(drawWorkHabitsChart);

function drawWorkHabitsChart() {
  var data = new google.visualization.arrayToDataTable([
    ["Category", "Performance"],
    ["Punctuality", averages.avgPunctual || 0],
    ["Reports Regularly", averages.avgReportsRegularly || 0],
    [
      "Performs Tasks Independently",
      averages.avgPerformsTasksIndependently || 0,
    ],
    ["Self Discipline", averages.avgSelfDiscipline || 0],
    ["Dedication & Commitment", averages.avgDedicationCommitment || 0],
  ]);

  var options = {
    title: "Work Habits",
    height: "100%", // Set height to 100%
    width: "100%", // Set width to 100%
    legend: { position: "none" },
    chart: {
      title: "Work Habits",
      subtitle: "Student work habits from the work immersion",
    },
    bars: "horizontal", // Required for Material Bar Charts.
    axes: {
      x: {
        0: { side: "top", label: "Performance" }, // Top x-axis.
      },
    },
    bar: { groupWidth: "90%" },
  };

  var chart = new google.charts.Bar(document.getElementById("wp-top-x-div"));
  chart.draw(data, options);
}

// Redraw chart on window resize
window.addEventListener("resize", function () {
  drawWorkHabitsChart();
});

// /////////////////////////////////// PIE CHART ////////////////////////////////////////
google.charts.setOnLoadCallback(drawChart);

// Calculate totals for each category
var totalWorkHabits =
  Number(averages.avgPunctual || 0) +
  Number(averages.avgReportsRegularly || 0) +
  Number(averages.avgPerformsTasksIndependently || 0) +
  Number(averages.avgSelfDiscipline || 0) +
  Number(averages.avgDedicationCommitment || 0);

var totalWorkSkills =
  Number(averages.avgAbilityToOperateMachines || 0) +
  Number(averages.avgHandlesDetails || 0) +
  Number(averages.avgShowsFlexibility || 0) +
  Number(averages.avgThoroughnessAttentionToDetail || 0) +
  Number(averages.avgUnderstandsTaskLinkages || 0) +
  Number(averages.avgOffersSuggestions || 0);

var totalSocialSkills =
  Number(averages.avgTactInDealingWithPeople || 0) +
  Number(averages.avgRespectAndCourtesy || 0) +
  Number(averages.avgHelpsOthers || 0) +
  Number(averages.avgLearnsFromCoWorkers || 0) +
  Number(averages.avgShowsGratitude || 0) +
  Number(averages.avgPoiseAndSelfConfidence || 0) +
  Number(averages.avgEmotionalMaturity || 0);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ["Category", "Score"],
    ["Work Habits", totalWorkHabits],
    ["Work Skills", totalWorkSkills],
    ["Social Skills", totalSocialSkills],
  ]);

  console.log("Total Work Habits:", totalWorkHabits);
  console.log("Total Work Skills:", totalWorkSkills);
  console.log("Total Social Skills:", totalSocialSkills);

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

  // Redraw chart on window resize
  window.addEventListener("resize", function () {
    if (chart) {
      drawChart();
    }
  });
}
// ///////////////////////////////////DAILY PERFORMACE CART ////////////////////////////////////////
google.charts.load("current", { packages: ["corechart", "line"] });
google.charts.setOnLoadCallback(drawDailyPerformanceChart);

function drawDailyPerformanceChart() {
  var dp_data = new google.visualization.DataTable();
  dp_data.addColumn("string", "Date"); // X-axis as Date
  dp_data.addColumn("number", "Performance Rating"); // Y-axis as Performance Rating

  // Convert dailyPerformance data to DataTable rows
  dailyPerformance.forEach(function (entry) {
    dp_data.addRow([entry.date, entry.score]); // Add each entry as a new row
  });

  var options = {
    title: "Daily Performance",
    height: "100%",
    width: "100%",
    hAxis: {
      title: "Date",
      format: "MMM dd", // Format for date on X-axis
    },
    vAxis: {
      title: "Performance Rating",
      minValue: 0,
      maxValue: 5, // Assuming your rating maximum limit is 5
    },
    legend: { position: "bottom" },
  };

  var dp_chart = new google.visualization.LineChart(
    document.getElementById("dp_chart_div")
  );
  dp_chart.draw(dp_data, options);
}

// Redraw the chart on window resize
window.addEventListener("resize", function () {
  drawDailyPerformanceChart();
});
////////////////////////////// Profile strength ///////////////////////////////////

(function ($) {
  $.fn.progress = function () {
    var percent = this.data("percent");
    this.css("width", percent + "%");
  };
})(jQuery);

$(document).ready(function () {
  $(".bar-one .bar").progress();
});

let slideIndex = 0;
showSlides();

function showSlides() {
  let slides = document.getElementsByClassName("mySlides");
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }
  slides[slideIndex - 1].style.display = "block";
}

function nextSlide() {
  let slides = document.getElementsByClassName("mySlides");
  slides[slideIndex - 1].style.display = "none";
  slideIndex++;
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }
  slides[slideIndex - 1].style.display = "block";
}

// //////////////////////////////////////upload file js/////////////////////////////////

jQuery(document).ready(function ($) {
  // Helper function to keep table row from collapsing when being sorted
  var fixHelperModified = function (e, tr) {
    var originals = tr.children(),
      helper = tr.clone();
    helper.children().each(function (index) {
      $(this).width(originals.eq(index).width());
    });
    return helper;
  };

  // Make diagnosis table sortable
  $("table#sortableTable tbody")
    .sortable({
      helper: fixHelperModified,
      update: function () {
        renumber_table("#sortableTable");
      },
    })
    .disableSelection();

  // Delete button in table rows
  $("table").on("click", ".btn-delete", function () {
    var tableID = "#" + $(this).closest("table").attr("id"),
      r = confirm("Delete this item?");
    if (r) {
      $(this).closest("tr").remove();
      renumber_table(tableID);
    }
  });

  var size;
  var filename;
  $("#uploadFile").on("change", function () {
    if (window.ActiveXObject) {
      var fso = new ActiveXObject("Scripting.FileSystemObject"),
        path = this.val(),
        thefile = fso.getFile(path),
        sizeinbytes = thefile.size;
    } else {
      sizeinbytes = this.files[0].size;
    }
    var list_size = new Array("Bytes", "KB", "MB", "GB"),
      fSize = sizeinbytes;
    i = 0;
    while (fSize > 900) {
      fSize /= 1024;
      i++;
    }
    size = Math.round(fSize * 100) / 100 + " " + list_size[i];
    filename = this.files[0].name;

    var fileExist = false;
    $("#sortableTable-docu td.name").each(function () {
      if ($(this).html() == filename) {
        $("#sortableTable-docu td.size").each(function () {
          if ($(this).html() == size) {
            fileExist = true;
          }
        });
      }
    });
    if (fileExist === true) {
      alert("File already exists!");
      $("#uploadFile").val("");
      return false;
    } else {
      $(".btn-add").removeAttr("disabled");
    }
  });

  // Add a row to table
  $(".btn-add").on("click", function () {
    // Get current date
    var d = new Date();
    var date_modified =
      d.getDate() +
      "/" +
      (d.getMonth() + 1) +
      "/" +
      d.getFullYear() +
      " " +
      d.getHours() +
      ":" +
      d.getMinutes() +
      ":" +
      d.getSeconds();

    // Get the selected document type
    var documentType = $("#documentType").val();

    if (filename !== undefined && size !== undefined && documentType !== "") {
      // Append to the table
      $("table#sortableTable-docu tbody").append(
        "<tr>" +
          '<td class="name">' +
          documentType +
          "</td>" + // Display the selected document type
          '<td class="name">' +
          filename +
          "</td>" +
          "<td>" +
          '<a class="btn btn-download btn-success" href="#" download="' +
          filename +
          '">Download</a>' +
          '<a class="btn btn-view btn-info" href="view_document.php?document_name=' +
          encodeURIComponent(filename) +
          '" target="_blank">View</a>' +
          '<a class="btn btn-delete btn-danger button-delete">Delete</a>' +
          "</td>" +
          "</tr>"
      );
      renumber_table("#sortableTable-docu");
    } else {
      alert("Please upload a file and select a document type.");
    }

    $("#uploadFile").val("");
    $("#documentType").val(""); // Reset the document type selection
    $(this).attr("disabled", "disabled");
  });
  // Download button in table rows
  $("table").on("click", ".btn-download", function (e) {
    e.preventDefault(); // Prevent the default anchor behavior
    var filename = $(this).attr("download"); // Get the filename from the download attribute

    // Create a Blob with some content (for demonstration purposes)
    var content = "This is the content of the file: " + filename; // Replace with actual file content
    var blob = new Blob([content], { type: "text/plain" }); // Create a Blob object
    var url = URL.createObjectURL(blob); // Create a URL for the Blob

    // Create a temporary anchor element to trigger the download
    var a = document.createElement("a");
    a.href = url;
    a.download = filename; // Set the filename for the download
    document.body.appendChild(a); // Append the anchor to the body
    a.click(); // Trigger the download
    document.body.removeChild(a); // Remove the anchor from the document
  });

  // Renumber table rows
  function renumber_table(tableID) {
    $(tableID + " tr").each(function () {
      var count = $(this).parent().children().index($(this)) + 1;
      $(this).find(".priority").html(count);
    });
    $(".successfully-saved").css("display", "block").delay(1000).fadeOut(600);
  }

  // Table header sorter
  function sortTable(table, col, reverse) {
    var tb = table.tBodies[0], // use `<tbody>` to ignore `<thead>` and `<tfoot>` rows
      tr = Array.prototype.slice.call(tb.rows, 0), // put rows into array
      i;
    reverse = -(+reverse || -1);
    tr = tr.sort(function (a, b) {
      // sort rows
      return (
        reverse *
        a.cells[col].textContent
          .trim()
          .localeCompare(b.cells[col].textContent.trim())
      );
    });
    for (i = 0; i < tr.length; ++i) tb.appendChild(tr[i]); // append each row in order
  }

  function makeSortable(table) {
    var th = table.tHead,
      i;
    th && (th = th.rows[0]) && (th = th.cells);
    if (th) i = th.length;
    else return; // if no `<thead>` then do nothing
    while (--i >= 0)
      (function (i) {
        var dir = 1;
        th[i].addEventListener("click", function () {
          sortTable(table, i, (dir = 1 - dir));
        });
      })(i);
  }

  function makeAllSortable(parent) {
    parent = parent || document.body;
    var t = parent.getElementsByTagName("table"),
      i = t.length;
    while (--i >= 0) makeSortable(t[i]);
  }

  window.onload = function () {
    makeAllSortable();
  };
});
// ////////////////////////////////////////DAILY PERFORMANCE CART////////////////////////////////////////
