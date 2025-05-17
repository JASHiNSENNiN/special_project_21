<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$notificationIds = $data['notificationIds'] ?? [];

if (!empty($notificationIds)) {
    $sql = "UPDATE notifications SET is_read = 1 WHERE notification_id IN (" . str_repeat('?,', count($notificationIds) - 1) . '?)';
    $stmt = $conn->prepare($sql);
    
    $types = str_repeat('i', count($notificationIds));
    $stmt->bind_param($types, ...$notificationIds);
    
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Return success response
header('Content-Type: application/json');
echo json_encode(['success' => true]);