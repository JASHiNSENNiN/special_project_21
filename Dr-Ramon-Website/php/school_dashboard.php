<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> School Dashboard </title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" type="text/css" href="../css/school_dashboard.css">
    <link rel="stylesheet" href="../css/profile_settings.css">
    <!-- <link rel="stylesheet" type="text/css" href="../css/school_dashboard.css"> -->
    <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet '>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>


<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <div class="sidebar">
        <div class="logo-details">

            <a href="#" class="active" style='text-decoration:none'>
                <i>
                    <!-- <img src="image/logov3.jpg" alt="Logo" height="11.5%" width="100%"
                        styl="margin-left:5px; margin-top:15px;"> -->
                </i>

            </a>
            <!-- <span class="logo_name" id="logo_name" style="color:#fff; margin-left: 80px;">Workify</span>f   -->

        </div>
        <br>
        <ul class="nav-links">
            <li>
                <a href="#" class="link" id="#dash">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="link" id="#student">
                    <i class='bx bxs-graduation'></i>
                    <span class="links_name">Student</span>
                </a>
            </li>
            <li>
                <a href="#" class="link" id="#company">
                    <i class='bx bx-building'></i>
                    <span class="links_name">Company</span>
                </a>
            </li>
            <li>
                <a href="#" class="link" id="#reports">
                    <i class='bx bxs-report'></i>
                    <span class="links_name">Reports</span>
                </a>
            </li>
            <li>
                <a href="#" class="link" id="#analytics">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="links_name">Analytics</span>
                </a>
                </a>
            </li>

            <li>
                <a href="#" class="link" id="#setting">
                    <i class='bx bx-cog'></i>
                    <span class="links_name">Setting</span>
                </a>
            </li>
            <li class="log_out">
                <a href="#">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn' onclick="toggle();"></i>
                <span class="dashboard"></span>
                <span class="dashboard"> </span>
                <span class="dashboard"><img src="image/logov3.jpg" alt="Logo" height="11%" width="50%"
                        styl="margin-left:5px; margin-top:15px;"></span>
                <!-- <div class="logo">
            <img src="../logo.jpg" alt="Logo">
            <h1>\</h1>
            <h1>Vorkify</h1>
        </div> -->
            </div>
            <!-- <div class="search-box">
                <input type="text" placeholder="Search...">
                <i class='bx bx-search'></i>
            </div> -->

            <div class="profile-details">
                <img src="image/OLSHCO.png" alt="">
                <span class="admin_name">OLSHCO</span>
                <i class='bx bx-chevron-down'></i>
            </div>
        </nav>



        <div class="home-content">


            <div id="content_container">
                <div id="dash" class="content active">

                    <div class="home-content">
                        <div class="overview-boxes" style="padding: 0px;">
                            <div class="box" style="width: 50%;">
                                <div class="box-topic">Strand</div>
                            </div>
                        </div>

                        <div class="overview-boxes">
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">HUMMS</div>
                                    <div class="number">100</div>
                                    <div class="indicator">
                                        <i class='bx bx-up-arrow-alt'></i>
                                        <span class="text">Up from yesterday</span>
                                    </div>
                                </div>
                                <!-- <i class='bx bx-cart-alt cart'></i> -->
                            </div>
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">GAS</div>
                                    <div class="number">150</div>
                                    <div class="indicator">
                                        <i class='bx bx-up-arrow-alt'></i>
                                        <span class="text">Up from yesterday</span>
                                    </div>
                                </div>
                                <!-- <i class='bx bxs-cart-add cart two' ></i> -->
                            </div>
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">STEM</div>
                                    <div class="number">160</div>
                                    <div class="indicator">
                                        <i class='bx bx-up-arrow-alt'></i>
                                        <span class="text">Up from yesterday</span>
                                    </div>
                                </div>
                                <!-- <i class='bx bx-cart cart three' ></i> -->
                            </div>
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">TECHVOC</div>
                                    <div class="number">170</div>
                                    <div class="indicator">
                                        <i class='bx bx-down-arrow-alt down'></i>
                                        <span class="text">Down From Today</span>
                                    </div>
                                </div>
                                <!-- <i class='bx bxs-cart-download cart four' ></i> -->
                            </div>
                        </div>


                        <div class="sales-boxes">
                            <div class="recent-sales box">
                                <div class="charts" style="margin-top: 20px">

                                    <div class="charts-card">
                                        <div class="chart-title" style="font-size: 20px;
