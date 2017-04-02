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

$publisher = $result->uid;
$class_id = $_POST["cid"];
$title = $_POST["title"];
$information = $_POST["html"];
$attachment = $_POST["attachment"];

$club = new ManipulateClubClass();
echo $club->addPost($class_id, $publisher, $title, $information, $attachment);
