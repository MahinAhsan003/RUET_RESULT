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
    $result = $query->fetch(PDO::FETCH_OBJ);

    if (!$result) {
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Portal | Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>
<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <nav class="navbar top-navbar bg-white box-shadow">
            <div class="container-fluid">
                <div class="navbar-header no-padding">
                    <a class="navbar-brand" href="dashboard.php">Student Portal</a>
                </div>
                <ul class="nav navbar-nav navbar-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                    <li class="hidden-xs">
                        <a href="#">Welcome, <?php echo htmlentities($result->StudentName); ?></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="content-wrapper">
            <div class="content-container">
                <div class="left-sidebar bg-black-300 box-shadow">
                    <div class="sidebar-content">
                        <div class="user-info closed">
                            <span class="name"><?php echo htmlentities($result->StudentName); ?></span>
                        </div>
                        <ul class="list-unstyled">
                            <li><a href="course-registration.php"><i class="fa fa-pencil"></i> Course Registration</a></li>
                            <li><a href="result.php"><i class="fa fa-file-text"></i> Check Result</a></li>
                        </ul>
                    </div>
                </div>

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-sm-6">
                                <h2 class="title">Dashboard</h2>
                            </div>
                        </div>
                    </div>

                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <h3>Student Information</h3>
                                            <p><strong>Roll ID:</strong> <?php echo htmlentities($result->RollId); ?></p>
                                            <p><strong>Registration ID:</strong> <?php echo htmlentities($result->RegistrationId); ?></p>
                                            <p><strong>Name:</strong> <?php echo htmlentities($result->StudentName); ?></p>
                                            <p><strong>Email:</strong> <?php echo htmlentities($result->StudentEmail); ?></p>
                                            <p><strong>Department:</strong> <?php echo htmlentities($result->Department); ?></p>
                                            <p><strong>Section:</strong> <?php echo htmlentities($result->Section); ?></p>
                                            <p><strong>Series:</strong> <?php echo htmlentities($result->Series); ?></p>
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
</body>
</html>
