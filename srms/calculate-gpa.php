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
        <title>SMS Admin| Calculate GPA </title>
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
                                            <h2 class="title">Calculate GPA</h2>
                                        </div>
                                    </div>
                                    <div class="row breadcrumb-div">
                                        <div class="col-md-6">
                                            <ul class="breadcrumb">
                                                <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                                <li> Result</li>
                                                <li class="active">Calculate GPA</li>
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
                                                            <tbody>
                                                                <?php
                                                                if (isset($_POST['filter'])) {
                                                                    $department = $_POST['department'];
                                                                    $series = $_POST['series'];
                                                                    $semester = $_POST['semester'];
                                                                    $course = $_POST['course'];

                                                                    // Fetch course credit to determine marks columns
                                                                    $sql = "SELECT CourseCredit FROM tblsubjects WHERE CourseCode = :course";
                                                                    $query = $dbh->prepare($sql);
                                                                    $query->execute([':course' => $course]);
                                                                    $courseCredit = $query->fetchColumn();

                                                                    // Based on course credit, we decide the marks columns
                                                                    if ($courseCredit < 3.0) {
                                                                        // Use tblsessional columns
                                                                        $marksColumns = ['Attendance', 'Quiz', 'BoardViva', 'Performance'];
                                                                        $sql = "SELECT DISTINCT s.StudentName, s.RollId, s.RegistrationId, s.Department, s.Section, s.Series, s.RegDate, s.Status,
                                                                        m.Attendance, m.Quiz, m.BoardViva, m.Performance
                                                                        FROM tblstudents s
                                                                        LEFT JOIN tblsessional m ON s.RollId = m.RollId
                                                                        INNER JOIN tblregistration r ON s.RollId = r.RollId
                                                                        WHERE r.RegisteredCourse = :course";
                                                                    } else {
                                                                        // Use tblmarks columns
                                                                        $marksColumns = ['CT_1', 'CT_2', 'CT_3', 'CT_4', 'Assignment', 'Semester_Final'];
                                                                        $sql = "SELECT DISTINCT s.StudentName, s.RollId, s.RegistrationId, s.Department, s.Section, s.Series, s.RegDate, s.Status,
                                                                        m.CT_1, m.CT_2, m.CT_3, m.CT_4, m.Assignment, m.Semester_Final
                                                                        FROM tblstudents s
                                                                        LEFT JOIN tblmarks m ON s.RollId = m.RollId
                                                                        INNER JOIN tblregistration r ON s.RollId = r.RollId
                                                                        WHERE r.RegisteredCourse = :course";
                                                                    }

                                                                    // Add filters for department, series, and semester
                                                                    if ($department)
                                                                        $sql .= " AND s.Department = :department";
                                                                    if ($series)
                                                                        $sql .= " AND s.Series = :series";
                                                                    if ($semester)
                                                                        $sql .= " AND r.Semester = :semester";

                                                                    // Prepare and execute query
                                                                    $query = $dbh->prepare($sql);
                                                                    $query->execute([
                                                                        ':course' => $course,
                                                                        ':department' => $department,
                                                                        ':series' => $series,
                                                                        ':semester' => $semester
                                                                    ]);

                                                                    $results = $query->fetchAll(PDO::FETCH_ASSOC);

                                                                    if ($query->rowCount() > 0) {
                                                                        // Table start
                                                                        echo '<table class="table table-bordered">';

                                                                        // Table header
                                                                        echo '<thead><tr>';
                                                                        echo '<th>#</th><th>Student Name</th><th>Roll ID</th>';

                                                                        // Dynamically create table headers for marks columns
                                                                        foreach ($marksColumns as $column) {
                                                                            echo "<th>" . htmlentities($column) . "</th>"; // Display column name in header
                                                                        }

                                                                        echo '</tr></thead><tbody>';

                                                                        // Display data rows dynamically based on marks columns
                                                                        $counter = 1; // Counter for row numbering
                                                                        foreach ($results as $row) {
                                                                            echo '<tr>';
                                                                            echo '<td>' . $counter++ . '</td>'; // Row number
                                                                            echo '<td>' . htmlentities($row['StudentName']) . '</td>';
                                                                            echo '<td>' . htmlentities($row['RollId']) . '</td>';

                                                                            // Loop through each marks column and display the corresponding value
                                                                            foreach ($marksColumns as $column) {
                                                                                echo '<td>' . htmlentities($row[$column] ?? 'N/A') . '</td>'; // Display marks or 'N/A' if not available
                                                                            }

                                                                            echo '</tr>';
                                                                        }

                                                                        echo '</tbody></table>';
                                                                    } else {
                                                                        echo '<tr><td colspan="9">No records found</td></tr>';
                                                                    }
                                                                }
                                                                ?>
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
            <!--/.main-wrapper -->
        </div>
        <script>
            // Update series dropdown based on department selection
            function updateSeries() {
                var department = document.getElementById("department").value;
                var seriesDropdown = document.getElementById("series");

                seriesDropdown.innerHTML = '<option value="">Select Series</option>';

                if (seriesOptions[department]) {
                    seriesOptions[department].forEach(function (series) {
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

                semesterDropdown.innerHTML = '<option value="">Select Semester</option>';

                var key = department + '|' + series;

                if (semesterOptions[key]) {
                    semesterOptions[key].forEach(function (semester) {
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

                courseDropdown.innerHTML = '<option value="">Select Course</option>';

                var key = department + '|' + semester;

                if (courseOptions[key]) {
                    courseOptions[key].forEach(function (course) {
                        var optionElement = document.createElement("option");
                        optionElement.value = course;
                        optionElement.text = course;
                        courseDropdown.appendChild(optionElement);
                    });
                }
            }

            var seriesOptions = {
                <?php
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
                foreach ($departments as $department => $series) {
                    $uniqueSeries = array_unique($series);
                    echo '"' . $department . '": ["' . implode('", "', $uniqueSeries) . '"],';
                }
                ?>
            };

            var semesterOptions = {
                <?php
                $sql = "SELECT Department, Series, Semester FROM tblclasses";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $deptSeries = [];
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                        $key = $result->Department . '|' . $result->Series;
                        $deptSeries[$key][] = $result->Semester;
                    }
                }

                foreach ($deptSeries as $key => $semesters) {
                    $uniqueSemesters = array_unique($semesters);
                    echo '"' . $key . '": ["' . implode('", "', $uniqueSemesters) . '"],';
                }
                ?>
            };

            var courseOptions = {
                <?php
                $sql = "SELECT Department, Semester, CourseCode FROM tblsubjects";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $deptSemesters = [];
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                        $key = $result->Department . '|' . $result->Semester;
                        $deptSemesters[$key][] = $result->CourseCode;
                    }
                }

                foreach ($deptSemesters as $key => $courses) {
                    $uniqueCourses = array_unique($courses);
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