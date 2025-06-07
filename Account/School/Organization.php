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

    // Fetch all partner organizations with their verification status and calculated rating
    $sql = "SELECT 
                pp.user_id, 
                pp.organization_name, 
                u.profile_image, 
                pp.verified_status,
                COALESCE(
                    ROUND(
                        (AVG(oe.quality_of_experience) + 
                         AVG(oe.productivity_of_tasks) + 
                         AVG(oe.problem_solving_opportunities) + 
                         AVG(oe.attention_to_detail_in_guidance) + 
                         AVG(oe.initiative_encouragement) + 
                         AVG(oe.punctuality_expectations) + 
                         AVG(oe.professional_appearance_standards) + 
                         AVG(oe.communication_training) + 
                         AVG(oe.respectfulness_environment) + 
                         AVG(oe.adaptability_challenges) + 
                         AVG(oe.willingness_to_learn_encouragement) + 
                         AVG(oe.feedback_application_opportunities) + 
                         AVG(oe.self_improvement_support) + 
                         AVG(oe.skill_development_assessment) + 
                         AVG(oe.knowledge_application_in_practice) + 
                         AVG(oe.team_participation_opportunities) + 
                         AVG(oe.cooperation_among_peers) + 
                         AVG(oe.conflict_resolution_guidance) + 
                         AVG(oe.supportiveness_among_peers) + 
                         AVG(oe.contribution_to_team_success) + 
                         AVG(oe.enthusiasm_for_tasks) + 
                         AVG(oe.drive_to_achieve_goals) + 
                         AVG(oe.resilience_to_challenges) + 
                         AVG(oe.commitment_to_experience) + 
                         AVG(oe.self_motivation_levels)) / 25, 1
                    ), 0
                ) AS avg_rating,
                COUNT(oe.evaluation_id) as total_evaluations
            FROM partner_profiles pp
            JOIN users u ON pp.user_id = u.id
            LEFT JOIN Organization_Evaluation oe ON pp.id = oe.organization_id
            WHERE u.account_type = 'Organization'
            GROUP BY pp.user_id, pp.organization_name, u.profile_image, pp.verified_status
            ORDER BY avg_rating DESC, pp.organization_name ASC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table class="rwd-table" id="searchHumss">
                <tbody>
                    <tr>
                        <th>#</th>
                        <th>Profile Photo</th>
                        <th>Organization Name</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>';

        $count = 1;
        while ($row = $result->fetch_assoc()) {
            $encoded_id = base64_encode(encrypt_url_parameter((string) $row['user_id']));
            $profile_image = !empty($row['profile_image']) ? "/Account/Organization/uploads/" . $row['profile_image'] : "Account/Organization/uploads/default.png";
            
            // Format rating display
            $rating = $row['avg_rating'];
            $total_evaluations = $row['total_evaluations'];
            $rating_display = $rating > 0 ? number_format($rating, 1) : "No ratings";
            $star_icon = $rating > 0 ? "<i class='fa fa-star fa-2x'></i>" : "<i class='fa fa-star-o fa-2x'></i>";

            echo "<tr>";
            echo "<td data-th='#'>" . $count . "</td>";
            echo "<td data-th='ID Picture' style='justify-content: center;'><img class='idpic' src='" . $profile_image . "' alt='Organization Photo'></td>";
            echo "<td data-th='Organization Name'>" . htmlspecialchars($row['organization_name']) . "</td>";
            echo "<td data-th='Rating'>" . $rating_display . " " . $star_icon;
            if ($total_evaluations > 0) {
                echo "<br><small>(" . $total_evaluations . " evaluation" . ($total_evaluations > 1 ? "s" : "") . ")</small>";
            }
            echo "</td>";
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
            <a href="Analytics.php"><i class="fa fa-bar-chart"></i>Analytics</a>
            <a href="Notification-logs.php"><i class="fa fa-list"></i>Logs</a>



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
                <?php displayPartnerOrganizations(); ?>
            </div>
        </div>

    </div>
    <script>
        function starRating(element, option, clickCallback, moveCallback) {
            if (option === undefined || option.hasOwnProperty("readyOnly")) {
                option = {
                    readOnly: false,
                    width: 146,
                    starCount: 5
                };
            } else {
                // Ensure starCount does not exceed 5
                if (option.starCount > 5) {
                    option.starCount = 5;
                }
            }
            // Rest of your function remains unchanged
            $(element).each(function() {
                let _this = $(this);
                let defaultRatingValue = 0;
                let selectedRatingValue = 0;
                let dataCount = _this.data("count");
                console.log(dataCount);

                if (dataCount === undefined || dataCount === null || dataCount === "") {
                    defaultRatingValue = (parseFloat(0) * 100) / option.starCount;
                    selectedRatingValue = defaultRatingValue;
                } else {
                    defaultRatingValue = (parseFloat(dataCount) * 100) / option.starCount;
                    selectedRatingValue = defaultRatingValue;
                }

                function changedPosition($this, position) {
                    $this.find(".percent").css("width", position + "%");
                }

                // Default rating value
                changedPosition(_this, defaultRatingValue);

                if (option.readOnly === false) {
                    _this.on("mousemove", function(e) {
                        let cX = getPosition(e);
                        if (cX < 100) {
                            changedPosition(_this, cX);

                            if (moveCallback && typeof moveCallback !== undefined) {
                                moveCallback(_this, round((cX / 100) * option.starCount));
                            }
                        }
                    });

                    _this.on("mouseleave", function(e) {
                        changedPosition(_this, defaultRatingValue);

                        if (moveCallback && typeof moveCallback !== undefined) {
                            moveCallback(
                                _this,
                                round((defaultRatingValue / 100) * option.starCount)
                            );
                        }
                    });

                    _this.on("click", function(e) {
                        selectedRatingValue = getPosition(e);
                        defaultRatingValue = selectedRatingValue;
                        changedPosition(_this, selectedRatingValue);

                        if (clickCallback && typeof clickCallback !== undefined) {
                            clickCallback(
                                _this,
                                round((selectedRatingValue / 100) * option.starCount)
                            );
                        }
                    });
                }
            });

            function round(v) {
                return Math.round(v * 100) / 100;
            }

            function getPosition(e) {
                return (e.originalEvent.layerX / option.width) * 100;
            }
        }

        // Usage example with enforced max 5 stars
        starRating(
            ".star-rating", {
                readOnly: false,
                width: 146,
                starCount: 10 // even if 10 is passed, it will be capped to 5
            },
            // function clickRating(e, rateCount) {
            //   $(e).parent().find(".rating-number").text(rateCount);
            // },
            function leaveRating(e, rateCount) {
                $(e).parent().find(".rating-number").text(rateCount);
            }
        );
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