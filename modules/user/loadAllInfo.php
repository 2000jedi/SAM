<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/15/15
 * Time: 16:06
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/UnitPersonalInfo.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/UnitClassofPersonalInfo.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/ManipulateUserClass.php";

$result = checkForceQuit();

$manipulation = new ManipulateUserClass();
$manipulation->loadUserPersonalInfo();

?>