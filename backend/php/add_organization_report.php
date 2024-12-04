<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$organization_id = $_SESSION['current_organization'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents('php://input');
    $evaluationData = json_decode($json, true);

    if ($evaluationData) {

        if (isset($evaluationData['student_id'])) {
            $encrypted_student_id = $evaluationData['student_id'];
            $student_id = decrypt_url_parameter(base64_decode($encrypted_student_id)); 
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Student ID not provided']);
            exit;
        }

        // Get the current user (evaluator) ID from session
        $evaluator_id = $_SESSION['user_id'] ?? null;
        if (!$evaluator_id) {
            echo json_encode(['status' => 'error', 'message' => 'Evaluator not authenticated']);
            exit;
        }

        // Work Habits
        $punctual = $evaluationData["question1"];  // Punctuality
        $reports_regularly = $evaluationData["question2"];  // Willingness to learn (reporting)
        $performs_tasks_independently = $evaluationData["question3"];  // Initiative
        $self_discipline = $evaluationData["question4"];  // Self-motivation
        $dedication_commitment = $evaluationData["question5"];  // Commitment

        // Work Skills
        $ability_to_operate_machines = $evaluationData["question6"];  // Knowledge application
        $handles_details = $evaluationData["question7"];  // Attention to detail
        $shows_flexibility = $evaluationData["question8"];  // Adaptability
        $thoroughness_attention_to_detail = $evaluationData["question9"];  // Attention to detail (repeated)
        $understands_task_linkages = $evaluationData["question10"];  // Team participation
        $offers_suggestions = $evaluationData["question11"];  // Problem-solving skills

        // Social Skills
        $tact_in_dealing_with_people = $evaluationData["question12"];  // Communication skills
        $respect_and_courtesy = $evaluationData["question13"];  // Respectfulness
        $helps_others = $evaluationData["question14"];  // Supportiveness
        $learns_from_co_workers = $evaluationData["question15"];  // Application of feedback
        $shows_gratitude = $evaluationData["question16"];  // Contribution
        $poise_and_self_confidence = $evaluationData["question17"];  // Skill development
        $emotional_maturity = $evaluationData["question18"];  // Conflict resolution

        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO Student_Evaluation (
            student_id, evaluator_id,
            punctual, reports_regularly, performs_tasks_independently, self_discipline, dedication_commitment,
            ability_to_operate_machines, handles_details, shows_flexibility, 
            thoroughness_attention_to_detail, understands_task_linkages, offers_suggestions,
            tact_in_dealing_with_people, respect_and_courtesy, helps_others, 
            learns_from_co_workers, shows_gratitude, poise_and_self_confidence, 
            emotional_maturity
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("iiiiiiiiiiiiiiiiiiii",
            $student_id, $evaluator_id,
            $punctual, $reports_regularly, $performs_tasks_independently, $self_discipline, $dedication_commitment,
            $ability_to_operate_machines, $handles_details, $shows_flexibility, 
            $thoroughness_attention_to_detail, $understands_task_linkages, $offers_suggestions,
            $tact_in_dealing_with_people, $respect_and_courtesy, $helps_others, 
            $learns_from_co_workers, $shows_gratitude, $poise_and_self_confidence, 
            $emotional_maturity
        );

        if ($stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Evaluation processed successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data: ' . $stmt->error]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: No data received.']);
    }
}
?>