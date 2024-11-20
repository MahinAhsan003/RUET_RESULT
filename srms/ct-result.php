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
    $selectedCourse = '';

    if (isset($_POST['filter'])) {
        $selectedSemester = $_POST['semester'];
        $selectedCourse = $_POST['course'];

        if (empty($selectedSemester) || empty($selectedCourse)) {
            $error = "Please select both semester and course!";
        } else {
            // Fetch results for the selected semester and course from tblmarks
            $sql = "SELECT CourseCode, CT_1, CT_2, CT_3, CT_4 
                    FROM tblmarks 
                    WHERE RollId = :rollId AND Semester = :semester AND CourseCode = :course";
            $query = $dbh->prepare($sql);
            $query->bindParam(':rollId', $rollId, PDO::PARAM_STR);
            $query->bindParam(':semester', $selectedSemester, PDO::PARAM_STR);
            $query->bindParam(':course', $selectedCourse, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
        }
    }

    // Fetch registered courses for the selected semester
    $sql = "SELECT DISTINCT s.CourseName, s.CourseCode, s.Semester 
            FROM tblsubjects s 
            JOIN tblregistration r ON s.CourseCode = r.RegisteredCourse 
            WHERE r.RollId = :rollId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rollId', $rollId, PDO::PARAM_STR);
    $query->execute();
    $courses = $query->fetchAll(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Semester Result</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/student-topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/student-leftbar.php'); ?>
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Semester Result</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="student-dash.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li>Result</li>
                                    <li class="active">Semester Result</li>
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
                                            <h5>View Result</h5>
                                        </div>
                                        <div class="panel-body">
                                            <?php if ($error) { ?>
                                                <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
                                            <?php } ?>
                                            <form method="post" action="" class="filter-form">
                                                <div class="form-group">
                                                    <label for="semester">Semester</label>
                                                    <select name="semester" id="semester" class="form-control">
                                                        <option value="">Select Semester</option>
                                                        <?php
                                                        $semesters = [];
                                                        foreach ($courses as $course) {
                                                            if (!in_array($course->Semester, $semesters)) {
                                                                $semesters[] = $course->Semester; ?>
                                                                <option value="<?php echo htmlentities($course->Semester); ?>" <?php if ($selectedSemester == $course->Semester) echo "selected"; ?>>
                                                                    <?php echo htmlentities($course->Semester); ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="course">Course</label>
                                                    <select name="course" id="course" class="form-control">
                                                        <option value="">Select Course</option>
                                                        <?php
                                                        foreach ($courses as $course) {
                                                            if ($course->Semester == $selectedSemester) { ?>
                                                                <option value="<?php echo htmlentities($course->CourseCode); ?>" <?php if ($selectedCourse == $course->CourseCode) echo "selected"; ?>>
                                                                    <?php echo htmlentities($course->CourseName); ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <button type="submit" name="filter" class="btn btn-primary">Filter</button>
                                            </form>

                                            <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Course Code</th>
                                                        <th>CT-1</th>
                                                        <th>CT-2</th>
                                                        <th>CT-3</th>
                                                        <th>CT-4</th>
                                                        <th>Average CT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cnt = 1;
                                                    if (!empty($results)) {
                                                        foreach ($results as $result) {
                                                            $ctMarks = array_filter([$result->CT_1, $result->CT_2, $result->CT_3, $result->CT_4]);
                                                            $averageCT = count($ctMarks) >= 3 ? ceil(array_sum(array_slice($ctMarks, -3)) / 3) : '';
                                                    ?>
                                                            <tr>
                                                                <td><?php echo htmlentities($cnt); ?></td>
                                                                <td><?php echo htmlentities($result->CourseCode); ?></td>
                                                                <td><?php echo htmlentities($result->CT_1); ?></td>
                                                                <td><?php echo htmlentities($result->CT_2); ?></td>
                                                                <td><?php echo htmlentities($result->CT_3); ?></td>
                                                                <td><?php echo htmlentities($result->CT_4); ?></td>
                                                                <td><?php echo htmlentities($averageCT); ?></td>
                                                            </tr>
                                                        <?php $cnt++;
                                                        }
                                                    } elseif (isset($_POST['filter'])) { ?>
                                                        <tr>
                                                            <td colspan="7" style="text-align: center;">No Results Found</td>
                                                        </tr>
                                                    <?php } ?>
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
    </div>
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(function($) {
            $('#example').DataTable();
        });
    </script>
</body>

</html>