<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 5/13/15
 * Time: 20:28
 */

function studentLoadAssignment($student){
    global $conn;

    $sql = "SELECT * from student WHERE id='$student'";
    $result = $conn->query($sql);

    $sqlForClass = "";

    while($row = $result->fetch_assoc()) {
        $classIDs = explode(";",$row['class']);

        if (count($classIDs)>1){
            $sqlForClass = "class = ".$classIDs[1]." ";
            for ($i = 2; $i < count($classIDs) ; $i++){
                $classID = $classIDs[$i];
                $sqlForClass = $sqlForClass."OR class = ".$classID." ";
            }
        }
    }

    $sqlForClass = "(".$sqlForClass.")";

    if ($sqlForClass == "()"){
        $sqlForClass = "1 = 0";
    }

    $sql = "SELECT * from assignment WHERE ( $sqlForClass AND dueday > curdate() ) OR class = '39' ORDER BY dueday ASC";
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

        if ($finished == true){
            // Do nothing
        }else{
            $unitAssignment = new UnitAssignment();
            $unitAssignment->constructFromDBRow($row, $class, $finished);
            $arr[$counter] = $unitAssignment;
            $counter++;
        }

    }

    return json_encode($arr);
}

?>