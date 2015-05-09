<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/22/15
 * Time: 01:12
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/UnitAssignment.php";

$result = checkForceQuit();

$student = $result->uid;

$sql = "SELECT * from student WHERE id='$student'";
$result = $conn->query($sql);

$sqlForClass = "";

while($row = $result->fetch_assoc()) {
    $classIDs = explode(";",$row['class']);

    $sqlForClass = "class = ".$classIDs[1]." ";

    if (count($classIDs)>1){
        for ($i = 2; $i < count($classIDs) ; $i++){
            $classID = $classIDs[$i];
            $sqlForClass = $sqlForClass."OR class = ".$classIDs[$i]." ";
        }
    }
}

$sqlForClass = "(".$sqlForClass.")";

if ($sqlForClass == "()"){
    $sqlForClass = "1 = 0";
}

$sql = "SELECT * from assignment WHERE $sqlForClass AND dueday > curdate() ORDER BY dueday ASC";
$result = $conn->query($sql);

$arr = array();
$counter = 0;


while($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $class = $row['class'];

    $finished = false;

    $sql2 = "SELECT * FROM personalassignment WHERE assignment = $id AND uid = $student";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
        $finished = true;
    }

    if (intval($row['type']) == 2 && $finished == true){
        // Do nothing
    }else{
        $unitAssignment = new UnitAssignment();
        $unitAssignment->constructFromDBRow($row, $class, $finished);
        $arr[$counter] = $unitAssignment;
        $counter++;
    }

}

echo json_encode($arr);

?>