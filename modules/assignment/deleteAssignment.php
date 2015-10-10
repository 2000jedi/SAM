<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/4/15
 * Time: 00:20
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/ManipulateAssignmentClass.php";

$result = checkForceQuit();

$teacher = $result->uid;

$assignment = $_GET['assignment'];

$manipulation = new ManipulateAssignmentClass();
$manipulation->setAssignment($assignment);
$manipulation->deleteAssignment($teacher);


?>