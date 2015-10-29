<?php
/*
Author: Jedi
Date: 2015/10/29
*/

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/statistics/StatisticsClass.php";

$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}
else{
    $Statistics = new StatisticsClass;
    $Statistics -> getIPs();
}
?>