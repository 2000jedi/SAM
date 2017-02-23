<?php
/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 2017/2/23
 * Time: 23:08
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/ManipulateClubClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitClub.php";

$result = checkForceQuit();
$userID = $result->uid;

$cid = $_GET["cid"];

$manipulation = new ManipulateClubClass();
echo $manipulation->leaveClub($cid, $userID);
