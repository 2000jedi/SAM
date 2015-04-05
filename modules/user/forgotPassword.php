<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/5/15
 * Time: 22:17
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/common/basic.php";

$code = $_GET['code'];
$code = explode(";", $code);

$username = $code[0];
$pass = $code[1];

$sql = "SELECT * from user WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $password = openssl_digest($row['password'], 'sha512');

        if ($password == $pass){
            $newPass = openssl_digest("s20148123", 'sha512');
            $sql2 = "UPDATE user SET password = '$newPass' WHERE username = '$username'";
            if ($conn->query($sql2) === TRUE) {
                echo "Your password has been reset as '$username'. <a href='/login.php'>Sign in</a>";
            } else {
                echo "Unexpected error.";
            }
        }else{
            die("Invalid!");
        }
    }
}else{
    die("Invalid!");
}

?>