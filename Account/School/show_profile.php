<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/session_handler.php';

$schoolName = $_SESSION['school_name'];
$email = $_SESSION['email'];


$profile_div = '<header class="nav-header">
        <div class="logo">
            <a href="#">
                <img src="image/logov3.jpg" alt="Logo">
            </a>
        </div>


        <nav class="by">
           

    

            <div class="dropdown" style="float:right;">
                <a href=""><i class="fas fa-user-alt" style="font-size:24px;  margin-top:10px;"></i></a>
                <div class="dropdown-content">
                    <div class="email">' . $email . '</div>
                    
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
// <a href="Profile.php"><i class="fas fa-user-alt" style="font-size:24px; margin-right:10px;"></i> My Profile</a> line 26