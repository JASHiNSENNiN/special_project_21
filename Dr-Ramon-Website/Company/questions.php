<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/questions.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>

</head>

<body>

    <header class="nav-header">
        <div class="logo">
            <a href="../index.php">
                <img src="https://i.postimg.cc/bwCDv2SH/logov3.jpg" alt="Logo">
            </a>
            <nav class="dash-middle">
                <a href="../index.php">Home</a>
                <a class="active-header" href="../job_list.php">Company review</a>
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
            <a href="reviews.php">Reviews</a>
            <a class="active" href="questions.php">Questions</a>
            <a href="work-immersion-list.php">Work immersion </a>
            <a href="photos.php">Photos</a>
        </nav>
    </div>
    <hr class="line_bottom">
    <div class="bgc">

        <div class="snapshot_container">
            <h1 style="font-size: 1.2rem; margin:0%; margin: bottom 20px; margin-block-end: 1rem;">Questions and Answers
                about NATIONAL IRRIGATION ADMINISTRATION (NIA)</h1>

        </div>
        <!-- ---------------------------------------------- Question and Answer------------------------------------------- -->

        <div class="tab">
            <button class="tablinks tab-1" onclick="openTab(event, 'tab')">
                <svg fill="#2d2d2d" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve">
                    <g>
                        <path d="M42,15.5H5.93C2.66,15.5,0,18.16,0,21.429V42.57c0,3.27,2.66,5.93,5.93,5.93H12v10c0,0.413,0.254,0.784,0.64,0.933
        C12.757,59.478,12.879,59.5,13,59.5c0.276,0,0.547-0.115,0.74-0.327L23.442,48.5H42c3.27,0,5.93-2.66,5.93-5.929V21.43
        C47.93,18.16,45.27,15.5,42,15.5z" />
                        <path d="M54.072,0.57L19.93,0.5C16.66,0.5,14,3.16,14,6.43v6.122c0,0.266,0.105,0.52,0.293,0.708
        c0.188,0.187,0.442,0.292,0.707,0.292c0,0,0.001,0,0.002,0L40.07,13.5c8.951,0,9.93,2.021,9.93,7.93v21.141
        c0,0.091-0.01,0.181-0.014,0.271l1.274,1.401c0.193,0.212,0.463,0.327,0.74,0.327c0.121,0,0.243-0.022,0.361-0.067
        C52.746,44.354,53,43.983,53,43.57v-10h1.07c3.27,0,5.93-2.66,5.93-5.929V6.5C60,3.23,57.34,0.57,54.072,0.57z" />
                    </g>
                </svg>Browse questions</button>

            <button class="tablinks tab-2" onclick="openTab(event, 'Register')"> <svg fill="#2d2d2d" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 348.882 348.882" xml:space="preserve">
                    <g>
                        <path d="M333.988,11.758l-0.42-0.383C325.538,4.04,315.129,0,304.258,0c-12.187,0-23.888,5.159-32.104,14.153L116.803,184.231
        c-1.416,1.55-2.49,3.379-3.154,5.37l-18.267,54.762c-2.112,6.331-1.052,13.333,2.835,18.729c3.918,5.438,10.23,8.685,16.886,8.685
        c0,0,0.001,0,0.001,0c2.879,0,5.693-0.592,8.362-1.76l52.89-23.138c1.923-0.841,3.648-2.076,5.063-3.626L336.771,73.176
        C352.937,55.479,351.69,27.929,333.988,11.758z M130.381,234.247l10.719-32.134l0.904-0.99l20.316,18.556l-0.904,0.99
        L130.381,234.247z M314.621,52.943L182.553,197.53l-20.316-18.556L294.305,34.386c2.583-2.828,6.118-4.386,9.954-4.386
        c3.365,0,6.588,1.252,9.082,3.53l0.419,0.383C319.244,38.922,319.63,47.459,314.621,52.943z" />
                        <path d="M303.85,138.388c-8.284,0-15,6.716-15,15v127.347c0,21.034-17.113,38.147-38.147,38.147H68.904
        c-21.035,0-38.147-17.113-38.147-38.147V100.413c0-21.034,17.113-38.147,38.147-38.147h131.587c8.284,0,15-6.716,15-15
        s-6.716-15-15-15H68.904c-37.577,0-68.147,30.571-68.147,68.147v180.321c0,37.576,30.571,68.147,68.147,68.147h181.798
        c37.576,0,68.147-30.571,68.147-68.147V153.388C318.85,145.104,312.134,138.388,303.85,138.388z" />
                    </g>
                </svg>Ask a question</button>
        </div>

        <div id="tab" class="tabcontent">
            <section id="testimonials">

                <!-- <h3 style="color: ##595959; text-align:left;">Find another company</h3> -->
                <!-- <span style="color: #595959;">Search Questions</span> -->
                <div class="line-search">

                    <!-- <div class="searchwork"> -->

                    <form class="form-search" action="#" method="get">

                        <div class="search-container">
                            <button type="submit"><i class="fas fa-search"></i></button>
                            <input class="txt-btn globalInputSearch" type="text" placeholder="search keywords">

                        </div>



                    </form>

                    <!-- </div> -->
                    <!-- <input class="sub-btn" type="submit" value="Search"> -->
                </div>





                <!--heading--->
                <div class="testimonial-heading">
                    <!-- <h2>Reviews</h2> -->

                </div>
                <!--testimonials-box-container------>
                <div class="testimonial-box-container">
                    <ul class="globalTargetList">
                        <li>
                            <!--BOX-1-------------->
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
                                            <a href="faq.php"><strong>What is covered by the life insurance at NATIONAL
                                                    IRRIGATION ADMINISTRATION (NIA)?</strong></a>
                                            <span>on September 15, 2023</span>
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
                                <!--Comments---------------------------------------->
                                <div class="client-comment">
                                    <a href="faq.php"><input class="sub-btn" type="submit" value="Answer"></a>
                                    <a class="css-2jfdql" href="faq.php"> See 1 answer<svg xmlns="http://www.w3.org/2000/svg" focusable="false" role="img" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" class="css-g5h3rj eac13zx0">
                                            <path d="M9.888 5.998a.506.506 0 00-.716-.008l-.707.707a.506.506 0 00.01.716L13.06 12l-4.587 4.587c-.2.2-.204.521-.009.716l.707.707a.507.507 0 00.717-.009l5.647-5.648c.1-.1.148-.233.144-.366a.492.492 0 00-.144-.34v-.001a.611.611 0 00-.009-.009L9.888 5.998z">
                                            </path>
                                        </svg></a>
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
                                            <a><strong>How long do you have to work at NATIONAL IRRIGATION ADMINISTRATION (NIA)
                                                    before you can go on maternity leave?</strong></a>
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
                                    <a><input class="sub-btn" type="submit" value="Answer"></a>
                                    <div class="css-3pliee eu4oa1w0">Be the first to answer!</div>
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
                                            <a><strong>What benefits does NATIONAL IRRIGATION ADMINISTRATION (NIA)
                                                    offer?</strong></a>
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
                                    <a><input class="sub-btn" type="submit" value="Answer"></a>
                                    <div class="css-3pliee eu4oa1w0">Be the first to answer!</div>
                                    <!-- <p>National Irirgation Administration is a good environment to work in. The agency has very supportive heads and employees willing to work an extra mile for the benefit of the Filipino farmers.</p> -->
                                </div>
                            </div>
                        </li>

                    </ul>
                    <div class="globalSearchResultNoFoundFeedback" aria-live="polite"> Search nothing found</div>
                </div>
            </section>
        </div>

        <div id="Register" class="tabcontent">
            <h2 class="css-19w3i0t">Tips to get helpful answers</h2>
            <div class="css-4pn4n5">
                <ol class="css-1piz3yk">
                    <li class="css-1z0pyms ">Check that your question hasn't already been asked</li>
                    <li class="css-1z0pyms ">Ask a direct question</li>
                    <li class="css-1z0pyms ">Check your spelling and grammar</li>
                </ol>
                <a href="#" target="_blank"><input class="guid-btn" type="submit" value="Guidelines"></a>
            </div>

            <textarea id="subject" name="subject" style="height:200px" placeholder="Type your question here"></textarea>
            <span class="guid-text"> By following this question, you will only see the answer when admin has answered
                your question in the browse question section. </span>
            <div class="installer-submit">
                <label for="progressLinux"><input id="progressLinux" type="radio"><span></span></label>
            </div>


            <div class="css-u9mbo3">
                Please note that all of this content is user-generated and its accuracy is not guaranteed by workify or
                this company.
            </div>

        </div>


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

        <!-- -------------------------------------------search comqany------------------------------------- -->
        <section class="search-find-com">
            <h3 style="color: #2d2d2d;">Find another company</h3>
            <div class="line-search-com">

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



    </div>
    <br>
    <footer>
        <p>&copy; 2024 WorkifyPH. All rights reserved. | Junior Philippines Computer Society Students</p>
    </footer>

    <script src="questions.js"></script>
    <script src="chart.js"></script>
    <script src="filter-work-immersion-list.js"></script>

</body>

</html>