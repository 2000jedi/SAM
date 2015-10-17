<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 10/17/15
 * Time: 16:00
 */


require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/UserInfo.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/class/ManipulateClassClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/ManipulateAssignmentClass.php";

$result = checkForceQuit();

$teacher = $result->uid;

$manipulate = new ManipulateAssignmentClass();
$manipulate->setAssignment($_GET['assignment']);
$scores = $manipulate->loadPersonalScores();

echo json_encode($scores);


?>