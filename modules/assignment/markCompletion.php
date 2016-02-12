<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/5/15
 * Time: 19:37
 */
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/ManipulateAssignmentClass.php";

$result = checkForceQuit();

$student = $result->uid;

$id = $_POST['id'];
$actual = $_POST['actual'];

$manipulation = new ManipulateAssignmentClass();
$manipulation->setAssignment($id);
$manipulation->markCompletion($actual, $student);


?>