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

function fetchEvaluationDates($pdo, $student_id)
{
    $sql = "SELECT 
                MIN(CASE WHEN day = '1' THEN evaluation_date END) AS date_start,
                MAX(CASE WHEN day = '10' THEN evaluation_date END) AS date_end
            FROM Student_Evaluation 
            WHERE student_id = :student_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return [
            'date_start' => $result['date_start'] ? date('M d, Y', strtotime($result['date_start'])) : 'Not Available',
            'date_end' => $result['date_end'] ? date('M d, Y', strtotime($result['date_end'])) : 'Not Available'
        ];
    }

    return [
        'date_start' => 'Not Available',
        'date_end' => 'Not Available'
    ];
}

function fetchEvaluationDateRange($pdo, $student_id)
{
    $sql = "SELECT 
                MIN(evaluation_date) AS date_start,
                MAX(evaluation_date) AS date_end
            FROM Student_Evaluation 
            WHERE student_id = :student_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['date_start']) {
        return [
            'date_start' => date('M d, Y', strtotime($result['date_start'])),
            'date_end' => date('M d, Y', strtotime($result['date_end']))
        ];
    }

    return [
        'date_start' => 'Not Available',
        'date_end' => 'Not Available'
    ];
}

function getStudentEvaluationsByDay($conn, $user_id)
{
    $evaluations = array_fill(1, 10, null); // Initialize array for all 10 days

    $query = "SELECT * FROM Student_Evaluation 
              WHERE student_id = ? 
              ORDER BY day";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $day = intval($row['day']);

        $evaluations[$day] = [
            'evaluation_id' => $row['evaluation_id'],
            'evaluation_date' => $row['evaluation_date'],
            'work_habits' => [
                'punctual' => $row['punctual'],
                'reports_regularly' => $row['reports_regularly'],
                'performs_tasks_independently' => $row['performs_tasks_independently'],
                'self_discipline' => $row['self_discipline'],
                'dedication_commitment' => $row['dedication_commitment']
            ],
            'technical_skills' => [
                'ability_to_operate_machines' => $row['ability_to_operate_machines'],
                'handles_details' => $row['handles_details'],
                'shows_flexibility' => $row['shows_flexibility'],
                'thoroughness_attention_to_detail' => $row['thoroughness_attention_to_detail'],
                'understands_task_linkages' => $row['understands_task_linkages'],
                'offers_suggestions' => $row['offers_suggestions']
            ],
            'interpersonal_skills' => [
                'tact_in_dealing_with_people' => $row['tact_in_dealing_with_people'],
                'respect_and_courtesy' => $row['respect_and_courtesy'],
                'helps_others' => $row['helps_others'],
                'learns_from_co_workers' => $row['learns_from_co_workers'],
                'shows_gratitude' => $row['shows_gratitude'],
                'poise_and_self_confidence' => $row['poise_and_self_confidence'],
                'emotional_maturity' => $row['emotional_maturity']
            ]
        ];
    }

    $stmt->close();
    return $evaluations;
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
                <img src="image/drdsnhs.svg" alt="Logo">
            </a>
           
            
        </div>
        <nav class="by">

 
 <a class="btn-home" style="color:#fff; font-weight: 600; text-decoration:none;" href="../../Account/' . $_SESSION['account_type'] . '"> Back &#8594; </a>
  
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

    $sql = "SELECT document_url FROM uploaded_documents WHERE user_id = :user_id AND document_name = :document_name";
    $stmt = $pdo->prepare($sql);

    // Bind parameters and execute
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':document_name', $document_name, PDO::PARAM_STR);
    $stmt->execute();

    $document_url = $stmt->fetchColumn();


    if ($document_url) {
        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/Account/Student/documents/' . basename($document_url);


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
    'business_permit' => 'Business Permit'
];


$conn = new mysqli($host, $username, $password, $database);

$evaluations = getStudentEvaluationsByDay($conn, $user_id);

$cleaned_evaluations = array_filter($evaluations, function ($value) {
    return $value !== null;
});

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


