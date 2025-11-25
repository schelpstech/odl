<?php
// Load PDO connector (expects $pdo). If connect.php defines $conn, we'll alias it.
require_once "../connect.php";

if (!isset($pdo)) {
    if (isset($conn) && $conn instanceof PDO) {
        $pdo = $conn;
    } else {
        //Helpful debug message — in production you might want to log instead.
        throw new RuntimeException('No PDO instance found. Ensure connect.php defines $pdo or $conn.');
    }
}
// Check user login
if (!isset($_SESSION['unamed'])) {
    header('Location: ../index.php');
    exit();
}
?>  
    <!doctype html>
    <html class="no-js" lang="">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Dashboard - Learn at Home</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- favicon
		============================================ -->
        <link rel="shortcut icon" type="image/x-icon" href="http://rabbischools.com.ng/press/wp-content/uploads/2020/04/icon.jpg">
        <!-- Google Fonts
		============================================ -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
        <!-- Bootstrap CSS
		============================================ -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- font awesome CSS
		============================================ -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- owl.carousel CSS
		============================================ -->
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/owl.theme.css">
        <link rel="stylesheet" href="css/owl.transitions.css">
        <!-- meanmenu CSS
		============================================ -->
        <link rel="stylesheet" href="css/meanmenu/meanmenu.min.css">
        <!-- animate CSS
		============================================ -->
        <link rel="stylesheet" href="css/animate.css">
        <!-- normalize CSS
		============================================ -->
        <link rel="stylesheet" href="css/normalize.css">
        <!-- wave CSS
		============================================ -->
        <link rel="stylesheet" href="css/wave/waves.min.css">
        <link rel="stylesheet" href="css/wave/button.css">
        <!-- mCustomScrollbar CSS
		============================================ -->
        <link rel="stylesheet" href="css/scrollbar/jquery.mCustomScrollbar.min.css">
        <!-- Notika icon CSS
		============================================ -->
        <link rel="stylesheet" href="css/notika-custom-icon.css">
        <!-- Data Table JS
		============================================ -->
        <link rel="stylesheet" href="css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
        <!-- main CSS
		============================================ -->
        <link rel="stylesheet" href="css/main.css">
        <!-- style CSS
		============================================ -->
        <link rel="stylesheet" href="style.css">
        <!-- responsive CSS
		============================================ -->
        <link rel="stylesheet" href="css/responsive.css">
        <!-- modernizr JS
		============================================ -->
        <script src="js/html2pdf.bundle.min.js"></script>


        <script>
            function generatePDF() {
                // Choose the element that our invoice is rendered in.
                const element = document.getElementById("doc");
                // Choose the element and save the PDF for our user.
                html2pdf()
                    .set({
                        html2canvas: {
                            scale: 4
                        }
                    })
                    .from(element)
                    .save();


            }
        </script>
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>

        <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
        <script>
            function getclass() {
                var str = '';
                var val = document.getElementById('class-list');
                for (i = 0; i < val.length; i++) {
                    if (val[i].selected) {
                        str += val[i].value + ',';
                    }
                }
                var str = str.slice(0, str.length - 1);

                $.ajax({
                    type: "GET",
                    url: "get_state.php",
                    data: 'class_id=' + str,
                    success: function(data) {
                        $("#sbj-list").html(data);
                    }
                });
            }
        </script>
    </head>

    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Start Header Top Area -->
        <div class="header-top-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="logo-area">
                            <a href="#"><img src="img/logo/logo.png" alt="" /></a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

                    </div>
                </div>
            </div>
        </div>

        <div class="mobile-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="mobile-menu">
                            <nav id="dropdown">
                                <ul class="mobile-menu-nav">

                                    <li><a data-toggle="collapse" data-target="#dash" href="#"></i> Dashboard</a>
                                        <ul id="dash" class="collapse dropdown-header-top">
                                            <li><a href="dashboard.php">Overview</a></li>
                                            <li><a href="profile.php">School Profile </a></li>

                                        </ul>
                                    </li>
                                    <li><a href="mgstaff.php"><i class="notika-icon notika-refresh"></i> Staff</a>
                                    </li>
                                    <li><a data-toggle="collapse" data-target="#learner" href="#">Registry</a>
                                        <ul id="learner" class="collapse dropdown-header-top">
                                            <li><a href="mglearners.php">Manage Learners</a></li>
                                            <li><a href="mgterm.php">Configure Academic Term </a></li>
                                            <li><a href="mgconfig.php">Configure Results </a></li>
                                            <li><a href="mgcalendar.php">Semester Calendar </a></li>
                                            <li><a href="mgresult.php">Manage Academic Records </a></li>
                                            <li><a href="mgaffective.php">Manage Affective Domain </a></li>
                                            <li><a href="mgmid.php">Mid Term Results </a></li>
                                            <li><a href="mgreport.php">Academic Results </a></li>
                                            <li><a href="promote.php">Promote Learners</a></li>
                                            <li><a href="../learn/app/do_backup.php">System Backup</a></li>


                                        </ul>
                                    </li>

                                    <li><a data-toggle="collapse" data-target="#burs" href="#">Bursary</a>
                                        <ul id="burs" class="collapse dropdown-header-top">
                                            <li><a href="mgfee.php">Manage Fees</a></li>
                                            <li><a href="assignfee.php">Assign Fees</a></li>
                                            <li><a href="mgdiscount.php">Manage Discount</a></li>
                                            <li><a href="payrecord.php">Payment Records</a></li>
                                            <li><a href="payreport.php">Class Payment Report</a></li>
                                            <li><a href="payview.php">Class Payments View</a></li>
                                        </ul>
                                    </li>

                                    <li><a data-toggle="collapse" data-target="#classdet" href="#">Program Manager</a>
                                        <ul id="classdet" class="collapse dropdown-header-top">
                                            <li><a href="program_mgr.php">Manage Programmes</a></li>
                                            <li><a href="course_mgr.php">Manage Course</a></li>
                                            <li><a href="allocate.php">Course Allocation</a></li>

                                        </ul>
                                    </li>

                                    <li><a data-toggle="collapse" data-target="#learnd" href="#">Learning Resources</a>
                                        <ul id="learnd" class="collapse dropdown-header-top">
                                            <li><a href="mglesson.php">Manage Learning Resources </a></li>
                                            <li><a href="filedash.php">Learning Resources Dashboard</a></li>

                                        </ul>
                                    </li>



                                    <li>
                                        <form method="post" action="logout.php"> <button name="log"> <i
                                                    class="notika-icon notika-close"></i> Log Out</button></form>
                                    </li>

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Menu end -->
        <!-- Main Menu area start-->
        <div class="main-menu-area mg-tb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">

                            <li><a data-toggle="tab" href="#dashd"><i class="notika-icon notika-windows"></i>Dashboard</a>
                            </li>
                            <li><a href="mgstaff.php"><i class="notika-icon notika-refresh"></i> Staff</a>
                            </li>

                            <li><a data-toggle="tab" href="#learn"><i class="notika-icon notika-form"></i>Registry</a>
                            </li>

                            <li><a data-toggle="tab" href="#bursar"><i class="notika-icon notika-form"></i>Bursary</a>
                            </li>


                            <li><a data-toggle="tab" href="#Charts"><i class="notika-icon notika-app"></i> Program Manager</a>
                            </li>
                            <li><a data-toggle="tab" href="#learndash"><i class="notika-icon notika-app"></i> Learning
                                    Resources</a>
                            </li>

                            <li>
                                <form method="post" action="logout.php"> <button name="log"> <i
                                            class="notika-icon notika-close"></i> Log Out</button></form>
                            </li>
                        </ul>
                        <div class="tab-content custom-menu-content">

                            <div id="dashd" class="tab-pane in notika-tab-menu-bg animated flipInX">
                                <ul class="notika-main-menu-dropdown">
                                    <li><a href="dashboard.php">Overview</a></li>
                                    <li><a href="profile.php">School Profile </a></li>

                                </ul>
                            </div>
                            <div id="bursar" class="tab-pane in notika-tab-menu-bg animated flipInX">
                                <ul class="notika-main-menu-dropdown">
                                    <li><a href="mgfee.php">Manage Fees</a></li>
                                    <li><a href="assignfee.php">Assign Fees</a></li>
                                    <li><a href="mgdiscount.php">Manage Discount</a></li>
                                    <li><a href="payrecord.php">Payment Records</a></li>
                                    <li><a href="payreport.php">Class Payment Report</a></li>
                                    <li><a href="payview.php">Class Payments View</a></li>

                                </ul>
                            </div>
                            <div id="Charts" class="tab-pane in notika-tab-menu-bg animated flipInX">
                                <ul class="notika-main-menu-dropdown">
                                    <li><a href="program_mgr.php">Manage Programmes</a></li>
                                    <li><a href="course_mgr.php">Manage Course</a></li>
                                    <li><a href="allocate.php">Course Allocation</a></li>

                                </ul>
                            </div>
                            <div id="learn" class="tab-pane in notika-tab-menu-bg animated flipInX">
                                <ul class="notika-main-menu-dropdown">
                                    <li><a href="mglearners.php">Manage Learners</a></li>
                                    <li><a href="mgterm.php">Configure Academic Term </a></li>
                                    <li><a href="mgconfig.php">Configure Results </a></li>
                                    <li><a href="mgcalendar.php">Semester Calendar </a></li>
                                    <li><a href="mgresult.php">Manage Academic Records </a></li>
                                    <li><a href="mgaffective.php">Manage Affective Domain </a></li>
                                    <li><a href="mgmid.php">Mid Term Results </a></li>
                                    <li><a href="mgreport.php">Academic Results </a></li>
                                    <li><a href="promote.php">Promote Learners</a></li>
                                    <li><a href="../learn/app/do_backup.php">System Backup</a></li>
                                </ul>
                            </div>
                            <div id="learndash" class="tab-pane in notika-tab-menu-bg animated flipInX">
                                <ul class="notika-main-menu-dropdown">
                                    <li><a href="mglesson.php">Manage Learning Resources</a></li>
                                    <li><a href="filedash.php">Learning Resources Dashboard</a></li>


                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>