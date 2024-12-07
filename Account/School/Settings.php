<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once 'show_profile.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School Dashboard</title>
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <link rel="stylesheet" type="text/css" href="css/Settings.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    .img-account-cover {
        width: 100% !important;
        height: 200px !important;
        object-fit: cover !important;
        vertical-align: middle !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .img-account-profile {
        height: 10rem;
    }

    .form-control {
        display: block;
        width: 100%;
        padding: -0.125rem 1.125rem;
        font-size: 0.875rem;
        font-weight: 400;
        line-height: 1;
        color: #69707a;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #c5ccd6;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0.35rem;
        transition:
            border-color 0.15s ease-in-out,
            box-shadow 0.15s ease-in-out;
    }

    .col-xl-4,
    .col-xl-8 {
        width: 100% !important;
        margin-top: 20px !important;
    }

    .mb-5 {
        margin-top: 0.5rem !important;
        margin-bottom: 2rem !important;
    }

    .container {
        width: 70% !important;
    }

    .list-group-item {
        margin-left: 10px !important;
    }

    .form-group {
        margin-right: 20px !important;
        margin-left: 20px !important;
    }

    .list-group-item.active {
        z-index: 2 !important;
        color: #fff !important;
        background-color: #18613b !important;
        border-color: #18613b !important;
    }

    .list-group-item:hover {
        color: #fff !important;
        background-color: #104d2d !important;
        border-color: #104d2d !important;
    }

    .btn-primary {
        color: #fff !important;
        background-color: #18613b !important;
        border-color: #18613b !important;
    }

    .btn-primary:hover {
        color: #fff !important;
        background-color: #104d2d !important;
        border-color: #104d2d !important;
    }

    .mt-3 {
        margin-bottom: 35px !important;
    }

    .nav-borders .nav-link.active {
        color: #0061f2;
        border-bottom-color: #0061f2;
    }

    .nav-borders .nav-link {
        color: #69707a;
        border-bottom-width: 0.125rem;
        border-bottom-style: solid;
        border-bottom-color: transparent;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        padding-left: 0;
        padding-right: 0;
        margin-left: 1rem;
        margin-right: 1rem;
    }
</style>

