<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/21/15
 * Time: 09:02
 */


require $_SERVER['DOCUMENT_ROOT']."/modules/common/basic.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/activity/ManipulateActivityClass.php";

$result = checkForceQuit();

$id = $_POST["id"];

$userID = $result->uid;
$comment = $_POST["comment"];
$attachment = "null";
if ($_POST['hasAttachment'] == "true"){
    $attachment = processAttachment();
}

$manipulation = new ManipulateActivityClass();
$manipulation->constructByID($id);
$manipulation->constructInLoad($userID);
echo $manipulation->addComment($comment, $attachment);

?>