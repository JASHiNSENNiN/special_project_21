<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
(Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/'))->load();

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlCheck = $conn->prepare("SELECT id, account_type FROM users WHERE email = ?");
    $sqlCheck->bind_param("s", $email);
    $sqlCheck->execute();
    $sqlCheck->bind_result($userId, $accountType);

    if ($sqlCheck->fetch() && $accountType) {
        $sqlCheck->close();

        $_SESSION['user_id'] = $userId;

        switch ($accountType) {
            case 'student':
                $stmt = $conn->prepare("SELECT first_name, middle_name, last_name, school, grade_level, strand FROM student_profiles WHERE user_id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $stmt->bind_result($firstName, $middleName, $lastName, $school, $gradeLevel, $strand);
                if ($stmt->fetch()) {
                    $_SESSION['profile'] = [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'school' => $school,
                        'grade_level' => $gradeLevel,
                        'strand' => $strand
                    ];
                }
                $stmt->close();
                break;

            case 'school':
                $stmt = $conn->prepare("SELECT school_name FROM school_profiles WHERE user_id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $stmt->bind_result($schoolName);
                if ($stmt->fetch()) {
                    $_SESSION['profile'] = [
                        'school_name' => $schoolName
                    ];
                }
                $stmt->close();
                break;

            case 'organization':
                $stmt = $conn->prepare("SELECT organization_name, strand FROM partner_profiles WHERE user_id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $stmt->bind_result($organizationName, $strand);
                if ($stmt->fetch()) {
                    $_SESSION['profile'] = [
                        'organization_name' => $organizationName,
                        'strand' => $strand
                    ];
                }
                $stmt->close();
                break;
        }

        $conn->close();

        $accType = ucfirst($accountType);
        $redirectUrl = "/Account/" . $accType . "/";
        header("Location: " . $redirectUrl);
        exit;
    } else {
        $sqlCheck->close();
        $conn->close();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        window.onload = function() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/backend/php/ajax/checkAccType.php', true);
            xhr.send();
        };
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <title>Set Up Account</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <link rel="stylesheet" type="text/css" href="../css/header_landing.css">
    <link rel="stylesheet" type="text/css" href="../css/loginform_landing.css">
    <link rel="stylesheet" type="text/css" href="../css/get_start_log.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TweenMax.min.js"></script>
    <script src="/backend/js/register.js"></script>
    <script src="/js/get_start_log.js"></script>

    <link
        href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,700,700i,800,800i,900,900i"
        rel="stylesheet">
</head>

<body>
    <noscript>
        <style>
            html {
                display: none;
            }
        </style>
        <meta http-equiv="refresh" content="0.0;url=https://www.workifyph.online/message.php">
    </noscript>
    <div class="container">

        <div class="overlay">
            <p class="screen">Lets setup your account</p>
            <div class="intro">
                <button class="myBtn" onclick="fadeOut()"> get started</button>
            </div>
        </div>

        <div class="overlay-2"></div>

        <div class="content">
            <div class="row">
                <div id="register-form" class="colm-form">
                    <!-- ---------------------------------Logo ---------------------- -->
                    <img class="logo-login" src="../img/DrRamonLOGO.svg" alt="Logo">

                    <div class="form-container">
                        <form id="setupForm" action="/backend/php/setup_account.php" method="POST"
                            onsubmit="return validateSetupForm()">

                            <input type="text" for="email" name="email" id="email"
                                placeholder="<?php echo $_SESSION['email'] ?>" disabled>
                            <input type="hidden" name="email" id="email" value="<?php echo $_SESSION['email'] ?>">
                            <select id="account-type" name="account-type" onchange="toggleFields()" required>
                                <option value="" selected disabled hidden class="null-type">Account Type:</option>
                                <option value="student">Student</option>
                                <option value="school">School</option>
                                <option value="organization">Partner Organization</option>
                            </select>
                            <div id="student-fields" style="display: none;">
                                <input value="" type="text" placeholder="First Name" id="first-name" name="first-name">
                                <input value="" type="text" placeholder="Middle Name" id="middle-name"
                                    name="middle-name">
                                <input value="" type="text" placeholder="Last Name" id="last-name" name="last-name">
                                <select name="grade-level" id="grade-level">
                                    <option value class="null-type">Grade Level:</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <select name="strand" id="strand">
                                    <option value="" selected disabled hidden class="null-type">Strand:</option>
                                    <option value="stem">STEM</option>
                                    <option value="humss">HUMSS</option>
                                    <option value="abm">ABM</option>
                                    <option value="gas">GAS</option>
                                    <option value="tvl">TVL</option>
                                </select>
                            </div>
                            <div id="school-fields" style="display: none;">
                                <input value="" type="text" placeholder="School Name" id="school-name"
                                    name="school-name">
                            </div>
                            <div id="partner-fields" style="display: none;">
                                <input value="" type="text" placeholder="Organization Name" id="organization-name"
                                    name="organization-name">
                                <select name="strand-focus" id="strand-focus">
                                    <option value="" selected disabled hidden class="null-type">Strand:</option>
                                    <option value="stem">STEM</option>
                                    <option value="humss">HUMSS</option>
                                    <option value="abm">ABM</option>
                                    <option value="gas">GAS</option>
                                    <option value="tvl">TVL</option>
                                </select>
                            </div>
                            <nav>
                                <a style="text-decoration: none" href="login.php">
                                    <button class="btn-login" id="switch-to-login">

                                        <p>
                                            Back</p>
                                    </button></a>
                                <button class="btn-new" type="submit" onclick="showLoginForm()">
                                    <p>Submit</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                        <path
                                            d="m31.71 15.29-10-10-1.42 1.42 8.3 8.29H0v2h28.59l-8.29 8.29 1.41 1.41 10-10a1 1 0 0 0 0-1.41z"
                                            data-name="3-Arrow Right" />
                                    </svg>
                                </button>


                            </nav>
                        </form>

                    </div>
                </div>
            </div>

        </div>
        <!-- <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students</p>        
    </footer> -->
    </div>
</body>
<script>
    function toggleFields() {
        var accountType = document.getElementById("account-type").value;
        var studentFields = document.getElementById("student-fields");
        var schoolFields = document.getElementById("school-fields");
        var partnerFields = document.getElementById("partner-fields");
        var registerForm = document.getElementById("register-form");

        if (accountType === "student") {
            registerForm.style.paddingTop = "25%";
            studentFields.style.display = "block";
            schoolFields.style.display = "none";
            partnerFields.style.display = "none";
        } else if (accountType === "school") {
            registerForm.style.paddingTop = "10%";
            studentFields.style.display = "none";
            schoolFields.style.display = "block";
            partnerFields.style.display = "none";
        } else if (accountType === "organization") {
            registerForm.style.paddingTop = "10%";
            studentFields.style.display = "none";
            schoolFields.style.display = "none";
            partnerFields.style.display = "block";
        } else {
            studentFields.style.display = "none";
            schoolFields.style.display = "none";
            partnerFields.style.display = "none";
        }
    }
</script>

</html>