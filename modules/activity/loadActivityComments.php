<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/12/15
 * Time: 21:05
 */


require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/activity/ManipulateActivityClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/activity/UnitActivityComment.php";

$result = checkForceQuit();

$aid = $_GET["id"];

$manipulation = new ManipulateActivityClass();
$manipulation->constructByID($aid);
echo $manipulation->loadComments();


?>