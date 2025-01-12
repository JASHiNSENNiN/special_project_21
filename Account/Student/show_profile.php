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
     ORDER BY created_at ASC)";

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
            <img src="image/drdsnhs.svg" alt="Logo">
        </a>
    </div>
    <nav class="by">
        <div class="dropdowntf" style="float:right;">
            <a href="" class="notification">
                <i class="fas fa-bell" style="font-size:24px; color:#fff;"></i>
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
                <a href=""><i class="fas fa-user-alt" style="font-size:24px;  margin-top:5px;color:#fff;"></i></a>
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
    <img class="logoimg" id="cover-pic" src="' . $cover_image . '" alt="" width="200" height="300">
    <div class="profile">
        <img src="' . $profile_image . '" alt="profile picture">
        <div class="name">' . $firstName . ' ' . $middleName . ' ' . $lastName . '</div>
        <label class="strand" for="">' . $strand . '</label>
    </div>';
?>