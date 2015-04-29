<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/29/15
 * Time: 23:26
 */


require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/UnitAssignment.php";

$result = checkForceQuit();

$student = $result->uid;

$class = $_GET['class'];

$sql1 = "SELECT * FROM student WHERE id = '$student'";
$result1 = $conn->query($sql1);

while($row = $result1->fetch_assoc()) {

    $classIDs = explode(";",$row['class']);

    $newClassList = "";

    if (count($classIDs)>1){
        for ($i = 1; $i < count($classIDs) ; $i++){
            $classID = $classIDs[$i];
            if ( $classID == $class ){
                // Do nothing;
            }else{
                $newClassList .= ";".$classID;
            }
        }
    }
    $sql2 = "UPDATE student SET class = '$newClassList' WHERE id = '$student'";
    if ($conn->query($sql2) === TRUE) {
        echo "Success!";
    } else {
        echo "Unexpected error.";
    }

}

?>