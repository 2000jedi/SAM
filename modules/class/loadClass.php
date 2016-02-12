<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/21/15
 * Time: 16:09
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/class/UnitClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/class/ManipulateClassClass.php";

$manipulation = new ManipulateClassClass("");
$manipulation->loadClass();
?>