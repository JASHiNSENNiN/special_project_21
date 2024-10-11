<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
(Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/'))->load();
$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_id = $_SESSION['user_id'];

function fetch_user_profile($user_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];
    $conn = new mysqli($host, $username, $password, $database);
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function fetch_student_profile($user_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];
    $conn = new mysqli($host, $username, $password, $database);
    $stmt = $conn->prepare("SELECT * FROM student_profiles WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function fetch_school_profile($user_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];
    $conn = new mysqli($host, $username, $password, $database);
    $stmt = $conn->prepare("SELECT * FROM school_profiles WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function fetch_partner_profile($user_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];
    $conn = new mysqli($host, $username, $password, $database);
    $stmt = $conn->prepare("SELECT * FROM partner_profiles WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

$user_profile = fetch_user_profile($user_id);
$_SESSION['email'] = $user_profile['email'];
$_SESSION['account_type'] = $user_profile['account_type'];
$profile_image = '../Account/Student/image/default.png';
if ($user_profile && $user_profile['profile_image']) {
    $profile_image_path = 'uploads/' . $user_profile['profile_image'];
    if (file_exists($profile_image_path)) {
        $_SESSION['profile_image'] = $profile_image_path;
    } else {
        $_SESSION['profile_image'] = "../Account/Student/image/default.png";
    }
}


if ($user_profile['account_type'] === 'student') {
    $student_profile = fetch_student_profile($user_id);
    $_SESSION['id'] = $student_profile['id'];
    $_SESSION['first_name'] = $student_profile['first_name'];
    $_SESSION['middle_name'] = $student_profile['middle_name'];
    $_SESSION['last_name'] = $student_profile['last_name'];
    $_SESSION['school'] = $student_profile['school'];
    $_SESSION['grade_level'] = $student_profile['grade_level'];
    $_SESSION['strand'] = $student_profile['strand'];
    $_SESSION['stars'] = $student_profile['stars'];
    $_SESSION['current_work'] = $student_profile['current_work'];
} elseif ($user_profile['account_type'] === 'school') {
    $school_profile = fetch_school_profile($user_id);
    $_SESSION['school_name'] = $school_profile['school_name'];
    $_SESSION['stars'] = $school_profile['stars'];
} elseif ($user_profile['account_type'] === 'organization') {
    $partner_profile = fetch_partner_profile($user_id);
    $_SESSION['organization_name'] = $partner_profile['organization_name'];
    $_SESSION['stars'] = $partner_profile['stars'];
    $_SESSION['strand'] = $partner_profile['strand'];
}

$conn->close();