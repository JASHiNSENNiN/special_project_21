<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Work Immersion Search | Workify</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>

</style>

<body>

    <header id="myHeader-sticky">
        <div class="logo">
            <a href="index.php">
                <img src="img/logov3.jpg" alt="Logo">
            </a>
            <nav class="dash-middle">
                <a href="index.php">Home</a>
                <a href="job_list.php">Company review</a>
                <a href="contact.php">Contact</a>
            </nav>
        </div>
        <nav>
            <a class="login-btn" href="./php/login_form.php" style="margin-left: 20px;">Sign in</a>
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="com-btn" href="post_work_Immersion.php">Post Work Immersion</a>
        </nav>

    </header>


    <div class="content-sticky">


        <section>
            <!-- <h2 class="sfa">Search, Find and Apply!</h2 -->
            <div class="line-search">
                <div class="searchwork">
                    <form action="#" method="get">

                        <div class="search-container">
                            <button type="submit"><i class="fas fa-search"></i></button>
                            <input type="text" placeholder="Work Immersion / Keyword">

                        </div>
                        <div class="search-container" style="border-left: 1px solid grey">
                            <button type="submit"><i class="fas fa-map-marker-alt"></i></button>
                            <input type="text" placeholder="Search location">

                        </div>

                        <input class="sub-btn" type="submit" value="Find Now" href="">
                </div>
                </form>
            </div>

        </section>
        <div class="tab-selection">

            <nav style="position:relative; margin-left:auto; margin-right:auto;">
                <a href="index.php">Work Immersion feed</a>
                <a class="active" href="recent-search.php">Recent search</a>



            </nav>
        </div>
        <hr class="line_bottom">
        <!-- ------------------------------------------------------Job list------------------------------>
        <div class="main-container">
            <div class="recent-search">
                <button class="clear-btn" disabled="disabled" onclick="clearRecent()">No recent searches yet</button>
                <div class="recent-search__list"></div>

            </div>
        </div>


        <script>
            document.getElementById("currentDate").innerHTML = new Date().getFullYear();
        </script>

        <script>
            window.onscroll = function() {
                myFunction()
            };

            var header = document.getElementById("myHeader-sticky");
            var sticky = header.offsetTop;

            function myFunction() {
                if (window.pageYOffset > sticky) {
                    header.classList.add("stickyhead");
                } else {
                    header.classList.remove("stickyhead");
                }
            }
        </script>

</body>


</html>