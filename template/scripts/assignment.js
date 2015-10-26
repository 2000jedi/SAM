/*

    Part I: Manipulate Assignment
    - It provides API for Assignment() to create UI
    - It also provides API for button to process a specific assignment

 */
function ManipulateAssignment(id){
    this.id = id;

    this.contentExpanding = function(){
        var cssText1 = "3.7em", cssText2 = "hidden", cssText3 = "0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12)";
        if ( $('#assignment-list-content-'+this.id).css("overflow") == "hidden"){
            cssText1 = "";
            cssText2 = "";
            cssText3 = "";
        }
        $('#assignment-list-content-'+this.id).css("height", cssText1).css("overflow", cssText2).css("box-shadow", cssText3);
    };

    this.deleteAssignment = function(){
        var conf = confirm("DO YOU REALLY want to delete the assignment?");
        if (conf == true) {
            var HWID = this.id;
            $.get("/modules/assignment/deleteAssignment.php",{assignment: HWID},function(data){
                $('#assignment-list-'+HWID).remove();
            });
        }
    };

    this.updateAssignment = function(){
        var idS = this.id.split("-");
        var assignmentID = idS[idS.length-1];

        var content = $("#"+this.id).children().html().replace(/<br.*?>/g, "\n");
        $('#update-card-content-id').html(assignmentID);
        $('#update-card-content-ta').val(content);

        new Class('','').openUpdateCardBox();
    };

    this.sendUpdateAssignment = function(){
        var id = $('#update-card-content-id').html();
        var content = $('#update-card-content-ta').val();
        $.post("/modules/assignment/updateAssignment.php",{id: id, content: content}, function(data){
            alert(data);
            $('#update-card-content-id').html("");
            $('#update-card-content-ta').val("");
            $('#shadow').hide();

            new Class($('#right-part-class-id').html(),'').loadAssignment(1, function(){
                $('#assignment-list').html("");
            });
        })
    };

     this.markCompletion = function(){
        var actual = prompt("You may tell us how much time you actually spent on the assignment (in minutes). (You can leave it blank.)");
        if (actual == null){
            return;
        }
        $.post("/modules/assignment/markCompletion.php",{id: this.id, actual: actual}, function(data){
            loadAssignment(function(){
                $('#assignment-list').html("");
            });
        });
    };

    this.markInfoAsRead = function(){
        var conf = confirm("DO YOU REALLY read the information?");
        if (conf == true) {
            $.post("/modules/assignment/markCompletion.php", {id: this.id, actual: 0}, function (data) {
                loadAssignment(function () {
                    $('#assignment-list').html("");
                });
            });
        }
    };
    this.markUnCompletion = function(){
        $.post("/modules/assignment/markUnCompletion.php",{id: this.id}, function(data){
            loadAssignment(function(){
                $('#assignment-list').html("");
            });
        });
    };

    this.updateScoresPopUp = function(){
        $('#floatBox-update-scores-dynamic-inputs').html("");
        var assignmentID = this.id;
        $.get("/modules/assignment/loadPersonalScores.php",{assignment: assignmentID}, function(data){
            data = JSON.parse(data);

            var num = data.length/3;
            $('#floatBox-update-scores-assignment-id').html(assignmentID);
            $('#floatBox-update-scores-assignment-num').html(num);

            var html = "<div>";
            html += "   <span style='width: 80px; display: inline-block'>IDs</span>";
            html += "   <span style='width: 150px; display: inline-block'>Names</span>";
            html += "   <span style='width: 80px; margin-left: 1em'>Scores (0-100)</span>";
            html += "</div>"
            for (var i = 0; i < (data.length/5); i++){
                var uid = data[i*5];
                var username = data[i*5+1];
                var ChineseName = data[i*5+2];
                var EnglishName = data[i*5+3];
                var score = data[i*5+4];

                html += "<div style='border-bottom: 1px solid #CCC; margin-top: 0.5em'>";
                html += "   <span id='floatBox-update-scores-dynamic-inputs-uid-"+i+"' style='display:none'>" + uid + "</span>";
                html += "   <span id='floatBox-update-scores-dynamic-inputs-username-"+i+"' style='width:80px; display: inline-block'>" + username + "</span>";
                html += "   <span id='floatBox-update-scores-dynamic-inputs-username-"+i+"' style='width:150px; display: inline-block'>" + ChineseName + "(" + EnglishName + ")</span>";
                html += "   <input id='floatBox-update-scores-dynamic-inputs-score-"+i+"' type='number' style='width:80px; display:inline; margin-left: 1em' value='" + score + "' />";
                html += "</div>"
            }

            $('#floatBox-update-scores-dynamic-inputs').append(html);

            $('#floatBox-update-card').hide();
            $('#floatBox-view-members').hide();
            $('#floatBox-add-card').hide();
            $('#floatBox-update-scores').show();
            $('#floatBox-title').html("Update Score");
            $('#add-card-class-id').val(this.id);
            $('#add-card-class-id-2').val(this.id);
            $('#shadow').css("display","table");
        });
    };

    this.updateScores = function(num){

        var uidParameter = "", scoreParameter = "";
        for (var i = 0; i < num; i++){
            var uid = ";" + $('#floatBox-update-scores-dynamic-inputs-uid-' + i).html();
            var score = ";" + $('#floatBox-update-scores-dynamic-inputs-score-' + i).val();
            uidParameter += uid;
            scoreParameter += score;
        }

        $.post("/modules/assignment/updatePersonalScore.php",{assignment: this.id, students: uidParameter, scores: scoreParameter}, function(data){
            alert("Success!");
            $('#shadow').hide();
        });
    }

}
// Part I ends


