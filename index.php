<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/14/15
 * Time: 20:12
 */
/*
 * This file is critical to the entire system.
 *
 * If program detects that the user has not signed in, it will redirect the user to login.php
 *
 * If the program does detect the authorized user, it will determine whether the user is a student or a teacher.
 * For student, the page will include student.php.
 * For teacher, the page will include teacher.php.
 */
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/common/basic.php";
if ( isset($_COOKIE['username']) and isset($_COOKIE['password']) ) {
    $check = checkValid($_COOKIE["username"], $_COOKIE["password"]);
    if ( $check == false) {
        Redirect("/login.php");
    }else{
        $uid = $check->uid;
        $username = $_COOKIE['username'];
        $userType = substr($username, 0, 1);
        if ($userType == "s"){
            Redirect("/student.html");
        }elseif ($userType == "t") {
            require "teacher.php";
        }
    }
}else{
    Redirect("/login.php");
}
?>

<!--require $_SERVER['DOCUMENT_ROOT']."/template/scripts/UID.php";
require $_SERVER['DOCUMENT_ROOT']."/template/scripts/base.js";
require $_SERVER['DOCUMENT_ROOT']."/template/scripts/floatBox.js";
require $_SERVER['DOCUMENT_ROOT']."/template/scripts/class.js";
require $_SERVER['DOCUMENT_ROOT']."/template/scripts/settings.js";
require $_SERVER['DOCUMENT_ROOT']."/template/scripts/waterfall.js";
require $_SERVER['DOCUMENT_ROOT']."/template/scripts/assignment.js";
require $_SERVER['DOCUMENT_ROOT']."/template/scripts/activity.js";
require $_SERVER['DOCUMENT_ROOT']."/template/scripts/college.js";
require $_SERVER['DOCUMENT_ROOT']."/template/scripts/presentation.js";-->