<?php
include ('includes/config.php');
if (isset($_POST['departmentId'])) {
    $departmentId = $_POST['departmentId'];
    $sql = "SELECT DISTINCT series_name FROM tblseries WHERE department_id = :departmentId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            echo "<option value='" . htmlentities($result->series_name) . "'>" . htmlentities($result->series_name) . "</option>";
        }
    } else {
        echo "<option value=''>No series available</option>";
    }
}
?>