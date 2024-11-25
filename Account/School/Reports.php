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

                        <button id="myBtn" class="button-9" onclick="toggleExpand(1)" role="button">View</button>

                        <button class="button-37" role="button">Archive</button>
                    </td>
                </tr>
                <tr id="expander-row-1" style="display:none;">
                    <td colspan="4">
                        <div class="expander-content">
                            <p>This is the expanded content! It can be any HTML element, like text, images, etc.</p>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td data-th="#">2</td>
                    <td data-th="Company">UPS South Inc.</td>
                    <td data-th="Student Name">Dan Mamaid</td>
                    <td data-th="Action"><button id="myBtn" class="button-9" onclick="toggleExpand(2)"
                            role="button">View</button>
                        <button class="button-37" role="button">Archive</button>
                    </td>


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

    <!-- <script>
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
    </script> -->

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
    <!-- <script>
    function toggleExpand() {
        const content = document.querySelector('.expander-content');
        // Toggle visibility of the content
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block";
        } else {
            content.style.display = "none";
        }
    }
    </script> -->


</body>

</html>