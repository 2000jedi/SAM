/* Click to expand module start */
function typeHTML(type, subject){
    type = type - 1;
    var color = new Array("black", "#0C0", "#F33", "#F93");
    var typeText = new Array("Assignment ONE DAY LEFT", "Information", "Assignment TWO DAYS LEFT", "Assignment");
    return "   <div class='card2-title' style='background:"+ color[type] +"'>"+subject+" "+typeText[type]+"</div>";
}
function whetherExpandHTML(id, content){
    if (content.length > 200){
        return "           <div style='margin:0.5em' onclick='contentExpanding("+id+")'><a href='#'>Click to display/hide.</a></div>";
    }else{
        return "           ";
    }
}
function whetherExpandCSS(content) {
    if (content.length > 200){
        return "height: 3em; overflow: hidden; box-shadow: inset 0px -10px 5px #DDD";
    }else{
        return "";
    }
}
function contentExpanding(id){
    var cssText1 = "3em", cssText2 = "hidden", cssText3 = "inset 0px -10px 5px #DDD";
    if ( $('#assignment-list-content-'+id).css("overflow") == "hidden"){
        cssText1 = "";
        cssText2 = "";
        cssText3 = "";
    }
    $('#assignment-list-content-'+id).css("height", cssText1).css("overflow", cssText2).css("box-shadow", cssText3);
}
/* Click to expand module end */

/* Delete Assignment Start */
function deleteAssignment(id){
    var conf = confirm("DO YOU REALLY want to delete the assignment?\nData will be permanently removed from server.\n\nTips: You should copy the content if you merely want to edit the assignment/information.");
    if (conf == true) {
        $.get("/modules/assignment/deleteAssignment.php",{assignment: id},function(data){
            $('#assignment-list-'+id).remove();
        });
    }
}
/* Delete Assignment End */

/* Mark Completion Start */
function markCompletion(id){
    var actual = prompt("You may tell us how much time you actually spent on the assignment. The data will be used to predict your actual completion time based on the estimation by your teacher. (You can leave it blank or input non-numeric values. It will not be recorded.)\n\nDO YOU REALLY want to mark the assignment as completed?\nIt will not be counted into recommendation any more.");
    if (actual == null){
        return;
    }
    $.post("/modules/assignment/markCompletion.php",{id: id, actual: actual}, function(data){
        loadAssignment(function(){
            $('#assignment-list').html("");
        });
    });
}
function markInfoAsRead(id){
    var conf = confirm("DO YOU REALLY read the information?");
    if (conf == true) {
        $.post("/modules/assignment/markCompletion.php", {id: id, actual: 0}, function (data) {
            loadAssignment(function () {
                $('#assignment-list').html("");
            });
        });
    }
}
function markUnCompletion(id){
    $.post("/modules/assignment/markUnCompletion.php",{id: id}, function(data){
        loadAssignment(function(){
            $('#assignment-list').html("");
        });
    });
}
/* Mark Completion End */

function diff(where, app, assignment){
    if (where == "prefix-id"){
        if (app == "teacher"){
            return "assignment-list-" + assignment.id;
        }else if (app == "student"){
            return "assignment-list-" + assignment.id;
        }else if (app == "student-in-class"){
            return "assignment-list-class-" + assignment.id;
        }
    }else if (where == "prefix-content-id"){
        if (app == "teacher"){
            return "assignment-list-content-" + assignment.id;
        }else if (app == "student"){
            return "assignment-list-content-" + assignment.id;
        }else if (app == "student-in-class"){
            return "assignment-list-content-2-" + assignment.id;
        }
    }else if (where == "expand-content"){
        if (app == "teacher"){
            return whetherExpandHTML("\""+assignment.id+"\"", "\""+assignment.content+"\"");
        }else if (app == "student"){
            return whetherExpandHTML("\""+assignment.id+"\"", "\""+assignment.content+"\"");
        }else if (app == "student-in-class"){
            return whetherExpandHTML("\"2-"+assignment.id+"\"", "\""+assignment.content+"\"");
        }
    }else if (where == "additional-button"){
        if (app == "teacher"){
            var html = "";
            html += "       <div>";
            html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='deleteAssignment(\"" + assignment.id + "\")'> Delete </button>";
            html += "       </div>";
            return html;
        }else if (app == "student"){
            var html = "";
            if (assignment.type != 2 && !assignment.finished) {
                html += "       <div>";
                html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='markCompletion(\"" + assignment.id + "\")'> Mark As Completed </button>";
                html += "       </div>";
            }
            if (assignment.type != 2 && assignment.finished) {
                html += "       <div>";
                html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='markUnCompletion(\"" + assignment.id + "\")'> Mark As Uncompleted </button>";
                html += "       </div>";
            }
            if (assignment.type == 2 && !assignment.finished) {
                html += "       <div>";
                html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='markInfoAsRead(\"" + assignment.id + "\")'> Mark As Read </button>";
                html += "       </div>";
            }
            return html;
        }else if (app == "student-in-class"){
            return "";
        }
    }
}
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
            return " No attachment.";
        }else{
            var arr = attachment.split(";"), html = "";
            for (var i = 1; i < arr.length; i++){
                html += " <a target=_blank href='" + arr[i] +"'>Attachment " + i + "</a>";
            }
            return html;
        }
    }
    this.app = app;

    this.id = id;
    this.type = dealWithType(type, dueday);
    this.content = content;
    this.attachment = dealWithAttachment(attachment);
    this.publish = publish;
    this.dueday = dueday;
    this.subject = subject;
    this.duration = duration + " hours";
    this.finished = finished;

    this.getHTML = function() {
        var html = "";
        var finishedCSS = "";
        if (this.finished){
            finishedCSS = " style='opacity:0.6'"
        }
        html += "<div id='" + diff("prefix-id", this.app, this) + "' class='card2 card-limit'"+ finishedCSS +">";
        html += typeHTML(this.type, this.subject);
        html += "   <div class='card2-content'>";
        html += "       <div style='margin-bottom: 0.5em'>";
        html += "           <div style='margin:0.5em;display:table;width:100%;text-align:left'>"
        html += "               <div style='display:table-cell'><div class='changeLineOrNot'>Published:&nbsp;</div><div class='changeLineOrNot'>" + this.publish + "</div></div>";

        var dueDayLabel = new Array("<div class='changeLineOrNot'>Due:&nbsp;</div>", "<div class='changeLineOrNot'>Expire:&nbsp;</div>");
        html += "               <div style='display:table-cell'>"+ dueDayLabel[parseInt(type)-1] + "<div class='changeLineOrNot'>" + this.dueday + "</div></div>";
        html += "           </div>";
        if (parseInt(type) == 1){
            html += "       <div style='margin:0.5em'>Estimated duration: " + this.duration + "</div>";
        }
        html += "           <div style='margin: 0.5em; border: 1px solid #EEE; padding:0.5em; border-bottom: 2px solid #DDD;"+whetherExpandCSS(this.content)+"' id='" + diff("prefix-content-id", this.app, this) + "'>" + Utils.string.formattedPostContent(this.content) + "</div>";
        html += diff("expand-content", this.app, this);
        html += "           <div style='margin:0.5em'>Attachment:" + this.attachment + "</div>";
        html += "       </div>";
        html += diff("additional-button", this.app, this);
        html += "   </div>";
        html += "</div>";
        return html;
    }
}