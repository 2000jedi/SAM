<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 2/17/16
 * Time: 5:40 PM
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/UnitStudent.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/Student.php";

$result = checkForceQuit();

$studentID = $result->uid;
$student = new Student($studentID);

echo json_encode($student->toUnitStudent());
?>