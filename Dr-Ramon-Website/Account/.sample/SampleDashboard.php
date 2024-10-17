<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- <link rel="stylesheet" type="text/css" href="header.css"> -->
    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/039e1072b5.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        <nav>

            <div class="dropdown" style="float:right;">
                <button class="dropbtn"><i class="fa fa-sign-out"></i></button>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </div>
            <a class="dropbtn" href=""><i class='fas fa-user-alt' style='font-size:2px; color: black;'></i></a>
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="login-btn" href="#" style="margin-left: 20px;"><span class="text">Log out</span></a>
        </nav>
    </header>


    <img class="logoimg" src="image/background.jpg" alt="" height="300" width="200">

    <div class="profile">
        <img src="image/me.jpg" alt="">
        <div class="name">National Irrigation Administration</div>
        <label class="strand" for="">NIA</label>
        <div class="Settings"><button> Edit Profile</button></div>
    </div><br>
    <hr>
    <div class="logo">

        <nav style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"> Job Ads</a>
            <a href="Job_request.php">Job Request</a>
            <a href="Faculty_report.php">Faculty Report</a>
            <a href="Details.php">Details</a>


        </nav>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <form action="" method="POST" class="form">
        <div class="container">
            <input type="text" name="name" required>
            <input type="email" name="email" required>
            <button type="submit" onclick="validation();" class="btn"> Submit</button>

            <!-- <div class="popup" id="popup">
                <img src="image/404-tick.png" alt="">
                <h2>Thank You!</h2>
                <p> Your details has been successfully submitted. Thanks!</p>
                <button type="submit" onclick="closePopup()">OK</button>
            </div> -->

        </div>
    </form>
    <div class="buttons">
        <button onclick="showToast(successMsg)">Success</button>
        <button onclick="showToast(errorsMsg )">Error</button>
        <button onclick="showToast(invalidMsg )">Invalid</button>
    </div>

    <div id="toastBox">

    </div>

    <script>
    let toastBox = document.getElementById('toastBox');
    let successMsg = '<i class="fa fa-check-circle"></i> Successfully submitted'
    let errorsMsg = '<i class="fa fa-times-circle"></i> Please fix the error!'
    let invalidMsg = '<i class="fa fa-exclamation-circle"></i> Invalid input, check again'

    function showToast(msg) {
        let toast = document.createElement('div');
        toast.classList.add('toast');
        toast.innerHTML = msg;
        toastBox.appendChild(toast);

        if (msg.includes('error')) {
            toast.classList.add('error');
        }
        if (msg.includes('Invalid')) {
            toast.classList.add('Invalid');
        }

        setTimeout(() => {
            toast.remove();
        }, 6000);
    }
    </script>

    <script>
    function validation() {
        Swal.fire({
            title: "Successfully send!",
            text: "You clicked the button!",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
        });

        // Swal.fire({
        //     icon: "error",
        //     title: "Oops...",
        //     text: "Something went wrong!",
        //     footer: '<a href="#">Why do I have this issue?</a>'
        // });
    }
    </script>
    <!-- <script>
    $(document).ready(function() {
        $('.form').on('submit', function() {
            // alert('Your details were successfully received.');
            Swal.fire({
                title: "Good job!",
                text: "You clicked the button!",
                icon: "success"
            });
        });
    });
    </script> -->

    <br>


    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students</p>
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>


</body>

</html>