<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
} else {
    $teacherid = $_SESSION['login'];
    $sql = "SELECT * FROM tblteachers WHERE TeacherId=:teacherid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':teacherid', $teacherid, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if (!$result) {
        header("Location: index.php");
        exit();
    }
}
?>
<?php
session_start();
error_reporting(0);
include('includes/config.php');
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

    </head>

    <body class="top-navbar-fixed">


        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include('includes/topbar.php'); ?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">
                    <!-- ========== LEFT SIDEBAR ========== -->
                    <?php include('includes/teacher-leftbar.php'); ?>
                    <!-- /.left-sidebar -->

                    <div class="content-wrapper">
                        <div class="content-container">

                            <div class="main-page">
                                <div class="container-fluid">
                                    <div class="row page-title-div">
                                        <div class="col-md-6">
                                            <h2 class="title">Add Result</h2>
                                        </div>
                                    </div>
                                    <div class="row breadcrumb-div">
                                        <div class="col-md-6">
                                            <ul class="breadcrumb">
                                                <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                                <li> Result</li>
                                                <li class="active">Add Result</li>
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
                                                            <h5>View Students Info</h5>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body p-20">
                                                        <form method="post" action="" class="filter-form">
                                                            <div class="form-group">
                                                                <label for="department">Department</label>
                                                                <select name="department" id="department"
                                                                    class="form-control" onchange="updateSeries()">
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
                                                                <label for="series">Series</label>
                                                                <select name="series" id="series" class="form-control"
                                                                    onchange="updateSemesters()">
                                                                    <option value="">Select Series</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="semester">Semester</label>
                                                                <select name="semester" id="semester" class="form-control"
                                                                    onchange="updateCourses()">
                                                                    <option value="">Select Semester</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="course">Course</label>
                                                                <select name="course" id="course" class="form-control">
                                                                </select>
                                                            </div>
                                                            <button type="submit" name="filter"
                                                                class="btn btn-primary">Filter</button>
                                                        </form>

                                                        <table id="example"
                                                            class="display table table-striped table-bordered"
                                                            cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Student Name</th>
                                                                    <th>Roll Id</th>
                                                                    <th>CT-1</th>
                                                                    <th>CT-2</th>
                                                                    <th>CT-3</th>
                                                                    <th>CT-4</th>
                                                                    <th>Attendance</th>
                                                                    <th>Assignment</th>
                                                                    <th>Semester Final</th>
                                                                    <th>Update</th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Student Name</th>
                                                                    <th>Roll Id</th>
                                                                    <th>CT-1</th>
                                                                    <th>CT-2</th>
                                                                    <th>CT-3</th>
                                                                    <th>CT-4</th>
                                                                    <th>Attendance</th>
                                                                    <th>Assignment</th>
                                                                    <th>Semester Final</th>
                                                                    <th>Update</th>
                                                                </tr>
                                                            </tfoot>
                                                            <tbody>
                                                                <?php
                                                                if (isset($_POST['filter'])) {
                                                                    $department = $_POST['department'];
                                                                    $series = $_POST['series'];
                                                                    $semester = $_POST['semester'];
                                                                    $course = $_POST['course'];
                                                                    // print_r($_POST);
                                                                    $sql = "SELECT DISTINCT s.StudentName, s.RollId, s.RegistrationId, s.Department, s.Section, s.Series, s.RegDate, 
                                                                    m.CT_1, m.CT_2, m.CT_3, m.CT_4, m.Attendance, m.Assignment, m.Semester_Final, s.Status
                                                                    FROM tblstudents s 
                                                                    LEFT JOIN tblmarks m ON s.RollId = m.RollId
                                                                    INNER JOIN tblregistration r ON s.RollId = r.RollId 
                                                                    WHERE 1=1";
                                                                    // echo "Department: $department, Series: $series, Course: $course<br>";
                                                                    if ($department != "") {
                                                                        $sql .= " AND s.Department = :department";
                                                                    }
                                                                    if ($series != "") {
                                                                        $sql .= " AND s.Series = :series";
                                                                    }
                                                                    if ($course != "") {
                                                                        $sql .= " AND r.RegisteredCourses = :course";
                                                                    }

                                                                    $sql .= " ORDER BY RollId";
                                                                    // echo "Constructed SQL: " . $sql . "<br>";
                                                                    $query = $dbh->prepare($sql);

                                                                    // Bind all parameters at once
                                                                    $params = [];
                                                                    if ($department != "") {
                                                                        $params[':department'] = $department;
                                                                    }
                                                                    if ($series != "") {
                                                                        $params[':series'] = $series;
                                                                    }
                                                                    if ($course != "") {
                                                                        $params[':course'] = (string) $course;
                                                                    }
                                                                    $query->execute($params);
                                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                } else {
                                                                    $results = [];
                                                                }
                                                                $cnt = 1;
                                                                if (count($results) > 0) {
                                                                    foreach ($results as $result) { ?>
                                                                        <tr>
                                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                                            <td><?php echo htmlentities($result->StudentName); ?>
                                                                            </td>
                                                                            <td><?php echo htmlentities($result->RollId); ?></td>
                                                                            <td><?php echo htmlentities($result->CT_1); ?>
                                                                            </td>
                                                                            <td><?php echo htmlentities($result->CT_2); ?>
                                                                            </td>
                                                                            <td><?php echo htmlentities($result->CT_3); ?></td>
                                                                            <td><?php echo htmlentities($result->CT_4); ?></td>
                                                                            <td><?php echo htmlentities($result->Attendance); ?>
                                                                            </td>
                                                                            <td><?php echo htmlentities($result->Status == 1 ? 'Active' : 'Blocked'); ?>
                                                                            <td><?php echo htmlentities($result->Status == 1 ? 'Active' : 'Blocked'); ?>
                                                                            </td>
                                                                            <td>
                                                                                <a href="edit-student.php?stid=<?php echo htmlentities($result->StudentId); ?>"
                                                                                    class="btn btn-primary btn-xs"
                                                                                    target="_blank">Update</a>
                                                                                <a href="delete-student.php?classid=<?php echo htmlentities($result->id); ?>"
                                                                                    class="btn btn-danger btn-xs" target="_blank"
                                                                                    onclick="return confirm('Are you sure you want to delete this class?');">Edit</a>
                                                                            </td>
                                                                        </tr>
                                                                <?php $cnt++;
                                                                    }
                                                                } ?>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <!-- /.content-container -->
                </div>
                <!-- /.content-wrapper -->
            </div>
            <!--       /.main-wrapper -->
        </div>
        <script>
            // Update series dropdown based on department selection
            function updateSeries() {
                var department = document.getElementById("department").value;
                var seriesDropdown = document.getElementById("series");

                seriesDropdown.innerHTML = '<option value="">--Select a series--</option>';

                if (seriesOptions[department]) {
                    seriesOptions[department].forEach(function(series) {
                        var optionElement = document.createElement("option");
                        optionElement.value = series;
                        optionElement.text = series;
                        seriesDropdown.appendChild(optionElement);
                    });
                }
                updateSemesters(); // Clear the next dropdowns when department changes
            }

            function updateSemesters() {
                var department = document.getElementById("department").value;
                var series = document.getElementById("series").value;
                var semesterDropdown = document.getElementById("semester");

                semesterDropdown.innerHTML = '<option value="">--Select a semester--</option>';

                var key = department + '|' + series;

                if (semesterOptions[key]) {
                    semesterOptions[key].forEach(function(semester) {
                        var optionElement = document.createElement("option");
                        optionElement.value = semester;
                        optionElement.text = semester;
                        semesterDropdown.appendChild(optionElement);
                    });
                }
                updateCourses(); // Clear the next dropdown when series changes
            }

            function updateCourses() {
                var department = document.getElementById("department").value;
                var semester = document.getElementById("semester").value;
                var courseDropdown = document.getElementById("course");

                courseDropdown.innerHTML = '<option value="">--Select a course--</option>';

                var key = department + '|' + semester;

                if (courseOptions[key]) {
                    courseOptions[key].forEach(function(course) {
                        var optionElement = document.createElement("option");
                        optionElement.value = course;
                        optionElement.text = course;
                        courseDropdown.appendChild(optionElement);
                    });
                }
            }
            var seriesOptions = {
                <?php
                // Fetch department and series data from tblclasses
                $sql = "SELECT DISTINCT Department, Series FROM tblclasses";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $departments = [];
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                        $departments[$result->Department][] = $result->Series;
                    }
                }
                // Generate the JavaScript object for seriesOptions
                foreach ($departments as $department => $series) {
                    $uniqueSeries = array_unique($series); // Remove duplicate series
                    echo '"' . $department . '": ["' . implode('", "', $uniqueSeries) . '"],';
                }
                ?>
            };
            // Update semesters dropdown based on department and series selection
            var semesterOptions = {
                <?php
                // Fetch department, series, and semester data from tblclasses
                $sql = "SELECT Department, Series, Semester FROM tblclasses";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $deptSeries = [];
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                        // Combine Department and Series as the key
                        $key = $result->Department . '|' . $result->Series;
                        $deptSeries[$key][] = $result->Semester;
                    }
                }

                // Generate the JavaScript object for semesterOptions
                foreach ($deptSeries as $key => $semesters) {
                    $uniqueSemesters = array_unique($semesters); // Remove duplicate semesters
                    echo '"' . $key . '": ["' . implode('", "', $uniqueSemesters) . '"],';
                }
                ?>
            };
            // Update courses dropdown based on department and semester selection
            var courseOptions = {
                <?php
                // Fetch department, semester, and course code data from tblsubjects
                $sql = "SELECT Department, Semester, CourseCode FROM tblsubjects";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $deptSemesters = [];
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                        // Combine Department and Semester as the key
                        $key = $result->Department . '|' . $result->Semester;
                        $deptSemesters[$key][] = $result->CourseCode;
                    }
                }

                // Generate the JavaScript object for courseOptions
                foreach ($deptSemesters as $key => $courses) {
                    $uniqueCourses = array_unique($courses); // Remove duplicate courses
                    echo '"' . $key . '": ["' . implode('", "', $uniqueCourses) . '"],';
                }
                ?>
            };
        </script>
        <script src="js/jquery/jquery-2.2.4.min.js"> </script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"> </script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script sr c="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>
    </body>

    </html>
<?PHP } ?>