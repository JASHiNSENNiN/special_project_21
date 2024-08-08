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
    <link rel="stylesheet" type="text/css" href="css/Student.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
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
            <a class="active1" href="Student.php">Student</a>
            <a href="Dashboard.php">Analytics</a>
            <a href="Reports.php">Reports</a>
            <!-- <a href="Details.php">Details</a> -->


        </nav>
    </div>
    <hr class="line_bottom">


    <br>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <div class="container">
        <div class="box" id="#humss">
            <span class="material-symbols-outlined">
                balance
            </span>
            <p>Humss</p>
        </div>
        <div class="box" id="#stem">
            <span class="material-symbols-outlined">
                experiment
            </span>
            <p>Stem</p>
        </div>
        <div class="box" id="#gas">
            <span class="material-symbols-outlined">
                menu_book
            </span>
            <p>Gas</p>
        </div>
        <div class="box" id="#techvoc">
            <span class="material-symbols-outlined">
                construction
            </span>
            <p>TechVOc</p>
        </div>
    </div>

    <div id="content_container">
        <div id="humss" class="content active">
            <div class="container2">
                <h1>HUMSS</h1>
                <table class="rwd-table">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>Start End</th>
                        </tr>
                        <tr>
                            <td data-th="#">1</td>
                            <td data-th="Name">Renata French</td>
                            <td data-th="Company">NIA</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2024</td>
                            <td data-th="Start End">12/30/2024</td>
                        </tr>
                        <tr>
                            <td data-th="#">2</td>
                            <td data-th="Name">Juelz Adkins</td>
                            <td data-th="Company">PNP</td>
                            <td data-th="Status">Pending</td>
                            <td data-th="Start Date">0/0/2024</td>
                            <td data-th="Start End">0/0/2024</td>
                        </tr>
                        <tr>
                            <td data-th="#">3</td>
                            <td data-th="Name">Navy Meza</td>
                            <td data-th="Company">Landbank</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2024</td>
                            <td data-th="Start End">12/30/2024</td>
                        </tr>
                        <tr>
                            <td data-th="#">4</td>
                            <td data-th="Name">Rylan Hammond</td>
                            <td data-th="Company">Carmel</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/1/2024</td>
                            <td data-th="Start End">12/10/2024</td>
                        </tr>
                    </tbody>
                </table>
                <!-- <h3>Resize Me</h3> -->
            </div>
        </div>

        <div id="stem" class="content">
            <div class="container2">
                <h1>STEM</h1>
                <table class="rwd-table">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>Start End</th>
                        </tr>
                        <tr>
                            <td data-th="#">1</td>
                            <td data-th="Name">Della Morse</td>
                            <td data-th="Company">BDO</td>
                            <td data-th="Status">Pending</td>
                            <td data-th="Start Date">0/0/2016</td>
                            <td data-th="Start End">0/0/2016</td>
                        </tr>
                        <tr>
                            <td data-th="#">2</td>
                            <td data-th="Name">Jerry Fischer</td>
                            <td data-th="Company">NIA</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2016</td>
                            <td data-th="Start End">06/25/2016</td>
                        </tr>
                        <tr>
                            <td data-th="#">3</td>
                            <td data-th="Name">Gabriela Carlson</td>
                            <td data-th="Company">Sr. Product Designer</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2016</td>
                            <td data-th="Start End">06/25/2016</td>
                        </tr>
                        <tr>
                            <td data-th="#">4</td>
                            <td data-th="Name">Demetrius Pollard</td>
                            <td data-th="Company">User Experience Designer</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2016</td>
                            <td data-th="Start End">06/25/2016</td>
                        </tr>
                    </tbody>
                </table>
                <!-- <h3>Resize Me</h3> -->
            </div>
        </div>

        <div id="gas" class="content">
            <div class="container2">
                <h1>GAS</h1>
                <table class="rwd-table">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>Start End</th>
                        </tr>
                        <tr>
                            <td data-th="#">1</td>
                            <td data-th="Name">Paxton Bennett</td>
                            <td data-th="Company">Pico Bank</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2024</td>
                            <td data-th="Start End">06/25/2024</td>
                        </tr>
                        <tr>
                            <td data-th="#">2</td>
                            <td data-th="Name">Maryam Hurst</td>
                            <td data-th="Company">OLSCHO</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2024</td>
                            <td data-th="Start End">06/25/2024</td>
                        </tr>
                        <tr>
                            <td data-th="#">3</td>
                            <td data-th="Name">Ali Lewis</td>
                            <td data-th="Company">PNP</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2024</td>
                            <td data-th="Start End">06/25/2024</td>
                        </tr>
                        <tr>
                            <td data-th="#">4</td>
                            <td data-th="Name">Municipal</td>
                            <td data-th="Company">Product Designer</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2024</td>
                            <td data-th="Start End">06/25/2024</td>
                        </tr>
                    </tbody>
                </table>
                <!-- <h3>Resize Me</h3> -->
            </div>
        </div>

        <div id="techvoc" class="content">
            <div class="container2">
                <h1>TECVOC</h1>
                <table class="rwd-table">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>Start End</th>
                        </tr>
                        <tr>
                            <td data-th="#">1</td>
                            <td data-th="Name">Jovanni Daniel</td>
                            <td data-th="Company">Pico Bank</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2024</td>
                            <td data-th="Start End">06/25/2024</td>
                        </tr>
                        <tr>
                            <td data-th="#">2</td>
                            <td data-th="Name">Ella Haynes</td>
                            <td data-th="Company">Pico Bank</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2024</td>
                            <td data-th="Start End">06/25/2024</td>
                        </tr>
                        <tr>
                            <td data-th="#">3</td>
                            <td data-th="Name">Dorian Buckley</td>
                            <td data-th="Company">Pico Bank</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2024</td>
                            <td data-th="Start End">06/25/2024</td>
                        </tr>
                        <tr>
                            <td data-th="#">4</td>
                            <td data-th="Name">Margot Todd</td>
                            <td data-th="Company">Pico Bank</td>
                            <td data-th="Status">Deployed</td>
                            <td data-th="Start Date">12/25/2024</td>
                            <td data-th="Start End">06/25/2024</td>
                        </tr>
                    </tbody>
                </table>
                <!-- <h3>Resize Me</h3> -->
            </div>
        </div>
    </div>


    <script>
    $(".box").click(function(e) {
        e.preventDefault();
        $(".content").removeClass("active");
        var content_id = $(this).attr("id");
        $(content_id).addClass("active");
    });
    </script>
    <br>
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

    <!-- <div class="sub-footer">
        2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students
    </div> -->


</body>

</html>