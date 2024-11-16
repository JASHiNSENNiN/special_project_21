<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/session_handler.php';

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$home = "Job_ads.php";

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = $conn->prepare("SELECT * FROM job_offers WHERE partner_id = ?");
$sql->bind_param("i", $_SESSION['user_id']);
$sql->execute();
$result = $sql->get_result();

$jobOffers = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $jobOffers[] = $row;
    }
}

function generateJobCards($jobOffers)
{
    if (empty($jobOffers)) {
        echo '<p>No job offers available.</p>';
        return;
    }

    foreach ($jobOffers as $job) {
        $strands = json_decode($job['strands']);
        $description = nl2br(html_entity_decode($job['description']));

        echo '
        <li>
            <div class="job-card">
                <div class="job-card-title">
                    <h2><span>' . htmlspecialchars($job['work_title']) . '</span></h2>
                    <div class="job-card-title-company">' . htmlspecialchars($job['organization_name']) . '</div>
                    <div class="job-detail-buttons">';

        if ($strands && is_array($strands)) {
            foreach ($strands as $strand) {
                echo '<button class="search-buttons detail-button">' . htmlspecialchars($strand) . '</button>';
            }
        }

        echo '
                    </div>
                </div>
                
                <div class="job-card-subtitle">
                    <div>' . $description . '</div>
                </div>
                
                <div class="job-card-buttons">';

        // Edit button
        echo '<a href="edit_job.php?id=' . htmlspecialchars($job['id']) . '"><button class="search-buttons card-buttons">Edit</button></a>';

        // Conditionally display archive/unarchive buttons based on job status
        if ($job['is_archived']) {
            echo '<a href="?action=unarchive&id=' . htmlspecialchars($job['id']) . '" onclick="return confirm(\'Are you sure you want to unarchive this job?\');"><button class="search-buttons card-buttons">Unarchive</button></a>';
        } else {
            echo '<a href="?action=archive&id=' . htmlspecialchars($job['id']) . '" onclick="return confirm(\'Are you sure you want to archive this job?\');"><button class="search-buttons card-buttons">Archive</button></a>';
        }

        echo '
                </div>
            </div>
        </li>';
    }
}

function archiveJob($id)
{
    global $conn;

    $sql = $conn->prepare("UPDATE job_offers SET is_archived = TRUE WHERE id = ?");
    $sql->bind_param("i", $id);
    return $sql->execute();
}

function unarchiveJob($id)
{
    global $conn;

    $sql = $conn->prepare("UPDATE job_offers SET is_archived = FALSE WHERE id = ?");
    $sql->bind_param("i", $id);
    return $sql->execute();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] === 'archive') {
        archiveJob($id);
    } elseif ($_GET['action'] === 'unarchive') {
        unarchiveJob($id);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/My_Jobs.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>
    <title>My Jobs</title>
</head>

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
            <a href="<?= $home ?>">
                <!-- <img src="../../img/logov3.jpg" alt="Logo"> -->
                <img src="image/drdsnhs.svg" alt="Logo">
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
            <a class="com-btn" href="<?= $home ?>"> Back</a>
        </nav>
    </header>

    <div class="container">
        <!-- <div class="row">
            <div class="col">
                <div class="containerbox">

                    <div class="job-card">
                        <div class="job-card-header">
                            <div class="menu-dot"></div>
                        </div>
                        <div class="job-card-title">UI / UX Designer</div>
                        <div class="job-card-subtitle">
                            The User Experience Designer position exists to create compelling and digital user
                            experience through excellent design...
                        </div>
                        <div class="job-detail-buttons">
                            <button class="search-buttons detail-button">Full Time</button>
                            <button class="search-buttons detail-button">Min. 1 Year</button>
                            <button class="search-buttons detail-button">Senior Level</button>
                        </div>
                        <div class="job-card-buttons">
                            <button class="button-10" role="button">Update</button>
                            <button class="button-3" onclick="myFunction()" role="button">Delete</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col order-5">
                Second in DOM, with a larger order
            </div>
            <div class="col order-1">
                Third in DOM, with an order of 1
            </div>
        </div> -->

        <div class="searched-jobs">
            <ul class="globalTargetList" style="list-style-type: none;">
                <div class="job-cards">

                    <?php generateJobCards($jobOffers); ?>


                </div>
            </ul>
            <!-- feedback -->
            <!-- <div class="globalSearchResultNoFoundFeedback" aria-live="polite"> Search nothing found</div> -->
        </div>
    </div>

    <script>
        function myFunction() {
            confirm("Are you Sure?");
        }
    </script>

</body>

</html>