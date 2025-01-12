<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
;
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
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM job_offers WHERE is_archived = 0";
$result = $conn->query($sql);

$jobOffers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobOffers[] = $row;
    }
}


$student_id = $_SESSION['user_id'];
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT status FROM applicants WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['status'] === 'completed') {
        header("Location: Congratulation.php");
        exit(); 
    }
}

$stmt->close();
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
                    <a href="org.php?job_id=' . base64_encode(encrypt_url_parameter((string) $job['id'])) . '"><button class="search-buttons card-buttons">Details</button></a>
                    <!--<button class="search-buttons card-buttons-msg">Save</button>-->
                </div>
            </div>
        </li>';
    }
}



function isStudentProfileVerified($pdo)
{
    $sql = "SELECT verified_status FROM student_profiles WHERE user_id = :user_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return (bool) $result['verified_status']; // Explicitly cast to boolean
        }
    }

    return false;
}

$student_id = $_SESSION['user_id'];

if (!isStudentProfileVerified($pdo)) {
    header('Location: verify.php');
    exit();
}

// <a href="../../org.php?job_id=' . base64_encode(encrypt_url_parameter((string) $job['id'])) . '" target="_blank"><button class="search-buttons card-buttons">Details</button></a>
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/modal.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
</head>
<style>

</style>

<body>

    <?php echo $profile_div; ?>

    <br><br>
    <!-- <hr> -->
    <div class="logo">

        <!-- <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a class="active" id="#area" href="Company_area.php"> Company Area</a>
            <a class="link" id="#review" href="Company_Review.php">Company review</a>
            <a class="link" id="#narrative" href="Narrative_Report.php">Narrative Report</a>

        </nav> -->
    </div>
    <hr class="line_bottom">




    <div class="content-sticky">


        <section>
            <!-- <h2 class="sfa">Search, Find and Apply!</h2> -->
            <div class="line-search">
                <div class="searchwork">

                    <form action="#" method="get">

                        <div class="search-container">
                            <button type="submit"><i class="fas fa-search"></i></button>
                            <input id="globalInputSearchs" name="globalInputSearchs" class="globalInputSearchs"
                                type="text" placeholder="Work Immersion / Keyword">

                        </div>
                        <div class="search-container" style="border-left: 1px solid grey">
                            <button type="submit"><i class="fas fa-map-marker-alt"></i></button>
                            <input id="InputSearch" name="InputSearch" class="globalInputSearchs" type="text"
                                placeholder="Search location">

                        </div>

                        <!-- <input class="sub-btn" type="submit" value="Find Now"> -->

                </div>
                </form>
            </div>

        </section>

        <div class="tab-selection">


            <nav style="position:relative; margin-left:auto; margin-right:auto;">
                <!-- <a class="active" href="index.php">Work Immersion feed</a>
                <a href="recent-search.php">Recent search</a> -->



            </nav>
        </div>
        <hr class="line_bottom">
        <!-- ------------------------------------------------------Job list------------------------------>
        <div class="main-container">

            <!-- -------------------------------------------------------job cards ------------------------------- -->

            <div class="searched-jobs">
                <ul class="globalTargetLists">
                    <div class="job-cards">

                        <?php generateJobCards($jobOffers); ?>


                    </div>
                </ul>
                <!-- feedback -->
                <div class="globalSearchResultNoFoundFeedbacks" aria-live="polite"> Search nothing found</div>
            </div>
        </div>


    </div>


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

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
        <!-- ©2024 Your Website. All rights reserved. | Junior Philippines Computer -->
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>

    <script src="css/filter.js"></script>


</body>


</html>