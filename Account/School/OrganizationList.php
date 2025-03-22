<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Dashboard</title>
    <link rel="stylesheet" href="css/orglist.css">


    <style>
    .popup {
        animation: transitionIn-Y-bottom 0.5s;
    }

    .sub-table {
        animation: transitionIn-Y-bottom 0.5s;
    }
    </style>

</head>

<body>
    <svg style="display:none;">




        <symbol id="dashboard" viewBox="0 0 24 24">
            <path
                d="M4 13h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm-1 7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v4zm10 0a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v7zm1-10h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1z" />
        </symbol>


        <symbol id="calendar-btn" viewBox="0 0 448 512">
            <path
                d="M152 64H296V24C296 10.75 306.7 0 320 0C333.3 0 344 10.75 344 24V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H104V24C104 10.75 114.7 0 128 0C141.3 0 152 10.75 152 24V64zM48 448C48 456.8 55.16 464 64 464H384C392.8 464 400 456.8 400 448V192H48V448z" />
        </symbol>

        <symbol id="history" viewBox="0 0 20 21">
            <path
                d="M10.5,0 C7,0 3.9,1.9 2.3,4.8 L0,2.5 L0,9 L6.5,9 L3.7,6.2 C5,3.7 7.5,2 10.5,2 C14.6,2 18,5.4 18,9.5 C18,13.6 14.6,17 10.5,17 C7.2,17 4.5,14.9 3.4,12 L1.3,12 C2.4,16 6.1,19 10.5,19 C15.8,19 20,14.7 20,9.5 C20,4.3 15.7,0 10.5,0 L10.5,0 Z M9,5 L9,10.1 L13.7,12.9 L14.5,11.6 L10.5,9.2 L10.5,5 L9,5 L9,5 Z" />
        </symbol>

        <symbol id="bookmark" viewBox="0 0 96 96">
            <path
                d="M78-.0011H18a5.9965,5.9965,0,0,0-6,6v84a6.0015,6.0015,0,0,0,9.75,4.6875L48,73.6805,74.25,94.6864A6.0015,6.0015,0,0,0,84,89.9989v-84A5.9965,5.9965,0,0,0,78-.0011ZM72,77.5125,51.75,61.3114a6.0134,6.0134,0,0,0-7.5,0L24,77.5125V11.9989H72Z" />
        </symbol>

        <symbol id="logout" viewBox="0 0 24 24">
            <path d="M12,10c1.1,0,2-0.9,2-2V4c0-1.1-0.9-2-2-2s-2,0.9-2,2v4C10,9.1,10.9,10,12,10z" />
            <path
                d="M19.1,4.9L19.1,4.9c-0.3-0.3-0.6-0.4-1.1-0.4c-0.8,0-1.5,0.7-1.5,1.5c0,0.4,0.2,0.8,0.4,1.1l0,0c0,0,0,0,0,0c0,0,0,0,0,0c1.3,1.3,2,3,2,4.9c0,3.9-3.1,7-7,7s-7-3.1-7-7c0-1.9,0.8-3.7,2.1-4.9l0,0C7.3,6.8,7.5,6.4,7.5,6c0-0.8-0.7-1.5-1.5-1.5c-0.4,0-0.8,0.2-1.1,0.4l0,0C3.1,6.7,2,9.2,2,12c0,5.5,4.5,10,10,10s10-4.5,10-10C22,9.2,20.9,6.7,19.1,4.9z" />
        </symbol>

        <symbol id="gallery" viewBox="0 0 24 24">
            <path
                d="M24,6c0-2.2-1.8-4-4-4H4C1.8,2,0,3.8,0,6v12c0,2.2,1.8,4,4,4h16c2.2,0,4-1.8,4-4V6z M6,6c1.1,0,2,0.9,2,2   c0,1.1-0.9,2-2,2S4,9.1,4,8C4,6.9,4.9,6,6,6z M22,18c0,1.1-0.9,2-2,2H4.4c-0.9,0-1.3-1.1-0.7-1.7l3.6-3.6c0.4-0.4,1-0.4,1.4,0   l0.6,0.6c0.4,0.4,1,0.4,1.4,0l6.6-6.6c0.4-0.4,1-0.4,1.4,0l3,3c0.2,0.2,0.3,0.4,0.3,0.7V18z" />
        </symbol>
    </svg>


    <section class="page-content">
        <section class="search-and-user">
            <span class="nav-title">Partner Organization</span>
            <div class="admin-profile">
                <div class="row-date">

                </div>
            </div>
        </section>

        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing:0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td colspan="4" style="padding-top:10px;width:100%;">
                        <p class="heading-main12"
                            style="text-align:left;margin-left:45px;font-size:18px;color:rgb(49, 49, 49)">All
                            Company (<span id="appointment-count">0</span>)</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width:100%;">
                        <center>
                            <table class="filter-container" border="0">
                                <tr>
                                    <!-- <td width="5%" style="text-align:center;">Date:</td>
                                    <td width="30%">
                                        <input type="date" name="scheduledate" id="date"
                                            class="input-text filter-container-items" style="margin:0;width:95%;">
                                    </td> -->
                                    <td width="10%" style="text-align:center;">Company Name:</td>
                                    <td width="30%">
                                        <input type="text" name="clientname" id="clientname"
                                            class="box filter-container-items" style="width:90%;height:37px;margin:0;"
                                            placeholder="Company Name from the list">
                                    </td>
                                    <td width="12%">
                                        <button id="filter-button" class="btn-primary-soft btn button-icon btn-filter"
                                            style="background-image:url('img/icon/filter-iceblue.svg');"> Filter
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0" id="appointments-table">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">Appointment number</th>
                                            <th class="table-headin">Client Name</th>
                                            <th class="table-headin">Category</th>
                                            <th class="table-headin">Session Date & Time</th>
                                            <th class="table-headin">Appointment Date</th>
                                            <th class="table-headin">Status</th>
                                            <th class="table-headin">Events</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-appointment-date="2025-01-02" data-client-name="Russel Requina">
                                            <td style="font-weight:600;">123</td>
                                            <td style="text-align:center;">Russel Requina</td>
                                            <td>Duo</td>
                                            <td style="text-align:center;font-size:12px;">1/2/25 <br>11:00 AM</td>
                                            <td style="text-align:center;">1/2/25</td>
                                            <td><input name="status" type="text" value="Completed" readonly
                                                    style="text-align:center;"></td>
                                            <td>


                                                <div style="display:flex;justify-content:center;">
                                                    <a href="?action=view&id=#" class="non-style-link"><button
                                                            class="btn-primary-soft btn button-icon btn-view"
                                                            style="background-image: url(' img/icon/view-iceblue.svg')">
                                                            <font class="tn-in-text">View</font>
                                                        </button></a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="?action=drop&id=123" class="non-style-link"><button
                                                            class="btn-primary-soft btn button-icon btn-delete"
                                                            style="background-image:url('img/icon/delete-iceblue.svg')">Delete</button></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr data-appointment-date="2025-01-03" data-client-name="Ivan Requina">
                                            <td style="font-weight:600;">124</td>
                                            <td style="text-align:center;">Ivan Requina</td>
                                            <td>Group</td>
                                            <td style="text-align:center;font-size:12px;">1/3/25 <br>11:30 AM</td>
                                            <td style="text-align:center;">1/3/25</td>
                                            <td><input name="status" type="text" value="Cancelled" readonly
                                                    style="text-align:center;"></td>
                                            <td>
                                                <div style="display:flex;justify-content:center;">
                                                    <a href="?action=view&id=#" class="non-style-link"><button
                                                            class="btn-primary-soft btn button-icon btn-view"
                                                            style="background-image: url(' img/icon/view-iceblue.svg')">
                                                            <font class="tn-in-text">View</font>
                                                        </button></a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="?action=drop&id=124" class="non-style-link"><button
                                                            class="btn-primary-soft btn button-icon btn-delete"
                                                            style="background-image:url('img/icon/delete-iceblue.svg')">Delete</button></a>
                                                </div>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                                <p id="no-results" class="heading-main12 no-results">We couldn't find anything related
                                    to your keywords!</p>
                            </div>
                        </center>
                    </td>
                </tr>
            </table>
        </div>


        <?php
        if ($_GET) {
            $action = $_GET["action"];

            if ($action == 'drop') {

                echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="history.php">&times;</a>
                        <div class="content">
                            You want to Delete this record<br>().
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="history.php?id=" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="history.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';
            } elseif ($action == 'view') {

                echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href=" history.php">&times;</a>
                        
                        <div  style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                  josh <br><br>
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                @gmail.com <br><br>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Telephone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                               12312312<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Category: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2"> Duo
                            <br><br>
                            </td>
                            </tr>

                             <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Specialties: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2"> 1/2/25 12:00 PM
                            <br><br>
                            </td>
                            </tr>

                             <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Payment Method: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2"> Gcash
                            <br><br>
                            </td>
                            </tr>



                            <tr>
                                <td colspan="2">
                                    <a href="history.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                
                                    
                                </td>
                
                            </tr>
                           

                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
            }
        }
        ;


        ?>




        <script src="js/search-filter-history.js"></script>

    </section>
</body>

</html>