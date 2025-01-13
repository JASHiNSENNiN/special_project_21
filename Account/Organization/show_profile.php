<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/session_handler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

// Create connection to the database.
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Session variables
$organizationId = $_SESSION['user_id'];
$organizationName = $_SESSION['organization_name'];
$email = $_SESSION['email'];
$strandFocus = strtoupper($_SESSION['strand']);

// Notification Handling
$notifications = [];
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
$notificationStmt->bind_param("ii", $organizationId, $organizationId);
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
// Get user images
$userImages = get_user_images($email);
$profileImageSrc = $userImages['profile_image'];
$coverImageSrc = $userImages['cover_image'];

// Build notifications HTML
$notificationHTML = '';
$unreadNotifications = array_filter($notifications, function ($n) {
    return !$n['is_read'];
});
if (!empty($unreadNotifications)) {
    foreach ($unreadNotifications as $notif) {
        $notificationHTML .= '
            <form method="POST" style="margin: 0;">
                <input type="hidden" name="notification_id" value="' . $notif['id'] . '">
                <button type="submit" style="width: 100%; text-align: left; border: none; background: #e8f4ff; cursor: pointer; padding: 10px; margin-bottom: 2px; title="Click to mark as read"">
                    <div class="notifi-item">
                        <img src="' . $profileImageSrc . '" alt="img" style"width: 50px; height: 50px;">
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

$readNotifications = array_filter($notifications, function ($n) {
    return $n['is_read'];
});
if (!empty($readNotifications)) {
    foreach ($readNotifications as $notif) {
        $notificationHTML .= '
            <div class="notifi-item">
                <img src="' . $profileImageSrc . '" alt="img" style"width: 50px; height: 50px;">
                <div class="text">
                    <h4 style="margin: 0;">Notification</h4>
                    <p style="margin: 5px 0;">' . htmlspecialchars($notif['message']) . '</p>
                    <small style="color: #666;">' . date('M j, Y g:i A', strtotime($notif['created_at'])) . '</small>
                </div>
            </div>';
    }
}

if (empty($notifications)) {
    $notificationHTML .= '<p>No notifications</p>';
}

// Function to get user images based on email
function get_user_images($email)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT profile_image, cover_image FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    $defaultProfileImage = 'uploads/default.png';
    $defaultCoverImage = 'uploads/cover.png';

    $images = [
        'profile_image' => $defaultProfileImage,
        'cover_image' => $defaultCoverImage,
    ];

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['profile_image']) && file_exists('uploads/' . $row['profile_image'])) {
            $images['profile_image'] = 'uploads/' . $row['profile_image'];
        }
        if (!empty($row['cover_image']) && file_exists('uploads/' . $row['cover_image'])) {
            $images['cover_image'] = 'uploads/' . $row['cover_image'];
        }
    }

    $stmt->close();
    $conn->close();
    return $images;
}


$badgeHTML = count($unreadNotifications) > 0 ? '<span class="badge">' . count($unreadNotifications) . '</span>' : '';

$profile_div = '<header class="nav-header">
        <div class="logo">
            <a href="#">
                 <img src="image/drdsnhs.svg" alt="Logo">
            </a>
        </div>
        <nav class="by">
            <div class="dropdowntf" style="float:right;">
                <a href="#" class="notification">
                    <i class="fas fa-bell" style="font-size:24px; color:#fff;"></i>
                    ' . $badgeHTML . '
                </a>
                <div class="dropdowntf-content" id="box">
                    <label class="notif">Notification</label>
                    <hr style="width: 100%;">
                    ' . $notificationHTML . '
                </div>
            </div>
            <div class="dropdown" style="float:right; margin-bottom:24px;">
                <a href=""><i class="fas fa-user-alt" style="font-size:24px; margin-top:10px;color:#fff;"></i></a>
                <div class="dropdown-content">
                    <div class="email">' . $email . '</div>
                    <a href="My_Jobs.php"><i class="fas fa-bookmark" style="font-size:24px; margin-right:10px;"></i> My Jobs</a>
                    <a href="../../weather_page.php"> <i class="fas fa-cloud-sun-rain" style="font-size:24px;margin-right:10px;"></i>Weather Update</a>
                    <a href="Upload.php"><i class="fa fa-file-text" style="font-size:24px; margin-right:10px;"></i> File Upload</a>
                    <a href="Settings.php"><i class="fa fa-gear" style="font-size:24px;"></i> Settings</a>
                    <hr>
                    <a class="logout" href="' . '/backend/php/logout.php' . '"> <i class="fa fa-sign-out" style="font-size:24px; margin-right:10px;"></i>Log out</a>
                </div>
            </div>
        </nav>
    </header>';

$profile_div .= '<img class="logoimg" id="cover-pic" src="' . $coverImageSrc . '" alt="" height="300" width="200">';
$profile_div .= '<div class="profile">
        <img id="profile-pic" src="' . $profileImageSrc . '" alt="">
        <div class="name">' . $organizationName . '</div>
        <label class="strand" for="">' . $strandFocus . '</label>
    </div>';
