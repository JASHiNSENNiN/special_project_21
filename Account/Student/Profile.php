<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';

$currentUrl = $_SERVER['REQUEST_URI'];
$urlParts = parse_url($currentUrl);
if (isset($urlParts['query'])) {
    parse_str($urlParts['query'], $queryParameters);
    if (isset($queryParameters['student_id'])) {
        $IdParam = $queryParameters['student_id'];
    }
} else {
    echo "Query string parameter not found.";
}

$user_id = decrypt_url_parameter(base64_decode($IdParam));

global $host;
global $username;
global $password;
global $database;
global $conn;


$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
$sql = "SELECT * FROM student_profiles WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$student_profile = $stmt->fetch(PDO::FETCH_ASSOC);

$firstName = $student_profile['first_name'];
$middleName = $student_profile['middle_name'];
$lastName = $student_profile['last_name'];
$fullName = $firstName . ' ' . $middleName . ' ' . $lastName;
$school = $student_profile['school'];
$gradeLevel = $student_profile['grade_level'];
$strand = strtoupper($student_profile['strand']);
$stars = $student_profile['stars'];
$currentWork = $student_profile['current_work'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="css/Profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <title>Student Dashboard</title>



    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />



    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- ---------------------------script ---------------------- -->
    <script type="text/javascript" src="css/eval_graph.js"></script>



</head>

<body>
    <!-- Navbar top -->
    <div class="navbar-top">
        <div class="title">
            <h1>Profile</h1>
        </div>

        <li>
            <a href="Company_Area.php">
                <i class="fa fa-sign-out-alt fa-2x"></i>
            </a>
        </li>
        </ul>
        <!-- End -->
    </div>
    <!-- End -->

    <!-- Sidenav -->
    <div class="sidenav">
        <div class="profile">
            <img src="image/default.png" alt="" width="100" height="100" />

            <div class="name"><?= $fullName; ?></div>
            <div class="job"><?= $strand ?></div>
        </div>

    </div>
    <!-- End -->

    <!-- Main -->
    <div class="main">
        <h2>IDENTITY</h2>
        <div class="card">
            <div class="card-body">



                <table>
                    <tbody>
                        <tr>
                            <td><b>Name</b></td>
                            <td>:</td>
                            <td><?= $fullName ?></td>
                        </tr>
                        <tr>
                            <td><b>Strand</b>:</td>
                            <td>:</td>
                            <td><?= $strand; ?></td>
                        </tr>
                        <tr>
                            <td><b>School</b></td>
                            <td>:</td>
                            <td><?= $school ?></td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td>:</td>
                            <td><?= $email ?></td>
                        </tr>
                        <tr>
                            <td><b>Address</b></td>
                            <td>:</td>
                            <td>Afan Salavador Street Guimba Nueva Ecija</td>
                        </tr>
                        <tr>
                            <td><b>Contact Number</b></td>
                            <td>:</td>
                            <td>0917-8830311</td>
                        </tr>
                        <tr>
                            <td><b>Guardians</b></td>
                            <td>:</td>
                            <td>N/A</td>
                        </tr>
                        <!-- <tr>
                            <td>Skill</td>
                            <td>:</td>
                            <td>PHP, HTML, CSS, Java</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
        <br>


        <div class="column">

            <h1 class="title">Student Population</h1>
            <!-- <div id="myChart2" class="Chart2"></div> -->
            <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
        </div>



        <!-- <h2>Work Performance</h2>
        <div class="card">
            <div class="card-body">



            </div>
        </div> -->

        <!-- <h2>SOCIAL MEDIA</h2>
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <div class="social-media">
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-facebook fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-instagram fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-invision fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-whatsapp fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-snapchat fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
            </div>
        </div> -->
    </div>

    <div class="wp-div-center">
        <div class="wp-header">
            <h2> Insights</h2>
        </div>
        <div class="dp-graph" id="dp_chart_div" style="width: 900px; height: 500px;"></div>
    </div>


    <div class="wp-div-center">
        <div class="wp-header">
            <h2> Insights</h2>
        </div>

        <div class="wp-graph" id="wp_top_x_div" style="width: 900px; height: 500px;"></div>
    </div>

    <div class="wp-div-center">
        <div class="wp-header">
            <!-- <h2> Insights</h2> -->
        </div>

        <div class="pro-graph" id="pro_top_x_div" style="width: 900px; height: 500px;"></div>
    </div>
    <div class="wp-div-center">
        <div class="wp-header">
            <!-- <h2> Insights</h2> -->
        </div>

        <div class="ld-graph" id="ld_top_x_div" style="width: 900px; height: 500px;"></div>
    </div>
    <div class="wp-div-center">
        <div class="wp-header">
            <!-- <h2> Insights</h2> -->
        </div>

        <div class="tc-graph" id="tc_top_x_div" style="width: 900px; height: 500px;"></div>
    </div>
    <div class="wp-div-center">
        <div class="wp-header">
            <!-- <h2> Insights</h2> -->
        </div>

        <div class="am-graph" id="am_top_x_div" style="width: 900px; height: 500px;"></div>
    </div>



    <!-- End -->
    <footer>
        2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students
    </footer>
</body>

</html>