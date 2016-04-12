<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 4/12/16
 * Time: 6:54 PM
 */


require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/search/ManipulateSearchClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/UnitAssignment.php";

$result = checkForceQuit();

$teacher = $result->uid;

$keyword = $_POST["query"];

$manipulation = new ManipulateSearchClass($keyword);
echo $manipulation->searchFromTeacherSide($teacher);


?>