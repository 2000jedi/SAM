<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/12/15
 * Time: 18:43
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$name = $_POST["name"];
$sid = $_POST["studentID"];
$sql = "INSERT INTO recruit (name, sid) VALUES ('$name', '$sid')";
$conn->query($sql);
echo "Success! <a href='/'>Go to SAM</a>";

?>