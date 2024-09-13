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
            <a href="Student.php">Student</a>
            <a class="active" href="Dashboard.php">Analytics</a>
            <a href="Reports.php">Reports</a>
            <!-- <a href="Details.php">Details</a> -->


        </nav>
    </div>
    <hr class="line_bottom">
    </div>

    <div class="Chart">
        <h1>Company Ratings</h1>
        <canvas id="myChart1" class="Chart1"></canvas>
        <h1>Student Population</h1>
        <div id="myChart2" class="Chart2"></div>
    </div>
    <hr class="line_bottom">

    <div class="container2">
        <h1 style="margin-bottom: 20px;">Student Information</h1>
        <table class="rwd-table">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>ID Picture</th>
                    <th>Student Name</th>
                    <th>Strand</th>
                    <th>Ratings</th>
                    <th>Action</th>

                </tr>
                <!-- <div class="dropdown2"> </div> -->
                <tr>
                    <td data-th="#">1</td>
                    <td data-th="ID Picture"><img class="idpic" src="image/me.jpg" alt="me">
                    </td>
                    <td data-th="Student Name">Joshua Rivera</td>
                    <td data-th="Strand">HUMSS</td>
                    <td data-th="Ratings">100%</td>
                    <td data-th="Action">

                        <button onclick="myFunction()" class="button-9" role="button">Result</button>
                        <br>
                        <button class="button-37" role="button">Archive</button>

                    </td>
                </tr>

                <tr>
                    <td data-th="#">2</td>
                    <td data-th="ID Picture"><img class="idpic" src="image/profile.jpg" alt="me"></td>
                    <td data-th="Student Name">Dan Mamaid</td>
                    <td data-th="Strand">STEM</td>
                    <td data-th="Ratings">99%</td>
                    <td data-th="Action">
                        <button onclick="myFunction()" class="button-9" role="button">Result</button><br>
                        <button class="button-37" role="button">Archive</button>
                    </td>
                </tr>
                <!-- <tr>
                    <td data-th="#">3</td>
                    <td data-th="Company">BOX Pro West</td>
                    <td data-th="Student Name">Ronald Diaz</td>
                    <td data-th="Action"><button id="myBtn" class="button-9" role="button">View</button><br>
                        <button class="button-37" role="button">Archive</button>
                    </td>
                </tr>
                <tr>
                    <td data-th="#">4</td>
                    <td data-th="Company">Pan Providers and Co.</td>
                    <td data-th="Student Name">Raniel Cruz</td>
                    <td data-th="Action"><button id="myBtn" class="button-9" role="button">View</button><br>
                        <button class="button-37" role="button">Archive</button>
                    </td>
                </tr> -->
            </tbody>

        </table>
        <!-- <h3>Resize Me</h3> -->
    </div>


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
    /* When the user clicks on the button, 
                                                                                                                                                                                    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.button-9')) {
            var dropdowns = document.getElementsByClassName("dropdown2-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
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
                'font-size': 100
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
            ['Strand', 'Mhl'],
            ['STEM', 54.8],
            ['HUMSS', 48.6],
            ['GAS', 44.4],
            ['ABM', 23.9],
            ['TECHVOC', 14.5]
        ]);


        // Set Options
        const options = {
            title: 'Result',
            is3D: true,
            'width': 600,
            'height': 300

        };


        // Draw
        const chart = new google.visualization.PieChart(document.getElementById('myChart2'));
        chart.draw(data, options);

    }
    </script>

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students</p>
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>


</body>

</html>