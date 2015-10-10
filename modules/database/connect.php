<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/14/15
 * Time: 21:10
 */

require $_SERVER['DOCUMENT_ROOT']."/config.php";

$conn;

if ($mode == "local"){
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_dbname = "missile";


// Create connection
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
    $conn->set_charset("utf8");

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
}else if ($mode == "SAE"){
    $conn = new mysqli(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS,"app_wflmssam");

    foreach ($_POST as $db_post_1_1 => $db_post_2_1) {
        $_POST[$db_post_1_1] = addslashes($db_post_2_1);
    }
    foreach ($_GET as $db_post_1_2 => $db_post_2_2) {
        $_GET[$db_post_1_2] = addslashes($db_post_2_2);
    }
}



?>