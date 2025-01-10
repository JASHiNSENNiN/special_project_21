<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="css/edit_profile.css">
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <!-- -------------font--------- -->
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet'>

</head>

<body>
    <div class="container-xl px-4 mt-4">
        <nav class="nav nav-borders">
            <a class="nav-link active ms-0" href="#">Edit Profile</a>

        </nav>

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
                        <form action="your_action_url_here" method="POST">

                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputOrgName">Organization name</label>
                                    <input class="form-control" id="inputOrgName" name="organization_name" type="text"
                                        autocomplete="off" placeholder="Enter your organization name">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLocation">Location</label>
                                    <input class="form-control" id="inputLocation" name="location" type text
                                        placeholder="Enter your location">
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                    <input class="form-control" id="inputEmailAddress" name="email" type="email"
                                        placeholder="Enter your email address">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Phone number</label>
                                    <input class="form-control" id="inputPhone" name="phone" type="tel"
                                        autocomplete="off" placeholder="Enter your phone number">
                                </div>

                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">Bio</label>
                                <textarea name="message" placeholder="Enter your message"></textarea>

                            </div>
                            <button class="btn btn-primary" type="submit">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Function profile selected image
        document.getElementById('image-upload').addEventListener('change', function(event) {
            const selectedImage = event.target.files[0];
            const profileImage = document.getElementById('profile-image');

            if (selectedImage) {
                const reader = new FileReader();

                reader.onload = function() {
                    profileImage.src = reader.result;
                };

                reader.readAsDataURL(selectedImage);
            }
        });

        document.getElementById('image-upload-cover').addEventListener('change', function(event) {
            const selectedImage = event.target.files[0];
            const profileImage = document.getElementById('profile-image-cover');

            if (selectedImage) {
                const reader = new FileReader();

                reader.onload = function() {
                    profileImage.src = reader.result;
                };

                reader.readAsDataURL(selectedImage);
            }
        });
    </script>
</body>

</html>