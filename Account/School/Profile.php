<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School Profile</title>
    <link rel="stylesheet" type="text/css" href="css/Profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->



    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />



</head>

<body>
    <!-- Navbar top -->
    <div class="navbar-top">
        <div class="title">
            <h1>Profile</h1>
        </div>

        <!-- Navbar -->
        <ul>
            <!-- <li>
          <a href="#message">
            <span class="icon-count">29</span>
            <i class="fa fa-envelope fa-2x"></i>
          </a>
        </li>
        <li>
          <a href="#notification">
            <span class="icon-count">59</span>
            <i class="fa fa-bell fa-2x"></i>
          </a>
        </li> -->
            <li>
                <a href="Student.php">
                    <i class="fa fa-sign-out-alt fa-2x"></i>
                </a>
            </li>
        </ul>
        <!-- End -->
    </div>
    <!-- End -->

    <!-- Sidenav -->
    <div class="sidenav">
        <div class="profile">
            <img src="image/Dr.Ramon.png" alt="" width="100" height="100" />

            <div class="name">Dr. Ramon De Santos National High School</div>
            <!-- <div class="job">OLSHCO</div> -->
        </div>

        <!-- <div class="sidenav-url">
            <div class="url">
                <a href="#profile" class="active">Profile</a>
                <hr align="center" />
            </div>
            <div class="url">
                <a href="Settings.php">Settings</a>
                <hr align="center" />
            </div>
        </div> -->
    </div>
    <!-- End -->

    <!-- Main -->
    <div class="main">
        <h2>IDENTITY</h2>
        <div class="card">
            <div class="card-body">

                <table>
                    <tbody>
                        <tr>
                            <td>School</td>
                            <td>:</td>
                            <td>Dr. Ramon De Santos National High School</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>school@yahoo.com</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td>Brgy. San Antonio, Cuyapo, Philippines</td>
                        </tr>
                        <tr>
                            <td>Contact Number</td>
                            <td>:</td>
                            <td> (044) 611-0026; 0917-8830311</td>
                        </tr>
                        <tr>
                            <td>President</td>
                            <td>:</td>
                            <td>Most Rev. Ruberto C. Mallari, D.D.</td>
                        </tr>
                        <!-- <tr>
                            <td>Skill</td>
                            <td>:</td>
                            <td>PHP, HTML, CSS, Java</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <h2>Map</h2>
        <!-- <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1920.8544297966187!2d120.7673922211044!3d15.660484473847125!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33912cdb2318296d%3A0xe4e2117e97dfc92e!2sOur%20Lady%20of%20The%20Sacred%20Heart%20College!5e0!3m2!1sen!2sph!4v1716015242226!5m2!1sen!2sph"
            width="850" height="350" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe> -->

        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4180.818006163703!2d120.70824703813983!3d15.714406648857958!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391320a99919993%3A0x9be48d66ed4cad27!2sDr%20Ramon%20De%20Santos%20National%20High%20School!5e1!3m2!1sen!2sph!4v1728567463175!5m2!1sen!2sph"
            width="780" height="350" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>



        <h2>SOCIAL MEDIA</h2>
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <div class="social-media">
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-facebook fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-instagram fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-invision fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-whatsapp fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-snapchat fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->
    <footer>
        2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School
    </footer>
</body>

</html>