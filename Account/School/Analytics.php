<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';


$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

function getStudentsBySchool($conn, $schoolName)
{
    $students = [];

    // Prepare the SQL query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM student_profiles WHERE school = ?");
    $stmt->bind_param("s", $schoolName); // "s" means the parameter is a string

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch all students into an array
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    // Close the statement
    $stmt->close();

    return $students;
}

function countStrands($students)
{
    $strandCounts = [
        'humss' => 0,
        'stem' => 0,
        'gas' => 0,
        'tvl' => 0,
        'abm' => 0,
    ];

    foreach ($students as $student) {
        $strand = strtolower($student['strand']);
        if (array_key_exists($strand, $strandCounts)) {
            $strandCounts[$strand]++;
        }
    }

    return $strandCounts;
}

function fetchEvaluationData($conn)
{

    $school_name = $_SESSION['school_name'];

    $sql = "
    SELECT SE.evaluation_id, 
           SP.first_name, 
           SP.last_name,
           SE.punctual,
           SE.reports_regularly,
           SE.performs_tasks_independently,
           SE.self_discipline,
           SE.dedication_commitment
    FROM Student_Evaluation SE
    JOIN student_profiles SP ON SE.student_id = SP.user_id 
    WHERE SP.school = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $school_name);
    $stmt->execute();
    $result = $stmt->get_result();

    $evaluation_data = [];
    while ($row = $result->fetch_assoc()) {
        $evaluation_data[] = [
            'name' => $row['first_name'] . ' ' . $row['last_name'],
            'punctual' => (int) $row['punctual'],
            'reports_regularly' => (int) $row['reports_regularly'],
            'performs_tasks_independently' => (int) $row['performs_tasks_independently'],
            'self_discipline' => (int) $row['self_discipline'],
            'dedication_commitment' => (int) $row['dedication_commitment'],
        ];
    }

    return $evaluation_data;
}


function fetchTopStudentsWorkHabits($conn)
{

    $school_name = $_SESSION['school_name'];

    $query = "
            SELECT 
                sp.first_name, 
                sp.last_name, 
                ROUND((
                    COALESCE(punctual, 0) + 
                    COALESCE(reports_regularly, 0) + 
                    COALESCE(performs_tasks_independently, 0) + 
                    COALESCE(self_discipline, 0) + 
                    COALESCE(dedication_commitment, 0)
                ) / 5, 2) AS average_work_habits_score
            FROM 
                Student_Evaluation se
            JOIN 
                student_profiles sp ON se.student_id = sp.user_id
            WHERE 
                sp.school = ?
            ORDER BY 
                average_work_habits_score DESC
            LIMIT 5
        ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $school_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $topStudents = [];

        while ($row = $result->fetch_assoc()) {
            $topStudents[] = [
                'name' => $row['first_name'] . ' ' . $row['last_name'],
                'average_score' => $row['average_work_habits_score']
            ];
        }

        return $topStudents;
    } else {
        error_log("Error fetching top students: " . $conn->error);
        return [];
    }
}

function fetchTopStudentsWorkSkills($conn)
{
    $school_name = $_SESSION['school_name'];

    $query = "
            SELECT 
                sp.first_name, 
                sp.last_name, 
                ROUND((
                    COALESCE(ability_to_operate_machines, 0) + 
                    COALESCE(handles_details, 0) + 
                    COALESCE(shows_flexibility, 0) + 
                    COALESCE(thoroughness_attention_to_detail, 0) + 
                    COALESCE(understands_task_linkages, 0) + 
                    COALESCE(offers_suggestions, 0)
                ) / 6, 2) AS average_skills_score
            FROM 
                Student_Evaluation se
            JOIN 
                student_profiles sp ON se.student_id = sp.user_id
            WHERE 
                sp.school = ?
            ORDER BY 
                average_skills_score DESC
            LIMIT 5
        ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $school_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $topStudents = [];

        while ($row = $result->fetch_assoc()) {
            $topStudents[] = [
                'name' => $row['first_name'] . ' ' . $row['last_name'],
                'average_score' => $row['average_skills_score']
            ];
        }

        return $topStudents;
    } else {
        error_log("Error fetching top students: " . $conn->error);
        return [];
    }
}

