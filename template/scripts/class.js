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
        html += "<div id='class-list-"+ this.id +"' class='card2'>";
        html += "   <div class='card2-title' style='background: #4CAF50'>"+this.subject+" (ID = " + this.id + ")</div>";
        html += "   <div class='card2-content'>";
        html += "       <div style='margin-bottom: 0.5em'>" + this.name + "</div>";
        html += "       <div style='line-height: 40px'>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block; padding: .5em .9em' onclick='new Class(\""+this.id+"\", \""+this.name+"\").viewMembers(1)'>Students</button>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block; padding: .5em .9em' onclick='new Class(\""+this.id+"\", \""+this.name+"\").viewMembers(2)'>Edit</button>";
        html += "       </div>";
        html += "   </div>";
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
        html += "<div id='class-list-"+ this.id +"' class='card2'>";
        html += "   <div class='card2-title' style='background: #4CAF50'>"+this.subject+" (ID = " + this.id + ")</div>";
        html += "   <div class='card2-content'>";
        html += "       <div style='margin-bottom: 0.5em'>" + this.name + "</div>";
        html += "       <div style='line-height: 40px'>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block; padding: .5em .9em' onclick='new Class(\""+this.id+"\", \""+this.name+"\").openManageClassPanel()'>Manage</button>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block; padding: .5em .9em' onclick='new Class(\""+this.id+"\", \""+this.name+"\").openAddCardBox()'>New</button>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block; padding: .5em .9em' onclick='new Class(\""+this.id+"\", \""+this.name+"\").viewMembers(0)'>Students</button>";
        html += "       </div>";
        html += "   </div>";
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
        html += "<div id='class-list-"+ this.id +"' class='card2'>";
        html += "   <div class='card2-title' style='background: #4CAF50'>"+this.subject+" (ID = " + this.id + ")</div>";
        html += "   <div class='card2-content'>";
        html += "       <div style='margin-bottom: 0.5em'>" + this.name + "</div>";
        html += "       <div>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='new Class(\""+this.id+"\", \""+this.name+"\").openViewClassPanel()'>View</button>";
        html += "       </div>";
        html += "   </div>";
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

    .switchBetweenAddCardTab(id) switches between 'Assignment' and 'Information'
    id == ''
        - assignment
    id == '_2'
        - information

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

            if (type == 0){
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
                $('#floatBox-update-scores').hide();
                $('#floatBox-view-members').show();
                $('#shadow').css("display","table");
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

    this.openManageClassPanel = function(){
        new Class(this.id, this.name).loadAssignment(1, function(){
            $('#assignment-list').html("");
        });
        $('#right-part-class-id').html(this.id);
        $('#right-part-title').html("Manage " + this.name);
        $('#right-part').show();
    };

    this.openViewClassPanel = function(){
        new Class(this.id, this.name).loadAssignment(0, function(){
            $('#assignment-list-in-class').html("");
        });
        $('#right-part-class-id').html(this.id);
        $('#right-part-title').html("View " + this.name);
        $('#right-part').show();
    };

    this.openAddCardBox = function(){
        $('#floatBox-update-card').hide();
        $('#floatBox-view-members').hide();
        $('#floatBox-update-scores').hide();
        $('#floatBox-add-card').show();
        $('#floatBox-title').html("Add Assignment/Information: " + this.name);
        $('#add-card-class-id').val(this.id);
        $('#add-card-class-id-2').val(this.id);
        $('#shadow').css("display","table");
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

    this.loadAssignment = function(type, func){
        var app = new Array(); app[0] = "student-in-class"; app[1] = "teacher";
        var appendID = new Array(); appendID[0] = "#assignment-list-in-class"; appendID[1] = "#assignment-list";


        $.get("/modules/assignment/classLoadAssignment.php",{class: id},function(data){
            func();
            data = JSON.parse(data);

            var idList = "";
            for (var i = 0; i < data.length; i++){
                var row = data[i];
                idList += ";" + row.id;
                var assignment = new Assignment(app[type],row.id, row.type, row.content, row.attachment, row.publish, row.dueday, convertSubject(row.subject), row.duration, row.finished);
                $(appendID[type]).append(assignment.getHTML());
            }
            localStorage.assignmentIDList2 = idList;
        });
    };

    this.openUpdateCardBox = function(){
        $('#floatBox-add-card').hide();
        $('#floatBox-view-members').hide();
        $('#floatBox-update-scores').hide();
        $('#floatBox-update-card').show();
        $('#floatBox-title').html("Update Assignment");
        $('#shadow').css("display","table");
    };

    this.switchBetweenAddCardTab = function(id){
        $('#submit_form_node').hide();
        $('#submit_form_node_2').hide();
        $('#submit_form_node'+id).show()
        $('#switch-between-tab'+id).css("border-bottom", "4px solid rgb(19, 47, 158)");
        id = id == "" ? "_2" : "";
        $('#switch-between-tab'+id).css("border-bottom", "4px solid #0078e7");;
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
