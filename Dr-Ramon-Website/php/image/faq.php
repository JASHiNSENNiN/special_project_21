<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search Portal</title>
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../css/contact.css">
    <link rel="stylesheet" type="text/css" href="../css/faq.css">

    </head>
<body>

    <header>
         <div class="logo">
            <img src="../logo.jpg" alt="Logo">
            <h1>\</h1>
            <h1>Vorkify</h1>
        </div>
        <nav>
            <a href="./index.php">Home</a>
            <a href="contact.php">Contact</a>
            <a href="aboutUs.php">About Us</a>
            <a href="faq.php">FAQ</a>
            
        </nav>
        <!-- <button class="login-btn">Log In</button> -->
         <div class="css-1ld7x2h eu4oa1w0"></div>
        <button class="login-btn">Log In</button>
    </header>

    <section class="contact-section">
        <h1 style="margin-top: 0px;">FAQ</h1>
    <div class="faq-item">
      <div class="question" onclick="toggleAnswer(1)">1. What is [Your Website/Service] about?</div>
      <div class="answer" id="answer1">[Your answer goes here.]</div>
    </div>

    <div class="faq-item">
      <div class="question" onclick="toggleAnswer(2)">2. How do I [perform a specific action]?</div>
      <div class="answer" id="answer2">[Your answer goes here.]</div>
    </div>
    </section>
    <footer>
        <p>&copy; 2024 Your Website. All rights reserved. | Junior Philippines Computer Society Students</p>
        <p>By using Workify you agrree to new <a href="#"></a></p>
    </footer>

    <!-- JavaScript to display the current date -->
    <script>
        document.getElementById("currentDate").innerHTML = new Date().getFullYear();
    </script>
    <script>
    function toggleAnswer(id) {
      var answer = document.getElementById('answer' + id);
      answer.classList.toggle('active');
    }
  </script>


</body>
</html>