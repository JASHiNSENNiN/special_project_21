<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/job_request.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->


    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet '>


</head>

<body>

    <header class="nav-header">
        <div class="logo">
            <a href="#">
                <img src="image/logov3.jpg" alt="Logo">
            </a>
        </div>

        <nav class="by">
            <a href=""><i class='fas fa-comment-alt' style='font-size:24px; margin-top:5px;'></i></a>
            <a href=""><i class='fas fa-bell' style='font-size:24px; margin-top:5px;'></i></a>

            <div class="dropdown" style="float:right;">
                <a href=""><i class='fas fa-user-alt' style='font-size:24px;  margin-top:5px;'></i></a>
                <div class="dropdown-content">
                    <div class="email">upriis.division6@nia.gov.ph</div>
                    <a href="#"><i class='fas fa-user-alt' style='font-size:24px; margin-right:10px;'></i> My
                        Profile</a>
                    <a href=""><i class='fas fa-bookmark' style='font-size:24px; margin-right:10px;'></i> My Jobs</a>
                    <a href="#"> <i class='fas fa-comment-alt' style='font-size:24px;margin-right:10px;'></i>My
                        Reviews</a>
                    <a href="Settings.php"><i class="fa fa-gear" style="font-size:24px"></i> Settings</a>
                    <hr>
                    <div class="foot">&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer
                        Society Students
                    </div>
                    <hr>
                    <a class="logout" href="#"> Log out</a>
                </div>
            </div>
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <!-- <a class="login-btn" href="#" style="margin-left: 20px;">Log out</a> -->
        </nav>
    </header>


    <img class="logoimg" id="cover-pic" src="image/background.jpg" alt="" height="300" width="200">
    <label for="input-file1" class="button-13" role="button"><span class="edit"><i class="fa fa-camera"></i>Edit cover
            photo</span>
        <span class="cam"><i class="fa fa-camera"></i></span></label>
    <input type="file" accept="image/jpeg, image/png, image/gif" id="input-file1" />

    <div class="profile">
        <img id="profile-pic" src="image/NIA.png" alt="">
        <div class="name">National Irrigation Administration</div>
        <label class="strand" for="">NIA</label>

        <div class="Settings"><label for="input-file2" class="button-12" role="button"><span class="edit"><i class="fa fa-pencil"></i> Edit
                    profile</span><span class="pen"><i class="fa fa-pencil"></i></span></label>
            <input type="file" accept="image/jpeg, image/png, image/gif" id="input-file2" />
        </div><br>
    </div>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Details.php">Snapshot</a>
            <!-- <a href="Job_ads.php"> Job Ads</a> -->
            <a class="active" href="Job_request.php">Job Request</a>
            <a href="Faculty_report.php">Faculty Report</a>
            <!-- <a href="Details.php">Details</a> -->


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
                        <button type="button" class="button-4">Details</button>
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