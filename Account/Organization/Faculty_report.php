<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <link rel="stylesheet" type="text/css" href="css/Faculty_report.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>


</head>

<body>
    <?php echo $profile_div; ?>
    <br>
    <hr>
    <div class="logo">

        <nav class="bt" style="position:relative; margin-left:auto; margin-right:auto;">
            <a href="Job_ads.php"> Job Ads</a>
            <a href="Job_request.php">Job Request</a>
            <a class="active1" href="Faculty_report.php">Student Evaluation</a>
            <a href="Question.php">Questions</a>
            <a href="Details.php">Analytics</a>


        </nav>
    </div>
    <hr class="line_bottom">

    <div class="container2">
        <h1>Student List</h1>
        <table class="rwd-table">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>ID Picture</th>
                    <th>Student Name</th>
                    <th>School</th>
                    <th>Result</th>
                    <th>Action</th>

                </tr>
                <tr>
                    <td data-th="#">1</td>
                    <td data-th="ID Picture"><img class="idpic" src="../Student/image/Default.png" alt="me">
                    </td>
                    <td data-th="Student Name">Joshua Rivera</td>
                    <td data-th="School">Olscho</td>
                    <td data-th="Result">

                        <div class="container3">
                            <div class="circular-progress">
                                <span class="progress-value"></span>
                            </div>
                        </div>

                    </td>
                    <td data-th="Action"><button class="button-9" role="button">Evaluate</button></td>
                </tr>

                <tr>
                    <td data-th="#">2</td>
                    <td data-th="ID Picture"><img class="idpic" src="../Student/image/Default.png" alt="me"></td>
                    <td data-th="Student Name">Dan Mamaid</td>
                    <td data-th="School">Olscho</td>
                    <td data-th="Result">
                        <div class="container3">
                            <div class="circular-progress">
                                <span class="progress-value"></span>
                            </div>
                        </div>
                        <!-- <button onclick="myFunction()" class="button-9" role="button">Result</button><br>
                        <button class="button-37" role="button">Archive</button> -->
                    </td>
                    <td data-th="Action"><button class="button-9" role="button">Evaluate</button></td>
                </tr>

            </tbody>

        </table>
    </div>



    <script>
        $("input:checkbox").on('click', function () {

            var $box = $(this);
            if ($box.is(":checked")) {
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    </script>

    <script>
        $(document).ready(function validation() {
            $('.form').on('submit', function validation() {
                Swal.fire({
                    title: "Successfully send!",
                    text: "You clicked the button!",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        });
    </script>


    <script>
        let profilePic1 = document.getElementById("cover-pic");
        let inputFile1 = document.getElementById("input-file1");

        inputFile1.onchange = function () {
            profilePic1.src = URL.createObjectURL(inputFile1.files[0]);
        }
    </script>

    <script>
        let profilePic2 = document.getElementById("profile-pic");
        let inputFile2 = document.getElementById("input-file2");

        inputFile2.onchange = function () {
            profilePic2.src = URL.createObjectURL(inputFile2.files[0]);
        }
    </script>


    <script>
            << << << < HEAD
                var form_1= document.querySelector(".form_1");
        var form_2 = document.querySelector(".form_2");
        var form_3 = document.querySelector(".form_3");
        var form_4 = document.querySelector(".form_4");
        var form_5 = document.querySelector(".form_5");

        var form_1_btns = document.querySelector(".form_1_btns");
        var form_2_btns = document.querySelector(".form_2_btns");
        var form_3_btns = document.querySelector(".form_3_btns");
        var form_4_btns = document.querySelector(".form_4_btns");
        var form_5_btns = document.querySelector(".form_5_btns");

        var form_1_next_btn = document.querySelector(".form_1_btns .btn_next");
        var form_2_back_btn = document.querySelector(".form_2_btns .btn_back");
        var form_2_next_btn = document.querySelector(".form_2_btns .btn_next");
        var form_3_back_btn = document.querySelector(".form_3_btns .btn_back");
        var form_3_next_btn = document.querySelector(".form_3_btns .btn_next");
        var form_4_back_btn = document.querySelector(".form_4_btns .btn_back");
        var form_4_next_btn = document.querySelector(".form_4_btns .btn_next");
        var form_5_back_btn = document.querySelector(".form_5_btns .btn_back");

        var form_2_progessbar = document.querySelector(".form_2_progessbar");
        var form_3_progessbar = document.querySelector(".form_3_progessbar");
        var form_4_progessbar = document.querySelector(".form_4_progessbar");
        var form_5_progessbar = document.querySelector(".form_5_progessbar");

        var btn_done = document.querySelector(".btn_done");
        var modal_wrapper = document.querySelector(".modal_wrapper");
        var shadow = document.querySelector(".shadow");

        form_1_next_btn.addEventListener("click", function () {
            form_1.style.display = "none";
            form_2.style.display = "block";

            form_1_btns.style.display = "none";
            form_2_btns.style.display = "flex";

            form_2_progessbar.classList.add("active");
        });

        form_2_back_btn.addEventListener("click", function () {
            form_1.style.display = "block";
            form_2.style.display = "none";

            form_1_btns.style.display = "flex";
            form_2_btns.style.display = "none";

            form_2_progessbar.classList.remove("active");
        });

        form_2_next_btn.addEventListener("click", function () {
            form_2.style.display = "none";
            form_3.style.display = "block";

            form_3_btns.style.display = "flex";
            form_2_btns.style.display = "none";

            form_3_progessbar.classList.add("active");
        });

        form_3_back_btn.addEventListener("click", function () {
            form_2.style.display = "block";
            form_3.style.display = "none";

            form_3_btns.style.display = "none";
            form_2_btns.style.display = "flex";

            form_3_progessbar.classList.remove("active");
        });

        form_3_next_btn.addEventListener("click", function () {
            form_3.style.display = "none";
            form_4.style.display = "block";

            form_4_btns.style.display = "flex";
            form_3_btns.style.display = "none";

            form_4_progessbar.classList.add("active");
        });

        form_4_back_btn.addEventListener("click", function () {
            form_3.style.display = "block";
            form_4.style.display = "none";

            form_4_btns.style.display = "none";
            form_3_btns.style.display = "flex";

            form_4_progessbar.classList.remove("active");
        });

        form_4_next_btn.addEventListener("click", function () {
            form_4.style.display = "none";
            form_5.style.display = "block";

            form_5_btns.style.display = "flex";
            form_4_btns.style.display = "none";

            form_5_progessbar.classList.add("active");
        });

        form_5_back_btn.addEventListener("click", function () {
            form_4.style.display = "block";
            form_5.style.display = "none";

            form_5_btns.style.display = "none";
            form_4_btns.style.display = "flex";

            form_5_progessbar.classList.remove("active");
        });

        btn_done.addEventListener("click", function () {
            modal_wrapper.classList.add("active");
        });

        shadow.addEventListener("click", function () {
            modal_wrapper.classList.remove("active");
        });
    </script>

    <script>
        const form = document.querySelector('form');
        form.addEventListener('submit', event => {
            const formData = new FormData(event.target);
            const rating = formData.get('rating');
            console.log(rating);
            event.preventDefault();
        });
    </script>

    <script>
        var inputsForm = document.querySelector("#inputs");
        inputsForm.onchange = function (e) {
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
        inputsForm.onsubmit = function () {
            console.log(
                ` ${this.question1.value}\n ${this.question2.value}\n${this.question3.value}\n${this.question4.value}\n${this.question5.value}`
            );
            return false;
        }
    </script>

    <script>
        var inputsForm = document.querySelector("#inputs1");
        inputsForm.onchange = function (e) {
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
        inputsForm.onsubmit = function () {
            console.log(
                ` ${this.question6.value}\n ${this.question7.value}\n${this.question8.value}\n${this.question9.value}\n${this.question0.value}`
            );
            return false;
        }
    </script>

    <script>
        var inputsForm = document.querySelector("#inputs2");
        inputsForm.onchange = function (e) {
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
        inputsForm.onsubmit = function () {
            console.log(
                ` ${this.question11.value}\n ${this.question12.value}\n${this.question13.value}\n${this.question14.value}\n${this.question15.value}`
            );
            return false;
        }
    </script>

    <script>
        var inputsForm = document.querySelector("#inputs3");
        inputsForm.onchange = function (e) {
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
        inputsForm.onsubmit = function () {
            console.log(
                ` ${this.question16.value}\n ${this.question17.value}\n${this.question18.value}\n${this.question19.value}\n${this.question20.value}`
            );
            return false;
        }
    </script>

    <script>
        var inputsForm = document.querySelector("#inputs4");
        inputsForm.onchange = function (e) {
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
        inputsForm.onsubmit = function () {
            console.log(
                ` ${this.question21.value}\n ${this.question22.value}\n${this.question23.value}\n${this.question24.value}\n${this.question25.value}`
            );
            return false;
        }

        // Get the form elements
        const form = document.getElementById('inputs');
        const form2 = document.getElementById('inputs1');
        const form3 = document.getElementById('inputs2');
        const form4 = document.getElementById('inputs3');
        const form5 = document.getElementById('inputs4');

        // Get the navigation buttons
        const nextButton = document.querySelector('.btn_next');
        const backButton = document.querySelector('.btn_back');
        const doneButton = document.querySelector('.btn_done');

        // Define the form sections
        const formSections = [
            document.querySelector('.form_1'),
            document.querySelector('.form_2'),
            document.querySelector('.form_3'),
            document.querySelector('.form_4'),
            document.querySelector('.form_5')
        ];

        // Define the current form section index
        let currentSectionIndex = 0;

        // Function to navigate to the next form section
        function navigateToNextSection() {
            // Hide the current form section
            formSections[currentSectionIndex].style.display = 'none';

            // Show the next form section
            currentSectionIndex++;
            formSections[currentSectionIndex].style.display = 'block';

            // Update the navigation buttons
            if (currentSectionIndex === 0) {
                nextButton.style.display = 'block';
                backButton.style.display = 'none';
            } else if (currentSectionIndex === formSections.length - 1) {
                nextButton.style.display = 'none';
                doneButton.style.display = 'block';
            } else {
                nextButton.style.display = 'block';
                backButton.style.display = 'block';
            }
        }

        // Function to navigate to the previous form section
        function navigateToPreviousSection() {
            // Hide the current form section
            formSections[currentSectionIndex].style.display = 'none';

            // Show the previous form section
            currentSectionIndex--;
            formSections[currentSectionIndex].style.display = 'block';

            // Update the navigation buttons
            if (currentSectionIndex === 0) {
                nextButton.style.display = 'block';
                backButton.style.display = 'none';
            } else if (currentSectionIndex === formSections.length - 1) {
                nextButton.style.display = 'none';
                doneButton.style.display = 'block';
            } else {
                nextButton.style.display = 'block';
                backButton.style.display = 'block';
            }
        }

        // Function to submit the form data
        function submitFormData() {
            // Get the form data
            const formData = new FormData(form);
            const formData2 = new FormData(form2);
            const formData3 = new FormData(form3);
            const formData4 = new FormData(form4);
            const formData5 = new FormData(form5);

            // Combine all form data into a single object
            const combinedData = {};

            // Function to append FormData to an object
            function appendFormData(formData) {
                for (const [key, value] of formData.entries()) {
                    combinedData[key] = value;
                }
            }

            // Append all form data
            appendFormData(formData);
            appendFormData(formData2);
            appendFormData(formData3);
            appendFormData(formData4);
            appendFormData(formData5);

            // Log the combined form data to the console
            console.log(combinedData);
        }

        // Add event listeners to the navigation buttons
        nextButton.addEventListener('click', navigateToNextSection);
        backButton.addEventListener('click', navigateToPreviousSection);
        doneButton.addEventListener('click', submitFormData);
    </script>
    =======
    let circularProgress =
    document.querySelector('.circular-progress'),
    progressValue =
    document.querySelector('.progress-value');



    let progressStartValue = 0,
    progressEndValue = 80,
    speed = 20;



    let progress = setInterval(() => {

    progressStartValue++;
    progressValue.textContent =
    `${progressStartValue}%`;
    circularProgress.style.background =
    `conic-gradient(#4379F2 ${progressStartValue
    * 3.6}deg, #ededed 0deg)`;

    //3.6deg * 100 = 360deg

    //3.6deg * 90 = 324deg





    if (progressStartValue == progressEndValue) {

    clearInterval(progress);



    }

    console.log(progressStartValue);

    }, speed);
    </script>

    >>>>>>> 0dc80e0e56a18e07e4c376bbabfe2fd51c16951e

    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students</p>
    </footer>


</body>

</html>