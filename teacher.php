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
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?= $appName ?> - Teacher</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <link rel="shortcut icon" href="/favicon.ico" />
    <script src="/framework/js/jq.js"></script>
    <script src="/framework/js/form.js"></script>
    <script src="/framework/fix/safari/fixdateinput.js"></script>
    <style>
        <?php
            require $_SERVER['DOCUMENT_ROOT']."/framework/pure/pure-min.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/geodesic/base.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/geodesic/settings.css";
            require $_SERVER['DOCUMENT_ROOT']."/framework/fix/safari/fixdateinput.css";
        ?>
    </style>
</head>
<body>
<script>
    function toggleModules(id){
        $('#right-part').hide();
        $('#mClass').hide();
        $('#left-tab-Class').css("background","#2196F3").css("color","white");
        $('#mSettings').hide();
        $('#left-tab-Settings').css("background","#2196F3").css("color","white");
        $('#m'+id).show();
        $('#left-tab-'+id).css("background","white").css("color","#2196F3");
    }
</script>
<div id="loading" style="display:block">Loading...</div>
<div id="header-part">
    <a id="appName" href="#"><?= $appName ?></a>
    <a id="userName" href="#"><?= $username ?></a>
    <ul id="header-tabs-outer">
        <li class="header-tab"><a href="#" id="left-tab-Class" class="header-tab-a" onclick="toggleModules('Class')">Classes</a></li>
        <li class="header-tab"><a href="#" id="left-tab-Settings" class="header-tab-a" onclick="toggleModules('Settings')">Settings</a></li>
    </ul>
</div>
<div id="body-part">
    <div id="mClass">
        <div id="classList"></div>
        <div class="card" style="text-align:center" onclick="addClass()">Add Class</div>
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
    <div class="belowActionBar">
        <div style="text-align: center">
            <button class="pure-button pure-button-primary" style="width: 100%; background-color: #0099ff" onclick="deleteClass()"> Delete Class </button>
        </div>
        <div id="assignment-list"></div>
    </div>
