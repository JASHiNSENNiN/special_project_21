<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
;
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
    $schools = getSchoolList($conn);
    $sqlCheck = $conn->prepare("SELECT id, account_type FROM users WHERE email = ?");
    $sqlCheck->bind_param("s", $email);
    $sqlCheck->execute();
    $sqlCheck->bind_result($userId, $accountType);

    if ($sqlCheck->fetch() && $accountType) {
        $sqlCheck->close();

        $_SESSION['user_id'] = $userId;

        switch ($accountType) {
            case 'Student':
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

            case 'School':
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

            case 'Organization':
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

        $accType = $accountType;
        $redirectUrl = "/Account/" . $accType . "/";
        header("Location: " . $redirectUrl);
        exit;
    } else {
        $sqlCheck->close();
        $conn->close();
    }
}

function getSchoolList($conn)
{
    $schools = [];

    $schoolQuery = "SELECT school_name FROM school_profiles";
    $schoolResult = $conn->query($schoolQuery);

    if ($schoolResult) {
        while ($row = $schoolResult->fetch_assoc()) {
            $schools[] = $row['school_name'];
        }
        $schoolResult->free();
    }

    return $schools;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        window.onload = function () {
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
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->
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

                    <!-- <img class="logo-login" src="../img/WORKIFYTEXTLOGO.svg" alt="Logo"> -->

                    <div class="form-container">
                        <form id="setupForm" action="/backend/php/setup_account.php" method="POST"
                            onsubmit="return validateSetupForm()">

                            <input type="text" for="email" name="email" id="email"
                                placeholder="<?php echo $_SESSION['email'] ?>" disabled>
                            <input type="hidden" name="email" id="email" value="<?php echo $_SESSION['email'] ?>">
                            <select id="account-type" name="account-type" onchange="toggleFields()" required>
                                <option value="" selected disabled hidden class="null-type">Account Type:</option>
                                <option value="Student">Student</option>
                                <option value="School">School</option>
                                <option value="Organization">Partner Organization</option>
                            </select>

                            <div id="student-fields" style="display: none;">

                                <input value="" type="number" placeholder="LRN" id="input-lrn" name="input-lrn"
                                    oninput="validateLRN()">
                                <input value="" type="text" placeholder="First Name" id="first-name" name="first-name">
                                <input value="" type="text" placeholder="Middle Name" id="middle-name"
                                    name="middle-name">
                                <input value="" type="text" placeholder="Last Name" id="last-name" name="last-name">
                                <select id="student-school-name" name="studentSchoolName">
                                    <option value="">Select School Name</option>
                                    <?php if (!empty($schools)): ?>
                                        <?php foreach ($schools as $schoolName): ?>
                                            <option value="<?php echo htmlspecialchars($schoolName); ?>">
                                                <?php echo htmlspecialchars($schoolName); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <select name="grade-level" id="grade-level">
                                    <option value class="null-type">Grade Level:</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <select name="strand" id="strand">
                                    <option value="" selected disabled hidden class="null-type">Strand:</option>
                                    <option value="STEM">STEM</option>
                                    <option value="HUMSS">HUMSS</option>
                                    <option value="ABM">ABM</option>
                                    <option value="GAS">GAS</option>
                                    <option value="TVL">TVL</option>
                                </select>

                            </div>
                            <div id="school-fields" style="display: none;">
                                <input value="" type="text" placeholder="School Name" id="school-name"
                                    name="school-name">

                            </div>
                            <div id="partner-fields" style="display: none;">
                                <input value="" type="text" placeholder="Organization Name" id="organization-name"
                                    name="organization_name">
                                <select name="strand_focus" id="strand-focus" style="margin-bottom: 10px;">
                                    <option value="" selected disabled hidden class="null-type">Strand:</option>
                                    <option value="STEM">STEM</option>
                                    <option value="HUMSS">HUMSS</option>
                                    <option value="ABM">ABM</option>
                                    <option value="GAS">GAS</option>
                                    <option value="TVL">TVL</option>
                                </select>
                                        
                                <input type="text" id="numberInput" name="phone_number" placeholder="Enter phone number">
                                <input type="text" id="zipcodenum" name="zip_code" placeholder="ZIP CODE">
                                <input type="text" id="inputAddressInput" name="address" placeholder="Street Name, House No., Barangay">
                                <input type="text" id="cityInput" name="city" placeholder="Enter city/town" >

                                <select class="form-control" id="provinces" name="provinces"
                                    style="margin-bottom: 10px;">
                                    <option value="">--Select a Province--</option>
                                    <option value="abra">Abra</option>
                                    <option value="agusan_del_norte">Agusan del Norte
                                    </option>
                                    <option value="agusan_del_sur">Agusan del Sur</option>
                                    <option value="albay">Albay</option>
                                    <option value="antique">Antique</option>
                                    <option value="apayao">Apayao</option>
                                    <option value="aurora">Aurora</option>
                                    <option value="bataan">Bataan</option>
                                    <option value="batanes">Batanes</option>
                                    <option value="batangas">Batangas</option>
                                    <option value="binguet">Benguet</option>
                                    <option value="bohol">Bohol</option>
                                    <option value="bukidnon">Bukidnon</option>
                                    <option value="bulacan">Bulacan</option>
                                    <option value="cagayan">Cagayan</option>
                                    <option value="camarines_norte">Camarines Norte</option>
                                    <option value="camarines_sur">Camarines Sur</option>
                                    <option value="cape_buenavista">Capiz</option>
                                    <option value="catanduanes">Catanduanes</option>
                                    <option value="ceb">Cebu</option>
                                    <option value="compostela_valley">Davao de Oro
                                        (Compostela
                                        Valley)</option>
                                    <option value="davao_del_norte">Davao del Norte</option>
                                    <option value="davao_del_sur">Davao del Sur</option>
                                    <option value="davao_occidental">Davao Occidental
                                    </option>
                                    <option value="Eastern_samar">Eastern Samar</option>
                                    <option value="guimaras">Guimaras</option>
                                    <option value="ilocos_norte">Ilocos Norte</option>
                                    <option value="ilocos_sur">Ilocos Sur</option>
                                    <option value="iloilo">Iloilo</option>
                                    <option value="isabela">Isabela</option>
                                    <option value="kalinga">Kalinga</option>
                                    <option value="kapangan">La Union</option>
                                    <option value="laguna">Laguna</option>
                                    <option value="lantapan">Lanao del Norte</option>
                                    <option value="lanao_del_sur">Lanao del Sur</option>
                                    <option value="leite">Leyte</option>
                                    <option value="marinduque">Marinduque</option>
                                    <option value="masbate">Masbate</option>
                                    <option value="misamis_oriental">Misamis Oriental
                                    </option>
                                    <option value="misamis_occidental">Misamis Occidental
                                    </option>
                                    <option value="mountain_province">Mountain Province
                                    </option>
                                    <option value="negros_occidental">Negros Occidental
                                    </option>
                                    <option value="negros_oriental">Negros Oriental</option>
                                    <option value="nueva_ecija">Nueva Ecija</option>
                                    <option value="nueva_vizcaya">Nueva Vizcaya</option>
                                    <option value="occidental_mindoro">Occidental Mindoro
                                    </option>
                                    <option value="oriente_mindoro">Oriental Mindoro
                                    </option>
                                    <option value="palawan">Palawan</option>
                                    <option value="pampanga">Pampanga</option>
                                    <option value="pangasinan">Pangasinan</option>
                                    <option value="quezon">Quezon</option>
                                    <option value="quiroguin">Quirino</option>
                                    <option value="romblon">Romblon</option>
                                    <option value="samar">Samar</option>
                                    <option value="sarangani">Sarangani</option>
                                    <option value="siquijor">Siquijor</option>
                                    <option value="sorsogon">Sorsogon</option>
                                    <option value="southern_leyn">Southern Leyte</option>
                                    <option value="tarlac">Tarlac</option>
                                    <option value="zambales">Zambales</option>
                                    <option value="zamboanga_del_norte">Zamboanga del Norte
                                    </option>
                                    <option value="zamboanga_del_sur">Zamboanga del Sur
                                    </option>
                                    <option value="zamboanga_sibugay">Zamboanga Sibugay
                                    </option>
                                </select>




                                <textarea id="aboutUs" name="about_us" placeholder="Write about your company..."></textarea>
                                <textarea id="corporateVision" name="corporate_vision" placeholder="Write the corporate vision..."></textarea>
                                <textarea id="corporateMission" name="corporate_mission" placeholder="Write the corporate mission..."></textarea>
                                <textarea id="corporatePhilosophy" name="corporate_philosophy" placeholder="Write the corporate philosophy..."></textarea>
                                <textarea id="corporatePrinciples" name="corporate_principles" placeholder="Write the corporate principles..."></textarea>
                            </div>
                            <nav>
                                <a style="text-decoration: none" href="login.php">
                                    <button class="btn-login" id="switch-to-login">

                                        <p>Back</p>
                                    </button></a>
                                <button class="btn-new" id="submitBtn" type="submit">
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
        <p>&copy; 2024 Your Website. All rights reserved. |Dr Ramon De Santos National High School</p>        
    </footer> -->
    </div>
</body>
<!-- <script>
    document.getElementById('submitBtn').addEventListener('click', function () {
        // Collect data from text areas
        const pnumber = document.getElementById('numberInput').value;
        const zipcode = document.getElementById('zipcodenum').value;
        const address = document.getElementById('inputAddressInput').value;
        const cityinput = document.getElementById('cityInput').value;
        const provinces = document.getElementById('provinces').value;
        const aboutUs = document.getElementById('aboutUs').value;
        const corporateVision = document.getElementById('corporateVision').value;
        const corporateMission = document.getElementById('corporateMission').value;
        const corporatePhilosophy = document.getElementById('corporatePhilosophy').value;
        const corporatePrinciples = document.getElementById('corporatePrinciples').value;

        // Create an object to send
        const data = {
            pnumber,
            zipcode,
            address,
            cityinput,
            provinces,
            aboutUs,
            corporateVision,
            corporateMission,
            corporatePhilosophy,
            corporatePrinciples
        };

        // Convert data to JSON
        const jsonData = JSON.stringify(data);

        // Send data to PHP API
        fetch('your-api-endpoint.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: jsonData
        })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                alert('Data submitted successfully!');
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('There was an error submitting the data.');
            });
    });
