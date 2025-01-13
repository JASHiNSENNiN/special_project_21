<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Register | Workify</title> -->
    <title>Register | DRDSNHS</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->
    <?php
    session_start();
    ?>
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/loginform.css">
    <script>
        function onSubmit(token) {
            if (validateRegisterForm()) {
                document.getElementById("registerForm").submit();
            }
        }
    </script>
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
    <div class="row">
        <div id="register-form" class="colm-form">
            <!-- <a href="index.php"><img class="logo-login" src="../img/WORKIFYTEXTLOGO.svg" alt="Logo"></a> -->
            <a href="index.php"><img class="logo-login" src="../img/DrRamonLOGO.svg" alt="Logo"></a>

            <div class="form-container">

                <form id="registerForm" method="POST" onsubmit="return validateRegisterForm()"
                    action="/backend/php/account_registration.php">

                    <input type="text" for="email" name="register_email" id="email" placeholder="Email address"
                        required>
                    <input type="password" placeholder="Password" id="password" name="register_password" required>
                    <input type="password" placeholder="Confirm Password" id="confirm-password"
                        name="register_confirm_password" required>

                    <div class="chek">
                        <input type="checkbox" onclick="myFunction()">
                    </div>
                    <p class="show">Show Password</p>

                    <p class="link-terms-pp">By clicking Register, you agree to our <a href="terms.php">Terms</a> and <a href="Privacy_policy.php">Privacy Policy</a></p>


                    <button id="register-button" class="btn-new" data-action="submit">Register</button>
                </form>

                <div class="dd-privacy-allow css-e1gwqt e15p7aqh1"><span class="css-8u2krs esbq1260">
                        <span role="separator" aria-orientation="horizontal"></span></span>

                </div>
                <div class="bottom-login">
                    <p>Already have account? </p>
                    <a href="login.php">Login Now
                        <!-- <button class="btn-new" id="switch-to-login">
                        Log in to Existing Account
                    </button> -->
                    </a>
                </div>



            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer
            Society Students</p>
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>

    <script>
        function myFunction() {
            var x = document.getElementById("confirm-password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>
<script src="/backend/js/register.js"></script>