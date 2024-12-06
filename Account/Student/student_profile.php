<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
};
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/session_handler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';

$student_id = $_SESSION['user_id'];
$firstName = $_SESSION['first_name'];
$middleName = $_SESSION['middle_name'];
$lastName = $_SESSION['last_name'];
$school = $_SESSION['school'];
$gradeLevel = $_SESSION['grade_level'];
$strand = strtoupper($_SESSION['strand']);
$stars = $_SESSION['stars'];
$currentWork = $_SESSION['current_work'];
$email = $_SESSION['email'];
$profile_image = ($_SESSION['profile_image'] === './uploads/') ? './image/default.png' : $_SESSION['profile_image'];


$profile_divv = '<header class="nav-header">
        <div class="logo">
            <a href="Company_Area.php"> 
                <img src="image/logov3.jpg" alt="Logo">
            </a>
           <a class="btn-home" style="color:#1bbc9b; font-weight: 600;" href="Narrative_Report.php"> Home </a>
            
        </div>
        <nav class="by">

 
 <div class="menu">
  <div class="item">
    <a class="link">
      <span class="firstname"> ' . $firstName . ' </span>
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
      <div class="submenu-item active-text-profile">
         <a href="Profile.php?student_id=' . base64_encode(encrypt_url_parameter($student_id)) . '"> My
                        Profile</a>
      </div>
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
