<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once 'student_profile.php';
(Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/'))->load();

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

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM student_profiles WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $student_profile = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $currentWorkId = $student_profile['current_work'];
    if ($currentWorkId) {
        $sql = "SELECT work_title FROM job_offers WHERE id = :job_offer_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':job_offer_id', $currentWorkId);
        $stmt->execute();
        $job_offer = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $job_offer = null;
    }
    $currentWork = $job_offer ? $job_offer['work_title'] : 'No current work';
    $firstName = $student_profile['first_name'];
    $middleName = $student_profile['middle_name'];
    $lastName = $student_profile['last_name'];
    $fullName = trim($firstName . ' ' . $middleName . ' ' . $lastName);
    $school = $student_profile['school'];
    $gradeLevel = $student_profile['grade_level'];
    $strand = strtoupper($student_profile['strand']);
    $stars = $student_profile['stars'];
    $email = $user['email'];
    $profile_image_path = './uploads/' . $user['profile_image'];
    if (file_exists($profile_image_path)) {
        $get_profile_image = $profile_image_path;
    } else {
        $get_profile_image = "/image/default.png";
    }
    $profile_image = ($get_profile_image === './uploads/') ? './image/default.png' : $get_profile_image;

    $sql = "SELECT 
                AVG(quality_of_work) AS avg_quality_of_work,
                AVG(productivity) AS avg_productivity,
                AVG(problem_solving_skills) AS avg_problem_solving_skills,
                AVG(attention_to_detail) AS avg_attention_to_detail,
                AVG(initiative) AS avg_initiative,
                AVG(punctuality) AS avg_punctuality,
                AVG(appearance) AS avg_appearance,
                AVG(communication_skills) AS avg_communication_skills,
                AVG(respectfulness) AS avg_respectfulness,
                AVG(adaptability) AS avg_adaptability,
                AVG(willingness_to_learn) AS avg_willingness_to_learn,
                AVG(application_of_feedback) AS avg_application_of_feedback,
                AVG(self_improvement) AS avg_self_improvement,
                AVG(skill_development) AS avg_skill_development,
                AVG(knowledge_application) AS avg_knowledge_application,
                AVG(team_participation) AS avg_team_participation,
                AVG(cooperation) AS avg_cooperation,
                AVG(conflict_resolution) AS avg_conflict_resolution,
                AVG(supportiveness) AS avg_supportiveness,
                AVG(contribution) AS avg_contribution,
                AVG(enthusiasm) AS avg_enthusiasm,
                AVG(drive) AS avg_drive,
                AVG(resilience) AS avg_resilience,
                AVG(commitment) AS avg_commitment,
                AVG(self_motivation) AS avg_self_motivation
            FROM Student_Evaluation";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $averages = $stmt->fetch(PDO::FETCH_ASSOC);

    $avgQualityOfWork = $averages['avg_quality_of_work'] ?? null;
    $avgProductivity = $averages['avg_productivity'] ?? null;
    $avgProblemSolvingSkills = $averages['avg_problem_solving_skills'] ?? null;
    $avgAttentionToDetail = $averages['avg_attention_to_detail'] ?? null;
    $avgInitiative = $averages['avg_initiative'] ?? null;
    $avgPunctuality = $averages['avg_punctuality'] ?? null;
    $avgAppearance = $averages['avg_appearance'] ?? null;
    $avgCommunicationSkills = $averages['avg_communication_skills'] ?? null;
    $avgRespectfulness = $averages['avg_respectfulness'] ?? null;
    $avgAdaptability = $averages['avg_adaptability'] ?? null;
    $avgWillingnessToLearn = $averages['avg_willingness_to_learn'] ?? null;
    $avgApplicationOfFeedback = $averages['avg_application_of_feedback'] ?? null;
    $avgSelfImprovement = $averages['avg_self_improvement'] ?? null;
    $avgSkillDevelopment = $averages['avg_skill_development'] ?? null;
    $avgKnowledgeApplication = $averages['avg_knowledge_application'] ?? null;
    $avgTeamParticipation = $averages['avg_team_participation'] ?? null;
    $avgCooperation = $averages['avg_cooperation'] ?? null;
    $avgConflictResolution = $averages['avg_conflict_resolution'] ?? null;
    $avgSupportiveness = $averages['avg_supportiveness'] ?? null;
    $avgContribution = $averages['avg_contribution'] ?? null;
    $avgEnthusiasm = $averages['avg_enthusiasm'] ?? null;
    $avgDrive = $averages['avg_drive'] ?? null;
    $avgResilience = $averages['avg_resilience'] ?? null;
    $avgCommitment = $averages['avg_commitment'] ?? null;
    $avgSelfMotivation = $averages['avg_self_motivation'] ?? null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="css/Profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Student Dashboard</title>
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">



    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />



    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- ---------------------------script ---------------------- -->
    <script type="text/javascript">
        const averages = {
            avgQualityOfWork: <?= json_encode($avgQualityOfWork) ?>,
            avgProductivity: <?= json_encode($avgProductivity) ?>,
            avgProblemSolvingSkills: <?= json_encode($avgProblemSolvingSkills) ?>,
            avgAttentionToDetail: <?= json_encode($avgAttentionToDetail) ?>,
            avgInitiative: <?= json_encode($avgInitiative) ?>,
            avgPunctuality: <?= json_encode($avgPunctuality) ?>,
            avgAppearance: <?= json_encode($avgAppearance) ?>,
            avgCommunicationSkills: <?= json_encode($avgCommunicationSkills) ?>,
            avgRespectfulness: <?= json_encode($avgRespectfulness) ?>,
            avgAdaptability: <?= json_encode($avgAdaptability) ?>,
            avgWillingnessToLearn: <?= json_encode($avgWillingnessToLearn) ?>,
            avgApplicationOfFeedback: <?= json_encode($avgApplicationOfFeedback) ?>,
            avgSelfImprovement: <?= json_encode($avgSelfImprovement) ?>,
            avgSkillDevelopment: <?= json_encode($avgSkillDevelopment) ?>,
            avgKnowledgeApplication: <?= json_encode($avgKnowledgeApplication) ?>,
            avgTeamParticipation: <?= json_encode($avgTeamParticipation) ?>,
            avgCooperation: <?= json_encode($avgCooperation) ?>,
            avgConflictResolution: <?= json_encode($avgConflictResolution) ?>,
            avgSupportiveness: <?= json_encode($avgSupportiveness) ?>,
            avgContribution: <?= json_encode($avgContribution) ?>,
            avgEnthusiasm: <?= json_encode($avgEnthusiasm) ?>,
            avgDrive: <?= json_encode($avgDrive) ?>,
            avgResilience: <?= json_encode($avgResilience) ?>,
            avgCommitment: <?= json_encode($avgCommitment) ?>,
            avgSelfMotivation: <?= json_encode($avgSelfMotivation) ?>
        };
    </script>
    <script type="text/javascript" src="css/eval_graph.js"></script>



</head>

<body>
    <!-- Navbar top -->
    <?php echo $profile_div; ?>

    <!-- <div class="navbar-top">
        <div class="title">
            <h1 style="color:#ffff; font-weight: bold">Profile</h1>
        </div>
        <ul>
            <li>
                <a href="../../Account/<?= $_SESSION['account_type']; ?>">
                    <i class=" fa fa-sign-out-alt fa-2x"></i>
                </a>
            </li>
        </ul>
    </div> -->
    <!-- End -->





    <div class="row-graph-profile">

        <!-- <div class="column-graph-profile" style="background-color:#fff;">
            <div class="container-grap-left">

                <div class="profile">
                    <img src="<?php echo $profile_image ?>" alt="" width="100" height="100" />

                    <div class="name"><?= $fullName; ?></div>
                    <div class="job"><?= $strand ?></div>


                </div>


            </div>
        </div> -->


        <div class="column-graph-profile-right">

            <div class="container-grap-right">


                <div class="card-body">
                    <span class="fullname"><?= $fullName ?></span>
                    <span class="LRN">LRN: 20181234</span>
                    <br>

                    <i class="fa fa-graduation-cap" aria-hidden="true"></i><span class="other-info"><?= $strand ?></span>
                    <br>
                    <i class="fa fa-envelope" aria-hidden="true"></i><span class="other-info"><?= $email  ?></span>
                    <br>

                    <i class="fa fa-phone" aria-hidden="true"></i><span class="other-info">09723207876</span>
                    <br>

                    <a style=" text-decoration: none; display:contents ;" href="Settings.php">
                        <button class="edit-button">
                            <svg class="edit-svgIcon" viewBox="0 0 512 512">
                                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                            </svg>
                        </button>
                    </a>

                    <!-- <table class="personal-details-table">
                        <tbody>
                            <tr>
                            <tr>
                                <td><b>First Name</b></td>
                                <td><b>Middle Name</b></td>
                                <td><b>Last Name</b></td>
                            </tr>
                            <td><input type="text" class="form-control mb-1" autocomplete="off"
                                    value="<?= $firstName ?>" readonly></td>
                            <td><input type="text" class="form-control mb-1" autocomplete="off"
                                    value="<?= $middleName ?>" readonly></td>
                            <td><input type="text" class="form-control mb-1" autocomplete="off" value="<?= $lastName ?>"
                                    readonly></td>
                            </tr>



                        </tbody>
                    </table>


                    <table class="personal-details-ss-table">
                        <tbody>
                            <tr class="tr-stard-school">
                            <tr>
                                <td><b>Strand</b></td>
                                <td><b>School</b></td>
                            </tr>
                            <td><input type="text" class="form-control mb-1 strand" autocomplete="off"
                                    value="<?= $strand ?>" readonly></td>
                            <td><input type="text" class="form-control mb-1 school" autocomplete="off"
                                    value="<?= $school ?>" readonly></td>
                            </tr>




                        </tbody>
                    </table>
                    <table class="personal-details-e-table">
                        <tbody>

                            <tr>
                            <tr>
                                <td><b>LRN</b></td>
                                <td><b>Email</b></td>
                            </tr>
                            <td><input type="number" class="form-control mb-1" autocomplete="off" value=""
                                    readonly></td>
                            <td><input type="text" class="form-control mb-1" autocomplete="off" value="<?= $email ?>"
                                    readonly></td>
                            </tr>

                        </tbody>
                        <tbody>

                            <tr>
                            <tr>
                                <td><b>Work Immersion</b></td>
                            </tr>
                            <td><input type="text" class="form-control mb-1" autocomplete="off"
                                    value="<?= $currentWork ?>" readonly></td>
                            </tr>

                        </tbody>
                    </table> -->


                </div>
            </div>
        </div>

    </div>


    <!-- -----------------------------------column graph ------------------------- -->

    <div class="row-graph">

        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">
                    <h2 class="title-resume">Daily Insight</h2>
                    <span class="description-resume">The line chart analyzes student daily performance in work immersion, and the pie chart displays the distribution of performance levels.</span>


                    <div class="container-grap">
                        <div class="dp-graph" id="piechart_3d"></div>
                    </div>



                    <div class="container-grap">
                        <div class="dp-graph" id="dp_chart_div"></div>

                    </div>

                </article>
                <article class="app-content__widget app-content__widget--secondary">
                    widget - secondary
                    <hr>
                </article>
                <article class="app-content__widget app-content__widget--tertiary">
                    widget - tertiary
                    <hr>
                </article>
            </main>
        </div>




        <!-- 
        <h2>Daily Insight</h2>
        <div class="contaier-graph">
            <div class="column-graph" style="background-color:#fff;">
                <div class="container-grap">
                    <div class="dp-graph" id="dp_chart_div"></div>

                </div>
            </div>


            <div class="column-graph" style="background-color:#fff;">
                <div class="container-grap">
                    <div class="dp-graph" id="piechart_3d"></div>
                </div>
            </div>
        </div> -->



    </div>
    <!-- -------------------------------------END ------------------------------------------------- -->
    <!-- ----------------------------------------EVALUATION GRAPH----------------------------------- -->

    <div class="container light-style flex-grow-1 container-p-y"
        style="padding-left: 0px; padding-right: 0px; max-height: 463px;">
        <div class="header-title">
            <h4 class="font-weight-bold py-3 mb-4" style=" color:#fff; padding-left: 10px; padding-right: 10px;">
                Evaluation Insight
            </h4>
            <a id="refreshButton">
                <i style="font-size:24px; cursor:pointer;" class="fa">&#xf021;</i>
            </a>
        </div>

        <div class="card-graph overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#wp-top-x-div-sel">Work habits</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#pro-top-x-div-sel">Work skills</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#ld-top-x-div-sel">Social skills</a>
                        <!-- <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#tc-top-x-div-sel">Team Work and Collaboration</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#am-top-x-div-sel">Attitude and Motivation</a> -->

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="wp-top-x-div-sel">
                            <div class="wp-graph" id="wp-top-x-div" style="width: 100%; height: 400px;"></div>

                        </div>

                        <div class="tab-pane fade active" id="pro-top-x-div-sel">
                            <div class="pro-graph" id="pro-top-x-div" style="width: 100%; height: 400px;"></div>
                        </div>

                        <div class="tab-pane fade active" id="ld-top-x-div-sel">
                            <div class="ld-graph" id="ld-top-x-div" style="width: 100%; height: 400px;"></div>
                        </div>

                        <!-- <div class="tab-pane fade active " id="tc-top-x-div-sel">
                            <div class="tc-graph" id="tc-top-x-div" style="width: 100%; height: 400px;"></div>
                        </div>

                        <div class="tab-pane fade active" id="am-top-x-div-sel">
                            <div class="am-graph" id="am-top-x-div" style="width: 100%; height: 400px;"></div>
                        </div> -->


                    </div>
                </div>
            </div>
        </div>
    </div>



    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>

    <!-- -------------------------------------------------END ------------------------------------------------------ -->
    <script>
        document.getElementById('refreshButton').addEventListener('click', function() {
            location.reload("card-graph");
        });
    </script>




    <!-- End -->
    <footer>
        <!-- 2024 Your Website. All rights reserved. | Dr Ramon De Santos National High School -->
        2024 Your Website. All rights reserved. | Junior Philippines Computer
        Society Students
    </footer>

</body>

</html>