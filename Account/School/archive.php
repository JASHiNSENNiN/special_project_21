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
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <link rel="stylesheet" type="text/css" href="css/Archive.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
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
            <!-- <a href="Company.php">Work Immersion List</a> -->
            <!-- <a href="#.php">Company</a> -->
            <a href="Student.php"><i class="fas fa-user-graduate"></i>Student</a>
            <a href="Dashboard.php"><i class="fa fa-bar-chart"></i>Analytics</a>
            <a href="Reports.php"><i class="fa fa-file-text-o"></i>Reports</a>
            <a class="active" href="Archive.php"><i class="fa fa-archive"></i>Archive</a>
            <!-- <a href="Details.php">Details</a> -->
        </nav>
    </div>
    <hr class="line_bottom">


    <div class="container2">
        <div class="page-wrapper">
            <ol class='years'>
                <li class='year'><a class='expander' href="#" id="current-year"></a>
                    <ol>
                        <li class='month'><a class='expander' href="#">December</a>
                            <ol>
                                <li>Christmas Special</li>
                                <li>Walk the Mile</li>
                                <li>Quilting Time</li>
                                <li>Retreat in Memphis</li>
                            </ol>
                        </li>
                        <li class='month'><a class='expander' href="#">November</a>
                            <ol>
                                <li>Thanksgiving Special</li>
                                <li>Walk the Mile</li>
                                <li>Quilting Time</li>
                                <li>Retreat in Memphis</li>
                            </ol>
                        </li>
                        <li>October</li>
                        <li>September</li>
                        <li>August</li>
                        <li>July</li>
                        <li>June</li>
                        <li>May</li>
                        <li>April</li>
                        <li>March</li>
                        <li>February</li>
                        <li>January</li>
                    </ol>
                </li>
                <li class='year'><a class='expander' href="#">2025</a>
                    <ol>
                        <li class='month'><a class='expander' href="#">December</a>
                            <ol>
                                <li>Christmas Special</li>
                                <li>Walk the Mile</li>
                                <li>Quilting Time</li>
                                <li>Retreat in Memphis</li>
                            </ol>
                        </li>
                        <li class='month'><a class='expander' href="#">November</a>
                            <ol>
                                <li>Thanksgiving Special</li>
                                <li>Walk the Mile</li>
                                <li>Quilting Time</li>
                                <li>Retreat in Memphis</li>
                            </ol>
                        </li>
                        <li>October</li>
                        <li>September</li>
                        <li>August</li>
                        <li>July</li>
                        <li>June</li>
                        <li>May</li>
                        <li>April</li>
                        <li>March</li>
                        <li>February</li>
                        <li>January</li>
                    </ol>
                </li>
            </ol>
        </div>
    </div>



    <br>

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
    </footer>

    <!-- <script>
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
    </script> -->

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function () {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $('.expander').click(function (e) {
            e.preventDefault();
            $(this)
                .parent()
                .toggleClass('expanded')
                .find('>ol')
                .slideToggle();
        });
    </script>

    <script type="text/javascript">
        // Get the current year
        const currentYear = new Date().getFullYear();

        // Find the element with id 'current-year' and set its text
        document.getElementById("current-year").textContent = currentYear;
    </script>

</body>

</html>