function fetchTopStudentsSocialSkills($conn)
{
    $school_name = $_SESSION['school_name'];

    $query = "
            SELECT 
                sp.first_name, 
                sp.last_name, 
                ROUND((
                    COALESCE(tact_in_dealing_with_people, 0) + 
                    COALESCE(respect_and_courtesy, 0) + 
                    COALESCE(helps_others, 0) + 
                    COALESCE(learns_from_co_workers, 0) + 
                    COALESCE(shows_gratitude, 0) + 
                    COALESCE(poise_and_self_confidence, 0) + 
                    COALESCE(emotional_maturity, 0)
                ) / 7, 2) AS average_social_skills_score
            FROM 
                Student_Evaluation se
            JOIN 
                student_profiles sp ON se.student_id = sp.user_id
            WHERE 
                sp.school = ?
            ORDER BY 
                average_social_skills_score DESC
            LIMIT 5
        ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $school_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $topStudents = [];

        while ($row = $result->fetch_assoc()) {
            $topStudents[] = [
                'name' => $row['first_name'] . ' ' . $row['last_name'],
                'average_score' => $row['average_social_skills_score']
            ];
        }

        return $topStudents;
    } else {
        error_log("Error fetching top students: " . $conn->error);
        return [];
    }
}

function fetchJobOffersWithStudentCount($conn)
{
    $school_name = $_SESSION['school_name'];

    $query = "
    SELECT 
        jo.work_title, 
        pp.organization_name,
        COUNT(DISTINCT a.student_id) AS student_count
    FROM 
        job_offers jo
    LEFT JOIN 
        applicants a ON jo.id = a.job_id
    JOIN 
        partner_profiles pp ON jo.partner_id = pp.user_id
    JOIN 
        student_profiles sp ON sp.current_work = jo.id
    WHERE 
        sp.school = ?
    AND 
        jo.is_archived = FALSE
    GROUP BY 
        jo.id, jo.work_title, pp.organization_name
    ORDER BY 
        student_count DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $school_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $jobOffers = [];

        while ($row = $result->fetch_assoc()) {
            $jobOffers[] = [
                'work_title' => $row['work_title'],
                'organization_name' => $row['organization_name'],
                'student_count' => $row['student_count']
            ];
        }

        return $jobOffers;
    } else {
        error_log("Error fetching job offers: " . $conn->error);
        return [];
    }
}


function fetchTopStudents($conn)
{
    $school_name = $_SESSION['school_name'];

    $query = "
    SELECT 
        sp.first_name, 
        sp.last_name, 
        ROUND(
            (punctual + 
            reports_regularly + 
            performs_tasks_independently + 
            self_discipline + 
            dedication_commitment + 
            ability_to_operate_machines + 
            handles_details + 
            shows_flexibility + 
            thoroughness_attention_to_detail + 
            understands_task_linkages + 
            offers_suggestions + 
            tact_in_dealing_with_people + 
            respect_and_courtesy + 
            helps_others + 
            learns_from_co_workers + 
            shows_gratitude + 
            poise_and_self_confidence + 
            emotional_maturity)
        ) AS total_score
    FROM 
        Student_Evaluation se
    JOIN 
        student_profiles sp ON se.student_id = sp.user_id
    WHERE 
        sp.school = ?
    ORDER BY 
        total_score DESC
    LIMIT 10
";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $school_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $topStudents = [];

        while ($row = $result->fetch_assoc()) {
            $topStudents[] = [
                'name' => $row['first_name'] . ' ' . $row['last_name'],
                'score' => $row['total_score']
            ];
        }

        return $topStudents;
    } else {
        error_log("Error fetching top students: " . $conn->error);
        return [];
    }
}


