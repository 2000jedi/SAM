<?php
    require $_SERVER['DOCUMENT_ROOT']."/modules/user/ManipulateUserClass.php";
    require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

    $result = checkForceQuit();
    if ($result->username != "t001"){
        die("Permission Denied!");
    }else {

        $manipulation = new ManipulateUserClass();
        $manipulation->studentInClass();
    }
?>