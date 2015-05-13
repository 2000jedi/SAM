<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 5/13/15
 * Time: 20:29
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/UnitAssignment.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/studentLoadAssignmentFunction.php";

$username = $_POST['username'];
$password = $_POST['password'];

$student = checkValid($username, $password);
if ($student == false){
    die("failed");
}else{

    $student = $student->uid;

    $newNotificationRaw = studentLoadAssignment($student);

    $sql = "SELECT * from client_v1_notification WHERE uid = '$student'";
    $result = $conn->query($sql);

    $isNothing = true;

    $notificationRaw = "";


    while($row = $result->fetch_assoc()) {
        $notificationRaw = $row['notificationRaw'];
        $isNothing = false;
    }

    if ($isNothing){
        $sql1 = "INSERT INTO client_v1_notification (uid, notificationRaw) VALUES ('$student', '$newNotificationRaw')";
        $conn->query($sql1);
    }else{
        $sql1 = "UPDATE client_v1_notification SET notificationRaw = '$newNotificationRaw' WHERE uid = '$student'";
        $conn->query($sql1);
        echo "!";
    }

    $returnObject = array(
        'type' => 'v1_notification',
        'data' => array(
            'hasUpdate' => false
        )
    );


    if ( $notificationRaw == $newNotificationRaw || $isNothing ){
    }else{
        $assignmentIDList = array();

        if ($notificationRaw == ""){
            $notificationRaw = "[]";
        }

        $notificationRaw = json_decode($notificationRaw);
        for ($i = 0; $i < count($notificationRaw); $i++){
            $assignmentIDList[$i] = $notificationRaw[$i]->id;
        }

        $counter = 0;

        $newNotificationRaw = json_decode($newNotificationRaw);

        for ($i = 0; $i < count($newNotificationRaw); $i++){
            $id = $newNotificationRaw[$i]->id;
            if (!in_array($id, $assignmentIDList) ){
                $counter++;
            }
        }

        if ($counter != 0) {
            $returnObject = array(
                'type' => 'v1_notification',
                'data' => array(
                    'hasUpdate' => true,
                    'numberOfNew' => $counter
                )
            );
        }
    }
    echo json_encode($returnObject);

}

?>