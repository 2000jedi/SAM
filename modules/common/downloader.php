<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 5/9/15
 * Time: 20:11
 */

$path = $_GET['path'];
$name = $_GET['name'];

header("Content-Disposition: attachment; filename='$name'");
header('Pragma: no-cache');
readfile($path);

?>