font-weight: 500; margin-bottom:10px;">Popularity Company </div>

                                        <!-- <div id="area-chart" style="width: auto; height: auto;" ></div> -->
                                        <div id="chart_div2" class="chart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="top-sales box">
                                <div class="charts-card">
                                    <div class="chart-title" style="font-size: 20px;
font-weight: 500; margin-bottom:10px;">Top Company </div>

                                    <!-- <div id="bar-chart"></div> -->
                                    <div id="chart_div1" class="chart"></div>

                                </div>

                            </div>
                        </div>
                    </div>


                </div>


                <div id="student" class="content active">

                    <div class="home-content ">

                        <div class="overview-boxes" style="padding: 0px;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm">
                                        <!-- <h4 class="font-weight-bold py-3 mb-4">
                                            Strand
                                        </h4> -->
                                        <div class="box" style="width: auto; ">
                                            Strand
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <!-- One of three columnss -->
                                    </div>
                                    <div class="col-sm">

                                        <div class="search-box">
                                            <input type="text" placeholder="Search...">
                                            <i class='bx bx-search'></i>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

                        <div class="overview-boxes">
                            <div class="box" id="#humss">
                                <div class="right-side">
                                    <div class="box-topic">HUMSS</div>
                                    <div class="number">100</div>
                                    <div class="indicator">
                                        <!-- <i class='bx bx-up-arrow-alt'></i> -->
                                        <span class="text">Total of Student</span>
                                    </div>

                                </div>
                                <i class='bx bxs-graduation'
                                    style="margin-top: 20px; margin-left: 20px; color:#333A73; font-size:3em; "></i>
                            </div>

                            <div class="box" id="#gas">
                                <div class="right-side">
                                    <div class="box-topic">GAS</div>
                                    <div class="number">150</div>
                                    <div class="indicator">
                                        <!-- <i class='bx bx-up-arrow-alt'></i> -->
                                        <span class="text">Total of Student</span>
                                    </div>
                                </div>
                                <i class='bx bxs-graduation'
                                    style="margin-top: 20px; margin-left: 20px; color:#387ADF; font-size:3em; "></i>
                            </div>
                            <div class="box" id="#stem">
                                <div class="right-side">
                                    <div class="box-topic">STEM</div>
                                    <div class="number">160</div>
                                    <div class="indicator">
                                        <!-- <i class='bx bx-up-arrow-alt'></i> -->
                                        <span class="text">Total of Student</span>
                                    </div>
                                </div>
                                <i class='bx bxs-graduation'
                                    style="margin-top: 20px; margin-left: 20px; color:#50C4ED; font-size:3em; "></i>
                            </div>
                            <div class="box" id="#techvoc">
                                <div class="right-side">
                                    <div class="box-topic">TECHVOC</div>
                                    <div class="number">170</div>
                                    <div class="indicator">
                                        <!-- <i class='bx bx-down-arrow-alt down'></i> -->
                                        <span class="text">Total of Student</span>
                                    </div>
                                </div>
                                <i class='bx bxs-graduation'
                                    style="margin-top: 20px; margin-left: 20px; color:#40679E; font-size:3em; "></i>
                            </div>

                        </div>

                        <div id="content_container">
                            <div id="humss" class="contents">

                                <div class="sales-boxes">
                                    <div class="recent-sales box" style="width: 100%; margin-bottom:20px;">
                                        <div class="title">
                                            <h3>Student List: HUMSS</h3>
                                        </div>

                                        <table style="width:100%">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Company</th>
                                                <th>Status</th>
                                                <th>Start Date</th>
                                                <th>Start End</th>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Joshua Rivera</td>
                                                <td>NIA</td>
                                                <td>Deployed</td>
                                                <td>01/02/24</td>
                                                <td>02/02/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Ivan Diaz</td>
                                                <td>PNP</td>
                                                <td>Deployed</td>
                                                <td>01/02/24</td>
                                                <td>02/02/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Angel Diaz</td>
                                                <td>Municipal</td>
                                                <td>Pending</td>
                                                <td>00/00/00</td>
                                                <td>00/00/00</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Alex Doe</td>
                                                <td>LTO</td>
                                                <td>Deployed</td>
                                                <td>03/22/24</td>
                                                <td>04/22/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div id="gas" class="contents active">
                                <div class="sales-boxes">
                                    <div class="recent-sales" style="width: 100%; margin-bottom:20px;">
                                        <div class="title">
                                            <h3>Student List: GAS</h3>
                                        </div>
                                        <table style="width:100%">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Company</th>
                                                <th>Status</th>
                                                <th>Start Date</th>
                                                <th>Start End</th>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Joshua Rivera</td>
                                                <td>Bank</td>
                                                <td>Deployed</td>
                                                <td>01/02/24</td>
                                                <td>02/02/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Ivan Diaz</td>
                                                <td>Finance</td>
                                                <td>Deployed</td>
                                                <td>01/02/24</td>
                                                <td>02/02/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Angel Diaz</td>
                                                <td>BDO</td>
                                                <td>Pending</td>
                                                <td>00/00/00</td>
                                                <td>00/00/00</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Alex Doe</td>
                                                <td>Land Bank</td>
                                                <td>Deployed</td>
                                                <td>03/22/24</td>
                                                <td>04/22/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div id="stem" class="contents active">
                                <div class="sales-boxes">
                                    <div class="recent-sales" style="width: 100%; margin-bottom:20px;">
                                        <div class="title">
                                            <h3>Student List: STEM</h3>
                                        </div>
                                        <table style="width:100%">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Company</th>
                                                <th>Status</th>
                                                <th>Start Date</th>
                                                <th>Start End</th>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Joshua Rivera</td>
                                                <td>NIA</td>
                                                <td>Deployed</td>
                                                <td>01/02/24</td>
                                                <td>02/02/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Ivan Diaz</td>
                                                <td>PNP</td>
                                                <td>Deployed</td>
                                                <td>01/02/24</td>
                                                <td>02/02/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Angel Diaz</td>
                                                <td>Municipal</td>
                                                <td>Pending</td>
                                                <td>00/00/00</td>
                                                <td>00/00/00</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Alex Doe</td>
                                                <td>LTO</td>
                                                <td>Deployed</td>
                                                <td>03/22/24</td>
                                                <td>04/22/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>

                            <div id="techvoc" class="contents active">
                                <div class="sales-boxes">
                                    <div class="recent-sales" style="width: 100%; margin-bottom:20px;">
                                        <div class="title">
                                            <h3>Student List: TECHVOC</h3>
                                        </div>
                                        <table style="width:100%">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Company</th>
                                                <th>Status</th>
                                                <th>Start Date</th>
                                                <th>Start End</th>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Joshua Rivera</td>
                                                <td>Deped</td>
                                                <td>Deployed</td>
                                                <td>01/02/24</td>
                                                <td>02/02/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Ivan Diaz</td>
                                                <td>IT</td>
                                                <td>Deployed</td>
                                                <td>01/02/24</td>
                                                <td>02/02/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Angel Diaz</td>
                                                <td>Developer</td>
                                                <td>Pending</td>
                                                <td>00/00/00</td>
                                                <td>00/00/00</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Alex Doe</td>
                                                <td>Assistant</td>
                                                <td>Deployed</td>
                                                <td>03/22/24</td>
                                                <td>04/22/24</td>
                                                <!-- <td><button type="button" class="btn btn-success">Apply</button>
                                                    <button type="button" class="btn btn-primary">Details</button>
                                                </td> -->

                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>


                        </div>

                    </div>


                </div>
                <div id="company" class="content active">
                    <div class="container">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                    <!-- One of three columns -->
                                </div>
                                <div class="col-sm">
                                    <div class="search-box">
                                        <input type="text" placeholder="Search..."
                                            style="margin-top:50px; width:100%; ">
                                        <i class='bx bx-search' style="top:62%;"></i>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <!-- One of three columns -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <div class="mobile-wrapper">
                                    <article class="job-card">
                                        <div class="company-logo-img">
                                            <img src="image/NIA.png" />
                                        </div>
                                        <div class="job-title">The National Irrigation Administration</div>
                                        <!-- <div class="company-name">Hays</div> -->
                                        <div class="skills-container">
                                            <div class="skill">Planter</div>
                                            <div class="skill">Assistant</div>
                                            <div class="skill">Computer</div>
                                        </div>
                                        <div class="btn-container">
                                            <button class="apply">Delete</button>
                                            <button class="save">Details</button>
                                        </div>
                                        <a href="#"></a>
                                    </article>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="mobile-wrapper">
                                    <article class="job-card">
                                        <div class="company-logo-img">
                                            <img src="image/Jollibee.png" />
                                        </div>
                                        <div class="job-title">Jollibee</div>
                                        <!-- <div class="company-name">Hays</div> -->
                                        <div class="skills-container">
                                            <div class="skill">Crew</div>
                                            <div class="skill">Assistant</div>
                                            <div class="skill">Guard</div>
                                        </div>
                                        <div class="btn-container">
                                            <button class="apply">Delete</button>
                                            <button class="save">Details</button>
                                        </div>
                                        <a href="#"></a>
                                    </article>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="mobile-wrapper">
                                    <article class="job-card">
                                        <div class="company-logo-img">
                                            <img src="image/landbank.jpg" />
                                        </div>
                                        <div class="job-title">LANBANK</div>
                                        <div class="skills-container">
                                            <div class="skill">Bookkeeper</div>
                                            <div class="skill">Assistant</div>
                                            <div class="skill">IT specialist</div>
                                        </div>
                                        <div class="btn-container">
                                            <button class="apply">Delete</button>
                                            <button class="save">Details</button>
                                        </div>
                                        <a href="#"></a>
                                    </article>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <div id="reports" class="content active">
                    <div class="sales-boxes">
                        <div class="recent-sales box" style="width: 100%; margin-top:50px">
                            <div class="title">
                                <h3>Reports</h3>
                            </div>

                            <table style="width:100%">
                                <tr>
                                    <th>#</th>
                                    <th>Company </th>
                                    <th>Student ID</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>NIA</td>
                                    <td>2024-17</td>
                                    <td>
                                        <button type="button" class="btn btn-primary">Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jollibee</td>
                                    <td>2024-18</td>
                                    <td>
                                        <button type="button" class="btn btn-primary">Details</button>
                                    </td>

                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>PNP</td>
                                    <td>2024-19</td>
                                    <td>
                                        <button type="button" class="btn btn-primary">Details</button>
                                    </td>

                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Minicipal</td>
                                    <td>2024-20</td>
                                    <td>
                                        <button type="button" class="btn btn-primary">Details</button>
                                    </td>

                                </tr>
                            </table>
                        </div>

                    </div>

                </div>
                <div id="analytics" class="content active">

                    <div class="sales-boxes">
                        <div class="recent-sales box" style="margin-top: 50px;">
                            <div class="charts" style="margin-top: 20px">

                                <div class="charts-card">
                                    <div class="chart-title" style="font-size: 20px;
