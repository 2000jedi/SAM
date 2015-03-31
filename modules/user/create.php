<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/14/15
 * Time: 21:25
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/common/crypto.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/database/connect.php";

$username = $_GET['username'];
$email = $_GET['email'];
$password = openssl_digest($username, 'sha512');

$sql = "INSERT INTO user (username, password, email) VALUES ('$username', '$password', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "Success";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>