<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/22/15
 * Time: 01:12
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/ManipulateAssignmentClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/UnitAssignment.php";

$result = checkForceQuit();

$userID = $result->uid;

$class = $_GET['class'];

$manipulation = new ManipulateAssignmentClass();
echo $manipulation->classLoadAssignment($class);


?>