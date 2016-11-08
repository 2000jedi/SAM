<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 2/17/16
 * Time: 5:21 PM
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/Student.php";

$result = checkForceQuit();

$studentID = $result->uid;
$student = new Student($studentID);

$ibScore = $_POST["ibScore"];
$satScore = $_POST["satScore"];
$actScore = $_POST["actScore"];
$toeflScore = $_POST["toeflScore"];
$ieltsScore = $_POST["ieltsScore"];
$numberOfAwards = $_POST["numberOfAwards"];

echo $student->updateScore($ibScore, $satScore, $actScore, $toeflScore, $ieltsScore, $numberOfAwards);


?>