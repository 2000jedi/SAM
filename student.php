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
            <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
                <svg id="todaySVG" fill="currentColor" width="150px" height="150px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop" style="margin: 1em auto">
                    <use xlink:href="#todayCircleChart" mask="url(#piemask)" />
                    <text x="0.5" y="0.55" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">
                        <tspan dy="0" font-size="0.3" id="todayPercentage">0</tspan><tspan dy="-0.07" font-size="0.2">%</tspan>
                    </text>
                    <text x="0.5" y="0.7" font-family="Roboto" font-size="0.1" fill="#888" text-anchor="middle" dy="0.1">TODAY</text>
                </svg>
                <svg id="totalSVG" fill="currentColor" width="150px" height="150px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop" style="margin: 1em auto">
                    <use xlink:href="#totalCircleChart" mask="url(#piemask)" />
                    <text x="0.5" y="0.55" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">
                        <tspan dy="0" font-size="0.3" id="totalPercentage">0</tspan><tspan dy="-0.07" font-size="0.2">%</tspan>
                    </text>
                    <text x="0.5" y="0.7" font-family="Roboto" font-size="0.1" fill="#888" text-anchor="middle" dy="0.1">ALL</text>
                </svg>
            </div>
            <div id="assignment-list" class="pinterestStyleWrapper mdl-grid demo-content"></div>
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
        <div id="assignment-list-in-class" class="pinterestStyleWrapper mdl-grid demo-content"></div>
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
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 500 250" style="position: fixed; left: -1000px; height: -1000px;">
    <defs>
        <g id="chart">
            <g id="Gridlines">
                <line fill="#888888" stroke="#888888" stroke-miterlimit="10" x1="0" y1="27.3" x2="468.3" y2="27.3"/>
                <line fill="#888888" stroke="#888888" stroke-miterlimit="10" x1="0" y1="66.7" x2="468.3" y2="66.7"/>
                <line fill="#888888" stroke="#888888" stroke-miterlimit="10" x1="0" y1="105.3" x2="468.3" y2="105.3"/>
                <line fill="#888888" stroke="#888888" stroke-miterlimit="10" x1="0" y1="144.7" x2="468.3" y2="144.7"/>
                <line fill="#888888" stroke="#888888" stroke-miterlimit="10" x1="0" y1="184.3" x2="468.3" y2="184.3"/>
            </g>
            <g id="Numbers">
                <text transform="matrix(1 0 0 1 485 29.3333)" fill="#888888" font-family="'Roboto'" font-size="9">500</text>
                <text transform="matrix(1 0 0 1 485 69)" fill="#888888" font-family="'Roboto'" font-size="9">400</text>
                <text transform="matrix(1 0 0 1 485 109.3333)" fill="#888888" font-family="'Roboto'" font-size="9">300</text>
                <text transform="matrix(1 0 0 1 485 149)" fill="#888888" font-family="'Roboto'" font-size="9">200</text>
                <text transform="matrix(1 0 0 1 485 188.3333)" fill="#888888" font-family="'Roboto'" font-size="9">100</text>
                <text transform="matrix(1 0 0 1 0 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">1</text>
                <text transform="matrix(1 0 0 1 78 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">2</text>
                <text transform="matrix(1 0 0 1 154.6667 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">3</text>
                <text transform="matrix(1 0 0 1 232.1667 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">4</text>
                <text transform="matrix(1 0 0 1 309 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">5</text>
                <text transform="matrix(1 0 0 1 386.6667 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">6</text>
                <text transform="matrix(1 0 0 1 464.3333 249.0003)" fill="#888888" font-family="'Roboto'" font-size="9">7</text>
            </g>
            <g id="Layer_5">
                <polygon opacity="0.36" stroke-miterlimit="10" points="0,223.3 48,138.5 154.7,169 211,88.5
                  294.5,80.5 380,165.2 437,75.5 469.5,223.3 	"/>
            </g>
            <g id="Layer_4">
                <polygon stroke-miterlimit="10" points="469.3,222.7 1,222.7 48.7,166.7 155.7,188.3 212,132.7
                  296.7,128 380.7,184.3 436.7,125 	"/>
            </g>
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
                        }
                        todayTotalTime += singleTime;
                    }
                    if (row.finished == true){
                        totalDoneTime += singleTime;
                    }
                    totalTotalTime += singleTime;
                }
                if (todayTotalTime == 0){
                    todayTotalTime = 1;
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

            var todayPercentage = ProcessPercentage(parseFloat(parseFloat(todayDoneTime / todayTotalTime)).toFixed(2));
            var totalPercentage = ProcessPercentage(parseFloat(parseFloat(totalDoneTime / totalTotalTime)).toFixed(2));

            function changeCircle(id, percentage){
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
            }

            changeCircle("today", todayPercentage);
            changeCircle("total", totalPercentage);
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


    setInterval(function(){
        Waterfall("assignment-list");
        Waterfall("assignment-list-in-class");
    }, 200);

</script>