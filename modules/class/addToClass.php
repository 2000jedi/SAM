<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/3/15
 * Time: 20:33
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/UnitAssignment.php";

$result = checkForceQuit();

$student = $result->uid;

$class = $_GET['class'];

$sql0 = "SELECT * FROM class WHERE id = '$class'";
$result = $conn->query($sql0);
if ($result->num_rows == 0){
    die("There is no class which id == ".$class);
}

$sql1 = "SELECT * FROM student WHERE id = '$student'";
$result1 = $conn->query($sql1);


while($row = $result1->fetch_assoc()) {
    $classes = $row['class'];
    if ( strpos($classes, $class) ){
        die("You are already in the class.");
    }else{
        $newClass = $classes.";".$class;
        $sql2 = "UPDATE student SET class = '$newClass' WHERE id = $student";
        if ($conn->query($sql2) === TRUE) {
            echo "Success!";
        } else {
            echo "Unexpected error.";
        }
    }

}

?>