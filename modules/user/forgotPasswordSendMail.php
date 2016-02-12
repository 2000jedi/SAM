<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/5/15
 * Time: 21:52
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/ManipulateUserClass.php";

$username = $_GET['user'];

$manipulation = new ManipulateUserClass();
$manipulation->forgotPasswordSentMail($username);

?>