<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
(Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/'))->load();

$accountType = $_POST["account-type"];

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];
$email = $_POST['email'];

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
    (Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] .  '/'))->load();
    die("Connection failed: " . $conn->connect_error);
}

$sqlCheck = $conn->prepare("SELECT id FROM users WHERE email = ?");
$sqlCheck->bind_param("s", $email);

$sqlCheck->execute();

$sqlCheck->bind_result($userId);

if ($sqlCheck->fetch()) {
    $sqlCheck->close();

    $sqlUpdate = $conn->prepare("UPDATE users SET account_type = ? WHERE email = ?");
    $sqlUpdate->bind_param("ss", $accountType, $email);
    $sqlUpdate->execute();

    $_SESSION['user_id'] = $userId;

    $sqlUpdate->close();
} else {
    $sqlCheck->close();

    $sqlInsert = $conn->prepare("INSERT INTO users (email, account_type) VALUES (?, ?)");
    $sqlInsert->bind_param("ss", $email, $accountType);
    $sqlInsert->execute();

    $userId = $conn->insert_id;

    $_SESSION['user_id'] = $userId;

    $sqlInsert->close();
}

$storedUserId = $_SESSION['user_id'];
$_SESSION['email'] = $email;

function addNotification($firstName, $lastName, $schoolName) {
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the school user ID
    $schoolUserId = null; 
    $schoolQuery = "SELECT user_id FROM school_profiles WHERE school_name = ?";
    $schoolStmt = $conn->prepare($schoolQuery);
    $schoolStmt->bind_param("s", $schoolName);
    $schoolStmt->execute();
    $schoolStmt->bind_result($schoolUserId);
    $schoolStmt->fetch();
    $schoolStmt->close(); 

    if ($schoolUserId) {
        $notificationMessage = "A new student has registered at your school: " . $firstName . " " . $lastName;

        $notificationQuery = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $notificationStmt = $conn->prepare($notificationQuery);
        $notificationStmt->bind_param("is", $schoolUserId, $notificationMessage);
        $notificationStmt->execute();
        $notificationStmt->close();
    }

    $conn->close();
}

switch ($accountType) {
    case "Student":
        $accType = "Student";
        $firstName = $_POST["first-name"];
        $middleName = $_POST["middle-name"];
        $lastName = $_POST["last-name"];
        $lrn = $_POST["input-lrn"]; 
        $schoolName = $_POST["studentSchoolName"];
        $gradeLevel = $_POST["grade-level"];
        $strand = $_POST["strand"];

        addNotification($firstName, $lastName, $schoolName);

        $stmt = $conn->prepare("INSERT INTO student_profiles (first_name, middle_name, last_name, lrn, school, grade_level, strand, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssi", $firstName, $middleName, $lastName, $lrn, $schoolName, $gradeLevel, $strand, $userId);
        $stmt->execute();
        $stmt->close();
        break;

    case "School":
        $schoolName = $_POST["school-name"];
        $accType = "School";
        $stmt = $conn->prepare("INSERT INTO school_profiles (school_name, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $schoolName, $userId);
        $stmt->execute();
        $stmt->close();
        break;

    case "Organization":
        $organizationName = $_POST["organization-name"];
        $strandFocus = $_POST["strand-focus"];
        $accType = "Organization";
        $stmt = $conn->prepare("INSERT INTO partner_profiles (organization_name, strand, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $organizationName, $strandFocus, $userId);
        $stmt->execute();
        $stmt->close();
        break;
}

$conn->close();
$redirectUrl = "/Account/" . $accType . "/";
header("Location: " . $redirectUrl);
exit;