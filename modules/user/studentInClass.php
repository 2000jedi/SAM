<?php
    require $_SERVER['DOCUMENT_ROOT']."/modules/user/ManipulateUserClass.php";
    require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

    $result = checkForceQuit();
    
    $manipulation = new ManipulateUserClass();
    $manipulation->studentInClass();
?>