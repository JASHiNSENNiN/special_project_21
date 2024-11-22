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

// Function to get applicants for the organization
function getApplicants($conn, $org_id)
{
    $applicants = [];
    $sql = "SELECT a.id, a.student_id, s.first_name, s.last_name, s.strand, s.school, u.profile_image 
            FROM applicants a 
            JOIN student_profiles s ON a.student_id = s.user_id 
            JOIN users u ON s.user_id = u.id 
            WHERE a.job_id IN (SELECT id FROM job_offers WHERE partner_id = ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $org_id);
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
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
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
                    <th>Result</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($applicants as $index => $applicant) {

                    $profile_image = '../Student/uploads/' . $applicant['profile_image']
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
                            <div class="container3">
                                <div class="circular-progress">
                                    <span class="progress-value"></span>
                                </div>
                            </div>
                        </td>
                        <td data-th="Action">
                            <a
                                href="EvaluationForm.php?student_id=<?= base64_encode(encrypt_url_parameter($applicant['student_id'])) ?>">
                                <button class="button-9" role="button">Evaluate</button>
                            </a>
                            <!-- <button class="button-37" role="button">View Profile</button> -->
                            </ td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <footer>
        <!-- <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p> -->
        <p>&copy;2024 Your Website. All rights reserved. | Junior Philippines Computer</p>
    </footer>
</body>

</html>