<?php
require_once __DIR__ . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM job_offers";
$result = $conn->query($sql);

$jobOffers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobOffers[] = $row;
    }
}


$conn->close();

function generateJobCards($jobOffers)
{
    foreach ($jobOffers as $job) {
        $strands = json_decode($job['strands']);

        $description = html_entity_decode($job['description']);

        $description = nl2br($description);

        echo '
        <li>
            <div class="job-card">
                <!--<div class="job-card-header">
                    div class="menu-dot"></div>
                </div>-->
                <div class="job-card-title">
                    <h2><span>' . htmlspecialchars($job['work_title']) . '</span></h2>
                      <div class="job-card-title-company">' . htmlspecialchars($job['organization_name']) .
            '</div>
                <div class="job-detail-buttons">';

        foreach ($strands as $strand) {
            echo '<button class="search-buttons detail-button">' . htmlspecialchars($strand) . '</button>';
        }

        echo '
                </div>
                      </div>
                
                <div class="job-card-subtitle">
                    <div>' . $description . '</div>
                </div>
                
                <div class="job-card-buttons">
                    <button class="search-buttons card-buttons" id="btnApply">Details</button>
                    <button class="search-buttons card-buttons-msg">Save</button>
                </div>
            </div>
        </li>';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Work Immersion Search | Workify</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
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
                <a href="job_list.php">Company review</a>
                <a href="contact.php">Contact</a>
            </nav>
        </div>
        <nav>
            <a class="login-btn" href="login.php" style="margin-left: 20px;">Sign in</a>
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="com-btn" href="post_work_Immersion.php">Post Work Immersion</a>
        </nav>

    </header>


    <div class="content-sticky">


        <section>
            <!-- <h2 class="sfa">Search, Find and Apply!</h2> -->
            <div class="line-search">
                <div class="searchwork">
                    <form action="#" method="get">

                        <div class="search-container">
                            <button type="submit"><i class="fas fa-search"></i></button>
                            <input id="globalInputSearch" name="globalInputSearch" class="globalInputSearch" type="text"
                                placeholder="Work Immersion / Keyword">

                        </div>
                        <div class="search-container" style="border-left: 1px solid grey">
                            <button type="submit"><i class="fas fa-map-marker-alt"></i></button>
                            <input id="InputSearch" name="InputSearch" class="globalInputSearch" type="text"
                                placeholder="Search location">

                        </div>

                        <!-- <input class="sub-btn" type="submit" value="Find Now"> -->

                </div>
                </form>
            </div>

        </section>

        <div class="tab-selection">


            <nav style="position:relative; margin-left:auto; margin-right:auto;">
                <a class="active" href="index.php">Work Immersion feed</a>
                <a href="recent-search.php">Recent search</a>



            </nav>
        </div>
        <hr class="line_bottom">
        <!-- ------------------------------------------------------Job list------------------------------>
        <div class="main-container">

            <!-- -------------------------------------------------------job cards ------------------------------- -->

            <div class="searched-jobs">
                <ul class="globalTargetList">
                    <div class="job-cards">

                        <?php generateJobCards($jobOffers); ?>


                    </div>
                </ul>
                <!-- feedback -->
                <div class="globalSearchResultNoFoundFeedback" aria-live="polite"> Search nothing found</div>
            </div>
        </div>


    </div>

    <!-- ----------------------modal job list ----------------------- -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="job-card">
                <div class="job-card-header">


                </div>
                <div class="job-card-title">
                    <h2><span>Work Immerion</span></h2>
                </div>
                <div class="job-detail-buttons">
                    <button class="search-buttons detail-button">Full Time</button>
                    <button class="search-buttons detail-button">Min. 1 Year</button>
                    <button class="search-buttons detail-button">Senior Level</button>
                </div>
                <div class="loc-com">
                    <h2>location</h2>
                    <div class="job-card-title-location"><i class="fas fa-map-marker-alt"></i>Pasig</div>
                </div>
                <div clas="full-des">
                    <h2>Full job description</h2>
                </div>
                <div class="job-card-subtitle">
                    <h4>JOB DESCRIPTION</h4>
                    <li>Properly document account information and input data in the appropriate systems.</li>
                    <li>Lead and prepare a report for each investigation to creditors.</li>
                    <li>Analytical and problem-solving skills to expedite these investigations.</li>
                    <li>Collect daily and weekly data for required reports and submit them to the supervisors prior to
                        deadlines.</li>
                    <li>Use computer applications to locate and trace clients.</li>

                    <h4>QUALIFICATION </h4>
                    <li>College Students taking up Computer and Business courses with On the Job training requirements
                        are also encouraged to join. (with allowance)</li>
                    <li>Computer literate</li>
                    <li>Knowledgeable in Microsoft Office tools</li>
                    <li>Critical thinker /Tech Savvy</li>

                    <h4>RESPONSIBILITIES</h4>
                    <li>[List of specific responsibilities and tasks]</li>
                    <li>[Another responsibility]</li>
                    <li>[Additional responsibility]</li>



                    <h4>BENEFITS</h4>
                    <li>[List of any benefits offered, such as health insurance, retirement plans, etc.].</li>

                    <h4>Consent from Parents or Guardians:</h4>
                    <li>Since work immersion may involve practical work experience outside the school premises,
                        consent from parents or guardians is usually required.</li>



                </div>


                <div class="job-card-buttons">
                    <a href="login.php"> <button class="search-buttons card-buttons" id="btnApply">Apply
                            Now</button></a>
                    <a href="login.php"><button class="search-buttons card-buttons-msg">Messages</button></a>
                </div>
            </div>
        </div>
    </div>


    <!-- --------------------------------joblist modal js-------------------------=--- -->
    <script>
    // Modal functionality
    document.addEventListener("DOMContentLoaded", function() {
        // Get the modal
        var modal = document.getElementById("myModal");

        var btn = document.getElementById("btnApply");

        var span = document.getElementsByClassName("close")[0];

        if (btn) {
            btn.onclick = function() {
                if (modal) {
                    modal.style.display = "block";
                }
            };
        }

        if (span) {

            span.onclick = function() {
                if (modal) {
                    modal.style.display = "none";
                }
            };
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    });
    </script>

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