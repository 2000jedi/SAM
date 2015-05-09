<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/22/15
 * Time: 01:12
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/UnitAssignment.php";

$result = checkForceQuit();

$userID = $result->uid;
$class = $_GET['class'];

$sql = "SELECT * FROM assignment WHERE class = '$class' AND dueday > (curdate() - 180) ORDER BY dueday DESC";
$result = $conn->query($sql);

$arr = array();
$counter = 0;

while($row = $result->fetch_assoc()) {

    $unitAssignment = new UnitAssignment();
    $unitAssignment->constructFromDBRow($row, $class, false);
    $arr[$counter] = $unitAssignment;
    $counter++;
}

echo json_encode($arr);

?>