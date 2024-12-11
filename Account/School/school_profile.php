<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/session_handler.php';

$schoolName = $_SESSION['school_name'];
$email = $_SESSION['email'];

$profile_divv = '<header class="nav-header">
        <div class="logo">
            <a href="Company_Area.php"> 
                <img src="image/header.png" alt="Logo">
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
      <div class="submenu-item active-text">
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
      <div class="submenu-item">
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
           

            <div class="dropdowntf" style="float:right;">
                <a href="" class="notification"><i class="fas fa-bell" style="font-size:24px;"></i><span
                        class="badge">2</span></a>
                <div class="dropdowntf-content" id="box">
                    <label for="" class="notif">Notification</label>
                    <hr style="width: 100%;">
                    <div class="notifi-item">
                        <img src="../Company/image/NIA.png" alt="img">
                        <div class="text">
                            <h4>NIA</h4>
                            <p>sent report for Revira, Joshua</p>
                        </div>
                    </div>
                    <div class="notifi-item">
                        <img src="../Company/image/NIA.png" alt="img">
                        <div class="text">
                            <h4>NIA</h4>
                            <p>sent report for Diaz, Ronald</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown" style="float:right;">
                <a href=""><i class="fas fa-user-alt" style="font-size:24px;  margin-top:10px;"></i></a>
                <div class="dropdown-content">
                    <div class="email">' . $email . '</div>
                    <a href="Profile.php"><i class="fas fa-user-alt" style="font-size:24px; margin-right:10px;"></i> My Profile</a>
                    <a href="../../weather_page.php"> <i class="fas fa-cloud-sun-rain" style="font-size:24px;margin-right:10px;"></i>
                        Weather Update</a>
                    <a href="Archive.php"> <i class="fa fa-archive" style="font-size:24px; Margin-right:10px"></i>Archive</a>
                    <a href="Settings.php"><i class="fa fa-gear" style="font-size:24px"></i> Settings</a>
                    <hr>
                    <a class="logout" href="' . '/backend/php/logout.php' . '"><i class="fa fa-sign-out" style="font-size:24px"></i> Log out</a>
                </div>
            </div>
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <!-- <a class="login-btn" href="#" style="margin-left: 20px;">Log out</a> -->
        </nav>
    </header>


    <img class="logoimg" id="cover-pic" src="image/schoolBackground.png" alt="" height="300" width="200">
    

    <div class="profile">
        <img id="profile-pic" src="image/schoolProfile.jpg" alt="">
        <div class="name">' . $schoolName . '</div>


        
    </div>';