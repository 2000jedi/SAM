<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 9/21/15
 * Time: 18:51
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/config.php";

$result = checkForceQuit();

$admin = $result->username;

if ($admin != "t001"){
    die("Permission Denied!");
}else {

    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title><?= $appName ?> - Admin</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <script src="/framework/js/jq.js"></script>
    <script src="/framework/js/form.js"></script>
    <style>
        <?php
            require $_SERVER['DOCUMENT_ROOT']."/framework/pure/pure-min.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/geodesic/base.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/geodesic/settings.css";
            require $_SERVER['DOCUMENT_ROOT']."/template/fix/safari/fixdateinput.css";
        ?>
    </style>
</head>
<body>
<script>
    function toggleModules(id) {
        $('#right-part').hide();
        $('#mListUsers').hide();
        $('#left-tab-ListUsers').css("background", "#2196F3").css("color", "white");
        $('#mCreateUsers').hide();
        $('#left-tab-CreateUsers').css("background", "#2196F3").css("color", "white");
        $('#left-tab-ListUsers').css("background", "#2196F3").css("color", "white");
        $('#mIP').hide();
        $('#left-tab-IP').css("background", "#2196F3").css("color", "white");
        $('#m' + id).show();
        $('#left-tab-' + id).css("background", "white").css("color", "#2196F3");
    }
</script>
<div id="header-part">
    <a id="appName" href="#"><?= $appName ?></a>
    <a id="userName" href="#">t001</a>
    <ul id="header-tabs-outer">
        <li class="header-tab"><a href="#" id="left-tab-ListUsers" class="header-tab-a" onclick="toggleModules('ListUsers')">List Users</a>
        </li>
        <li class="header-tab"><a href="#" id="left-tab-CreateUsers" class="header-tab-a" onclick="toggleModules('CreateUsers')">Create Users</a>
        </li>
        <li class="header-tab"><a href="#" id="left-tab-IP" class="header-tab-a" onclick="toggleModules('IP')">IP</a>
        </li>
    </ul>
</div>
<div id="body-part">
    <div id="mListUsers">
        <div class="card">
            <a href="/modules/user/listUserInfo.php" target="_blank">List User Info</a>
        </div>
        <div class="card">
            <a href="/modules/user/listUserWithDefaultPassword.php" target="_blank">List User With Default Password</a>
        </div>
    </div>
    <div id="mCreateUsers">
        <div class="card">
            <div style="text-align: center">Create A User</div>
            <?php
            require $_SERVER['DOCUMENT_ROOT']."/modules/user/createFromUI.php";
            ?>
        </div>
        <div class="card">
            <div style="text-align: center">Mass-produce Users</div>
            <?php
            require $_SERVER['DOCUMENT_ROOT']."/modules/user/createFromUIMassive.php";
            ?>
        </div>
    </div>
    <div id="mIP">
        <div class="card">
            <a href="/modules/security/loadIPAddresses.php" target="_blank">IP Address List</a>
        </div>
    </div>
</div>
</body>
<script>
    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/base.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/class.js";
    ?>

    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/settings.js";
    ?>
    toggleModules("ListUsers");
</script>
<?php
    }
?>