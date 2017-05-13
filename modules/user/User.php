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

    function setUsername( $username ){
        $this->username = $username;
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

    function changeInfo($newInfo){
        global $conn;
        $sql = "UPDATE userInfo SET info = '$newInfo' WHERE uid = $this->uid";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Unexpected error.";
        }
    }

    function loadInfo(){
        global $conn;
        $sql = "SELECT info FROM userInfo WHERE uid = $this->uid";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            echo $row["info"];
            return;
        }
    }

    function __destruct(){}
}

function userVariableConversion($variable, $from, $to){
    global $conn;
    $output = "";
    $sql = "SELECT * FROM user WHERE $from = '$variable'";
    $result = $conn->query($sql);
    while($row = mysqli_fetch_assoc($result)) {
        $output = $row[$to];
    }
    return $output;
}

?>