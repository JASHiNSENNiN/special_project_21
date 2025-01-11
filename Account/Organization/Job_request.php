<?php
session_start();
require_once 'show_profile.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$ProfileViewURL = "../../ProfileView.php";

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

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT job_id, student_id FROM applicants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {

        echo "No applicant found with the given ID.";
        return;
    }

    $job_offer_id = $row['job_id'];
    $student_id = $row['student_id'];

    $sql = "UPDATE applicants SET status = 'accepted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();

    $sql = "UPDATE student_profiles SET current_work = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $job_offer_id, $student_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}















if (isset($_POST['complete_applicant'])) {
    $applicant_id = $_POST['applicant_id'];
    completeApplicant($applicant_id);
}

function completeApplicant($applicant_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE applicants SET status = 'completed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['ongoing_applicant'])) {
    $applicant_id = $_POST['applicant_id'];
    revertToOngoing($applicant_id);
}

function revertToOngoing($applicant_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE applicants SET status = 'accepted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
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
            <a href="Job_ads.php"><i class="fa fa-calendar-plus-o"></i> Job Ads</a>
            <a class="active" href="Job_request.php"><i class="fa fa-user-plus"></i> Job Request</a>
            <a href="Faculty_report.php"><i class='fas fa-tasks'></i> Student Evaluation</a>
            <!-- <a href="Question.php">Questions</a> -->
            <a href="Details.php"><i class="fa fa-bar-chart"></i> Analytics</a>


        </nav>
    </div>
    <hr class="line_bottom">


    <div class="sales-boxes">
        <div class="recent-sales box">
            <b>
                <div class="box-topic">Job Request</div>
            </b>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search...">
                <i class='bx bx-search'></i>
            </div>

            <br>

            <table id="tbl" class="rwd-table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Strand</th>
                    <th>Job Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($applicants as $job_id => $applicant_list) { ?>
                    <?php foreach ($applicant_list as $applicant) { ?>
                        <?php
                        $student_id = $applicant['student_id'];
                        $sql = "SELECT * FROM student_profiles WHERE user_id = '$student_id'";
                        $student_row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

                        $job_title_query = "SELECT work_title FROM job_offers WHERE id = '{$applicant['job_id']}'";
                        $job_row = mysqli_fetch_assoc(mysqli_query($conn, $job_title_query));
                        $job_title = $job_row['work_title'] ?? 'N/A'; // Use 'N/A' if no job title found
                        ?>
                        <tr>
                            <td><?= $applicant['id'] ?></td>
                            <td><?= $student_row['first_name'] . ' ' . $student_row['last_name'] ?></td>
                            <td><?= $student_row['strand'] ?></td>
                            <td><?= $job_title ?></td>
                            <td>
                                <?php
                                switch ($applicant['status']) {
                                    case 'applied':
                                        echo '<input type="text" value="Requesting.." readonly>
                                  ';
                                        break;
                                    case 'accepted':
                                        echo '<input type="text" value="Ongoing.." readonly>
                                  ';
                                        break;
                                    case 'completed':
                                        echo '<input type="text" value="Completed!" readonly>
                                  ';
                                        break;
                                    default:
                                        echo '<input type="text" value="Applying" readonly>';
                                }
                                ?>
                            </td>


                            <td>
                                <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                                    <input type="hidden" name="applicant_id" value="<?= $applicant['id'] ?>">
                                    <?php if ($applicant['status'] === 'completed') { ?>
                                        <!-- Do not show any buttons if the status is 'completed' -->
                                        <!-- <input type="text" value="Completed!" readonly> -->
                                    <?php } elseif ($applicant['status'] === 'accepted') { ?>
                                        <button type="submit" class="button-5" name="remove_applicant" autofocus>Remove</button><br>
                                    <?php } else { ?>
                                        <button type="submit" class="button-9" name="accept_applicant" onclick="updateStatus(this)"
                                            autofocus>Accept</button>
                                    <?php } ?>
                                </form>
                                <a
                                    href="<?php echo $ProfileViewURL; ?>?student_id=<?= base64_encode(encrypt_url_parameter($applicant['student_id'])); ?>">
                                    <button type="button" class="button-4">Details</button> <br>
                                </a>
                                <?php
                                switch ($applicant['status']) {
                                    case 'applied':
                                        echo '
                                  <form method="POST" style="display:inline;">
                                      <input type="hidden" name="applicant_id" value="' . $applicant['id'] . '">
                                      <button type="submit" class="button-9" name="accept_applicant" style="padding: 0 13px;">Accept</button>
                                  </form>';
                                        break;
                                    case 'accepted':
                                        echo '
                                  <form method="POST" style="display:inline;">
                                      <input type="hidden" name="applicant_id" value="' . $applicant['id'] . '"> 
                                      <button type="submit" class="button-9" name="complete_applicant" style="padding: 0 13px;">Complete</button>
                                  </form>';
                                        break;
                                    case 'completed':
                                        echo '
                                  <form method="POST" style="display:inline;">
                                      <input type="hidden" name="applicant_id" value="' . $applicant['id'] . '">
                                      <button type="submit" class="button-9" name="ongoing_applicant" style="padding: 0 13px;">Revert to Ongoing</button>
                                  </form>';
                                        break;
                                    default:
                                        break;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>

        </div>
    </div>

    <!-- The Modal -->


    <!-- JavaScript for table search -->
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            var searchValue = this.value.toLowerCase();
            var rows = document.querySelectorAll('#tbl tr:not(:first-child)');

            Ramws.forEach(function (row) {
                var cells = row.getElementsByTagName('td');
                var nameCell = cells[1];
                var jobCell = cells[3];
                var found = false;

                if (
                    nameCell.textContent.toLowerCase().indexOf(searchValue) > -1 ||
                    jobCell.textContent.toLowerCase().indexOf(searchValue) > -1
                ) {
                    found = true;
                }

                row.style.display = found ? '' : 'none';
            });
        });
    </script>




    <footer>
        <!-- <p>&copy;2024 Your Website. All rights reserved. | Junior Philippines Computer</p> -->
        <p>&copy;2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
    </footer>

    <script>
        let profilePic1 = document.getElementById("cover-pic");
        let inputFile1 = document.getElementById("input-file1");

        inputFile1.onchange = function () {
            profilePic1.src = URL.createObjectURL(inputFile1.files[0]);
        }
    </script>

    <script>
        let profilePic2 = document.getElementById("profile-pic");
        let inputFile2 = document.getElementById("input-file2");

        inputFile2.onchange = function () {
            profilePic2.src = URL.createObjectURL(inputFile2.files[0]);
        }
    </script>


    <script type="text/javascript">
        function toggleNotifications() {
            const extraNotifications = document.querySelector('.extra-notifications');
            const seeMoreLink = document.querySelector('.see-more');

            if (extraNotifications.style.display === 'none' || extraNotifications.style.display === '') {
                extraNotifications.style.display = 'block';
                seeMoreLink.textContent = 'See Less';
            } else {
                extraNotifications.style.display = 'none';
                seeMoreLink.textContent = 'See More';
            }
        }
    </script>


</body>

</html>