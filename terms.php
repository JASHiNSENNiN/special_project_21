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

    <title> Terms | DRDSNHS</title>

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
                <h2>Registration Terms for DRDSNHS</h2>
            </div>
            <div class="container__content">



                <p><strong>Last Updated: 9/01/2024 </strong></p>

                <h2>1. Eligibility</h2>
                <ul>
                    <li>Applicants must be senior high school students enrolled in a recognized educational institution in the Philippines.</li>
                    <li>Students must be at least 15 years old but not more than 30 years old, as stipulated by the Special Program for Employment of Students (SPES).</li>
                </ul>

                <h2>2. Documentation</h2>
                <ul>
                    <li>Students must provide valid identification and proof of enrollment.</li>
                    <li>A signed parental consent form may be required for applicants under 18 years of age.</li>
                </ul>

                <h2>3. Work Immersion Requirements</h2>
                <ul>
                    <li>Students must complete a minimum of 80 hours and a maximum of 320 hours of work immersion, depending on their specific track (e.g., ABM, STEM).</li>
                    <li>The work immersion must align with the student's field of study and career interests.</li>
                </ul>

                <h2>4. Compliance with Labor Laws</h2>
                <ul>
                    <li>Participating employers must comply with the provisions of Republic Act No. 10917, which governs the employment of students under the SPES.</li>
                    <li>Employers must provide a safe working environment and adhere to child protection policies.</li>
                </ul>

                <h2>5. Monitoring and Evaluation</h2>
                <ul>
                    <li>Students' performance during the work immersion will be monitored, and feedback will be provided to ensure that learning objectives are met.</li>
                    <li>Students may be required to submit a report or presentation summarizing their work experience.</li>
                </ul>

                <h2>6. Termination of Agreement</h2>
                <ul>
                    <li>Either party (student or employer) may terminate the work immersion agreement with proper notice, as outlined in the terms of the agreement signed at the start of the immersion.</li>
                </ul>

                <h2>Legal Framework</h2>
                <p>The registration and operation of DRDSNHS are guided by Republic Act No. 10917, which amends the Special Program for Employment of Students (SPES). This law outlines the rights of student workers, the responsibilities of employers, and the necessary conditions for student employment in the Philippines.</p>
            </div>
            <div class="container__nav">
                <footer>
                    <p>By adhering to these terms, students can ensure a productive and legally compliant work immersion experience through DRDSNHS.</p>
                </footer>

            </div>
        </section>
    </main>



</body>


</html>