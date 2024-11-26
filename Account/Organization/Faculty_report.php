<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get applicants for the organization
function getApplicants($conn, $currentOrgId)
{
    $applicants = [];

    $sql = "SELECT a.id AS applicant_id, a.student_id, s.first_name, s.last_name, s.strand, s.school, s.user_id, u.profile_image 
    FROM applicants a 
    JOIN student_profiles s ON a.student_id = s.user_id 
    JOIN users u ON s.user_id = u.id 
    WHERE s.current_work IN (
        SELECT id FROM job_offers WHERE partner_id = ?
    )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $currentOrgId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $applicants[] = $row;
    }

    $stmt->close();
    return $applicants;
}

$org_id = $_SESSION['user_id'];
$applicants = getApplicants($conn, $org_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <link rel="stylesheet" type="text/css" href="css/Faculty_report.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>
</head>

<body>
    <?php echo $profile_div; ?>
    <br>
    <hr>
    <div class="logo">
        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"><i class="fa fa-calendar-plus-o"></i> Job Ads</a>
            <a href="Job_request.php"><i class="fa fa-user-plus"></i>Job Request</a>
            <a class="active1" href="Faculty_report.php"><i class='fas fa-tasks'></i>Student Evaluation</a>
            <a href="Details.php"><i class="fa fa-bar-chart"></i>Analytics</a>
        </nav>
    </div>
    <hr class="line_bottom">

    <div class="container2">
        <h1>Student List</h1>
        <br>
        <table class="rwd-table">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>ID Picture</th>
                    <th>Student Name</th>
                    <th>Average Score</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($applicants as $index => $applicant) {
                    $profile_image = '../Student/uploads/' . $applicant['profile_image'];

                    // Check if the applicant has already evaluated today
                    $sql = "SELECT COUNT(*) as eval_count FROM Student_Evaluation 
            WHERE student_id = :student_id AND evaluation_date = CURDATE()";
                    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':student_id', $applicant['student_id'], PDO::PARAM_INT);
                    $stmt->execute();

                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $has_evaluation_today = $result['eval_count'] > 0;

                    // Calculate average score for the current student
                    $average_sql = "SELECT AVG(quality_of_work) AS avg_quality_of_work,
                           AVG(productivity) AS avg_productivity,
                           AVG(problem_solving_skills) AS avg_problem_solving_skills,
                           AVG(attention_to_detail) AS avg_attention_to_detail,
                           AVG(initiative) AS avg_initiative,
                           AVG(punctuality) AS avg_punctuality,
                           AVG(appearance) AS avg_appearance,
                           AVG(communication_skills) AS avg_communication_skills,
                           AVG(respectfulness) AS avg_respectfulness,
                           AVG(adaptability) AS avg_adaptability,
                           AVG(willingness_to_learn) AS avg_willingness_to_learn,
                           AVG(application_of_feedback) AS avg_application_of_feedback,
                           AVG(self_improvement) AS avg_self_improvement,
                           AVG(skill_development) AS avg_skill_development,
                           AVG(knowledge_application) AS avg_knowledge_application,
                           AVG(team_participation) AS avg_team_participation,
                           AVG(cooperation) AS avg_cooperation,
                           AVG(conflict_resolution) AS avg_conflict_resolution,
                           AVG(supportiveness) AS avg_supportiveness,
                           AVG(contribution) AS avg_contribution,
                           AVG(enthusiasm) AS avg_enthusiasm,
                           AVG(drive) AS avg_drive,
                           AVG(resilience) AS avg_resilience,
                           AVG(commitment) AS avg_commitment,
                           AVG(self_motivation) AS avg_self_motivation
                       FROM Student_Evaluation 
                       WHERE student_id = :student_id";

                    $stmt_avg = $pdo->prepare($average_sql);
                    $stmt_avg->bindParam(':student_id', $applicant['student_id'], PDO::PARAM_INT);
                    $stmt_avg->execute();
                    $avg_result = $stmt_avg->fetch(PDO::FETCH_ASSOC);

                    // Calculate overall average score, ignoring nulls
                    $total_score = 0;
                    $score_count = 0;
                    foreach ($avg_result as $key => $value) {
                        if ($value !== null) {
                            $total_score += $value;
                            $score_count++;
                        }
                    }
                    $average_score = $score_count > 0 ? round($total_score / $score_count, 2) : 0; // Round to 2 decimal places
                    ?>
                    <tr>
                        <td data-th="#"><?= $index + 1 ?></td>
                        <td data-th="ID Picture">

                            <img class="idpic"
                                src="<?= !empty($applicant['profile_image']) ? $profile_image : '../Student/image/Default.png' ?>"
                                alt="Profile Picture">
                        </td>
                        <td data-th="Student Name"><?= $applicant['first_name'] . ' ' . $applicant['last_name'] ?></td>
                        <td data-th="Result">
                            <?= (floor($average_score) == $average_score) ? (int) $average_score : number_format($average_score, 2); ?>/5
                        </td>
                        <!-- Displaying the average score -->
                        <td data-th="Action">
                            <a
                                href="EvaluationForm.php?student_id=<?= base64_encode(encrypt_url_parameter($applicant['student_id'])) ?>">
                                <?php if ($has_evaluation_today): ?>
                                    <button type="button" class="btn_next" disabled>
                                        <span class="time-remaining" id="timer-<?= $index ?>">Timer Starting...</span>
                                    </button>
                                    <script>

                                    </script>
                                <?php else: ?>
                                    <button class="button-9" role="button">Evaluate</button>
                                <?php endif; ?>
                            </a>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
        <!-- <p>&copy;2024 Your Website. All rights reserved. | Junior Philippines Computer</p> -->
    </footer>
</body>

</html>