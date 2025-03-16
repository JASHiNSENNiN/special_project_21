<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
;
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/session_handler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';

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
$profile_image = ($_SESSION['profile_image'] === './uploads/') ? './image/default.png' : $_SESSION['profile_image'];
$cover_image = ($_SESSION['cover_image'] === './uploads/') ? './image/logov3.jpg' : $_SESSION['cover_image'];


$profile_divv = '<header class="nav-header">
        <div class="logo">
            <a href="Company_Area.php"> 
                <img src="image/drdsnhs.svg" alt="Logo">
            </a>
         
            
        </div>
        <nav class="by">

 
 <div class="menu">
  <div class="item">
    <a class="link">
      <span class="firstname"> <span class="username">Welcome </span> ' . $firstName . ' </span>
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

      <a class="logout"  href="' . '/backend/php/logout.php' . '">
      
      <div class="submenu-item ">
       Log out
      
      </div>
      
      </a>
    
     
    </div>
  </div>
</div>
        
        </nav>

    </header>

    ';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->
    <title>Verification</title>
    <link rel="stylesheet" href="css/verify.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
    </style>
</head>

<body>
    <!-- <header class="nav-header">
        <div class="logo">
            <a href="#">
                <img src="image/header.png" alt="Logo">
                <img src="image/logov3.jpg" alt="Logo">
            </a>
        </div>

     
        <div class="user-info">

            <span class="username">Welcome</span>

          
            <div class="dropdown">
                
                <a href="../../index.php">Logout</a>
            </div>
        </div>
    </header> -->
    <?php echo $profile_divv; ?>
    <div class="background">
        <div class="wame">
            <div class="exclamation">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1 class="wait">Wait for Your Account Verification</h1>
            <div class="message">Please upload all requirements to verify your account <a href="File.php">here</a>.
            </div>
            <!-- <a href="Upload.php"><button class="button-10">Upload file</button></a> -->
        </div>
    </div>
</body>

</html>