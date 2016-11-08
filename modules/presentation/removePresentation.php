<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 7/13/16
 * Time: 2:38 PM
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/common/basic.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/presentation/ManipulatePresentationClass.php";

$manipulation = new ManipulatePresentationClass();
$manipulation->setPresentation($_GET['id']);
$manipulation->removePresentation();

?>