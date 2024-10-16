<?php
session_start();
require_once 'show_profile.php';

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

$org_id = $_SESSION['user_id'];

$sql = "SELECT * FROM job_offers WHERE partner_id = '$org_id'";
$result = mysqli_query($conn, $sql);

$applicants = array();
while ($row = mysqli_fetch_assoc($result)) {
    $job_id = $row['id'];
    $sql = "SELECT * FROM applicants WHERE job_id = '$job_id'";
    $applicant_result = mysqli_query($conn, $sql);
    while ($applicant_row = mysqli_fetch_assoc($applicant_result)) {
        $applicants[$job_id][] = $applicant_row;
    }
}

if (isset($_POST['remove_applicant'])) {
    $applicant_id = $_POST['applicant_id'];
    removeApplicant($applicant_id);
}

function removeApplicant($applicant_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];
    $conn = new mysqli($host, $username, $password, $database);

    $sql = "UPDATE applicants SET status = 'rejected' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();

    $sql = "UPDATE student_profiles SET current_work = NULL WHERE user_id = (SELECT student_id FROM applicants WHERE id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    header("Location: " . $_SERVER['PHP_SELF']);
}

if (isset($_POST['accept_applicant'])) {
    $applicant_id = $_POST['applicant_id'];
    acceptApplicant($applicant_id);
}

function acceptApplicant($applicant_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];
    $conn = new mysqli($host, $username, $password, $database);

    $sql = "SELECT student_id FROM applicants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $student_id = $row['student_id'];

    $sql = "UPDATE applicants SET status = 'accepted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();

    $sql = "UPDATE student_profiles SET current_work = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $applicant_id, $student_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    header("Location: " . $_SERVER['PHP_SELF']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <link rel="stylesheet" type="text/css" href="css/Job_request.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->


    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet '>


</head>

<body>
    <?php echo $profile_div; ?>
    <br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"> Job Ads</a>
            <a class="active" href="Job_request.php">Job Request</a>
            <a href="Faculty_report.php">Student Evaluation</a>
            <a href="Question.php">Questions</a>
            <a href="Details.php">Analytics</a>


        </nav>
    </div>
    <hr class="line_bottom">


    <div class="sales-boxes">
        <div class="recent-sales box">

            <b>
                <div class="box-topic">Job Request</div>
            </b>
            <div class="search-box">
                <input type="text" placeholder="Search...">
                <i class='bx bx-search'></i>
            </div>

            <br>
            <!-- <div class="title">Popularity Company </div> -->
            <!-- <div class="title">Student List <div class="icon"><i class="bx bx-user-plus"></i> </div> </div> -->

            <table id="tbl" class="rwd-table">
                <tr>
                    <th>ID</th>
                    <!-- <th>Student ID</th> -->
                    <th>Name</th>
                    <th>Strand</th>
                    <th>School</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($applicants as $job_id => $applicant_list) { ?>
                    <?php foreach ($applicant_list as $applicant) { ?>
                        <?php
                        $student_id = $applicant['student_id'];
                        $sql = "SELECT * FROM student_profiles WHERE user_id = '$student_id'";
                        $result = mysqli_query($conn, $sql);
                        $student_row = mysqli_fetch_assoc($result);
                        ?>
                        <tr>
                            <td><?= $applicant['id'] ?></td>
                            <td><?= $student_row['first_name'] . ' ' . $student_row['last_name'] ?></td>
                            <td><?= $student_row['strand'] ?></td>
                            <td><?= $student_row['school'] ?></td>
                            <td>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="applicant_id" value="<?= $applicant['id'] ?>">
                                    <?php if ($applicant['status'] == 'accepted') { ?>
                                        <button type="submit" class="button-4" name="remove_applicant">Remove</button>
                                    <?php } else { ?>
                                        <button type="submit" class="button-9" name="accept_applicant">Accept</button>
                                    <?php } ?>
                                </form>
                                <a
                                    href="../Student/Profile.php?student_id=<?= base64_encode(encrypt_url_parameter($applicant['student_id'])) ?>">
                                    <button type="button" class="button-4">Details</button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
        </div>

    </div>


    <footer>
        <p>&copy;2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
    </footer>

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