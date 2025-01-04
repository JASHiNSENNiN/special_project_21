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

    // Student profile data
    $firstName = $student_profile['first_name'];
    $middleName = $student_profile['middle_name'];
    $lastName = $student_profile['last_name'];
    $fullName = trim("$firstName $middleName $lastName");
    $school = $student_profile['school'];
    $gradeLevel = $student_profile['grade_level'];
    $lrn = $student_profile['lrn'];
    $strand = strtoupper($student_profile['strand']);
    $school = $student_profile['school'];
    $email = $user['email'];
    $profile_image_path = './uploads/' . $user['profile_image'];

    $get_profile_image = file_exists($profile_image_path) ? $profile_image_path : './image/default.png';
    $profile_image = ($get_profile_image === './uploads/') ? './image/default.png' : $get_profile_image;

    // Fetch averages from Student_Evaluation based on new fields
    $sql = "SELECT 
                AVG(punctual) AS avg_punctual,
                AVG(reports_regularly) AS avg_reports_regularly,
                AVG(performs_tasks_independently) AS avg_performs_tasks_independently,
                AVG(self_discipline) AS avg_self_discipline,
                AVG(dedication_commitment) AS avg_dedication_commitment,
                AVG(ability_to_operate_machines) AS avg_ability_to_operate_machines,
                AVG(handles_details) AS avg_handles_details,
                AVG(shows_flexibility) AS avg_shows_flexibility,
                AVG(thoroughness_attention_to_detail) AS avg_thoroughness_attention_to_detail,
                AVG(understands_task_linkages) AS avg_understands_task_linkages,
                AVG(offers_suggestions) AS avg_offers_suggestions,
                AVG(tact_in_dealing_with_people) AS avg_tact_in_dealing_with_people,
                AVG(respect_and_courtesy) AS avg_respect_and_courtesy,
                AVG(helps_others) AS avg_helps_others,
                AVG(learns_from_co_workers) AS avg_learns_from_co_workers,
                AVG(shows_gratitude) AS avg_shows_gratitude,
                AVG(poise_and_self_confidence) AS avg_poise_and_self_confidence,
                AVG(emotional_maturity) AS avg_emotional_maturity
            FROM Student_Evaluation WHERE student_id = :student_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':student_id', $user_id);
    $stmt->execute();
    $averages = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retrieve average values
    $avgPunctual = $averages['avg_punctual'] ?? null;
    $avgReportsRegularly = $averages['avg_reports_regularly'] ?? null;
    $avgPerformsTasksIndependently = $averages['avg_performs_tasks_independently'] ?? null;
    $avgSelfDiscipline = $averages['avg_self_discipline'] ?? null;
    $avgDedicationCommitment = $averages['avg_dedication_commitment'] ?? null;
    $avgAbilityToOperateMachines = $averages['avg_ability_to_operate_machines'] ?? null;
    $avgHandlesDetails = $averages['avg_handles_details'] ?? null;
    $avgShowsFlexibility = $averages['avg_shows_flexibility'] ?? null;
    $avgThoroughnessAttentionToDetail = $averages['avg_thoroughness_attention_to_detail'] ?? null;
    $avgUnderstandsTaskLinkages = $averages['avg_understands_task_linkages'] ?? null;
    $avgOffersSuggestions = $averages['avg_offers_suggestions'] ?? null;
    $avgTactInDealingWithPeople = $averages['avg_tact_in_dealing_with_people'] ?? null;
    $avgRespectAndCourtesy = $averages['avg_respect_and_courtesy'] ?? null;
    $avgHelpsOthers = $averages['avg_helps_others'] ?? null;
    $avgLearnsFromCoWorkers = $averages['avg_learns_from_co_workers'] ?? null;
    $avgShowsGratitude = $averages['avg_shows_gratitude'] ?? null;
    $avgPoiseAndSelfConfidence = $averages['avg_poise_and_self_confidence'] ?? null;
    $avgEmotionalMaturity = $averages['avg_emotional_maturity'] ?? null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

