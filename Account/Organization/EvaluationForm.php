<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';

$currentUrl = $_SERVER['REQUEST_URI'];
$urlParts = parse_url($currentUrl);
if (isset($urlParts['query'])) {
    parse_str($urlParts['query'], $queryParameters);
    if (isset($queryParameters['student_id'])) {
        $IdParam = $queryParameters['student_id'];
    }
} else {
    echo "Query string parameter not found.";
}

$user_id = decrypt_url_parameter(base64_decode($IdParam));

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

$sql = "SELECT COUNT(*) as eval_count FROM Student_Evaluation 
        WHERE student_id = :student_id AND evaluation_date = CURDATE()";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':student_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);
$has_evaluation_today = $result['eval_count'] > 0;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Evaluation Form</title>
    <link rel="stylesheet" type="text/css" href="css/EvaluationForm.css">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>

<body>
    <!-- Navbar top -->
    <style>
        /* NavbarTop */


        /* End */
    </style>
    <div class="navbar-top">
        <div class="title">
            <h1 style="color:#ffff; font-weight: bold">Student Evaluation</h1>
        </div>
        <ul>
            <li>
                <a href="../../Account/<?= $_SESSION['account_type']; ?>">
                    <i class=" fa fa-sign-out-alt fa-2x"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- End -->
    <div class="container-rating">
        <h3>Star rating:</h3>
        <ol>
            <li><b>1=Did not meet job requirements.</b> Significant performance improvement urgently needed.
            </li>
            <li><b>2=Met minimum job requirements.</b> Work improvement plan was needed to bring performance to a satisfactory level.</li>
            <li><b>3=Met normal job requirements with few exceptions.</b> Improvements in performance needed in one or more elements.</li>
            <li><b>4=Fully met job requirements.</b> Performance was what was expected of a person in his/her position.</li>
            <li><b>5=Exceeded job requirements.</b> Student performance was impressive, exceeded what is normally expected in this position.</li>

        </ol>
    </div>
    <div class="wrapper">
        <div class="header1">
            <ul>
                <li class="active form_1_progessbar">
                    <div>
                        <p>1</p>
                    </div>
                </li>
                <li class="form_2_progessbar">
                    <div>
                        <p>2</p>
                    </div>
                </li>
                <li class="form_3_progessbar">
                    <div>
                        <p>3</p>
                    </div>
                </li>
                <!-- <li class="form_4_progessbar">
                    <div>
                        <p>4</p>
                    </div>
                </li>
                <li class="form_5_progessbar">
                    <div>
                        <p>5</p>
                    </div>
                </li> -->
            </ul>
        </div>

        <div class="form_wrap">
            <div class="form_1 data_info">
                <h2>WORK HABITS</h2>

                <div class="form_container">
                    <div class="questioner">

                        <form id="inputs">
                            <div class="st">
                                <h3>1. Punctual</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question1" value="1"
                                            checked checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. Reports regularly</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question2" value="1"
                                            checked checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. Performs tasks without much supervision </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question3" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question3" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question3" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question3" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question3" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>4. Practices self-discipline in his/her work</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question4" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question4" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question4" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question4" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question4" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>5. Demonstrates dedication and commitment to the task assigned to him/her
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question5" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question5" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question5" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question5" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question5" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>



            <div class="form_2 data_info" style="display: none;">
                <h2>WORK SKILLS</h2>
                <div class="form_container">
                    <div class="questioner">
                        <form id="inputs1">
                            <div class="st">
                                <h3>1. Demonstrate the ability to operate machines needed on the job
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question6" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question6" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question6" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question6" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question6" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. Handles the details of the work assigned to him/her</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question7" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question7" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question7" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question7" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question7" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. Shows flexibility (whenever the need arises) in the process of going through his or her task
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question8" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question8" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question8" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question8" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question8" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>4. Manifest thoroughness and precise attention to details </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question9" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question9" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question9" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question9" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question9" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>5. Fully understand the linkage or connection between his/her task to previous interviewing and subsequent tasks </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question10" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>6. Usually comes up with sound suggestion to problems
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question10" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>

                            </div>
                        </form>
                    </div>

                    <!-- <div class="input_wrap">
                            <label for="user_name">User Name</label>
                            <input type="text" name="User Name" class="input" id="user_name">
                        </div>
                        <div class="input_wrap">
                            <label for="first_name">First Name</label>
                            <input type="text" name="First Name" class="input" id="first_name">
                        </div>
                        <div class="input_wrap">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="Last Name" class="input" id="last_name">
                        </div> -->
                </div>
            </div>
            <div class="form_3 data_info" style="display: none;">
                <h2>SOCIAL SKILLS</h2>
                <div class="form_container">
                    <div class="questioner">
                        <form id="inputs2">
                            <div class="st">
                                <h3>1. Shows tact in dealing with different people he/she comes in contact with
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question11" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. Shows respect and courtesy in dealing with peers and superiors
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question12" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. Willingly helps others (whenever necessary) in the performance of their task.
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question13" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>4. Is capable of learning from and listening to co-workers.
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question14" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>5. Shows appreciation and gratitude for any form of assistance granted to him/her by others.
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question15" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>6. Shows poise, self-confidence and is always well-groomed.
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question15" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>7. Shows emotional maturity.
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question15" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>

                            </div>
                        </form>
                    </div>

                    <!-- <div class="input_wrap">
                            <label for="company">Current Company</label>
                            <input type="text" name="Current Company" class="input" id="company">
                        </div>
                        <div class="input_wrap">
                            <label for="experience">Total Experience</label>
                            <input type="text" name="Total Experience" class="input" id="experience">
                        </div>
                        <div class="input_wrap">
                            <label for="designation">Designation</label>
                            <input type="text" name="Designation" class="input" id="designation">
                        </div> -->
                </div>
            </div>
            <div class="form_4 data_info" style="display: none;">
                <h2>Teamwork and Collaboration</h2>
                <div class="form_container">

                    <div class="questioner">
                        <form id="inputs3">
                            <div class="st">
                                <h3>1. How actively does the student participate in team activities and discussions?
                                </h3>
                                <div class="sr">
                                    <label class="star empty"><input type="radio" name="question16" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. How well does the student work with others to achieve common goals?
                                </h3>
                                <div class="sr">
                                    <label class="star empty"><input type="radio" name="question17" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. How effectively does the student handle conflicts within the team?
                                </h3>
                                <div class="sr">
                                    <label class="star empty"><input type="radio" name="question18" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>4. How supportive is the student towards their team members?
                                </h3>
                                <div class="sr">
                                    <label class="star empty"><input type="radio" name="question19" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question19" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question19" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question19" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question19" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>5. How valuable are the student's contributions to the team’s success?
                                </h3>
                                <div class="sr">
                                    <label class="star empty"><input type="radio" name="question20" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question20" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question20" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question20" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question20" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="form_5 data_info" style="display: none;">
                <h2>Attitude and Motivation</h2>
                <div class="form_container">

                    <div class="questioner">
                        <form id="inputs4">
                            <div class="st">
                                <h3>1. How enthusiastic is the student about their tasks and responsibilities?
                                </h3>
                                <div class="sr">
                                    <label class="star empty"><input type="radio" name="question21" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question21" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question21" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question21" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question21" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. How driven is the student to achieve their goals and exceed expectations?
                                </h3>
                                <div class="sr">
                                    <label class="star empty"><input type="radio" name="question22" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question22" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question22" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question22" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question22" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. How well does the student handle stress and setbacks?
                                </h3>
                                <div class="sr">
                                    <label class="star empty"><input type="radio" name="question23" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question23" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question23" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question23" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question23" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>4. How committed is the student to completing their work and contributing to the
                                    organization?
                                </h3>
                                <div class="sr">
                                    <label class="star empty"><input type="radio" name="question24" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question24" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question24" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question24" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question24" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>5. How motivated is the student to take initiative and pursue their own improvement?
                                </h3>
                                <div class="sr">
                                    <label class="star empty"><input type="radio" name="question25" value="1" checked><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question25" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question25" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question25" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question25" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>

                            </div>
                        </form>
                    </div>
                    <!-- <div class="input_wrap">
                            <label for="company">Current Company</label>
                            <input type="text" name="Current Company" class="input" id="company">
                        </div>
                        <div class="input_wrap">
                            <label for="experience">Total Experience</label>
                            <input type="text" name="Total Experience" class="input" id="experience">
                        </div>
                        <div class="input_wrap">
                            <label for="designation">Designation</label>
                            <input type="text" name="Designation" class="input" id="designation">
                        </div> -->
                </div>

            </div>
        </div>
        <div class="btns_wrap">
            <div class="common_btns form_1_btns">
                <?php if ($has_evaluation_today): ?>
                    <button type="button" class="btn_next" disabled>
                        <span class="time-remaining"></span>
                    </button>
                <?php else: ?>
                    <button type="button" class="btn_next">Next <span class="icon">
                            <span class="icon">
                                <ion-icon name="arrow-forward-sharp"></ion-icon>
                            </span>
                    </button>
                <?php endif; ?>
            </div>
            <div class="common_btns form_2_btns" style="display: none;">
                <button type="button" class="btn_back"><span class="icon">
                        <ion-icon name="arrow-back-sharp"></ion-icon>
                    </span>Back</button>
                <button type="button" class="btn_next">Next <span class="icon">
                        <ion-icon name="arrow-forward-sharp"></ion-icon>
                    </span></button>
            </div>
            <div class="common_btns form_3_btns" style="display: none;">
                <button type="button" class="btn_back"><span class="icon">
                        <ion-icon name="arrow-back-sharp"></ion-icon>
                    </span>Back</button>
                <!-- <button type="button" class="btn_next">Next <span class="icon">
                        <ion-icon name="arrow-forward-sharp"></ion-icon>
                    </span></button> -->
                <button type="button" class="btn_done">Done</button>
            </div>
            <!-- <div class="common_btns form_4_btns" style="display: none;">
                <button type="button" class="btn_back"><span class="icon">
                        <ion-icon name="arrow-back-sharp"></ion-icon>
                    </span>Back</button>
                <button type="button" class="btn_next">Next <span class="icon">
                        <ion-icon name="arrow-forward-sharp"></ion-icon>
                    </span></button>
            </div>
            <div class="common_btns form_5_btns" style="display: none;">
                <button type="button" class="btn_back"><span class="icon">
                        <ion-icon name="arrow-back-sharp"></ion-icon>
                    </span>Back</button>
                <button type="button" class="btn_done">Done</button>
            </div> -->

        </div>
    </div>


    <div class="modal_wrapper">
        <div class="shadow"></div>
        <div class="success_wrap">
            <span class="modal_icon">
                <ion-icon name="checkmark-sharp"></ion-icon>
            </span>
            <p>You have successfully completed the process.</p>
        </div>
    </div>

    <script>
        <?php if ($has_evaluation_today): ?>

            const now = new Date();
            const midnight = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1);
            let countdown = Math.floor((midnight - now) / 1000);

            let countdownElement = document.querySelector('.time-remaining');

            function updateCountdown() {
                let hours = Math.floor(countdown / 3600);
                let minutes = Math.floor((countdown % 3600) / 60);
                let seconds = countdown % 60;
                countdownElement.textContent = `${hours}h ${minutes}m ${seconds}s`;
                countdown--;

                if (countdown < 0) {

                    location.reload();
                }
            }

            setInterval(updateCountdown, 1000);
        <?php endif; ?>
    </script>

    <script>
        var form_1 = document.querySelector(".form_1");
        var form_2 = document.querySelector(".form_2");
        var form_3 = document.querySelector(".form_3");
        var form_4 = document.querySelector(".form_4");
        var form_5 = document.querySelector(".form_5");

        var form_1_btns = document.querySelector(".form_1_btns");
        var form_2_btns = document.querySelector(".form_2_btns");
        var form_3_btns = document.querySelector(".form_3_btns");
        var form_4_btns = document.querySelector(".form_4_btns");
        var form_5_btns = document.querySelector(".form_5_btns");

        var form_1_next_btn = document.querySelector(".form_1_btns .btn_next");
        var form_2_back_btn = document.querySelector(".form_2_btns .btn_back");
        var form_2_next_btn = document.querySelector(".form_2_btns .btn_next");
        var form_3_back_btn = document.querySelector(".form_3_btns .btn_back");
        var form_3_next_btn = document.querySelector(".form_3_btns .btn_next");
        var form_4_back_btn = document.querySelector(".form_4_btns .btn_back");
        var form_4_next_btn = document.querySelector(".form_4_btns .btn_next");
        var form_5_back_btn = document.querySelector(".form_5_btns .btn_back");

        var form_2_progessbar = document.querySelector(".form_2_progessbar");
        var form_3_progessbar = document.querySelector(".form_3_progessbar");
        var form_4_progessbar = document.querySelector(".form_4_progessbar");
        var form_5_progessbar = document.querySelector(".form_5_progessbar");

        var btn_done = document.querySelector(".btn_done");
        var modal_wrapper = document.querySelector(".modal_wrapper");
        var shadow = document.querySelector(".shadow");

        form_1_next_btn.addEventListener("click", function() {
            form_1.style.display = "none";
            form_2.style.display = "block";

            form_1_btns.style.display = "none";
            form_2_btns.style.display = "flex";

            form_2_progessbar.classList.add("active");
        });

        form_2_back_btn.addEventListener("click", function() {
            form_1.style.display = "block";
            form_2.style.display = "none";

            form_1_btns.style.display = "flex";
            form_2_btns.style.display = "none";

            form_2_progessbar.classList.remove("active");
        });

        form_2_next_btn.addEventListener("click", function() {
            form_2.style.display = "none";
            form_3.style.display = "block";

            form_3_btns.style.display = "flex";
            form_2_btns.style.display = "none";

            form_3_progessbar.classList.add("active");
        });

        form_3_back_btn.addEventListener("click", function() {
            form_2.style.display = "block";
            form_3.style.display = "none";

            form_3_btns.style.display = "none";
            form_2_btns.style.display = "flex";

            form_3_progessbar.classList.remove("active");
        });

        form_3_next_btn.addEventListener("click", function() {
            form_3.style.display = "none";
            form_4.style.display = "block";

            form_4_btns.style.display = "flex";
            form_3_btns.style.display = "none";

            form_4_progessbar.classList.add("active");
        });

        form_4_back_btn.addEventListener("click", function() {
            form_3.style.display = "block";
            form_4.style.display = "none";

            form_4_btns.style.display = "none";
            form_3_btns.style.display = "flex";

            form_4_progessbar.classList.remove("active");
        });

        form_4_next_btn.addEventListener("click", function() {
            form_4.style.display = "none";
            form_5.style.display = "block";

            form_5_btns.style.display = "flex";
            form_4_btns.style.display = "none";

            form_5_progessbar.classList.add("active");
        });

        form_5_back_btn.addEventListener("click", function() {
            form_4.style.display = "block";
            form_5.style.display = "none";

            form_5_btns.style.display = "none";
            form_4_btns.style.display = "flex";

            form_5_progessbar.classList.remove("active");
        });

        var form1 = document.getElementById('inputs');
        var form2 = document.getElementById('inputs1');
        var form3 = document.getElementById('inputs2');
        var form4 = document.getElementById('inputs3');
        var form5 = document.getElementById('inputs4');

        btn_done.addEventListener("click", function() {
            // Get the radio button values
            const answers = [];

            function collectAnswers(form, startIndex) {
                for (let i = 0; i < 5; i++) {
                    const questionIndex = startIndex + i;
                    const radioButtons = form.querySelectorAll(`[name="question${questionIndex}"]`);
                    let selectedValue = "1";

                    radioButtons.forEach((radioButton) => {
                        if (radioButton.checked) {
                            selectedValue = radioButton.value;
                        }
                    });
                    answers.push(selectedValue);
                }
            }

            collectAnswers(form1, 1);
            collectAnswers(form2, 6);
            collectAnswers(form3, 11);
            collectAnswers(form4, 16);
            collectAnswers(form5, 21);

            const urlParams = new URLSearchParams(window.location.search);
            const studentId = urlParams.get('student_id');

            const jsonData = {};
            for (let i = 0; i < answers.length; i++) {
                jsonData[`question${i + 1}`] = answers[i];
            }

            jsonData.student_id = studentId;
            console.log(jsonData);
            console.log('<?php echo $_SERVER['PHP_SELF']; ?>');

            const url = '../../backend/php/add_organization_report.php';
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(jsonData)
                })
                .then(response => {

                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.text();
                })
                .then(data => {

                    try {
                        const jsonData = JSON.parse(data);
                        console.log(jsonData);


                        if (jsonData.status === 'success') {
                            window.location.reload();
                        }
                    } catch (e) {
                        console.error('Parsing error:', e, 'Response data:', data);
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        shadow.addEventListener("click", function() {
            modal_wrapper.classList.remove("active");
        });
    </script>

    <script>
        const form = document.querySelector('form');
        form.addEventListener('submit', event => {
            const formData = new FormData(event.target);
            const rating = formData.get('rating');
            console.log(rating);
            event.preventDefault();
        });
    </script>

    <script>
        var inputsForm = document.querySelector("#inputs");
        inputsForm.onchange = function(e) {
            if (e.target.type = "radio") {
                var stars = document.querySelectorAll(`[name='${e.target.name}']`);
                for (var i = 0; i < stars.length; i++) {
                    if (i < e.target.value) {
                        stars[i].parentElement.classList.replace("empty", "green");
                    } else {
                        stars[i].parentElement.classList.replace("green", "empty");
                    }
                }
            }
        }

        // just for showing the values (not required only for testing)
        inputsForm.onsubmit = function() {
            console.log(
                ` ${this.question1.value}\n ${this.question2.value}\n${this.question3.value}\n${this.question4.value}\n${this.question5.value}`
            );
            return false;
        }
    </script>

    <script>
        var inputsForm = document.querySelector("#inputs1");
        inputsForm.onchange = function(e) {
            if (e.target.type = "radio") {
                var stars = document.querySelectorAll(`[name='${e.target.name}']`);
                for (var i = 0; i < stars.length; i++) {
                    if (i < e.target.value) {
                        stars[i].parentElement.classList.replace("empty", "green");
                    } else {
                        stars[i].parentElement.classList.replace("green", "empty");
                    }
                }
            }
        }

        // just for showing the values (not required only for testing)
        inputsForm.onsubmit = function() {
            console.log(
                ` ${this.question6.value}\n ${this.question7.value}\n${this.question8.value}\n${this.question9.value}\n${this.question0.value}`
            );
            return false;
        }
    </script>
    <script>
        var inputsForm = document.querySelector("#inputs2");
        inputsForm.onchange = function(e) {
            if (e.target.type = "radio") {
                var stars = document.querySelectorAll(`[name='${e.target.name}']`);
                for (var i = 0; i < stars.length; i++) {
                    if (i < e.target.value) {
                        stars[i].parentElement.classList.replace("empty", "green");
                    } else {
                        stars[i].parentElement.classList.replace("green", "empty");
                    }
                }
            }
        }

        // just for showing the values (not required only for testing)
        inputsForm.onsubmit = function() {
            console.log(
                ` ${this.question11.value}\n ${this.question12.value}\n${this.question13.value}\n${this.question14.value}\n${this.question15.value}`
            );
            return false;
        }

        var inputsForm = document.querySelector("#inputs3");
        inputsForm.onchange = function(e) {
            if (e.target.type = "radio") {
                var stars = document.querySelectorAll(`[name='${e.target.name}']`);
                for (var i = 0; i < stars.length; i++) {
                    if (i < e.target.value) {
                        stars[i].parentElement.classList.replace("empty", "green");
                    } else {
                        stars[i].parentElement.classList.replace("green", "empty");
                    }
                }
            }
        }

        // just for showing the values (not required only for testing)
        inputsForm.onsubmit = function() {
            console.log(
                ` ${this.question16.value}\n ${this.question17.value}\n${this.question18.value}\n${this.question19.value}\n${this.question20.value}`
            );
            return false;
        }
    </script>
    <script>
        var inputsForm = document.querySelector("#inputs4");
        inputsForm.onchange = function(e) {
            if (e.target.type = "radio") {
                var stars = document.querySelectorAll(`[name='${e.target.name}']`);
                for (var i = 0; i < stars.length; i++) {
                    if (i < e.target.value) {
                        stars[i].parentElement.classList.replace("empty", "green");
                    } else {
                        stars[i].parentElement.classList.replace("green", "empty");
                    }
                }
            }
        }

        // just for showing the values (not required only for testing)
        inputsForm.onsubmit = function() {
            console.log(
                ` ${this.question21.value}\n ${this.question22.value}\n${this.question23.value}\n${this.question24.value}\n${this.question25.value}`
            );
            return false;
        }
    </script>

</body>

</html>