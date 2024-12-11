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
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <link rel="stylesheet" type="text/css" href="css/Reports.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>


    <!-- <script type="text/javascript" src="js/Reports.js"></script> -->

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
            <a class="active" href="Reports.php"><i class="fa fa-file-text-o"></i>Reports</a>
            <!-- <a href="Details.php">Details</a> -->
        </nav>
    </div>
    <hr class="line_bottom">



    <div class="container2">
        <table class="rwd-table">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>Student Name</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td data-th="#">1</td>
                    <td data-th="Company">NIA</td>
                    <td data-th="Student Name">Joshua Rivera</td>
                    <td data-th="Action">
                        <button class="button-9" onclick="toggleExpand(1)" role="button">View</button>
                        <button class="button-37" onclick="printStudentGraph('Joshua Rivera')" role="button">Print</button>
                        <!-- <button class="button-print" onclick="printStudentGraph('Joshua Rivera')" role="button">Print</button> -->
                    </td>
                </tr>
                <script>
                    google.charts.load("current", {
                        packages: ["bar"]
                    });
                    google.charts.setOnLoadCallback(drawStufftsw);

                    function drawStufftsw() {
                        var datatsw = new google.visualization.arrayToDataTable([
                            ["Opening", "Percentage"],
                            ["Work habit's", 15],
                            ["Work skills'", 20],
                            ["Social skills", 12],
                        ]);

                        var options = {
                            title: "Chess opening moves",
                            legend: {
                                position: "none"
                            },
                            chart: {
                                title: "Overall rating",
                                subtitle: "Work habit, Work skills, Social skills",
                            },
                            bars: "horizontal", // Required for Material Bar Charts.
                            axes: {
                                x: {
                                    0: {
                                        side: "top",
                                        label: "Percentage"
                                    }, // Top x-axis.
                                },
                            },
                            bar: {
                                groupWidth: "50%"
                            },
                        };

                        var chart = new google.charts.Bar(document.getElementById("top_x_div_tsw"));
                        chart.draw(datatsw, options);
                    }

                    function printStudentGraph(studentName) {
                        // Create a new window for printing
                        var printWindow = window.open('', '_blank');
                        printWindow.document.write('<html><head><title>Print</title>');
                        printWindow.document.write('</head><body>');
                        printWindow.document.write('<h2>' + studentName + '</h2>'); // Print student name

                        // Print the graph
                        printWindow.document.write('</body></html>');
                        printWindow.document.close(); // Close the document
                        printWindow.print(); // Trigger print
                        printWindow.close(); // Close the window after printing
                    }

                    // Handle window resize to redraw the chart
                    window.addEventListener("resize", drawStufftsw);
                </script>
                <tr id="expander-row-1">
                    <td colspan="4">
                        <div class="expander-content">
                            <div id="top_x_div_tsw"></div>
                        </div>
                    </td>
                </tr>




            </tbody>
        </table>
    </div>



    <br>

    <footer>
        <!-- <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p> -->
        <p>&copy;2024 Your Website. All rights reserved. | Junior Philippines Computer</p>
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
        // Toggle the display of the expanded content row
        function toggleExpand(rowId) {
            var expanderRow = document.getElementById('expander-row-' + rowId);
            // Check the current display status and toggle it
            if (expanderRow.style.display === "none" || expanderRow.style.display === "") {
                expanderRow.style.display = "table-row";
            } else {
                expanderRow.style.display = "none";
            }
        }
    </script>






</body>

</html>