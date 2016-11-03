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
        $msg = "<span id='errormsg'>Your username and password do not match.<span>";
    }else{
        setcookie("username", $username, time() + (86400 * 365), "/"); // 365 days
        setcookie("password", $password, time() + (86400 * 365), "/");
        Redirect("/");
    }
}

?>
<!DOCTYPE html>
<html style="background: url('/framework/sam/login-bg.png') no-repeat center center fixed;">
<meta name="viewport" content="width=device-width" />
<head>
    <title><?= $appName ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" href="/framework/material/material.min.css">
    <link rel="stylesheet" href="/framework/material/material-dashboard-styles.css">
    <link rel="stylesheet" href="/framework/geodesic/base.css">
    <link rel="stylesheet" href="/framework/sam/login.css">
</head>
<body style="background-color: transparent;">
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
    <form id="form" action="login.php" method="post">
        <div id="request">
            <div id="title">
                Welcome
            </div>
            <div class="inputs">
                <div class="input-box">
                    <label class="func" id="user" for="usnmInput"></label>
                    <input name="username" type="text" id="usnmInput" placeholder="Your Username"/>

                </div>
                <div class="input-box">
                    <label class="func" id="pass" for="pswdInput"></label>
                    <input name="password" type="password" id="pswdInput" placeholder="Your Password"/>
                </div>
                <input type="submit" style="display: none">
            </div>
            <hr />
            <div class="buttons" align="center">
                <a class="button" id="sign-in" style="margin-right: 1em" onclick="$('#form').submit()">
                    SIGN IN
                </a>
                <a class="button" id="forget-password" onclick="forgotPassword()">
                    FORGOT
                </a>
            </div>
        </div>
        <div id="hint-box">
            <div id="hint">
                <?=$msg ?>
            </div>
        </div>
    </form>
</body>




</html>
