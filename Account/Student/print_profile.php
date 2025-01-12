<?php

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
            'score' => round($averageScore, 2)
        ];
    }

    return json_encode($formattedData);
}
$dailyPerformance = getDailyPerformance($user_id, $pdo);






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

$default_profile_image = '/Account/Student/uploads/default.png';
$default_cover_image = '/Account/Student/uploads/cover.png';

$profile_image_path = '/Account/Student/uploads/' . $profile_data['profile_image'];
$cover_image_path = '/Account/Student/uploads/' . $profile_data['cover_image'];

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $profile_image_path)) {
    $profile_image_path = $default_profile_image;
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $cover_image_path)) {
    $cover_image_path = $default_cover_image;
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printable Page</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <link rel="stylesheet" href="css/print_profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- <script type="text/javascript" src="css/eval_graph.js"></script> -->
</head>

<body>
    <div class="print-container">
        <div class="container-grap-right">

            <div class="row-profile" id="row_profile">

                <div class="column-profile column-side profile-pic">
                    <img src="<?php echo $profile_image_path; ?>" alt="Profile Image Preview"
                        style="border-radius: 50%;">


                </div>
                <div class="column-profile ">
                    <div class="card-body">
                        <span class="fullname"><?= $fullName ?></span>
                        <span class="LRN">LRN: <?= $lrn ?></span>
                        <br>

                        <i class="fa fa-graduation-cap" aria-hidden="true"></i><span
                            class="other-info"><?= $strand ?></span>
                        <br>
                        <i class="fa fa-envelope" aria-hidden="true"></i><span class="other-info"><?= $email ?></span>

                        <br>
                        <i class="fa fa-home" aria-hidden="true"></i><span class="other-info"><?= $school ?></span>
                        <br>
                        <i class="fa fa-briefcase" aria-hidden="true"></i><span
                            class="other-info"><?= $currentWork   ?></span>






                    </div>
                </div>
            </div>





        </div>

        <div class="student-graph">
            <hr>
            <h2 class="title-resume">Daily Insight</h2>
            <span class="description-resume">The line chart analyzes student daily performance in work
                immersion, and the pie chart displays the distribution of performance levels.</span>



            <div class="container-graph">
                <div class="column-graph">
                    <div class="container-grap">
                        <div class="dp-graph" id="piechart_3d"></div>
                    </div>
                </div>
                <div class="column-graph">
                    <div class="container-grap">
                        <div class="dp-graph" id="dp_chart_div"></div>

                    </div>
                </div>
            </div>


        </div>



        <div class="student-graph">
            <hr>
            <h2 class="title-resume">Evaluation Insight</h2>
            <span class="description-resume" style="margin-bottom:20px;">The graph summarizes supervisor feedback on
                students' work habits,
                skills, and social skills during immersion.</span>

            <div class="container-graph-bar">
                <div class="wp-graph eval-graph" id="wp-top-x-div"></div>
            </div>


            <div class="container-graph-bar">
                <div class="pro-graph eval-graph" id="pro-top-x-div"></div>
            </div>

            <div class="container-graph-bar">
                <div class="ld-graph eval-graph" id="ld-top-x-div"></div>
            </div>


        </div>

    </div>

    <!-- <button onclick="window.print()">Print this page</button> -->
</body>
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

<script>
google.charts.load("current", {
    packages: ["corechart"]
});
google.charts.setOnLoadCallback(drawChart);

var totalWorkHabits =
    Number(averages.avgPunctual || 0) +
    Number(averages.avgReportsRegularly || 0) +
    Number(averages.avgPerformsTasksIndependently || 0) +
    Number(averages.avgSelfDiscipline || 0) +
    Number(averages.avgDedicationCommitment || 0);

var totalWorkSkills =
    Number(averages.avgAbilityToOperateMachines || 0) +
    Number(averages.avgHandlesDetails || 0) +
    Number(averages.avgShowsFlexibility || 0) +
    Number(averages.avgThoroughnessAttentionToDetail || 0) +
    Number(averages.avgUnderstandsTaskLinkages || 0) +
    Number(averages.avgOffersSuggestions || 0);

var totalSocialSkills =
    Number(averages.avgTactInDealingWithPeople || 0) +
    Number(averages.avgRespectAndCourtesy || 0) +
    Number(averages.avgHelpsOthers || 0) +
    Number(averages.avgLearnsFromCoWorkers || 0) +
    Number(averages.avgShowsGratitude || 0) +
    Number(averages.avgPoiseAndSelfConfidence || 0) +
    Number(averages.avgEmotionalMaturity || 0);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ["Category", "Score"],
        ["Work Habits", totalWorkHabits],
        ["Work Skills", totalWorkSkills],
        ["Social Skills", totalSocialSkills],
    ]);

    var options = {
        title: "Total Work Performance",
        height: "50%",
        width: "50%",
        is3D: true,
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
    chart.draw(data, options);
    window.addEventListener("resize", function() {
        if (chart) {
            drawChart();
        }
    });

}


