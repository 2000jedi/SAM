<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/14/15
 * Time: 20:13
 */
require $_SERVER['DOCUMENT_ROOT']."/config.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/user/checkValid.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/common/basic.php";

$msg = "You have not signed in.<br /><br /> If you are the first time user of SAM, your username is the username on TSIMS, and your password is your username. <br />Please change your password as soon as possible.";

if ( isset($_COOKIE['username']) and isset($_COOKIE['password']) ) {
    if (checkValid($_COOKIE["username"], $_COOKIE["password"]) != false) {
        Redirect("/");
    }
}

if ( isset($_POST['username']) and isset($_POST['password']) ){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = checkValid($username, $password);
    if ($result == false){
        $msg = "Your username and password do not match.";
    }else{
        setcookie("username", $username, time() + (86400 * 365), "/"); // 365 days
        setcookie("password", $password, time() + (86400 * 365), "/");
        Redirect("/");
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $appName ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" href="/framework/material/material.min.css">
    <link rel="stylesheet" href="/framework/material/material-dashboard-styles.css">
    <link rel="stylesheet" href="/framework/geodesic/base.css">
</head>
<body>
<script src="/framework/js/jq.js"></script>
<script src="/framework/js/material.js"></script>
<script>
    function forgotPassword(){
        var user = $('#usnmInput').val();
        if (user == null || user == ""){
            alert("Please input your username first!");
        }else{
            $.get("/modules/user/forgotPasswordSendMail.php",{user: user},function(data){
                alert(data);
            });
        }
    }
</script>
    <header class="demo-header mdl-layout__header mdl-color--white mdl-color--grey-100 mdl-color-text--grey-600" style="display: flex">
        <div class="mdl-layout__header-row">
            <span id="title" class="mdl-layout-title"><?= $appName ?></span>
        </div>
    </header>
    <form id="form" action="login.php" method="post">
        <div class="demo-cards mdl-cell mdl-grid mdl-grid--no-spacing" style="margin: 1em auto; display: block">
            <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-cell--12-col-desktop">
                <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                    <h2 class="mdl-card__title-text">Login</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <div><?=$msg ?></div>
                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" name="username" type="text" id="usnmInput" />
                        <label class="mdl-textfield__label" for="usnmInput">Your username</label>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" name="password" type="password" id="pswdInput"/>
                        <label class="mdl-textfield__label" for="pswdInput">Your password</label>
                    </div>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" onclick="$('#form').submit()">
                        Sign In
                    </a>
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" onclick="forgotPassword()">
                        Forgot Password
                    </a>
                </div>
            </div>
        </div>
    </form>
</body>
</html>