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



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['business_permit_files'])) {
    $userId = $_SESSION['user_id'];
    $orgName = $_SESSION['organization_name'];

    $randomNumber = sprintf('%06d', mt_rand(0, 999999));
    $dateTime = microtime(true);
    $formattedDateTime = DateTime::createFromFormat('U.u', $dateTime)->format('YmdHisv');

    $newFileName = "{$orgName}_business_permit_{$randomNumber}_{$formattedDateTime}";

    // Check for existing document
    $existingDocumentQuery = $conn->prepare("SELECT document_url FROM uploaded_documents WHERE user_id = ? AND document_name = 'business_permit'");
    $existingDocumentQuery->bind_param('i', $userId);
    $existingDocumentQuery->execute();
    $result = $existingDocumentQuery->get_result();

    if ($row = $result->fetch_assoc()) {
        $oldFilePath = $row['document_url'];

        // Delete old file if it exists
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        // Remove the old entry from the database
        $deleteStmt = $conn->prepare("DELETE FROM uploaded_documents WHERE user_id = ? AND document_name = 'business_permit'");
        $deleteStmt->bind_param('i', $userId);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    foreach ($_FILES['business_permit_files']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['business_permit_files']['error'][$key] === UPLOAD_ERR_OK) {
            $originalFileName = basename($_FILES['business_permit_files']['name'][$key]);
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            $allowedFileExtensions = ['pdf', 'doc', 'docx', 'txt', 'png', 'jpg'];
            $allowedMimeTypes = [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/msword',
                'image/jpeg',
                'image/png'
            ];

            if (in_array($fileExtension, $allowedFileExtensions) && in_array($mimeType, $allowedMimeTypes)) {
                $filePath = "documents/{$newFileName}." . $fileExtension;

                if (move_uploaded_file($tmpName, $filePath)) {

                    $stmt = $conn->prepare("INSERT INTO uploaded_documents (user_id, document_name, document_url) VALUES (?, ?, ?)");
                    $documentName = 'business_permit';
                    $stmt->bind_param('iss', $userId, $documentName, $filePath);

                    if ($stmt->execute()) {

                    } else {
                        echo "Error uploading file: " . htmlspecialchars($newFileName);
                    }
                    $stmt->close();
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                echo "Invalid file format. Allowed formats: PDF, DOC, DOCX, JPG, PNG.";
            }
        } else {
            echo "Error uploading file: " . htmlspecialchars($_FILES['business_permit_files']['name'][$key]);
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['memorandum_of_agreement_files'])) {
    $userId = $_SESSION['user_id'];
    $orgName = $_SESSION['organization_name'];

    $randomNumber = sprintf('%06d', mt_rand(0, 999999));
    $dateTime = microtime(true);
    $formattedDateTime = DateTime::createFromFormat('U.u', $dateTime)->format('YmdHisv');

    $newFileName = "{$orgName}_memorandum_of_agreement_{$randomNumber}_{$formattedDateTime}";

    // Check for existing document
    $existingDocumentQuery = $conn->prepare("SELECT document_url FROM uploaded_documents WHERE user_id = ? AND document_name = 'memorandum_of_agreement'");
    $existingDocumentQuery->bind_param('i', $userId);
    $existingDocumentQuery->execute();
    $result = $existingDocumentQuery->get_result();

    if ($row = $result->fetch_assoc()) {
        $oldFilePath = $row['document_url'];

        // Delete old file if it exists
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        // Remove old entry from the database
        $deleteStmt = $conn->prepare("DELETE FROM uploaded_documents WHERE user_id = ? AND document_name = 'memorandum_of_agreement'");
        $deleteStmt->bind_param('i', $userId);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    foreach ($_FILES['memorandum_of_agreement_files']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['memorandum_of_agreement_files']['error'][$key] === UPLOAD_ERR_OK) {
            $originalFileName = basename($_FILES['memorandum_of_agreement_files']['name'][$key]);
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            // Allowed file types
            $allowedFileExtensions = ['pdf', 'doc', 'docx', 'txt', 'png', 'jpg'];
            $allowedMimeTypes = [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/msword',
                'image/jpeg',
                'image/png'
            ];

            if (in_array($fileExtension, $allowedFileExtensions) && in_array($mimeType, $allowedMimeTypes)) {
                $filePath = "documents/{$newFileName}." . $fileExtension;

                if (move_uploaded_file($tmpName, $filePath)) {

                    $stmt = $conn->prepare("INSERT INTO uploaded_documents (user_id, document_name, document_url) VALUES (?, ?, ?)");
                    $documentName = 'memorandum_of_agreement';
                    $stmt->bind_param('iss', $userId, $documentName, $filePath);

                    if ($stmt->execute()) {

                    } else {
                        echo "Error uploading file: " . htmlspecialchars($newFileName);
                    }
                    $stmt->close();
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                echo "Invalid file format. Allowed formats: PDF, DOC, DOCX, JPG, PNG.";
            }
        } else {
            echo "Error uploading file: " . htmlspecialchars($_FILES['memorandum_of_agreement_files']['name'][$key]);
        }
    }
}


function isDocumentUploaded($documentName)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions
    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }

    $sql = "SELECT COUNT(*) FROM uploaded_documents WHERE user_id = :user_id AND document_name = :document_name";

    $stmt = $pdo->prepare($sql);

    $userId = $_SESSION['user_id'];

    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':document_name', $documentName, PDO::PARAM_STR);

    $stmt->execute();

    $count = $stmt->fetchColumn();

    return $count > 0;
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
            <a class="active" href="Job_ads.php"><i class="fa fa-calendar-plus-o"></i> Job Ads</a>
            <a href="Job_request.php"><i class="fa fa-user-plus"></i> Job Request</a>
            <a href="Faculty_report.php"><i class='fas fa-tasks'></i> Student Evaluation</a>
            <a href="Details.php"><i class="fa fa-bar-chart"></i>Analytics</a>
            <a class="active" id="#area" href="Upload.php"> File Upload</a>

        </nav>
    </div>
    <hr class="line_bottom">


    <div class="row">
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Business Permit
                        <?php if (isDocumentUploaded("business_permit")): ?>
                        <div class="check-icon"></div>
                        <?php endif; ?>
                    </h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="drop_box">
                            <header>
                                <h4>Select Files here</h4>
                            </header>
                            <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
                            <input type="file" name="business_permit_files[]" accept=".doc,.docx,.pdf,.txt,.png,.jpg"
                                id="business_permit" multiple hidden>
                            <button type="button" class="btn"
                                onclick="document.getElementById('business_permit').click();">Choose Files</button>
                            <button type="submit" style="margin-top:10px;" class="btn">Upload Files</button>
                        </div>
                        <ul class="file-list"></ul>
                    </form>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Memorandum of Agreement
                        <?php if (isDocumentUploaded("memorandum_of_agreement")): ?>
                        <div class="check-icon"></div>
                        <?php endif; ?>

                    </h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="drop_box">
                            <header>
                                <h4>Select Files here</h4>
                            </header>
                            <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
                            <input type="file" name="memorandum_of_agreement_files[]"
                                accept=".doc,.docx,.pdf,.txt,.png,.jpg" id="memorandum_of_agreement" multiple hidden>
                            <button type="button" class="btn"
                                onclick="document.getElementById('memorandum_of_agreement').click();">Choose
                                Files</button>
                            <button type="submit" style="margin-top:10px;" class="btn">Upload Files</button>
                        </div>
                        <ul class="file-list"></ul>
                    </form>
                </div>
            </div>
        </div>

    </div>




    <!-- -------------------------------------header stick js ------------------------------ -->
    <script>
    window.onscroll = function() {
        myFunction();
    };
    window.onscroll = function() {
        myFunction();
    };

    var header = document.getElementById("myHeader-sticky");
    var sticky = header.offsetTop;
    var header = document.getElementById("myHeader-sticky");
    var sticky = header.offsetTop;

    function myFunction() {
        if (window.pageYOffset > sticky) {
            header.classList.add("stickyhead");
        } else {
            header.classList.remove("stickyhead");
        }
    }

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
        dropBoxes.forEach(dropBox => {
            const button = dropBox.querySelector("button");
            const input = dropBox.querySelector("input");
            const fileListElement = dropBox.nextElementSibling; // Get the corresponding file list

            button.onclick = () => {
                input.click();
            };
            button.onclick = () => {
                input.click();
            };

            input.addEventListener("change", function(e) {
                const files = e.target.files; // Get the selected files
                fileListElement.innerHTML = ''; // Clear the previous file list

                // Display each selected file
                Array.from(files).forEach(file => {
                    let fileItem = document.createElement('li');
                    fileItem.innerHTML = `
                    <h4>${file.name}</h4>
                    
                `;
                    fileListElement.appendChild(fileItem);
                });
            });
        });
    });
    </script>


    <footer>
        <!-- <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p> -->
        ©2024 Your Website. All rights reserved. | Junior Philippines Computer
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>

    <script src="css/filter.js"></script>

    <script type="text/javascript">
    function toggleNotifications() {
        const extraNotifications = document.querySelector('.extra-notifications');
        const seeMoreLink = document.querySelector('.see-more');

        if (extraNotifications.style.display === 'none' || extraNotifications.style.display === '') {
            extraNotifications.style.display = 'block';
            seeMoreLink.textContent = 'See Less';
        } else {
            extraNotifications.style.display = 'none';
            seeMoreLink.textContent = 'See More';
        }
    }
    </script>


</body>


</html>