<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/16/15
 * Time: 19:31
 */

function create($username, $type){

    $result = checkForceQuit();

    $admin = $result->username;

    if ($admin != "t001"){
        die("Permission Denied!");
    }else{
        //$type = $_POST['type'];
        //$username = $_POST['username'];
        $password = openssl_digest($username, 'sha512');
        $email = "sam@developersam.com";

        $sql = "INSERT INTO user (username, password, email) VALUES ('$username', '$password', '$email')";

        global $conn;

        if ($conn->query($sql) === TRUE) {
            echo "Success<br>";
        } else {
            echo "Unexpected error 1.";
        }

        $sql2 = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql2);

        $id = "";

        while($row = $result->fetch_assoc()) {
            $id = $row['uid'];
        }

        $sql3 = "";

        if ($type == "s"){
            $sql3 = "INSERT INTO student (id, class) VALUES ('$id', '')";
        }else if ($type == "t"){
            $subject = $_POST['subject'];
            $sql3 = "INSERT INTO teacher (id, subject) VALUES ('$id', '$subject')";
        }

        if ($conn->query($sql3) === TRUE) {
            echo "Success<br>";
        } else {
            echo "Unexpected error 3.";
        }

    }
}

?>