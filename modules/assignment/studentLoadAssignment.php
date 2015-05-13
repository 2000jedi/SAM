<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/22/15
 * Time: 01:12
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/UnitAssignment.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/studentLoadAssignmentFunction.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/client/v1/assignment/updateNotificationRaw.php";

$result = checkForceQuit();

$student = $result->uid;

$newNotificationRaw = studentLoadAssignment($student);

updateNotificationRaw($student, $newNotificationRaw);

echo $newNotificationRaw;

?>