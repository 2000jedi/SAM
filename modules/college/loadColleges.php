<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 2/17/16
 * Time: 5:39 PM
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/Student.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/College.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/UnitCollege.php";

$result = checkForceQuit();

$studentID = $result->uid;
$manipulation = new ManipulateCollegeClass();

echo $manipulation->loadColleges($studentID);

?>