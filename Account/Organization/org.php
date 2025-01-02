<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$currentUrl = $_SERVER['REQUEST_URI'];
$urlParts = parse_url($currentUrl);
if (isset($urlParts['query'])) {
    parse_str($urlParts['query'], $queryParameters);
    if (isset($queryParameters['job_id'])) {
        $jobIdParam =  $queryParameters['job_id'];
    }
} else {
    echo "Query string parameter not found.";
}
$jobId = decrypt_url_parameter(base64_decode($jobIdParam));

if (!isset($jobId)) {
    die("Missing job ID parameter in the URL.");
}
$sql = "SELECT * FROM job_offers WHERE id = :jobId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':jobId', $jobId, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$job = $result;

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT 
    AVG(quality_of_experience) AS avg_quality_of_experience,
    AVG(productivity_of_tasks) AS avg_productivity_of_tasks,
    AVG(problem_solving_opportunities) AS avg_problem_solving_opportunities,
    AVG(attention_to_detail_in_guidance) AS avg_attention_to_detail_in_guidance,
    AVG(initiative_encouragement) AS avg_initiative_encouragement,
    AVG(punctuality_expectations) AS avg_punctuality_expectations,
    AVG(professional_appearance_standards) AS avg_professional_appearance_standards,
    AVG(communication_training) AS avg_communication_training,
    AVG(respectfulness_environment) AS avg_respectfulness_environment,
    AVG(adaptability_challenges) AS avg_adaptability_challenges,
    AVG(willingness_to_learn_encouragement) AS avg_willingness_to_learn_encouragement,
    AVG(feedback_application_opportunities) AS avg_feedback_application_opportunities,
    AVG(self_improvement_support) AS avg_self_improvement_support,
    AVG(skill_development_assessment) AS avg_skill_development_assessment,
    AVG(knowledge_application_in_practice) AS avg_knowledge_application_in_practice,
    AVG(team_participation_opportunities) AS avg_team_participation_opportunities,
    AVG(cooperation_among_peers) AS avg_cooperation_among_peers,
    AVG(conflict_resolution_guidance) AS avg_conflict_resolution_guidance,
    AVG(supportiveness_among_peers) AS avg_supportiveness_among_peers,
    AVG(contribution_to_team_success) AS avg_contribution_to_team_success,
    AVG(enthusiasm_for_tasks) AS avg_enthusiasm_for_tasks,
    AVG(drive_to_achieve_goals) AS avg_drive_to_achieve_goals,
    AVG(resilience_to_challenges) AS avg_resilience_to_challenges,
    AVG(commitment_to_experience) AS avg_commitment_to_experience,
    AVG(self_motivation_levels) AS avg_self_motivation_levels
FROM Organization_Evaluation";

$result = $conn->query($sql);

