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
require $_SERVER['DOCUMENT_ROOT']."/modules/client/v1/assignment/updateNotificationRaw.php";

$username = $_POST['username'];
$password = $_POST['password'];

$student = checkValid($username, $password);
if ($student == false){
    die("failed");
}else{

    $student = $student->uid;

    $newNotificationRaw = studentLoadAssignment($student);

    $notificationRaw = updateNotificationRaw($student, $newNotificationRaw);

    $returnObject = array(
        'type' => 'v1_notification',
        'data' => array(
            'hasUpdate' => false
        )
    );


    if ( $notificationRaw == $newNotificationRaw ){
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