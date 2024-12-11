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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['resume_files'])) {
    $userId = $_SESSION['user_id'];
    $firstName = $_SESSION['first_name'];
    $middleName = $_SESSION['middle_name'];
    $lastName = $_SESSION['last_name'];
    $lrn = $_SESSION['lrn'];

    $randomNumber = sprintf('%06d', mt_rand(0, 999999));
    $dateTime = microtime(true);
    $formattedDateTime = DateTime::createFromFormat('U.u', $dateTime)->format('YmdHisv');

    $newFileName = "{$firstName}_{$middleName}_{$lastName}_{$lrn}_resume_{$randomNumber}_{$formattedDateTime}";

    $existingDocumentQuery = $conn->prepare("SELECT document_url FROM uploaded_documents WHERE user_id = ? AND document_name = 'resume'");
    $existingDocumentQuery->bind_param('i', $userId);
    $existingDocumentQuery->execute();
    $result = $existingDocumentQuery->get_result();

    if ($row = $result->fetch_assoc()) {
        $oldFilePath = $row['document_url'];

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $deleteStmt = $conn->prepare("DELETE FROM uploaded_documents WHERE user_id = ? AND document_name = 'resume'");
        $deleteStmt->bind_param('i', $userId);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    foreach ($_FILES['resume_files']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['resume_files']['error'][$key] === UPLOAD_ERR_OK) {
            $originalFileName = basename($_FILES['resume_files']['name'][$key]);
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            $allowedFileExtensions = ['pdf', 'doc', 'docx'];
            $allowedMimeTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'];

            if (in_array($fileExtension, $allowedFileExtensions) && in_array($mimeType, $allowedMimeTypes)) {

                $filePath = "documents/{$newFileName}." . $fileExtension;

                if (move_uploaded_file($tmpName, $filePath)) {

                    $stmt = $conn->prepare("INSERT INTO uploaded_documents (user_id, document_name, document_url) VALUES (?, ?, ?)");
                    $documentName = 'resume';
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
                echo "Invalid file format. Allowed formats: PDF, DOC, DOCX.";
            }
        } else {
            echo "Error uploading file: " . htmlspecialchars($_FILES['resume_files']['name'][$key]);
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['letter_files'])) {
    $userId = $_SESSION['user_id'];
    $firstName = $_SESSION['first_name'];
    $middleName = $_SESSION['middle_name'];
    $lastName = $_SESSION['last_name'];
    $lrn = $_SESSION['lrn'];

    $randomNumber = sprintf('%06d', mt_rand(0, 999999));
    $dateTime = microtime(true);
    $formattedDateTime = DateTime::createFromFormat('U.u', $dateTime)->format('YmdHisv');

    $newFileName = "{$firstName}_{$middleName}_{$lastName}_{$lrn}_application_letter_{$randomNumber}_{$formattedDateTime}";

    // Check if a document already exists for the user
    $existingDocumentQuery = $conn->prepare("SELECT document_url FROM uploaded_documents WHERE user_id = ? AND document_name = 'application_letter'");
    $existingDocumentQuery->bind_param('i', $userId);
    $existingDocumentQuery->execute();
    $result = $existingDocumentQuery->get_result();

    if ($row = $result->fetch_assoc()) {
        $oldFilePath = $row['document_url'];

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $deleteStmt = $conn->prepare("DELETE FROM uploaded_documents WHERE user_id = ? AND document_name = 'application_letter'");
        $deleteStmt->bind_param('i', $userId);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    foreach ($_FILES['letter_files']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['letter_files']['error'][$key] === UPLOAD_ERR_OK) {
            $originalFileName = basename($_FILES['letter_files']['name'][$key]);
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            $allowedFileExtensions = ['pdf', 'doc', 'docx', 'txt'];
            $allowedMimeTypes = [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/msword',
                'text/plain'
            ];

            if (in_array($fileExtension, $allowedFileExtensions) && in_array($mimeType, $allowedMimeTypes)) {

                $filePath = "documents/{$newFileName}." . $fileExtension;

                if (move_uploaded_file($tmpName, $filePath)) {

                    $stmt = $conn->prepare("INSERT INTO uploaded_documents (user_id, document_name, document_url) VALUES (?, ?, ?)");
                    $documentName = 'application_letter';
                    $stmt->bind_param('iss', $userId, $documentName, $filePath);

                    if ($stmt->execute()) {
                        // echo "Application letter uploaded successfully: " . htmlspecialchars($newFileName);
                    } else {
                        echo "Error uploading application letter: " . htmlspecialchars($newFileName);
                    }
                    $stmt->close();
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                echo "Invalid file format for application letter. Allowed formats: PDF, DOC, DOCX, TXT.";
            }
        } else {
            echo "Error uploading application letter: " . htmlspecialchars($_FILES['letter_files']['name'][$key]);
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['parents_consent_files'])) {
    $userId = $_SESSION['user_id'];
    $firstName = $_SESSION['first_name'];
    $middleName = $_SESSION['middle_name'];
    $lastName = $_SESSION['last_name'];
    $lrn = $_SESSION['lrn'];

    $randomNumber = sprintf('%06d', mt_rand(0, 999999));
    $dateTime = microtime(true);
    $formattedDateTime = DateTime::createFromFormat('U.u', $dateTime)->format('YmdHisv');

    $newFileName = "{$firstName}_{$middleName}_{$lastName}_{$lrn}_parents_consent_{$randomNumber}_{$formattedDateTime}";

    $existingDocumentQuery = $conn->prepare("SELECT document_url FROM uploaded_documents WHERE user_id = ? AND document_name = 'parents_consent'");
    $existingDocumentQuery->bind_param('i', $userId);
    $existingDocumentQuery->execute();
    $result = $existingDocumentQuery->get_result();

    if ($row = $result->fetch_assoc()) {
        $oldFilePath = $row['document_url'];

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $deleteStmt = $conn->prepare("DELETE FROM uploaded_documents WHERE user_id = ? AND document_name = 'parents_consent'");
        $deleteStmt->bind_param('i', $userId);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    foreach ($_FILES['parents_consent_files']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['parents_consent_files']['error'][$key] === UPLOAD_ERR_OK) {
            $originalFileName = basename($_FILES['parents_consent_files']['name'][$key]);
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            $allowedFileExtensions = ['pdf', 'doc', 'docx'];
            $allowedMimeTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'];

            if (in_array($fileExtension, $allowedFileExtensions) && in_array($mimeType, $allowedMimeTypes)) {
                $filePath = "documents/{$newFileName}." . $fileExtension;

                if (move_uploaded_file($tmpName, $filePath)) {
                    $stmt = $conn->prepare("INSERT INTO uploaded_documents (user_id, document_name, document_url) VALUES (?, ?, ?)");
                    $documentName = 'parents_consent';
                    $stmt->bind_param('iss', $userId, $documentName, $filePath);

                    if ($stmt->execute()) {
                        // Successfully uploaded parents consent file
                    } else {
                        echo "Error uploading parents consent file: " . htmlspecialchars($newFileName);
                    }
                    $stmt->close();
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                echo "Invalid file format. Allowed formats: PDF, DOC, DOCX.";
            }
        } else {
            echo "Error uploading file: " . htmlspecialchars($_FILES['parents_consent_files']['name'][$key]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['barangay_clearance_files'])) {
    $userId = $_SESSION['user_id'];
    $firstName = $_SESSION['first_name'];
    $middleName = $_SESSION['middle_name'];
    $lastName = $_SESSION['last_name'];
    $lrn = $_SESSION['lrn'];

    $randomNumber = sprintf('%06d', mt_rand(0, 999999));
    $dateTime = microtime(true);
    $formattedDateTime = DateTime::createFromFormat('U.u', $dateTime)->format('YmdHisv');

    $newFileName = "{$firstName}_{$middleName}_{$lastName}_{$lrn}_barangay_clearance_{$randomNumber}_{$formattedDateTime}";

    $existingDocumentQuery = $conn->prepare("SELECT document_url FROM uploaded_documents WHERE user_id = ? AND document_name = 'barangay_clearance'");
    $existingDocumentQuery->bind_param('i', $userId);
    $existingDocumentQuery->execute();
    $result = $existingDocumentQuery->get_result();

    if ($row = $result->fetch_assoc()) {
        $oldFilePath = $row['document_url'];

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $deleteStmt = $conn->prepare("DELETE FROM uploaded_documents WHERE user_id = ? AND document_name = 'barangay_clearance'");
        $deleteStmt->bind_param('i', $userId);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    foreach ($_FILES['barangay_clearance_files']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['barangay_clearance_files']['error'][$key] === UPLOAD_ERR_OK) {
            $originalFileName = basename($_FILES['barangay_clearance_files']['name'][$key]);
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            $allowedFileExtensions = ['pdf', 'doc', 'docx', 'txt'];
            $allowedMimeTypes = [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/msword',
                'text/plain'
            ];

            if (in_array($fileExtension, $allowedFileExtensions) && in_array($mimeType, $allowedMimeTypes)) {
                $filePath = "documents/{$newFileName}." . $fileExtension;

                if (move_uploaded_file($tmpName, $filePath)) {
                    $stmt = $conn->prepare("INSERT INTO uploaded_documents (user_id, document_name, document_url) VALUES (?, ?, ?)");
                    $documentName = 'barangay_clearance';
                    $stmt->bind_param('iss', $userId, $documentName, $filePath);

                    if ($stmt->execute()) {
                        // echo "Barangay clearance uploaded successfully: " . htmlspecialchars($newFileName);
                    } else {
                        echo "Error uploading barangay clearance: " . htmlspecialchars($newFileName);
                    }
                    $stmt->close();
                } else {
                    echo "Failed to move uploaded barangay clearance.";
                }
            } else {
                echo "Invalid file format for barangay clearance. Allowed formats: PDF, DOC, DOCX, TXT.";
            }
        } else {
            echo "Error uploading barangay clearance: " . htmlspecialchars($_FILES['barangay_clearance_files']['name'][$key]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['mayor_permit_files'])) {
    $userId = $_SESSION['user_id'];
    $firstName = $_SESSION['first_name'];
    $middleName = $_SESSION['middle_name'];
    $lastName = $_SESSION['last_name'];
    $lrn = $_SESSION['lrn'];

    $randomNumber = sprintf('%06d', mt_rand(0, 999999));
    $dateTime = microtime(true);
    $formattedDateTime = DateTime::createFromFormat('U.u', $dateTime)->format('YmdHisv');

    $newFileName = "{$firstName}_{$middleName}_{$lastName}_{$lrn}_mayors_permit_{$randomNumber}_{$formattedDateTime}";

    // Check if a document already exists for the user
    $existingDocumentQuery = $conn->prepare("SELECT document_url FROM uploaded_documents WHERE user_id = ? AND document_name = 'mayors_permit'");
    $existingDocumentQuery->bind_param('i', $userId);
    $existingDocumentQuery->execute();
    $result = $existingDocumentQuery->get_result();

    if ($row = $result->fetch_assoc()) {
        $oldFilePath = $row['document_url'];

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        // Optionally delete from database
        $deleteStmt = $conn->prepare("DELETE FROM uploaded_documents WHERE user_id = ? AND document_name = 'mayors_permit'");
        $deleteStmt->bind_param('i', $userId);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    foreach ($_FILES['mayor_permit_files']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['mayor_permit_files']['error'][$key] === UPLOAD_ERR_OK) {
            $originalFileName = basename($_FILES['mayor_permit_files']['name'][$key]);
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            $allowedFileExtensions = ['pdf', 'doc', 'docx', 'txt'];
            $allowedMimeTypes = [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/msword',
                'text/plain'
            ];

            if (in_array($fileExtension, $allowedFileExtensions) && in_array($mimeType, $allowedMimeTypes)) {
                $filePath = "documents/{$newFileName}." . $fileExtension;

                if (move_uploaded_file($tmpName, $filePath)) {
                    $stmt = $conn->prepare("INSERT INTO uploaded_documents (user_id, document_name, document_url) VALUES (?, 'mayors_permit', ?)");
                    $stmt->bind_param('is', $userId, $filePath);

                    if ($stmt->execute()) {
                        // echo "Mayor's Permit uploaded successfully: " . htmlspecialchars($newFileName);
                    } else {
                        echo "Error uploading Mayor's Permit: " . htmlspecialchars($newFileName);
                    }
                    $stmt->close();
                } else {
                    echo "Failed to move uploaded Mayor's Permit.";
                }
            } else {
                echo "Invalid file format for Mayor's Permit. Allowed formats: PDF, DOC, DOCX, TXT.";
            }
        } else {
            echo "Error uploading Mayor's Permit: " . htmlspecialchars($_FILES['mayor_permit_files']['name'][$key]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['police_clearance_files'])) {
    $userId = $_SESSION['user_id'];
    $firstName = $_SESSION['first_name'];
    $middleName = $_SESSION['middle_name'];
    $lastName = $_SESSION['last_name'];
    $lrn = $_SESSION['lrn'];

    $randomNumber = sprintf('%06d', mt_rand(0, 999999));
    $dateTime = microtime(true);
    $formattedDateTime = DateTime::createFromFormat('U.u', $dateTime)->format('YmdHisv');

    $newFileName = "{$firstName}_{$middleName}_{$lastName}_{$lrn}_police_clearance_{$randomNumber}_{$formattedDateTime}";

    // Check if a document already exists for the user
    $existingDocumentQuery = $conn->prepare("SELECT document_url FROM uploaded_documents WHERE user_id = ? AND document_name = 'police_clearance'");
    $existingDocumentQuery->bind_param('i', $userId);
    $existingDocumentQuery->execute();
    $result = $existingDocumentQuery->get_result();

    if ($row = $result->fetch_assoc()) {
        $oldFilePath = $row['document_url'];

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $deleteStmt = $conn->prepare("DELETE FROM uploaded_documents WHERE user_id = ? AND document_name = 'police_clearance'");
        $deleteStmt->bind_param('i', $userId);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    foreach ($_FILES['police_clearance_files']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['police_clearance_files']['error'][$key] === UPLOAD_ERR_OK) {
            $originalFileName = basename($_FILES['police_clearance_files']['name'][$key]);
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            $allowedFileExtensions = ['pdf', 'doc', 'docx', 'txt'];
            $allowedMimeTypes = [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/msword',
                'text/plain'
            ];

            if (in_array($fileExtension, $allowedFileExtensions) && in_array($mimeType, $allowedMimeTypes)) {
                $filePath = "documents/{$newFileName}." . $fileExtension;

                if (move_uploaded_file($tmpName, $filePath)) {
                    $stmt = $conn->prepare("INSERT INTO uploaded_documents (user_id, document_name, document_url) VALUES (?, ?, ?)");
                    $documentName = 'police_clearance';
                    $stmt->bind_param('iss', $userId, $documentName, $filePath);

                    if ($stmt->execute()) {
                        // echo "Police clearance uploaded successfully: " . htmlspecialchars($newFileName);
                    } else {
                        echo "Error uploading police clearance: " . htmlspecialchars($newFileName);
                    }
                    $stmt->close();
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                echo "Invalid file format for police clearance. Allowed formats: PDF, DOC, DOCX, TXT.";
            }
        } else {
            echo "Error uploading police clearance: " . htmlspecialchars($_FILES['police_clearance_files']['name'][$key]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['medical_certificate_files'])) {
    $userId = $_SESSION['user_id'];
    $firstName = $_SESSION['first_name'];
    $middleName = $_SESSION['middle_name'];
    $lastName = $_SESSION['last_name'];
    $lrn = $_SESSION['lrn'];

    $randomNumber = sprintf('%06d', mt_rand(0, 999999));
    $dateTime = microtime(true);
    $formattedDateTime = DateTime::createFromFormat('U.u', $dateTime)->format('YmdHisv');

    $newFileName = "{$firstName}_{$middleName}_{$lastName}_{$lrn}_medical_certificate_{$randomNumber}_{$formattedDateTime}";

    // Check if a document already exists for the user
    $existingDocumentQuery = $conn->prepare("SELECT document_url FROM uploaded_documents WHERE user_id = ? AND document_name = 'medical_certificate'");
    $existingDocumentQuery->bind_param('i', $userId);
    $existingDocumentQuery->execute();
    $result = $existingDocumentQuery->get_result();

    if ($row = $result->fetch_assoc()) {
        $oldFilePath = $row['document_url'];

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $deleteStmt = $conn->prepare("DELETE FROM uploaded_documents WHERE user_id = ? AND document_name = 'medical_certificate'");
        $deleteStmt->bind_param('i', $userId);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    foreach ($_FILES['medical_certificate_files']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['medical_certificate_files']['error'][$key] === UPLOAD_ERR_OK) {
            $originalFileName = basename($_FILES['medical_certificate_files']['name'][$key]);
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            $allowedFileExtensions = ['pdf', 'doc', 'docx'];
            $allowedMimeTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'];

            if (in_array($fileExtension, $allowedFileExtensions) && in_array($mimeType, $allowedMimeTypes)) {
                $filePath = "documents/{$newFileName}." . $fileExtension;

                if (move_uploaded_file($tmpName, $filePath)) {
                    $stmt = $conn->prepare("INSERT INTO uploaded_documents (user_id, document_name, document_url) VALUES (?, ?, ?)");
                    $documentName = 'medical_certificate';
                    $stmt->bind_param('iss', $userId, $documentName, $filePath);

                    if ($stmt->execute()) {
                        // echo "Medical certificate uploaded successfully: " . htmlspecialchars($newFileName);
                    } else {
                        echo "Error uploading medical certificate: " . htmlspecialchars($newFileName);
                    }
                    $stmt->close();
                } else {
                    echo "Failed to move uploaded medical certificate.";
                }
            } else {
                echo "Invalid file format for medical certificate. Allowed formats: PDF, DOC, DOCX.";
            }
        } else {
            echo "Error uploading medical certificate: " . htmlspecialchars($_FILES['medical_certificate_files']['name'][$key]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['insurance_policy_files'])) {
    $userId = $_SESSION['user_id'];
    $firstName = $_SESSION['first_name'];
    $middleName = $_SESSION['middle_name'];
    $lastName = $_SESSION['last_name'];
    $lrn = $_SESSION['lrn'];

    $randomNumber = sprintf('%06d', mt_rand(0, 999999));
    $dateTime = microtime(true);
    $formattedDateTime = DateTime::createFromFormat('U.u', $dateTime)->format('YmdHisv');

    $newFileName = "{$firstName}_{$middleName}_{$lastName}_{$lrn}_insurance_policy_{$randomNumber}_{$formattedDateTime}";

    $existingDocumentQuery = $conn->prepare("SELECT document_url FROM uploaded_documents WHERE user_id = ? AND document_name = 'insurance_policy'");
    $existingDocumentQuery->bind_param('i', $userId);
    $existingDocumentQuery->execute();
    $result = $existingDocumentQuery->get_result();

    if ($row = $result->fetch_assoc()) {
        $oldFilePath = $row['document_url'];

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $deleteStmt = $conn->prepare("DELETE FROM uploaded_documents WHERE user_id = ? AND document_name = 'insurance_policy'");
        $deleteStmt->bind_param('i', $userId);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    foreach ($_FILES['insurance_policy_files']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['insurance_policy_files']['error'][$key] === UPLOAD_ERR_OK) {
            $originalFileName = basename($_FILES['insurance_policy_files']['name'][$key]);
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            $allowedFileExtensions = ['pdf', 'doc', 'docx', 'txt'];
            $allowedMimeTypes = [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/msword',
                'text/plain'
            ];

            if (in_array($fileExtension, $allowedFileExtensions) && in_array($mimeType, $allowedMimeTypes)) {
                $filePath = "documents/{$newFileName}." . $fileExtension;

                if (move_uploaded_file($tmpName, $filePath)) {
                    $stmt = $conn->prepare("INSERT INTO uploaded_documents (user_id, document_name, document_url) VALUES (?, 'insurance_policy', ?)");
                    $stmt->bind_param('is', $userId, $filePath);

                    if ($stmt->execute()) {
                        // echo "Insurance policy uploaded successfully: " . htmlspecialchars($newFileName);
                    } else {
                        echo "Error uploading insurance policy: " . htmlspecialchars($newFileName);
                    }
                    $stmt->close();
                } else {
                    echo "Failed to move uploaded insurance policy.";
                }
            } else {
                echo "Invalid file format for insurance policy. Allowed formats: PDF, DOC, DOCX, TXT.";
            }
        } else {
            echo "Error uploading insurance policy: " . htmlspecialchars($_FILES['insurance_policy_files']['name'][$key]);
        }
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
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="drop_box">
                            <header>
                                <h4>Select Files here</h4>
                            </header>
                            <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                            <input type="file" name="resume_files[]" accept=".doc,.docx,.pdf,.txt" id="Resume" multiple
                                hidden>
                            <button type="button" class="btn"
                                onclick="document.getElementById('Resume').click();">Choose Files</button>
                            <button type="submit" class="btn">Upload Files</button>
                        </div>
                        <ul class="file-list"></ul>
                    </form>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Application Letter</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="drop_box">
                            <header>
                                <h4>Select Files here</h4>
                            </header>
                            <p>Files Supported: PDF, DOC, DOCX, TXT</p>
                            <input type="file" name="letter_files[]" accept=".doc,.docx,.pdf,.txt" id="Letter" multiple
                                hidden>
                            <button type="button" class="btn"
                                onclick="document.getElementById('Letter').click();">Choose Files</button>
                            <button type="submit" class="btn">Upload Files</button>
                        </div>
                        <ul class="file-list"></ul>
                    </form>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Parents Consent</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="drop_box">
                            <header>
                                <h4>Select Files here</h4>
                            </header>
                            <p>Files Supported: PDF, DOC, DOCX</p>
                            <input type="file" name="parents_consent_files[]" accept=".doc,.docx,.pdf" id="Consent"
                                multiple hidden>
                            <button type="button" class="btn"
                                onclick="document.getElementById('Consent').click();">Choose Files</button>
                            <button type="submit" class="btn">Upload Files</button>
                        </div>
                        <ul class="file-list"></ul>
                    </form>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Barangay Clearance</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="drop_box">
                            <header>
                                <h4>Select Files here</h4>
                            </header>
                            <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                            <input type="file" name="barangay_clearance_files[]" accept=".doc,.docx,.pdf,.txt" id="Brgy"
                                multiple hidden>
                            <button type="button" class="btn" onclick="document.getElementById('Brgy').click();">Choose
                                Files</button>
                            <button type="submit" class="btn">Upload Files</button>
                        </div>
                        <ul class="file-list"></ul>
                    </form>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Mayor's Permit</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="drop_box">
                            <header>
                                <h4>Select Files here</h4>
                            </header>
                            <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                            <input type="file" name="mayor_permit_files[]" hidden accept=".doc,.docx,.pdf,.txt"
                                id="Permit" multiple>
                            <button type="button" class="btn"
                                onclick="document.getElementById('Permit').click();">Choose Files</button>
                            <button type="submit" class="btn">Upload Files</button>
                        </div>
                        <ul class="file-list"></ul>
                    </form>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Police Clearance</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="drop_box">
                            <header>
                                <h4>Select Files here</h4>
                            </header>
                            <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                            <input type="file" name="police_clearance_files[]" hidden accept=".doc,.docx,.pdf,.txt"
                                id="Police" multiple>
                            <button type="button" class="btn"
                                onclick="document.getElementById('Police').click();">Choose Files</button>
                            <button type="submit" class="btn">Upload Files</button>
                        </div>
                        <ul class="file-list"></ul>
                    </form>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">
                <div class="card">
                    <h3>Medical Certificate</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="drop_box">
                            <header>
                                <h4>Select Files here</h4>
                            </header>
                            <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                            <input type="file" name="medical_certificate_files[]" accept=".doc,.docx,.pdf,.txt"
                                id="Medical" multiple hidden>
                            <button type="button" class="btn"
                                onclick="document.getElementById('Medical').click();">Choose Files</button>
                            <button type="submit" class="btn">Upload Files</button>
                        </div>
                        <ul class="file-list"></ul>
                    </form>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="container">

                <div class="card">
                    <h3>Insurance Policy</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="drop_box">
                            <header>
                                <h4>Select Files here</h4>
                            </header>
                            <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                            <input type="file" name="insurance_policy_files[]" hidden accept=".doc,.docx,.pdf,.txt"
                                id="Policy" multiple>
                            <button type="button" class="btn"
                                onclick="document.getElementById('Policy').click();">Choose Files</button>
                            <button type="submit" class="btn">Upload Files</button>
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


</body>


</html>