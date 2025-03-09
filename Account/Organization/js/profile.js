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

// ////////////////////////////upload photo////////////////
function toggleEdit(textareaId) {
  const textarea = document.getElementById(textareaId);
  textarea.readOnly = !textarea.readOnly; // Toggle read-only state
  textarea.focus(); // Focus on the textarea
}

// Add event listeners for each textarea to handle Enter key
const textarea = [
  "about-us-edit-textarea",
  "mission-edit-textarea",
  "vision-edit-textarea",
  "principles-edit-textarea",
  "philosophy-edit-textarea",
];

textareas.forEach((textareaId) => {
  document
    .getElementById(textareaId)
    .addEventListener("keypress", function (event) {
      if (event.key === "Enter") {
        event.preventDefault(); // Prevent the new line character
        this.readOnly = true; // Set to readonly to save text
      }
    });
});

function submitData() {
  const data = {
    aboutUs: document.getElementById("about-us-edit-textarea").value,
    mission: document.getElementById("mission-edit-textarea").value,
    vision: document.getElementById("vision-edit-textarea").value,
    principles: document.getElementById("principles-edit-textarea").value,
    philosophy: document.getElementById("philosophy-edit-textarea").value,
  };

  fetch("your-api-endpoint.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Success:", data);
      // Handle success (e.g., show a message to the user)
    })
    .catch((error) => {
      console.error("Error:", error);
      // Handle error (e.g., show an error message to the user)
    });
}
