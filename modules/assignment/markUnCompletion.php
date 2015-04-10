<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/5/15
 * Time: 19:37
 */
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$student = $result->uid;

$id = $_POST['id'];

$sql = "DELETE FROM personalassignment WHERE assignment = '$id' AND uid = $student";

if ($conn->query($sql) === TRUE) {
    echo "Success!";
} else {
    echo "Unexpected error.";
}

?>