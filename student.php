<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 10/23/15
 * Time: 22:02
 */

if (!function_exists('checkForceQuit')){
    die("You are detected as an unexpected intruder.");
}else{
    checkForceQuit();
}

?>
<!DOCTYPE HTML>
<!--
  Material Design Lite
  Copyright 2015 Google Inc. All rights reserved.

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

      https://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="SAM, System of Assignment Management">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $appName ?> - Student</title>
    <link rel="shortcut icon" href="/favicon.ico" />
    <script src="/framework/js/jq.js"></script>
    <script src="/framework/js/form.js"></script>
    <script src="/framework/js/masonry.js"></script>
    <script src="/framework/js/material.js"></script>
    <style>
        <?php
            require $_SERVER['DOCUMENT_ROOT']."/framework/material/material.min.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/material/material-dashboard-styles.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/geodesic/base.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/geodesic/settings.css";
        ?>
        /*
            Desktop: 840px
            Tablet: 480px
        */
        @media (min-width: 840px){
            #percentageRings{
                position: fixed;
                top: 56px;
                right: 0px;
                height: calc(100% - 56px);
                height: -moz-calc(100% - 56px);
                height: -webkit-calc(100% - 56px);
                width: 200px;
            }
            #todaySVG, #totalSVG{
                display: block;
                width: 100%;
            }
            #assignment-list-wrapper{
                width: calc(100% - 240px);
                width: -moz-calc(100% - 240px);
                width: -webkit-calc(100% - 240px);
            }
        }
        @media (max-width: 840px){
            #todaySVG, #totalSVG{
                width: 120px;
                height: 120px;
            }
            #assignment-list-wrapper{
                width: 100%;
            }
        }
        #assignment-list, #assignment-list-class{
            margin: 0 auto;
        }
    </style>
</head>
<script>
    function toggleModules(id){
        $('#right-part').hide();
        $('#mHome').hide();
        $('#left-tab-Home').css("background","").css("color","#eceff1");
        $('#mClasses').hide();
        $('#left-tab-Classes').css("background","").css("color","#eceff1");
        $('#mSettings').hide();
        $('#left-tab-Settings').css("background","").css("color","#eceff1");
        $('#m'+id).show();
        $('#left-tab-'+id).css("background","#00BCD4").css("color","#37474F");
        $('#title').html(id);
        $('.demo-drawer').removeClass("is-visible")
    }
</script>
<body>
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
                <span style="display: block; margin-top: 0.5em"><?= $username ?></span>
            </div>
        </header>
        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
            <a id="left-tab-Home" onclick="toggleModules('Home')" class="mdl-navigation__link" href="#"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home</a>
            <a id="left-tab-Classes" onclick="toggleModules('Classes')" class="mdl-navigation__link" href="#"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">school</i>Classes</a>
            <a id="left-tab-Settings" onclick="toggleModules('Settings')" class="mdl-navigation__link" href="#"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">settings</i>Settings</a>
        </nav>
    </div>
    <main class="mdl-layout__content mdl-color--grey-100">
        <div id="loading" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="width: auto;"></div>
        <div id="mHome">
            <div id="percentageRings" class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
                <svg id="todaySVG" fill="currentColor" width="150px" height="150px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop" style="margin: 1em auto; position: relative">
                    <use xlink:href="#todayCircleChart" mask="url(#piemask)" />
                    <text x="0.5" y="0.55" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">
                        <tspan dy="0" font-size="0.3" id="todayPercentage">0</tspan><tspan dy="-0.09" font-size="0.15">%</tspan>
                    </text>
                    <text x="0.5" y="0.65" font-size="0.1" fill="#888" text-anchor="middle" dy="0.1">
                        <tspan dy="0" font-size="0.1" id="todayItemsDone">0</tspan><tspan dy="0" font-size="0.08"> OUT OF </tspan><tspan dy="0" font-size="0.1" id="todayTotalItems">0</tspan>
                    </text>
                    <text x="0.5" y="0.75" font-size="0.1" fill="#888" text-anchor="middle" dy="0.1">TODAY</text>
                </svg>
                <svg id="totalSVG" fill="currentColor" width="150px" height="150px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop" style="margin: 1em auto; position: relative">
                    <use xlink:href="#totalCircleChart" mask="url(#piemask)" />
                    <text x="0.5" y="0.55" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">
                        <tspan dy="0" font-size="0.3" id="totalPercentage">0</tspan><tspan dy="-0.09" font-size="0.15">%</tspan>
                    </text>
                    <text x="0.5" y="0.65" font-size="0.1" fill="#888" text-anchor="middle" dy="0.1">
                        <tspan dy="0" font-size="0.1" id="totalItemsDone">0</tspan><tspan dy="0" font-size="0.08"> OUT OF </tspan><tspan dy="0" font-size="0.1" id="totalTotalItems">0</tspan>
                    </text>
                    <text x="0.5" y="0.75" font-size="0.1" fill="#888" text-anchor="middle" dy="0.1">ALL</text>
                </svg>
            </div>
            <div id="assignment-list-wrapper">
                <div id="assignment-list"></div>
            </div>
        </div>
        <div id="mClasses">
            <div id="classList" class="mdl-grid demo-content"></div>
        </div>
        <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/pages/settings.html";
        ?>
    </main>
    <div id="right-part" class="mdl-layout--fixed-header" style="display:none">
        <header class="demo-header mdl-layout__header mdl-color--white mdl-color--grey-100 mdl-color-text--grey-600">
            <div class="mdl-layout__header-row" style="padding-left: 1em; cursor: pointer" onclick="$('#assignment-list-in-class').empty();$('#right-part').hide()">
                    <span class="mdl-layout-title" style="display: flex; flex-direction: row">
                        <span class="material-icons"style="display: flex">close</span>
                        <span id="right-part-title" style="display: flex">Manage Class</span>
                    </span>
            </div>
        </header>
        <div id="assignment-list-class"></div>
    </div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" style="position: fixed; left: -1000px; height: -1000px;">
    <defs>
        <mask id="piemask" maskContentUnits="objectBoundingBox">
            <circle cx=0.5 cy=0.5 r=0.49 fill="white" />
            <circle cx=0.5 cy=0.5 r=0.40 fill="black" />
        </mask>
        <g id="todayCircleChart">
            <circle cx=0.5 cy=0.5 r=0.5 />
            <path id="todayCircle" d="M 0.5 0.5 0.5 0 A 0.5 0.5 0 1 1 0.4996858407553117 9.869604078449612e-8 z" stroke="none" fill="rgba(255, 255, 255, 0.75)" />
        </g>
        <g id="totalCircleChart">
            <circle cx=0.5 cy=0.5 r=0.5 />
            <path id="totalCircle" d="M 0.5 0.5 0.5 0 A 0.5 0.5 0 1 1 0.4996858407553117 9.869604078449612e-8 z" stroke="none" fill="rgba(255, 255, 255, 0.75)" />
        </g>
    </defs>
