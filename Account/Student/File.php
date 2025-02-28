<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
;
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/session_handler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';

$student_id = $_SESSION['user_id'];
$firstName = $_SESSION['first_name'];
$middleName = $_SESSION['middle_name'];
$lastName = $_SESSION['last_name'];
$school = $_SESSION['school'];
$gradeLevel = $_SESSION['grade_level'];
$strand = strtoupper($_SESSION['strand']);
// $stars = $_SESSION['stars'];
$currentWork = $_SESSION['current_work'];
$email = $_SESSION['email'];
$profile_image = ($_SESSION['profile_image'] === './uploads/') ? './image/default.png' : $_SESSION['profile_image'];
$cover_image = ($_SESSION['cover_image'] === './uploads/') ? './image/logov3.jpg' : $_SESSION['cover_image'];


$profile_divv = '<header class="nav-header">
        <div class="logo">
            <a href="Company_Area.php"> 
                <img src="image/drdsnhs.svg" alt="Logo">
            </a>
         
            
        </div>
        <nav class="by">

 
 <div class="menu">
  <div class="item">
    <a class="link">
      <span class="firstname"> <span class="username">Welcome </span> ' . $firstName . ' </span>
      <svg viewBox="0 0 360 360" xml:space="preserve">
        <g id="SVGRepo_iconCarrier">
          <path
            id="XMLID_225_"
            d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393 s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"
          ></path>
        </g>
      </svg>
    </a>
    <div class="submenu">

      <a class="logout"  href="' . '/backend/php/logout.php' . '">
      
      <div class="submenu-item ">
       Log out
      
      </div>
      
      </a>
    
     
    </div>
  </div>
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
  <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
  <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/Jh2v0t5W/W.png"> -->
  <title>Verification</title>
  <link rel="stylesheet" href="css/File.css">

  <style>
  </style>
</head>