$avg_quality_of_experience = 0.0;
$avg_productivity_of_tasks = 0.0;
$avg_problem_solving_opportunities = 0.0;
$avg_attention_to_detail_in_guidance = 0.0;
$avg_initiative_encouragement = 0.0;
$avg_punctuality_expectations = 0.0;
$avg_professional_appearance_standards = 0.0;
$avg_communication_training = 0.0;
$avg_respectfulness_environment = 0.0;
$avg_adaptability_challenges = 0.0;
$avg_willingness_to_learn_encouragement = 0.0;
$avg_feedback_application_opportunities = 0.0;
$avg_self_improvement_support = 0.0;
$avg_skill_development_assessment = 0.0;
$avg_knowledge_application_in_practice = 0.0;
$avg_team_participation_opportunities = 0.0;
$avg_cooperation_among_peers = 0.0;
$avg_conflict_resolution_guidance = 0.0;
$avg_supportiveness_among_peers = 0.0;
$avg_contribution_to_team_success = 0.0;
$avg_enthusiasm_for_tasks = 0.0;
$avg_drive_to_achieve_goals = 0.0;
$avg_resilience_to_challenges = 0.0;
$avg_commitment_to_experience = 0.0;
$avg_self_motivation_levels = 0.0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $avg_quality_of_experience = $row['avg_quality_of_experience'];
    $avg_productivity_of_tasks = $row['avg_productivity_of_tasks'];
    $avg_problem_solving_opportunities = $row['avg_problem_solving_opportunities'];
    $avg_attention_to_detail_in_guidance = $row['avg_attention_to_detail_in_guidance'];
    $avg_initiative_encouragement = $row['avg_initiative_encouragement'];
    $avg_punctuality_expectations = $row['avg_punctuality_expectations'];
    $avg_professional_appearance_standards = $row['avg_professional_appearance_standards'];
    $avg_communication_training = $row['avg_communication_training'];
    $avg_respectfulness_environment = $row['avg_respectfulness_environment'];
    $avg_adaptability_challenges = $row['avg_adaptability_challenges'];
    $avg_willingness_to_learn_encouragement = $row['avg_willingness_to_learn_encouragement'];
    $avg_feedback_application_opportunities = $row['avg_feedback_application_opportunities'];
    $avg_self_improvement_support = $row['avg_self_improvement_support'];
    $avg_skill_development_assessment = $row['avg_skill_development_assessment'];
    $avg_knowledge_application_in_practice = $row['avg_knowledge_application_in_practice'];
    $avg_team_participation_opportunities = $row['avg_team_participation_opportunities'];
    $avg_cooperation_among_peers = $row['avg_cooperation_among_peers'];
    $avg_conflict_resolution_guidance = $row['avg_conflict_resolution_guidance'];
    $avg_supportiveness_among_peers = $row['avg_supportiveness_among_peers'];
    $avg_contribution_to_team_success = $row['avg_contribution_to_team_success'];
    $avg_enthusiasm_for_tasks = $row['avg_enthusiasm_for_tasks'];
    $avg_drive_to_achieve_goals = $row['avg_drive_to_achieve_goals'];
    $avg_resilience_to_challenges = $row['avg_resilience_to_challenges'];
    $avg_commitment_to_experience = $row['avg_commitment_to_experience'];
    $avg_self_motivation_levels = $row['avg_self_motivation_levels'];
}

