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
    <title>SAM by Computerization</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        div {
            background-color: transparent;!important;
        }

        <?php
            require $_SERVER['DOCUMENT_ROOT']."/framework/geodesic/base.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/geodesic/settings.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/sam/main.css";
        ?>
    </style>

    <script src="/framework/js/jq.js"></script>
    <script src="/framework/js/form.js"></script>
    <script src="/framework/js/masonry.js"></script>
    <script>
        <?php
            require $_SERVER['DOCUMENT_ROOT']."/template/scripts/UID.php";
            require $_SERVER['DOCUMENT_ROOT']."/template/scripts/base.js";
            require $_SERVER['DOCUMENT_ROOT']."/template/scripts/floatBox.js";
            require $_SERVER['DOCUMENT_ROOT']."/template/scripts/class.js";
            require $_SERVER['DOCUMENT_ROOT']."/template/scripts/settings.js";
            require $_SERVER['DOCUMENT_ROOT']."/template/scripts/waterfall.js";
            require $_SERVER['DOCUMENT_ROOT']."/template/scripts/assignment.js";
            require $_SERVER['DOCUMENT_ROOT']."/template/scripts/activity.js";
            require $_SERVER['DOCUMENT_ROOT']."/template/scripts/college.js";
            require $_SERVER['DOCUMENT_ROOT']."/template/scripts/presentation.js";
        ?>

        function updatePercentage(perc) { // draw assignment percentage circle
            perc = parseFloat(perc);
            em = Number(getComputedStyle(document.body, null).fontSize.replace(/[^\d]/g, ''));

            var canvas = document.getElementById("percentage");
            var ctx = canvas.getContext("2d");
            var text = parseInt(perc * 100) + '%';

            canvas.width = 40 * em;
            canvas.height = 40 * em;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.lineWidth = 25;

            if (perc == 1.0) {
                ctx.beginPath();
                ctx.arc(20 * em, 20 * em, 12 * em, 0, 2 * Math.PI);
                ctx.strokeStyle = 'rgba(81,157,217,1)';
                ctx.stroke();
            }

            if (perc == 0.0) {
                ctx.beginPath();
                ctx.arc(20 * em, 20 * em, 12 * em, 0, 2 * Math.PI);
                ctx.strokeStyle = 'rgba(240,124,120,1)';
                ctx.stroke();
            }

            if ((perc < 1) && (perc > 0)) {
                ctx.beginPath();
                ctx.arc(20 * em, 20 * em, 12 * em, (1.0125 - perc) * 2 * Math.PI, 2 * Math.PI - 0.075);
                ctx.strokeStyle = 'rgba(81,157,217,1)';
                ctx.stroke();

                ctx.beginPath();
                ctx.strokeStyle = 'rgba(240,124,120,1)';
                ctx.arc(20 * em, 20 * em, 12 * em, -0.9875 * 2 * Math.PI, -(perc + 0.0125) * 2 * Math.PI);
                ctx.stroke();
            }

            ctx.font = 8 * em + "px Arial";
            ctx.fillStyle = 'rgba(133,189,234,1)';
            ctx.fillText(text, (canvas.width - text.length*em*4)/2 - 25, (canvas.height + 4*em)/2);
        }

        // toggle modules

        var flag_showApps = false;
        function showApps(){
            flag_showApps = !flag_showApps;
            if (flag_showApps){
                $('#apps-menu-detail').css('display','block');
            }
            else{
                $('#apps-menu-detail').css('display','none');
            }
        }
        function showModule(id){
            $('#assignment').css('display','none');
            $('#classes').css('display','none');
            $('#settings').css('display','none');

            $('#app-assignment').css('display','inline-block');
            $('#app-classes').css('display','inline-block');
            $('#app-settings').css('display','inline-block');

            $('#' + id).css('display', 'block');
            $('#app-' + id).css('display', 'none');

            showApps();
        }
</script>
</head>

