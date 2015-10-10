<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 5/12/15
 * Time: 20:23
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/UserInfo.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/class/ManipulateClassClass.php";

$result = checkForceQuit();

$teacher = $result->uid;

$class = $_GET['class'];

$manipulation = new ManipulateClassClass($class);
$arr = $manipulation->loadClassMembers();

echo json_encode($arr);

?>