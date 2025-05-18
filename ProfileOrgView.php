<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

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


} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$profile_divv = '<header class="nav-header">
        <div class="logo">
            <a href="/Account/' . $_SESSION['account_type'] . '"> 
                <img src="img/drdsnhs.svg" alt="Logo">
            </a>
           
            
        </div>
        <nav class="by">

 
 <a class="btn-home" style="color:#fff; font-weight: 600;" href="../../Account/' . $_SESSION['account_type'] . '"> Back </a>
  
</div>
        
        </nav>

    </header> 

    ';


$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);
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

$profile_image_path = '/Account/Organization/uploads/' . $profile_data['profile_image'];
$cover_image_path = '/Account/Organization/uploads/' . $profile_data['cover_image'];


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

if (isset($_GET['document_name'])) {
    $document_name = $_GET['document_name'];

    $acceptable_documents = [
        'resume',
        'application_letter',
        'parents_consent',
        'barangay_clearance',
        'mayors_permit',
        'police_clearance',
        'medical_certificate',
        'insurance_policy',
        'business_permit',
        'memorandum_of_agreement'
    ];

    // Check if the document name is valid
    if (!in_array($document_name, $acceptable_documents)) {
        die("Invalid document name!");
    }

    $sql = "SELECT document_url FROM uploaded_documents WHERE user_id = :user_id AND document_name = :document_name";
    $stmt = $pdo->prepare($sql);

    // Bind parameters and execute
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':document_name', $document_name, PDO::PARAM_STR);
    $stmt->execute();

    $document_url = $stmt->fetchColumn();

    if ($document_url) {
        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/Account/Organization/documents/' . basename($document_url);

        echo $file_path;
        if (file_exists($file_path)) {

            $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

            $mime_types = [
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'txt' => 'text/plain',
                'png' => 'image/png',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',

            ];

            $content_type = isset($mime_types[$file_extension]) ? $mime_types[$file_extension] : 'application/octet-stream';

            header('Content-Description: File Transfer');
            header('Content-Type: ' . $content_type);
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));

            flush();
            readfile($file_path);
            exit;
        } else {
            die("File not found!");
        }
    } else {
        die("Document URL not found in the database!");
    }
}

$sql = "SELECT document_name FROM uploaded_documents WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

$unique_documents = [];
foreach ($documents as $doc) {
    if (!empty($doc['document_name']) && !isset($unique_documents[$doc['document_name']])) {
        $unique_documents[$doc['document_name']] = $doc['document_name'];
    }
}

