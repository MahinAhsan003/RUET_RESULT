<?php
session_start();
error_reporting(0);
include ('includes/config.php');
if (strlen($_SESSION['tlogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $marks = array();
        $class = $_POST['class'];
        $studentid = $_POST['studentid'];
        $mark = $_POST['marks'];

        $stmt = $dbh->prepare("SELECT tblsubjects.SubjectName,tblsubjects.id FROM tblsubjectcombination JOIN tblsubjects ON tblsubjects.id = tblsubjectcombination.SubjectId WHERE tblsubjectcombination.ClassId = :cid ORDER BY tblsubjects.SubjectName");
        $stmt->execute(array(':cid' => $class));
        $sid1 = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($sid1, $row['id']);
        }

        for ($i = 0; $i < count($mark); $i++) {
            $mar = $mark[$i];
            $sid = $sid1[$i];
            $sql = "INSERT INTO tblresult(StudentId,ClassId,SubjectId,marks) VALUES(:studentid, :class, :sid, :marks)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
            $query->bindParam(':class', $class, PDO::PARAM_STR);
            $query->bindParam(':sid', $sid, PDO::PARAM_STR);
            $query->bindParam(':marks', $mar, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $msg = "Result info added successfully";
            } else {
                $error = "Something went wrong. Please try again";
            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMS Admin| Add Result </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen">
        <link rel="stylesheet" href="css/select2/select2.min.css">
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
        <script>
            $(document).ready(function () {
                // Populate Series based on Department
                $('#department').change(function () {
                    var department = $(this).val();
                    if (department) {
                        $.ajax({
                            type: 'POST',
                            url: 'getSeries.php',
                            data: 'departmentId=' + department,
                            success: function (html) {
                                $('#series').html(html);
                                $('#section').html('<option value="">Select Section</option>');
                                $('#semester').html('<option value="">Select Semester</option>');
                                $('#course').html('<option value="">Select Course</option>');
                                $('#student').html('<option value="">Select Student</option>');
                            }
                        });
                    } else {
                        $('#series').html('<option value="">Select Series</option>');
                        $('#section').html('<option value="">Select Section</option>');
                        $('#semester').html('<option value="">Select Semester</option>');
                        $('#course').html('<option value="">Select Course</option>');
                        $('#student').html('<option value="">Select Student</option>');
                    }
                });

                // Populate Section based on Series
                $('#series').change(function () {
                    var series = $(this).val();
                    if (series) {
                        $.ajax({
                            type: 'POST',
                            url: 'getSections.php',
                            data: 'seriesId=' + series,
                            success: function (html) {
                                $('#section').html(html);
                                $('#semester').html('<option value="">Select Semester</option>');
                                $('#course').html('<option value="">Select Course</option>');
                                $('#student').html('<option value="">Select Student</option>');
                            }
                        });
                    } else {
                        $('#section').html('<option value="">Select Section</option>');
                        $('#semester').html('<option value="">Select Semester</option>');
                        $('#course').html('<option value="">Select Course</option>');
                        $('#student').html('<option value="">Select Student</option>');
                    }
                });

                // Populate Semester based on Section
                $('#section').change(function () {
                    var section = $(this).val();
                    if (section) {
                        $.ajax({
                            type: 'POST',
                            url: 'getSemesters.php',
                            data: 'sectionId=' + section,
                            success: function (html) {
                                $('#semester').html(html);
                                $('#course').html('<option value="">Select Course</option>');
                                $('#student').html('<option value="">Select Student</option>');
                            }
                        });
                    } else {
                        $('#semester').html('<option value="">Select Semester</option>');
                        $('#course').html('<option value="">Select Course</option>');
                        $('#student').html('<option value="">Select Student</option>');
                    }
                });

                // Populate Courses based on Semester
                $('#semester').change(function () {
                    var semester = $(this).val();
                    var department = $('#department').val();
                    if (semester && department) {
                        $.ajax({
                            type: 'POST',
                            url: 'getCourses.php',
                            data: {
                                semesterId: semester,
                                departmentId: department
                            },
                            success: function (html) {
                                $('#course').html(html);
                                $('#student').html('<option value="">Select Student</option>');
                            }
                        });
                    } else {
                        $('#course').html('<option value="">Select Course</option>');
                        $('#student').html('<option value="">Select Student</option>');
                    }
                });

                // Populate Students based on Department, Series, Section, and Semester
                $('#course').change(function () {
                    var semester = $('#semester').val();
                    var department = $('#department').val();
                    var series = $('#series').val();
                    var section = $('#section').val();
                    if (semester && department && series && section) {
                        $.ajax({
                            type: 'POST',
                            url: 'getStudents.php',
                            data: {
                                semesterId: semester,
                                departmentId: department,
                                seriesId: series,
                                sectionId: section
                            },
                            success: function (html) {
                                $('#student').html(html);
                            }
                        });
                    } else {
                        $('#student').html('<option value="">Select Student</option>');
                    }
                });

                // Show/Hide Marks Section based on Course Credit
                $('#course').change(function () {
                    var course = $(this).val();
                    if (course) {
                        $.ajax({
                            type: 'POST',
                            url: 'getCourseCredit.php',
                            data: 'courseId=' + course,
                            success: function (credit) {
                                if (credit >= 3) {
                                    $('#marksSection').show();
                                    $('#theoryMarks').show();
                                    $('#sessionalMarks').hide();
                                } else {
                                    $('#marksSection').show();
                                    $('#theoryMarks').hide();
                                    $('#sessionalMarks').show();
                                }
                            }
                        });
                    } else {
                        $('#marksSection').hide();
                    }
                });
            });
        </script>

    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include ('includes/topbar.php'); ?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                    <?php include ('includes/leftbar.php'); ?>
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Declare Result</h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>

                                        <li class="active">Student Result</li>
                                    </ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">

                                        <div class="panel-body">
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                                </div><?php } else if ($error) { ?>
                                                    <div class="alert alert-danger left-icon-alert" role="alert">
                                                        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                    </div>
                                            <?php } ?>
                                            <form class="form-horizontal" method="post">

                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Department</label>
                                                    <div class="col-sm-10">
                                                        <select name="department" class="form-control" id="department"
                                                            required="required">
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
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Series</label>
                                                    <div class="col-sm-10">
                                                        <select name="series" class="form-control" id="series"
                                                            required="required">
                                                            <option value="">Select Series</option>
                                                            <?php
                                                            $sql = "SELECT DISTINCT Series FROM tblclasses";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) { ?>
                                                                    <option value="<?php echo htmlentities($result->Series); ?>">
                                                                        <?php echo htmlentities($result->Series); ?>
                                                                    </option>
                                                                <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Section</label>
                                                    <div class="col-sm-10">
                                                        <select name="section" class="form-control" id="section"
                                                            required="required">
                                                            <option value="">Select Section</option>
                                                            <?php
                                                            $sql = "SELECT DISTINCT Section FROM tblclasses";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) { ?>
                                                                    <option value="<?php echo htmlentities($result->Section); ?>">
                                                                        <?php echo htmlentities($result->Section); ?>
                                                                    </option>
                                                                <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Semester</label>
                                                    <div class="col-sm-10">
                                                        <select name="semester" class="form-control" id="semester"
                                                            required="required">
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
                                                </div>


                                                <div class="form-group">
                                                    <label for="course" class="col-sm-2 control-label">Course</label>
                                                    <div class="col-sm-10">
                                                        <select name="course" class="form-control" id="course"
                                                            required="required">
                                                            <option value="">Select Course</option>
                                                            <?php
                                                            $sql = "SELECT DISTINCT CourseName FROM tblsubjects";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) { ?>
                                                                    <option
                                                                        value="<?php echo htmlentities($result->CourseName); ?>">
                                                                        <?php echo htmlentities($result->CourseName); ?>
                                                                    </option>
                                                                <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="date" class="col-sm-2 control-label ">Student Name</label>
                                                    <div class="col-sm-10">
                                                        <select name="student" class="form-control" id="student"
                                                            required="required">
                                                            <option value="">Select Student</option>
                                                            <?php
                                                            $sql = "SELECT DISTINCT StudentName FROM tblstudents";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) { ?>
                                                                    <option
                                                                        value="<?php echo htmlentities($result->StudentName); ?>">
                                                                        <?php echo htmlentities($result->StudentName); ?>
                                                                    </option>
                                                                <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="date" class="col-sm-2 control-label ">Marks Section</label>
                                                    <div class="col-sm-10">
                                                        <div id="marksSection" style="display:none;">
                                                            <!-- Marks fields will be shown here based on course credit -->
                                                            <div id="theoryFields" style="display:none;"><br>
                                                                <label for="termFinal">Term Final:</label>
                                                                <input type="number" step="0.001" id="termFinal"
                                                                    name="termFinal">
                                                                <label for="quiz">Quiz:</label>
                                                                <input type="number" step="0.001" id="quiz" name="quiz">
                                                                <label for="attendance">Attendance:</label>
                                                                <input type="number" step="0.001" id="attendance"
                                                                    name="attendance">
                                                            </div>

                                                            <div id="sessionalFields" style="display:none;">
                                                                <label for="labPerformance">Lab Performance:</label>
                                                                <input type="text" id="labPerformance"
                                                                    name="labPerformance"><br>
                                                                <label for="attendanceS">Attendance:</label>
                                                                <input type="text" id="attendanceS" name="attendanceS"><br>
                                                                <label for="viva">Viva:</label>
                                                                <input type="text" id="viva" name="viva"><br>
                                                                <label for="labQuiz">Lab Quiz:</label>
                                                                <input type="text" id="labQuiz" name="labQuiz"><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" name="submit" id="submit"
                                                            class="btn btn-primary">Declare Result</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                        </div>
                    </div>
                    <!-- /.content-container -->
                </div>
                <!-- /.content-wrapper -->
            </div>
            <!-- /.main-wrapper -->
            <script src="js/jquery/jquery-2.2.4.min.js"></script>
            <script src="js/bootstrap/bootstrap.min.js"></script>
            <script src="js/pace/pace.min.js"></script>
            <script src="js/lobipanel/lobipanel.min.js"></script>
            <script src="js/iscroll/iscroll.js"></script>
            <script src="js/prism/prism.js"></script>
            <script src="js/select2/select2.min.js"></script>
            <script src="js/main.js"></script>
            <script src="js/DataTables/datatables.min.js"></script>
            <script>
                $(function ($) {
                    $(".js-states").select2();
                    $(".js-states-limit").select2({
                        maximumSelectionLength: 2
                    });
                    $(".js-states-hide").select2({
                        minimumResultsForSearch: Infinity
                    });
                });
            </script>
    </body>

    </html>
<?PHP } ?>