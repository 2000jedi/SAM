<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 5/12/15
 * Time: 20:23
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/UserInfo.php";

$result = checkForceQuit();

$teacher = $result->uid;

$class = $_GET['class'];

$sql = "SELECT * from student WHERE class LIKE '%;$class;%' OR class LIKE '%;$class' ORDER BY id ASC";
$result = $conn->query($sql);

$studentArr = array();
$counter = 0;

while($row = $result->fetch_assoc()) {
    $id = $row['id'];

    $sql1 = "SELECT * FROM userInfo WHERE uid = '$id'";

    $result1 = $conn->query($sql1);

    while($row1 = $result1->fetch_assoc()) {
        $userInfo = new UserInfo();
        $userInfo->constructByDBRow($row1);
        $studentArr[$counter] = $userInfo;
    }
    $counter++;
}

echo json_encode($studentArr);

?>