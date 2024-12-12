<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/session_handler.php';

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$home = "My_Jobs.php";

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
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/My_Jobs.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <img src="../../img/logov3.jpg" alt="Logo">
                <!-- <img src="image/drdsnhs.svg" alt="Logo"> -->
            </a>
            <nav class="dash-middle">

            </nav>
        </div>
        <nav class="nav-log">

            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="com-btn" href="<?= $home ?>"> Back</a>
        </nav>
    </header>

    <div class="sales-boxes">
        <div class="recent-sales box">
            <b>
                <!-- <div class="box-topic" style="margin-left: 20px;">Post a Job ad for free </div> -->
            </b>

            <!-- <div class="title">Popularity Company </div> -->
            <!-- <div class="title">Student List <div class="icon"><i class="bx bx-user-plus"></i> </div> </div> -->

            <form method="post" action="/backend/php/add_job.php">
                <div class="container">

                    <h1 class="ti">EDIT POST JOB AD</h1>
                    <p class="ti">Please fill in this form to create a job.</p>



                    <div class="box">
                        <label for="worktitle"><b>Work Title</b></label>
                        <input type="text" placeholder="Enter Work Title" name="work_title" id="worktitle" required>

                        <label for=""><b>Choose a Strand:</b></label><br><br>
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
                        <label class="con">ABM
                            <input type="checkbox" name="strand[]" value="ABM">
                            <span class="checkmark"></span>
                        </label>


                        <div class="wrapper">
                            <div class="title">


                            </div>
                        </div>

                        <h1>Job Description</h1>

                        <input type="hidden" name="description" id="description">
                        <div id="editor-container"></div>

                        <div class="container__nav">
                            <small>By clicking 'Check box' you are agreeing to our <a
                                    href="../../Term_and_Privacy.php">Terms & Privacy</a></small>
                            <input class="required" type="checkbox" id="agree" name="agree" value="agree" required>
                        </div>
                        <button class="button-9-save" id="show-modal" role="button" type="submit"
                            autofocus>Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <script>
    // Initialize Quill editor for each modal dynamically
    document.addEventListener("DOMContentLoaded", function() {
        <?php foreach ($jobOffers as $job): ?>
        var quill = new Quill('#editor-container_<?php echo $job['id']; ?>', {
            theme: 'snow'
        });

        // Set the current description in the editor for each job modal
        quill.root.innerHTML = '<?php echo htmlspecialchars($job['description']); ?>';

        // When submitting the form, save the content from the editor
        var form = document.querySelector("#myModal-job<?php echo $job['id']; ?> form");
        form.addEventListener("submit", function() {
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