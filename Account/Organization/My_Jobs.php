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
        // Inside the loop, generate the edit button for each job
        echo '<a href="javascript:void(0);" class="editBtn" id="editBtn_' . $job['id'] . '" onclick="openModal(' . $job['id'] . ')">
        <button class="search-buttons card-buttons">Edit</button>
      </a>';




        // Conditionally display archive/unarchive buttons based on job status
        if ($job['is_archived']) {
            echo '<a href="?action=unarchive&id=' . htmlspecialchars($job['id']) . '"
    onclick="return confirm(\'Are you sure you want to unarchive this job?\');"><button
        class="search-buttons card-buttons">Unarchive</button></a>';
        } else {
            echo '<a href="?action=archive&id=' . htmlspecialchars($job['id']) . '"
    onclick="return confirm(\'Are you sure you want to archive this job?\');"><button
        class="search-buttons card-buttons">Archive</button></a>';
        }

        echo '
</div>
</div>
</li>';
        echo '<div id="myModal_' . $job['id'] . '" class="modal">
    <div class="modal-content" style="width:50%; margin-top:-60px; border-radius:20px;">
        <span class="close" onclick="closeModal(' . $job['id'] . ')">&times;</span>
        <div class="gra">
            <h1 style="color:#fff;">EDIT JOB ADS</h1>
            <p style="color:#fff;">Please fill in this form to update your job.</p>
        </div>
        <form method="post" action="/backend/php/add_job.php">
            <div class="container1">
                <input type="text" placeholder="Enter Work Title" name="work_title" id="worktitle_' . $job['id'] . '"
                    value="' . htmlspecialchars($job['work_title']) . '" required>

                <div class="container2">
                    <label class="con">STEM
                        <input type="checkbox" name="strand[]" value="STEM" ' . (in_array("STEM", $strands) ? ' checked'
            : '') . '>
                            <span class="checkmark"></span>
                        </label>
                        <label class="con">GAS
                            <input type="checkbox" name="strand[]" value="GAS" ' . (in_array("GAS", $strands)
            ? 'checked' : '') . '>
                            <span class="checkmark"></span>
                        </label>
                        <label class="con">HUMSS
                            <input type="checkbox" name="strand[]" value="HUMSS" ' . (in_array("HUMSS", $strands)
            ? 'checked' : '') . '>
                            <span class="checkmark"></span>
                        </label>
                        <label class="con">TECHVOC
                            <input type="checkbox" name="strand[]" value="TVL" ' . (in_array("TVL", $strands)
            ? 'checked' : '') . '>
                            <span class="checkmark"></span>
                        </label>
                    </div>

                    <input type="hidden" name="description" id="description_' . $job['id'] . '" value="' .
            htmlspecialchars($job['description']) . '">
                    <div id="editor-container_' . $job['id'] . '" style="height: 100px;"></div>

                   
                <button class="button-9" role="button" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>';
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

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
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
    <!-- <div id="myModal" class="modal">

       
        <div class="modal-content" style="width:50%; margin-top:-60px; border-radius:20px;">
            <span class="close">&times;</span>
            <div class="gra">
                <h1 style="color:#fff;">EDIT JOB ADS</h1>
                <p style="color:#fff;">Please fill in this form to update your job.</p>
            </div>
            <form method="post" action="/backend/php/add_job.php">

                <div class="container1">


                    <input type="text" placeholder="Enter Work Title" name="work_title" id="worktitle" required>

                    <div class="container2">
                       
                        <label class="con">STEM
                            <input type="checkbox" name="strand[]" value="STEM">
                            <span class="checkmark"></span>
                        </label>

                        <label class="con">GAS
                            <input type="checkbox" name="strand[]" value="GAS">
                            <span class="checkmark"></span>
                        </label>
                        <label class="con">HUMSS
                            <input type="checkbox" name="strand[]" value="HUMSS">
                            <span class="checkmark"></span>
                        </label>
                        <label class="con">TECHVOC
                            <input type="checkbox" name="strand[]" value="TVL">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    

                    <input type="hidden" name="description" id="description">
                    <div id="editor-container" style="height: 100px;"></div>

                    <div class="container__nav">
                        <small>By clicking 'Check box' you are agreeing to our <a
                                href="../../Term_and_Privacy.php">Terms & Privacy</a></small>
                        <input type="checkbox" id="agree" name="agree" value="agree" required>
                    </div>
                    <button class="button-9" role="button" type="submit">Submit</button>
                </div>
            </form>

        </div>

    </div> -->

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

    <div class="container" style="margin-left:-20px; width:auto;">

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

    <!-- <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function () {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script> -->

    <!-- <script>
    // Get all the buttons that open modals
    var modalBtns = document.querySelectorAll('.editBtn'); // Use a class for all buttons

    modalBtns.forEach(function(btn) {
        // Get the modal ID dynamically from the button's ID (e.g., editBtn_1 -> myModal_1)
        var modalId = 'myModal_' + btn.id.split('_')[1]; // Extract job id from the button ID
        var modal = document.getElementById(modalId); // Get the corresponding modal
        var span = modal.getElementsByClassName("close")[0]; // Get the close button inside the modal

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
    });
    </script> -->

    <script>
        // Open the modal for the specific job
        function openModal(jobId) {
            var modal = document.getElementById("myModal_" + jobId); // Get the modal based on job ID
            modal.style.display = "block";
        }

        // Close the modal for the specific job
        function closeModal(jobId) {
            var modal = document.getElementById("myModal_" + jobId); // Get the modal based on job ID
            modal.style.display = "none";
        }

        // Close modal when clicking outside of it
        window.onclick = function (event) {
            var modalBtns = document.querySelectorAll('.modal');
            modalBtns.forEach(function (modal) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });
        }
    </script>

    <script>
        // Initialize Quill editor for each modal dynamically
        document.addEventListener("DOMContentLoaded", function () {
            <?php foreach ($jobOffers as $job): ?>
                var quill = new Quill('#editor-container_<?php echo $job['id']; ?>', {
                    theme: 'snow'
                });

                // Set the current description in the editor for each job modal
                quill.root.innerHTML = '<?php echo htmlspecialchars($job['description']); ?>';

                // When submitting the form, save the content from the editor
                var form = document.querySelector("#myModal_<?php echo $job['id']; ?> form");
                form.addEventListener("submit", function () {
                    document.getElementById("description_<?php echo $job['id']; ?>").value = quill.root
                        .innerHTML;
                });
            <?php endforeach; ?>
        });
    </script>


    <script>
        function myFunction() {
            confirm("Are you Sure?");
        }
    </script>
    <script type="text/javascript" src="css/doc.js"></script>

</body>

</html>