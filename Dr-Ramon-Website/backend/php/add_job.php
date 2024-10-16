<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $workTitle = filter_input(INPUT_POST, 'work_title', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    $strands = filter_input(INPUT_POST, 'strand', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($strands !== null) {
        $strands = array_map('htmlspecialchars', $strands);
        $strandJson = json_encode($strands); // Encode as JSON
    } else {
        $strandJson = json_encode([]); // Default to an empty JSON array
    }

    $partnerId = $_SESSION['user_id'];
    $orgName = $_SESSION['organization_name'];

    if ($partnerId && $workTitle && $description && $strandJson) {
        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO job_offers (work_title, strands, description, partner_id, organization_name) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssis", $workTitle, $strandJson, $description, $partnerId, $orgName);

        if ($stmt->execute() === false) {
            die("Execute failed: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();

        header("Location: /Account/Organization/Job_ads.php");
        exit();
    } else {
        // Handle invalid input or session
        echo "Invalid input or user not logged in." . $partnerId . $workTitle . $description . $strandJson;
    }
}