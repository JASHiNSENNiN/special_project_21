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
    // Assuming the session is already started and school_name is set
    $school_name = $_SESSION['school_name'];

    // Prepare the SQL to fetch data
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
    WHERE SP.school = ?"; // Using prepared statements for security

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $school_name);
    $stmt->execute();
    $result = $stmt->get_result();

    $evaluation_data = [];
    while ($row = $result->fetch_assoc()) {
        $evaluation_data[] = [
            'name' => $row['first_name'] . ' ' . $row['last_name'], // Full name
            'punctual' => (int) $row['punctual'],
            'reports_regularly' => (int) $row['reports_regularly'],
            'performs_tasks_independently' => (int) $row['performs_tasks_independently'],
            'self_discipline' => (int) $row['self_discipline'],
            'dedication_commitment' => (int) $row['dedication_commitment'],
        ];
    }

    return $evaluation_data;
}

function fetchTopStudents($conn)
{
    $schoolName = $_SESSION['school_name'];

    $sql = "
        SELECT sp.id, CONCAT(sp.first_name, ' ', sp.last_name) AS student_name, 
               AVG((punctual + reports_regularly + performs_tasks_independently + 
                    self_discipline + dedication_commitment + ability_to_operate_machines + 
                    handles_details + shows_flexibility + thoroughness_attention_to_detail + 
                    understands_task_linkages + offers_suggestions + tact_in_dealing_with_people + 
                    respect_and_courtesy + helps_others + learns_from_co_workers + 
                    shows_gratitude + poise_and_self_confidence + emotional_maturity) / 17) as avg_score
        FROM student_profiles sp
        JOIN Student_Evaluation se ON sp.id = se.student_id
        WHERE sp.school = ?
        GROUP BY sp.id
        ORDER BY avg_score DESC
        LIMIT 10
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $schoolName);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = [
            'name' => $row['student_name'],
            'avg_score' => round($row['avg_score'], 2)
        ];
    }

    return $students;
}



$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_SESSION['school_name'])) {
    $schoolName = $_SESSION['school_name'];
    $students = getStudentsBySchool($conn, $schoolName);

    $strandCounts = countStrands($students);

    $topStudents = fetchTopStudents($conn);

    $jsonData = json_encode($topStudents);
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
    <script type="text/javascript" src="js/Dashboard.js"></script>

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:500,600|Ubuntu:400,700" rel="stylesheet">


    <style>
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
    </style>
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
                                            <th>Total Student</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td data-label="Name"><a href="#">Friendship</a></td>

                                            <td data-label="TotalStudent">5</td>
                                        </tr>
                                        <tr>

                                            <td data-label="Name"><a href="#">Jollibee</a></td>

                                            <td data-label="TotalStudent">2</td>
                                        </tr>
                                        <tr>

                                            <td data-label="Name"><a href="#">NIA</a></td>

                                            <td data-label="TotalStudent">5</td>
                                        </tr>
                                        <tr>

                                            <td data-label="Name"><a href="#">Puregold</a></td>

                                            <td data-label="TotalStudent">1</td>
                                        </tr>
                                        <tr>

                                            <td data-label="Name"><a href="#">BFP</a></td>

                                            <td data-label="TotalStudent">10</td>
                                        </tr>
                                        <tr>

                                            <td data-label="Name"><a href="#">Police Station</a></td>

                                            <td data-label="TotalStudent">5</td>
                                        </tr>
                                        <tr>

                                            <td data-label="Name"><a href="#">Brgy Hall</a></td>

                                            <td data-label="TotalStudent">3</td>
                                        </tr>
                                        <tr>

                                            <td data-label="Name"><a href="#">Mang inasal</a></td>

                                            <td data-label="TotalStudent">3</td>
                                        </tr>



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