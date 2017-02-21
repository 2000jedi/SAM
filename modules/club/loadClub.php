<?php
/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 2017/2/21
 * Time: 22:13
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/ManipulateClubClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitClub.php";

$result = checkForceQuit();

$cid = $_GET["id"];
$manipulation = new ManipulateClubClass();

if ($cid == -1){
    echo $manipulation->loadAllClubs();
}
else {
    echo $manipulation->loadClub($cid);
}
