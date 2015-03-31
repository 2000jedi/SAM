<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/14/15
 * Time: 21:10
 */

$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_dbname = "missile";

// Create connection
$conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach ($_POST as $db_post_1_1 => $db_post_2_1) {
    $_POST[$db_post_1_1] = mysql_real_escape_string($db_post_2_1);
}
foreach ($_GET as $db_post_1_2 => $db_post_2_2) {
    $_GET[$db_post_1_2] = mysql_real_escape_string($db_post_2_2);
}

?>