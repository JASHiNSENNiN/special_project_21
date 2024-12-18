<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$currentUrl = $_SERVER['REQUEST_URI'];
$urlParts = parse_url($currentUrl);
if (isset($urlParts['query'])) {
    parse_str($urlParts['query'], $queryParameters);
    if (isset($queryParameters['job_id'])) {
        $jobIdParam = $queryParameters['job_id'];
    }
} else {
    echo "Query string parameter not found.";
}
$jobId = decrypt_url_parameter(base64_decode($jobIdParam));

if (!isset($jobId)) {
    die("Missing job ID parameter in the URL.");
}
$sql = "SELECT * FROM job_offers WHERE id = :jobId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':jobId', $jobId, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$job = $result;

function UserIsApplied($jobId)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    $conn = mysqli_connect($host, $username, $password, $database);

    $workId = $jobId;

    $userId = $_SESSION['user_id'];

    $sql = "SELECT * FROM applicants WHERE job_id = ? AND student_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $workId, $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}


function deleteUserApplication($jobId)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM applicants WHERE job_id = ? AND student_id = ?");
    $stmt->bind_param("ii", $jobId, $_SESSION['user_id']);
    $result = $stmt->execute();
    if ($result && $stmt->affected_rows > 0) {
        echo "Application deleted successfully.";
    } else {
        echo "No application found to delete or an error occurred.";
    }
    $stmt->close();
    $conn->close();
}

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'apply_application') {
        $host = "localhost";
        $username = $_ENV['MYSQL_USERNAME'];
        $password = $_ENV['MYSQL_PASSWORD'];
        $database = $_ENV['MYSQL_DBNAME'];

        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $jobId = $_POST['job_id'];
        $userId = $_SESSION['user_id'];

        $sql = "INSERT INTO applicants (job_id, student_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $jobId, $userId);
        $stmt->execute();

        if (!$stmt) {
            die("Query failed: " . $conn->error);
        }

        header("Location: Company_Area.php");
        exit;
    } elseif ($_POST['action'] === 'cancel_application') {

        deleteUserApplication($_POST['job_id']);

        header("Location: Company_Area.php");
        exit;
    }
}