////////////////////////////////////////////////////DAILY PERFORMANCE ////////////////////////////////////

google.charts.load("current", {
    packages: ["corechart", "line"]
});
google.charts.setOnLoadCallback(drawBasic);

// function drawDailyPerformanceChart() {
//     var dp_data = new google.visualization.DataTable();
//     dp_data.addColumn("string", "Date");
//     dp_data.addColumn("number", "Performance Rating");


//     dailyPerformance.forEach(function(entry) {
//         dp_data.addRow([entry.date, entry.score]); 
//     });
function drawBasic() {

    var dp_data = new google.visualization.DataTable();
    dp_data.addColumn("string", "Date"); // X-axis as Date
    dp_data.addColumn("number", "Performance Rating"); // Y-axis as Performance Rating

    // Convert dailyPerformance data to DataTable rows
    dailyPerformance.forEach(function(entry) {
        dp_data.addRow([entry.date, entry.score]); // Add each entry as a new row
    });


    var options = {
        title: "Daily Performance",
        height: "100%",
        width: "100%",
        // hAxis: {
        //     title: "Date",
        //     format: "MMM dd",
        // },
        vAxis: {
            title: "Performance Rating",
            minValue: 0,
            maxValue: 5,
        },
        legend: {
            position: "bottom"
        },
    };

    var dp_chart = new google.visualization.LineChart(
        document.getElementById("dp_chart_div")
    );
    dp_chart.draw(dp_data, options);
}

// Redraw the chart on window resize
window.addEventListener("resize", function() {
    drawDailyPerformanceChart();
});

/////////////////////////////////////////////// WORK HABITS CHART ///////////////////////////////////////
google.charts.load("current", {
    packages: ["bar"],
});
google.charts.setOnLoadCallback(drawWorkHabitsChart);

// function drawWorkHabitsChart() {
//     var data = new google.visualization.arrayToDataTable([
//         ["Category", "Performance"],
//         ["Punctuality", averages.avgPunctual || 0],
//         ["Reports Regularly", averages.avgReportsRegularly || 0],
//         [
//             "Performs Tasks Independently",
//             averages.avgPerformsTasksIndependently || 0,
//         ],
//         ["Self Discipline", averages.avgSelfDiscipline || 0],
//         ["Dedication & Commitment", averages.avgDedicationCommitment || 0],
//     ]);
function drawWorkHabitsChart() {

    var data = new google.visualization.arrayToDataTable([
        ["Category", "Performance"],
        ["Punctuality", averages.avgPunctual || 0],
        ["Reports Regularly", averages.avgReportsRegularly || 0],
        [
            "Performs Tasks Independently",
            averages.avgPerformsTasksIndependently || 0,
        ],
        ["Self Discipline", averages.avgSelfDiscipline || 0],
        ["Dedication & Commitment", averages.avgDedicationCommitment || 0],
    ]);

    var options = {
        title: "Work Habits",
        height: "100%", // Set height to 100%
        width: "100%", // Set width to 100%
        legend: {
            position: "none"
        },
        chart: {
            title: "Work Habits",
            subtitle: "Student work habits from the work immersion",
        },
        bars: "horizontal", // Required for Material Bar Charts.
        axes: {
            x: {
                0: {
                    side: "top",
                    label: "Performance"
                }, // Top x-axis.
            },
        },
        bar: {
            groupWidth: "90%"
        },
    };

    var chart = new google.charts.Bar(document.getElementById("wp-top-x-div"));
    chart.draw(data, options);
}

// Redraw chart on window resize
window.addEventListener("resize", function() {
    drawWorkHabitsChart();
});
/////////////////////////////////////////////// WORK SKILLS CHART ///////////////////////////////////////
google.charts.load("current", {
    packages: ["bar"]
});
google.charts.setOnLoadCallback(drawWorkSkillsChart);

