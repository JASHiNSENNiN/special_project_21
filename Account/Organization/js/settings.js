document
  .getElementById("dataForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    // Gather data from the form
    const phone = document.getElementById("phoneInput").value;
    const zipcode = document.getElementById("zipcodenum").value;
    const address = document.getElementById("inputAddressInput").value;
    const city = document.getElementById("cityInput").value;
    const province = document.getElementById("provinces").value;

    // Prepare data for the API
    const data = {
      phone: phone,
      zipcode: zipcode,
      address: address,
      city: city,
      province: province,
    };

    // Make an API request using Fetch
    fetch("your_api_endpoint.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data), // Send data as JSON
    })
      .then((response) => response.json()) // Parse the JSON response
      .then((data) => {
        // Handle success, display a message or the result
        console.log("Success:", data);
        alert("Data submitted successfully!");
      })
      .catch((error) => {
        // Handle error
        console.error("Error:", error);
        alert("Error submitting data.");
      });
  });
