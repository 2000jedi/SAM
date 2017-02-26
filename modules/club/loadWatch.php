<?php
/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 2017/2/21
 * Time: 22:18
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/ManipulateClubClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitClub.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitPost.php";

$result = checkForceQuit();
$userID = $result->uid;

$manipulation = new ManipulateClubClass();
echo $manipulation->loadWatchClubs($userID);