function generateJobCard()
{
    global $job;
    $strands = json_decode($job['strands']);
    $work_title = $job['work_title'];
    $description = html_entity_decode($job['description']);
    $description = nl2br($description);
    global $totalApplicants;
    $strands = json_decode($job['strands']);
    $work_title = $job['work_title'];
    $description = html_entity_decode($job['description']);
    $description = nl2br($description);

    echo '<div id="titlebar" class="single titlebar-boxed-company-info">';
    echo '<div class="container">';
    echo '<div class="eleven columns">';

    echo '<span class="job-category"><a href="#">Company</a></span>';
    // echo '<h1>' . htmlspecialchars($job['work_title']);
    echo '<h1>' .  htmlspecialchars($job['organization_name']);

    foreach ($strands as $strand) {
        echo '<span class="job-type full-time">' . htmlspecialchars($strand) . '</span>';
    }
    // echo '<span class="job-category"><a href="#">Organization</a></span>';
    // echo '<h1>' .  htmlspecialchars($job['organization_name']);
    echo '<hr>';
    // foreach ($strands as $strand) {
    //     echo '<span class="job-type full-time">' . htmlspecialchars($strand) . '</span>';
    // }

    echo '</h1></div>';
    echo '</h1></div>';

    echo '<div class="five columns">';
    echo '<div class="job-manager-form wp-job-manager-bookmarks-form">';
    echo '</div></div></div></div>';
    echo '<div class="five columns">';
    echo '<div class="job-manager-form wp-job-manager-bookmarks-form">';
    echo '</div></div></div></div>';

    echo '
            </div>
        </div>



        <!-- </section> -->
        <div class="container right-sidebar">
            <div class="sixteen columns"></div>
            <div class="company-info-boxed">
                <div class="company-info left-company-logo">


                    <div class="content">
                        <h4>
                           
                            <a href="#"> <strong>' . htmlspecialchars($job['work_title']) .
        '</strong>
                            </a>
                           
                        </h4>';

    foreach ($strands as $strand) {
        echo '<span class="job-type full-time">' . htmlspecialchars($strand) . '</span>';
    }

    echo '                  


                    </div>
                    <div class="company-info-apply-btn">

                        <div class="job_application application">

                            <a href="login.php" class="small-dialog popup-with-zoom-anim button apply-dialog-button">Apply now</a>


                        </div>
                    </div>
                </div>


            </div>
            <div class="eleven columns ">
                <div class="padding-right">
                    <div class="single_job_listing">
                        ' . $description . '
                        

                    </div>
                </div>

            </div>


            <div class="eleven columns ">
                <div class="padding-right">
                
                    <div class="single_job_listing">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                     <h4 class="font-weight-bold py-3 mb-4"
            style="background-color:#172738; color:#fff; padding-left: 20px; padding-right: 10px;margin: 0px !important; "> <i class="fa fa-pie-chart" aria-hidden="true"></i>Rating</h4>
                        <div class="flex-container">
                        
  <div class="flex-left">
    <div id="top_x_div_rating"></div>
    <div class="rating-users">
      <i class="fa fa-user" aria-hidden="true"></i><span>' . $totalApplicants  . '</span> total students
    </div>
  </div>
  <div class="flex-right">
      
<div id="total-student" style="width: 90%; height: 100%;"></div>
  </div>
</div> 
                        

                    </div>
                </div>

            </div>



             
            <div class="container-org light-style flex-grow-1 container-p-y" style="padding-left: 0px; padding-right: 0px;">
            <h4 class="font-weight-bold py-3 mb-4"
            style="background-color:#172738; color:#fff; padding-left: 20px; padding-right: 10px;margin: 0px !important; ">  <i class="fa fa-bar-chart" aria-hidden="true"></i>Insights</h4>
        <div class="container-btm-rating">
        
		<div class="row clearfix">
			<div class="col-3">
				<div class="common">
					 <div class="wp-graph" id="wp-top-x-div" style="width: 100%; height: 100%;"></div>
				</div> <!-- end:common -->
			</div> <!-- end:col-3 -->

			<div class="col-3">
				<div class="common">
					<div class="pro-graph" id="pro-top-x-div" style="width: 100%; height: 100%;"></div>
				</div> <!-- end:common -->
			</div> <!-- end:col-3 -->

			<div class="col-3">
				<div class="common">
					 <div class="ld-graph" id="ld-top-x-div" style="width: 100%; height: 100%;"></div>
				</div> <!-- end:common -->
			</div> <!-- end:col-3 -->

			<div class="col-3">
				<div class="common">
					<div class="tc-graph" id="tc-top-x-div" style="width: 100%; height: 100%;"></div>
				</div> <!-- end:common -->
				
			</div> <!-- end:col-3 -->
			<div class="col-3">
				<div class="common">
					 <div class="am-graph" id="am-top-x-div" style="width: 100%; height: 100%;"></div>
				</div> <!-- end:common -->
			</div> <!-- end:col-3 -->
		</div><!-- end:row -->
	</div> <!-- end:container -->


        </div>';
}

function getApplicantsCountByStrand($jobId, $pdo)
{
    $sql = "SELECT strand, COUNT(*) AS count FROM applicants 
            JOIN student_profiles ON applicants.student_id = student_profiles.user_id 
            WHERE applicants.job_id = :jobId 
            GROUP BY strand";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':jobId', $jobId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $strandCounts = [
        'humss' => 0,
        'gas' => 0,
        'stem' => 0,
        'tvl' => 0,
        'abm' => 0,
    ];

    foreach ($results as $row) {
        if (isset($strandCounts[$row['strand']])) {
            $strandCounts[$row['strand']] = (int)$row['count'];
        }
    }

    // Calculate the total number of applicants
    $totalApplicants = array_sum($strandCounts);

    return [
        'counts' => $strandCounts,
        'total' => $totalApplicants
    ];
}

$strandData = getApplicantsCountByStrand($jobId, $pdo);
$strandCounts = $strandData['counts'];
$totalApplicants = $strandData['total'];