<body>

  <?php echo $profile_divv; ?>


  <div class="row">
    <div class="column">
      <div class="container">
        <div class="card">
          <h3>Resume
            <?php if (isDocumentUploaded("resume")): ?>
              <div class="check-icon"></div>
            <?php endif; ?>
          </h3>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="drop_box">
              <header>
                <h4>Select Files here</h4>
              </header>
              <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
              <input type="file" name="resume_files[]" accept=".doc,.docx,.pdf,.txt,.png,.jpg" id="Resume" multiple
                hidden>
              <button type="button" class="btn" onclick="document.getElementById('Resume').click();">Choose
                Files</button>
              <button type="submit" style="margin-top:10px;" class="btn">Upload Files</button>
            </div>
            <ul class="file-list"></ul>
          </form>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="container">
        <div class="card">
          <h3>Application Letter
            <?php if (isDocumentUploaded("application_letter")): ?>
              <div class="check-icon"></div>
            <?php endif; ?>

          </h3>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="drop_box">
              <header>
                <h4>Select Files here</h4>
              </header>
              <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
              <input type="file" name="letter_files[]" accept=".doc,.docx,.pdf,.txt,.png,.jpg" id="Letter" multiple
                hidden>
              <button type="button" class="btn" onclick="document.getElementById('Letter').click();">Choose
                Files</button>
              <button type="submit" style="margin-top:10px;" class="btn">Upload Files</button>
            </div>
            <ul class="file-list"></ul>
          </form>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="container">
        <div class="card">
          <h3>Parents Consent
            <?php if (isDocumentUploaded("parents_consent")): ?>
              <div class="check-icon"></div>
            <?php endif; ?>
          </h3>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="drop_box">
              <header>
                <h4>Select Files here</h4>
              </header>
              <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
              <input type="file" name="parents_consent_files[]" accept=".doc,.docx,.pdf" id="Consent" multiple hidden>
              <button type="button" class="btn" onclick="document.getElementById('Consent').click();">Choose
                Files</button>
              <button type="submit" style="margin-top:10px;" class="btn">Upload Files</button>
            </div>
            <ul class="file-list"></ul>
          </form>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="container">
        <div class="card">
          <h3>Barangay Clearance
            <?php if (isDocumentUploaded("barangay_clearance")): ?>
              <div class="check-icon"></div>
            <?php endif; ?>
          </h3>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="drop_box">
              <header>
                <h4>Select Files here</h4>
              </header>
              <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
              <input type="file" name="barangay_clearance_files[]" accept=".doc,.docx,.pdf,.txt,.png,.jpg" id="Brgy"
                multiple hidden>
              <button type="button" class="btn" onclick="document.getElementById('Brgy').click();">Choose
                Files</button>
              <button type="submit" style="margin-top:10px;" class="btn">Upload Files</button>
            </div>
            <ul class="file-list"></ul>
          </form>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="container">
        <div class="card">
          <h3>Mayor's Permit
            <?php if (isDocumentUploaded("mayors_permit")): ?>
              <div class="check-icon"></div>
            <?php endif; ?>
          </h3>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="drop_box">
              <header>
                <h4>Select Files here</h4>
              </header>
              <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
              <input type="file" name="mayor_permit_files[]" hidden accept=".doc,.docx,.pdf,.txt,.png,.jpg" id="Permit"
                multiple>
              <button type="button" class="btn" onclick="document.getElementById('Permit').click();">Choose
                Files</button>
              <button type="submit" style="margin-top:10px;" class="btn">Upload Files</button>
            </div>
            <ul class="file-list"></ul>
          </form>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="container">
        <div class="card">
          <h3>Police Clearance
            <?php if (isDocumentUploaded("police_clearance")): ?>
              <div class="check-icon"></div>
            <?php endif; ?>
          </h3>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="drop_box">
              <header>
                <h4>Select Files here</h4>
              </header>
              <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
              <input type="file" name="police_clearance_files[]" hidden accept=".doc,.docx,.pdf,.txt,.png,.jpg"
                id="Police" multiple>
              <button type="button" class="btn" onclick="document.getElementById('Police').click();">Choose
                Files</button>
              <button type="submit" style="margin-top:10px;" class="btn">Upload Files</button>
            </div>
            <ul class="file-list"></ul>
          </form>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="container">
        <div class="card">
          <h3>Medical Certificate
            <?php if (isDocumentUploaded("medical_certificate")): ?>
              <div class="check-icon"></div>
            <?php endif; ?>
          </h3>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="drop_box">
              <header>
                <h4>Select Files here</h4>
              </header>
              <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
              <input type="file" name="medical_certificate_files[]" accept=".doc,.docx,.pdf,.txt,.png,.jpg" id="Medical"
                multiple hidden>
              <button type="button" class="btn" onclick="document.getElementById('Medical').click();">Choose
                Files</button>
              <button type="submit" style="margin-top:10px;" class="btn">Upload Files</button>
            </div>
            <ul class="file-list"></ul>
          </form>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="container">

        <div class="card">
          <h3>Insurance Policy
            <?php if (isDocumentUploaded("insurance_policy")): ?>
              <div class="check-icon"></div>
            <?php endif; ?>
          </h3>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="drop_box">
              <header>
                <h4>Select Files here</h4>
              </header>
              <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
              <input type="file" name="insurance_policy_files[]" hidden accept=".doc,.docx,.pdf,.txt,.png,.jpg"
                id="Policy" multiple>
              <button type="button" class="btn" onclick="document.getElementById('Policy').click();">Choose
                Files</button>
              <button type="submit" style="margin-top:10px;" class="btn">Upload Files</button>
            </div>
            <ul class="file-list"></ul>
          </form>
        </div>

      </div>
    </div>
  </div>

  <script type="text/javascript">
    const dropBoxes = document.querySelectorAll(".drop_box");


    dropBoxes.forEach(dropBox => {
      const button = dropBox.querySelector("button");
      const input = dropBox.querySelector("input");
      const fileListElement = dropBox.nextElementSibling;
      dropBoxes.forEach(dropBox => {
        const button = dropBox.querySelector("button");
        const input = dropBox.querySelector("input");
        const fileListElement = dropBox.nextElementSibling;

        button.onclick = () => {
          input.click();
        };
        button.onclick = () => {
          input.click();
        };

        input.addEventListener("change", function (e) {
          const files = e.target.files;
          fileListElement.innerHTML = '';


          Array.from(files).forEach(file => {
            let fileItem = document.createElement('li');
            fileItem.innerHTML = `
                    <h4>${file.name}</h4>
                `;
            fileListElement.appendChild(fileItem);
          });
        });
      });
    });
  </script>
</body>

</html>