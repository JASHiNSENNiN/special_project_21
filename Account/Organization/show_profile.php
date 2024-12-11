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

$conn = new mysqli($host, $username, $password, $database);


$organizationId = $_SESSION['user_id'];
$organizationName = $_SESSION['organization_name'];
$email = $_SESSION['email'];
$strandFocus = strtoupper($_SESSION['strand']);


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

$userImages = get_user_images($email);

$profileImageSrc = $userImages['profile_image'];
$coverImageSrc = $userImages['cover_image'];

$navbar_div = '<header class="nav-header">
        <div class="logo">
            <a href="Job_ads.php"> 
                <img src="image/logov3.jpg" alt="Logo">
            </a>
           <a class="btn-home" style="color:#1bbc9b; font-weight: 600;" href="../../Account/' . $_SESSION['account_type'] . '"> Home </a>
            
        </div>
        <nav class="by">

 
 <div class="menu">
  <div class="item">
    <a class="link">
      <span class="firstname"> ' . $organizationName . ' </span>
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

    </header>
';




$profile_div = '<header class="nav-header">
        <div class="logo">
            <a href="#">
                 <img src="image/logov3.jpg" alt="Logo">
            </a>
        </div>

        <nav class="by">

            <div class="dropdown" style="float:right; margin-bottom:24px;">
                <a href=""><i class="fas fa-user-alt" style="font-size:24px;  margin-top:10px;"></i></a>
                <div class="dropdown-content">
                    <div class="email">' . $email . '</div>
                    
                    <a href="Profile.php?organization_id=' . base64_encode(encrypt_url_parameter($organizationId)) . '"><i class="fas fa-user-alt" style="font-size:24px; margin-right:10px;"></i> My
                        Profile</a>
                    <a href="My_Jobs.php"><i class="fas fa-bookmark" style="font-size:24px; margin-right:10px; "></i> My Jobs</a>
                    
                         <a href="../../weather_page.php"> <i class="fas fa-cloud-sun-rain" style="font-size:24px;margin-right:10px;"></i>
                        Weather Update</a>
                    <a href="Settings.php"><i class="fa fa-gear" style="font-size:24px;"></i> Settings & privacy</a>
                    <hr>
                    
                    <hr>
                    <a class="logout" href="' . '/backend/php/logout.php' . '"> <i class="fa fa-sign-out" style="font-size:24px; margin-right:10px;"></i>Log out</a>
                </div>
            </div>
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <!-- <a class="login-btn" href="#" style="margin-left: 20px;">Log out</a> -->
        </nav>
    </header>


    <img class="logoimg" id="cover-pic" src="' . $coverImageSrc . '" alt="" height="300" width="200">


    <div class="profile">
        <img id="profile-pic" src="' . $profileImageSrc . '" alt="">
        <div class="name">' . $organizationName . '</div>
        <label class="strand" for="">' . $strandFocus . '</label>

        
    </div>';