$document_name_mapping = [
    'resume' => 'Resume',
    'application_letter' => 'Application Letter',
    'parents_consent' => 'Parents Consent',
    'barangay_clearance' => 'Barangay Clearance',
    'mayors_permit' => 'Mayor\'s Permit',
    'police_clearance' => 'Police Clearance',
    'medical_certificate' => 'Medical Certificate',
    'insurance_policy' => 'Insurance Policy',
    'business_permit' => 'Business Permit',
    'memorandum_of_agreement' => 'Memorandum of Agreement'
];

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

    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" /> -->

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
                            src="<?php echo $profile_data['profile_image'] ? '/Account/Organization/uploads/' . $profile_data['profile_image'] : 'uploads/default.png'; ?>"
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

        <?php endif; ?>

        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">

                    <hr>
                    <h2 class="title-resume">About Us</h2>

                    <div class="DailyJournal">
                        <div class="editable-container">
                            <textarea class="textarea-com-details" id="about-us-edit-textarea"
                                placeholder="Tell us about your company"
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
                            <textarea class="textarea-com-details" id="mission-edit-textarea"
                                placeholder="State your mission"
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
                            <textarea class="textarea-com-details" id="vision-edit-textarea"
                                placeholder="State your vision"
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
                            <textarea class="textarea-com-details" id="principles-edit-textarea"
                                placeholder="State your principles"
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
                            <textarea class="textarea-com-details" id="philosophy-edit-textarea"
                                placeholder="State your philosophy"
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
                                    <?php
                                    // Start by checking for URL and existence of the document
                                    $sql = "SELECT document_url FROM uploaded_documents WHERE user_id = :user_id AND document_name = :document_name";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                                    $stmt->bindParam(':document_name', $document_name, PDO::PARAM_STR);
                                    $stmt->execute();
                                    $document_url = $stmt->fetchColumn();

                                    // Only render a row if a valid document exists
                                    if ($document_url) {
                                        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/Account/Organization/documents/' . basename($document_url);
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($document_name_mapping[$document_name] ?? $document_name); ?>
                                            </td>
                                            <td>
                                                <?php if (file_exists($file_path)): ?>
                                                    <a class="btn btn-download btn-success"
                                                        href="<?php echo $_SERVER['PHP_SELF'] . '?document_name=' . htmlspecialchars($document_name) . '&organization_id=' . $IdParam; ?>">
                                                        Download
                                                    </a>
                                                <?php else: ?>
                                                    <button disabled>File Not Available</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <!-- Only create a row if document_url exists -->
                                <?php endforeach; ?>
                            </tbody>

                            <tr>
                                <td>
                                </td>
                                <td>
                                    <?php

                                    if (!$conn) {
                                        try {
                                            $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
                                            $conn = new PDO($dsn, $username, $password, [
                                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                                            ]);
                                        } catch (PDOException $e) {
                                            die("Database connection failed: " . $e->getMessage());
                                        }
                                    }

                                    // Check for the document URL and existence of file
                                    $sql = "SELECT document_url FROM uploaded_documents WHERE user_id = :user_id AND document_name = :document_name";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                                    $stmt->bindParam(':document_name', $document_name, PDO::PARAM_STR);
                                    $stmt->execute();
                                    $document_url = $stmt->fetchColumn();

                                    if ($document_url) {
                                        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/Account/Organization/' . basename($document_url);
                                        if (file_exists($file_path)): ?>
                                            <a class="btn btn-download btn-success"
                                                href="<?php echo $_SERVER['PHP_SELF'] . '?document_name=' . htmlspecialchars($document_name) . '&organization_id=' . $IdParam; ?>">
                                                Download
                                            </a>
                                            <!-- Uncomment the button below to enable viewing functionality -->
                                            <!-- <a class="btn btn-view btn-info" href="view_document.php?document_name=<?php echo urlencode($document_name); ?>" target="_blank">View</a> -->
                                            <!-- <a class="btn btn-delete btn-danger button-delete">Delete</a> -->
                                        <?php else: ?>

                                        <?php endif;
                                    } else { ?>
                                        <button disabled>No Document Found</button>
                                    <?php } ?>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        </table>
                    </div>

                </article>
            </main>
        </div>






        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <!-- <article class="app-content__widget app-content__widget--primary">

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

                    


                </article> -->

            </main>
        </div>

        <div class="btn-apr-dis"> <span class="frontend-text">Do you approve or disapprove of this company's
                account?</span><button class='button-10' type='submit' name='action' value='Approve'
                autofocus>Approve</button> <button class='button-11' type='submit' name='action' value='Disapprove'
                autofocus>Disapprove</button></div>

        <div class="container-alert-mssg">

            <!-- Danger Message -->
            <div class="xd-message msg-danger">
                <div class="xd-message-icon">
                    <!-- <i class="ion-close-round"></i> -->
                    <span class="label-remarks">Remarks</span>
                </div>
                <div class="xd-message-content">
                    <p>After careful review of the submitted background and documentation, we regret to inform you that
                        your
                        company account has not been approved at this time.</p>
                </div>
                <!--     <a href="#" class="xd-message-close">
<i class="close-icon ion-close-round"></i>
</a>   -->
            </div>

            <!-- Danger Success -->
            <div class="xd-message msg-success">
                <div class="xd-message-icon">
                    <!-- <i class="ion-checkmark"></i> -->
                    <span class="label-remarks">Remarks</span>
                </div>
                <div class="xd-message-content">
                    <p>Your company account has been approved after successfully reviewing the background information
                        and
                        verifying the complete document uploads.</p>
                </div>
                <!--     <a href="#" class="xd-message-close">
<i class="close-icon ion-close-round"></i>
</a>   -->
            </div>



        </div>



    </div>






    <footer>
        2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School
    </footer>

    <script src="js/profile.js"></script>
</body>

</html>