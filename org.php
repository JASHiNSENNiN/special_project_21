<?php
require_once __DIR__ . '/backend/php/config.php';
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

  echo '<span class="job-category"><a href="#">Position title</a></span>';
  echo '<h1>' . htmlspecialchars($job['work_title']);

  foreach ($strands as $strand) {
    echo '<span class="job-type full-time">' . htmlspecialchars($strand) . '</span>';
  }

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

                    <div class="company-info-boxed-logo">
                        <a href="#"> <img width="150" height="150" class="company_logo"
                                src="https://workscout.in/wp-content/uploads/job-manager-uploads/company_logo/2021/11/company-logo-06-150x150.png"
                                alt=""> </a>
                    </div>

                    <div class="content">
                        <h4>
                            <a href="#"> <strong>' . htmlspecialchars($job['organization_name']) .
            '</strong>
                            </a>
                            <p class="company-data__content--list-item">Improving Lives Together</p>
                        </h4>

                        <div class="company-info-boxed-links">



                            <span class="company-data__content--list-item _company_website"><a class="website" href="#"
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
                                </span>
                            <span class="company-data__content--list-item _company_email">
                                <a href="#" target="_blank"><i class="fa fa-envelope"></i>
                                    telimed@example.com</a>
                            </span>
                            <span class="company-data__content--list-item _company_x">
                                <a href="#">  <i class="fa fa-link"></i> 
                                   
                                    Link </a></span>

                            


                        </div>


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
            

        </div>';
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Work Immersion | Workify</title>
    <link rel="stylesheet" type="text/css" href="css/org_style.css">
    <!-- <link rel="stylesheet" type="text/scss" href="css/reboot.css"> -->
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


</head>
<style>

</style>

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
                <img src="img/logov3.jpg" alt="Logo">
            </a>
            <nav class="dash-middle">
                <a class="active-header" href="index.php">Home</a>
                <!-- <a href="job_list.php">Company review</a>
                <a href="contact.php">Contact</a> -->
            </nav>
        </div>
        <nav class="nav-log">
            <a class="login-btn" href="login.php" style="margin-left: 20px;">Sign in</a>
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="com-btn" href="post_work_Immersion.php">Post Work Immersion</a>
        </nav>

    </header>


    <div class="content-sticky">
        <?php generateJobCard(); ?>


    </div>

    <!-- ----------------------------------------------footer ------------------------------------------------------- -->
    <footer class="new_footer_area bg_color">
        <div class="new_footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <a href="index.php">
                            <img src="img/logov3.jpg" alt="Logo">
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="f_widget company_widget wow fadeInLeft" data-wow-delay="0.2s"
                            style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;">
                            <h3 class="f-title f_600 t_color f_size_18">Get in Touch</h3>
                            <p>Don’t miss out on the latest updates and insights! Subscribe to our newsletter for
                                exclusive content and tips.</p>
                            <form action="#" class="f_subscribe_two mailchimp" method="post" novalidate="true"
                                _lpchecked="1">
                                <input type="text" name="EMAIL" class="form-control memail" placeholder="Email">
                                <button class="btn btn_get btn_get_two" type="submit">Subscribe</button>
                                <p class="mchimp-errmessage" style="display: none;"></p>
                                <p class="mchimp-sucmessage" style="display: none;"></p>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="f_widget about-widget pl_70 wow fadeInLeft" data-wow-delay="0.6s"
                            style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInLeft;">
                            <h3 class="f-title f_600 t_color f_size_18">Help</h3>
                            <ul class="list-unstyled f_list">

                                <li><a href="term_and_Conditions.php">Term &amp; conditions</a></li>
                                <li><a href="Support_policy.php">Support Policy</a></li>
                                <li><a href="#">Privacy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="f_widget social-widget pl_70 wow fadeInLeft" data-wow-delay="0.8s"
                            style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInLeft;">
                            <h3 class="f-title f_600 t_color f_size_18">Team Solutions</h3>
                            <div class="f_social_icon">
                                <a href="#" class="fab fa-facebook"></a>
                                <a href="#" class="fab fa-twitter"></a>
                                <a href="#" class="fab fa-linkedin"></a>
                                <a href="#" class="fab fa-pinterest"></a>
                            </div>
                        </div>
                    </div>
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