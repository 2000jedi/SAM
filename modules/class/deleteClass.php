<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/21/15
 * Time: 17:02
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/class/ManipulateClassClass.php";

$result = checkForceQuit();

$teacher = $result->uid;

$class = $_GET['class'];

$manipulation = new ManipulateClassClass($class);
$manipulation->deleteClass();

?>