$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchCompanyAverages($conn)
{
    $school_name = $_SESSION['school_name'];

    $query = "
    SELECT 
        pp.organization_name,
        ROUND(AVG(
            punctual + 
            reports_regularly + 
            performs_tasks_independently + 
            self_discipline + 
            dedication_commitment + 
            ability_to_operate_machines + 
            handles_details + 
            shows_flexibility + 
            thoroughness_attention_to_detail + 
            understands_task_linkages + 
            offers_suggestions + 
            tact_in_dealing_with_people + 
            respect_and_courtesy + 
            helps_others + 
            learns_from_co_workers + 
            shows_gratitude + 
            poise_and_self_confidence + 
            emotional_maturity
        ), 2) AS company_average
    FROM 
        Student_Evaluation se
    JOIN 
        student_profiles sp ON se.student_id = sp.user_id
    JOIN 
        applicants a ON sp.user_id = a.student_id
    JOIN 
        job_offers jo ON a.job_id = jo.id
    JOIN 
        partner_profiles pp ON jo.partner_id = pp.user_id
    WHERE 
        sp.school = ?
        AND a.status = 'accepted'
    GROUP BY 
        pp.organization_name
    ORDER BY 
        company_average DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $school_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $companyData = [];

        while ($row = $result->fetch_assoc()) {
            $companyData[] = [
                'company' => $row['organization_name'],
                'average' => $row['company_average']
            ];
        }

        return $companyData;
    } else {
        error_log("Error fetching company averages: " . $conn->error);
        return [];
    }
}

// Function to fetch strand comparison data
function fetchStrandComparisonData($conn)
{
    $school_name = $_SESSION['school_name'];

    $query = "
    SELECT 
        sp.strand,
        -- Work Habits Average
        ROUND(AVG(
            punctual + 
            reports_regularly + 
            performs_tasks_independently + 
            self_discipline + 
            dedication_commitment
        ), 2) AS work_habits_avg,
        -- Work Skills Average  
        ROUND(AVG(
            ability_to_operate_machines + 
            handles_details + 
            shows_flexibility + 
            thoroughness_attention_to_detail + 
            understands_task_linkages + 
            offers_suggestions
        ), 2) AS work_skills_avg,
        -- Social Skills Average
        ROUND(AVG(
            tact_in_dealing_with_people + 
            respect_and_courtesy + 
            helps_others + 
            learns_from_co_workers + 
            shows_gratitude + 
            poise_and_self_confidence + 
            emotional_maturity
        ), 2) AS social_skills_avg
    FROM 
        Student_Evaluation se
    JOIN 
        student_profiles sp ON se.student_id = sp.user_id
    WHERE 
        sp.school = ?
    GROUP BY 
        sp.strand
    ORDER BY 
        sp.strand
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $school_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $strandData = [];
        $overallTotals = [
            'work_habits' => 0,
            'work_skills' => 0,
            'social_skills' => 0,
            'count' => 0
        ];

        while ($row = $result->fetch_assoc()) {
            $strandData[] = [
                'strand' => strtoupper($row['strand']),
                'work_habits' => $row['work_habits_avg'],
                'work_skills' => $row['work_skills_avg'],
                'social_skills' => $row['social_skills_avg']
            ];

            // Calculate overall totals for average line
            $overallTotals['work_habits'] += $row['work_habits_avg'];
            $overallTotals['work_skills'] += $row['work_skills_avg'];
            $overallTotals['social_skills'] += $row['social_skills_avg'];
            $overallTotals['count']++;
        }

        // Calculate overall averages
        if ($overallTotals['count'] > 0) {
            $overallAverages = [
                'work_habits' => round($overallTotals['work_habits'] / $overallTotals['count'], 2),
                'work_skills' => round($overallTotals['work_skills'] / $overallTotals['count'], 2),
                'social_skills' => round($overallTotals['social_skills'] / $overallTotals['count'], 2)
            ];
        } else {
            $overallAverages = [
                'work_habits' => 0,
                'work_skills' => 0,
                'social_skills' => 0
            ];
        }

        return [
            'strand_data' => $strandData,
            'overall_averages' => $overallAverages
        ];
    } else {
        error_log("Error fetching strand comparison data: " . $conn->error);
        return [
            'strand_data' => [],
            'overall_averages' => []
        ];
    }
}

