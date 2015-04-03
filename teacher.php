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
    <title><?= $appName ?> - Teacher</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" href="/framework/pure/pure-min.css">
    <link rel="stylesheet" href="/framework/geodesic/base.css">
    <link rel="stylesheet" href="/framework/geodesic/settings.css">
    <script src="/framework/js/jq.js"></script>
    <script src="/framework/js/form.js"></script>
</head>
<body>
<script>
    function toggleModules(id){
        $('#right-part').hide();
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
        <li class="header-tab"><a href="#" id="left-tab-Class" class="header-tab-a" onclick="toggleModules('Class')">Classes</a></li>
        <li class="header-tab"><a href="#" id="left-tab-Settings" class="header-tab-a" onclick="toggleModules('Settings')">Settings</a></li>
    </ul>
</div>
<div id="body-part">
    <div id="mClass">
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
    <div id="assignment-list" class="belowActionBar"></div>
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
                    <div id="floatBox-add-class">
                        <div>
                            <div class="form">
                                <input class="card" id="new-class-name" type="text" placeholder="The name for the new class" />
                            </div>
                            <div style="text-align: center">
                                <button onclick="addClass()" class="pure-button pure-button-primary" style="margin:0 auto;display:inline-block;">Add</button>
                            </div>
                        </div>
                    </div>
                    <div id="floatBox-add-card">
                        <div style="text-align: center;display: table; width: 100%;margin-bottom: 1.5em">
                            <div style="display: table-cell" class="pure-button pure-button-primary" onclick="switchBetweenAddCardTab('')">Assignment</div>
                            <div style="display: table-cell" class="pure-button pure-button-primary" onclick="switchBetweenAddCardTab('_2')">Information</div>
                        </div>
                        <div>
                            <form id="submit_form_node" action='/modules/assignment/addAssignment.php' method="post" enctype="multipart/form-data">
                                <input id="add-card-class-id" type="hidden" name="class" />
                                <input type="hidden" name="type" value="1" />
                                <div class="form">
                                    <label>Content:</label>
                                    <textarea class="card" id="add-card-form-content" name="content" type="text" placeholder="Content"></textarea>
                                </div>
                                <div class="form">
                                    <label>Estimated Duration (in hours):</label>
                                    <input class="card" id="add-card-form-duration" name="duration" type="text" placeholder="Estimated Duration" />
                                </div>
                                <div class="form">
                                    <label>Due day:</label>
                                    <input class="card" id="add-card-form-dueday" name="dueday" style="margin-top: 0.5em" type="date" />
                                </div>
                                <div class="form">
                                    <label>Add attachment (optional):</label>
                                    <input class="card" id="add-card-form-file" style="margin-top: 0.5em" name="attachment" type="file" />
                                </div>
                                <div style="text-align: center">
                                    <input type="submit" value="Submit" id="submit_btn_add_card" class="pure-button pure-button-primary" style="display:inline-block" />
                                </div>
                            </form>
                            <form id="submit_form_node_2" action='/modules/assignment/addAssignment.php' method="post" enctype="multipart/form-data" style="display: none;">
                                <input id="add-card-class-id-2" type="hidden" name="class" />
                                <input type="hidden" name="type" value="2" />
                                <div class="form">
                                    <label>Content:</label>
                                    <textarea class="card" id="add-card-form-content-2" name="content" type="text" placeholder="Content"></textarea>
                                </div>
                                <div class="form">
                                    <label>Expire Date (leave it blank to keep it permanently):</label>
                                    <input class="card" id="add-card-form-dueday-2" name="dueday" style="margin-top: 0.5em" type="date" />
                                </div>
                                <div class="form">
                                    <label>Add attachment (optional):</label>
                                    <input class="card" id="add-card-form-file-2" style="margin-top: 0.5em" name="attachment" type="file" />
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
</html>
<script>
    /* Class Module */
    function openAddClassBox(){
        $('#floatBox-add-class').show();
        $('#floatBox-add-card').hide();
        $('#floatBox-title').html("Add Class");
        $('#shadow').css("display","table");
    }
    function addClass(){
        var name = $('#new-class-name').val();
        if (name != null || name != "" ) {
            $.post("/modules/class/createClass.php", {name: name}, function (data) {
                if (data == "Success") {
                    $('#new-class-name').val("");
                    $('#shadow').hide();
                    loadClass(function(){
                        $('#classList').html("");
                    });
                }
                alert(data);
            })
        }
    }
    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/base.js";
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

                var oneClass = new ClassTeacher(id, teacher, name);
                $('#classList').append(oneClass.getHTML());
            }
        })
    }

    function openAddCardBox(id, name){
        $('#floatBox-add-class').hide();
        $('#floatBox-add-card').show();
        $('#floatBox-title').html("Add Assignment/Information: " + name);
        $('#add-card-class-id').val(id);
        $('#add-card-class-id-2').val(id);
        $('#shadow').css("display","table");
    }
    function switchBetweenAddCardTab(id){
        $('#submit_form_node').hide();
        $('#submit_form_node_2').hide();
        $('#submit_form_node'+id).show();
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
                    }
                }
                if ( isNull($('#add-card-form-dueday').val()) ){
                    alert("Due day is empty!")
                    return false;
                }
                if ( !validDate($('#add-card-form-dueday').val()) ){
                    alert("Due day is invalid!")
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
                    alert("Expire day is invalid!")
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


    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/assignment.js";
    ?>

    function loadAssignment(id, func){
        $.get("/modules/assignment/classLoadAssignment.php",{class: id},function(data){
            func();
            data = JSON.parse(data);
            for (var i = 0; i < data.length; i++){
                var row = data[i];
                var assignment = new Assignment("teacher", row.id, row.type, row.content, row.attachment, row.publish, row.dueday, row.subject, row.duration);
                $('#assignment-list').append(assignment.getHTML());
            }
        });
    }
    function openManageClassPanel(id, name){
        loadAssignment(id, function(){
            $('#assignment-list').html("");
        });
        $('#right-part-class-id').html(id);
        $('#right-part-title').html("Manage " + name);
        $('#right-part').show();
    }

    <?php
        require $_SERVER['DOCUMENT_ROOT']."/template/scripts/settings.js";
    ?>
    toggleModules("Class");
    loadClass(function(){});
</script>