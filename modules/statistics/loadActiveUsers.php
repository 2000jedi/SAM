<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 10/27/15
 * Time: 02:01
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/statistics/StatisticsClass.php";

$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}else {

    $stat = new StatisticsClass();
    $stat->loadActiveUsers();

    /*
    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        $id = $row['uid'];
        $username = $row['username'];

        $s = new Security($id);
        $ipArr = $s->getIPs();

        for ($i = 0; $i < sizeof($ipArr); $i++){
            $html = "<div style='display: table'><div style='display: table-cell; width: 50px'>".$id."</div><div style='display: table-cell; width: 80px'>".$username."</div><div style='display: table-cell; width: 80px'>".$ipArr[$i]."</div></div>";

            echo $html;
        }
    }
    */
}

?>