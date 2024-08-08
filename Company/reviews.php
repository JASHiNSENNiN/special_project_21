<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/reviews.css">

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

    </div><br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Details.php">Snapshot</a>
            <a href="About.php">Why Join Us</a>
            <a class="active" href="reviews.php">Reviews</a>
            <a href="questions.php">Questions</a>
            <a href="work-immersion-list.php">Work immersion </a>
            <a href="photos.php">Photos</a>
        </nav>
    </div>
    <hr class="line_bottom">
    <div class="bgc">

        <div class="snapshot_container">
            <h1 style="font-size: 1.2rem;  width: auto; padding-top: 0px;  margin-block-end: 1rem;">NATIONAL IRRIGATION ADMINISTRATION (NIA) Work Immersion Review </h1>

        </div>

        <section class="sec-search-rev">
            <!-- <h2 class="sfa">Search, Find and Apply!</h2> -->
            <div class="line-search">
                <div class="searchwork">
                    <form action="#" method="get">

                        <div class="search-container">
                            <button type="submit"><i class="fas fa-search"></i></button>
                            <input class="globalInputSearch" type="text" placeholder="Work Immersion title">

                        </div>
                        <div class="search-container" style="border-left: 1px solid grey">
                            <button type="submit"><i class="fas fa-map-marker-alt"></i></button>
                            <input class="globalInputSearch" type="text" placeholder="Location">

                        </div>

                        <!-- <input class="sub-btn" type="submit" value="Search" href=""> -->
                </div>
                </form>
            </div>
            <!--heading--->
            <div class="testimonial-heading">
                <!-- <span>3 Reviews found</span> -->

            </div>
            <!--testimonials-box-container------>
            <div class="testimonial-box-container">
                <ul class="globalTargetList">
                    <!--BOX-1-------------->
                    <li>
                        <div class="testimonial-box">
                            <!--top------------------------->

                            <div class="box-top">
                                <!--profile----->
                                <div class="profile">

                                    <!--img---->
                                    <!-- <div class="profile-img">
                                    <img src="https://i.postimg.cc/638DNCV2/profile.jpg" />
                                </div> -->
                                    <!--name-and-username-->
                                    <div class="name-user">
                                        <a href="#"><strong>Productive and more learning</strong></a>
                                        <span>Quezon Province - September 9, 2020</span>
                                    </div>
                                </div>
                                <!--reviews------>
                                <!-- <div class="reviews">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div> -->

                            </div>
                            <span class="css-15r9gu1 ">Good in cooperation and research study you will learned to coordinate in the Lgu and other government agencies in the feasibility study sometimes they challenge you to finish investigate the subject area for the proposed irrigation project </span>
                            <br><br>
                            <div class="css-eyjn56 ">Was this review helpful?</div>
                            <!--Comments---------------------------------------->
                            <div class="client-comment">

                                <input class="sub-btn" type="submit" value="Yes">
                                <input class="sub-btn" type="submit" value="No">
                                <button class="reportBtn">
                                    <span class="IconContainer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
                                            <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001" />
                                        </svg>
                                    </span>
                                    <p class="text-Report">Report</p>
                                </button>
                                <!-- <p>Working on this company is a good experience it is because it is related to the course I've taken in college as a Bachelor of Science and Social Work also the company memmber is a hard worker ang responsible for their work in the company. Other than that our relationship as a member of the company is good as we can united at the problem we are facing .</p> -->
                            </div>
                        </div>
                    </li>
                    <li>
                        <!--BOX-2-------------->
                        <div class="testimonial-box">
                            <!--top------------------------->
                            <div class="box-top">
                                <!--profile----->
                                <div class="profile">
                                    <!--img---->
                                    <!-- <div class="profile-img">
                                    <img src="https://i.postimg.cc/638DNCV2/profile.jpg" />
                                </div> -->
                                    <!--name-and-username-->
                                    <div class="name-user">
                                        <strong>Has a good relationship with the member and a excellent work</strong>
                                        <span>Marawi - September 9, 2020</span>
                                    </div>
                                </div>
                                <!--reviews------>
                                <!--                     <div class="reviews">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div> -->
                            </div>
                            <span class="css-15r9gu1 ">Working on this company is a good experience it is because it is related to the course I've taken in college as a Bachelor of Science and Social Work also the company memmber is a hard worker ang responsible for their work in the company. Other than that our relationship as a member of the company is good as we can united at the problem we are facing .</span>
                            <br><br>
                            <div class="css-eyjn56 ">Was this review helpful?</div>
                            <!--Comments---------------------------------------->
                            <div class="client-comment">
                                <a href="#"><input class="sub-btn" type="submit" value="Yes"></a>
                                <a href="#"><input class="sub-btn" type="submit" value="No"></a><button class="reportBtn">
                                    <span class="IconContainer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
                                            <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001" />
                                        </svg>
                                    </span>
                                    <p class="text-Report">Report</p>
                                </button>
                                <!-- <p>Good in cooperation and research study you will learned to coordinate in the Lgu and other government agencies in the feasibility study sometimes they challenge you to finish investigate the subject area for the proposed irrigation project.</p> -->
                            </div>
                        </div>
                    </li>
                    <li>
                        <!--BOX-3-------------->
                        <div class="testimonial-box">
                            <!--top------------------------->
                            <div class="box-top">
                                <!--profile----->
                                <div class="profile">
                                    <!--img---->
                                    <!-- <div class="profile-img">
                                    <img src="https://i.postimg.cc/638DNCV2/profile.jpg" />
                                </div> -->
                                    <!--name-and-username-->
                                    <div class="name-user">
                                        <strong>Productive and fun to work with</strong>
                                        <span>Zamboanga Sibugay - May 31, 2020</span>
                                    </div>
                                </div>
                                <!--reviews------>
                                <!--                     <div class="reviews">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div> -->
                            </div>
                            <span class="css-15r9gu1 ">National Irirgation Administration is a good environment to work in. The agency has very supportive heads and employees willing to work an extra mile for the benefit of the Filipino farmers.</span>
                            <br><br>
                            <div class="css-eyjn56 ">Was this review helpful?</div>
                            <!--Comments---------------------------------------->
                            <div class="client-comment">
                                <a href="#"><input class="sub-btn" type="submit" value="Yes"></a>
                                <a href="#"><input class="sub-btn" type="submit" value="No"></a>
                                <button class="reportBtn">
                                    <span class="IconContainer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
                                            <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001" />
                                        </svg>
                                    </span>
                                    <p class="text-Report">Report</p>
                                </button>
                                <!-- <p>National Irirgation Administration is a good environment to work in. The agency has very supportive heads and employees willing to work an extra mile for the benefit of the Filipino farmers.</p> -->
                            </div>
                        </div>
                    </li>

                </ul>
                <!-- feedback -->
                <div class="globalSearchResultNoFoundFeedback" aria-live="polite"> Search nothing found</div>
            </div>

        </section>


        <!-- --------------------------------------------------Feedback and search comqany--------------------------------------- -->
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
        <section class="search-find-com">
            <h3 style="color: #2d2d2d;">Find another company</h3>
            <div class="line-search-fed">

                <div class="searchwork">

                    <form class="form-search" action="#" method="get">

                        <div class="search-container">
                            <button type="submit"><i class="fas fa-search"></i></button>
                            <input class="txt-btn" type="text" placeholder="Company name">

                        </div>



                    </form>

                </div>
                <input class="sub-btn" type="submit" value="Search">
            </div>

        </section>


        <br>
        <footer>
            <p>&copy; 2024 WorkifyPH. All rights reserved. | Junior Philippines Computer Society Students</p>
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
        <script src="chart.js"></script>
        <script src="filter-work-immersion-list.js"></script>
</body>

</html>