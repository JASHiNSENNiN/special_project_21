<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$ProfileViewURL = "../../ProfileView.php";

function get_students_by_strand($strand)
{

    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!isset($_SESSION['school_name'])) {
        die("Error: School name is not set in the session.");
    }
    $schoolName = $_SESSION['school_name'];

    $stmt = $conn->prepare("
        SELECT sp.*, 
               u.*, 
               COALESCE(jo.organization_name, 'N/A') AS organization_name 
        FROM student_profiles AS sp 
        JOIN users AS u ON sp.user_id = u.id 
        LEFT JOIN job_offers AS jo ON sp.current_work = jo.id 
        WHERE sp.strand = ? AND sp.school = ?
    ");

    $stmt->bind_param("ss", $strand, $schoolName);

    $stmt->execute();

    $result = $stmt->get_result();

    $students = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }

    $stmt->close();
    $conn->close();

    return $students;
}

// function verify_student($student_id)
// {
// }
function verify_student($student_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE student_profiles SET verified_status = TRUE WHERE user_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// function unverify_student($student_id)
// {}

function unverify_student($student_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE student_profiles SET verified_status = FALSE WHERE user_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
    $student_id = intval($_POST['student_id']);
    $action = $_POST['action'];

    if ($action === 'verify') {
        verify_student($student_id);
    } elseif ($action === 'unverify') {
        unverify_student($student_id);
    }

    // header("Location: " . $_SERVER['PHP_SELF']); 
    // exit();
}

$list_organization = get_students_by_strand('list');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Dashboard</title>

    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <link rel="stylesheet" type="text/css" href="css/Organization.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>


</head>

<body>


    <?php echo $profile_div; ?>
    <br><br>
    <hr>
    <div class="logo">
        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Student.php"><i class="fas fa-user-graduate"></i>Student</a>
            <a class="active1" href="Organization.php"><i class="	fas fa-building"></i>Organization</a>
            <a href="Dashboard.php"><i class="fa fa-bar-chart"></i>Analytics</a>



        </nav>
    </div>
    <hr class="line_bottom">


    <br>


    <div id="content_container">
        <div id="list" class="content active">
            <h1 style="margin-bottom: 50px; margin-top:50px">Organization List</h1>


            <div class="container2">
                <div class="search-bar">
                    <input type="text" class="search-input" id="searchOrg" onkeyup="searchTable('list')"
                        placeholder="Search..." />
                    <button class="search-button">Search</button>
                </div>
                <table class="rwd-table" id="searchHumss">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>ID Picture</th>
                            <th>Organization Name</th>

                            <th>Action</th>
                        </tr>

                        <tr>
                            <td data-th="#">1</td>
                            <td data-th="ID Picture"><img class="idpic" src="uploads/default.png" alt="me"></td>
                            <td data-th="Student Name">PICC</td>

                            <td data-th="Action">
                                <button class="button-9" role="button"
                                    onclick="window.location.href='../../ProfileOrgView.php'">View
                                    Profile</button>
                            </td>
                        </tr>
                        <tr>
                            <td data-th="#">2</td>
                            <td data-th="ID Picture"><img class="idpic" src="uploads/default.png" alt="me"></td>
                            <td data-th="Student Name">HYUNDAI</td>

                            <td data-th="Action">

                                <button class="button-9" role="button"
                                    onclick="window.location.href='../../ProfileOrgView.php?student_id=encoded_student_id_2'">View
                                    Profile</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
    function searchTable(section) {
        // Get the input value and convert it to uppercase
        let input = document.querySelector(`#search${section.charAt(0).toUpperCase() + section.slice(1)}Input`);
        let filter = input.value.toUpperCase();

        // Select the table within the active content section
        let table = document.getElementById(`search${section.charAt(0).toUpperCase() + section.slice(1)}`);
        let tr = table.getElementsByTagName('tr'); // Get all row   s in the table

        // Loop through the rows (skip the header row)
        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName('td')[2]; // Check the Student Name column (index 2)
            if (td) {
                let textValue = td.textContent || td.innerText;
                // If the name matches the input value, show the row; otherwise, hide it
                if (textValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = ''; // Show the row
                } else {
                    tr[i].style.display = 'none'; // Hide the row
                }
            }
        }
    }
    </script>


    <script>
    $(".box").click(function(e) {
        e.preventDefault();
        $(".content").removeClass("active");
        var content_id = $(this).attr("id");
        $(content_id).addClass("active");
    });
    </script>
    <br>
    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
        <!-- <p>&copy;2024 Your Website. All rights reserved. | Junior Philippines Computer</p> -->
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



    <script type="text/javascript">
    // Get DOM Elements
    const modal = document.querySelector('#my-modal');
    const modalBtn = document.querySelector('#modal-btn');
    const closeBtn = document.querySelector('.close');

    // Events
    modalBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    window.addEventListener('click', outsideClick);

    // Open
    function openModal() {
        modal.style.display = 'block';
    }

    // Close
    function closeModal() {
        modal.style.display = 'none';
    }

    // Close If Outside Click
    function outsideClick(e) {
        if (e.target == modal) {
            modal.style.display = 'none';
        }
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