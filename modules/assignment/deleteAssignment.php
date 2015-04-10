<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/4/15
 * Time: 00:20
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$teacher = $result->uid;

$assignment = $_GET['assignment'];

$sql = "DELETE FROM assignment WHERE id = '$assignment' AND teacher = '$teacher'";
$sql2 = "DELETE FROM personalassignment WHERE assignment = '$assignment'";

if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE ) {
    echo "Successfully deleted one assignment.";
} else {
    echo "Unexpected Error";
}


?>