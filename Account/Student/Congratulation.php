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
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <link rel="stylesheet" type="text/css" href="css/Congratulatio.css">
    <title>Woriky Verification</title>
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