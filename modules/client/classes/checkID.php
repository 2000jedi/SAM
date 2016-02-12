<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 9/14/15
 * Time: 22:32
 */
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/client/classes/Device.php";

$username = $_POST['username'];
$password = $_POST['password'];

$result = checkValid($username, $password);

if ($result == false){
    die("false");
}else {
    die("true");
}
?>