<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    };
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in | Workify</title>
    <!-- <title>Log in | Workify</title> -->
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/loginform.css">
    <script src="/backend/js/register.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get("error"); // Get the "error" parameter

        if (error === "invalidEmail") {
            // If the error is "invalidEmail", set a custom validity message
            const emailField = document.getElementById("login-email");
            emailField.setCustomValidity("The email address is already taken.");
            emailField.reportValidity();
        } else if (error === "Login_Failed") {
            // If the error is "Login_Failed", set a custom validity message for both fields
            const emailField = document.getElementById("login-email");
            const passwordField = document.getElementById("login-password");
            emailField.setCustomValidity("Invalid email or password.");
            passwordField.setCustomValidity("Invalid email or password.");
            emailField.reportValidity();
            passwordField.reportValidity();
        } else {
            // Clear custom validity if no error or other error
            document.getElementById("login-email").setCustomValidity('');
            document.getElementById("login-password").setCustomValidity('');
        }
    };



    function onRegisterSubmit(token) {
        document.getElementById("login_form").submit();
    }


    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get("error");

        if (error === "alreadyTakenEmail") {
            document
                .getElementById("email")
                .setCustomValidity("The email address was already taken");
            document.getElementById("email").reportValidity();
        }
        if (error === "0AuthDuplicateEmail") {
            document
                .getElementById("google-login-btn")
                .setCustomValidity(
                    "Your email was already taken, try logging in using a different method"
                );
            document.getElementById("email").reportValidity();
        }
        if (error === "Login_Failed") {
            const loginEmailField = document.getElementById("login-email");
            const loginPasswordField = document.getElementById("login-password");

            loginEmailField.addEventListener("click", function() {
                window.location.href = "login.php";
            });
            loginPasswordField.addEventListener("click", function() {
                window.location.href = "login.php";
            });

            if (loginEmailField && loginPasswordField) {
                loginEmailField.setCustomValidity("Invalid Email or Password");
                loginPasswordField.setCustomValidity("Invalid Email or Password");
                loginEmailField.reportValidity();
                loginPasswordField.reportValidity();
            }

            loginEmailField.addEventListener("focus", function() {
                window.location.href = "login.php";
            });

            loginPasswordField.addEventListener("focus", function() {
                window.location.href = "login.php";
            });
        }
    };

    const emailInput = document.getElementById("email");

    emailInput.addEventListener("input", function() {
        emailInput.setCustomValidity("");
    });
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


        <div id="login-form" class="colm-form">

            <!-- <a href="index.php"> <img class="logo-login" src="../img/DrRamonLOGO.svg" alt="Logo"></a> -->
            <a href="index.php"> <img class="logo-login" src="../img/WORKIFYTEXTLOGO.svg" alt="Logo"></a>
            <!-- ---------------------------------Logo ---------------------- -->


            <div class="form-container">


                <!-- <div class="dd-privacy-allow css-e1gwqt e15p7aqh1"><span class="css-8u2krs esbq1260">
                        <span role="separator" aria-orientation="horizontal"></span></span>

                </div>
                
 -->


                <!-- --------------------------------Line OR--------------------------->
                <form id="loginForm" method="POST" action="/backend/php/account_login.php">

                    <label class="css-ddheu4"> Email address <span aria-hidden="true"
                            class="css-ers2ar es2vvo71">&nbsp;*</span> </label>
                    <input class="email" autocomplete="email" type="text" placeholder="" id="login-email"
                        name="login_email" required>

                    <label class="css-ddheu4"> Password <span aria-hidden="true"
                            class="css-ers2ar es2vvo71">&nbsp;*</span>
                    </label>
                    <input class="pass" autocomplete="current-password" type="password" placeholder=""
                        id="login-password" name="login_password" required>
                    <br>

                    <div class="chek">
                        <input type="checkbox" onclick="myFunction()">
                    </div>
                    <p class="show">Show Password</p>

                    <button type="submit" class="btn-login" style="height: 40px; font-size: 15px">
                        <span class="hover-underline-animation"> Continue </span>
                        <svg id="arrow-horizontal" xmlns="http://www.w3.org/2000/svg" width="30" height="10"
                            viewBox="0 0 46 16" fill="#fff">
                            <path id="Path_10" data-name="Path 10"
                                d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z"
                                transform="translate(30)"></path>
                        </svg>
                    </button>

                </form>

                <!-- --------------------------------Line OR--------------------------->

                <div class="dd-privacy-allow css-e1gwqt e15p7aqh1"><span class="css-8u2krs esbq1260">
                        <span role="separator" aria-orientation="horizontal"></span></span>

                </div>


                <a href="register.php">
                    <button class="btn-new" id="switch-to-register" style=" font-size: 15px">
                        <span class="hover-underline-animation">
                            Create new account
                        </span>

                    </button>

                </a>
                <a href="index.php" style="text-decoration: none;">
                    << Back</a>
            </div>

        </div>

    </div>

    <script>
    function myFunction() {
        var x = document.getElementById("login-password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    </script>
    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer
            Society Students </p>
        <!-- <p>By using Workify you agrree to new <a href="#"></a></p> -->

    </footer>
</body>

</html>