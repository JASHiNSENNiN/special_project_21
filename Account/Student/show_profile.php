<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/session_handler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';

$student_id = $_SESSION['id'];
$firstName = $_SESSION['first_name'];
$middleName = $_SESSION['middle_name'];
$lastName = $_SESSION['last_name'];
$school = $_SESSION['school'];
$gradeLevel = $_SESSION['grade_level'];
$strand = strtoupper($_SESSION['strand']);
$stars = $_SESSION['stars'];
$currentWork = $_SESSION['current_work'];
$email = $_SESSION['email'];

$profile_div = '<header class="nav-header">
        <div class="logo">
            <a href="image/index.php">
                <img src="image/logov3.jpg" alt="Logo">
            </a>
        </div>
        <nav class="by">
           
           

            <div class="dropdown" style="float:right;">
                <a href=""><i class="fas fa-user-alt" style="font-size:24px;  margin-top:5px;"></i></a>
                <div class="dropdown-content">
                    <div class="email">' . $email . '</div>
                    <a href="Profile.php?student_id=' . base64_encode(encrypt_url_parameter($student_id)) . '"><i class="fas fa-user-alt" style="font-size:24px; margin-right:10px;"></i> My
                        Profile</a>
                    <a href="#"> <i class="fas fa-comment-alt" style="font-size:24px;margin-right:10px;"></i>My
                        Reviews</a>
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

    <img class="logoimg" id="cover-pic" src="image/background.jpg" alt="" width="200" height="300">
    

    <div class="profile">
        <img src="image/default.png" alt="">
        <div class="name">' . $firstName . ' ' . $middleName . ' ' . $lastName . '</div>
        <label class="strand" for="">' . $strand . '</label>

        <div class="Settings">
        <a href="edit_profile.php" style="text-decoration: none;">
        <label for="input-file2" class="button-12" role="button">
        <span class="edit">
        <i class="fa fa-pencil"></i> Edit profile
                        </span>
                        <span class="pen"><i class="fa fa-pencil"></i></span></label></a>
        </div>
    </div>';
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