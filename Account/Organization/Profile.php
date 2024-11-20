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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Company Profile</title>
    <link rel="stylesheet" type="text/css" href="css/Profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->



    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />



</head>

<body>
    <!-- Navbar top -->
    <div class="navbar-top">
        <div class="title">
            <h1>Profile</h1>
        </div>
        <ul>

            <li>
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" onclick="window.location.href = document.referrer;">
                    <i class=" fa fa-sign-out-alt fa-2x"></i>
                </a>
            </li>
        </ul>
        <!-- End -->
    </div>
    <!-- End -->
    <div class="main">
        <br>
    </div>
    <!-- Sidenav -->

    <div class="row-graph-profile">
        <div class="column-graph-profile" style="background-color:#fff;">
            <div class="container-grap-left">


                <div class="profile">
                    <img src="<?php echo $profile_image ?>" alt="" width="200" height="200" />

                    <!-- <div class="name"> Unkown</div>
                    <div class="job">Unkown</div> -->
                </div>
            </div>
        </div>


        <h2>Details</h2>
        <div class="column-graph-profile-right" style="background-color:#fff;">
            <div class="container-grap-right">
                <div class="card-body">

                    <table class="personal-details-ss-table">
                        <tbody>
                            <tr>

                                <td><b>Organization</b></td>
                                <td><b style="margin-left: 10px;">Strand</b></td>

                            </tr>
                            <tr>
                                <td><input type="text" class="form-control mb-1" autocomplete="off"
                                        value="<?= $organizationName ?>" readonly>
                                </td>
                                <td><input type=" text" class="form-control mb-1" style="margin-left:10px;"
                                        autocomplete="off" value="<?= $strand ?>" readonly></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="personal-details-ss-table">
                        <tbody>
                            <tr class="tr-stard-school">
                            <tr>
                                <td><b>Email</b></td>
                                <!-- <td><b style="margin-left: 10px;">Contact number</b></td> -->

                            </tr>
                            <td><input type="text" class="form-control mb-1 strand" autocomplete="off"
                                    value="<?= $email ?>" readonly></td>
                            <!-- <td><input type="text" class="form-control mb-1 strand" style="margin-left:10px;"
                                    autocomplete="off" value="" readonly></td> -->
                            </tr>


                        </tbody>
                    </table>

                    <!-- <table class="personal-details-ss-table">
                        <tbody>
                            <tr class="tr-stard-school">
                            <tr>
                                <td><b>Location</b></td>
                            </tr>
                            <td><input type="text" class="form-control mb-1 strand" autocomplete="off" value="" readonly></td>

                            </tr>


                        </tbody>
                    </table> -->


                </div>
            </div>
        </div>
    </div>
    <br>




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