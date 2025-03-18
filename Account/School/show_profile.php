<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/session_handler.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$schoolName = $_SESSION['school_name'];
$email = $_SESSION['email'];
$student_id = $_SESSION['user_id'];

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
$notificationStmt->bind_param("ii", $student_id, $student_id);
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

// Get user images function
function get_user_images($email)
{
    global $host, $username, $password, $database;
    $conn = new mysqli($host, $username, $password, $database);
    $defaultProfileImage = 'uploads/default.png';
    $defaultCoverImage = 'uploads/cover.png';

    $images = [
        'profile_image' => $defaultProfileImage,
        'cover_image' => $defaultCoverImage,
    ];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT profile_image, cover_image FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

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

$userImages = get_user_images($email);
$profileImageSrc = $userImages['profile_image'];
$coverImageSrc = $userImages['cover_image'];

$notificationHTML = '';
$unreadNotifications = array_filter($notifications, function ($n) {
    return !$n['is_read'];
});
if (!empty($unreadNotifications)) {
    foreach ($unreadNotifications as $notif) {
        $notificationHTML .= '
          <form method="POST" style="margin: 0;">
              <input type="hidden" name="notification_id" value="' . $notif['id'] . '">
              <button type="submit" style="width: 100%; text-align: left; border: none; background: #e8f4ff; cursor: pointer; padding: 10px; margin-bottom: 2px;" title="Click to mark as read">
                  <div class="notifi-item">
                      
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

$unreadCount = count($unreadNotifications);
$badgeHTML = $unreadCount > 0 ? '<span class="badge">' . $unreadCount . '</span>' : '';

$profile_div = '<header class="nav-header">
    <div class="logo">
        <a href="#">
            <img src="image/drdsnhs.svg" alt="Logo">
        </a>
    </div>
    <nav class="by">
        <div class="dropdowntf" style="float:right; ">
            <a href="#" class="notification">
                <i class="fas fa-bell" style="font-size:24px;color:#fff;"></i>
                ' . $badgeHTML . '
            </a>
            <div class="dropdowntf-content" id="box">
                <label for="" class="notif">Notification</label>
                <hr style="width: 100%;">
                ' . $notificationHTML . '
            </div>
        </div>
        <div class="dropdown" style="float:right;">
            <a href=""><i class="fas fa-user-alt" style="font-size:24px; margin-top:10px; color:#fff;"></i></a>
            <div class="dropdown-content">
                <div class="email">' . $email . '</div>
                 <a href="OrganizationList.php"><i class="fas fa-building" style="font-size:20px;margin-right:10px;" ></i> Partner Organization</a>
                <a href="../../weather_page.php"><i class="fas fa-cloud-sun-rain" style="font-size:24px;margin-right:10px;"></i> Weather Update</a>
                <a href="Settings.php"><i class="fa fa-gear" style="font-size:24px"></i> Settings</a>
                <hr>
                <a class="logout" href="' . '/backend/php/logout.php' . '"><i class="fa fa-sign-out" style="font-size:24px"></i> Log out</a>
            </div>
        </div>
    </nav>
</header>
<img class="logoimg" id="cover-pic" src="' . $coverImageSrc . '" alt="" height="300" width="200">
<div class="profile">
    <img id="profile-pic" src="' . $profileImageSrc . '" alt="">
    <div class="name">' . $schoolName . '</div>
</div>';


$navbar_div = '<header class="nav-header">

        <div class="logo">
         
         <a href="../../Account/' . $_SESSION['account_type'] . '" style="text-decoration:none;font-size: 40px;
    color: white;
    margin-left: -60px;
    margin-right: 50px;
    margin-top: -16px;">&larr;</a>
            <a href="Student.php"> 
                <img src="image/drdsnhs.svg" alt="Logo">
            </a>
           
            
        </div>
        <nav class="by">

 
 <div class="menu">
  <div class="item">
    <a class="link">
      <span class="firstname" style="color:#fff;";> ' . $schoolName . ' </span>
      <svg viewBox="0 0 360 360" xml:space="preserve">
        <g id="SVGRepo_iconCarrier">
          <path 
            id="XMLID_225_"
            d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393 s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"
          ></path>
        </g>
      </svg>
    </a>
    <div class="submenu">
      
      <div class="submenu-item">
        <a href="../../weather_page.php"> 
                        Weather Update</a>
      </div>
      <div class="submenu-item">
        <a href="Upload.php">
                        FIle Upload</a>
      </div>
      <div class="submenu-item active-text-setting">
        <a href="Settings.php"> Settings & privacy</a>
      </div>
      <hr>
      <a class="logout"  href="' . '/backend/php/logout.php' . '">
      <div class="submenu-item ">
        <i class="fa fa-sign-out" style="font-size:24px; margin-right:10px;"></i>Log out
      
      </div></a>
    
     
    </div>
  </div>
</div>

        
        </nav>

    </header>';