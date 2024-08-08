<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
(Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] .  '/'))->load();

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($host, $username, $password, $database);

    $_SESSION['email'] = filter_var($_POST['register_email'], FILTER_SANITIZE_EMAIL);
    $Password = password_hash($_POST['register_password'], PASSWORD_BCRYPT, ['cost' => 15]);
    $_SESSION['password'] = $Password;

    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $_SESSION['email'], $_SESSION['password']);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    $destination = '/get_started.php';
    header("Location: $destination");
    exit();
}
