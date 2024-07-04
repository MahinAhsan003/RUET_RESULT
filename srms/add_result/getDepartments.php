<?php
include ('includes/config.php');

$sql = "SELECT DISTINCT Department FROM tblclasses";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        echo "<option value='" . htmlentities($result->id) . "'>" . htmlentities($result->Department) . "</option>";
    }
} else {
    echo "<option value=''>No departments available</option>";
}
?>