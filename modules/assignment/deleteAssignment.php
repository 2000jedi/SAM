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

$sql = "DELETE FROM assignment WHERE id = $assignment AND teacher = '$teacher'";

if ($conn->query($sql) === TRUE) {
    echo "Successfully deleted one assignment.";
} else {
    echo "Unexpected Error";
}


?>