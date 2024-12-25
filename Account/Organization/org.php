<?php
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
        $jobIdParam =  $queryParameters['job_id'];
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

function generateJobCard()
{
    global $job;
    $strands = json_decode($job['strands']);
    $work_title = $job['work_title'];
    $description = html_entity_decode($job['description']);
    $description = nl2br($description);

    echo '<div id="titlebar" class="single titlebar-boxed-company-info">';
    echo '<div class="container">';
    echo '<div class="eleven columns">';

    echo '<span class="job-category"><a href="#">Organization</a></span>';
    echo '<h1>' .  htmlspecialchars($job['organization_name']);
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
                            <a href="#"> <strong>' . htmlspecialchars($job['work_title']) .
        '</strong>
                            </a>
                           
                        </h4>';

    foreach ($strands as $strand) {
        echo '<span class="job-type full-time">' . htmlspecialchars($strand) . '</span>';
    }

    echo '                  


                    </div>
                    <div class="company-info-apply-btn">

                        <div class="job_application application">

                            <a href="login.php" class="small-dialog popup-with-zoom-anim button apply-dialog-button">Apply now</a>


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
            style="background-color:#172738; color:#fff; padding-left: 20px; padding-right: 10px;margin: 0px !important; "><i class="fa fa-pie-chart" aria-hidden="true"></i></i>Rating</h4>
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
            style="background-color:#172738; color:#fff; padding-left: 20px; padding-right: 10px;margin: 0px !important; "><i class="fa fa-bar-chart" aria-hidden="true"></i>Insights</h4>
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

        </div>';
}


if (isset($_SESSION['account_type'])) {

    $account_type = $_SESSION['account_type'];

    $link = "/Account/$account_type";
} else {

    $link = "./";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Work Immersion | Workify</title>
    <!-- <title>Work Immersion | DRDSNHS</title> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="stylesheet" type="text/css" href="../../css/org_style.css">
    <!-- <link rel="stylesheet" type="text/scss" href="css/reboot.css"> -->
    <link rel="stylesheet" type="text/css" href="../../css/footer.css">
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
            <a href="index.php">
                <img src="../../img/logov3.jpg" alt="Logo">
                <!-- <img src="img/DrRamonLOGO.svg" alt="Logo"> -->
            </a>
            <nav class="dash-middle">
                <!-- <a class="active-header" href="index.php">Home</a> -->
                <!-- <a href="job_list.php">Company review</a>
                <a href="contact.php">Contact</a> -->
            </nav>
        </div>
        <nav class="nav-log">

            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="com-btn" href="Details.php">Back</a>
        </nav>

    </header>


    <div class="content-sticky">
        <!-- --------------------------------------------------location----------------------------------------------- -->
        <!-- <span class="company-data__content--list-item _company_website">
            <a class="website" href="#"
                target="_blank" rel="nofollow">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    version="1.1" width="15.413" height="14" viewBox="0 0 256 256"
                    xml:space="preserve">

                    <defs>
                    </defs>
                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                        transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                        <path
                            d="M 45 90 c -1.415 0 -2.725 -0.748 -3.444 -1.966 l -4.385 -7.417 C 28.167 65.396 19.664 51.02 16.759 45.189 c -2.112 -4.331 -3.175 -8.955 -3.175 -13.773 C 13.584 14.093 27.677 0 45 0 c 17.323 0 31.416 14.093 31.416 31.416 c 0 4.815 -1.063 9.438 -3.157 13.741 c -0.025 0.052 -0.053 0.104 -0.08 0.155 c -2.961 5.909 -11.41 20.193 -20.353 35.309 l -4.382 7.413 C 47.725 89.252 46.415 90 45 90 z"
                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(119, 119, 119); fill-rule: nonzero; opacity: 1;"
                            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path
                            d="M 45 45.678 c -8.474 0 -15.369 -6.894 -15.369 -15.368 S 36.526 14.941 45 14.941 c 8.474 0 15.368 6.895 15.368 15.369 S 53.474 45.678 45 45.678 z"
                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                    </g>
                </svg>
                Location
            </a>
        </span> -->

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
                        <!-- <p class="mb-0 f_400">© 2024 Your Website. All rights reserved. | Dr Ramon De Santos National High School</p> -->
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
    <script>
        $(document).ready(function() {
            $('.bar span').hide();
            $('#bar-five').animate({
                width: '85%'
            }, 1000);
            $('#bar-four').animate({
                width: '35%'
            }, 1000);
            $('#bar-three').animate({
                width: '20%'
            }, 1000);
            $('#bar-two').animate({
                width: '17%'
            }, 1000);
            $('#bar-one').animate({
                width: '30%'
            }, 1000);

            setTimeout(function() {
                $('.bar span').fadeIn('slow');
            }, 1000);

        });
    </script>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>



    <script src="js/filter.js"> </script>


</body>


</html>