function getDailyPerformance($student_id, $pdo)
{
    $sql = "SELECT 
                DATE(evaluation_date) as evaluation_date, 
                AVG(punctual) AS avg_punctual,
                AVG(reports_regularly) AS avg_reports,
                AVG(performs_tasks_independently) AS avg_independent_tasks,
                AVG(self_discipline) AS avg_self_discipline,
                AVG(dedication_commitment) AS avg_commitment
            FROM Student_Evaluation 
            WHERE student_id = :student_id 
            GROUP BY DATE(evaluation_date)
            ORDER BY DATE(evaluation_date) ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();

    $dailyPerformance = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare the data for JavaScript
    $formattedData = [];
    foreach ($dailyPerformance as $row) {
        $date = (string) $row['evaluation_date'];
        $averageScore = (
            ($row['avg_punctual'] +
                $row['avg_reports'] +
                $row['avg_independent_tasks'] +
                $row['avg_self_discipline'] +
                $row['avg_commitment']) / 5) ?? 0;

        $formattedData[] = [
            'date' => $date,
            'score' => round($averageScore, 2) // Round to 2 decimal places
        ];
    }

    return json_encode($formattedData);
}
$dailyPerformance = getDailyPerformance($user_id, $pdo);

$profile_divv = '<header class="nav-header">
        <div class="logo">
            <a href="../../Account/' . $_SESSION['account_type'] . '"> 
                <img src="image/logov3.jpg" alt="Logo">
            </a>
           
            
        </div>
        <nav class="by">

 
 <a class="btn-home" style="color:#1bbc9b; font-weight: 600;" href="../../Account/' . $_SESSION['account_type'] . '"> Back </a>
  
