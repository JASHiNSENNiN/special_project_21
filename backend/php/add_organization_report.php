<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection credentials
$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

// Get current organization ID from session (assuming this holds the organization ID)
$organization_id = $_SESSION['current_organization'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents('php://input');
    $evaluationData = json_decode($json, true);

    if ($evaluationData) {
        // Decrypt the student ID received in the request
        if (isset($evaluationData['student_id'])) {
            $encrypted_student_id = $evaluationData['student_id'];
            $student_id = decrypt_url_parameter(base64_decode($encrypted_student_id)); 
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Student ID not provided']);
            exit;
        }

        // Retrieve evaluation scores from JSON
        $quality_of_work = $evaluationData["question1"];
        $productivity = $evaluationData["question2"];
        $problem_solving_skills = $evaluationData["question3"];
        $attention_to_detail = $evaluationData["question4"];
        $initiative = $evaluationData["question5"];
        $punctuality = $evaluationData["question6"];
        $appearance = $evaluationData["question7"];
        $communication_skills = $evaluationData["question8"];
        $respectfulness = $evaluationData["question9"];
        $adaptability = $evaluationData["question10"];
        $willingness_to_learn = $evaluationData["question11"];
        $application_of_feedback = $evaluationData["question12"];
        $self_improvement = $evaluationData["question13"];
        $skill_development = $evaluationData["question14"];
        $knowledge_application = $evaluationData["question15"];
        $team_participation = $evaluationData["question16"];
        $cooperation = $evaluationData["question17"];
        $conflict_resolution = $evaluationData["question18"];
        $supportiveness = $evaluationData["question19"];
        $contribution = $evaluationData["question20"];
        $enthusiasm = $evaluationData["question21"];
        $drive = $evaluationData["question22"];
        $resilience = $evaluationData["question23"];
        $commitment = $evaluationData["question24"];
        $self_motivation = $evaluationData["question25"];
        
        // Prepare data insertion
        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO Student_Evaluation (
            student_id, quality_of_work, productivity, problem_solving_skills, 
            attention_to_detail, initiative, punctuality, appearance, 
            communication_skills, respectfulness, adaptability, 
            willingness_to_learn, application_of_feedback, 
            self_improvement, skill_development, knowledge_application, 
            team_participation, cooperation, conflict_resolution, 
            supportiveness, contribution, enthusiasm, drive, 
            resilience, commitment, self_motivation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("isssssssssssssssssssssssss",
            $student_id, $quality_of_work, $productivity, 
            $problem_solving_skills, $attention_to_detail, 
            $initiative, $punctuality, $appearance, 
            $communication_skills, $respectfulness, $adaptability, 
            $willingness_to_learn, $application_of_feedback, 
            $self_improvement, $skill_development, $knowledge_application, 
            $team_participation, $cooperation, $conflict_resolution, 
            $supportiveness, $contribution, $enthusiasm, $drive,
            $resilience, $commitment, $self_motivation);

        // Execute the prepared statement
        if ($stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Data processed successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data: ' . $stmt->error]);
        }

        // Clean up
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: No data received.']);
    }
}
?>