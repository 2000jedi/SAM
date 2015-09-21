<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 9/21/15
 * Time: 11:52
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}else {

    processUserFromAClass("201381");
    processUserFromAClass("201382");
    processUserFromAClass("201383");
    processUserFromAClass("201384");
    processUserFromAClass("201385");
    processUserFromAClass("201386");
    processUserFromAClass("201387");
    processUserFromAClass("201481");
    processUserFromAClass("201482");
    processUserFromAClass("201483");
    processUserFromAClass("201484");
    processUserFromAClass("201485");
    processUserFromAClass("201486");
    processUserFromAClass("201581");
    processUserFromAClass("201581");
    processUserFromAClass("201582");
    processUserFromAClass("201583");
    processUserFromAClass("201584");
    processUserFromAClass("201585");
    processUserFromAClass("201586");

}


function processUserFromAClass($classprefix){

    $type = "s";

    for ($i = 1; $i < 36; $i++){

        if ($i < 10){
            $i = "0".$i;
        }

        $username = $type.$classprefix.$i;

        checkAndOutput($username);
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