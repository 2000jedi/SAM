<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/14/15
 * Time: 20:17
 */

if (!function_exists('checkForceQuit')){
    die("You are detected as an unexpected intruder.");
}else{
    checkForceQuit();
}

?>
<html>
<head>
    <title><?= $appName ?> - Student</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" href="/framework/pure/pure-min.css">
    <link rel="stylesheet" href="/framework/geodesic/base.css">
    <link rel="stylesheet" href="/framework/geodesic/settings.css">
    <script src="/framework/js/jq.js"></script>
    <script src="/framework/js/form.js"></script>
    <style>
        @media (min-width: 960px) {
            #body-part {
                position: fixed;
                top: 3px;
                left: 200px;
                width: -moz-calc(100% - 200px);
                width: -webkit-calc(100% - 200px);
                width: calc(100% - 200px);
            }
            #right-part{
                width: -moz-calc(100% - 200px);
                width: -webkit-calc(100% - 200px);
                width: calc(100% - 200px);
            }
            #actionBar{
                width: -moz-calc(100% - 200px);
                width: -webkit-calc(100% - 200px);
                width: calc(100% - 200px);
            }
        }
    </style>
</head>
<body>
<script>
    function toggleModules(id){
        $('#right-part').hide();
        $('#mStream').hide();
        $('#left-tab-Stream').css("background","#1f8dd6").css("color","white");
        $('#mClass').hide();
        $('#left-tab-Class').css("background","#1f8dd6").css("color","white");
        $('#mSettings').hide();
        $('#left-tab-Settings').css("background","#1f8dd6").css("color","white");
        $('#m'+id).show()
        $('#left-tab-'+id).css("background","white").css("color","#1f8dd6");
    }
</script>
<div id="header-part">
    <a id="appName" href="#"><?= $appName ?></a>
    <a id="userName" href="#"><?= $username ?></a>
    <ul id="header-tabs-outer">
        <li class="header-tab"><a href="#" class="header-tab-a" id="left-tab-Stream" onclick="toggleModules('Stream')">Stream</a></li>
        <li class="header-tab"><a href="#" class="header-tab-a" id="left-tab-Class" onclick="toggleModules('Class')">Classes</a></li>
        <li class="header-tab"><a href="#" class="header-tab-a" id="left-tab-Settings" onclick="toggleModules('Settings')">Settings</a></li>
        <li class="header-tab"><a href="#" class="header-tab-a" onclick="signOut()">Sign Out</a></li>
    </ul>
</div>
<div id="body-part">
    <div id="mStream">
        <div class="card card-limit" style="margin: 0;padding: 0"><div id="assignment-time-management" style="margin: 1em"></div></div>
        <div id="assignment-list" style="position: relative">
            <div class="card">Loading information...</div>
        </div>
    </div>
    <div id="mClass"style="display: none">
        <div id="classList"></div>
        <div class="card" style="text-align:center" onclick="openAddClassBox()">Add Class</div>
    </div>
    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/pages/settings.html";
    ?>
</div>
<div id="right-part" style="display:none">
    <div id="actionBar">
        <div style="display: inline-block" onclick="$('#right-part').hide()">
            <div class="material-icon arrow" data-icon="arrow" style="width: 50px;height: 30px;">
                <span class="first"></span>
                <span class="second"></span>
                <span class="third"></span>
            </div>
        </div>
        <div style="display: none;" id="right-part-class-id"></div>
        <div style="display: inline-table; vertical-align: middle;padding-bottom:15px;font-size: 1.5em;color: #ffffff" id="right-part-title">Manage Class</div>
    </div>
    <div id="assignment-list-in-class" style="position: absolute;top:55px;left: 0px; width: 100%"></div>
</div>