/*

    Part II: Assignment UI
    - It creates the assignment card UI in different conditions


    Parameter app:
        'student' - Student Stream View
        'student in class' - Student Class View
        'teacher' - Teacher Class View
 */
function Assignment(app, id, type, content, attachment, publish, dueday, subject, duration, finished){
    function dealWithType(type, dueday){
        var daysLeft = DateDiff.inDays(new Date(), new Date(dueday));
        if (type == "2"){
            return 2;
        }
        if (daysLeft == 1){
            return 1;
        }else if (daysLeft == 2){
            return 3;
        }else if (daysLeft > 2 || daysLeft <= 0){
            return 4;
        }
    }
    function dealWithAttachment(attachment) {
        if (attachment == "null"){
            return "";
        }else{
            var arr = attachment.split(";"), html = "<div style='margin-top: 1em; border-top: 1px solid #CCC; padding-top: .5em'>";
            for (var i = 1; i < arr.length-1; i = i+2){
                var url = arr[i];
                var name = arr[i+1];
                var hrefText = "/modules/common/downloader.php?path=" + encodeURIComponent(url) + "&name=" + encodeURIComponent(name);
                html += "<div style='display: flex; flex-direction: row;'><span class='material-icons'>attachment</span><a target=_blank style='text-indent: 5px' href='" + hrefText +"'>" + arr[i+1] + "</a></div>";
            }
            html += "</div>";
            return html;
        }
    }

    function typeColorBackground(type){
        type = type - 1;
        var color = new Array("red", "green", "deep-orange", "teal");
        return color[type];
    }

    this.app = app;

    this.id = id;
    this.type = dealWithType(type, dueday);
    this.content = content;
    this.attachment = dealWithAttachment(attachment);
    this.publish = publish;
    this.dueday = dueday;
    this.subject = subject;
    this.duration = duration;
    this.finished = finished;


    this.whetherExpandCSS = function() {
        if (this.content.length > 100){
            return "height: 3.7em; overflow: hidden; box-shadow: 0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);";
        }else{
            return "";
        }
    };
    this.whetherExpandHTML = function(){
        if (this.content.length > 100){
            return "           <div style='margin:0.5em; font-size:16px' onclick='new ManipulateAssignment("+this.id+").contentExpanding()'><a href='#'>Click to display/hide.</a></div>";
        }else{
            return "           ";
        }
    };

    this.diff = function(where){
        var assignment = this;
        if (where == "prefix-id"){
            if (assignment.app == "teacher"){
                return "assignment-list-" + assignment.id;
            }else if (assignment.app == "student"){
                return "assignment-list-" + assignment.id;
            }else if (assignment.app == "student-in-class"){
                return "assignment-list-class-" + assignment.id;
            }
        }else if (where == "prefix-content-id"){
            if (assignment.app == "teacher"){
                return "assignment-list-content-" + assignment.id;
            }else if (assignment.app == "student"){
                return "assignment-list-content-" + assignment.id;
            }else if (assignment.app == "student-in-class"){
                return "assignment-list-content-2-" + assignment.id;
            }
        }else if (where == "expand-content"){
            if (assignment.app == "teacher"){
                return this.whetherExpandHTML();
            }else if (assignment.app == "student"){
                return this.whetherExpandHTML();
            }else if (assignment.app == "student-in-class"){
                return this.whetherExpandHTML();
            }
        }else if (where == "additional-button"){
            if (assignment.app == "teacher"){
                var html = "";
                html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick='new ManipulateAssignment(\"" + this.diff("prefix-content-id", assignment) + "\").updateAssignment()'>Update Content</a>";
                if (assignment.type != 2){
                    html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick='new ManipulateAssignment(\"" + assignment.id + "\").updateScoresPopUp()''>Update Scores</a>";
                }
                return html;
            }else if (assignment.app == "student"){
                return "";
            }else if (assignment.app == "student-in-class"){
                return "";
            }
        }else if (where == "iconButton"){
            var html = "";
            if (assignment.app == "student") {
                var methodName, methodText;
                if (assignment.type != 2 && !assignment.finished) {
                    methodName = "markCompletion()"; methodText = "Mark as completed";
                }
                if (assignment.type != 2 && assignment.finished) {
                    methodName = "markUnCompletion()"; methodText = "Mark as uncompleted";
                }
                if (assignment.type == 2 && !assignment.finished) {
                    methodName = "markInfoAsRead()"; methodText = "Mark as read";
                }
            }else if ( assignment.app == "teacher"){
                methodName = "deleteAssignment()"; methodText = "Delete";
            }else{
                return "";
            }
            html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick='new ManipulateAssignment(\"" + assignment.id + "\")."+ methodName +"'>" + methodText + "</a>";
            return html;
        }
    };

    this.getHTML = function() {
        var html = "";
        var finishedCSS = "";
        if (this.finished) {
            finishedCSS = " style='opacity:0.6'"
        }
        function calculateDaysLeft(dueday) {
            var daysLeft = DateDiff.inDays(new Date(), new Date(dueday));
            if (daysLeft < 0) {
                daysLeft = 0;
            }
            return daysLeft;
        }
        var daysLeft = calculateDaysLeft(this.dueday);

        var iconTextBeforeSubject = this.type == 2 ? "assignment" : "book";

        html += "<div id='" + this.diff("prefix-id", this) + "' class='demo-cards mdl-cell mdl-grid mdl-grid--no-spacing'" + finishedCSS + ">";
        html += "   <div class='demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop'>";

        html += "       <div class='mdl-card__title mdl-card--expand mdl-color--" + typeColorBackground(this.type) + "-300' style='position: relative'>";

        html += "           <h2 class='mdl-card__title-text'><span class='material-icons'>" + iconTextBeforeSubject + "</span> " + this.subject + "</h2>";
        html += "           <div style='position: absolute; right: 0; top: 0; width: 150px; height: 83px; color: white'>";
        if (this.type != 2) {
            html += "               <div style='line-height: 70px; position: absolute; width:70px; bottom:-10px; right: 90px; font-size: 1.1em; text-align: center; background: rgba(255, 255,255,0.2)'>" + daysLeft + "</div>";
        }
        if (this.type != 2) {
            html += "               <div style='line-height: 70px; position: absolute; width:70px; bottom:-10px; right: 10px; font-size: 1.1em; background: rgba(255, 255,255,0.2); text-align: center;'>" + this.duration + "</div>";
        } else {
            html += "               <div style='line-height: 70px; position: absolute; width:70px; bottom:-10px; right: 10px; font-size: 1.1em; background: rgba(255, 255,255,0.2); text-align: center;'>Info</div>";
        }
        if ( this.type != 2 ) {
            html += "               <div style='right: 93px; bottom: -9px; font-size: 11px; position: absolute'>days left</div>";
        }
        if (this.type != 2){
            html += "               <div style='right: 13px; bottom: -9px; font-size: 11px; position: absolute'>min needed</div>";
        }
        html += "           </div>";
        html += "       </div>";
        if ( !(this.type == 2 && daysLeft > 1000) ) {
            html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
            if (app == "teacher") {
                html += "           <div style='margin-bottom: 0.5em'><span>Pub: " + this.publish + "</span></div>";
            }
            if (!( this.type == 2 && daysLeft > 1000)) {
                var dueDayLabel = new Array("Due", "Expire");
                html += "           <div>" + dueDayLabel[parseInt(type) - 1] + ": " + this.dueday + "</div>";
            }
            html += "       </div>";
        }
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600'>";
        html += "           <div style='line-height: 1.5; "+this.whetherExpandCSS()+"' id='" + this.diff("prefix-content-id", this) + "'>";
        html += "               <div>" + Utils.string.formattedPostContent(this.content) + "</div>" + this.attachment;
        html += "           </div>";
        html += this.diff("expand-content", this);
        html += "       </div>";

        html += "       <div class='mdl-card__actions mdl-card--border'>";
        html += this.diff("iconButton", this);
        html += this.diff("additional-button", this);
        html += "       </div>";
        html += "   </div>";
        html += "</div>";
        return html;
    }
}
// Part II ends
