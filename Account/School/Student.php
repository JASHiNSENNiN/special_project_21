<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <link rel="stylesheet" type="text/css" href="css/Student.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>


</head>

<body>

    <?php echo $profile_div; ?>
    <br><br>
    <hr>
    <div class="logo">
        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Company.php">Work Immersion List</a>
            <!-- <a href="#.php">Company</a> -->
            <a class="active1" href="Student.php">Student</a>
            <a href="Dashboard.php">Analytics</a>
            <a href="Reports.php">Reports</a>
            <!-- <a href="Details.php">Details</a> -->


        </nav>
    </div>
    <hr class="line_bottom">


    <br>





    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <div class="container">
        <div class="box" id="#humss">
            <span class="material-symbols-outlined">
                balance
            </span>
            <p>Humss</p>
        </div>
        <div class="box" id="#stem">
            <span class="material-symbols-outlined">
                experiment
            </span>
            <p>Stem</p>
        </div>
        <div class="box" id="#gas">
            <span class="material-symbols-outlined">
                menu_book
            </span>
            <p>Gas</p>
        </div>
        <div class="box" id="#techvoc">
            <span class="material-symbols-outlined">
                construction
            </span>
            <p>TechVOc</p>
        </div>
    </div>

    <div id="content_container">
        <div id="humss" class="content active">
            <h1 style="margin-bottom: 50px; margin-top:50px">HUMSS</h1>
            <div class="container2">
                <table class="rwd-table">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>ID Picture</th>
                            <th>Student Name</th>
                            <th>Result</th>
                            <th>Action</th>

                        </tr>
                        <tr>
                            <td data-th="#">1</td>
                            <td data-th="ID Picture"><img class="idpic" src="image/me.jpg" alt="me">
                            </td>
                            <td data-th="Student Name">Joshua Rivera</td>
                            <td data-th="Result">

                                <div class="container3">
                                    <div class="circular-progress">
                                        <span class="progress-value"></span>
                                    </div>
                                </div>

                            </td>
                            <td data-th="Action"><button class="button-9" role="button">View Profile</button></td>
                        </tr>

                        <tr>
                            <td data-th="#">2</td>
                            <td data-th="ID Picture"><img class="idpic" src="image/profile.jpg" alt="me"></td>
                            <td data-th="Student Name">Dan Mamaid</td>
                            <td data-th="Result">
                                <div class="container3">
                                    <div class="circular-progress">
                                        <span class="progress-value"></span>
                                    </div>
                                </div>
                                <!-- <button onclick="myFunction()" class="button-9" role="button">Result</button><br>
                        <button class="button-37" role="button">Archive</button> -->
                            </td>
                            <td data-th="Action"><button class="button-9" role="button">View Profile</button></td>
                        </tr>

                    </tbody>

                </table>
            </div>
        </div>

        <div id="stem" class="content">
            <h1 style="margin-bottom: 50px; margin-top:50px">STEM</h1>
            <div class="container2">
                <table class="rwd-table">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>ID Picture</th>
                            <th>Student Name</th>
                            <th>Result</th>
                            <th>Action</th>

                        </tr>
                        <tr>
                            <td data-th="#">1</td>
                            <td data-th="ID Picture"><img class="idpic" src="image/me.jpg" alt="me">
                            </td>
                            <td data-th="Student Name">Joshua Rivera</td>
                            <td data-th="Result">

                                <div class="container3">
                                    <div class="circular-progress">
                                        <span class="progress-value"></span>
                                    </div>
                                </div>

                            </td>
                            <td data-th="Action"><button class="button-9" role="button">View Profile</button></td>
                        </tr>

                        <tr>
                            <td data-th="#">2</td>
                            <td data-th="ID Picture"><img class="idpic" src="image/profile.jpg" alt="me"></td>
                            <td data-th="Student Name">Dan Mamaid</td>
                            <td data-th="Result">
                                <div class="container3">
                                    <div class="circular-progress">
                                        <span class="progress-value"></span>
                                    </div>
                                </div>
                                <!-- <button onclick="myFunction()" class="button-9" role="button">Result</button><br>
                        <button class="button-37" role="button">Archive</button> -->
                            </td>
                            <td data-th="Action"><button class="button-9" role="button">View Profile</button></td>
                        </tr>

                    </tbody>

                </table>
            </div>
        </div>

        <div id="gas" class="content">
            <h1 style="margin-bottom: 50px; margin-top:50px">GAS</h1>
            <div class="container2">
                <table class="rwd-table">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>ID Picture</th>
                            <th>Student Name</th>
                            <th>Result</th>
                            <th>Action</th>

                        </tr>
                        <tr>
                            <td data-th="#">1</td>
                            <td data-th="ID Picture"><img class="idpic" src="image/me.jpg" alt="me">
                            </td>
                            <td data-th="Student Name">Joshua Rivera</td>
                            <td data-th="Result">

                                <div class="container3">
                                    <div class="circular-progress">
                                        <span class="progress-value"></span>
                                    </div>
                                </div>

                            </td>
                            <td data-th="Action"><button class="button-9" role="button">View Profile</button></td>
                        </tr>

                        <tr>
                            <td data-th="#">2</td>
                            <td data-th="ID Picture"><img class="idpic" src="image/profile.jpg" alt="me"></td>
                            <td data-th="Student Name">Dan Mamaid</td>
                            <td data-th="Result">
                                <div class="container3">
                                    <div class="circular-progress">
                                        <span class="progress-value"></span>
                                    </div>
                                </div>
                                <!-- <button onclick="myFunction()" class="button-9" role="button">Result</button><br>
                        <button class="button-37" role="button">Archive</button> -->
                            </td>
                            <td data-th="Action"><button class="button-9" role="button">View Profile</button></td>
                        </tr>

                    </tbody>

                </table>
            </div>
        </div>

        <div id="techvoc" class="content">
            <h1 style="margin-bottom: 50px; margin-top:50px">TECHVOC</h1>
            <div class="container2">
                <table class="rwd-table">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>ID Picture</th>
                            <th>Student Name</th>
                            <th>Result</th>
                            <th>Action</th>

                        </tr>
                        <tr>
                            <td data-th="#">1</td>
                            <td data-th="ID Picture"><img class="idpic" src="image/me.jpg" alt="me">
                            </td>
                            <td data-th="Student Name">Joshua Rivera</td>
                            <td data-th="Result">

                                <div class="container3">
                                    <div class="circular-progress">
                                        <span class="progress-value"></span>
                                    </div>
                                </div>

                            </td>
                            <td data-th="Action"><button class="button-9" role="button">View Profile</button></td>
                        </tr>

                        <tr>
                            <td data-th="#">2</td>
                            <td data-th="ID Picture"><img class="idpic" src="image/profile.jpg" alt="me"></td>
                            <td data-th="Student Name">Dan Mamaid</td>
                            <td data-th="Result">
                                <div class="container3">
                                    <div class="circular-progress">
                                        <span class="progress-value"></span>
                                    </div>
                                </div>
                                <!-- <button onclick="myFunction()" class="button-9" role="button">Result</button><br>
                        <button class="button-37" role="button">Archive</button> -->
                            </td>
                            <td data-th="Action"><button class="button-9" role="button">View Profile</button></td>
                        </tr>

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <script>
        $(".box").click(function(e) {
            e.preventDefault();
            $(".content").removeClass("active");
            var content_id = $(this).attr("id");
            $(content_id).addClass("active");
        });
    </script>
    <br>
    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students</p>
    </footer>

    <script>
        let profilePic1 = document.getElementById("cover-pic");
        let inputFile1 = document.getElementById("input-file1");

        inputFile1.onchange = function() {
            profilePic1.src = URL.createObjectURL(inputFile1.files[0]);
        }
    </script>

    <script>
        let profilePic2 = document.getElementById("profile-pic");
        let inputFile2 = document.getElementById("input-file2");

        inputFile2.onchange = function() {
            profilePic2.src = URL.createObjectURL(inputFile2.files[0]);
        }
    </script>

    <script>
        let circularProgress =
            document.querySelector('.circular-progress'),
            progressValue =
            document.querySelector('.progress-value');



        let progressStartValue = 0,
            progressEndValue = 80,
            speed = 20;



        let progress = setInterval(() => {

            progressStartValue++;
            progressValue.textContent =
                `${progressStartValue}%`;
            circularProgress.style.background =
                `conic-gradient(#4379F2 ${progressStartValue
                * 3.6}deg, #ededed 0deg)`;

            //3.6deg * 100 = 360deg

            //3.6deg * 90 = 324deg





            if (progressStartValue == progressEndValue) {

                clearInterval(progress);



            }

            console.log(progressStartValue);

        }, speed);
    </script>

    <!-- <div class="sub-footer">
        2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students
    </div> -->


</body>

</html>