<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Workify </title>
    <link rel="stylesheet" type="text/css" href="./css/header.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
    <link rel="stylesheet" type="text/css" href="./css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>

</head>

<header class="nav-header">
    <div class="logo">
        <a href="index.php">
            <img src="./img/logov3.jpg" alt="Logo">
        </a>
        <nav>
            <a href="index.php">Home</a>
            <a href="job_list.php">Company review</a>
            <a class="active-header" href="contact.php">Contact</a>
        </nav>
    </div>
    <nav>
        <a class="login-btn" href="./php/login_form.php" style="margin-left: 20px;">Sign in</a>
        <div class="css-1ld7x2h eu4oa1w0"></div>
        <a href="post_work_Immersion.php">Post Work Immersion</a>
    </nav>
</header>

<div class="slideshow-container">

    <div class="mySlides fade">
        <img src="./img/joblisting.jpg" style="width:100%">

        <h1 class="text-slide-container">Contact Us</h1>
    </div>


</div>
<div class="video-contact">
    <video class="jpcs-vid" width="800" autoplay loop muted>
        <source src="./img/video-con.mp4" type="video/mp4">


    </video>

</div>

<section class="contact-section">


    <div class="container">
        <div class="content">
            <div class="left-side">
                <div class="address details">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="topic">Address</div>
                    <div class="text-one">Afan Salvador St, </div>
                    <div class="text-two"> Guimba, Nueva Ecija</div>
                </div>
                <div class="phone details">
                    <i class="fas fa-phone-alt"></i>
                    <div class="topic">Phone</div>
                    <div class="text-one">+0098 9893 5647</div>
                    <div class="text-two">+0096 3434 5678</div>
                </div>
                <div class="email details">
                    <i class="fas fa-envelope"></i>
                    <div class="topic">Email</div>
                    <div class="text-one">Jpcs@gmail.com</div>
                    <div class="text-two">BSIT@gmail.com</div>
                </div>
            </div>
            <div class="right-side">
                <div class="topic-text">Send us a message</div>
                <p>Thank you for considering Workify for your work immersion. We are committed to providing a valuable
                    and informative experience to all our applicants. Please feel free to contact us if you have any
                    questions or would like to learn more about our website.</p>

                <form action="https://api.web3forms.com/submit" method="POST" autocomplete="off">
                    <input type="hidden" name="access_key" value="1c3d7737-14bc-4bc1-819a-0a5c1c760bc4">
                    <div class="input-box">
                        <input pattern="[A-Za-z]{3,10}" minlength="3" maxlength="10" oninvalid="setCustomValidity('Please enter on alphabets only. ')" type="text" name="name" placeholder="Enter your name" required />
                    </div>
                    <div class="input-box">
                        <input type="text" name="email" placeholder="Enter your email" required />
                    </div>
                    <div class="input-box message-box">
                        <textarea name="message" placeholder="Enter your message"></textarea>
                    </div>
                    <div>
                        <button class="sub-button" type="submit">Send Now</button>
                        <!-- <input type="button" value="Send Now"> -->
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>


<footer>
    <p>&copy; 2024 WorkifyPH. All rights reserved. | Junior Philippines Computer Society Students</p>

</footer>

<!-- JavaScript to display the current date -->
<script>
    document.getElementById("currentDate").innerHTML = new Date().getFullYear();
</script>

<!-- <script src="js/send-email.js"></script> -->
</body>

</html>