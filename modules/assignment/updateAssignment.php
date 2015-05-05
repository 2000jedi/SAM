<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/5/15
 * Time: 19:37
 */
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$teacher = $result->uid;

$id = $_POST['id'];
$content = $_POST['content'];

$sql = "UPDATE assignment SET content = '$content' WHERE id = '$id' AND teacher = '$teacher'";

if ($conn->query($sql) === TRUE) {
    echo "Success!";
} else {
    echo "Unexpected error.";
}

?>