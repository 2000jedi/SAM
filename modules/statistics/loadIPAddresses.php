<?php
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/ManipulateUserClass.php";

$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}else {
    $manipulation = new ManipulateUserClass();
    $manipulation->enumUserIP();
}

?>