</div>
<div id="shadow" style="display: none;">
    <div style="display:table-cell;vertical-align: middle">
        <div style="display:table;margin-left:auto;margin-right: auto;">
            <div id="floatBox">
                <div id="floatBox-close" onclick="$('#shadow').hide()">Close</div>
                <div class="settings_title_bar" style="padding: 0;">
                    <div id="floatBox-title" style="margin: 0.5em"></div>
                </div>
                <div id="floatBox-content">
                    <div id="floatBox-update-card">
                        <div>
                            <label>Content:</label>
                            <div style="display: none" id="update-card-content-id"></div>
                            <textarea class="card" id="update-card-content-ta" name="content" type="text" placeholder="Content"></textarea>
                        </div>
                        <div>
                            <div class="pure-button pure-button-primary" onclick="sendUpdateAssignment()"> Update </div>
                        </div>
                    </div>
                    <div id="floatBox-view-members">
                        <div id="floatBox-view-members-list"></div>
                    </div>
                    <div id="floatBox-add-card">
                        <div style="text-align: center;display: table; width: 100%;margin-bottom: 1.5em">
                            <div id="switch-between-tab" style="display: table-cell; border-bottom: 4px solid rgb(19, 47, 158)" class="pure-button pure-button-primary" onclick="switchBetweenAddCardTab('')">Assignment</div>
                            <div id="switch-between-tab_2" style="display: table-cell; border-bottom: 4px solid #0078e7" class="pure-button pure-button-primary" onclick="switchBetweenAddCardTab('_2')">Information</div>
                        </div>
                        <div>
                            <form id="submit_form_node" action='/modules/assignment/addAssignment.php' method="post" enctype="multipart/form-data">
                                <input id="add-card-class-id" type="hidden" name="class" />
                                <input type="hidden" name="type" value="1" />
                                <div>
                                    <label>Content:</label>
                                    <textarea class="card" id="add-card-form-content" name="content" type="text" placeholder="Content"></textarea>
                                </div>
                                <div>
                                    <label>Estimated Duration (in minutes):</label>
                                    <input class="card" id="add-card-form-duration" name="duration" type="text" placeholder="Estimated Duration (Now in minutes)" />
                                </div>
                                <div>
                                    <label>Due:</label>
                                    <input class="card" id="add-card-form-dueday" name="dueday" style="margin-top: 0.5em" type="text" placeholder="Due Day" data-format="yyyy-MM-dd" />
                                </div>
                                <div>
                                    <label>Add attachment (optional):</label>
                                    <input class="card uploadfile1" id="add-card-form-file" style="margin-top: 0.5em" name="attachment[]" type="file" multiple />
                                    <button id="add-card-form-file-button-1">Add More Files</button>
                                </div>
                                <div style="text-align: center">
                                    <input type="submit" value="Submit" id="submit_btn_add_card" class="pure-button pure-button-primary" style="display:inline-block" />
                                </div>
                            </form>
                            <form id="submit_form_node_2" class="dropzone" action='/modules/assignment/addAssignment.php' method="post" enctype="multipart/form-data" style="display: none;">
                                <input id="add-card-class-id-2" type="hidden" name="class" />
                                <input type="hidden" name="type" value="2" />
                                <div>
                                    <label>Content:</label>
                                    <textarea class="card" id="add-card-form-content-2" name="content" type="text" placeholder="Content"></textarea>
                                </div>
                                <div style="position: relative">
                                    <label>Expire (leave it blank to keep it permanently):</label>
                                    <input class="card" id="add-card-form-dueday-2" name="dueday" style="margin-top: 0.5em" type="text" placeholder="Expire Day"  data-format="yyyy-MM-dd" />
                                </div>
                                <div>
                                    <label>Add attachment (optional):</label>
                                    <input class="card uploadfile2" id="add-card-form-file-2" style="margin-top: 0.5em" name="attachment[]" type="file" multiple />
                                    <button id="add-card-form-file-button-2">Add More Files</button>
                                </div>
                                <div style="text-align: center">
                                    <input type="submit" value="Submit" id="submit_btn_add_card-2" class="pure-button pure-button-primary" style="display:inline-block" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/base.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/class.js";
    ?>

    $(function() {
        $('#add-card-form-dueday').datepick();
        $('#add-card-form-dueday-2').datepick();
    });
    /* Class Module */
    function addClass(){
        var name = prompt("Please enter the name for the new Class", "");
        if (name == null || name == ""){
            // Do nothing.
        }else{
            $.post("/modules/class/createClass.php", {name: name}, function (data) {
                if (data == "Success") {
                    $('#new-class-name').val("");
                    $('#shadow').hide();
                    loadClass(function () {
                        $('#classList').html("");
                    });
                }
                alert(data);
            })
        }
    }
    function loadClass(func){
        $.get("/modules/class/loadClass.php",function(data){
            func();
            data = JSON.parse(data);
            for ( var i = 0; i < data.length; i++){
                var id = data[i].id;
                var teacher = data[i].teacher;
                var name = data[i].name;
                var subject = convertSubject(data[i].subject);

                var oneClass = new ClassTeacher(id, teacher, name, subject);
                $('#classList').append(oneClass.getHTML());
            }
        })
    }

    function openUpdateCardBox(){
        $('#floatBox-add-card').hide();
        $('#floatBox-view-members').hide();
        $('#floatBox-update-card').show();
        $('#floatBox-title').html("Update Assignment");
        $('#shadow').css("display","table");
    }
    function openAddCardBox(id, name){
        $('#floatBox-update-card').hide();
        $('#floatBox-view-members').hide();
        $('#floatBox-add-card').show();
        $('#floatBox-title').html("Add Assignment/Information: " + name);
        $('#add-card-class-id').val(id);
        $('#add-card-class-id-2').val(id);
        $('#shadow').css("display","table");
    }
    function switchBetweenAddCardTab(id){
        $('#submit_form_node').hide();
        $('#submit_form_node_2').hide();
        $('#submit_form_node'+id).show()
        $('#switch-between-tab'+id).css("border-bottom", "4px solid rgb(19, 47, 158)");
        id = id == "" ? "_2" : "";
        $('#switch-between-tab'+id).css("border-bottom", "4px solid #0078e7");;
    }
    function hasFile(){
        //if there is a value, return true, else: false;
        return $('#add-card-form-file').val() ? true: false;
    }
    function hasFile2(){
        return $('#add-card-form-file-2').val() ? true: false;
    }
    $('#submit_form_node').submit(function(){
        $(this).ajaxSubmit({
            beforeSubmit: function(){
                function isNull(t){
                    if (t == null || t == ""){return true}
                    return false;
                }
                function getToday() {
                    var today = new Date(), dd = today.getDate(), mm = today.getMonth() + 1; //January is 0!
                    var yyyy = today.getFullYear();
                    if (dd < 10) {dd = '0' + dd}
                    if (mm < 10) {mm = '0' + mm}
                    today = yyyy + "-" + mm + "-" + dd;
                    return today;
                }
                function validDate(dateStr) {
                    var d1 = Date.parse(getToday()), d2 = Date.parse(dateStr);
                    if (d1 > d2) {return false}
                    return true;
                }

                if ( isNull($('#add-card-form-content').val()) ){
                    alert("Content is empty!");
                    return false;
                }
                if ( isNull($('#add-card-form-duration').val()) ){
                    alert("Duration is empty!");
                    return false;
                }
                if ( isNaN($('#add-card-form-duration').val()) ){
                    alert("Duration is not a number!");
                    return false;
                }else{
                    if ( parseFloat($('#add-card-form-duration').val()) <=0  ){
                        alert("Duration should be greater than zero!");
                        return false;
                    }else if ( parseFloat($('#add-card-form-duration').val()) > 1000  ){
                        alert("It is inappropriate to give students so much homework to do!");
                        return false;
                    }
                }
                if ( isNull($('#add-card-form-dueday').val()) ){
                    alert("Due day is empty!");
                    return false;
                }
                if ( !validDate($('#add-card-form-dueday').val()) ){
                    alert("Due day is invalid!");
                    return false;
                }
                if ( parseInt(localStorage.filesize1) > 25 ){
                    alert("File size in total should not exceed 25MB.");
                    return false;
                }
                $('#submit_btn_add_card').prop('disabled',true).val("Sending...");

                return true;
            },
            clearForm: true,
            data:{hasAttachment: hasFile()},
            success: function(content,textStatus,xhr,$form){
                if (content == "Success"){
                    alert(content);
                }
                $('#submit_btn_add_card').prop('disabled',false).val("Submit");
                $('#shadow').hide();
                loadAssignment($('#add-card-class-id').val(),function(){
                    $('#assignment-list').html("");
                })
            }
        });
        return false;
    });
    $('#submit_form_node_2').submit(function(){
        $(this).ajaxSubmit({
            beforeSubmit: function(){
                function isNull(t){
                    if (t == null || t == ""){return true}
                    return false;
                }
                function getToday() {
                    var today = new Date(), dd = today.getDate(), mm = today.getMonth() + 1; //January is 0!
                    var yyyy = today.getFullYear();
                    if (dd < 10) {dd = '0' + dd}
                    if (mm < 10) {mm = '0' + mm}
                    today = yyyy + "-" + mm + "-" + dd;
                    return today;
                }
                function validDate(dateStr) {
                    var d1 = Date.parse(getToday()), d2 = Date.parse(dateStr);
                    if (d1 > d2) {return false}
                    return true;
                }

                if ( isNull($('#add-card-form-content-2').val()) ){
                    alert("Content is empty!");
                    return false;
                }
                if ( !validDate($('#add-card-form-dueday-2').val()) ){
                    alert("Expire day is invalid!");
                    return false;
                }
                if (parseInt(localStorage.filesize2) > 25){
                    alert("File size in total should not exceed 25MB.");
                    return false;
                }
                $('#submit_btn_add_card-2').prop('disabled',true).val("Sending...");
                return true;
            },
            clearForm: true,
            data:{hasAttachment: hasFile2()},
            success: function(content,textStatus,xhr,$form){
                if (content == "Success"){
                    alert(content);
                }
                $('#submit_btn_add_card-2').prop('disabled',false).val("Submit");
                $('#shadow').hide();
                loadAssignment($('#add-card-class-id-2').val(),function(){
                    $('#assignment-list').html("");
                })
            }
        });
        return false;
    });
    $('#add-card-form-file-button-1').click(function(e){
        e.preventDefault();
        html = "<input class='card uploadfile1' name='attachment[]' type='file' multiple />";
        $(this).before(html);
    });
    $('#add-card-form-file-button-2').click(function(e){
        e.preventDefault();
        html = "<input class='card uploadfile2' name='attachment[]' type='file' multiple />";
        $(this).before(html);
    });
    $('.uploadfile1').bind('change', function() {
        var temp = 0;
        for (var i = 0; i < this.files.length; i++){
            temp += this.files[i].size/1024/1024;
        }
        localStorage.filesize1 = parseInt(localStorage.filesize1) + temp;
    });
    $('.uploadfile2').bind('change', function() {
        var temp = 0;
        for (var i = 0; i < this.files.length; i++){
            temp += this.files[i].size/1024/1024;
        }
        localStorage.filesize2 = parseInt(localStorage.filesize2) + temp;
    });
    localStorage.filesize1 = 0;
    localStorage.filesize2 = 0;

    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/assignment.js";
    ?>

    function loadAssignment(id, func){
        $.get("/modules/assignment/classLoadAssignment.php",{class: id},function(data){
            func();
            data = JSON.parse(data);
            for (var i = 0; i < data.length; i++){
                var row = data[i];
                var assignment = new Assignment("teacher", row.id, row.type, row.content, row.attachment, row.publish, row.dueday, convertSubject(row.subject), row.duration, row.finished);
                $('#assignment-list').append(assignment.getHTML());
            }
        });
    }
    function viewMembers(id){
        $.get('/modules/class/loadClassMembers.php',{class: id},function(data){
            data = JSON.parse(data);

            var html = "<div class='card' style='width: calc(100%-2em);box-sizing: border-box;'>Total Number: " + data.length + "</div>";
            for (var i = 0; i < data.length; i++){
                var userInfo = data[i];
                var username = userInfo.username;
                var ChineseName = userInfo.ChineseName;
                var EnglishName = userInfo.EnglishName;
                html += "<div class='card' style='display:table; width: calc(100%-2em);box-sizing: border-box;'>";
                html += "   <div style='display: table-cell; width: 65%'>Name: "+ ChineseName + " ("+ EnglishName + ")</div><div style='display: table-cell; width: 30%'>ID:"+username+"</div>";
                html += "</div>";
            }
            $('#floatBox-view-members-list').html(html);
            $('#floatBox-title').html("Members in my class");

            $('#floatBox-update-card').hide();
            $('#floatBox-add-card').hide();
            $('#floatBox-view-members').show();
            $('#shadow').css("display","table");
        })
    }
    function openManageClassPanel(id, name){
        loadAssignment(id, function(){
            $('#assignment-list').html("");
        });
        $('#right-part-class-id').html(id);
        $('#right-part-title').html("Manage " + name);
        $('#right-part').show();
    }
    function deleteClass(){
        var id = $('#right-part-class-id').html();
        var conf = confirm("DO YOU REALLY want to delete the class? All the data related to the class will be removed from the server permanently!");
        if (conf == true) {
            $.get("/modules/class/deleteClass.php",{class: id},function(data){
                alert(data);
                window.location = "/";
            });
        }
    }

    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/settings.js";
    ?>
    toggleModules("Class");
    loadClass(function(){});
</script>