// Function to generate JavaScript data for company pie chart
function generateCompanyChartJS($companyData)
{
    $jsData = "var companyAverageData = [\n";
    $jsData .= "    ['Company', 'Overall Average'],\n";

    foreach ($companyData as $company) {
        $jsData .= "    ['" . addslashes($company['company']) . "', " . $company['average'] . "],\n";
    }

    $jsData .= "];\n";
    return $jsData;
}

// Function to generate JavaScript data for strand comparison chart
function generateStrandChartJS($strandComparisonData)
{
    $strandData = $strandComparisonData['strand_data'];
    $overallAvg = $strandComparisonData['overall_averages'];

    $jsData = "var strandComparisonData = [\n";

    // Header row
    $jsData .= "    ['Category'";
    foreach ($strandData as $strand) {
        $jsData .= ", '" . $strand['strand'] . "'";
    }
    $jsData .= ", 'Average'],\n";

    // Work Habits row
    $jsData .= "    ['Work Habits'";
    foreach ($strandData as $strand) {
        $jsData .= ", " . $strand['work_habits'];
    }
    $jsData .= ", " . $overallAvg['work_habits'] . "],\n";

    // Work Skills row
    $jsData .= "    ['Work Skills'";
    foreach ($strandData as $strand) {
        $jsData .= ", " . $strand['work_skills'];
    }
    $jsData .= ", " . $overallAvg['work_skills'] . "],\n";

    // Social Skills row
    $jsData .= "    ['Social Skills'";
    foreach ($strandData as $strand) {
        $jsData .= ", " . $strand['social_skills'];
    }
    $jsData .= ", " . $overallAvg['social_skills'] . "]\n";

    $jsData .= "];\n";
    return $jsData;
}


if (isset($_SESSION['school_name'])) {
    $schoolName = $_SESSION['school_name'];
    $students = getStudentsBySchool($conn, $schoolName);

    $strandCounts = countStrands($students);


    $topStudentsData = fetchTopStudents($conn);

    $topStudentsDataJson = json_encode([
        ['Student', 'Rating'],
        ...array_map(function ($student) {
            return [$student['name'], $student['score']];
        }, $topStudentsData)
    ]);

    $topStudentsDataWorkHabits = fetchTopStudentsWorkHabits($conn);

    $topStudentsDataJsonWorkHabits = json_encode([
        ['Student', 'Rating'],
        ...array_map(function ($student) {
            return [$student['name'], $student['average_score']];
        }, $topStudentsDataWorkHabits)
    ]);

    $topStudentsDataWorkSkills = fetchTopStudentsWorkSkills($conn);

    $topStudentsDataJsonWorkSkills = json_encode([
        ['Student', 'Rating'],
        ...array_map(function ($student) {
            return [$student['name'], $student['average_score']];
        }, $topStudentsDataWorkSkills)
    ]);

    $topStudentsDataSocialSkills = fetchTopStudentsSocialSkills($conn);

    $topStudentsDataJsonSocialSkills = json_encode([
        ['Student', 'Rating'],
        ...array_map(function ($student) {
            return [$student['name'], $student['average_score']];
        }, $topStudentsDataSocialSkills)
    ]);

    $jobOffersData = fetchJobOffersWithStudentCount($conn);

    $jobOffersDataJson = json_encode([
        ['Work Title', 'Student Count'],
        ...array_map(function ($offer) {
            return [$offer['work_title'], $offer['student_count']];
        }, $jobOffersData)
    ]);
}








