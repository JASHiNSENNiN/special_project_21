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
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->
    <link rel="stylesheet" type="text/css" href="css/Dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/analytics.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <!-- Include the Data Labels plugin -->
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
            <a href="Student.php"><i class="fas fa-user-graduate"></i>Student</a>
            <a class="active" href="Dashboard.php"><i class="fa fa-bar-chart"></i>Analytics</a>
            <a href="Reports.php"><i class="fa fa-file-text-o"></i>Reports</a>


        </nav>
    </div>
    <hr class="line_bottom">
    </div>
    <!-- <h1 class="title">Total of Student Deployment</h1>

    <div class="box-container">

        <div class="box">Box 1</div>
        <div class="box">Box 2</div>
        <div class="box">Box 3</div>
        <div class="box">Box 4</div>
    </div> -->

    <div class="container4">
        <h1 class="Time">Student Ranking</h1>
        <div id="curve_chart" style="height: auto;"></div>
    </div>

    <div class="row">
        <div class="column">
            <h1 class="title">Top Student</h1>
            <canvas id="myChart1" class="Chart1"></canvas>
        </div>
        <div class="column">
            <h1 class="title">Student Population</h1>
            <div id="myChart2" class="Chart2"></div>
        </div>
        <div class="column">
            <h1 class="title">Top 6 Company</h1>
            <canvas id="myHorizontalBarChart"></canvas>
        </div>
        <div class="column">
            <h1 class="title">Company list</h1><br>
            <div id="table_div"></div>
        </div>
    </div>



    <hr class="line_bottom">




    <br>
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

    <script>
        // JSON object for the chart data and configuration
        const chartData = {
            "data": {
                "labels": ['Jollibee', 'Mcdo', 'Inasal', 'BDO', 'Lamart', 'PNP'], // X-axis labels
                "datasets": [{
                    "label": "Data",
                    "data": [50, 100, 75, 150, 200, 250], // Y-axis values
                    "backgroundColor": 'rgb(31, 69, 41,0.8)', // Bar color
                    "borderColor": 'rgb(31, 69, 41,)', // Border color
                    "borderWidth": 1
                }]
            },
            "config": {
                "type": "bar",
                "options": {
                    "responsive": true,
                    "indexAxis": "y", // Make it a horizontal bar chart
                    "scales": {
                        "x": {
                            "beginAtZero": true, // Ensure the x-axis starts at zero
                            "title": {
                                "display": true,
                                "text": "Data"
                            }
                        },
                        "y": {
                            "title": {
                                "display": true,
                                "text": "Months"
                            }
                        }
                    },
                    "plugins": {
                        "datalabels": {
                            "align": 'center', // Position data labels inside the bar, centered
                            "anchor": 'center', // Anchor the text inside the bar
                            "formatter": (value, context) => {
                                // Calculate the percentage for each bar
                                const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                const percentage = ((value / total) * 100).toFixed(
                                    1); // Calculate percentage with 1 decimal
                                const label = context.chart.data.labels[context
                                    .dataIndex]; // Get the label (month name)
                                return `${label}: ${percentage}%`; // Return both name and percentage
                            },
                            "color": 'white', // Text color for labels
                            "font": {
                                "weight": 'bold',
                                "size": 14
                            }
                        }
                    }
                }
            }
        };

        // Sort the data by sales in descending order
        const sortedData = chartData.data.datasets[0].data
            .map((value, index) => ({
                value,
                label: chartData.data.labels[index]
            })) // Combine sales data with labels
            .sort((a, b) => b.value - a.value); // Sort by sales in descending order

        // Update the chart data with sorted values
        chartData.data.labels = sortedData.map(item => item.label); // Sorted month labels
        chartData.data.datasets[0].data = sortedData.map(item => item.value); // Sorted sales data

        // Render the chart using the updated sorted data
        const ctx = document.getElementById('myHorizontalBarChart').getContext('2d');
        new Chart(ctx, {
            type: chartData.config.type,
            data: chartData.data,
            options: chartData.config.options
        });
    </script>
    <script>
        const xValues = ["Joshua Olipas", "Ronald Dagdag", "Dan Dela cruz", "John Ric Revira", "Raniel Santos"];
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


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Day', 'Joshua Rivera', 'Ronald Olipas'],
                ['1', 50, 60],
                ['2', 20, 10],
                ['3', 40, 25],
                ['4', 30, 45],
                ['5', 30, 45]
            ]);

            var options = {
                // title: 'Company Performance',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['table']
        });
        google.charts.setOnLoadCallback(drawTable);

        function drawTable() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Company Name');
            // data.addColumn('number', 'Ratings');
            // data.addColumn('boolean', 'Full Time Employee');
            data.addRows([
                ['PNP'],
                ['Lamart'],
                ['BDO'],
                ['Mcdo'],
                ['Inasal'],
                ['Jollibee'],
                ['Kuya J']

            ]);

            var table = new google.visualization.Table(document.getElementById('table_div'));

            table.draw(data, {
                showRowNumber: true,
                width: '100%',
                height: '100%'
            });
        }
    </script>
    <!-- <script>
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
                ['Joshua Rivera ', new Date(2024, 1, 8), new Date(2024, 12, 8)],
                ['Dan Mamaid', new Date(2024, 1, 8), new Date(2024, 13, 8)],
                ['Jefferson Dela cruz', new Date(2024, 1, 8), new Date(2024, 14, 8)]
            ]);

            chart.draw(dataTable);
        }
    </script> -->

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
        <!-- <p>&copy;2024 Your Website. All rights reserved. | Junior Philippines Computer</p> -->
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>


</body>

</html>