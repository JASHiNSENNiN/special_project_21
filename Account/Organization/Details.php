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
        $counts['total_students'] = (int) $result_total->fetch_assoc()['total'];

        // Count approved students for these job IDs
        $sql_approved = "SELECT COUNT(DISTINCT student_id) as approved FROM applicants WHERE job_id IN ($job_ids_placeholder) AND status = 'accepted'";
        $stmt_approved = $conn->prepare($sql_approved);
        $stmt_approved->bind_param(str_repeat('i', count($job_ids)), ...$job_ids);
        $stmt_approved->execute();
        $result_approved = $stmt_approved->get_result();
        $counts['approved_students'] = (int) $result_approved->fetch_assoc()['approved'];

        // Count pending students for these job IDs
        $sql_pending = "SELECT COUNT(DISTINCT student_id) as pending FROM applicants WHERE job_id IN ($job_ids_placeholder) AND status != 'accepted'";
        $stmt_pending = $conn->prepare($sql_pending);
        $stmt_pending->bind_param(str_repeat('i', count($job_ids)), ...$job_ids);
        $stmt_pending->execute();
        $result_pending = $stmt_pending->get_result();
        $counts['pending_students'] = (int) $result_pending->fetch_assoc()['pending'];
    }

    $conn->close();
    return $counts;
}

function getDailyPerformanceData()
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "
        SELECT 
            DATE(evaluation_date) as eval_date, 
            AVG(quality_of_experience) as avg_quality,
            AVG(productivity_of_tasks) as avg_productivity,
            AVG(problem_solving_opportunities) as avg_problem_solving,
            AVG(attention_to_detail_in_guidance) as avg_attention,
            AVG(initiative_encouragement) as avg_initiative,
            AVG(punctuality_expectations) as avg_punctuality,
            AVG(professional_appearance_standards) as avg_appearance,
            AVG(communication_training) as avg_communication,
            AVG(respectfulness_environment) as avg_respectfulness,
            AVG(adaptability_challenges) as avg_adaptability,
            AVG(willingness_to_learn_encouragement) as avg_willingness,
            AVG(feedback_application_opportunities) as avg_feedback,
            AVG(self_improvement_support) as avg_self_improvement,
            AVG(skill_development_assessment) as avg_skill_development,
            AVG(knowledge_application_in_practice) as avg_knowledge_application,
            AVG(team_participation_opportunities) as avg_team_participation,
            AVG(cooperation_among_peers) as avg_cooperation,
            AVG(conflict_resolution_guidance) as avg_conflict_resolution,
            AVG(supportiveness_among_peers) as avg_supportiveness,
            AVG(contribution_to_team_success) as avg_contribution,
            AVG(enthusiasm_for_tasks) as avg_enthusiasm,
            AVG(drive_to_achieve_goals) as avg_drive,
            AVG(resilience_to_challenges) as avg_resilience,
            AVG(commitment_to_experience) as avg_commitment,
            AVG(self_motivation_levels) as avg_self_motivation
        FROM Organization_Evaluation
        GROUP BY eval_date
        ORDER BY eval_date DESC
    ";

    $result = $conn->query($query);
    $dataPoints = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $overall_average = array_sum(array_slice($row, 1)) / (count($row) - 1);
            $dataPoints[] = [(strtotime($row['eval_date']) * 1000), $overall_average]; // Convert to milliseconds
        }
    }

    $conn->close();

    return json_encode($dataPoints);
}

function getJobOffers($partner_user_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $job_offers = [];
    $sql = "
        SELECT 
            job_offers.work_title, 
            job_offers.id,
            COUNT(DISTINCT applicants.student_id) as total_students,  -- Count distinct students
            AVG(Organization_Evaluation.quality_of_experience) as avg_quality_of_experience,
            AVG(Organization_Evaluation.productivity_of_tasks) as avg_productivity,
            AVG(Organization_Evaluation.problem_solving_opportunities) as avg_problem_solving,
            AVG(Organization_Evaluation.attention_to_detail_in_guidance) as avg_attention,
            AVG(Organization_Evaluation.initiative_encouragement) as avg_initiative,
            AVG(Organization_Evaluation.punctuality_expectations) as avg_punctuality,
            AVG(Organization_Evaluation.professional_appearance_standards) as avg_appearance,
            AVG(Organization_Evaluation.communication_training) as avg_communication,
            AVG(Organization_Evaluation.respectfulness_environment) as avg_respectfulness,
            AVG(Organization_Evaluation.adaptability_challenges) as avg_adaptability,
            AVG(Organization_Evaluation.willingness_to_learn_encouragement) as avg_willingness,
            AVG(Organization_Evaluation.feedback_application_opportunities) as avg_feedback,
            AVG(Organization_Evaluation.self_improvement_support) as avg_self_improvement,
            AVG(Organization_Evaluation.skill_development_assessment) as avg_skill_development,
            AVG(Organization_Evaluation.knowledge_application_in_practice) as avg_knowledge_application,
            AVG(Organization_Evaluation.team_participation_opportunities) as avg_team_participation,
            AVG(Organization_Evaluation.cooperation_among_peers) as avg_cooperation,
            AVG(Organization_Evaluation.conflict_resolution_guidance) as avg_conflict_resolution,
            AVG(Organization_Evaluation.supportiveness_among_peers) as avg_supportiveness,
            AVG(Organization_Evaluation.contribution_to_team_success) as avg_contribution,
            AVG(Organization_Evaluation.enthusiasm_for_tasks) as avg_enthusiasm,
            AVG(Organization_Evaluation.drive_to_achieve_goals) as avg_drive,
            AVG(Organization_Evaluation.resilience_to_challenges) as avg_resilience,
            AVG(Organization_Evaluation.commitment_to_experience) as avg_commitment,
            AVG(Organization_Evaluation.self_motivation_levels) as avg_self_motivation
        FROM job_offers 
        LEFT JOIN applicants ON job_offers.id = applicants.job_id 
        LEFT JOIN Organization_Evaluation ON job_offers.id = Organization_Evaluation.job_id
        WHERE job_offers.partner_id = ? 
        AND applicants.status IN ('applied', 'accepted')  -- Filter for ongoing students
        GROUP BY job_offers.id
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $partner_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $job_offers[] = $row;
    }

    $conn->close();
    return $job_offers;
}