function generateJobCard()
{
    global $job;
    global $jobId;
    $strands = json_decode($job['strands']);
    $work_title = $job['work_title'];
    $description = html_entity_decode($job['description']);
    $description = nl2br($description);
    $hasApplied = UserIsApplied($jobId);

    echo '<div id="titlebar" class="single titlebar-boxed-company-info">';
    echo '<div class="container">';
    echo '<div class="eleven columns">';

    echo '<span class="job-category"><a href="#">Organization</a></span>';
    echo '<h1>' . htmlspecialchars($job['organization_name']);
    echo '<hr>';


    echo '</h1></div>';

    echo '<div class="five columns">';
    echo '<div class="job-manager-form wp-job-manager-bookmarks-form">';
    echo '</div></div></div></div>';

    echo '
            </div>
        </div>



        <!-- </section> -->
        <div class="container right-sidebar">
            <div class="sixteen columns"></div>
            <div class="company-info-boxed">
                <div class="company-info left-company-logo">

                    
                    <div class="content">
                        <h4>
                            <a href="#"> <strong>' . htmlspecialchars($job['work_title'])  .
        '</strong>
                            </a>
                            
                        </h4>';

    foreach ($strands as $strand) {
        echo '<span class="job-type full-time">' . htmlspecialchars($strand) . '</span>';
    }


    echo '                 </div>';
    echo '
                        <div class="company-info-apply-btn">
                            <div class="job_application application">
                                <form method="post">
                                    <input type="hidden" name="job_id" value="' . $jobId . '">';

    if ($hasApplied === true) {
        echo '<button type="submit" class="small-dialog popup-with-zoom-anim button button-cancel apply-dialog-button">Cancel Application</button>
                                        <input type="hidden" name="action" value="cancel_application">';
    } else {
        echo '<button type="submit" class="small-dialog popup-with-zoom-anim button apply-dialog-button">Apply now</button>
                                        <input type="hidden" name="action" value="apply_application">';
    }

    echo '</form>

                        </div>
                    </div>
                </div>


            </div>
            <div class="eleven columns ">
                <div class="padding-right">
                    <div class="single_job_listing">
                        ' . $description . '
                        

                    </div>
                </div>

            </div>

            <div class="eleven columns ">
                <div class="padding-right">
                    <div class="single_job_listing">
                    <h4 class="font-weight-bold py-3 mb-4"
            style="background-color:#172738; color:#fff; padding-left: 20px; padding-right: 10px;margin: 0px !important; "> <i class="fa fa-pie-chart" aria-hidden="true"></i>Rating</h4>
                        <div class="flex-container">
                        
  <div class="flex-left">
    <div id="top_x_div_rating"></div>
    <div class="rating-users">
      <i class="fa fa-user" aria-hidden="true"></i><span>1,014,004</span> total students
    </div>
  </div>
  <div class="flex-right">
      
<div id="total-student" style="width: 90%; height: 100%;"></div>
  </div>
</div>
                        

                    </div>
                </div>

            </div>



             <div class="container-org light-style flex-grow-1 container-p-y" style="padding-left: 0px; padding-right: 0px;">
        <h4 class="font-weight-bold py-3 mb-4"
            style="background-color:#172738; color:#fff; padding-left: 20px; padding-right: 10px;margin: 0px !important; "> <i class="fa fa-bar-chart" aria-hidden="true"></i>Insights</h4>
        <div class="container-btm-rating">
        
		<div class="row clearfix">
			<div class="col-3">
				<div class="common">
					 <div class="wp-graph" id="wp-top-x-div" style="width: 100%; height: 100%;"></div>
				</div> <!-- end:common -->
			</div> <!-- end:col-3 -->

			<div class="col-3">
				<div class="common">
					<div class="pro-graph" id="pro-top-x-div" style="width: 100%; height: 100%;"></div>
				</div> <!-- end:common -->
			</div> <!-- end:col-3 -->

			<div class="col-3">
				<div class="common">
					 <div class="ld-graph" id="ld-top-x-div" style="width: 100%; height: 100%;"></div>
				</div> <!-- end:common -->
			</div> <!-- end:col-3 -->

			<div class="col-3">
				<div class="common">
					<div class="tc-graph" id="tc-top-x-div" style="width: 100%; height: 100%;"></div>
				</div> <!-- end:common -->
				
			</div> <!-- end:col-3 -->
			<div class="col-3">
				<div class="common">
					 <div class="am-graph" id="am-top-x-div" style="width: 100%; height: 100%;"></div>
				</div> <!-- end:common -->
			</div> <!-- end:col-3 -->
		</div><!-- end:row -->
	</div> <!-- end:container -->

    </div>
            
        </div>
        
        
        
        ';
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Work Immersion | Workify</title>
    <!-- <link rel="shortcut icon" type="x-icon" href="image/Dr.Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
    <link rel="stylesheet" type="text/css" href="../../css/org_style.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/org_style.css"> -->
    <!-- <link rel="stylesheet" type="text/scss" href="css/reboot.css"> -->
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- ---------------------------------------evaluation script ------------------------------------------- -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<script type="text/javascript" src="../../js/org.js"></script>


<body>
    <noscript>
        <style>
        html {
            display: none;
        }
        </style>
        <meta http-equiv="refresh" content="0.0;url=message.php">
    </noscript>
    <header id="myHeader-sticky">
        <div class="logo">
            <a href="Company_Area.php">
                <!-- <img src="../../img/header.png" alt="Logo"> -->
                <img src="../../img/logov3.jpg" alt="Logo">
            </a>
            <nav class="dash-middle">
                <!-- <a class="active-header" href="index.php">Home</a>
                <a href="job_list.php">Company review</a>
                <a href="contact.php">Contact</a> -->
            </nav>
        </div>
        <nav class="nav-log">
            <!-- <a class="login-btn" href="login.php" style="margin-left: 20px;">Sign in</a> -->
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="com-btn" href="../../Account/<?= $_SESSION['account_type']; ?>"
                onclick="window.location.href = document.referrer;"> Back</a>
        </nav>

    </header>


    <div class="content-sticky">
        <?php generateJobCard(); ?>


    </div>

    <!-- ----------------------------------------------footer ------------------------------------------------------- -->
    <footer class="new_footer_area bg_color">
        <div class="new_footer_top">
            <div class="container">
                <div class="row" style=" gap: 120px !important;">
                    <a href="index.php">
                        <img src="../../img/logov3.jpg" alt="Logo">
                        <!-- <img src="img/DrRamonLOGO.svg" alt="Logo"> -->
                    </a>




                </div>
            </div>
            <div class="footer_bg">
                <div class="footer_bg_one"></div>
                <div class="footer_bg_two"></div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-7">
                        <p class="mb-0 f_400">© 2024 WorkifyPH. All rights reserved. | Junior Philippines Computer
                            Society Students</p>
                    </div>
                    <!-- <div class="col-lg-6 col-sm-5 text-right">
                        <p>Made with <i class="icon_heart"></i> in <a href="#" target="_blank">JPCS</a></p>
                    </div> -->
                </div>
            </div>
        </div>
    </footer>


    <!-- -------------------------------------header stick js ------------------------------ -->
    <script>
    window.onscroll = function() {
        myFunction();
    };

    var header = document.getElementById("myHeader-sticky");
    var sticky = header.offsetTop;

    function myFunction() {
        if (window.pageYOffset > sticky) {
            header.classList.add("stickyhead");
        } else {
            header.classList.remove("stickyhead");
        }
    }
    </script>
    <script src="js/filter.js"> </script>


</body>


</html>