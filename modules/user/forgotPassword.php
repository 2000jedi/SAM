<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/5/15
 * Time: 22:17
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/ManipulateUserClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/common/basic.php";

$code = $_GET['code'];

$manipulation = new ManipulateUserClass();
$manipulation->forgotPasswordReset($code);

?>