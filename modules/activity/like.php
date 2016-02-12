<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/15/15
 * Time: 12:08
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/activity/ManipulateActivityClass.php";

$result = checkForceQuit();

$userID = $result->uid;

$id = $_GET["id"];

$manipulation = new ManipulateActivityClass();
$manipulation->constructInLoad($userID);
$manipulation->constructByID($id);
echo $manipulation->like();


?>