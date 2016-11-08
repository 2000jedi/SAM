<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 4/12/16
 * Time: 11:48 PM
 */


require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/Student.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/College.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/UnitCollege.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/ManipulateCollegeClass.php";

$result = checkForceQuit();

$studentID = $result->uid;
$manipulation = new ManipulateCollegeClass();
echo $manipulation->updateChoice($studentID, $_POST["id"], $_POST['newChoice']);

?>