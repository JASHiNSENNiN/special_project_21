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

$humss_students = get_students_by_strand('humss');
$stem_students = get_students_by_strand('stem');
$abm_students = get_students_by_strand('abm');
$gas_students = get_students_by_strand('gas');
$tvl_students = get_students_by_strand('tvl');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Dashboard</title>

    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <link rel="stylesheet" type="text/css" href="css/Student.css">

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
            <!-- <a href="Company.php">Work Immersion List</a> -->
            <!-- <a href="#.php">Company</a> -->
            <a class="active1" href="Student.php"><i class="fas fa-user-graduate"></i>Student</a>
            <a href="Organization.php"><i class="	fas fa-building"></i>Organization</a>
            <a href="Dashboard.php"><i class="fa fa-bar-chart"></i>Analytics</a>
            <!-- <a href="Reports.php"><i class="fa fa-file-text-o"></i>Reports</a> -->
            <!-- <a href="Details.php">Details</a> -->


        </nav>
    </div>
    <hr class="line_bottom">


    <br>

    <!-- <a href="Archive.php"> <i class="fa fa-archive" style="font-size:24px; Margin-right:10px"></i>Archive</a> -->
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <div class="container">
        <div class="box" id="#humss">
            <span class="material-symbols-outlined">
                balance
            </span>
            <p>HUMSS</p>
        </div>
        <div class="box" id="#stem">
            <span class="material-symbols-outlined">
                experiment
            </span>
            <p>STEM</p>
        </div>
        <div class="box" id="#gas">
            <span class="material-symbols-outlined">
                menu_book
            </span>
            <p>GAS</p>
        </div>
        <div class="box" id="#techvoc">
            <span class="material-symbols-outlined">
                construction
            </span>
            <p>TECHVOC</p>
        </div>
        <div class="box" id="#abm">
            <span class="material-symbols-outlined">
                insert_drive_file
            </span>

            <p>ABM</p>
        </div>
    </div>


    <div id="content_container">
        <div id="humss" class="content active">
            <h1 style="margin-bottom: 50px; margin-top:50px">HUMSS</h1>


            <div class="container2">
                <div class="search-bar">
                    <input type="text" class="search-input" id="searchHumssInput" onkeyup="searchTable('humss')"
                        placeholder="Search..." />
                    <button class="search-button">Search</button>
                </div>
                <table class="rwd-table" id="searchHumss">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>ID Picture</th>
                            <th>Student Name</th>
                            <th>Organization</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $count = 1;
                        foreach ($humss_students as $student) {
                            echo "<tr>";
                            echo "<td data-th='#'>" . $count . "</td>";
                            echo "<td data-th='ID Picture'><img class='idpic' src='../Student/uploads/" . $student['profile_image'] . "' alt='me'></td>";
                            echo "<td data-th='Student Name'>" . $student['first_name'] . " " . $student['middle_name'] . " " . $student['last_name'] . "</td>";
                            echo "<td data-th='Organization'>" . $student['organization_name'] . "</td>";
                            echo "<td data-th='Status'>" . ($student['verified_status'] ? "Verified" : "Not Verified") . "</td>";

                            echo "<td data-th='Action'>";
                            // Action form for verification and unverification
                            echo "<form method='post' style='display: inline;'>";
                            echo "<input type='hidden' name='student_id' value='" . $student['id'] . "'>";
                            if ($student['verified_status']) {
                                echo "<button class='button-11' type='submit' name='action' value='unverify' autofocus>Unverify</button><br>";
                            } else {
                                echo "<button class='button-10' type='submit' name='action' value='verify' autofocus>Verify</button><br>";
                            }
                            echo "</form>";
                            echo "<button class='button-9' role='button' onclick=\"window.location.href='../../ProfileView.php?student_id=" . base64_encode(encrypt_url_parameter((string) $student['id'])) . "'\">View Profile</button>";
                            echo "</td>";
                            echo "</tr>";
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>



        <div id="stem" class="content active">
            <h1 style="margin-bottom: 50px; margin-top:50px">STEM</h1>
            <div class="container2">
                <div class="search-bar">
                    <input type="text" class="search-input" id="searchStemInput" onkeyup="searchTable('stem')"
                        placeholder="Search..." />
                    <button class="search-button">Search</button>
                </div>
                <table class="rwd-table" id="searchStem">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>ID Picture</th>
                            <th>Student Name</th>
                            <th>Organization</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $count = 1;
                        foreach ($stem_students as $student) {
                            echo "<tr>";
                            echo "<td data-th='#'>" . $count . "</td>";
                            echo "<td data-th='ID Picture'><img class='idpic' src='../Student/uploads/" . $student['profile_image'] . "' alt='me'></td>";
                            echo "<td data-th='Student Name'>" . $student['first_name'] . " " . $student['middle_name'] . " " . $student['last_name'] . "</td>";
                            echo "<td data-th='Organization'>" . $student['organization_name'] . "</td>";
                            echo "<td data-th='Status'>" . ($student['verified_status'] ? "Verified" : "Not Verified") . "</td>";

                            echo "<td data-th='Action'>";
                            // Action form for verification and unverification
                            echo "<form method='post' style='display: inline;'>";
                            echo "<input type='hidden' name='student_id' value='" . $student['id'] . "'>";
                            if ($student['verified_status']) {
                                echo "<button class='button-11' type='submit' name='action' value='unverify'>Unverify</button><br>";
                            } else {
                                echo "<button class='button-10' type='submit' name='action' value='verify'>Verify</button> <br>";
                            }
                            echo "</form>";
                            echo "<button class='button-9' role='button' onclick=\"window.location.href='../../ProfileView.php?student_id=" . base64_encode(encrypt_url_parameter((string) $student['id'])) . "'\">View Profile</button>";
                            echo "</td>";
                            echo "</tr>";
                            $count++;
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>

        <div id="gas" class="content active">
            <h1 style="margin-bottom: 50px; margin-top:50px">GAS</h1>
            <div class="container2">
                <div class="search-bar">
                    <input type="text" class="search-input" id="searchGasInput" onkeyup="searchTable('gas')"
                        placeholder="Search..." />
                    <button class="search-button">Search</button>
                </div>
                <table class="rwd-table" id="searchGas">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>ID Picture</th>
                            <th>Student Name</th>
                            <th>Organization</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $count = 1;
                        foreach ($gas_students as $student) {
                            echo "<tr>";
                            echo "<td data-th='#'>" . $count . "</td>";
                            echo "<td data-th='ID Picture'><img class='idpic' src='../Student/uploads/" . $student['profile_image'] . "' alt='me'></td>";
                            echo "<td data-th='Student Name'>" . $student['first_name'] . " " . $student['middle_name'] . " " . $student['last_name'] . "</td>";
                            echo "<td data-th='Organization'>" . $student['organization_name'] . "</td>";
                            echo "<td data-th='Status'>" . ($student['verified_status'] ? "Verified" : "Not Verified") . "</td>";

                            echo "<td data-th='Action'>";
                            // Action form for verification and unverification
                            echo "<form method='post' style='display: inline;'>";
                            echo "<input type='hidden' name='student_id' value='" . $student['id'] . "'>";
                            if ($student['verified_status']) {
                                echo "<button class='button-11' type='submit' name='action' value='unverify'>Unverify</button><br>";
                            } else {
                                echo "<button class='button-10' type='submit' name='action' value='verify'>Verify</button><br>";
                            }
                            echo "</form>";
                            echo "<button class='button-9' role='button' onclick=\"window.location.href='../../ProfileView.php?student_id=" . base64_encode(encrypt_url_parameter((string) $student['id'])) . "'\">View Profile</button>";
                            echo "</td>";
                            echo "</tr>";
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="techvoc" class="content active">
            <h1 style="margin-bottom: 50px; margin-top:50px">TECHVOC</h1>
            <div class="container2">
                <div class="search-bar">
                    <input type="text" class="search-input" id="searchtechvocInput" onkeyup="searchTable('techvoc')"
                        placeholder="Search..." />
                    <button class="search-button">Search</button>
                </div>
                <table class="rwd-table" id="searchTechvoc">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>ID Picture</th>
                            <th>Student Name</th>
                            <th>Organization</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $count = 1;
                        foreach ($tvl_students as $student) {
                            echo "<tr>";
                            echo "<td data-th='#'>" . $count . "</td>";
                            echo "<td data-th='ID Picture'><img class='idpic' src='../Student/uploads/" . $student['profile_image'] . "' alt='me'></td>";
                            echo "<td data-th='Student Name'>" . $student['first_name'] . " " . $student['middle_name'] . " " . $student['last_name'] . "</td>";
                            echo "<td data-th='Organization'>" . $student['organization_name'] . "</td>";
                            echo "<td data-th='Status'>" . ($student['verified_status'] ? "Verified" : "Not Verified") . "</td>";

                            echo "<td data-th='Action'>";
                            // Action form for verification and unverification
                            echo "<form method='post' style='display: inline;'>";
                            echo "<input type='hidden' name='student_id' value='" . $student['id'] . "'>";
                            if ($student['verified_status']) {
                                echo "<button class='button-11' type='submit' name='action' value='unverify'>Unverify</button><br>";
                            } else {
                                echo "<button class='button-10' type='submit' name='action' value='verify'>Verify</button><br>";
                            }
                            echo "</form>";
                            echo "<button class='button-9' role='button' onclick=\"window.location.href='../../ProfileView.php?student_id=" . base64_encode(encrypt_url_parameter((string) $student['id'])) . "'\">View Profile</button>";
                            echo "</td>";
                            echo "</tr>";
                            $count++;
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
        <div id="abm" class="content active">
            <h1 style="margin-bottom: 50px; margin-top:50px">ABM</h1>
            <div class="container2">
                <div class="search-bar">
                    <input type="text" class="search-input" id="searchAbmInput" onkeyup="searchTable('abm')"
                        placeholder="Search..." />
                    <button class="search-button">Search</button>
                </div>
                <table class="rwd-table" id="searchAbm">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>ID Picture</th>
                            <th>Student Name</th>
                            <th>Organization</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $count = 1;
                        foreach ($abm_students as $student) {
                            echo "<tr>";
                            echo "<td data-th='#'>" . $count . "</td>";
                            echo "<td data-th='ID Picture'><img class='idpic' src='../Student/uploads/" . $student['profile_image'] . "' alt='me'></td>";
                            echo "<td data-th='Student Name'>" . $student['first_name'] . " " . $student['middle_name'] . " " . $student['last_name'] . "</td>";
                            echo "<td data-th='Organization'>" . $student['organization_name'] . "</td>";
                            echo "<td data-th='Status'>" . ($student['verified_status'] ? "Verified" : "Not Verified") . "</td>";

                            echo "<td data-th='Action'>";
                            // Action form for verification and unverification
                            echo "<form method='post' style='display: inline;'>";
                            echo "<input type='hidden' name='student_id' value='" . $student['id'] . "'>";
                            if ($student['verified_status']) {
                                echo "<button class='button-11' type='submit' name='action' value='unverify'>Unverify</button><br>";
                            } else {
                                echo "<button class='button-10' type='submit' name='action' value='verify'>Verify</button><br>";
                            }
                            echo "</form>";
                            echo "<button class='button-9' role='button' onclick=\"window.location.href='../../ProfileView.php?student_id=" . base64_encode(encrypt_url_parameter((string) $student['id'])) . "'\">View Profile</button>";
                            echo "</td>";
                            echo "</tr>";
                            $count++;
                        }
                        ?>
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
        $(".box").click(function (e) {
            e.preventDefault();
            $(".content").removeClass("active");
            var content_id = $(this).attr("id");
            $(content_id).addClass("active");
        });
    </script>
    <br>
    <footer>
        <!-- <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>Fhums -->
        <p>&copy;2024 Your Website. All rights reserved. | Junior Philippines Computer</p>
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

    <!-- <script>
        const searchInput = document.getElementById('searchInput');
        const dropdownList = document.getElementById('dropdownList1');
        const dropdownItems = dropdownList.getElementsByClassName('dropdown-item1');
        let selectedStudent = '';

        // Filter dropdown items based on search input
        searchInput.addEventListener('input', function () {
            const filter = searchInput.value.toLowerCase();
            let hasMatches = false;

            // Show the dropdown list
            dropdownList.style.display = 'block';

            // Check if the input is empty
            if (filter === '') {
                // If empty, show all items and return
                for (let i = 0; i < dropdownItems.length; i++) {
                    dropdownItems[i].style.display = 'block';
                }
                return; // Exit the function
            }

            // Filter based on input
            for (let i = 0; i < dropdownItems.length; i++) {
                const itemText = dropdownItems[i].textContent.toLowerCase();
                if (itemText.includes(filter)) {
                    dropdownItems[i].style.display = 'block';
                    hasMatches = true;
                } else {
                    dropdownItems[i].style.display = 'none';
                }
            }

            // Hide dropdown if no matches found
            if (!hasMatches) {
                dropdownList.style.display = 'none';
            }
        });

        // Select student on item click
        for (let i = 0; i < dropdownItems.length; i++) {
            dropdownItems[i].addEventListener('click', function () {
                selectedStudent = this.textContent;
                searchInput.value = selectedStudent;
                dropdownList.style.display = 'none';
            });
        }

        // Add student to table
        document.getElementById('addButton1').addEventListener('click', function () {
            if (selectedStudent) {
                const row = document.createElement('tr');
                const nameCell = document.createElement('td');

                nameCell.textContent = selectedStudent;
                row.appendChild(nameCell);
                document.getElementById('studentTableBody1').appendChild(row);

                // Clear input and reset selected student
                searchInput.value = '';
                selectedStudent = '';
            } else {
                alert('Please select a student.');
            }
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function (event) {
            if (!event.target.matches('.dropdown-input1')) {
                dropdownList.style.display = 'none';
            }
        });
    </script> -->

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