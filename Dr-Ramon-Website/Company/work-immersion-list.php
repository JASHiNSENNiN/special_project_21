<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/work-immersion-list.css">
    <link rel="stylesheet" type="text/css" href="../css/modal.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>

</head>

<body>

    <header class="nav-header">
        <div class="logo">
            <a href="../index.php">
                <img src="https://i.postimg.cc/bwCDv2SH/logov3.jpg" alt="Logo">
            </a>
            <nav class="dash-middle">
                <a href="../index.php">Home</a>
                <a href="../job_list.php">Company review</a>
                <a href="../contact.php">Contact</a>
            </nav>
        </div>
        <nav>
            <a class="login-btn" href="../login.php" style="margin-left: 20px;">Sign in</a>
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="com-btn" href="../post_work_Immersion.php">Post Work Immersion</a>
        </nav>
    </header>


    <img class="logoimg" id="cover-pic" src="image/background.jpg" alt="" height="300" width="200">



    <div class="profile-name">
        <img id="profile-pic" src="image/NIA.png" alt="">
        <div class="name">National Irrigation Administration (NIA)</div>
        <div class="company-card__review">
            <div class="review-stars">


                <div class="rating-icons-profile">
                    <span class="one-prof"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                    <span class="two-prof"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                </div>


                <span class="css-hid0zu e1wnkr790"><span class="total-reviews">0</span> reviews</span>
            </div>
        </div>

        <div class="Settings">
            <label for="input-file2" class="button-12" role="button">Follow </label>
            <a href="../login.php"><label for="input-file2" class="button-13" role="button">Write a review </label></a>
        </div>

    </div><br><br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Details.php">Snapshot</a>
            <a href="About.php">Why Join Us</a>
            <a href="reviews.php">Reviews</a>
            <a href="questions.php">Questions</a>
            <a class="active" href="work-immersion-list.php">Work immersion </a>
            <a href="photos.php">Photos</a>
        </nav>
    </div>
    <hr class="line_bottom">

    <div class="bgc">

        <div class="snapshot_container">
            <h1 style="font-size: 1.2rem;padding-top:0px; margin:0%; width: auto; margin: bottom 20px; margin-block-end: 1rem;">NATIONAL IRRIGATION ADMINISTRATION (NIA) Work Immersions</h1>
        </div>
    </div>
    <section class="section-search-loc-wrk" style="margin-top:0px; padding-top: 0px;">
        <!-- <h2 class="sfa">Search, Find and Apply!</h2> -->
        <div class="line-search">
            <div class="searchwork">
                <form class="form-search" action="#" method="get">

                    <div class="search-container">
                        <button type="submit"><i class="fas fa-search"></i></button>
                        <input class="work-input-text globalInputSearch" type="text" placeholder="Work Immersion / Keyword">

                    </div>
                    <div class="search-container" style="border-left: 1px solid grey">
                        <button type="submit"><i class="fas fa-map-marker-alt"></i></button>
                        <input class="loc-input-text globalInputSearch" type="text" placeholder="Search location">

                    </div>

                    <!-- <input class="sub-btn" type="submit" value="Find Now" href=""> -->
            </div>
            </form>
        </div>

    </section>
    <!-- ------------------------------------------------------Job list------------------------------>
    <div class="main-container">
        <!-- <div class="search-type">
                <div class="job-time">
                    <div class="job-time-title">Type of Employment</div>
                    <div class="job-wrapper">
                        <div class="type-container">
                            <input type="checkbox" id="job1" class="job-style">
                            <label for="job1">Full Time Jobs</label>
                            <span class="job-number">0</span>
                        </div>
                        <div class="type-container">
                            <input type="checkbox" id="job2" class="job-style">
                            <label for="job2">Part Time Jobs</label>
                            <span class="job-number">0</span>
                        </div>
                        <div class="type-container">
                            <input type="checkbox" id="job3" class="job-style">
                            <label for="job3">Remote Jobs</label>
                            <span class="job-number">0</span>
                        </div>
                        <div class="type-container">
                            <input type="checkbox" id="job4" class="job-style">
                            <label for="job4">Internship Jobs</label>
                            <span class="job-number">0</span>
                        </div>
                        <div class="type-container">
                            <input type="checkbox" id="job5" class="job-style">
                            <label for="job5">Contract</label>
                            <span class="job-number">0</span>
                        </div>
                        <div class="type-container">
                            <input type="checkbox" id="job6" class="job-style">
                            <label for="job6">Training Jobs</label>
                            <span class="job-number">0</span>
                        </div>
                    </div>
                </div>

            </div> -->
        <!-- <div class="searched-bar">
                <div class="searched-show">Showing 46 Jobs</div>
            </div> -->
        <!-- -------------------------------------------------------job cards ------------------------------- -->

        <div class="searched-jobs">
            <ul class="globalTargetList">
                <div class="job-cards">
                    <li>
                        <div class="job-card">
                            <div class="job-card-header">

                                <div class="menu-dot"></div>
                            </div>
                            <div class="job-card-title">
                                <h2><span>Work Immersion</span></h2>
                            </div>

                            <div class="loc-com">
                                <div class="job-card-title-company">King Emerald Collection Service</div>
                                <div class="job-card-title-location">Pasig</div>
                            </div>

                            <div class="job-detail-buttons">
                                <button class="search-buttons detail-button">Full Time</button>
                                <button class="search-buttons detail-button">Min. 1 Year</button>
                                <button class="search-buttons detail-button">Senior Level</button>
                            </div>

                            <div class="job-card-subtitle">
                                <ul>
                                    <li>College Students taking up Computer and Business courses with On the Job training requirements are also encouraged to join. (with allowance)</li>
                                    <li>Computer literate</li>
                                    <li>Knowledgeable in Microsoft Office tools</li>
                                    <li>Critical thinker /Tech Savvy</li>
                                </ul>

                            </div>

                            <span class="css-1f21ew ">Posted 7 minutes ago</span>


                            <div class="job-card-buttons">
                                <button class="search-buttons card-buttons" id="btnApply">Details</button>
                                <button class="search-buttons card-buttons-msg">Save</button>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="job-card">
                            <div class="job-card-header">

                                <div class="menu-dot"></div>
                            </div>
                            <div class="job-card-title">
                                <h2><span>Work Immersion</span></h2>
                            </div>
                            <div class="loc-com">
                                <div class="job-card-title-company">Besco Clark Philippines Group of Companies Corporation</div>
                                <div class="job-card-title-location">Quezon</div>
                            </div>

                            <div class="job-detail-buttons">
                                <button class="search-buttons detail-button">Full Time</button>
                                <button class="search-buttons detail-button">Min. 1 Year</button>
                                <button class="search-buttons detail-button">Senior Level</button>
                            </div>

                            <div class="job-card-subtitle">
                                <ul>
                                    <li>College Students taking up Computer and Business courses with On the Job training requirements are also encouraged to join. (with allowance)</li>
                                    <li>Computer literate</li>
                                    <li>Knowledgeable in Microsoft Office tools</li>
                                    <li>Critical thinker /Tech Savvy</li>
                                </ul>

                            </div>

                            <span data-testid="myJobsState" class="css-1f21ew eu4oa1w0">Posted 7 minutes ago</span>


                            <div class="job-card-buttons">
                                <button class="search-buttons card-buttons" id="btnApply">Details</button>
                                <button class="search-buttons card-buttons-msg">Save</button>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="job-card">
                            <div class="job-card-header">

                                <div class="menu-dot"></div>
                            </div>
                            <div class="job-card-title">
                                <h2><span>Work Immersion</span></h2>
                            </div>
                            <div class="loc-com">
                                <div class="job-card-title-company">Aspen Philippines Inc.</div>
                                <div class="job-card-title-location">Nueva Ecija</div>
                            </div>

                            <div class="job-detail-buttons">
                                <button class="search-buttons detail-button">Full Time</button>
                                <button class="search-buttons detail-button">Min. 1 Year</button>
                                <button class="search-buttons detail-button">Senior Level</button>
                            </div>

                            <div class="job-card-subtitle">
                                <ul>
                                    <li>College Students taking up Computer and Business courses with On the Job training requirements are also encouraged to join. (with allowance)</li>
                                    <li>Computer literate</li>
                                    <li>Knowledgeable in Microsoft Office tools</li>
                                    <li>Critical thinker /Tech Savvy</li>
                                </ul>

                            </div>

                            <span data-testid="myJobsState" class="css-1f21ew eu4oa1w0">Posted 7 minutes ago</span>


                            <div class="job-card-buttons">
                                <button class="search-buttons card-buttons" id="btnApply">Details</button>
                                <button class="search-buttons card-buttons-msg">Save</button>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="job-card">
                            <div class="job-card-header">

                                <div class="menu-dot"></div>
                            </div>
                            <div class="job-card-title">
                                <h2><span>Work Immersion</span></h2>
                            </div>
                            <div class="loc-com">
                                <div class="job-card-title-company">SBS Philippines Corporation</div>
                                <div class="job-card-title-location">Makati</div>
                            </div>

                            <div class="job-detail-buttons">
                                <button class="search-buttons detail-button">Full Time</button>
                                <button class="search-buttons detail-button">Min. 1 Year</button>
                                <button class="search-buttons detail-button">Senior Level</button>
                            </div>

                            <div class="job-card-subtitle">
                                <ul>
                                    <li>College Students taking up Computer and Business courses with On the Job training requirements are also encouraged to join. (with allowance)</li>
                                    <li>Computer literate</li>
                                    <li>Knowledgeable in Microsoft Office tools</li>
                                    <li>Critical thinker /Tech Savvy</li>
                                </ul>

                            </div>

                            <span data-testid="myJobsState" class="css-1f21ew eu4oa1w0">Posted 7 minutes ago</span>


                            <div class="job-card-buttons">
                                <button class="search-buttons card-buttons" id="btnApply">Details</button>
                                <button class="search-buttons card-buttons-msg">Save</button>
                            </div>
                        </div>
                    </li>

                </div>
            </ul>
            <!-- feedback -->
            <div class="globalSearchResultNoFoundFeedback" aria-live="polite"> Search nothing found</div>
        </div>
    </div>


    <!-- ----------------------modal job list ----------------------- -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="job-card">
                <div class="job-card-header">


                </div>
                <div class="job-card-title">
                    <h2><span>Work Immerion</span></h2>
                </div>
                <div class="job-detail-buttons">
                    <button class="search-buttons detail-button">Full Time</button>
                    <button class="search-buttons detail-button">Min. 1 Year</button>
                    <button class="search-buttons detail-button">Senior Level</button>
                </div>
                <div class="loc-com">
                    <h2>location</h2>
                    <div class="job-card-title-location"><i class="fas fa-map-marker-alt"></i>Pasig</div>
                </div>
                <div clas="full-des">
                    <h2>Full job description</h2>
                </div>
                <div class="job-card-subtitle">
                    <h4>JOB DESCRIPTION</h4>
                    <li>Properly document account information and input data in the appropriate systems.</li>
                    <li>Lead and prepare a report for each investigation to creditors.</li>
                    <li>Analytical and problem-solving skills to expedite these investigations.</li>
                    <li>Collect daily and weekly data for required reports and submit them to the supervisors prior to deadlines.</li>
                    <li>Use computer applications to locate and trace clients.</li>

                    <h4>QUALIFICATION </h4>
                    <li>College Students taking up Computer and Business courses with On the Job training requirements are also encouraged to join. (with allowance)</li>
                    <li>Computer literate</li>
                    <li>Knowledgeable in Microsoft Office tools</li>
                    <li>Critical thinker /Tech Savvy</li>

                    <h4>RESPONSIBILITIES</h4>
                    <li>[List of specific responsibilities and tasks]</li>
                    <li>[Another responsibility]</li>
                    <li>[Additional responsibility]</li>



                    <h4>BENEFITS</h4>
                    <li>[List of any benefits offered, such as health insurance, retirement plans, etc.].</li>

                    <h4>Consent from Parents or Guardians:</h4>
                    <li>Since work immersion may involve practical work experience outside the school premises,
                        consent from parents or guardians is usually required.</li>



                </div>


                <div class="job-card-buttons">
                    <a href="login.php"> <button class="search-buttons card-buttons" id="btnApply">Apply Now</button></a>
                    <a href="login.php"><button class="search-buttons card-buttons-msg">Messages</button></a>
                </div>
            </div>
        </div>
    </div>



    <div class="bgc">

        <!----------------------------------------------------feed back--------------------------------------------- -->
        <div class="des-feed">
            <h3 style="color: #2d2d2d; font-size: 1rem; margin-top: 0px;
    margin-bottom: 0px;">Tell us how to improve this page</h3>
            <label style="font-size: .75rem; color: #595959;">What would you add or change?</label>
        </div>

        <div class="container">
            <form action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="1c3d7737-14bc-4bc1-819a-0a5c1c760bc4">

                <textarea id="subject" name="message" style="height:200px" required></textarea>
                <div class="installer">
                    <label for="progressLinux"><input id="progressLinux" type="submit"><span></span></label>
                </div>
            </form>



        </div>

        <!-- -----------------------------search comqany --------------------------------- -->
        <section class="section-search-com">
            <h3 style="color: #2d2d2d;">Find another company</h3>
            <div class="line-search-find-com">

                <div class="searchwork">

                    <form class="form-search" action="#" method="get">

                        <div class="search-container">
                            <button type="submit"><i class="fas fa-search"></i></button>
                            <input class="txt-btn" type="text" placeholder="Company name">

                        </div>



                    </form>

                </div>
                <input class="sub-btn-wrk" type="submit" value="Search">
            </div>


        </section>
    </div>



    <br>
    <footer>
        <p>&copy; 2024 WorkifyPH. All rights reserved. | Junior Philippines Computer Society Students</p>
    </footer>


    <!-- --------------------------------joblist modal js-------------------------=--- -->
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("btnApply");

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
    <!-- -----------------------------------------cover qhoto qic js ---------------------------------- -->
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
    <script src="chart.js"></script>
    <script src="filter-work-immersion-list.js"></script>
</body>

</html>