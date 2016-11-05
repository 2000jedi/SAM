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
        function toggleModules(id){
            $('#right-part').hide();
            $('#mHome').hide();
            $('#left-tab-Home').css("background","").css("color","#eceff1");
            $('#mClasses').hide();
            $('#left-tab-Classes').css("background","").css("color","#eceff1");
            $('#mActivities').hide();
            $('#left-tab-Activities').css("background","").css("color","#eceff1");
            $('#mColleges').hide();
            $('#left-tab-Colleges').css("background","").css("color","#eceff1");
            $('#mPresentations').hide();
            $('#left-tab-Presentations').css("background","").css("color","#eceff1");
            $('#mSettings').hide();
            $('#left-tab-Settings').css("background","").css("color","#eceff1");
            $('#m'+id).show();
            $('#left-tab-'+id).css("background","#00BCD4").css("color","#37474F");
            $('#title').html(id);
            $('.demo-drawer').removeClass("is-visible");
        }
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
        var flag_showApps = false;
        function showApps(){
            flag_showApps = !flag_showApps;
            if (flag_showApps){
                $('#apps-menu-detail').css('display','block');
                $('#apps-menu-arrow-front').css('display','block');
                $('#apps-menu-arrow-back').css('display','block');
            }
            else{
                $('#apps-menu-detail').css('display','none');
                $('#apps-menu-arrow-front').css('display','none');
                $('#apps-menu-arrow-back').css('display','none');
            }
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
    <div id="apps-menu-arrow-back" style="display: none;"></div>
    <div id="apps-menu-arrow-front" style="display: none;"></div>
    <div id="apps-menu-detail" style="display: none;" aria-label="Apps" aria-hidden="false" role="region">
        <ul class="list-apps" aria-dropeffect="move">
            <li class="drag" style="display: none;" id="app-assignment">
                <a class="app" onclick="showAssignment()">
                    <span class="app-img" style="background: url('/files/icons/icons-google.png') 0 -552px;background-size: 64px 2065px;"></span>
                    <span class="app-desc"><div style="margin: 0 auto;">Assignments</div></span>
                </a>
            </li>

            <li class="drag" style="display: inline-block;" id="app-classes">
                <a class="app" onclick="showClasses()">
                    <span class="app-img" style="background: url('/files/icons/icons-google.png') 0 -483px;background-size: 64px 2065px;"></span>
                    <span class="app-desc"><div style="margin: 0 auto;">Classes</div></span>
                </a>
            </li>

            <li class="drag" style="display: inline-block;" id="app-settings">
                <a class="app" onclick="showSettings()">
                    <span class="app-img" style="background: url('/files/icons/icons-google.png') 0 -1449px;background-size: 64px 2065px;"></span>
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
            <div id="classList" class="mdl-grid demo-content"></div>
        </div>
        <div id="settings" style="display: none">
                <div class="">
                            <h2 class="">Change Email</h2>
                            <div>
                                Set up your own email address. <br />
                                You need your email address to receive your reset password email confirmation.
                            </div>
                            <div class="">
                                <input class="" type="email" id="newEmail" placeholder="Your new email"/>
                                <label class="" for="newEmail"></label>
                            </div>
                        <div class="">
                            <a class="" onclick="changeEmail()">
                                Change Email
                            </a>
                        </div>
                </div>
                <div class="" >
                            <h2 class="mdl-card__title-text">Change Password</h2>
                            <div>Please set up a strong password for yourself.</div>
                            <div class="">
                                <input class="" type="password" id="oldPass" placeholder="Old Password"/>
                                <label class="" for="oldPass">Old Password</label>
                            </div>
                            <div class="">
                                <input class="" type="password" id="newPass1" placeholder="Your new password"/>
                                <label class="" for="newPass1">Your new password</label>
                            </div>
                            <div class="">
                                <input class="" type="password" id="newPass2" placeholder="Retype your new password"/>
                                <label class="" for="newPass2">Retype your new password</label>
                            </div>
                            <a class="" onclick="changePassword()">
                                Change Password
                            </a>
                </div>
                <div class="" >
                            <h2 class="mdl-card__title-text">More</h2>
                            <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" onclick="signOut()">
                                Sign out
                            </a> -
                            <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" onclick="window.location='mailto:sam@developersam.com'">
                                Bug report
                            </a>
                </div>
        </div>
    </main>

    <div id="right-part" class="" style="display:none">

        <div id="right-part-view-class" style="display: none;">
            <header class="" style="display: flex">
                <div class=""  onclick="$('#right-part').hide()">
                        <span class="" style="display: flex; flex-direction: row">
                            <span class="btn-action" style="display: flex">X</span>
                            <span id="right-part-title" style="display: flex">Manage Class</span>
                        </span>
                </div>
            </header>
            <div id="assignment-list-class">
                <div id="assignment-list-class-assignment-pile" class="two-adjacent-pile"></div>
                <div id="assignment-list-class-information-pile" class="two-adjacent-pile"></div>
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
    // draw assignment percentage canvas
    function updatePercentage(perc) {
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

    // other functions
    var featureList = ["add-activity", "add-activity-comment", "view-activity-members"];
    var floatBox = new FloatBox(featureList);
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
                $('#assignment-list').append(assignment.getHTML());
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
        });
    }
    function isNull(t){
        return (t == null || t == "");
    }
    function hasFile(id){
        //if there is a value, return true, else: false;
        return $('#'+id).val() ? true: false;
    }
    $('#submit_form_add_activity').submit(function(){
        $(this).ajaxSubmit({
            beforeSubmit: function(){
                if (isNull($("#add-activity-form-name").val())){
                    alert("Name of the activity cannot be empty!");
                    return false;
                }
                if (isNull($("#add-activity-form-description").val())){
                    alert("Description of the activity cannot be empty!");
                    return false;
                }
                $('#submit_btn_add_activity').prop('disabled',true).val("Sending...");
                $("#progress_activity_1").show();
                return true;
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#progress_activity_1').attr("value", percentComplete);
            },
            clearForm: true,
            data:{hasAttachment: hasFile('add-activity-form-file')},
            success: function(content,textStatus,xhr,$form){
                if (content == "Success"){
                    alert(content);
                }
                $('#submit_btn_add_activity').prop('disabled',false).val("Submit");
                $('#shadow').hide();
                $("#progress_activity_1").hide();
                new ManipulateActivity().loadActivities(function(){
                    $('#activity-list').html("");
                })
            }
        });
        return false;
    });
    $('#submit_form_add_activityComment').submit(function(){
        $(this).ajaxSubmit({
            beforeSubmit: function(){
                if (isNull($("#add-activityComment-form-comment").val())){
                    alert("Comment cannot be empty!");
                    return false;
                }
                $('#submit_btn_add_activityComment').prop('disabled',true).val("Sending...");
                $("#progress_activity_2").show();
                return true;
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#progress_activity_2').attr("value", percentComplete);
            },
            clearForm: true,
            data:{hasAttachment: hasFile('add-activityComment-form-file')},
            success: function(content,textStatus,xhr,$form){
                if (content == "Success"){
                    alert(content);
                }
                $('#submit_btn_add_activityComment').prop('disabled',false).val("Submit");
                $('#shadow').hide();
                $("#progress_activity_2").hide();
                var id = $('#right-part-view-activity-id').html();
                new Activity(id, "", "", "", "", "", "", "", [], []).loadComments(function(){
                    $('#activity-comment-list').html("");
                });
            }
        });
        return false;
    });
    $('#add-activity-form-file-button-1').click(function(e){
        e.preventDefault();
        var html = "<div class='mdl-textfield mdl-js-textfield' style='display: block; padding: 10px 0; width: 100%'><input class='mdl-textfield__input uploadfile1' style='margin-top: 0.5em; background: white' name='attachment[]' type='file' multiple /></div>";
        $("#add-activity-form-file-input-list").append(html);
    });
    $('#add-activityComment-form-file-button').click(function(e){
        e.preventDefault();
        var html = "<div class='mdl-textfield mdl-js-textfield' style='display: block; padding: 10px 0; width: 100%'><input class='mdl-textfield__input uploadfile1' style='margin-top: 0.5em; background: white' name='attachment[]' type='file' multiple /></div>";
        $("#add-activityComment-form-file-input-list").append(html);
    });
    toggleModules('Home');
    loadAssignment(function(){
        $('#assignment-list').html("");
    });
    new ManipulateActivity().loadActivities(function(){
        $('#activity-list').html("");
    });
    new ManipulateCollege().loadColleges(function(){
        $('#college-list').html("");
    });
    new Class('', '').loadClass(1, function(){
        $('#classList').html("");
    });
    new ManipulatePresentation().loadPresentations(1);

    // set the height of the device bar
    $(window).load(function() {
        $('.vertical').css('height', $('#assignment-list-wrapper').height());
    });

    // set app state change
    function showAssignment(){
        $('#assignment').css('display','block');
        $('#classes').css('display','none');
        $('#settings').css('display','none');

        $('#app-assignment').css('display','none');
        $('#app-classes').css('display','inline-block');
        $('#app-settings').css('display','inline-block');
    }

    function showClasses(){
        $('#assignment').css('display','none');
        $('#classes').css('display','block');
        $('#settings').css('display','none');

        $('#app-assignment').css('display','inline-block');
        $('#app-classes').css('display','none');
        $('#app-settings').css('display','inline-block');
    }

    function showSettings(){
        $('#assignment').css('display','none');
        $('#classes').css('display','none');
        $('#settings').css('display','block');

        $('#app-assignment').css('display','inline-block');
        $('#app-classes').css('display','inline-block');
        $('#app-settings').css('display','none');
    }


</script>
</html>
