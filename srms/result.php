<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
} else {
    $rollId = $_SESSION['login'];
    $sql = "SELECT * FROM tblstudents WHERE RollId=:rollId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rollId', $rollId, PDO::PARAM_STR);
    $query->execute();
    $student = $query->fetch(PDO::FETCH_OBJ);

    if (!$student) {
        header("Location: index.php");
        exit();
    }

    $results = [];
    $selectedSemester = '';
    $scgpa = 0.0;
    $cgpa = 0.0;

    if (isset($_POST['filter'])) {
        $selectedSemester = $_POST['semester'];

        if (empty($selectedSemester)) {
            $error = "Please select a semester!";
        } else {
            // Fetch results for the selected semester
            $sql = "SELECT CourseCode, CT_1, CT_2, CT_3, CT_4, Attendance, Assignment, Semester_Final 
                    FROM tblmarks 
                    WHERE RollId = :rollId AND Semester = :semester";
            $query = $dbh->prepare($sql);
            $query->bindParam(':rollId', $rollId, PDO::PARAM_STR);
            $query->bindParam(':semester', $selectedSemester, PDO::PARAM_INT);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            // Calculate SGPA
            $totalGPA = 0.0;
            $courseCount = 0;
            foreach ($results as $result) {
                $ctAvg = (max($result->CT_1, $result->CT_2, $result->CT_3) +
                    max($result->CT_2, $result->CT_3, $result->CT_4) +
                    max($result->CT_1, $result->CT_3, $result->CT_4)) / 3;
                $totalMarks = $ctAvg + $result->Attendance + $result->Assignment + $result->Semester_Final;

                $gradePoint = calculateGrade($totalMarks);
                $totalGPA += $gradePoint;
                $courseCount++;
            }
            $sgpa = $courseCount > 0 ? $totalGPA / $courseCount : 0;

            // Fetch CGPA from tblcgpa
            $sql = "SELECT CGPA FROM tblcgpa WHERE RollId = :rollId AND Semester = :semester";
            $query = $dbh->prepare($sql);
            $query->bindParam(':rollId', $rollId, PDO::PARAM_STR);
            $query->bindParam(':semester', $selectedSemester, PDO::PARAM_INT);
            $query->execute();
            $cgpaResult = $query->fetch(PDO::FETCH_OBJ);
            $cgpa = $cgpaResult ? $cgpaResult->CGPA : 0.0;
        }
    }
}

// Function to calculate grade point
function calculateGrade($score)
{
    if ($score >= 80) return 4.0;
    elseif ($score >= 75) return 3.75;
    elseif ($score >= 70) return 3.5;
    elseif ($score >= 65) return 3.25;
    elseif ($score >= 60) return 3.0;
    elseif ($score >= 55) return 2.75;
    elseif ($score >= 50) return 2.5;
    elseif ($score >= 45) return 2.25;
    elseif ($score >= 40) return 2.0;
    else return 0.0;
}

// Function to convert grade point to letter grade
function getLetterGrade($gradePoint)
{
    if ($gradePoint >= 4.0) return 'A+';
    elseif ($gradePoint >= 3.75) return 'A';
    elseif ($gradePoint >= 3.5) return 'A-';
    elseif ($gradePoint >= 3.25) return 'B+';
    elseif ($gradePoint >= 3.0) return 'B';
    elseif ($gradePoint >= 2.75) return 'B-';
    elseif ($gradePoint >= 2.5) return 'C+';
    elseif ($gradePoint >= 2.25) return 'C';
    elseif ($gradePoint >= 2.0) return 'D';
    else return 'F';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Semester Results</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/student-topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/student-leftbar.php'); ?>
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="title">Semester Results</h2>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="container-fluid">
                            <form method="post">
                                <div class="form-group">
                                    <label for="semester">Select Semester</label>
                                    <select name="semester" id="semester" class="form-control">
                                        <option value="">-- Select Semester --</option>
                                        <?php
                                        $sql = "SELECT DISTINCT Semester FROM tblclasses ORDER BY Semester";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $semesters = $query->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($semesters as $semester) { ?>
                                            <option value="<?php echo htmlentities($semester->Semester); ?>"
                                                <?php echo $selectedSemester == $semester->Semester ? 'selected' : ''; ?>>
                                                <?php echo htmlentities($semester->Semester); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <button type="submit" name="filter" class="btn btn-primary">Filter</button>
                            </form>
                            <?php if (!empty($results)) { ?>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Course Code</th>
                                            <th>Average CT</th>
                                            <th>Attendance</th>
                                            <th>Assignment</th>
                                            <th>Semester Final</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($results as $result) {
                                            $ctAvg = (max($result->CT_1, $result->CT_2, $result->CT_3) +
                                                max($result->CT_2, $result->CT_3, $result->CT_4) +
                                                max($result->CT_1, $result->CT_3, $result->CT_4)) / 3;
                                            $totalMarks = $ctAvg + $result->Attendance + $result->Assignment + $result->Semester_Final;
                                            $gradePoint = calculateGrade($totalMarks);
                                            $letterGrade = getLetterGrade($gradePoint);
                                        ?>
                                            <tr>
                                                <td><?php echo htmlentities($result->CourseCode); ?></td>
                                                <td><?php echo number_format($ctAvg, 2); ?></td>
                                                <td><?php echo htmlentities($result->Attendance); ?></td>
                                                <td><?php echo htmlentities($result->Assignment); ?></td>
                                                <td><?php echo htmlentities($result->Semester_Final); ?></td>
                                                <td><?php echo htmlentities($letterGrade); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">SGPA</td>
                                            <td><?php echo number_format($sgpa, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">CGPA</td>
                                            <td><?php echo number_format($cgpa, 2); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <button onclick="window.print()" class="btn btn-success">Print</button>
                            <?php } elseif (isset($_POST['filter'])) { ?>
                                <div class="alert alert-danger">No results found for the selected semester.</div>
                            <?php } ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</body>

</html>