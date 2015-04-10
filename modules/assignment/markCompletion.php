<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/5/15
 * Time: 19:37
 */
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$student = $result->uid;

$id = $_POST['id'];
$actual = $_POST['actual'];


if (is_numeric($actual)){
    $actual = floatval($actual);
    if ($actual > 0){
        // DO nothing.
    }else{
        $actual = 0;
    }
}else{
    $actual = 0;
}

$sql = "INSERT INTO personalassignment (assignment, uid, actual) VALUES ($id, $student, $actual)";

if ($conn->query($sql) === TRUE) {
    echo "Thank you for cooperation!";
} else {
    echo "Unexpected error.";
}

?>