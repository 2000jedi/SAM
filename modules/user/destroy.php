<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 7/1/16
 * Time: 2:41 PM
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/activity/ManipulateActivityClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/College.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/college/ManipulateCollegeClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/ManipulateUserClass.php";

$type = $_POST['type'];
$username = $_POST['username'];

$manipulation = new ManipulateUserClass();

$manipulation->destroy($username, $type);