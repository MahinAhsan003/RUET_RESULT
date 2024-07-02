<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else { 
    if (isset($_POST['register'])) {
        $studentId = $_SESSION['studentid'];
        $courses = $_POST['courses'];

        foreach ($courses as $course) {
            $sql = "INSERT INTO tblcourse_registration(StudentId, CourseId) VALUES(:studentid, :courseid)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':studentid', $studentId, PDO::PARAM_STR);
            $query->bindParam(':courseid', $course, PDO::PARAM_STR);
            $query->execute();
        }
        $msg = "Courses registered successfully";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SMS Admin | Course Registration</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include('includes/topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php'); ?>
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
                                    <li class="active">Course Registration</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Register Courses</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if ($msg) { ?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                            </div><?php } else if ($error) { ?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post">
                                            <div class="form-group">
                                                <label for="department" class="col-sm-2 control-label">Department</label>
                                                <div class="col-sm-10">
                                                    <select name="department" class="form-control" id="department" required>
                                                        <option value="">Select Department</option>
                                                        <?php
                                                        $sql = "SELECT DISTINCT Department FROM tbldept";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        foreach ($results as $result) {
                                                        ?>
                                                            <option value="<?php echo htmlentities($result->Department); ?>">
                                                                <?php echo htmlentities($result->Department); ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="series" class="col-sm-2 control-label">Series</label>
                                                <div class="col-sm-10">
                                                    <select name="series" class="form-control" id="series" required>
                                                        <option value="">Select Series</option>
                                                        <?php
                                                        $sql = "SELECT DISTINCT Series FROM tblclasses";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        foreach ($results as $result) {
                                                        ?>
                                                            <option value="<?php echo htmlentities($result->Series); ?>">
                                                                <?php echo htmlentities($result->Series); ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="semester" class="col-sm-2 control-label">Semester</label>
                                                <div class="col-sm-10">
                                                    <select name="semester" class="form-control" id="semester" required>
                                                        <option value="">Select Semester</option>
                                                        <?php
                                                        $sql = "SELECT DISTINCT Semester FROM tblclasses";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        foreach ($results as $result) {
                                                        ?>
                                                            <option value="<?php echo htmlentities($result->Semester); ?>">
                                                                <?php echo htmlentities($result->Semester); ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="courses" class="col-sm-2 control-label">Courses</label>
                                                <div class="col-sm-10">
                                                    <select name="courses[]" class="form-control" id="courses" multiple required>
                                                        <option value="">Select Courses</option>
                                                        <?php
                                                        $sql = "SELECT * FROM tblcourses";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        foreach ($results as $result) {
                                                        ?>
                                                            <option value="<?php echo htmlentities($result->CourseId); ?>">
                                                                <?php echo htmlentities($result->CourseName); ?> (<?php echo htmlentities($result->CourseType); ?>, <?php echo htmlentities($result->Credits); ?> credits)
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="register" class="btn btn-primary">Register</button>
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
    </div>
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
<?php } ?>