<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/20/15
 * Time: 22:15
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/common/basic.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/activity/ManipulateActivityClass.php";

$result = checkForceQuit();

$organizer = $result->uid;
$name = $_POST["name"];
$description = $_POST["description"];
$deal = $_POST["deal"];
$attachment = "null";
if ($_POST['hasAttachment'] == "true"){
    $attachment = processAttachment();
}

$manipulation = new ManipulateActivityClass();
$manipulation->constructForAddAndProcessActivity($organizer, $name, $description, $attachment, $deal);
$manipulation->addActivity();

?>