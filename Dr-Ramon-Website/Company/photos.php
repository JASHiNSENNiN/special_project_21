<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/photos.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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
            <a href="reviews.php">Reviews</a>
            <a href="questions.php">Questions</a>
            <a href="work-immersion-list.php">Work immersion </a>
            <a class="active" href="photos.php">Photos</a>
        </nav>
    </div>
    <hr class="line_bottom">
    <div class="bgc">

        <div class="snapshot_container">
            <h1 style="font-size: 1.2rem; margin:0%; margin: bottom 20px; padding-top:0px; margin-block-end: 1rem;">NATIONAL IRRIGATION ADMINISTRATION (NIA) PHOTOS</h1>

        </div>
        <div class="upload__box">
            <div class="upload__btn-box">
                <label class=" css-1cxc9zk">
                    <span class="span-title">Photos</span>
                    <!-- <b class="b-num">1</b>
                    <span class="span-title">-</span>
                    <b class="b-num">1</b>
                    <span class="span-title">of</span>
                    <b class="b-num">1</b> -->
                </label>
                <label class="upload__btn">
                    <p class="title-up">Upload images</p>
                    <input type="file" multiple="" data-max_length="20" accept="image/png, image/gif, image/jpeg" class="upload__inputfile">
                </label>
            </div>
            <div class="upload__img-wrap"></div>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Modal Header</h2>
                </div>
                <div class="modal-body">
                    <p>Some text in the Modal Body</p>
                    <p>Some other text...</p>
                    <div class="upload__box">
                        <div class="upload__btn-box">
                            <label class=" css-1cxc9zk">
                                <span class="span-title">Photos</span>
                                <b class="b-num">1</b>
                                <span class="span-title">-</span>
                                <b class="b-num">1</b>
                                <span class="span-title">of</span>
                                <b class="b-num">1</b>
                            </label>
                            <label class="upload__btn">
                                <p class="title-up">Upload images</p>
                                <input type="file" multiple="" data-max_length="20" accept="image/png, image/gif, image/jpeg" class="upload__inputfile">
                            </label>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <h3>Modal Footer</h3>
                </div>
            </div>

        </div>



        <!-- -------------------------search comqany and feedback--------------------------------- -->
        <div class="container">
            <form action="/action_page.php">
                <h3 style="color: #2d2d2d; font-size: 1rem;">Tell us how to improve this page</h3>
                <label style="font-size: .75rem; color: #595959;">What would you add or change?</label>

                <textarea id="subject" name="subject" style="height:200px" required></textarea>

            </form>

            <div class="installer">
                <label for="progressLinux"><input id="progressLinux" type="radio"><span></span></label>
            </div>

        </div>
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
    <script src="photos.js"></script>
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
    <script>
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
    </script>


    <script src="chart.js"></script>
</body>

</html>