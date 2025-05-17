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
        $phone_number = filter_var($_POST['phone_number'], FILTER_SANITIZE_STRING);
        $zip_code = filter_var($_POST['zip_code'], FILTER_SANITIZE_STRING);
        $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
        $province = filter_var($_POST['province'], FILTER_SANITIZE_STRING);
        $about_us = filter_var($_POST['about_us'], FILTER_SANITIZE_STRING);
        $corporate_vision = filter_var($_POST['corporate_vision'], FILTER_SANITIZE_STRING);
        $corporate_mission = filter_var($_POST['corporate_mission'], FILTER_SANITIZE_STRING);
        $corporate_philosophy = filter_var($_POST['corporate_philosophy'], FILTER_SANITIZE_STRING);
        $corporate_principles = filter_var($_POST['corporate_principles'], FILTER_SANITIZE_STRING);

        // Validate strand
        $valid_strands = ['STEM', 'HUMSS', 'ABM', 'GAS', 'TVL'];
        if (!in_array(strtoupper($strand), $valid_strands)) {
            exit('Invalid strand'); // Handle invalid strands
        }

        // Update partner profile
        $sql = "UPDATE partner_profiles
                SET organization_name = ?, strand = ?, phone_number = ?, zip_code = ?, 
                    address = ?, city = ?, province = ?, about_us = ?, 
                    corporate_vision = ?, corporate_mission = ?, 
                    corporate_philosophy = ?, corporate_principles = ?
                WHERE user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssssssi",
            $organization_name, $strand, $phone_number, $zip_code, 
            $address, $city, $province, $about_us, 
            $corporate_vision, $corporate_mission, 
            $corporate_philosophy, $corporate_principles, 
            $user_id
        );

        if ($stmt->execute()) {
            echo "Profile updated successfully.";
        } else {
            echo "Error updating profile: " . $stmt->error;
        }

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
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">



