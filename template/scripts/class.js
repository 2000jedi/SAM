/*

    Part I: Classes for generate HTML

    ClassAdmin is used in admin.php
    ClassTeacher is used in teacher.php
    ClassStudent is used in student.php

 */
function ClassAdmin(id, teacher, name, subject){
    this.id = id;
    this.teacher = teacher;
    this.name = name;
    this.subject = subject;

    this.getHTML = function(){
        var html = "";
        html += "<div id='class-list-"+ this.id +"' class='demo-cards mdl-cell mdl-grid mdl-grid--no-spacing'>";
        html += "   <div class='demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop'>";
        html += "       <div class='mdl-card__title mdl-card--expand mdl-color--green-300' style='min-height: 0'>";
        html += "         <h2 class='mdl-card__title-text'>" + this.subject + "</h2>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600'>";
        html += "           <div>" + this.name + " <i>(ID: " + this.id + ")</i></div>";
        html += "       </div>";
        html += "       <div class='mdl-card__actions mdl-card--border'>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick='new Class(\""+this.id+"\", \""+this.name+"\").viewMembers(1)'>Students</a>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick='new Class(\""+this.id+"\", \""+this.name+"\").viewMembers(2)'>Edit</a>";
        html += "       </div>";
        html += "</div>";
        return html;
    }
}

function ClassTeacher(id, teacher, name, subject){
    this.id = id;
    this.teacher = teacher;
    this.name = name;
    this.subject = subject;

    this.getHTML = function(){
        var html = "";
        html += "<div id='class-list-"+ this.id +"' class='demo-cards mdl-cell mdl-grid mdl-grid--no-spacing'>";
        html += "   <div class='demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop'>";
        html += "       <div class='mdl-card__title mdl-card--expand mdl-color--green-300' style='min-height: 0'>";
        html += "         <h2 class='mdl-card__title-text'>" + this.subject + "</h2>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600'>";
        html += "           <div>" + this.name + " <i>(ID: " + this.id + ")</i></div>";
        html += "       </div>";
        html += "       <div class='mdl-card__actions mdl-card--border'>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick='new Class(\""+this.id+"\", \""+this.name+"\").openManageClassPanel()'>Manage</a>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick='new Class(\""+this.id+"\", \""+this.name+"\").openAddCardBox()'>New</a>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick='new Class(\""+this.id+"\", \""+this.name+"\").viewMembers(0)'>Students</a>";
        html += "       </div>";
        html += "</div>";
        return html;
    }
}

function ClassStudent(id, teacher, name, subject){
    this.id = id;
    this.teacher = teacher;
    this.name = name;
    this.subject = subject;

    this.getHTML = function(){
        var html = "";
        html += "<div id='class-list-"+ this.id +"' class='class-list' onclick='new Class(\""+this.id+"\", \""+this.name+"\").openViewClassPanel();'>";
        // html += "   <div class='demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop'>";
        html += "         <h2 class=''>" + this.subject + "</h2>";
        html += "           <div>" + this.name + " <i>(ID: " + this.id + ")</i></div>";
        html += "</div>";
        return html;
    }
}
// Part I ends


/*

    Part II: Class for processing a specific class

    .viewMembers(type) loads the members of a class in a way defined by variable type
    type == 0
        - load from the teacher side
        - display in a box with HTML
    type == 1
        - load from the admin side
        - display in an alert box with \n
    type == 2
        - load from the admin side
        - display in an prompt showing the user names

    .openManageClassPanel() opens the manage class panel for teachers

    .openViewClassPanel() opens the view class panel for students

    .openAddCardBox() opens the add new box for teachers

    .deleteClass() opens the recheck deletion alert for teachers

    .loadAssignment(type, func) loads assignments for a class
    type == 0
        - load from the student side
        - display in a large panel in waterfall layout
    type == 1
        - load from the teacher side
        - display in a right panel in linear layout
    func is the function used for further processing after loading

    .openUpdateCardBox() opens the update content of assignment box

    .loadClass(type, func) loads assignments for a student/teacher
    type == 1
        - load from the student side
    type == 2
        - load from the teacher side
    func is the function used for further processing after loading

 */
