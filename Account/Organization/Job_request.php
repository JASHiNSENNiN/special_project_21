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
    <link rel="stylesheet" type="text/css" href="css/Job_request.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->


    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet '>


</head>

<body>
    <?php echo $profile_div; ?>
    <br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"> Job Ads</a>
            <a class="active" href="Job_request.php">Job Request</a>
            <a href="Faculty_report.php">Faculty Report</a>
            <a href="Question.php">Questions</a>
            <a href="Details.php">Snapshot</a>


        </nav>
    </div>
    <hr class="line_bottom">


    <div class="sales-boxes">
        <div class="recent-sales box">

            <b>
                <div class="box-topic">Job Request</div>
            </b>
            <div class="search-box">
                <input type="text" placeholder="Search...">
                <i class='bx bx-search'></i>
            </div>

            <br>
            <!-- <div class="title">Popularity Company </div> -->
            <!-- <div class="title">Student List <div class="icon"><i class="bx bx-user-plus"></i> </div> </div> -->

            <table id="tbl">
                <tr>
                    <th>#</th>
                    <!-- <th>Student ID</th> -->
                    <th>Name</th>
                    <th>Strand</th>
                    <th>School</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>1</td>
                    <!-- <td>2024-11</td> -->
                    <td>Miguel Natividad</td>
                    <td>HUMSS</td>
                    <td>OLSHCO</td>
                    <td>Guimba</td>
                    <td><button type="button" class="button-9">Accept</button>
                        <a href="../Student/Resume.php" target="_blank">
                            <button type="button" class="button-4">Details</button></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <!-- <td>2024-12</td> -->
                    <td>Russel Requina</td>
                    <td>GAS</td>
                    <td>National</td>
                    <td>Guimba</td>
                    <td><button type="button" class="button-9">Accept</button>
                        <button type="button" class="button-4">Details</button>
                    </td>

                </tr>
                <tr>
                    <td>3</td>
                    <!-- <td>2024-13</td> -->
                    <td>Josh Cinense</td>
                    <td>STEM</td>
                    <td>BLUN</td>
                    <td>Guimba</td>
                    <td><button type="button" class="button-9">Accept</button>
                        <button type="button" class="button-4">Details</button>
                    </td>

                </tr>
            </table>
            <!-- <div class="button">
                        <a href="#">See All</a>
                    </div> -->
        </div>

    </div>


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