</script> -->

<script>
    function toggleFields() {
        var accountType = document.getElementById("account-type").value;
        var studentFields = document.getElementById("student-fields");
        var schoolFields = document.getElementById("school-fields");
        var partnerFields = document.getElementById("partner-fields");
        var registerForm = document.getElementById("register-form");

        if (accountType === "Student") {
            registerForm.style.paddingTop = "25%";
            studentFields.style.display = "block";
            schoolFields.style.display = "none";
            partnerFields.style.display = "none";
        } else if (accountType === "School") {
            registerForm.style.paddingTop = "10%";
            studentFields.style.display = "none";
            schoolFields.style.display = "block";
            partnerFields.style.display = "none";
        } else if (accountType === "Organization") {
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

<script>
    function showSelectedSchool() {
        const schoolSelect = document.getElementById('schoolSelect');
        const selectedSchool = schoolSelect.value;
        const resultDiv = document.getElementById('selectedSchool');

        if (selectedSchool) {
            resultDiv.innerHTML = `<h2>You selected: ${selectedSchool}</h2>`;
        } else {
            resultDiv.innerHTML = "<h2>Please select a school from the list.</h2>";
        }
    }
</script>

<!-- <script type="text/javascript">
const dropArea = document.querySelector(".drop_box"),
    button = dropArea.querySelector(".btn"),
    input = dropArea.querySelector("input");

let files = [];

button.onclick = () => {
    input.click();
};

input.addEventListener("change", function(e) {
    files = e.target.files; // Get the selected files
    const fileListElement = document.querySelector(".file-list");
    fileListElement.innerHTML = ''; // Clear the previous file list

    // Display each selected file
    Array.from(files).forEach((file, index) => {
        let fileItem = document.createElement('li');
        fileItem.innerHTML = ` 
                <h4>${file.name}</h4>
                <button class="remove-btn" onclick="removeFile(${index})">Remove</button>
            `;
        fileListElement.appendChild(fileItem);
    });
});

// Function to remove a file from the list
function removeFile(index) {
    // Remove the file from the array
    files = Array.from(files).filter((_, i) => i !== index);

    // Update the UI
    const fileListElement = document.querySelector(".file-list");
    fileListElement.innerHTML = ''; // Clear the list

    // Re-render the file list after removal
    Array.from(files).forEach((file, index) => {
        let fileItem = document.createElement('li');
        fileItem.innerHTML = ` 
                <h4>${file.name}</h4>
                <button class="remove-btn" onclick="removeFile(${index})">Remove</button>
            `;
        fileListElement.appendChild(fileItem);
    });
}

// Function to upload all files
function uploadFiles() {
    const emailInput = document.querySelector('input[type="email"]');
    const email = emailInput ? emailInput.value : null;

    if (!email) {
        alert('Please enter an email address.');
        return;
    }

    // Create a FormData object for sending the files
    const formData = new FormData();
    Array.from(files).forEach(file => {
        formData.append('files', file); // Append each file
    });
    formData.append('email', email); // Append the email

    // Send the files using fetch
    fetch('YOUR_SERVER_URL_HERE', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const fileListElement = document.querySelector(".file-list");

            // Add a success message after uploading all files
            const successMessage = document.createElement('p');
            successMessage.classList.add('file-uploaded');
            successMessage.textContent = `All files uploaded successfully!`;
            fileListElement.appendChild(successMessage);
        })
        .catch(error => {
            alert('File upload failed. Please try again.');
            console.error('Error uploading files:', error);
        });
}
</script>


<script type="text/javascript">
const imageInput = document.querySelector("#fileID");
let images = [];

imageInput.addEventListener("change", function(e) {
    images = e.target.files; // Get the selected images
    const imagePreviewContainer = document.querySelector(".image-preview");
    imagePreviewContainer.innerHTML = ''; // Clear the previous image previews

    // Display previews for each selected image
    Array.from(images).forEach((image, index) => {
        let imgPreview = document.createElement('div');
        imgPreview.innerHTML = `
            <img src="${URL.createObjectURL(image)}" alt="${image.name}">
            <button class="remove-btn" onclick="removeImage(${index})">Remove</button>
        `;
        imagePreviewContainer.appendChild(imgPreview);
    });
});

// Function to remove an image from the preview list
function removeImage(index) {
    images = Array.from(images).filter((_, i) => i !== index);
    const imagePreviewContainer = document.querySelector(".image-preview");
    imagePreviewContainer.innerHTML = ''; // Clear the list

    // Re-render the image previews after removal
    Array.from(images).forEach((image, index) => {
        let imgPreview = document.createElement('div');
        imgPreview.innerHTML = `
            <img src="${URL.createObjectURL(image)}" alt="${image.name}">
            <button class="remove-btn" onclick="removeImage(${index})">Remove</button>
        `;
        imagePreviewContainer.appendChild(imgPreview);
    });
}

// Function to upload images
function uploadImages() {
    const formData = new FormData();
    Array.from(images).forEach(image => {
        formData.append('images', image); // Append each image
    });

    fetch('YOUR_SERVER_URL_HERE', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const imagePreviewContainer = document.querySelector(".image-preview");
            const successMessage = document.createElement('p');
            successMessage.classList.add('file-uploaded');
            successMessage.textContent = `All images uploaded successfully!`;
            imagePreviewContainer.appendChild(successMessage);
        })
        .catch(error => {
            alert('Image upload failed. Please try again.');
            console.error('Error uploading images:', error);
        });
}
</script> -->

