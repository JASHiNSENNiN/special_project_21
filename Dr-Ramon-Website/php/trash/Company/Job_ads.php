<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/job_ads.css">

    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.core.css">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>


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


    <img class="logoimg" src="image/background.jpg" alt="" height="300" width="200">
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
            <!-- <a class="active" href="Job_ads.php"> Job Ads</a> -->
            <a href="Job_request.php">Job Request</a>
            <a href="Faculty_report.php">Faculty Report</a>
            <!-- <a href="Details.php">Details</a> -->


        </nav>
    </div>
    <hr class="line_bottom">


    <br>

    <div class="sales-boxes">
        <div class="recent-sales box">
            <b>
                <!-- <div class="box-topic" style="margin-left: 20px;">Post a Job ad for free </div> -->
            </b>

            <!-- <div class="title">Popularity Company </div> -->
            <!-- <div class="title">Student List <div class="icon"><i class="bx bx-user-plus"></i> </div> </div> -->

            <form action="">
                <div class="container">
                    <h1>Post a Job ads</h1>
                    <p>Please fill in this form to create an job.</p>
                    <hr>

                    <label for="worktitle"><b>Work Title</b></label>
                    <input type="text" placeholder="" name="" id="" required>

                    <label for="date"><b>Expected Job Start date</b></label><br>
                    <input type="date" placeholder="DD/MM/YY" name="" id="" required>

                    <label for=""><b>Chooce a Strand:</b></label><br>
                    <label class="con">STEM
                        <input type="checkbox" checked="checked">
                        <span class="checkmark"></span>
                    </label>
                    <label class="con">GAS
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="con">HUMSS
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="con">TECHVOC
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>

                    <h1>Job Description</h1>
                    <hr>
                    <div id="editor-container">
                    </div>


                    <!-- <label for="job"><b>Job Description</b></label><br>
                    <textarea type="textarea" name="" id="textarea"></textarea> -->
                    <hr>

                    <p>By creating job ads you agree to our <a href="#">Terms & Privacy</a>.</p>
                    <button class="button-9" role="button">Submit</button>
                    <!-- <button type="submit" class="registerbtn"></button> -->
                </div>

            </form>
            <!-- <div class="button">
                        <a href="#">See All</a>
                    </div> -->
        </div>


    </div>


    <script src="css/doc.js"></script>

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