<div id="shadow" style="display: none;">
    <div style="display:table-cell;vertical-align: middle">
        <div style="display:table;margin-left:auto;margin-right: auto;">
            <div id="floatBox">
                <div id="floatBox-close" onclick="$('#shadow').hide()">Close</div>
                <div class="settings_title_bar" id="floatBox-title"></div>
                <div id="floatBox-content">
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    /* Class Module */
    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/waterfall.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/assignment.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/waterfall.js";
    ?>
    var DateDiff = {
        inDays: function(d1, d2) {
            var t2 = d2.getTime();
            var t1 = d1.getTime();
            return parseInt((t2-t1)/(24*3600*1000));
        }
    }

    function loadAssignment(func){
        $.get("/modules/assignment/studentLoadAssignment.php",function(data){
            func();

            data = JSON.parse(data);

            var idList = "";

            var todayTime = 0.0;
            var separatedRecommendation = "";

            for (var i = 0; i < data.length; i++){
                var row = data[i];

                if (row.type == "1"){
                    var timeUnit = parseFloat(row.duration);
                    var date = row.dueday;
                    var daysLeft = DateDiff.inDays(new Date(), new Date(date)) + 1;
                    var todayDoingTime = parseFloat(parseFloat(timeUnit/daysLeft).toFixed(1));

                    var abbrHWContent = row.content;
                    if (abbrHWContent.length > 10){
                        abbrHWContent = abbrHWContent.substring(0,10) + "...";
                    }
                    separatedRecommendation += todayDoingTime + " hours for class " + row.class + " on:<br />"+"&nbsp;&nbsp;&nbsp;&nbsp;"+abbrHWContent+"<br/>";
                    todayTime += todayDoingTime;
                }

                idList += ";" + row.id;

                var assignment = new Assignment("student",row.id, row.type, row.content, row.attachment, date, row.duration);
                $('#assignment-list').append(assignment.getHTML());
            }

            var assignmentTimeRecommendation = "You are recommended to spend " + parseFloat(todayTime).toFixed(1) + " hours on assignments today.<br />";
            $('#assignment-time-management').html(assignmentTimeRecommendation+"Details:<br />"+separatedRecommendation);

            localStorage.assignmentIDList = idList;
        });
    }
    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/class.js";
    ?>
    function loadClass(func){
        $.get("/modules/class/loadClass.php",function(data){
            func();
            data = JSON.parse(data);
            for ( var i = 0; i < data.length; i++){
                var id = data[i].id;
                var teacher = data[i].teacher;
                var name = data[i].name;

                var oneClass = new ClassStudent(id, teacher, name);
                $('#classList').append(oneClass.getHTML());
            }
        })
    }
    function loadAssignmentInClass(id, func){
        $.get("/modules/assignment/classLoadAssignment.php",{class: id},function(data){
            func();
            data = JSON.parse(data);

            var idList = "";
            for (var i = 0; i < data.length; i++){
                var row = data[i];
                idList += ";" + row.id;
                var assignment = new Assignment("student-in-class",row.id, row.type, row.content, row.attachment, row.dueday, row.duration);
                $('#assignment-list-in-class').append(assignment.getHTML());
            }
            localStorage.assignmentIDList2 = idList;
        });
    }
    function openViewClassPanel(id, name){
        loadAssignmentInClass(id, function(){
            $('#assignment-list-in-class').html("");
        });
        $('#right-part-class-id').html(id);
        $('#right-part-title').html("View " + name);
        $('#right-part').show();
    }

    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/settings.js";
    ?>

    toggleModules('Stream');
    loadAssignment(function(){
        $('#assignment-list').html("");
    });
    loadClass(function(){
        $('#classList').html("");
    })

    localStorage.assignmentIDList = "";
    localStorage.assignmentIDList2 = "";

    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/fixfuckingsafari.js";
    ?>

    setInterval(function(){
        WaterFall(localStorage.assignmentIDList,"assignment-list-");
        WaterFall(localStorage.assignmentIDList2,"assignment-list-class-");
    }, 200);

</script>