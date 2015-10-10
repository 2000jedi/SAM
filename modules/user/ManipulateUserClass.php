<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 10/9/15
 * Time: 13:28
 */

class ManipulateUserClass {

    function __construct(){
        // Do nothing
    }

    /*
     *
     * In this page, only the function listed by commented shall be called from outside.
     *
     */

    /*
     *
     * Part I: Create User
     * This part of code is used by the admin panel developed by Sam Chou.
     * They can be called only with t001, which is verified in the function create()
     *
     * create($username, $type) is used to create a single user,
     * where $username is like 's20148123' and type is either 's' or 't'
     *
     * massiveCreateUser($classprefix) is used to generate a class of students
     * $classprefix has the form of 201X0X, when one student in the class may have username like 's201X0XAA'
     *
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

    function massiveCreateUser($classprefix){
        $type = "s";

        for ($i = 1; $i < 36; $i++){

            if ($i < 10){
                $i = "0".$i;
            }

            $username = $type.$classprefix.$i;
            echo $username." is created.<br>";
            $this->create($username, $type);
        }
    }
    // Part I ends


    /*
     *
     * Part II: Forgot Password
     * This part of code is used by the users who forget password
     * They can be called by anyone who can verify himself or herself.
     *
     * forgotPasswordSentMain($username) is used to send an reset email to the mailbox of the user
     * $username is the username of the user who forgets password.
     *
     * forgotPasswordReset($code) is used to check the code of verification email. If it is right, process.
     * $code is the code included in the link in the email.
     */
    function forgotPasswordSentMail($username){
        global $conn;

        $sql = "SELECT * from user WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $email = $row['email'];
                $password = openssl_digest($row['password'], 'sha512');

                $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';

                $link = $protocol.$_SERVER['HTTP_HOST']."/modules/user/forgotPassword.php?code=".$username.";".$password;

                mail($email,"Reset Password", "Link for resetting password:\n".$link);

                die($link);
            }
        }else{
            die("The username does not exist!");
        }
    }

    function forgotPasswordReset($code){
        global $conn;

        $code = explode(";", $code);

        $username = $code[0];
        $pass = $code[1];

        $sql = "SELECT * from user WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $password = openssl_digest($row['password'], 'sha512');

                if ($password == $pass){
                    $newPass = openssl_digest($username, 'sha512');
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
    }
    // Part II ends



    /*
     *
     * Part III: List Users
     * This part is used by admin to analyze users
     *
     * listUserInfo() lists the following info:
     *  uid, username, Chinese name, English name
     *
     * listUserWithDefaultPassword() lists the user info of those who have default password
     *
     */
    function listUserInfo(){
        global $conn;

        $result = checkForceQuit();

        $admin = $result->username;

        if ($admin != "t001"){
            die("Permission Denied!");
        }else{

            $sql = "SELECT * FROM userInfo";
            $result = $conn->query($sql);

            $id = "";

            while($row = $result->fetch_assoc()) {
                $id = $row['uid'];
                $username = $row['username'];
                $ChineseName = $row['ChineseName'];
                $EnglishName = $row['EnglishName'];

                $html = "<div style='display: table'><div style='display: table-cell; width: 50px'>".$id."</div><div style='display: table-cell; width: 80px'>".$username."</div><div style='display: table-cell; width: 80px'>".$ChineseName."</div><div style='display: table-cell; width: 80px'>".$EnglishName."</div></div>";

                echo $html;
            }
        }
    }

    function listUserWithDefaultPassword(){
        $result = checkForceQuit();

        $admin = $result->username;

        if ($admin != "t001"){
            die("Permission Denied!");
        }else {

            $this->processUserFromAClass("201381");
            $this->processUserFromAClass("201382");
            $this->processUserFromAClass("201383");
            $this->processUserFromAClass("201384");
            $this->processUserFromAClass("201385");
            $this->processUserFromAClass("201386");
            $this->processUserFromAClass("201387");
            $this->processUserFromAClass("201481");
            $this->processUserFromAClass("201482");
            $this->processUserFromAClass("201483");
            $this->processUserFromAClass("201484");
            $this->processUserFromAClass("201485");
            $this->processUserFromAClass("201486");
            $this->processUserFromAClass("201581");
            $this->processUserFromAClass("201581");
            $this->processUserFromAClass("201582");
            $this->processUserFromAClass("201583");
            $this->processUserFromAClass("201584");
            $this->processUserFromAClass("201585");
            $this->processUserFromAClass("201586");

        }
    }

    function processUserFromAClass($classprefix){

        $type = "s";

        for ($i = 1; $i < 36; $i++){

            if ($i < 10){
                $i = "0".$i;
            }

            $username = $type.$classprefix.$i;

            $this->checkAndOutput($username);
        }
    }

    function checkAndOutput($username){
        global $conn;
        $password = openssl_digest($username, 'sha512');

        $resultOfCheck = checkValid($username, $username);
        if ($resultOfCheck == false) {

        } else {
            $sql = "SELECT * FROM userInfo WHERE username = '$username'";
            $result = $conn->query($sql);

            $id = "";

            while ($row = $result->fetch_assoc()) {
                $id = $row['uid'];
                $username = $row['username'];
                $ChineseName = $row['ChineseName'];
                $EnglishName = $row['EnglishName'];

                $html = "<div style='display: table'><div style='display: table-cell; width: 50px'>" . $id . "</div><div style='display: table-cell; width: 80px'>" . $username . "</div><div style='display: table-cell; width: 80px'>" . $ChineseName . "</div><div style='display: table-cell; width: 80px'>" . $EnglishName . "</div></div>";

                echo $html;
            }
        }
    }
    // Part III ends


}