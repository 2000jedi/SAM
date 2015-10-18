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
        global $mode;

        $sql = "SELECT * from user WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $email = $row['email'];
                $password = openssl_digest($row['password'], 'sha512');

                $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';

                $link = $protocol.$_SERVER['HTTP_HOST']."/modules/user/forgotPassword.php?code=".$username.";".$password;

                if ($mode == "local"){
                    mail($email,"Reset Password", "Link for resetting password:\n".$link);
                    die($link);
                }else if ($mode == "SAE"){
                    $this->send_mail_lazypeople($email,"Reset Password","Link for resetting password: ".$link);
                    echo "The link for resetting password has been sent to your mailbox. If you did not set up your mailbox in SAM, the mail was sent to the developer's mailbox.";

                }
            }
        }else{
            die("The username does not exist!");
        }
    }

    function send_mail_lazypeople($to, $subject = 'Your register infomation', $body) {
        $loc_host = "SAE";
        $smtp_acc = "wflmswflms@sina.com";
        $smtp_pass="1234567890";
        $smtp_host="smtp.sina.com";
        $from="wflmswflms@sina.com";
        $headers = "Content-Type: text/plain; charset=\"utf-8\"\r\nContent-Transfer-Encoding: base64";
        $lb="\r\n";             //linebreak

        $hdr = explode($lb,$headers);
        if($body) {
            $bdy = preg_replace("/^\./","..",explode($lb,$body));
        }

        $smtp = array(
            array("EHLO ".$loc_host.$lb,"220,250","HELO error: "),
            array("AUTH LOGIN".$lb,"334","AUTH error:"),
            array(base64_encode($smtp_acc).$lb,"334","AUTHENTIFICATION error : "),
            array(base64_encode($smtp_pass).$lb,"235","AUTHENTIFICATION error : "));
        $smtp[] = array("MAIL FROM: <".$from.">".$lb,"250","MAIL FROM error: ");
        $smtp[] = array("RCPT TO: <".$to.">".$lb,"250","RCPT TO error: ");
        $smtp[] = array("DATA".$lb,"354","DATA error: ");
        $smtp[] = array("From: ".$from.$lb,"","");
        $smtp[] = array("To: ".$to.$lb,"","");
        $smtp[] = array("Subject: ".$subject.$lb,"","");
        foreach($hdr as $h) {
            $smtp[] = array($h.$lb,"","");
        }
        $smtp[] = array($lb,"","");
        if($bdy) {
            foreach($bdy as $b) {
                $smtp[] = array(base64_encode($b.$lb).$lb,"","");
            }
        }
        $smtp[] = array(".".$lb,"250","DATA(end)error: ");
        $smtp[] = array("QUIT".$lb,"221","QUIT error: ");
        $fp = @fsockopen($smtp_host, 25);
        if (!$fp) echo "Error: Cannot conect to ".$smtp_host." ";
        while($result = @fgets($fp, 1024)){
            if(substr($result,3,1) == " ") { break; }
        }

        $result_str="";
        foreach($smtp as $req){
            @fputs($fp, $req[0]);
            if($req[1]){
                while($result = @fgets($fp, 1024)){
                    if(substr($result,3,1) == " ") { break; }
                };
                if (!strstr($req[1],substr($result,0,3))){
                    $result_str.=$req[2].$result." ";
                }
            }
        }
        @fclose($fp);
        return $result_str;
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
     * studentInClass() echos a table like follows
     * Student subjectA subjectB subjectC
     * AAA     Tick              Tick
     * BBB     Tick     Tick     Tick
     * CCC     Tick     Tick
     * Then admin can decide which subject teacher should join SAM the next to maximize our working efficiency
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

    function studentInClass(){
        global $conn;

        $sql = "SELECT * FROM student ORDER BY id ASC";
        $student = $conn->query($sql);
        // $student contains the query result of enumeration of students with their classes.

        $sql = "SELECT * FROM teacher";
        $subjects = $conn->query($sql);
        // $teacher contains the query result of enumeration of teachers with their subjects.

        $subjectsProcessed = array();
        $subjectsCnt = 0;
        while ($i = $subjects->fetch_assoc()){
            if ( array_search($i['subject'],$subjectsProcessed) === false ){
                $subjectsProcessed[$subjectsCnt] = $i['subject'];
                $subjectsCnt++;
            }
        }
        // This part puts all the subjects into $subjectsProcessed.

        $tableHTML = "";

        $classHTML = "<div style='display: table'><div style='display: table-cell; width: 100px; border: 1px solid #CCC; padding: 0.5em'>username</div>";

        for($i = 0; $i < $subjectsCnt; $i++){
            $classHTML = $classHTML."<div style='display: table-cell; width: 80px; border: 1px solid #CCC; padding: 0.5em'>$subjectsProcessed[$i]</div>";
        }

        $classHTML = $classHTML."</div>";


        while ($i = $student->fetch_assoc()){
            $tableHTML = $tableHTML.$classHTML;
            $studentId = $i['id'];

            $sql = "SELECT * FROM user where uid = '$studentId'";
            $result = $conn->query($sql);
            while ($row1 = $result->fetch_assoc()){
                $studentName = $row1['username'];
                // Find the username of each user by uid

                $tableHTML = $tableHTML."<div style='display: table'><div style='display: table-cell; width: 100px; border: 1px solid #CCC; padding: 0.5em'>$studentName</div>";

                $studentSubjects = array();
                // set up $studentSubjects as an empty array for later addition of elements

                $studentClass = explode(';',substr($i['class'],1));

                $studentSubjectsCounter = 0;
                foreach ($studentClass as $j){
                    $sql = "SELECT * FROM class where id = '$j'";
                    $result = $conn->query($sql);

                    while ($row2 = $result->fetch_assoc()){
                        $teacherId = $row2['teacher'];
                        $sql = "SELECT subject FROM teacher where id = '$teacherId'";
                        $result = $conn->query($sql);

                        while ($row3 = $result->fetch_assoc()){
                            $subjectName = $row3['subject'];


                            if ( array_search($subjectName, $studentSubjects) === false ){
                                $studentSubjects[$studentSubjectsCounter] = $subjectName;
                                $studentSubjectsCounter++;
                            }

                            // array_push($studentSubjects, array_search($subjectName, $subjectsProcessed));
                        }

                    }
                }
                // $studentSubjects contains all the subject the student has


                for ($j = 0; $j < $subjectsCnt; $j++){
                    if ( array_search($subjectsProcessed[$j], $studentSubjects) === false ){
                        $tableHTML = $tableHTML."<div style='display: table-cell; width: 80px; border: 1px solid #CCC; padding: 0.5em'></div>";
                    }else{
                        $tableHTML = $tableHTML."<div style='display: table-cell; width: 80px; border: 1px solid #CCC; padding: 0.5em; background: #FFFF00'>√</div>";
                    }
                    // If an element in $studentSubjects is the same as that in $subjectProcessed, tick; otherwise, do nothing.
                }

                $tableHTML = $tableHTML."</div>";
            }
        }
        echo $tableHTML;
    }

    // Part III ends

}