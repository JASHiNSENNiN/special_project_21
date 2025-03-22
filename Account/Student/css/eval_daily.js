google.charts.load("current", {
  packages: ["corechart"],
});
google.charts.setOnLoadCallback(initializedaily);

function initializedaily() {
  const dropdown = document.getElementById("dayDropdown");
  dropdown.addEventListener("change", drawChartdaily);
  drawChartdaily();
  window.addEventListener("resize", drawChartdaily);
}

function drawChartdaily() {
  const dropdown = document.getElementById("dayDropdown");
  const selectedDay = dropdown.value;
  const day = parseInt(selectedDay.replace("Day ", ""));

  const data1 = google.visualization.arrayToDataTable(getChartData1(day));
  const data2 = google.visualization.arrayToDataTable(getChartData2(day));
  const data3 = google.visualization.arrayToDataTable(getChartData3(day));

  const options1 = {
    title: `Work Habits - ${selectedDay}`,
    hAxis: {
      title: "Score (0-5)",
      minValue: 0,
      maxValue: 5,
    },
    vAxis: {
      title: "Category",
    },
    legend: "none",
    height: "100%",
    width: "100%",
  };

  const options2 = {
    title: `Work Skills - ${selectedDay}`,
    hAxis: {
      title: "Score (0-5)",
      minValue: 0,
      maxValue: 5,
    },
    vAxis: {
      title: "Category",
    },
    legend: "none",
    height: "100%",
    width: "100%",
  };

  const options3 = {
    title: `Social Skills - ${selectedDay}`,
    hAxis: {
      title: "Score (0-5)",
      minValue: 0,
      maxValue: 5,
    },
    vAxis: {
      title: "Category",
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
  const evaluation = studentEvaluations[day];
  if (!evaluation) {
    return [
      ["Category", "Score"],
      ["Punctual", 0],
      ["Reports Regularly", 0],
      ["Performs Tasks Independently", 0],
      ["Self Discipline", 0],
      ["Dedication & Commitment", 0],
    ];
  }

  return [
    ["Category", "Score"],
    ["Punctual", evaluation.work_habits.punctual],
    ["Reports Regularly", evaluation.work_habits.reports_regularly],
    [
      "Performs Tasks Independently",
      evaluation.work_habits.performs_tasks_independently,
    ],
    ["Self Discipline", evaluation.work_habits.self_discipline],
    ["Dedication & Commitment", evaluation.work_habits.dedication_commitment],
  ];
}

function getChartData2(day) {
  const evaluation = studentEvaluations[day];
  if (!evaluation) {
    return [
      ["Category", "Score"],
      ["Machine Operation", 0],
      ["Handles Details", 0],
      ["Shows Flexibility", 0],
      ["Thoroughness", 0],
      ["Understands Task Linkages", 0],
      ["Offers Suggestions", 0],
    ];
  }

  return [
    ["Category", "Score"],
    [
      "Machine Operation",
      evaluation.technical_skills.ability_to_operate_machines,
    ],
    ["Handles Details", evaluation.technical_skills.handles_details],
    ["Shows Flexibility", evaluation.technical_skills.shows_flexibility],
    [
      "Thoroughness",
      evaluation.technical_skills.thoroughness_attention_to_detail,
    ],
    [
      "Understands Task Linkages",
      evaluation.technical_skills.understands_task_linkages,
    ],
    ["Offers Suggestions", evaluation.technical_skills.offers_suggestions],
  ];
}

function getChartData3(day) {
  const evaluation = studentEvaluations[day];
  if (!evaluation) {
    return [
      ["Category", "Score"],
      ["Tact with People", 0],
      ["Respect & Courtesy", 0],
      ["Helps Others", 0],
      ["Learns from Co-workers", 0],
      ["Shows Gratitude", 0],
      ["Poise & Confidence", 0],
      ["Emotional Maturity", 0],
    ];
  }

  return [
    ["Category", "Score"],
    [
      "Tact with People",
      evaluation.interpersonal_skills.tact_in_dealing_with_people,
    ],
    [
      "Respect & Courtesy",
      evaluation.interpersonal_skills.respect_and_courtesy,
    ],
    ["Helps Others", evaluation.interpersonal_skills.helps_others],
    [
      "Learns from Co-workers",
      evaluation.interpersonal_skills.learns_from_co_workers,
    ],
    ["Shows Gratitude", evaluation.interpersonal_skills.shows_gratitude],
    [
      "Poise & Confidence",
      evaluation.interpersonal_skills.poise_and_self_confidence,
    ],
    ["Emotional Maturity", evaluation.interpersonal_skills.emotional_maturity],
  ];
}
// ///////////////////////////////////PHOTO UPLOAD///////////////////////////////
document
  .getElementById("file-input")
  .addEventListener("change", function (event) {
    const files = event.target.files;
    const gallery = document.getElementById("gallery");
    gallery.innerHTML = ""; // Clear current gallery

    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();

      reader.onload = function (e) {
        const img = document.createElement("img");
        img.src = e.target.result;
        img.alt = file.name;

        // Click event for the image
        img.addEventListener("click", function () {
          openModal(e.target.result, file.name);
        });

        gallery.appendChild(img);
      };
      reader.readAsDataURL(file);
    }
  });

// Modal functionality
function openModal(src, name) {
  const modal = document.getElementById("image-modal");
  const modalImg = document.getElementById("modal-img");
  const captionText = document.getElementById("caption");
  const downloadBtn = document.getElementById("download-btn");

  modal.style.display = "flex";
  modalImg.src = src;
  captionText.innerHTML = name;
  downloadBtn.style.display = "block";
  downloadBtn.onclick = function () {
    const a = document.createElement("a");
    a.href = src;
    a.download = name;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  };
}

// Close modal when clicking on (x)
document.getElementById("close-modal").onclick = function () {
  document.getElementById("image-modal").style.display = "none";
};
