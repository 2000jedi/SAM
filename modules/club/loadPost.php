<?php
/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 2017/2/23
 * Time: 23:30
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/ManipulateClubClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitClub.php";

$result = checkForceQuit();

$pid = $_GET["postid"];

$manipulation = new ManipulateClubClass();
echo $manipulation->loadPost($pid);
