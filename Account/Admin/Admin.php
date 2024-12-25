<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- <link rel="stylesheet" type="text/css" href="header.css"> -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" type="x-icon" href="image/W.png">

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

            <!-- <div class="dropdown" style="float:right;">
                <button class="dropbtn"><i class="fa fa-sign-out"></i></button>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </div> -->
            <a href="" style="margin-top:5px;">Admin</a>
            <!-- <a class="dropbtn" href=""><i class='fas fa-user-alt' style='font-size:2px; color: black;'></i></a> -->
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <div class="dropdown" style="float:right;">
                <a class="login-btn" href="#" style="margin-left: 20px;"><span class="text"><i class="fa fa-gear"
                            style="font-size:24px"></i></span></a>
                <div class="dropdown-content">
                    <!-- <a href="#"><i class="fa fa-gear" style="font-size:24px; margin-right:10px;"></i>Settings</a> -->
                    <a href="#"><i class="fa fa-sign-out"
                            style="font-size:24px; margin-right:10px; margin-top:5px;"></i>Sign out</a>
                </div>
            </div>
        </nav>
    </header>

    <br>
    <!-- <div class="logo">

        <nav style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"> Job Ads</a>
            <a href="Job_request.php">Job Request</a>
            <a href="Faculty_report.php">Faculty Report</a>
            <a href="Details.php">Details</a>


        </nav>
    </div> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <div class="container1">
        <div class="box" id="#student">
            <h1><i class='fas fa-user-graduate' style='font-size:36px;margin-right:10px;'></i>Student</h1>
            <h1>1</h1>
            <p class="Total">Total</p>
        </div>
        <div class="box" id="#school">
            <h1><i class='fas fa-school' style='font-size:36px;margin-right:10px;'></i>School</h1>
            <h1>1</h1>
            <p class="Total">Total</p>
        </div>
        <div class="box" id="#company">
            <h1><i class='fas fa-building' style='font-size:36px;margin-right:10px;'></i>Company</h1>
            <h1>1</h1>
            <p class="Total">Total</p>
        </div>
        <!-- <div class="box" id="#techvoc">
            <span class="material-symbols-outlined">
                construction
            </span>
            <p>TechVOc</p>
        </div> -->
    </div>
    <br><br>
    <div id="content_container">
        <div id="student" class="content active">
            <div class="container2">
                <table class="rwd-table">
                    <tbody id="studentTableBody1">
                        <tr>
                            <th>#</th>
                            <!-- <th>ID Picture</th> -->
                            <th>Student Name</th>
                            <th>School</th>
                            <th>Action</th>

                        </tr>

                        <tr>
                            <td data-th='#'>1</td>
                            <td data-th='Student Name'>Juan Dela cruz</td>
                            <td data-th='School'>OLSHCO</td>
                            <td data-th='Action'><button class="button-3" role="button"><i class="fa fa-check"
                                        style="font-size:15px"></i></button>
                                <button class="button-5" role="button"><i class='fas fa-user-alt'
                                        style='font-size:15px'></i></button>
                                <button class="button-4" role="button"><i class="fa fa-archive"
                                        style="font-size:15px"></i></button>
                            </td>
                        </tr>


                    </tbody>

                </table>
            </div>
        </div>
        <div id="school" class="content">
            <div class="container2">
                <table class="rwd-table">
                    <tbody id="studentTableBody1">
                        <tr>
                            <th>#</th>
                            <!-- <th>ID Picture</th> -->
                            <th>School Name</th>
                            <th>School Number</th>
                            <th>Address</th>
                            <th>Action</th>

                        </tr>

                        <tr>
                            <td data-th='#'>1</td>
                            <!-- <td data-th='ID Picture'></td> -->
                            <td data-th='School Name'>OLSHCO</td>
                            <td data-th='School Number'>12252024</td>
                            <td data-th='Address'>Guimba</td>
                            <td data-th='Action'><button class="button-3" role="button"><i class="fa fa-check"
                                        style="font-size:15px"></i></button>
                                <button class="button-5" role="button"><i class='fas fa-user-alt'
                                        style='font-size:15px'></i></button>
                                <button class="button-4" role="button"><i class="fa fa-trash-o"
                                        style="font-size:15px"></i></button>
                            </td>
                        </tr>


                    </tbody>

                </table>
            </div>
        </div>
        <div id="company" class="content">
            <div class="container2">
                <table class="rwd-table">
                    <tbody id="studentTableBody1">
                        <tr>
                            <th>#</th>
                            <th>Company Name</th>
                            <!-- <th>Business Permit</th> -->
                            <th>Address</th>
                            <th>Action</th>

                        </tr>

                        <tr>
                            <td data-th='#'>1</td>
                            <td data-th='Company Name'>Jollibee</td>
                            <!-- <td data-th='Bussiness Permit'> <img id="image" src="image/permit.png" alt=""></td> -->
                            <td data-th='Address'>Guimba</td>
                            <td data-th='Action'><button class="button-3" role="button"><i class="fa fa-check"
                                        style="font-size:15px"></i></button>
                                <button class="button-5" role="button"><i class='fas fa-user-alt'
                                        style='font-size:15px'></i></button>
                                <button class="button-4" role="button"><i class="fa fa-trash-o"
                                        style="font-size:15px"></i></button>
                            </td>
                        </tr>


                    </tbody>

                </table>
            </div>
        </div>

    </div>


    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <form action="" method="POST" class="form">
        <div class="container">
            <input type="text" name="name" required>
            <input type="email" name="email" required>
            <button type="submit" onclick="validation();" class="btn"> Submit</button>


        </div>
    </form> -->
    <!-- <div class="buttons">
        <button onclick="showToast(successMsg)">Success</button>
        <button onclick="showToast(errorsMsg )">Error</button>
        <button onclick="showToast(invalidMsg )">Invalid</button>
    </div> -->
    <!-- 
    <div id="toastBox">

    </div> -->

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

    <script>
        $(".box").click(function (e) {
            e.preventDefault();
            $(".content").removeClass("active");
            var content_id = $(this).attr("id");
            $(content_id).addClass("active");
        });
    </script>




    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students</p>
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>


</body>

</html>