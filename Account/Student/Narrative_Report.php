<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);
$appliedJobAds = fetchAppliedJobAds($conn);
$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

$sql = "SELECT COUNT(*) as eval_count FROM Organization_Evaluation 
        WHERE job_id = :job_id AND evaluation_date = CURDATE() AND evaluator_id = :evaluator_id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':job_id', $student_profile['current_work'], PDO::PARAM_INT);
$stmt->bindParam(':evaluator_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);
$has_evaluation_today = $result['eval_count'] > 0;



function fetchAppliedJobAds($conn) {
    $studentId = $_SESSION['user_id'];
    $query = "
        SELECT 
            jo.work_title 
        FROM 
            job_offers jo
        INNER JOIN 
            applicants a ON jo.id = a.job_id
        WHERE 
            a.student_id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $studentId); 
    $stmt->execute();
    $result = $stmt->get_result();

    $jobTitles = [];
    
    while ($row = $result->fetch_assoc()) {
        $jobTitles[] = $row['work_title'];
    }

    return $jobTitles; 
}
function isApplicantCompleted($pdo, $student_id, $job_id)
{
    $sql = "SELECT status FROM applicants 
            WHERE student_id = :student_id AND job_id = :job_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['status'] === 'completed';
    }

    return false;
}

function isStudentProfileVerified($pdo) {
    $sql = "SELECT verified_status FROM student_profiles WHERE user_id = :user_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return (bool) $result['verified_status']; // Explicitly cast to boolean
        }
    }
    
    return false;
}

$student_id = $_SESSION['user_id']; 

if (!isStudentProfileVerified($pdo)) {
    header('Location: verify.php'); 
    exit(); 
}

$student_id = $_SESSION['user_id'];
 $job_id = $student_profile['current_work']; 
$is_completed = isApplicantCompleted($pdo, $student_id, $job_id);

