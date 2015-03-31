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

$msg = "You have not signed in.";

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
<html>
<head>
    <title><?= $appName ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" href="/framework/pure/pure-min.css">
    <link rel="stylesheet" href="/framework/geodesic/base.css">
</head>
<body>
    <header id="header-part" style="color: white; text-align: center;padding: 1em 0">
        <span id="appname" style="display: block"><?= $appName ?></span>
    </header>
    <div id="body-part">
        <div class="card"><?=$msg ?></div>
        <form id="form" action="login.php" method="post">
            <div class="form">
                <input class="card" name="username" type="text" placeholder="Your username." />
            </div>
            <div class="form">
                <input class="card" name="password" type="password" placeholder="Your password." />
            </div>
            <input type="submit" style="display:none"/>
        </form>
        <div style="text-align: center">
            <button onclick="$('#form').submit()" class="pure-button pure-button-primary" style="margin:0 auto;display:inline-block;">Sign In</button>
            <button onclick="" class="pure-button pure-button-primary" style="margin:0 auto;display:inline-block;">Forgot Password</button>
        </div>
    </div>
</body>
</html>
<script src="/framework/js/jq.js"></script>