</svg>
</body>
</html>
<script>
    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/base.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/class.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/settings.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/waterfall.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/assignment.js";
    ?>


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
                    var timeUnit = parseFloat(row.duration);
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
                function ProcessPercentage(percentage){
                    if (percentage < 0.01){
                        return 0.01;
                    }
                    return percentage;
                }
                var assignment = new Assignment("student",row.id, row.type, row.content, row.attachment, row.publish, row.dueday, subject, row.duration, row.finished);
                $('#assignment-list').append(assignment.getHTML())
            }

            if (todayTotalTime == 0){
                todayDoneTime = 1;
                todayTotalTime = 1;
            }
            if (totalTotalTime == 0){
                totalDoneTime = 1;
                totalTotalTime = 1;
            }

            var todayPercentage = ProcessPercentage(parseFloat(parseFloat(todayDoneTime / todayTotalTime)).toFixed(2));
            var totalPercentage = ProcessPercentage(parseFloat(parseFloat(totalDoneTime / totalTotalTime)).toFixed(2));

            function changeCircle(id, percentage, itemDone, itemTotal){
                var deg = (1 - percentage) * 360;
                function polarToCartesian(centerX, centerY, radius, angleInDegrees) {
                    var angleInRadians = (angleInDegrees-90) * Math.PI / 180.0;
                    return {
                        x: centerX + (radius * Math.cos(angleInRadians)),
                        y: centerY + (radius * Math.sin(angleInRadians))
                    };
                }
                function describeArc(x, y, radius, endAngle){
                    var end = polarToCartesian(x, y, radius, endAngle), val = endAngle < 180 ? 0: 1;
                    var d = ["M", 0.5, 0.5, 0.5, 0, "A", 0.5, 0.5, 0, val, 1, end.x, end.y, "z"].join(" ");
                    return d;
                }
                $('#' + id + 'Circle').attr("d", describeArc(0.5, 0.5, 0.5, deg));
                if (percentage == 0.01){
                    percentage = 0;
                }
                var updatedText = parseInt(percentage * 100).toString();
                $('#' + id + 'Percentage').html(updatedText);
                $('#' + id + 'ItemsDone').html(itemDone.toString());
                $('#' + id + 'TotalItems').html(itemTotal.toString());
            }

            changeCircle("today", todayPercentage, todayDoneItems, todayTotalItems);
            changeCircle("total", totalPercentage, totalDoneItems, totalTotalItems);
            updateMasonry('assignment-list');
        });
    }

    toggleModules('Home');

    loadAssignment(function(){
        $('#assignment-list').html("");
    });

    new Class('', '').loadClass(1, function(){
        $('#classList').html("");
    });

    localStorage.assignmentIDList = "";
    localStorage.assignmentIDList2 = "";

    $('#assignment-list').on( 'click', '.assignment-list', function() {
        $('#assignment-list').masonry('layout');
    });
    $('#assignment-list-class').on( 'click', '.assignment-list-class', function() {
        $('#assignment-list-class').masonry('layout');
    });


</script>