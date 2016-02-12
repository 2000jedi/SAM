<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 9/14/15
 * Time: 21:31
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/client/classes/Device.php";

$username = $_POST['username'];
$password = $_POST['password'];

$result = checkValid($username, $password);

if ($result == false){
    die("Permission Denied");
}else{
    $token = $_POST['token'];
    $platform = $_POST['platform'];
    $uid = $result->uid;

    $device = new Device($uid);
    $device->updateToken($platform, $token);

}




?>