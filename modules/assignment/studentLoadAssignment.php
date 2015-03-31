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

$student = $result->uid;

$sql = "SELECT * from assignment WHERE receiver = '$student' ORDER BY dueday ASC";
$result = $conn->query($sql);

$arr = array();
$counter = 0;

while($row = $result->fetch_assoc()) {

    $id = $row['id'];
    $type = $row['type'];
    $content = $row['content'];
    $attachment = $row['attachment'];
    $dueday = $row['dueday'];
    $duration = $row['duration'];
    $class = $row['class'];
    $receiver = $row['receiver'];
    $teacher = $row['teacher'];
    $unitAssignment = new UnitAssignment($id, $type, $content, $attachment, $dueday, $duration, $class, $receiver, $teacher);
    $arr[$counter] = $unitAssignment;
    $counter++;
}

echo json_encode($arr);

?>