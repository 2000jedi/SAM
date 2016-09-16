<?php
/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 16/9/16
 * Time: 上午12:14
 */
if (!function_exists('checkForceQuit')){
    die("You are detected as an unexpected intruder.");
}else{
    checkForceQuit();
}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <script src="/framework/js/material.js"></script>
    <link rel="stylesheet" href="/framework/sam/main.css">
    <style>
        <?php
            require $_SERVER['DOCUMENT_ROOT']."/framework/material/material.min.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/geodesic/base.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/geodesic/settings.css";
        ?>
        body {
            background-color:#FFFFFF;
        }/*Overwrite in MDL*/
    </style>
    <script>
        var flag_showApps = false;
        function showApps(){
            flag_showApps = !flag_showApps;
            if (flag_showApps){

            }
            else{

            }
        }

        var flag_userPanel = false;
        function showUserPanel(){
            flag_userPanel = !flag_userPanel;
            if (flag_userPanel){

            }
            else{

            }
        }
    </script>
</head>

<body>
    <div class="banner">
        <p id="left-banner">
            SAM
        </p>
        <a id="apps-menu" onclick="showApps();">
            <i style="height: 40px;line-height: 40px;" class="material-icons">apps</i>
        </a>
        <img id="avatar" src="/framework/material-images/user.png" height="40px">
        <p id="right-banner" onclick="showUserPanel()">
                <?= $username ?>
        </p>
    </div>
    <!--
    <ul id="apps-menu-detail" style="display: none;" aria-dropeffect="none">
        <li class="app">
            <a class="app-link" href="/">
                <i class="material-icons">assignments</i>
                <span class="app-desc">Assignments</span>
            </a>
        </li>
    </ul>
    -->

</body>
</html>