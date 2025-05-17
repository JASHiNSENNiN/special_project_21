<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$profile_divv = '<header class="nav-header">
        <div class="logo">
            <a href="register.php"> 
                <img src="img/drdsnhs.svg" alt="Logo">
            </a>
           
            
        </div>
        <nav class="by">

 
 <a class="btn-home" style="color:#fff; font-weight: 600;" href="Account/Organization/Job_ads.php"> Back </a>
  
</div>
        
        </nav>

    </header>

    ';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Term & Privacy | DRDSNHS</title>
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="stylesheet" type="text/css" href="css/org_style.css">
    <link rel="stylesheet" type="text/scss" href="css/reboot.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css"> -->
    <link rel="stylesheet" type="text/css" href="css/term_and_Privacy_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


</head>
<style>

</style>

<body>
    <?php echo $profile_divv; ?>
    <noscript>
        <style>
            html {
                display: none;
            }
        </style>
        <meta http-equiv="refresh" content="0.0;url=message.php">
    </noscript>
    <main class="wrap">
        <section class="container">
            <div class="container__heading">
                <h2>Terms & Privacy</h2>
            </div>
            <div class="container__content">

                <h1>Terms of Service and Privacy Policy for Job Ads</h1>
                <p><strong>Last Updated: 10/18/2024 </strong></p>

                <p>Welcome to DRDSNHS! By logging into and using our platform, you agree to comply with these Terms and
                    Privacy. If you do not agree, please do not log in or use our services.</p>

                <h2>1. Acceptance of Terms</h2>
                <p>Welcome to DRDSNHS. By creating job ads on our platform, partner organizations agree to comply with
                    these Terms of Service and Privacy Policy.</p>

                <h2>2. Acceptance of Terms</h2>
                <p>By accessing or using our services, you agree to these Terms. If you do not agree, please do not use
                    our services.</p>

                <h2>3. Job Ad Creation</h2>
                <ul>
                    <li><b>Eligibility:</b> You must be a legally recognized entity to create job ads.</li>
                    <li><b>Content Responsibility:</b> You are responsible for the content of your job ads. Ensure that
                        they comply with all applicable laws and do not contain misleading information.</li>
                    <li><b>Non-Discrimination :</b> All job ads must adhere to non-discrimination laws and should not
                        promote discrimination based on race, gender, nationality, religion, disability, or any other
                        status.</li>
                </ul>

                <h2>4. User Accounts</h2>
                <ul>
                    <li><b>Account Creation:</b> To create job ads, you must create an account on our website. You agree
                        to provide accurate and complete information during registration.</li>
                    <li><b>Account Security:</b> You are responsible for maintaining the confidentiality of your account
                        credentials and for all activities that occur under your account.</li>

                </ul>

                <h2>5. Data Privacy</h2>
                <ul>
                    <li><b>Information Collection:</b> We collect personal information when you create an account and
                        post job ads. This may include your name, contact details, and company information.</li>
                    <li><b>Use of Information:</b>Your information will be used to facilitate job ad postings,
                        communicate with you, and improve our services.</li>
                    <li><b>Data Sharing:</b>We do not sell or rent your personal information to third parties. We may
                        share your data with service providers who assist us, under strict confidentiality agreements.
                    </li>

                </ul>


                <h2>6. Intellectual Property</h2>
                <ul>
                    <li><b>Ownership:</b> You retain ownership of the content you submit. However, by posting job ads,
                        you grant us a non-exclusive, worldwide, royalty-free license to use, display, and distribute
                        your content.</li>
                </ul>

                <h2>7. Limitation of Liability</h2>
                <ul>
                    <li>DRDSNHS is not liable for any direct, indirect, incidental, or consequential damages that arise
                        from your use of our services or the content of job ads.</li>
                </ul>


                <h2>8. Changes to Terms</h2>
                <p>We may update these Terms and Privacy Policy from time to time. We will notify you of any significant
                    changes by posting a notice on our website.</p>



                <h2>9. Contact us</h2>
                <p>For questions about these Terms, please contact us at <a href="#">JPCS@workify.com</a>.</p>

                <h2>10. Governing Law and References</h2>
                <p>This Terms and Privacy Policy shall be governed by and construed in accordance with the laws of the Republic of the Philippines. In particular, we adhere to the following laws and regulations:</p>
                <ul>
                    <li><b>Data Privacy Act of 2012 (Republic Act No. 10173):</b> This law governs the collection, handling, and protection of personal information in the Philippines, ensuring that your privacy and rights as a data subject are respected and protected.</li>
                    <li><b>Labor Code of the Philippines:</b> All job ads posted on our platform must comply with the provisions of the Labor Code to promote fair employment practices.</li>
                    <li><b>Anti-Discrimination provisions:</b> All job ads must adhere to applicable laws regarding non-discrimination in employment, ensuring fairness in job advertisements and hiring practices.</li>
                </ul>

            </div>
            <div class="container__nav">

                <footer>
                    <p>By using our services, you acknowledge and agree to comply with these laws as they relate to your use of DRDSNHS.</p>
                </footer>
            </div>
        </section>
    </main>



</body>


</html>