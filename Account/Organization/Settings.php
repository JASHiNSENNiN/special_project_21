<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

// Database connection
$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_SESSION['email'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $repeatNewPassword = $_POST['repeat_new_password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($currentPassword, $hashedPassword)) {
        if ($newPassword === $repeatNewPassword) {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 15]);

            $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $updateStmt->bind_param("ss", $hashedNewPassword, $email);
            if ($updateStmt->execute()) {
                // Send JavaScript alert for successful password change
                echo '<script>alert("Password changed successfully!");</script>';
            } else {
                echo '<script>alert("Error updating password.");</script>';
            }
            $updateStmt->close();
        } else {
            echo '<script>alert("New passwords do not match.");</script>';
        }
    } else {
        echo '<script>alert("Current password is incorrect.");</script>';
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['change_password'])) {
    $user_id = $_SESSION['user_id'];

    // Process image uploads
    function uploadImage($file)
    {
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

    // Handle partner profile update
    if (isset($_POST['organization_name'])) {
        $required_fields = ['organization_name', 'strand'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                exit; // Handle errors as required
            }
        }

        // Sanitize inputs
        $organization_name = filter_var($_POST['organization_name'], FILTER_SANITIZE_STRING);
        $strand = filter_var($_POST['strand'], FILTER_SANITIZE_STRING);

        // Validate strand
        $valid_strands = ['stem', 'humss', 'abm', 'gas', 'tvl'];
        if (!in_array($strand, $valid_strands)) {
            exit; // Handle invalid strands as required
        }

        // Update partner profile
        $sql = "UPDATE partner_profiles
                SET organization_name = ?, strand = ?
                WHERE user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $organization_name, $strand, $user_id);

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
            exit; // Redirect after successful update
        } else {
            exit; // Handle errors as required
        }
    }
}


