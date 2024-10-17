<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();
require_once 'show_profile.php';

function getStudentCounts($partner_user_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $counts = [
        'total_students' => 0,
        'approved_students' => 0,
        'pending_students' => 0
    ];

    // Get job IDs for the partner
    $sql_jobs = "SELECT id FROM job_offers WHERE partner_id = ?";
    $stmt_jobs = $conn->prepare($sql_jobs);
    $stmt_jobs->bind_param("i", $partner_user_id);
    $stmt_jobs->execute();
    $job_ids_result = $stmt_jobs->get_result();
    
    // Collect job IDs
    $job_ids = [];
    while ($row = $job_ids_result->fetch_assoc()) {
        $job_ids[] = $row['id'];
    }

    if (!empty($job_ids)) {
        // Count total applied students for these job IDs
        $job_ids_placeholder = implode(',', array_fill(0, count($job_ids), '?'));
        $sql_total = "SELECT COUNT(DISTINCT student_id) as total FROM applicants WHERE job_id IN ($job_ids_placeholder)";
        $stmt_total = $conn->prepare($sql_total);
        $stmt_total->bind_param(str_repeat('i', count($job_ids)), ...$job_ids);
        $stmt_total->execute();
        $result_total = $stmt_total->get_result();
        $counts['total_students'] = $result_total->fetch_assoc()['total'];

        // Count approved students for these job IDs
        $sql_approved = "SELECT COUNT(DISTINCT student_id) as approved FROM applicants WHERE job_id IN ($job_ids_placeholder) AND status = 'accepted'";
        $stmt_approved = $conn->prepare($sql_approved);
        $stmt_approved->bind_param(str_repeat('i', count($job_ids)), ...$job_ids);
        $stmt_approved->execute();
        $result_approved = $stmt_approved->get_result();
        $counts['approved_students'] = $result_approved->fetch_assoc()['approved'];

        // Count pending students for these job IDs
        $sql_pending = "SELECT COUNT(DISTINCT student_id) as pending FROM applicants WHERE job_id IN ($job_ids_placeholder) AND status = 'applied'";
        $stmt_pending = $conn->prepare($sql_pending);
        $stmt_pending->bind_param(str_repeat('i', count($job_ids)), ...$job_ids);
        $stmt_pending->execute();
        $result_pending = $stmt_pending->get_result();
        $counts['pending_students'] = $result_pending->fetch_assoc()['pending'];
    }

    $conn->close();
    return $counts;
}

$studentCounts = getStudentCounts($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <!-- <link rel="icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">

    <link rel="stylesheet" type="text/css" href="css/Details.css">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>

    <script src="./css/analytics.js"></script>

</head>

<body>
    <?php echo $profile_div; ?>


    <br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"> Job Ads</a>
            <a href="Job_request.php">Job Request</a>
            <a href="Faculty_report.php">Student Evaluation</a>
            <!-- <a href="Question.php">Questions</a> -->
            <a class="active" href="Details.php">Analytics</a>


        </nav>
    </div>
    <hr class="line_bottom">


    <div class="bgc">

        <div class="container-data-box">

            <div class="data-box">

                <p><?php echo $studentCounts['total_students']; ?></p>
                <label>Total of Student</label>
            </div>

            <div class="data-box">

                <p><?php echo $studentCounts['approved_students']; ?></p>
                <label>Total of Deployment</label>
            </div>

            <div class="data-box">

                <p><?php echo $studentCounts['pending_students'] ?></p>
                <label>Total of Request Applicant</label>
            </div>
        </div>


        <div class="row-analytics">

            <div class="column-1">
                <h3 class="title">Company Performance</h3>
                <div class="dp-graph" id="com_chart_div">
                </div>


            </div>
            <div class="column">
                <h3 class="title">Total Strand Workspace</h3>
                <div class="dp-graph-strand" id="piechart_3d"></div>



            </div>


        </div>

        <!-- <hr class="line_bottom"> -->


    </div>


    <br>

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
    </footer>

    <script>
    let profilePic1 = document.getElementById("cover-pic");
    let inputFile1 = document.getElementById("input-file1");

    inputFile1.onchange = function() {
        profilePic1.src = URL.createObjectURL(inputFile1.files[0])
    };
    </script>

    <script>
    let profilePic2 = document.getElementById("profile-pic");
    let inputFile2 = document.getElementById("input-file2");

    inputFile2.onchange = function() {
        profilePic2.src = URL.createObjectURL(inputFile2.files[0])
    };
    </script>


    <!-- 
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>