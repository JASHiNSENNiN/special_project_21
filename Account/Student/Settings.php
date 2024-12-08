<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'student_profile.php';

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

// Database connection
$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);
$schools = getSchoolList($conn);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // Handle file uploads
    $profile_image_name = $_FILES['profile_image']['name'];
    $cover_image_name = $_FILES['cover_image']['name'];

    function uploadImage($file) {
        $upload_dir = 'uploads/';
        if ($file['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $random_name = uniqid('', true) . '.' . $ext; // Generate a unique name
            $destination = $upload_dir . $random_name;
            move_uploaded_file($file['tmp_name'], $destination);
            return $random_name;
        }
        return null; // Upload error
    }

    $profile_image = uploadImage($_FILES['profile_image']);
    $cover_image = uploadImage($_FILES['cover_image']);

    // Handle profile update
    if (isset($_POST['first_name'])) {
        $required_fields = ['first_name', 'last_name', 'school', 'strand'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                exit;
            }
        }

        // Sanitize inputs
        $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
        $middle_name = filter_var($_POST['middle_name'], FILTER_SANITIZE_STRING);
        $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
        $school = filter_var($_POST['school'], FILTER_SANITIZE_STRING);
        $strand = filter_var($_POST['strand'], FILTER_SANITIZE_STRING);

        // Validate strand
        $valid_strands = ['stem', 'humss', 'abm', 'gas', 'tvl'];
        if (!in_array($strand, $valid_strands)) {
            exit;
        }

        // Update student profile
        $sql = "UPDATE student_profiles 
                SET first_name = ?, 
                    middle_name = ?, 
                    last_name = ?, 
                    school = ?, 
                    strand = ? 
                WHERE user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssi",
            $first_name,
            $middle_name,
            $last_name,
            $school,
            $strand,
            $user_id
        );

        if ($stmt->execute()) {
            // Update images if they exist
            if ($profile_image) {
                $sql_image = "UPDATE users SET profile_image = ? WHERE id = ?";
                $stmt_image = $conn->prepare($sql_image);
                $stmt_image->bind_param("si", $profile_image, $user_id);
                $stmt_image->execute();
            }
            if ($cover_image) {
                $sql_image = "UPDATE users SET cover_image = ? WHERE id = ?";
                $stmt_image = $conn->prepare($sql_image);
                $stmt_image->bind_param("si", $cover_image, $user_id);
                $stmt_image->execute();
            }

            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

function getSchoolList($conn) {
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

// Fetch current profile data
$profile_data = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/Settings.css">
    <title>Settings</title>
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">



</head>
<script>

</script>
<style>
</style>

<body>
    <noscript>
        <style>
        html {
            display: none;
        }
        </style>
        <meta http-equiv="refresh" content="0.0;url=message.php">
    </noscript>
    <?php if (!isset($_SESSION['user_id'])): ?>
    <div class="container mt-5">
        <div class="alert alert-danger">Please log in to access this page.</div>
    </div>
    <?php else: ?>
    <?php echo $profile_divv; ?>





    <div class="home-content">
        <div class="container light-style flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">Account settings</h4>
            <div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <!-- <a class="list-group-item list-group-item-action active" data-toggle="list"
                                href="#account-general">General</a> -->
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-info">Personal Details</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-change-password">Change password</a>


                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane fade " id="account-change-password">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control mb-1" autocomplete="off"
                                            value="<?php echo $email ?>" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" class="form-control" placeholder="Current password" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control" placeholder="New password" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Repeat new password</label>
                                        <input type="password" class="form-control" placeholder="Repeat new password" />
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade active show" id="account-info">
                                <form id="edit-profile-form" method="POST" enctype="multipart/form-data">
                                    <div class="container-xl px-4 mt-4">
                                        <div class="row row1">
                                            <div class="col-xl-4">
                                                <div class="card mb-4 mb-5 mb-xl-0">
                                                    <div class="card-header">Cover Picture </div>
                                                    <div class="card-body text-center">
                                                        <img class="img-account-cover mb-2" id="profile-image-cover"
                                                            src="<?php echo $profile_data['cover_image'] ? 'uploads/' . $profile_data['cover_image'] : 'uploads/default.png'; ?>"
                                                            alt="Cover Image Preview"
                                                            style="width: 100%; height: auto;">
                                                        <div class="small font-italic text-muted mb-4">JPG or PNG no
                                                            larger than 5 MB</div>
                                                        <input type="file" id="image-upload-cover"
                                                            accept="image/jpeg,image/png" style="display: none;"
                                                            onchange="previewImage('image-upload-cover', 'profile-image-cover')"
                                                            name="cover_image">
                                                        <label for="image-upload-cover" class="btn btn-primary">Upload
                                                            new image</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="card mb-4 mb-xl-0">
                                                    <div class="card-header">Profile Picture</div>
                                                    <div class="card-body text-center">
                                                        <img class="img-account-profile rounded-circle mb-2"
                                                            id="profile-image"
                                                            src="<?php echo $profile_data['profile_image'] ? 'uploads/' . $profile_data['profile_image'] : 'uploads/default.png'; ?>"
                                                            alt="Profile Image Preview"
                                                            style="width: 200px; height: 200px; object-fit: cover;">
                                                        <div class="small font-italic text-muted mb-4">JPG or PNG no
                                                            larger than 5 MB</div>
                                                        <input type="file" id="image-upload" name="profile_image"
                                                            accept="image/jpeg,image/png" style="display: none;"
                                                            onchange="previewImage('image-upload', 'profile-image')"
                                                            name="profile_image">
                                                        <label for="image-upload" class="btn btn-primary">Upload new
                                                            image</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                            function previewImage(inputId, imgId) {
                                                const file = document.getElementById(inputId).files[0];
                                                const img = document.getElementById(imgId);

                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        img.src = e.target
                                                            .result;
                                                    }
                                                    reader.readAsDataURL(
                                                        file);
                                                }
                                            }
                                            </script>
                                            <div class="col-xl-8">
                                                <div class="card mb-4">
                                                    <div class="card-header">Account Details</div>
                                                    <div class="card-body">
                                                        <div class="row gx-3 mb-3">
                                                            <div class="col-md-6">
                                                                <label class="small mb-1" for="inputFirstName">First
                                                                    name</label>
                                                                <input class="form-control" id="inputFirstName"
                                                                    name="first_name" type="text"
                                                                    value="<?php echo htmlspecialchars($profile_data['first_name'] ?? ''); ?>"
                                                                    required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="small mb-1" for="inputMiddleName">Middle
                                                                    name</label>
                                                                <input class="form-control" id="inputMiddleName"
                                                                    name="middle_name" type="text"
                                                                    value="<?php echo htmlspecialchars($profile_data['middle_name'] ?? ''); ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="small mb-1" for="inputLastName">Last
                                                                    name</label>
                                                                <input class="form-control" id="inputLastName"
                                                                    name="last_name" type="text"
                                                                    value="<?php echo htmlspecialchars($profile_data['last_name'] ?? ''); ?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="row gx-3 mb-3">
                                                            <div class="col-md-6">
                                                                <label class="small mb-1" for="inputSchool">School
                                                                    name</label>
                                                                <select class="form-control" id="inputSchool"
                                                                    name="school" required>
                                                                    <option value="" disabled>Select your school
                                                                    </option>
                                                                    <option
                                                                        value="<?php echo htmlspecialchars($profile_data['school'] ?? ''); ?>"
                                                                        selected>
                                                                        <?php echo htmlspecialchars($profile_data['school'] ?? ''); ?>
                                                                    </option>
                                                                    <?php if (!empty($schools)) : ?>
                                                                    <?php foreach ($schools as $schoolName) : ?>
                                                                    <option
                                                                        value="<?php echo htmlspecialchars($schoolName); ?>">
                                                                        <?php echo htmlspecialchars($schoolName); ?>
                                                                    </option>
                                                                    <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="small mb-1"
                                                                    for="inputStrand">Strand</label>
                                                                <select class="form-control" id="inputStrand"
                                                                    name="strand" required>
                                                                    <?php
                                    $strands = ['stem' => 'STEM', 'humss' => 'HUMSS', 'abm' => 'ABM', 'gas' => 'GAS', 'tvl' => 'TVL'];
                                    foreach ($strands as $value => $label) {
                                        $selected = ($profile_data['strand'] ?? '') === $value ? 'selected' : '';
                                        echo "<option value=\"$value\" $selected>$label</option>";
                                    }
                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="text-right mt-3">
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>&nbsp;
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>



        <div class="tab-pane fade" id="account-social-links">
            <div class="card-body pb-2">
                <div class="form-group">
                    <label class="form-label">Twitter</label>
                    <input type="text" class="form-control" value="https://twitter.com/user" />
                </div>
                <div class="form-group">
                    <label class="form-label">Facebook</label>
                    <input type="text" class="form-control" value="https://www.facebook.com/user" />
                </div>
                <div class="form-group">
                    <label class="form-label">Google+</label>
                    <input type="text" class="form-control" value />
                </div>
                <div class="form-group">
                    <label class="form-label">Instagram</label>
                    <input type="text" class="form-control" value="https://www.instagram.com/user" />
                </div>
            </div>
        </div>



        <div class="tab-pane fade" id="account-connections">
            <div class="card-body">
                <button type="button" class="btn btn-twitter" style="font-size: 15px">
                    Connect to <strong>Twitter</strong>
                </button>
            </div>
            <hr class="border-light m-0" />
            <div class="card-body">
                <h5 class="mb-2" style="font-size: 15px">
                    <a href="javascript:void(0)" class="float-right text-muted text-tiny" style="font-size: 15px"><i
                            class="ion ion-md-close"></i> Remove</a>
                    <i class="ion ion-logo-google text-google"></i>
                    You are connected to Google:
                </h5>
                <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                    data-cfemail="f9979498818e9c9595b994989095d79a9694">[email&#160;protected]</a>
            </div>
            <hr class="border-light m-0" />
            <div class="card-body">
                <button type="button" class="btn btn-facebook" style="font-size: 15px">
                    Connect to <strong>Facebook</strong>
                </button>
            </div>
            <hr class="border-light m-0" />
            <div class="card-body">
                <button type="button" class="btn btn-instagram" style="font-size: 15px">
                    Connect to <strong>Instagram</strong>
                </button>
            </div>
        </div>
        <div class="tab-pane fade" id="account-notifications">
            <div class="card-body pb-2">
                <h6 class="mb-4">Activity</h6>
                <div class="form-group">
                    <label class="switcher">
                        <input type="checkbox" class="switcher-input" checked />
                        <span class="switcher-indicator">
                            <span class="switcher-yes"></span>
                            <span class="switcher-no"></span>
                        </span>
                        <span class="switcher-label">When someone Send a Feedback </span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="switcher">
                        <input type="checkbox" class="switcher-input" checked />
                        <span class="switcher-indicator">
                            <span class="switcher-yes"></span>
                            <span class="switcher-no"></span>
                        </span>
                        <span class="switcher-label">When someone send a report</span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="switcher">
                        <input type="checkbox" class="switcher-input" />
                        <span class="switcher-indicator">
                            <span class="switcher-yes"></span>
                            <span class="switcher-no"></span>
                        </span>
                        <span class="switcher-label">When someone follows </span>
                    </label>
                </div>
            </div>
            <hr class="border-light m-0" />
            <div class="card-body pb-2">
                <h6 class="mb-4">Application</h6>
                <div class="form-group">
                    <label class="switcher">
                        <input type="checkbox" class="switcher-input" checked />
                        <span class="switcher-indicator">
                            <span class="switcher-yes"></span>
                            <span class="switcher-no"></span>
                        </span>
                        <span class="switcher-label">News and announcements</span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="switcher">
                        <input type="checkbox" class="switcher-input" />
                        <span class="switcher-indicator">
                            <span class="switcher-yes"></span>
                            <span class="switcher-no"></span>
                        </span>
                        <span class="switcher-label">Weekly product updates</span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="switcher">
                        <input type="checkbox" class="switcher-input" checked />
                        <span class="switcher-indicator">
                            <span class="switcher-yes"></span>
                            <span class="switcher-no"></span>
                        </span>
                        <span class="switcher-label">Weekly blog digest</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    </div>
    </div>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php endif; ?>
</body>

</html>