// Fetch current profile data
$profile_data = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
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
        <?php echo $navbar_div; ?>





        <div class="home-content">
            <div class="container light-style flex-grow-1 container-p-y">
                <h4 class="font-weight-bold py-3 mb-4">Account settings</h4>
                <div class="card overflow-hidden">
                    <div class="row no-gutters row-bordered row-border-light">




                        <div class="tab-pane fade active show" id="account-info">
                            <form id="edit-profile-form" method="POST" enctype="multipart/form-data">
                                <div class="container-xl px-4 mt-4">
                                    <div class="row row1">
                                        <div class="col-xl-4">
                                            <!-- Cover Picture card -->
                                            <div class="card mb-4 mb-5 mb-xl-0">
                                                <div class="card-header">Cover Picture</div>
                                                <div class="card-body text-center">
                                                    <img class="img-account-cover mb-2" id="profile-image-cover"
                                                        src="<?php echo $profile_data['cover_image'] ? 'uploads/' . $profile_data['cover_image'] : 'uploads/cover.png'; ?>"
                                                        alt="Cover Image Preview" style="width: 100%; height: auto;">
                                                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than
                                                        5 MB</div>
                                                    <input type="file" id="image-upload-cover" accept="image/jpeg,image/png"
                                                        style="display: none;"
                                                        onchange="previewImage('image-upload-cover', 'profile-image-cover')"
                                                        name="cover_image">
                                                    <label for="image-upload-cover" class="btn btn-primary">Upload new
                                                        image</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <!-- Profile Picture card -->
                                            <div class="card mb-4 mb-xl-0">
                                                <div class="card-header">Profile Picture</div>
                                                <div class="card-body text-center">
                                                    <img class="img-account-profile rounded-circle mb-2" id="profile-image"
                                                        src="<?php echo $profile_data['profile_image'] ? 'uploads/' . $profile_data['profile_image'] : 'uploads/default.png'; ?>"
                                                        alt="Profile Image Preview"
                                                        style="width: 200px; height: 200px; object-fit: cover;">
                                                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than
                                                        5 MB</div>
                                                    <input type="file" id="image-upload" name="profile_image"
                                                        accept="image/jpeg,image/png" style="display: none;"
                                                        onchange="previewImage('image-upload', 'profile-image')">
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
                                                        img.src = e.target.result;
                                                    }
                                                    reader.readAsDataURL(file);
                                                }
                                            }
                                        </script>

                                        <div class="col-xl-8">
                                            <!-- Account Details card -->
                                            <div class="card mb-4">
                                                <div class="card-header">Account Details</div>
                                                <div class="card-body">
                                                    <div class="row gx-3 mb-3">
                                                        <div class="col-md-12">
                                                            <label class="small mb-1"
                                                                for="inputOrganizationName">Organization Name</label>
                                                            <input class="form-control" id="inputOrganizationName"
                                                                name="organization_name" type="text"
                                                                value="<?php echo htmlspecialchars($profile_data['organization_name'] ?? ''); ?>"
                                                                required>

                                                            <label class="small mb-1" for="inputStrand">Strand</label>
                                                            <select class="form-control" id="inputStrand" name="strand"
                                                                required>
                                                                <?php
                                                                $strands = ['stem' => 'STEM', 'humss' => 'HUMSS', 'abm' => 'ABM', 'gas' => 'GAS', 'tvl' => 'TVL'];
                                                                foreach ($strands as $value => $label) {
                                                                    $selected = ($profile_data['strand'] ?? '') === $value ? 'selected' : '';
                                                                    echo "<option value=\"$value\" $selected>$label</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <!-- <label class="small mb-1" for="inputStrand">Strand</label>
                                                        <select class="form-control" id="inputStrand" name="strand"
                                                            required>
                                                            <?php
                                                            $strands = ['stem' => 'STEM', 'humss' => 'HUMSS', 'abm' => 'ABM', 'gas' => 'GAS', 'tvl' => 'TVL'];
                                                            foreach ($strands as $value => $label) {
                                                                $selected = ($profile_data['strand'] ?? '') === $value ? 'selected' : '';
                                                                echo "<option value=\"$value\" $selected>$label</option>";
                                                            }
                                                            ?>
                                                        </select> -->
                                                        </div>
                                                    </div>
                                                    <div class="text-right mt-3">
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="col-md-3 pt-0">
                            <div class="list-group list-group-flush account-settings-links">
                                <!-- <a class="list-group-item list-group-item-action active" data-toggle="list"
                                href="#account-general">General</a> -->
                                <!-- <a class="list-group-item list-group-item-action" data-toggle="list"
                                    href="#account-info">Personal Details</a>
                                <a class="list-group-item list-group-item-action" data-toggle="list"
                                    href="#account-change-password">Change password</a> -->


                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content">

                                <div class="card-body pb-2">

                                    <form method="POST" action="" onsubmit="return validateForm()">
                                        <div class="tab-pane active show" id="account-change-password">

                                            <div class="form-group">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control mb-1" autocomplete="off"
                                                    value="<?php echo htmlspecialchars($email); ?>" readonly />
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Current password</label>
                                                <input type="password" class="form-control" name="current_password"
                                                    placeholder="Current password" required />
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">New password</label>
                                                <input type="password" class="form-control" name="new_password"
                                                    placeholder="New password" required id="new_password" />
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Repeat new password</label>
                                                <input type="password" class="form-control" name="repeat_new_password"
                                                    placeholder="Repeat new password" required id="repeat_new_password" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" name="change_password" class="btn btn-primary">Change
                                                    Password</button>
                                            </div>
                                        </div>
                                    </form>

                                    <script>
                                        function validateForm() {
                                            const newPassword = document.getElementById("new_password").value;
                                            const repeatNewPassword = document.getElementById("repeat_new_password").value;

                                            if (newPassword !== repeatNewPassword) {
                                                alert("New password and repeat password do not match.");
                                                return false;
                                            }

                                            if (newPassword.length < 8) {
                                                alert("New password must be at least 8 characters long.");
                                                return false;
                                            }


                                            const passwordStrengthRegex =
                                                /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;
                                            if (!passwordStrengthRegex.test(newPassword)) {
                                                alert(
                                                    "New password must contain at least one uppercase letter, one lowercase letter, and one number."
                                                );
                                                return false;
                                            }

                                            return true;
                                        }
                                    </script>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>









        <script>
            function validateForm(event) {
                // Prevent form submission
                event.preventDefault();

                // Get form fields
                const firstName = document.getElementById('inputFirstName').value.trim();
                const middleName = document.getElementById('inputMiddleName').value.trim();
                const lastName = document.getElementById('inputLastName').value.trim();
                const lrn = document.getElementById('inputLRN').value.trim();
                const school = document.getElementById('inputSchool').value;
                const strand = document.getElementById('inputStrand').value;

                let errorMessages = [];

                if (!firstName) {
                    errorMessages.push("First name is required.");
                }
                if (!lastName) {
                    errorMessages.push("Last name is required.");
                }
                if (!lrn) {
                    errorMessages.push("LRN is required.");
                } else if (!/^\d{12}$/.test(lrn)) {
                    errorMessages.push("LRN must be a 12-digit numeric ID.");
                }
                if (!school || school === "") {
                    errorMessages.push("You must select a school.");
                }
                if (!strand || strand === "") {
                    errorMessages.push("You must select a strand.");
                }


                if (errorMessages.length > 0) {
                    alert(errorMessages.join("\n"));
                } else {

                    document.getElementById("edit-profile-form").submit();
                }
            }
        </script>
        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php endif; ?>
</body>

</html>