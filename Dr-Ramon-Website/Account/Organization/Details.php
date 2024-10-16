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
    <title>Company Dashboard</title>
    <link rel="icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">

    <link rel="stylesheet" type="text/css" href="css/Details.css">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>

    <script src="./css/analytics.js"></script>

</head>

<body>
    <?php echo $profile_div; ?>


    <br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"> Job Ads</a>
            <a href="Job_request.php">Job Request</a>
            <a href="Faculty_report.php">Student Evaluation</a>
            <a href="Question.php">Questions</a>
            <a class="active" href="Details.php">Analytics</a>


        </nav>
    </div>
    <hr class="line_bottom">


    <div class="bgc">

        <div class="container-data-box">

            <div class="data-box">

                <p>20</p>
                <label>Total of Student</label>
            </div>

            <div class="data-box">

                <p>10</p>
                <label>Total of Deployment</label>
            </div>

            <div class="data-box">

                <p>34</p>
                <label>Total of Request Applicant</label>
            </div>
        </div>


        <div class="row-analytics">

            <div class="column-1">
                <h3 class="title">Company Performance</h3>
                <div class="dp-graph" id="com_chart_div">
                </div>


            </div>
            <div class="column">
                <h3 class="title">Total Strand Workspace</h3>
                <div class="dp-graph-strand" id="piechart_3d"></div>



            </div>


        </div>

        <!-- <hr class="line_bottom"> -->


    </div>


    <br>

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
    </footer>

    <script>
        let profilePic1 = document.getElementById("cover-pic");
        let inputFile1 = document.getElementById("input-file1");

        inputFile1.onchange = function() {
            profilePic1.src = URL.createObjectURL(inputFile1.files[0])
        };
    </script>

    <script>
        let profilePic2 = document.getElementById("profile-pic");
        let inputFile2 = document.getElementById("input-file2");

        inputFile2.onchange = function() {
            profilePic2.src = URL.createObjectURL(inputFile2.files[0])
        };
    </script>


    <!-- 
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>