if (isset($_SESSION['account_type'])) {

    $account_type = ucfirst($_SESSION['account_type']);

    $link = "/Account/$account_type";
} else {

    $link = "./";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Work Immersion | Workify</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
    <!-- <title>Work Immersion | DRDSNHS</title> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="stylesheet" type="text/css" href="css/org_style.css">
    <!-- <link rel="stylesheet" type="text/scss" href="css/reboot.css"> -->
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->


    <!-- ---------------------------------------evaluation script ------------------------------------------- -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>




<body>
    <noscript>
        <style>
        html {
            display: none;
        }
        </style>
        <meta http-equiv="refresh" content="0.0;url=message.php">
    </noscript>


    <script>
    var strandCounts = <?php echo json_encode($strandCounts); ?>;
    var totalApplicants = strandCounts.humss + strandCounts.gas + strandCounts.stem + strandCounts.tvl;

    // Experience averages
    const avgQualityOfExperience = Number(<?php echo json_encode($avg_quality_of_experience); ?>);
    const avgProductivityOfTasks = Number(<?php echo json_encode($avg_productivity_of_tasks); ?>);
    const avgProblemSolvingOpportunities = Number(<?php echo json_encode($avg_problem_solving_opportunities); ?>);
    const avgAttentionToDetailInGuidance = Number(<?php echo json_encode($avg_attention_to_detail_in_guidance); ?>);
    const avgInitiativeEncouragement = Number(<?php echo json_encode($avg_initiative_encouragement); ?>);

    const avgExperience = (
        (avgQualityOfExperience + avgProductivityOfTasks + avgProblemSolvingOpportunities +
            avgAttentionToDetailInGuidance + avgInitiativeEncouragement) / 5
    );

    // Professionalism averages
    const avgPunctualityExpectations = Number(<?php echo json_encode($avg_punctuality_expectations); ?>);
    const avgProfessionalAppearanceStandards = Number(
        <?php echo json_encode($avg_professional_appearance_standards); ?>);
    const avgCommunicationTraining = Number(<?php echo json_encode($avg_communication_training); ?>);
    const avgRespectfulnessEnvironment = Number(<?php echo json_encode($avg_respectfulness_environment); ?>);
    const avgAdaptabilityChallenges = Number(<?php echo json_encode($avg_adaptability_challenges); ?>);

    const avgProfessionalism = (
        (avgPunctualityExpectations + avgProfessionalAppearanceStandards + avgCommunicationTraining +
            avgRespectfulnessEnvironment + avgAdaptabilityChallenges) / 5
    );

    // Learning and development averages
    const avgWillingnessToLearnEncouragement = Number(
        <?php echo json_encode($avg_willingness_to_learn_encouragement); ?>);
    const avgFeedbackApplicationOpportunities = Number(
        <?php echo json_encode($avg_feedback_application_opportunities); ?>);
    const avgSelfImprovementSupport = Number(<?php echo json_encode($avg_self_improvement_support); ?>);
    const avgSkillDevelopmentAssessment = Number(<?php echo json_encode($avg_skill_development_assessment); ?>);
    const avgKnowledgeApplicationInPractice = Number(
        <?php echo json_encode($avg_knowledge_application_in_practice); ?>);

    const avgLearningAndDevelopment = (
        (avgWillingnessToLearnEncouragement + avgFeedbackApplicationOpportunities + avgSelfImprovementSupport +
            avgSkillDevelopmentAssessment + avgKnowledgeApplicationInPractice) / 5
    );

    // Collaboration averages
    const avgTeamParticipationOpportunities = Number(<?php echo json_encode($avg_team_participation_opportunities); ?>);
    const avgCooperationAmongPeers = Number(<?php echo json_encode($avg_cooperation_among_peers); ?>);
    const avgConflictResolutionGuidance = Number(<?php echo json_encode($avg_conflict_resolution_guidance); ?>);
    const avgSupportivenessAmongPeers = Number(<?php echo json_encode($avg_supportiveness_among_peers); ?>);
    const avgContributionToTeamSuccess = Number(<?php echo json_encode($avg_contribution_to_team_success); ?>);

    const avgCollaboration = (
        (avgTeamParticipationOpportunities + avgCooperationAmongPeers + avgConflictResolutionGuidance +
            avgSupportivenessAmongPeers + avgContributionToTeamSuccess) / 5
    );

    // Attitude and Motivation averages
    const avgEnthusiasmForTasks = Number(<?php echo json_encode($avg_enthusiasm_for_tasks); ?>);
    const avgDriveToAchieveGoals = Number(<?php echo json_encode($avg_drive_to_achieve_goals); ?>);
    const avgResilienceToChallenges = Number(<?php echo json_encode($avg_resilience_to_challenges); ?>);
    const avgCommitmentToExperience = Number(<?php echo json_encode($avg_commitment_to_experience); ?>);
    const avgSelfMotivationLevels = Number(<?php echo json_encode($avg_self_motivation_levels); ?>);

    const avgAttitudeAndMotivation = (
        (avgEnthusiasmForTasks + avgDriveToAchieveGoals + avgResilienceToChallenges +
            avgCommitmentToExperience + avgSelfMotivationLevels) / 5
    );
    </script>

    <header id="myHeader-sticky">
        <?php
        session_start();

        if (isset($_SESSION['account_type'])) {
            $account_type = ucfirst($_SESSION['account_type']);
            $link = "/Account/$account_type";
        } else {
            $link = "./";
        }
        ?>
        <div class="logo">
            <a href="<?php echo htmlspecialchars($link); ?>">
                <img src="../../../img/logov3.jpg" alt="Logo">
                <!-- <img src="img/DrRamonLOGO.svg" alt="Logo"> -->
            </a>
            <nav class="dash-middle">

            </nav>
        </div>
        <nav class="nav-log">



            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="com-btn" href="<?php echo htmlspecialchars($link); ?>">Back</a>
        </nav>

    </header>


    <div class="content-sticky">
        <!-- --------------------------------------------------location----------------------------------------------- -->


        <?php generateJobCard(); ?>


    </div>

    <!-- ----------------------------------------------footer ------------------------------------------------------- -->
    <footer class="new_footer_area bg_color">
        <div class="new_footer_top">
            <div class="container">
                <div class="row" style=" gap: 120px !important;">

                    <img src="../../../img/WORKIFY-LOGO.svg" alt="Logo">
                    <!-- <img src="img/DrRamonLOGO.svg" alt="Logo"> -->


                </div>
            </div>
            <div class="footer_bg">
                <div class="footer_bg_one"></div>
                <div class="footer_bg_two"></div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-7">
                        <p class="mb-0 f_400">© 2024 WorkifyPH. All rights reserved. | Junior Philippines Computer
                            Society Students</p>
                        <!-- <p class="mb-0 f_400">© 2024 Your Website. All rights reserved. | Dr Ramon De Santos National High School</p> -->
                    </div>
                    <!-- <div class="col-lg-6 col-sm-5 text-right">
                        <p>Made with <i class="icon_heart"></i> in <a href="#" target="_blank">JPCS</a></p>
                    </div> -->
                </div>
            </div>
        </div>
    </footer>


    <!-- -------------------------------------header stick js ------------------------------ -->
    <script>
    window.onscroll = function() {
        myFunction();
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
    <script>
    $(document).ready(function() {
        $('.bar span').hide();
        $('#bar-five').animate({
            width: '85%'
        }, 1000);
        $('#bar-four').animate({
            width: '35%'
        }, 1000);
        $('#bar-three').animate({
            width: '20%'
        }, 1000);
        $('#bar-two').animate({
            width: '17%'
        }, 1000);
        $('#bar-one').animate({
            width: '30%'
        }, 1000);

        setTimeout(function() {
            $('.bar span').fadeIn('slow');
        }, 1000);

    });
    </script>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>



    <script src="js/filter.js"> </script>
    <script type="text/javascript" src="js/org.js"></script>

</body>


</html>