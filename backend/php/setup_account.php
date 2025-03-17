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
        $accType = "Organization";
        if (!isset($userId)) {
            die("Error: User ID is missing.");
        }
        $organizationName   = trim($_POST["organization_name"] ?? '');
        $strandFocus        = trim($_POST["strand_focus"] ?? '');
        $phoneNumber        = trim($_POST["phone_number"] ?? '');
        $zipCode            = trim($_POST["zip_code"] ?? '');
        $address            = trim($_POST["address"] ?? '');
        $city               = trim($_POST["city"] ?? '');
        $province           = trim($_POST["provinces"] ?? '');
        $aboutUs            = trim($_POST["about_us"] ?? '');
        $corporateVision    = trim($_POST["corporate_vision"] ?? '');
        $corporateMission   = trim($_POST["corporate_mission"] ?? '');
        $corporatePhilosophy= trim($_POST["corporate_philosophy"] ?? '');
        $corporatePrinciples= trim($_POST["corporate_principles"] ?? '');

        // Secure data (Extra sanitization, optional)
        $organizationName   = mysqli_real_escape_string($conn, $organizationName);
        $strandFocus        = mysqli_real_escape_string($conn, $strandFocus);
        $phoneNumber        = mysqli_real_escape_string($conn, $phoneNumber);
        $zipCode            = mysqli_real_escape_string($conn, $zipCode);
        $address            = mysqli_real_escape_string($conn, $address);
        $city               = mysqli_real_escape_string($conn, $city);
        $province           = mysqli_real_escape_string($conn, $province);
        $aboutUs            = mysqli_real_escape_string($conn, $aboutUs);
        $corporateVision    = mysqli_real_escape_string($conn, $corporateVision);
        $corporateMission   = mysqli_real_escape_string($conn, $corporateMission);
        $corporatePhilosophy= mysqli_real_escape_string($conn, $corporatePhilosophy);
        $corporatePrinciples= mysqli_real_escape_string($conn, $corporatePrinciples);

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO partner_profiles 
            (organization_name, strand, phone_number, zip_code, address, city, province, about_us, corporate_vision, corporate_mission, corporate_philosophy, corporate_principles, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("ssssssssssssi", 
            $organizationName, $strandFocus, $phoneNumber, $zipCode, $address, $city, $province, 
            $aboutUs, $corporateVision, $corporateMission, $corporatePhilosophy, $corporatePrinciples, $userId
        );

        if ($stmt->execute()) {
            echo "Organization profile created successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        break;

}

$conn->close();
$redirectUrl = "/Account/" . $accType . "/";
header("Location: " . $redirectUrl);
exit;