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


function fetchTopStudentsWorkHabits($conn) {
   
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

    function fetchTopStudentsWorkSkills($conn) {
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

    function fetchTopStudentsSocialSkills($conn) {
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

        function fetchJobOffersWithStudentCount($conn) {
            $school_name = $_SESSION['school_name'];
        
            $query = "
                SELECT 
                    jo.work_title, 
                    COUNT(a.student_id) AS student_count
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
                    jo.id, jo.work_title
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
                        'student_count' => $row['student_count']
                    ];
                }
                
                return $jobOffers;
            } else {
                error_log("Error fetching job offers: " . $conn->error);
                return [];
            }
        }

function fetchTopStudents($conn) {
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


if (isset($_SESSION['school_name'])) {
    $schoolName = $_SESSION['school_name'];
    $students = getStudentsBySchool($conn, $schoolName);

    $strandCounts = countStrands($students);

    
    $topStudentsData = fetchTopStudents($conn);

    $topStudentsDataJson = json_encode([
        ['Student', 'Rating'],
        ...array_map(function($student) {
            return [$student['name'], $student['score']];
        }, $topStudentsData)
    ]);

    $topStudentsDataWorkHabits = fetchTopStudentsWorkHabits($conn);

    $topStudentsDataJsonWorkHabits = json_encode([
        ['Student', 'Rating'],
        ...array_map(function($student) {
            return [$student['name'], $student['average_score']]; 
        }, $topStudentsDataWorkHabits)
    ]);

    $topStudentsDataWorkSkills = fetchTopStudentsWorkSkills($conn);

    $topStudentsDataJsonWorkSkills = json_encode([
        ['Student', 'Rating'],
        ...array_map(function($student) {
            return [$student['name'], $student['average_score']];
        }, $topStudentsDataWorkSkills)
    ]);

    $topStudentsDataSocialSkills = fetchTopStudentsSocialSkills($conn);

    $topStudentsDataJsonSocialSkills = json_encode([
        ['Student', 'Rating'],
        ...array_map(function($student) {
            return [$student['name'], $student['average_score']];
        }, $topStudentsDataSocialSkills)
    ]);

    $jobOffersData = fetchJobOffersWithStudentCount($conn);
    
    $jobOffersDataJson = json_encode([
        ['Work Title', 'Student Count'],
        ...array_map(function($offer) {
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
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
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


    <!-- <style>
    .bubble-chart-container-wh,
    .line-chart-container-ws,
    .mixed-chart-container-tp {
        padding: 20px;

        height: 300px;

        display: flex;

        justify-content: center;

        align-items: center;

        overflow: hidden;

    }

    .card-4,
    .card-6,
    .card-7 {
        display: flex;

        flex-direction: column;

        height: auto;

    }

    @media (max-width: 600px) {

        .bubble-chart-container-wh,
        .line-chart-container-ws,
        .mixed-chart-container-tp {
            height: 100%;

        }
    }

    .bar-chart-container {
        max-height: 100%;
        overflow-y: auto;
        /* Enable vertical scrolling */
    }
    </style> -->
</head>

<body>

    <?php echo $profile_div; ?>
    <br><br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <!-- <a href="Company.php">Work Immersion List</a> -->
            <a href="Student.php"><i class="fas fa-user-graduate"></i>Student</a>
            <a class="active" href="Dashboard.php"><i class="fa fa-bar-chart"></i>Analytics</a>
            <a href="Reports.php"><i class="fa fa-file-text-o"></i>Reports</a>


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

        <main>
            <div class="dashboard-container">
                <!-- <div class="card-1">
                    <h4 class="chart-lbl">
                        Doughnut Chart
                    </h4>
                    <div class="divider">
                    </div>
                    <div class="content-center">
                        <div class="doughnut-chart-container">
                            <canvas class="doughnut-chart" id="doughnut">
                            </canvas>
                        </div>
                    </div>
                </div> -->
                <!-- <div class="card-2">
                    <h4 class="chart-lbl">
                        Pie Chart
                    </h4>
                    <div class="divider">
                    </div>
                    <div class="content-center">
                        <div class="pie-chart-container">
                            <canvas class="pie-chart" id="pie">
                            </canvas>
                        </div>
                    </div>
                </div> -->
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
                                            <th>Name</th>
                                            <th>Total Students</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
     
            $jobOffersData = fetchJobOffersWithStudentCount($conn);

            if (!empty($jobOffersData)) {
                foreach ($jobOffersData as $offer) {
                    echo '<tr>';
                    echo '<td data-label="Name"><a href="#">' . htmlspecialchars($offer['work_title']) . '</a></td>';
                    echo '<td data-label="TotalStudent">' . htmlspecialchars($offer['student_count']) . '</td>';
                    echo '</tr>';
                }
            } else {
        
                echo '<tr><td colspan="2">No job offers found.</td></tr>';
            }
            ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
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
        </main>
    </div>
    <!-- <h1 class="title">Total of Student Deployment</h1>

    <div class="box-container">

        <div class="box">Box 1</div>
        <div class="box">Box 2</div>
        <div class="box">Box 3</div>
        <div class="box">Box 4</div>
    </div> -->
    <!-- 
    <div class="container4">
        <h1 class="Time">Student Ranking</h1>
        <div id="curve_chart" style="height: auto;"></div>
    </div>

    <div class="row">
        <div class="column">
            <h1 class="title">Top Student</h1>
            <canvas id="myChart1" class="Chart1"></canvas>
        </div>
        <div class="column">
            <h1 class="title">Student Population</h1>
            <div id="myChart2" class="Chart2"></div>
        </div>
        <div class="column">
            <h1 class="title">Top 6 Company</h1>
            <canvas id="myHorizontalBarChart"></canvas>
        </div>
        <div class="column">
            <h1 class="title">Company list</h1><br>
            <div id="table_div"></div>
        </div>
    </div> -->








    <br>
    <script>
    let strands = <?php echo json_encode($strandCounts); ?>;
    console.log("<?php echo $schoolName; ?>");
    let humss = strands.humss;
    let stem = strands.stem;
    let gas = strands.gas;
    let techVoc = strands.tvl;
    let abm = strands.abm;

    console.log(strands);



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
    <scri type="text/javascript">

    </scri>
    <script>
    let profilePic1 = document.getElementById("cover-pic");
    let inputFile1 = document.getElementById("input-file1");

    inputFile1.onchange = function() {
        profilePic1.src = URL.createObjectURL(inputFile1.files[0]);
    }
    </script>

    <script>
    let profilePic2 = document.getElementById("profile-pic");
    let inputFile2 = document.getElementById("input-file2");

    inputFile2.onchange = function() {
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
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>


    <footer>
        <!-- <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p> -->
        <p>&copy;2024 Your Website. All rights reserved. | Junior Philippines Computer</p>
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>


</body>

</html>
<script>
var topStudentsData = <?php echo $topStudentsDataJson; ?>;
var topStudentsDataWorkHabits = <?php echo $topStudentsDataJsonWorkHabits; ?>;
var topStudentsDataWorkSkills = <?php echo $topStudentsDataJsonWorkSkills; ?>;
var topStudentsDataJsonSocialSkills = <?php echo $topStudentsDataJsonSocialSkills; ?>
</script>
<script type="text/javascript" src="js/Dashboard.js"></script>