<?php
/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 2017/2/23
 * Time: 23:29
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/ManipulateClubClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitClub.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitPost.php";

$result = checkForceQuit();

$cid = $_GET["cid"];

$manipulation = new ManipulateClubClass();
echo $manipulation->loadPosts($cid);
