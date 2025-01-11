<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
;
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

$student_id = $_SESSION['user_id'];
$firstName = $_SESSION['first_name'];
$middleName = $_SESSION['middle_name'];
$lastName = $_SESSION['last_name'];
$school = $_SESSION['school'];
$gradeLevel = $_SESSION['grade_level'];
$strand = strtoupper($_SESSION['strand']);
// $stars = $_SESSION['stars'];
$currentWork = $_SESSION['current_work'];
$email = $_SESSION['email'];
$profile_image_path = $_SESSION['profile_image'];
$cover_image_path = $_SESSION['cover_image'];


// Fetch current profile data
$profile_data = null;
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT sp.*, u.profile_image, u.cover_image
FROM student_profiles sp
JOIN users u ON sp.user_id = u.id
WHERE sp.user_id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $profile_data = $result->fetch_assoc();
}
$stmt->close();
$conn->close();

$profile_image_path = 'uploads/' . $profile_data['profile_image'];
$cover_image_path = 'uploads/' . $profile_data['cover_image'];

$profile_image = (isset($profile_data['profile_image']) && file_exists($profile_image_path)) ? $profile_image_path : 'uploads/default.png';

$cover_image = (isset($profile_data['cover_image']) && file_exists($cover_image_path)) ? $cover_image_path : 'uploads/cover.png';
$profile_div = '<header class="nav-header">
        <div class="logo">
            <a href="Company_Area.php">
                <img src="image/drdsnhs.svg" alt="Logo">
            </a>
        </div>
        <nav class="by">

 <div class="dropdowntf" style="float:right;">
                <a href="" class="notification"><i class="fas fa-bell" style="font-size:24px; color:#fff;"></i><span
                        class="badge">2</span></a>
                <div class="dropdowntf-content" id="box">
                    <label  class="notif">Notification</label>
                    <hr style="width: 100%;">
                    <div class="notifi-item">
                        <img src="../Organization/image/NIA.png" alt="img">
                        <div class="text">
                            <h4>NIA</h4>
                            <p>Welcome to NIA</p>
                        </div>
                    </div>
                    <div class="notifi-item">
                        <img src="../School/image/OLSHCO.png" alt="img">
                        <div class="text">
                            <h4>OLSHCO</h4>
                            <p>Your Account is verified</p>
                        </div>
                    </div>
                       <div class="notifi-item">
      <img src="https://via.placeholder.com/50" alt="img">
      <div class="text">
        <h4>Notification 3</h4>
        <p>Some message here</p>
      </div>
    </div>

   
    <div class="notifi-item">
      <img src="https://via.placeholder.com/50" alt="img">
      <div class="text">
        <h4>Notification 4</h4>
        <p>Another message</p>
      </div>
    </div>

    
    <div class="extra-notifications">
      <div class="notifi-item">
        <img src="https://via.placeholder.com/50" alt="img">
        <div class="text">
          <h4>Notification 5</h4>
          <p>Extra notification 1</p>
        </div>
      </div>
      <div class="notifi-item">
        <img src="https://via.placeholder.com/50" alt="img">
        <div class="text">
          <h4>Notification 6</h4>
          <p>Extra notification 2</p>
        </div>
      </div>
    </div>

    
    <div class="see-more" onclick="toggleNotifications()">See More</div>
  </div>
                </div>
            </div>


            <div class="dropdown" style="float:right;">
                <a href=""><i class="fas fa-user-alt" style="font-size:24px;  margin-top:5px;color:#fff;"></i></a>
                <div class="dropdown-content">
                    <div class="email">' . $email . '</div>
                    <a href="Profile.php?student_id=' . base64_encode(encrypt_url_parameter($student_id)) . '"><i class="fas fa-user-alt" style="font-size:24px; margin-right:10px;"></i> My
                        Profile</a>
                        <a href="../../weather_page.php"> <i class="fas fa-cloud-sun-rain" style="font-size:24px;margin-right:10px;"></i>
                        Weather Update</a>
                         <a href="Journal.php"><i class="fa fa-newspaper-o" style="font-size:24px; margin-right:10px;"></i>
                        Journal</a>
                        <a href="Upload.php"><i class="fa fa-file-text" style="font-size:24px; margin-right:10px;"></i>
                        File Upload</a>
                   
                    <a href="Settings.php"><i class="fa fa-gear" style="font-size:24px;margin-right:10px;"></i> Settings</a>
                    <hr>
                    <hr>
                    <a class="logout" href="' . '/backend/php/logout.php' . '"><i class="fa fa-sign-out" style="font-size:24px; margin-right:10px;"></i>Log out</a>
                </div>
            </div>
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <!-- <a class="login-btn" href="#" style="margin-left: 20px;">Log out</a> -->
        </nav>

    </header>

    <img class="logoimg" id="cover-pic" src="' . $cover_image . '" alt="" width="200" height="300">
    

    <div class="profile">
    
        <img src="' . $profile_image . '" alt="profile picture">
        <div class="name">' . $firstName . ' ' . $middleName . ' ' . $lastName . '</div>
        <label class="strand" for="">' . $strand . '</label>

         
        
    </div>';

// <div class="Settings">
//     <a href="edit_profile.php" style="text-decoration: none;">
//     <label for="input-file2" class="button-12" role="button">

//     <span class="edit">
//     <i class="fa fa-pencil"></i> Edit profile
//                     </span>
//                     <span class="pen"><i class="fa fa-pencil"></i></span></label></a>
//     </div>
//  <div class="dropdowntf" style="float:right;">
//                 <a href="" class="notification"><i class="fas fa-bell" style="font-size:24px;"></i><span
//                         class="badge">2</span></a>
//                 <div class="dropdowntf-content" id="box">
//                     <label for="" class="notif">Notification</label>
//                     <hr style="width: 100%;">
//                     <div class="notifi-item">
//                         <img src="../Organization/image/NIA.png" alt="img">
//                         <div class="text">
//                             <h4>NIA</h4>
//                             <p>Welcome to NIA</p>
//                         </div>
//                     </div>
//                     <div class="notifi-item">
//                         <img src="../School/image/OLSHCO.png" alt="img">
//                         <div class="text">
//                             <h4>OLSHCO</h4>
//                             <p>Report to the Office</p>
//                         </div>
//                     </div>
//                 </div>
//             </div>