?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->
    <link rel="stylesheet" type="text/css" href="css/Dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/analytics.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" rel="stylesheet" type="text/css"> -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <!-- Include the Data Labels plugin -->
    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:500,600|Ubuntu:400,700" rel="stylesheet">


</head>

<body>

    <?php echo $profile_div; ?>
    <br><br>
    <hr>
    <div class="logo">
        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Student.php"><i class="fas fa-user-graduate"></i>Student</a>
            <a href="Organization.php"><i class="fas fa-building"></i>Organization</a>
            <a class="active" href="Analytics.php"><i class="fa fa-bar-chart"></i>Analytics</a>
            <a href="Notification-logs.php"><i class="fa fa-list"></i>Logs</a>
        </nav>
    </div>
    <hr class="line_bottom">
    </div>


    <div class="container">

        <div class="card blue">
            <h2>0</h2>
            <p>Total HUMSS</p>
            <a href="Student.php#humss"><button class="view-details">View Details</button></a>
        </div>

        <div class="card green">
            <h2>0</h2>
            <p>Total STEM</p>
            <a href="Student.php#stem"><button class="view-details">View Details</button></a>
        </div>

        <div class="card yellow">
            <h2>0</h2>
            <p>Total GAS</p>
            <a href="Student.php#gas"><button class="view-details">View Details</button></a>
        </div>

        <div class="card red">
            <h2>0</h2>
            <p>Total TechVoc</p>
            <a href="Student.php#techvoc"><button class="view-details">View Details</button></a>
        </div>

        <div class="card orange">
            <h2>0</h2>
            <p>Total ABM</p>
            <a href="Student.php#techvoc"><button class="view-details">View Details</button></a>
        </div>
        </main>
    </div>

    <div class="container2">

        <!-- <main> -->
        <div class="dashboard-container">


            <div class="c1">
                <div class="card-5">
                    <h4 class="chart-lbl">
                        Top Student Work Immersion
                    </h4>
                    <div class="divider">
                    </div>
                    <div class="bar-chart-container">
                        <div id="top_x_div_tp"></div>
                    </div>
                </div>
                <div class="card-3">
                    <h4 class="chart-lbl">
                        List Work Immersion
                    </h4>
                    <div class="divider">
                    </div>
                    <div class="content-center">
                        <div class="polar-chart-container">
                            <!-- <div id="radar-chart-ts"></div> -->
                            <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th>Position</th>
                                            <th>Total Students</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $jobOffersData = fetchJobOffersWithStudentCount($conn);

                                        if (!empty($jobOffersData)) {
                                            foreach ($jobOffersData as $offer) {
                                                echo '<tr>';
                                                echo '<td data-label="Name">' . htmlspecialchars($offer['organization_name']) . '</td>';
                                                echo '<td data-label="Name">' . htmlspecialchars($offer['work_title']) . '</td>';
                                                echo '<td data-label="TotalStudent">' . htmlspecialchars($offer['student_count']) . '</td>';
                                                echo '</tr>';
                                            }
                                        } else {

                                            echo '<tr><td colspan="3">No job offers found.</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="c2">
                <div class="card-4">
                    <h4 class="chart-lbl">
                        Top Student in Work habits
                    </h4>
                    <div class="divider">
                    </div>
                    <div class="bubble-chart-container-wh">

                        <div id="top_x_div_wh"></div>
                    </div>
                </div>





                <div class="card-6">
                    <h4 class="chart-lbl">
                        Top Student in Work skills
                    </h4>
                    <div class="divider">
                    </div>
                    <div class="line-chart-container-ws">
                        <div id="top_x_div_ws"></div>
                    </div>
                </div>
                <div class="card-7">
                    <h4 class="chart-lbl">
                        Top Student in Social skills
                    </h4>
                    <div class="divider">
                    </div>
                    <div class="mixed-chart-container-tp">
                        <div id="top_x_div_ss"></div>

                    </div>
                </div>
            </div>





        </div>



        <div class="ave-container">
            <div class="card-pie">
                <div id="piechart-ave" style="width: 100%; height: 100%; min-height: 300px;"></div>
            </div>
            <div class="card-chart">
                <div id="chart_div_ave" style="width: 100%; height: 100%; min-height: 300px;"></div>
            </div>
        </div>
        <i class="txt-des">*To print the analytics, press Ctrl + P.</i>
        <!-- </main> -->
    </div>


    <script>

    </script>


    <br>
    <script>
        let strands = <?php echo json_encode($strandCounts); ?>;

    let humss = strands.humss;
        let stem = strands.stem;
        let gas = strands.gas;
        let techVoc = strands.tvl;
        let abm = strands.abm;

        // console.log(strands);



        function updateCardData() {
            document.querySelector('.card.blue h2').textContent = humss;
            document.querySelector('.card.green h2').textContent = stem;
            document.querySelector('.card.yellow h2').textContent = gas;
            document.querySelector('.card.red h2').textContent = techVoc;
            document.querySelector('.card.orange h2').textContent = abm;
        }

        updateCardData();
    </script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js">
    </script>
    <!-- <script>
    let profilePic1 = document.getElementById("cover-pic");
    let inputFile1 = document.getElementById("input-file1");

    inputFile1.onchange = function() {
        profilePic1.src = URL.createObjectURL(inputFile1.files[0]);
    }
    </script> -->

    </script>

    <script>
        let profilePic2 = document.getElementById("profile-pic");
        let inputFile2 = document.getElementById("input-file2");

        inputFile2.onchange = function () {
            profilePic2.src = URL.createObjectURL(inputFile2.files[0]);
        }
    </script>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function () {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
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


    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
        <!-- <p>&copy;2024 Your Website. All rights reserved. | Junior Philippines Computer</p> -->
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>


</body>

</html>
<script>
    <?php
    // Prepare company data for chart
    $companyData = fetchCompanyAverages($conn);
    echo generateCompanyChartJS($companyData); // outputs: var companyAverageData = [...];
    echo "var topStudentsData = $topStudentsDataJson;\n";
    echo "var topStudentsDataWorkHabits = $topStudentsDataJsonWorkHabits;\n";
    echo "var topStudentsDataWorkSkills = $topStudentsDataJsonWorkSkills;\n";
    echo "var topStudentsDataSocialSkills = $topStudentsDataJsonSocialSkills;\n";
    // Prepare strand comparison data for chart
    $strandData = fetchStrandComparisonData($conn);
    $chartArray = [['Category']];
    foreach ($strandData['strand_data'] as $strand) {
        $chartArray[0][] = $strand['strand'];
    }
    $chartArray[0][] = 'Average';
    $workHabitsRow = ['Work Habits'];
    foreach ($strandData['strand_data'] as $strand) {
        $workHabitsRow[] = (float) $strand['work_habits'];
    }
    $workHabitsRow[] = (float) $strandData['overall_averages']['work_habits'];
    $chartArray[] = $workHabitsRow;
    $workSkillsRow = ['Work Skills'];
    foreach ($strandData['strand_data'] as $strand) {
        $workSkillsRow[] = (float) $strand['work_skills'];
    }
    $workSkillsRow[] = (float) $strandData['overall_averages']['work_skills'];
    $chartArray[] = $workSkillsRow;
    $socialSkillsRow = ['Social Skills'];
    foreach ($strandData['strand_data'] as $strand) {
        $socialSkillsRow[] = (float) $strand['social_skills'];
    }
    $socialSkillsRow[] = (float) $strandData['overall_averages']['social_skills'];
    $chartArray[] = $socialSkillsRow;
    echo "var strandComparisonData = " . json_encode($chartArray) . ";\n";
    ?>
</script>
<script type="text/javascript" src="js/Dashboard.js"></script>