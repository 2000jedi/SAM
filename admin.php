<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 9/21/15
 * Time: 18:51
 */

require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";

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
        ?>
    </style>
</head>
<body>
<script>
    function toggleModules(id) {
        $('#right-part').hide();
        $('#mStatistics').hide();
        $('#left-tab-Statistics').css("background", "#2196F3").css("color", "white");
        $('#mCreateUsers').hide();
        $('#left-tab-CreateUsers').css("background", "#2196F3").css("color", "white");
        $('#mClasses').hide();
        $('#left-tab-Classes').css("background", "#2196F3").css("color", "white");
        $('#m' + id).show();
        $('#left-tab-' + id).css("background", "white").css("color", "#2196F3");
    }
</script>
<div id="header-part">
    <a id="appName" href="#"><?= $appName ?></a>
    <a id="userName" href="#">t001</a>
    <ul id="header-tabs-outer">
        <li class="header-tab"><a href="#" id="left-tab-Statistics" class="header-tab-a" onclick="toggleModules('Statistics')">Statistics</a>
        </li>
        <li class="header-tab"><a href="#" id="left-tab-CreateUsers" class="header-tab-a" onclick="toggleModules('CreateUsers')">Create Users</a>
        </li>
        <li class="header-tab"><a href="#" id="left-tab-Classes" class="header-tab-a" onclick="toggleModules('Classes')">Classes</a>
        </li>
    </ul>
</div>
<div id="body-part">
    <div id="mStatistics">
        <div class="card">
            <a href="/modules/user/listUserInfo.php" target="_blank">List User Info</a>
        </div>
        <div class="card">
            <a href="/modules/user/listUserWithDefaultPassword.php" target="_blank">List User With Default Password</a>
        </div>
        <div class="card">
            <a href="/modules/user/studentInClass.php" target="_blank">Student In Class</a>
        </div>
        <!--
        <div class="card">
            <a href="/modules/statistics/loadIPAddresses.php" target="_blank">IP Address List</a>
        </div>
        -->
    </div>
    <div id="mCreateUsers">
        <div class="card">
            <div style="text-align: center">Create A User</div>
            <form action='/modules/user/create.php' method="post" style="margin: 0.5em">
                <div>
                    <label>username</label>
                    <input name="username" />
                </div>
                <div>
                    <label>type</label>
                    <input name="type" />
                </div>
                <div>
                    <label>subject</label>
                    <input name="subject" />
                </div>
                <div style="text-align: center; margin: 1em">
                    <input type="submit" class="pure-button pure-button-primary" />
                </div>
            </form>
        </div>
        <div class="card">
            <div style="text-align: center">Mass-produce Users</div>
            <form action='/modules/user/massiveCreateUser.php' method="post" style="margin: 0.5em">
                <div>
                    <label>classprefix</label>
                    <input name="classprefix" />
                </div>
                <div style="text-align: center; margin: 1em">
                    <input type="submit" class="pure-button pure-button-primary" />
                </div>
            </form>
        </div>
    </div>
    <div id="mClasses">
    </div>
    <div id="mIP">
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
    toggleModules("Statistics");

    function loadClass(func){
        $.get("/modules/class/loadClass.php?inAdmin=true",function(data){
            func();
            data = JSON.parse(data);
            for ( var i = 0; i < data.length; i++){
                var id = data[i].id;
                var teacher = data[i].teacher;
                var name = data[i].name;
                var subject = convertSubject(data[i].subject);

                var oneClass = new ClassAdmin(id, teacher, name, subject);
                $('#mClasses').append(oneClass.getHTML());
            }
        })
    }
    loadClass(function(){});

</script>
<?php
    }
?>