<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/14/15
 * Time: 20:17
 */

$appName = "SAM";

$modes = array("local", "SAE");

$mode = $modes[0];

$protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';

$baseURL = $protocol.$_SERVER['HTTP_HOST'];

?>