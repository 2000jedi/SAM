<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/12/15
 * Time: 18:43
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}else {
    $sql = "SELECT * FROM recruit";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $sid = $row['sid'];
        echo "<div style='table; width: 100%'><div style='display: table-cell; width: 100px'>$name</div><div style='display: table-cell; width:100px'>$sid</div></div>";
    }
}

?>