<body>

    <noscript>
        <style>
            html {
                display: none;
            }
        </style>
        <meta http-equiv="refresh" content="0.0;url=message.php">
    </noscript>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="container mt-5">
            <div class="alert alert-danger">Please log in to access this page.</div>
        </div>
    <?php else: ?>

        <div class="home-content">
            <div class="container light-style flex-grow-1 container-p-y">
                <h4 class="font-weight-bold py-3 mb-4">Account settings</h4>
                <div class="card overflow-hidden">
                    <div class="row no-gutters row-bordered row-border-light">
                        <div class="col-md-3 pt-0">
                            <div class="list-group list-group-flush account-settings-links">
                                <!-- <a class="list-group-item list-group-item-action active" data-toggle="list"
                                href="#account-general">General</a> -->

                                <a class="list-group-item list-group-item-action" data-toggle="list"
                                    href="#account-info">Personal Details</a>
                                <a class="list-group-item list-group-item-action" data-toggle="list"
                                    href="#account-change-password">Change password</a>

                                <!-- <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-social-links">Social links</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-connections">Connections</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-notifications">Notifications</a> -->
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content">
                                <!-- <div class="tab-pane fade active show" id="account-general">
                                <hr class="border-light m-0" />
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control mb-1">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">President</label>
                                        <input type="text" class="form-control" placeholder="" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Name of School</label>
                                        <input type="text" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Telephone # / Phone #</label>
                                        <input type="number" class="form-control" placeholder="#" min="0" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div> -->
                                <div class="tab-pane fade " id="account-change-password">
                                    <div class="card-body pb-2">
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control mb-1" placeholder="@gmail.com" />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Current password</label>
                                            <input type="password" class="form-control" placeholder="Current password" />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">New password</label>
                                            <input type="password" class="form-control" placeholder="New password" />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Repeat new password</label>
                                            <input type="password" class="form-control" placeholder="Repeat new password" />
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade active show" id="account-info">
                                    <!-- <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Bio</label>
                                        <textarea class="form-control" rows="5"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Country</label>
                                        <select class="custom-select">
                                            <option>USA</option>
                                            <option selected>Philippines</option>
                                            <option>UK</option>
                                            <option>Germany</option>
                                            <option>France</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="border-light m-0" />
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Contacts</h6>
                                    <div class="form-group">
                                        <label class="form-label">Website</label>
                                        <input type="text" class="form-control" value />
                                    </div>
                                </div> -->

                                    <div class="container-xl px-4 mt-4">
                                        <div class="row row1">
                                            <div class="col-xl-4">

                                                <div class="card mb-4 mb-5 mb-xl-0">
                                                    <div class="card-header">Cover Picture </div>

                                                    <div class="card-body text-center">

                                                        <img class="img-account-cover  mb-2" id="profile-image-cover"
                                                            src="https://i.postimg.cc/c454Lh9J/bg.png" alt>

                                                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                                        <form id="image-upload-form">
                                                            <input type="file" id="image-upload-cover" style="display: none;">
                                                            <label for="image-upload" class="btn btn-primary">Upload new image</label>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="card mb-4 mb-xl-0">
                                                    <div class="card-header">Profile Picture </div>

                                                    <div class="card-body text-center">

                                                        <img class="img-account-profile rounded-circle mb-2" id="profile-image"
                                                            src="https://i.postimg.cc/LXTmK3g2/Default.png" alt>

                                                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                                        <form id="image-upload-form">
                                                            <input type="file" id="image-upload" style="display: none;">
                                                            <label for="image-upload" class="btn btn-primary">Upload new image</label>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="card mb-4">
                                                    <div class="card-header">Account Details</div>
                                                    <div class="card-body">
                                                        <form id="edit-profile-form">
                                                            <!-- <div class="row gx-3 mb-3">
                                                            <div class="col-md-6">
                                                                <label class="small mb-1" for="inputFirstName">First name</label>
                                                                <input class="form-control" id="inputFirstName" name="first_name" type="text"
                                                                    value="<?php echo htmlspecialchars($profile_data['first_name'] ?? ''); ?>"
                                                                    required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="small mb-1" for="inputMiddleName">Middle name</label>
                                                                <input class="form-control" id="inputMiddleName" name="middle_name" type="text"
                                                                    value="<?php echo htmlspecialchars($profile_data['middle_name'] ?? ''); ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="small mb-1" for="inputLastName">Last name</label>
                                                                <input class="form-control" id="inputLastName" name="last_name" type="text"
                                                                    value="<?php echo htmlspecialchars($profile_data['last_name'] ?? ''); ?>"
                                                                    required>
                                                            </div>
                                                        </div> -->
                                                            <div class="row gx-3 mb-3">
                                                                <div class="col-md-6">

                                                                    <div class="container4">
                                                                        <label class="small mb-1" for="inputSchool">School name</label>
                                                                        <input class="form-control" id="inputSchoolName" name="SchoolName" type="text"
                                                                            value=""
                                                                            required>
                                                                        <!-- <form class="form-control" action="/submit" method="post">
                                                                            <select class="form-control" id="student" name="student"
                                                                            <?php echo htmlspecialchars($profile_data['school'] ?? ''); ?> required>
                                                                            <option value="" disabled selected>Select a School</option>
                                                                            <option value="OLSHCO">OLSHCO</option>
                                                                            <option value="National">Dr Ramon</option>
                                                                            <option value="CATMAN">CATMAN</option>
                                                                            <option value="WCC">WCC</option>
                                                                            <option value="CRT">CRT</option>
                                                                        </select>
                                                                            <label class="StudentLabel" for="student">Choose a Strand:</label>
                        <select class="StudentSelect" id="student" name="student" required>
                            <option value="" disabled selected>Select a student</option>
                            <option value="HUMSS">HUMSS</option>
                            <option value="STEM">STEM</option>
                            <option value="GAS">GAS</option>
                            <option value="TECHVOC">TECHVOC</option>
                        </select>

                                                                            <button type="submit" class="submit-btn"><i class='fas fa-user-plus'
                                                    style='margin-right:10px;'></i>Add
                                                Student</button>
                                                                        </form> -->
                                                                    </div>

                                                                    <!-- <input class="form-control" id="inputSchool" name="school" type="text"
                                        value="<?php echo htmlspecialchars($profile_data['school'] ?? ''); ?>" required> -->
                                                                </div>



                                                                <div class="col-md-6">
                                                                    <label class="small mb-1" for="inputStrand">Strand</label>
                                                                    <select class="form-control" id="inputStrand" name="strand" required>
                                                                        <?php
                                                                        $strands = ['stem' => 'STEM', 'humss' => 'HUMSS', 'abm' => 'ABM', 'gas' => 'GAS', 'tvl' => 'TVL'];
                                                                        foreach ($strands as $value => $label) {
                                                                            $selected = ($profile_data['strand'] ?? '') === $value ? 'selected' : '';
                                                                            echo "<option value=\"$value\" $selected>$label</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>



                                                                <div class="col-md-6">
                                                                    <label class="small mb-1" for="inputSchool">Location</label>
                                                                    <input class="form-control" id="inputLocation" name="Location" type="text"
                                                                        value=""
                                                                        required>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="small mb-1" for="inputSchool">Phone number</label>
                                                                    <input class="form-control" id="inputLocation" name="Location" type="text"
                                                                        value=""
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <!-- <button class="btn btn-primary" type="submit">Save changes</button> -->
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>




                                <div class="tab-pane fade" id="account-social-links">
                                    <div class="card-body pb-2">
                                        <div class="form-group">
                                            <label class="form-label">Twitter</label>
                                            <input type="text" class="form-control" value="https://twitter.com/user" />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Facebook</label>
                                            <input type="text" class="form-control" value="https://www.facebook.com/user" />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Google+</label>
                                            <input type="text" class="form-control" value />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Instagram</label>
                                            <input type="text" class="form-control"
                                                value="https://www.instagram.com/user" />
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="account-connections">
                                    <div class="card-body">
                                        <button type="button" class="btn btn-twitter" style="font-size: 15px">
                                            Connect to <strong>Twitter</strong>
                                        </button>
                                    </div>
                                    <hr class="border-light m-0" />
                                    <div class="card-body">
                                        <h5 class="mb-2" style="font-size: 15px">
                                            <a href="javascript:void(0)" class="float-right text-muted text-tiny"
                                                style="font-size: 15px"><i class="ion ion-md-close"></i> Remove</a>
                                            <i class="ion ion-logo-google text-google"></i>
                                            You are connected to Google:
                                        </h5>
                                        <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                            data-cfemail="f9979498818e9c9595b994989095d79a9694">[email&#160;protected]</a>
                                    </div>
                                    <hr class="border-light m-0" />
                                    <div class="card-body">
                                        <button type="button" class="btn btn-facebook" style="font-size: 15px">
                                            Connect to <strong>Facebook</strong>
                                        </button>
                                    </div>
                                    <hr class="border-light m-0" />
                                    <div class="card-body">
                                        <button type="button" class="btn btn-instagram" style="font-size: 15px">
                                            Connect to <strong>Instagram</strong>
                                        </button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="account-notifications">
                                    <div class="card-body pb-2">
                                        <h6 class="mb-4">Activity</h6>
                                        <div class="form-group">
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher-input" checked />
                                                <span class="switcher-indicator">
                                                    <span class="switcher-yes"></span>
                                                    <span class="switcher-no"></span>
                                                </span>
                                                <span class="switcher-label">When someone Send a Feedback </span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher-input" checked />
                                                <span class="switcher-indicator">
                                                    <span class="switcher-yes"></span>
                                                    <span class="switcher-no"></span>
                                                </span>
                                                <span class="switcher-label">When someone send a report</span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher-input" />
                                                <span class="switcher-indicator">
                                                    <span class="switcher-yes"></span>
                                                    <span class="switcher-no"></span>
                                                </span>
                                                <span class="switcher-label">When someone follows </span>
                                            </label>
                                        </div>
                                    </div>
                                    <hr class="border-light m-0" />
                                    <div class="card-body pb-2">
                                        <h6 class="mb-4">Application</h6>
                                        <div class="form-group">
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher-input" checked />
                                                <span class="switcher-indicator">
                                                    <span class="switcher-yes"></span>
                                                    <span class="switcher-no"></span>
                                                </span>
                                                <span class="switcher-label">News and announcements</span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher-input" />
                                                <span class="switcher-indicator">
                                                    <span class="switcher-yes"></span>
                                                    <span class="switcher-no"></span>
                                                </span>
                                                <span class="switcher-label">Weekly product updates</span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher-input" checked />
                                                <span class="switcher-indicator">
                                                    <span class="switcher-yes"></span>
                                                    <span class="switcher-no"></span>
                                                </span>
                                                <span class="switcher-label">Weekly blog digest</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-3">
                    <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
                    <a href="Student.php"><button type="button" class="btn btn-default">Cancel</button></a>
                </div>
            </div>
        </div>

        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            let profilePic = document.getElementById("profile-pic");
            let inputfile = document.getElementById("input-file");
            inputfile.onchange = function() {
                profilePic.src = URL.createObjectURL(inputfile.files[0]);
            }
        </script>
    <?php endif; ?>
</body>

</html>