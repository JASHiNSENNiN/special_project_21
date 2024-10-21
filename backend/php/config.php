<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
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
  account_type ENUM('student', 'school', 'organization'),
  profile_image VARCHAR(255) DEFAULT 'default.png',
  cover_image VARCHAR(255)
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
  is_archived BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (partner_id) REFERENCES partner_profiles(user_id)
);

CREATE TABLE IF NOT EXISTS applicants (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  job_id INT(11),
  student_id INT(11),
  status ENUM('applied', 'cancelled', 'accepted', 'rejected') DEFAULT 'applied',
  UNIQUE KEY (job_id, student_id),
  FOREIGN KEY (job_id) REFERENCES job_offers(id),
  FOREIGN KEY (student_id) REFERENCES student_profiles(user_id)
);

CREATE TABLE IF NOT EXISTS Student_Evaluation (
    evaluation_id INT PRIMARY KEY,
    student_id INT,
    quality_of_work INT CHECK (quality_of_work BETWEEN 0 AND 5),
    productivity INT CHECK (productivity BETWEEN 0 AND 5),
    problem_solving_skills INT CHECK (problem_solving_skills BETWEEN 0 AND 5),
    attention_to_detail INT CHECK (attention_to_detail BETWEEN 0 AND 5),
    initiative INT CHECK (initiative BETWEEN 0 AND 5),
    punctuality INT CHECK (punctuality BETWEEN 0 AND 5),
    appearance INT CHECK (appearance BETWEEN 0 AND 5),
    communication_skills INT CHECK (communication_skills BETWEEN 0 AND 5),
    respectfulness INT CHECK (respectfulness BETWEEN 0 AND 5),
    adaptability INT CHECK (adaptability BETWEEN 0 AND 5),
    willingness_to_learn INT CHECK (willingness_to_learn BETWEEN 0 AND 5),
    application_of_feedback INT CHECK (application_of_feedback BETWEEN 0 AND 5),
    self_improvement INT CHECK (self_improvement BETWEEN 0 AND 5),
    skill_development INT CHECK (skill_development BETWEEN 0 AND 5),
    knowledge_application INT CHECK (knowledge_application BETWEEN 0 AND 5),
    team_participation INT CHECK (team_participation BETWEEN 0 AND 5),
    cooperation INT CHECK (cooperation BETWEEN 0 AND 5),
    conflict_resolution INT CHECK (conflict_resolution BETWEEN 0 AND 5),
    supportiveness INT CHECK (supportiveness BETWEEN 0 AND 5),
    contribution INT CHECK (contribution BETWEEN 0 AND 5),
    enthusiasm INT CHECK (enthusiasm BETWEEN 0 AND 5),
    drive INT CHECK (drive BETWEEN 0 AND 5),
    resilience INT CHECK (resilience BETWEEN 0 AND 5),
    commitment INT CHECK (commitment BETWEEN 0 AND 5),
    self_motivation INT CHECK (self_motivation BETWEEN 0 AND 5),
    FOREIGN KEY (student_id) REFERENCES student_profiles(id)
);

CREATE TABLE IF NOT EXISTS Organization_Evaluation (
    evaluation_id INT PRIMARY KEY AUTO_INCREMENT,
    organization_id INT,
    quality_of_experience INT CHECK (quality_of_experience BETWEEN 0 AND 5),
    productivity_of_tasks INT CHECK (productivity_of_tasks BETWEEN 0 AND 5),
    problem_solving_opportunities INT CHECK (problem_solving_opportunities BETWEEN 0 AND 5),
    attention_to_detail_in_guidance INT CHECK (attention_to_detail_in_guidance BETWEEN 0 AND 5),
    initiative_encouragement INT CHECK (initiative_encouragement BETWEEN 0 AND 5),
    punctuality_expectations INT CHECK (punctuality_expectations BETWEEN 0 AND 5),
    professional_appearance_standards INT CHECK (professional_appearance_standards BETWEEN 0 AND 5),
    communication_training INT CHECK (communication_training BETWEEN 0 AND 5),
    respectfulness_environment INT CHECK (respectfulness_environment BETWEEN 0 AND 5),
    adaptability_challenges INT CHECK (adaptability_challenges BETWEEN 0 AND 5),
    willingness_to_learn_encouragement INT CHECK (willingness_to_learn_encouragement BETWEEN 0 AND 5),
    feedback_application_opportunities INT CHECK (feedback_application_opportunities BETWEEN 0 AND 5),
    self_improvement_support INT CHECK (self_improvement_support BETWEEN 0 AND 5),
    skill_development_assessment INT CHECK (skill_development_assessment BETWEEN 0 AND 5),
    knowledge_application_in_practice INT CHECK (knowledge_application_in_practice BETWEEN 0 AND 5),
    team_participation_opportunities INT CHECK (team_participation_opportunities BETWEEN 0 AND 5),
    cooperation_among_peers INT CHECK (cooperation_among_peers BETWEEN 0 AND 5),
    conflict_resolution_guidance INT CHECK (conflict_resolution_guidance BETWEEN 0 AND 5),
    supportiveness_among_peers INT CHECK (supportiveness_among_peers BETWEEN 0 AND 5),
    contribution_to_team_success INT CHECK (contribution_to_team_success BETWEEN 0 AND 5),
    enthusiasm_for_tasks INT CHECK (enthusiasm_for_tasks BETWEEN 0 AND 5),
    drive_to_achieve_goals INT CHECK (drive_to_achieve_goals BETWEEN 0 AND 5),
    resilience_to_challenges INT CHECK (resilience_to_challenges BETWEEN 0 AND 5),
    commitment_to_experience INT CHECK (commitment_to_experience BETWEEN 0 AND 5),
    self_motivation_levels INT CHECK (self_motivation_levels BETWEEN 0 AND 5),
    FOREIGN KEY (organization_id) REFERENCES partner_profiles(id)
);
";

if (mysqli_multi_query($conn, $sql)) {
  //echo "Tables created successfully or already exist\n";
} else {
  echo "Error creating tables: " . mysqli_error($conn) . "\n";
}


$conn->close();

$key = $_ENV['ENCRYPTION_KEY'];

function encrypt_url_parameter($data)
{
  global  $key;
  $cipher = "aes-256-cbc";
  $ivlen = openssl_cipher_iv_length($cipher);
  $iv = openssl_random_pseudo_bytes($ivlen);
  $encrypted_data = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
  return base64_encode($iv . $encrypted_data);
}

function decrypt_url_parameter($encrypted_data)
{
  global  $key;
  $cipher = "aes-256-cbc";
  $ivlen = openssl_cipher_iv_length($cipher);
  $data = base64_decode($encrypted_data);
  $iv = substr($data, 0, $ivlen);
  $encrypted_data = substr($data, $ivlen);
  return openssl_decrypt($encrypted_data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
}