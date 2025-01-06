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
    <title>Organization Dashboard</title>
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="stylesheet" type="text/css" href="css/job_ads.css">
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>
</head>

<body>
    <?php echo $profile_div; ?>
    <br>
    <hr>
    <div class="logo">

        <!-- <div class="dropdowntf" style="float:right;">
            <a href="" class="notification"><i class="fas fa-bell" style="font-size:24px;"></i><span
                    class="badge">1</span></a>
            <div class="dropdowntf-content" id="box">
                <label for="" class="notif">Notification</label>
                <hr style="width: 100%;">
                <div class="notifi-item">
                    <img src="../Student/image/me.jpg" alt="img">
                    <div class="text">
                        <h4>Miguel Von Natividad</h4>
                        <p>Sent Request</p>
                    </div>
                </div>
            </div>
        </div> -->

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a class="active" href="Job_ads.php"><i class="fa fa-calendar-plus-o"></i> Job Ads</a>
            <a href="Job_request.php"><i class="fa fa-user-plus"></i> Job Request</a>
            <a href="Faculty_report.php"><i class='fas fa-tasks'></i> Student Evaluation</a>
            <!-- <a href="Question.php">Questions</a> -->
            <a href="Details.php"><i class="fa fa-bar-chart"></i>Analytics</a>


        </nav>
    </div>
    <hr class="line_bottom">


    <br>



    <div class="sales-boxes">
        <div class="recent-sales box">
            <b>
                <!-- <div class="box-topic" style="margin-left: 20px;">Post a Job ad for free </div> -->
            </b>

            <!-- <div class="title">Popularity Company </div> -->
            <!-- <div class="title">Student List <div class="icon"><i class="bx bx-user-plus"></i> </div> </div> -->

            <form method="post" action="/backend/php/add_job.php">
                <div class="container">

                    <h1 class="ti">POST A JOB AD</h1>
                    <p class="ti">Please fill in this form to create a job.</p>



                    <div class="box">
                        <label for="worktitle"><b>Work Title</b></label>
                        <input type="text" placeholder="Enter Work Title" name="work_title" id="worktitle" required>

                        <label for=""><b>Choose a Strand:</b></label><br><br>
                        <label class="con">STEM
                            <input type="checkbox" name="strand[]" value="STEM">
                            <span class="checkmark"></span>
                        </label>

                        <label class="con">GAS
                            <input type="checkbox" name="strand[]" value="GAS">
                            <span class="checkmark"></span>
                        </label>
                        <label class="con">HUMSS
                            <input type="checkbox" name="strand[]" value="HUMSS">
                            <span class="checkmark"></span>
                        </label>
                        <label class="con">TECHVOC
                            <input type="checkbox" name="strand[]" value="TVL">
                            <span class="checkmark"></span>
                        </label>

                        <div class="wrapper">
                            <div class="title">


                            </div>
                        </div>

                        <h1>Job Description</h1>

                        <input type="hidden" name="description" id="description">
                        <div id="editor-container"></div>

                        <div class="container__nav">
                            <small>By clicking 'Check box' you are agreeing to our <a
                                    href="../../Term_and_Privacy.php">Terms & Privacy</a></small>
                            <input class="required" type="checkbox" id="agree" name="agree" value="agree" required>
                        </div>
                        <button class="button-9" id="show-modal" role="button" type="submit" autofocus>Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- <div id="containerModal" class="contain"> -->
    <div id="success-modal" class="modal">
        <div class="modal__icon">✓</div>
        <h3 class="modal__title">Successfully posted ads.</h3>
        <p class="modal__countdown">
            <!-- <button class="button-0" role="button" type="submit">Submit</button><br><br> -->
            Disappearing in <span id="countdown">5</span> seconds...
        </p>
    </div>
    <!-- </div> -->


    <script src="css/job_ads.js"> </script>

    <script type="text/javascript" src="css/doc.js"></script>

    <footer>
        <!-- <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p> -->
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer </p>
    </footer>

    <!-- <script>
    document.addEventListener("DOMContentLoaded", () => {
        const button = document.getElementById("show-modal");
        const modal = document.getElementById("success-modal");
        const countdownElement = document.getElementById("countdown");
        const inputField = document.getElementById("worktitle"); 
        const checkbox = document.getElementById("agree"); 

        button.addEventListener("click", () => {
           
            if (inputField.value.trim() === "") {
                alert("Please fill out text cannot be empty!"); 
                return; 
            }

            if (!checkbox.checked) {
                alert("You must agree to the terms!"); 
                return; 
            }

           
            modal.style.display = "flex"; 
            modal.classList.add("modal--open");

            
            let seconds = 5;
            countdownElement.textContent = seconds;

            const countdownInterval = setInterval(() => {
                seconds--;
                countdownElement.textContent = seconds;

                
                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                    modal.classList.remove("modal--open"); 
                    setTimeout(() => {
                        modal.style.display = "none"; 
                    }, 500); 
                }
            }, 1000);
        });
    });
    </script> -->

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const button = document.getElementById("show-modal");
        const modal = document.getElementById("success-modal");
        const countdownElement = document.getElementById("countdown");



        button.addEventListener("click", () => {
            // Open the modal
            modal.classList.add("modal--open");

            // Countdown logic
            let seconds = 5;
            countdownElement.textContent = seconds;

            const countdownInterval = setInterval(() => {
                seconds--;
                countdownElement.textContent = seconds;

                // When the countdown reaches 0, hide the modal
                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                    modal.classList.remove("modal--open");
                }
            }, 1000);
        });
    });
    </script>



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

    <script type="text/javascript">
    function toggleNotifications() {
        const extraNotifications = document.querySelector('.extra-notifications');
        const seeMoreLink = document.querySelector('.see-more');

        if (extraNotifications.style.display === 'none' || extraNotifications.style.display === '') {
            extraNotifications.style.display = 'block';
            seeMoreLink.textContent = 'See Less';
        } else {
            extraNotifications.style.display = 'none';
            seeMoreLink.textContent = 'See More';
        }
    }
    </script>


</body>

</html>