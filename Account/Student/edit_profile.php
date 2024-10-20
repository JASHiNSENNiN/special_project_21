<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Not authenticated']);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Handle image upload
    if (isset($_FILES['profile_image'])) {
        $file = $_FILES['profile_image'];

        // Validate file
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($file['type'], $allowed_types)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type']);
            exit;
        }

        if ($file['size'] > 5 * 1024 * 1024) { // 5MB limit
            echo json_encode(['success' => false, 'message' => 'File too large']);
            exit;
        }

        // Create upload directory if it doesn't exist
        $upload_dir = 'uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Generate unique filename
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = md5($user_id . time()) . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            // Update database with new image path
            $sql = "UPDATE users SET profile_image = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_filename, $user_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'filename' => $new_filename]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database update failed']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
        }
        exit;
    }

    // Handle profile update
    if (isset($_POST['first_name'])) {
        $required_fields = ['first_name', 'last_name', 'school', 'strand'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                echo json_encode(['success' => false, 'message' => 'Missing required fields']);
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
            echo json_encode(['success' => false, 'message' => 'Invalid strand']);
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
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed']);
        }
        exit;
    }
}

// Fetch current profile data
$profile_data = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT sp.*, u.profile_image 
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
    <link rel="stylesheet" type="text/css" href="css/org_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>
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
    <header id="myHeader-sticky">
        <div class="logo">
            <a href="Company_Area.php">
                <img src="../../img/logov3.jpg" alt="Logo">
            </a>
            <nav class="dash-middle">
                <!-- <a class="active-header" href="index.php">Home</a>
                <a href="job_list.php">Company review</a>
                <a href="contact.php">Contact</a> -->
            </nav>
        </div>
        <nav class="nav-log">
            <!-- <a class="login-btn" href="login.php" style="margin-left: 20px;">Sign in</a> -->
            <div class="css-1ld7x2h eu4oa1w0"></div>
            <a class="com-btn" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"
                onclick="window.location.href = document.referrer;"> Back</a>
        </nav>

    </header>
    <?php if (!isset($_SESSION['user_id'])): ?>
    <div class="container mt-5">
        <div class="alert alert-danger">Please log in to access this page.</div>
    </div>
    <?php else: ?>
    <div class="container-xl px-4 mt-4">

        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <img class="img-account-profile rounded-circle mb-2" id="profile-image"
                            src="<?php echo $profile_data['profile_image'] ? 'uploads/' . $profile_data['profile_image'] : 'uploads/default.png'; ?>"
                            alt="Profile" style="width: 200px; height: 200px; object-fit: cover;">
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        <form id="profile-image-form">
                            <input type="file" id="image-upload" name="profile_image" accept="image/*"
                                style="display: none;">
                            <label for="image-upload" class="btn btn-primary">Upload new image</label>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form id="edit-profile-form">
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName">First name</label>
                                    <input class="form-control" id="inputFirstName" name="first_name" type="text"
                                        value="<?php echo htmlspecialchars($profile_data['first_name'] ?? ''); ?>"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputMiddleName">Middle name</label>
                                    <input class="form-control" id="inputMiddleName" name="middle_name" type="text"
                                        value="<?php echo htmlspecialchars($profile_data['middle_name'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLastName">Last name</label>
                                    <input class="form-control" id="inputLastName" name="last_name" type="text"
                                        value="<?php echo htmlspecialchars($profile_data['last_name'] ?? ''); ?>"
                                        required>
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">

                                    <div class="container4">
                                        <form class="form-control" action="/submit" method="post">
                                            <label class="small mb-1" for="inputSchool">School name</label>
                                            <select class="form-control" id="student" name="student"
                                                <?php echo htmlspecialchars($profile_data['school'] ?? ''); ?> required>
                                                <option value="" disabled selected>Select a School</option>
                                                <option value="OLSHCO">OLSHCO</option>
                                                <option value="National">Dr Ramon</option>
                                                <option value="CATMAN">CATMAN</option>
                                                <option value="WCC">WCC</option>
                                                <option value="CRT">CRT</option>
                                            </select>
                                            <!-- <label class="StudentLabel" for="student">Choose a Strand:</label>
                        <select class="StudentSelect" id="student" name="student" required>
                            <option value="" disabled selected>Select a student</option>
                            <option value="HUMSS">HUMSS</option>
                            <option value="STEM">STEM</option>
                            <option value="GAS">GAS</option>
                            <option value="TECHVOC">TECHVOC</option>
                        </select> -->

                                            <!-- <button type="submit" class="submit-btn"><i class='fas fa-user-plus'
                                                    style='margin-right:10px;'></i>Add
                                                Student</button> -->
                                        </form>
                                    </div>

                                    <!-- <input class="form-control" id="inputSchool" name="school" type="text"
                                        value="<?php echo htmlspecialchars($profile_data['school'] ?? ''); ?>" required> -->
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputStrand">Strand</label>
                                    <select class="form-control" id="inputStrand" name="strand" required>
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
                            <button class="btn btn-primary" type="submit">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const searchInput = document.getElementById('searchInput');
    const dropdownList = document.getElementById('dropdownList1');
    const dropdownItems = dropdownList.getElementsByClassName('dropdown-item1');
    let selectedStudent = '';

    // Filter dropdown items based on search input
    searchInput.addEventListener('input', function() {
        const filter = searchInput.value.toLowerCase();
        let hasMatches = false;

        dropdownList.style.display = 'block'; // Show the dropdown list

        for (let i = 0; i < dropdownItems.length; i++) {
            const itemText = dropdownItems[i].textContent.toLowerCase();
            if (itemText.includes(filter)) {
                dropdownItems[i].style.display = 'block';
                hasMatches = true;
            } else {
                dropdownItems[i].style.display = 'none';
            }
        }

        if (!hasMatches) {
            dropdownList.style.display = 'none'; // Hide if no matches
        }
    });

    // Select student on item click
    for (let i = 0; i < dropdownItems.length; i++) {
        dropdownItems[i].addEventListener('click', function() {
            selectedStudent = this.textContent; // Store the selected student
            searchInput.value = selectedStudent; // Set input value
            dropdownList.style.display = 'none'; // Hide dropdown
        });
    }

    // Add student to table
    document.getElementById('addButton1').addEventListener('click', function() {
        if (selectedStudent) {
            const row = document.createElement('tr');
            const nameCell = document.createElement('td');

            nameCell.textContent = selectedStudent;
            row.appendChild(nameCell);
            document.getElementById('studentTableBody1').appendChild(row);

            // Clear input and reset selected student
            searchInput.value = '';
            selectedStudent = '';
        } else {
            alert('Please select a student.');
        }
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.matches('.dropdown-input1')) {
            dropdownList.style.display = 'none';
        }
    });
    </script>

    <script>
    // Handle profile image preview and upload
    document.getElementById('image-upload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-image').src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Upload image immediately when selected
            const formData = new FormData();
            formData.append('profile_image', file);

            fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Profile image updated successfully');
                    } else {
                        alert(data.message || 'Error updating profile image');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating profile image');
                });
        }
    });

    // Handle form submission
    document.getElementById('edit-profile-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Profile updated successfully');
                } else {
                    alert(data.message || 'Error updating profile');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating profile');
            });
    });
    </script>
    <?php endif; ?>
</body>

</html>