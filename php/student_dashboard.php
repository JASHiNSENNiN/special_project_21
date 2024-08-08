<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Student Dashboard</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" type="text/css" href="../css/student_student_dashboard.css">
    <link rel="stylesheet" href="../css/profile_settings.css">
    <link rel="stylesheet" href="../js/chart.js" type="text/Javascript">
    <!-- <link rel="stylesheet" type="text/css" href="../css/school_dashboard.css"> -->
    <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet '>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <div class="sidebar">
        <div class="logo-details">

            <a href="#" class="active" style='text-decoration:none'>
                <i><img src="logo.png" alt="Logo" height="50" style="margin-left:5px; margin-top:15px;">
                </i>

            </a>
            <span class="logo_name" id="logo_name" style="color:#fff; margin-left: 80px;">Workify</span>
        </div>
        <br>
        <ul class="nav-links">
            <li>
                <a href="#" class="link" id="#company">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Company Area</span>
                </a>
            </li>
            <li>
                <a href="#" class="link" id="#narrative">
                    <i class='bx bx-paperclip'></i>
                    <span class="links_name">Narrative Report</span>
                </a>
            </li>

            <li>
                <a href="#" class="link" id="#setting">
                    <i class='bx bx-cog'></i>
                    <span class="links_name">Setting</span>
                </a>
            </li>
            <li class="log_out">
                <a href="#">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn' onclick="toggle();"></i>
                <span class="dashboard"></span>
                <span class="dashboard"> </span>
                <span class="dashboard">Dashboard</span>

            </div>
            <!-- <div class="search-box">
                <input type="text" placeholder="Search...">
                <i class='bx bx-search'></i>
            </div> -->


            <div class="profile-details">
                <img src="image/me.jpg" alt="">
                <span class="admin_name">Natividad, Miguel Von A.</span>
                <i class='bx bx-chevron-down'></i>
            </div>

        </nav>



        <div class="home-content">


            <div id="content_container">
                <div id="company" class="content active">
                    <div class="container">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                    One of three columns
                                </div>
                                <div class="col-sm">
                                    <div class="search-box">
                                        <input type="text" placeholder="Search..." style="margin-top:50px; width:100%">
                                        <i class='bx bx-search'></i>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    One of three columns
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <div class="mobile-wrapper">
                                    <article class="job-card">
                                        <div class="company-logo-img">
                                            <img src="image/NIA.png" />
                                        </div>
                                        <div class="job-title">The National Irrigation Administration</div>
                                        <!-- <div class="company-name">Hays</div> -->
                                        <div class="skills-container">
                                            <div class="skill">Planter</div>
                                            <div class="skill">Assistant</div>
                                            <div class="skill">Computer</div>
                                        </div>
                                        <div class="btn-container">
                                            <button class="apply">Apply</button>
                                            <button class="save">Save Job</button>
                                        </div>
                                        <a href="#"></a>
                                    </article>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="mobile-wrapper">
                                    <article class="job-card">
                                        <div class="company-logo-img">
                                            <img src="image/Jollibee.png" />
                                        </div>
                                        <div class="job-title">Jollibee</div>
                                        <!-- <div class="company-name">Hays</div> -->
                                        <div class="skills-container">
                                            <div class="skill">Crew</div>
                                            <div class="skill">Assistant</div>
                                            <div class="skill">Guard</div>
                                        </div>
                                        <div class="btn-container">
                                            <button class="apply">Apply</button>
                                            <button class="save">Save Job</button>
                                        </div>
                                        <a href="#"></a>
                                    </article>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="mobile-wrapper">
                                    <article class="job-card">
                                        <div class="company-logo-img">
                                            <img src="image/landbank.jpg" />
                                        </div>
                                        <div class="job-title">LANBANK</div>
                                        <div class="skills-container">
                                            <div class="skill">Bookkeeper</div>
                                            <div class="skill">Assistant</div>
                                            <div class="skill">IT specialist</div>
                                        </div>
                                        <div class="btn-container">
                                            <button class="apply">Apply</button>
                                            <button class="save">Save Job</button>
                                        </div>
                                        <a href="#"></a>
                                    </article>
                                </div>
                            </div>

                        </div>
                    </div>



                </div>
                <div id="narrative" class="content">

                    <div class="sales-boxes">
                        <div class="recent-sales box" style="width: 90%;">
                            <b>
                                <div class="box-topic">Narrative Report</div>
                            </b>
                            <br>

                            <label for="studentid">Company name</label> <br>
                            <input type="text" placeholder="Enter Company name" name="studentid" id="studentid" required>
                            <!-- <div class="title">Popularity Company </div> -->
                            <!-- <div class="title">Student List <div class="icon"><i class="bx bx-user-plus"></i> </div> </div> -->

                            <table style="width:100%">
                                <!-- <tr>
                                    <th>#</th>
                                    <th>Company</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr> -->
                                <tr>
                                    <td>5</td>
                                    <td>Outstanding</td>
                                    <td>Perform exceeds the required standard.</td>

                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Very Satisfactory</td>
                                    <td>Performace fully met job requirements. Was able to perform what was expected
                                        of
                                        a person in his/her position.</td>


                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Satisfactory</td>
                                    <td>Performance has met the required standard. Can perform duties with minimal
                                        supervision.</td>


                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Fair</td>
                                    <td>Performace partially meet the required stantard. Less than satisfactory
                                        could be
                                        doind better.</td>


                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Needs Improvement</td>
                                    <td>Performance does not meet the required standard. Major improvements needed.
                                    </td>
                                    <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                        <button type="button" class="btn btn-primary">Details</button>
                                    </td> -->

                                </tr>
                            </table>
                            <br>
                            <form action="">
                                <div class="container">
                                    <h3>Evaluation </h3>
                                    <p>Please fill in this evaluation form.</p>
                                    <hr>

                                    <table style="width:100%">
                                        <tr>
                                            <th>#</th>
                                            <th>Questioner</th>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Consistently works with others to accomplish goals and tasks. </td>
                                            <td><input type="checkbox" name="fooby[1][]"></td>
                                            <td><input type="checkbox" name="fooby[1][]"></td>
                                            <td><input type="checkbox" name="fooby[1][]"></td>
                                            <td><input type="checkbox" name="fooby[1][]"></td>
                                            <td><input type="checkbox" name="fooby[1][]"></td>

                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Treats all team members in a respectful courteous manner.</td>
                                            <td><input type="checkbox" name="fooby[2][]"></td>
                                            <td><input type="checkbox" name="fooby[2][]"></td>
                                            <td><input type="checkbox" name="fooby[2][]"></td>
                                            <td><input type="checkbox" name="fooby[2][]"></td>
                                            <td><input type="checkbox" name="fooby[2][]"></td>

                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Actively participates in activities and assigned tasks required.
                                            </td>
                                            <td><input type="checkbox" name="fooby[3][]"></td>
                                            <td><input type="checkbox" name="fooby[3][]"></td>
                                            <td><input type="checkbox" name="fooby[3][]"></td>
                                            <td><input type="checkbox" name="fooby[3][]"></td>
                                            <td><input type="checkbox" name="fooby[3][]"></td>

                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Willing to work with team members to improve team collaboration on
                                                continuous basis.</td>
                                            <td><input type="checkbox" name="fooby[4][]"></td>
                                            <td><input type="checkbox" name="fooby[4][]"></td>
                                            <td><input type="checkbox" name="fooby[4][]"></td>
                                            <td><input type="checkbox" name="fooby[4][]"></td>
                                            <td><input type="checkbox" name="fooby[4][]"></td>

                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Considers the feedback and views of team members when completing an
                                                assigned task. </td>
                                            <td><input type="checkbox" name="fooby[5][]"></td>
                                            <td><input type="checkbox" name="fooby[5][]"></td>
                                            <td><input type="checkbox" name="fooby[5][]"></td>
                                            <td><input type="checkbox" name="fooby[5][]"></td>
                                            <td><input type="checkbox" name="fooby[5][]"></td>

                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Attendance and tardiness. </td>
                                            <td><input type="checkbox" name="fooby[6][]"></td>
                                            <td><input type="checkbox" name="fooby[6][]"></td>
                                            <td><input type="checkbox" name="fooby[6][]"></td>
                                            <td><input type="checkbox" name="fooby[6][]"></td>
                                            <td><input type="checkbox" name="fooby[6][]"></td>

                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Is cooperative and dependable. </td>
                                            <td><input type="checkbox" name="fooby[7][]"></td>
                                            <td><input type="checkbox" name="fooby[7][]"></td>
                                            <td><input type="checkbox" name="fooby[7][]"></td>
                                            <td><input type="checkbox" name="fooby[7][]"></td>
                                            <td><input type="checkbox" name="fooby[7][]"></td>

                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>Accepts responsibility with initiative. </td>
                                            <td><input type="checkbox" name="fooby[8][]"></td>
                                            <td><input type="checkbox" name="fooby[8][]"></td>
                                            <td><input type="checkbox" name="fooby[8][]"></td>
                                            <td><input type="checkbox" name="fooby[8][]"></td>
                                            <td><input type="checkbox" name="fooby[8][]"></td>

                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>Show interest in work. </td>
                                            <td><input type="checkbox" name="fooby[9][]"></td>
                                            <td><input type="checkbox" name="fooby[9][]"></td>
                                            <td><input type="checkbox" name="fooby[9][]"></td>
                                            <td><input type="checkbox" name="fooby[9][]"></td>
                                            <td><input type="checkbox" name="fooby[9][]"></td>

                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>Grooms appropriately and carries self well. </td>
                                            <td><input type="checkbox" name="fooby[10][]"></td>
                                            <td><input type="checkbox" name="fooby[10][]"></td>
                                            <td><input type="checkbox" name="fooby[10][]"></td>
                                            <td><input type="checkbox" name="fooby[10][]"></td>
                                            <td><input type="checkbox" name="fooby[10][]"></td>

                                        </tr>
                                    </table>
                                    <hr>


                                    <button type="submit" class="btn btn-primary" style="width: auto;">Submit</button>
                                </div>



                            </form>
                            <!-- <div class="button">
                        <a href="#">See All</a>
                    </div> -->
                        </div>

                    </div>


                </div>
                <div id="setting" class="content">
                    <div class="home-content">
                        <div class="container light-style flex-grow-1 container-p-y">
                            <h4 class="font-weight-bold py-3 mb-4">
                                Account settings
                            </h4>
                            <div class="card overflow-hidden">
                                <div class="row no-gutters row-bordered row-border-light">
                                    <div class="col-md-3 pt-0">
                                        <div class="list-group list-group-flush account-settings-links">
                                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a>
                                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-social-links">Social links</a>
                                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-connections">Connections</a>
                                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-notifications">Notifications</a>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="account-general">
                                                <div class="card-body media align-items-center">
                                                    <img src="image/profile.jpg" alt="profile" id="profile-pic" class="d-block ui-w-80" style="border-radius:50%; height:150px;  width : 160px !important;">
                                                    <div class="media-body ml-4">
                                                        <label class="btn btn-outline-primary">
                                                            Upload new photo
                                                            <input type="file" class="account-settings-fileinput" accept="image/jpeg, image/png, image/jpg" id="input-file">
                                                        </label> &nbsp;
                                                        <button type="button" class="btn btn-default md-btn-flat">Reset</button>
                                                        <div class="text-light small mt-1">Allowed JPG, GIF or PNG.
                                                            Max
                                                            size
                                                            of 800K</div>
                                                    </div>
                                                </div>
                                                <hr class="border-light m-0">
                                                <div class="card-body">
                                                    <!-- <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control mb-1" >
                                </div> -->
                                                    <div class="form-group">
                                                        <label class="form-label">School Name</label><br>
                                                        <input type="text" class="form-control" style="width: 50%" ;><br>
                                                        <label class="form-label">First Name</label><br>
                                                        <input type="text" class="form-control" style="width: 50%" ;><br>
                                                        <label class="form-label">Middle Name</label><br>
                                                        <input type="text" class="form-control" style="width: 50%" ;><br>
                                                        <label class="form-label">Last Name</label><br>
                                                        <input type="text" class="form-control" style="width: 50%" ;><br>
                                                        <label class="form-label">Student ID</label><br>
                                                        <input type="text" class="form-control" style="width: 50%" ;>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">E-mail</label><br>
                                                        <input type="text" class="form-control mb-1" placeholder="@gmail.com" style="width: 50%">
                                                        <div class="alert alert-warning mt-3">
                                                            Your email is not confirmed. Please check your
                                                            inbox.<br>
                                                            <a href="javascript:void(0)">Resend confirmation</a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Company</label><br>
                                                        <input type="text" class="form-control" style="width: 50%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="account-change-password">
                                                <div class="card-body pb-2">
                                                    <div class="form-group">
                                                        <label class="form-label">Current password</label>
                                                        <input type="password" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">New password</label>
                                                        <input type="password" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Repeat new password</label>
                                                        <input type="password" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="account-info">
                                                <div class="card-body pb-2">
                                                    <div class="form-group">
                                                        <label class="form-label">Bio</label>
                                                        <textarea class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Birthday</label><br>
                                                        <input type="text" class="form-control" style="width: 50%">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Country</label>
                                                        <select class="custom-select">
                                                            <option>USA</option>
                                                            <option selected>Philippines</option>
                                                            <option>UK</option>
                                                            <option>Germany</option>
                                                            <option>France</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr class="border-light m-0">
                                                <div class="card-body pb-2">
                                                    <h6 class="mb-4">Contacts</h6>
                                                    <div class="form-group">
                                                        <label class="form-label">Phone</label><br>
                                                        <input type="number" class="form-control" value="+0 (123) 456 7891" style="width: 50%">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Website</label><br>
                                                        <input type="text" class="form-control" style="width: 50%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="account-social-links">
                                                <div class="card-body pb-2">
                                                    <div class="form-group">
                                                        <label class="form-label">Twitter</label><br>
                                                        <input type="text" class="form-control" value="https://twitter.com/user" style="width: 90%">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Facebook</label><br>
                                                        <input type="text" class="form-control" value="https://www.facebook.com/user" style="width: 90%">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Google+</label><br>
                                                        <input type="text" class="form-control" style="width: 90%">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">LinkedIn</label><br>
                                                        <input type="text" class="form-control" style="width: 90%">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Instagram</label><br>
                                                        <input type="text" class="form-control" value="https://www.instagram.com/user" style="width: 90%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="account-connections">
                                                <div class="card-body">
                                                    <button type="button" class="btn btn-twitter" style="font-size: 15px;">Connect to
                                                        <strong>Twitter</strong></button>
                                                </div>
                                                <hr class="border-light m-0">
                                                <div class="card-body">
                                                    <h5 class="mb-2" style="font-size: 15px;">
                                                        <a href="javascript:void(0)" class="float-right text-muted text-tiny" style="font-size: 15px;"><i class="ion ion-md-close"></i>
                                                            Remove</a>
                                                        <i class="ion ion-logo-google text-google"></i>
                                                        You are connected to Google:
                                                    </h5>
                                                    <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="f9979498818e9c9595b994989095d79a9694">[email&#160;protected]</a>
                                                </div>
                                                <hr class="border-light m-0">
                                                <div class="card-body">
                                                    <button type="button" class="btn btn-facebook" style="font-size: 15px;">Connect to
                                                        <strong>Facebook</strong></button>
                                                </div>
                                                <hr class="border-light m-0">
                                                <div class="card-body">
                                                    <button type="button" class="btn btn-instagram" style="font-size: 15px;">Connect to
                                                        <strong>Instagram</strong></button>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="account-notifications">
                                                <div class="card-body pb-2">
                                                    <h6 class="mb-4">Activity</h6>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input" checked>
                                                            <span class="switcher-indicator">
                                                                <span class="switcher-yes"></span>
                                                                <span class="switcher-no"></span>
                                                            </span>
                                                            <span class="switcher-label">Email me when someone
                                                                comments
                                                                on
                                                                my article</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input" checked>
                                                            <span class="switcher-indicator">
                                                                <span class="switcher-yes"></span>
                                                                <span class="switcher-no"></span>
                                                            </span>
                                                            <span class="switcher-label">Email me when someone
                                                                answers
                                                                on my
                                                                forum
                                                                thread</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input">
                                                            <span class="switcher-indicator">
                                                                <span class="switcher-yes"></span>
                                                                <span class="switcher-no"></span>
                                                            </span>
                                                            <span class="switcher-label">Email me when someone
                                                                follows
                                                                me</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <hr class="border-light m-0">
                                                <div class="card-body pb-2">
                                                    <h6 class="mb-4">Application</h6>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input" checked>
                                                            <span class="switcher-indicator">
                                                                <span class="switcher-yes"></span>
                                                                <span class="switcher-no"></span>
                                                            </span>
                                                            <span class="switcher-label">News and
                                                                announcements</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input">
                                                            <span class="switcher-indicator">
                                                                <span class="switcher-yes"></span>
                                                                <span class="switcher-no"></span>
                                                            </span>
                                                            <span class="switcher-label">Weekly product
                                                                updates</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input" checked>
                                                            <span class="switcher-indicator">
                                                                <span class="switcher-yes"></span>
                                                                <span class="switcher-no"></span>
                                                            </span>
                                                            <span class="switcher-label">Weekly blog digest</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-3">
                                <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
                                <button type="button" class="btn btn-default">Cancel</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>




        </div>
    </section>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function() {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    </script>
    <script>
        let toggle = () => {

            let element = document.getElementById("logo_name");
            let hidden = element.getAttribute("hidden");

            if (hidden) {
                element.removeAttribute("hidden");
            } else {
                element.setAttribute("hidden", "hidden");
            }
        }
    </script>
    <script type="text/javascript" src=" ../js/analytics_school_dashboard.js"></script>

    <script>
        $(".link").click(function(e) {
            e.preventDefault();
            $(".content").removeClass("active");
            var content_id = $(this).attr("id");
            $(content_id).addClass("active");
        });
    </script>
    <script>
        $("input:checkbox").on('click', function() {

            var $box = $(this);
            if ($box.is(":checked")) {
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    </script>
    <script>
        let profilePic = document.getElementById("profile-pic");
        let inputfile = document.getElementById("input-file");
        inputfile.onchange = function() {
            profilePic.src = URL.createObjectURL(inputfile.files[0]);
        }
    </script>


</body>

</html>