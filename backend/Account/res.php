<!DOCTYPE html>
<html>

<head>
    <title>Progressive Form | Multi Steps Form</title>
    <link rel="stylesheet" type="text/css" href="res.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>

    <div class="wrapper">
        <div class="header1">
            <ul>
                <li class="active form_1_progessbar">
                    <div>
                        <p>1</p>
                    </div>
                    <h6>Personal Details</h6>
                </li>
                <li class="form_2_progessbar">
                    <div>
                        <p>2</p>
                    </div>
                    <h6>Upload File</h6>
                </li>
                <!-- <li class="form_3_progessbar">
                    <div>
                        <p>3</p>
                    </div>
                    <h6>Upload File</h6>
                </li> -->

            </ul>
        </div>
        <div class="form_wrap">
            <div class="form_1 data_info">
                <h2>Signup Info</h2>
                <form>
                    <div class="form_container">
                        <input value="" type="text" placeholder="School Name" id="school-name" name="school-name">
                        <input value="" type="number" placeholder="LRN" id="input-lrn" name="input-lrn">
                        <input value="" type="text" placeholder="First Name" id="first-name" name="first-name">
                        <input value="" type="text" placeholder="Middle Name" id="middle-name" name="middle-name">
                        <input value="" type="text" placeholder="Last Name" id="last-name" name="last-name">
                        <select name="grade-level" id="grade-level">
                            <option value class="null-type">Grade Level:</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <select name="strand" id="strand">
                            <option value="" selected disabled hidden class="null-type">Strand:</option>
                            <option value="STEM">STEM</option>
                            <option value="HUMSS">HUMSS</option>
                            <option value="ABM">ABM</option>
                            <option value="GAS">GAS</option>
                            <option value="TVL">TVL</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="form_2 data_info" style="display: none;">
                <h2>Upload Files</h2>
                <form>
                    <div class="container">
                        <div class="card">
                            <!-- <h3>Upload Files</h3> -->
                            <div class="drop_box">
                                <header>
                                    <h4>Select Files here</h4>
                                </header>
                                <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
                                <input type="file" hidden accept=".doc,.docx,.pdf,.txt,.png,.jpg" id="fileID" multiple>
                                <div class="btn">Choose Files</div>
                            </div>
                            <ul class="file-list"></ul>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="form_3 data_info" style="display: none;">
                <h2>Upload Files</h2>
                <form>
                    <div class="container">
                        <div class="card">
                            <h3>Upload Files</h3>
                            <div class="drop_box">
                                <header>
                                    <h4>Select Files here</h4>
                                </header>
                                <p>PDF, DOC, DOCX, TXT, JPG, PNG</p>
                                <input type="file" hidden accept=".doc,.docx,.pdf,.txt,.png,.jpg" id="fileID" multiple>
                                <div class="btn">Choose Files</div>
                            </div>
                            <ul class="file-list"></ul>
                        </div>
                    </div>
                </form>
            </div> -->
            <!--  <div class="form_4 data_info" style="display: none;">
                <h2>Professional Info</h2>
                <form>
                    <div class="form_container">
                        <div class="input_wrap">
                            <label for="company">Current Company</label>
                            <input type="text" name="Current Company" class="input" id="company">
                        </div>
                        <div class="input_wrap">
                            <label for="experience">Total Experience</label>
                            <input type="text" name="Total Experience" class="input" id="experience">
                        </div>
                        <div class="input_wrap">
                            <label for="designation">Designation</label>
                            <input type="text" name="Designation" class="input" id="designation">
                        </div>
                    </div>
                </form>
            </div> -->
        </div>
        <div class="btns_wrap">
            <div class="common_btns form_1_btns">
                <button type="button" class="btn_next">Next <span class="icon">
                        <ion-icon name="arrow-forward-sharp"></ion-icon>
                    </span></button>
            </div>
            <div class="common_btns form_2_btns" style="display: none;">
                <button type="button" class="btn_back"><span class="icon">
                        <ion-icon name="arrow-back-sharp"></ion-icon>
                    </span>Back</button>
                <button type="button" class="btn_done">Done</button>
            </div>
            <!-- <div class="common_btns form_3_btns" style="display: none;">
                <button type="button" class="btn_back"><span class="icon">
                        <ion-icon name="arrow-back-sharp"></ion-icon>
                    </span>Back</button>
                <button type="button" class="btn_done">Done</button>
            </div> -->
            <!-- <div class="common_btns form_4_btns" style="display: none;">
                <button type="button" class="btn_back"><span class="icon">
                        <ion-icon name="arrow-back-sharp"></ion-icon>
                    </span>Back</button>
                <button type="button" class="btn_done">Done</button>
            </div> -->

        </div>
    </div>

    <div class="modal_wrapper">
        <div class="shadow"></div>
        <div class="success_wrap">
            <span class="modal_icon">
                <ion-icon name="checkmark-sharp"></ion-icon>
            </span>
            <p>You have successfully completed the process.</p>
        </div>
    </div>



    <script type="text/javascript">
        const dropArea = document.querySelector(".drop_box"),
            button = dropArea.querySelector(".btn"),
            dragText = dropArea.querySelector("header"),
            input = dropArea.querySelector("input");
        let files = [];

        button.onclick = () => {
            input.click();
        };

        input.addEventListener("change", function(e) {
            files = e.target.files; // Get the selected files
            const fileListElement = document.querySelector(".file-list");
            fileListElement.innerHTML = ''; // Clear the previous file list

            // Display each selected file
            Array.from(files).forEach(file => {
                let fileItem = document.createElement('li');
                fileItem.innerHTML = `
            <h4>${file.name}</h4>
            <form action="" method="post">
                <div class="form">
                    <input type="email" placeholder="Enter email to upload file">
                        <button class="btn">Upload</button>
                </div>
            </form>
    `;
                fileListElement.appendChild(fileItem);
            });
        });
    </script>

    <script>
        var form_1 = document.querySelector(".form_1");
        var form_2 = document.querySelector(".form_2");
        // var form_3 = document.querySelector(".form_3");
        // var form_4 = document.querySelector(".form_4");

        var form_1_btns = document.querySelector(".form_1_btns");
        var form_2_btns = document.querySelector(".form_2_btns");
        // var form_3_btns = document.querySelector(".form_3_btns");
        // var form_4_btns = document.querySelector(".form_4_btns");

        var form_1_next_btn = document.querySelector(".form_1_btns .btn_next");
        var form_2_back_btn = document.querySelector(".form_2_btns .btn_back");
        // var form_2_next_btn = document.querySelector(".form_2_btns .btn_next");
        // var form_3_back_btn = document.querySelector(".form_3_btns .btn_back");
        // var form_3_next_btn = document.querySelector(".form_3_btns .btn_next");
        // var form_4_back_btn = document.querySelector(".form_4_btns .btn_back");

        var form_2_progessbar = document.querySelector(".form_2_progessbar");
        // var form_3_progessbar = document.querySelector(".form_3_progessbar");
        // var form_4_progessbar = document.querySelector(".form_4_progessbar");

        var btn_done = document.querySelector(".btn_done");
        var modal_wrapper = document.querySelector(".modal_wrapper");
        var shadow = document.querySelector(".shadow");

        form_1_next_btn.addEventListener("click", function() {
            form_1.style.display = "none";
            form_2.style.display = "block";

            form_1_btns.style.display = "none";
            form_2_btns.style.display = "flex";

            form_2_progessbar.classList.add("active");
        });

        form_2_back_btn.addEventListener("click", function() {
            form_1.style.display = "block";
            form_2.style.display = "none";

            form_1_btns.style.display = "flex";
            form_2_btns.style.display = "none";

            form_2_progessbar.classList.remove("active");
        });


        btn_done.addEventListener("click", function() {
            modal_wrapper.classList.add("active");
        });

        shadow.addEventListener("click", function() {
            modal_wrapper.classList.remove("active");
        });
    </script>

</body>

</html>