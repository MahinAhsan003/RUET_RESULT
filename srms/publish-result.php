<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
    exit;
}
?>
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
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
                    <?php include('includes/leftbar.php'); ?>
                    <!-- /.left-sidebar -->

                    <div class="content-wrapper">
                        <div class="content-container">

                            <div class="main-page">
                                <div class="container-fluid">
                                    <div class="row page-title-div">
                                        <div class="col-md-6">
                                            <h2 class="title">Publish Result</h2>
                                        </div>
                                    </div>
                                    <div class="row breadcrumb-div">
                                        <div class="col-md-6">
                                            <ul class="breadcrumb">
                                                <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                                <li> Result</li>
                                                <li class="active">Publish Result</li>
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
                                                        <form method="POST" id="filterForm">
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

                                                            <button type="button" id="filterBtn"
                                                                class="btn btn-primary">Filter</button>
                                                        </form>

                                                        <!-- The Form for calculating result -->
                                                        <form method="POST" id="calculateForm" style="display:none;">
                                                            <!-- Hidden inputs to pass filter details -->
                                                            <input type="hidden" name="department" id="hiddenDepartment">
                                                            <input type="hidden" name="series" id="hiddenSeries">
                                                            <input type="hidden" name="semester" id="hiddenSemester">

                                                            <!-- Dropdown for selecting Semester (1-8) for Result Publishing, initially hidden -->
                                                            <div id="semesterSelectDiv" style="display:none;">
                                                                <label for="selectSemester">Select Semester for Publishing
                                                                    Result</label>
                                                                <select name="selectSemester" id="selectSemester"
                                                                    class="form-control">
                                                                    <option value="">Select Semester</option>
                                                                    <option value="1">Semester 1</option>
                                                                    <option value="2">Semester 2</option>
                                                                    <option value="3">Semester 3</option>
                                                                    <option value="4">Semester 4</option>
                                                                    <option value="5">Semester 5</option>
                                                                    <option value="6">Semester 6</option>
                                                                    <option value="7">Semester 7</option>
                                                                    <option value="8">Semester 8</option>
                                                                </select>
                                                            </div>

                                                            <!-- Show Publish Result button -->
                                                            <div id="publishResultButtonDiv" style="display:none;">
                                                                <button type="submit" name="publishResult"
                                                                    class="btn btn-warning mt-3">Publish Result</button>
                                                            </div>
                                                        </form>
                                                        <div id="echoDetails" class="mt-3"></div>

                                                        <script>
                                                            document.getElementById('filterBtn').addEventListener('click',
                                                                function () {
                                                                    // Get selected filter values
                                                                    var department = document.getElementById('department')
                                                                        .value;
                                                                    var series = document.getElementById('series').value;
                                                                    var semester = document.getElementById('semester')
                                                                        .value;

                                                                    // Display the selected filter details
                                                                    var echoDetails = document.getElementById(
                                                                        'echoDetails');
                                                                    echoDetails.innerHTML = `
                        <strong>Department:</strong> ${department}<br>
                        <strong>Series:</strong> ${series}<br>
                        <strong>Semester:</strong> ${semester}
                    `;

                                                                    // Show the 'Publish Result' button and semester selection dropdown
                                                                    document.getElementById('calculateForm').style.display =
                                                                        'block';

                                                                    // Set the hidden fields with the selected filter values
                                                                    document.getElementById('hiddenDepartment').value =
                                                                        department;
                                                                    document.getElementById('hiddenSeries').value = series;
                                                                    document.getElementById('hiddenSemester').value =
                                                                        semester;
                                                                });

                                                            // Show the semester selection dropdown and publish result button when the form is displayed
                                                            document.getElementById('calculateForm').addEventListener('submit',
                                                                function (e) {
                                                                    e
                                                                        .preventDefault(); // Prevent form submission to keep the page intact

                                                                    // Show the select semester dropdown and publish result button
                                                                    document.getElementById('semesterSelectDiv').style
                                                                        .display = 'block';
                                                                    document.getElementById('publishResultButtonDiv').style
                                                                        .display = 'block';
                                                                });
                                                        </script>
                                                        <?php

                                                        // Publish Result (Calculate SGPA and CGPA)
                                                        if (isset($_POST['publishResult'])) {
                                                            // Get filter details from POST variables
                                                            $semester = $_POST['semester'];
                                                            $department = $_POST['department'];
                                                            $series = $_POST['series'];

                                                            // Query to get RollIds for the selected semester, department, and series
                                                            $sql = "SELECT DISTINCT RollId FROM tblgpa WHERE Semester = :semester";
                                                            $query = $dbh->prepare($sql);
                                                            $query->bindParam(':semester', $semester, PDO::PARAM_STR);
                                                            $query->execute();
                                                            $rollIds = $query->fetchAll(PDO::FETCH_ASSOC);

                                                            foreach ($rollIds as $rollId) {
                                                                $roll = $rollId['RollId'];

                                                                // Query to calculate SGPA for each student
                                                                $sql = "SELECT SUM(s.CourseCredit * g.GPA) AS weightedGPA, SUM(s.CourseCredit) AS totalCredits
                                                                FROM tblgpa g
                                                                JOIN tblsubjects s ON g.CourseCode = s.CourseCode
                                                                WHERE g.RollId = :rollId AND g.Semester = :semester
                                                                GROUP BY g.RollId, g.Semester
                                                            ";

                                                                $query = $dbh->prepare($sql);
                                                                $query->bindParam(':rollId', $roll, PDO::PARAM_INT);
                                                                $query->bindParam(':semester', $semester, PDO::PARAM_STR);
                                                                $query->execute();

                                                                // Fetch the weighted GPA and total credits
                                                                $result = $query->fetch(PDO::FETCH_ASSOC);

                                                                if ($result) {
                                                                    $weightedGPA = $result['weightedGPA'];
                                                                    $totalCredits = $result['totalCredits'];

                                                                    // Calculate SGPA
                                                                    if ($totalCredits > 0) {
                                                                        $sgpa = $weightedGPA / $totalCredits;
                                                                    } else {
                                                                        $sgpa = 0;  // In case of no courses in that semester
                                                                    }

                                                                    // Insert the calculated SGPA into the tblsgpa table
                                                                    $sql = "INSERT INTO tblsgpa (RollId, Semester, SGPA) 
                    VALUES (:rollId, :semester, :sgpa) 
                    ON DUPLICATE KEY UPDATE SGPA = :sgpa";

                                                                    $query = $dbh->prepare($sql);
                                                                    $query->bindParam(':rollId', $roll, PDO::PARAM_INT);
                                                                    $query->bindParam(':semester', $semester, PDO::PARAM_STR);
                                                                    $query->bindParam(':sgpa', $sgpa, PDO::PARAM_STR);

                                                                    try {
                                                                        $query->execute();
                                                                        echo "SGPA successfully calculated and updated for Roll ID: $roll<br>";
                                                                    } catch (PDOException $e) {
                                                                        echo "Error updating SGPA for Roll ID: $roll - " . $e->getMessage() . "<br>";
                                                                    }
                                                                }
                                                            }

                                                            // Calculate CGPA (Optional based on selected semester)
                                                            if (isset($_POST['selectSemester'])) {
                                                                $selectedSemester = $_POST['selectSemester'];

                                                                // Query to get RollIds for the selected department and semesters
                                                                $sql = "SELECT DISTINCT RollId 
                                                                FROM tblgpa 
                                                                WHERE Semester IN (";

                                                                // Add semesters 1 to selected semester dynamically
                                                                $semesters = range(1, $selectedSemester);  // Generate array of semesters up to selected
                                                                $placeholders = implode(',', array_fill(0, count($semesters), '?'));
                                                                $sql .= $placeholders . ")";

                                                                $query = $dbh->prepare($sql);
                                                                // Bind the semester values dynamically
                                                                $query->execute($semesters);
                                                                $rollIds = $query->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach ($rollIds as $rollId) {
                                                                    $roll = $rollId['RollId'];

                                                                    // Query to calculate total SGPA for all semesters up to the selected semester
                                                                    $sql = "SELECT SUM(s.CourseCredit * g.GPA) AS weightedGPA, SUM(s.CourseCredit) AS totalCredits
                                                                    FROM tblgpa g
                                                                    JOIN tblsubjects s ON g.CourseCode = s.CourseCode
                                                                    WHERE g.RollId = :rollId AND g.Semester IN (";

                                                                    $placeholders = implode(',', array_fill(0, count($semesters), '?'));
                                                                    $sql .= $placeholders . ") GROUP BY g.RollId";

                                                                    $query = $dbh->prepare($sql);
                                                                    $query->execute(array_merge([$roll], $semesters));
                                                                    $result = $query->fetch(PDO::FETCH_ASSOC);

                                                                    if ($result) {
                                                                        $weightedGPA = $result['weightedGPA'];
                                                                        $totalCredits = $result['totalCredits'];

                                                                        // Calculate CGPA
                                                                        if ($totalCredits > 0) {
                                                                            $cgpa = $weightedGPA / $totalCredits;
                                                                        } else {
                                                                            $cgpa = 0; // No courses found
                                                                        }

                                                                        // Insert the calculated CGPA into the tblcgpa table
                                                                        $sql = "INSERT INTO tblcgpa (RollId, Semester, CGPA) 
                        VALUES (:rollId, :semester, :cgpa) 
                        ON DUPLICATE KEY UPDATE CGPA = :cgpa";

                                                                        $query = $dbh->prepare($sql);
                                                                        $query->bindParam(':rollId', $roll, PDO::PARAM_INT);
                                                                        $query->bindParam(':semester', $selectedSemester, PDO::PARAM_STR);
                                                                        $query->bindParam(':cgpa', $cgpa, PDO::PARAM_STR);

                                                                        try {
                                                                            $query->execute();
                                                                            echo "CGPA successfully calculated and updated for Roll ID: $roll<br>";
                                                                        } catch (PDOException $e) {
                                                                            echo "Error updating CGPA for Roll ID: $roll - " . $e->getMessage() . "<br>";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
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