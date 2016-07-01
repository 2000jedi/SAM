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
    <script src="/framework/js/material.js"></script>
    <style>
        <?php
            require $_SERVER['DOCUMENT_ROOT']."/framework/material/material.min.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/material/material-dashboard-styles.css";
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
        $('#left-tab-Statistics').css("background","").css("color","#eceff1");
        $('#mCreateUsers').hide();
        $('#left-tab-CreateUsers').css("background","").css("color","#eceff1");
        $('#mClasses').hide();
        $('#left-tab-Classes').css("background","").css("color","#eceff1");
        $('#m' + id).css("display", "");
        $('#left-tab-' + id).css("background","#00BCD4").css("color","#37474F");
        $('#title').html(id);
        $('.demo-drawer').removeClass("is-visible")
    }
</script>
<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <header class="demo-header mdl-layout__header mdl-color--white mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">
            <span id="title" class="mdl-layout-title">Home</span>
        </div>
    </header>
    <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="demo-drawer-header">
            <img src="/framework/material-images/user.png" class="demo-avatar">
            <div class="demo-avatar-dropdown">
                <span style="display: block; margin-top: 0.5em">t001</span>
            </div>
        </header>
        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
            <a id="left-tab-Statistics" onclick="toggleModules('Statistics')" class="mdl-navigation__link" href="#"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">school</i>Statistics</a>
            <a id="left-tab-CreateUsers" onclick="toggleModules('CreateUsers')" class="mdl-navigation__link" href="#"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">settings</i>Create Users</a>
            <a id="left-tab-Classes" onclick="toggleModules('Classes')" class="mdl-navigation__link" href="#"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">settings</i>Classes</a>
        </nav>
    </div>
    <main class="mdl-layout__content mdl-color--grey-100">
        <div id="loading" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="width: auto;"></div>
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
            <div class="card">
                <a href="/modules/statistics/loadActiveUsers.php" target="_blank">Active Users</a>
            </div>
            <div class="card">
                <a href="/modules/statistics/loadIPAddresses.php" target="_blank">IP Address List</a>
            </div>
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
                        <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" style="background: #3f51b5" />
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
                        <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" style="background: #3f51b5" />
                    </div>
                </form>
            </div>
            <div class="card">
                <div style="text-align: center">Destroy A User</div>
                <form action='/modules/user/destroy.php' method="post" style="margin: 0.5em">
                    <div>
                        <label>username</label>
                        <input name="username" />
                    </div>
                    <div>
                        <label>type</label>
                        <input name="type" />
                    </div>
                    <div style="text-align: center; margin: 1em">
                        <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" style="background: #3f51b5" />
                    </div>
                </form>
            </div>
            <div class="card">
                <div style="text-align: center">Users Massacre</div>
                <form action='/modules/user/massiveDestroyUser.php' method="post" style="margin: 0.5em">
                    <div>
                        <label>classprefix</label>
                        <input name="classprefix" />
                    </div>
                    <div style="text-align: center; margin: 1em">
                        <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" style="background: #3f51b5" />
                    </div>
                </form>
            </div>
        </div>
        <div id="mClasses" class="mdl-grid demo-content"></div>
    </main>
</div>
</body>
<script>
    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/base.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/class.js";
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