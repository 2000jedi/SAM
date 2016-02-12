<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 9/21/15
 * Time: 11:52
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/ManipulateUserClass.php";

$result = checkForceQuit();

$manipulation = new ManipulateUserClass();
$manipulation->listUserWithDefaultPassword();