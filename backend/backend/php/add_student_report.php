<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
$job_id = $_SESSION['current_work']; 
$sql = "SELECT pp.id AS partner_profile_id 
        FROM job_offers jo
        JOIN partner_profiles pp ON jo.partner_id = pp.user_id 
        WHERE jo.id = :job_id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
$stmt->execute();
$work_id = $stmt->fetch(PDO::FETCH_ASSOC);
if ($work_id) {
    $partner_profile_id = $work_id['partner_profile_id'];
} else {
    $partner_profile_id = null; 
}

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// First, let's add a unique constraint if it doesn't exist
$alterTableSQL = "
    ALTER TABLE Organization_Evaluation 
    ADD UNIQUE KEY unique_evaluation (job_id, evaluator_id, day);
";
try {
    $conn->query($alterTableSQL);
} catch (Exception $e) {
    // Constraint might already exist, continue
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents('php://input');
    $radioButtonData = json_decode($json, true);

    if ($radioButtonData) {
        // Extract all the evaluation data
        $quality_of_experience = $radioButtonData["question1"];
        $productivity_of_tasks = $radioButtonData["question2"];
        $problem_solving_opportunities = $radioButtonData["question3"];
        $attention_to_detail_in_guidance = $radioButtonData["question4"];
        $initiative_encouragement = $radioButtonData["question5"];
        $punctuality_expectations = $radioButtonData["question6"];
        $professional_appearance_standards = $radioButtonData["question7"];
        $communication_training = $radioButtonData["question8"];
        $respectfulness_environment = $radioButtonData["question9"];
        $adaptability_challenges = $radioButtonData["question10"];
        $willingness_to_learn_encouragement = $radioButtonData["question11"];
        $feedback_application_opportunities = $radioButtonData["question12"];
        $self_improvement_support = $radioButtonData["question13"];
        $skill_development_assessment = $radioButtonData["question14"];
        $knowledge_application_in_practice = $radioButtonData["question15"];
        $team_participation_opportunities = $radioButtonData["question16"];
        $cooperation_among_peers = $radioButtonData["question17"];
        $conflict_resolution_guidance = $radioButtonData["question18"];
        $supportiveness_among_peers = $radioButtonData["question19"];
        $contribution_to_team_success = $radioButtonData["question20"];
        $enthusiasm_for_tasks = $radioButtonData["question21"];
        $drive_to_achieve_goals = $radioButtonData["question22"];
        $resilience_to_challenges = $radioButtonData["question23"];
        $commitment_to_experience = $radioButtonData["question24"];
        $self_motivation_levels = $radioButtonData["question25"];
        $work_id = $_SESSION['current_work'];
        $date = $radioButtonData['date'];
        $day = $radioButtonData['day'];

        // Prepare the INSERT ... ON DUPLICATE KEY UPDATE statement
        $sql = "INSERT INTO Organization_Evaluation (
            organization_id, evaluator_id, job_id, quality_of_experience, productivity_of_tasks,
            problem_solving_opportunities, attention_to_detail_in_guidance,
            initiative_encouragement, punctuality_expectations,
            professional_appearance_standards, communication_training,
            respectfulness_environment, adaptability_challenges,
            willingness_to_learn_encouragement, feedback_application_opportunities,
            self_improvement_support, skill_development_assessment,
            knowledge_application_in_practice, team_participation_opportunities,
            cooperation_among_peers, conflict_resolution_guidance,
            supportiveness_among_peers, contribution_to_team_success,
            enthusiasm_for_tasks, drive_to_achieve_goals,
            resilience_to_challenges, commitment_to_experience,
            self_motivation_levels, evaluation_date, day
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            quality_of_experience = VALUES(quality_of_experience),
            productivity_of_tasks = VALUES(productivity_of_tasks),
            problem_solving_opportunities = VALUES(problem_solving_opportunities),
            attention_to_detail_in_guidance = VALUES(attention_to_detail_in_guidance),
            initiative_encouragement = VALUES(initiative_encouragement),
            punctuality_expectations = VALUES(punctuality_expectations),
            professional_appearance_standards = VALUES(professional_appearance_standards),
            communication_training = VALUES(communication_training),
            respectfulness_environment = VALUES(respectfulness_environment),
            adaptability_challenges = VALUES(adaptability_challenges),
            willingness_to_learn_encouragement = VALUES(willingness_to_learn_encouragement),
            feedback_application_opportunities = VALUES(feedback_application_opportunities),
            self_improvement_support = VALUES(self_improvement_support),
            skill_development_assessment = VALUES(skill_development_assessment),
            knowledge_application_in_practice = VALUES(knowledge_application_in_practice),
            team_participation_opportunities = VALUES(team_participation_opportunities),
            cooperation_among_peers = VALUES(cooperation_among_peers),
            conflict_resolution_guidance = VALUES(conflict_resolution_guidance),
            supportiveness_among_peers = VALUES(supportiveness_among_peers),
            contribution_to_team_success = VALUES(contribution_to_team_success),
            enthusiasm_for_tasks = VALUES(enthusiasm_for_tasks),
            drive_to_achieve_goals = VALUES(drive_to_achieve_goals),
            resilience_to_challenges = VALUES(resilience_to_challenges),
            commitment_to_experience = VALUES(commitment_to_experience),
            self_motivation_levels = VALUES(self_motivation_levels),
            evaluation_date = VALUES(evaluation_date)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiissssssssssssssssssssssssssi", 
            $partner_profile_id, $_SESSION['user_id'], $work_id, 
            $quality_of_experience, $productivity_of_tasks,
            $problem_solving_opportunities, $attention_to_detail_in_guidance,
            $initiative_encouragement, $punctuality_expectations,
            $professional_appearance_standards, $communication_training,
            $respectfulness_environment, $adaptability_challenges,
            $willingness_to_learn_encouragement, $feedback_application_opportunities,
            $self_improvement_support, $skill_development_assessment,
            $knowledge_application_in_practice, $team_participation_opportunities,
            $cooperation_among_peers, $conflict_resolution_guidance,
            $supportiveness_among_peers, $contribution_to_team_success,
            $enthusiasm_for_tasks, $drive_to_achieve_goals,
            $resilience_to_challenges, $commitment_to_experience,
            $self_motivation_levels, $date, $day);

        if ($stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Data processed successfully']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Error processing data: ' . $stmt->error]);
        }

        $stmt->close();
        $conn->close();
        exit;
    } else {
        echo "Error: No data received.";
    }
}
?>