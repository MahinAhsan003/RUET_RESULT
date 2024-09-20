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
        }
        $msg = "Result info added successfully";
    }

    // Process Make Result button click
    if (isset($_POST['makeResult'])) {
        // Collect student info
        $class = $_POST['class'];
        $studentid = $_POST['studentid'];

        // Fetch marks from DB for the student
        $sql = "SELECT CT_1, CT_2, CT_3, CT_4, Attendance, Assignment, `Semester Final` 
                FROM tblmarks 
                WHERE StudentId = :studentid AND ClassId = :class";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
        $query->bindParam(':class', $class, PDO::PARAM_STR);
        $query->execute();
        $marks = $query->fetch(PDO::FETCH_ASSOC);

        // Take the best 3 CT marks
        $ct_marks = [$marks['CT_1'], $marks['CT_2'], $marks['CT_3'], $marks['CT_4']];
        sort($ct_marks);
        $best_3_avg = array_sum(array_slice($ct_marks, 1)) / 3;

        // Calculate total score and SGPA for the student
        $total_score = $best_3_avg + $marks['Attendance'] + $marks['Assignment'] + $marks['Semester Final'];
        $sgpa = calculateSGPA($total_score);

        // Calculate CGPA based on past semesters
        $cgpa = calculateCGPA($studentid);

        // Generate PDF with student details
        generatePDF($studentid, $sgpa, $cgpa);
    }

    // Function to calculate SGPA based on total score
    function calculateSGPA($score) {
        // Use grading system logic provided
        if ($score >= 80) return 4.0;
        elseif ($score >= 75) return 3.75;
        elseif ($score >= 70) return 3.5;
        elseif ($score >= 65) return 3.25;
        elseif ($score >= 60) return 3.0;
        elseif ($score >= 55) return 2.75;
        elseif ($score >= 50) return 2.5;
        elseif ($score >= 45) return 2.25;
        elseif ($score >= 40) return 2.0;
        else return 0;  // Failed
    }

    // Function to calculate CGPA
    function calculateCGPA($studentid) {
        global $dbh;

        $sql = "SELECT SUM(Credits * GradePoints) AS total_grade_points, SUM(Credits) AS total_credits 
                FROM tblresult 
                WHERE StudentId = :studentid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result['total_credits'] > 0) {
            return $result['total_grade_points'] / $result['total_credits'];
        } else {
            return 0;
        }
    }

    // Function to generate PDF with results
    function generatePDF($studentid, $sgpa, $cgpa) {
        require('fpdf/fpdf.php');

        $pdf = new FPDF();
        $pdf->AddPage();

        // Set font and title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Student Results');

        // Add student information
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln();
        $pdf->Cell(40, 10, "Student ID: " . $studentid);
        $pdf->Ln();
        $pdf->Cell(40, 10, "SGPA: " . number_format($sgpa, 2));
        $pdf->Ln();
        $pdf->Cell(40, 10, "CGPA: " . number_format($cgpa, 2));

        // Save the file
        $pdf->Output('F', 'results/student_' . $studentid . '_result.pdf');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Result</title>
    <link rel="stylesheet" href="path_to_your_css/bootstrap.css"> <!-- Add the correct path to your Bootstrap -->
</head>
<body>
    <div class="container">
        <h2>Add Result</h2>

        <?php if ($msg) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlentities($msg); ?>
            </div>
        <?php } ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="class">Class:</label>
                <input type="text" class="form-control" name="class" required>
            </div>

            <div class="form-group">
                <label for="studentid">Student ID:</label>
                <input type="text" class="form-control" name="studentid" required>
            </div>

            <!-- Table for marks input (adapt as per your requirements) -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Populate this section dynamically with subjects -->
                    <tr>
                        <td>Subject 1</td>
                        <td><input type="text" name="marks[]" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td>Subject 2</td>
                        <td><input type="text" name="marks[]" class="form-control" required></td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>

            <!-- Submit and Make Result buttons -->
            <button type="submit" name="submit" class="btn btn-success">Submit Marks</button>
            <button type="submit" name="makeResult" class="btn btn-primary">Make Result</button>
        </form>
    </div>

    <script src="path_to_your_js/bootstrap.js"></script> <!-- Add the correct path to your Bootstrap JS -->
</body>
</html>
