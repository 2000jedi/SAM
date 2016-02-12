<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 5/13/15
 * Time: 21:56
 */

function updateNotificationRaw($student, $newNotificationRaw){

    global $conn;

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
    }

    return $notificationRaw;

}

?>