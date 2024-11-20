<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
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

global $host;
global $username;
global $password;
global $database;
global $conn;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM student_profiles WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $student_profile = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $firstName = $student_profile['first_name'];
    $middleName = $student_profile['middle_name'];
    $lastName = $student_profile['last_name'];
    $fullName = trim($firstName . ' ' . $middleName . ' ' . $lastName);
    $school = $student_profile['school'];
    $gradeLevel = $student_profile['grade_level'];
    $strand = strtoupper($student_profile['strand']);
    $stars = $student_profile['stars'];
    $currentWork = $student_profile['current_work'];
    $email = $user['email'];
    $profile_image = ($_SESSION['profile_image'] === './uploads/') ? './image/default.png' : $_SESSION['profile_image'];

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
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->



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
    <div class="navbar-top">
        <div class="title">
            <h1 style="color:#ffff; font-weight: bold">Profile</h1>
        </div>
        <ul>
            <li>
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" onclick="window.location.href = document.referrer;">
                    <i class=" fa fa-sign-out-alt fa-2x"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- End -->


    <!-- Main -->
    <div class="main">

        <br>



    </div>

    <div class="row-graph-profile">

        <div class="column-graph-profile" style="background-color:#fff;">
            <div class="container-grap-left">

                <div class="profile">
                    <img src="<?php echo $profile_image ?>" alt="" width="100" height="100" />

                    <div class="name"><?= $fullName; ?></div>
                    <div class="job"><?= $strand ?></div>


                </div>


            </div>
        </div>

        <h2>Personal details </h2>
        <div class="column-graph-profile-right" style="background-color:#fff;">

            <div class="container-grap-right">

                <div class="card-body">

                    <table class="personal-details-table">
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
                                <td><b>Email</b></td>
                            </tr>
                            <td><input type="text" class="form-control mb-1" autocomplete="off" value="<?= $email ?>"
                                    readonly></td>
                            </tr>

                        </tbody>
                    </table>



                </div>
            </div>
        </div>

    </div>


    <!-- -----------------------------------column graph ------------------------- -->

    <div class="row-graph">

        <h2>Daily Insight</h2>

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

    </div>
    <!-- -------------------------------------END ------------------------------------------------- -->
    <!-- ----------------------------------------EVALUATION GRAPH----------------------------------- -->

    <div class="container light-style flex-grow-1 container-p-y" style="padding-left: 0px; padding-right: 0px;">
        <h4 class="font-weight-bold py-3 mb-4"
            style="background-color:#18613b; color:#fff; padding-left: 10px; padding-right: 10px;">Evaluation Insight
        </h4>
        <div class="card-graph overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#wp-top-x-div-sel">Work Performance</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#pro-top-x-div-sel">Professionalism</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#ld-top-x-div-sel">Learning and Development</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#tc-top-x-div-sel">Team Work and Collaboration</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#am-top-x-div-sel">Attitude and Motivation</a>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="wp-top-x-div-sel">
                            <div class="wp-graph" id="wp-top-x-div" style="width: 900px; height: 500px;"></div>
                        </div>

                        <div class="tab-pane fade active show" id="pro-top-x-div-sel">
                            <div class="pro-graph" id="pro-top-x-div" style="width: 900px; height: 500px;"></div>
                        </div>

                        <div class="tab-pane fade active show" id="ld-top-x-div-sel">
                            <div class="ld-graph" id="ld-top-x-div" style="width: 900px; height: 500px;"></div>
                        </div>

                        <div class="tab-pane fade active show" id="tc-top-x-div-sel">
                            <div class="tc-graph" id="tc-top-x-div" style="width: 900px; height: 500px;"></div>
                        </div>

                        <div class="tab-pane fade active show" id="am-top-x-div-sel">
                            <div class="am-graph" id="am-top-x-div" style="width: 900px; height: 500px;"></div>
                        </div>


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





    <!-- End -->
    <footer>
        2024 Your Website. All rights reserved. | Dr Ramon De Santos National High School
    </footer>

</body>

</html>