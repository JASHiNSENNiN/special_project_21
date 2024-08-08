<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/Details.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>

</head>

<body>

    <header class="nav-header">
        <div class="logo">
            <a href="index.php">
                <img src="https://i.postimg.cc/bwCDv2SH/logov3.jpg" alt="Logo">
            </a>
            <nav class="dash-middle">
                <a href="index.php">Home</a>
                <a href="job_list.php">Company review</a>
                <a href="contact.php">Contact</a>
            </nav>
        </div>
        <nav>
            <a class="login-btn" href="login.php" style="margin-left: 20px;">Sign in</a>
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="com-btn" href="post_work_Immersion.php">Post Work Immersion</a>
        </nav>
    </header>


    <img class="logoimg" id="cover-pic" src="image/background.jpg" alt="" height="300" width="200">
    <label for="input-file1" class="button-13" role="button"><span class="edit"><i class="fa fa-camera"></i>Edit cover
            photo</span>
        <span class="cam"><i class="fa fa-camera"></i></span></label>
    <input type="file" accept="image/jpeg, image/png, image/gif" id="input-file1" />


    <div class="profile-name">
        <img id="profile-pic" src="image/NIA.png" alt="">
        <div class="name">National Irrigation Administration</div>
        <label class="strand" for="">NIA</label>

        <div class="Settings"><label for="input-file2" class="button-12" role="button"><span class="edit"><i class="fa fa-pencil"></i> Edit
                    profile</span><span class="pen"><i class="fa fa-pencil"></i></span></label>
            <input type="file" accept="image/jpeg, image/png, image/gif" id="input-file2" />
        </div>

    </div><br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a class="active" href="Details.php">Snapshot</a>
            <a href="#">Why Join Us</a>
            <a href="#">Reviews</a>
            <a href="#">Questions</a>
            <a href="#">Work immersion </a>
            <a href="#">Photos</a>

            <!-- <a href="Job_ads.php"> Job Ads</a>
            <a href="Job_request.php">Job Request</a>
            <a href="Faculty_report.php">Faculty Report</a> -->



        </nav>
    </div>
    <hr class="line_bottom">
    <div class="bgc">

        <div class="snapshot_container">
            <label style="font-size: .75rem; color: #595959;">National Irrigation Administration Careers and Employment</label>
            <h1 style="font-size: 1.75rem; margin:0%; margin: bottom 20px; margin-block-end: 1rem;">About the company</h1>
            <!-- <span class="snapshot_title"><strong>Snapshots</strong>(Added 7/20 Available)</span> -->
            <!-- <span class="snapshot_toggle">Toggle to show snapshot details
                <button class="button-26">+</button>
                <button class="button-14" role="button">MANAGE</button>
            </span> -->

            <div class="api_card">
                <div class="api_details">
                    <span class="api_title">Ceo</span></br>
                    <span class="api_details_one">Robert Victor G. Seares, Jr.</span></br>
                    <div class="rating">62%</div></br>
                    <span class="api_details_two">approve of Robert Victor G. Seares, Jr. performance</span></br>


                </div>

            </div>
            <!-- <div class="api_card">
                <div class="api_details">
                    <span class="api_title">Headerquarters</span></br>
                    <span class="api_details_one">Payday: 02/01/2021</span></br>

                </div>

            </div> -->
            <div class="section-wrap">
                <div class="api_card_half">
                    <div class="api_details">
                        <p class="api_title">Headerquarters</p></br>
                        <span class="api_details_one">Quezon City, Metro Manila</span>
                    </div>

                </div>

            </div>
            <div class="section-wrap">
                <div class="api_card_half">
                    <div class="api_details">
                        <p class="api_title">Link</p></br>
                        <a class="api_details_one" style="color: #2557a7;" href="https://www.nia.gov.ph/">NIA Philippines <svg xmlns="http://www.w3.org/2000/svg" focusable="false" role="img" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" class=" css-1jtd2m7 eac13zx0">
                                <title>Opens in a new window</title>
                                <path d="M14.504 3a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h3.085l-9.594 9.594a.5.5 0 000 .707l.707.708a.5.5 0 00.707 0l9.594-9.595V9.5a.5.5 0 00.5.5h1a.5.5 0 00.5-.5v-6a.5.5 0 00-.5-.5h-6z"></path>
                                <path d="M5 3.002a2 2 0 00-2 2v13.996a2 2 0 001.996 2.004h14a2 2 0 002-2v-6.5a.5.5 0 00-.5-.5h-1a.5.5 0 00-.5.5v6.5L5 18.998V5.002L11.5 5a.495.495 0 00.496-.498v-1a.5.5 0 00-.5-.5H5z"></path>
                            </svg></a>
                    </div>

                </div>
            </div>
            <h1 style="font-size: 1.75rem; margin:0%; margin: bottom 20px; margin-block-end: 1rem;">Rating overview</h1>
            <label style="font-size: .75rem; color: #595959;">Rating is calculated based on 4 reviews and is evolving.</label>
        </div>
    </div>


    <div class="rating-overview">
        <svg id="line" width="100%" style="/*background: #f5f5f5;*/font-size:8px;font-family: system-ui;cursor: pointer;"></svg>
    </div>
    <section id="testimonials">


        <!--heading--->
        <div class="testimonial-heading">
            <h2>Reviews</h2>

        </div>
        <!--testimonials-box-container------>
        <div class="testimonial-box-container">
            <!--BOX-1-------------->
            <div class="testimonial-box">
                <!--top------------------------->
                <div class="box-top">
                    <!--profile----->
                    <div class="profile">
                        <!--img---->
                        <div class="profile-img">
                            <img src="https://i.postimg.cc/638DNCV2/profile.jpg" />
                        </div>
                        <!--name-and-username-->
                        <div class="name-user">
                            <strong>Liam mendes</strong>
                            <span>on September 15, 2023</span>
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
                <!--Comments---------------------------------------->
                <div class="client-comment">
                    <p>Working on this company is a good experience it is because it is related to the course I've taken in college as a Bachelor of Science and Social Work also the company memmber is a hard worker ang responsible for their work in the company. Other than that our relationship as a member of the company is good as we can united at the problem we are facing .</p>
                </div>
            </div>
            <!--BOX-2-------------->
            <div class="testimonial-box">
                <!--top------------------------->
                <div class="box-top">
                    <!--profile----->
                    <div class="profile">
                        <!--img---->
                        <div class="profile-img">
                            <img src="https://i.postimg.cc/638DNCV2/profile.jpg" />
                        </div>
                        <!--name-and-username-->
                        <div class="name-user">
                            <strong>Noah Wood</strong>
                            <span>on September 9, 2020</span>
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
                <!--Comments---------------------------------------->
                <div class="client-comment">
                    <p>Good in cooperation and research study you will learned to coordinate in the Lgu and other government agencies in the feasibility study sometimes they challenge you to finish investigate the subject area for the proposed irrigation project.</p>
                </div>
            </div>
            <!--BOX-3-------------->
            <div class="testimonial-box">
                <!--top------------------------->
                <div class="box-top">
                    <!--profile----->
                    <div class="profile">
                        <!--img---->
                        <div class="profile-img">
                            <img src="https://i.postimg.cc/638DNCV2/profile.jpg" />
                        </div>
                        <!--name-and-username-->
                        <div class="name-user">
                            <strong>Oliver Queen</strong>
                            <span>on May 31, 2020</span>
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
                <!--Comments---------------------------------------->
                <div class="client-comment">
                    <p>National Irirgation Administration is a good environment to work in. The agency has very supportive heads and employees willing to work an extra mile for the benefit of the Filipino farmers.</p>
                </div>
            </div>
            <!--BOX-4-------------->
            <div class="testimonial-box">
                <!--top------------------------->
                <div class="box-top">
                    <!--profile----->
                    <div class="profile">
                        <!--img---->
                        <div class="profile-img">
                            <img src="https://i.postimg.cc/638DNCV2/profile.jpg" />
                        </div>
                        <!--name-and-username-->
                        <div class="name-user">
                            <strong>Barry Allen</strong>
                            <span>on February 11, 2020</span>
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
                <!--Comments---------------------------------------->
                <div class="client-comment">
                    <p>I've been working under planning unit. I properly evaluate Program of Works (POW) from 7 different divisions in Region III. The most complex part of my former job is when all 7 divisions submitted their POW on same date (due date) and not before due date. What I sincerely like in my previous job is there's no gossiping. They merely encourage you to be better.</p>
                </div>
            </div>
        </div>
    </section>
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