<body>
    <div class="banner">
        <p id="left-banner">
            <img src="/framework/sam/SAM_logo.svg" />
            <span><lead>S</lead>AM <small>by Computerization</small></span>
        </p>
        <a id="apps-menu" onclick="showApps();">
            <i style="height: 40px;line-height: 40px;" class="material-icons">apps</i>
        </a>
        <img id="avatar" src="/framework/material-images/user.png" height="40px">
        <p id="right-banner" onclick="showUserPanel()">
    </div>
    <div id="apps-menu-detail" style="display: none;" aria-label="Apps" aria-hidden="false" role="region">
        <ul class="list-apps" aria-dropeffect="move">
            <li class="drag" style="display: none;" id="app-assignment">
                <a class="app" onclick="showModule('assignment')">
                    <span class="app-img" style="background-image: url('/files/icons/assignments.svg');background-size: 64px 64px;"></span>
                    <span class="app-desc"><div style="margin: 0 auto;">Assignments</div></span>
                </a>
            </li>

            <li class="drag" style="display: inline-block;" id="app-classes">
                <a class="app" onclick="showModule('classes')">
                    <span class="app-img" style="background-image: url('/files/icons/classes.svg');background-size: 64px 64px;"></span>
                    <span class="app-desc"><div style="margin: 0 auto;">Classes</div></span>
                </a>
            </li>

            <li class="drag" style="display: inline-block;" id="app-settings">
                <a class="app" onclick="showModule('settings')">
                    <span class="app-img" style="background-image: url('/files/icons/setting.svg');background-size: 64px 64px;"></span>
                    <span class="app-desc"><div style="margin: 0 auto;">Settings</div></span>
                </a>
            </li>
        </ul>
    </div>

    <main id="main_drawer">
        <div id="assignment">
            <div id="assignment-stats" style="background-color: transparent;">
                <canvas id="percentage" style="width: 15em;height: 15em;"></canvas>
            </div>
            <div id="greeting" style="background-color: transparent;"><?php require $_SERVER['DOCUMENT_ROOT']."/framework/sam/greeting";?></div>

            <div id="assignment-list-wrapper">
                <div class="vertical"></div>
                <div id="assignment-list"></div>
            </div>
        </div>
        <div id="classes" style="display: none">
            <div id="classList" class="class-content"></div>
        </div>
        <div id="settings" style="display: none">
                <div class="">
                            <h2 class="">Change Email</h2>
                            <div>
                                Set up your own email address. <br />
                                You need your email address to receive your reset password email confirmation.
                            </div>
                            <div class="">
                                <input class="input-text" type="email" id="newEmail" placeholder="Your new email"/>
                                <label class="input-text" for="newEmail"></label>
                            </div>
                        <div class="button">
                            <a class="a-button" onclick="changeEmail()">
                                Change Email
                            </a>
                        </div>
                </div>
                <div class="" >
                            <h2 class="">Change Password</h2>
                            <div>Please set up a strong password for yourself.</div>
                            <div class="">
                                <input class="input-text" type="password" id="oldPass" placeholder="Old Password"/>
                                <label class="" for="oldPass">Old Password</label>
                            </div>
                            <div class="">
                                <input class="input-text" type="password" id="newPass1" placeholder="Your new password"/>
                                <label class="" for="newPass1">Your new password</label>
                            </div>
                            <div class="">
                                <input class="input-text" type="password" id="newPass2" placeholder="Retype your new password"/>
                                <label class="" for="newPass2">Retype your new password</label>
                            </div>
                            <div class="button">
                            <a class="a-button" onclick="changePassword()">
                                Change Password
                            </a>
                            </div>
                </div>
                <div class="" >
                    <h2 class="c">More</h2>
                    <div class="">Computerization Proudly Present</div>
                    <div class="">Version 16.11.23</div>
                    <a class="a-button" onclick="signOut()">
                        Sign Out
                    </a> -
                    <a class="a-button" onclick="window.location='mailto:jedi.primer@yandex.com'">
                        Bug Report
                    </a>
                </div>
        </div>
    </main>

    <div id="right-part" class="" style="display:none">

        <div id="right-part-view-class" style="display: none;">
            <header id="single-class-header">
                <div id="single-class-compile"  onclick="$('#right-part').hide()">
                        <span class="single-class-banner">
                            <span id="right-part-title">Manage Class</span>
                            <span id="btn-action-cross">X</span>
                        </span>
                </div>
            </header>
            <div id="assignment-list-class">
                <div id="assignment-list-class-pile" class="pile"></div>
            </div>
        </div>

        <div id="right-part-view-activity" style="display: none">
            <div id="right-part-view-activity-id" style="display: none;"></div>
            <header class="" style="display: flex">
                <div class="" style="padding-left: 1em; cursor: pointer" onclick="$('#right-part').hide()">
                        <span class="m" style="display: flex; flex-direction: row">
                            <span class="material-icons" style="display: flex">close</span>
                            <span style="display: flex">Discussion</span>
                        </span>
                </div>
            </header>
            <button id="add-activity-comment-button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-color--pink-300" style="position: fixed; right: 1em; bottom: 1em; z-index:100" onclick="new ManipulateActivity().addActivityCommentButtonClick()">
                <i class="material-icons">add</i>
            </button>
            <div id="activity-comment-list"></div>
        </div>
    </div>

</body>
<script>
    var VerticalHeight = -40;
    
    function loadAssignment(func){
        $.get("/modules/assignment/studentLoadAssignment.php",function(data){
            func();
            data = JSON.parse(data);
            var todayDoneTime = 0, todayTotalTime = 0, totalDoneTime = 0, totalTotalTime = 0;
            var todayDoneItems = 0, todayTotalItems = 0, totalDoneItems = 0, totalTotalItems = 0;
            for (var i = 0; i < data.length; i++){
                var row = data[i];
                var subject = convertSubject(row.subject);
                if (row.type == "1"){
                    var date = row.dueday;
                    var daysLeft = DateDiff.inDays(new Date(), new Date(date));
                    var singleTime = parseFloat(parseFloat(row.duration).toFixed(1));
                    if (daysLeft == 1){
                        if (row.finished == true){
                            todayDoneTime += singleTime;
                            todayDoneItems++;
                        }
                        todayTotalTime += singleTime;
                        todayTotalItems++;
                    }
                    if (row.finished == true){
                        totalDoneTime += singleTime;
                        totalDoneItems++;
                    }
                    totalTotalTime += singleTime;
                    totalTotalItems++;
                }
                var assignment = new Assignment("student", row.id, row.type, row.content, row.attachment, row.publish, row.dueday, subject, row.duration, row.finished, row.class);
                $('#assignment-list').append(assignment.getHTML(true));
                VerticalHeight += 189; // 189 is the height of the card.
            }
            if (todayTotalTime == 0){
                todayDoneTime = 1;
                todayTotalTime = 1;
            }
            if (totalTotalTime == 0){
                totalDoneTime = 1;
                totalTotalTime = 1;
            }
            function ProcessPercentage(percentage){
                if (percentage < 0.01){
                    return 0.001;
                }
                return percentage;
            }
            var totalPercentage = ProcessPercentage(parseFloat(parseFloat(totalDoneTime / totalTotalTime)).toFixed(2));
            updatePercentage(totalPercentage);
            $('.vertical').css('height', VerticalHeight);
            VerticalHeight = -40;
        });
    }
    loadAssignment(function(){
        $('#assignment-list').html("");
    });
    new Class('', '').loadClass(1, function(){
        $('#classList').html("");
    });
</script>
</html>
