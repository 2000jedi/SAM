<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/15/15
 * Time: 11:38
 */

class User {

    var $uid;
    var $username;
    var $password;

    function __construct( $uid ){
        $this->uid = $uid;
    }

    function changePassword($_newPassword){
        global $conn;
        $newPassword = openssl_digest($_newPassword, 'sha512');
        $sql = "UPDATE user SET password = '$newPassword' WHERE uid = $this->uid";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Unexpected error.";
        }
    }

    function changeEmail($email){
        global $conn;
        $sql = "UPDATE user SET email = '$email' WHERE uid = $this->uid";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Unexpected error.";
        }
    }

    function __destruct(){}
}

?>