</div>
        
        </nav>

    </header> 

    ';




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

    // Define the acceptable document names
    $acceptable_documents = [
        'resume',
        'application_letter',
        'parents_consent',
        'barangay_clearance',
        'mayors_permit',
        'police_clearance',
        'medical_certificate',
        'insurance_policy',
        'business_permit'
    ];

    // Check if the document name is valid
    if (!in_array($document_name, $acceptable_documents)) {
        die("Invalid document name!");
    }

    // Prepare the SQL statement
    $sql = "SELECT document_url FROM uploaded_documents WHERE user_id = :user_id AND document_name = :document_name";
    $stmt = $pdo->prepare($sql);

    // Bind parameters and execute
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':document_name', $document_name, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the document URL
    $document_url = $stmt->fetchColumn();

    // Check if the document URL exists
    if ($document_url) {
        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/Account/Student/documents/' . basename($document_url);

        // Check if file exists
        if (file_exists($file_path)) {
            // Set headers to initiate download
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf'); // Adjust based on actual file type
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            flush(); // Flush the system output buffer
            readfile($file_path); // Read and output the file
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
    'business_permit' => 'Business Permit'
];


$conn = new mysqli($host, $username, $password, $database);

$profile_data = null;
if (isset($user_id)) {
    $sql = "SELECT sp.*, u.profile_image, u.cover_image
FROM student_profiles sp
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
    <link rel="stylesheet" type="text/css" href="css/Profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <title>Student Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->


    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- ---------------------------script ---------------------- -->
    <script type="text/javascript">
    const averages = {
        avgPunctual: <?= json_encode($avgPunctual) ?>,
        avgReportsRegularly: <?= json_encode($avgReportsRegularly) ?>,
        avgPerformsTasksIndependently: <?= json_encode($avgPerformsTasksIndependently) ?>,
        avgSelfDiscipline: <?= json_encode($avgSelfDiscipline) ?>,
        avgDedicationCommitment: <?= json_encode($avgDedicationCommitment) ?>,
        avgAbilityToOperateMachines: <?= json_encode($avgAbilityToOperateMachines) ?>,
        avgHandlesDetails: <?= json_encode($avgHandlesDetails) ?>,
        avgShowsFlexibility: <?= json_encode($avgShowsFlexibility) ?>,
        avgThoroughnessAttentionToDetail: <?= json_encode($avgThoroughnessAttentionToDetail) ?>,
        avgUnderstandsTaskLinkages: <?= json_encode($avgUnderstandsTaskLinkages) ?>,
        avgOffersSuggestions: <?= json_encode($avgOffersSuggestions) ?>,
        avgTactInDealingWithPeople: <?= json_encode($avgTactInDealingWithPeople) ?>,
        avgRespectAndCourtesy: <?= json_encode($avgRespectAndCourtesy) ?>,
        avgHelpsOthers: <?= json_encode($avgHelpsOthers) ?>,
        avgLearnsFromCoWorkers: <?= json_encode($avgLearnsFromCoWorkers) ?>,
        avgShowsGratitude: <?= json_encode($avgShowsGratitude) ?>,
        avgPoiseAndSelfConfidence: <?= json_encode($avgPoiseAndSelfConfidence) ?>,
        avgEmotionalMaturity: <?= json_encode($avgEmotionalMaturity) ?>

    };
    const dailyPerformance = <?= getDailyPerformance($user_id, $pdo) ?>;
    console.log(dailyPerformance);
    </script>
    <script type="text/javascript" src="css/eval_graph.js"></script>

    <style>
    @media print {
        body {

            -webkit-print-color-adjust: exact;
            margin: 0;
            padding: 0;
            overflow: hidden;
            height: 100% !important;
        }

        .column-profile {
            float: left;
            width: auto;
            padding: 10px;
            height: 300px;
        }

        .row-profile:after {
            content: "";
            display: table;
            clear: both;
        }


        .print-btn,
        .docu,
        .edit-button,
        .nav-header,
        footer {
            display: none;
        }

        /* #piechart_3d,
            #dp_chart_div {
                width: auto;
                height: 200%;
                padding-bottom: 50px;


            } */

        /* main,
            .app-content__widget,
            .eval-graph,
            .dp-graph {
                
                

            } */

    }
    </style>


</head>

<body>

    <?php
    if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'Student') {
        echo $profile_divv;
    } else {
        // echo $profile_div_non_student;
    }

    ?>

    <div class="row-graph-profile">
        <div class="column-graph-profile-right">

            <div class="container-grap-right">
                <div class="print-left">


                </div>


                <div class="row-profile" id="row_profile">

                    <div class="column-profile column-side profile-pic">
                        <img class="img-account-profile rounded-circle mb-2" id="profile-image"
                            src="<?php echo $profile_data['profile_image'] ? 'uploads/' . $profile_data['profile_image'] : 'uploads/default.png'; ?>"
                            alt="Profile Image Preview" style="width: 200px; height: 200px; object-fit: cover;">



                    </div>
                    <div class="column-profile ">
                        <div class="card-body">
                            <span class="fullname"><?= $fullName ?></span>
                            <span class="LRN">LRN: <?= $lrn ?></span>

                            <br>

                            <i class="fa fa-graduation-cap" aria-hidden="true"></i><span
                                class="other-info"><?= $strand ?></span>
                            <br>
                            <i class="fa fa-envelope" aria-hidden="true"></i><span
                                class="other-info"><?= $email ?></span>

                            <br>
                            <i class="fa fa-home" aria-hidden="true"></i><span class="other-info"><?= $school ?></span>
                            <br>
                            <i class="fa fa-briefcase" aria-hidden="true"></i><span
                                class="other-info"><?= $currentWork ?></span>




                            <a href="print_profile.php" target="_blank" style="text-decoration:none;"> <button
                                    class="print-btn">
                                    <span class="printer-wrapper">
                                        <span class="printer-container">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 92 75">
                                                <path stroke-width="5" stroke="black"
                                                    d="M12 37.5H80C85.2467 37.5 89.5 41.7533 89.5 47V69C89.5 70.933 87.933 72.5 86 72.5H6C4.067 72.5 2.5 70.933 2.5 69V47C2.5 41.7533 6.75329 37.5 12 37.5Z">
                                                </path>
                                                <mask fill="white" id="path-2-inside-1_30_7">
                                                    <path
                                                        d="M12 12C12 5.37258 17.3726 0 24 0H57C70.2548 0 81 10.7452 81 24V29H12V12Z">
                                                    </path>
                                                </mask>
                                                <path mask="url(#path-2-inside-1_30_7)" fill="black"
                                                    d="M7 12C7 2.61116 14.6112 -5 24 -5H57C73.0163 -5 86 7.98374 86 24H76C76 13.5066 67.4934 5 57 5H24C20.134 5 17 8.13401 17 12H7ZM81 29H12H81ZM7 29V12C7 2.61116 14.6112 -5 24 -5V5C20.134 5 17 8.13401 17 12V29H7ZM57 -5C73.0163 -5 86 7.98374 86 24V29H76V24C76 13.5066 67.4934 5 57 5V-5Z">
                                                </path>
                                                <circle fill="black" r="3" cy="49" cx="78"></circle>
                                            </svg>
                                        </span>

                                        <span class="printer-page-wrapper">
                                            <span class="printer-page"></span>
                                        </span>
                                    </span>
                                    Print
                                </button></a>

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


    <!-- -----------------------------------column graph ------------------------- -->

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

        <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'Student'): ?>
        <div class="dashboard-body docu">

            <main class="dashboard__main app-content">

                <article class="app-content__widget app-content__widget--primary">
                    <hr>
                    <h2 class="title-resume">Application Documents</h2>
                    <!-- <span class="description-resume">Please upload the required documents for your work immersion
                        application: resume, application letter, barangay clearance, police clearance, mayor's
                        clearance, and medical certificate. </span> -->
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
                                            href="<?php echo $_SERVER['PHP_SELF'] . '?document_name=' . htmlspecialchars($document_name); ?>">
                                            Download
                                        </a>
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
                        <!-- <div class="one_col file-upload">
                                <label for="documentType">Document Type:</label>
                                <select id="documentType" name="documentType">
                                    <option value="">--Select--</option>
                                    <option value="Resume">Resume</option>
                                    <option value="Application-letter ">Application letter </option>
                                    <option value="Barangay">Barangay</option>
                                    <option value="Police-Clearance ">Police Clearance </option>
                                    <option value="Mayors-Clearance ">Mayor's Clearance </option>
                                    <option value="Medical-Certificate">Medical Certificate</option>
                                </select>
                                <div id="file">
                                    <ul id="image-list">
                                    </ul>
                                </div>
                                <input type="file" class="file" name="images" id="uploadFile" multiple />
                                <span class="error"></span>
                            </div> -->
                        <!-- <button class="btn btn-add btn-primary" disabled="disabled">Add New</button> -->

                        <!-- <span class="successfully-saved">
                                <i class="fa fa-thumbs-up"></i> Saved!
                            </span> -->





                    </div>
                    <hr>
                    <h2 class="title-resume">Daily Insight</h2>
                    <span class="description-resume">The line chart analyzes student daily performance in work
                        immersion, and the pie chart displays the distribution of performance levels.</span>


                    <div class="container-grap">
                        <div class="dp-graph" id="piechart_3d"></div>
                    </div>



                    <div class="container-grap">
                        <div class="dp-graph" id="dp_chart_div"></div>

                    </div>
                </article>

                <div class="DailyJournal">
                    <h2 class="title-resume">Daily Journal (2/10)</h2>

                    <div class="content-box">
                        <div class="date">January 3, 2025</div>
                        <div class="day">Day 1</div>

                        <div class="titleW">Work Immersion Report</div>
                        <div class="description">
                            This report highlights the key learnings and experiences during the work immersion program.
                            It includes
                            tasks performed, skills gained, challenges encountered, and reflections on the work
                            experience.
                        </div>
                    </div>
                    <div class="content-box">
                        <div class="date">January 4, 2025</div>
                        <div class="day">Day 2</div>

                        <div class="titleW">Work Immersion Report</div>
                        <div class="description">
                            This report highlights the key learnings and experiences during the work immersion program.
                            It includes
                            tasks performed, skills gained, challenges encountered, and reflections on the work
                            experience.
                        </div>
                    </div>
                    <!-- <button class="next">View all &#8594;</button> -->
                    <a href="#">View all</a>
                </div>

            </main>
        </div>
        <?php endif; ?>





        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">

                    <hr>
                    <h2 class="title-resume">Evaluation Insight</h2>
                    <span class="description-resume">The graph summarizes supervisor feedback on students' work habits,
                        skills, and social skills during immersion.</span>
                    <div class="wp-graph eval-graph" id="wp-top-x-div" style="width: 100%; height: 400px;"></div>
                    <div class="pro-graph eval-graph" id="pro-top-x-div" style="width: 100%; height: 400px;"></div>
                    <div class="ld-graph eval-graph" id="ld-top-x-div" style="width: 100%; height: 400px;"></div>




                </article>
                <article class="app-content__widget app-content__widget--secondary">
                    <!-- widget - secondary
                    <hr> -->
                </article>
                <article class="app-content__widget app-content__widget--tertiary">
                    <!-- widget - tertiary
                    <hr> -->
                </article>
            </main>
        </div>
    </div>
    <!-- -------------------------------------END ------------------------------------------------- -->
    <!-- ----------------------------------------EVALUATION GRAPH----------------------------------- -->

    <!-- <div class="container light-style flex-grow-1 container-p-y"
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
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#tc-top-x-div-sel">Team Work and Collaboration</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#am-top-x-div-sel">Attitude and Motivation</a>

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

                        <div class="tab-pane fade active " id="tc-top-x-div-sel">
                            <div class="tc-graph" id="tc-top-x-div" style="width: 100%; height: 400px;"></div>
                        </div>

                        <div class="tab-pane fade active" id="am-top-x-div-sel">
                            <div class="am-graph" id="am-top-x-div" style="width: 100%; height: 400px;"></div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div> -->



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
        2024 Your Website. All rights reserved. | Dr Ramon De Santos National High School
        <!-- 2024 Your Website. All rights reserved. | Junior Philippines Computer
        Society Students -->
    </footer>

</body>

</html>