$dailyPerformance = getDailyPerformanceData();
$studentCounts = getStudentCounts($_SESSION['user_id']);
$jobOffers = getJobOffers($_SESSION['user_id']);
?>
<script>
    var dailyPerformance = <?php echo $dailyPerformance; ?>;
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="stylesheet" type="text/css" href="css/Details.css">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>


    <script src="./css/analytics.js"></script>

</head>

<body>
    <?php echo $profile_div; ?>


    <br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"><i class="fa fa-calendar-plus-o"></i> Job Ads</a>
            <a href="Job_request.php"><i class="fa fa-user-plus"></i>Job Request</a>
            <a href="Faculty_report.php"><i class='fas fa-tasks'></i>Student Evaluation</a>
            <!-- <a href="Question.php">Questions</a> -->
            <a class="active" href="Details.php"><i class="fa fa-bar-chart"></i>Analytics</a>


        </nav>
    </div>
    <hr class="line_bottom">


    <div class="bgc">

        <div class="container-data-box">

            <div class="data-box">

                <p><?php echo $studentCounts['total_students']; ?></p>
                <label>Students</label>
            </div>

            <div class="data-box">

                <p><?php echo $studentCounts['approved_students']; ?></p>
                <label>Deployments</label>
            </div>

            <div class="data-box">

                <p><?php echo $studentCounts['pending_students'] ?></p>
                <label>Applicant Requests</label>
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
        <?php

        if (!empty($jobOffers)) {
            usort($jobOffers, function ($a, $b) {
                return $b['total_students'] <=> $a['total_students'];
            });
        }
        ?>
        <div class="container mt-5">
            <table class="table table-striped" id="job-title">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Rating</th>
                        <th>Total Students</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($jobOffers)): ?>
                        <?php foreach ($jobOffers as $job): ?>
                            <tr class="job_title">
                                <td>
                                    <a
                                        href="../../org.php?job_id=<?php echo urlencode(base64_encode(encrypt_url_parameter((string) $job['id']))); ?>">
                                        <?php echo htmlspecialchars($job['work_title'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="stars-outer">
                                        <div class="stars-inner"
                                            style="width: <?php echo (isset($job['avg_quality_of_experience']) ? $job['avg_quality_of_experience'] : 0) / 5 * 100; ?>%;">
                                        </div>
                                    </div>
                                    <span
                                        class="number-rating"><?php echo number_format(isset($job['avg_quality_of_experience']) ? $job['avg_quality_of_experience'] : 0, 1); ?></span>
                                </td>
                                <td><?php echo (int) $job['total_students']; ?></td>
                            </tr>
                            <script>
                                // Add the average rating for this job offer
                                ratings['job_title_<?php echo $job['id']; ?>'] =
                                    <?php echo isset($job['avg_quality_of_experience']) ? $job['avg_quality_of_experience'] : 0; ?>;
                            </script>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No job offers available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>


    <br>

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
        <!-- <p>&copy;2024 Your Website. All rights reserved. | Junior Philippines Computer</p> -->
    </footer>
    <script>
        // Total Stars
        const starsTotal = 5;

        // Get ratings
        function getRatings() {
            const jobTitles = document.querySelectorAll('.job_title'); // Get all job titles

            jobTitles.forEach((job) => {
                const ratingElement = job.querySelector('.number-rating');

                if (ratingElement) {
                    const ratingValue = parseFloat(ratingElement.innerHTML);
                    // Get percentage
                    const starPercentage = (ratingValue / starsTotal) * 100;

                    // Round to nearest 10
                    const starPercentageRounded = `${Math.round(starPercentage / 10) * 10}%`;
                    const starsInnerElement = job.querySelector('.stars-inner');

                    if (starsInnerElement) {
                        starsInnerElement.style.width = starPercentageRounded;
                    }
                }
            });
        }

        // Run getRatings when DOM loads
        document.addEventListener('DOMContentLoaded', getRatings);
    </script>

    <script>
        let profilePic1 = document.getElementById("cover-pic");
        let inputFile1 = document.getElementById("input-file1");

        inputFile1.onchange = function () {
            profilePic1.src = URL.createObjectURL(inputFile1.files[0])
        };
    </script>

    <script>
        let profilePic2 = document.getElementById("profile-pic");
        let inputFile2 = document.getElementById("input-file2");

        inputFile2.onchange = function () {
            profilePic2.src = URL.createObjectURL(inputFile2.files[0])
        };
    </script>


    <script>
        document.getElementById('searchInput').addEventListener('keypress', function (event) {
            if (event.key === 'Enter') {
                filterTable();
            }
        });

        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('job-title');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[0];
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
                }
            }
        }
    </script>

    <script type="text/javascript">
        function toggleNotifications() {
            const extraNotifications = document.querySelector('.extra-notifications');
            const seeMoreLink = document.querySelector('.see-more');

            if (extraNotifications.style.display === 'none' || extraNotifications.style.display === '') {
                extraNotifications.style.display = 'block';
                seeMoreLink.textContent = 'See Less';
            } else {
                extraNotifications.style.display = 'none';
                seeMoreLink.textContent = 'See More';
            }
        }
    </script>
    <!-- 
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>