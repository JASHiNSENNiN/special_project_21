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

function verify_org($org_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE partner_profiles SET verified_status = TRUE WHERE user_id = ?");
    $stmt->bind_param("i", $org_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function unverify_org($org_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE partner_profiles SET verified_status = FALSE WHERE user_id = ?");
    $stmt->bind_param("i", $org_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['org_id'])) {
    $org_id = intval($_POST['org_id']);
    $action = $_POST['action'];

    if ($action === 'verify') {
        verify_org($org_id);
    } elseif ($action === 'unverify') {
        unverify_org($org_id);
    }

    // Redirect back to the same page after verification
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function displayPartnerOrganizations()
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch all partner organizations with their verification status
    $sql = "SELECT pp.user_id, pp.organization_name, u.profile_image, pp.verified_status 
            FROM partner_profiles pp
            JOIN users u ON pp.user_id = u.id
            WHERE u.account_type = 'Organization'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table class="rwd-table" id="searchHumss">
                <tbody>
                    <tr>
                        <th>#</th>
                        <th>Profile Photo</th>
                        <th>Organization Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>';

        $count = 1;
        while ($row = $result->fetch_assoc()) {
            $encoded_id = base64_encode(encrypt_url_parameter((string) $row['user_id']));
            $profile_image = !empty($row['profile_image']) ? "/Account/Organization/uploads/" . $row['profile_image'] : "Account/Organization/uploads/default.png";

            echo "<tr>";
            echo "<td data-th='#'>" . $count . "</td>";
            echo "<td data-th='ID Picture' style='justify-content: center;'><img class='idpic' src='" . $profile_image . "' alt='Organization Photo'></td>";
            echo "<td data-th='Organization Name'>" . $row['organization_name'] . "</td>";
            echo "<td data-th='Status'>" . ($row['verified_status'] ? "Verified" : "Not Verified") . "</td>";

            echo "<td data-th='Action'>";
            // Action form for verification and unverification
            echo "<form method='post' style='display: inline;'>";
            echo "<input type='hidden' name='org_id' value='" . $row['user_id'] . "'>";
            // if ($row['verified_status']) {
            //     echo "<button class='button-11' type='submit' name='action' value='Disapprove' autofocus>Disapprove</button><br>";
            // } else {
            //     echo "<button class='button-10' type='submit' name='action' value='Approve' autofocus>Approve</button><br>";
            // }
            echo "</form>";
            echo "<button class='button-9' role='button' onclick=\"window.location.href='../../ProfileOrgView.php?organization_id=" . $encoded_id . "'\">Review Profile</button>";
            echo "</td>";
            echo "</tr>";

            $count++;
        }

        echo '</tbody></table>';
    } else {
        echo "<p>No partner organizations found.</p>";
    }

    $conn->close();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Dashboard</title>

    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <link rel="stylesheet" type="text/css" href="css/Notification-logs.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


</head>

<body>


    <?php echo $profile_div; ?>
    <br><br>
    <hr class="line_top">
    <div class="logo">
        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Student.php"><i class="fas fa-user-graduate"></i>Student</a>
            <a href="Organization.php"><i class="	fas fa-building"></i>Organization</a>
            <a href="Analytics.php"><i class="fa fa-bar-chart"></i>Analytics</a>
            <a class="active1" href="Notification-logs.php"><i class="fa fa-list"></i>Logs</a>



        </nav>
    </div>
    <hr class="line_bottom">


    <br>


    <div id="content_container">
        <div id="list" class="content active">
            <h1 style="margin-bottom: 3.125rem; margin-top:3.125rem">Notification logs</h1>
            <div class="d-flex justify-content-center ">

                <div class="tab-pane w-70 p-3 active show" id="messages" role="tabpanel">

                    <div class="filter-container mb-3">
                        <label for="dateFilter">Filter by Date:</label>
                        <select id="dateFilter" class="form-control w-25">
                            <option value="all">Whole Month</option>
                            <option value="today">Today</option>
                            <option value="thisWeek">This Week</option>
                            <option value="lastWeek">Last Week</option>
                        </select>
                    </div>

                    <div class="message" data-date="2025-05-01">
                        <div class="py-3 pb-5 mr-3 float-left">
                            <div class="avatar">
                                <i class="fa fa-bell text-muted" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">name of Company </small>
                            <small class="text-muted float-right mt-1">minutes</small>


                        </div>
                        <div class="text-truncate"> message</div>
                        <small class="text-muted">2025-05-05</small>
                        <hr>
                    </div>

                    <div class="message" data-date="2025-05-07">
                        <div class="py-3 pb-5 mr-3 float-left">
                            <div class="avatar">
                                <i class="fa fa-bell text-muted" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted"> Name of Company</small>
                            <small class="text-muted float-right mt-1">minutes (example 1 minutes ago)</small>
                        </div>
                        <div class="text-truncate">Accept message dialog </div>
                        <small class="text-muted">2025-05-07</small>
                        <hr>
                    </div>

                    <div class="message" data-date="2025-05-14">
                        <div class="py-3 pb-5 mr-3 float-left">
                            <div class="avatar">
                                <i class="fa fa-bell text-muted" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">name of company</small>
                            <small class="text-muted float-right mt-1">minutes</small>
                        </div>
                        <div class="text-truncate">disapprove message dialog </div>
                        <small class="text-muted">2025-05-14</small>
                        <hr>
                    </div>

                    <div class="message" data-date="2025-05-15">
                        <div class="py-3 pb-5 mr-3 float-left">
                            <div class="avatar">
                                <i class="fa fa-bell text-muted" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">name of Student</small>
                            <small class="text-muted float-right mt-1">2 days ago</small>
                        </div>
                        <div class="text-truncate">A new student has registered at your school: </div>
                        <small class="text-muted">2025-05-15</small>
                        <hr>
                    </div>

                    <div class="message" data-date="2025-05-19">
                        <div class="py-3 pb-5 mr-3 float-left">
                            <div class="avatar">
                                <i class="fa fa-bell text-muted" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">name of Student</small>
                            <small class="text-muted float-right mt-1">2 days ago</small>
                        </div>
                        <div class="text-truncate">A new student has registered at your school: </div>
                        <small class="text-muted">2025-05-19</small>
                        <hr>
                    </div>

                </div>

            </div>



        </div>

    </div>

    <script>
        document.getElementById('dateFilter').addEventListener('change', function () {
            const filterValue = this.value;
            const messages = document.querySelectorAll('.tab-pane .message');
            const today = new Date();
            // Helper functions
            function getStartOfWeek(date) {
                const day = date.getDay();
                const diff = date.getDate() - day + (day === 0 ? -6 : 1); // adjust when day is Sunday
                return new Date(date.getFullYear(), date.getMonth(), diff);
            }

            function getEndOfWeek(date) {
                const start = getStartOfWeek(date);
                return new Date(start.getFullYear(), start.getMonth(), start.getDate() + 6);
            }

            messages.forEach(msg => {
                const msgDateStr = msg.getAttribute('data-date');
                if (!msgDateStr) {
                    // If no date data, show by default
                    msg.style.display = '';
                    return;
                }
                const msgDate = new Date(msgDateStr);
                let show = true;

                switch (filterValue) {
                    case 'all':
                        show = true;
                        break;
                    case 'today':
                        show = msgDate.toDateString() === today.toDateString();
                        break;
                    case 'thisWeek':
                        const startOfWeek = getStartOfWeek(today);
                        const endOfWeek = getEndOfWeek(today);
                        show = msgDate >= startOfWeek && msgDate <= endOfWeek;
                        break;
                    case 'lastWeek':
                        const lastWeekStart = new Date(getStartOfWeek(today));
                        lastWeekStart.setDate(lastWeekStart.getDate() - 7);
                        const lastWeekEnd = new Date(lastWeekStart);
                        lastWeekEnd.setDate(lastWeekStart.getDate() + 6);
                        show = msgDate >= lastWeekStart && msgDate <= lastWeekEnd;
                        break;
                }

                msg.style.display = show ? '' : 'none';
            });
        });
    </script>

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
        $(".box").click(function (e) {
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