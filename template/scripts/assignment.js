/*

    Part I: Manipulate Assignment
    - It provides API for Assignment() to create UI
    - It also provides API for button to process a specific assignment

 */
function ManipulateAssignment(id){
    this.id = id;

    this.contentExpanding = function(idPrefix){
        var cssText1 = "3.7em", cssText2 = "hidden", cssText3 = "0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12)";
        var obj = $('#' + idPrefix);
        if (obj.css("overflow") == "hidden"){
            cssText1 = "auto";
            cssText2 = "visible";
            cssText3 = "";
        }
        obj.css("height", cssText1).css("overflow", cssText2).css("box-shadow", cssText3);
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

    this.updateAssignment = function(content){
        var idS = this.id.split("-");
        var assignmentID = idS[idS.length-1];

        content = content.replace(/<br.*?>/g, "\n");
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

            new Class($('#right-part-class-id').html(),'').loadAssignment(1, true, function(){
                $('#assignment-list').html("");
            });
        })
    };

     this.markCompletion = function(){
        var actual = 0;
        $.post("/modules/assignment/markCompletion.php",{id: this.id, actual: actual}, function(data){
            loadAssignment(function(){
                $('#assignment-list').html("");
            });
        });
    };

    this.markInfoAsRead = function(){
        var id = this.id;
        $('#assignment-list-'+id).remove();
        $.post("/modules/assignment/markCompletion.php", {id: id, actual: 0}, function (data) {});
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
            html += "</div>";
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


            floatBox.showFeature("Update Score", "update-scores", function(){
                $('#floatBox-update-scores-dynamic-inputs').append(html);
            });
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
function Assignment(app, id, type, content, attachment, publish, dueday, subject, duration, finished, _class){
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
            var arr = attachment.split(";"), html = "<hr class='attachment-divider' style='bottom: calc(0.5em + 1.5em * " + (arr.length - 1) / 2+ ")'><div class='attachment-holder'>";
            for (var i = 1; i < arr.length-1; i = i+2){
                var url = arr[i];
                var urlSplit = url.split(".");
                /*
                if ( urlSplit[urlSplit.length-1].toLowerCase() == "jpg" || urlSplit[urlSplit.length-1].toLowerCase() == "png" ) {
                    html += "<img src='/modules/common/downloader.php?path=" + encodeURIComponent(url) + "' style='width: 100%' />";
                }else{
                */ // We don't need to show pics.
                    var name = arr[i+1];
                    var hrefText = "/modules/common/downloader.php?path=" + encodeURIComponent(url) + "&name=" + encodeURIComponent(name);
                    html += "<div style='display: flex; flex-direction: row;'><span class='material-icons'>attachment</span><a target=_blank style='text-indent: 5px' href='" + hrefText +"'>" + name + "</a></div>";
                //}
            }
            html += "</div>";
            return html;
        }
    }

    function typeColorBackground(type){
        type = type - 1;
        var color = ["red", "green", "deep-orange", "teal"];
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
    this._class = _class;


    this.diff = function(where){
        var assignment = this;
        var html = "";
        if (where == "prefix"){
            if (assignment.app == "teacher"){
                return "assignment-list";
            }else if (assignment.app == "student"){
                return "assignment-list";
            }else if (assignment.app == "student-in-class"){
                return "assignment-list-class";
            }
        }else if (where == "prefix-id"){
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
        }else if (where == "finished-css"){
            if (assignment.app == "student"){
                return " style='opacity:0.6'";
            }else{
                return "";
            }
        }else if (where == "additional-button"){
            if (assignment.app == "teacher"){
                html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick='new ManipulateAssignment(\"" + this.diff("prefix-content-id", assignment) + "\").updateAssignment(\""+Utils.string.line.RegexFormat(this.content)+"\")'>Update Content</a>";
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
            if (assignment.app == "student") {
                var methodName, methodText;
                if (assignment.type != 2 && !assignment.finished) {
                    methodName = "markCompletion()"; methodText = "' style='top: 20px;'> Mark as done";
                }
                if (assignment.type != 2 && assignment.finished) {
                    methodName = "markUnCompletion()"; methodText = "' style='top: 20px;'> Mark as undone";
                }
                if (assignment.type == 2 && !assignment.finished) {
                    methodName = "markInfoAsRead()"; methodText = "'> Mark as read";
                }
                html += "           <a href='#' class='btn-action-mark' onclick='new ManipulateAssignment(\"" + assignment.id + "\")."+ methodName + methodText + "</a>";
            }else if ( assignment.app == "teacher"){
                methodName = "deleteAssignment()"; methodText = "Delete";
                html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick='new ManipulateAssignment(\"" + assignment.id + "\")."+ methodName +"'>" + methodText + "</a>";
            }else{
                return "";
            }
            //html += "           <a href='#' class='btn-action-mark' onclick='new ManipulateAssignment(\"" + assignment.id + "\")."+ methodName + methodText + "</a>";
            return html;
        }
    };

    this.teacher_getHTML = function(){
        var html = "";
        var finishedCSS = "";
        if (this.finished) {
            finishedCSS = this.diff("finished-css", this);
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

        html += "<div id='" + this.diff("prefix-id", this) + "' class='" + this.diff("prefix", this) + " demo-cards mdl-cell mdl-grid mdl-grid--no-spacing' style='width: 55%; margin: 1em auto'>";
        html += "   <div id='"+this.diff("prefix", this)+"-first-child' class='demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop'" + finishedCSS + ">";

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
            html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC; width: 100%'>";
            if (app == "teacher") {
                html += "           <div style='margin-bottom: 0.5em'><span>Pub: " + this.publish + "</span></div>";
            }
            if (!( this.type == 2 && daysLeft > 1000)) {
                var dueDayLabel = new Array("Due", "Expire");
                html += "           <div>" + dueDayLabel[parseInt(type) - 1] + ": " + this.dueday + "</div>";
            }
            html += "       </div>";
        }
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='overflow: visible'>";
        html += "           <div style='line-height: 1.5;' id='" + this.diff("prefix-content-id", this) + "'>";
        html += "               <div>" + Utils.string.formattedPostContent(this.content) + "</div>" + this.attachment;
        html += "           </div>";
        html += "       </div>";
        html += "       <div class='mdl-card__actions mdl-card--border'>";
        html += this.diff("iconButton", this);
        html += this.diff("additional-button", this);
        html += "       </div>";
        html += "   </div>";
        html += "</div>";
        return html;
    }

    this.getHTML = function(hasConnector) {
        var html = "";

        function calculateDaysLeft(dueday) {
            var daysLeft = DateDiff.inDays(new Date(), new Date(dueday));
            if (daysLeft < 0) {
                daysLeft = 0;
            }
            return daysLeft;
        }

        var daysLeft = calculateDaysLeft(this.dueday);

        var type = this.type == 2 ? "Information" : "Assignment";

        html += "<div id='" + this.diff("prefix-id", this) + "' class='" + this.diff("prefix", this) + "'>";
        if (hasConnector)
            html += "<div class='connector'></div> ";
        html += "       <div class='title'>" +
            "<div class='title-text'>" + this._class + "</div>" +
            "<hr>" +
            "<div class='assignment-info'>" + type + " From</div>";
        html += "           <h2 class='subject'> " + this.subject + "</h2>";
        html += "       </div>";
        html += "       <div class='content'>";
        html += "           <div class='content-text' id='" + this.diff("prefix-content-id", this) + "'>";
        html += "               <div class='content-holder'>" + Utils.string.formattedPostContent(this.content) + "</div>" + this.attachment;
        html += "           </div>";
        html += "       </div>";
        if (hasConnector) {
            html += "       <div class='action'>";
            html += this.diff("iconButton", this);
            html += this.diff("additional-button", this);
            if (!(this.type == 2)) {
                html += "<div class='time'><span class='due-left'>Due Date</span><span class='due-right'>" + this.dueday + "</span></div>";
                html += "<div class='time' style='padding: 0 10px;margin: 0;'><span class='due-left'>Duration</span><span class='due-right'>" + this.duration + " mins</span></div>";
            }
            html += "</div>";
        }
        if (hasConnector)
            if (! (this.type == 2)) {
                if(this.finished){
                    html += "   <div class='bar-finished'></div>";
                }else {
                    html += "   <div class='bar-unfinished'></div>";
                }
            }
        html += "   <div class='footer'></div>";
        html += "</div>";
        return html;
    }
}
// Part II ends