</head>

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
                                                        style="width: 12.5rem; height: 12.5rem; object-fit: cover;">
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
                                                    reader.onload = function (e) {
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


                                                        </div>
                                                        <form action="dataForm">
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


                                                                <label class="small mb-1" for="numberInput">Phone
                                                                    Number:</label>
                                                                <input class="form-control" type="number" id="numberInput"
                                                                    name="phone_number" placeholder="09x-xxx-xxxx"  value="<?php echo htmlspecialchars($profile_data['phone_number'] ?? ''); ?>"
                                                                    required>


                                                            </div>
                                                            <div class="col-md-6">

                                                                <label class="small mb-1" for="numberInput">Zipcode</label>
                                                                <input class="form-control" type="number" id="zipcodenum"
                                                                    name="zip_code" placeholder="xxxx" 
                                                                    value="<?php echo htmlspecialchars($profile_data['zip_code'] ?? ''); ?>"
                                                                    required>


                                                            </div>
                                                            <div ss="col-md-12">
                                                                <label class="small mb-1"
                                                                    for="inputOrganizationName">Address</label>
                                                                <input class="form-control" id="inputAddressInput"
                                                                    name="address" type="text"
                                                                    placeholder="Street Name, Building, House No., Barangay"
                                                                    value="<?php echo htmlspecialchars($profile_data['address'] ?? ''); ?>"
                                                                    required>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="small mb-1" for="inputStrand">Strand</label>
                                                                <select class="form-control" id="inputStrand" name="strand" required>
                                                                    <option value="<?php echo htmlspecialchars($profile_data['strand'] ?? ''); ?>"><?php echo htmlspecialchars($profile_data['strand'] ?? ''); ?></option>
                                                                    <option value="STEM" <?php echo (isset($profile_data['strand']) && $profile_data['strand'] == 'STEM') ? 'selected' : ''; ?>>STEM</option>
                                                                    <option value="HUMSS" <?php echo (isset($profile_data['strand']) && $profile_data['strand'] == 'HUMSS') ? 'selected' : ''; ?>>HUMSS</option>
                                                                    <option value="ABM" <?php echo (isset($profile_data['strand']) && $profile_data['strand'] == 'ABM') ? 'selected' : ''; ?>>ABM</option>
                                                                    <option value="GAS" <?php echo (isset($profile_data['strand']) && $profile_data['strand'] == 'GAS') ? 'selected' : ''; ?>>GAS</option>
                                                                    <option value="TVL" <?php echo (isset($profile_data['strand']) && $profile_data['strand'] == 'TVL') ? 'selected' : ''; ?>>TVL</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6">

                                                                <label class="small mb-1" for="numberInput">City /
                                                                    Municipality</label>
                                                                <input class="form-control" type="text" id="cityInput"
                                                                value="<?php echo htmlspecialchars($profile_data['city'] ?? ''); ?>"
                                                                    name="city" placeholder="" required>


                                                            </div>

                                                            <div class="col-md-6">

                                                                <!-- <label class="small mb-1" for="numberInput"></label>
                                                                                                                <input class="form-control" type="number" id="numberInput"
                                                                                                                    name="numberInput" required> -->

                                                                <label for="provinces" style="margin-bottom: 4px;">Select
                                                                    a
                                                                    Province:</label>
                                                                <select class="form-control" id="provinces"
                                                                    name="province">
                                                                    <option selected value=""><?php echo htmlspecialchars($profile_data['province'] ?? ''); ?></option>
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
                                                            </div>
                                                            <div ss="col-md-12">
                                                                <label class="small mb-1"
                                                                    for="inputOrganizationName">About Us</label>
                                                                <input class="form-control" id="inputAddressInput"
                                                                    name="about_us" type="text"
                                                                    placeholder="About Us"
                                                                    value="<?php echo htmlspecialchars($profile_data['about_us'] ?? ''); ?>"
                                                                    required>
                                                            </div>
                                                            
                                                            <div ss="col-md-12">
                                                                <label class="small mb-1"
                                                                    for="inputOrganizationName">Corporate Vision</label>
                                                                <input class="form-control" id="inputAddressInput"
                                                                    name="corporate_vision" type="text"
                                                                    placeholder="Corporate Vision"
                                                                    value="<?php echo htmlspecialchars($profile_data['corporate_vision'] ?? ''); ?>"
                                                                    required>
                                                            </div>
                                                            <div ss="col-md-12">
                                                                <label class="small mb-1"
                                                                    for="inputOrganizationName">Corporate Mission</label>
                                                                <input class="form-control" id="inputAddressInput"
                                                                    name="corporate_mission" type="text"
                                                                    placeholder="Corporate Vision"
                                                                    value="<?php echo htmlspecialchars($profile_data['corporate_mission'] ?? ''); ?>"
                                                                    required>
                                                            </div>
                                                            <div ss="col-md-12">
                                                                <label class="small mb-1"
                                                                    for="inputOrganizationName">Corporate Pholosophy</label>
                                                                <input class="form-control" id="inputAddressInput"
                                                                    name="corporate_philosophy" type="text"
                                                                    placeholder="Corporate Vision"
                                                                    value="<?php echo htmlspecialchars($profile_data['corporate_philosophy'] ?? ''); ?>"
                                                                    required>
                                                            </div>
                                                            <div ss="col-md-12">
                                                                <label class="small mb-1"
                                                                    for="inputOrganizationName">Corporate Mission</label>
                                                                <input class="form-control" id="inputAddressInput"
                                                                    name="corporate_principles" type="text"
                                                                    placeholder="Corporate Principles"
                                                                    value="<?php echo htmlspecialchars($profile_data['corporate_principles'] ?? ''); ?>"
                                                                    required>
                                                            </div>
                                                        </form>
                                                        <?php
                                                        // header('Content-Type: application/json');
                                                    

                                                        $data = json_decode(file_get_contents('php://input'), true);


                                                        if (isset($data['phone'], $data['zipcode'], $data['address'], $data['city'], $data['province'], $data['organization_name'], $data['strand'], $data['about_us'], $data['corporate_vision'], $data['corporate_mission'], $data['corporate_philosophy'], $data['corporate_principles'])) {

                                                            $response = [
                                                                'status' => 'success',
                                                                'message' => 'Data received successfully.',
                                                                'data' => $data
                                                            ];
                                                            echo json_encode($response);
                                                        } else {
                                                            
                                                            
                                                        }
                                                        ?>
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
                        <!-- <div class="col-md-3 pt-0">
                            <div class="list-group list-group-flush account-settings-links">
                                <a class="list-group-item list-group-item-action active" data-toggle="list"
                                href="#account-general">General</a>
                                <a class="list-group-item list-group-item-action" data-toggle="list"
                                    href="#account-info">Personal Details</a>
                                <a class="list-group-item list-group-item-action" data-toggle="list"
                                    href="#account-change-password">Change password</a>


                            </div>
                        </div> -->
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
                                            <div class=" form-group">
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




        <script src="js/settings.js"></script>




        <script>
            function validateForm(event) {
                // Prevent form submission
                event.preventDefault();

                
                    document.getElementById("edit-profile-form").submit();
                
            }
        </script>
        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php endif; ?>
</body>

</html>