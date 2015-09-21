<?php
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}else {
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
}

?>