// function drawWorkSkillsChart() {
//     var data = new google.visualization.arrayToDataTable([
//         ["Category", "Performance"],
//         ["Ability to Operate Machines", averages.avgAbilityToOperateMachines || 0],
//         ["Handles Details", averages.avgHandlesDetails || 0],
//         ["Shows Flexibility", averages.avgShowsFlexibility || 0],
//         [
//             "Thoroughness & Attention to Detail",
//             averages.avgThoroughnessAttentionToDetail || 0,
//         ],
//         ["Understands Task Linkages", averages.avgUnderstandsTaskLinkages || 0],
//         ["Offers Suggestions", averages.avgOffersSuggestions || 0],
//     ]);
function drawWorkSkillsChart() {

    var data = new google.visualization.arrayToDataTable([
        ["Category", "Performance"],
        ["Ability to Operate Machines", averages.avgAbilityToOperateMachines || 0],
        ["Handles Details", averages.avgHandlesDetails || 0],
        ["Shows Flexibility", averages.avgShowsFlexibility || 0],
        [
            "Thoroughness & Attention to Detail",
            averages.avgThoroughnessAttentionToDetail || 0,
        ],
        ["Understands Task Linkages", averages.avgUnderstandsTaskLinkages || 0],
        ["Offers Suggestions", averages.avgOffersSuggestions || 0],
    ]);

    var options = {
        title: "Work Skills",
        height: "100%",
        width: "100%",
        legend: {
            position: "none"
        },
        chart: {
            title: "Work Skills",
            subtitle: "Student work skills from the work immersion",
        },
        bars: "horizontal",
        axes: {
            x: {
                0: {
                    side: "top",
                    label: "Performance"
                },
            },
        },
        bar: {
            groupWidth: "90%"
        },
    };

    var chart = new google.charts.Bar(document.getElementById("pro-top-x-div"));
    chart.draw(data, options);
}

// Redraw chart on window resize
window.addEventListener("resize", function() {
    drawWorkSkillsChart();
});


/////////////////////////////////////////////// Social Skills CHART ///////////////////////////////////////
google.charts.load("current", {
    packages: ["bar"]
});
google.charts.setOnLoadCallback(drawSocialSkillsChart);

// function drawSocialSkillsChart() {
//     var data = new google.visualization.arrayToDataTable([
//         ["Category", "Performance"],
//         ["Tact in Dealing with People", averages.avgTactInDealingWithPeople || 0],
//         ["Respect and Courtesy", averages.avgRespectAndCourtesy || 0],
//         ["Helps Others", averages.avgHelpsOthers || 0],
//         ["Learns from Co-Workers", averages.avgLearnsFromCoWorkers || 0],
//         ["Shows Gratitude", averages.avgShowsGratitude || 0],
//         ["Poise and Self Confidence", averages.avgPoiseAndSelfConfidence || 0],
//         ["Emotional Maturity", averages.avgEmotionalMaturity || 0],
//     ]);
function drawSocialSkillsChart() {

    var data = new google.visualization.arrayToDataTable([
        ["Category", "Performance"],
        ["Tact in Dealing with People", averages.avgTactInDealingWithPeople || 0],
        ["Respect and Courtesy", averages.avgRespectAndCourtesy || 0],
        ["Helps Others", averages.avgHelpsOthers || 0],
        ["Learns from Co-Workers", averages.avgLearnsFromCoWorkers || 0],
        ["Shows Gratitude", averages.avgShowsGratitude || 0],
        ["Poise and Self Confidence", averages.avgPoiseAndSelfConfidence || 0],
        ["Emotional Maturity", averages.avgEmotionalMaturity || 0],
    ]);
    var options = {
        title: "Social Skills",
        height: "100%",
        width: "100%",
        legend: {
            position: "none"
        },
        chart: {
            title: "Social Skills",
            subtitle: "Student social skills from the work immersion",
        },
        bars: "horizontal",
        axes: {
            x: {
                0: {
                    side: "top",
                    label: "Performance"
                },
            },
        },
        bar: {
            groupWidth: "90%"
        },
    };

    var chart = new google.charts.Bar(document.getElementById("ld-top-x-div"));
    chart.draw(data, options);
}

// Redraw chart on window resize
window.addEventListener("resize", function() {
    drawSocialSkillsChart();
});
</script>

</html>