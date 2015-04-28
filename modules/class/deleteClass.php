<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/21/15
 * Time: 17:02
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$teacher = $result->uid;

$class = $_GET['class'];

$sql0 = "SELECT * FROM assignment WHERE class = '$class'";
$result = $conn->query($sql0);

while($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $sql4 = "DELETE FROM personalassignment WHERE assignment = '$id'";
    $conn->query($sql4);
}

$sql = "DELETE FROM assignment WHERE class = '$class'";
$conn->query($sql);


$sql = "SELECT * from student WHERE class LIKE '%;$class%'";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $classIDs = explode(";", $row['class']);
    $newStr = "";

    for ($i = 1; $i < count($classIDs); $i++) {
        $classID = $classIDs[$i];
        if ($classID != $class){
            $newStr = $newStr.";".$classID;
        }
    }

    $sql2 = "UPDATE student SET class = '$newStr' WHERE id = $id";
    $conn->query($sql2);

}

$sql3 = "DELETE FROM class WHERE id = '$class'";
$conn->query($sql3);

echo "The class is removed from the server.";

?>