<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 10/17/15
 * Time: 15:31
 */
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/ManipulateAssignmentClass.php";

$result = checkForceQuit();

$teacher = $result->uid;

$assignment = $_POST['assignment'];
$manipulation = new ManipulateAssignmentClass();
$manipulation->setAssignment($assignment);

$students = explode(";", $_POST['students']);
$scores = explode(";", $_POST['scores']);
for ($i = 1; $i < sizeof($scores); $i++){
    $oneStudent = $students[$i];
    $oneScore = $scores[$i];

    $manipulation->updatePersonalScore($oneStudent, $oneScore);
}


?>