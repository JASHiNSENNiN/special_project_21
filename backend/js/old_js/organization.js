function fetchAndRenderApplicants() {
	function renderApplicants(applicants) {
		const applicantsContainer = document.getElementById(
			"applicantsContainer"
		);

		applicants.forEach(function (applicant) {
			const applicantItem = document.createElement("div");
			applicantItem.className = "applicant-item";

			const id = document.createElement("p");
			id.textContent = "ID: " + applicant.id;

			const name = document.createElement("h2");
			name.textContent =
				"Name: " +
				applicant.first_name +
				" " +
				applicant.middle_name +
				" " +
				applicant.last_name;

			const acceptButton = document.createElement("button");
			acceptButton.textContent = "Accept";
			acceptButton.addEventListener("click", function () {
				acceptApplicant(applicant.id);
			});

			const declineButton = document.createElement("button");
			declineButton.textContent = "Decline";
			declineButton.addEventListener("click", function () {
				declineApplicant(applicant.id);
			});

			applicantItem.appendChild(id);
			applicantItem.appendChild(name);
			applicantItem.appendChild(acceptButton);
			applicantItem.appendChild(declineButton);

			applicantsContainer.appendChild(applicantItem);
		});
	}

	function acceptApplicant(applicantId) {
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "../php/accept_applicants.php", true);
		xhr.setRequestHeader(
			"Content-Type",
			"application/x-www-form-urlencoded"
		);
		xhr.onreadystatechange = function () {
			if (xhr.readyState === XMLHttpRequest.DONE) {
				if (xhr.status === 200) {
					console.log("Applicant accepted");
					location.reload();
				} else {
					console.error("Failed to accept applicant");
				}
			}
		};
		xhr.send("applicant_id=" + encodeURIComponent(applicantId));
	}

	function declineApplicant(applicantId) {
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "../php/decline_applicants.php", true);
		xhr.setRequestHeader(
			"Content-Type",
			"application/x-www-form-urlencoded"
		);
		xhr.onreadystatechange = function () {
			if (xhr.readyState === XMLHttpRequest.DONE) {
				if (xhr.status === 200) {
					console.log("Applicant declined");
					location.reload();
				} else {
					console.error("Failed to decline applicant");
				}
			}
		};
		xhr.send("applicant_id=" + encodeURIComponent(applicantId));
	}

	const xhr = new XMLHttpRequest();
	xhr.open("GET", "../php/get_applicants.php", true);
	xhr.onreadystatechange = function () {
		if (xhr.readyState === XMLHttpRequest.DONE) {
			if (xhr.status === 200) {
				if (xhr.responseText !== "") {
					const applicants = JSON.parse(xhr.responseText);
					renderApplicants(applicants);
				}
			} else {
				console.error("Error: " + xhr.status);
			}
		}
	};
	xhr.send();
}

fetchAndRenderApplicants();

function getStudentProfiles() {
	const xhr = new XMLHttpRequest();
	xhr.open("GET", "../php/get_participant_profiles.php", true);

	xhr.onload = function () {
		if (xhr.status === 200) {
			console.log(xhr.responseText);
			const response = JSON.parse(xhr.responseText);
			const studentProfiles = response.student_profiles;

			const table = document.createElement("table");
			table.classList.add("student-profiles-table");

			const tableHeader = document.createElement("tr");
			tableHeader.innerHTML = `
        <th>First Name</th>
        <th>Middle Name</th>
        <th>Last Name</th>
        <th>School</th>
        <th>Grade Level</th>
        <th>Strand</th>
        <th>Stars</th>`;
			table.appendChild(tableHeader);

			studentProfiles.forEach(function (profile) {
				const tableRow = document.createElement("tr");
				tableRow.innerHTML = `
          <td>${profile.first_name}</td>
          <td>${profile.middle_name}</td>
          <td>${profile.last_name}</td>
          <td>${profile.school}</td>
          <td>${profile.grade_level}</td>
          <td>${profile.strand.toUpperCase()}</td>
          <td>${profile.stars}</td>
        `;
				table.appendChild(tableRow);
			});

			const container = document.getElementById("participant-list");
			container.appendChild(table);
		}
	};

	xhr.send();
}

getStudentProfiles();

function populateData() {
	const xhr = new XMLHttpRequest();

	xhr.open("GET", "../php/get_partner_profiles.php", true);
	xhr.setRequestHeader("Content-Type", "application/json");

	xhr.onload = function () {
		if (xhr.status === 200) {
			console.log(xhr.responseText);
			const response = JSON.parse(xhr.responseText);
			console.log(response);
			if (response.success) {
				const orgNameElement = document.getElementById("org-name");
				const orgStrandElement = document.getElementById("org-strand");
				const orgRatingsElement =
					document.getElementById("org-ratings");

				if (response.partner_profile === null) {
					orgNameElement.textContent = "";
					orgStrandElement.textContent = "";
					orgRatingsElement.textContent = "";
				} else {
					orgNameElement.textContent =
						response.partner_profile.organization_name;
					orgStrandElement.textContent =
						response.partner_profile.strand.toUpperCase();
					orgRatingsElement.textContent =
						response.partner_profile.stars;
				}
			}
		}
	};

	xhr.onerror = function () {
		console.log("Error: Request failed");
	};

	xhr.send();
}
populateData();
