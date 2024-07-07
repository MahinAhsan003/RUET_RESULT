<?php
session_start();
error_reporting(0);
include ('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

    if (isset($_POST['register'])) {
        $studentId = $_SESSION['alogin']; // Assuming student ID is stored in session
        $semester = $_POST['semester'];
        $registeredCourses = implode(",", $_POST['selected_courses']);
        $sql = "INSERT INTO tblregistration (StudentId, RegisteredCourses, Semester, RegistrationStatus) VALUES (:studentId, :registeredCourses, :semester, 1)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentId', $studentId, PDO::PARAM_STR);
        $query->bindParam(':registeredCourses', $registeredCourses, PDO::PARAM_STR);
        $query->bindParam(':semester', $semester, PDO::PARAM_STR);
        $query->execute();
        $msg = "Registration successful!";

    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Manage Students</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen">
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            /* Added margin to create gap between the filter button and the table */
            .filter-form {
                margin-bottom: 20px;
            }
        </style>
    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include ('includes/topbar.php'); ?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">
                    <div class="left-sidebar bg-black-300 box-shadow">
                        <div class="sidebar-content">
                            <div class="user-info closed">
                                <img src="http://placehold.it/90/c2c2c2?text=User" alt="John Doe"
                                    class="img-circle profile-img">
                                <h6 class="title">Student Dashboard</h6>
                            </div>

                            <div class="sidebar-nav">
                                <ul class="side-nav color-gray">
                                    <li class="nav-header">
                                        <span class="">Main Category</span>
                                    </li>
                                    <li>
                                        <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>

                                    </li>

                                    <li class="nav-header">
                                        <span class="">Appearance</span>
                                    </li>
                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-file-text"></i> <span>Course Management</span> <i
                                                class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="#"><i class="fa fa-bars"></i> <span>Course
                                                        Registration Notice</span></a></li>
                                            <li><a href="course-registration.php"><i class="fa fa fa-server"></i>
                                                    <span>Course Registration</span></a></li>
                                            <li><a href="#"><i class="fa fa fa-server"></i> <span>Form Fill Up</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-file-text"></i> <span>Backlog</span> <i
                                                class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="#"><i class="fa fa-bars"></i> <span>Backlog Form Fill Up</span></a>
                                            </li>
                                            <li><a href="#"><i class="fa fa fa-server"></i> <span>Backlog Course
                                                        Registration</span></a></li>
                                        </ul>
                                    </li>

                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-file-text"></i> <span>Short Semester</span> <i
                                                class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="#"><i class="fa fa-bars"></i> <span>Short Semester Form Fill
                                                        Up</span></a></li>
                                            <li><a href="#"><i class="fa fa fa-server"></i> <span>Short Semester Course
                                                        Registration</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-file-text"></i> <span>Result</span> <i
                                                class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="result.php"><i class="fa fa-bars"></i> <span>Check
                                                        Result</span></a></li>
                                        </ul>
                                    </li>

                                    <li><a href="change-password.php"><i class="fa fa fa-server"></i> <span> Student Change
                                                Password</span></a>
                                    </li>

                            </div>
                        </div>
                    </div>

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Course Registration</h2>
                                </div>
                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li>Course Management</li>
                                        <li class="active">Course Registration</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <section class="section">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>View Registration Info</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body p-20">
                                                <?php if ($msg) { ?>
                                                    <div class="succWrap"><strong>SUCCESS</strong>:
                                                        <?php echo htmlentities($msg); ?>
                                                    </div>
                                                <?php } ?>
                                                <form method="post" action="" class="filter-form">
                                                    <div class="form-group">
                                                        <label for="department">Department</label>
                                                        <select name="department" id="department" class="form-control">
                                                            <option value="">Select Department</option>
                                                            <?php
                                                            $sql = "SELECT DISTINCT Department FROM tblclasses";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) { ?>
                                                                    <option
                                                                        value="<?php echo htmlentities($result->Department); ?>">
                                                                        <?php echo htmlentities($result->Department); ?>
                                                                    </option>
                                                                <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="semester">Semester</label>
                                                        <select name="semester" id="semester" class="form-control">
                                                            <option value="">Select Semester</option>
                                                            <?php
                                                            $sql = "SELECT DISTINCT Semester FROM tblclasses";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) { ?>
                                                                    <option value="<?php echo htmlentities($result->Semester); ?>">
                                                                        <?php echo htmlentities($result->Semester); ?>
                                                                    </option>
                                                                <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                    <button type="submit" name="filter"
                                                        class="btn btn-primary">Filter</button>
                                                </form>

                                                <form method="post" action="">
                                                    <table id="example" class="display table table-striped table-bordered"
                                                        cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Course Name</th>
                                                                <th>Course Code</th>
                                                                <th>Course Credit</th>
                                                                <th>Fee</th>
                                                                <th>Select</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            if (isset($_POST['filter'])) {
                                                                $department = $_POST['department'];
                                                                $semester = $_POST['semester'];
                                                                $sql = "SELECT CourseName, CourseCode, CourseCredit, Department, Semester FROM tblsubjects WHERE 1=1";
                                                                if ($department != "") {
                                                                    $sql .= " AND Department=:department";
                                                                }
                                                                if ($semester != "") {
                                                                    $sql .= " AND Semester=:semester";
                                                                }
                                                                $sql .= " ORDER BY id"; // Sort by RollId
                                                                $query = $dbh->prepare($sql);
                                                                if ($department != "") {
                                                                    $query->bindParam(':department', $department, PDO::PARAM_STR);
                                                                }
                                                                if ($semester != "") {
                                                                    $query->bindParam(':semester', $semester, PDO::PARAM_STR);
                                                                }
                                                                $query->execute();
                                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            } else {
                                                                $results = [];
                                                            }
                                                            $cnt = 1;
                                                            if (count($results) > 0) {
                                                                foreach ($results as $result) { ?>
                                                                    <tr>
                                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                                        <td><?php echo htmlentities($result->CourseName); ?></td>
                                                                        <td><?php echo htmlentities($result->CourseCode); ?></td>
                                                                        <td><?php echo htmlentities($result->CourseCredit); ?></td>
                                                                        <td><?php echo htmlentities($result->CourseCredit * 20); ?>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" name="selected_courses[]"
                                                                                value="<?php echo htmlentities($result->CourseCode); ?>">
                                                                        </td>
                                                                        <td>
                                                                            <a href="edit-student.php?stid=<?php echo htmlentities($result->id); ?>"
                                                                                class="btn btn-primary btn-xs"
                                                                                target="_blank">Edit</a>
                                                                            <a href="edit-result.php?stid=<?php echo htmlentities($result->id); ?>"
                                                                                class="btn btn-warning btn-xs" target="_blank">View
                                                                                Result</a>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $cnt++;
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                    <input type="hidden" name="semester"
                                                        value="<?php echo htmlentities($semester); ?>">
                                                    <button type="submit" name="register"
                                                        class="btn btn-success">Register</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script sr c="js/lobipanel/lobipanel.min.js"></script>
          <scr   ipt src=" js/iscroll/iscroll.js">
               </sc ript>
                <script src="js/prism/prism.js"></script>
            <script src="js/DataTables/datatables.min.js"></script>
            <script src="js/main.js"></script>
            <script>
            $(function($) {
                $('#example').DataTable();
            });
            </script>
    </body>

    </html>
<?php } ?>