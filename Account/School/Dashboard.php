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
    <link rel="stylesheet" type="text/css" href="css/Dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/analytics.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
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
            <a href="Student.php">Student</a>
            <a class="active" href="Dashboard.php">Analytics</a>
            <a href="Reports.php">Reports</a>


        </nav>
    </div>
    <hr class="line_bottom">
    </div>

    <div class="row">
        <div class="column">
            <h1 class="title">Top 5 Company</h1>
            <canvas id="myChart1" class="Chart1"></canvas>
        </div>
        <div class="column">
            <h1 class="title">Student Population</h1>
            <div id="myChart2" class="Chart2"></div>
        </div>
    </div>

    <hr class="line_bottom">
    <div class="container4">
        <h1 class="Time">Student Timeline</h1>
        <div id="timeline" style="height: 180px;"></div>
    </div>

    <!-- <div class="container2">
        <h1 style="margin-bottom: 20px;">Student Information</h1>
        <table class="rwd-table">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>ID Picture</th>
                    <th>Student Name</th>
                    <th>Strand</th>
                    <th>Result</th>
                    <th>Action</th>

                </tr>
                <tr>
                    <td data-th="#">1</td>
                    <td data-th="ID Picture"><img class="idpic" src="image/me.jpg" alt="me">
                    </td>
                    <td data-th="Student Name">Joshua Rivera</td>
                    <td data-th="Strand">HUMSS</td>
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
                    <td data-th="Strand">STEM</td>
                    <td data-th="Result">
                    </td>
                    <td data-th="Action"><button class="button-9" role="button">View Profile</button></td>
                </tr>

            </tbody>

        </table>
    </div> -->



    <br>
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
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <script>
        const xValues = ["NIA", "Jollibee", "Mcdo", "Inasal", "Argentina"];
        const yValues = [55, 49, 44, 24, 15];
        const barColors = ["#7CF5FF", "#00CCDD", "#4F75FF", "#6439FF", "#4379F2"];

        new Chart("myChart1", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {
                    display: false

                },
                title: {
                    display: true,
                    text: "Result",
                    fontSize: 20,
                    color: 'black'

                }
            }
        });
    </script>

    <script>
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            // Set Data
            const data = google.visualization.arrayToDataTable([
                ['Strand', 'none'],
                ['STEM', 54],
                ['HUMSS', 48],
                ['GAS', 44],
                ['ABM', 23],
                ['TECHVOC', 14]
            ]);


            // Set Options
            const options = {
                title: 'Result',
                is3D: true,
                'width': 800,
                'height': 400,
                fontSize: 12

            };


            // Draw
            const chart = new google.visualization.PieChart(document.getElementById('myChart2'));
            chart.draw(data, options);

        }
    </script>

    <script>
        let circularProgress =

            document.querySelector('.circular-progress'),

            progressValue =

            document.querySelector('.progress-value');



        let progressStartValue = 0,

            progressEndValue = 50,

            speed = 20;



        let progress = setInterval(() => {

            progressStartValue++;



            progressValue.textContent =

                `${progressStartValue}%`;



            circularProgress.style.background =

                `conic-gradient(#7d2ae8 ${progressStartValue

                * 3.6}deg, #ededed 0deg)`;

            //3.6deg * 100 = 360deg

            //3.6deg * 90 = 324deg





            if (progressStartValue == progressEndValue) {

                clearInterval(progress);



            }

            console.log(progressStartValue);

        }, speed);
    </script>

    <script>
        google.charts.load('current', {
            'packages': ['timeline']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var container = document.getElementById('timeline');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();

            dataTable.addColumn({
                type: 'string',
                id: 'President'
            });
            dataTable.addColumn({
                type: 'date',
                id: 'Start'
            });
            dataTable.addColumn({
                type: 'date',
                id: 'End'
            });
            dataTable.addRows([
                ['Joshua Rivera ', new Date(2024, 1, 30), new Date(2025, 1, 4)],
                ['Dan Mamaid', new Date(2024, 1, 4), new Date(2025, 1, 4)],
                ['Jefferson Dela cruz', new Date(2024, 1, 4), new Date(2025, 1, 4)]
            ]);

            chart.draw(dataTable);
        }
    </script>

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students</p>
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>


</body>

</html>