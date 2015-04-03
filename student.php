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
        @media (min-width: 955px) {
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
            #assignment-time-management-caller{
                position: fixed;
                background-color: #FF3333;
                text-align: center;
                box-shadow: -10px 10px 10px gray;
                color: white;
                font-size: 3em;
                right: 5px;
                top: 5px;
                width: 1.3em;
                height: 1.3em;
                border-radius: 5em;
                z-index: 1500;
            }
            #assignment-time-management-wrapper{
                position: fixed;
                right: 0;
                top: 0;
                z-index: 2000;
                width: 370px;
                box-shadow: -10px 0px 10px #888;
                height: 100%;
                background-color: rgba(239,239,239,0.9);
            }
            #assignment-time-management-wrapper.hide{
                display: none;
            }
            #assignment-time-management{
                margin-top: 3em;
            }
            #panel-close{
                position: absolute;
                right: 0;
                top: 0;
                font-size: 1.5em;
                color: #0078e7;
                padding: 0.5em;
            }
        }
        @media (max-width: 955px) {
            #assignment-time-management-caller{
                display: none;
            }
            #assignment-time-management{
            }
            #panel-close{
                display: none;
            }
        }
    </style>
</head>
<body>
<script>
    function toggleModules(id){
        $('#right-part').hide();
        $('#assignment-time-management-wrapper').addClass("hide");
        $('#mStream').hide();
        $('#left-tab-Stream').css("background","#1f8dd6").css("color","white");
        $('#mClass').hide();
        $('#left-tab-Class').css("background","#1f8dd6").css("color","white");
        $('#mSettings').hide();
        $('#left-tab-Settings').css("background","#1f8dd6").css("color","white");
        $('#m'+id).show()
        $('#left-tab-'+id).css("background","white").css("color","#1f8dd6");
        if (id == "Stream"){
            $('#assignment-time-management-wrapper').removeClass("hide");
        }
    }
</script>
<div id="header-part">
    <a id="appName" href="#"><?= $appName ?></a>
    <a id="userName" href="#"><?= $username ?></a>
    <ul id="header-tabs-outer">
        <li class="header-tab"><a href="#" class="header-tab-a" id="left-tab-Stream" onclick="toggleModules('Stream')">Stream</a></li>
        <li class="header-tab"><a href="#" class="header-tab-a" id="left-tab-Class" onclick="toggleModules('Class')">Classes</a></li>
        <li class="header-tab"><a href="#" class="header-tab-a" id="left-tab-Settings" onclick="toggleModules('Settings')">Settings</a></li>
    </ul>
</div>
<div id="body-part">
    <div id="mStream">
        <div id="assignment-time-management-caller" style="display: none;" onclick="$('#assignment-time-management-wrapper').show();$('#assignment-time-management-caller').hide()">
            <div>+</div>
        </div>
        <div id="assignment-time-management-wrapper">
            <div id="panel-close" onclick="$('#assignment-time-management-wrapper').hide();$('#assignment-time-management-caller').show()">Close</div>
            <div id="assignment-time-management"></div>
        </div>
        <div id="assignment-list" style="position: relative">
            <div class="card">Loading information...</div>
        </div>
    </div>
    <div id="mClass" style="display: none">
        <div id="classList"></div>
        <div class="card" style="text-align:center" onclick="addToClass()">Add Class</div>
    </div>
    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/pages/settings.html";
    ?>
</div>
<div id="right-part" style="display:none">
    <div id="actionBar">
        <div style="display: inline-block" onclick="$('#assignment-list-in-class').empty();setTimeout(function(){$('#right-part').hide()},200)">
            <div class="material-icon arrow" data-icon="arrow" style="width: 50px;height: 30px;">
                <span class="first"></span>
                <span class="second"></span>
                <span class="third"></span>
            </div>
        </div>
        <div style="display: none;" id="right-part-class-id"></div>
        <div style="display: inline-table; vertical-align: middle;padding-bottom:15px;font-size: 1.5em;color: #ffffff" id="right-part-title">Manage Class</div>
    </div>
    <div id="assignment-list-in-class" class="belowActionBar"></div>
</div>

