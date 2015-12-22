<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/22/15
 * Time: 18:36
 */
require $_SERVER['DOCUMENT_ROOT']."/modules/common/basic.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/activity/ManipulateActivityClass.php";

$result = checkForceQuit();

$id = $_GET["id"];

$manipulation = new ManipulateActivityClass();
$manipulation->constructByID($id);
echo $manipulation->loadMembersName();


?>