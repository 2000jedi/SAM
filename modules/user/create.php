<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/14/15
 * Time: 21:25
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/ManipulateUserClass.php";

$type = $_POST['type'];
$username = $_POST['username'];

$manipulation = new ManipulateUserClass();

$manipulation->create($username, $type);

?>