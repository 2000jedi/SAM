<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/15/15
 * Time: 16:06
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$username = $_COOKIE['username'];
$password = $_COOKIE['password'];
$info = $_POST['info'];


$user = $result;
echo $user->changeInfo($info);


?>