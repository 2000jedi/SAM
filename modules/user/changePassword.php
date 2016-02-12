<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/15/15
 * Time: 15:36
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

checkForceQuit();

$username = $_COOKIE['username'];
$password = $_POST['oldPass'];
$newPass1 = $_POST['newPass'];

$result = checkValid($username, $password);

if ($result == false){
    echo "Wrong old password!";
}else{
    setcookie("password", $newPass1, time() + (86400 * 365), "/");
    $user = $result;
    echo $user->changePassword($newPass1);

}


?>