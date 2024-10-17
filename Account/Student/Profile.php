<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
(Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/'))->load();

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

$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
$sql = "SELECT * FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$firstName = $student_profile['first_name'];
$middleName = $student_profile['middle_name'];
$lastName = $student_profile['last_name'];
$fullName = $firstName . ' ' . $middleName . ' ' . $lastName;
$school = $student_profile['school'];
$gradeLevel = $student_profile['grade_level'];
$strand = strtoupper($student_profile['strand']);
$stars = $student_profile['stars'];
$currentWork = $student_profile['current_work'];
$email = $user['email'];
$profile_image = "uploads/" . $user['profile_image'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="css/Profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Student Dashboard</title>
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">



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
        <ul>
            <li>
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" onclick="window.location.href = document.referrer;">
                    <i class=" fa fa-sign-out-alt fa-2x"></i>
                </a>
            </li>
        </ul>
        <!-- End -->
    </div>
    <!-- End -->



    <!-- Main -->
    <div class="main">

        <br>


        <!-- <div class="column">

            <h1 class="title">Student Population</h1>
            <div id="myChart2" class="Chart2"></div>
            <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
        </div> -->





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

    <div class="row-graph-profile">

        <div class="column-graph-profile" style="background-color:#fff;">
            <div class="container-grap-left">

                <div class="profile">
                    <img src="<?php echo $profile_image ?>" alt="" width="100" height="100" />

                    <div class="name"><?= $fullName; ?></div>
                    <div class="job"><?= $strand ?></div>
                </div>


            </div>
        </div>

        <h2>Personal details </h2>
        <div class="column-graph-profile-right" style="background-color:#fff;">

            <div class="container-grap-right">

                <div class="card-body">

                    <table>
                        <tbody>
                            <tr>
                                <td><b>Name</b></td>
                                <td>:</td>
                                <td><?= $fullName ?></td>
                            </tr>
                            <tr>
                                <td><b>Strand</b></td>
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
                            <!-- <tr>
                                <td><b>Address</b></td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Contact Number</b></td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Guardians</b></td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Guardians number</b></td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Guardians number</b></td>
                                <td>:</td>
                                <td>N/A</td>
                            </tr> -->
                            <!-- <tr>
                            <td>Skill</td>
                            <td>:</td>
                            <td>PHP, HTML, CSS, Java</td>
                        </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- <div class="wp-div-center">
        <div class="wp-header">
            <h2> Daily Insight</h2>
        </div>
        <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
    </div> -->

    <!-- <div class="wp-div-center">
        <div class="wp-header">
            <h2> Daily Insight</h2>
        </div>
        <div class="dp-graph" id="dp_chart_div" style="width: 900px; height: 500px;"></div>
    </div> -->

    <!-- -----------------------------------column graph ------------------------- -->

    <div class="row-graph">

        <h2>Daily Insight</h2>

        <div class="column-graph" style="background-color:#fff;">
            <div class="container-grap">
                <div class="dp-graph" id="dp_chart_div"></div>
            </div>
        </div>


        <div class="column-graph" style="background-color:#fff;">
            <div class="container-grap">
                <div class="dp-graph" id="piechart_3d"></div>
            </div>
        </div>

    </div>
    <!-- -------------------------------------END ------------------------------------------------- -->
    <!-- ----------------------------------------EVALUATION GRAPH----------------------------------- -->

    <div class="container light-style flex-grow-1 container-p-y" style="padding-left: 0px; padding-right: 0px;">
        <h4 class="font-weight-bold py-3 mb-4"
            style="background-color:#f1f1f1;  padding-left: 10px; padding-right: 10px;">Evaluation Insight</h4>
        <div class="card-graph overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#wp-top-x-div-sel">Work Performance</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#pro-top-x-div-sel">Professionalism</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#ld-top-x-div-sel">Learning and Development</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#tc-top-x-div-sel">Team Work and Collaboration</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#am-top-x-div-sel">Attitude and Motivation</a>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="wp-top-x-div-sel">
                            <div class="wp-graph" id="wp-top-x-div" style="width: 900px; height: 500px;"></div>
                        </div>

                        <div class="tab-pane fade active show" id="pro-top-x-div-sel">
                            <div class="pro-graph" id="pro-top-x-div" style="width: 900px; height: 500px;"></div>
                        </div>

                        <div class="tab-pane fade active show" id="ld-top-x-div-sel">
                            <div class="ld-graph" id="ld-top-x-div" style="width: 900px; height: 500px;"></div>
                        </div>

                        <div class="tab-pane fade active show" id="tc-top-x-div-sel">
                            <div class="tc-graph" id="tc-top-x-div" style="width: 900px; height: 500px;"></div>
                        </div>

                        <div class="tab-pane fade active show" id="am-top-x-div-sel">
                            <div class="am-graph" id="am-top-x-div" style="width: 900px; height: 500px;"></div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="text-right mt-3">
            <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
            <button type="button" class="btn btn-default">Cancel</button>
        </div> -->
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>

    <!-- -------------------------------------------------END ------------------------------------------------------ -->

    <!--  ------------work performance---------->
    <!-- <div class="wp-div-center">
    
        <div class="wp-graph" id="wp_top_x_div" style="width: 900px; height: 500px;"></div>
    </div>

    <div class="wp-div-center">

        <div class="pro-graph" id="pro_top_x_div" style="width: 900px; height: 500px;"></div>
    </div>
    <div class="wp-div-center">
        
        <div class="ld-graph" id="ld_top_x_div" style="width: 900px; height: 500px;"></div>
    </div>
    <div class="wp-div-center">

        <div class="tc-graph" id="tc_top_x_div" style="width: 900px; height: 500px;"></div>
    </div>
    <div class="wp-div-center">

        <div class="am-graph" id="am_top_x_div" style="width: 900px; height: 500px;"></div>
    </div> -->



    <!-- End -->
    <footer>
        2024 Your Website. All rights reserved. | Dr Ramon De Santos National High School
    </footer>

</body>

</html>