</body>
<script src="chart.js"></script>

</html>
<script>
    /*
Conic gradients are not supported in all browsers (https://caniuse.com/#feat=css-conic-gradients), so this pen includes the CSS conic-gradient() polyfill by Lea Verou (https://leaverou.github.io/conic-gradient/)
*/

    // Find al rating items
    const ratings = document.querySelectorAll(".rating");

    // Iterate over all rating items
    ratings.forEach((rating) => {
        // Get content and get score as an int
        const ratingContent = rating.innerHTML;
        const ratingScore = parseInt(ratingContent, 10);

        // Define if the score is good, meh or bad according to its value
        const scoreClass =
            ratingScore < 40 ? "bad" : ratingScore < 60 ? "meh" : "good";

        // Add score class to the rating
        rating.classList.add(scoreClass);

        // After adding the class, get its color
        const ratingColor = window.getComputedStyle(rating).backgroundColor;

        // Define the background gradient according to the score and color
        const gradient = `background: conic-gradient(${ratingColor} ${ratingScore}%, transparent 0 100%)`;

        // Set the gradient as the rating background
        rating.setAttribute("style", gradient);

        // Wrap the content in a tag to show it above the pseudo element that masks the bar
        rating.innerHTML = `<span>${ratingScore} ${
    ratingContent.indexOf("%") >= 0 ? "<small>%</small>" : ""}</span>`;
    });
</script>