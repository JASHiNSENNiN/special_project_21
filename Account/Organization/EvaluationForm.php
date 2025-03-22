<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';

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

$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

$sql = "SELECT COUNT(*) as eval_count FROM Student_Evaluation 
        WHERE student_id = :student_id AND evaluation_date = CURDATE()";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':student_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);
$has_evaluation_today = $result['eval_count'] > 0;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Evaluation Form</title>
    <link rel="stylesheet" type="text/css" href="css/EvaluationForm.css">
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>

<body>
    <!-- Navbar top -->
    <style>
    /* NavbarTop */


    /* End */
    </style>
    <div class="navbar-top">
        <div class="title">
            <h1 style="color:#ffff; font-weight: bold">Student Evaluation</h1>
        </div>
        <ul>
            <li>
                <a href="../../Account/<?= $_SESSION['account_type']; ?>">
                    <i class=" fa fa-sign-out-alt fa-2x"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- End -->
    <div class="container-rating">


        <h3>Star rating:</h3>
        <ol>
            <li><b>1=Did not meet job requirements.</b> Significant performance improvement urgently needed.
            </li>
            <li><b>2=Met minimum job requirements.</b> Work improvement plan was needed to bring performance to a
                satisfactory level.</li>
            <li><b>3=Met normal job requirements with few exceptions.</b> Improvements in performance needed in one or
                more elements.</li>
            <li><b>4=Fully met job requirements.</b> Performance was what was expected of a person in his/her position.
            </li>
            <li><b>5=Exceeded job requirements.</b> Student performance was impressive, exceeded what is normally
                expected in this position.</li>

        </ol>
        <div class="form-group">
            <label class="Jor" for="date">Date</label>
            <input class="inp" type="date" id="date" name="date" value="" required>
        </div>

        <div class="form-group">
            <label class="Jor" for="day">Select Day (1-10)</label>
            <select class="inp" id="day" name="day" required>
                <option value="" disabled selected>Select a day</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
        </div>
    </div>
    <div class="wrapper">
        <div class="header1">
            <ul>
                <li class="active form_1_progessbar">
                    <div>
                        <p>1</p>
                    </div>
                </li>
                <li class="form_2_progessbar">
                    <div>
                        <p>2</p>
                    </div>
                </li>
                <li class="form_3_progessbar">
                    <div>
                        <p>3</p>
                    </div>
                </li>

            </ul>
        </div>

        <div class="form_wrap">
            <div class="form_1 data_info">
                <h2>WORK HABITS</h2>

                <div class="form_container">
                    <div class="questioner">
                        <form id="inputs">
                            <div class="st">
                                <h3>1. Punctual</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question1" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question1" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. Reports regularly</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question2" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question2" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. Performs tasks without much supervision</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question3" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question3" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question3" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question3" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question3" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>4. Practices self-discipline in his/her work</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question4" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question4" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question4" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question4" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question4" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>5. Demonstrates dedication and commitment to the task assigned to him/her</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question5" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question5" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question5" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question5" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question5" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="form_2 data_info" style="display: none;">
                <h2>WORK SKILLS</h2>
                <div class="form_container">
                    <div class="questioner">
                        <form id="inputs1">
                            <div class="st">
                                <h3>1. Demonstrate the ability to operate machines needed on the job</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question6" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question6" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question6" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question6" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question6" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. Handles the details of the work assigned to him/her</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question7" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question7" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question7" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question7" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question7" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. Shows flexibility (whenever the need arises) in the process of going through his
                                    or her task</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question8" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question8" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question8" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question8" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question8" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>4. Manifest thoroughness and precise attention to details</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question9" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question9" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question9" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question9" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question9" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>5. Fully understand the linkage or connection between his/her task to previous
                                    interviewing and subsequent tasks</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question10" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question10" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>6. Usually comes up with sound suggestion to problems</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question11" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question11" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="form_3 data_info" style="display: none;">
                <h2>SOCIAL SKILLS</h2>
                <div class="form_container">
                    <div class="questioner">
                        <form id="inputs2">
                            <div class="st">
                                <h3>1. Shows tact in dealing with different people he/she comes in contact with</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question12" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question12" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>2. Shows respect and courtesy in dealing with peers and superiors</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question13" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question13" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>3. Willingly helps others (whenever necessary) in the performance of their task.
                                </h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question14" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question14" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>4. Is capable of learning from and listening to co-workers.</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question15" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question15" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>5. Shows appreciation and gratitude for any form of assistance granted to him/her by
                                    others.</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question16" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question16" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>6. Shows poise, self-confidence and is always well-groomed.</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question17" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question17" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                                <h3>7. Shows emotional maturity.</h3>
                                <div class="sr">
                                    <label class="star empty green"><input type="radio" name="question18" value="1"
                                            checked><i class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="2"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="3"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="4"><i
                                            class="fa fa-star"></i></label>
                                    <label class="star empty"><input type="radio" name="question18" value="5"><i
                                            class="fa fa-star"></i></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="btns_wrap">
            <div class="common_btns form_1_btns">

                <button type="button" class="btn_next">Next <span class="icon">
                        <span class="icon">
                            <ion-icon name="arrow-forward-sharp"></ion-icon>
                        </span>
                </button>

            </div>
            <div class="common_btns form_2_btns" style="display: none;">
                <button type="button" class="btn_back"><span class="icon">
                        <ion-icon name="arrow-back-sharp"></ion-icon>
                    </span>Back</button>
                <button type="button" class="btn_next">Next <span class="icon">
                        <ion-icon name="arrow-forward-sharp"></ion-icon>
                    </span></button>
            </div>
            <div class="common_btns form_3_btns" style="display: none;">
                <button type="button" class="btn_back"><span class="icon">
                        <ion-icon name="arrow-back-sharp"></ion-icon>
                    </span>Back</button>

                <button type="button" class="btn_done">Done</button>
            </div>


        </div>
    </div>


    <div class="modal_wrapper">
        <div class="shadow"></div>
        <div class="success_wrap">
            <span class="modal_icon">
                <ion-icon name="checkmark-sharp"></ion-icon>
            </span>
            <p>You have successfully completed the process.</p>
        </div>
    </div>

    <script>
    // console.log("id: <?php echo decrypt_url_parameter(base64_decode($IdParam)); ?>");
    <?php if ($has_evaluation_today): ?>

    const now = new Date();
    const midnight = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1);
    let countdown = Math.floor((midnight - now) / 1000);

    let countdownElement = document.querySelector('.time-remaining');

    function updateCountdown() {
        let hours = Math.floor(countdown / 3600);
        let minutes = Math.floor((countdown % 3600) / 60);
        let seconds = countdown % 60;
        countdownElement.textContent = `${hours}h ${minutes}m ${seconds}s`;
        countdown--;

        if (countdown < 0) {

            location.reload();
        }
    }

    setInterval(updateCountdown, 1000);
    <?php endif; ?>
    </script>

    <script>
    var form_1 = document.querySelector(".form_1");
    var form_2 = document.querySelector(".form_2");
    var form_3 = document.querySelector(".form_3");

    var form_1_btns = document.querySelector(".form_1_btns");
    var form_2_btns = document.querySelector(".form_2_btns");
    var form_3_btns = document.querySelector(".form_3_btns");

    var form_1_next_btn = document.querySelector(".form_1_btns .btn_next");
    var form_2_back_btn = document.querySelector(".form_2_btns .btn_back");
    var form_2_next_btn = document.querySelector(".form_2_btns .btn_next");
    var form_3_back_btn = document.querySelector(".form_3_btns .btn_back");

    var btn_done = document.querySelector(".btn_done");
    var modal_wrapper = document.querySelector(".modal_wrapper");
    var shadow = document.querySelector(".shadow");

    form_1_next_btn.addEventListener("click", function() {
        form_1.style.display = "none";
        form_2.style.display = "block";
        form_1_btns.style.display = "none";
        form_2_btns.style.display = "flex";
    });

    form_2_back_btn.addEventListener("click", function() {
        form_1.style.display = "block";
        form_2.style.display = "none";
        form_1_btns.style.display = "flex";
        form_2_btns.style.display = "none";
    });

    form_2_next_btn.addEventListener("click", function() {
        form_2.style.display = "none";
        form_3.style.display = "block";
        form_2_btns.style.display = "none";
        form_3_btns.style.display = "flex";
    });

    form_3_back_btn.addEventListener("click", function() {
        form_2.style.display = "block";
        form_3.style.display = "none";
        form_2_btns.style.display = "flex";
        form_3_btns.style.display = "none";
    });

    btn_done.addEventListener("click", function() {

        const answers = [];

        function collectAnswers(form, startIndex, questionCount) {
            for (let i = 0; i < questionCount; i++) {
                const questionIndex = startIndex + i;
                const radioButtons = form.querySelectorAll(`[name="question${questionIndex}"]`);
                let selectedValue = "1"; // Default value

                radioButtons.forEach((radioButton) => {
                    if (radioButton.checked) {
                        selectedValue = radioButton.value;
                    }
                });
                answers.push(selectedValue);
            }
        }
        const dateInput = document.getElementById('date');
        const dayInput = document.getElementById('day');

        if (!dateInput.value || !dayInput.value) {
            alert("Please select an entry for the date and day");
            return;
        }

        // Collecting answers
        collectAnswers(document.getElementById('inputs'), 1, 5); // Work Habits: 5 questions
        collectAnswers(document.getElementById('inputs1'), 6, 6); // Work Skills: 6 questions
        collectAnswers(document.getElementById('inputs2'), 12, 7); // Social Skills: 7 questions

        const urlParams = new URLSearchParams(window.location.search);
        const studentId = urlParams.get('student_id');

        const jsonData = {};
        for (let i = 0; i < answers.length; i++) {
            jsonData[`question${i + 1}`] = answers[i];
        }

        jsonData.date = dateInput.value;
        jsonData.day = dayInput.value;
        jsonData.student_id = studentId;

        // console.log(jsonData);

        const url = '../../backend/php/add_organization_report.php';
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.text();
            })
            .then(data => {
                try {
                    const jsonData = JSON.parse(data);
                    if (jsonData.status === 'success') {
                        window.location.reload();
                    }
                } catch (e) {
                    console.error('Parsing error:', e, 'Response data:', data);
                }
            })
            .catch(error => console.error('Error:', error));
    });

    shadow.addEventListener("click", function() {
        modal_wrapper.classList.remove("active");
    });
    </script>

    <script>
    const form = document.querySelector('form');
    form.addEventListener('submit', event => {
        const formData = new FormData(event.target);
        const rating = formData.get('rating');
        // console.log(rating);
        event.preventDefault();
    });
    </script>

    <script>
    var inputsForm = document.querySelector("#inputs");
    inputsForm.onchange = function(e) {
        if (e.target.type = "radio") {
            var stars = document.querySelectorAll(`[name='${e.target.name}']`);
            for (var i = 0; i < stars.length; i++) {
                if (i < e.target.value) {
                    stars[i].parentElement.classList.replace("empty", "green");
                } else {
                    stars[i].parentElement.classList.replace("green", "empty");
                }
            }
        }
    }

    inputsForm.onsubmit = function() {
        // console.log(
        //     ` ${this.question1.value}\n ${this.question2.value}\n${this.question3.value}\n${this.question4.value}\n${this.question5.value}`
        // );
        return false;
    }
    </script>

    <script>
    var inputsForm = document.querySelector("#inputs1");
    inputsForm.onchange = function(e) {
        if (e.target.type = "radio") {
            var stars = document.querySelectorAll(`[name='${e.target.name}']`);
            for (var i = 0; i < stars.length; i++) {
                if (i < e.target.value) {
                    stars[i].parentElement.classList.replace("empty", "green");
                } else {
                    stars[i].parentElement.classList.replace("green", "empty");
                }
            }
        }
    }

    inputsForm.onsubmit = function() {
        // console.log(
        //     ` ${this.question6.value}\n ${this.question7.value}\n${this.question8.value}\n${this.question9.value}\n${this.question0.value}`
        // );
        return false;
    }
    </script>
    <script>
    var inputsForm = document.querySelector("#inputs2");
    inputsForm.onchange = function(e) {
        if (e.target.type = "radio") {
            var stars = document.querySelectorAll(`[name='${e.target.name}']`);
            for (var i = 0; i < stars.length; i++) {
                if (i < e.target.value) {
                    stars[i].parentElement.classList.replace("empty", "green");
                } else {
                    stars[i].parentElement.classList.replace("green", "empty");
                }
            }
        }
    }

    inputsForm.onsubmit = function() {
        // console.log(
        //     ` ${this.question11.value}\n ${this.question12.value}\n${this.question13.value}\n${this.question14.value}\n${this.question15.value}`
        // );
        return false;
    }

    var inputsForm = document.querySelector("#inputs3");
    inputsForm.onchange = function(e) {
        if (e.target.type = "radio") {
            var stars = document.querySelectorAll(`[name='${e.target.name}']`);
            for (var i = 0; i < stars.length; i++) {
                if (i < e.target.value) {
                    stars[i].parentElement.classList.replace("empty", "green");
                } else {
                    stars[i].parentElement.classList.replace("green", "empty");
                }
            }
        }
    }

    // just for showing the values (not required only for testing)
    inputsForm.onsubmit = function() {
        // console.log(
        //     ` ${this.question16.value}\n ${this.question17.value}\n${this.question18.value}\n${this.question19.value}\n${this.question20.value}`
        // );
        return false;
    }
    </script>
    <script>
    var inputsForm = document.querySelector("#inputs4");
    inputsForm.onchange = function(e) {
        if (e.target.type = "radio") {
            var stars = document.querySelectorAll(`[name='${e.target.name}']`);
            for (var i = 0; i < stars.length; i++) {
                if (i < e.target.value) {
                    stars[i].parentElement.classList.replace("empty", "green");
                } else {
                    stars[i].parentElement.classList.replace("green", "empty");
                }
            }
        }
    }

    // just for showing the values (not required only for testing)
    inputsForm.onsubmit = function() {
        // console.log(
        //     ` ${this.question21.value}\n ${this.question22.value}\n${this.question23.value}\n${this.question24.value}\n${this.question25.value}`
        // );
        return false;
    }
    </script>

</body>

</html>