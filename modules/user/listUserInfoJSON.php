<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 7/1/16
 * Time: 2:05 PM
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/ManipulateUserClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/UserInfo.php";

$manipulation = new ManipulateUserClass();
$manipulation->listUserInfoJSON();

?>