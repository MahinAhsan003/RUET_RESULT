<?php
include ('includes/config.php');

$sql = "SELECT DISTINCT Department FROM tblclasses";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
        <option value="<?php echo htmlentities($result->Section); ?>">
            <?php echo htmlentities($result->Section); ?>
        </option> <?php }
} else {
    echo "<option value=''>No departments available</option>";
} ?>