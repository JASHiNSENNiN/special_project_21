<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png">
    <title>Woriky Verification</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .wait {
        margin-bottom: 20px;
        color: #333;
        margin-top: 40%;
    }

    .message {
        font-size: 20px;
        color: #555;
        text-align: center;
        margin-bottom: 40px;
    }

    .nav-header {
        background-color: #fff;
        color: #fff;
        padding-right: 20px;
        padding-left: 100px;
        text-align: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo img {
        width: 220px;
        margin-right: 30px;
    }

    .logo h1 {
        margin: 0;
        font-size: 24px;
    }

    .user-info {
        display: flex;
        align-items: center;
        font-size: 16px;
        position: relative;
        margin-right: 100px;
    }

    .user-info img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
        cursor: pointer;
    }

    .user-info .username {
        font-weight: bold;
        color: #333;
    }

    /* Dropdown Styles */
    .dropdown {
        display: none;
        position: absolute;
        top: 35px;
        /* Position dropdown below the user icon */
        right: 0;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
        z-index: 100;
        width: 150px;
        padding: 10px;
    }

    .dropdown a {
        display: block;
        padding: 8px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
    }

    .dropdown a:hover {
        background-color: #f0f0f0;
    }

    /* Show the dropdown when hovering over the user-info */
    .user-info:hover .dropdown {
        display: block;
    }
    </style>
</head>

<body>
    <header class="nav-header">
        <div class="logo">
            <a href="#">
                <img src="image/logov3.jpg" alt="Logo">
            </a>
        </div>

        <!-- User info on the right side -->
        <div class="user-info">
            <img src="https://i.postimg.cc/TWZK3Jg1/user-icon.png" alt="User Avatar">
            <span class="username">John Doe</span>

            <!-- Dropdown menu -->
            <div class="dropdown">
                <a href="#">Profile</a>
                <a href="#">Settings</a>
                <a href="#">Logout</a>
            </div>
        </div>
    </header>

    <div class="wame">
        <h1 class="wait">Wait for Your Account Verification</h1>
        <div class="message">Please wait for the verification of your account.</div>
    </div>
</body>

</html>