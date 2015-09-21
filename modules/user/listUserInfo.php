<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 9/6/15
 * Time: 19:14
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";


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
?>