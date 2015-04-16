<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 4/16/15
 * Time: 19:33
 */
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/createFunction.php";

$type = "s";
$classprefix = $_POST['classprefix'];

for ($i = 1; $i < 36; $i++){

    if ($i < 10){
        $i = "0".$i;
    }

    $username = $type.$classprefix.$i;
    echo $username." is created.<br>";
    create($username, $type);
}


?>