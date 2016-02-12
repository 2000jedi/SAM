<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 9/25/15
 * Time: 00:16
 */


require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/UserInfo.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/class/UnitClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/class/ManipulateClassClass.php";

$class = $_POST['class'];

$manipulation = new ManipulateClassClass($class);
$manipulation->changeClassMembers($_POST['studentList']);


?>