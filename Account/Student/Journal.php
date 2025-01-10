<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getJournalEntry($conn, $student_id, $entry_number)
{
    $query = $conn->prepare("SELECT date, title, entry FROM student_journals WHERE student_id = ? AND entry_number = ?");
    $query->bind_param("ii", $student_id, $entry_number);
    $query->execute();
    $result = $query->get_result();

    return $result->fetch_assoc();
}

$student_id = $_SESSION['user_id'];
$entries = [];

for ($i = 1; $i <= 10; $i++) {
    $entries[$i] = getJournalEntry($conn, $student_id, $i);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $title = $_POST['title'];
    $entry = $_POST['entry'];
    $entry_number = $_POST['entry_number'];
    $entry_number = $_POST['entry_number'];

    $existingEntry = getJournalEntry($conn, $student_id, $entry_number);

    if ($existingEntry) {

        $stmt = $conn->prepare("UPDATE student_journals SET date = ?, title = ?, entry = ? WHERE student_id = ? AND entry_number = ?");
        $stmt->bind_param("sssii", $date, $title, $entry, $student_id, $entry_number);
    } else {
        $stmt = $conn->prepare("INSERT INTO student_journals (student_id, date, title, entry, entry_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $student_id, $date, $title, $entry, $entry_number);
    }

    if ($stmt->execute()) {
        header("Refresh:0");
        // echo "Journal entry saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Dashboard</title>
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <link rel="stylesheet" type="text/css" href="css/Journal.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>


</head>

<body>

    <?php echo $profile_div; ?>
    <br><br>
    <hr>
    <div class="logo">
        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a id="#area" href="Company_area.php"> Company Area</a>
            <a class="active" id="#area" href="Journal.php">Journal</a>
        </nav>
    </div>
    <hr class="line_bottom">


    <div class="container2">
        <h1>Student Work Immersion Journal</h1>
        <div class="page-wrapper">
            <ol class='years'>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                <li class='year'>
                    <a class='expander' href="#">
                        <?php if (isset($entries[$i]) && !empty($entries[$i]['entry'])): ?>
                        <i class="fa fa-check-circle" style="font-size:24px;color:green"></i>
                        <?php else: ?>
                        <i class="fa fa-exclamation-circle" style="font-size:24px;color:red"></i>
                        <?php endif; ?>
                        Day <?php echo $i; ?> - Immersion Experience
                    </a>
                    <ol>
                        <li>
                            <div class="container3">
                                <h2 class="title">Journal Entry</h2>
                                <form action="#" method="post">
                                    <input type="hidden" id="entry_number" name="entry_number"
                                        value="<?php echo $i; ?>">
                                    <div class="form-group">
                                        <label class="Jor" for="date">Date</label>
                                        <input class="inp" type="date" id="date" name="date"
                                            value="<?php echo $entries[$i]['date'] ?? ''; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="Jor" for="title">Title</label>
                                        <input class="inp" type="text" id="title" name="title"
                                            placeholder="Enter a title"
                                            value="<?php echo $entries[$i]['title'] ?? ''; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="Jor" for="entry">Journal Entry</label>
                                        <textarea id="entry" name="entry" placeholder="Write your journal entry here..."
                                            required><?php echo $entries[$i]['entry'] ?? ''; ?></textarea>
                                    </div>

                                    <button class="sub" type="submit">Save Entry</button>
                                </form>
                            </div>
                        </li>
                    </ol>
                </li>
                <?php endfor; ?>
            </ol>
        </div>
    </div>

    <br>

    <footer>
        <!-- <p>&copy; 2024 Your Website. All rights reserved. | Dr. Ramon De Santos National High School</p> -->
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer</p>

    </footer>

    <!-- <script>
    let profilePic1 = document.getElementById("cover-pic");
    let inputFile1 = document.getElementById("input-file1");

    inputFile1.onchange = function() {
        profilePic1.src = URL.createObjectURL(inputFile1.files[0]);
    }
    </script>

    <script>
    let profilePic2 = document.getElementById("profile-pic");
    let inputFile2 = document.getElementById("input-file2");

    inputFile2.onchange = function() {
        profilePic2.src = URL.createObjectURL(inputFile2.files[0]);
    }
    </script> -->

    <script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
    $('.expander').click(function(e) {
        e.preventDefault();
        $(this)
            .parent()
            .toggleClass('expanded')
            .find('>ol')
            .slideToggle();
    });
    </script>

    <script type="text/javascript">
    // Get the current year
    const currentYear = new Date().getFullYear();

    // Find the element with id 'current-year' and set its text
    document.getElementById("current-year").textContent = currentYear;
    </script>

</body>

</html>