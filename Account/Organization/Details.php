<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();
require_once 'show_profile.php';

function getStudentCounts($partner_user_id)
{
    $host = "localhost";
    $username = $_ENV['MYSQL_USERNAME'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $database = $_ENV['MYSQL_DBNAME'];
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $counts = [
        'total_students' => 0,
        'approved_students' => 0,
        'pending_students' => 0
    ];

    // Get job IDs for the partner
    $sql_jobs = "SELECT id FROM job_offers WHERE partner_id = ?";
    $stmt_jobs = $conn->prepare($sql_jobs);
    $stmt_jobs->bind_param("i", $partner_user_id);
    $stmt_jobs->execute();
    $job_ids_result = $stmt_jobs->get_result();

    // Collect job IDs
    $job_ids = [];
    while ($row = $job_ids_result->fetch_assoc()) {
        $job_ids[] = $row['id'];
    }

    if (!empty($job_ids)) {
        // Count total applied students for these job IDs
        $job_ids_placeholder = implode(',', array_fill(0, count($job_ids), '?'));
        $sql_total = "SELECT COUNT(DISTINCT student_id) as total FROM applicants WHERE job_id IN ($job_ids_placeholder)";
        $stmt_total = $conn->prepare($sql_total);
        $stmt_total->bind_param(str_repeat('i', count($job_ids)), ...$job_ids);
        $stmt_total->execute();
        $result_total = $stmt_total->get_result();
        $counts['total_students'] = $result_total->fetch_assoc()['total'];

        // Count approved students for these job IDs
        $sql_approved = "SELECT COUNT(DISTINCT student_id) as approved FROM applicants WHERE job_id IN ($job_ids_placeholder) AND status = 'accepted'";
        $stmt_approved = $conn->prepare($sql_approved);
        $stmt_approved->bind_param(str_repeat('i', count($job_ids)), ...$job_ids);
        $stmt_approved->execute();
        $result_approved = $stmt_approved->get_result();
        $counts['approved_students'] = $result_approved->fetch_assoc()['approved'];

        // Count pending students for these job IDs
        $sql_pending = "SELECT COUNT(DISTINCT student_id) as pending FROM applicants WHERE job_id IN ($job_ids_placeholder) AND NOT status = 'accepted'";
        $stmt_pending = $conn->prepare($sql_pending);
        $stmt_pending->bind_param(str_repeat('i', count($job_ids)), ...$job_ids);
        $stmt_pending->execute();
        $result_pending = $stmt_pending->get_result();
        $counts['pending_students'] = $result_pending->fetch_assoc()['pending'];
    }

    $conn->close();
    return $counts;
}

$studentCounts = getStudentCounts($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->
    <link rel="stylesheet" type="text/css" href="css/Details.css">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>


    <script src="./css/analytics.js"></script>

</head>

<body>
    <?php echo $profile_div; ?>


    <br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"><i class="fa fa-calendar-plus-o"></i> Job Ads</a>
            <a href="Job_request.php"><i class="fa fa-user-plus"></i>Job Request</a>
            <a href="Faculty_report.php"><i class='fas fa-tasks'></i>Student Evaluation</a>
            <!-- <a href="Question.php">Questions</a> -->
            <a class="active" href="Details.php"><i class="fa fa-bar-chart"></i>Analytics</a>


        </nav>
    </div>
    <hr class="line_bottom">


    <div class="bgc">

        <div class="container-data-box">

            <div class="data-box">

                <p><?php echo $studentCounts['total_students']; ?></p>
                <label>Total of Student</label>
            </div>

            <div class="data-box">

                <p><?php echo $studentCounts['approved_students']; ?></p>
                <label>Total of Deployment</label>
            </div>

            <div class="data-box">

                <p><?php echo $studentCounts['pending_students'] ?></p>
                <label>Total of Request Applicant</label>
            </div>
        </div>


        <div class="row-analytics">

            <div class="column-1">
                <h3 class="title">Company Performance</h3>
                <div class="dp-graph" id="com_chart_div">
                </div>


            </div>
            <div class="column">
                <h3 class="title">Total Strand Workspace</h3>
                <div class="dp-graph-strand" id="piechart_3d"></div>



            </div>


        </div>

        <!-- <hr class="line_bottom"> -->

        <div class="container mt-5">
            <div class="form-group">
                <!-- <select id="product-select" class="form-control custom-select">
                    <option value="0" disabled selected>Select Product</option>
                    <option value="sony">Sony 4K TV</option>
                    <option value="samsung">Samsung 4K TV</option>
                    <option value="vizio">Vizio 4K TV</option>
                    <option value="panasonic">Panasonic 4K TV</option>
                    <option value="phillips">Phillips 4K TV</option>
                </select> -->
                <!-- <input type="text" class="input-search-bar-job-title" id="searchInput" placeholder="Search job title..." /> -->
                <div class="group">
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="icon">
                        <g>
                            <path
                                d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                        </g>
                    </svg>
                    <input class="input-search-bar-job-title" id="searchInput" type="text" placeholder="Search job title" />
                </div>
            </div>


            <table class="table table-striped" id="job-title">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="job_title">
                        <td>IT Specialist</td>
                        <td>
                            <div class="stars-outer">
                                <div class="stars-inner"></div>
                            </div>
                            <span class="number-rating"></span>
                            <div class="rating-users">
                                <i class="icon-user"></i> 100 total student
                            </div>
                        </td>
                    </tr>
                    <tr class="job_title_1">
                        <td>Software Developer inter</td>
                        <td>
                            <div class="stars-outer">
                                <div class="stars-inner"></div>
                            </div>
                            <span class="number-rating"></span>
                            <div class="rating-users">
                                <i class="icon-user"></i>50 total student
                            </div>
                        </td>
                    </tr>
                    <tr class="job_title_2">
                        <td>Frontend Developer Intern</td>
                        <td>
                            <div class="stars-outer">
                                <div class="stars-inner"></div>
                            </div>
                            <span class="number-rating"></span>
                            <div class="rating-users">
                                <i class="icon-user"></i>30 total student
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>


    <br>

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p>
    </footer>
    <script>
        // Initial Ratings
        const ratings = {
            job_title: 4.7,
            job_title_1: 3.4,
            job_title_2: 2.3,

        }

        // Total Stars
        const starsTotal = 5;

        // Run getRatings when DOM loads
        document.addEventListener('DOMContentLoaded', getRatings);

        // Form Elements
        const productSelect = document.getElementById('product-select');
        const ratingControl = document.getElementById('rating-control');

        // Init product
        let product;

        // Product select change
        productSelect.addEventListener('change', (e) => {
            product = e.target.value;
            // Enable rating control
            ratingControl.disabled = false;
            ratingControl.value = ratings[product];
        });

        // Rating control change
        ratingControl.addEventListener('blur', (e) => {
            const rating = e.target.value;

            // Make sure 5 or under
            if (rating > 5) {
                alert('Please rate 1 - 5');
                return;
            }

            // Change rating
            ratings[product] = rating;

            getRatings();
        });

        // Get ratings
        function getRatings() {
            for (let rating in ratings) {
                // Get percentage
                const starPercentage = (ratings[rating] / starsTotal) * 100;

                // Round to nearest 10
                const starPercentageRounded = `${Math.round(starPercentage / 10) * 10}%`;

                // Set width of stars-inner to percentage
                document.querySelector(`.${rating} .stars-inner`).style.width = starPercentageRounded;

                // Add number rating
                document.querySelector(`.${rating} .number-rating`).innerHTML = ratings[rating];
            }
        }
    </script>

    <script>
        let profilePic1 = document.getElementById("cover-pic");
        let inputFile1 = document.getElementById("input-file1");

        inputFile1.onchange = function() {
            profilePic1.src = URL.createObjectURL(inputFile1.files[0])
        };
    </script>

    <script>
        let profilePic2 = document.getElementById("profile-pic");
        let inputFile2 = document.getElementById("input-file2");

        inputFile2.onchange = function() {
            profilePic2.src = URL.createObjectURL(inputFile2.files[0])
        };
    </script>


    <script>
        document.getElementById('searchInput').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                filterTable();
            }
        });

        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('job-title');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[0]; // Search in the first column
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
                }
            }
        }
    </script>
    <!-- 
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>