<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/5/15
 * Time: 21:52
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$username = $_GET['user'];

$sql = "SELECT * from user WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $email = $row['email'];
        $password = openssl_digest($row['password'], 'sha512');

        $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';

        $link = $protocol.$_SERVER['HTTP_HOST']."/modules/user/forgotPassword.php?code=".$username.";".$password;

        mail($email,"Reset Password", "Link for resetting password:\n".$link);

        die("The link for resetting password has been sent to your mailbox. If you did not set up your mailbox in SAM, the mail was sent to the developer's mailbox.");
    }
}else{
    die("The username does not exist!");
}

?>