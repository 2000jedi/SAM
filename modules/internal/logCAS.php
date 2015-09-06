<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 9/2/15
 * Time: 07:40
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/createFunction.php";

$result = checkForceQuit();

$student = $result->uid;

$time = $_POST['time'];
$narration = $_POST['narration'];

$sql = "INSERT INTO internalCAS (id, time, narration) VALUES ('$uid', '$time', '$narration')";

if ($conn->query($sql) === TRUE) {
    echo "Success";
} else {
    echo "Unexpected error 1.";
}

?>