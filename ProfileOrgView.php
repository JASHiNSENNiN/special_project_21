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
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!isset($user_id) || !is_numeric($user_id)) {
            throw new Exception('Invalid user ID');
        }

        $sql = "SELECT * FROM partner_profiles WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $partner_profiles = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($partner_profiles === false) {
            echo 'No partner profile found for the given user ID: ' . $user_id;
        }


        $sql = "SELECT * FROM users WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            throw new Exception('No user found for the given user ID');
        }

        // Get values with a check to ensure they exist
        $organizationName = $partner_profiles['organization_name'] ?? 'Unknown Organization';
        $strand = isset($partner_profiles['strand']) ? strtoupper($partner_profiles['strand']) : 'UNKNOWN';
        $email = $user['email'] ?? 'No email provided';
        $phoneNumber = $partner_profiles['phone_number'] ?? 'No phone number provided';
        $zipCode = $partner_profiles['zip_code'] ?? 'No ZIP code provided';
        $address = $partner_profiles['address'] ?? 'No address provided';
        $city = $partner_profiles['city'] ?? 'No city provided';
        $province = $partner_profiles['province'] ?? 'No province provided';
        $aboutUs = $partner_profiles['about_us'] ?? 'No information available';
        $corporateVision = $partner_profiles['corporate_vision'] ?? 'No vision provided';
        $corporateMission = $partner_profiles['corporate_mission'] ?? 'No mission provided';
        $corporatePhilosophy = $partner_profiles['corporate_philosophy'] ?? 'No philosophy provided';
        $corporatePrinciples = $partner_profiles['corporate_principles'] ?? 'No principles provided';


        // Check for the $_SESSION variable and fallback to default if necessary
        $profile_image = !empty($_SESSION['profile_image']) && $_SESSION['profile_image'] !== './uploads/'
            ? $_SESSION['profile_image']
            : './image/default.png';

    } catch (PDOException $e) {
        // Handle PDO exceptions
        echo 'Database error: ' . $e->getMessage();
    } catch (Exception $e) {
        // Handle general exceptions
        echo 'An error occurred: ' . $e->getMessage();
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
                <img src="image/drdsnhs.svg" alt="Logo">
            </a>
           
            
        </div>
        <nav class="by">

 
 <a class="btn-home" style="color:#fff; font-weight: 600; text-decoration:none;" href="../../Account/' . ucfirst($_SESSION['account_type']) . '"> Back &#8594; </a>
  
</div>
        
        </nav>

    </header>

    ';
$profile_image_path = './uploads/' . $user['profile_image'];

$get_profile_image = file_exists($profile_image_path) ? $profile_image_path : './image/default.png';

$profile_data = null;
if (isset($user_id)) {
    $sql = "SELECT sp.*, u.profile_image, u.cover_image
FROM partner_profiles sp
JOIN users u ON sp.user_id = u.id
WHERE sp.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $profile_data = $result->fetch_assoc();
}
$stmt->close();
$conn->close();

$profile_image_path = 'uploads/' . $profile_data['profile_image'];
$cover_image_path = 'uploads/' . $profile_data['cover_image'];



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Company Profile</title>
    <link rel="stylesheet" type="text/css" href="Account/Organization/css/Profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->



    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



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
                <div class="print-left">


                </div>


                <div class="row-profile" id="row_profile">

                    <div class="column-profile column-side profile-pic">
                        <img class="img-account-profile rounded-circle mb-2" id="profile-image"
                            src="<?php echo $profile_data['profile_image'] ? 'uploads/' . $profile_data['profile_image'] : 'uploads/default.png'; ?>"
                            alt="Profile Image Preview" style="width: 16rem;  object-fit: cover;">



                    </div>
                    <div class="column-profile ">
                        <div class="card-body">
                            <span class="fullname"><?= $organizationName ?></span>
                            <br>
                            <i class="fa fa-bullseye" aria-hidden="true"></i><span class="other-info"><?= $strand ?>
                            </span>
                            <br>
                            <i class="fa fa-envelope" aria-hidden="true"></i><span
                                class="other-info"><?= $email ?></span>
                            <br>
                            <i class="fa fa-phone" aria-hidden="true"></i><span class="other-info"> <?= $phoneNumber ?>
                            </span>
                            <br>
                            <a href="https://www.google.com/maps/search/?api=1&query=NUEVA+ECIJA" target="_blank"
                                style="text-decoration: none;">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span class="other-info"><?= $address ?></span>
                            </a>
                        </div>

                    </div>
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
        <!-- <div class="dashboard-body">

            <main class="dashboard__main app-content">

                <article class="app-content__widget app-content__widget--primary">

                    <h2 class="title-resume">Personal Summary</h2>
                    <span class="description-resume">Introduce yourself and explain your goals and interest in work
                        immersion. </span>
                    <form class="txt-Personal-summary">
                        <div>
                            <textarea class="form-control" rows="10" placeholder=""></textarea>
                            <span class="description-resume subtitle-resume">Stay safe. Don’t include sensitive personal
                                information such as identity documents, health, race, religion or financial data.
                            </span>
                        </div>

                        <button class="btn-save">Save Summary</button>

                    </form>

 
                </article>

                <article class="app-content__widget app-content__widget--secondary">

                    <div class="card-strong-profile">
                        <h1 class="title-resume">Profile Strength</h1>
                        <div class="card__indicator">

                            <span class="card__indicator-percentage">20%</span>
                        </div>
                        <div class="card__progress"><progress max="100" value="20"></progress></div>

                    </div>


                    <div class="slideshow-container">
                        <div class="mySlides fade-text">
                            <div class="card__subtitle ">
                                Showcase relevant skills and projects in your resume and cover letter
                            </div>
                        </div>
                        <div class="mySlides fade-text " style="display: none;">
                            <div class="card__subtitle">
                                Introduce yourself and explain your goals and interest in work immersion.
                            </div>
                        </div>
                        <div class="mySlides fade-text" style="display: none;">
                            <div class="card__subtitle">
                                Fill in accurate personal information, and interests.
                            </div>
                        </div>
                    </div>
                    <button class="next" onclick="nextSlide()">Next tip &#8594;</button>

                </article>


            </main>
        </div> -->

        <?php if (
            isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'Student' || $_SESSION['account_type'] === '	
Organization' || $_SESSION['account_type'] === '	
School'
        ): ?>
        <div class="dashboard-body docu">
            <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">
                    <hr>
                    <h2 class="title-resume">Application Documents</h2>
                    <div id="content-cover">
                        <table class="table" id="sortableTable-docu">
                            <thead>
                                <tr>
                                    <th class="th-name">Document Name</th>
                                    <th class="th-date">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($unique_documents as $document_name): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($document_name_mapping[$document_name] ?? $document_name); ?>
                                    </td>
                                    <td>
                                        <?php
                                                // Check for the document URL and existence of file
                                                $sql = "SELECT document_url FROM uploaded_documents WHERE user_id = :user_id AND document_name = :document_name";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                                                $stmt->bindParam(':document_name', $document_name, PDO::PARAM_STR);
                                                $stmt->execute();
                                                $document_url = $stmt->fetchColumn();

                                                if ($document_url) {
                                                    $file_path = $_SERVER['DOCUMENT_ROOT'] . '/Account/Student/documents/' . basename($document_url);
                                                    if (file_exists($file_path)): ?>
                                        <a class="btn btn-download btn-success"
                                            href="<?php echo $_SERVER['PHP_SELF'] . '?document_name=' . htmlspecialchars($document_name) . '&student_id=' . $IdParam; ?>">
                                            Download
                                        </a>
                                        <!-- Uncomment the button below to enable viewing functionality -->
                                        <!-- <a class="btn btn-view btn-info" href="view_document.php?document_name=<?php echo urlencode($document_name); ?>" target="_blank">View</a> -->
                                        <!-- <a class="btn btn-delete btn-danger button-delete">Delete</a> -->
                                        <?php else: ?>
                                        <button disabled>File Not Available</button>
                                        <?php endif;
                                                } else { ?>
                                        <button disabled>No Document Found</button>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </table>
                    </div>
                    <hr>
                    <h2 class="title-resume">Insight</h2>
                    <span class="description-resume">The line chart analyzes student daily performance in work
                        immersion, and the pie chart displays the distribution of performance levels.</span>

                    <div class="container-grap">
                        <div class="dp-graph" id="piechart_3d"></div>
                    </div>
                    <div class="container-grap">
                        <div class="dp-graph" id="dp_chart_div"></div>
                    </div>
                </article>
            </main>
        </div>
        <?php endif; ?>

        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">

                    <hr>
                    <h2 class="title-resume">About Us</h2>

                    <div class="DailyJournal">
                        <div class="editable-container">
                            <textarea id="about-us-edit-textarea" placeholder="Tell us about your company"
                                readonly><?= htmlspecialchars($aboutUs) ?></textarea>
                            <?php if (
                                isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'Organization'
                            ): ?>
                            <span class="edit-icon" onclick="toggleEdit('about-us-edit-textarea')">
                                <i class="fa fa-pencil" aria-hidden="true" style="color: #08203a;"></i>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>



                </article>

            </main>
        </div>
        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">

                    <hr>
                    <h2 class="title-resume">Corporate Mission</h2>

                    <div class="DailyJournal">
                        <div class="editable-container">
                            <textarea id="mission-edit-textarea" placeholder="State your mission"
                                readonly><?= htmlspecialchars($corporateMission) ?></textarea>
                            <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'Organization'): ?>

                            <span class="edit-icon" onclick="toggleEdit('mission-edit-textarea')">
                                <i class="fa fa-pencil" aria-hidden="true" style="color: #08203a;"></i>
                            </span>
                            <?php endif; ?>
                        </div>

                    </div>



                </article>

            </main>
        </div>


        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">

                    <hr>
                    <h2 class="title-resume">Corporate Vision</h2>

                    <div class="DailyJournal">
                        <div class="editable-container">
                            <textarea id="vision-edit-textarea" placeholder="State your vision"
                                readonly><?= htmlspecialchars($corporateVision) ?></textarea>
                            <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'Organization'): ?>
                            <span class="edit-icon" onclick="toggleEdit('vision-edit-textarea')">
                                <i class="fa fa-pencil" aria-hidden="true" style="color: #08203a;"></i>
                            </span>
                            <?php endif; ?>
                        </div>

                    </div>



                </article>

            </main>
        </div>



        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">

                    <hr>
                    <h2 class="title-resume">Our Principles</h2>

                    <div class="DailyJournal">
                        <div class="editable-container">
                            <textarea id="principles-edit-textarea" placeholder="State your principles"
                                readonly><?= htmlspecialchars($corporatePrinciples) ?></textarea>
                            <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'Organization'): ?>
                            <span class="edit-icon" onclick="toggleEdit('principles-edit-textarea')">
                                <i class="fa fa-pencil" aria-hidden="true" style="color: #08203a;"></i>
                            </span>
                            <?php endif; ?>
                        </div>

                    </div>



                </article>

            </main>
        </div>




        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">

                    <hr>
                    <h2 class="title-resume">Our Philosophy</h2>

                    <div class="DailyJournal">
                        <div class="editable-container">
                            <textarea id="philosophy-edit-textarea" placeholder="State your philosophy"
                                readonly><?= htmlspecialchars($corporatePhilosophy) ?></textarea>
                            <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'Organization'): ?>
                            <span class="edit-icon" onclick="toggleEdit('philosophy-edit-textarea')">
                                <i class="fa fa-pencil" aria-hidden="true" style="color: #08203a;"></i>
                            </span>
                            <?php endif; ?>
                        </div>

                    </div>



                </article>

            </main>
        </div>




        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">

                    <hr>
                    <h2 class="title-resume">Event Highlights</h2>

                    <div class="DailyJournal">
                        <div class="container-gallery">




                            <div id="gallery" class="gallery"></div>
                        </div>

                        <div id="image-modal" class="modal">

                            <button class="download-button">
                                <i class="fas fa-download"></i>
                            </button>

                            <span class="close" id="close-modal">&times;</span>
                            <img class="modal-content" id="modal-img">
                            <div id="caption"></div>

                        </div>


                    </div>
                    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'Organization'): ?>
                    <hr>

                    <span class="description-resume">Upload a clear, well-oriented photo for your profile to ensure
                        accurate representation.</span>
                    <br>

                    <div class="file-upload">
                        <input type="file" id="file-input" multiple accept="image/*">
                        <label for="file-input"> <span>
                                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                                </svg>
                                Upload Photo
                            </span></label>
                    </div>

                    <?php endif; ?>


                </article>

            </main>
        </div>



    </div>



    <footer>
        2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School
    </footer>

    <script src="Account/Organization/js/profile.js"></script>
</body>

</html>