if ($is_completed) {
    header('Location: Congratulation.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <link rel="stylesheet" href="css/Narrative.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>


</head>

<body>

    <?php echo $profile_div; ?>
    <br><br>
    <hr>
    <div class="logo">

        <!-- <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a class="link" id="#area" href="Company_Area.php"> Company Area</a>
            <a class="link" id="#review" href="Company_Review.php">Company review</a>
            <a class="active1" id="#narrative" href="Narrative_Report.php">Narrative Report</a>
            <a class="link" id="#contact">Contact</a>

            <a href="aboutUs.php">About</a>

        </nav> -->
    </div>
    <hr class="line_bottom">




    <br>
    <div class="titleEF">
        <b>
            <h1 class="sfa">Evaluation Form</h1>
            <div class="box-topic">
                <?php 
    
    if (!empty($appliedJobAds)) {
        echo implode(", ", $appliedJobAds); 
    } else {
        echo "No job applications found.";
    }
    ?>
            </div>
        </b>
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
                <li class="form_4_progessbar">
                    <div>
                        <p>4</p>
                    </div>
                </li>
                <li class="form_5_progessbar">
                    <div>
                        <p>5</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="form_wrap">
            <div class="form_1 data_info">
                <div class="form_container">
                    <div class="questioner">

                        <form id="inputs" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="st">
                                <h3>1. How would you rate the overall quality of your work immersion experience?</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question1" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. How effectively were the tasks assigned to you managed during the immersion?</h3>
                                <div class="sr">
                                    <label class="star empty green" green><input type="radio" name="question2" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. How well did the immersion provide opportunities for you to solve real
                                    challenges? </h3>
                                <div class="sr">
                                    <label class="star empty green" green><input type="radio" name="question3" value="1"
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
                                <h3>4. How thorough was the guidance you received in ensuring high-quality work?</h3>
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
                                <h3>5. How proactive did the immersion encourage you to take on additional tasks or
                                    responsibilities?
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
                <h2>Professionalism</h2>
                <div class="form_container">
                    <div class="questioner">
                        <form id="inputs1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="st">
                                <h3>1. How well did the immersion program emphasize punctuality in arriving and meeting
                                    deadlines?
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
                                <h3>2. How effectively did the immersion set standards for professional attire and
                                    grooming?</h3>
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
                                <h3>3. How effective was the immersion in improving your communication skills with peers
                                    and supervisors?
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
                                <h3>4. How well did the immersion foster a respectful environment among colleagues and
                                    supervisors?
                                </h3>
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
                                <h3>5. How well did the immersion prepare you to adjust to changes in the work
                                    environment or tasks?
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
                <h2>Learning and Development</h2>
                <div class="form_container">
                    <div class="questioner">
                        <form id="inputs2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="st">
                                <h3>1. How open did the immersion make you feel about acquiring new skills and
                                    knowledge?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question11" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. How effectively did the immersion provide opportunities to apply feedback for
                                    performance improvement?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question12" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. How actively did the immersion encourage you to seek opportunities for
                                    self-improvement?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question13" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>4. How well did the immersion facilitate your skill development over the course of
                                    the experience?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question14" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>5. How effectively did the immersion allow you to apply theoretical knowledge to
                                    practical tasks?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question15" value="1"
                                            checked><i class="fa fa-star"></i></label>
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
                        <form id="inputs3" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="st">
                                <h3>1. How actively did the immersion encourage participation in team activities and
                                    discussions?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question16" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. How well did the immersion foster cooperation among participants to achieve
                                    common goals?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question17" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. How effectively did the immersion address conflict resolution within the team?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question18" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>4. How supportive was the environment created by the immersion towards team members?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question19" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question19" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question19" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question19" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question19" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>5. How valuable do you believe your contributions were to the team's success during
                                    the immersion?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question20" value="1"
                                            checked><i class="fa fa-star"></i></label>
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
            <div class="form_5 data_info" style="display: none;">
                <h2>Attitude and Motivation</h2>
                <div class="form_container">

                    <div class="questioner">
                        <form id="inputs4" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="st">
                                <h3>1. How enthusiastic were you about your tasks and responsibilities throughout the
                                    immersion?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question21" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question21" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question21" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question21" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question21" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. How driven did you feel to achieve your goals and exceed expectations during the
                                    immersion?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question22" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question22" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question22" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question22" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question22" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. How well did you handle stress and setbacks experienced during the immersion?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question23" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question23" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question23" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question23" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question23" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>4. How committed were you to completing your work and contributing to the
                                    organization during the immersion?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question24" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question24" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question24" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question24" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question24" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>5. How motivated did you feel to take initiative and pursue your own improvement
                                    throughout the immersion?
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question25" value="1"
                                            checked><i class="fa fa-star"></i></label>
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
                <?php
                
                
                $is_completed;

                if ($is_completed): ?>
                <div class="work-completion-message">
                    Work Immersion Complete
                </div>
                <?php else: ?>
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
                <button type="button" class="btn_next">Next <span class="icon">
                        <ion-icon name="arrow-forward-sharp"></ion-icon>
                    </span></button>
            </div>
            <div class="common_btns form_4_btns" style="display: none;">
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
            </div>

        </div>
    </div>


    <div class="modal_wrapper">
        <div class="shadow"></div>
        <div class="success_wrap">
            <span class="modal_icon">
                <ion-icon name="checkmark-sharp"></ion-icon>
            </span>
            <p>You have successfully completed the Evaluation.</p>
        </div>
    </div>



    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Dr Ramon De Santos National High School</p>

    </footer>

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
    let popup = document.getElementById("popup");

    function openPopup() {

        Swal.fire({
            title: "Successfully send!",
            icon: "success",
            showConfirmButton: false,
            timer: 2500
        });
    }

    function closePopup() {
        popup.classList.remove("open-popup");
    }
    </script>


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

        // Form 1
        for (let i = 1; i <= 5; i++) {
            const radioButtons = form1.querySelectorAll(`[name="question${i}"]`);
            radioButtons.forEach((radioButton) => {
                if (radioButton.checked) {
                    answers.push(radioButton.value);
                }
            });
        }

        // Form 2
        for (let i = 6; i <= 10; i++) {
            const radioButtons = form2.querySelectorAll(`[name="question${i}"]`);
            radioButtons.forEach((radioButton) => {
                if (radioButton.checked) {
                    answers.push(radioButton.value);
                }
            });
        }

        // Form 3
        for (let i = 11; i <= 15; i++) {
            const radioButtons = form3.querySelectorAll(`[name="question${i}"]`);
            radioButtons.forEach((radioButton) => {
                if (radioButton.checked) {
                    answers.push(radioButton.value);
                }
            });
        }

        // Form 4
        for (let i = 16; i <= 20; i++) {
            const radioButtons = form4.querySelectorAll(`[name="question${i}"]`);
            radioButtons.forEach((radioButton) => {
                if (radioButton.checked) {
                    answers.push(radioButton.value);
                }
            });
        }

        // Form 5
        for (let i = 21; i <= 25; i++) {
            const radioButtons = form5.querySelectorAll(`[name="question${i}"]`);
            radioButtons.forEach((radioButton) => {
                if (radioButton.checked) {
                    answers.push(radioButton.value);
                }
            });
        }

        // Create a JSON object
        const jsonData = {};
        for (let i = 0; i < answers.length; i++) {
            jsonData[`question${i + 1}`] = answers[i];
        }
        console.log(jsonData);
        console.log('<?php echo $_SERVER['PHP_SELF']; ?>');
        // Send the JSON data to the PHP script using AJAX
        const url = '../../backend/php/add_student_report.php';
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => {
                // Check if response is OK (status in the range 200-299)
                if (!response.ok) {
                    // Log the raw response even for non 200 status
                    return response.text().then(text => {
                        console.error('Error response:', text); // Log the entire response
                        throw new Error('Network response was not ok: ' + response.statusText);
                    });
                }

                return response.text(); // Get response as text if it's OK
            })
            .then(data => {
                try {
                    // Try to parse the response as JSON
                    const jsonData = JSON.parse(data);

                    // Check if jsonData.status exists and is 'success'
                    if (jsonData.status === 'success') {
                        window.location.reload();
                    } else {
                        console.error('Operation failed:', jsonData);
                    }

                    console.log(jsonData); // Log JSON data
                } catch (e) {
                    // Log the error if JSON parsing fails
                    console.error('Parsing error:', e);
                    console.log('Response data:', data); // Log the raw data for inspection
                }
            })
            .catch(error => {
                // Catch network errors or parsing errors
                console.error('Error:', error);
            });
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
    </script>

    <script>
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