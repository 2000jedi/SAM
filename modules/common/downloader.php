<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 5/9/15
 * Time: 20:11
 */

require $_SERVER['DOCUMENT_ROOT']."/config.php";

$path = $_GET['path'];
$name = $_GET['name'];

$pathArr = explode("/",$path);
$realPath = $pathArr[count($pathArr)-1];
$names = explode(".",$realPath);
$type = $names[count($names)-1];

if ( $type == "png" || $type == "jpg" || $type == "gif" ){
    header("Content-Type: image/$type");
}else{
    header("Content-Type: application/$type");
}

header("Content-Disposition: inline; filename=$name");
header('Pragma: no-cache');

if ($mode == "local"){
    readfile($_SERVER['DOCUMENT_ROOT'].$path);
}else if ($mode == "SAE"){
    $s = new SaeStorage();

    $content = $s->read('wflmssam', $realPath);

    echo $content;
}

?>