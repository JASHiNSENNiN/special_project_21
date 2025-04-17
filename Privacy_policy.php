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

 
 <a class="btn-home" style="color:#fff; font-weight: 600;" href="register.php"> Back </a>
  
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

    <title> Privacy Policy | DRDSNHS</title>

    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <!-- <link rel="shortcut icon" type="x-icon" href="/img/W.png"> -->

    <link rel="stylesheet" type="text/css" href="css/terms.css">
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
                <h2>Privacy Policy for DRDSNHS</h2>
            </div>
            <div class="container__content">
                <h1>Privacy Policy for DRDSNHS</h1>

                <h2>Introduction</h2>
                <p>DRDSNHS is committed to protecting the privacy of our users, particularly senior high school students seeking work immersion opportunities. This Privacy Policy outlines how we collect, use, and protect your personal information in compliance with applicable laws in the Philippines.</p>

                <h2>Information We Collect</h2>

                <h2>Student Information</h2>
                <p>Here is the student information we collect:</p>
                <ul>
                    <li>Name</li>
                    <li>Student ID</li>
                    <li>Grade Level</li>
                    <li>School Information</li>
                    <li>Parent/Guardian Information</li>
                </ul>

                <h2>Documents</h2>
                <p>We may collect the following documents:</p>
                <ul>
                    <li>Resume</li>
                    <li>Application Letter</li>
                    <li>Barangay Clearance</li>
                    <li>Police Clearance</li>
                    <li>Mayor's Clearance</li>
                    <li>Medical Certificate</li>
                    <li>Insurance Policy</li>
                    <li>Parent's Consent</li>
                </ul>

                <h2>Evaluation Information</h2>
                <p>We may also collect:</p>
                <ul>
                    <li>Evaluation Scores/Ratings</li>
                    <li>Skills Assessment</li>
                    <li>Attendance Records</li>
                    <li>Work Ethics Evaluation</li>
                    <li>Supervisor Feedback</li>
                </ul>

                <h2>Organization Information</h2>
                <p>Here is the organization information we collect:</p>
                <ul>
                    <li>Work Placement Details (Company Name, Address, Contact Information)</li>
                    <li>Duration of Work Immersion</li>
                    <li>Tasks and Responsibilities Assigned to Students</li>
                    <li>Work Immersion Schedule</li>
                </ul>

                <h2>School Information</h2>
                <p>Here is the school information we collect:</p>
                <ul>
                    <li>School Name</li>
                    <li>Other relevant information</li>
                </ul>

                <h2>Use of Information</h2>
                <p>We use the collected information for the following purposes:</p>
                <ul>
                    <li>To create and manage your account on DRDSNHS.</li>
                    <li>To match you with suitable work immersion opportunities.</li>
                    <li>To communicate with you regarding your application and other relevant updates.</li>
                    <li>To evaluate your performance and provide feedback.</li>
                    <li>To comply with legal obligations and protect our rights.</li>
                </ul>

                <h2>Data Protection</h2>
                <p>We implement appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction. Access to your personal data is limited to authorized personnel who need to know that information to process your application.</p>

                <h2>Retention of Data</h2>
                <p>Your personal information will be retained only for as long as necessary to fulfill the purposes outlined in this Privacy Policy or as required by law. We will securely delete or anonymize your data when it is no longer needed.</p>

                <h2>Your Rights</h2>
                <p>Under the Data Privacy Act of 2012 (Republic Act No. 10173) in the Philippines, you have the right to:</p>
                <ul>
                    <li>Access your personal data.</li>
                    <li>Request correction of inaccurate or incomplete data.</li>
                    <li>Request the deletion of your personal data under certain conditions.</li>
                    <li>Withdraw your consent at any time, where we rely on your consent to process your personal data.</li>
                </ul>

                <h2>Changes to This Privacy Policy</h2>
                <p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated effective date. We encourage you to review this Privacy Policy periodically for any changes.</p>

                <h2>Contact Us</h2>
                <p>If you have any questions or concerns about this Privacy Policy or our data practices, please contact us at <a href="gmail.com">jpcsolshco@gmail.com</a>.</p>
            </div>
            <div class="container__nav">
                <footer>
                    <p>This Privacy Policy is governed by the Data Privacy Act of 2012 (Republic Act No. 10173) and other relevant laws in the Philippines, which provide guidelines on the collection, use, and protection of personal information.</p>
                </footer>

            </div>
        </section>
    </main>



</body>


</html>