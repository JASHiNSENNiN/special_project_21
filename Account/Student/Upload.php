<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
;
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM job_offers WHERE is_archived = 0";
$result = $conn->query($sql);

$jobOffers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobOffers[] = $row;
    }
}


$conn->close();


// <a href="../../org.php?job_id=' . base64_encode(encrypt_url_parameter((string) $job['id'])) . '" target="_blank"><button class="search-buttons card-buttons">Details</button></a>
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
    <link rel="stylesheet" type="text/css" href="css/Upload.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/modal.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
</head>
<style>

</style>

<body>

    <?php echo $profile_div; ?>

    <br><br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a id="#area" href="Company_area.php"> Company Area</a>
            <a class="active" id="#area" href="Company_area.php"> File Upload</a>
            <!-- <a class="link" id="#review" href="Company_Review.php">Company review</a>
            <a class="link" id="#narrative" href="Narrative_Report.php">Narrative Report</a> -->

        </nav>
    </div>
    <hr class="line_bottom">


    <div class="row">
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Resume</h3>
                    <div class="drop_box">
                        <header>
                            <h4>Select Files here</h4>
                        </header>
                        <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                        <input type="file" hidden accept=".doc,.docx,.pdf,.txt" id="Resume" multiple>
                        <button class="btn">Choose Files</button>
                    </div>
                    <ul class="file-list"></ul>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Application Letter</h3>
                    <div class="drop_box">
                        <header>
                            <h4>Select Files here</h4>
                        </header>
                        <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                        <input type="file" hidden accept=".doc,.docx,.pdf,.txt" id="Letter" multiple>
                        <button class="btn">Choose Files</button>
                    </div>
                    <ul class="file-list"></ul>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Parents Consent</h3>
                    <div class="drop_box">
                        <header>
                            <h4>Select Files here</h4>
                        </header>
                        <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                        <input type="file" hidden accept=".doc,.docx,.pdf,.txt" id="Consent" multiple>
                        <button class="btn">Choose Files</button>
                    </div>
                    <ul class="file-list"></ul>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Barangay Clearance</h3>
                    <div class="drop_box">
                        <header>
                            <h4>Select Files here</h4>
                        </header>
                        <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                        <input type="file" hidden accept=".doc,.docx,.pdf,.txt" id="Brgy" multiple>
                        <button class="btn">Choose Files</button>
                    </div>
                    <ul class="file-list"></ul>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Mayor's Permit</h3>
                    <div class="drop_box">
                        <header>
                            <h4>Select Files here</h4>
                        </header>
                        <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                        <input type="file" hidden accept=".doc,.docx,.pdf,.txt" id="Permit" multiple>
                        <button class="btn">Choose Files</button>
                    </div>
                    <ul class="file-list"></ul>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Police Clearance</h3>
                    <div class="drop_box">
                        <header>
                            <h4>Select Files here</h4>
                        </header>
                        <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                        <input type="file" hidden accept=".doc,.docx,.pdf,.txt" id="Police" multiple>
                        <button class="btn">Choose Files</button>
                    </div>
                    <ul class="file-list"></ul>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Medical Certificate</h3>
                    <div class="drop_box">
                        <header>
                            <h4>Select Files here</h4>
                        </header>
                        <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                        <input type="file" hidden accept=".doc,.docx,.pdf,.txt" id="Medical" multiple>
                        <button class="btn">Choose Files</button>
                    </div>
                    <ul class="file-list"></ul>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Insurance Policy</h3>
                    <div class="drop_box">
                        <header>
                            <h4>Select Files here</h4>
                        </header>
                        <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                        <input type="file" hidden accept=".doc,.docx,.pdf,.txt" id="Policy" multiple>
                        <button class="btn">Choose Files</button>
                    </div>
                    <ul class="file-list"></ul>
                </div>
            </div>
        </div>
    </div>




    <!-- -------------------------------------header stick js ------------------------------ -->
    <script>
        window.onscroll = function () {
            myFunction();
        };

        var header = document.getElementById("myHeader-sticky");
        var sticky = header.offsetTop;

        function myFunction() {
            if (window.pageYOffset > sticky) {
                header.classList.add("stickyhead");
            } else {
                header.classList.remove("stickyhead");
            }
        }
    </script>

    <script type="text/javascript">
        const dropBoxes = document.querySelectorAll(".drop_box");

        dropBoxes.forEach(dropBox => {
            const button = dropBox.querySelector("button");
            const input = dropBox.querySelector("input");
            const fileListElement = dropBox.nextElementSibling; // Get the corresponding file list

            button.onclick = () => {
                input.click();
            };

            input.addEventListener("change", function (e) {
                const files = e.target.files; // Get the selected files
                fileListElement.innerHTML = ''; // Clear the previous file list

                // Display each selected file
                Array.from(files).forEach(file => {
                    let fileItem = document.createElement('li');
                    fileItem.innerHTML = `
                    <h4>${file.name}</h4>
                    <form action="" method="post">
                        <div class="form">
                            <input type="email" placeholder="Enter email to upload file">
                            <button class="btn">Upload</button>
                        </div>
                    </form>
                `;
                    fileListElement.appendChild(fileItem);
                });
            });
        });
    </script>
    <!-- <script type="text/javascript">
        const dropArea = document.querySelector(".drop_box"),
            button = dropArea.querySelector("button"),
            dragText = dropArea.querySelector("header"),
            input = dropArea.querySelector("input");
        let files = [];

        button.onclick = () => {
            input.click();
        };

        input.addEventListener("change", function (e) {
            files = e.target.files; // Get the selected files
            const fileListElement = document.querySelector(".file-list");
            fileListElement.innerHTML = ''; // Clear the previous file list

            // Display each selected file
            Array.from(files).forEach(file => {
                let fileItem = document.createElement('li');
                fileItem.innerHTML = `
      <h4>${file.name}</h4>
      <form action="" method="post">
        <div class="form">
          <input type="email" placeholder="Enter email to upload file">
          <button class="btn">Upload</button>
        </div>
      </form>
    `;
                fileListElement.appendChild(fileItem);
            });
        });
    </script> -->

    <footer>
        <!-- <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p> -->
        ©2024 Your Website. All rights reserved. | Junior Philippines Computer
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>

    <script src="css/filter.js"></script>


</body>


</html>