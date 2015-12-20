<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/21/15
 * Time: 21:43
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/common/basic.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/assignment/ManipulateAssignmentClass.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/client/classes/Device.php";

$manipulation = new ManipulateAssignmentClass();
$manipulation->addAssignment();

?>