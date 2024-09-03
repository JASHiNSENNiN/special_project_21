<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);


if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS $database";
if (mysqli_query($conn, $sql)) {
  //echo "Database created successfully or already exists\n";
} else {
  //echo "Error creating database: " . mysqli_error($conn) . "\n";
}


mysqli_select_db($conn, $database);

$sql = "
CREATE TABLE IF NOT EXISTS users (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  account_type ENUM('student', 'school', 'organization')
);

CREATE TABLE IF NOT EXISTS school_profiles (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  school_name VARCHAR(255),
  stars INT(10),
  user_id INT(11),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS student_profiles (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(255),
  middle_name VARCHAR(255),
  last_name VARCHAR(255),
  school VARCHAR(255),
  grade_level ENUM('11', '12'),
  strand ENUM('stem', 'humss', 'abm', 'gas', 'tvl'),
  stars INT(10),
  current_work INT(11),
  user_id INT(11),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS partner_profiles (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  organization_name VARCHAR(255),
  stars INT(10),
  user_id INT(11),
  strand ENUM('stem', 'humss', 'abm', 'gas', 'tvl'),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS job_offers (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  work_title VARCHAR(255) NOT NULL,
  strands JSON NOT NULL,
  description TEXT NOT NULL,
  partner_id INT(11) NOT NULL,
  organization_name VARCHAR(255),
  FOREIGN KEY (partner_id) REFERENCES partner_profiles(user_id)
);

CREATE TABLE IF NOT EXISTS applicants (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  partner_id INT(11),
  student_id INT(11),
  FOREIGN KEY (partner_id) REFERENCES partner_profiles(user_id),
  FOREIGN KEY (student_id) REFERENCES student_profiles(user_id)
);

CREATE TABLE IF NOT EXISTS performance_evaluations (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  evaluation_name VARCHAR(255),
  description TEXT,
  start_date DATE,
  end_date DATE,
  location VARCHAR(255),
  user_id INT(11),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS feedback_surveys (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  survey_name VARCHAR(255),
  description TEXT,
  start_date DATE,
  end_date DATE,
  location VARCHAR(255),
  user_id INT(11),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS risk_assessments (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  assessment_name VARCHAR(255),
  description TEXT,
  start_date DATE,
  end_date DATE,
  location VARCHAR(255),
  user_id INT(11),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE otp (
    otp_id INT AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    otp_value VARCHAR(6) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (otp_id)
);
";

if (mysqli_multi_query($conn, $sql)) {
  //echo "Tables created successfully or already exist\n";
} else {
  //echo "Error creating tables: " . mysqli_error($conn) . "\n";
}

$conn->close();
