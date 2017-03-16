<?php
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitClub.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitPost.php";

$result = checkForceQuit();
$admin = $result->username;
$cid = $_GET['id'];

$club = new UnitClub($cid);

if ($club->organizer != $admin){
    die("Permission Denied!");
}else {
    // do nothing
}
