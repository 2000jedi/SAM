<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/21/15
 * Time: 16:09
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/class/UnitClass.php";

$result = checkForceQuit();

$user = $result->uid;
$userType = substr($_COOKIE['username'], 0, 1);

$sql = "SELECT * from class WHERE teacher='$user'";
if ($userType == "s"){
    $sql = "SELECT * from student WHERE id='$user'";
}
$result = $conn->query($sql);

$arr = array();
$counter = 0;

while($row = $result->fetch_assoc()) {
    if ($userType == "t") {
        $id = $row['id'];
        $teacher = $row['teacher'];
        $name = $row['name'];
        $unitClass = new UnitClass($id, $teacher, $name);
        $arr[$counter] = $unitClass;
        $counter++;
    }else{
        $classIDs = explode(";",$row['class']);
        $sql2 = "SELECT * from class WHERE id = '$classIDs[1]'";
        for ($i = 2; $i < sizeof($classIDs); $i++){
            $sql2 = $sql2." OR id = '$classIDs[$i]'";
        }
        $result2 = $conn->query($sql2);
        while($row2 = $result2->fetch_assoc()) {
            $id = $row2['id'];
            $teacher = $row2['teacher'];
            $name = $row2['name'];
            $unitClass = new UnitClass($id, $teacher, $name);
            $arr[$counter] = $unitClass;
            $counter++;
        }

    }
}

echo json_encode($arr);

?>