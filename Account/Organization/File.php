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

$profile_divv = '<header class="nav-header">
        <div class="logo">
            <a href="Company_Area.php"> 
                <img src="image/drdsnhs.svg" alt="Logo">
            </a>
         
            
        </div>
        <nav class="by">

 
 <div class="menu">
  <div class="item">
    <a class="link">
      <span class="firstname"> <span class="username">Welcome </span> ' . $firstName . ' </span>
      <svg viewBox="0 0 360 360" xml:space="preserve">
        <g id="SVGRepo_iconCarrier">
          <path
            id="XMLID_225_"
            d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393 s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"
          ></path>
        </g>
      </svg>
    </a>
    <div class="submenu">

      <a class="logout"  href="' . '/backend/php/logout.php' . '">
      
      <div class="submenu-item ">
       Log out
      
      </div>
      
      </a>
    
     
    </div>
  </div>
</div>
        
        </nav>

    </header>

    ';



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
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->
    <title>Verification</title>
    <link rel="stylesheet" href="css/File.css">

    <style>
    </style>
</head>

<body>

    <?php echo $profile_divv; ?>



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

    <script type="text/javascript">
        const dropBoxes = document.querySelectorAll(".drop_box");


        dropBoxes.forEach(dropBox => {
            const button = dropBox.querySelector("button");
            const input = dropBox.querySelector("input");
            const fileListElement = dropBox.nextElementSibling;
            dropBoxes.forEach(dropBox => {
                const button = dropBox.querySelector("button");
                const input = dropBox.querySelector("input");
                const fileListElement = dropBox.nextElementSibling;

                button.onclick = () => {
                    input.click();
                };
                button.onclick = () => {
                    input.click();
                };

                input.addEventListener("change", function (e) {
                    const files = e.target.files;
                    fileListElement.innerHTML = '';


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
</body>

</html>