font-weight: 500; margin-bottom:10px;">Popularity Company </div>

                                    <!-- <div id="area-chart" style="width: auto; height: auto;" ></div> -->
                                    <div id="chart_div2" class="chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="top-sales box">
                            <div class="charts-card">
                                <div class="chart-title" style="font-size: 20px;
font-weight: 500; margin-bottom:10px;">Top Company </div>

                                <!-- <div id="bar-chart"></div> -->
                                <div id="chart_div1" class="chart"></div>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="setting" class="content">

                    <div class="home-content">
                        <div class="container light-style flex-grow-1 container-p-y">
                            <h4 class="font-weight-bold py-3 mb-4">
                                Account settings
                            </h4>
                            <div class="card overflow-hidden">
                                <div class="row no-gutters row-bordered row-border-light">
                                    <div class="col-md-3 pt-0">
                                        <div class="list-group list-group-flush account-settings-links">
                                            <a class="list-group-item list-group-item-action active" data-toggle="list"
                                                href="#account-general">General</a>
                                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                                href="#account-change-password">Change password</a>
                                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                                href="#account-info">Info</a>
                                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                                href="#account-social-links">Social links</a>
                                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                                href="#account-connections">Connections</a>
                                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                                href="#account-notifications">Notifications</a>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="account-general">
                                                <div class="card-body media align-items-center">
                                                    <img src="image/profile.jpg" alt="profile" id="profile-pic"
                                                        class="d-block ui-w-80"
                                                        style="border-radius:50%; height:150px;  width : 160px !important;">
                                                    <div class="media-body ml-4">
                                                        <label class="btn btn-outline-primary">
                                                            Upload new photo
                                                            <input type="file" class="account-settings-fileinput"
                                                                accept="image/jpeg, image/png, image/jpg"
                                                                id="input-file">
                                                        </label> &nbsp;
                                                        <button type="button"
                                                            class="btn btn-default md-btn-flat">Reset</button>
                                                        <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max
                                                            size
                                                            of 800K</div>
                                                    </div>
                                                </div>
                                                <hr class="border-light m-0">
                                                <div class="card-body">
                                                    <!-- <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control mb-1" >
                                </div> -->
                                                    <div class="form-group">
                                                        <label class="form-label">Name of School</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">E-mail</label>
                                                        <input type="text" class="form-control mb-1"
                                                            placeholder="@gmail.com">
                                                        <div class="alert alert-warning mt-3">
                                                            Your email is not confirmed. Please check your inbox.<br>
                                                            <a href="javascript:void(0)">Resend confirmation</a>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="form-group">
                                                    <label class="form-label">Company</label>
                                                    <input type="text" class="form-control">
                                                </div> -->
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="account-change-password">
                                                <div class="card-body pb-2">
                                                    <div class="form-group">
                                                        <label class="form-label">Current password</label>
                                                        <input type="password" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">New password</label>
                                                        <input type="password" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Repeat new password</label>
                                                        <input type="password" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="account-info">
                                                <div class="card-body pb-2">
                                                    <div class="form-group">
                                                        <label class="form-label">Bio</label>
                                                        <textarea class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Birthday</label>
                                                        <input type="text" class="form-control">
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
                                                <hr class="border-light m-0">
                                                <div class="card-body pb-2">
                                                    <h6 class="mb-4">Contacts</h6>
                                                    <div class="form-group">
                                                        <label class="form-label">Phone</label>
                                                        <input type="text" class="form-control"
                                                            value="+0 (123) 456 7891">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Website</label>
                                                        <input type="text" class="form-control" value>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="account-social-links">
                                                <div class="card-body pb-2">
                                                    <div class="form-group">
                                                        <label class="form-label">Twitter</label>
                                                        <input type="text" class="form-control"
                                                            value="https://twitter.com/user">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Facebook</label>
                                                        <input type="text" class="form-control"
                                                            value="https://www.facebook.com/user">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Google+</label>
                                                        <input type="text" class="form-control" value>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">LinkedIn</label>
                                                        <input type="text" class="form-control" value>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Instagram</label>
                                                        <input type="text" class="form-control"
                                                            value="https://www.instagram.com/user">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="account-connections">
                                                <div class="card-body">
                                                    <button type="button" class="btn btn-twitter"
                                                        style="font-size: 15px;">Connect to
                                                        <strong>Twitter</strong></button>
                                                </div>
                                                <hr class="border-light m-0">
                                                <div class="card-body">
                                                    <h5 class="mb-2" style="font-size: 15px;">
                                                        <a href="javascript:void(0)"
                                                            class="float-right text-muted text-tiny"
                                                            style="font-size: 15px;"><i class="ion ion-md-close"></i>
                                                            Remove</a>
                                                        <i class="ion ion-logo-google text-google"></i>
                                                        You are connected to Google:
                                                    </h5>
                                                    <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                        data-cfemail="f9979498818e9c9595b994989095d79a9694">[email&#160;protected]</a>
                                                </div>
                                                <hr class="border-light m-0">
                                                <div class="card-body">
                                                    <button type="button" class="btn btn-facebook"
                                                        style="font-size: 15px;">Connect to
                                                        <strong>Facebook</strong></button>
                                                </div>
                                                <hr class="border-light m-0">
                                                <div class="card-body">
                                                    <button type="button" class="btn btn-instagram"
                                                        style="font-size: 15px;">Connect to
                                                        <strong>Instagram</strong></button>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="account-notifications">
                                                <div class="card-body pb-2">
                                                    <h6 class="mb-4">Activity</h6>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input" checked>
                                                            <span class="switcher-indicator">
                                                                <span class="switcher-yes"></span>
                                                                <span class="switcher-no"></span>
                                                            </span>
                                                            <span class="switcher-label">Email me when someone comments
                                                                on
                                                                my article</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input" checked>
                                                            <span class="switcher-indicator">
                                                                <span class="switcher-yes"></span>
                                                                <span class="switcher-no"></span>
                                                            </span>
                                                            <span class="switcher-label">Email me when someone answers
                                                                on my
                                                                forum
                                                                thread</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input">
                                                            <span class="switcher-indicator">
                                                                <span class="switcher-yes"></span>
                                                                <span class="switcher-no"></span>
                                                            </span>
                                                            <span class="switcher-label">Email me when someone follows
                                                                me</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <hr class="border-light m-0">
                                                <div class="card-body pb-2">
                                                    <h6 class="mb-4">Application</h6>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input" checked>
                                                            <span class="switcher-indicator">
                                                                <span class="switcher-yes"></span>
                                                                <span class="switcher-no"></span>
                                                            </span>
                                                            <span class="switcher-label">News and announcements</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input">
                                                            <span class="switcher-indicator">
                                                                <span class="switcher-yes"></span>
                                                                <span class="switcher-no"></span>
                                                            </span>
                                                            <span class="switcher-label">Weekly product updates</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="switcher">
                                                            <input type="checkbox" class="switcher-input" checked>
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
                                <button type="button" class="btn btn-default">Cancel</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        </div>


    </section>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
            sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else
            sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }
    </script>
    <script>
    let toggle = () => {

        let element = document.getElementById("logo_name");
        let hidden = element.getAttribute("hidden");

        if (hidden) {
            element.removeAttribute("hidden");
        } else {
            element.setAttribute("hidden", "hidden");
        }
    }
    </script>
    <script type="text/javascript" src=" ../js/analytics_school_dashboard.js"></script>

    <script>
    $(".link").click(function(e) {
        e.preventDefault();
        $(".content").removeClass("active");
        var content_id = $(this).attr("id");
        $(content_id).addClass("active");
    });
    </script>

    <script>
    $(".box").click(function(e) {
        e.preventDefault();
        $(".contents").removeClass("active");
        var content_id = $(this).attr("id");
        $(content_id).addClass("active");
    });
    </script>

    <script>
    let profilePic = document.getElementById("profile-pic");
    let inputfile = document.getElementById("input-file");
    inputfile.onchange = function() {
        profilePic.src = URL.createObjectURL(inputfile.files[0]);
    }
    </script>
    <script src="../js/chart.js"></script>

</body>

</html>