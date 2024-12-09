<?php
require_once 'show_profile.php';

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
    if (isset($queryParameters['organization_id'])) {
        $IdParam = $queryParameters['organization_id'];
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

    $sql = "SELECT * FROM partner_profiles WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $partner_profile = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $organizationName = $partner_profile['organization_name'];
    $strand = strtoupper($partner_profile['strand']);
    $email = $user['email'];
    $profile_image = ($_SESSION['profile_image'] === './uploads/') ? './image/default.png' : $_SESSION['profile_image'];

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
            FROM Organization_Evaluation
            WHERE organization_id = :user_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $averages = $stmt->fetch(PDO::FETCH_ASSOC);

    $avgQualityOfExperience = $averages['avg_quality_of_experience'] ?? null;
    $avgProductivityOfTasks = $averages['avg_productivity_of_tasks'] ?? null;
    $avgProblemSolvingOpportunities = $averages['avg_problem_solving_opportunities'] ?? null;
    $avgAttentionToDetailInGuidance = $averages['avg_attention_to_detail_in_guidance'] ?? null;
    $avgInitiativeEncouragement = $averages['avg_initiative_encouragement'] ?? null;
    $avgPunctualityExpectations = $averages['avg_punctuality_expectations'] ?? null;
    $avgProfessionalAppearanceStandards = $averages['avg_professional_appearance_standards'] ?? null;
    $avgCommunicationTraining = $averages['avg_communication_training'] ?? null;
    $avgRespectfulnessEnvironment = $averages['avg_respectfulness_environment'] ?? null;
    $avgAdaptabilityChallenges = $averages['avg_adaptability_challenges'] ?? null;
    $avgWillingnessToLearnEncouragement = $averages['avg_willingness_to_learn_encouragement'] ?? null;
    $avgFeedbackApplicationOpportunities = $averages['avg_feedback_application_opportunities'] ?? null;
    $avgSelfImprovementSupport = $averages['avg_self_improvement_support'] ?? null;
    $avgSkillDevelopmentAssessment = $averages['avg_skill_development_assessment'] ?? null;
    $avgKnowledgeApplicationInPractice = $averages['avg_knowledge_application_in_practice'] ?? null;
    $avgTeamParticipationOpportunities = $averages['avg_team_participation_opportunities'] ?? null;
    $avgCooperationAmongPeers = $averages['avg_cooperation_among_peers'] ?? null;
    $avgConflictResolutionGuidance = $averages['avg_conflict_resolution_guidance'] ?? null;
    $avgSupportivenessAmongPeers = $averages['avg_supportiveness_among_peers'] ?? null;
    $avgContributionToTeamSuccess = $averages['avg_contribution_to_team_success'] ?? null;
    $avgEnthusiasmForTasks = $averages['avg_enthusiasm_for_tasks'] ?? null;
    $avgDriveToAchieveGoals = $averages['avg_drive_to_achieve_goals'] ?? null;
    $avgResilienceToChallenges = $averages['avg_resilience_to_challenges'] ?? null;
    $avgCommitmentToExperience = $averages['avg_commitment_to_experience'] ?? null;
    $avgSelfMotivationLevels = $averages['avg_self_motivation_levels'] ?? null;

    // // ganito lagay nyo sa frontend 
    // echo "<h3>Average Organization Evaluation Scores</h3>";
    // echo "Average Quality of Experience: " . ($avgQualityOfExperience !== null ? round($avgQualityOfExperience, 2) : 'N/A') . "<br>";
    // echo "Average Productivity of Tasks: " . ($avgProductivityOfTasks !== null ? round($avgProductivityOfTasks, 2) : 'N/A') . "<br>";
    // echo "Average Problem Solving Opportunities: " . ($avgProblemSolvingOpportunities !== null ? round($avgProblemSolvingOpportunities, 2) : 'N/A') . "<br>";
    // echo "Average Attention to Detail in Guidance: " . ($avgAttentionToDetailInGuidance !== null ? round($avgAttentionToDetailInGuidance, 2) : 'N/A') . "<br>";
    // echo "Average Initiative Encouragement: " . ($avgInitiativeEncouragement !== null ? round($avgInitiativeEncouragement, 2) : 'N/A') . "<br>";
    // echo "Average Punctuality Expectations: " . ($avgPunctualityExpectations !== null ? round($avgPunctualityExpectations, 2) : 'N/A') . "<br>";
    // // Add additional output lines for other averages as necessary...

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$profile_divv = '<header class="nav-header">
        <div class="logo">
            <a href="../../Account/' . ucfirst($_SESSION['account_type']) . '"> 
                <img src="image/logov3.jpg" alt="Logo">
            </a>
           
            
        </div>
        <nav class="by">

 
 <a class="btn-home" style="color:#1bbc9b; font-weight: 600;" href="../../Account/' . ucfirst($_SESSION['account_type']) . '"> Back </a>
  
</div>
        
        </nav>

    </header>

    ';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Company Profile</title>
    <link rel="stylesheet" type="text/css" href="css/Profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">



    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />



</head>

<body>
    <!-- Navbar top -->
    <?php echo $profile_divv; ?>
    <!-- <div class="navbar-top">
        <div class="title">
            <h1>Profile</h1>
        </div>
        <ul>

            <li>
                <a href="<?php //echo $_SERVER['HTTP_REFERER']; ?>" onclick="window.location.href = document.referrer;">
                    <i class=" fa fa-sign-out-alt fa-2x"></i>
                </a>
            </li>
        </ul>
        
    </div> -->
    <!-- End -->



    <!-- Sidenav -->

    <div class="row-graph-profile">


        <div class="column-graph-profile-right">
            <div class="container-grap-right">

                <div class="card-body">
                    <span class="fullname"><?= $organizationName ?></span>
                    <br>
                    <i class="fa fa-bullseye" aria-hidden="true"></i><span class="other-info"><?= $strand ?></span>
                    <br>
                    <i class="fa fa-envelope" aria-hidden="true"></i><span class="other-info"><?= $email  ?></span>
                    <!-- 
                <br>
                <i class="fa fa-house" aria-hidden="true"></i><span class="other-info"><?= $school  ?></span>
                <br>
                <i class="fa fa-briefcase" aria-hidden="true"></i><span class="other-info"><?= $currentWork   ?></span> -->





                    <a style=" text-decoration: none; display:contents ;" href="Settings.php">
                        <button class="edit-button">
                            <svg class="edit-svgIcon" viewBox="0 0 512 512">
                                <path
                                    d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                                </path>
                            </svg>
                        </button>
                    </a>

                </div>
            </div>

        </div>
    </div>
    <br>



    <div class="row-graph">
        <div class="main">
            <h2>Map</h2>
            <!-- <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1920.8544297966187!2d120.7673922211044!3d15.660484473847125!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33912cdb2318296d%3A0xe4e2117e97dfc92e!2sOur%20Lady%20of%20The%20Sacred%20Heart%20College!5e0!3m2!1sen!2sph!4v1716015242226!5m2!1sen!2sph"
            width="850" height="350" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe> -->

            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4180.818006163703!2d120.70824703813983!3d15.714406648857958!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391320a99919993%3A0x9be48d66ed4cad27!2sDr%20Ramon%20De%20Santos%20National%20High%20School!5e1!3m2!1sen!2sph!4v1728567463175!5m2!1sen!2sph"
                width="780" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>


        <!-- <h2>SOCIAL MEDIA</h2>
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <div class="social-media">
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-facebook fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-instagram fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-invision fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-whatsapp fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-sm">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fab fa-snapchat fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
            </div>
        </div> -->
        <!-- End -->
        <footer>
            2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School
        </footer>
</body>

</html>