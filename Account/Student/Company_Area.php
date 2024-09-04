<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
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

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>

</style>

<body>

    <?php echo $profile_div; ?>

    <br><br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a class="active" id="#area" href="Company_area.php"> Company Area</a>
            <a class="link" id="#review" href="Company_Review.php">Company review</a>
            <a class="link" id="#narrative" href="Narrative_Report.php">Narrative Report</a>
            <!-- <a class="link" id="#contact">Contact</a> -->

            <!-- <a href="aboutUs.php">About</a> -->

        </nav>
    </div>
    <hr class="line_bottom">




    <div class="content-sticky">


        <section>
            <!-- <h2 class="sfa">Search, Find and Apply!</h2 -->
            <div class="line-search">
                <div class="searchwork">
                    <form action="#" method="get">

                        <div class="search-container">
                            <button type="submit"><i class="fas fa-search"></i></button>
                            <input type="text" placeholder="Work Immersion / Keyword">

                        </div>
                        <div class="search-container">
                            <button type="submit"><i class="fas fa-map-marker-alt"></i></button>
                            <input type="text" placeholder="Search location">

                        </div>

                        <input type="submit" value="Find Now" href="">
                </div>
                </form>
            </div>

        </section>
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

        <!-- ----------------------modal job list ----------------------- -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="job-card">
                    <div class="job-card-header">
                        <svg viewBox="0 -13 512 512" xmlns="http://www.w3.org/2000/svg"
                            style="background-color:#2e2882">
                            <g fill="#feb0a5">
                                <path
                                    d="M256 92.5l127.7 91.6L512 92 383.7 0 256 91.5 128.3 0 0 92l128.3 92zm0 0M256 275.9l-127.7-91.5L0 276.4l128.3 92L256 277l127.7 91.5 128.3-92-128.3-92zm0 0" />
                                <path d="M127.7 394.1l128.4 92 128.3-92-128.3-92zm0 0" />
                            </g>
                            <path
                                d="M512 92L383.7 0 256 91.5v1l127.7 91.6zm0 0M512 276.4l-128.3-92L256 275.9v1l127.7 91.5zm0 0M256 486.1l128.4-92-128.3-92zm0 0"
                                fill="#feb0a5" />
                        </svg>
                        <div class="menu-dot"></div>
                    </div>
                    <div class="job-card-title">UI / UX Designer</div>
                    <div class="job-card-subtitle">
                        <h4>Job Summary:</h4>
                        The User Experience Designer position exists to create compelling and digital user experience
                        through excellent design...

                        <h4>Responsibilities:</h4>
                        <li>[List of specific responsibilities and tasks]</li>
                        <li>[Another responsibility]</li>
                        <li>[Additional responsibility]</li>

                        <h4>Requirements:</h4>
                        <li>College graduate.</li>
                        <li>Comfortable with performance-based income</li>
                        <li>Willing to be trained (training provided for free)</li>

                        <h4>Benefits:</h4>
                        <li>[List of any benefits offered, such as health insurance, retirement plans, etc.].</li>

                        <h4>Consent from Parents or Guardians:</h4>
                        <li>Since work immersion may involve practical work experience outside the school premises,
                            consent from parents or guardians is usually required.</li>



                    </div>

                    <div class="job-detail-buttons">
                        <button class="search-buttons detail-button">Full Time</button>
                        <button class="search-buttons detail-button">Min. 1 Year</button>
                        <button class="search-buttons detail-button">Senior Level</button>
                    </div>
                    <div class="job-card-buttons">
                        <button class="search-buttons card-buttons" id="btnApply">Apply Now</button>
                        <button class="search-buttons card-buttons-msg">Messages</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students</p>
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>

    <script>
    document.getElementById("currentDate").innerHTML = new Date().getFullYear();
    </script>
    <script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("btnApply");

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
    <script>
    window.onscroll = function() {
        myFunction()
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

</body>


</html>