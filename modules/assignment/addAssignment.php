<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/21/15
 * Time: 21:43
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

$result = checkForceQuit();

$teacher = $result->uid;

$type = $_POST['type'];
$dueday = "null";
$duration = 0.0;
$attachment = "null";
if ($type == "1"){
    $duration = $_POST['duration'];
}
$dueday = $_POST['dueday'];
if ($dueday == ""){
    $dueday = "2038-1-1";
}
$dueday = date("Y-m-d", strtotime($dueday));

if ($_POST['hasAttachment'] == "true"){
    function genRandomString(){
        $length = 5;
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWZYZ";

        $real_string_length = strlen($characters) ;
        $string="id";

        for ($p = 0; $p < $length; $p++)
        {
            $string .= $characters[mt_rand(0, $real_string_length-1)];
        }

        return strtolower($string);
    }

    $target_dir = "/files/attachments/";

    $attachment = "";

    for ($i = 0; $i < count($_FILES["attachment"]['name']); $i++ ){
        $rand = genRandomString();
        $fileType = pathinfo($_FILES["attachment"]["name"][$i], PATHINFO_EXTENSION);
        $final_filename = $rand."_".session_id()."_".time().".".$fileType;
        $target_file = $_SERVER['DOCUMENT_ROOT'].$target_dir .$final_filename;

        $attachment .= ";".$target_dir.$final_filename;

        move_uploaded_file($_FILES["attachment"]["tmp_name"][$i], $target_file);
    }


}
$content = $_POST['content'];
$class = $_POST['class'];

$sql2 = "INSERT INTO assignment (type, content, attachment, publish, dueday, duration, class, teacher) VALUES ($type, '$content', '$attachment', now(), '$dueday', $duration, '$class', '$teacher')";
$conn->query($sql2);

echo "Success";

?>