<script type="text/javascript">
    // Handling Document File Upload
    const documentInput = document.querySelector("#documentID");
    let documentFiles = [];
    const documentFileList = document.querySelector(".file-list");

    // documentInput.addEventListener("change", function(e) {
    //     documentFiles = e.target.files;
    //     documentFileList.innerHTML = ''; // Clear previous files

    //     Array.from(documentFiles).forEach((file, index) => {
    //         let fileItem = document.createElement('li');
    //         fileItem.innerHTML = `
    //             <h4>${file.name}</h4>
    //             <button class="remove-btn" onclick="removeDocumentFile(${index})">Remove</button>
    //         `;
    //         documentFileList.appendChild(fileItem);
    //     });
    // });

    function removeDocumentFile(index) {
        documentFiles = Array.from(documentFiles).filter((_, i) => i !== index);
        documentFileList.innerHTML = '';
        Array.from(documentFiles).forEach((file, index) => {
            let fileItem = document.createElement('li');
            fileItem.innerHTML = `
                <h4>${file.name}</h4>
                <button class="remove-btn" onclick="removeDocumentFile(${index})">Remove</button>
            `;
            documentFileList.appendChild(fileItem);
        });
    }

    // Function to upload documents
    function uploadDocuments() {
        const formData = new FormData();
        Array.from(documentFiles).forEach(file => {
            formData.append('documents', file);
        });

        fetch('YOUR_SERVER_URL_HERE', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                alert('Documents uploaded successfully!');
            })
        // .catch(error => {
        //     alert('Document upload failed. Please try again.');
        //     console.error('Error uploading documents:', error);
        // });
    }

    // Handling Image File Upload
    const imageInput = document.querySelector("#imageID");
    let imageFiles = [];
    const imagePreviewContainer = document.querySelector(".image-preview");

    // imageInput.addEventListener("change", function(e) {
    //     imageFiles = e.target.files;
    //     imagePreviewContainer.innerHTML = ''; // Clear previous image previews

    //     Array.from(imageFiles).forEach((image, index) => {
    //         let imgPreview = document.createElement('div');
    //         imgPreview.innerHTML = `
    //                 <img src="${URL.createObjectURL(image)}" alt="${image.name}">
    //                 <button class="remove-btn" onclick="removeImage(${index})">Remove</button>
    //             `;
    //         imagePreviewContainer.appendChild(imgPreview);
    //     });
    // });

    function removeImage(index) {
        imageFiles = Array.from(imageFiles).filter((_, i) => i !== index);
        imagePreviewContainer.innerHTML = '';
        Array.from(imageFiles).forEach((image, index) => {
            let imgPreview = document.createElement('div');
            imgPreview.innerHTML = `
                <img src="${URL.createObjectURL(image)}" alt="${image.name}">
                <button class="remove-btn" onclick="removeImage(${index})">Remove</button>
            `;
            imagePreviewContainer.appendChild(imgPreview);
        });
    }

    // Function to upload images
    function uploadImages() {
        const formData = new FormData();
        Array.from(imageFiles).forEach(image => {
            formData.append('images', image);
        });

        fetch('YOUR_SERVER_URL_HERE', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                alert('Images uploaded successfully!');
            })
        // .catch(error => {
        //     alert('Image upload failed. Please try again.');
        //     console.error('Error uploading images:', error);
        // });
    }
</script>
<script>
    // Function to allow only numbers (no special characters)
    function validateLRN() {
        const input = document.getElementById('input-lrn');
        // Remove any non-numeric characters (except for the "-" sign, if needed)
        input.value = input.value.replace(/[^0-9]/g, '');
    }
</script>


</html>