<div id="shadow" style="display: none;">
    <div style="display:table-cell;vertical-align: middle">
        <div style="display:table;margin-left:auto;margin-right: auto;">
            <div id="floatBox">
                <div id="floatBox-close" onclick="$('#shadow').hide()">Close</div>
                <div class="settings_title_bar" id="floatBox-title"></div>
                <div id="floatBox-content"></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    /* Class Module */
    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/base.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/waterfall.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/assignment.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/waterfall.js";
    ?>


    function loadAssignment(func){
        $.get("/modules/assignment/studentLoadAssignment.php",function(data){
            func();

            data = JSON.parse(data);

            var idList = "";

            /* Notification Start */
            var todayItemCounter = 0;
            var todayHoursCounter = 0.0;
            function outputTodayNotification(){
                var notification = "<div class=\"card\">" + "Assignments due tomorrow: <br>" + todayItemCounter + " item(s)/" + todayHoursCounter + " hour(s)" +"</div>";
                return notification;
            }
            /* Notification End */

            /* Suggestion Start */
            var len = data.length;
            var assignmentCounter = 0;
            var todayTime = 0.0;
            var separatedRecommendation = "";
            var subjectArr = new Array(), hoursArr = new Array(), itemsArr = new Array();

            function findIDInArrayByName(name){
                for (var i = 0; i < subjectArr.length; i++){
                    if ( subjectArr[i] == name ){
                        return i;
                    }
                }
                return -1;
            }
            function addTo(name, hours){
                var id = findIDInArrayByName(name);
                if ( id == -1 ){
                    subjectArr[0] = name;
                    hoursArr[0] = hours;
                    itemsArr[0] = 1
                }else{
                    hoursArr[id] = hoursArr[id] + hours;
                    itemsArr[id] = itemsArr[id] + 1;
                }
            }
            function outputSuggestion(){
                for (var i = 0; i < subjectArr.length; i++){
                    separatedRecommendation += subjectArr[i] + ": " + hoursArr[i] + " hour(s)/" + itemsArr[i] + " item(s)<br />";
                }
                var assignmentTimeRecommendation = "Recommendation: " + assignmentCounter + " item(s)/" + parseFloat(todayTime).toFixed(1) + " hour(s) today.<br />";
                var suggestion = "<div class=\"card\">"+assignmentTimeRecommendation+"Details:<br />"+separatedRecommendation+"</div>";

                return suggestion;
            }
            /* Suggestion End */

            for (var i = 0; i < len; i++){
                var row = data[i];

                if (row.type == "1"){
                    var timeUnit = parseFloat(row.duration);
                    var date = row.dueday;
                    var daysLeft = DateDiff.inDays(new Date(), new Date(date));
                    var todayDoingTime = parseFloat(parseFloat(timeUnit/daysLeft).toFixed(1));

                    if (daysLeft == 1){
                        todayItemCounter += 1;
                        todayHoursCounter += todayDoingTime;
                    }

                    addTo(row.subject, todayDoingTime);
                    todayTime += todayDoingTime;

                    assignmentCounter++;
                }

                idList += ";" + row.id;

                var assignment = new Assignment("student",row.id, row.type, row.content, row.attachment, row.publish, row.dueday, row.subject, row.duration);
                $('#assignment-list').append(assignment.getHTML());
            }

            $('#assignment-time-management').html(outputTodayNotification() + outputSuggestion());

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
                var assignment = new Assignment("student-in-class",row.id, row.type, row.content, row.attachment, row.publish, row.dueday, row.subject, row.duration);
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
    function addToClass(){
        var classID = prompt("Please enter the class ID", "");
        if (isNaN(classID)){
            alert("Invalid class ID");
        }else if (classID == null || classID == ""){
            // Do nothing.
        }else{
            $.get("/modules/class/addToClass.php",{class: classID},function(data){
                loadClass(function(){
                    $('#classList').empty();
                })
                alert(data);
            })
        }
    }

    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/settings.js";
    ?>

    toggleModules('Stream'); $('#assignment-time-management-wrapper').removeClass("hide");
    loadAssignment(function(){
        $('#assignment-list').html("");
    });
    loadClass(function(){
        $('#classList').html("");
    })

    localStorage.assignmentIDList = "";
    localStorage.assignmentIDList2 = "";

    setInterval(function(){
        WaterFall(localStorage.assignmentIDList,"assignment-list-");
        WaterFall(localStorage.assignmentIDList2,"assignment-list-class-");
    }, 200);

</script>