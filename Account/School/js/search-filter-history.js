document.getElementById("filter-button").addEventListener("click", function () {
  let dateInput = document.getElementById("date").value;
  let clientNameInput = document
    .getElementById("clientname")
    .value.toLowerCase();
  let rows = document.querySelectorAll("#appointments-table tbody tr");
  let visibleCount = 0;

  // Hide the no results message initially
  document.getElementById("no-results").style.display = "none";

  rows.forEach((row) => {
    let appointmentDate = row.getAttribute("data-appointment-date");
    let clientName = row.getAttribute("data-client-name").toLowerCase();

    let dateMatches = !dateInput || appointmentDate === dateInput;
    let clientMatches =
      !clientNameInput || clientName.includes(clientNameInput);

    if (dateMatches && clientMatches) {
      row.style.display = "";
      visibleCount++;
    } else {
      row.style.display = "none";
    }
  });

  // Update appointment count
  document.getElementById("appointment-count").textContent = visibleCount;

  // Show or hide the no results message
  document.getElementById("no-results").style.display =
    visibleCount === 0 ? "block" : "none";
});
