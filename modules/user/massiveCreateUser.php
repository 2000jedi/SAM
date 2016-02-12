<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/16/15
 * Time: 19:33
 */
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/ManipulateUserClass.php";

$classprefix = $_POST['classprefix'];

$manipulation = new ManipulateUserClass();
$manipulation->massiveCreateUser($classprefix);


?>