function Class(id, name){
    this.id = id;
    this.name = name;

    this.viewMembers = function(type){
        var usedID = this.id;


        $.get('/modules/class/loadClassMembers.php', {class: usedID}, function (data) {
            data = JSON.parse(data);
            $('#floatBox-view-members-class-id').html(usedID);

            if (type == 0){
                $.get("/modules/user/listUserInfoJSON.php", function(data2){
                    data2 = JSON.parse(data2);

                    function inListCheck(userInfo, users){
                        for (var i = 0; i < users.length; i++){
                            var onePieceOfUserInfoInList = users[i];
                            if (userInfo.uid == onePieceOfUserInfoInList.uid){
                                return true;
                            }
                        }
                        return false;
                    }

                    var html = "";
                    var htmlForChecked = "";
                    // var html = "<div class='card' style='width: calc(100%);box-sizing: border-box;'>Total Number: " + data.length + "</div>";
                    for (var i = 0; i < data2.length; i++){
                        var userInfo = data2[i];
                        var uid = userInfo.uid;
                        var username = userInfo.username;
                        var ChineseName = userInfo.ChineseName;
                        var EnglishName = userInfo.EnglishName;

                        var isCheckedString = "checked";
                        var isInList = inListCheck(userInfo, data);

                        if (isInList == false) {
                            isCheckedString = "";
                        }

                        function generateHTML(uid, username, isCheckedString, ChineseName, EnglishName){
                            var gHTML = "";
                            gHTML += "   <label class='mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect' for='chkbox-" + uid + "'>";
                            gHTML += "       <input type='checkbox' id='chkbox-" + uid + "' username='" + username +"' class='mdl-checkbox__input' " + isCheckedString + ">";
                            gHTML += "       <span class='mdl-checkbox__label'>Name: "+ ChineseName + " ("+ EnglishName + ") ID: " + username +"</span>";
                            gHTML += "   </label>";
                            return gHTML;
                        }

                        if (isInList){
                            htmlForChecked += generateHTML(uid, username, isCheckedString, ChineseName, EnglishName);
                        }else {
                            html += generateHTML(uid, username, isCheckedString, ChineseName, EnglishName);
                        }

                    }
                    floatBox.showFeature("Members in my class", "view-members", function(){
                        $('#floatBox-view-members-list').html(htmlForChecked + html);
                        var elementList = $('#floatBox-view-members-list>label.mdl-checkbox').get();
                        for (i in elementList){
                            var element = elementList[i];
                            componentHandler.upgradeElement(element);
                        }
                    });
                })
            }else if (type == 1){
                var html = "Total Number: " + data.length + "\n";
                for (var i = 0; i < data.length; i++) {
                    var userInfo = data[i];
                    var username = userInfo.username;
                    var ChineseName = userInfo.ChineseName;
                    var EnglishName = userInfo.EnglishName;
                    html += "Name: " + ChineseName + " (" + EnglishName + ")      ID:" + username + "\n";
                }
                alert(html);
            }else if (type == 2){
                var html = "";
                for (var i = 0; i < data.length; i++) {
                    var userInfo = data[i];
                    var username = userInfo.username;
                    html += ";"+ username;
                }
                var result = prompt("Edit", html);
                if (result == null){
                    return;
                }
                $.post('/modules/class/changeClassMembers.php', {class: usedID, studentList: result}, function (data) {
                    alert(data);
                });
            }
        })
    };

    this.updateMembersList = function(){
        var usedID = this.id;

        var IDs = "";
        $('#floatBox-view-members-list>label>.mdl-checkbox__input').each(function() {
            var id = $(this).attr('username');
            if ($(this).is(':checked')) {
                IDs += ";" + id;
            }
        });
        $.post('/modules/class/changeClassMembers.php', {class: usedID, studentList: IDs}, function (data) {
            $('#shadow').css("display","none");
            alert("You have successfully updated the members list for your class!");
        });
    };

    this.openManageClassPanel = function(){
        new Class(this.id, this.name).loadAssignment(1, true, function(){
            $('#assignment-list-assignment-pile').html("");
            $('#assignment-list-information-pile').html("");
        });
        $('#right-part-class-id').html(this.id);
        $('#right-part-title').html("Manage " + this.name);
        $('#right-part').show();
    };

    this.openViewClassPanel = function(){
        new Class(this.id, this.name).loadAssignment(0, false, function(){
            $('#assignment-list-class-assignment-pile').html("");
            $('#assignment-list-class-information-pile').html("");
            $('#assignment-list-class-pile').html("");
        });
        $('#right-part-class-id').html(this.id);
        $('#right-part-view-class').show();
        $('#right-part-view-activity').hide();
        $('#right-part').show();
        //$('.connector').each(function(){$(this).hide()});
    };

    this.openAddCardBox = function(){
        var id = this.id;
        floatBox.showFeature("Add Assignment/Information: " + this.name, "add-card", function(){
            $('#add-card-class-id').val(id);
            $('#add-card-class-id-2').val(id);
        });
    };

    this.deleteClass = function(){
        var id = $('#right-part-class-id').html();
        var conf = confirm("DO YOU REALLY want to delete the class? All the data related to the class will be removed from the server permanently!");
        if (conf == true) {
            $.get("/modules/class/deleteClass.php",{class: id},function(data){
                alert(data);
                window.location = "/";
            });
        }
    };

    this.loadAssignment = function(type, isTeacher, func){
        var app = new Array(); app[0] = "student-in-class"; app[1] = "teacher";
        var appendID = new Array(); appendID[0] = "#assignment-list-class"; appendID[1] = "#assignment-list";

        $.get("/modules/assignment/classLoadAssignment.php",{class: id},function(data){
            func();
            data = JSON.parse(data);

            var idList = "";
            for (var i = 0; i < data.length; i++){
                var row = data[i];
                idList += ";" + row.id;
                var assignment = new Assignment(app[type],row.id, row.type, row.content, row.attachment, row.publish, row.dueday, convertSubject(row.subject), row.duration, row.finished, row.class);
                var suffixOfContainer = ""; // It is used to add assignment into different piles.
                if (row.type == 1){
                    suffixOfContainer = "-assignment-pile";
                }else{
                    suffixOfContainer = "-information-pile";
                }
                if (isTeacher)
                    $(appendID[type]+suffixOfContainer).append(assignment.teacher_getHTML());
                else
                    $(appendID[type] + "-pile").append(assignment.getHTML(false));
            }
        });
    };

    this.openUpdateCardBox = function(){
        floatBox.showFeature("Update Assignment", "update-card", function(){});
    };

    this.loadClass = function(type, func){
        $.get("/modules/class/loadClass.php",function(data){
            func();
            data = JSON.parse(data);
            for ( var i = 0; i < data.length; i++) {
                var id = data[i].id;

                var includingCondition = true;
                // The includingCondition excludes official announcement on student side
                if (type == 1){
                    includingCondition = (id != "39");
                }

                if (includingCondition) {
                    var teacher = data[i].teacher;
                    var name = data[i].name;
                    var subject = convertSubject(data[i].subject);

                    var oneClass;
                    if (type == 1){
                        oneClass = new ClassStudent(id, teacher, name, subject);
                    }else if (type == 2){
                        oneClass = new ClassTeacher(id, teacher, name, subject);
                    }
                    $('#classList').append(oneClass.getHTML());
                }
            }
        })
    };

    this.addClass = function(){
        var name = prompt("Please enter the name for the new Class", "");
        if (name == null || name == ""){
            // Do nothing.
        }else{
            $.post("/modules/class/createClass.php", {name: name}, function (data) {
                if (data == "Success") {
                    $('#new-class-name').val("");
                    $('#shadow').hide();
                    new Class('').loadClass(2, function () {
                        $('#classList').html("");
                    });
                }
                alert(data);
            })
        }
    }
}
