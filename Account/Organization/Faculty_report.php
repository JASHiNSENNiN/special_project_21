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
    <link rel="stylesheet" type="text/css" href="css/Faculty_report.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>


</head>

<body>
    <?php echo $profile_div; ?>
    <br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"> Job Ads</a>
            <a href="Job_request.php">Job Request</a>
            <a class="active1" href="Faculty_report.php">Student Evaluation</a>
            <a href="Question.php">Questions</a>
            <a href="Details.php">Analytics</a>


        </nav>
    </div>
    <hr class="line_bottom">

    <div class="container2">
        <h1>Student List</h1>
        <table class="rwd-table">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>ID Picture</th>
                    <th>Student Name</th>
                    <th>School</th>
                    <th>Result</th>
                    <th>Action</th>

                </tr>
                <tr>
                    <td data-th="#">1</td>
                    <td data-th="ID Picture"><img class="idpic" src="../Student/image/Default.png" alt="me">
                    </td>
                    <td data-th="Student Name">Joshua Rivera</td>
                    <td data-th="School">Olscho</td>
                    <td data-th="Result">

                        <div class="container3">
                            <div class="circular-progress">
                                <span class="progress-value"></span>
                            </div>
                        </div>

                    </td>
                    <td data-th="Action"><button class="button-9" role="button">Evaluate</button></td>
                </tr>

                <tr>
                    <td data-th="#">2</td>
                    <td data-th="ID Picture"><img class="idpic" src="../Student/image/Default.png" alt="me"></td>
                    <td data-th="Student Name">Dan Mamaid</td>
                    <td data-th="School">Olscho</td>
                    <td data-th="Result">
                        <div class="container3">
                            <div class="circular-progress">
                                <span class="progress-value"></span>
                            </div>
                        </div>
                        <!-- <button onclick="myFunction()" class="button-9" role="button">Result</button><br>
                        <button class="button-37" role="button">Archive</button> -->
                    </td>
                    <td data-th="Action"><button class="button-9" role="button">Evaluate</button></td>
                </tr>

            </tbody>

        </table>
    </div>



    <script>
        $("input:checkbox").on('click', function () {

            var $box = $(this);
            if ($box.is(":checked")) {
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    </script>

    <script>
        $(document).ready(function validation() {
            $('.form').on('submit', function validation() {
                Swal.fire({
                    title: "Successfully send!",
                    text: "You clicked the button!",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        });
    </script>


    <script>
        let profilePic1 = document.getElementById("cover-pic");
        let inputFile1 = document.getElementById("input-file1");

        inputFile1.onchange = function () {
            profilePic1.src = URL.createObjectURL(inputFile1.files[0]);
        }
    </script>

    <script>
        let profilePic2 = document.getElementById("profile-pic");
        let inputFile2 = document.getElementById("input-file2");

        inputFile2.onchange = function () {
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


    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students</p>
    </footer>


</body>

</html>