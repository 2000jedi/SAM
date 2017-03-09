<?php
/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 2017/2/21
 * Time: 22:45
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/ManipulateClubClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitClub.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitPost.php";

$result = checkForceQuit();
$userID = $result->uid;
$admin = $result->username;
if ($admin != "t001"){
    die("Permission Denied!");
}

$class_name = $_GET["name"];
$organizer_id = $_GET["uid"];

$club = new ManipulateClubClass();
echo $club->addClub($name, $uid);
