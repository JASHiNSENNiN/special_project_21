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

        $accType = ucfirst($accountType);
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
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
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
                    <!-- <img class="logo-login" src="../img/DrRamonLOGO.svg" alt="Logo"> -->

                    <img class="logo-login" src="../img/WORKIFYTEXTLOGO.svg" alt="Logo">

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
                                <!-- <input value="" type="text" placeholder="School Name" id="NameSchool" name="NameSchool"> -->
                                <select id="schoolSelect">
                                    <option value="">Select a School:</option>
                                    <option value="Springfield High School">Springfield High School</option>
                                    <option value="Greenwood Academy">Greenwood Academy</option>
                                    <option value="Riverdale Secondary School">Riverdale Secondary School</option>
                                    <option value="Westbrook International School">Westbrook International School
                                    </option>
                                    <option value="Sunshine Preparatory School">Sunshine Preparatory School</option>
                                </select>
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
                                <br>
                                <hr>
                                <div class="container1">
                                    <div class="card">
                                        <h3>Upload Documents</h3>

                                        <div class="drop_box">
                                            <header>
                                                <h4>Select Document Files</h4>
                                            </header>
                                            <p>Upload the following requirements: <u><b>Resume, Application
                                                        Letter,
                                                        Barangay, Police, Mayor's Clearance, Medical
                                                        Certificate, Job Interview, Insurance Policy, Parent's
                                                        Consent</b></u>
                                            </p>
                                            <input class="fileimage" type="file" hidden accept=".doc,.docx,.pdf,.txt"
                                                id="documentID" multiple>
                                            <div class="btn" onclick="document.getElementById('documentID').click();">
                                                Choose Files</div>
                                        </div>

                                        <ul class="file-list"></ul>
                                        <!-- Upload Button for Documents -->
                                        <!-- <button onclick="uploadDocuments(); uploadImages();" class="btn">Upload
                                            Documents</button> -->
                                    </div>
                                </div>
                                <nav>
                                    <a style="text-decoration: none" href="login.php">
                                        <button class="btn-login" id="switch-to-login">

                                            <p>Back</p>
                                        </button></a>
                                    <button class="btn-new" type="submit"
                                        onclick="uploadDocuments();showSelectedSchool();">
                                        <p>Submit</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                            <path
                                                d="m31.71 15.29-10-10-1.42 1.42 8.3 8.29H0v2h28.59l-8.29 8.29 1.41 1.41 10-10a1 1 0 0 0 0-1.41z"
                                                data-name="3-Arrow Right" />
                                        </svg>
                                    </button>


                                </nav>
                            </div>
                            <div id="school-fields" style="display: none;">
                                <input value="" type="text" placeholder="School Name" id="school-name"
                                    name="school-name">
                                <nav>
                                    <a style="text-decoration: none" href="login.php">
                                        <button class="btn-login" id="switch-to-login">

                                            <p>Back</p>
                                        </button></a>
                                    <button class="btn-new" type="submit" onclick="">
                                        <p>Submit</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                            <path
                                                d="m31.71 15.29-10-10-1.42 1.42 8.3 8.29H0v2h28.59l-8.29 8.29 1.41 1.41 10-10a1 1 0 0 0 0-1.41z"
                                                data-name="3-Arrow Right" />
                                        </svg>
                                    </button>


                                </nav>
                            </div>
                            <div id="partner-fields" style="display: none;">
                                <input value="" type="text" placeholder="Organization Name" id="organization-name"
                                    name="organization-name">
                                <select name="strand-focus" id="strand-focus">
                                    <option value="" selected disabled hidden class="null-type">Strand:</option>
                                    <option value="STEM">STEM</option>
                                    <option value="HUMSS">HUMSS</option>
                                    <option value="ABM">ABM</option>
                                    <option value="GAS">GAS</option>
                                    <option value="TVL">TVL</option>
                                </select>
                                <br>
                                <hr>
                                <!-- Image Upload Section -->
                                <div class="container1">
                                    <div class="card">
                                        <h3>Upload Images</h3>

                                        <div class="drop_box">
                                            <header>
                                                <h4>Select Image Files</h4>
                                            </header>
                                            <p>Upload the following requirements: <center><u>Business Permit</u>
                                                    <br><b>Back and Front</b>
                                                </center>
                                            </p>
                                            <p>Files Supported: PNG, JPG</p>
                                            <input class="fileimage" type="file" hidden accept=".png,.jpg" id="imageID"
                                                multiple>
                                            <div class="btnImage" onclick="document.getElementById('imageID').click();">
                                                Choose Files</div>
                                        </div>

                                        <!-- Image Preview Section -->
                                        <div class="image-preview"></div>
                                        <!-- Upload Button for Images -->
                                        <!-- <button onclick="uploadDocuments(); uploadImages();" class="btn">Upload
                                            Images</button> -->
                                    </div>
                                </div>
                                <nav>
                                    <a style="text-decoration: none" href="login.php">
                                        <button class="btn-login" id="switch-to-login">

                                            <p>Back</p>
                                        </button></a>
                                    <button class="btn-new" type="submit" onclick="uploadImages()">
                                        <p>Submit</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                            <path
                                                d="m31.71 15.29-10-10-1.42 1.42 8.3 8.29H0v2h28.59l-8.29 8.29 1.41 1.41 10-10a1 1 0 0 0 0-1.41z"
                                                data-name="3-Arrow Right" />
                                        </svg>
                                    </button>


                                </nav>
                            </div>

                        </form>

                    </div>
                    <nav>
                        <a style="text-decoration: none" href="login.php">
                            <button class="btn-login" id="switch-to-login">

                                <p style="color:white;">Back</p>
                            </button></a>
                        <button class="btn-new" type="submit" onclick="uploadImages()">
                            <p style="color:white;">Submit</p>
                            <!-- <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 32 32">
                                <path
                                    d="m31.71 15.29-10-10-1.42 1.42 8.3 8.29H0v2h28.59l-8.29 8.29 1.41 1.41 10-10a1 1 0 0 0 0-1.41z"
                                    data-name="3-Arrow Right" />
                            </svg> -->
                        </button>


                    </nav>
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

documentInput.addEventListener("change", function(e) {
    documentFiles = e.target.files;
    documentFileList.innerHTML = ''; // Clear previous files

    Array.from(documentFiles).forEach((file, index) => {
        let fileItem = document.createElement('li');
        fileItem.innerHTML = `
                <h4>${file.name}</h4>
                <button class="remove-btn" onclick="removeDocumentFile(${index})">Remove</button>
            `;
        documentFileList.appendChild(fileItem);
    });
});

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

imageInput.addEventListener("change", function(e) {
    imageFiles = e.target.files;
    imagePreviewContainer.innerHTML = ''; // Clear previous image previews

    Array.from(imageFiles).forEach((image, index) => {
        let imgPreview = document.createElement('div');
        imgPreview.innerHTML = `
                <img src="${URL.createObjectURL(image)}" alt="${image.name}">
                <button class="remove-btn" onclick="removeImage(${index})">Remove</button>
            `;
        imagePreviewContainer.appendChild(imgPreview);
    });
});

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