$evaluation_dates = fetchEvaluationDates($pdo, $user_id);
$date_start = $evaluation_dates['date_start'];
$date_end = $evaluation_dates['date_end'];

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

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">



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
        // console.log(dailyPerformance);
    </script>
    <script type="text/javascript" src="css/eval_graph.js"></script>

    <style>

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
                            alt="Profile Image Preview" style="width: 16rem;  object-fit: cover;">



                    </div>
                    <div class="column-profile ">
                        <div class="card-body">
                            <span class="fullname"><?= $fullName ?></span>
                            <span class="LRN">LRN: <?= $lrn ?></span>

                            <br>

                            <i class="fa fa-graduation-cap" aria-hidden="true" title="Strand"></i><span
                                class="other-info"><?= $strand ?></span>
                            <br>
                            <i class="fa fa-envelope" aria-hidden="true" title="Email Address"></i><span
                                class="other-info"><?= $email ?></span>

                            <br>
                            <i class="fa fa-home" aria-hidden="true" title="School"></i><span
                                class="other-info"><?= $school ?></span>
                            <br>
                            <i class="fa fa-briefcase" aria-hidden="true" title="Position"></i><span
                                class="other-info"><?= $currentWork ?></span>

                            <br>
                            <i class="fa fa-calendar" aria-hidden="true" title="Date Start"></i><span
                                class="other-info"><?= $date_start ?></span>

                            <br>
                            <i class="fa fa-calendar" aria-hidden="true" title="Date End "></i><span
                                class="other-info"><?= $date_end ?></span>




                            <!-- <a href="print_profile.php?student_id=<?php echo $IdParam ?>" target="_blank"
                                style="text-decoration:none;"> <button class="print-btn">
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
                                </button></a> -->

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
                        <!-- <h2 class="title-resume">Insight</h2>
                    <span class="description-resume">The line chart analyzes student daily performance in work
                        immersion, and the pie chart displays the distribution of performance levels.</span>

                    <div class="container-grap">
                        <div class="dp-graph" id="piechart_3d"></div>
                    </div>
                    <div class="container-grap">
                        <div class="dp-graph" id="dp_chart_div"></div>
                    </div> -->
                    </article>
                </main>
            </div>
        <?php endif; ?>

        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">

                    <hr>
                    <h2 class="title-resume">Daily Journal</h2>

                    <div class="DailyJournal">
                        <?php
                        try {
                            // Create a new PDO instance
                            $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            // Prepare the SQL statement to fetch entries numbered 1 to 10
                            $stmt = $pdo->prepare("SELECT date, title, entry, entry_number FROM student_journals WHERE student_id = ? AND entry_number BETWEEN 1 AND 10 ORDER BY entry_number ASC");
                            $stmt->execute([$user_id]);

                            // Check if there are entries
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<div class="content-box">';
                                    echo '<div class="date">' . htmlspecialchars($row['date']) . '</div>';
                                    echo '<div class="day">Day ' . htmlspecialchars($row['entry_number']) . '</div>';
                                    echo '<div class="titleW">' . htmlspecialchars($row['title']) . '</div>';
                                    echo '<div class="description">' . htmlspecialchars($row['entry']) . '</div>';
                                    echo '<span class="action">';
                                    // echo '<a href="print_journal.php" target="_blank"><button class="eye fas fas fa-eye"></button></a>';
                                    // echo '<a href="print_journal.php" target="_blank"><button class="print fas fas fa-print"></button></a>';
                                    // echo '<button class="edit fas fa-pencil-alt"></button>';
                                    // echo '<button class="delete fas fa-trash-alt"></button>';
                                    echo '</span>';
                                    echo '</div>'; // close content-box
                                }
                            } else {
                                echo '<div class="content-box">No journal entries found.</div>';
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . htmlspecialchars($e->getMessage());
                        }
                        ?>
                    </div>

                    <hr>

                    <span class="description-resume">Daily journaling after work immersion boosts learning and
                        reflection for growth.</span>
                    <br>
                    <a href="Journal.php">
                        <button class="btn-create">
                            <span>
                                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                                </svg>
                                Create
                            </span>
                        </button></a>


                </article>
                <!-- <article class="app-content__widget app-content__widget--secondary">
                    
                </article>
                <article class="app-content__widget app-content__widget--tertiary">
                    
                </article> -->
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

                            <span class="close" id="close-modal">×</span>
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

                  <a href="">
                        <button class="btn-create">
                            <span>
                                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                                </svg>
                                Create
                            </span>
                        </button></a> -->


                <!-- </article>  -->
                <!-- <article class="app-content__widget app-content__widget--secondary">
                    
                </article>
                <article class="app-content__widget app-content__widget--tertiary">
                    
                </article> -->
                <hr>

                <h2 class="title-resume">Evaluation</h2>
                <span class="description-resume">From Day 1 to Day 10, the evaluation of the company on the students revealed a steady improvement in work habits, work skills, and social skills, demonstrating their ability to adapt and grow in a professional environment. <br> <br> </span>

                <table class="rwd-table">
                    <tbody>
                        <tr>
                            <th>Day 1</th>
                            <th>Day 2</th>
                            <th>Day 3</th>
                            <th>Day 4</th>
                            <th>Day 5</th>
                            <th>Day 6</th>
                            <th>Day 7</th>
                            <th>Day 8</th>
                            <th>Day 9</th>
                            <th>Day 10</th>
                        </tr>
                        <!-- First Student Row -->
                        <tr>
                            <td data-th="Day 1">
                                <div class="evaluation-status not-evaluated">
                                    <div>9/15/2023</div>
                                    <div style="font-size: 12px; margin-top: 3px;">✓ Done</div>
                                    <div class="rating-student">
                                        <div id="average">0</div>
                                        <div id="starContainer" class="stars">
                                            <span class="star" data-index="1">&#9733;</span>
                                            <span class="star" data-index="2">&#9733;</span>
                                            <span class="star" data-index="3">&#9733;</span>
                                            <span class="star" data-index="4">&#9733;</span>
                                            <span class="star" data-index="5">&#9733;</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Day 2">
                                <div class="evaluation-status evaluated">
                                    <div>9/15/2023</div>
                                    <div style="font-size: 12px; margin-top: 3px;">✓ Done</div>

                                    <div class="rating-student">
                                        <div id="average">0</div>
                                        <div id="starContainer" class="stars">
                                            <span class="star" data-index="1">&#9733;</span>
                                            <span class="star" data-index="2">&#9733;</span>
                                            <span class="star" data-index="3">&#9733;</span>
                                            <span class="star" data-index="4">&#9733;</span>
                                            <span class="star" data-index="5">&#9733;</span>
                                        </div>
                                    </div>

                                </div>
                            </td>
                            <td data-th="Day 3">
                                <div class="evaluation-status evaluated">
                                    <div>9/15/2023</div>
                                    <div style="font-size: 12px; margin-top: 3px;">✓ Done</div>
                                    <div class="rating-student">
                                        <div id="average">0</div>
                                        <div id="starContainer" class="stars">
                                            <span class="star" data-index="1">&#9733;</span>
                                            <span class="star" data-index="2">&#9733;</span>
                                            <span class="star" data-index="3">&#9733;</span>
                                            <span class="star" data-index="4">&#9733;</span>
                                            <span class="star" data-index="5">&#9733;</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Day 4">
                                <div class="evaluation-status not-evaluated">
                                    <div style="font-size: 12px;">✗ Pending</div>
                                </div>
                            </td>
                            <td data-th="Day 5">
                                <div class="evaluation-status evaluated">
                                    <div style="font-size: 12px;">✗ Pending</div>
                                </div>
                            </td>
                            <td data-th="Day 6">
                                <div class="evaluation-status not-evaluated">
                                    <div style="font-size: 12px;">✗ Pending</div>
                                </div>
                            </td>
                            <td data-th="Day 7">
                                <div class="evaluation-status evaluated">
                                    <div style="font-size: 12px;">✗ Pending</div>
                                </div>
                            </td>
                            <td data-th="Day 8">
                                <div class="evaluation-status not-evaluated">
                                    <div style="font-size: 12px;">✗ Pending</div>
                                </div>
                            </td>
                            <td data-th="Day 9">
                                <div class="evaluation-status not-evaluated">
                                    <div style="font-size: 12px;">✗ Pending</div>
                                </div>
                            </td>
                            <td data-th="Day 10">
                                <div class="evaluation-status evaluated">
                                    <div style="font-size: 12px;">✗ Pending</div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </main>
        </div>




        <div class="dashboard-body">

            <main class="dashboard__main app-content">
                <!-- <article class="app-content__widget app-content__widget--primary">

                    <hr>
                    <h2 class="title-resume">Evaluation Insight</h2>
                    <span class="description-resume">The graph summarizes supervisor feedback on students' work habits,
                        skills, and social skills during immersion.</span>
                    <div class="wp-graph eval-graph" id="wp-top-x-div" style="width: 100%; height: 400px;"></div>
                    <div class="pro-graph eval-graph" id="pro-top-x-div" style="width: 100%; height: 400px;"></div>
                    <div class="ld-graph eval-graph" id="ld-top-x-div" style="width: 100%; height: 400px;"></div>




                </article> -->
                <!-- <article class="app-content__widget app-content__widget--secondary">
                    
                </article>
                <article class="app-content__widget app-content__widget--tertiary">
                   
                </article> -->
            </main>
        </div>


        <script>
            const studentEvaluations = <?php echo json_encode($cleaned_evaluations, JSON_PRETTY_PRINT); ?>;

            // console.log('Student Evaluations:', studentEvaluations);

            function getEvaluationForDay(day) {
                return studentEvaluations[day] || null;
            }

            function calculateAverages() {
                let totals = {
                    work_habits: {},
                    technical_skills: {},
                    interpersonal_skills: {}
                };

                let counts = {
                    work_habits: {},
                    technical_skills: {},
                    interpersonal_skills: {}
                };

                // Sum up all scores
                Object.values(studentEvaluations).forEach(evaluation => {
                    for (let category in evaluation) {
                        if (typeof evaluation[category] === 'object') {
                            for (let metric in evaluation[category]) {
                                if (!totals[category][metric]) {
                                    totals[category][metric] = 0;
                                    counts[category][metric] = 0;
                                }
                                totals[category][metric] += evaluation[category][metric];
                                counts[category][metric]++;
                            }
                        }
                    }
                });

                let averages = {
                    work_habits: {},
                    technical_skills: {},
                    interpersonal_skills: {}
                };

                for (let category in totals) {
                    for (let metric in totals[category]) {
                        averages[category][metric] = totals[category][metric] / counts[category][metric];
                    }
                }
                return averages;
            }
        </script>


        <div class="dashboard-body">

            <!-- <main class="dashboard__main app-content">
                <article class="app-content__widget app-content__widget--primary">

                    <hr>
                    <h2 class="title-resume">Daily Evaluation Insight</h2>
                    <span class="description-resume">This report assesses senior high school students' work immersion
                        from Day 1 to Day 10, highlighting key performance metrics and growth trends to identify areas
                        for improvement in the program.</span>
                    <br>
                    <select id="dayDropdown">
                        <option value="Day 1">Day 1</option>
                        <option value="Day 2">Day 2</option>
                        <option value="Day 3">Day 3</option>
                        <option value="Day 4">Day 4</option>
                        <option value="Day 5">Day 5</option>
                        <option value="Day 6">Day 6</option>
                        <option value="Day 7">Day 7</option>
                        <option value="Day 8">Day 8</option>
                        <option value="Day 9">Day 9</option>
                        <option value="Day 10">Day 10</option>
                    </select> -->

            <!-- <div class="daily-graph eval-graph" id="chart_div_daily" style="width: 100%; height: 400px;"></div> -->

            <!-- <div class="daily-graph eval-graph" id="chart_div_daily1" style="height: 400px; width: 100%;"></div>
                    <div class="daily-graph eval-graph" id="chart_div_daily2" style="height: 400px; width: 100%;"></div>
                    <div class="daily-graph eval-graph" id="chart_div_daily3" style="height: 400px; width: 100%;"></div>




                </article> -->
            <!-- <article class="app-content__widget app-content__widget--secondary">
                    
                </article>
                <article class="app-content__widget app-content__widget--tertiary">
                   
                </article> -->
            <!-- </main> -->
        </div>




    </div>
    <!-- -------------------------------------END ------------------------------------------------- -->

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
    <script type="text/javascript" src="css/eval_daily.js"></script>

    <!-- End -->
    <footer>
        2024 Your Website. All rights reserved. | Dr Ramon De Santos National High School
        <!-- 2024 Your Website. All rights reserved. | Junior Philippines Computer
        Society Students -->
    </footer>

</body>

</html>