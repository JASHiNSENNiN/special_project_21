<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/session_handler.php';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notification_id'])) {
    $notificationId = $_POST['notification_id'];
    $updateQuery = "UPDATE notifications SET is_read = 1 WHERE notification_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("i", $notificationId);
    $updateStmt->execute();
    $updateStmt->close();
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$student_id = $_SESSION['user_id'];
$firstName = $_SESSION['first_name'];
$middleName = $_SESSION['middle_name'];
$lastName = $_SESSION['last_name'];
$school = $_SESSION['school'];
$gradeLevel = $_SESSION['grade_level'];
$strand = strtoupper($_SESSION['strand']);
$currentWork = $_SESSION['current_work'];
$email = $_SESSION['email'];
$profile_image_path = $_SESSION['profile_image'];
$cover_image_path = $_SESSION['cover_image'];
$userId = $_SESSION['user_id'];

$notifications = [];
$notificationQuery = "
    (SELECT notification_id, message, created_at, is_read 
     FROM notifications 
     WHERE user_id = ? AND is_read = 0 
     ORDER BY created_at DESC)
    UNION ALL
    (SELECT notification_id, message, created_at, is_read 
     FROM notifications 
     WHERE user_id = ? AND is_read = 1 
     ORDER BY created_at DESC)";

$notificationStmt = $conn->prepare($notificationQuery);
$notificationStmt->bind_param("ii", $userId, $userId);
$notificationStmt->execute();
$result = $notificationStmt->get_result();

while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'id' => $row['notification_id'],
        'message' => $row['message'],
        'created_at' => $row['created_at'],
        'is_read' => $row['is_read']
    ];
}
$notificationStmt->close();

$profile_data = null;
if (isset($_SESSION['user_id'])) {
    $sql = "SELECT sp.*, u.profile_image, u.cover_image
            FROM student_profiles sp
            JOIN users u ON sp.user_id = u.id
            WHERE sp.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $profile_data = $result->fetch_assoc();
    $stmt->close();
}

$conn->close();

$profile_image_path = 'uploads/' . $profile_data['profile_image'];
$cover_image_path = 'uploads/' . $profile_data['cover_image'];

$profile_image = (isset($profile_data['profile_image']) && file_exists($profile_image_path)) ? $profile_image_path : 'uploads/default.png';
$cover_image = (isset($profile_data['cover_image']) && file_exists($cover_image_path)) ? $cover_image_path : 'uploads/cover.png';

$unreadCount = count(array_filter($notifications, function($n) { return !$n['is_read']; }));
$badgeHTML = $unreadCount > 0 ? '<span class="badge">' . $unreadCount . '</span>' : '';

$profile_div = '<header class="nav-header">
    <div class="logo">
        <a href="Company_Area.php">
            <img src="image/logov3.jpg" alt="Logo">
        </a>
    </div>
    <nav class="by">
        <div class="dropdowntf" style="float:right;">
            <a href="" class="notification">
                <i class="fas fa-bell" style="font-size:24px;"></i>
                ' . $badgeHTML . '
            </a>
            <div class="dropdowntf-content" id="box">
                <label class="notif">Notification</label>
                <hr style="width: 100%;">
                ';

$unreadNotifications = array_filter($notifications, function($n) { return !$n['is_read']; });
if (!empty($unreadNotifications)) {
  $profile_div .= '';
  foreach ($unreadNotifications as $notif) {
      $profile_div .= '
          <form method="POST" style="margin: 0;">
              <input type="hidden" name="notification_id" value="' . $notif['id'] . '">
              <button type="submit" style="width: 100%; text-align: left; border: none; background: #e8f4ff; cursor: pointer; padding: 10px; margin-bottom: 2px;" title="Click to mark as read">
                  <div class="notifi-item">
                      <img src="https://via.placeholder.com/50" alt="img">
                      <div class="text" style="font-weight: bold;">
                          <h4 style="margin: 0;">New Notification</h4>
                          <p style="margin: 5px 0;">' . htmlspecialchars($notif['message']) . '</p>
                          <small style="color: #666;">' . date('M j, Y g:i A', strtotime($notif['created_at'])) . '</small>
                      </div>
                  </div>
              </button>
          </form>';
  }
}

