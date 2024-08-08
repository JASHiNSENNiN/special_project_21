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
    <link rel="stylesheet" type="text/css" href="css/Reports.css">
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
            <a href="Company.php">Work Immersion List</a>
            <!-- <a href="#.php">Company</a> -->
            <a href="Student.php">Student</a>
            <a href="Dashboard.php">Analytics</a>
            <a class="active" href="Reports.php">Reports</a>
            <a href="Details.php">Details</a>


        </nav>
    </div>
    <hr class="line_bottom">



    <div class="container2">
        <!-- <h1>HUMSS</h1> -->
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
                        <!-- <a href="#" id="myBtn" class="btn-4d-can"><span>View</span></a> -->
                        <button id="myBtn" class="button-9" role="button">View</button>
                        <div id="myModal" class="modal">
                            <!-- Modal content -->
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <img src="image/evaluation.png" alt="" width="1100" height="1400">
                            </div>

                        </div><br>
                        <button class="button-37" role="button">Archive</button>
                    </td>
                </tr>
                <tr>
                    <td data-th="#">2</td>
                    <td data-th="Company">UPS South Inc.</td>
                    <td data-th="Student Name">Dan Mamaid</td>
                    <td data-th="Action"><button id="myBtn" class="button-9" role="button">View</button>
                        <button class="button-37" role="button">Archive</button>
                    </td>
                </tr>
                <tr>
                    <td data-th="#">3</td>
                    <td data-th="Company">BOX Pro West</td>
                    <td data-th="Student Name">Ronald Diaz</td>
                    <td data-th="Action"><button id="myBtn" class="button-9" role="button">View</button>
                        <button class="button-37" role="button">Archive</button>
                    </td>
                </tr>
                <tr>
                    <td data-th="#">4</td>
                    <td data-th="Company">Pan Providers and Co.</td>
                    <td data-th="Student Name">Raniel Cruz</td>
                    <td data-th="Action"><button id="myBtn" class="button-9" role="button">View</button>
                        <button class="button-37" role="button">Archive</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- <h3>Resize Me</h3> -->
    </div>



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


</body>

</html>