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
$sql = "SELECT * FROM job_offers WHERE is_archived = false";
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
                    <a href="org.php?job_id=' . base64_encode(encrypt_url_parameter((string) $job['id'])) . '" ><button class="search-buttons card-buttons">Details</button></a>
                    
                </div>
            </div>
        </li>';
    }
}

?>
<!-- <button class="search-buttons card-buttons-msg">Save</button> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Work Immersion Search | Workify</title>
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
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
    <script>
    document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
    <header id="myHeader-sticky">
        <div class="logo">
            <a href="index.php">
                <img src="img/WORKIFY-LOGO.svg" alt="Logo">
                <!-- <img src="img/DrRamonLOGO.svg" alt="Logo"> -->
                <!-- <img src="img/drdsnhs.svg" alt="Logo"> -->
            </a>
            <nav class="dash-middle">
                <!-- <a class="active-header" href="index.php">Home</a>
                <a href="job_list.php">Company review</a>
                <a href="contact.php">Contact</a> -->
            </nav>
        </div>
        <nav>
            <a class="login-btn" href="login.php" style="margin-left: 20px;">Sign in</a>
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="com-btn" href="post_work_Immersion.php">Post Work Immersion</a>
        </nav>

    </header>

    <div class="bg-search">
        <div class="content-sticky">



            <section>
                <!-- <h2 class="sfa">Search, Find and Apply!</h2> -->
                <div class="line-search">
                    <div class="searchwork">
                        <form action="#" method="get">

                            <div class="search-container">
                                <button type="submit"><i class="fas fa-search"></i></button>
                                <input id="globalInputSearch" name="globalInputSearch" class="globalInputSearch"
                                    type="text" placeholder="Work Immersion / Keyword">

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
                    <!-- <a href="recent-search.php">Recent search</a> -->



                </nav>
            </div>
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