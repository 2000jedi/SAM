<?php

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/UnitAssignment.php";

require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitClub.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/club/UnitPost.php";

$result = checkForceQuit();
$student = $result->uid;
$sid = userVariableConversion($student, "uid", "username");

function sort_by_publish($a, $b){
    if ($a->publish == $b->publish) return 0;
    return ($a->publish < $b->publish) ? 1 : -1;
}

$arr_type1 = array();
$arr_type23 = array();

global $conn;

// Process Student's Classes
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

if (substr($sid, 0, 5) == "s2015" or substr($sid, 0, 5) == "s2016"){
    $sql = "SELECT * from assignment WHERE dueday > curdate() AND class = '39' ORDER BY type ASC, dueday ASC, publish DESC";
    $result = $conn->query($sql); // class = 39 ==> ad class
    // Exclude the archived ad
    while($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $class = $row['class'];

        $finished = false;

        $sql = "SELECT * FROM personalassignment WHERE assignment = '$id' AND uid = '$student' AND actual >= 0";
        $result2 = $conn->query($sql);
        if ($result2->num_rows > 0) {
            $finished = true;
        }

        if (!($finished && $row['type'] == "2")){
            $unitAssignment = new UnitAssignment();
            $unitAssignment->constructFromDBRow($row, $class, $finished);
            if ($row['type'] == 1)
                $arr_type1[] = $unitAssignment;
            else
                $arr_type23[] = $unitAssignment;
        }
    }
}

$sql = "SELECT * from assignment WHERE dueday > curdate() AND ($sqlForClass) ORDER BY type ASC, dueday ASC, publish DESC";
$result = $conn->query($sql);

// Exclude the finished assignments
while($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $class = $row['class'];

    $finished = false;

    $sql = "SELECT * FROM personalassignment WHERE assignment = '$id' AND uid = '$student' AND actual >= 0";
    $result2 = $conn->query($sql);
    if ($result2->num_rows > 0) {
        $finished = true;
    }

    if (!($finished && $row['type'] == "2")){
        $unitAssignment = new UnitAssignment();
        $unitAssignment->constructFromDBRow($row, $class, $finished);
        if ($row['type'] == 1)
                $arr_type1[] = $unitAssignment;
        else
            $arr_type23[] = $unitAssignment;
    }
}

$sql = "SELECT * FROM club_post WHERE to_days(now()) - to_days(publish) < 7 ORDER BY publish DESC";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    $uP = new UnitPost();
    $uP->construct($row['ID'], $row['club'], $row['publisher'], $row['title'],$row['information'], $row['attachment'], $row['publish']);
    $arr_type23[] = $uP;
}

// Sort information and club together and append to arr1
usort($arr_type23, "sort_by_publish");
$arrlength=count($arr_type23);
for ($i=0; $i < $arrlength; $i++){
    $arr_type1[] = $arr_type23[$i];
}

echo json_encode($arr_type1);
