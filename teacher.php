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


    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/base.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/class.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/assignment.js";
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/settings.js";
    ?>

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
        <div class="card" style="text-align:center" onclick="new Class('', '').addClass()">Add Class</div>
    </div>
    <?php
    require $_SERVER['DOCUMENT_ROOT']."/template/pages/settings.html";
    ?>
</div>
<div id="right-part" style="display:none">
    <div id="actionBar">
        <div style="display: none;" id="right-part-class-id"></div>
        <div style="display: inline-table; vertical-align: middle;padding-bottom:15px;font-size: 1.5em;color: #ffffff; cursor: pointer" onclick="$('#right-part').hide()">
            <div style="font-size: 2em; display: table-cell; vertical-align: middle">&nbsp;&times;&nbsp;</div>
            <div id="right-part-title" style="display: table-cell; vertical-align: middle"> Manage Class</div>
        </div>
    </div>
    <div class="belowActionBar">
        <div style="text-align: center">
            <button class="pure-button pure-button-primary" style="width: 100%; background-color: #0099ff" onclick="new Class('', '').deleteClass()"> Delete Class </button>
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
                            <div class="pure-button pure-button-primary" onclick="new ManipulateAssignment('').sendUpdateAssignment()"> Update </div>
                        </div>
                    </div>
                    <div id="floatBox-view-members">
                        <div id="floatBox-view-members-list"></div>
                    </div>
                    <div id="floatBox-add-card">
                        <div style="text-align: center;display: table; width: 100%;margin-bottom: 1.5em">
                            <div id="switch-between-tab" style="display: table-cell; border-bottom: 4px solid rgb(19, 47, 158)" class="pure-button pure-button-primary" onclick="new Class('', '').switchBetweenAddCardTab('')">Assignment</div>
                            <div id="switch-between-tab_2" style="display: table-cell; border-bottom: 4px solid #0078e7" class="pure-button pure-button-primary" onclick="new Class('', '').switchBetweenAddCardTab('_2')">Information</div>
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

    $(function() {
        $('#add-card-form-dueday').datepick();
        $('#add-card-form-dueday-2').datepick();
    });

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
    function hasFile(id){
        //if there is a value, return true, else: false;
        return $('#'+id).val() ? true: false;
    }

    function validateInputs(type){
        var suffix;
        if (type == 'assignment'){
            suffix = "";
        }else if (type == 'information'){
            suffix = "-2";
        }

        if ( isNull($('#add-card-form-content'+suffix).val()) ){
            alert("Content is empty!");
            return false;
        }
        if ( !validDate($('#add-card-form-dueday'+suffix).val()) ){
            if (type == "assignment"){
                alert("Due day is invalid");
            }else if (type == "information"){
                alert("Expire day is invalid!");
            }
            return false;
        }

        if (type == 'assignment'){
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
        }

        var fileCondition = true;
        if (type == 'assignment'){
            fileCondition = parseInt(localStorage.filesize1) > 25;
        }else if (type == 'information'){
            fileCondition = parseInt(localStorage.filesize2) > 25;
        }
        if (fileCondition){
            alert("File size in total should not exceed 25MB.");
            return false;
        }

        return true;
    }
    $('#submit_form_node').submit(function(){
        $(this).ajaxSubmit({
            beforeSubmit: function(){
                if (!validateInputs('assignment')){
                    return false;
                }
                $('#submit_btn_add_card').prop('disabled',true).val("Sending...");
                return true;
            },
            clearForm: true,
            data:{hasAttachment: hasFile('add-card-form-file')},
            success: function(content,textStatus,xhr,$form){
                if (content == "Success"){
                    alert(content);
                    localStorage.filesize1 = 0;
                }
                $('#submit_btn_add_card').prop('disabled',false).val("Submit");
                $('#shadow').hide();
                new Class($('#add-card-class-id').val(), '').loadAssignment(1, function(){
                    $('#assignment-list').html("");
                })
            }
        });
        return false;
    });
    $('#submit_form_node_2').submit(function(){
        $(this).ajaxSubmit({
            beforeSubmit: function(){
                if (!validateInputs('information')){
                    return false;
                }
                $('#submit_btn_add_card-2').prop('disabled',true).val("Sending...");
                return true;
            },
            clearForm: true,
            data:{hasAttachment: hasFile('add-card-form-file-2')},
            success: function(content,textStatus,xhr,$form){
                if (content == "Success"){
                    alert(content);
                    localStorage.filesize2 = 0;
                }
                $('#submit_btn_add_card-2').prop('disabled',false).val("Submit");
                $('#shadow').hide();
                new Class($('#add-card-class-id-2').val(), '').loadAssignment(1, function(){
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

    toggleModules("Class");
    new Class('', '').loadClass(2, function(){});
</script>