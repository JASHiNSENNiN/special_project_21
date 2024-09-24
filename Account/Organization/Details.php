<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';


$company_Name = "National Irrigation Administration Careers and
                Employment";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <link rel="stylesheet" type="text/css" href="css/Details.css">


    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>


    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>

    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Work', 11],
                ['Eat', 2],
                ['Commute', 2],
                ['Watch TV', 2],
                ['Sleep', 7]
            ]);

            var options = {
                title: 'My Daily Activities',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>
    <script>
        var options = {
            chart: {
                type: 'bar'
            },
            series: [{
                name: 'sales',
                data: [30, 40, 45, 50, 49, 60, 70, 91, 125]
            }],
            xaxis: {
                categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999]
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>

</head>

<body>
    <?php echo $profile_div; ?>


    <br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"> Job Ads</a>
            <a href="Job_request.php">Job Request</a>
            <a href="Faculty_report.php">Student Evaluation</a>
            <a href="Question.php">Questions</a>
            <a class="active" href="Details.php">Analytics</a>


        </nav>
    </div>
    <hr class="line_bottom">
    <div class="bgc">

        <div class="row">

            <div class="column">
                <h1 class="title">Student Population</h1>
                <!-- <div id="myChart2" class="Chart2"></div> -->
                <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
            </div>
        </div>

        <hr class="line_bottom">

        <div class="container4">
            <h1 class="Time">Student Timeline</h1>
            <!-- <div id="timeline" style="height: 180px;"></div> -->
            <div id="chartres">
            </div>
        </div>

        <div class="snapshot_container">
            <label style="font-size: .75rem; color: #595959;"><?php echo $company_Name ?></label>
            <h1 style="font-size: 1.75rem; margin:0%; margin: bottom 20px; margin-block-end: 1rem;">About the company
            </h1>


            <!-- <div class="api_card">
                <div class="api_details">
                    <span class="api_title">Ceo</span></br>
                    <span class="api_details_one">Robert Victor G. Seares, Jr.</span></br>
                    <div class="rating">62%</div></br>
                    <span class="api_details_two">approve of Robert Victor G. Seares, Jr. performance</span></br>


                </div>

            </div> -->
            <div class="section-wrap">
                <div class="api_card_half">
                    <div class="api_details">
                        <p class="api_title">Ceo</p></br>
                        <span class="api_details_one">Robert Victor G. Seares, Jr.</span>
                    </div>

                </div>

            </div>

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
                        <a class="api_details_one" style="color: #2557a7;" href="https://www.nia.gov.ph/">NIA
                            Philippines <svg xmlns="http://www.w3.org/2000/svg" focusable="false" role="img"
                                fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"
                                class=" css-1jtd2m7 eac13zx0">
                                <title>Opens in a new window</title>
                                <path
                                    d="M14.504 3a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h3.085l-9.594 9.594a.5.5 0 000 .707l.707.708a.5.5 0 00.707 0l9.594-9.595V9.5a.5.5 0 00.5.5h1a.5.5 0 00.5-.5v-6a.5.5 0 00-.5-.5h-6z">
                                </path>
                                <path
                                    d="M5 3.002a2 2 0 00-2 2v13.996a2 2 0 001.996 2.004h14a2 2 0 002-2v-6.5a.5.5 0 00-.5-.5h-1a.5.5 0 00-.5.5v6.5L5 18.998V5.002L11.5 5a.495.495 0 00.496-.498v-1a.5.5 0 00-.5-.5H5z">
                                </path>
                            </svg></a>
                    </div>

                </div>
            </div>
            <h1 style="font-size: 1.75rem; margin:0%; margin: bottom 20px; margin-block-end: 1rem;">Rating overview</h1>
            <label style="font-size: .75rem; color: #595959;">Rating is calculated based on <span
                    class="total-reviews">0</span> reviews and is evolving.</label>

        </div>
    </div>

    <div class="container-rating">
        <div class="global">
            <span class="global-value">0.0</span>
            <div class="rating-icons">
                <span class="one"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                        class="fas fa-star"></i><i class="fas fa-star"></i></span>
                <span class="two"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                        class="fas fa-star"></i><i class="fas fa-star"></i></span>
            </div>
            <!-- <span class="rev-title"> Base on
                <span class="total-reviews">0</span> reviews</span> -->
        </div>
        <div class="chart">
            <div class="rate-box">
                <span class="value">5</span>
                <div class="progress-bar">
                    <span class="progress"></span>
                </div>
                <span class="count">0</span>
            </div>
            <div class="rate-box">
                <span class="value">4</span>
                <div class="progress-bar"><span class="progress"></span></div>
                <span class="count">0</span>
            </div>
            <div class="rate-box">
                <span class="value">3</span>
                <div class="progress-bar"><span class="progress"></span></div>
                <span class="count">0</span>
            </div>
            <div class="rate-box">
                <span class="value">2</span>
                <div class="progress-bar"><span class="progress"></span></div>
                <span class="count">0</span>
            </div>
            <div class="rate-box">
                <span class="value">1</span>
                <div class="progress-bar"><span class="progress"></span></div>
                <span class="count">0</span>
            </div>
        </div>
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
                    <div class="profileUser">
                        <!--img---->
                        <div class="user-img">
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
                    <p>Working on this company is a good experience it is because it is related to the course I've taken
                        in college as a Bachelor of Science and Social Work also the company memmber is a hard worker
                        ang responsible for their work in the company. Other than that our relationship as a member of
                        the company is good as we can united at the problem we are facing .</p>
                </div>
            </div>
            <!--BOX-2-------------->
            <div class="testimonial-box">
                <!--top------------------------->
                <div class="box-top">
                    <!--profile----->
                    <div class="profileUser">
                        <!--img---->
                        <div class="user-img">
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
                    <p>Good in cooperation and research study you will learned to coordinate in the Lgu and other
                        government agencies in the feasibility study sometimes they challenge you to finish investigate
                        the subject area for the proposed irrigation project.</p>
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



    <script>
        let circularProgress =

            document.querySelector('.circular-progress'),

            progressValue =

            document.querySelector('.progress-value');



        let progressStartValue = 0,

            progressEndValue = 50,

            speed = 20;



        let progress = setInterval(() => {

            progressStartValue++;



            progressValue.textContent =

                `${progressStartValue}%`;



            circularProgress.style.background =

                `conic-gradient(#7d2ae8 ${progressStartValue

                * 3.6}deg, #ededed 0deg)`;

            //3.6deg * 100 = 360deg

            //3.6deg * 90 = 324deg





            if (progressStartValue == progressEndValue) {

                clearInterval(progress);



            }

            console.log(progressStartValue);

        }, speed);
    </script>

    <script>
        google.charts.load('current', {
            'packages': ['timeline']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var container = document.getElementById('timeline');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();

            dataTable.addColumn({
                type: 'string',
                id: 'President'
            });
            dataTable.addColumn({
                type: 'date',
                id: 'Start'
            });
            dataTable.addColumn({
                type: 'date',
                id: 'End'
            });
            dataTable.addRows([
                ['Joshua Rivera ', new Date(2024, 1, 30), new Date(2025, 1, 4)],
                ['Dan Mamaid', new Date(2024, 1, 4), new Date(2025, 1, 4)],
                ['Jefferson Dela cruz', new Date(2024, 1, 4), new Date(2025, 1, 4)]
            ]);

            chart.draw(dataTable);
        }
    </script>


</body>

</html>