<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/12/15
 * Time: 18:43
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/activity/ManipulateActivityClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/activity/UnitActivity.php";

$result = checkForceQuit();

$userID = $result->uid;

$manipulation = new ManipulateActivityClass();
$manipulation->constructInLoad($userID);
echo $manipulation->loadAllActivities();


?>