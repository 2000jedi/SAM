<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/22/15
 * Time: 20:36
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/activity/ManipulateActivityClass.php";

$result = checkForceQuit();

$userID = $result->uid;

$id = $_GET["id"];

$manipulation = new ManipulateActivityClass();
echo $manipulation->deleteActivityComment($id, $userID);


?>