$readNotifications = array_filter($notifications, function($n) { return $n['is_read']; });
if (!empty($readNotifications)) {
    $profile_div .= '';
    foreach ($readNotifications as $notif) {
        $profile_div .= '
            <div style="background: #ffffff; padding: 10px; opacity: 0.7; margin-bottom: 2px;">
                <div class="notifi-item">
                    <img src="https://via.placeholder.com/50" alt="img">
                    <div class="text">
                        <h4 style="margin: 0;">Notification</h4>
                        <p style="margin: 5px 0;">' . htmlspecialchars($notif['message']) . '</p>
                        <small style="color: #666;">' . date('M j, Y g:i A', strtotime($notif['created_at'])) . '</small>
                    </div>
                </div>
            </div>';
    }
}

if (empty($notifications)) {
    $profile_div .= '<p>No notifications</p>';
}

$profile_div .= '    
                </div>
            </div>
            <div class="dropdown" style="float:right;">
                <a href=""><i class="fas fa-user-alt" style="font-size:24px;  margin-top:5px;"></i></a>
                <div class="dropdown-content">
                    <div class="email">' . $email . '</div>
                    <a href="Profile.php?student_id=' . base64_encode(encrypt_url_parameter($student_id)) . '"><i class="fas fa-user-alt" style="font-size:24px; margin-right:10px;"></i> My Profile</a>
                    <a href="../../weather_page.php"> <i class="fas fa-cloud-sun-rain" style="font-size:24px;margin-right:10px;"></i> Weather Update</a>
                    <a href="Journal.php"><i class="fa fa-newspaper-o" style="font-size:24px; margin-right:10px;"></i> Journal</a>
                    <a href="Upload.php"><i class="fa fa-file-text" style="font-size:24px; margin-right:10px;"></i> File Upload</a>
                    <a href="Settings.php"><i class="fa fa-gear" style="font-size:24px;margin-right:10px;"></i> Settings</a>
                    <hr>
                    <a class="logout" href="' . '/backend/php/logout.php' . '"><i class="fa fa-sign-out" style="font-size:24px; margin-right:10px;"></i>Log out</a>
                </div>
            </div>
            <div class="css-1ld7x2h eu4oa1w0"></div>
        </nav>
    </header>
    ';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <title>Woriky Verification</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .wait {
        margin-bottom: 20px;
        color: #333;
        margin-top: 10%;
        width: 100%;
        text-align: center;
    }

    .wait1 {
        margin-bottom: 20px;
        color: #333;
        /* margin-top: 10%; */
        width: 100%;
        text-align: center;
    }

    .message {
        font-size: 20px;
        color: #555;
        text-align: center;
        margin-bottom: 40px;
    }

    .nav-header {
        background-color: #fff;
        padding-right: 20px;
        padding-left: 100px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
    }

    .logo img {
        width: 220px;
        margin-right: 30px;
    }

    .container {
        width: 100vw;
        height: 100vh;
        background: #ffffff;
        border: 1px solid white;
        position: relative;
        /* Make sure the container is relative */
    }

    .confetti-container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
    }

    .confetti {
        position: absolute;
        z-index: 1;
        top: -10px;
        border-radius: 0%;
        width: 10px;
        height: 10px;
    }

    /* Confetti Animations */
    .confetti--animation-slow {
        animation: confetti-slow 2.25s linear 1 forwards;
    }

    .confetti--animation-medium {
        animation: confetti-medium 1.75s linear 1 forwards;
    }

    .confetti--animation-fast {
        animation: confetti-fast 1.25s linear 1 forwards;
    }

    @keyframes confetti-slow {
        0% {
            transform: translate3d(0, 0, 0) rotateX(0) rotateY(0);
        }

        100% {
            transform: translate3d(25px, 105vh, 0) rotateX(360deg) rotateY(180deg);
        }
    }

    @keyframes confetti-medium {
        0% {
            transform: translate3d(0, 0, 0) rotateX(0) rotateY(0);
        }

        100% {
            transform: translate3d(100px, 105vh, 0) rotateX(100deg) rotateY(360deg);
        }
    }

    @keyframes confetti-fast {
        0% {
            transform: translate3d(0, 0, 0) rotateX(0) rotateY(0);
        }

        100% {
            transform: translate3d(-50px, 105vh, 0) rotateX(10deg) rotateY(250deg);
        }
    }

    /* Checkmark Styles */
    .checkmark-circle {
        width: 150px;
        height: 150px;
        position: relative;
        display: inline-block;
        vertical-align: top;
        margin-left: auto;
        margin-right: auto;
    }

    .checkmark-circle .background {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: #00C09D;
        position: absolute;
    }

    .checkmark-circle .checkmark {
        border-radius: 5px;
    }

    .submit-btn {
        height: 45px;
        width: 200px;
        font-size: 15px;
        background-color: #00c09d;
        border: 1px solid #00ab8c;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        transition: all .2s ease-out;
    }

    .submit-btn:hover {
        background-color: #2ca893;
        transition: all .2s ease-out;
    }

    .icon {
        width: 50px;
        height: 50px;
        background-image: url('checkmark-icon.png');
        /* Replace with your icon */
        background-size: cover;
        margin: 20px auto;
    }

    .go-home-button {
        background: linear-gradient(135deg, #28a745, #218838);
        /* Gradient background */
        color: white;
        /* Text color */
        border: none;
        /* Remove border */
        padding: 15px 30px;
        /* Padding for the button */
        border-radius: 8px;
        /* More rounded corners */
        font-size: 18px;
        /* Font size */
        cursor: pointer;
        /* Pointer cursor */
        transition: background-color 0.3s ease, transform 0.2s ease;
        /* Smooth transitions */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        /* Shadow for depth */
        text-align: center;
        margin: auto;
        width: auto;
    }

    .go-home-button:hover {
        background: linear-gradient(135deg, #218838, #1e7e34);
        /* Darker gradient on hover */
        transform: translateY(-3px);
        /* Slight lift effect on hover */
    }

    .go-home-button:active {
        transform: translateY(1px);
        /* Pressed effect */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        /* Reduce shadow when pressed */
    }

    nav {
        text-align: center;
        display: flex;
        margin-right: 180px;
    }

    nav a {
        color: #000000;
        text-decoration: none;
        padding: 10px 20px;
        margin: 0 10px;
        border-radius: 5px;
        position: relative;
        transition: background-color 0.3s;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
    }

    nav .login-btn:hover {
        color: #172738;
    }

    nav a:hover {
        color: #000000;
        /* background-color: rgba(27, 188, 155, 0.3); */
        font-weight: bold;
    }
    </style>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php echo $profile_div;?>

    <div class="js-container container">
        <div class="wame">
            <h1 class="wait">Congratulations!</h1>
            <h3 class="wait1"><?php echo $firstName . ' ' . $middleName . ' ' . $lastName; ?></h3>
            <p class="message">You have successfully completed your work immersion.</p>
            <p class="message" style="margin-top:-15px;">We are proud of your hard work and dedication. This is just the
                beginning of your bright
                future! <br>
                <a href="Profile.php?student_id=<?= base64_encode(encrypt_url_parameter($student_id)) ?>"
                    style="position: relative; z-index: 10;">
                    <button class="go-home-button" style="margin-top: 50px; position: relative; z-index: 20;">View
                        Result</button>
                </a>
            </p>

        </div>
    </div>


    <script>
    const Confettiful = function(el) {
        this.el = el;
        this.containerEl = null;
        this.confettiFrequency = 3;
        this.confettiColors = ['#EF2964', '#00C09D', '#2D87B0', '#48485E', '#EFFF1D'];
        this.confettiAnimations = ['slow', 'medium', 'fast'];

        this._setupElements();
        this._renderConfetti();
    };

    Confettiful.prototype._setupElements = function() {
        const containerEl = document.createElement('div');
        containerEl.classList.add('confetti-container');
        this.el.appendChild(containerEl);
        this.containerEl = containerEl;
    };

    Confettiful.prototype._renderConfetti = function() {
        this.confettiInterval = setInterval(() => {
            const confettiEl = document.createElement('div');
            const confettiSize = (Math.floor(Math.random() * 3) + 7) + 'px';
            const confettiBackground = this.confettiColors[Math.floor(Math.random() * this.confettiColors
                .length)];
            const confettiLeft = (Math.floor(Math.random() * this.el.offsetWidth)) + 'px';
            const confettiAnimation = this.confettiAnimations[Math.floor(Math.random() * this
                .confettiAnimations.length)];

            confettiEl.classList.add('confetti', 'confetti--animation-' + confettiAnimation);
            confettiEl.style.left = confettiLeft;
            confettiEl.style.width = confettiSize;
            confettiEl.style.height = confettiSize;
            confettiEl.style.backgroundColor = confettiBackground;

            confettiEl.removeTimeout = setTimeout(function() {
                confettiEl.parentNode.removeChild(confettiEl);
            }, 3000);

            this.containerEl.appendChild(confettiEl);
        }, 25);
    };

    window.confettiful = new Confettiful(document.querySelector('.js-container'));
    </script>
</body>

</html>