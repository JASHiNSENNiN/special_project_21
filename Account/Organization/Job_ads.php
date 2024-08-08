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
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <link rel="stylesheet" type="text/css" href="css/job_ads.css">

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

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a class="active" href="Job_ads.php"> Job Ads</a>
            <a href="Job_request.php">Job Request</a>
            <a href="Faculty_report.php">Faculty Report</a>
            <a href="Question.php">Questions</a>
            <a href="Details.php">Snapshot</a>


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
                    <h1>Post a Job ad</h1>
                    <p>Please fill in this form to create a job.</p>
                    <hr>

                    <label for="worktitle"><b>Work Title</b></label>
                    <input type="text" placeholder="Enter Work Title" name="work_title" id="worktitle" required>

                    <label for=""><b>Choose a Strand:</b></label><br>
                    <label class="con">STEM
                        <input type="checkbox" name="strand[]" value="stem">
                        <span class="checkmark"></span>
                    </label>
                    <label class="con">GAS
                        <input type="checkbox" name="strand[]" value="gas">
                        <span class="checkmark"></span>
                    </label>
                    <label class="con">HUMSS
                        <input type="checkbox" name="strand[]" value="humss">
                        <span class="checkmark"></span>
                    </label>
                    <label class="con">TECHVOC
                        <input type="checkbox" name="strand[]" value="tvl">
                        <span class="checkmark"></span>
                    </label>


                    <h1>Job Description</h1>
                    <hr>
                    <input type="hidden" name="description" id="description">
                    <div id="editor-container"></div>
                    <hr>

                    <p>By creating job ads you agree to our <a href="#">Terms & Privacy</a>.</p>
                    <button class="button-9" role="button" type="submit">Submit</button>
                </div>
            </form>

            </form>
            <!-- <div class="button">
                        <a href="#">See All</a>
                    </div> -->
        </div>


    </div>


    <script src="css/doc.js"></script>

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


</body>

</html>