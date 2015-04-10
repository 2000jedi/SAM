<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/15/15
 * Time: 11:44
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/database/connect.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/User.php";

function checkValid($_username, $_password){
    $password = openssl_digest($_password, 'sha512');
    $sql = "SELECT * from user WHERE username = '$_username' AND password = '$password'";

    global $conn;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $user = new User($row["uid"]);
            return $user;
        }
    } else {
        return false;
    }
}

function checkForceQuit(){
    if ( isset($_COOKIE['username']) and isset($_COOKIE['password'])){
        $username = $_COOKIE['username'];
        $password = $_COOKIE['password'];
        $result = checkValid($username, $password);
        if ( $result == false ){
            die("You are detected as an unexpected intruder.");
        }else{
            $result->setUsername($username);
            return $result;
        }
    }else{
        die("You are detected as an unexpected intruder.");
    }

}

?>