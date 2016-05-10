<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/15/15
 * Time: 11:44
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/database/connect.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/User.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/statistics/OperationLog.php";

function checkValid($_username, $_password){
    $password = openssl_digest($_password, 'sha512');
    $sql = "SELECT * from user WHERE username = '$_username' AND password = '$password'";

    global $conn;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $user = new User($row["uid"]);

            $oL = new OperationLog();
            $oL->constructByInfo('', $user->uid, get_client_ip(), '', $_SERVER['REQUEST_URI']);
            $oL->writeIntoDB();
            // $s = new Security($user->uid);
            // $s->updateIP(get_client_ip());
            return $user;
        }
    } else {
        return false;
    }
}

function checkValidWithOutLog($_username, $_password){
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

function get_client_ip() {
    if ( function_exists( 'apache_request_headers' ) ) {
        $headers = apache_request_headers();
    } else {
        $headers = $_SERVER;
    }
    if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
        $the_ip = $headers['X-Forwarded-For'];
    } elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
    ){
        $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
    } else {
        $the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
    return $the_ip;
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