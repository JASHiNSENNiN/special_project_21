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

        $evaluator_id = $_SESSION['user_id'] ?? null;
        if (!$evaluator_id) {
            echo json_encode(['status' => 'error', 'message' => 'Evaluator not authenticated']);
            exit;
        }

        $date = $evaluationData['date'];
        $day = $evaluationData['day'];

        // Work Habits
        $punctual = $evaluationData["question1"];
        $reports_regularly = $evaluationData["question2"];
        $performs_tasks_independently = $evaluationData["question3"];
        $self_discipline = $evaluationData["question4"];
        $dedication_commitment = $evaluationData["question5"];

        // Work Skills
        $ability_to_operate_machines = $evaluationData["question6"];
        $handles_details = $evaluationData["question7"];
        $shows_flexibility = $evaluationData["question8"];
        $thoroughness_attention_to_detail = $evaluationData["question9"];
        $understands_task_linkages = $evaluationData["question10"];
        $offers_suggestions = $evaluationData["question11"];

        // Social Skills
        $tact_in_dealing_with_people = $evaluationData["question12"];
        $respect_and_courtesy = $evaluationData["question13"];
        $helps_others = $evaluationData["question14"];
        $learns_from_co_workers = $evaluationData["question15"];
        $shows_gratitude = $evaluationData["question16"];
        $poise_and_self_confidence = $evaluationData["question17"];
        $emotional_maturity = $evaluationData["question18"];

        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $checkStmt = $conn->prepare("SELECT student_id FROM Student_Evaluation WHERE student_id = ? AND day = ?");
        $checkStmt->bind_param("ii", $student_id, $day);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
           
            $updateStmt = $conn->prepare("UPDATE Student_Evaluation SET
                evaluator_id = ?, punctual = ?, reports_regularly = ?, performs_tasks_independently = ?, 
                self_discipline = ?, dedication_commitment = ?, ability_to_operate_machines = ?, handles_details = ?, 
                shows_flexibility = ?, thoroughness_attention_to_detail = ?, understands_task_linkages = ?, 
                offers_suggestions = ?, tact_in_dealing_with_people = ?, respect_and_courtesy = ?, helps_others = ?, 
                learns_from_co_workers = ?, shows_gratitude = ?, poise_and_self_confidence = ?, emotional_maturity = ?, 
                evaluation_date = ? 
            WHERE student_id = ? AND day = ?");

            $updateStmt->bind_param("iiiiiiiiiiiiiiiiiiisii",
                            $evaluator_id, $punctual, $reports_regularly, $performs_tasks_independently, $self_discipline, $dedication_commitment,
                            $ability_to_operate_machines, $handles_details, $shows_flexibility, $thoroughness_attention_to_detail, $understands_task_linkages,
                            $offers_suggestions, $tact_in_dealing_with_people, $respect_and_courtesy, $helps_others, $learns_from_co_workers,
                            $shows_gratitude, $poise_and_self_confidence, $emotional_maturity, $date,
                            $student_id, $day
                        );




            if ($updateStmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Evaluation updated successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update data: ' . $updateStmt->error]);
            }
            $updateStmt->close();
        } else {
           
            $stmt = $conn->prepare("INSERT INTO Student_Evaluation (
                student_id, evaluator_id,
                punctual, reports_regularly, performs_tasks_independently, self_discipline, dedication_commitment,
                ability_to_operate_machines, handles_details, shows_flexibility, 
                thoroughness_attention_to_detail, understands_task_linkages, offers_suggestions,
                tact_in_dealing_with_people, respect_and_courtesy, helps_others, 
                learns_from_co_workers, shows_gratitude, poise_and_self_confidence, 
                emotional_maturity, evaluation_date, day
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param("iiiiiiiiiiiiiiiiiiiisi",
                $student_id, $evaluator_id,
                $punctual, $reports_regularly, $performs_tasks_independently, $self_discipline, $dedication_commitment,
                $ability_to_operate_machines, $handles_details, $shows_flexibility, 
                $thoroughness_attention_to_detail, $understands_task_linkages, $offers_suggestions,
                $tact_in_dealing_with_people, $respect_and_courtesy, $helps_others, 
                $learns_from_co_workers, $shows_gratitude, $poise_and_self_confidence, 
                $emotional_maturity,
                $date, 
                $day   
            );

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Evaluation processed successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to insert data: ' . $stmt->error]);
            }

            $stmt->close();
        }

        $checkStmt->close();
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: No data received.']);
    }
}
?>