<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$ProfileViewURL = "../../ProfileView.php";

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Get notifications with user information
$query = "
    SELECT n.notification_id, n.message, n.created_at, n.is_read, 
           u.id as user_id, u.email, u.account_type
    FROM notifications n
    JOIN users u ON n.user_id = u.id
    ORDER BY n.created_at DESC
";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching notifications: " . $e->getMessage());
}

// Function to calculate time elapsed
function timeElapsed($datetime) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->d == 0) {
        if ($diff->h == 0) {
            if ($diff->i == 0) {
                return "just now";
            } else {
                return $diff->i . " minute" . ($diff->i > 1 ? "s" : "") . " ago";
            }
        } else {
            return $diff->h . " hour" . ($diff->h > 1 ? "s" : "") . " ago";
        }
    } else if ($diff->d < 7) {
        return $diff->d . " day" . ($diff->d > 1 ? "s" : "") . " ago";
    } else {
        return date("M j, Y", strtotime($datetime));
    }
}

// Get current filter (if any)
$dateFilter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
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
            <div class="d-flex justify-content-center">
                <div class="tab-pane w-70 p-3 active show" id="messages" role="tabpanel">
                    <div class="filter-container mb-3">
                        <label for="dateFilter">Filter by Date:</label>
                        <select id="dateFilter" class="form-control w-25" onchange="filterNotifications()">
                            <option value="all">All Notifications</option>
                            <option value="month">Current Month</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="lastWeek">Last Week</option>
                        </select>
                    </div>

                    <?php if (empty($notifications)): ?>
                        <div class="alert alert-info">No notifications found.</div>
                    <?php else: ?>
                        <?php foreach ($notifications as $notification): 
                            $date = date("Y-m-d", strtotime($notification['created_at']));
                            $timeAgo = timeElapsed($notification['created_at']);
                            
                            // Format the name based on account type
                            if ($notification['account_type'] === 'Student') {
                                $name = "Student: " . htmlspecialchars($notification['email']);
                            } elseif ($notification['account_type'] === 'Organization') {
                                $name = "Organization: " . htmlspecialchars($notification['email']);
                            } else {
                                $name = htmlspecialchars($notification['email']);
                            }
                        ?>
                        <div class="message" data-date="<?php echo $date; ?>">
                            <div class="py-3 pb-5 mr-3 float-left">
                                <div class="avatar">
                                    <i class="fa fa-bell text-muted" style="font-size: 24px;"></i>
                                </div>
                            </div>
                            <div>
                                <small class="text-muted"><?php echo $name; ?></small>
                                <small class="text-muted float-right mt-1"><?php echo $timeAgo; ?></small>
                            </div>
                            <div class="text-truncate"><?php echo htmlspecialchars($notification['message']); ?></div>
                            <small class="text-muted"><?php echo $date; ?></small>
                            <hr>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterNotifications() {
            const filterValue = document.getElementById('dateFilter').value;
            const messages = document.querySelectorAll('.message');
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            function getStartOfWeek(date) {
                const newDate = new Date(date);
                const day = newDate.getDay();
                const diff = newDate.getDate() - day + (day === 0 ? -6 : 1);
                newDate.setDate(diff);
                newDate.setHours(0, 0, 0, 0);
                return newDate;
            }

            function getEndOfWeek(date) {
                const start = getStartOfWeek(date);
                const end = new Date(start);
                end.setDate(start.getDate() + 6);
                end.setHours(23, 59, 59, 999);
                return end;
            }

            function isInCurrentMonth(date) {
                return date.getMonth() === today.getMonth() && 
                       date.getFullYear() === today.getFullYear();
            }

            function isToday(date) {
                return date.getTime() === today.getTime();
            }

            function isInDateRange(date, start, end) {
                return date >= start && date <= end;
            }

            messages.forEach(msg => {
                const msgDateStr = msg.getAttribute('data-date');
                if (!msgDateStr) {
                    msg.style.display = '';
                    return;
                }
                
                const msgDate = new Date(msgDateStr);
                msgDate.setHours(0, 0, 0, 0);
                let show = true;

                switch (filterValue) {
                    case 'all':
                        show = true;
                        break;
                    case 'month':
                        show = isInCurrentMonth(msgDate);
                        break;
                    case 'today':
                        show = isToday(msgDate);
                        break;
                    case 'week':
                        const thisWeekStart = getStartOfWeek(today);
                        const thisWeekEnd = getEndOfWeek(today);
                        show = isInDateRange(msgDate, thisWeekStart, thisWeekEnd);
                        break;
                    case 'lastWeek':
                        const lastWeekToday = new Date(today);
                        lastWeekToday.setDate(today.getDate() - 7);
                        const lastWeekStart = getStartOfWeek(lastWeekToday);
                        const lastWeekEnd = getEndOfWeek(lastWeekToday);
                        show = isInDateRange(msgDate, lastWeekStart, lastWeekEnd);
                        break;
                }

                msg.style.display = show ? '' : 'none';
            });

            updateNoResultsMessage();
        }

        function updateNoResultsMessage() {
            const messages = document.querySelectorAll('.message');
            const visibleMessages = Array.from(messages).filter(msg => msg.style.display !== 'none');
            const noResultsMsg = document.getElementById('no-results-message');
            
            if (noResultsMsg) {
                noResultsMsg.remove();
            }

            if (visibleMessages.length === 0) {
                const messageContainer = document.querySelector('.tab-pane');
                const noResults = document.createElement('div');
                noResults.id = 'no-results-message';
                noResults.className = 'alert alert-info mt-3';
                noResults.textContent = 'No notifications found for the selected time period.';
                messageContainer.appendChild(noResults);
            }
        }

        // Initialize filtering on page load
        document.addEventListener('DOMContentLoaded', filterNotifications);
        document.getElementById('dateFilter').addEventListener('change', filterNotifications);
    </script>

    <script>
        function searchTable(section) {
            // Get the input value and convert it to uppercase
            let input = document.querySelector(`#search${section.charAt(0).toUpperCase() + section.slice(1)}Input`);
            let filter = input.value.toUpperCase();

            // Select the table within the active content section
            let table = document.getElementById(`search${section.charAt(0).toUpperCase() + section.slice(1)}`);
            let tr = table.getElementsByTagName('tr'); // Get all rows in the table

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