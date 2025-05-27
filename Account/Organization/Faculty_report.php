<?php
session_start();
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

$userId = $_SESSION['user_id'];

function isDocumentUploaded($documentName)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }

    $sql = "SELECT COUNT(*) FROM uploaded_documents WHERE user_id = :user_id AND document_name = :document_name";
    $stmt = $pdo->prepare($sql);
    $userId = $_SESSION['user_id'];
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':document_name', $documentName, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count > 0;
}

function isOrganizationVerified()
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }

    $sql = "SELECT verified_status FROM partner_profiles WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $userId = $_SESSION['user_id'];
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return (bool) $stmt->fetchColumn();
}

function checkRequiredDocuments()
{
    $requiredDocuments = ['business_permit', 'memorandum_of_agreement'];
    foreach ($requiredDocuments as $document) {
        if (!isDocumentUploaded($document)) {
            header("Location: Verify.php");
            exit();
        }
    }
    if (!isOrganizationVerified()) {
        header("Location: Verify.php");
        exit();
    }
}

checkRequiredDocuments();

// Function to get currently working students for the organization
function getCurrentlyWorkingStudents($conn, $currentOrgId)
{
    $students = [];
    
    $sql = "SELECT DISTINCT
                s.user_id AS student_id, 
                s.first_name, 
                s.last_name, 
                s.strand, 
                s.school, 
                u.profile_image,
                jo.work_title,
                a.status
            FROM 
                student_profiles s 
            JOIN 
                users u ON s.user_id = u.id 
            JOIN 
                applicants a ON s.user_id = a.student_id
            JOIN 
                job_offers jo ON a.job_id = jo.id
            WHERE 
                jo.partner_id = ? 
                AND a.status = 'accepted'
                AND s.current_work = jo.id";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $currentOrgId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    $stmt->close();
    return $students;
}

// Function to get evaluation status and date for each day
function getEvaluationStatusAndDate($conn, $studentId, $evaluatorId, $day) {
    $sql = "SELECT evaluation_date FROM Student_Evaluation 
            WHERE student_id = ? AND day = ?
            ORDER BY evaluation_date DESC LIMIT 1";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $studentId,  $day);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    return $row ? $row['evaluation_date'] : null;
}

$org_id = $_SESSION['user_id'];
$currentlyWorkingStudents = getCurrentlyWorkingStudents($conn, $org_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <link rel="stylesheet" type="text/css" href="css/Faculty_report.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>
    <style>
        .evaluated {
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
        }
        .not-evaluated {
            background-color: #f8d7da;
            color: #721c24;
        }
        .evaluation-status {
            padding: 5px;
            border-radius: 3px;
            text-align: center;
        }
    </style>
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
        </nav>
    </div>
    <hr class="line_bottom">

    <div class="container2">
        <h1>Currently Working Students</h1>
        <i class="txt-des">To print the table, press Ctrl + P.</i>
        <br>
        <br>

        <?php if (empty($currentlyWorkingStudents)): ?>
            <div style="text-align: center; padding: 40px;">
                <h3>No students are currently working</h3>
                <p>Students will appear here once they are accepted for internship positions.</p>
            </div>
        <?php else: ?>
            <table class="rwd-table">
                <tbody>
                    <tr>
                        <th>#</th>
                        <th>ID Picture</th>
                        <th>Student Name</th>
                        <th>Job Position</th>
                        <?php for ($day = 1; $day <= 10; $day++): ?>
                            <th>Day <?= $day ?></th>
                        <?php endfor; ?>
                        <th class="action-tb">Action</th>
                    </tr>
                    <?php foreach ($currentlyWorkingStudents as $index => $student): 
                        $profile_image = '../Student/uploads/' . $student['profile_image'];
                    ?>
                        <tr>
                            <td data-th="#"><?= $index + 1 ?></td>
                            <td data-th="ID Picture">
                                <img class="idpic"
                                    src="<?= !empty($student['profile_image']) ? $profile_image : '../Student/image/Default.png' ?>"
                                    alt="Profile Picture">
                            </td>
                            <td data-th="Student Name">
                                <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                                <br>
                                <small><?= htmlspecialchars($student['strand']) ?> - <?= htmlspecialchars($student['school']) ?></small>
                            </td>
                            <td data-th="Job Position">
                                <?= htmlspecialchars($student['work_title']) ?>
                            </td>
                            <?php for ($day = 1; $day <= 10; $day++): 
                                $evaluationDate = getEvaluationStatusAndDate($conn, $student['student_id'], $org_id, $day);
                                $isEvaluated = !is_null($evaluationDate);
                            ?>
                                <td data-th="Day <?= $day ?>">
                                    <div class="evaluation-status <?= $isEvaluated ? 'evaluated' : 'not-evaluated' ?>">
                                        <?php if ($isEvaluated): ?>
                                            <div><?= date('n/j/Y', strtotime($evaluationDate)) ?></div>
                                            <div style="font-size: 12px; margin-top: 3px;">✓ Done</div>
                                        <?php else: ?>
                                            <div style="font-size: 12px;">✗ Pending</div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endfor; ?>
                            <td class="action-tb" data-th="Action">
                                <a href="EvaluationForm.php?student_id=<?= base64_encode(encrypt_url_parameter($student['student_id'])) ?>">
                                    <button class="button-9" role="button">Evaluate</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script>
        // Function to set progress value
        function setProgress(progress) {
            progress = Math.max(0, Math.min(100, progress));
            const progressValue = document.querySelector('.progress-value');
            if (progressValue) {
                progressValue.textContent = `${progress}%`;
            }
            const circularProgress = document.querySelector('.circular-progress');
            if (circularProgress) {
                circularProgress.style.setProperty('--progress', progress);
            }
        }

        // Example of animating the progress from 0 to 100
        let progress = 0;
        const interval = setInterval(() => {
            progress += 1;
            setProgress(progress);
            if (progress >= 100) {
                clearInterval(interval);
            }
        }, 50);
    </script>

    <script type="text/javascript">
        function toggleNotifications() {
            const extraNotifications = document.querySelector('.extra-notifications');
            const seeMoreLink = document.querySelector('.see-more');

            if (extraNotifications && seeMoreLink) {
                if (extraNotifications.style.display === 'none' || extraNotifications.style.display === '') {
                    extraNotifications.style.display = 'block';
                    seeMoreLink.textContent = 'See Less';
                } else {
                    extraNotifications.style.display = 'none';
                    seeMoreLink.textContent = 'See More';
                }
            }
        }
    </script>

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
    </footer>
</body>

</html>